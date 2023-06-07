<?php
$this->breadcrumbs=array(
	$this->modelName=>array('index'),
	'Novo',
);

/*$this->menu=array(
	array('label'=>'','url'=>array('index'), 'icon'=>'icon-th-list', 'itemOptions'=>array('title'=>'Listagem')),
	array('label'=>'','url'=>array('admin'), 'icon'=>'icon-briefcase', 'itemOptions'=>array('title'=>'Gerenciar')),
);*/
?>

<h1>Cadastro</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'items'=>$items)); ?>