<?php
$this->breadcrumbs=array(
	'Usuários'=>array('index'),
	'Lista',
);

// $this->menu=array(
	// // array('label'=>'List Usuario','url'=>array('index')),
	// array('label'=>'Adicionar','url'=>array('create')),
// );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('usuario-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Usuários</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'usuario-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nome',
		// 'senha',
		'papel',
		// 'professor_id',
		array(
			// 'visible' => 'isset($data->professor)',
			'header' => 'Associado à',
			'value' => 'isset($data->professor)? $data->professor->nome . " (professor)" : (isset($data->aluno)? $data->aluno->nome . " (aluno)" : (isset($data->instituicao)? $data->instituicao->nome . " (instituição)" : "--"))', 
		),
		// 'aluno_id',
		//'instituicao_id',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
