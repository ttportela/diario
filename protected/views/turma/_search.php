<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'nome',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'ano',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'semestre',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'classe',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'chrelogio',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'chaula',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'horarios',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'observacoes',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'professor_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'disciplina_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Pesquisar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
