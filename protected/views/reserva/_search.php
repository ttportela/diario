<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'sala_id',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textAreaRow($model,'finalidade',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'inicio',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fim',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'data',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'solicitante_id',array('class'=>'span5','maxlength'=>20)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Pesquisar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
