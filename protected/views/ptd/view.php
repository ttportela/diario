<?php
$this->breadcrumbs=array(
	$this->modelName=>array('index'),
	$model->id,
);

/*$this->menu=array(
	array('label'=>'','url'=>array('index'), 'icon'=>'icon-th-list', 'itemOptions'=>array('title'=>'Listagem')),
	array('label'=>'','url'=>array('create'), 'icon'=>'icon-plus', 'itemOptions'=>array('title'=>'Cadastrar')),
	array('label'=>'','url'=>array('update','id'=>$model->id), 'icon'=>'icon-edit', 'itemOptions'=>array('title'=>'Alterar')),
	array('label'=>'','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Tem certeza que deseja excluir este item?'), 'icon'=>'icon-remove', 'itemOptions'=>array('title'=>'Excluir')),
	array('label'=>'','url'=>array('admin'), 'icon'=>'icon-briefcase', 'itemOptions'=>array('title'=>'Gerenciar')),
);*/
?>

<h1> #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ano',
		'semestre',
		array(
			'visible'=>$model->usuario_id == null ? false : true,
			'name'=>'usuario_id',
			'value'=>$model->usuario_id
		),
		array(
			'visible'=>$model->curso_id == null ? false : true,
			'name'=>'curso_id',
			'value'=>$model->curso_id
		),
	),
)); ?>
