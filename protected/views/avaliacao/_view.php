<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nome')); ?>:</b>
	<?php echo CHtml::encode($data->nome); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bimestre')); ?>:</b>
	<?php echo CHtml::encode($data->bimestre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('peso')); ?>:</b>
	<?php echo CHtml::encode($data->peso); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notamaxima')); ?>:</b>
	<?php echo CHtml::encode($data->notamaxima); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('turma_id')); ?>:</b>
	<?php echo CHtml::encode($data->turma->nome); ?>
	<br />


</div>