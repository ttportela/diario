<?php
$this->breadcrumbs=array(
	'Notas e Faltas',
); ?>

<!-- <style type="text/css">
	.panel-group {
	  margin-bottom: 20px !important;
	}
	.panel-group .panel {
	  margin-bottom: 0 !important;
	  border-radius: 4px !important;
	}
	.panel-default {
	  border-color: #ddd !important;
	}
	.panel {
	  margin-bottom: 20px !important;
	  background-color: #fff !important;
	  border: 1px solid transparent !important;
	  border-radius: 4px !important;
	  -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05) !important;
	  box-shadow: 0 1px 1px rgba(0,0,0,.05) !important;
	}
	.panel-default>.panel-heading {
	  color: #333 !important;
	  background-color: #f5f5f5 !important;
	  border-color: #ddd !important;
	}
	.panel-group .panel-heading {
	  border-bottom: 0 !important;
	}
	.panel-heading {
	  padding: 10px 15px !important;
	  border-bottom: 1px solid transparent !important;
	  border-top-left-radius: 3px !important;
	  border-top-right-radius: 3px !important;
	}
	.panel-title {
	  margin-top: 0 !important;
	  margin-bottom: 0 !important;
	  font-size: 16px !important;
	  color: inherit !important;
	}
	.panel-title>.small, .panel-title>.small>a, .panel-title>a, .panel-title>small, .panel-title>small>a {
	  color: inherit !important;
	}
	.anchorjs-link {
	  float: left !important;
	  width: 1em !important;
	  height: 1em !important;
	  margin-left: -1.2em !important;
	  opacity: 0 !important;
	  color: inherit !important;
	  text-align: center !important;
	}
	.anchorjs-icon {
	  font-size: 60% !important;
	  vertical-align: .2em !important;
	}
	.anchorjs-icon {
	  font-family: anchorjs-link !important;
	  speak: none !important;
	  font-style: normal !important;
	  font-weight: 400 !important;
	  font-variant: normal !important;
	  text-transform: none !important;
	  line-height: 1 !important;
	  -webkit-font-smoothing: antialiased !important;
	  -moz-osx-font-smoothing: grayscale !important;
	}
	.collapse {
	  display: none !important;
	}
	.collapse.in {
	  display: block !important;
	}
	.collapsing {
	  position: relative;
	  height: 0;
	  overflow: hidden;
	  -webkit-transition-timing-function: ease;
	  -o-transition-timing-function: ease;
	  transition-timing-function: ease;
	  -webkit-transition-duration: .35s;
	  -o-transition-duration: .35s;
	  transition-duration: .35s;
	  -webkit-transition-property: height,visibility;
	  -o-transition-property: height,visibility;
	  transition-property: height,visibility;
	}
	.panel-default>.panel-heading+.panel-collapse>.panel-body {
	  border-top-color: #ddd !important;
	}
	.panel-group .panel-heading+.panel-collapse>.list-group, .panel-group .panel-heading+.panel-collapse>.panel-body {
	  border-top: 1px solid #ddd !important;
	}
	.panel-body {
	  padding: 15px !important;
	}
	.anchorjs-icon:before {
	  content: "\e600" !important;
	}
</style> -->


<h1>Notas e Faltas</h1>

<?php 
$ra = isset($_GET['ra'])? $_GET['ra'] : null;
$instituicao_id = isset($_GET['instituicao_id'])? $_GET['instituicao_id'] : null;

if (!(isset($ra) && !empty($instituicao_id) && $ra != '' && $instituicao_id != '')) {
	
?>
<?php //echo CHtml::form('','post',array('enctype'=>'multipart/form-data')); ?>

<div class="well">
	<div>
		<?php echo CHtml::label('Instituição', ''); ?>
		<?php echo CHtml::dropDownList('instituicao_id', ($instituicao_id != null)? $instituicao_id : '', CHtml::listData(
		Instituicao::model()->findAll(), 'id', 'nome')
		//array('prompt' => 'Selecione a instituição','class'=>'span5')
		); ?>
	</div>
	
	<?php echo CHtml::label('Registro Acadêmico',''); ?>
	<?php echo CHtml::textField('ra', ($ra != null)? $ra : '', array('class'=>'span5')); ?>
</div>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Enviar',
		// 'onclick'=>"reditrect();",
		'htmlOptions' => array('onclick'=>"redirect();"),
	)); ?>
