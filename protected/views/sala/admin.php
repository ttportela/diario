<?php
$this->breadcrumbs=array(
	$this->modelName=>array('index'),
	'Gerenciar',
);

/*$this->menu=array(
	array('label'=>'Cadastrar Sala','url'=>array('create')),
	array('label'=>'Gerenciar Sala','url'=>array('admin')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sala-grid', {
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
	'id'=>'sala-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array(
			//'header'=>'descricao',
            'type'=>'raw',
            'name'=>'descricao',
			'value'=>'str_replace(PHP_EOL, "<br />", $data->descricao)',
			'htmlOptions' => array('max-width' => '30%'),
		),
		array(
			//'header'=>'responsavel_instituicao_id',
            'name'=>'responsavel_instituicao_id',
			'value'=>'$data->responsavel_instituicao->toString()',
		),
		array(
			//'header'=>'responsavel_curso_id',
            'name'=>'responsavel_curso_id',
			'value'=>'$data->responsavel_curso->toString()',
		),
		array(
			//'header'=>'responsavel_usuario_id',
            'name'=>'responsavel_usuario_id',
			'value'=>'$data->responsavel_usuario->toString()',
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
