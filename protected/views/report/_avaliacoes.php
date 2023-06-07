<style type="text/css">
	* {
		font-family: Arial;
	}
	
	table.tb-notas {
		width: 100%;
		border-spacing: 0;
		
	}
	
	table.tb-notas th {
		border: 1px solid #808080;
		font-weight: bold;
		text-align: center;	
		width: 4.8%;
		max-width: 107px;
	}
	
	table.tb-notas th, table.tb-notas td {
		text-align: center;
	}
	
	table.tb-notas td, table.tb-notas td:first-child, table.tb-notas td:last-child{
		border-top: 3px double #aa9898; 
		border-bottom: 3px double #aa9898; 
		border-left: 1px solid #aa9898; 
		border-right: 1px solid #aa9898;
	}
	
	table.tb-notas div, table.tb-notas th{
		font-size: 8pt;
		height: 12px;
		overflow: hidden;
		vertical-align: middle;
	}
	
	table.tb-legenda td {
		font-size: 7pt;
	}

</style>

<?php 

	$round = isset($_GET['round'])? ($_GET['round'] == '0'? false : true) : true;

	$numAlunos = 20;

	$linhasAv = array();
	
	$totalFaltas = array(array(),array());
	
	$pags_alunos = array();
	$pag_atual = array();
	$ct = 0;
	foreach ($lsalunos as $a) {
		array_push($pag_atual, $a);
		$ct++;
		
		if (count($pag_atual) == $numAlunos || $ct == count($turma->alunos)) {
			array_push($pags_alunos, $pag_atual);
			$pag_atual = array();	
		}
		
	}

	$avExame = $turma->exame;
	$isExame = isset($avExame);
	
	$priAluno = 1;
	foreach ($pags_alunos as $alunos) {

if ($priAluno != 1) {?> <div style="page-break-after: always"></div><?php } ?>

<div class="container-report">
		<?php echo $this->renderPartial('_cabecalho-IFPR', array('turma'=>$turma)); ?>
		<table class="tb-cabecalho" style="width: 100%;">
			<tbody>
			<tr>
				<td style="width: 40%;"><?php echo $turma->disciplina->codigo . ' - ' . $turma->disciplina->nome;?></td>
				<td style="width: 40%;">Departamento: Colegiado Institucional</td>
				<td style="width: 20%;">Turma: <?php echo $turma->classe;?></td>
			</tr>
		</tbody></table>
		<table class="tb-cabecalho" style="width: 100%;">
			<tbody>
			<tr>
				<td style="width: 10%; text-align: center;"><?php echo $turma->ano . '-' . $turma->semestre;?></td>
				<td style="width: 40%;">Professor: <?php echo $turma->professor->nome;?></td>
				<td style="width: 30%;">Tutor (a)</td>
				<td style="width: 20%;">Carga Horária: <?php echo $turma->chrelogio;?> horas</td>
			</tr>
		</tbody></table>
		
		<table class="tb-notas" style="width: 100%;">
		<thead>
			<tr>
				<th rowspan="2" colspan="2"  style="width: auto; text-align: left;">NOME</th>
				<th rowspan="2" style="width: auto;">MATRÍCULA</th>
				<th colspan="2">1º Bimestre</th>
				<th colspan="2">2º Bimestre</th>
				<th rowspan="2">MÉDIA PARCIAL</th>
				<th rowspan="2">EXAME FINAL</th>
				<th rowspan="2">MÉDIA FINAL</th>
				<th rowspan="2">TOTAL FALTAS</th>
				<th rowspan="2">PROC. DE FREQUÊNCIA</th>
				<th rowspan="2">RESULTADO FINAL</th>
			</tr>
			<tr>
				<th>NOTA</th>
				<th>FALTAS</th>
				<th>NOTA</th>
				<th>FALTAS</th>
			</tr>
		</thead>
		<tbody>
			
<?php

	foreach ($alunos as $aluno) {
		$notaB1 = $aluno->mediaBimestral($turma, 1, false);
		$notaB2 = $aluno->mediaBimestral($turma, 2, false);
		
		if ($round) {
			$notaB1 = Avaliacao::roundUp($notaB1);
			$notaB2 = Avaliacao::roundUp($notaB2);
		}
		
		$mediaParcial = $aluno->mediaParcial($turma, $notaB1, $notaB2);
		
		$faltasB1 = $aluno->faltas($turma, 1);
		$faltasB2 = $aluno->faltas($turma, 2);
		$totalFaltas = $aluno->totalFaltas($turma, $faltasB1, $faltasB2);
		
		$porcFaltas = $aluno->percentualFaltas($turma);	
		
		// Resultado do aluno:
		$mediaFinal = $aluno->mediaFinal($turma, $mediaParcial, $notaB1, $notaB2, $porcFaltas);
	    $resultado = $aluno->resultado($turma, $mediaParcial, $notaB1, $notaB2, $porcFaltas, $totalFaltas);	
		
?>
				<tr>
					<td style="width: 25px;"><div><?php echo $priAluno;?></div></td>
					<td style="text-align: left;"><div><?php echo $aluno->nome;?></div></td>
					<td><div><?php echo $aluno->ra;?></div></td>
					<td><div><?php echo str_replace('.',',', Yii::app()->getNumberFormatter()->format("0.00",$notaB1));?></div></td>
					<td><div><?php echo $faltasB1;?></div></td>
					<td><div><?php echo str_replace('.',',', Yii::app()->getNumberFormatter()->format("0.00",$notaB2));?></div></td>
					<td><div><?php echo $faltasB2;?></div></td>
					<td><div><?php echo str_replace('.',',', Yii::app()->getNumberFormatter()->format("0.00",$mediaParcial));?></div></td>
					<td><div><?php echo ($isExame)? str_replace('.',',', Yii::app()->getNumberFormatter()->format("0.00",$avExame->nota($aluno)->nota)) : '';?></div></td>
					<td><div><?php echo str_replace('.',',', Yii::app()->getNumberFormatter()->format("0.00", $mediaFinal));?></div></td>
					<td><div><?php echo $totalFaltas;?></div></td>
					<td><div><?php echo str_replace('.',',', Yii::app()->getNumberFormatter()->format("0.0", $porcFaltas));?>%</div></td>
					<td><div><?php echo $resultado[1];?></div></td>
				</tr>
				
<?php
$priAluno++;
}
?>
				
		</tbody></table>
		
		<table class="tb-legenda" style="width: 100%;">
			<tr>
				<td style="width: 70%">
					<table style="width: 100%;">
						<tr>
							<td colspan="4">Resultado Final:</td>
						</tr>
						<tr>
							<td style="width: 15%">A</td>
							<td style="width: 35%">Aprovado por Média</td>
							<td style="width: 15%">AF</td>
							<td style="width: 35%">Aprovado na Prova Final</td>
						</tr>
						<tr>
							<td style="width: 15%">AQ</td>
							<td style="width: 35%">Aprovado por Frequência</td>
							<td style="width: 15%">DA</td>
							<td style="width: 35%">Dispensa Atividade Física</td>
						</tr>
						<tr>
							<td style="width: 15%">DI</td>
							<td style="width: 35%">Dispensada</td>
							<td style="width: 15%">R</td>
							<td style="width: 35%">Reprovado por Média</td>
						</tr>
						<tr>
							<td style="width: 15%">RF</td>
							<td style="width: 35%">Reprovado na Prova Final</td>
							<td style="width: 15%">RQ</td>
							<td style="width: 35%">Reprovado por Frequência</td>
						</tr>
						<tr>
							<td style="width: 15%">TR</td>
							<td style="width: 35%">Trancada</td>
							<td style="width: 15%"></td>
							<td style="width: 35%"></td>
						</tr>
					</table>
					
				</td>
				<td style="width: 30%; text-align: center;">
					<br /><br /><br />
					________________________________________________<br />
					Assinatura do Professor
				</td>
			</tr>
		</table>
</div>
<?php
}
?>