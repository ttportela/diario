<?php

class UsuarioController extends Controller
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
			// array('allow',  // and ROLE_ALUNO
				// 'actions'=>array('view','update'),
				// 'roles'=>array(UserIdentity::ROLE_ALUNO),
				// 'expression'=> function () {
					// return Yii::app()->user->id==$_GET["id"];
				// },
			// ),
			array('allow', // OWN for ROLE_PROFE or ROLE_ALUNO
				'actions'=>array('update','view'),
				'roles'=>array(UserIdentity::ROLE_PROFE,UserIdentity::ROLE_ALUNO),
				'expression'=> function () {
					return Yii::app()->user->id==$_GET["id"];
				},
			),
			array('allow', // allow admin all
				'actions'=>array('admin','delete','create','update','index','view'),
				'roles'=>array(UserIdentity::ROLE_ADMIN),
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
		
		$model=$this->loadModel($id);
		
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Usuario;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Usuario']))
		{
			$model->attributes=$_POST['Usuario'];
			
			// Cript. da senha:
			// $salt = openssl_random_pseudo_bytes(22);
			// $salt = '$2a$%13$' . strtr($salt, array('_' => '.', '~' => '/'));
			// $model->senha = crypt($model->senha, $salt);
			
			if($model->save()) {
				
				// $auth=Yii::app()->authManager;
				// if(!$auth->isAssigned($model->papel,$model->id))
		        // {
		            // if($auth->assign($model->papel,$model->id))
		            // {
		                // Yii::app()->authManager->save();
		            // }
		        // }
				
				$this->redirect(array('view','id'=>$model->id));
			}
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

		if(isset($_POST['Usuario']))
		{
			$model->attributes=$_POST['Usuario'];
			
			// Cript. da senha:
			// $salt = openssl_random_pseudo_bytes(22);
			// $salt = '$2a$%13$' . strtr($salt, array('_' => '.', '~' => '/'));
			// $model->senha = crypt($model->senha, $salt);
			
			// $auth=Yii::app()->authManager;
			// if(!$auth->isAssigned($model->papel,$model->id))
	        // {
	            // if($auth->assign($model->papel,$model->id))
	            // {
	                // Yii::app()->authManager->save();
	            // }
	        // }
			
			
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
		$model = $this->loadModel($id);
		
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		if (!Yii::app()->user->checkAccess('admin')) {
			$this->redirect(array('admin'));
		}
		
		// $dataProvider=new CActiveDataProvider('Usuario');
		// $this->render('index',array(
			// 'dataProvider'=>$dataProvider,
		// ));
		$model=new Usuario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Usuario']))
			$model->attributes=$_GET['Usuario'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Usuario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Usuario']))
			$model->attributes=$_GET['Usuario'];

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
		$model=Usuario::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
