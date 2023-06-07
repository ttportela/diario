<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'projeto-form',
	'enableAjaxValidation'=>false,
	// we need the next one for transmission of files in the form.
    // 'htmlOptions' => array('enctype' => 'multipart/form-data'),
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
	
	<fieldset>
        <div id="items-multiple">
            <?php
            $i = 0;
            foreach ($items as $item) {
                /* @var Song $song */
                $this->renderPartial('/interessado/_form', array('model' => $item, 'counter' => $i,'form'=>$form));
                $i++;
            }
                // print the button here, which replicates the form but advances its counters
                // add the blank, extra 'song' form, with display=none... :
                echo '<div id="extra-item" style="display: none;">';
                $this->renderPartial('/interessado/_form', array('model' => new Interessado(), 'counter' => $i,'form'=>$form));
                echo "</div>";
            ?>
        </div>
		<button id='items-multiple-add' class="btn btn-info">Adicionar Colaborador</button>
        <?php /* echo CHtml::ajaxButton ("Adicionar Colaborador",
			         CController::createUrl('projeto/addinteressado'),
			         array(
			          'type' => 'get',
			          'data'=> 'js:"ct="+counter', 
			          'success' => 'js: function(result) {
			            if(result != "") {
			              $("#items-multiple").append( result ); //add to partial-data
			              //toogleType (counter,ids[0]);
			              counter += 1;
			            }
			          }',
			        ),
			        array(
			          'id' => 'items-multiple-add',
			          'class'=>'btn btn-info'
			        )); */ ?>
    </fieldset>
    
    <br/>
    <div id="page-projeto">
	<div class="page-header">
	  <h3>Detalhamento da Proposta</h3>
	</div>
	
	
	<?php 
	if (!isset($model->documento_id)) {
		echo $this->renderPartial('_generate', array(
				'modelo'=>DocumentoModelo::model()->projeto()->find(),
				'hideNext'=>true,
				'form'=>$form));
	} else {
		?><p class="help-block">Atenção: se os interessados no projeto foram alterados, será necessário modificar o texto do projeto também.</p><?php		
		echo $this->renderPartial('../documento/_form', array(
				'modelo'=>$model->documento,
				'hideNext'=>true,
				'form'=>$form));
	}			
	?>
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Criar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script language="javascript">	
	var counter = <?php echo $i; ?>;
	// var prefix = '#Interessado_';
	// var ids = [
		// 'professor_id',
		// 'aluno_id',
	// ];
// 	
	// $( document ).ready(function() {
	    // for (var i = 0; i < counter; i++) {
			// toogleType (i, ids[0]);
		// }
	// });
// 		
	// function setAttr(id,attr,value) {
		// $(prefix+id).attr(attr, value);
	// }
// 
	// function toogleType (ct, id) {
		// for (var i = 0; i < ids.length; i++) {
			// setAttr(ct+'_'+ids[i],'value','');
			// setAttr(ct+'_'+ids[i],'disabled',true);
		// }
// 		
		// setAttr(ct+'_'+id,'disabled',false);
	// }
	
	$(document).ready(function() {
		$('#items-multiple-add').click( function (e) {
			e.preventDefault();
	        $.ajax({
	            type: "GET",
	            url: "<?php echo CController::createUrl('projeto/addinteressado'); ?>",
	            data: "ct="+counter,
	            success: function(result) {
		            if(result != "") {
		              $("#items-multiple").append( result ); //add to partial-data
		              //toogleType (counter,ids[0]);
		              counter += 1;
		            }
		          }
	        });
	    });
	});
	
</script>
