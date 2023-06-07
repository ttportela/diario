<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'diario-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php
		$alunos = array();
		if (isset($model->turma)) {
			$alunos = Turma::model()->findByPk($model->turma->id)->alunos;
		}
		
		if (!isset($model->id)) {
			$model->aulas = 2;
		}
	?>
	<?php echo $form->errorSummary($model); ?>

	<?php if ($model->isNewRecord) { ?>
	<?php echo $form->selectorRow($model,'turma_id', 
			$model->turma_id, (Yii::app()->helper->set($model->turma)? $model->turma->toString():''),
			(Turma::model()), null); ?>
	<?php } else { ?>
		<?php echo $form->hiddenField($model,'turma_id',array('class'=>'span5','maxlength'=>10)); ?>
		<?php echo CHtml::textField('turma_nome',$model->turma->nome,array('disabled'=>'true','class'=>'span5','maxlength'=>10)); ?>
	<?php } ?>


	<?php echo $form->dateRow($model, 'data', array('class' => 'control-label')); ?>
	<!-- <div class="control-group ">
		<?php echo $form -> labelEx($model, 'data', array('class' => 'control-label')); ?>
		<div class="controls">
		<?php
		// $this -> widget('zii.widgets.jui.CJuiDatePicker', array('name' => 'Asset[acquisition]', 'flat' => true, //remove to hide the datepicker
			// 'options' => array('showAnim' => 'slide', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
			// ), 'htmlOptions' => array('style' => ''), ));
			$this->widget('zii.widgets.jui.CJuiDatePicker',array(
			    // 'name'=>'acquisition_date',//CHtml::activeName($model, 'acquisition'),
			    'model'=>$model,
			    // 'flat'=>true,//remove to hide the datepicker
			    'attribute'=>'data',
			    'options'=>array(
			    	'dateFormat' => 'yy-mm-dd',
			        'showAnim'=>'fold',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
			        // 'altField'=>'#acquisition_date', // The jQuery selector of the "target" field
	        		// 'altFormat'=>'yy-mm-dd', // If you want the target field to have a different format
			    ),
			    'htmlOptions'=>array(
			        'style'=>'',
			        'value'=>(isset($model->data)? $model->data : date('Y-m-d')),
			        // 'name'=>CHtml::activeName($model, 'acquisition'),
			    ),
			));
		?>
		<?php //echo $form->hiddenField($model, 'acquisition', array('id'=>'#acquisition_date', 'value'=>date('Y-m-d'))); ?>
		</div>
		<?php echo $form -> error($model, 'data'); ?>
	</div> -->

	<?php echo $form->textFieldRow($model,'aulas',array('class'=>'span5 max-faltas', 'onchange'=>'maxFaltasChanged();', 'value'=>$model->aulas)); ?>

	<?php echo $form->textAreaRow($model, 'conteudo', array('class'=>'span8', 'rows'=>5,'maxlength'=>100)); ?>
	
	<fieldset>
        <legend>Frequência</legend>
        <table class="table table-bordered table-striped table-hover table-condensed">
        	<thead>
        	<tr>
        		<th>Aluno</th>
        		<th style="width: 40px; text-align: center;"><a id='toogle-faltas' onclick="maxFaltasAll()" class="icon-align-justify" title="Marcar todos com o máximo de faltas"></a></th>
        	</tr>
        	</thead>
        	<tbody>
        	<?php
        	if (!empty($alunos)) {
				//$alunos = Turma::model()->findByPk($model->turma->id)->alunos;
				$i=1;
				$itens = array();
		        foreach ($alunos as $a) {
		        	$freq = $model->getFrequencia($a); 
					$itens[] = $freq;
		        	?>
		        	<tr>
						<td>
							<?php echo $freq->aluno->nome; ?>
						</td>
						<td style="text-align: center;">
							<?php
							if(isset($freq->id)) echo $form->hiddenField($freq,'['.$i.']id');
							echo $form->hiddenField($freq,'['.$i.']aluno_id', array('value' =>$freq->aluno->id)); 
							echo CHtml::button($freq->faltas, array('class'=>'btn btn-sm' . 
							(($freq->faltas == 0)? ' btn-success' : ' btn-warning'), 
							'style'=>'line-height:10px','onclick'=>'toogleFaltas('.$i.')',
							'id'=>'btn-faltas-'.$i));
							echo $form->hiddenField($freq,'['.$i.']faltas');
							?>
						</td>
		        	</tr>
		        	<?php
		        	$i++;
		        }
				$model->frequencias = $itens;
			}
		?>
		</tbody>
        </table>
    </fieldset>
	
	<script language="javascript">	
		var max_faltas = <?php echo $model->aulas; ?>;
		var ctAlunos = <?php echo count($alunos); ?>;
		
		function maxFaltasChanged() {
			
			var n = $('.max-faltas').val();
			
			if (!parseInt(n)) {
				max_faltas = 2;
				$('.max-faltas').attr('value', 2);
			} else {
				max_faltas = parseInt(n);
			}
			
			for (var i=1; i <= ctAlunos; i++) {
			  var aux = $('#Frequencia_' + i + '_faltas').val();
			  if (aux > max_faltas) {
			  	setFaltas(i, max_faltas);
			  }
			};
		}
	
		function toogleFaltas (i) {
			var n = $('#Frequencia_' + i + '_faltas').val();
			// var btn = $('#btn-faltas-' + i);
			
			n = n - 1;
			
			if (n < 0) {
				n = max_faltas;
			}
			
			setFaltas(i, n);
			
			// if (n == 0) {
				// btn.attr('class', 'btn btn-xs btn-success');
			// } else {
				// btn.attr('class', 'btn btn-xs btn-warning');
			// }
// 			
			// btn.attr('value', n);
			// $('#Frequencia_' + i + '_faltas').attr('value', n);
		}
		
		function setFaltas(i, faltas) {
			// var n = $('#Frequencia_' + i + '_faltas').val();
			var btn = $('#btn-faltas-' + i);
			
			var n = faltas;
			
			if (n == 0) {
				btn.attr('class', 'btn btn-sm btn-success');
			} else {
				btn.attr('class', 'btn btn-sm btn-warning');
			}
			
			btn.attr('value', n);
			$('#Frequencia_' + i + '_faltas').attr('value', n);
			
		}
		
		function maxFaltasAll() {
			if ($('#toogle-faltas').hasClass('icon-align-justify')) {
				setAllFaltas(max_faltas);
				$('#toogle-faltas').removeClass('icon-align-justify');
				$('#toogle-faltas').addClass('icon-list');
				$('#toogle-faltas').prop('title', 'Marcar todos com zero faltas.');
			} else {
				setAllFaltas(0);
				$('#toogle-faltas').removeClass('icon-list');
				$('#toogle-faltas').addClass('icon-align-justify');
				$('#toogle-faltas').prop('title', 'Marcar todos com o máximo de faltas.');
			}
		}
		
		function setAllFaltas(n) {
			for (var i=1; i <= ctAlunos; i++) {
				setFaltas(i, n);
			};
		}
		
		function updateTurma(turma_id) {
			var url = '<?php echo $this->createAbsoluteUrl('diario/'. $model->isNewRecord? 'create' : 'update'); ?>&turma_id=' + turma_id;
			$(location).attr('href',url);
		}
	</script>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Adicionar' : 'Salvar',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
