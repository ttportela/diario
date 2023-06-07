<?php
class ModelField extends DocumentField {
	
	const NAME = 'ITEM';
	
	const FIELD_TS = 'TS';
	
	const LIST_UL = 'ul';
	const LIST_OL = 'ol';
	const LIST_TB = 'table';
	
	public function __construct() {
		$this->params = array(
			'campos'=>self::FIELD_TS,
			'list'=>self::LIST_UL,
			'modelo'=>'Aluno', 
			'titulo'=>'Item',
			'html'=>'['.self::FIELD_TS.']',
			// 'filtro'=>null,
		);
	}

	public static function getName() {
		return self::NAME;
	}
	
	public function formField($form) {
		$search = new $this->params['modelo'];
		
		$filtro = $this->params['filtro'];
		if (isset($filtro)) {
			$search = $search->$filtro();
		}
		
		return $form->selectorRow($this->model,$this->getFormName(), 
			$this->value, '', $search, null);
	}
	
	public function getHTML() {
		
		if (!isset($this->value) || $this->value == '') return '';
		
		if (!isset($this->params['campos']) || $this->params['campos'] == '') 
			$this->params['campos'] = self::FIELD_TS;
		
		$list = (!isset($this->params['list']) || $this->params['list'] == '')? self::LIST_UL : $this->params['list'];
		
		$cols = explode(',',$this->params['campos']);
		Yii::app()->helper->trace($cols);
		
		if ($this->value instanceof $this->params['modelo']) {
			$val = $this->value;
		} else {
			$val = new $this->params['modelo'];
			$val = $val->findByPk($this->value);	
		}
		
		if (isset($this->params['html'])) {
			$aux = DocumentHelper::decodeHTML($this->params['html']);
			
			for ($nr = 0; $nr < count($cols); $nr++) {
				$aux = str_replace('['.$cols[$nr].']', self::translateData($val, $cols[$nr], $list), $aux);
			}
		} else {
			$aux = '';
			if (count($cols) == 1) {
				$aux = self::translateData($val, $cols[0], $list);
			} else {
				$aux = '<ul>';
				for ($nr = 0; $nr < count($cols); $nr++) {
					$aux .= '<li>'.self::translateData($val, $cols[$nr], $list).'</li>';		
				}
				$aux .= '</ul>';
			}
		}
		return $aux;
	}
	
	public static function translateCol($col, $model) {
		if ($model !== ActiveRecord) $model = new $model; 
		return $model->getAttributeLabel($col);
	}
	
	public static function translateData($val, $col=self::FIELD_TS, $list=self::LIST_UL) {
		if ($col == self::FIELD_TS) {
			return $val->toString();
		} else if (strpos($col, '.') !== false) {
			$aux = explode('.', $col);
			if (is_array($val->$aux[0])) {
				return self::translateList($val->$aux[0], $aux[1], $list);
			} else {
				return self::translateData($val->$aux[0], $aux[1], $list);
			}
		} else if (is_array($val->$col)) {
			return self::translateList($val->$col, self::FIELD_TS, $list);
		} else {
			return $val->$col;
		}
	}
	
	public static function translateList($val, $col=self::FIELD_TS, $list=self::LIST_UL) {
		if ($list==self::LIST_TB)
			$ls = array('<table border="1" style="border-collapse: collapse;width: 100%;margin-top: -2px;border-right:0;border-left:0;border-top: 1px solid black;"><tbody>','<tr style="border-top: 1px solid black;"><td>',
				'</td></tr>','</tbody></table>');
		else if ($list==self::LIST_OL)
			$ls = array('<ol>','<li>','</li>','</ol>');
		else
			$ls = array('<ul>','<li>','</li>','</ul>');
		
		
		
		$html = $ls[0];
		for ($nr = 0; $nr < count($val); $nr++) {
			$html .= $ls[1].self::translateData($val[$nr], $col).$ls[2];		
		}
		$html .= $ls[3];
		return $html;
	}
		
}