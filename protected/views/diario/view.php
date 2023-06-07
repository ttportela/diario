<?php
$this->breadcrumbs=array(
	'Diários'=>array('index'),
	$model->id,
);

// $this->menu=array(
	// // array('label'=>'List Diario','url'=>array('index')),
	// array('label'=>'Adicionar','url'=>array('create')),
	// array('label'=>'Alterar','url'=>array('update','id'=>$model->id)),
	// array('label'=>'Deletar','url'=>array('delete','id'=>$model->id),'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	// array('label'=>'Listar','url'=>array('admin')),
// );

Yii::app()->user->returnUrl = array('diario/admin', 'turma_id'=>$model->turma->id);

?>

<h1>Diário #<?php echo $model->turma->nome .' (' .$model->data. ')'; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'data',
		'aulas',
		'conteudo',
		array(
			'name' => 'turma_id',
			'value' => $model->turma->nome, 
		),
	),
)); ?>

<br/><br/>
<legend>Frequência</legend>

<?php 
	
	$config = array();
	$rawData = array();
	
	$alunos = Turma::model()->findByPk($model->turma->id)->alunos;
	foreach ($alunos as $a) {
		$freq = $model->getFrequencia($a);
		$rawData[] = $freq;
	}
	
	$dataProvider = new CArrayDataProvider($rawData, $config);

	$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'frequencias',
	'dataProvider'=>$dataProvider,
	// 'filter'=>$modelHistory,
	'columns'=>array(
		array(
            'name'=>'Aluno',
            'value'=>'$data->aluno->nome',
        ),
		array(
            'name'=>'Faltas',
            'value'=>'$data->faltas',
        ),
	),
)); ?>
