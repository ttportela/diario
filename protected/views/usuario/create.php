<?php
$this->breadcrumbs=array(
	'Usuários'=>array('index'),
	'Create',
);

// $this->menu=array(
	// // array('label'=>'Listar','url'=>array('index')),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1>Novo Usuário</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>