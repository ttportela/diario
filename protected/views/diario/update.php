<?php
$this->breadcrumbs=array(
	'Diarios'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Atualizar',
);

// $this->menu=array(
	// // array('label'=>'List Diario','url'=>array('index')),
	// array('label'=>'Adicionar','url'=>array('create')),
	// array('label'=>'Visualizar','url'=>array('view','id'=>$model->id)),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1>Diário <?php echo $model->turma->nome . ' (' .$model->data. ')'; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>