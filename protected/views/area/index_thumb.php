<?php
$this->breadcrumbs=array(
	Yii::t('model', 'model.area', 2)=>array('index'),
	Yii::t('app', 'app.crud.label.index'),
);

/*$this->menu=array(
	array('label'=>'','url'=>array('index'), 'icon'=>'fa fa-th-list', 'itemOptions'=>array('title'=>Yii::t('app', 'app.crud.label.index'))),
	array('label'=>'','url'=>array('create'), 'icon'=>'fa fa-plus', 'itemOptions'=>array('title'=>Yii::t('app', 'app.crud.label.create'))),
);*/

/*$this->menu=array(
	array('label'=>Yii::t('app', 'app.crud.label.index'),'url'=>array('index')),
	array('label'=>Yii::t('app', 'app.crud.label.create'),'url'=>array('create')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('area-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<style type="text/css">
.glyphicon { margin-right:5px; }
.thumbnail
{
    margin-bottom: 20px;
    padding: 0px;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    border-radius: 0px;
}

.item.list-group-item
{
    float: none;
    width: 100%;
    background-color: #fff;
    margin-bottom: 10px;
}
.item.list-group-item:nth-of-type(odd):hover,.item.list-group-item:hover
{
    background: #428bca;
}

.item.list-group-item .list-group-image
{
    margin-right: 10px;
}
.item.list-group-item .thumbnail
{
    margin-bottom: 0px;
}
.item.list-group-item .caption
{
    padding: 9px 9px 0px 9px;
}
.item.list-group-item:nth-of-type(odd)
{
    background: #eeeeee;
}

.item.list-group-item:before, .item.list-group-item:after
{
    display: table;
    content: " ";
}

.item.list-group-item img
{
    float: left;
}
.item.list-group-item:after
{
    clear: both;
}
.list-group-item-text
{
    margin: 0 0 11px;
}
</style>

<div class="page-header">
  <h3><?php echo Yii::t('model', 'model.area', 2); ?>  <small><?php echo Yii::t('app', 'app.crud.label.index'); ?></small></h3>
</div>

<?php echo CHtml::link(Yii::t('app', 'app.crud.label.advancedsearch'),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">

<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php  $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_view',
)); ?>
