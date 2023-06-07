<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'ch',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'funcao',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'naies',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'inclusao',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'exclusao',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'formacao',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'telefone',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'projeto_id',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'professor_id',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'aluno_id',array('class'=>'span5','maxlength'=>20)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Pesquisar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
