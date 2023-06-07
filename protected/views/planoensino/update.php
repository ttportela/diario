<?php
$this->breadcrumbs=array(
	'Planos de Ensino'=>array('index'),
	$turma->nome=>array('view','id'=>$turma->id),
	'Plano de Ensino',
);

// $this->menu=array(
	// array('label'=>'Listar','url'=>array('index')),
	// array('label'=>'Visualizar Turma','url'=>array('turma/view','id'=>$turma->id)),
	// array('label'=>'Visualizar Plano de Ensino','url'=>array('planoensino/view','id'=>$turma->id)),
// );
?>

<div class="page-header">
  <h1>Plano de Ensino <br/><small><?php echo $turma->nome; ?></small></h1>
</div>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>