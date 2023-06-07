<?php
$this->breadcrumbs=array(
	'Modelos de Documentos'=>array('index'),
	$model->nome,
);

// $this->menu=array(
	// array('label'=>'Listar','url'=>array('index')),
	// array('label'=>'Novo','url'=>array('create')),
	// array('label'=>'Editar','url'=>array('update','id'=>$model->id)),
	// array('label'=>'Excluir','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Tem certeza que deseja excluir este item?')),
// );
?>

<div class="page-header">
  <h1><?php echo $model->nome; ?></h1>
</div>

<?php if (isset($model->cabecalho_id)) echo $model->cabecalho->conteudo . '<hr/>'; ?>

<?php echo $model->conteudo; ?>

<?php if (isset($model->rodape_id)) echo '<hr/>' . $model->rodape->conteudo; ?>
