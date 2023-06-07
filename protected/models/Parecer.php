<?php

/**
 * This is the model class for table "parecer".
 *
 * The followings are the available columns in table 'parecer':
 * @property string $id
 * @property string $projeto_id
 * @property string $professor_id
 * @property string $data
 * @property string $texto
 *
 * The followings are the available model relations:
 * @property Professor $professor
 * @property Projeto $projeto
 */
class Parecer extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'parecer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('projeto_id, professor_id, data, texto', 'required'),
			array('projeto_id, professor_id', 'length', 'max'=>20),
			array('data','default',
              'value'=>new CDbExpression('NOW()'),
              'setOnEmpty'=>true,'on'=>'insert'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, projeto_id, professor_id, data, texto', 'safe', 'on'=>'search'),
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
			'professor' => array(self::BELONGS_TO, 'Professor', 'professor_id'),
			'projeto' => array(self::BELONGS_TO, 'Projeto', 'projeto_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'projeto_id' => 'Projeto',
            'professor_id' => 'Parecerista',
            'data' => 'Data',
            'texto' => 'Parecer',
        );
    }

	public function toString()
	{
		return $this->id;
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
		$criteria->compare('projeto_id',$this->projeto_id,true);
		$criteria->compare('professor_id',$this->professor_id,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('texto',$this->texto,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Parecer the static model class
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
