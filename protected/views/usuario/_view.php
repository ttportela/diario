<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nome')); ?>:</b>
	<?php echo CHtml::encode($data->nome); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('senha')); ?>:</b>
	<?php echo CHtml::encode($data->senha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('papel')); ?>:</b>
	<?php echo CHtml::encode($data->papel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('professor_id')); ?>:</b>
	<?php echo CHtml::encode($data->professor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aluno_id')); ?>:</b>
	<?php echo CHtml::encode($data->aluno_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('instituicao_id')); ?>:</b>
	<?php echo CHtml::encode($data->instituicao_id); ?>
	<br />


</div>