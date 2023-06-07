<?php

class DiarioController extends Controller
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
				'actions'=>array('delete','update','view'),
				'roles'=>array(UserIdentity::ROLE_PROFE),
				'expression'=> function () {
					return Diario::model()->findByPk($_GET["id"])->turma->professor_id==Yii::app()->user->papel_id;
				},
			),
			array('allow', // OWN for ROLE_PROFE
				'actions'=>array('admin','index','create','bulkupdate','examsheet','examata','ajaxupdate'),
				'roles'=>array(UserIdentity::ROLE_PROFE),
			),
			array('allow', // OWN for ROLE_ADMIN
				'actions'=>array('admin','delete','create','update','bulkupdate','examsheet','examata','index','view'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @param integer $turma_id the ID of the model to be displayed
	 */
	public function actionCreate($turma_id=null)
	{
		$model=new Diario;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Diario']))
		{
			$itens_freq_salvar = array();
			$itens_validos = true;
			$sucesso_salvando_tudo = true;
				
			$model->attributes=$_POST['Diario'];
			
			// itens de Frequência
			if(isset($_POST['Frequencia'])) {
				foreach ($_POST['Frequencia'] as $index => $item_freq) {
					$freq = new Frequencia();
					$freq->attributes = $item_freq;
					
					//Yii::trace(CVarDumper::dumpAsString($item_freq),'vardump');
					
					// ignora os itens que não tem faltas..
					if ($freq->faltas==0) continue;
					
					array_push($itens_freq_salvar, $freq);
				}
			}
			
			if ($model->validate()) {
				$trans = Yii::app()->db->beginTransaction();				
				try {

                    $model->save(false);
				
                    foreach ($itens_freq_salvar as $item_freq) {
                   		$item_freq->diario_id = $model->id;
	                	// $item_freq->isNewRecord = true;
						// $item_freq->id = null;
                        $item_freq->save(false);
                    }
 
                    $trans->commit();
                } catch (Exception $e) {
                    $trans->rollback();
					Yii::app()->helper->error('salvar o diário', $e);
                    $sucesso_salvando_tudo = false;
                }
				
				if ($sucesso_salvando_tudo) {
                    // Caminho feliz
                    Yii::app()->user->setFlash('success', 'Frequências lançadas com sucesso!');
                    $this->redirect(array("view", "id" => $model->id));
                }
			}
		}

		$itens = (isset($itens_freq_salvar)) ? $itens_freq_salvar : array();
		if (isset($turma_id)) {
			$model->turma = Turma::model()->findByPk($turma_id);
			$model->turma_id = $model->turma->id;

			// foreach ($model->turma->alunos as $aluno) {
                // $item_freq = new Frequencia;
				// $item_freq->aluno_id = $aluno->id;
				// $item_freq->faltas = 0;
 				
				// $itens[] = $item_freq;
            // }
		}

		$model->frequencias = $itens;

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

		if(isset($_POST['Diario']))
		{
			$itens_freq_salvar = array();
			$itens_validos = true;
			$sucesso_salvando_tudo = true;
						
			$model->attributes=$_POST['Diario'];
			
			// Start Transaction
			$trans = Yii::app()->db->beginTransaction();
			try {
				
				if(isset($_POST['Frequencia'])) {
					foreach ($_POST['Frequencia'] as $index => $item_freq) {
						// next, validate each submitted instance
	                    if (isset($item_freq['id'])) {
	                        /* Validate that the submitted belong to this artist */
	                        $freq = Frequencia::model()->findByPk($item_freq['id']);
	                    }
	                    else {
	                        $freq = new Frequencia;
	                    }
						
						$freq->attributes = $item_freq;
						
						// ignora os itens que não tem faltas..
						if ($freq->faltas==0) {
							if (!$freq->isNewRecord) {
								$freq->delete(); 
							}
							continue;
						} 
						
						array_push($itens_freq_salvar, $freq);
					}
				}
				
				if ($model->validate()) {	
	
	                    $model->save(false);
					
	                    foreach ($itens_freq_salvar as $item_freq) {
	                        $item_freq->diario_id = $model->id;
	                        $item_freq->save(false);
	                    }
					
				}
				
				$trans->commit();
				
            } catch (Exception $e) {
                $trans->rollback();
				Yii::app()->helper->error('atualizar o diário', $e);
                $sucesso_salvando_tudo = false;
            }
			
			if ($sucesso_salvando_tudo) {
	            // Caminho feliz
	            Yii::app()->user->setFlash('success', 'Frequências lançadas com sucesso!');
	            $this->redirect(array("view", "id" => $model->id));
	        }	
			
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionBulkupdate()
	{
		
		$this->layout='//layouts/column1';
		
		$turma_id = isset($_GET['turma_id'])? $_GET['turma_id'] : null;
		
		if(isset($_POST['Frequencia'])) {
			// Start Transaction
			$trans = Yii::app()->db->beginTransaction();
			try {
				
				$itens_freq_salvar = array();
				$sucesso_salvando_tudo = true;
				
				foreach ($_POST['Frequencia'] as $index => $item_freq) {
					// next, validate each submitted instance
                    if (isset($item_freq['id'])) {
                        /* Validate that the submitted belong to this artist */
                        $freq = Frequencia::model()->findByPk($item_freq['id']);
                    }
                    else {
                        $freq = new Frequencia;
                    }
					
					$freq->attributes = $item_freq;
					// $freq->aluno_id = $item_freq['aluno_id'];
					// $freq->diario_id = $item_freq['diario_id'];
					// $freq->faltas = $item_freq['faltas'];
					
					// ignora os itens que não tem faltas..
					if ($freq->faltas==0) {
						if (!$freq->isNewRecord) {
							$freq->delete(); 
						}
						continue;
					} 
					
					// Yii::trace(CVarDumper::dumpAsString($freq),'vardump');
					
					array_push($itens_freq_salvar, $freq);
				}
				
				foreach ($itens_freq_salvar as $item_freq) {
	            	$item_freq->save(false);
					//Yii::trace(CVarDumper::dumpAsString($item_freq),'vardump');
				}
				
				$trans->commit();
	        } catch (Exception $e) {
	            $trans->rollback();
	            Yii::log("Error occurred while saving diario or its 'items'. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
	            Yii::app()->user->setFlash('error', "Um erro aconteceu. Peça ao administrador do sistema para verificar o problema.");
	            $sucesso_salvando_tudo = false;
	        }
	        
	        if ($sucesso_salvando_tudo) {
                // Caminho feliz
                Yii::app()->user->setFlash('success', 'Frequências lançadas com sucesso!');
                $this->redirect(array("bulkupdate", "turma_id" => $turma_id));
            }
		}
			
		$this->render('bulkupdate');
	}

	public function actionAjaxUpdate($index)
	{
		// echo var_dump($_POST['Frequencia']);
		
		if (isset($_POST['Frequencia'])) {
            
            $item_freq = $_POST['Frequencia'][$index];
			
			if (isset($item_freq['id'])) {
                        /* Validate that the submitted belong to this artist */
                $freq = Frequencia::model()->findByPk($item_freq['id']);
            }
            else {
                $freq = new Frequencia;
            }
			
			$freq->attributes = $item_freq;
			// $freq->aluno_id = $item_freq['aluno_id'];
			// $freq->diario_id = $item_freq['diario_id'];
			// $freq->faltas = $item_freq['faltas'];
			
			// ignora os itens que não tem faltas..
			if ($freq->faltas==0) {
				if (!$freq->isNewRecord) {
					$freq->delete(); 
					$freq->id=null;
				}
			} else {
				$freq->save();	
			}
			
			echo $this->renderPartial('_faltasbtn', array(
		        'freq' => $freq,
		        'i' => $index,
		    ), false, true);
        } //renderInternal
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		// if(Yii::app()->request->isPostRequest)
		// {
			$trans = Yii::app()->db->beginTransaction();
			try {				
			
				// we only allow deletion via POST request
				$model = $this->loadModel($id);
				foreach ($model->frequencias as $item) {
					$item->delete();
				}
				$model->delete();
			
			$trans->commit();
			
			} catch (Exception $e) {
                $trans->rollback();
                Yii::log("Error occurred while deleting diario or its 'items'. Rolling back... . Failure reason as reported in exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
                Yii::app()->user->setFlash('error', "Um erro aconteceu");
                $sucesso_salvando_tudo = false;
            }
			
			$this->redirect(Yii::app()->user->returnUrl);

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			// if (!isset($_GET['ajax']))
				// $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		// }
		// else
			// throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (!Yii::app()->user->checkAccess('admin')) {
			$this->redirect(array('admin'));
		}
		
		$dataProvider=new CActiveDataProvider('Diario');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Diario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Diario']))
			$model->attributes=$_GET['Diario'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionExamsheet()
	{
		$this->render('examsheet');
	}

	/**
	 * Manages all models.
	 */
	public function actionExamata()
	{
		$this->render('examata');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Diario::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='diario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
