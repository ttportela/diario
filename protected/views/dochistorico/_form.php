<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'documento-historico-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textAreaRow($model,'nome',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textAreaRow($model,'conteudo',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textAreaRow($model,'observacoes',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->dateRow($model, 'data', array('class' => 'control-label')); ?>

	<?php echo $form->uneditableRow($model,'documento_id', $model->documento->nome, array('class'=>'span5','maxlength'=>10)); ?>
			
	<?php echo $form->selectorRow($model,'criador_id', 
			$model->criador_id, (Yii::app()->helper->set($model->criador)? $model->criador->toString():''),
			(Usuario::model()), null); ?>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Criar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
