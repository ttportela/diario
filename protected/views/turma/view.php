<?php
$this->breadcrumbs=array(
	'Turmas'=>array('index'),
	$model->nome,
);

// $this->menu=array(
	// // array('label'=>'List Usuario','url'=>array('index')),
	// array('label'=>'Adicionar','url'=>array('create')),
	// array('label'=>'Alterar','url'=>array('update','id'=>$model->id)),
	// array('label'=>'Deletar','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Tem certeza que deseja excluir este item?')),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1>Turma - <?php echo $model->disciplina->nome . ' (' . $model->ano . '-' . $model->semestre . ')'; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		// 'nome',
		'ano',
		'semestre',
		'classe',
		'chrelogio',
		'chaula',
		'horarios',
		'observacoes',
		// 'professor_id',
		array(
			'name' => 'professor_id',
			'value' => $model->professor->nome, 
		),
		// 'disciplina_id',
		array(
			'name' => 'disciplina_id',
			'value' => $model->disciplina->nome, 
		),
	),
)); ?>

<br/><br/>
<legend>Rendimento Médio - <?php echo $model->disciplina->nome . ' (' . $model->ano . '-' . $model->semestre . ')'; ?></legend>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name' => 'notamedia',
			'value' => $model->notamedia, 
		),
		array(
			'name' => 'nroap',
			'value' => $model->nroap, 
		),
		array(
			'name' => 'nrorp',
			'value' => $model->nrorp, 
		),
	),
)); ?>

<br/><br/>
<legend>Alunos</legend>

<?php
	$config = array();
	$dataProvider = new CArrayDataProvider($rawData=$model->alunos, $config);

	$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'alunos',
	'dataProvider'=>$dataProvider,//Frequencia::model()->findAll(array('diario_id' => '$model->id')),
	// 'filter'=>$modelHistory,
	'columns'=>array(
		array(
            'name'=>'Nome',
            'value'=>'$data->nome',
        ),
		array(
            'name'=>'E-mail',
            'value'=>'$data->email',
        ),
	),
)); ?>