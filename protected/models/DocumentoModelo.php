<?php

/**
 * This is the model class for table "documento_modelo".
 *
 * The followings are the available columns in table 'documento_modelo':
 * @property string $id
 * @property string $nome
 * @property string $conteudo
 * @property string $cabecalho_id
 * @property string $rodape_id
 * @property string $criado
 * @property integer $ativo
 * @property string $criador_id
 *
 * The followings are the available model relations:
 * @property Documento[] $documentos
 * @property DocumentoCampo[] $documentoCampos
 * @property Usuario $criador
 * @property DocumentoModelo $cabecalho
 * @property DocumentoModelo[] $documentoModelos
 * @property DocumentoModelo $rodape
 * @property DocumentoModelo[] $documentoModelos1
 */
class DocumentoModelo extends CActiveRecord
{
	
	public static $STATUS_TIMBRE = 0;
	public static $STATUS_ATIVO = 1;
	public static $STATUS_INATIVO = 2;
	
	public static $STATUS_PROJETO = 10;
	public static $STATUS_PARECER = 15;
	public static $STATUS_RELATOR = 20;
	
	public static $DEFAULT_CABECALHO = 1;
	public static $DEFAULT_RODAPE = 2;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'documento_modelo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, criado, criador_id', 'required'),
			array('ativo', 'numerical', 'integerOnly'=>true),
			array('cabecalho_id, rodape_id, criador_id', 'length', 'max'=>20),
			array('conteudo', 'safe'),
            // array('cabecalho_id','default',
              // 'value'=>1,
              // 'setOnEmpty'=>true,'on'=>'insert'),
            // array('rodape_id','default',
              // 'value'=>2,
              // 'setOnEmpty'=>true,'on'=>'insert'),
            array('criado','default',
              'value'=>new CDbExpression('NOW()'),
              'setOnEmpty'=>true,'on'=>'insert'),
            array('criador_id','default',
              'value'=>Yii::app()->user->id,
              'setOnEmpty'=>true,'on'=>'insert'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, conteudo, cabecalho_id, rodape_id, criado, ativo, criador_id', 'safe', 'on'=>'search'),
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
			'documentos' => array(self::HAS_MANY, 'Documento', 'modelo_id'),
			// 'campos' => array(self::HAS_MANY, 'DocumentoCampo', 'modelo_id'),
			'criador' => array(self::BELONGS_TO, 'Usuario', 'criador_id'),
			'cabecalho' => array(self::BELONGS_TO, 'DocumentoModelo', 'cabecalho_id'),
			'rodape' => array(self::BELONGS_TO, 'DocumentoModelo', 'rodape_id'),
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
			'cabecalho_id' => 'Cabecalho',
			'rodape_id' => 'Rodapé',
			'criado' => 'Criado em',
			'ativo' => 'Status',
			'criador_id' => 'Criador',
		);
	}

	public function toString()
	{
		return $this->nome;
	}
	
	public function cope()
	{
	    $this->getDbCriteria()->mergeWith(array(
	        'condition'=>'ativo='.self::$STATUS_PROJETO.
	        			' OR ativo='.self::$STATUS_PARECER.
	        			' OR ativo='.self::$STATUS_RELATOR,
	    ));
	    return $this;
	}
	
	public function projeto()
	{
	    $this->getDbCriteria()->mergeWith(array(
	        'condition'=>'ativo='.self::$STATUS_PROJETO,
	    ));
	    return $this;
	}
	
	public function parecer()
	{
	    $this->getDbCriteria()->mergeWith(array(
	        'condition'=>'ativo='.self::$STATUS_PARECER,
	    ));
	    return $this;
	}
	
	public function relatorio()
	{
	    $this->getDbCriteria()->mergeWith(array(
	        'condition'=>'ativo='.self::$STATUS_RELATOR,
	    ));
	    return $this;
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
		$criteria->compare('cabecalho_id',$this->cabecalho_id,true);
		$criteria->compare('rodape_id',$this->rodape_id,true);
		$criteria->compare('criado',$this->criado,true);
		$criteria->compare('ativo',$this->ativo);
		$criteria->compare('criador_id',$this->criador_id,true);
		
		// if (Yii::app()->user->papel == UserIdentity::ROLE_ADMIN) {
			// $criteria->compare('ativo',$this->ativo);
		// } else if (Yii::app()->user->papel == UserIdentity::ROLE_COPE) {
			// $criteria->compare('ativo',$this->ativo);
		// } else {
			// $criteria->compare('ativo', DocumentoModelo::$STATUS_ATIVO);
		// }
		
		$criteria->order = "t.criado DESC";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DocumentoModelo the static model class
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
