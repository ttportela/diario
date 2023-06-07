<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ch')); ?>:</b>
	<?php echo CHtml::encode($data->ch); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('funcao')); ?>:</b>
	<?php echo CHtml::encode($data->funcao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('naies')); ?>:</b>
	<?php echo CHtml::encode($data->naies); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inclusao')); ?>:</b>
	<?php echo CHtml::encode($data->inclusao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('exclusao')); ?>:</b>
	<?php echo CHtml::encode($data->exclusao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('formacao')); ?>:</b>
	<?php echo CHtml::encode($data->formacao); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('telefone')); ?>:</b>
	<?php echo CHtml::encode($data->telefone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('projeto_id')); ?>:</b>
	<?php echo CHtml::encode($data->projeto_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('professor_id')); ?>:</b>
	<?php echo CHtml::encode($data->professor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aluno_id')); ?>:</b>
	<?php echo CHtml::encode($data->aluno_id); ?>
	<br />

	*/ ?>

</div>