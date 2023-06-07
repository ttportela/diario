<?php

class TurmaController extends Controller
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
				'actions'=>array('admin','delete','create','update','index','view','emails'),
				'roles'=>array(UserIdentity::ROLE_ADMIN,UserIdentity::ROLE_PROFE),
			),
			array('allow', 
				'actions'=>array('autocomplete'),
				'users'=>array('@'),
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
		$model = $this->loadModel($id);
		
		// if ($model->professor->id != Yii::app()->user->papel_id)
		if (!Yii::app()->helper->checkProfessor($model))
			throw new CHttpException(400,'Você não tem permissão para esta operação.');
		
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionEmails($id)
	{
		$model = $this->loadModel($id);
		
		// if ($model->professor->id != Yii::app()->user->papel_id)
		if (!Yii::app()->helper->checkProfessor($model))
			throw new CHttpException(400,'Você não tem permissão para esta operação.');
		
		$this->render('emails',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Turma;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Turma']))
		{
			$model->attributes=$_POST['Turma'];
			
			if (is_array(($_POST['Turma']['horarios']))) {
				$model->horarios = '@';
				foreach ($_POST['Turma']['horarios'] as $t) {
					$model->horarios .= chr($t);
				}
			}
			
			$alunos = array();
			if (isset($_POST['Turma']['alunos'])) {
				foreach ($_POST['Turma']['alunos'] as $a) {
					$aluno = Aluno::model()->findByPk($a);
		            array_push($alunos, $aluno); 
		        }
			}
			$model->alunos = $alunos;
			
			if($model->withRelated->save(true,array('alunos')))
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
		// TODO TESTEEEEEE
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		// if ($model->professor->id != Yii::app()->user->papel_id)
		if (!Yii::app()->helper->checkProfessor($model))
			throw new CHttpException(400,'Você não tem permissão para esta operação.');
		
		if(isset($_POST['Turma']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try 
			{	
				$model->attributes=$_POST['Turma'];
				
				// $connection=Yii::app()->db; 
				// $sql = 'delete from '. Yii::app()->params['tablePrefix'] . 'turma_has_aluno where turma_id=' . $model->id;
				// $command=$connection->createCommand($sql);
				// $command->execute();
				
				// $alunos = array();
				// foreach ($_POST['Turma']['alunos'] as $a) {
					// $aluno = Aluno::model()->findByPk($a);
		            // array_push($alunos, $aluno); 
		        // }
// 				
				// $model->alunos = $alunos;
// 				
				// $model->withRelated->save(true,array('alunos'));
				$model->save();
// 				
				// foreach ($model->avaliacoes as $item) {
					// $sql = 'delete from '. Yii::app()->params['tablePrefix'] . 'avaliacao_has_aluno where avaliacao_id=' . $item->id .
						// ' AND aluno_id NOT IN (select aluno_id from '. Yii::app()->params['tablePrefix'] . 'turma_has_aluno where turma_id=' . $model->id. ')';
					// $command=$connection->createCommand($sql);
					// $command->execute();
				// }
// 				
				// foreach ($model->diarios as $item) {
					// $sql = 'delete from '. Yii::app()->params['tablePrefix'] . 'diario_has_aluno where diario_id=' . $item->id .
						// ' AND aluno_id NOT IN (select aluno_id from '. Yii::app()->params['tablePrefix'] . 'turma_has_aluno where turma_id=' . $model->id. ')';
					// $command=$connection->createCommand($sql);
					// $command->execute();
				// }
				
				$transaction->commit();
				$this->redirect(array('view','id'=>$model->id));
			}
			catch (Exception $e)
			{
				$transaction->rollBack();
				Yii::app()->user->setFlash('error', "{$e->getMessage()}");
				$this->refresh();
			}
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
			$model = $this->loadModel($id);
			
			// if ($model->professor->id != Yii::app()->user->papel_id)
			if (!Yii::app()->helper->checkProfessor($model))
				throw new CHttpException(400,'Você não tem permissão para esta operação.');
		
			// we only allow deletion via POST request
			$model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Página inválida, tente não repetir esta operação novamente.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// $dataProvider=new CActiveDataProvider('Turma');
		// $this->render('index',array(
			// 'dataProvider'=>$dataProvider,
		// ));
		$model=new Turma('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Turma']))
			$model->attributes=$_GET['Turma'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Turma('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Turma']))
			$model->attributes=$_GET['Turma'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/*public function actionAutocomplete () {
	  if (isset($_GET['term'])) {
		
		$data = Aluno::model();
		$data->globalSearch=$_GET['term'];
		$data = $data->search()->getData();
	 
	    $return_array = array();
	    foreach($data as $item) {
	      $return_array[] = array(
	                    'label'=>$item->toString(),
	                    'value'=>$item->id,
	                    'id'=>$item->id,
	                    );
	    }
	 
	    echo CJSON::encode($return_array);
	  }
	}*/

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Turma::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'Página não encontrada.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='turma-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
