<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nome')); ?>:</b>
	<?php echo CHtml::encode($data->nome); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('conteudo')); ?>:</b>
	<?php echo CHtml::encode($data->conteudo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('observacoes')); ?>:</b>
	<?php echo CHtml::encode($data->observacoes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data')); ?>:</b>
	<?php echo CHtml::encode($data->aletrado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('documento_id')); ?>:</b>
	<?php echo CHtml::encode($data->documento_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('criador_id')); ?>:</b>
	<?php echo CHtml::encode($data->criador_id); ?>
	<br />


</div>