<?php

$pageName = 'Frequência';

include_once '_report_header.php';

if (isset($turma)) {
	
	echo $this->renderPartial('_frequencia-folha', array('turma'=>$turma, 'lsdiarios'=>$lsdiarios, 'lsalunos'=>$lsalunos));

 } ?>