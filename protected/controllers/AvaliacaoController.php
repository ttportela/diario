<?php

class AvaliacaoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // OWN for ROLE_PROFE
				'actions'=>array('admin','delete','create','update','index','view','notas'),
				'roles'=>array(UserIdentity::ROLE_ADMIN),
			),
			array('allow', // OWN for ROLE_PROFE
				'actions'=>array('create','index'),
				'roles'=>array(UserIdentity::ROLE_PROFE),
			),
			array('allow', // OWN for ROLE_PROFE
				'actions'=>array('delete','update','view'),
				'roles'=>array(UserIdentity::ROLE_PROFE),
				'expression'=> function () {
					return Avaliacao::model()->findByPk($_GET["id"])->turma->professor_id==Yii::app()->user->papel_id;
				},
			),
			array('allow', // OWN for ROLE_PROFE
				'actions'=>array('notas'),
				'roles'=>array(UserIdentity::ROLE_PROFE),
				'expression'=> function () {
					if (isset($_GET['turma_id'])) {
						return Turma::model()->findByPk($_GET["turma_id"])->professor_id==Yii::app()->user->papel_id;
					} else {
						return true;
					}
				},
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Avaliacao;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Avaliacao']))
		{
			$model->attributes=$_POST['Avaliacao'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Avaliacao']))
		{
			$model->attributes=$_POST['Avaliacao'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$trans = Yii::app()->db->beginTransaction();
			try {
			
				$model = $this->loadModel($id);
				
				foreach ($model->avaliacoes as $item) {
					$item->delete();
				} 
				
				// we only allow deletion via POST request
				$model->delete();
				
				$trans->commit();
			} catch (Exception $e) {
                $trans->rollback();
				Yii::app()->helper->error('excluir a avaliação e suas notas', $e);
                $sucesso_salvando_tudo = false;
            }

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Requisição Inválida.');
	}
		
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// $dataProvider=new CActiveDataProvider('Avaliacao');
		// $this->render('index',array(
			// 'dataProvider'=>$dataProvider,
		// ));
		$model=new Avaliacao('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Avaliacao']))
			$model->attributes=$_GET['Avaliacao'];
		
		if(isset($_GET['turma_id']))
			$model->turma_id = $_GET['turma_id'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Avaliacao('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Avaliacao']))
			$model->attributes=$_GET['Avaliacao'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionNotas()
	{
		
		if (isset($_GET['turma_id'])) {
			// retrieve items to be updated in a batch mode
		    // assuming each item is of model class 'Item'
					
        	$trans = Yii::app()->db->beginTransaction();				
			try {
				
			    $items=$this->getAvaliacoes();
			    if(isset($_POST['AvaliacaoAluno']))
			    {
			        $valid=true;
					foreach($items as $item) 
			        {
			            $valid=$item->validate() && $valid;
			        }
			        if($valid) {  // all items are valid
			        	$saved = true;
					    foreach($items as $item) {
			            	$saved = $item->save(false) && $saved;
			            }	
						
						if ($saved) {
							$trans->commit();
							Yii::app()->user->setFlash('success', 'Notas lançadas com sucesso!');
						} else {
							$trans->rollback();
							Yii::app()->user->setFlash('error', "Algum erro ocorreu ao tentar salvar as notas, contacte o administrador do sistema.");
							foreach($items as $item) {
				            	Yii::app()->helper->trace($item->getErrors());
				            }
						} 
		            } else {
		            	Yii::app()->user->setFlash('error', "As notas informadas não estão corretas.");
		            }
			    }
			
            } catch (Exception $e) {
                $trans->rollback();
				Yii::app()->helper->error('salvar as notas da avaliação', $e);
            }
			
			
		}
		
		$this->render('notas');

	}

	function getRealPOST() {
	    $pairs = explode("&", file_get_contents("php://input"));
	    $vars = array();
	    foreach ($pairs as $pair) {
	        $nv = explode("=", $pair);
	        $name = urldecode($nv[0]);
	        $value = urldecode($nv[1]);
	        $vars[$name] = $value;
	    }
	    return $vars;
	}
	
	public function getAvaliacoes() {
        // Create an empty list of records
        $items = array();
		
		$post = $_POST;
		
        // Iterate over each item from the submitted form
        if (isset($post['AvaliacaoAluno']) && is_array($post['AvaliacaoAluno'])) {
            foreach ($post['AvaliacaoAluno'] as $i=>$item) {
                // If item id is available, read the record from database 
                // Yii::app()->helper->trace($i,$item);
                $dbItem = AvaliacaoAluno::model()->findByAttributes(array('aluno_id' => $item['aluno_id'], 'avaliacao_id' => $item['avaliacao_id']));
                if ( isset($dbItem) ){
                    $item = $dbItem;
                }
                // Otherwise create a new record
                else {
                    $item = new AvaliacaoAluno();
                }
				
				$item->attributes=$post['AvaliacaoAluno'][$i];
				
				if ($item->nota == '' || $item->nota == '-') {
					$item->nota = 0;
				}
				
				array_push($items, $item);
            }
        }
        return $items;
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Avaliacao::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='avaliacao-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
