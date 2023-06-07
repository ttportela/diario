<?php

/**
 * This is the model class for table "curso".
 *
 * The followings are the available columns in table 'curso':
 * @property integer $id
 * @property string $nome
 * @property integer $instituicao_id
 *
 * The followings are the available model relations:
 * @property Instituicao $instituicao
 * @property Disciplina[] $disciplinas
 */
class Curso extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'curso';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instituicao_id', 'required'),
			array('instituicao_id, coordenador_id', 'numerical', 'integerOnly'=>true),
			array('nome', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, instituicao_id, coordenador_id', 'safe', 'on'=>'search'),
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
			'instituicao' => array(self::BELONGS_TO, 'Instituicao', 'instituicao_id'),
			'disciplinas' => array(self::HAS_MANY, 'Disciplina', 'curso_id'),
			'coordenador' => array(self::BELONGS_TO, 'Professor', 'coordenador_id'),
			// 'ptds' => array(self::HAS_MANY, 'PTD', 'curso_id'),
			// 'salas' => array(self::HAS_MANY, 'Sala', 'responsavel_curso_id'),
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
			'instituicao_id' => 'Instituição',
			'coordenador_id' => 'Coordenador',
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
		$criteria->compare('instituicao_id',$this->instituicao_id);
		$criteria->compare('coordenador_id',$this->coordenador_id,true);
		
		if (isset($_GET['Curso'])) {
			$this->unsetAttributes();  // clear any default values
			$this->attributes=$_GET['Curso'];
		}
		
		if (isset($_GET['Curso']['globalSearch'])) {
			$this->globalSearch=$_GET['Curso']['globalSearch'];

			$criteria->addISearchCondition('t.nome', $this->globalSearch, true, 'OR');
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Curso the static model class
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
