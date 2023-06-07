<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'turma-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php //echo $form->textFieldRow($model,'nome',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'ano',array('class'=>'span5')); ?>
	
	<?php echo $form->labelEx($model,'semestre'); ?>
	<?php echo $form->radioButtonList($model,'semestre',array(1=>'1º Semestre',
														  2=>'2º Semestre')); ?>
	<?php echo $form->error($model,'semestre'); ?>

	<?php echo $form->textFieldRow($model,'classe',array('class'=>'span5','maxlength'=>20, 'value'=>'T01')); ?>

	<?php echo $form->textFieldRow($model,'chrelogio',array('class'=>'span5', 'value'=>'64')); ?>

	<?php echo $form->textFieldRow($model,'chaula',array('class'=>'span5', 'value'=>'80')); ?>

	<?php echo $form->textAreaRow($model,'horarios',array('class'=>'span5','maxlength'=>100)); ?>
	<?php //echo $this->renderPartial('_horarios', array('form'=>$form, 'model'=>$model)); ?>

	<?php echo $form->textAreaRow($model,'observacoes',array('class'=>'span5','maxlength'=>400)); ?>

	<?php echo $form->selectorRow($model,'professor_id', 
			$model->professor_id, (Yii::app()->helper->set($model->professor)? $model->professor->toString():''),
			(Professor::model()), null); ?>

	<?php echo $form->selectorRow($model,'disciplina_id', 
			$model->disciplina_id, (Yii::app()->helper->set($model->disciplina)? $model->disciplina->toString():''),
			(Disciplina::model()), null); ?>
			
	<?php echo $form->selectorMultipleRow($model,'aluno_ids', 
			$model->alunos, (Aluno::model()), null); ?>		

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Adicionar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
