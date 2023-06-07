<?php
class DocumentForm extends CFormModel {
	
	public $isNewRecord = true;
	
	public $nome = '';
	public $modelo_id;
	public $model = null;
	
	public $fields = array();
	
	function readFields($model) {
		$this->model = $model;
		$this->nome = $model->nome;
		
		// Ler os campos do conteúdo:		
		preg_match_all('/\{\[[^\]][^\}]*\]\}/', $model->conteudo, $strfields);
		// $strfields = $this->betweenStrings('\{\[','\]\}',$model->conteudo);
		
		$ct = 1;
		foreach ($strfields[0] as $strfield) {
			$strfield = trim(trim($strfield,'}]'),'{[');
			array_push($this->fields, DocumentField::translate($strfield, $this, $ct++));
		}
	}
	
	function betweenStrings($start, $end, $str){
	    $matches = array();
	    $regex = "/$start([a-zA-Z0-9_]*)$end/";
	    preg_match_all($regex, $str, $matches);
	    return $matches[1];
	}
	
	public function getContents() {
		// Trocar os campos do conteúdo:
		$cont = $this->model->conteudo;
		
		foreach ($this->fields as $f) {
			$cont = str_replace($f->toString(), $f->getHTML(), $cont);
		}
		
		return $cont;
	}
	
	 /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		$attr = 'nome'; 
		
		foreach ($this->fields as $f) {
			$attr .= ',' . $f->getFormName();
		}
		
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array($attr, 'required'),
			// array('periodo, publicarpe', 'numerical', 'integerOnly'=>true),			
			array($attr, 'safe'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels = array(
			'id' => 'ID',
			'nome' => 'Nome',
		);
		
		foreach ($this->fields as $f) {
			$labels[$f->getFormName()] = $f->getLabel();
		}
		
		return $labels;
	}
	
	public function __set($name, $value) {
		foreach ($this->fields as $f) {
			if ($f->getFormName() == $name) {
				$f->value = $value;
				return;
			} 	
		}
        
        parent::__set($name, $value);
        
    }
	
	public function __get($name) {
		foreach ($this->fields as $f) {
			if ($f->getFormName() == $name) {
				return $f->value;
			} 	
		}
        
        parent::__get($name);
        
    }
	
}
	