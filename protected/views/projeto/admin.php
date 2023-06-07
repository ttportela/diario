<?php
$this->breadcrumbs=array(
	$this->modelName=>array('index'),
	'Gerenciar',
);

/*$this->menu=array(
	array('label'=>'Cadastrar Projeto','url'=>array('create')),
	array('label'=>'Gerenciar Projeto','url'=>array('admin')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('projeto-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Gerenciar <?php echo $this->modelName; ?></h1>

<!-- <p>
Você pode, opcionalmente, incluir um operador de comparação (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
ou <b>=</b>) antes de cada campo de pesquisa.
</p> -->

<?php echo CHtml::link('Pesquisa Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'projeto-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'documento.nome',
		array(
			//'header'=>'nroprocesso',
            'type'=>'raw',
            'name'=>'nroprocesso',
			'value'=>'str_replace(PHP_EOL, "<br />", $data->nroprocesso)',
			'htmlOptions' => array('max-width' => '30%'),
		),
		'status',
		array(
			//'header'=>'inicio',
            'name'=>'inicio',
			'value'=>'Yii::app()->getDateFormatter()->format("dd/MM/yyyy",strtotime($data->inicio))',
			'htmlOptions' => array('style' => 'text-align:center;'),
		),
		array(
			//'header'=>'fim',
            'name'=>'fim',
			'value'=>'Yii::app()->getDateFormatter()->format("dd/MM/yyyy",strtotime($data->fim))',
			'htmlOptions' => array('style' => 'text-align:center;'),
		),
		// array(
			// //'header'=>'documento_id',
            // 'name'=>'documento_id',
			// 'value'=>'$data->documento->toString()',
		// ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
