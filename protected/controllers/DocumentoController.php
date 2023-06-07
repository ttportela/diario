<?php

class DocumentoController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','ex_help'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
			// $this->render('imprimir',array(
				// 'model'=>$model,
			// ));	
			
			$this->layout='//layouts/column1';
			
			# mPDF
        	$mPDF1 = Yii::app()->ePdf->mpdf();
			
			if (isset($model->modelo->cabecalho_id))
				$mPDF1->SetHtmlHeader('<page_header>'.$model->modelo->cabecalho->conteudo.'</page_header>');
			if (isset($model->modelo->rodape_id))
				$mPDF1->SetHtmlFooter('<page_footer>'.$model->modelo->rodape->conteudo.'</page_footer>');
	        
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
		$model=new Documento;
		$modelo = null;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$modelo_id = isset($_GET['modelo_id'])? $_GET['modelo_id'] : null;
		
		if (isset($modelo_id)) {
		
		$modelo = DocumentoModelo::model()->findByPk($modelo_id);	
		
		if(isset($_POST['DocumentForm']))
		{
			$docmodel = Yii::app()->doc->readForm($modelo);
	
			// Gera o documento:
			$model->nome = WriteNumber::replaceDataMask($docmodel->nome);
			$model->conteudo = $docmodel->getContents();
			$model->modelo_id = $modelo->id;
			
			$this->render('create',array(
				'model'=>$model,
				'modelo'=>$modelo,
				'gen'=>false,
			)); return;
			
		} else 
		if(isset($_POST['Documento']))
		{
			$model->attributes=$_POST['Documento'];
			$model->ativo=Documento::$STATUS_ATIVO;
			$model->criado = new CDbExpression('NOW()');
			$model->criador_id = Yii::app()->user->id;
			
			$trans = Yii::app()->db->beginTransaction();
			try {
				$model->save(false);
				self::novoHistorico($model)->save(false);
				
				$trans->commit();
				
				Yii::app()->user->setFlash('success', 'Dados salvos com sucesso!');
				$this->redirect(array('view','id'=>$model->id));
	        } catch (Exception $e) {
	            $trans->rollback();
				Yii::app()->helper->error('salvar o documento ou seu histórico', $e);
	        }
		}
		
		} 

		$this->render('create',array(
			'model'=>$model,
			'modelo'=>$modelo,
			'gen'=>true,
		));
	}

	public static function novoHistorico($model, $obs='Documento criado.') {
		$hist = new DocumentoHistorico;
		$hist->nome = $model->nome;
		$hist->conteudo = $model->conteudo;
		$hist->observacoes = $obs;
		$hist->documento_id = $model->id;
		$hist->criador_id = Yii::app()->user->id;
		$hist->data = new CDbExpression('NOW()');
		return $hist;
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

		if(isset($_POST['Documento']))
		{
			$trans = Yii::app()->db->beginTransaction();
			try {
				
				$model->attributes=$_POST['Documento'];
				$model->save(false);
				self::novoHistorico($model)->save(false);
	 
				Yii::app()->user->setFlash('success', 'Dados salvos com sucesso!');
				$this->redirect(array('view','id'=>$model->id));
				
				$trans->commit();
	        } catch (Exception $e) {
	            $trans->rollback();
				Yii::app()->helper->error('salvar o documento ou seu histórico', $e);
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
			// we only allow deletion via POST request
			$model=$this->loadModel($id);
			
			if ($model->criador_id != Yii::app()->user->id)
				throw new CHttpException(400,'Você não pode excluir este documento.');
			
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
		$model=new Documento('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Documento']))
			$model->attributes=$_GET['Documento'];
		
		if (isset($_GET['modelo_id'])) {
			$model->modelo_id = $_GET['modelo_id'];
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Documento('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Documento']))
			$model->attributes=$_GET['Documento'];
		
		if (isset($_GET['modelo_id'])) {
			$model->modelo_id = $_GET['modelo_id'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEx_help()
	{
		// $model=new Documento;
		$model = new DocumentForm;
		$model->isNewRecord = true;
		$model->nome = "Teste de Campos";
		
		$mfprof = new ManyField;
		$mfprof->params['modelo'] = 'Professor';
		$mfprof->order=20;
		
		$model->fields = array(
			new NowField,
			new DateField,
			new TextField,
			new AreaField,
			// new ProfessorField,
			// new AlunoField,
			// new DisciplinaField,
			// new TurmaField,
			new ModelField,
			new ManyField,
			$mfprof
		);
		
		foreach ($model->fields as $field) {
			$field->desc = "Campo " . $field::NAME;
			$field->model = $model;
		}
		
		$this->render('ex_help',array(
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
		$model=Documento::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='documento-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
