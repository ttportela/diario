<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.mask.min.js',CClientScript::POS_END);

/* @var $this ReportController */
$this->breadcrumbs=array(
	'Avaliação'=>array('/avaliacao'),
	'Notas'=>array('/avaliacao/notas'),
	'Informar Notas',
);
?>
<h1>Notas de Avaliação</h1>
<?php

$turma_id = isset($_GET['turma_id'])? $_GET['turma_id'] : null;

if (!(isset($turma_id))) {
		
	echo $this->renderPartial('/report/_select-turma', array('targetBlank'=>false));
		
} else {
	
	$turma = Turma::model()->findByPk($turma_id);
	$avaliacoes = Avaliacao::model()->with('turma')->findAll(
	    'turma.id = :tid', array(':tid' => $turma_id)
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
	
	<div class="form">
	<?php echo CHtml::beginForm(); ?>
	
	<nav>
	  <ul class="pagination pagination-lg">
	  	<?php
		foreach ($avaliacoes as $a) {
			?><li><a href="#" onclick="toogleAvaliacao(<?php echo $a->id; ?>)" class="btn-av btn-<?php echo $a->id; ?>"><?php echo $a->nome; ?></a></li><?php
		}
		?>
	  </ul>
	</nav>
	
	<fieldset>
        <legend>Informar Notas da Avaliações</legend>
        <table class="table table-bordered table-striped table-hover table-condensed" style="width: 100%;">
        	<thead>
        	<tr>
        		<th rowspan="2" style="text-align: center; vertical-align: middle">Aluno</th>
        		<th rowspan="2" style="text-align: center; vertical-align: middle">RA</th>
        		<?php
        		foreach ($avaliacoes as $a) {
					?><th class="col-av col-<?php echo $a->id; ?>" style="width: 40px; text-align: center; vertical-align: middle" colspan="2"><?php echo $a->nome; ?></th><?php
				}
        		?>
        	</tr>
        	<tr>
        		<?php
        		foreach ($avaliacoes as $a) {
					?><th class="col-av col-<?php echo $a->id; ?>" style="width: 40px; text-align: center; vertical-align: middle">Nota</th>
					<th class="col-av col-<?php echo $a->id; ?>" style="width: 40px; text-align: center; vertical-align: middle">Obs.</th><?php
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
							
							if (!isset($itav)) {
								$itav = new AvaliacaoAluno;
								$itav->avaliacao = $avaliacao;
								$itav->avaliacao_id = $avaliacao->id;
								$itav->aluno = $aluno;
								$itav->aluno_id = $aluno->id;
								$itav->nota = '0';
							}
							
						?>
						<td class="col-av col-<?php echo $avaliacao->id; ?>"><?php 
							echo CHtml::activeTextField($itav,"[$i]nota", array('size'=>3,'maxlength'=>6,'width'=>'25', 'class'=>'nota-input')); 
						?></td>
						<td class="col-av col-<?php echo $avaliacao->id; ?>"><?php echo CHtml::activeTextField($itav,"[$i]observacoes", array('maxlength'=>100, 'width'=>25*10)); ?>
							<?php echo CHtml::activeHiddenField($itav, "[$i]aluno_id", array('value' =>$itav->aluno->id)); ?>
							<?php echo CHtml::activeHiddenField($itav, "[$i]avaliacao_id", array('value' =>$itav->avaliacao->id)); ?>
						</td>
						<?php 
						$i++;
						} ?>
		        	</tr>
		        	<?php
		        }
		?>
		</tbody>
        </table>
    </fieldset>
    
    <script language="javascript">	
		function toogleAvaliacao(i) {
			$('.col-av').hide();
			$('.col-' + i).show();
			
			$('.btn-av').css( "color", "#ccc" );
			$('.btn-av').css( "background-color", "#f9f9f9" );
			$('.btn-' + i).css( "color", "#0088cc" );
			$('.btn-' + i).css( "background-color", "#FFF" );
			
		}
		
		$( window ).load(function() {
			$('.col-av').hide();
		  
			$('.btn-av').css( "color", "#ccc" );
			$('.btn-av').css( "background-color", "#f9f9f9" );
			$(".nota-input").mask("999.99");
		});
	</script>
    
    <!-- <?php echo CHtml::submitButton('Salvar'); ?> -->
    <div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Salvar',
		)); ?>
	</div>
	<div>
	<?php echo CHtml::endForm(); ?>
	</div>
<?php	
	
}
	