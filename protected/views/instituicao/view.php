<?php
$this->breadcrumbs=array(
	'Instituições'=>array('index'),
	$model->id,
);

// $this->menu=array(
	// // array('label'=>'List Usuario','url'=>array('index')),
	// array('label'=>'Adicionar','url'=>array('create')),
	// array('label'=>'Alterar','url'=>array('update','id'=>$model->id)),
	// array('label'=>'Deletar','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Tem certeza que deseja excluir este item?')),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1>View Instituicao #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nome',
		'sigla',
	),
)); ?>
