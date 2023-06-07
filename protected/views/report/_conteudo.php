<style type="text/css">
	table.tb-cont-all {
	  border-collapse: collapse;
	  table-layout:fixed;
	  float: left;
	  width: 50%;
	}
	
	table.tb-cont-2 {
		border-left: none;
	}
	
	.tb-cont-all {
		border: 1px solid;
		font-size: 10pt;
	}
	
	th.tb-cont-col1 {	
		width: 5%;
		text-align: center;
	}
	
	th.tb-cont-col2 {	
		width: 8%;
		text-align: center;
	}
	
	th.tb-cont-col3 {	
		width: 28%;
	}
	
	th.tb-cont-col4 {	
		width: 8%;
	}
	
	td.tb-cont-all {
		font-weight: normal;
		text-align: center;
		height: 34px;
		overflow: hidden;
	}
	
	td.tb-cont-assunto {
		text-align: left;
		font-size: 8pt;
	}
	
	th.tb-cont-all, td.tb-cont-all {	
	    padding-bottom: 1px;
	    padding-left: 1px;
	    padding-right: 1px;
	    padding-top: 1px;
		height: 24px;
		overflow: hidden;
	}
</style>
<?php
	
	$diarios = array();

	foreach ($lsdiarios as $d) {
		for ($i=1; $i <= $d->aulas; $i++) {
			array_push($diarios, $d);
		}
	}
	
	$numAulas = 17;
	$ct = 1;
	
	$dir = false;
	while ($ct <= count($diarios)) {
		
		if ($ct != 1) {?> <div style="page-break-after: always"></div><?php } ?>
		
		<div class="container-report">
		<?php echo $this->renderPartial('_cabecalho-IFPR', array('turma'=>$turma)); ?>
		<table class="tb-cabecalho">
			<tbody>
			<tr>
				<th>Curso</th>
				<th>Disciplina</th>
				<th>Classe</th>
				<th>Período Letivo</th>
				<th>Carga Horária</th>
			</tr>
			<tr>
				<td><?php echo $turma->disciplina->curso->nome;?></td>
				<td><?php echo $turma->disciplina->nome;?></td>
				<td><?php echo $turma->classe; ?></td>
				<td><?php echo $turma->ano . '-' . $turma->semestre;?></td>
				<td><?php echo $turma->chrelogio;?></td>
			</tr>
		</tbody></table>
		<?php
		
		for ($j=1; $j <=2; $j++) {
			?>
			<table class="tb-cont-all tb-cont-<?php echo $j; ?>">
				<tr class="tb-cont-all">
					<th class="tb-cont-all tb-cont-col1">Aula</th>
					<th class="tb-cont-all tb-cont-col2">Dia/Mês</th>
					<th class="tb-cont-all tb-cont-col3">Assunto</th>
					<th class="tb-cont-all tb-cont-col4">Rubrica</th>
				</tr>
			<?php  
			for ($i = 1 ; $i <= $numAulas; $i++) {
				
				if (isset($diarios[$ct-1])) {
					$d = $diarios[$ct-1];
					?>
						<tr class="tb-cont-all">
							<td class="tb-cont-all"><?php echo $ct++; ?></td>
							<td class="tb-cont-all"><?php echo Yii::app()->getDateFormatter()->format("dd/MM",strtotime($d->data)); ?></td>
							<td class="tb-cont-all tb-cont-assunto"><?php echo $d->conteudo; ?></td>
							<td class="tb-cont-all"> </td>
						</tr>
						<!-- <tr class="tb-cont-all">
							<td class="tb-cont-all tb-cont-assunto"><?php echo substr($d->conteudo, 44, 88); ?></td>
						</tr> -->
					<?php
				} else {
					?>
						<tr class="tb-cont-all">
							<td class="tb-cont-all"><?php echo $ct++; ?></td>
							<td class="tb-cont-all"></td>
							<td class="tb-cont-all tb-cont-assunto"></td>
							<td class="tb-cont-all"> </td>
						</tr>
						<!-- <tr class="tb-cont-all">
							<td class="tb-cont-all"> </td>
						</tr> -->
					<?php
				}
			}
			?>
			</table>
			<?php
		}
		?><!-- <div style="clear: both"></div> -->
		</div>
		<!-- <div style="page-break-after: always"></div> -->
<?php } ?>