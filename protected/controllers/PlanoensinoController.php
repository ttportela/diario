<?php

class PlanoensinoController extends Controller
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
				'actions'=>array('admin','update','index','view'),
				'roles'=>array(UserIdentity::ROLE_ADMIN,UserIdentity::ROLE_PROFE),
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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$turma=$this->loadModel($id);
		$model=$this->createForm($turma);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PlanoensinoForm']))
		{
			
			$model->attributes=$_POST['PlanoensinoForm'];
			if(!$model->validate()) break;
			
			$this->updateModel($turma, $model);
			
			if($turma->disciplina->save() && $turma->save())
				$this->redirect(array('view','id'=>$turma->id));
		}

		$this->render('update',array(
			'model'=>$model,
			'turma'=>$turma,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
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
	
	public function createForm($turma)
	{
		$model = new PlanoensinoForm;
		
		// Disciplina
		$model->periodo = $turma->disciplina->periodo;
		$model->ementa = $turma->disciplina->ementa;
		$model->bibbasica = $turma->disciplina->bibbasica;
		
		// Turma
		$model->bibcomplementar = $turma->bibcomplementar;
		$model->conteudo = $turma->conteudo;
		$model->metodologia = $turma->metodologia;
		$model->recursos = $turma->recursos;
		$model->objetivosespecificos = $turma->objetivosespecificos;
		$model->objetivosgerais = $turma->objetivosgerais;
		$model->publicarpe = $turma->publicarpe;
		
		return $model;
	}
	
	public function updateModel($turma, $form)
	{
		// Disciplina
		$turma->disciplina->periodo = $form->periodo;
		$turma->disciplina->ementa = $form->ementa;
		$turma->disciplina->bibbasica = $form->bibbasica;
		
		// Turma
		$turma->bibcomplementar = $form->bibcomplementar;
		$turma->conteudo = $form->conteudo;
		$turma->metodologia = $form->metodologia;
		$turma->recursos = $form->recursos;
		$turma->objetivosespecificos = $form->objetivosespecificos;
		$turma->objetivosgerais = $form->objetivosgerais;
		$turma->publicarpe = $form->publicarpe;
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
