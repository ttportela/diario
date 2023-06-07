<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'ptd-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'ano',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'semestre',array('class'=>'span5')); ?>

	<div>
		<small><?php echo $form->labelEx($model,'usuario_id'); ?></small>
		<?php echo $form->dropDownList($model, 'usuario_id', CHtml::listData(
		Usuario::model()->findAll(), 'id', 'id'), // Maybe you have to chage de value column to another
		array('prompt' => '...','class'=>'span5')); ?>
		<?php echo $form->error($model,'usuario_id'); ?>
	</div>
	<div>
		<small><?php echo $form->labelEx($model,'curso_id'); ?></small>
		<?php echo $form->dropDownList($model, 'curso_id', CHtml::listData(
		Curso::model()->findAll(), 'id', 'id'), // Maybe you have to chage de value column to another
		array('prompt' => '...','class'=>'span5')); ?>
		<?php echo $form->error($model,'curso_id'); ?>
	</div>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Criar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
