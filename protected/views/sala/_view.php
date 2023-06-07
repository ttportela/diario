<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descricao')); ?>:</b>
	<?php echo CHtml::encode($data->descricao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('responsavel_instituicao_id')); ?>:</b>
	<?php echo CHtml::encode($data->responsavel_instituicao_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('responsavel_curso_id')); ?>:</b>
	<?php echo CHtml::encode($data->responsavel_curso_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('responsavel_usuario_id')); ?>:</b>
	<?php echo CHtml::encode($data->responsavel_usuario_id); ?>
	<br />


</div>