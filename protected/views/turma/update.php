<?php
$this->breadcrumbs=array(
	'Turmas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Atualizar',
);

// $this->menu=array(
	// // array('label'=>'Listar','url'=>array('index')),
	// array('label'=>'Adicionar','url'=>array('create')),
	// array('label'=>'Visualizar','url'=>array('view','id'=>$model->id)),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1>Turma <?php echo $model->nome; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>