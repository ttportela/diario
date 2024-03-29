<?php
/**
 * TbActiveForm class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 */

Yii::import('bootstrap.widgets.input.TbInput');

/**
 * Bootstrap active form widget.
 */
class TbActiveForm extends CActiveForm
{
	// Form types.
	const TYPE_VERTICAL = 'vertical';
	const TYPE_INLINE = 'inline';
	const TYPE_HORIZONTAL = 'horizontal';
	const TYPE_SEARCH = 'search';

	// Input classes.
	const INPUT_HORIZONTAL = 'bootstrap.widgets.input.TbInputHorizontal';
	const INPUT_INLINE = 'bootstrap.widgets.input.TbInputInline';
	const INPUT_SEARCH = 'bootstrap.widgets.input.TbInputSearch';
	const INPUT_VERTICAL = 'bootstrap.widgets.input.TbInputVertical';

	/**
	 * @var string the form type. See class constants.
	 */
	public $type = self::TYPE_VERTICAL;
	/**
	 * @var string input class.
	 */
	public $input;
	/**
	 * @var boolean indicates whether to display errors as blocks.
	 */
	public $inlineErrors;

	/**
	 * Initializes the widget.
	 * This renders the form open tag.
	 */
	public function init()
	{
		if (!isset($this->htmlOptions['class']))
			$this->htmlOptions['class'] = 'form-'.$this->type;
		else
			$this->htmlOptions['class'] .= ' form-'.$this->type;

		if (!isset($this->inlineErrors))
			$this->inlineErrors = $this->type === self::TYPE_HORIZONTAL;

		if ($this->inlineErrors)
			$this->errorMessageCssClass = 'help-inline error';
		else
			$this->errorMessageCssClass = 'help-block error';

		parent::init();
	}

	/**
	 * Renders a text field input row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 */
	public function header($title, $description, $size = 1)
	{
		return  '<div class="page-header">'.
				'	<h'.$size.'>'.$title.' '.(isset($description)? '<small>'.$description.'</small>':'').'</h'.$size.'>'.
				'</div>';
	}

	/**
	 * Renders a checkbox input row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 */
	public function checkBoxRow($model, $attribute, $htmlOptions = array())
	{
		return $this->inputRow(TbInput::TYPE_CHECKBOX, $model, $attribute, null, $htmlOptions);
	}

	/**
	 * Renders a checkbox list input row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data the list data
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 */
	public function checkBoxListRow($model, $attribute, $data = array(), $htmlOptions = array())
	{
		return $this->inputRow(TbInput::TYPE_CHECKBOXLIST, $model, $attribute, $data, $htmlOptions);
	}

	/**
	 * Renders a checkbox list inline input row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data the list data
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 */
	public function checkBoxListInlineRow($model, $attribute, $data = array(), $htmlOptions = array())
	{
		return $this->inputRow(TbInput::TYPE_CHECKBOXLIST_INLINE, $model, $attribute, $data, $htmlOptions);
	}
	
