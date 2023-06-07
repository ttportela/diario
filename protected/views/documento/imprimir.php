<?php
$this->layout='report';

$date = date('YY-mm-dd');

$this->pageTitle = Yii::app()->format->date_ymd($date).' - '.$model->nome;

if (isset($model->modelo->cabecalho_id)) echo $model->modelo->cabecalho->conteudo;

echo $model->conteudo;

if (isset($model->modelo->rodape_id)) echo $model->modelo->rodape->conteudo; 

?>
