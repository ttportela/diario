<?php
$this->breadcrumbs=array(
	'Documentos'
);

// $this->menu=array(
	// array('label'=>'Listar','url'=>array('index')),
	// array('label'=>'Novo','url'=>array('create')),
// );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('documento-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Documentos</h1>

<!--<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'documento-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		// 'id',
		'nome',
		// 'conteudo',
		// 'modelo_id',
		array(
			'name' => 'criado',
			'value' => 'Yii::app()->format->date_dmy($data->criado)', 
		),
		// array(
			// 'name' => 'criador_id',
			// 'value' => '$data->criador->toString()', 
		// ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{print} {view} {update} {delete}',
			'htmlOptions' => array('width' => '70px'),
			'buttons'=>array(
	        	'print'=>array(
	                'label'=>'Imprimir',
	                'icon' => 'icon-print',
	                'url'=>'Yii::app()->createUrl("documento/view", array("id"=>$data->id,"print"=>1))',
	                'options'=>array('target'=>'_blank'),
	            ),
	        ),
		),
	),
)); ?>
