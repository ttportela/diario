<?php
	
	$numDias = 30;
	$numAlunos = 20;
	
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
				
				$totalFaltas[$fq->aluno_id] += $fq->faltas;
				
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
	foreach ($turma->alunos as $a) {
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
<br/>
<table align="left" cellspacing="0" border="0" width="1500px" style="border-collapse: inherit">
	<tbody>
	<tr>
		<td style="border-top: 1px solid #aa9898; border-bottom: 3px double #aa9898; border-left: 1px solid #aa9898; border-right: 1px solid #aa9898" colspan="7" rowspan="4" height="82" align="left" valign="middle"><font face="Arial" color="#000000">Aluno</font></td>
		<td style="border-top: 1px solid #aa9898; border-bottom: 3px double #aa9898; border-right: 1px solid #aa9898" colspan="32" align="center" valign="bottom" bgcolor="#EAEAEA"><b><font face="Arial" color="#000000">Registro de falta - Preencher com 'A' as ausências</font></b></td>
		</tr>
	<tr style="height: 27px;">
		<td style="border-top: 3px double #aa9898; border-bottom: 3px double #aa9898; border-right: 1px solid #aa9898" align="center" valign="bottom"><font face="Arial" color="#000000">Aula</font></td>
	<?php //for ($i=$priAula; $i <= $numDias; $i++) {
	$ct = 0;
	for ($ct; $ct < $numDias; $ct++) {
			?><td style="width: 28px; border-top: 3px double #aa9898; border-bottom: 3px double #aa9898; border-left: 1px solid #aa9898; border-right: 1px solid #aa9898" align="center" valign="bottom" sdnum="1033;"><font face="Arial" color="#000000"><?php echo $ct+$priAula; ?></font></td><?php 
	} ?>
		<td style="border-top: 3px double #aa9898; border-left: 1px solid #aa9898; border-right: 1px solid #aa9898" align="center" valign="bottom"><font face="Arial" color="#000000">Sub-</font></td>
	</tr>
	<tr style="height: 27px;">
		<td style="border-top: 3px double #aa9898; border-bottom: 3px double #aa9898; border-right: 1px solid #aa9898" align="center" valign="bottom"><font face="Arial" color="#000000">Dia</font></td>
	<?php 
	$ct = 0;
	foreach ($diarios as $d) {
		$ct++;
		?><td style="width: 28px; border-top: 3px double #aa9898; border-bottom: 3px double #aa9898; border-left: 1px solid #aa9898; border-right: 1px solid #aa9898" align="center" valign="bottom"><font face="Arial" color="#000000"><?php echo date_format(date_create($d->data), 'd'); ?></font></td><?php
		if ($ct > $numDias) break;
	}
	
	for ($ct; $ct < $numDias; $ct++) {
		?><td style="width: 28px; border-top: 3px double #aa9898; border-bottom: 3px double #aa9898; border-left: 1px solid #aa9898; border-right: 1px solid #aa9898" align="center" valign="bottom"><font face="Arial" color="#000000"><br/></font></td><?php
	}
	?>
		<td style="border-left: 1px solid #aa9898; border-right: 1px solid #aa9898" align="center" valign="bottom"><font face="Arial" color="#000000">Total </font></td>
	</tr>
	<tr style="height: 27px;">
		<td style="border-top: 3px double #aa9898; border-bottom: 3px double #aa9898; border-right: 1px solid #aa9898" align="center" valign="bottom"><font face="Arial" color="#000000">Mês</font></td>
	<?php 
	$ct = 0;
	foreach ($diarios as $d) {
		$ct++;
		?><td style="width: 28px; border-top: 3px double #aa9898; border-bottom: 3px double #aa9898; border-left: 1px solid #aa9898; border-right: 1px solid #aa9898" align="center" valign="bottom"><font face="Arial" color="#000000"><?php echo date_format(date_create($d->data), 'm'); ?></font></td><?php
		if ($ct > $numDias) break; 
	}
	
	for ($ct; $ct < $numDias; $ct++) {
		?><td style="width: 28px; border-top: 3px double #aa9898; border-bottom: 3px double #aa9898; border-left: 1px solid #aa9898; border-right: 1px solid #aa9898" align="center" valign="bottom"><font face="Arial" color="#000000"><br></font></td><?php
	} ?>
		<td style="border-bottom: 3px double #aa9898; border-left: 1px solid #aa9898; border-right: 1px solid #aa9898" align="center" valign="bottom"><font face="Arial" color="#000000">Faltas</font></td>
	</tr>
	<?php 
	
	//$i=$priAluno;
	// $cta = 0;
	$priAlunoAux = $priAluno;
	foreach ($alunos as $aluno) {
		// $cta++; if ($cta < $i) continue;
		
		?><tr style="height: 27px;">
			<td style="border-top: 3px double #aa9898; border-bottom: 3px double #aa9898; border-left: 1px solid #aa9898; border-right: 1px solid #aa9898" height="22" align="center" valign="bottom" sdnum="1033;0;@"><font face="Arial" size="1" color="#000000"><?php echo $priAlunoAux;?></font></td>
			<td style="border-top: 3px double #aa9898; border-bottom: 3px double #aa9898; border-left: 1px solid #aa9898" align="center" valign="bottom" sdval="201200001" sdnum="1033;"><font face="Arial" size="1" color="#000000"><?php echo $aluno->ra;?></font></td>
			<td style="border-top: 3px double #aa9898; border-bottom: 3px double #aa9898; border-right: 1px solid #aa9898" colspan="6" align="left" valign="bottom"><font face="Arial" size="1" color="#000000"><?php echo $aluno->nome;?></font></td>
			<?php 
			$priAulaAux = $priAula;
			for ($j=0 ; $j < $numDias ; $j++) {
			//foreach ($diarios as $d) {
				//$ct++;
				?><td style="width: 28px; border-top: 3px double #aa9898; border-bottom: 3px double #aa9898; border-left: 1px solid #aa9898; border-right: 1px solid #aa9898" align="center" valign="bottom"><font face="Arial" color="#000000">
					<?php 
					
						if (isset($diarios[$j])) {
							$d = $diarios[$j];
							echo ($d->getFrequencia($aluno)->faltas > 0)? 'A' : 'C';
						}
					
					?>
				</font></td><?php
				
				$priAulaAux++;
			}
			
			//for ($ct; $ct < $numDias; $ct++) {
				?><!--td style="width: 28px; border-top: 3px double #aa9898; border-bottom: 3px double #aa9898; border-left: 1px solid #aa9898; border-right: 1px solid #aa9898" align="center" valign="bottom"><font face="Arial" color="#000000"><br></font></td--><?php
			//}?>
			<td style="border-top: 3px double #aa9898; border-bottom: 3px double #aa9898; border-left: 1px solid #aa9898; border-right: 1px solid #aa9898" align="center" valign="bottom" sdval="0" sdnum="1033;"><font face="Arial" color="#000000"><?php echo isset($totalFaltas[$aluno->id])? $totalFaltas[$aluno->id] : 0;?></font></td>
		</tr><?php
		$priAlunoAux++;
		// if (($i-priAluno) > $numAlunos) break;
	} ?>
	<tr>
		<td height="21" align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td colspan="2" height="20" align="center" valign="bottom" sdnum="1033;0;@"><font face="Arial" color="#000000">Observações:</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan="23" rowspan="3" align="center" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td style="border-bottom: 1px solid #000000" align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
	</tr>
	<tr>
		<td height="20" align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font face="Arial" color="#000000"><br></font></td>
		<td style="border-top: 1px solid #000000" colspan="9" align="center" valign="bottom"><font face="Arial" color="#000000">Assinatura do Professor</font></td>
		<td align="left" valign="bottom"><font color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font color="#000000"><br></font></td>
		<td align="left" valign="bottom"><font color="#000000"><br></font></td>
	</tr>
</tbody></table>
<br clear="left">
</div>
<!-- ************************************************************************** -->
<?php
			$priAula += $numDias;
		}
		$priAluno += $numAlunos;
	}
?>