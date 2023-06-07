<?php
class Multiselect extends CWidget
{
	
	public $form;
	public $model;
	public $attribute;
	public $data;
	public $htmlOptions = array();
	
    public function init()
    {
    	$path = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.multiselect', -1, false));
        $file= $path . '/assets/css/multi-select.css';
		Yii::app()->clientScript->registerCssFile($file);
        
        $file=$path.'/assets/js/jquery.multi-select.js';
        Yii::app()->clientScript->registerScriptFile($file);
        
        parent::init();
    }
	
	 /**
     * Run this widget.
     * renders the needed HTML code.
     */
    public function run() {
    	
		// array_merge($this->htmlOptions, array(
						// 'multiple'=>true, 
						// 'id'=>'multiselect-'.$this->attribute
					// ));
					
		$this->htmlOptions['multiple'] = true;
		$this->htmlOptions['mulidtiple'] = 'multiselect-'.$this->attribute;
		
        echo '<div>
				<legend>' . $this->form->labelEx($this->model,$this->attribute) . '</legend>'.
				$this->form->dropDownList($this->model, $this->attribute, $this->data,
					$this->htmlOptions
				) .
				$this->form->error($this->model,$this->attribute). '
			    <script language="javascript">$("#multiselect-'.$this->attribute.'").multiSelect();</script>
			  </div>';
    }
}