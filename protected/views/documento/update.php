<?php
$this->breadcrumbs=array(
	'Documentos'=>array('index'),
	$model->nome=>array('view','id'=>$model->id),
	'Edição',
);

// $this->menu=array(
	// array('label'=>'Listar','url'=>array('index')),
	// array('label'=>'Novo','url'=>array('create')),
	// array('label'=>'Visualizar','url'=>array('view','id'=>$model->id)),
// );
?>

<h1><?php echo $model->nome; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>