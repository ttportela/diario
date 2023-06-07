<?php
$this->breadcrumbs=array(
	'Alunos'=>array('index'),
	$model->id,
);

// $this->menu=array(
	// // array('label'=>'List Aluno','url'=>array('index')),
	// array('label'=>'Adicionar','url'=>array('create')),
	// array('label'=>'Alterar','url'=>array('update','id'=>$model->id)),
	// array('label'=>'Deletar','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	// array('label'=>'Listar','url'=>array('admin')),
// );
?>

<h1><?php echo $model->nome; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		// 'nome',
		'ra',
		'email',
		array(
			'name' => 'instituicao_id',
			'value' => $model->instituicao->nome, 
		),
	),
)); ?>


<h3>Turmas:</h3>

<?php 
// $dataProvider =  new CActiveDataProvider(Turma::model()->tableName());
// $dataProvider->setData($model->turmas);
// 
// $this->widget('bootstrap.widgets.TbGridView',array(
	// 'id'=>'turma-grid',
	// 'dataProvider'=>$dataProvider,
	// 'columns'=>array(
		// 'id',
		// 'nome',
		// 'ano',
		// 'semestre',
		// array(
			// 'name' => 'professor_id',
			// 'value' => '$data->professor->nome', 
		// ),
		// array(
			// 'name' => 'disciplina_id',
			// 'value' => '$data->disciplina->nome', 
		// ),
	// ),
// )); 


$turmas = $model->turmas;
		
?>
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
			$faltas = $model->totalFaltas($t);
			
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
			
			$notaB1 = $model->mediaBimestral($t, 1, true);
			$notaB2 = $model->mediaBimestral($t, 2, true);
			
			// Resultado do aluno:
			$mediaFinal = $model->mediaFinal($t, null, $notaB1, $notaB2, null);
		    $resultado = $model->resultado($t, null, $notaB1, $notaB2, null, $faltas);	
	
			foreach ($avaliacoes as $av) {
				if ($av->bimestre == Avaliacao::$EXAME) continue;
				
				$grade = $av->nota($model);
				
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
	          	if (isset($avExame) && ($nota = $avExame->nota($model)) != null)  { ?>
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

<?php if (Yii::app()->helper->isAdmin()) {
$criteria = new CDbCriteria();
$criteria->condition = 'ra = '.$model->ra.' AND 
						ra IN (select ra
							from '.Aluno::model()->tableName().' t2'.'
							group  by ra
							having count(*) > 1)';
$criteria->order = 'LOWER(nome),id ASC';

$dataProvider=new CActiveDataProvider(Aluno::model()->tableName(), array(
    'criteria'=>$criteria,
    'pagination'=>array(
        'pageSize'=>20,
    ),
));

if ($dataProvider->getTotalItemCount() > 1) {
	
?>

<h4>Duplicatas:</h4>
<?php 
$criteria = new CDbCriteria();
$criteria->condition = 'ra = '.$model->ra.' AND 
						ra IN (select ra
							from '.Aluno::model()->tableName().' t2'.'
							group  by ra
							having count(*) > 1)';
$criteria->order = 'LOWER(nome),id ASC';

$dataProvider=new CActiveDataProvider(Aluno::model()->tableName(), array(
    'criteria'=>$criteria,
    'pagination'=>array(
        'pageSize'=>20,
    ),
));

$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'turma-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'id',
		'nome',
		'ra',
		'email',
		array(
			'name' => 'instituicao_id',
			'value' => '$data->instituicao->nome', 
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{merge}',
			// 'htmlOptions' => array('width' => '60px'),
			'buttons'=>array(
	        	'merge'=>array(
	        		'visible'=>'$data->id != '.$model->id,
	                'label'=>'Mesclar',
	                'icon' => 'fa fa-code-fork',
	                'url'=>'Yii::app()->createUrl("aluno/merge", array("from"=>$data->id,"to"=>'.$model->id.'))',
	            ),
	        ),
		),
	),
));

} 
}
?>
