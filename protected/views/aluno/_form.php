<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'aluno-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'nome',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'ra',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>50)); ?>

	<div>
		<?php echo $form->labelEx($model,'instituicao_id'); ?>
		<?php echo $form->dropDownList($model, 'instituicao_id', CHtml::listData(
		Instituicao::model()->findAll(), 'id', 'nome'),
		array('prompt' => 'Selecione a instituição','class'=>'span5')
		); ?>
		<?php echo $form->error($model,'instituicao_id'); ?>
	</div>

	<!-- <?php echo $form->textFieldRow($model,'instituicao_id',array('class'=>'span5')); ?> -->

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Adicionar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
