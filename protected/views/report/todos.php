<?php

$pageName = 'Diário';

include_once '_report_header.php';

if (isset($turma)) {
	
	$this->pageTitle = $turma->ano.'-'.$turma->semestre.' - Diário de Classe - '.$turma->disciplina->nome;
	
	echo $this->renderPartial('_capa-folha', array('turma' => $turma));
	echo '<div style="page-break-after: always"></div>';
	echo $this->renderPartial('_frequencia-folha', array('turma'=>$turma, 'lsdiarios'=>$lsdiarios, 'lsalunos'=>$lsalunos));
	echo '<div style="page-break-after: always"></div>';
	echo $this->renderPartial('_conteudo', array('turma' => $turma, 'lsdiarios'=>$lsdiarios));
	echo '<div style="page-break-after: always"></div>';
	echo $this->renderPartial('_avaliacoes', array('turma' => $turma, 'lsdiarios'=>$lsdiarios, 'lsalunos'=>$lsalunos));

} ?>