<?php

$pageName = 'Capa';

include_once '_report_header.php';

if (isset($turma)) {
	
	echo $this->renderPartial('_capa-folha', array('turma' => $turma ));

} ?>