<style type="text/css">
	
	.hover {
		background-color: #eee;
	}
	.hover-cell {
		background-color: #E8FF73;
	}
	/* --------------------> */
	.tb-aluno tr, .tb-aluno th, .tb-aluno td {
		border: 1px solid #dddddd;
	}
	
	form {
		margin: 0 !important;
	}
	
	table.tb-aluno {
	  overflow: hidden;
	}
	
	.tb-aluno td, .tb-aluno th {
	  padding: 0;
	  position: relative;
	  outline: 0;
	}
	
	body:not(.nohover) .tb-aluno tbody tr:hover {
	  background-color: #ffa;
	}
	
	.tb-aluno td:hover::after,
	.tb-aluno thead th:not(:empty):hover::after,
	.tb-aluno td:focus::after,
	.tb-aluno thead th:not(:empty):focus::after { 
	  content: '';  
	  height: 10000px;
	  left: 0;
	  position: absolute;  
	  top: -5000px;
	  width: 100%;
	  z-index: -1;
	}
	
	.tb-aluno td:hover::after,
	.tb-aluno th:hover::after {
	  background-color: #ffa;
	}
	
	.tb-aluno td:focus::after,
	.tb-aluno th:focus::after {
	  background-color: lightblue;
	}
	
	/* Focus stuff for mobile */
	.tb-aluno td:focus::before,
	.tb-aluno tbody th:focus::before {
	  background-color: lightblue;
	  content: '';  
	  height: 100%;
	  top: 0;
	  left: -5000px;
	  position: absolute;  
	  width: 10000px;
	  z-index: -1;
	}
	
	table.tb-aluno tr.aulas td a {
		font-size: 8pt;
	}
	
	li.sep {
		width: 63px;
		display: inline-flex;
	}
	
	div.sep {
	    padding-top: 8px;
	    padding-bottom: 8px;
	    margin-top: 2px;
	    margin-bottom: 2px;
	    -webkit-border-radius: 5px;
	    -moz-border-radius: 5px;
	    border-radius: 5px;
	    width: 20px;
    	text-align: center;
	}

</style>

<?php
/* @var $this ReportController */
$this->breadcrumbs=array(
	'Diário'=>array('/diario'),
	'Conferência de Diários',
);
?>
<h1>Conferência de Diários</h1>
<?php

$turma_id = isset($_GET['turma_id'])? $_GET['turma_id'] : null;

