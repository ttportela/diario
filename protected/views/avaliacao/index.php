<?php
$this->breadcrumbs=array(
	'Avaliações',
);

// $this->menu=array(
	// // array('label'=>'List Avaliacao','url'=>array('index')),
	// array('label'=>'Adicionar','url'=>array('create')),
// );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('avaliacao-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Avaliações</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'avaliacao-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nome',
		'bimestre',
		'peso',
		'notamaxima',
		array(
			'name' => 'turma_id',
			'value' => '$data->turma->nome', 
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
