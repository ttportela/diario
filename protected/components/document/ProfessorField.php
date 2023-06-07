<?php
class ProfessorField extends DocumentField {
	
	const NAME = 'PROF';
	
	const FIELD_NOME = 'nome';
	const FIELD_SIAPE = 'siape';
	const FIELD_EMAIL = 'email';
	
	// public $dado = self::FIELD_NOME;
	public function __construct() {
		$this->params = array(
			'dado'=>self::FIELD_NOME,
		);
	}

	public static function getName() {
		return self::NAME;
	}
		
	// public function getParams() {
		// return array('dado'=>$this->dado);
	// }
// 	
	// public function setParams($params) {
		// $this->dado = $params['dado'];
	// }
	
	public function formField($form) {
		// return $form->dropDownListRow($this->form,$this->getFormName(), 
		// CHtml::listData(Professor::model()->findAll(), 'id', 'nome'),
			// array('class'=>'span5'));
			
		return $form->selectorRow($this->model,$this->getFormName(), 
			$this->value, '', Professor::model(), null);
	}
	
	public function getHTML() {
		
		if (!isset($this->value)) return '';
		
		$val = Professor::model()->findByPk($this->value);
		if (isset($val))
			switch ($this->params['dado']) {
				case self::FIELD_SIAPE:
					return $val->siape;
				case self::FIELD_EMAIL:
					return $val->email;
				case self::FIELD_NOME:
				default:
					return $val->nome;
			}
		else 
			return '';
	}
		
}