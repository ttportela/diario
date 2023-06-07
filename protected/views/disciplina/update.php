<?php
$this->breadcrumbs=array(
	'Disciplinas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Atualizar',
);

// $this->menu=array(
	// // array('label'=>'List Disciplina','url'=>array('index')),
	// array('label'=>'Adicionar','url'=>array('create')),
	// array('label'=>'Visualizar','url'=>array('view','id'=>$model->id)),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1>Disciplina <?php echo $model->nome; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>