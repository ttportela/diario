<?php

/**
 * This is the model class for table "instituicao".
 *
 * The followings are the available columns in table 'instituicao':
 * @property integer $id
 * @property string $nome
 * @property string $sigla
 *
 * The followings are the available model relations:
 * @property Aluno[] $alunos
 * @property Curso[] $cursos
 * @property Usuario[] $usuarios
 */
class Instituicao extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'instituicao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome', 'length', 'max'=>100),
			array('sigla, responsavel_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, sigla, responsavel_id', 'safe', 'on'=>'search'),
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
			'alunos' => array(self::HAS_MANY, 'Aluno', 'instituicao_id'),
			'cursos' => array(self::HAS_MANY, 'Curso', 'instituicao_id'),
			'usuarios' => array(self::HAS_MANY, 'Usuario', 'instituicao_id'),
			'responsavel' => array(self::BELONGS_TO, 'Usuario', 'responsavel_id'),
			'salas' => array(self::HAS_MANY, 'Sala', 'responsavel_instituicao_id'),
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
			'sigla' => 'Sigla',
			'responsavel_id' => 'Responsavel',
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
		$criteria->compare('sigla',$this->sigla,true);
		$criteria->compare('responsavel_id',$this->responsavel_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Instituicao the static model class
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
