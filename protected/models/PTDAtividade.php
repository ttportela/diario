<?php

/**
 * This is the model class for table "ptd_has_atividade".
 *
 * The followings are the available columns in table 'ptd_has_atividade':
 * @property string $id
 * @property string $ptd_id
 * @property string $atividade_id
 * @property string $ordem
 * @property string $turno
 *
 * The followings are the available model relations:
 * @property AtividadeDocente $atividade
 * @property Ptd $ptd
 */
class PTDAtividade extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'ptd_has_atividade';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ptd_id, atividade_id, ordem, turno', 'required'),
			array('ptd_id, atividade_id', 'length', 'max'=>20),
			array('ordem, turno', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ptd_id, atividade_id, ordem, turno', 'safe', 'on'=>'search'),
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
			'atividade' => array(self::BELONGS_TO, 'AtividadeDocente', 'atividade_id'),
			'ptd' => array(self::BELONGS_TO, 'PTD', 'ptd_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ptd_id' => 'Plano de Trabalho Docente',
			'atividade_id' => 'Atividade',
			'ordem' => 'Ordem',
			'turno' => 'Turno',
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
		
		$criteria->with = array('ptd','atividade');
        $criteria->together = true;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('ptd_id',$this->ptd_id,true);
		$criteria->compare('atividade_id',$this->atividade_id,true);
		$criteria->compare('ordem',$this->ordem,true);
		$criteria->compare('turno',$this->turno,true);
		
		if (isset($_GET['PTDAtividade'])) {
			$this->unsetAttributes();  // clear any default values
			$this->attributes=$_GET['PTDAtividade'];
			$this->globalSearch=$_GET['PTDAtividade']['globalSearch'];

			$criteria->addSearchCondition('ptd.ano', $this->globalSearch, true, 'OR');
			$criteria->addSearchCondition('ptd.semestre', $this->globalSearch, true, 'OR');
			$criteria->addSearchCondition('atividade.nome', $this->globalSearch, true, 'OR');
			$criteria->addSearchCondition('atividade.descricao', $this->globalSearch, true, 'OR');
			$criteria->addSearchCondition('ordem', $this->globalSearch, true, 'OR');
			$criteria->addSearchCondition('turno', $this->globalSearch, true, 'OR');
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PTDAtividade the static model class
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
