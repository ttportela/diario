<?php

$pageName = 'Conteúdo';

include_once '_report_header.php';

if (isset($turma)) {
	
	echo $this->renderPartial('_conteudo', array('turma' => $turma, 'lsdiarios'=>$lsdiarios));

} ?>