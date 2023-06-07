<?php

$pageName = 'Avaliações';

include_once '_report_header.php';

if (isset($turma)) {
	
	echo $this->renderPartial('_avaliacoes', array('turma' => $turma, 'lsdiarios'=>$lsdiarios, 'lsalunos'=>$lsalunos));

} ?>