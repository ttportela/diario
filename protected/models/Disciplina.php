<?php

/**
 * This is the model class for table "disciplina".
 *
 * The followings are the available columns in table 'disciplina':
 * @property integer $id
 * @property string $nome
 * @property string $codigo
 * @property integer $curso_id
 *
 * The followings are the available model relations:
 * @property Curso $curso
 * @property Turma[] $turmas
 */
class Disciplina extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'disciplina';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('curso_id', 'required'),
			array('curso_id, periodo', 'numerical', 'integerOnly'=>true),
			array('nome', 'length', 'max'=>50),
			array('codigo', 'length', 'max'=>20),
			array('ementa, bibbasica', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, codigo, curso_id, periodo, ementa, bibbasica', 'safe', 'on'=>'search'),
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
			'curso' => array(self::BELONGS_TO, 'Curso', 'curso_id'),
			'turmas' => array(self::HAS_MANY, 'Turma', 'disciplina_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nome' => 'Nome',
			'codigo' => 'Código',
			'curso_id' => 'Curso',
			'periodo' => 'Período',
			'ementa' => 'Ementa',
			'bibbasica' => 'Bibliografia Básica',
		);
	}

	public function toString()
	{
		return $this->nome;
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

		$criteria->compare('id',$this->id);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('curso_id',$this->curso_id);
		$criteria->compare('periodo',$this->periodo);
		$criteria->compare('ementa',$this->ementa,true);
		$criteria->compare('bibbasica',$this->bibbasica,true);
		
		if (isset($_GET['Disciplina'])) {
			$this->unsetAttributes();  // clear any default values
			$this->attributes=$_GET['Disciplina'];
		}
		
		if (isset($_GET['Disciplina']['globalSearch'])) {
			$this->globalSearch=$_GET['Disciplina']['globalSearch'];

			$criteria->addISearchCondition('t.nome', $this->globalSearch, true, 'OR');
			$criteria->addISearchCondition('t.codigo', $this->globalSearch, true, 'OR');
			$criteria->addISearchCondition('t.periodo', $this->globalSearch, true, 'OR');
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Disciplina the static model class
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
