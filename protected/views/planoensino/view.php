<?php
$this->breadcrumbs=array(
	'Planos de Ensino'=>array('index'),
	$model->nome,
);

// $this->menu=array(
	// array('label'=>'Atualizar','url'=>array('update','id'=>$model->id)),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<div class="page-header">
  <h1>Plano de Ensino <br/>
  	<small><?php echo $model->nome; ?> 
  	<?php echo CHtml::link('',array('/report/planoensino','turma_id'=>$model->id), array('class'=>'icon-print', 'target'=>'_blank', 'title'=>'Imprimir Plano de Ensino')); ?>
  	</small></h1>
</div>

<div class="page-header">
  <h3>1. DADOS DE INDENTIFICAÇÃO</h3>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'label' => 'Instituição',
			'value' => strtoupper($model->disciplina->curso->instituicao->nome), 
		),
		array(
			'label' => 'Curso',
			'value' => strtoupper($model->disciplina->curso->nome), 
		),
		array(
			'name' => 'ano',
			'value' => $model->ano, 
		),
		array(
			'name' => 'semestre',
			'value' => $model->semestre . 'º', 
		),
		array(
			'name' => 'periodo',
			'value' => $model->disciplina->periodo . 'º', 
		),
		array(
			'label' => 'Disciplina',
			'value' => strtoupper($model->disciplina->nome), 
		),
		array(
			'label' => 'Carga Horária',
			'value' => $model->chrelogio . ' h - ' . ($model->chaula/20) . ' créditos – ' . $model->chaula . ' h/a', 
		),
		array(
			'label' => 'Professor',
			'value' => strtoupper($model->professor->nome), 
		),
	),
)); ?>

<br/>
<div class="page-header">
  <h3>2. EMENTA</h3>
</div>
<?php echo $model->disciplina->ementa; ?>

<br/>
<div class="page-header">
  <h3>3. OBJETIVOS</h3>
</div>

<h3>3.1. Gerais</h3>
<?php echo $model->objetivosgerais; ?>

<h3>3.2. Específicos</h3>
<?php echo $model->objetivosespecificos; ?>

<br/>
<div class="page-header">
  <h3>4. CONTEÚDO PROGRAMÁTICO</h3>
</div>
<?php echo $model->conteudo; ?>

<br/>
<div class="page-header">
  <h3>5. METODOLOGIA</h3>
</div>
<?php echo $model->metodologia; ?>

<br/>
<div class="page-header">
  <h3>6. RECURSOS DIDÁTICOS</h3>
</div>
<?php echo $model->recursos; ?>

<br/>
<div class="page-header">
  <h3>7. BIBLIOGRAFIA</h3>
</div>

<h3>7.1. Bibliografia Básica</h3>
<?php echo $model->disciplina->bibbasica; ?>

<h3>7.2. Bibliografia Complementar</h3>
<?php echo $model->bibcomplementar; ?>