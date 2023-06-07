<style type="text/css">
	* {
		font-family: Arial;
	}
	
	table.tb-freq {
		width: 100%;
		border-spacing: 0;
	}
	
	table.tb-freq th {
		/*border: 1px solid #808080;*/
		border: 1px solid #aa9898; 
		font-weight: bold;
		text-align: center;	
		width: auto;
	}
	
	table.tb-freq th, table.tb-freq td {
		font-size: 8pt;
	}
	
	table.tb-freq .expand {	
		width: auto;
		max-width: none;
		text-align: left;
	}
	
	table.tb-freq th, table.tb-freq td {
		text-align: center;
	}
	
	table.tb-freq td {
		border-top: 3px double #aa9898; 
		border-bottom: 3px double #aa9898; 
		border-left: 1px solid #aa9898; 
		border-right: 1px solid #aa9898;
	}
	
	table.tb-freq .tb-freq-row div {
		height: 12px;
		overflow: hidden;
		vertical-align: middle;
	}
	
	table.tb-freq .tb-freq-col-a {
		width: 10%;
		text-align: left;
	}
	
	table.tb-freq .tb-freq-col-b {
		width: 1% !important;
	}
	
	table.tb-freq .tb-freq-col-c {
		width: 0.5%;
	}
</style>
<?php
	
	$numDias = 30;
	$numAlunos = 18;
	
	$totalFaltas = array();
	
	$pags_diarios = array();
	$pag_atual = array();
	$ct = 0;
	foreach ($lsdiarios as $d) {
		$ct++;
		for ($i=1; $i <= $d->aulas; $i++) {
			
			$freqs = array();
			foreach ($d->frequencias as $f) {
				$fq = new Frequencia;
				$fq->id = $f->id;
				$fq->diario_id = $f->diario_id;
				$fq->aluno_id = $f->aluno_id;
				
				$fq->faltas = ($i <= $f->faltas)? 1 : 0;
				
				$totalFaltas[$fq->aluno_id] = $fq->faltas + (isset($totalFaltas[$fq->aluno_id])? $totalFaltas[$fq->aluno_id] : 0);
				
				array_push($freqs, $fq);
			}
			
			$dia = new Diario;
			$dia->id = $d->id;
			$dia->data = $d->data;
			$dia->aulas = $d->aulas;
			$dia->conteudo = $d->conteudo;
			// $dia->turma = $d->turma;
			$dia->frequencias = $freqs;
			
			
			array_push($pag_atual, $dia);
			
			if (count($pag_atual) == $numDias || ($ct == count($lsdiarios) && $i == $d->aulas)) {
				array_push($pags_diarios, $pag_atual);	
				$pag_atual = array();	
			}
		}
	}
	
	$pags_alunos = array();
	// $pag_atual = array();
	$ct = 0;
	foreach ($lsalunos as $a) {
		array_push($pag_atual, $a);
		$ct++;
		
		if (count($pag_atual) == $numAlunos || $ct == count($turma->alunos)) {
			array_push($pags_alunos, $pag_atual);
			$pag_atual = array();	
		}
	}
	// echo var_dump($pags_alunos);
	
	$priAluno = 1;
	foreach ($pags_alunos as $alunos) {
		//$priAlunoAux = $priAluno; 
		$priAula = 1; 
		foreach ($pags_diarios as $diarios) {
			// echo $this->renderPartial('_frequencia-folha', array('diarios'=>$pagd, 'alunos'=>$paga, 'turma'=>$turma,
				// 'numDias'=>$numDias, 'numAlunos'=>$numAlunos, 'priAula'=>$priAula, 'priAluno'=>$priAluno, 
				// 'totalFaltas'=>$total_faltas)); 
?>
<!-- ************************************************************************** -->
<?php if (!($priAluno == 1 && $priAula == 1)) {?> <div style="page-break-after: always"></div><?php } ?>
<div class="container-report">
<?php echo $this->renderPartial('_cabecalho-IFPR', array('turma'=>$turma)); ?>
<table class="tb-cabecalho" style="width: 100%;">
	<tbody>
	<tr>
		<th>Curso</th>
		<th>Disciplina</th>
	</tr>
	<tr>
		<td><?php echo $turma->disciplina->curso->nome;?></td>
		<td><?php echo $turma->disciplina->codigo . ' - '. $turma->disciplina->nome;?></td>
	</tr>
</tbody></table>
<table class="tb-freq">
	<tbody>
	<tr>
		<th rowspan="4" colspan="2">Aluno</th>
		<th colspan="<?php echo $numDias + 2;?>" style="background: rgb(234, 234, 234);">Registro de falta - Preencher com 'A' as ausências</th>
	</tr>
	<tr>
		<th class="tb-freq-col-b" style="width: 20px;">Aula</th>
		<?php for ($ct = 0; $ct < $numDias; $ct++) { ?>
		<th class="tb-freq-col-c"><?php echo $ct+$priAula; ?></th>
		<?php } ?>
		<th class="tb-freq-col-b">Sub-</th>
	</tr>
	<tr>
		<th class="tb-freq-col-b">Dia</th>
		<?php $ct = 0;
		foreach ($diarios as $d) {
		$ct++;
		?><th class="tb-freq-col-c"><?php echo date_format(date_create($d->data), 'd'); ?></th><?php
		if ($ct > $numDias) break;
		}
	
		for ($ct; $ct < $numDias; $ct++) {
		?><th class="tb-freq-col-c"></th><?php
		}
		?>
		<th class="tb-freq-col-b">Total</th>
	</tr>
	<tr>
		<th class="tb-freq-col-b">Mês</th>
		<?php 
		$ct = 0;
		foreach ($diarios as $d) {
			$ct++;
			?><th class="tb-freq-col-c"><?php echo date_format(date_create($d->data), 'm'); ?></th><?php
			if ($ct > $numDias) break; 
		}
		
		for ($ct; $ct < $numDias; $ct++) {
			?><th class="tb-freq-col-c"></th><?php
		} ?>
		<th class="tb-freq-col-b">Faltas</th>
	</tr>
<?php 
	
	$priAlunoAux = $priAluno;
	foreach ($alunos as $aluno) {
		
?>
	<tr class="tb-freq-row">
		<td class="tb-freq-col-c"><div><?php echo $priAlunoAux;?></div></td>
		<td class="tb-freq-col-a" colspan="2"><div><?php echo $aluno->ra . '&emsp;&emsp;' . $aluno->nome;?></div></td>
		<?php 
			$priAulaAux = $priAula;
			for ($j=0 ; $j < $numDias ; $j++) {
				?><td class="tb-freq-col-c"><div>
					<?php 
					
						if (isset($diarios[$j])) {
							$d = $diarios[$j];
							echo ($d->getFrequencia($aluno)->faltas > 0)? 'A' : 'C';
						}
					
					?></div></td><?php
				
				$priAulaAux++;
			}
?>
		<td class="tb-freq-col-b"><div><?php echo isset($totalFaltas[$aluno->id])? $totalFaltas[$aluno->id] : 0;?></div></td>
	</tr>
	<?php 
	
		$priAlunoAux++;
	} ?>
</tbody></table>
<br clear="left">
<table class="tb-legenda" style="width: 100%;">
	<tr>
		<td style="width: 15%">
			Observações:
		</td>
		<td style="width: 75%; border: 1px solid black;">
			<?php echo $turma->observacoes;?>
		</td>
		<td style="width: 20%; text-align: center;">
			<br /><br />
			____________________________<br />
			Assinatura do Professor
		</td>
	</tr>
</table>
</div>
<!-- ************************************************************************** -->
<?php
			$priAula += $numDias;
		}
		$priAluno += $numAlunos;
	}
?>