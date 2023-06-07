<?php
$this->breadcrumbs=array(
	'Cursos',
);

// $this->menu=array(
	// array('label'=>'List Curso','url'=>array('index')),
	//array('label'=>'Adcicionar','url'=>array('create')),
// );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('curso-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Cursos</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'curso-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nome',
		array(
			'name' => 'instituicao_id',
			'value' => '$data->instituicao->nome', 
		),
		// array(
			// 'class'=>'bootstrap.widgets.TbButtonColumn',
		// ),
	),
)); ?>
