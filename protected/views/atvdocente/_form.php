<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'atividade-docente-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textAreaRow($model,'nome',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textAreaRow($model,'descricao',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class='control-group'>
		<?php echo $form -> labelEx($model, 'inicio', array('class' => 'control-label')); ?>
		<div class='controls'>
		<?php
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				'model'=>$model,
				'attribute'=>'inicio',
				'options'=>array(
					'dateFormat' => 'yy-mm-dd',
					'showAnim'=>'fold',
				),
				'htmlOptions'=>array(
					'style'=>'',
					'value'=>(isset($model->inicio)? $model->inicio : date('Y-m-d')),
				),
			));
		?>
		</div>
		<?php echo $form -> error($model, 'inicio'); ?>
	</div>

	<div class='control-group'>
		<?php echo $form -> labelEx($model, 'fim', array('class' => 'control-label')); ?>
		<div class='controls'>
		<?php
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				'model'=>$model,
				'attribute'=>'fim',
				'options'=>array(
					'dateFormat' => 'yy-mm-dd',
					'showAnim'=>'fold',
				),
				'htmlOptions'=>array(
					'style'=>'',
					'value'=>(isset($model->fim)? $model->fim : date('Y-m-d')),
				),
			));
		?>
		</div>
		<?php echo $form -> error($model, 'fim'); ?>
	</div>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

	<div>
		<small><?php echo $form->labelEx($model,'tipo_id'); ?></small>
		<?php echo $form->dropDownList($model, 'tipo_id', CHtml::listData(
		Atividade_tipo::model()->findAll(), 'id', 'id'), // Maybe you have to chage de value column to another
		array('prompt' => '...','class'=>'span5')); ?>
		<?php echo $form->error($model,'tipo_id'); ?>
	</div>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Criar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
