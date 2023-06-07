<?php
$this->breadcrumbs=array(
	'Instituições',
);

// $this->menu=array(
	// array('label'=>'Adicionar','url'=>array('create')),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1>Instituições</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
