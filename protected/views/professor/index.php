<?php
$this->breadcrumbs=array(
	'Professores',
);

// $this->menu=array(
	// array('label'=>'Novo','url'=>array('create')),
	// array('label'=>'Administrar','url'=>array('admin')),
// );
?>

<h1>Professores</h1>


<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
