<?php
$this->breadcrumbs=array(
	$this->modelName=>array('index'),
	'Gerenciar',
);

/*$this->menu=array(
	array('label'=>'Cadastrar DocumentoHistorico','url'=>array('create')),
	array('label'=>'Gerenciar DocumentoHistorico','url'=>array('admin')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('documento-historico-grid', {
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
	'id'=>'documento-historico-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
			//'header'=>'nome',
            'type'=>'raw',
            'name'=>'nome',
			'value'=>'str_replace(PHP_EOL, "<br />", $data->nome)',
			'htmlOptions' => array('max-width' => '30%'),
		),
		array(
			//'header'=>'conteudo',
            'type'=>'raw',
            'name'=>'conteudo',
			'value'=>'str_replace(PHP_EOL, "<br />", $data->conteudo)',
			'htmlOptions' => array('max-width' => '30%'),
		),
		array(
			//'header'=>'observacoes',
            'type'=>'raw',
            'name'=>'observacoes',
			'value'=>'str_replace(PHP_EOL, "<br />", $data->observacoes)',
			'htmlOptions' => array('max-width' => '30%'),
		),
		array(
			//'header'=>'aletrado',
            'name'=>'data',
			'value'=>'Yii::app()->getDateFormatter()->format("dd/MM/yyyy",strtotime($data->aletrado))',
			'htmlOptions' => array('style' => 'text-align:center;'),
		),
		array(
			//'header'=>'documento_id',
            'name'=>'documento_id',
			'value'=>'$data->documento->toString()',
		),
		/*
		array(
			//'header'=>'criador_id',
            'name'=>'criador_id',
			'value'=>'$data->criador->toString()',
		),
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