if (!(isset($turma_id))) {
		
	echo $this->renderPartial('/report/_select-turma');
		
} else {
	
	$turma = Turma::model()->findByPk($turma_id);
	
	$this->breadcrumbs=array(
		'Diário'=>array('/diario'),
		'Conferência de Diários'=>array('diario/bulkupdate'),
		$turma->toString(),
	);
	
	Yii::app()->user->returnUrl = array('diario/bulkupdate', 'turma_id'=>$turma->id);
	
	// $numDias = 30;
	// $numAlunos = 18;
	
	$criteria=new CDbCriteria(array(
		'condition'=>'turma.id='.$turma->id,
		'order'=>'data ASC',
		'with'=>'turma',
	));
	
	$diarios = Diario::model()->findAll($criteria);
	
	// ----------->
	
	$total_faltas = array();

	foreach ($diarios as $d) {
		foreach ($d->frequencias as $f) {
			$faltas = 0;
			if (isset($total_faltas[$f->aluno_id])) {
				$faltas = $total_faltas[$f->aluno_id];
			}
			$faltas += $f->faltas;
			$total_faltas[$f->aluno_id] = $faltas;
			// array_merge($total_faltas, array($f->aluno_id=>$faltas));
		}
	}
// 	
	// $pags_alunos = array();
	// // $pag_atual = array();
	// $ct = 0;
	// foreach ($turma->alunos as $a) {
		// array_push($pag_atual, $a);
		// $ct++;
// 		
		// if (count($pag_atual) == $numAlunos || $ct == count($turma->alunos)) {
			// array_push($pags_alunos, $pag_atual);
			// $pag_atual = array();	
		// }
	// }
// 	
	// $priAluno = 1;
	// foreach ($pags_alunos as $paga) {
		// $priAula = 1; 
		// foreach ($pags_diarios as $pagd) {
			// echo $this->renderPartial('_frequencia-folha', array('diarios'=>$pagd, 'alunos'=>$paga, 'turma'=>$turma,
				// 'numDias'=>$numDias, 'numAlunos'=>$numAlunos, 'priAula'=>$priAula, 'priAluno'=>$priAluno, 
				// 'totalFaltas'=>$total_faltas)); 
			// $priAula += $numDias;
		// }
		// $priAluno += $numAlunos;
	// }
	
// ------->

	$alunos = Turma::model()->findByPk($turma->id)->alunos;
	
?>

<!-- ************************************************************************** -->
<!-- <div class="tb-aluno-height"><?php foreach ($alunos as $aluno) {?><br/><?php } ?><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/></div>
<br/><br/> -->
<legend><?php echo $turma->disciplina->nome;?></legend>
<div style="">

<?php 
	
	$this->widget('bootstrap.widgets.TbDetailView',array(
		'data'=>$turma,
		'attributes'=>array(
			// 'id',
			// 'nome',
			'ano',
			'semestre',
			array(
				'name' => 'Curso',
				'value' => $turma->disciplina->curso->nome, 
			),
			array(
				'name' => 'professor_id',
				'value' => $turma->professor->nome, 
			),
			array(
				'name' => 'horarios',
				'value' => $turma->horarios, 
				'type'=>'ntext',
			),
			// 'classe',
			// 'chrelogio',
			'chaula',
			'observacoes',
			array(
				'name' => 'Limite de Faltas',
				'value' => $turma->limiteFaltas(), 
			),
		),
	));

	//**************************************************************************

	?><legend>Conteúdo</legend><?php
	
	$config = array();
	
	$dataProvider = new CArrayDataProvider($diarios, $config);
	$dataProvider->pagination->pageSize=$dataProvider->totalItemCount;

	$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'frequencias',
	'dataProvider'=>$dataProvider,
	// 'filter'=>$modelHistory,
	// 'template'=>"{items}",
	// 'enablePagination' => false,
	'columns'=>array(
		array(
            'name'=>'Data',
            'value'=>'Yii::app()->getDateFormatter()->format("dd/MM",strtotime($data->data))',
        ),
		array(
            'name'=>'Conteúdo',
            'value'=>'$data->conteudo',
        ),
        array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); 
 
?>
</div>
<!-- <br clear="left"> -->

<div class="well">
	Este formulário salva as faltas do aluno no momento em que o botão é clicado. Se o botão permanecer em cinza, significa que as faltas para aquele aluno não foram salvas (tente atualizar a página).
	<!-- <?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Salvar',
	)); ?> -->
	<div class="panel panel-default">
  		<div class="panel-body" style="text-align: center;">
	<?php 
	$menu=array(
		array('label'=>'','url'=>array('diario/create', 'turma_id'=>$turma->id), 'icon'=>'icon-plus', 'itemOptions'=>array('target'=>'_blank', 'title'=>'Adicionar Diário')),
		array('label'=>'','url'=>array('/report/result', 'nome'=>1,'RA'=>1,'faltas'=>1,'med_parc'=>1,'result'=>1,'em_exame'=>1,'turma_id'=>$turma->id), 'icon'=>'icon-check', 'itemOptions'=>array('target'=>'_blank', 'title'=>'Lista de Exame')),
		array('label'=>'','url'=>array('/diario/examata','turma_id'=>$turma->id), 'icon'=>'icon-list-alt', 'itemOptions'=>array('target'=>'_blank', 'title'=>'Imprimir Ata de Exame')),
		
		array('label'=>'','url'=>array('/report/todos','turma_id'=>$turma->id), 'icon'=>'icon-print', 'template'=>'<div class="sep">|</div>{menu}<div class="sep">|</div>', 'itemOptions'=>array('target'=>'_blank', 'title'=>'Imprimir Diários','class'=>'sep')),
		
		array('label'=>'','url'=>array('diario/bulkupdate', 'turma_id'=>$turma->id), 'icon'=>'icon-refresh', 'itemOptions'=>array('title'=>'Atualizar Página')), 
		array('label'=>'','url'=>array('turma/update', 'id'=>$turma->id), 'icon'=>'icon-edit', 'itemOptions'=>array('target'=>'_blank', 'title'=>'Editar Turma'))
	);
	$this->beginWidget('zii.widgets.CPortlet', array(
        //'title'=>'Ações',
        'title'=>'',
    ));
    $this->widget('bootstrap.widgets.TbMenu', array(
        'items'=>$menu,
        'stacked' => false,
        'htmlOptions'=>array('class'=>'operations nav nav-pills', 'style'=>'margin: 0;display: inline-block;text-align: left;'),
    ));
    $this->endWidget();
	
	// echo CHtml::link('',array('diario/create', 'turma_id'=>$turma->id), array('target'=>'_blank', 'class'=>'icon-plus', 'title'=>'Adicionar Diário')) . '&emsp;' .
			// CHtml::link('',array('/report/result', 'nome'=>1,'RA'=>1,'faltas'=>1,'med_parc'=>1,'result'=>1,'em_exame'=>1,'turma_id'=>$turma->id), array('class'=>'icon-check', 'target'=>'_blank', 'title'=>'Lista de Exame')) . '&emsp;' .
			// CHtml::link('',array('/diario/examata','turma_id'=>$turma->id), array('class'=>'icon-list-alt', 'target'=>'_blank', 'title'=>'Imprimir Ata de Exame')) . '&emsp;&emsp; - &emsp;&emsp;' . 
			// CHtml::link('',array('/report/todos','turma_id'=>$turma->id), array('class'=>'icon-print', 'target'=>'_blank', 'title'=>'Imprimir Diários')) . '&emsp;&emsp; - &emsp;&emsp;' . 
			// CHtml::link('',array('diario/bulkupdate', 'turma_id'=>$turma->id), array('class'=>'icon-refresh', 'title'=>'Atualizar Página')) . '&emsp;' . 
			// CHtml::link('',array('turma/update', 'id'=>$turma->id), array('class'=>'icon-edit', 'target'=>'_blank', 'title'=>'Editar Turma')); 
			
	?>
	</div></div>