	public function dateRow($model, $attribute, $htmlOptions = array(), $mask='dd/mm/yyyy')
	{
		if (isset($htmlOptions['value']))
			$date = $htmlOptions['value'];
		else {
			$date = date("Y-m-d",strtotime($model->isNewRecord? date('d-m-Y') : $model->$attribute));
		}
		$widget=$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				    // 'name'=>'acquisition_date',//CHtml::activeName($model, 'acquisition'),
				    'model'=>$model,
				    // 'flat'=>true,//remove to hide the datepicker
				    'attribute'=>$attribute,
				    // 'value'=>$date,
				    'options'=>array(
				    	'dateFormat' => 'yy-mm-dd',
				    	// 'dateFormat' => 'dd/mm/yy',
				        'showAnim'=>'fold',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
				        // 'altField'=>'#acquisition_date', // The jQuery selector of the "target" field
		        		// 'altFormat'=>'dd/mm/yy', // If you want the target field to have a different format
				    ),
				    'htmlOptions'=>array(
				        'style'=>'',
				        'class'=>'span5 form-control',
				        // 'aria-describedby'=>'basic-addon-'.$attribute,
				        'value'=>$date,
				        // 'name'=>CHtml::activeName($model, 'acquisition'),
				    ),
				), true);
		return //'<div class="control-group ">'.
			$this->labelEx($model, $attribute, array('class' => 'control-label')).
			'<div class="input-group">'.
			$widget .
			'<span class="input-group-addon" id="basic-addon-'.$attribute.'" style="padding-left: 25px;">'.$mask.'</span>'.
			'</div>'.
			$this->error($model, $attribute);
	}
	
	public function dateTimeRow($model, $attribute, $htmlOptions = array(), $mask='dd/mm/yyyy HH:mm')
	{
		if (isset($htmlOptions['value']))
			$date = $htmlOptions['value'];
		else {
			$date = date("Y-m-d",strtotime($model->isNewRecord? date('d-m-Y') : $model->$attribute));
		}
		$widget=$this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
				    // 'name'=>'acquisition_date',//CHtml::activeName($model, 'acquisition'),
				    'model'=>$model,
				    // 'flat'=>true,//remove to hide the datepicker
				    'attribute'=>$attribute,
				    'mode'=>'datetime',
				    // 'value'=>$date,
				    'options'=>array(
				    	// 'mode'=>'datetime',
				    	'dateFormat'=>'yy-mm-dd', 
                        // 'altFormat'=>'dd-mm-yy',
				    	// // 'dateFormat' => 'dd/mm/yy',
				        // 'showAnim'=>'fold',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
				        // // 'altField'=>'#acquisition_date', // The jQuery selector of the "target" field
		        		// // 'altFormat'=>'dd/mm/yy', // If you want the target field to have a different format
				    ),
				    'htmlOptions'=>array(
				        'style'=>'',
				        'class'=>'span5 form-control',
				        // 'aria-describedby'=>'basic-addon-'.$attribute,
				        // 'value'=>$date,
				        // 'name'=>CHtml::activeName($model, 'acquisition'),
				    ),
				), true);
		return //'<div class="control-group ">'.
			$this->labelEx($model, $attribute, array('class' => 'control-label')).
			'<div class="input-group">'.
			$widget .
			'<span class="input-group-addon" id="basic-addon-'.$attribute.'" style="padding-left: 25px;">'.$mask.'</span>'.
			'</div>'.
			$this->error($model, $attribute);
	}
	
	// public function datetimeRow($model, $attribute, $controller, $htmlOptions = array())
	// {
		// $date = date("d/m/Y H:i:s",strtotime($model->isNewRecord? date('m/d/Y H:i:s') : $model->$attribute));
		// $widget=$this->widget('zii.widgets.jui.CJuiDatePicker',array(
				    // // 'name'=>'acquisition_date',//CHtml::activeName($model, 'acquisition'),
				    // 'model'=>$model,
				    // // 'flat'=>true,//remove to hide the datepicker
				    // 'attribute'=>$attribute,
				    // 'options'=>array(
				    	// 'dateFormat' => 'dd/mm/yy h:i:s',
				        // 'showAnim'=>'fold',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
				        // // 'altField'=>'#acquisition_date', // The jQuery selector of the "target" field
		        		// // 'altFormat'=>'yy-mm-dd', // If you want the target field to have a different format
				    // ),
				    // 'htmlOptions'=>array(
				        // 'style'=>'',
				        // 'class'=>'span5 form-control',
				        // // 'aria-describedby'=>'basic-addon-'.$attribute,
				        // 'value'=>$date,
				        // // 'name'=>CHtml::activeName($model, 'acquisition'),
				    // ),
				// ), true);
		// return //'<div class="control-group ">'.
			// $this->labelEx($model, $attribute, array('class' => 'control-label')).
			// '<div class="input-group">'.
			// $widget .
			// '<span class="input-group-addon" id="basic-addon-'.$attribute.'" style="padding-left: 25px;">dd/mm/yyyy hh:mm:ss</span>'.
			// '</div>'.
			// $this->error($model, $attribute);
	// }

	/**
	 * Renders a drop-down list input row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data the list data
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 *
	public function dropDownListRow($model, $attribute, $data = array(), $htmlOptions = array())
	{
		return $this->inputRow(TbInput::TYPE_DROPDOWN, $model, $attribute, $data, $htmlOptions);
	}*/

	/**
	 * Renders a drop-down list input row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data the list data
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 */
	public function dropDownListRow($model, $attribute, $data = array(), $htmlOptions = array())
	{
		return 
		'<div>'.
			'<small>'.$this->labelEx($model,$attribute).'</small>'.
			$this->dropDownList($model, $attribute, $data, $htmlOptions).
			$this->error($model,$attribute).
		'</div><br/>';
	}
	
	public function selectorRow($model, $attribute, $value, $display, $provider, $htmlOptions=null, $showLabel=true)
	{
		//Yii::app()->helper->trace($create);
		return $this->widget('LookupDialog', array(
			'form'=>$this,
            'model'=>$model,
            'attribute'=>$attribute,
            'htmlOptions'=>$htmlOptions,
            'value'=>$value,
            'display'=>$display,
            'provider'=>$provider,
            'showLabel'=>$showLabel,
        ), true);
	}
	
	public function selectorMultipleRow($model, $attribute, $values, $provider, $htmlOptions=null)
	{
		//Yii::app()->helper->trace($create);
		return $this->widget('LookupMultipleDialog', array(
			'form'=>$this,
            'model'=>$model,
            'attribute'=>$attribute,
            'htmlOptions'=>$htmlOptions,
            'values'=>$values,
            // 'display'=>$display,
            'provider'=>$provider,
        ), true);
	}

	/**
	 * Renders a file field input row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 */
	public function fileFieldRow($model, $attribute, $htmlOptions = array())
	{
		return $this->inputRow(TbInput::TYPE_FILE, $model, $attribute, null, $htmlOptions);
	}

	/**
	 * Renders a password field input row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 */
	public function passwordFieldRow($model, $attribute, $htmlOptions = array())
	{
		return $this->inputRow(TbInput::TYPE_PASSWORD, $model, $attribute, null, $htmlOptions);
	}

	/**
	 * Renders a radio button input row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 */
	public function radioButtonRow($model, $attribute, $htmlOptions = array())
	{
		return $this->inputRow(TbInput::TYPE_RADIO, $model, $attribute, null, $htmlOptions);
	}

	/**
	 * Renders a radio button list input row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data the list data
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 */
	public function radioButtonListRow($model, $attribute, $data = array(), $htmlOptions = array())
	{
		return $this->inputRow(TbInput::TYPE_RADIOLIST, $model, $attribute, $data, $htmlOptions);
	}

	/**
	 * Renders a radio button list inline input row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data the list data
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 */
	public function radioButtonListInlineRow($model, $attribute, $data = array(), $htmlOptions = array())
	{
		return $this->inputRow(TbInput::TYPE_RADIOLIST_INLINE, $model, $attribute, $data, $htmlOptions);
	}

	/**
	 * Renders a text field input row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 */
	public function textFieldRow($model, $attribute, $htmlOptions = array())
	{
		return $this->inputRow(TbInput::TYPE_TEXT, $model, $attribute, null, $htmlOptions);
	}

	/**
	 * Renders a text field input row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 */
	public function numberFieldRow($model, $attribute, $decimals = 2, $htmlOptions = array())
	{
		$model->$attribute = Yii::app()->format->formatNumber($model->$attribute,$decimals);
		if (isset($htmlOptions['class'])) {
			$htmlOptions['class'] .= ' mask-number_'.$decimals.'d';
		} else {
			$htmlOptions['class'] = ' mask-number_'.$decimals.'d';
		}
		return $this->inputRow(TbInput::TYPE_TEXT, $model, $attribute, null, $htmlOptions);
	}

	/**
	 * Renders a text field input row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 */
	public function moneyFieldRow($model, $attribute, $htmlOptions = array())
	{
		$model->$attribute = Yii::app()->format->formatCurrency($model->$attribute);
		if (isset($htmlOptions['class'])) {
			$htmlOptions['class'] .= ' mask-money form-control';
		} else {
			$htmlOptions['class'] = 'mask-money form-control';
		}
		// $htmlOptions['onsubmit'] .= '$($this).val($($this).mask())';
		return  $this->labelEx($model,$attribute,array()) .
				'<div class="input-group span5">'.
				  '<span class="input-group-addon">R$</span>'.
				  CHtml::activeTextField($model,$attribute,$htmlOptions).
				'</div>'.
				$this->error($model,$attribute);//$this->inputRow(TbInput::TYPE_TEXT, $model, $attribute, null, $htmlOptions);
	}

	/**
	 * Renders a text area input row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 */
	public function textAreaRow($model, $attribute, $htmlOptions = array())
	{
		return $this->inputRow(TbInput::TYPE_TEXTAREA, $model, $attribute, null, $htmlOptions);
	}

	public function editorRow($model, $attribute, $htmlOptions = array())
	{
		array_merge($htmlOptions, array('id'=>$attribute));
		
		return $this->inputRow(TbInput::TYPE_TEXTAREA, $model, $attribute, null, $htmlOptions) .
		"<script>
			CKEDITOR.replace( '" .CHTML::activeId($model,$attribute). "', {
				height: 260,
				toolbarGroups: [
					{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
					{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
					{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
					{ name: 'forms', groups: [ 'forms' ] },
					'/',
					{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
					{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
					{ name: 'links', groups: [ 'links' ] },
					{ name: 'insert', groups: [ 'insert' ] },
					'/',
					{ name: 'styles', groups: [ 'styles' ] },
					{ name: 'colors', groups: [ 'colors' ] },
					{ name: 'tools', groups: [ 'tools' ] },
					{ name: 'others', groups: [ 'others' ] },
					{ name: 'about', groups: [ 'about' ] }
				],
				removeButtons:'Save,NewPage,Templates,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Language,Flash,Iframe,About'
			} );
		</script><br/>";
	}

	/**
	 * Renders a captcha row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 * @since 0.9.3
	 */
	public function captchaRow($model, $attribute, $htmlOptions = array())
	{
		return $this->inputRow(TbInput::TYPE_CAPTCHA, $model, $attribute, null, $htmlOptions);
	}

	/**
	 * Renders an uneditable text field row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 * @since 0.9.5
	 *
	public function uneditableRow($model, $attribute, $htmlOptions = array())
	{
		return $this->inputRow(TbInput::TYPE_UNEDITABLE, $model, $attribute, null, $htmlOptions);
	}*/

	/**
	 * Renders an uneditable text field row.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 * @since 0.9.5
	 */
	public function uneditableRow($model, $attribute, $value, $htmlOptions = array())
	{
		$htmlOptions['disabled'] = 'true';
		return //$this->inputRow(TbInput::TYPE_TEXT, $model, $attribute, null, $htmlOptions);
		'<div>'.
			'<small>'.$this->labelEx($model,$attribute).'</small>'.
			CHtml::textField($attribute, $value, $htmlOptions).
			$this->error($model,$attribute).
		'</div>';
	}

	/**
	 * Renders a checkbox list for a model attribute.
	 * This method is a wrapper of {@link CHtml::activeCheckBoxList}.
	 * Please check {@link CHtml::activeCheckBoxList} for detailed information
	 * about the parameters for this method.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data value-label pairs used to generate the check box list.
	 * @param array $htmlOptions additional HTML options.
	 * @return string the generated check box list
	 * @since 0.9.5
	 */
	public function checkBoxList($model, $attribute, $data, $htmlOptions = array())
	{
		return $this->inputsList(true, $model, $attribute, $data, $htmlOptions);
	}

	/**
	 * Renders a radio button list for a model attribute.
	 * This method is a wrapper of {@link CHtml::activeRadioButtonList}.
	 * Please check {@link CHtml::activeRadioButtonList} for detailed information
	 * about the parameters for this method.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data value-label pairs used to generate the radio button list.
	 * @param array $htmlOptions additional HTML options.
	 * @return string the generated radio button list
	 * @since 0.9.5
	 */
	public function radioButtonList($model, $attribute, $data, $htmlOptions = array())
	{
		return $this->inputsList(false, $model, $attribute, $data, $htmlOptions);
	}

	/**
	 * Renders an input list.
	 * @param boolean $checkbox flag that indicates if the list is a checkbox-list.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data value-label pairs used to generate the input list.
	 * @param array $htmlOptions additional HTML options.
	 * @return string the generated input list.
	 * @since 0.9.5
	 */
	protected function inputsList($checkbox, $model, $attribute, $data, $htmlOptions = array())
	{
		CHtml::resolveNameID($model, $attribute, $htmlOptions);
		$select = CHtml::resolveValue($model, $attribute);

		if ($model->hasErrors($attribute))
		{
			if (isset($htmlOptions['class']))
				$htmlOptions['class'] .= ' '.CHtml::$errorCss;
			else
				$htmlOptions['class'] = CHtml::$errorCss;
		}

		$name = $htmlOptions['name'];
		unset($htmlOptions['name']);

		if (array_key_exists('uncheckValue', $htmlOptions))
		{
			$uncheck = $htmlOptions['uncheckValue'];
			unset($htmlOptions['uncheckValue']);
		}
		else
			$uncheck = '';

		$hiddenOptions = isset($htmlOptions['id']) ? array('id' => CHtml::ID_PREFIX.$htmlOptions['id']) : array('id' => false);
		$hidden = $uncheck !== null ? CHtml::hiddenField($name, $uncheck, $hiddenOptions) : '';

		if (isset($htmlOptions['template']))
			$template = $htmlOptions['template'];
		else
			$template = '<label class="{labelCssClass}">{input}{label}</label>';

		unset($htmlOptions['template'], $htmlOptions['separator'], $htmlOptions['hint']);

		if ($checkbox && substr($name, -2) !== '[]')
			$name .= '[]';

		unset($htmlOptions['checkAll'], $htmlOptions['checkAllLast']);

		$labelOptions = isset($htmlOptions['labelOptions']) ? $htmlOptions['labelOptions'] : array();
		unset($htmlOptions['labelOptions']);

		$items = array();
		$baseID = CHtml::getIdByName($name);
		$id = 0;
		$method = $checkbox ? 'checkBox' : 'radioButton';
		$labelCssClass = $checkbox ? 'checkbox' : 'radio';

		if (isset($htmlOptions['inline']))
		{
			$labelCssClass .= ' inline';
			unset($htmlOptions['inline']);
		}

		foreach ($data as $value => $label)
		{
			$checked = !is_array($select) && !strcmp($value, $select) || is_array($select) && in_array($value, $select);
			$htmlOptions['value'] = $value;
			$htmlOptions['id'] = $baseID.'_'.$id++;
			$option = CHtml::$method($name, $checked, $htmlOptions);
			$label = CHtml::label($label, $htmlOptions['id'], $labelOptions);
			$items[] = strtr($template, array(
				'{labelCssClass}' => $labelCssClass,
				'{input}' => $option,
				'{label}' => $label,
			));
		}

		return $hidden.implode('', $items);
	}

	/**
	 * Displays a summary of validation errors for one or several models.
	 * This method is very similar to {@link CHtml::errorSummary} except that it also works
	 * when AJAX validation is performed.
	 * @param mixed $models the models whose input errors are to be displayed. This can be either
	 * a single model or an array of models.
	 * @param string $header a piece of HTML code that appears in front of the errors
	 * @param string $footer a piece of HTML code that appears at the end of the errors
	 * @param array $htmlOptions additional HTML attributes to be rendered in the container div tag.
	 * @return string the error summary. Empty if no errors are found.
	 * @see CHtml::errorSummary
	 */
	public function errorSummary($models, $header = null, $footer = null, $htmlOptions = array())
	{
		if (!isset($htmlOptions['class']))
			$htmlOptions['class'] = 'alert alert-block alert-error'; // Bootstrap error class as default

		return parent::errorSummary($models, $header, $footer, $htmlOptions);
	}

	/**
	 * Displays the first validation error for a model attribute.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute name
	 * @param array $htmlOptions additional HTML attributes to be rendered in the container div tag.
	 * @param boolean $enableAjaxValidation whether to enable AJAX validation for the specified attribute.
	 * @param boolean $enableClientValidation whether to enable client-side validation for the specified attribute.
	 * @return string the validation result (error display or success message).
	 */
	public function error($model, $attribute, $htmlOptions = array(), $enableAjaxValidation = true, $enableClientValidation = true)
	{
		if (!$this->enableAjaxValidation)
			$enableAjaxValidation = false;

		if (!$this->enableClientValidation)
			$enableClientValidation = false;

		if (!isset($htmlOptions['class']))
			$htmlOptions['class'] = $this->errorMessageCssClass;

		if (!$enableAjaxValidation && !$enableClientValidation)
			return $this->renderError($model, $attribute, $htmlOptions);

		$id = CHtml::activeId($model,$attribute);
		$inputID = isset($htmlOptions['inputID']) ? $htmlOptions['inputID'] : $id;
		unset($htmlOptions['inputID']);
		if (!isset($htmlOptions['id']))
			$htmlOptions['id'] = $inputID.'_em_';

		$option = array(
			'id'=>$id,
			'inputID'=>$inputID,
			'errorID'=>$htmlOptions['id'],
			'model'=>get_class($model),
			'name'=>CHtml::resolveName($model, $attribute),
			'enableAjaxValidation'=>$enableAjaxValidation,
			'inputContainer'=>'div.control-group', // Bootstrap requires this
		);

		$optionNames = array(
			'validationDelay',
			'validateOnChange',
			'validateOnType',
			'hideErrorMessage',
			'inputContainer',
			'errorCssClass',
			'successCssClass',
			'validatingCssClass',
			'beforeValidateAttribute',
			'afterValidateAttribute',
		);

		foreach ($optionNames as $name)
		{
			if (isset($htmlOptions[$name]))
			{
				$option[$name] = $htmlOptions[$name];
				unset($htmlOptions[$name]);
			}
		}

		if ($model instanceof CActiveRecord && !$model->isNewRecord)
			$option['status'] = 1;

		if ($enableClientValidation)
		{
			$validators = isset($htmlOptions['clientValidation']) ? array($htmlOptions['clientValidation']) : array();

			$attributeName = $attribute;
			if (($pos = strrpos($attribute, ']')) !== false && $pos !== strlen($attribute) - 1) // e.g. [a]name
				$attributeName = substr($attribute, $pos + 1);

			foreach ($model->getValidators($attributeName) as $validator)
			{
				if ($validator->enableClientValidation)
					if (($js = $validator->clientValidateAttribute($model, $attributeName)) != '')
						$validators[] = $js;
			}

			if ($validators !== array())
				$option['clientValidation'] = "js:function(value, messages, attribute) {\n".implode("\n", $validators)."\n}";
		}

		$html = $this->renderError($model, $attribute, $htmlOptions);

		if ($html === '')
		{
			if (isset($htmlOptions['style']))
				$htmlOptions['style'] = rtrim($htmlOptions['style'], ';').'; display: none';
			else
				$htmlOptions['style'] = 'display: none';

			$html = CHtml::tag('span', $htmlOptions, '');
		}

		$this->attributes[$inputID] = $option;

		return $html;
	}

	/**
	 * Displays the first validation error for a model attribute.
	 * @param CModel $model the data model
	 * @param string $attribute the attribute name
	 * @param array $htmlOptions additional HTML attributes to be rendered in the container div tag.
	 * @return string the error display. Empty if no errors are found.
	 * @see CModel::getErrors
	 * @see errorMessageCss
	 */
	protected static function renderError($model, $attribute, $htmlOptions = array())
	{
		CHtml::resolveName($model, $attribute); // turn [a][b]attr into attr
		$error = $model->getError($attribute);
		return $error != '' ? CHtml::tag('span', $htmlOptions, $error) : '';
	}

	/**
	 * Creates an input row of a specific type.
	 * @param string $type the input type
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data the data for list inputs
	 * @param array $htmlOptions additional HTML attributes
	 * @return string the generated row
	 */
	public function inputRow($type, $model, $attribute, $data = null, $htmlOptions = array())
	{
		ob_start();
		$this->getOwner()->widget($this->getInputClassName(), array(
            'form'=>$this,
            'type'=>$type,
			'model'=>$model,
			'attribute'=>$attribute,
			'data'=>$data,
			'htmlOptions'=>$htmlOptions,
		));
		return ob_get_clean();
	}

	/**
	 * Returns the input widget class name suitable for the form.
	 * @return string the class name
	 */
	protected function getInputClassName()
	{
		if (isset($this->input))
			return $this->input;
		else
		{
			switch ($this->type)
			{
				case self::TYPE_HORIZONTAL:
					return self::INPUT_HORIZONTAL;
					break;

				case self::TYPE_INLINE:
					return self::INPUT_INLINE;
					break;

				case self::TYPE_SEARCH:
					return self::INPUT_SEARCH;
					break;

				case self::TYPE_VERTICAL:
				default:
					return self::INPUT_VERTICAL;
					break;
			}
		}
	}
}
