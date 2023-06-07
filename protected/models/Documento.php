<?php

/**
 * This is the model class for table "documento".
 *
 * The followings are the available columns in table 'documento':
 * @property string $id
 * @property string $nome
 * @property string $conteudo
 * @property string $modelo_id
 * @property string $criado
 * @property integer $ativo
 * @property string $criador_id
 *
 * The followings are the available model relations:
 * @property DocumentoModelo $modelo
 * @property Usuario $criador
 * @property DocumentoHistorico[] $documentoHistoricos
 */
class Documento extends ActiveRecord
{
	
	public static $STATUS_ATIVO = 1;
	public static $STATUS_INATIVO = 2;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'documento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, modelo_id, criado, criador_id', 'required'),
			array('ativo', 'numerical', 'integerOnly'=>true),
			array('modelo_id, criador_id', 'length', 'max'=>20),
			array('conteudo', 'safe'),
			array('criado','default',
              'value'=>new CDbExpression('NOW()'),
              'setOnEmpty'=>true,'on'=>'insert'),
            array('criador_id','default',
              'value'=>Yii::app()->user->id,
              'setOnEmpty'=>true,'on'=>'insert'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, conteudo, modelo_id, criado, ativo, criador_id', 'safe', 'on'=>'search'),
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
			'modelo' => array(self::BELONGS_TO, 'DocumentoModelo', 'modelo_id'),
			'criador' => array(self::BELONGS_TO, 'Usuario', 'criador_id'),
			'historicos' => array(self::HAS_MANY, 'DocumentoHistorico', 'documento_id'),
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
			'conteudo' => 'Conteúdo',
			'modelo_id' => 'Modelo',
			'criado' => 'Criado em',
			'ativo' => 'Status',
			'criador_id' => 'Criador',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('conteudo',$this->conteudo,true);
		$criteria->compare('modelo_id',$this->modelo_id,true);
		$criteria->compare('criado',$this->criado,true);
		// $criteria->compare('ativo',$this->ativo);
		// $criteria->compare('criador_id',$this->criador_id,true);

		if (Yii::app()->user->papel == UserIdentity::ROLE_ADMIN) {
			$criteria->compare('ativo',$this->ativo);
			$criteria->compare('criador_id',$this->criador_id,true);
		} else {
			$criteria->compare('ativo', DocumentoModelo::$STATUS_ATIVO);
			$criteria->compare('criador_id',Yii::app()->user->id,true);
		}

		$criteria->order = "t.criado DESC";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Documento the static model class
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
