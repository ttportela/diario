<?php
$this->breadcrumbs=array(
	'Documentos'=>array('index'),
	$model->nome,
);

$this->menu_add=array(
	array('label'=>'','url'=>array('dochistorico/index','id'=>$model->id), 'icon'=>'fa fa-history', 'itemOptions'=>array('title'=>'Versões Anteriores')),
);
?>

<div class="page-header">
  <h1><?php echo $model->nome; ?>
	<?php echo CHtml::link('',array('/documento/view','id'=>$model->id, 'print'=>1), array('class'=>'icon-print', 'target'=>'_blank', 'title'=>'Imprimir')); ?>
  </h1>
</div>

<?php if (isset($model->modelo->cabecalho_id)) echo $model->modelo->cabecalho->conteudo . '<hr/>';

echo $model->conteudo;

if (isset($model->modelo->rodape_id)) echo '<hr/>' . $model->modelo->rodape->conteudo; ?>
