<?php

/**
 * This is the model class for table "dia_avaliacao_has_aluno".
 *
 * The followings are the available columns in table 'dia_avaliacao_has_aluno':
 * @property integer $avaliacao_id
 * @property integer $aluno_id
 * @property string $nota
 * @property string $observacoes
 */
class AvaliacaoAluno extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'avaliacao_has_aluno';
	}

	// public function behaviors()
	// {
	    // return array(
	        // 'withRelated'=>array(
	            // 'class'=>'ext.wr.WithRelatedBehavior',
	        // ),
	    // );
	// }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('avaliacao_id, aluno_id', 'required'),
			array('avaliacao_id, aluno_id', 'numerical', 'integerOnly'=>true),
			array('nota', 'length', 'max'=>10),
			array('observacoes', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, avaliacao_id, aluno_id, nota, observacoes', 'safe', 'on'=>'search'),
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
			'avaliacao' => array(self::BELONGS_TO, 'Avaliacao', 'avaliacao_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'avaliacao_id' => 'Avaliação',
			'aluno_id' => 'Aluno',
			'nota' => 'Nota',
			'observacoes' => 'Observações',
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
		$criteria->compare('avaliacao_id',$this->avaliacao_id);
		$criteria->compare('aluno_id',$this->aluno_id);
		$criteria->compare('nota',$this->nota,true);
		$criteria->compare('observacoes',$this->observacoes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	// public function afterFind() {
	    // $this->price = Yii::app()->format->number($this->price);
	    // return parent::afterFind();
	// }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AvaliacaoAluno the static model class
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
