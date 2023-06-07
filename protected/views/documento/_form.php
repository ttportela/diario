<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'documento-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'nome', array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->editorRow($model,'conteudo',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->hiddenField($model,'modelo_id',array('class'=>'span5','maxlength'=>20)); ?>
	
	<?php echo (!($model->isNewRecord)? $form->radioButtonListRow($model,'ativo',array(
														Documento::$STATUS_ATIVO=>'Ativo',
														Documento::$STATUS_INATIVO=>'Inativo',)) : ''); ?>
														
	<?php $date = date("Y-m-d H:i:s", isset($model->criado)? strtotime($model->criado) : date("Y-m-d H:i:s"));
		if (!$model->isNewRecord) echo $form->uneditableRow($model,'criado',$date, array('class'=>'span5','maxlength'=>10)); ?>
	
	<?php $user = Usuario::model()->findByPk($model->isNewRecord? Yii::app()->user->id : $model->criador_id)->toString();
	echo $form->uneditableRow($model,'criador_id', $user, array('class'=>'span5','maxlength'=>10)); ?>

	<?php if (!$hideNext) { ?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Salvar',
		)); ?>
	</div>
	<?php } ?>

<?php $this->endWidget(); ?>
