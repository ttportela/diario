<?php
class DisciplinaField extends DocumentField {
	
	const NAME = 'DISCIPLINA';
	
	const FIELD_NOME = 'nome';
	const FIELD_CODIGO = 'codigo';
	const FIELD_PERIODO = 'periodo';
	const FIELD_EMENTA = 'ementa';
	
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
		// CHtml::listData(Disciplina::model()->findAll(), 'id', 'nome'),
			// array('class'=>'span5'));
		
		return $form->selectorRow($this->model,$this->getFormName(), 
			$this->value, '', Disciplina::model(), null);
	}
	
	public function getHTML() {
		
		if (!isset($this->value)) return '';
		
		$val = Disciplina::model()->findByPk($this->value);
		if (isset($val))
			switch ($this->params['dado']) {
				case self::FIELD_CODIGO:
					return $val->codigo;
				case self::FIELD_EMENTA:
					return $val->ementa;
				case self::FIELD_PERIODO:
					return $val->periodo;
				case self::FIELD_NOME:
				default:
					return $val->nome;
			}
		else 
			return '';
	}
		
}