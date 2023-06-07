<?php
class ManyField extends DocumentField {
	
	const NAME = 'LISTA';
	
	const FIELD_TS = 'TS';
	
	public function __construct() {
		$this->params = array(
			'campos'=>self::FIELD_TS,
			'list'=>ModelField::LIST_UL,
			'modelo'=>'Aluno', 
			'titulo'=>'Item',
			'html'=>'['.self::FIELD_TS.']'
		);
	}

	public static function getName() {
		return self::NAME;
	}
	
	public function formField($form) {
		return $form->selectorMultipleRow($this->model,$this->getFormName(), 
			array(), (new $this->params['modelo']), null);
	}
	
	public function getHTML() {
		
		if (!isset($this->value) || $this->value == '') return '';
		
		if (!isset($this->params['campos']) || $this->params['campos'] == '') 
			$this->params['campos'] = self::FIELD_TS;
		
		$list = (!isset($this->params['list']) || $this->params['list'] == '')? self::LIST_UL : $this->params['list'];
		
		$cols = explode(',',$this->params['campos']);
		
		$data = array();
		foreach ($this->value as $id) {
			$val = new $this->params['modelo'];
			$val = $val->findByPk($id);
			array_push($data, $val);
		}
			
		if (isset($this->params['html'])) {
			$html = '';
			for ($i = 0; $i < count($data); $i++) {
				$aux = DocumentHelper::decodeHTML($this->params['html']);
				
				for ($nr = 0; $nr < count($cols); $nr++) {
					$aux = str_replace('['.$cols[$nr].']', ModelField::translateData($data[$i], $cols[$nr], $list), $aux);
				}
				$html .= $aux;
			}
			return $html;
		} else {
			$table = '<table border="1" style="border-collapse: collapse;border: 1px solid black;"><thead><tr>';
			
			for ($nr = 0; $nr < count($cols); $nr++) {
				$table .= '<th style="border: 1px solid black;">'.$this->translateCol($cols[$nr]).'</th>';
			}
			$table .= '</tr></thead><tbody>';
			for ($i = 0; $i < count($data); $i++) {
				$table .= '<tr>';
				for ($nr = 0; $nr < count($cols); $nr++) {
					$table .= '<td style="border: 1px solid black;">'.ModelField::translateData($data[$i], $cols[$nr], $list).'</td>';
				}
				$table .= '</tr>';
			}
			$table .= '</tbody></table>';
			return $table;
		}
	}
	
	public function translateCol($col) {
		if ($col == self::FIELD_TS) {
			return (isset($this->params['titulo']))? $this->params['titulo'] : 'Ítem';
		} else {
			return ModelField::translateCol($col, $this->params['modelo']);
		}
	}
		
}