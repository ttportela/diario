<?php
class TextField extends DocumentField {
	
	const NAME = 'TEXTO';
	
	public function __construct() {
		$this->params = array(
			'tam'=>20,
			'txt'=>''
		);
	}
	
	// public $tam = 20;
	// public $txt = '';

	public static function getName() {
		return self::NAME;
	}
		
	// public function getParams() {
		// return array('tam'=>$this->tam, 'txt'=>$this->txt);
	// }
// 	
	// public function setParams($params) {
		// $this->tam = $params['tam'];
		// $this->txt = $params['txt'];
	// }
	
	public function formField($form) {
		return $form->textFieldRow($this->model,$this->getFormName(), 
			array('class'=>'span5', 'maxlength'=>$this->params['tam'], 'value'=>$this->params['txt']));
	}
	
	public function getHTML() {
		return $this->value;
	}
		
}