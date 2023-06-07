<style type="text/css">
	* {
		font-family: Arial;
	}
	.container-report {
      	margin-left: 5px;
      	margin-right: 5px;
      	right: 0;
      	left: 0;
      	width: 100%;
	}
	
	table.tb-cabecalho {
		width: 100%;
		border-spacing: 0;
	}
	
	table.tb-cabecalho td, table.tb-cabecalho th {
		border: 1px solid #808080;	
		margin: 0;	
	}
	
	table.tb-cabecalho th {
		font-weight: bold;
		text-align: left;	
	}
</style>
<?php

$turma_id = isset($_GET['turma_id'])? $_GET['turma_id'] : null;

if (!(isset($turma_id))) {
		
	/* @var $this ReportController */
	$this->breadcrumbs=array(
		'Relatório'=>array('/report'),
		$pageName,
	);
	?>
	<h1>Folhas de <?php echo $pageName;?></h1>
	<?php 
		
	echo $this->renderPartial('_select-turma', array('targetBlank'=>true));
		
} else {
	$this->layout='report';
	
	$turma = Turma::model()->findByPk($turma_id);
	
	$criteria=new CDbCriteria(array(
		'condition'=>'turma.id='.$turma->id,
		'order'=>'data ASC',
		'with'=>'turma',
	));
	
	$lsdiarios = Diario::model()->findAll($criteria);
	
	$criteria=new CDbCriteria(array(
		'condition'=>'turmas.id='.$turma->id,
		'order'=>'t.nome ASC',
		'with'=>array('turmas'=>array('select'=>'turmas.id', 'joinType'=>'INNER JOIN')),//'turmas',
	));
	
	$lsalunos = Aluno::model()->findAll($criteria);
	
} ?>