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

	$modelos = DocumentoModelo::model()->search();//Yii::app()->helper->currentTurmas();

?>
<h3>Selecione o modelo:</h3>
<ul class="list-group"><?php
foreach ($modelos->getData() as $x) {
	$paramsAux = array('/' . $this->id . '/' . $this->action->id,'modelo_id'=>$x->id);
	if (isset($params)) { $paramsAux = array_merge($paramsAux, $params); }
	?><li class="list-group-item"><?php echo CHtml::link($x->nome, $paramsAux, array('target'=>(isset($targetBlank) && $targetBlank)? '_blank' : '_self')); ?></li><?php
}
?></ul>