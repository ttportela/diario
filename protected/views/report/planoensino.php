<page>
<?php

$pageName = 'Plano de Ensino';

include_once '_report_header.php';

if (isset($turma)) {
	
	$this->pageTitle = $turma->ano.'-'.$turma->semestre.' - '.$pageName.' - '.$turma->disciplina->nome;
	
?>

<style type="text/css">
	table th {
		text-align: left;
	}
	
	p {
		line-height: 150%;
	}
</style>

<div class="container-report">

<div class="page-header">
  <h2 style="text-align: center; border: 1px solid black; background: rgb(227, 227, 227);">PLANO DE ENSINO</h2>
</div>

<div class="page-header">
  <h3>1. DADOS DE INDENTIFICAÇÃO</h3>
</div>

<table>
	<tr>
		<th>1.1. INSTITUIÇÃO</th>
		<td><?php echo mb_strtoupper($turma->disciplina->curso->instituicao->nome); ?></td>
	</tr>
	<tr>
		<th>1.2. CURSO</th>
		<td><?php echo mb_strtoupper($turma->disciplina->curso->nome); ?></td>
	</tr>
	<tr>
		<th>1.3. ANO</th>
		<td><?php echo $turma->ano; ?></td>
	</tr>
	<tr>
		<th>1.4. SEMESTRE</th>
		<td><?php echo $turma->semestre . 'º'; ?></td>
	</tr>
	<tr>
		<th>1.5. PERÍODO</th>
		<td><?php echo $turma->disciplina->periodo . 'º'; ?></td>
	</tr>
	<tr>
		<th>1.6. DISCIPLINA</th>
		<td><?php echo mb_strtoupper($turma->disciplina->nome); ?></td>
	</tr>
	<tr>
		<th>1.7. CARGA HORÁRIA</th>
		<td><?php echo $turma->chrelogio . ' h - ' . ($turma->chaula/20) . ' créditos – ' . $turma->chaula . ' h/a'; ?></td>
	</tr>
	<tr>
		<th>1.8. PROFESSOR</th>
		<td><?php echo mb_strtoupper($turma->professor->nome); ?></td>
	</tr>
</table>

<div style="text-align: justify;">
<div class="page-header">
  <h3>2. EMENTA</h3>
</div>
<?php echo ($turma->disciplina->ementa); ?>


<div class="page-header">
  <h3>3. OBJETIVOS</h3>
</div>

<h3>3.1. Gerais</h3>
<?php echo ($turma->objetivosgerais); ?>

<h3>3.2. Específicos</h3>
<?php echo ($turma->objetivosespecificos); ?>


<div class="page-header">
  <h3>4. CONTEÚDO PROGRAMÁTICO</h3>
</div>
<?php echo ($turma->conteudo); ?>


<div class="page-header">
  <h3>5. METODOLOGIA</h3>
</div>
<?php echo ($turma->metodologia); ?>


<div class="page-header">
  <h3>6. RECURSOS DIDÁTICOS</h3>
</div>
<?php echo ($turma->recursos); ?>


<div class="page-header">
  <h3>7. BIBLIOGRAFIA</h3>
</div>

<h3>7.1. Bibliografia Básica</h3>
<?php echo ($turma->disciplina->bibbasica); ?>

<h3>7.2. Bibliografia Complementar</h3>
<?php echo ($turma->bibcomplementar); ?>

</div>

<br/><br/><br/>
<div style="text-align: center;">
	<b><u><?php for ($ct = 0; $ct < strlen($turma->professor->nome)*2; $ct++) echo '&nbsp;'; ?></u></b><br/>
	<b><?php echo mb_strtoupper($turma->professor->nome); ?></b><br/>
	SIAPE: <?php echo mb_strtoupper($turma->professor->siape); ?>
</div>

</div>
</page>
<?php } ?>