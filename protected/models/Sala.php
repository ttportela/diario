<?php

/**
 * This is the model class for table "sala".
 *
 * The followings are the available columns in table 'sala':
 * @property string $id
 * @property string $descricao
 * @property string $responsavel_instituicao_id
 * @property string $responsavel_curso_id
 * @property string $responsavel_usuario_id
 *
 * The followings are the available model relations:
 * @property Reserva[] $reservas
 * @property Curso $responsavelCurso
 * @property Instituicao $responsavelInstituicao
 * @property Usuario $responsavelUsuario
 * @property Turma[] $turmas
 */
class Sala extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'sala';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descricao', 'required'),
			array('responsavel_instituicao_id, responsavel_curso_id, responsavel_usuario_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, descricao, responsavel_instituicao_id, responsavel_curso_id, responsavel_usuario_id', 'safe', 'on'=>'search'),
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
			'reservas' => array(self::HAS_MANY, 'Reserva', 'sala_id'),
			'res_curso' => array(self::BELONGS_TO, 'Curso', 'responsavel_curso_id'),
			'res_instituicao' => array(self::BELONGS_TO, 'Instituicao', 'responsavel_instituicao_id'),
			'res_usuario' => array(self::BELONGS_TO, 'Usuario', 'responsavel_usuario_id'),
			'turmas' => array(self::HAS_MANY, 'Turma', 'sala_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'descricao' => 'Descrição',
			'responsavel_instituicao_id' => 'Responsável (Instituição)',
			'responsavel_curso_id' => 'Responsável (Curso)',
			'responsavel_usuario_id' => 'Responsável (Usuário)',
			'responsavel' => 'Responsável',
		);
	}

	public function toString()
	{
		return $this->descricao;
	}

	public function getResponsavel()
	{
		if (isset($this->res_curso)) {
			return $this->res_curso; 
		} else if (isset($this->res_instituicao)) {
			return $this->res_instituicao; 
		} else if (isset($this->res_usuario)) {
			return $this->res_usuario; 
		}
		
		return null;
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
		$criteria->compare('descricao',$this->descricao,true);
		$criteria->compare('responsavel_instituicao_id',$this->responsavel_instituicao_id,true);
		$criteria->compare('responsavel_curso_id',$this->responsavel_curso_id,true);
		$criteria->compare('responsavel_usuario_id',$this->responsavel_usuario_id,true);
		
		if (isset($_GET['Sala'])) {
			$this->unsetAttributes();  // clear any default values
			$this->attributes=$_GET['Sala'];
			$this->globalSearch=$_GET['Sala']['globalSearch'];

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
	 * @return Sala the static model class
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
