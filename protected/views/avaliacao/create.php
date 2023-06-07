<?php
$this->breadcrumbs=array(
	'Avaliacões'=>array('index'),
	'Nova',
);

// $this->menu=array(
	// // array('label'=>'List Avaliacao','url'=>array('index')),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1>Nova Avaliação</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>