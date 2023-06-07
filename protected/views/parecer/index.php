<?php
$this->breadcrumbs=array(
	$this->modelName,
);

/*$this->menu=array(
	array('label'=>'Cadastrar Parecer','url'=>array('create')),
	array('label'=>'Gerenciar Parecer','url'=>array('admin')),
);*/


/*Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('parecer-grid', {
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
	'id'=>'parecer-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			//'header'=>'projeto_id',
            'name'=>'projeto_id',
			'value'=>'$data->projeto->toString()',
		),
		array(
			//'header'=>'professor_id',
            'name'=>'professor_id',
			'value'=>'$data->professor->toString()',
		),
		array(
			//'header'=>'data',
            'name'=>'data',
			'value'=>'Yii::app()->getDateFormatter()->format("dd/MM/yyyy",strtotime($data->data))',
			'htmlOptions' => array('style' => 'text-align:center;'),
		),
		array(
			//'header'=>'texto',
            'type'=>'raw',
            'name'=>'texto',
			'value'=>'str_replace(PHP_EOL, "<br />", $data->texto)',
			'htmlOptions' => array('max-width' => '30%'),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
