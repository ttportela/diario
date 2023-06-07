<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'projeto-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="page-header">
	  <h3>Identificação da Proposta  <small>Dados Básicos</small></h3>
	</div>

	<?php  
		echo (!($model->isNewRecord)? $form->radioButtonListRow($model,'status',array(
														Projeto::STATUS_NOVO=>'Novo',
														Projeto::STATUS_REC=>'Recebido',
														Projeto::STATUS_AP=>'Aprovado',
														Projeto::STATUS_APP=>'Aprovado com Pendências',
														Projeto::STATUS_RP=>'Reprovado',
														Projeto::STATUS_EX=>'Excluído',
														Projeto::STATUS_FN=>'Finalizado',
										)) : '');
	?>
	

	<?php echo $form->textFieldRow($model, 'nroprocesso', array('maxlength'=>200)); ?>

	<?php echo $form->dateRow($model, 'inicio'); ?>

	<?php echo $form->dateRow($model, 'fim'); ?>
	
	<br/>
	<div class="page-header">
	  <h3>Integrantes da Proposta</h3>
	</div>
	
	<?php echo $form->selectorRow($model,'coordenador', 
			(Yii::app()->helper->set($model->coordenador)? $model->coordenador->id : null), 
			(Yii::app()->helper->set($model->coordenador)? $model->coordenador->toString():''),
			(Professor::model()), null); ?>
			
	<?php echo $form->selectorRow($model,'vice', 
			(Yii::app()->helper->set($model->vice)? $model->vice->id : null), 
			(Yii::app()->helper->set($model->vice)? $model->vice->toString():''),
			(Professor::model()), null); ?>
	
	<?php echo $form->selectorMultipleRow($model,'docentes', 
			$model->docentes, (Professor::model()), null); ?>
			
	<?php echo $form->selectorMultipleRow($model,'discentes', 
			$model->discentes, (Aluno::model()), null); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Próximo Passo',
		)); ?>
	</div>

<?php $this->endWidget(); ?>


---------


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'projeto-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="page-header">
	  <h3>Integrantes da Proposta <small>Detalhamento</small></h3>
	</div>

	<?php echo $this->renderPartial('../interessado/_form', array(
				'modelo'=>$model->coordenador,
				'hideNext'=>true));?>
				
	<?php echo $this->renderPartial('../interessado/_form', array(
				'modelo'=>$model->vice,
				'hideNext'=>true));?>
			
	<?php if (isset($model->docentes) && !empty($model->docentes)) {
		
		foreach ($model->docentes as $it) {
			echo $this->renderPartial('../interessado/_form', array(
				'modelo'=>$it,
				'hideNext'=>true));
		} 
				
	} ?>
	
	<?php if (isset($model->discentes) && !empty($model->discentes)) {
		
		foreach ($model->discentes as $it) {
			echo $this->renderPartial('../interessado/_form', array(
				'modelo'=>$it,
				'hideNext'=>true));
		} 
				
	} ?>
	
	<br/>
	<div class="page-header">
	  <h3>Detalhamento da Proposta</h3>
	</div>
	
	<?php 
	if (isset($model->documento_id)) {
		echo $this->renderPartial('../documento/_generate', array(
				'modelo'=>DocumentoModelo::model()->projeto()->first(),
				'hideNext'=>true));
	} else {
		?><p class="help-block">Atenção: se os interessados no projeto foram alterados, será necessário modificar o texto do projeto também.</p><?php		
		echo $this->renderPartial('../documento/_form', array(
				'modelo'=>$model->documento,
				'hideNext'=>true));
	}			
	?>
			
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
