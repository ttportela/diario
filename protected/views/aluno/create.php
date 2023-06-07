<?php
$this->breadcrumbs=array(
	'Alunos'=>array('index'),
	'Novo',
);

// $this->menu=array(
	// // array('label'=>'List Aluno','url'=>array('index')),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1>Novo Aluno</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>