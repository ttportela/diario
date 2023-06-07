<?php

class AlunoController extends Controller
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
			array('allow',  // ALL
				'actions'=>array('grades','gradebook','updemail','stars'),
				'users'=>array('*'),
			),
			array('allow',  // OWN
				'actions'=>array('view','update'),
				'roles'=>array(UserIdentity::ROLE_ALUNO),
			),
			array('allow', 
				'actions'=>array('create','update','index','view','import'),
				'roles'=>array(UserIdentity::ROLE_ADMIN,UserIdentity::ROLE_PROFE),
			),
			array('allow', 
				'actions'=>array('admin','delete','duplicates','merge'),
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
	public function actionMerge($from,$to)
	{
		$transaction = Yii::app()->db->beginTransaction();
		try 
		{
			$log = 'Merge do id='.$from.' com id='.$to.':<br/>';
			$n=Yii::app()->db->createCommand('UPDATE avaliacao_has_aluno SET aluno_id='.$to.' WHERE aluno_id='.$from)->execute();
			$log .= 'UPDATE em avaliacao_has_aluno, '.$n.' registros afetados<br/>';
			$n=Yii::app()->db->createCommand('UPDATE diario_has_aluno SET aluno_id='.$to.' WHERE aluno_id='.$from)->execute();
			$log .= 'UPDATE em diario_has_aluno, '.$n.' registros afetados<br/>';
			$n=Yii::app()->db->createCommand('UPDATE turma_has_aluno SET aluno_id='.$to.' WHERE aluno_id='.$from)->execute();
			$log .= 'UPDATE em turma_has_aluno, '.$n.' registros afetados<br/>';
			$n=Yii::app()->db->createCommand('DELETE FROM '.Yii::app()->params['tablePrefix'].'aluno WHERE id='.$from)->execute();
			$log .= 'DELETE do aluno, '.$n.' registros afetados';
		   
        	$transaction->commit();
			Yii::app()->user->setFlash('info', $log);
		}
		catch (Exception $e)
		{
			$transaction->rollBack();
			Yii::app()->user->setFlash('error', "{$e->getMessage()}");
			// $this->refresh();
		}
		
		$this->redirect(array('aluno/view', 'id'=>$to));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionDuplicates()
	{   
        $criteria = new CDbCriteria();
		$criteria->condition = 'ra IN (select ra
									from '.Aluno::model()->tableName().' t2'.'
									group  by ra
									having count(*) > 1)';
		$criteria->order = 'LOWER(nome),id ASC';
		
		$dataProvider=new CActiveDataProvider(Aluno::model()->tableName(), array(
		    'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>20,
		    ),
		));
		
		$model=new Aluno('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Aluno']))
			$model->attributes=$_GET['Aluno'];
		
		$this->render('admin',array(
			'model'=>$model,
			'provider'=>$dataProvider,
		));
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
		$model=new Aluno;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Aluno']))
		{
			$model->attributes=$_POST['Aluno'];
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

		if(isset($_POST['Aluno']))
		{
			$model->attributes=$_POST['Aluno'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionUpdemail($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Aluno']))
		{
			$model->email=$_POST['Aluno']['email'];
			if($model->save())
				$this->redirect(array('grades','ra'=>$model->ra, 'instituicao_id'=>$model->instituicao->id));
		}

		$this->render('updemail',array(
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
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// $dataProvider=new CActiveDataProvider('Aluno');
		// $this->render('index',array(
			// 'dataProvider'=>$dataProvider,
		// ));
		$model=new Aluno('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Aluno']))
			$model->attributes=$_GET['Aluno'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Aluno('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Aluno']))
			$model->attributes=$_GET['Aluno'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionImport() 
	{
		$model = array();
		$temp = CUploadedFile::getInstanceByName("file");   
			
        if(isset($temp))
        {
            $string = file_get_contents($temp->tempName);
			//Yii::trace(CVarDumper::dumpAsString($string),'vardump');
			
			$xml = simplexml_load_string($string);
			//Yii::trace(CVarDumper::dumpAsString($xml),'vardump');
			
			$instituicao_id = isset($_POST['instituicao_id'])? $_POST['instituicao_id'] : null;
			foreach ($xml->student as $item) {
				$aluno = new Aluno;
				$aluno->nome = $item->nome . '';
				$aluno->ra = $item->registroAcademico . '';
				$aluno->email = $item->email . '';
				$aluno->instituicao_id = $instituicao_id;
				
				$model[] = $aluno;			
			}
			
			$_SESSION['alunos-import'] = $model; 
        } else if (isset($_SESSION['alunos-import'])) {
        	$model = $_SESSION['alunos-import'];
			unset($_SESSION['alunos-import']);
			
			$transaction = Yii::app()->db->beginTransaction();
			try 
			{
				
				$instituicao_id = isset($_POST['instituicao_id'])? $_POST['instituicao_id'] : null;
				foreach ($model as $item) {
					// Yii::trace(CVarDumper::dumpAsString($item),'vardump');
					$item->instituicao_id = $instituicao_id;
					$item->save(false);
				}
				
				$transaction->commit();
				$this->redirect(array('admin'));
			}
			catch (Exception $e)
			{
				$transaction->rollBack();
				Yii::app()->user->setFlash('error', "Ocorreu um ero ao salvar os alunos: {$e->getMessage()}");
				$this->refresh();
			}	 
        }
		
        $this->render('import', array(
        	'model'=>$model,
        	'instituicao_id'=>isset($_POST['instituicao_id'])? $_POST['instituicao_id'] : 0
		));
	}

	public function actionGrades() 
	{
		// TODO Temp...
		if (Yii::app()->helper->set($_GET['ra'])) {
			$aluno = Aluno::model()->findByAttributes(
			    array('ra'=>$_GET['ra'])
			);
			foreach ($aluno->turmas as $t) {
				if ($t->id == 22) {
					Yii::app()->user->setFlash('info', 'Aluno, ' . 
						CHtml::link('veja suas estrelas clicando aqui.',array('aluno/stars', 'turma_id'=>22, 'ra'=>$_GET['ra'], 'instituicao_id'=>$_GET['instituicao_id'])));
					break;
				}
			}
		}
		
        $this->render('grades', array(
        	// 'model'=>$model,
        	'instituicao_id'=>isset($_POST['instituicao_id'])? $_POST['instituicao_id'] : 0
		));
	}

	public function actionStars() 
	{
		$this->render('stars');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Aluno::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='aluno-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
