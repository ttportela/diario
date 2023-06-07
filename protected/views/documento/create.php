<?php

if (!(isset($modelo))) {

$this->breadcrumbs=array(
	'Documentos'=>array('index'),
	'Novo',
);

// $this->menu=array(
	// array('label'=>'Listar','url'=>array('index')),
	// array('label'=>'Novo Doc','url'=>array('create')),
// );
?>

<div class="page-header">
  <h1>Novo Documento</h1>
</div>

<?php echo $this->renderPartial('_select-docmodelo', array('targetBlank'=>false));

} else { 
	
if ($gen) {
	
?>
<div class="page-header">
  <h1>Novo: <?php echo $modelo->nome; ?></h1>
</div>
<?php 
	
	echo $this->renderPartial('_generate', array('model'=>$model, 'modelo'=>$modelo)); 	
} else {

?>
<div class="page-header">
  <h1><?php echo $model->nome; ?></h1>
</div>
<?php 
	
	echo $this->renderPartial('_form', array('model'=>$model, 'modelo'=>$modelo));	
} 

?>

<?php } ?>