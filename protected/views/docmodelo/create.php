<?php
$this->breadcrumbs=array(
	'Modelos de Documentos'=>array('index'),
	'Novo',
);

// $this->menu=array(
	// array('label'=>'Listar','url'=>array('index')),
	// array('label'=>'Meus Documentos','url'=>array('documento/index')),
// );
?>

<h1>Novo Modelo de Documento</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>