<?php
$this->breadcrumbs=array(
	'Disciplinas'=>array('index'),
	'Nova',
);

// $this->menu=array(
	// // array('label'=>'List Disciplina','url'=>array('index')),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1>Nova Disciplina</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>