<?php
class ActiveRecord extends CActiveRecord {
	
	private $_globalSearch;
	
	public function setAttributes($values, $safeOnly = true) {
		if (!is_array($values))
			return;
		$attributes = array_flip($safeOnly ? $this->getSafeAttributeNames() : $this->attributeNames());
		
		foreach ($values as $name => $value) {
			if (isset($attributes[$name])) {
				$column = $this -> getTableSchema() -> getColumn($name);// new
				if (stripos($column -> dbType, 'decimal') !== false || stripos($column -> dbType, 'double') !== false
					 || stripos($column -> dbType, 'float') !== false) {// new
					
					$value = Yii::app()->format->unformatNumber($value);// new
					
				}
				$this->$name = $value;
			} else if ($safeOnly)
				$this->onUnsafeAttribute($name, $value);
		}
		
	}
	
	public function getGlobalSearch() {
		return $this->_globalSearch;
	}
	
	public function setGlobalSearch($q) {
		return $this->_globalSearch = $q;
	}

}
