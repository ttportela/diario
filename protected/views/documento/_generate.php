<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'documento-form',
	'enableAjaxValidation'=>false,
)); 

$docmodel = Yii::app()->doc->createForm($modelo);

?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($docmodel); ?>

	<?php echo $form->textFieldRow($docmodel,'nome', array('class'=>'span5','maxlength'=>100)); ?>

	<?php 
		foreach ($docmodel->fields as $field) {
			echo $field->formField($form);
		}
	?>

	<?php echo $form->hiddenField($docmodel,'modelo_id',array('class'=>'span5','maxlength'=>20, 'value'=>$modelo->id)); ?>

	<?php if (!$hideNext) { ?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Próximo',
		)); ?>
	</div>
	<?php } ?>

<?php $this->endWidget(); ?>
