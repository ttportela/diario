<?php

class ReservaController extends Controller
{
	
	public $modelName = "Reserva";
	
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions'=>array('update','delete'),
				'users'=>array('@'),
				//'users'=>array('admin'),
			),
			array('allow', // allow admin user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions'=>array('admin'),
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
		$model=new Reserva;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Reserva']))
		{
			$model->attributes=$_POST['Reserva'];
			
			$model->status = Reserva::STATUS_APPROVED;
			$model->solicitante_id = Yii::app()->user->id;
			
			// $model->inicio = strtotime($this->inicio);
			// $model->fim = strtotime($this->fim);
			
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
		
		Yii::app()->helper->trace(Yii::app()->user->id, $model->solicitante_id, !Yii::app()->helper->isAdmin() || Yii::app()->user->id != $model->solicitante_id,
		!Yii::app()->helper->isAdmin(), Yii::app()->user->id != $model->solicitante_id);
		
		if (!Yii::app()->helper->isAdmin() && Yii::app()->user->id != $model->solicitante_id)
			throw new CHttpException(400,'Você não tem permissão para esta operação.');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Reserva']))
		{
			$model->attributes=$_POST['Reserva'];
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
			$model=$this->loadModel($id);
			
			if (!Yii::app()->helper->isAdmin() && Yii::app()->user->id != $model->solicitante_id)
				throw new CHttpException(400,'Você não tem permissão para esta operação.');
			
			// we only allow deletion via POST request
			// $model->delete();
			$model->status=Reserva::STATUS_CANCELLED;
			$model->save();

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
		/*$dataProvider=new CActiveDataProvider('Reserva');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		
		$model=new Reserva('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Reserva']))
			$model->attributes=$_GET['Reserva'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Reserva('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Reserva']))
			$model->attributes=$_GET['Reserva'];

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
		$model=Reserva::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='reserva-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
