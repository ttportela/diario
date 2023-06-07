<?php
$this->breadcrumbs=array(
	$this->modelName,
);

/*$this->menu=array(
	array('label'=>'Cadastrar AtividadeTipo','url'=>array('create')),
	array('label'=>'Gerenciar AtividadeTipo','url'=>array('admin')),
);*/


/*Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('atividade-tipo-grid', {
		data: $(this).serialize()
	});
	return false;
});
");*/
?>

<h1><?php echo $this->modelName; ?></h1>

<!-- <p>
Você pode, opcionalmente, incluir um operador de comparação (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
ou <b>=</b>) antes de cada campo de pesquisa.
</p> 

<?php echo CHtml::link('Pesquisa Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'atividade-tipo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			//'header'=>'descricao',
            'type'=>'raw',
            'name'=>'descricao',
			'value'=>'str_replace(PHP_EOL, "<br />", $data->descricao)',
			'htmlOptions' => array('max-width' => '30%'),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
