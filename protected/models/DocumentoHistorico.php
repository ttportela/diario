<?php

/**
 * This is the model class for table "documento_historico".
 *
 * The followings are the available columns in table 'documento_historico':
 * @property string $id
 * @property string $nome
 * @property string $conteudo
 * @property string $observacoes
 * @property string $aletrado
 * @property string $documento_id
 * @property string $criador_id
 *
 * The followings are the available model relations:
 * @property Documento $documento
 * @property Usuario $criador
 */
class DocumentoHistorico extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'documento_historico';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, data, documento_id, criador_id', 'required'),
			array('id, documento_id, criador_id', 'length', 'max'=>20),
			array('nome, conteudo, observacoes', 'safe'),
			array('data','default',
              'value'=>new CDbExpression('NOW()'),
              'setOnEmpty'=>true,'on'=>'insert'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, conteudo, observacoes, data, documento_id, criador_id', 'safe', 'on'=>'search'),
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
			'documento' => array(self::BELONGS_TO, 'Documento', 'documento_id'),
			'criador' => array(self::BELONGS_TO, 'Usuario', 'criador_id'),
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
			'observacoes' => 'Observações',
			'data' => 'Aletrado em',
			'documento_id' => 'Documento',
			'criador_id' => 'Alterado por',
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
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('conteudo',$this->conteudo,true);
		$criteria->compare('observacoes',$this->observacoes,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('documento_id',$this->documento_id,true);
		$criteria->compare('criador_id',$this->criador_id,true);

		$criteria->order = "t.data DESC";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DocumentoHistorico the static model class
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
