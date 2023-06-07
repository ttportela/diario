<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'avaliacao-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'nome',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'bimestre',array('class'=>'span5')); ?>
	<?php echo $form->labelEx($model,'bimestre'); ?>
	<?php echo $form->radioButtonList($model,'bimestre',array(
														  Avaliacao::$BIM_1=>'1º Bimestre', 
														  Avaliacao::$BIM_2=>'2º Bimestre',
														  Avaliacao::$EXAME=>'Exame')); ?>
	<?php echo $form->error($model,'bimestre'); ?>

	<?php echo $form->textFieldRow($model,'peso',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'notamaxima',array('class'=>'span5')); ?>

	<div>
		<small><?php echo $form->labelEx($model,'turma_id'); ?></small>
		<?php echo $form->dropDownList($model, 'turma_id', CHtml::listData(
		Yii::app()->helper->currentTurmas(), 'id', 'nome'),
		array('prompt' => 'Selecione a turma','class'=>'span5')
		); ?>
		<?php echo $form->error($model,'turma_id'); ?>
	</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Adicionar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
