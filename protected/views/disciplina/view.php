<?php
$this->breadcrumbs=array(
	'Disciplinas'=>array('index'),
	$model->id,
);

// $this->menu=array(
	// // array('label'=>'List Disciplina','url'=>array('index')),
	// array('label'=>'Adicionar','url'=>array('create')),
	// array('label'=>'Atualizar','url'=>array('update','id'=>$model->id)),
	// array('label'=>'Deletar','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1>View Disciplina #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nome',
		'codigo',
		array(
			'name' => 'curso_id',
			'value' => $model->curso->nome, 
		),
	),
)); ?>