</div>

<?php //echo CHtml::submitButton('Enviar'); ?>
<?php //echo CHtml::endForm(); ?>

<?php 
} else {

	?>
	<table class="table table-striped">
	<?php
	
	$aluno = Aluno::model()->findByAttributes(
	    array('ra'=>$ra,'instituicao_id'=>$instituicao_id)
	);

	// Temos ALUNO ------------------------------------>
	if (isset($aluno->id)) {
		
		// $criteria=new CDbCriteria;
// 		
		// $criteria->with = array('alunos');
	    // $criteria->together = true;
// 	
		// $criteria->compare('alunos.id',$aluno->id,true);
		// $criteria->compare('instituicao_id',$instituicao_id,true);
// 		
		// $criteria->order = 'ano DESC, semestre DESC';
// 	
		// $turmas = Turma::model()->findAll($criteria);
		
		$turmas = $aluno->turmas;
		
		// $turmas = Turma::model()->with('alunos')->findAll(
		    // 'alunos.id = :aid', array(':aid' => $aluno->id),'instituicao_id = :iid', array(':iid' => $instituicao_id)
		// );
		
		?>
		
		<h3><?php echo $aluno->nome; ?></h3>
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$aluno,
			'attributes'=>array(
				// 'id',
				// 'nome',
				'ra',
				// 'email',
				array(
					'name' => 'email',
					'type'=>'raw',
					'value' => (isset($aluno->email)? $aluno->email : '') . ' ' .  
						CHtml::link(' ',array('aluno/updemail','id'=>$aluno->id), array('class'=>'icon-pencil')), 
				),
			),
		)); ?>
		

