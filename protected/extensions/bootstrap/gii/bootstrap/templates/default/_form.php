<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php \$form=\$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>false,
)); ?>\n"; ?>

	<p class="help-block">Campos com <span class="required">*</span> são obrigatórios.</p>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach($this->tableSchema->columns as $column)
{	
	if($column->autoIncrement)
		continue;
	
	// Removed: , array('class' => 'control-label')
	
	// var_dump($column);
	//var_dump($column->dbType == 'bool');
	
	if ($column->isForeignKey) {
		
		echo "\t<?php echo \$form->selectorRow(\$model,'".$column->name."', \$model->".$column->name.", \n". 
			"\t\t(Yii::app()->helper->set(\$model->".str_replace('_id', '', $column->name).")? \$model->".str_replace('_id', '', $column->name)."->toString():''),\n".
			"\t\t(".$this->getRelationModelClass($column->name)."::model()), null); ?>\n\n"; 
	
	} else if ($column->dbType == 'tinyint(1)' || $column->dbType == 'bool' || $column->dbType == 'boolean') {
		
		echo "\t<?php echo \$form->checkBoxRow(\$model, '".$column->name."'); ?>\n\n";
	
	} else if ((strpos($column->dbType, 'tinyint') !== false) || (strpos($column->dbType, 'mediumint') !== false)) {
		
		echo "\t<?php echo \$form->radioButtonListRow(\$model,'".$column->name."',array(/*
														  ".$this->modelClass."::\$COSNT_1=>'1', 
														  ".$this->modelClass."::\$COSNT_2=>'2'*/)); ?>\n\n";
	
	} else if ($column->dbType == 'int' && $column->size !== null) {
		
		echo "\t<?php echo \$form->numberFieldRow(\$model, '".$column->name."', 0, array( 'maxlength'=>".$column->size.")); ?>\n\n";
	
	} else if ($column->dbType == 'int') {
		
		echo "\t<?php echo \$form->numberFieldRow(\$model, '".$column->name."', 0, array('maxlength'=>9)); ?>\n\n";
	
	} else if (($column->dbType == 'decimal' && ($column->scale == '2' || $column->scale == '3')) || $column->dbType == 'double') {
		
		echo "\t<?php echo \$form->moneyFieldRow(\$model, '".$column->name."', array('class' => 'control-label')); \n" .
			 "\t\t// echo \$form->numberFieldRow(\$model, '".$column->name."', ".$column->scale."); ?><br/>\n\n";
	
	} else if ($column->dbType == 'decimal') {
		
		echo "\t<?php echo \$form->numberFieldRow(\$model, '".$column->name."', ".$column->scale."); ?>\n\n";
	
	} else if ($column->dbType == 'datetime') {
		
		echo "\t<?php echo \$form->dateTimeRow(\$model, '".$column->name."'); ?>\n\n"; 
	
	} else if ($column->dbType == 'date') {
		
		echo "\t<?php echo \$form->dateRow(\$model, '".$column->name."'); ?>\n\n";
	
	} else if ($column->dbType == 'text') {
		
		echo "\t<?php echo \$form->textFieldRow(\$model, '".$column->name."', array('maxlength'=>200)); ?>\n\n";
	
	} else if ($column->dbType == 'mediumtext') {
		
		echo "\t<?php echo \$form->textAreaRow(\$model, '".$column->name."'); ?>\n\n";
	
	} else if ($column->dbType == 'longtext') {
		
		echo "\t<?php echo \$form->editorRow(\$model, '".$column->name."'); ?>\n\n";
	
	} else {

?>
	<?php echo "<?php echo ".$this->generateActiveRow($this->modelClass,$column)."; ?>\n"; ?>

<?php
	}
}
?>
	<div class="form-actions">
		<?php echo "<?php \$this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>\$model->isNewRecord ? 'Criar' : 'Salvar',
		)); ?>\n"; ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
