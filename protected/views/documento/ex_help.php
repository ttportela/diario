<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'documento-form',
	'enableAjaxValidation'=>false,
)); ?>

<div class="page-header">
  <h1><?php echo $model->nome; ?>
	<small>Exemplo de uso de campos do documento</small>
  </h1>
</div>

	<!-- <p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p> -->

	<?php //echo $form->errorSummary($model); ?>

	<?php //echo $form->textFieldRow($model,'nome', array('class'=>'span5','maxlength'=>100)); ?>

	<?php //echo $form->editorRow($model,'conteudo',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->hiddenField($model,'modelo_id',array('class'=>'span5','maxlength'=>20)); ?>
	
	<?php 
		foreach ($model->fields as $field) { ?>
			<div class="page-header">
			  <h3>Campo <?php echo $field::NAME; ?>:<br/>
				<small><?php echo $field->toString(); ?></small>
			  </h3>
			  <?php echo $field->formField($form); ?>
			</div>			
		<?php
		}
	?>
	
	<div class="form-actions">
		<?php /*$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Salvar',
		)); */?>
	</div>

<?php $this->endWidget(); ?>
