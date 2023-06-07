<?php
$this->breadcrumbs=array(
	'Alunos'=>array('index'),
	'Lista',
);

// $this->menu=array(
	// // array('label'=>'Listar','url'=>array('index')),
	// array('label'=>'Novo','url'=>array('create')),
// );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('aluno-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Alunos</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'aluno-grid',
	'dataProvider'=>Yii::app()->helper->set($provider)? $provider : $model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nome',
		'ra',
		'email',
		array(
			'name' => 'instituicao_id',
			'value' => '$data->instituicao->nome', 
		),
		// 'instituicao_id',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
