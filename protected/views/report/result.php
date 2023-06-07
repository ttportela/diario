<?php

// Cores da Lista:
$colors = array(
	'#FBF2F0',
	'#E5E2E1'
);

// SETA OS PARÂMETROS DE CONFIGURAÇÃO:
$imprimir 	= isset($_GET['imprimir'])? true : false;
$notas	 	= isset($_GET['notas'])? true : false;
$nome 		= isset($_GET['nome'])? true : false;
$RA 		= isset($_GET['RA'])? true : false;
$pri_bim 	= isset($_GET['pri_bim'])? true : false;
$seg_bim 	= isset($_GET['seg_bim'])? true : false;
$faltas 	= isset($_GET['faltas'])? true : false;
$med_parc 	= isset($_GET['med_parc'])? true : false;
$exame	 	= isset($_GET['exame'])? true : false;
$med_final 	= isset($_GET['med_final'])? true : false;
$result 	= isset($_GET['result'])? true : false;
$round 		= isset($_GET['round'])? ($_GET['round'] == '0'? false : true) : true;

$em_exame 	= isset($_GET['em_exame'])? true : false;
$aprovado 	= isset($_GET['aprovado'])? true : false;
$reprovado 	= isset($_GET['reprovado'])? true : false;

$params = array();
if ($notas) 	$params['notas']		= '1';
if ($nome) 		$params['nome']			= '1';
if ($RA) 		$params['RA'] 			= '1';
if ($pri_bim) 	$params['pri_bim'] 		= '1';
if ($seg_bim) 	$params['seg_bim'] 		= '1';
if ($faltas) 	$params['faltas'] 		= '1';
if ($med_parc) 	$params['med_parc'] 	= '1';
if ($exame) 	$params['exame'] 		= '1';
if ($med_final) $params['med_final'] 	= '1';
if ($result) 	$params['result'] 		= '1';
if ($em_exame) 	$params['em_exame'] 	= '1';
if ($aprovado) 	$params['aprovado'] 	= '1';
if ($reprovado) $params['reprovado'] 	= '1';
if ($round) 	$params['round'] 		= '1';
if (isset($_GET['round']) && $_GET['round'] == '0') 	$params['round'] 		= '0';

$turma_id = isset($_GET['turma_id'])? $_GET['turma_id'] : null;

