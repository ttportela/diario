<?php
$this->breadcrumbs=array(
	'Aluno'=>array('index'),
	'Importar',
); ?>

<h1>Importar Alunos</h1>

<?php echo CHtml::form('','post',array('enctype'=>'multipart/form-data')); ?>

<div class="well">
	<?php echo CHtml::label('Arquivo XML',''); ?>
	<?php echo CHtml::fileField('file', '', array('class'=>'span5')); ?>
	
	<div>
		<?php echo CHtml::label('Instituição', ''); ?>
		<?php echo CHtml::dropDownList('instituicao_id', ($instituicao_id != 0)? $instituicao_id : '', CHtml::listData(
		Instituicao::model()->findAll(), 'id', 'nome')
		//array('prompt' => 'Selecione a instituição','class'=>'span5')
		); ?>
	</div>
</div>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Enviar',
	)); ?>
</div>

<?php //echo CHtml::submitButton('Enviar'); ?>
<?php echo CHtml::endForm(); ?>

<?php 
if (isset($model) && !empty($model)) {
	
	$config = array();
	$dataProvider = new CArrayDataProvider($model, $config);
	$dataProvider->pagination->pageSize = count($model);
	
	$this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'aluno-grid',
		'dataProvider'=>$dataProvider,
		'template'=>"{items}",
		'columns'=>array(
			array(
	            'name'=>'Registro Acadêmico',
	            'value'=>'$data->ra',
	        ),
			array(
	            'name'=>'Nome',
	            'value'=>'$data->nome',
	        ),
			array(
	            'name'=>'E-mail',
	            'value'=>'$data->email',
	        ),
		),
	));
} ?>