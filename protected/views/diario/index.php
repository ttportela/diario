<?php
$this->breadcrumbs=array(
	'Diários',
);

// $this->menu=array(
	// array('label'=>'Adicionar','url'=>array('create')),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1>Diarios</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
