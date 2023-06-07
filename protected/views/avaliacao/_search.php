<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nome',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'bimestre',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'peso',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'notamaxima',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'turma_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Pesquisar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
