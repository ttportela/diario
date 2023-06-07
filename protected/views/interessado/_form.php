<?php /*$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'interessado-form',
	'enableAjaxValidation'=>false,
)); */ ?>

	<?php // echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'id',array('class'=>'span5','maxlength'=>20)); ?>
	
	<fieldset>
    <legend><?php echo $counter+1; ?>º Colaborador:</legend>
	  <div class="col-lg-6">
	    <div class="input-group">
	      <span class="input-group-addon">
	        <input type="radio" name="associacao" checked="checked" />
	      </span>
		    <?php echo $form->dropDownList($model, '['.$counter.']professor_id', CHtml::listData(
			Professor::model()->findAll(), 'id', 'nome'),
			array('prompt' => 'Selecione o professor','class'=>'span5 form-control')
			); ?>
	    </div><!-- /input-group -->
	  </div><!-- /.col-lg-6 -->
	  <div class="col-lg-6">
	    <div class="input-group">
	      <span class="input-group-addon">
	        <input type="radio" name="associacao" />
	      </span>
	      <?php echo $form->dropDownList($model, '['.$counter.']aluno_id', CHtml::listData(
		Aluno::model()->findAll(), 'id', 'nome'),
		array('prompt' => 'Selecione o aluno','class'=>'span5 form-control')
		); ?>
	    </div><!-- /input-group -->
	  </div><!-- /.col-lg-6 -->
	<?php echo $form->error($model,'['.$counter.']professor_id'); ?>
	<?php echo $form->error($model,'['.$counter.']aluno_id'); ?>
    </fieldset>

	<?php echo $form->textFieldRow($model,'ch',array('class'=>'span5')); ?>
	
	<?php 
	if (!isset($model->naies)) $model->naies = 1;
	echo $form->checkBoxRow($model, 'naies'); ?>

	<?php 
	if ($counter) $model->funcao = Interessado::FUNC_COL_DOC;
	if (!isset($model->funcao)) $model->funcao = Interessado::FUNC_COORD;
	echo $form->radioButtonListRow($model,'funcao',
		array(
			Interessado::FUNC_COORD=>'Coordenador',
			Interessado::FUNC_VICE=>'Vice - Coordenador',
			Interessado::FUNC_COL_DOC=>'Colaborador Docente',
			Interessado::FUNC_COL_DIS=>'Colaboradore Discente',
		)); ?>

	<?php echo $form->textFieldRow($model,'formacao',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'telefone',array('class'=>'span5','maxlength'=>45)); ?>

<?php /* $this->endWidget(); */ ?>
