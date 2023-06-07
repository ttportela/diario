<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'documento-modelo-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'nome', array('class'=>'span5','maxlength'=>100)); ?>
	
	<?php echo $form->dropDownListRow($model, 'cabecalho_id', CHtml::listData(
		DocumentoModelo::model()->findAllByAttributes(array('ativo'=>DocumentoModelo::$STATUS_TIMBRE)), 'id', 'nome'),
		array('prompt' => '- Nenhum Cabeçalho -','class'=>'span5')
		); ?>

	<?php echo $form->editorRow($model,'conteudo',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
	
	<?php echo $form->dropDownListRow($model, 'rodape_id', CHtml::listData(
		DocumentoModelo::model()->findAllByAttributes(array('ativo'=>DocumentoModelo::$STATUS_TIMBRE)), 'id', 'nome'),
		array('prompt' => '- Nenhum Rodapé -','class'=>'span5')
		); ?>

	<?php //echo $form->textFieldRow($model,'cabecalho_id',array('class'=>'span5','maxlength'=>20)); ?>

	<?php //echo $form->textFieldRow($model,'rodape_id',array('class'=>'span5','maxlength'=>20)); ?>

	<?php //echo $form->textFieldRow($model,'criado',array('class'=>'span5')); ?>

	<?php
	if (Yii::app()->user->papel == UserIdentity::ROLE_COPE) {
		echo (!($model->isNewRecord)? $form->radioButtonListRow($model,'ativo',array(
														DocumentoModelo::$STATUS_ATIVO=>'Ativo',
														DocumentoModelo::$STATUS_INATIVO=>'Inativo',
														DocumentoModelo::$STATUS_PROJETO=>'Modelo de Projeto - COPE',
														DocumentoModelo::$STATUS_RELATOR=>'Modelo de Reltório - COPE',
														DocumentoModelo::$STATUS_PARECER=>'Modelo de Parecer - COPE',)) : '');
	} else {
		echo (!($model->isNewRecord)? $form->radioButtonListRow($model,'ativo',array(
														DocumentoModelo::$STATUS_ATIVO=>'Ativo',
														DocumentoModelo::$STATUS_INATIVO=>'Inativo',)) : ''); 
	}													
	?>
	
	
	<?php $date = date("Y-m-d H:i:s", isset($model->criado)? strtotime($model->criado) : date("Y-m-d H:i:s"));
		if (!$model->isNewRecord) echo $form->uneditableRow($model,'criado',$date, array('class'=>'span5','maxlength'=>10)); ?>
	
	<?php 
	$user = Usuario::model()->findByPk(($model->isNewRecord? Yii::app()->user->id : $model->criador_id));
	echo $form->uneditableRow($model,'criador_id', $user->toString(), array('class'=>'span5','maxlength'=>10)); ?>
	

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
