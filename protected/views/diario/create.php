<?php
$this->breadcrumbs=array(
	'Diários'=>array('index'),
	'Novo',
);

// $this->menu=array(
	// // array('label'=>'List Diario','url'=>array('index')),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1>Novo Diário</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>