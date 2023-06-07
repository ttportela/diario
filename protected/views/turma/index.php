<?php
$this->breadcrumbs=array(
	'Turmas',
);

// $this->menu=array(
	// // array('label'=>'List Turma','url'=>array('index')),
	// array('label'=>'Adicionar','url'=>array('create')),
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

<h1>Turmas</h1>

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
		'id',
		'nome',
		'ano',
		'semestre',
		// 'classe',
		'chrelogio',
		'chaula',
		// 'horarios',
		// 'observacoes',
		// 'professor_id',
		array(
			'name' => 'professor_id',
			'value' => '$data->professor->nome', 
		),
		// 'disciplina_id',
		array(
			'name' => 'disciplina_id',
			'value' => '$data->disciplina->nome', 
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{bulkupdate}{createavaliacao}{indexavaliacao}{notas}{view}{update}{delete}',
			'htmlOptions' => array('width' => '60px'),
			'buttons'=>array(
	        	'bulkupdate'=>array(
	                'label'=>'Conferência de Diários',
	                'icon' => 'icon-list-alt',
	                'url'=>'Yii::app()->createUrl("diario/bulkupdate", array("turma_id"=>$data->id))',
	            ),
	            'createavaliacao'=>array(
	                'label'=>'Inserir Avaliação',
	                'icon' => 'icon-edit',
	                'url'=>'Yii::app()->createUrl("avaliacao/create", array("turma_id"=>$data->id))',
	            ),
	            'indexavaliacao'=>array(
	                'label'=>'Listar Avaliações',
	                'icon' => 'icon-check',
	                'url'=>'Yii::app()->createUrl("avaliacao/index", array("turma_id"=>$data->id))',
	            ),
	            'notas'=>array(
	                'label'=>'Notas',
	                'icon' => 'icon-flag',
	                'url'=>'Yii::app()->createUrl("avaliacao/notas", array("turma_id"=>$data->id))',
	            ),
	        ),
		),
	),
)); ?>
