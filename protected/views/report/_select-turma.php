<style type="text/css">
	
	.list-group {
		padding-left: 0;
		margin-bottom: 20px;
		max-width: 400px;
	}
	
	.list-group-item:first-child {
		border-top-left-radius: 4px;
		border-top-right-radius: 4px;
	}
	
	.list-group-item {
		position: relative;
		display: block;
		padding: 10px 15px;
		margin-bottom: -1px;
		background-color: #fff;
		border: 1px solid #ddd;
	}
</style>

<?php

if (!isset($params)) $params = array();

$round = isset($_GET['round'])? ($_GET['round'] == '0'? false : true) : true;
if (isset($_GET['round']) && $_GET['round'] == '0') 	$params['round'] 		= '0';

	$turmas = Yii::app()->helper->currentTurmas();

?>
<h3>Selecione a Turma:</h3>
<ul class="list-group"><?php
foreach ($turmas as $turma) {
	$paramsAux = array('/' . $this->id . '/' . $this->action->id,'turma_id'=>$turma->id);
	if (isset($params)) { $paramsAux = array_merge($paramsAux, $params); }
	?><li class="list-group-item"><?php echo CHtml::link($turma->nome, $paramsAux, array('target'=>(isset($targetBlank) && $targetBlank)? '_blank' : '_self')); ?></li><?php
}
?></ul>