<?php
$this->breadcrumbs=array(
	'Turmas'=>array('index'),
	$model->nome,
);

?>

<h1>E-mails de Turma: <?php echo $model->nome; ?></h1>
<hr/>
<?php

foreach ($model->alunos as $aluno) {
	if (isset($aluno->email) && !empty(trim($aluno->email)))
		echo $aluno->email . ',<br/>';
}

?>