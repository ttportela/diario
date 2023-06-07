<?php

/**
 * This is the model class for table "area".
 *
 * The followings are the available columns in table 'area':
 * @property string $id
 * @property string $texto
 * @property integer $nivel
 * @property string $codigo
 *
 * The followings are the available model relations:
 * @property Projeto[] $projetos
 * @property Projeto[] $projetos1
 */
class Area extends ActiveRecord
{
	
	const N_1 = 1;
	const N_2 = 2;
	const N_3 = 3;
	const N_4 = 4;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'area';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('texto, nivel, codigo', 'required'),
			array('nivel', 'numerical', 'integerOnly'=>true),
			array('codigo', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, texto, nivel, codigo', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'projetos_area' => array(self::HAS_MANY, 'Projeto', 'area_id'),
			'projetos_grandearea' => array(self::HAS_MANY, 'Projeto', 'grandearea_id'),
		);
	}
	
	public function defaultScope() {
	    return array(
	        'order' => 'codigo ASC',
	    );
	}
	
	public function grandesareas()
	{
	    $this->getDbCriteria()->mergeWith(array(
	        'condition'=>'nivel='.self::N_1,
	    ));
	    return $this;
	}
	
	public function areas()
	{
	    $this->getDbCriteria()->mergeWith(array(
	        'condition'=>'nivel='.self::N_2.' OR nivel='.self::N_3.' OR nivel='.self::N_4,
	    ));
	    return $this;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'texto' => 'Descrição',
            'nivel' => 'Nível',
            'codigo' => 'Código',
        );
    }

	public function toString()
	{
		$t = $this->codigo . ' ';
		
		if ($this->nivel == self::N_3) {
			$t .= '- '; 
		} else if ($this->nivel == self::N_4) {
			$t .= '-- '; 
		}
		
		return $t . $this->texto;
	}
	
	public function nivel_txt()
	{
		switch ($this->nivel) {
			case self::N_1: return 'Grande Área';
			case self::N_2: return 'Área';
			case self::N_3: return 'Subárea';
			case self::N_4: return 'Especialidade';
		}
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('texto',$this->texto,true);
		$criteria->compare('nivel',$this->nivel);
		$criteria->compare('codigo',$this->codigo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Area the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave() {
		if (parent::beforeSave()) {
			$arrayForeignKeys=$this->tableSchema->foreignKeys;
		    foreach ($this->attributes as $name=>$value) {
		      if (array_key_exists($name, $arrayForeignKeys) && $this->metadata->columns[$name]->allowNull && trim($value)=='') {       
		        $this->$name=null;
			  }
		    }
			return true;
        }
        return false;
	}
}
