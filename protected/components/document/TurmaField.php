<?php
class TurmaField extends DocumentField {
	
	const NAME = 'TURMA';
	
	const FIELD_DISCIPLINA = 'nome';
	const FIELD_ANO = 'ano';
	const FIELD_SEMESTRE = 'semestre';
	const FIELD_HR = 'hr';
	const FIELD_HA = 'ha';
	const FIELD_ALUNOS = 'alunos.nome';
	
	// public $dado = self::FIELD_NOME;
	public function __construct() {
		$this->params = array(
			'dado'=>self::FIELD_DISCIPLINA
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
			$this->value, '', Turma::model(), null);
	}
	
	public function getHTML() {
		
		if (!isset($this->value)) return '';
		
		$val = Turma::model()->findByPk($this->value);
		if (isset($val))
			switch ($this->params['dado']) {
				case self::FIELD_ANO:
					return $val->ano;
				case self::FIELD_SEMESTRE:
					return $val->semestre;
				case self::FIELD_HR:
					return $val->chrelogio;
				case self::FIELD_HA:
					return $val->chaula;
				case self::FIELD_ALUNOS:
					return $this->generateHTMLTable($val->alunos);
				case self::FIELD_DISCIPLINA:
				default:
					return $val->disciplina->nome;
			}
		else 
			return '';
	}
	
	private function generateHTMLTable($list) {
		$html = '<table>';
		$html .= '<tr>
					<th>Alunos</th>
				  </tr>';
				  
		foreach ($list as $val) {
			$html .= '<tr><td>' .
				$val->nome
				.'</td></tr>';
		}
		
		$html .= '</table>';
		return $html;
	}
		
}