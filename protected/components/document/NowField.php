<?php
class NowField extends DocumentField {
	
	const NAME = 'NOW';
	
	const FORMAT_YYMMDD 		= 'aa/mm/dd';
	const FORMAT_YYYYMMDD 		= 'aaaa/mm/dd';
	const FORMAT_YYYY_MM_DD 	= 'aaaa-mm-dd';
	const FORMAT_DD_MM_YYYY 	= 'dd-mm-aaaa';
	const FORMAT_DDMMYY 		= 'dd/mm/aa';
	const FORMAT_DDMMYYYY 		= 'dd/mm/aaaa';
	const FORMAT_DD	 			= 'dd';
	const FORMAT_MM	 			= 'mm';
	const FORMAT_YY	 			= 'aa';
	const FORMAT_YYYY	 		= 'aaaa';
	const FORMAT_WK				= 'wk';
	const FORMAT_DD_TEXT 		= 'dia';
	const FORMAT_MM_TEXT 		= 'mes';
	const FORMAT_YY_TEXT		= 'ano';
	const FORMAT_WK_TEXT		= 'sem';
	const FORMAT_TEXT	 		= 'extenso';
	const FORMAT_TRADITIONAL	= 'tradicional';
	
	// public $mask = self::FORMAT_DDMMYYYY;
	public function __construct() {
		$this->params = array(
			'mask'=>self::FORMAT_DDMMYYYY,
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
	// }
	
	public function formField($form) {
		return '';
	}
	
	public function getHTML() {
		
		return DocumentHelper::dataPorMascara('today', $this->params['mask']);
		
	}
		
}