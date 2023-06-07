<?php

/**
 * This is the model class for table "atividade_docente".
 *
 * The followings are the available columns in table 'atividade_docente':
 * @property string $id
 * @property string $nome
 * @property string $descricao
 * @property string $inicio
 * @property string $fim
 * @property integer $status
 * @property string $tipo_id
 *
 * The followings are the available model relations:
 * @property AtividadeTipo $tipo
 * @property PtdHasAtividade[] $ptdHasAtividades
 */
class AtividadeDocente extends ActiveRecord
{
	
	const STATUS_ATIVO = 1;
	const STATUS_INATIVO = 0;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'atividade_docente';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, tipo_id', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('tipo_id', 'length', 'max'=>20),
			array('descricao, inicio, fim', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, descricao, inicio, fim, status, tipo_id', 'safe', 'on'=>'search'),
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
			'tipo' => array(self::BELONGS_TO, 'AtividadeTipo', 'tipo_id'),
			'atividades' => array(self::HAS_MANY, 'PTDAtividade', 'atividade_id'),
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
			'descricao' => 'Descrição',
			'inicio' => 'Início',
			'fim' => 'Fim',
			'status' => 'Status',
			'tipo_id' => 'Tipo',
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

		$criteria->with = array('tipo');
        $criteria->together = true;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('descricao',$this->descricao,true);
		$criteria->compare('inicio',$this->inicio,true);
		$criteria->compare('fim',$this->fim,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('tipo_id',$this->tipo_id,true);
		
		if (isset($_GET['PTDAtividade'])) {
			$this->unsetAttributes();  // clear any default values
			$this->attributes=$_GET['PTDAtividade'];
			$this->globalSearch=$_GET['PTDAtividade']['globalSearch'];

			$criteria->addSearchCondition('tipo.descricao', $this->globalSearch, true, 'OR');
			$criteria->addSearchCondition('nome', $this->globalSearch, true, 'OR');
			$criteria->addSearchCondition('descricao', $this->globalSearch, true, 'OR');
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AtividadeDocente the static model class
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
