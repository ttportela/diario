<?php

class DochistoricoController extends Controller
{
	
	public $modelName = "Documento Historico";
	
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
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'create', 'update', 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update'),
				'expression'=>'Yii::app()->helper->userIsAdmin()',
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
		$model=$this->loadModel($id);
		
		if (isset($_GET['print'])) {			
			$this->layout='//layouts/column1';
			
			# mPDF
        	$mPDF1 = Yii::app()->ePdf->mpdf();
			
			if (isset($model->documento->modelo->cabecalho_id))
				$mPDF1->SetHtmlHeader('<page_header>'.$model->documento->modelo->cabecalho->conteudo.'</page_header>');
			if (isset($model->documento->modelo->rodape_id))
				$mPDF1->SetHtmlFooter('<page_footer>'.$model->documento->modelo->rodape->conteudo.'</page_footer>');
	        
	        $mPDF1->WriteHTML($model->conteudo);
			$mPDF1->Output();
			
		} else {
			$this->render('view',array(
				'model'=>$model,
			));	
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new DocumentoHistorico;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DocumentoHistorico']))
		{
			$model->attributes=$_POST['DocumentoHistorico'];
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

		if(isset($_POST['DocumentoHistorico']))
		{
			$model->attributes=$_POST['DocumentoHistorico'];
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
	public function actionIndex($id)
	{
		/*$dataProvider=new CActiveDataProvider('DocumentoHistorico');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));*/
		
		$model=new DocumentoHistorico('search');
		$model->documento_id=$id;
		
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DocumentoHistorico']))
			$model->attributes=$_GET['DocumentoHistorico'];

		$this->render('index',array(
			'model'=>$model,
			'doc'=>Documento::model()->findByPk($id)
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new DocumentoHistorico('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DocumentoHistorico']))
			$model->attributes=$_GET['DocumentoHistorico'];

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
		$model=DocumentoHistorico::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='documento-historico-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
