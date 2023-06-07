<?php

/**
 * This is the model class for table "interessado".
 *
 * The followings are the available columns in table 'interessado':
 * @property string $id
 * @property integer $ch
 * @property integer $funcao
 * @property integer $naies
 * @property string $inclusao
 * @property string $exclusao
 * @property string $formacao
 * @property string $telefone
 * @property string $professor_id
 * @property string $projeto_id
 *
 * The followings are the available model relations:
 * @property Professor $professor
 * @property Projeto $projeto
 */
class Interessado extends ActiveRecord
{
	const FUNC_COORD			= 0; // Coordenador
	const FUNC_VICE				= 5; // Vice-Coordenador
	const FUNC_COL_DOC			= 10; // Colaborador Docente / TA
	const FUNC_COL_DIS			= 15; // Colaborador Discente
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'interessado';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, ch, formacao, projeto_id', 'required'),
			array('ch, funcao, naies', 'numerical', 'integerOnly'=>true),
			array('id, professor_id, aluno_id, projeto_id', 'length', 'max'=>20),
			array('formacao', 'length', 'max'=>200),
			array('telefone', 'length', 'max'=>45),
			array('inclusao, exclusao', 'safe'),
			array('inclusao','default',
              'value'=>new CDbExpression('NOW()'),
              'setOnEmpty'=>true,'on'=>'insert'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ch, funcao, naies, inclusao, exclusao, formacao, telefone, professor_id, aluno_id, projeto_id', 'safe', 'on'=>'search'),
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
            'aluno' => array(self::BELONGS_TO, 'Aluno', 'aluno_id'),
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
			'ch' => 'Carga Horária',
			'funcao' => 'Função',
			'naies' => 'CH na IES',
			'inclusao' => 'Data de Inclusão',
			'exclusao' => 'Data de Exclusão',
			'formacao' => 'Formação/Titulação',
			'telefone' => 'Telefone (Informar o DDD)',
            'projeto_id' => 'Projeto',
            'professor_id' => 'Professor',
            'aluno_id' => 'Aluno',
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
		$criteria->compare('ch',$this->ch);
		$criteria->compare('funcao',$this->funcao);
		$criteria->compare('naies',$this->naies);
		$criteria->compare('inclusao',$this->inclusao,true);
		$criteria->compare('exclusao',$this->exclusao,true);
		$criteria->compare('formacao',$this->formacao,true);
		$criteria->compare('telefone',$this->telefone,true);
        $criteria->compare('projeto_id',$this->projeto_id,true);
        $criteria->compare('professor_id',$this->professor_id,true);
        $criteria->compare('aluno_id',$this->aluno_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Interessado the static model class
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
