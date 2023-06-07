<?php
$this->breadcrumbs=array(
	$model->ra=>array('grades','ra'=>$model->ra),
	'Atualizar E-mail',
);
?>

<h1><?php echo $model->nome; ?></h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'aluno-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>50)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>