<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.mask.min.js',CClientScript::POS_END);

/* @var $this ReportController */
$this->breadcrumbs=array(
	'Notas'=>array('/aluno/grades', 'ra'=>$_GET['ra'], 'instituicao_id'=>$_GET['instituicao_id']),
	'Estrelinhas',
);

$star 		= '<i class="fa fa-star" style="font-size: xx-large;color: gold;"></i>';
$star_half 	= '<i class="fa fa-star-half-o" style="font-size: xx-large;color: lightgoldenrodyellow;"></i>';
$star_none 	= '<i class="fa fa-circle-o" style="font-size: xx-large;color: lightgray;"></i>';

?>
<h1><?php echo $star;?> Stars <?php echo $star;?></h1>
<?php

$turma_id = isset($_GET['turma_id'])? $_GET['turma_id'] : null;
$ra = isset($_GET['ra'])? $_GET['ra'] : null;
$instituicao_id = isset($_GET['instituicao_id'])? $_GET['instituicao_id'] : null;

if (!(isset($ra) && !empty($instituicao_id) && $ra != '' && $instituicao_id != '') && !(isset($turma_id))) {
		
	$this->redirect(array('/aluno/grades', 'ra'=>$_GET['ra'], 'instituicao_id'=>$_GET['instituicao_id']));
		
} else {
	
	$turma = Turma::model()->findByPk($turma_id);
	$aluno = Aluno::model()->findByAttributes(
	    array('ra'=>$ra,'instituicao_id'=>$instituicao_id)
	);
	$avaliacoes = Avaliacao::model()->with('turma')->findAll(
	    'turma.id = :tid', array(':tid' => $turma_id)
	);
	
	?>
	<div class="panel panel-warning">
	  <div class="panel-heading">
	  	<?php echo $aluno->nome;?>
	  	<span class="pull-right">Estrelas para: <?php echo $turma->nome;?></span>
	  </div>
	  <div class="panel-body">
	    <?php 
	    $i = 0;
	    foreach ($avaliacoes as $avaliacao) { 
			$itav = $avaliacao->nota($aluno);	
			
			if (!Yii::app()->helper->set($itav)) {
				?> <?php echo $star_none;?> <?php 
			} else if ((!Yii::app()->helper->set($itav->nota) && !($itav->nota >0)) && Yii::app()->helper->set($itav->observacoes)) {
				?> <?php echo $star_half;?> <?php 
				$i++;
			} else {
				?> <?php echo $star;?> <?php 
				$i++;
			}
		
		} ?>
	  </div>
	  <div class="panel-footer"><?php echo $i;?> Estrelas Douradas</div>
	</div>
    
<?php	
	
}
	