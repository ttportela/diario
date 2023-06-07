<?php
abstract class DocumentField {
	
	/*
	 * Anatomia dos campos:
	 * {[tipo|descrição|param1=valor|param2=valor]}
	 */
	
	const OPEN_TAG 		= '{['; // Cuidado com o código em DocumentForm::readFilds se for mudar este seletor
	const CLOSE_TAG 		= ']}'; // idem
	const SEPARATOR1 		= '|';
	const SEPARATOR2 		= '=';
	
	public $desc = '';
	// public $form = null;
	public $order = 0;
	
	public $params = array();
	
	public $value = null;
	
	// abstract public function getName();
	// abstract public function getParams();
	// abstract public function setParams($params);
	
	abstract public function getHTML();
	abstract public function formField($form);
	
	public function getLabel() {
		return $this->desc;
	}
	
	public function getFormName() {
		return $this->getName() . $this->order;
	}
	
	public static function translate($strfield, $form, $order) {
		
		$aux = explode(DocumentField::SEPARATOR1, $strfield);
		
		$field = null;
		switch ($aux[0]) {
			case NowField::NAME:
				$field = new NowField; break;
			case DateField::NAME:
				$field = new DateField; break;
			case TextField::NAME:
				$field = new TextField; break;
			case AreaField::NAME:
				$field = new AreaField; break;
			case ProfessorField::NAME:
				$field = new ProfessorField; break;
			case AlunoField::NAME:
				$field = new AlunoField; break;
			case DisciplinaField::NAME:
				$field = new DisciplinaField; break;
			case TurmaField::NAME:
				$field = new TurmaField; break;
			case ModelField::NAME:
				$field = new ModelField; break;
			case ManyField::NAME:
				$field = new ManyField; break;
			default:
				throw new Exception("Tipo de campo: ".$aux[0]." não definido!", 500);
				
		}
		
		$field->desc = $aux[1];
		$field->model = $form;
		$field->order = $order;
		
		$params = array();
		for ($i = 2; $i < count($aux); $i++) {
			$p = explode(DocumentField::SEPARATOR2, $aux[$i]);
			$params[$p[0]] = $p[1];
		}
		
		$field->setParams($params);
		return $field;
	}
	
	public function toString() {
		$params = array();
		foreach ($this->getParams() as $key => $value) {
			array_push($params, implode(DocumentField::SEPARATOR2, array($key, $value)));
		}
		
		
		return DocumentField::OPEN_TAG . 
					$this->getName() . DocumentField::SEPARATOR1 .
					$this->getLabel() . DocumentField::SEPARATOR1 .		
					implode(DocumentField::SEPARATOR1, $params) . 
			   DocumentField::CLOSE_TAG; 
	}
		
	public function getParams() {
		return $this->params;
	}
	
	public function setParams($params) {
		$this->params = $params;
	}
		
}