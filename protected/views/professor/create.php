<?php
$this->breadcrumbs=array(
	'Professores'=>array('index'),
	'Novo',
);

// $this->menu=array(
	// // array('label'=>'Listar','url'=>array('index')),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1>Novo Professor</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>