<div id="accordion" role="tablist" aria-multiselectable="true">
<?php
  			
		// Temos TURMAS ------------------------------------>>
		if (isset($turmas) && !empty($turmas))
		foreach ($turmas as $t) {
			$avaliacoes = Avaliacao::model()->findAll(
			    'turma_id = :tid', array(':tid' => $t->id)
			);
			
?>

  <div class="panel panel-default" style="margin-bottom: 5px;">
    <div class="panel-heading" role="tab" id="heading<?php echo $t->id;?>">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $t->id;?>" aria-expanded="false" aria-controls="collapse<?php echo $t->id;?>">
        	<?php echo $t->disciplina->nome . ' ('.$t->semestre.'/'.$t->ano.')'; ?></h5>
        </a>
      </h4>
    </div>
    <div id="collapse<?php echo $t->id;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $t->id;?>">
<?php 
			$faltas = $aluno->totalFaltas($t);
			
			$this->widget('bootstrap.widgets.TbDetailView',array(
				'data'=>$t,
				'attributes'=>array(
					// 'id',
					// 'nome',
					'ano',
					'semestre',
					array(
						'label' => 'Curso',
						'value' => $t->disciplina->curso->nome, 
					),
					array(
						'name' => 'professor_id',
						'value' => $t->professor->nome, 
					),
					'horarios',
					// 'classe',
					// 'chrelogio',
					'chaula',
					// 'observacoes',
					array(
						'label' => 'Limite de Faltas',
						'value' => $t->limiteFaltas(), 
					),
					array(
						'label' => 'Faltas do Aluno',
						'value' => $faltas, 
					),
					array(
						'visible' => $t->publicarpe,
						'label' => 'Plano de Ensino',
						'type'=>'raw',
						'value' => CHtml::link('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Visualizar',array('/report/planoensino','turma_id'=>$t->id), array('class'=>'icon-print tooltipster', 'target'=>'_blank', 'title'=>'Imprimir Plano de Ensino')), 
					),
				),
			)); ?>
			<table class="table table-striped table-bordered">
				<thead>
					<th><?php echo Turma::model()->getAttributeLabel('avaliacoes'); ?></th>
					<th><?php echo AvaliacaoAluno::model()->getAttributeLabel('nota'); ?></th>
					<th><?php echo AvaliacaoAluno::model()->getAttributeLabel('observacoes'); ?></th>
				</thead>
			<?php
			// Temos AVALIAÇÕES ------------------------------------>>>
			?>
			<tbody class="table-hover">
			<?php
			if (isset($avaliacoes) && !empty($avaliacoes)){
				
			$avExame = $t->exame;
			
			$notaB1 = $aluno->mediaBimestral($t, 1, true);
			$notaB2 = $aluno->mediaBimestral($t, 2, true);
			
			// Resultado do aluno:
			$mediaFinal = $aluno->mediaFinal($t, null, $notaB1, $notaB2, null);
		    $resultado = $aluno->resultado($t, null, $notaB1, $notaB2, null, $faltas);	
	
			foreach ($avaliacoes as $av) {
				if ($av->bimestre == Avaliacao::$EXAME) continue;
				
				$grade = $av->nota($aluno);
				
				?>
				<tr>
		          <td><?php echo $av->nome . ' ['. $av->bimestre .'ºB]';?></td>
		          <td class="nota-td"><?php echo isset($grade)? number_format($grade->nota, 2, ',', '') : '-';?></td>
		          <td><?php echo isset($grade)? $grade->observacoes : '-';?></td>
		       </tr>
				<?php
			}
				?>
			<tr>
	          <td>Nota de EXAME</td>
	          <?php	$nota = null;
	          	if (isset($avExame) && ($nota = $avExame->nota($aluno)) != null)  { ?>
	           	<td class="nota-td"><?php echo number_format($nota->nota, 2, ',', '');?></td>
	          	<td><?php echo $nota->observacoes;?></td>
	          <?php } else { ?>
	          	<td class="nota-td">-</td>
	         	<td>-</td>
	          <?php }?>
	       </tr>
		   </tbody>
		</table>
		
		<!-- Resultados ---------------------------------------------------------------------------->
			<table class="table table-striped table-bordered">
				<thead>
					<th>Médias</th>
					<th><?php echo AvaliacaoAluno::model()->getAttributeLabel('nota'); ?></th>
				</thead>
			<tbody class="table-hover">
				<tr>
		          <td>1º Bimestre</td>
		          <td class="nota-td"><?php echo str_replace('.',',', Yii::app()->getNumberFormatter()->format("#.##",$notaB1));?></td>
		       </tr>
		       
				<tr>
		          <td>2º Bimestre</td>
		          <td class="nota-td"><?php echo str_replace('.',',', Yii::app()->getNumberFormatter()->format("#.##",$notaB2));;?></td>
		       </tr>
		       
				<tr>
		          <td>Média Final</td>
		          <td class="nota-td"><?php echo str_replace('.',',', Yii::app()->getNumberFormatter()->format("#.##", $mediaFinal));?></td>
		       </tr>
		       
				<tr>
		          <td>Situação</td>
		          <td><?php echo $resultado[0];?></td>
		       </tr>
		   </tbody>
		</table>
				<?php
			
			
			} else {
				?>
				<tr>
		          <td colspan="3">Não há avaliações no momento...</td>
		       </tr>
		   </tbody>
		</table>
				<?php
			}
?>
		</div>
    </div>
<?php
			
		}
		// Temos TURMAS ------------------------------------>>
		?>
</div><br/><br/>
<?php
		
	}
	// Temos ALUNO ------------------------------------>
}

?>

<script language="javascript">
	function redirect() {
		var ra = $('#ra').val();
		var iid = $('#instituicao_id').val();
		var url = '<?php echo $this->createAbsoluteUrl('aluno/grades'); ?>&ra=' + ra + '&instituicao_id=' + iid;
		$(location).attr('href',url);
	}
	
	// $( window ).load(function() {
		//$(".nota-td").mask("999.99");
		// $('.collapse').collapse();
		// $( "#accordion" ).accordion({ active: false, collapsible: true });
	// });
	
</script>