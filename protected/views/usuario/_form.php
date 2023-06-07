<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'usuario-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'nome',array('class'=>'span5','maxlength'=>20)); ?>
	
	<?php echo $form->passwordFieldRow($model,'senha',array('class'=>'span5','maxlength'=>20)); ?>
	
	<?php echo $form->passwordFieldRow($model,'repeat_senha',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->labelEx($model,'papel'); ?>
	<?php echo $form->radioButtonList($model,'papel',array(UserIdentity::ROLE_ADMIN=>'Administrador', 
														  UserIdentity::ROLE_PROFE=>'Professor',
														  UserIdentity::ROLE_INSTI=>'Instituição de Ensino',
														  UserIdentity::ROLE_COPE=>'COPE', 
														  UserIdentity::ROLE_ALUNO=>'Aluno')); ?>
	<?php echo $form->error($model,'papel'); ?>
	
	<fieldset>
    <legend>Associar usuário à:</legend>
	  <div class="col-lg-6">
	    <div class="input-group">
	      <span class="input-group-addon">
	        <input type="radio" name="associacao" checked="checked" onchange="toogleType('professor_id')" />
	      </span>
		    <?php echo $form->dropDownList($model, 'professor_id', CHtml::listData(
			Professor::model()->findAll(), 'id', 'nome'),
			array('prompt' => 'Selecione o professor','class'=>'span5 form-control')
			); ?>
	    </div><!-- /input-group -->
	  </div><!-- /.col-lg-6 -->
	  <div class="col-lg-6">
	    <div class="input-group">
	      <span class="input-group-addon">
	        <input type="radio" name="associacao" onchange="toogleType('aluno_id')" />
	      </span>
	      <?php echo $form->dropDownList($model, 'aluno_id', CHtml::listData(
		Aluno::model()->findAll(), 'id', 'nome'),
		array('prompt' => 'Selecione o aluno','class'=>'span5 form-control')
		); ?>
	    </div><!-- /input-group -->
	  </div><!-- /.col-lg-6 -->
	  <div class="col-lg-6">
	    <div class="input-group">
	      <span class="input-group-addon">
	        <input type="radio" name="associacao" onchange="toogleType('instituicao_id')" />
	      </span>
	      <?php echo $form->dropDownList($model, 'instituicao_id', CHtml::listData(
		Instituicao::model()->findAll(), 'id', 'nome'),
		array('prompt' => 'Selecione a instituição','class'=>'span5 form-control')
		); ?>
	    </div><!-- /input-group -->
	  </div><!-- /.col-lg-6 -->
	<?php echo $form->error($model,'professor_id'); ?>
	<?php echo $form->error($model,'aluno_id'); ?>
	<?php echo $form->error($model,'instituicao_id'); ?>
    </fieldset>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Adicionar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

	<script language="javascript">
		var prefix = '#Usuario_';
		var ids = [
			'professor_id',
			'aluno_id',
			'instituicao_id'
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
