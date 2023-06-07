<?php

class ProjetoController extends Controller
{
	
	public $modelName = "Projeto";
	
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
			// array('allow',  // allow all users to perform 'index' and 'view' actions
				// 'actions'=>array('index','view','create','update'),
				// 'users'=>array('*'),
			// ),
			array('allow', // Allow nothing to authenticated user, by default
				'actions'=>array('index','view','create','update','addinteressado'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'expression'=>'Yii::app()->helper->isAdmin()',
				//'users'=>array('admin'),
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
		$model=new Projeto;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Projeto']))
		{
			// start optimistically by settings a few variables that we'll need
            $all_valid = true;
            $items_to_save = array();
            $success_saving_all = true;
			
			$model->attributes=$_POST['Projeto'];
			
			// lets start handle related models that were submitted, if any
            if (isset($_POST['Interessado'])) {
            	// now handle each submitted:
                foreach ($_POST['Interessado'] as $index => $submitted) {
                	// We could have empty item which means empty submitted forms in POST. Ignore those:
                    if ($submitted['professor_id'] == '' || $submitted['aluno_id'] == '') {
                        // empty one - skip it, if you please.
                        continue;
                    }
					
					// validate each submitted instance
                    $it = new Interessado();
                    $it->attributes = $submitted;
                    if (!$it->validate()) {
                        // at least one invalid. We'll need to remember this fact in order to render the create
                        // form back to the user, with the error message:
                        $all_valid = false;
                        // we do not 'break' here since we want validation on all items at the same shot
                    }
                    else {
                        // put aside the new *and valid* Item to be saved
                        $items_to_save[] = $it;
                    }
                }
            }
			
			$projeto=new Documento;	
			$modelo = DocumentoModelo::model()->projeto()->find();
		
			if(isset($_POST['DocumentForm']))
			{
				$docmodel = $this->readDocForm($model, $modelo);
		
				// Gera o documento:
				$projeto->nome = WriteNumber::replaceDataMask($docmodel->nome);
				$projeto->conteudo = $docmodel->getContents();
				$projeto->modelo_id = $modelo->id;
				$projeto->ativo=Documento::$STATUS_ATIVO;
				$projeto->criado = new CDbExpression('NOW()');
				$projeto->criador_id = Yii::app()->user->id;
				
			} else 
			if(isset($_POST['Documento']))
			{
				$projeto->attributes=$_POST['Documento'];
			}

			if ($all_valid && $model->validate()) {
				$trans = Yii::app()->db->beginTransaction();
 
                try {
                	$projeto->save(false);
					DocumentoController::novoHistorico($projeto)->save(false);
					$model->projeto_id = $projeto->id;
                	$model->save(false);
					
					// save the items
                    foreach ($items_to_save as $it) {
                        $it->projeto_id = $model->id;
                        $it->save(false);
                    }
					
					 $trans->commit();
                }
                catch (Exception $e) {
                    // oops, saving artist or its songs failed. rollback, report us, and show the user an error.
                    $trans->rollback();
                    Yii::log("Um erro aconteceu ao tentar salvar o projeto e seus integrantes. Erro reportado: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
                    Yii::app()->user->setFlash('error', 'Um erro aconteceu ao tentar salvar o projeto e seus integrantes. Tente novamente ou contacte o administrador do sistema.');
                    $success_saving_all = false;
                }
				
				if ($success_saving_all) {
                    // everything's done. Would you believe it?! Go to 'view' page :)
                    $success_msg = (count($items_to_save) > 0) ? "Projeto e interessados criados com sucesso!" : "Projeto criado com sucesso!";
                    Yii::app()->user->setFlash('success', $success_msg);
                    $this->redirect(array("view", "id" => $model->id));
                }
            }
		}

		$this->render('create',array(
			'model'=>$model,
			'items'=>(isset($items_to_save)) ? $items_to_save : array(new Interessado('insert')),
		));
	}

	private function readDocForm($projeto,$model) {
		$form = new DocumentForm;
		$form->readFields($model);
		
		if (isset($_POST['DocumentForm']['nome'])) {
			$form->nome = $_POST['DocumentForm']['nome'];
		}
		
		if (isset($_POST['DocumentForm']['modelo_id'])) {
			$form->modelo_id = $_POST['DocumentForm']['modelo_id'];
		}
		
		foreach ($form->fields as $field) {
			// Yii::app()->helper->trace($field->getFormName(), $_POST['DocumentForm'][$field->getFormName()]);
			if (isset($_POST['DocumentForm'][$field->getFormName()])) {
				// Yii::app()->helper->trace($_POST['DocumentForm'][$field->getFormName()]);
				$field->value = $_POST['DocumentForm'][$field->getFormName()];
			} else if ($field instanceof ModelField && $field->params['modelo'] == 'Projeto') {
				$field->value = $projeto;
			}
		}
		
		return $form;
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

		if(isset($_POST['Projeto']))
		{
			$model->attributes=$_POST['Projeto'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionAddinteressado($ct)
    {
    	$this->renderPartial('/interessado/_form', array('model' => new Interessado(), 'counter' => $ct));
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
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Operação inválida. tente não repetí-la novamente.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		/*$dataProvider=new CActiveDataProvider('Projeto');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		
		$model=new Projeto('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Projeto']))
			$model->attributes=$_GET['Projeto'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Projeto('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Projeto']))
			$model->attributes=$_GET['Projeto'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Projeto::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'Esta página não foi encontrada.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='projeto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
