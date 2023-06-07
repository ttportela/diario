<?php
$this->breadcrumbs=array(
	'Documentos'=>array('documento/index'),
	$model->nome=>array('documento/view', 'id'=>$model->documento->id),
	'Versões Anteriores'
);

/*$this->menu=array(
	array('label'=>'Cadastrar DocumentoHistorico','url'=>array('create')),
	array('label'=>'Gerenciar DocumentoHistorico','url'=>array('admin')),
);*/


/*Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('documento-historico-grid', {
		data: $(this).serialize()
	});
	return false;
});
");*/
?>

<div class="page-header">
  <h1><?php echo $doc->nome; ?> <small>Histórico do Documento</small></h1>
</div>

<!-- <p>
Você pode, opcionalmente, incluir um operador de comparação (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
ou <b>=</b>) antes de cada campo de pesquisa.
</p> 

<?php echo CHtml::link('Pesquisa Avançada','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'documento-historico-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		// array(
			// //'header'=>'nome',
            // 'type'=>'raw',
            // 'name'=>'nome',
			// 'value'=>'str_replace(PHP_EOL, "<br />", $data->documento->nome)',
			// 'htmlOptions' => array('max-width' => '30%'),
		// ),
		// array(
			// //'header'=>'conteudo',
            // 'type'=>'raw',
            // 'name'=>'conteudo',
			// 'value'=>'str_replace(PHP_EOL, "<br />", $data->conteudo)',
			// 'htmlOptions' => array('max-width' => '30%'),
		// ),
		array(
			//'header'=>'aletrado',
            'name'=>'data',
			'value'=>'Yii::app()->getDateFormatter()->format("dd/MM/yyyy HH:mm:ss",strtotime($data->data))',
			'htmlOptions' => array('style' => 'text-align:center;'),
		),
		// array(
			// //'header'=>'documento_id',
            // 'name'=>'documento_id',
			// 'value'=>'$data->documento->toString()',
		// ),
		array(
			//'header'=>'criador_id',
            'name'=>'criador_id',
			'value'=>'$data->criador->toString()',
		),
		array(
			//'header'=>'observacoes',
            'type'=>'raw',
            'name'=>'observacoes',
			'value'=>'str_replace(PHP_EOL, "<br />", $data->observacoes)',
			'htmlOptions' => array('max-width' => '40%'),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}{delete}{restore}{print}',
			'htmlOptions' => array('width' => '70px'),
			'buttons'=>array(
	        	'restore'=>array(
	                'label'=>'Restaurar',
	                'icon' => 'icon-repeat',
	                'url'=>'Yii::app()->createUrl("dochistorico/restaurar", array("id"=>$data->id))',
	            ),
	            'print'=>array(
	                'label'=>'Imprimir',
	                'icon' => 'icon-print',
	                'options' => array("target"=>"_blank"),
	                'url'=>'Yii::app()->createUrl("dochistorico/view", array("id"=>$data->id, "print"=>1))',
	            ),
	        ),
		),
	),
)); ?>
