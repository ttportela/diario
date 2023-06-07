<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.mask.min.js',CClientScript::POS_END);

/* @var $this ReportController */
$this->breadcrumbs=array(
	'Report'=>array('/report'),
	'Notas'=>array('/avaliacao/notas'),
	'Conferência de Avaliações'=>array('/report/ckaval'),
	'Selecionar Turma',
);
?>
<h1>Conferência de Avaliações</h1>
<?php

$turma_id = isset($_GET['turma_id'])? $_GET['turma_id'] : null;

if (!(isset($turma_id))) {
		
	echo $this->renderPartial('./_select-turma', array('targetBlank'=>false));
		
} else {
	
	$turma = Turma::model()->findByPk($turma_id);
	$avaliacoes = Avaliacao::model()->with('turma')->findAll(
	    'turma.id = :tid', array(':tid' => $turma_id)
	);
	
	$this->breadcrumbs=array(
		'Report'=>array('/report'),
		'Notas'=>array('/avaliacao/notas'),
		'Conferência de Avaliações'=>array('/report/ckaval'),
		$turma->toString(),
	);
	
	?>
	<h3>Turma: <?php echo $turma->nome;?></h3>
	<?php 
	
	// $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		// 'id'=>'avaliacoes-form',
		// 'enableAjaxValidation'=>false,
	// ));
	
	// echo $form->errorSummary($model);
	?>
	<style type="text/css">
		input {
			width: inherit;
		}
		
		.pagination {
			display: inline-block;
			padding-left: 0;
			margin: 20px 0;
			border-radius: 4px;
		}
		
		.pagination-lg>li>a, .pagination-lg>li>span {
			padding: 10px 16px;
			font-size: 18px;
		}
		
		.pagination>li>a, .pagination>li>span {
			position: relative;
			float: left;
			padding: 6px 12px;
			margin-left: -1px;
			line-height: 1.42857143;
			color: #428bca;
			text-decoration: none;
			background-color: #fff;
			border: 1px solid #ddd;
		}
		
		nav {
			display: block;
		}
		
		.pagination>li {
			display: inline;
		}
		
		.pagination-lg>li:first-child>a, .pagination-lg>li:first-child>span {
			border-top-left-radius: 6px;
			border-bottom-left-radius: 6px;
		}
		
		.pagination>li:first-child>a, .pagination>li:first-child>span {
			margin-left: 0;
			border-top-left-radius: 4px;
			border-bottom-left-radius: 4px;
		}
		
		.pagination-lg>li:last-child>a, .pagination-lg>li:last-child>span {
			border-top-right-radius: 6px;
			border-bottom-right-radius: 6px;
		}
		
		.pagination>li:last-child>a, .pagination>li:last-child>span {
			border-top-right-radius: 4px;
			border-bottom-right-radius: 4px;
		}
	</style>
	
	<fieldset>
        <legend>
		Legenda:
		<span class="label label-success fa fa-check-circle"> </span> Avaliada - 
		<span class="label label-warning fa fa-check-circle-o"> </span> Com observação -
		<span class="label label-error fa fa-circle-o"> </span> Não avaliada 
        </legend>
        <table class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
        	<thead>
        	<tr>
        		<th style="text-align: center; vertical-align: middle">Aluno</th>
        		<th style="text-align: center; vertical-align: middle">RA</th>
        		<?php
        		foreach ($avaliacoes as $a) {
					?><th class="col-av" style="width: 40px; text-align: center; vertical-align: middle"><?php echo $a->nome; ?></th><?php
				}
        		?>
        	</tr>
        	</thead>
        	<tbody>
        	<?php
        	
				$i=1;
		        foreach ($turma->alunos as $aluno) {
		        	
		        	?>
		        	<tr>
						<td><?php echo $aluno->nome; ?></td>
						<td><?php echo $aluno->ra; ?></td>
						<?php foreach ($avaliacoes as $avaliacao) { 
							$itav = $avaliacao->nota($aluno);	
							
							if (!Yii::app()->helper->set($itav)) {
								?><td class="col-av"><span class="label label-error fa fa-circle-o"> </span></td><?php 
							} else if (!Yii::app()->helper->set($itav->nota) && Yii::app()->helper->set($itav->observacoes)) {
								?><td class="col-av"><span class="label label-warning fa fa-check-circle-o"> </span></td><?php 
							} else {
								?><td class="col-av"><span class="label label-success fa fa-check-circle"> </span></td><?php 
							}
						$i++;
						} ?>
		        	</tr>
		        	<?php
		        }
		?>
		</tbody>
        </table>
    </fieldset>
    
<?php	
	
}
	