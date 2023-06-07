<?php
$this->breadcrumbs=array(
	'Planos de Ensino'=>array('index'),
	'Listagem',
);

// $this->menu=array(
	// array('label'=>'Listar','url'=>array('index')),
// );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('turma-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Planos de Ensino</h1>

<?php echo CHtml::link('Pesquisa Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'turma-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		// 'id',
		'nome',
		// 'ano',
		// 'semestre',
		// 'classe',
		// 'chrelogio',
		// 'chaula',
		// 'horarios',
		// 'observacoes',
		// 'professor_id',
		array(
			'name' => 'professor_id',
			'value' => '$data->professor->nome', 
		),
		// 'disciplina_id',
		// array(
			// 'name' => 'disciplina_id',
			// 'value' => '$data->disciplina->nome', 
		// ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view} {update} {print}',
			'htmlOptions' => array('width' => '60px'),
			'buttons'=>array(
	        	'print'=>array(
	                'label'=>'Imprimir',
	                'icon' => 'icon-print',
	                'url'=>'Yii::app()->createUrl("report/planoensino", array("turma_id"=>$data->id))',
	                'options'=>array('target'=>'_blank'),
	            ),
	        ),
		),
	),
)); ?>
