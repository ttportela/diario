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

<div class="page-header">
  <h1>Reserva:<br/>
	<small><?php echo $model->toString(); ?></small>
  </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'visible'=>$model->sala_id == null ? false : true,
			'name'=>'sala_id',
			'value'=>$model->sala->toString()
		),
		'finalidade',
		'inicio',
		'fim',
		'status_str',
		array(
			'visible'=>$model->solicitante_id == null ? false : true,
			'name'=>'solicitante_id',
			'value'=>$model->solicitante->toString()
		),
		'data',
	),
)); ?>
