<?php
$this->breadcrumbs=array(
	'Disciplinas',
);

// $this->menu=array(
	// // array('label'=>'List Disciplina','url'=>array('index')),
	// array('label'=>'Adicionar','url'=>array('create')),
// );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('disciplina-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Disciplinas</h1>

<?php echo CHtml::link('Pesquisa Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'disciplina-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nome',
		'codigo',
		// 'curso_id',
		array(
			'name' => 'curso_id',
			'value' => '$data->curso->nome', 
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}'
		),
	),
)); ?>
