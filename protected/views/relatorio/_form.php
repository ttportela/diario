<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'relatorio-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->selectorRow($model,'projeto_id', $model->projeto_id, 
		(Yii::app()->helper->set($model->projeto)? $model->projeto->toString():''),
		(Projeto::model()), null); ?>

	<?php echo $form->dateTimeRow($model, 'data'); ?>

	<?php echo $form->textFieldRow($model, 'texto', array('maxlength'=>200)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Criar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
