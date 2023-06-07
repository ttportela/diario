<?php

$pageName = 'Lista de Presença em Prova Final';

$turma_id = isset($_GET['turma_id'])? $_GET['turma_id'] : null;

if (!(isset($turma_id))) {
		
	/* @var $this ReportController */
	$this->breadcrumbs=array(
		'Diário'=>array('/diario'),
		$pageName,
	);
	?>
	<h1><?php echo $pageName;?></h1>
	<?php 
		
	echo $this->renderPartial('../report/_select-turma', array('targetBlank'=>true));
		
} else {

	// include_once './../report/_report_header.php';
	require_once(Yii::app()->basePath . '/views/report/_report_header.php');
	 
	$this->pageTitle = $turma->ano.'-'.$turma->semestre.' - Ata de EXAME - '.$turma->nome;
	 
	// $totalFaltas = array(array(),array());
	// foreach ($lsalunos as $a) {
// 		
		// // total de faltas
		// for ($i = 0 ; $i < count($lsdiarios) ; $i++ ) {
			// $d = $lsdiarios[$i];
			// $totalFaltas[$a->id] = $d->getFrequencia($a)->faltas + (isset($totalFaltas[$a->id])? $totalFaltas[$a->id] : 0);
		// }
	// }	
	
?>
	
<style type="text/css">
	* {
		font-family: Arial;
	}
	
	th {
		text-align: left;
	}
	
	table.alunos,
	table.alunos td,
	table.alunos th {
		border: 1px solid black;
	}
</style>
<div class="container-report">
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

		<h1 style="text-align: center;">ATA DE EXAME</h1>
		<br />
		<table style="width: 100%;" class="cabecalho">
			<tr>
				<th>Curso:</th>
				<td><?php echo $turma->disciplina->curso->nome;?></td>
			</tr>
			<tr>
				<th>Data:</th>
				<td>____/____/_________</td>
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
		<table style="width: 100%;" class="alunos" cellspacing="0">
			<tr>
				<th style="width: 40%;">Acadêmico</th>
				<th style="width: 20%;">R.G.</th>
				<th style="width: 20%;">Assinatura</th>
				<th style="width: 10%;">Nota</th>
				<th style="width: 10%;">Situação</th>
			</tr>
			<?php foreach ($lsalunos as $a) { 
				// $notaB1 = Avaliacao::mediaBimestral($turma->avaliacoes, $a, 1, true);
				// $notaB2 = Avaliacao::mediaBimestral($turma->avaliacoes, $a, 2, true);
// 				
				// $notaB1 = Avaliacao::roundUp($notaB1);
				// $notaB2 = Avaliacao::roundUp($notaB2);
// 				
				// $mediaParcial = (($notaB1 + $notaB2) / 2);	
				// $porcFaltas = ($turma->chaula - $totalFaltas[$a->id])*100/$turma->chaula;
// 				
				// if (!($mediaParcial >= 4 && $mediaParcial < 7 && $porcFaltas >= 75)) 
					// continue;
					
				$res = $a->resultado($turma);
				if ($res[1] != "EXAME")
					continue;
			?>
			<tr>
				<td><?php echo strtoupper($a->nome);?></td>
				<td> </td>
				<td> </td>
				<td> </td>
				<td> </td>
			</tr>
			<?php } ?>
		</table>
		<br /><br /><br />
		_______________,_____ de _______________________ de __________.
		
		<br /><br /><br /><br /><br /><br />
		<div style="width: 100%; text-align: center">
			_________________________________<br />
			<?php echo $turma->professor->nome;?>
		</div>
		
</div>
<?php }
?>