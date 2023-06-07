<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'sala-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<?php echo $form->textFieldRow($model,'descricao',array('class'=>'span5','maxlength'=>200)); ?>
	
	<fieldset>
    <legend>Responsável pelas Reservas:</legend>
	  <div class="col-lg-6">
	    <div class="input-group">
	      <span class="input-group-addon">
	        <input type="radio" name="associacao" checked="checked" onchange="toogleType('responsavel_instituicao_id')" />
	      </span>
		    <?php /*echo $form->dropDownList($model, 'responsavel_instituicao_id', CHtml::listData(
			Instituicao::model()->findAll(), 'id', 'nome'),
			array('prompt' => 'Selecione uma instituição ...','class'=>'span5 form-control')
			);*/ ?>
			<?php echo $form->selectorRow($model, 'responsavel_instituicao_id', 
			$model->responsavel_instituicao_id, (Yii::app()->helper->set($model->res_instituicao)? $model->res_instituicao->toString():''),
			Instituicao::model(), 
			array('placeholder' => 'Selecione uma instituição ...','class'=>'span5 form-control'), false
			); ?>
	    </div><!-- /input-group -->
	  </div><!-- /.col-lg-6 -->
	  <div class="col-lg-6">
	    <div class="input-group">
	      <span class="input-group-addon">
	        <input type="radio" name="associacao" onchange="toogleType('responsavel_curso_id')" />
	      </span>
		<?php echo $form->selectorRow($model, 'responsavel_curso_id', 
			$model->responsavel_curso_id, (Yii::app()->helper->set($model->res_curso)? $model->res_curso->toString():''),
			Curso::model(), 
			array('placeholder' => 'Selecione um curso ...','class'=>'span5 form-control'), false
			); ?>
	    </div><!-- /input-group -->
	  </div><!-- /.col-lg-6 -->
	  <div class="col-lg-6">
	    <div class="input-group">
	      <span class="input-group-addon">
	        <input type="radio" name="associacao" onchange="toogleType('responsavel_usuario_id')" />
	      </span>
		<?php echo $form->selectorRow($model, 'responsavel_usuario_id', 
			$model->responsavel_usuario_id, (Yii::app()->helper->set($model->res_usuario)? $model->res_usuario->toString():''),
			Usuario::model(), 
			array('placeholder' => 'Selecione um usuário ...','class'=>'span5 form-control'), false
			); ?>
	    </div><!-- /input-group -->
	  </div><!-- /.col-lg-6 -->
	<?php echo $form->error($model,'responsavel_instituicao_id'); ?>
	<?php echo $form->error($model,'responsavel_curso_id'); ?>
	<?php echo $form->error($model,'responsavel_usuario_id'); ?>
    </fieldset>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Criar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script language="javascript">
	var prefix = '#Sala_';
	var ids = [
		'responsavel_instituicao_id',
		'responsavel_curso_id',
		'responsavel_usuario_id'
	];
	
	function setAttr(id,attr,value) {
		$(prefix+id).attr(attr, value);
	}

	function toogleType (id) {
		for (var i = 0; i < ids.length; i++) {
			setAttr(ids[i],'value','');
			setAttr(ids[i],'disabled',true);
		}
		
		setAttr(id,'disabled',false);
	}
	
	toogleType (ids[0]);
</script>
