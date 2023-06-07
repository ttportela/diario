<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'curso-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'nome',array('class'=>'span5','maxlength'=>50)); ?>

	<div>
		<?php echo $form->labelEx($model,'instituicao_id'); ?>
		<?php echo $form->dropDownList($model, 'instituicao_id', CHtml::listData(
		Instituicao::model()->findAll(), 'id', 'nome'),
		array('prompt' => 'Selecione a instituição','class'=>'span5')
		); ?>
		<?php echo $form->error($model,'instituicao_id'); ?>
	</div>
	
	<?php echo $form->dropDownListRow($model, 'coordenador_id', CHtml::listData(
		Professor::model()->findAll(), 'id', 'nome'),
		array('prompt' => '- Nenhum Coordenador -','class'=>'span5')
		); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Adicionar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
