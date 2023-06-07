<?php

class ReportController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // OWN for ROLE_PROFE
				'actions'=>array('avaliacoes','boletim','boletimind', 'boletimparc', 'capa', 'conteudo', 
					'frequencia', 'notas', 'notasind', 'todos', 'result', 'folhafrequencia', 'planoensino',
					'planner', 'ckaval'),
				'expression'=>'!Yii::app()->user->isGuest && Yii::app()->user->papel == ' . UserIdentity::ROLE_PROFE,
			),
			// array('allow', // OWN for ALUNO
				// 'actions'=>array('planoensino'),
				// 'users'=>array('*'),
			// ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionAvaliacoes()
	{
		$this->render('avaliacoes');
	}

	public function actionBoletim()
	{
		$this->render('boletim');
	}

	public function actionBoletimind()
	{
		$this->render('boletimind');
	}

	public function actionBoletimparc()
	{
		$this->render('boletimparc');
	}

	public function actionCapa()
	{
		$this->render('capa');
	}

	public function actionConteudo()
	{
		$this->render('conteudo');
	}

	public function actionFrequencia()
	{
		$this->render('frequencia');
	}

	public function actionNotas()
	{
		$this->render('notas');
	}

	public function actionNotasind()
	{
		$this->render('notasind');
	}

	public function actionTodos()
	{
		$this->render('todos');
	}

	public function actionResult()
	{
		$this->layout='//layouts/column1';
		
		$this->render('result');
	}

	public function actionFolhafrequencia()
	{
		$this->render('folhafrequencia');
	}

	public function actionPlanner()
	{
		$this->layout=false;
		$mon = date ("Y-m-d", strtotime('monday this week'));
		$sem = date("W", strtotime($mon));
		$this->title = 'Planner ' . $sem . '-' . ($sem+$NUM_SEM);
		$this->render('planner', array('mon' => $mon, 'sem' => $sem));
	}

	public function actionCkaval()
	{
		$this->render('ckaval');
	}

	public function actionPlanoensino()
	{
		$this->layout='//layouts/column1';
		
		// if (isset($_GET['turma_id'])) {
			// $turma = Turma::model()->findByPk($_GET['turma_id']);
			// $this->pageTitle = $turma->ano.'-'.$turma->semestre.' - Plano de Ensino - '.$turma->disciplina->nome;
		// }
		// $this->render('planoensino');
		# Print
        // $html2pdf = Yii::app()->ePdf->HTML2PDF();
		// $html2pdf->setDefaultFont('Arial');
        // $html2pdf->WriteHTML($this->renderPartial('planoensino', array(), true));
        // $html2pdf->Output();
        
        # mPDF
        $mPDF1 = Yii::app()->ePdf->mpdf();
 
        # You can easily override default constructor's params
        // $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
 
        # render (full page)
		$mPDF1->SetHtmlHeader($this->renderPartial('_timbre_IFPR_cabecalho', array(), true));
		$mPDF1->SetHtmlFooter($this->renderPartial('_timbre_IFPR_rodape', array(), true));
        $mPDF1->WriteHTML($this->renderPartial('planoensino', array(), true));
        $mPDF1->SetTitle($this->pageTitle);
 
        # Load a stylesheet
        // $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
        // $mPDF1->WriteHTML($stylesheet, 1);
 
        # renderPartial (only 'view' of current controller)
        // $mPDF1->WriteHTML($this->renderPartial('index', array(), true));
 
        # Renders image
        // $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));
 
        # Outputs ready PDF
        $mPDF1->Output($this->pageTitle, 'I');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}