<?php

/**
 * This is the model class for table "diario".
 *
 * The followings are the available columns in table 'diario':
 * @property integer $id
 * @property string $data
 * @property integer $aulas
 * @property string $conteudo
 * @property integer $turma_id
 *
 * The followings are the available model relations:
 * @property Turma $turma
 * @property Aluno[] $alunos
 */
class Diario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'diario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('data, aulas, turma_id', 'required'),
			array('aulas, turma_id', 'numerical', 'integerOnly'=>true),
			array('conteudo', 'length', 'max'=>100),
			array('data', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, data, aulas, conteudo, turma_id', 'safe', 'on'=>'search'),
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
			'turma' => array(self::BELONGS_TO, 'Turma', 'turma_id'),
			'frequencias' => array(self::HAS_MANY, 'Frequencia', 'diario_id'),
			//'frequencias' => array(self::MANY_MANY, 'Aluno', Yii::app()->params['tablePrefix'] . 'diario_has_aluno(diario_id, aluno_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'data' => 'Data',
			'aulas' => 'Aulas',
			'conteudo' => 'Conteúdo',
			'turma_id' => 'Turma',
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
		
		$criteria->with = array('turma');//,
							//'disciplina');
        $criteria->together = true;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.data',$this->data,true);
		$criteria->compare('t.aulas',$this->aulas);
		$criteria->compare('t.conteudo',$this->conteudo,true);
		$criteria->compare('t.turma_id',$this->turma_id);
		// $criteria->order = "data ASC";
		
		if (Yii::app()->user->papel == UserIdentity::ROLE_PROFE) {
			$criteria->compare('turma.professor_id',Yii::app()->user->papel_id, true);
		} else if (Yii::app()->user->papel == UserIdentity::ROLE_INSTI) {
			// TODO selecionar da instituição apenas
		} else {
			$criteria->compare('t.professor_id',$this->professor_id);
		}

		$criteria->order = "t.data DESC";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Diario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getFrequencia($aluno) {
		if (isset($this->frequencias)) {
	        foreach ($this->frequencias as $freq) {
	        	if ($freq->aluno_id == $aluno->id)
					return $freq;
			} 
		}
		
		$item_freq = new Frequencia;
		$item_freq->aluno = $aluno;
		$item_freq->diario = $this;
		$item_freq->faltas = 0;
		
		return $item_freq;
	}
	
	public function getBimestre() {
		// echo date('m', strtotime($this->data));
		switch (date('m', strtotime($this->data))) {
			case '1':
			case '2':
			case '3':
			case '7':
			case '8':
			case '9':
				// echo '[1]===';
				return 1;
			default:
				// echo '[2]===';
				return 2;
		}
	}
}
