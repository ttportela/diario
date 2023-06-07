<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'reserva-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->selectorRow($model, 'sala_id', 
			$model->sala_id, (Yii::app()->helper->set($model->sala_id)? $model->sala->toString():''),
			Sala::model(), null
			); ?>
	
	<?php echo $form->textAreaRow($model,'finalidade',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->dateTimeRow($model, 'inicio', array('class' => 'control-label')); ?>
	
	<?php echo $form->dateTimeRow($model, 'fim', array('class' => 'control-label')); ?>
	
	<?php
	if (Yii::app()->helper->isAdmin()) { 
		echo $form->radioButtonList($model,'status',array(
					Reserva::STATUS_NEW=>Reserva::status_str(Reserva::STATUS_NEW),
					Reserva::STATUS_APPROVED=>Reserva::status_str(Reserva::STATUS_APPROVED),
					Reserva::STATUS_REPROVED=>Reserva::status_str(Reserva::STATUS_REPROVED),
					Reserva::STATUS_CANCELLED=>Reserva::status_str(Reserva::STATUS_CANCELLED)
		));
	} else if (!$model->isNewRecord && Yii::app()->user->id == $model->solicitante_id) {
		echo $form->radioButtonList($model,'status',array(
					Reserva::STATUS_NEW=>Reserva::status_str(Reserva::STATUS_NEW),
					Reserva::STATUS_CANCELLED=>Reserva::status_str(Reserva::STATUS_CANCELLED)
		));
	} 
	?>

	<?php 
	if (Yii::app()->helper->isAdmin()) { 
		echo $form->selectorRow($model, 'solicitante_id', 
			$model->solicitante_id, (Yii::app()->helper->set($model->solicitante_id)? $model->solicitante->toString():''),
			Usuario::model(), null
		); 
	 } ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Criar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
