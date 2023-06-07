<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nome')); ?>:</b>
	<?php echo CHtml::encode($data->nome); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ano')); ?>:</b>
	<?php echo CHtml::encode($data->ano); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('semestre')); ?>:</b>
	<?php echo CHtml::encode($data->semestre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('classe')); ?>:</b>
	<?php echo CHtml::encode($data->classe); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chrelogio')); ?>:</b>
	<?php echo CHtml::encode($data->chrelogio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chaula')); ?>:</b>
	<?php echo CHtml::encode($data->chaula); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('horarios')); ?>:</b>
	<?php echo CHtml::encode($data->horarios); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('observacoes')); ?>:</b>
	<?php echo CHtml::encode($data->observacoes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('professor_id')); ?>:</b>
	<?php echo CHtml::encode($data->professor->nome); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('disciplina_id')); ?>:</b>
	<?php echo CHtml::encode($data->disciplina->nome); ?>
	<br />

</div>