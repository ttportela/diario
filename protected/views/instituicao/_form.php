<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'instituicao-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'nome',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'sigla',array('class'=>'span5','maxlength'=>20)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Adicionar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
