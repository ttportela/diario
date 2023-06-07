<?php
$this->breadcrumbs=array(
	'Cursos'=>array('index'),
	'Novo',
);

// $this->menu=array(
	// // array('label'=>'List Curso','url'=>array('index')),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1>Novo Curso</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>