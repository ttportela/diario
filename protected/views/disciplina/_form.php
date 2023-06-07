<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'disciplina-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'nome',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'codigo',array('class'=>'span5','maxlength'=>20)); ?>

	<div>
		<small><?php echo $form->labelEx($model,'curso_id'); ?></small>
		<?php echo $form->dropDownList($model, 'curso_id', CHtml::listData(
		Curso::model()->findAll(), 'id', 'nome'),
		array('prompt' => 'Selecione o curso','class'=>'span5')
		); ?>
		<?php echo $form->error($model,'curso_id'); ?>
	</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Adicionar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
