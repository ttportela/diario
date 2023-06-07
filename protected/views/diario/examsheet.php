<?php

$pageName = 'Lista de Presença em Prova Final';

// include_once './../report/_report_header.php';
require_once(Yii::app()->basePath . '/views/report/_report_header.php');

if (isset($turma)) {
	 
	$totalFaltas = array(array(),array());
	foreach ($lsalunos as $a) {
		
		// total de faltas
		for ($i = 0 ; $i < count($lsdiarios) ; $i++ ) {
			$d = $lsdiarios[$i];
			$totalFaltas[$a->id] += $d->getFrequencia($a)->faltas;
		}
	}	
	
?>
	
<style type="text/css">
	* {
		font-family: Arial;
	}
	
	th {
		text-align: left;
	}
	
	td.nome {
		width: 60%;
		font-size: 10pt;
	}
	
	td.assinatura {
		width: 40%;
		height: 20px;
		border-bottom: 2px solid black;
	}
</style>
<div class="container-report">
		<div>
			<div style="display: inline">
			<?php echo CHtml::image('images/ifpr.png', 'IFPR Logo', array("width"=>"150px" ,"height"=>"90px")); ?>
			</div>
			<div style="float: left; position: absolute; display: inline">
			<b><font face="Arial" color="#000000">INSTITUTO FEDERAL DO PARANÁ</font></b><br/>
			<b><font face="Arial" color="#000000">Sagres Diário</font></b><br/>
			<b><font face="Arial" color="#000000">____/____/_________</font></b>
			</div>
		</div>

		<h1>&emsp;Lista de Presença da Prova Final</h1>
		<hr />
		<table style="width: 100%;">
			<tr>
				<th>Unidade Acadêmica:</th>
				<td colspan="3">Depto de Administração</td>
			</tr>
			<tr>
				<th>Classe:</th>
				<td colspan="3"><?php echo $turma->disciplina->codigo . ' - ' . $turma->disciplina->nome;?> (Teórica - <?php echo $turma->classe;?>)</td>
			</tr>
			<tr>
				<th>Carga Horária:</th>
				<td><?php echo $turma->chrelogio;?> horas</td>
				<th>Período Letivo:</th>
				<td><?php echo $turma->ano .'-'. $turma->semestre;?></td>
			</tr>
			<tr>
				<th>Professor:</th>
				<td colspan="3"><?php echo strtoupper($turma->professor->nome);?></td>
			</tr>
		</table>
		<hr /><br />
		<table style="width: 100%;">
			<tr>
				<th>Aluno</th>
				<th>Assinatura do Aluno</th>
			</tr>
			<?php foreach ($lsalunos as $a) { 
				$notaB1 = Avaliacao::mediaBimestral($turma->avaliacoes, $a, 1, true);
				$notaB2 = Avaliacao::mediaBimestral($turma->avaliacoes, $a, 2, true);
				
				$notaB1 = Avaliacao::roundUp($notaB1);
				$notaB2 = Avaliacao::roundUp($notaB2);
				
				$mediaParcial = (($notaB1 + $notaB2) / 2);	
				$porcFaltas = ($turma->chaula - $totalFaltas[$a->id])*100/$turma->chaula;
				
				if (!($mediaParcial >= 4 && $mediaParcial < 7 && $porcFaltas >= 75)) 
					continue;
			?>
			<tr>
				<td class="nome"><?php echo strtoupper($a->nome . ' ('.$a->ra.')');?></td>
				<td class="assinatura"> </td>
			</tr>
			<?php } ?>
		</table>
</div>
<?php }
?>