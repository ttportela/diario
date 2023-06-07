<?php
$this->breadcrumbs=array(
	$this->modelName=>array('index'),
	'Gerenciar',
);

/*$this->menu=array(
	array('label'=>'Cadastrar Interessado','url'=>array('create')),
	array('label'=>'Gerenciar Interessado','url'=>array('admin')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('interessado-grid', {
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
	'id'=>'interessado-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'ch',
		'funcao',
		'naies',
		array(
			//'header'=>'inclusao',
            'name'=>'inclusao',
			'value'=>'Yii::app()->getDateFormatter()->format("dd/MM/yyyy",strtotime($data->inclusao))',
			'htmlOptions' => array('style' => 'text-align:center;'),
		),
		array(
			//'header'=>'exclusao',
            'name'=>'exclusao',
			'value'=>'Yii::app()->getDateFormatter()->format("dd/MM/yyyy",strtotime($data->exclusao))',
			'htmlOptions' => array('style' => 'text-align:center;'),
		),
		/*
		'formacao',
		'telefone',
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
			//'header'=>'aluno_id',
            'name'=>'aluno_id',
			'value'=>'$data->aluno->toString()',
		),
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