if (!(isset($turma_id))) {
		
	/* @var $this ReportController */
	$this->breadcrumbs=array(
		'Relatórios'=>array('/report'),
		'Resultados'=>array_merge(array('/report/result'),$params),
		'Seleção de Turma'
	);
	?>
	<div class="page-header">
		<h1>Resultados</h1>
	</div>
	<?php 
		
	echo $this->renderPartial('_select-turma', array('targetBlank'=>false, 'params'=>$params));
		
} else {
	
	$turma = Turma::model()->findByPk($turma_id);
	
	$this->breadcrumbs=array(
		'Relatórios'=>array('/report'),
		'Resultados'=>array_merge(array('/report/result'),$params),
		$turma->nome . ' [' . $turma->ano . '-' . $turma->semestre . ']'
	);

	$this->pageTitle = $turma->ano.'-'.$turma->semestre.' - RESULTADOS - '.$turma->nome;
	$params['imprimir'] = '1';
	
	// SE FOR PARA IMPRIMIR:
	if ($imprimir) {
		require_once(Yii::app()->basePath . '/views/report/_report_header.php');
		
// Estilo de impressão
?>
<style type="text/css">
	.table {
		width: 100%;
		border-collapse: collapse;
	}
	.table, .table tr, .table td, .table th {
		border: 1px solid black;
	} 
</style>
<div>
	<div style="display: inline">
	<?php echo CHtml::image('images/ifpr.png', 'IFPR Logo', array("width"=>"150px" ,"height"=>"90px")); ?>
	</div>
	<div style="float: left; position: absolute; display: inline">
	<b><font face="Arial" color="#000000">INSTITUTO FEDERAL DO PARANÁ</font></b><br/>
	<b><font face="Arial" color="#000000">Ministério da Educação</font></b><br/>
	<!-- <b><font face="Arial" color="#000000">____/____/_________</font></b> -->
	</div>
</div>
<?php
	}

	// BUSCA DADOS
	$criteria=new CDbCriteria(array(
		'condition'=>'turma.id='.$turma->id,
		'order'=>'data ASC',
		'with'=>'turma',
	));
	
	$lsdiarios = Diario::model()->findAll($criteria);
	
	$criteria=new CDbCriteria(array(
		'condition'=>'turmas.id='.$turma->id,
		'order'=>'t.nome ASC',
		'with'=>array('turmas'=>array('select'=>'turmas.id', 'joinType'=>'INNER JOIN')),//'turmas',
	));
	
	$lsalunos = Aluno::model()->findAll($criteria);
	
	// $totalFaltas = array(array(),array());
	
	// $ct = 0;
	// foreach ($lsalunos as $aluno) {
		// $ct++;
// 		
		// // total de faltas
		// for ($i = 0 ; $i < (count($lsdiarios) / 2) ; $i++ ) {
			// $d = $lsdiarios[$i];
			// $totalFaltas[$aluno->id][0] = $d->getFrequencia($aluno)->faltas + (isset($totalFaltas[$aluno->id][0])? $totalFaltas[$aluno->id][0] : 0);
		// }
		// for ($i ; $i < count($lsdiarios) ; $i++ ) {
			// $d = $lsdiarios[$i];
			// $totalFaltas[$aluno->id][1] = $d->getFrequencia($aluno)->faltas + (isset($totalFaltas[$aluno->id][1])? $totalFaltas[$aluno->id][1] : 0);
		// }
	// }

	$avExame = $turma->exame;
	// foreach ($turma->avaliacoes as $av) {
		// if ($av->bimestre == Avaliacao::$EXAME) {
			// $avExame = $av;
			// break;
		// }
	// }
	
	if (!isset($avExame)) $exame = false;

?>

<div class="page-header">
	<h1>Resultados <small><?php echo $turma->disciplina->nome . ' [' . $turma->ano . '-' . $turma->semestre . ']'; ?>
		<?php if (!$imprimir) echo CHtml::link('',array_merge(array('/report/result','turma_id'=>$turma->id), $params), array('class'=>'icon-print', 'target'=>'_blank', 'title'=>'Imprimir Resultados'));?>
	</small></h1>
	
</div>

<br />
<table style="width: 100%;" class="cabecalho">
	<tr>
		<th>Curso:</th>
		<td><?php echo $turma->disciplina->curso->nome;?></td>
	</tr>
	<tr>
		<th>Disciplina:</th>
		<td><?php echo $turma->disciplina->nome;?></td>
	</tr>
	<tr>
		<th>Professor:</th>
		<td><?php echo $turma->professor->nome;?></td>
	</tr>
</table>
<br />

<table class="table">
	<tr>
		<?php if ($nome) { ?><th style="min-width: 280px" rowspan="2">Acadêmico</th><?php } ?>
		<?php if ($RA) { ?><th rowspan="2">Registro Acadêmico</th><?php } ?>
		
		<?php if ($notas && $pri_bim) { 
				foreach ($turma->avaliacoes as $av) {
					if($av->bimestre == Avaliacao::$BIM_1 && $av->bimestre != Avaliacao::$EXAME) {
			?><th><?php echo $av->nome;?></th>
		<?php 		}
				} 
			  }
		?>
		
		<?php if ($pri_bim && $med_parc) { ?><th style="background-color: <?php echo $colors[1]; ?>;" rowspan="2">MÉDIA 1ºB</th><?php } ?>
		<?php if ($faltas && $pri_bim) { ?><th style="background-color: <?php echo $colors[0]; ?>;" rowspan="2">FALTAS 1ºB</th><?php } ?>
		
		<?php if ($notas && $seg_bim) { 
				foreach ($turma->avaliacoes as $av) {
					if($av->bimestre == Avaliacao::$BIM_2 && $av->bimestre != Avaliacao::$EXAME) {
			?><th><?php echo $av->nome;?></th>
		<?php 		}
				} 
			  }
		?>

		<?php if ($seg_bim && $med_parc) { ?><th style="background-color: <?php echo $colors[1]; ?>;" rowspan="2">MÉDIA 2ºB</th><?php } ?>
		<?php if ($faltas && $seg_bim) { ?><th style="background-color: <?php echo $colors[0]; ?>;" rowspan="2">FALTAS 2ºB</th><?php } ?>
			  
		<?php if ($med_parc) { ?><th rowspan="2">Média Parcial</th><?php } ?>
		<?php if ($faltas) { ?><th style="background-color: <?php echo $colors[0]; ?>;" rowspan="2">Faltas</th><?php } ?>
		<?php if ($faltas) { ?><th style="background-color: <?php echo $colors[0]; ?>;" rowspan="2">%</th><?php } ?>
		<?php if ($exame) { ?><th rowspan="2">Exame</th><?php } ?>
		<?php if ($round && $med_final) { ?><th style="background-color: <?php echo $colors[1]; ?>;" rowspan="2">Média Final</th><?php } ?>
		<?php if ($result) { ?><th rowspan="2">Resultado</th><?php } ?>
	</tr>
	<tr>
		<?php if ($notas && $pri_bim) { 
				foreach ($turma->avaliacoes as $av) {
					if($av->bimestre == Avaliacao::$BIM_1 && $av->bimestre != Avaliacao::$EXAME) {
			?><th style="font-weight: normal;"><?php echo $av->notamaxima.'/'.$av->peso;?></th>
		<?php 		}
				} 
			  }
		?>
		
		<?php if ($notas && $seg_bim) { 
				foreach ($turma->avaliacoes as $av) {
					if($av->bimestre == Avaliacao::$BIM_2 && $av->bimestre != Avaliacao::$EXAME) {
			?><th style="font-weight: normal;"><?php echo $av->notamaxima.'/'.$av->peso;?></th>
		<?php 		}
				} 
			  }
		?>
	</tr>
<?php foreach ($lsalunos as $aluno) { 
	$notaB1 = $aluno->mediaBimestral($turma, 1, false);//Avaliacao::mediaBimestral($turma->avaliacoes, $aluno, 1, true);
	$notaB2 = $aluno->mediaBimestral($turma, 2, false);//Avaliacao::mediaBimestral($turma->avaliacoes, $aluno, 2, true);
	
	if ($round) {
		$notaB1 = Avaliacao::roundUp($notaB1);
		$notaB2 = Avaliacao::roundUp($notaB2);
	}
	
	$mediaParcial = $aluno->mediaParcial($turma, $notaB1, $notaB2); //(($notaB1 + $notaB2) / 2);
	
	$faltasB1 = $aluno->faltas($turma, 1);
	$faltasB2 = $aluno->faltas($turma, 2);
	$totalFaltas = $aluno->totalFaltas($turma, $faltasB1, $faltasB2);
	
	$porcFaltas = $aluno->percentualFaltas($turma); // ($turma->chaula-($totalFaltas[$aluno->id][0]+$totalFaltas[$aluno->id][1]))*100/$turma->chaula;
	
	//$mediaParcial = round($mediaParcial, 1);
	
	$mediaFinal = $aluno->mediaFinal($turma, $mediaParcial, $notaB1, $notaB2, $porcFaltas);
	
	// Resultado do aluno:
    $resultado = $aluno->resultado($turma, $mediaParcial, $notaB1, $notaB2, $porcFaltas, $totalFaltas);

?>
	<tr>
		<?php if ($nome) { ?><td><?php echo $aluno->nome; ?></td><?php } ?>
		<?php if ($RA) { ?><td style="text-align: center;"><?php echo $aluno->ra; ?></td><?php } ?>
		
		<?php if ($notas && $pri_bim) { 
				foreach ($turma->avaliacoes as $av) {
					if($av->bimestre == Avaliacao::$BIM_1 && $av->bimestre != Avaliacao::$EXAME) {
			?><td style="text-align: right;"><?php echo str_replace('.',',', Yii::app()->getNumberFormatter()->format("0.00",$av->notaBase($aluno)));?></td>
		<?php 		}
				} 
			  }
		?>
		<?php if ($pri_bim && $med_parc) { ?><td style="text-align: right;background-color: <?php echo $colors[1]; ?>;"><?php echo str_replace('.',',', Yii::app()->getNumberFormatter()->format("0.00",$notaB1));?></td><?php } ?>
		<?php if ($faltas && $pri_bim) { ?><td style="text-align: center;background-color: <?php echo $colors[0]; ?>;"><?php echo $faltasB1; //$totalFaltas[$aluno->id][0];?></td><?php } ?>
		
		<?php if ($notas && $seg_bim) { 
				foreach ($turma->avaliacoes as $av) {
					if($av->bimestre == Avaliacao::$BIM_2 && $av->bimestre != Avaliacao::$EXAME) {
			?><td style="text-align: right;"><?php echo str_replace('.',',', Yii::app()->getNumberFormatter()->format("0.00",$av->notaBase($aluno)));?></td>
		<?php 		}
				} 
			  }
		?>
		<?php if ($seg_bim && $med_parc) { ?><td style="text-align: right;background-color: <?php echo $colors[1]; ?>;"><?php echo str_replace('.',',', Yii::app()->getNumberFormatter()->format("0.00",$notaB2));?></td><?php } ?>
		<?php if ($faltas && $seg_bim) { ?><td style="text-align: center;background-color: <?php echo $colors[0]; ?>;"><?php echo $faltasB2;?></td><?php } ?>
			  
		<?php if ($med_parc) { ?><td style="text-align: right;"><?php echo str_replace('.',',', Yii::app()->getNumberFormatter()->format("0.00",$mediaParcial));?></td><?php } ?>
		<?php if ($faltas) { ?><td style="text-align: center;background-color: <?php echo $colors[0]; ?>;"><?php echo $totalFaltas;?></td><?php } ?>
		<?php if ($faltas) { ?><td style="text-align: center;background-color: <?php echo $colors[0]; ?>;"><?php echo str_replace('.',',', Yii::app()->getNumberFormatter()->format("0.0",$porcFaltas));?>%</td><?php } ?>
		<?php if ($exame) { ?><td style="text-align: right;"><?php echo ($aluno->emExame($mediaParcial, $porcFaltas)? str_replace('.',',', Yii::app()->getNumberFormatter()->format("0.00",$avExame->notaBase10($aluno))) : ''); ?></td><?php } ?>
		<?php if ($med_final) { ?><td style="text-align: right;background-color: <?php echo $colors[1]; ?>;"><?php echo str_replace('.',',', Yii::app()->getNumberFormatter()->format("0.00", $mediaFinal));?></td><?php } ?>
		<?php if ($result) { ?><td><div class='label label-<?php echo ($resultado[1] == "EXAME"? 'warning' : ($resultado[2]? 'success' : 'important'));?>'><?php echo $resultado[0];?></div></td><?php } ?>
	</tr>	
<?php } ?>
</table>

<?php } ?>
