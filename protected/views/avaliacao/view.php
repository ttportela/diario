<?php
$this->breadcrumbs=array(
	'Avaliações'=>array('index'),
	$model->id,
);

// $this->menu=array(
	// // array('label'=>'List Avaliacao','url'=>array('index')),
	// array('label'=>'Adicionar','url'=>array('create')),
	// array('label'=>'Atualizar','url'=>array('update','id'=>$model->id)),
	// array('label'=>'Deletar','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1>View Avaliacao #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nome',
		'bimestre',
		'peso',
		'notamaxima',
		array(
			'name' => 'turma_id',
			'value' => $model->turma->nome, 
		),
	),
)); ?>