</div>

<!-- <br clear="left"> -->

<!-- --------------------------- Begin TABLE ---------------------------- -->
<table class="table tb-aluno table-sm">
	<?php //for ($i=0; $i < count($diarios)+3; $i++) {? ><colgroup></colgroup><?php } ?>
	<thead>
		<tr>
			<th rowspan="5" style="text-align: center;vertical-align: middle;"><h3><?php echo $turma->ano.'-'.$turma->semestre.'<br/>'.$turma->disciplina->nome; ?></h3></th>
			<th colspan="<?php echo count($diarios)+2;?>" style="text-align: center;vertical-align: middle;">Registro de Faltas</th>
			<th rowspan="5" style="text-align: center;vertical-align: middle;"><h3><?php echo $turma->ano.'-'.$turma->semestre.'<br/>'.$turma->disciplina->nome; ?></h3></th>
		</tr>
		<tr class="aulas">
			<th style="width: 65px; text-align: center;">Aulas</th>
			<?php 
			$ct = 1;
			foreach ($diarios as $d)
			{
			?><td style="width: 10px;text-align: center;vertical-align: middle;">
				<?php echo CHtml::link($ct . ':' . ($ct+$d->aulas-1), array('diario/update', 'id'=>$d->id), array('target'=>'_blank', 'title'=>$d->conteudo)); ?>
			</td>
			<?php $ct = $ct + $d->aulas;
			} ?>
			<th style="text-align: center;"><?php echo $ct-1; ?></th>
		</tr>
		<tr>
			<th style="text-align: center;">Qtd.</th>
			<?php foreach ($diarios as $d) { ?>
			<td style="text-align: center;vertical-align: middle;"><?php echo $d->aulas ?></td>
			<?php } ?>
			<th rowspan="3" style="width: 10px;text-align: center;vertical-align: middle;">Total de Faltas</th>
		</tr>
		<tr>
			<th style="text-align: center;">Dia</th>
			<?php 
			$ct = 0;
			foreach ($diarios as $d) { 
				$ct++;
			?>
				<td style="text-align: center;vertical-align: middle;"><?php echo date_format(date_create($d->data), 'd'); ?></td>
			<?php } ?>
		</tr>
		<tr>
			<th style="text-align: center;">Mês</th>
			<?php 
			$ct = 0;
			foreach ($diarios as $d) { 
				$ct++;
			?>
				<td style="text-align: center;vertical-align: middle;"><?php echo date_format(date_create($d->data), 'm'); ?></td>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php
		$i = 1; $k = 1;
		foreach ($alunos as $aluno) {
		?>
		<tr>
			<td colspan="2" style="min-width: 500px;"><?php echo $i . '&emsp;&emsp;' . $aluno->ra . '&emsp;&emsp;' . $aluno->nome; ?></td>
			<?php 
			foreach ($diarios as $d) {
				$freq = $d->getFrequencia($aluno);
			?>
			<td style="text-align: center;vertical-align: middle;">
				
					<?php $this->renderPartial('_faltasbtn', array(
				        'freq' => $freq,
				        // 'aluno' => $aluno,
				        // 'd' => $d,
				        'i' => $k,
				    ));?>
				    
			</td>
			<?php 
				$k++;
			} ?>
			<td style="text-align: center;vertical-align: middle;"><?php echo ((isset($total_faltas[$aluno->id]))? $total_faltas[$aluno->id] : 0);?></td>
			<td style="min-width: 350px;"><?php echo $aluno->nome; ?></td>
		</tr>
		<?php 
			$i++;
		} ?>
		
	</tbody>
</table>
<div style="clear: left;"></div>
<!-- --------------------------- END ------------------------------------ -->

<script language="javascript">	
		var ctAlunos = <?php echo count($alunos); ?>;
	
		function toogleFaltas (i, max_faltas) {
			var n = $('#Frequencia_' + i + '_faltas').val();
			
			n = n - 1;
			
			if (n < 0) {
				n = max_faltas;
			}
			
			setFaltas(i, n);
			
			$('#btn-faltas-' + i).attr('class', 'btn btn-xs btn-default');
		}
		
		function setFaltas(i, faltas) {
			var btn = $('#btn-faltas-' + i);
			
			var n = faltas;
			
			if (n == 0) {
				btn.attr('class', 'btn btn-xs btn-success');
			} else {
				btn.attr('class', 'btn btn-xs btn-warning');
			}
			
			btn.attr('value', n);
			$('#Frequencia_' + i + '_faltas').attr('value', n);
			
		}
		
		// function maxFaltasAll() {
			// setAllFaltas(max_faltas);
		// }
		
		// function setAllFaltas(n) {
			// for (var i=1; i <= ctAlunos; i++) {
				// setFaltas(i, n);
			// };
		// }
		
		$(".tb-aluno").delegate('td','mouseover mouseleave', function(e) {
		    if (e.type == 'mouseover') {
		      $(this).addClass("hover-cell");
		      // $(this).parent().addClass("hover");
		      // $("colgroup").eq($(this).index()+1).addClass("hover");
		    }
		    else {
		      $(this).removeClass("hover-cell");
		      // $(this).parent().removeClass("hover");
		      // $("colgroup").eq($(this).index()+1).removeClass("hover");
		    }
		});
	</script>

<?php } ?>