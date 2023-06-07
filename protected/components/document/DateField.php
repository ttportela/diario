<?php
class DateField extends DocumentField {
	
	const NAME = 'DATA';
	
	// public $mask = NowField::FORMAT_DDMMYYYY;
	public function __construct() {
		$this->params = array(
			'mask'=>NowField::FORMAT_DDMMYYYY,
		);
	}
	
	public static function getName() {
		return self::NAME;
	}
		
	// public function getParams() {
		// return array('mask'=>$this->mask);
	// }
// 	
	// public function setParams($params) {
		// $this->mask = $params['mask'];
		// // $this->txt = $params['txt'];
	// }
	
	public function formField($form) {
		return $form->dateRow($this->model,$this->getFormName(), 
			array('class'=>'span5'), $this->params['mask']);
	}
	
	public function getHTML() {
		
		if (!isset($this->value)) return '';
		
		// $date = date("Y-m-d",strtotime($this->value));
		
		return DocumentHelper::dataPorMascara($this->value, $this->params['mask']);
	}
		
}