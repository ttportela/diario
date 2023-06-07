<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'area-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'codigo',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->radioButtonList($model,'nivel',array(
														  Area::N_1=>'Grande área ', 
														  Area::N_2=>'Área',
														  Area::N_3=>'Subárea',
														  Area::N_4=>'Especialidade')); ?>

	<?php echo $form->textFieldRow($model, 'texto', array('class'=>'span5', 'maxlength'=>200)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Criar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
