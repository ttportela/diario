<?php

/**
 * This is the model class for table "professor".
 *
 * The followings are the available columns in table 'professor':
 * @property integer $id
 * @property string $siape
 * @property string $nome
 * @property string $email
 *
 * The followings are the available model relations:
 * @property Turma[] $turmas
 * @property Usuario[] $usuarios
 */
class Professor extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'professor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('siape', 'length', 'max'=>20),
			array('nome, email', 'length', 'max'=>50),
			array('email','email'),
			array('lattes', 'safe'),
			array('siape', 'filter', 'filter'=>'trim'),
			array('siape','unique', 'message'=>'Este SIAPE já foi cadastrado.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, siape, nome, email, lattes', 'safe', 'on'=>'search'),
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
			'turmas' => array(self::HAS_MANY, 'Turma', 'professor_id'),
			'usuarios' => array(self::HAS_MANY, 'Usuario', 'professor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'siape' => 'SIAPE',
			'nome' => 'Nome',
			'email' => 'E-mail',
			'lattes' => 'URL do Lattes',
		);
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
		$criteria->compare('siape',$this->siape,true);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('lattes',$this->lattes,true);
		
		if (isset($_GET['Professor'])) {
			$this->unsetAttributes();  // clear any default values
			$this->attributes=$_GET['Professor'];
		}
		
		if (isset($_GET['Professor']['globalSearch'])) {
			$this->globalSearch=$_GET['Professor']['globalSearch'];

			$criteria->addISearchCondition('t.nome', $this->globalSearch, true, 'OR');
			$criteria->addISearchCondition('t.siape', $this->globalSearch, true, 'OR');
			$criteria->addISearchCondition('t.email', $this->globalSearch, true, 'OR');
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Professor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function toString()
	{
		return $this->nome;
	}
}
