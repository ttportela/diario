<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'data',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'aulas',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'conteudo',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'turma_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Pesqusar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
