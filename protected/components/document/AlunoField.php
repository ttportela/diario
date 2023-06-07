<?php
class AlunoField extends DocumentField {
	
	const NAME = 'ALUNO';
	
	const FIELD_NOME = 'nome';
	const FIELD_RA = 'ra';
	const FIELD_EMAIL = 'email';
	
	// public $dado = self::FIELD_NOME;
	public function __construct() {
		$this->params = array(
			'dado'=>self::FIELD_NOME
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
		// CHtml::listData(Aluno::model()->findAll(), 'id', 'nome'),
			// array('class'=>'span5', 'maxlength'=>$this->size, 'value'=>$this->txt));
			
		return $form->selectorRow($this->model,$this->getFormName(), 
			$this->value, '', Aluno::model(), null);
	}
	
	public function getHTML() {
		
		if (!isset($this->value)) return '';
		
		$val = Aluno::model()->findByPk($this->value);
		if (isset($val))
			switch ($this->params['dado']) {
				case self::FIELD_RA:
					return $val->ra;
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