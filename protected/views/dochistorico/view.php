<?php
$this->breadcrumbs=array(
	'Documentos'=>array('documento/index'),
	$model->documento->nome=>array('documento/view', 'id'=>$model->documento->id),
	'Versões Anteriores'=>array('dochistorico/index', 'id'=>$model->documento->id),
	Yii::app()->getDateFormatter()->format("dd-MM-yyyy ss.mm.HH",strtotime($model->data)),
);

$this->menu_add=array(
	array('label'=>'','url'=>array('dochistorico/restaurar','id'=>$model->id), 'icon'=>'fa fa-repeat', 'itemOptions'=>array('title'=>'Versões Anteriores')),
);

?>

<div class="page-header">
  <h1><?php echo $model->nome; ?>
	<?php echo CHtml::link('',array('/documento/view','id'=>$model->id, 'print'=>1), array('class'=>'icon-print', 'target'=>'_blank', 'title'=>'Imprimir')); ?>
  	<small>Versão <?php echo Yii::app()->getDateFormatter()->format("yyyy-MM-dd ss.mm.HH",strtotime($model->data)); ?></small>
  </h1>
</div>

<?php if (isset($model->documento->modelo->cabecalho_id)) echo $model->documento->modelo->cabecalho->conteudo . '<hr/>';

echo $model->conteudo;

if (isset($model->documento->modelo->rodape_id)) echo '<hr/>' . $model->documento->modelo->rodape->conteudo; ?>
