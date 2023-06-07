<div class="form">
    <?php echo CHtml::beginForm(); ?>
    <div class="item-freq-<?php echo $counter ?>">
        <div class="row">
	        <?php echo CHtml::activeLabel($model,'aluno_id',array('class'=>'span5')); ?>
	        <?php echo CHtml::activeHiddenField($model,'aluno_id',array('class'=>'span5')) ?>
        </div>
        <div class="row">
	        <?php echo CHtml::activeLabel($model,'faltas',array('class'=>'span5')); ?>
	        <?php echo CHtml::activeTextField($model,'faltas',array('class'=>'span5')) ?>
        </div>
 
        <?php
        /*
         * Rest of the form fields should be rendered here, using CHtml::...
         */
        ?>
    </div>
 
    <?php CHtml::endForm(); ?>
</div>
