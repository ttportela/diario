<?php

/**
 * This is the model class for table "reserva".
 *
 * The followings are the available columns in table 'reserva':
 * @property string $id
 * @property string $sala_id
 * @property string $finalidade
 * @property string $inicio
 * @property string $fim
 * @property integer $status
 * @property string $data
 * @property string $solicitante_id
 *
 * The followings are the available model relations:
 * @property Sala $sala
 * @property Usuario $solicitante
 */
class Reserva extends ActiveRecord
{

	const STATUS_NEW = 1;
	const STATUS_APPROVED = 10;
	const STATUS_REPROVED = 20;
	const STATUS_CANCELLED = 30;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'reserva';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sala_id, inicio, fim', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('sala_id, solicitante_id', 'length', 'max'=>20),
			array('finalidade', 'safe'),
			array('data','default',
              'value'=>new CDbExpression('NOW()'),
              'setOnEmpty'=>true,'on'=>'insert'),
            array('solicitante_id','default',
              'value'=>Yii::app()->user->id,
              'setOnEmpty'=>true,'on'=>'insert'),
            array('inicio','noOverlap'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sala_id, finalidade, inicio, fim, status, data, solicitante_id', 'safe', 'on'=>'search'),
		);
	}

	public function noOverlap()
	{
		$inicio = strtotime($this->inicio);
		$fim = strtotime($this->fim);
		
		if ($inicio < date("Y-m-d H:i")) {
			$this->addError('inicio', 'Data de Início não pode estar no passado');
		}
		
		if ($fim < date("Y-m-d H:i")) {
			$this->addError('fim', 'Data de Fim não pode estar no passado');
		}

		if ($inicio > $fim) {
			$this->addError('inicio', 'Data de Início deve ser anterior à data de Fim');
		}  
		
		if (!$this->hasErrors()) {
			$criteria = new CDbCriteria;    
		    $a = new Reserva();
			$criteria->compare('sala_id',$this->sala_id,true);
			$criteria->compare('status',self::STATUS_APPROVED,true);
		    $criteria->addBetweenCondition('inicio', $inicio, $fim, 'OR');
		    $criteria->addBetweenCondition('fim', $inicio, $fim);
		    //start_date and end_date in table A, the other in table B
		    $model = $a->exists($criteria);
		    if (!empty($model)) {
		        $this->addError($attribute, "Já existe uma reserva neste período.");
		    }
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'sala' => array(self::BELONGS_TO, 'Sala', 'sala_id'),
			'solicitante' => array(self::BELONGS_TO, 'Usuario', 'solicitante_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sala_id' => 'Sala',
			'finalidade' => 'Finalidade',
			'inicio' => 'Início',
			'fim' => 'Fim',
			'status' => 'Status',
			'status_str' => 'Status',
			'data' => 'Data',
			'solicitante_id' => 'Solicitante',
		);
	}

	public function toString()
	{
		return $this->sala->descricao.' / '.$this->solicitante->toString().' (De: '.
			Yii::app()->getDateFormatter()->format("dd/MM/yy HH:mm",strtotime($this->inicio)).' a '.
			Yii::app()->getDateFormatter()->format("dd/MM/yy HH:mm",strtotime($this->fim)).')';
	}
	
	public function getStatus_str()
	{
		return self::status_str($this->status);
	}
	
	public static function status_str($status)
	{
		switch ($status) {
			case self::STATUS_NEW:
				return  "Aguardando Aprovação";
			case self::STATUS_APPROVED:
				return  "Aprovado";
			case self::STATUS_REPROVED:
				return  "Reprovado";
			case self::STATUS_CANCELLED:
				return  "Cancelado";
			default:
				return  null;
		}
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
		
		// $criteria->with = array('sala','usuario');
        // $criteria->together = true;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('sala_id',$this->sala_id,true);
		$criteria->compare('finalidade',$this->finalidade,true);
		$criteria->compare('inicio',$this->inicio,true);
		$criteria->compare('fim',$this->fim,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('solicitante_id',$this->solicitante_id,true);
		
		if (isset($_GET['Reserva'])) {
			$this->unsetAttributes();  // clear any default values
			$this->attributes=$_GET['Reserva'];
		}
		
		if (isset($_GET['Reserva']['globalSearch'])) {
			$this->globalSearch=$_GET['Reserva']['globalSearch'];

			$criteria->addISearchCondition('sala.descricao', $this->globalSearch, true, 'OR');
			$criteria->addISearchCondition('finalidade', $this->globalSearch, true, 'OR');
			$criteria->addISearchCondition('status', $this->globalSearch, true, 'OR');
			$criteria->addISearchCondition('solicitante.nome', $this->globalSearch, true, 'OR');
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
	 * @return Reserva the static model class
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
