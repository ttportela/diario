<?php
$this->breadcrumbs=array(
	'Turmas'=>array('index'),
	'Nova',
);

// $this->menu=array(
	// // array('label'=>'Listar','url'=>array('index')),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1>Nova Turma</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>