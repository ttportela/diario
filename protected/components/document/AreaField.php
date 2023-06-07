<?php
class AreaField extends DocumentField {
	
	const NAME = 'AREA';
	
	// public $tam = 20;
	// public $txt = '';
	public function __construct() {
		$this->params = array(
			'tam'=>200,
			'txt'=>'',
		);
	}

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
		return $form->editorRow($this->model,$this->getFormName(), 
			array('class'=>'span5', 'maxlength'=>$this->params['tam'], 'value'=>$this->params['txt']));
	}
	
	public function getHTML() {
		return $this->value;
	}
		
}