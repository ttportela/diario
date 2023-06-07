<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'planoensino-form',
	'enableAjaxValidation'=>false,
)); ?>

	<!-- <p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p> -->

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->checkBoxRow($model,'publicarpe',array('value' => '1', 'uncheckValue'=>'0')); ?>
	
    <?php echo $form->textFieldRow($model,'periodo',array('class'=>'span5')); ?>

	<br/><hr/><br/>
    <?php echo $form->editorRow($model,'ementa',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<br/><hr/><br/>
    <?php echo $form->editorRow($model,'objetivosgerais',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<br/><hr/><br/>
    <?php echo $form->editorRow($model,'objetivosespecificos',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<br/><hr/><br/>
    <?php echo $form->editorRow($model,'conteudo',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<br/><hr/><br/>
    <?php echo $form->editorRow($model,'metodologia',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<br/><hr/><br/>
    <?php echo $form->editorRow($model,'recursos',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<br/><hr/><br/>
    <?php echo $form->editorRow($model,'bibbasica',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<br/><hr/><br/>
    <?php echo $form->editorRow($model,'bibcomplementar',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
