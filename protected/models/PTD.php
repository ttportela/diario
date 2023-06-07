<?php

/**
 * This is the model class for table "ptd".
 *
 * The followings are the available columns in table 'ptd':
 * @property string $id
 * @property integer $ano
 * @property integer $semestre
 * @property string $usuario_id
 * @property string $curso_id
 *
 * The followings are the available model relations:
 * @property Curso $curso
 * @property Usuario $usuario
 * @property PtdHasAtividade[] $ptdHasAtividades
 */
class PTD extends ActiveRecord
{
	public static $TURNO = array(
		'Seg' => array(
			'M'=>array(1=>1,2=>2,3=>3,4=>4,5=>5),
			'T'=>array(1=>6,2=>7,3=>8,4=>9,5=>10),
			'N'=>array(1=>11,2=>12,3=>13,4=>14,5=>15),
		),
		'Ter' => array(
			'M'=>array(1=>16,2=>17,3=>18,4=>19,5=>20),
			'T'=>array(1=>21,2=>22,3=>23,4=>24,5=>25),
			'N'=>array(1=>26,2=>27,3=>28,4=>29,5=>30),
		),
		'Qua' => array(
			'M'=>array(1=>31,2=>32,3=>33,4=>34,5=>35),
			'T'=>array(1=>36,2=>37,3=>38,4=>39,5=>40),
			'N'=>array(1=>41,2=>42,3=>43,4=>44,5=>45),
		),
		'Qui' => array(
			'M'=>array(1=>46,2=>47,3=>48,4=>49,5=>50),
			'T'=>array(1=>51,2=>52,3=>53,4=>54,5=>55),
			'N'=>array(1=>56,2=>57,3=>58,4=>59,5=>60),
		),
		'Sex' => array(
			'M'=>array(1=>61,2=>62,3=>63,4=>64,5=>65),
			'T'=>array(1=>66,2=>67,3=>68,4=>69,5=>70),
			'N'=>array(1=>71,2=>72,3=>73,4=>74,5=>75),
		),
		'Sab' => array(
			'M'=>array(1=>76,2=>77,3=>78,4=>79,5=>80),
			'T'=>array(1=>81,2=>82,3=>83,4=>84,5=>85),
			'N'=>array(1=>86,2=>87,3=>88,4=>89,5=>90),
		),
		'Dom' => array(
			'M'=>array(1=>91,2=>92,3=>93,4=>94,5=>95),
			'T'=>array(1=>96,2=>97,3=>98,4=>99,5=>100),
			'N'=>array(1=>101,2=>102,3=>103,4=>104,5=>105),
		),
	);
	
	public static function turno_dia($t) {
		if (in_array($t, self::$TURNO['Seg']['M']) || 
			in_array($t, self::$TURNO['Seg']['T']) || 
			in_array($t, self::$TURNO['Seg']['N'])) {
			return 'SEG ';	
		} else if (
			in_array($t, self::$TURNO['Ter']['M']) || 
			in_array($t, self::$TURNO['Ter']['T']) || 
			in_array($t, self::$TURNO['Ter']['N'])) {
			return 'TER ';	
		} elseif (
			in_array($t, self::$TURNO['Qua']['M']) || 
			in_array($t, self::$TURNO['Qua']['T']) || 
			in_array($t, self::$TURNO['Qua']['N'])) {
			return 'QUA ';	
		} else if (
			in_array($t, self::$TURNO['Qui']['M']) || 
			in_array($t, self::$TURNO['Qui']['T']) || 
			in_array($t, self::$TURNO['Qui']['N'])) {
			return 'QUI ';	
		} else if (
			in_array($t, self::$TURNO['Sex']['M']) || 
			in_array($t, self::$TURNO['Sex']['T']) || 
			in_array($t, self::$TURNO['Sex']['N'])) {
			return 'SEX ';	
		} else if (
			in_array($t, self::$TURNO['Sab']['M']) || 
			in_array($t, self::$TURNO['Sab']['T']) || 
			in_array($t, self::$TURNO['Sab']['N'])) {
			return 'SAB ';	
		} else if (
			in_array($t, self::$TURNO['Dom']['M']) || 
			in_array($t, self::$TURNO['Dom']['T']) || 
			in_array($t, self::$TURNO['Dom']['N'])) {
			return 'DOM ';	
		}
	}
	
	public static function turno_hora($t) {
		switch ($t) {
			case self::$TURNO['Seg']['M'][1]:
			case self::$TURNO['Ter']['M'][1]:
			case self::$TURNO['Qua']['M'][1]:
			case self::$TURNO['Qui']['M'][1]:
			case self::$TURNO['Sex']['M'][1]:
			case self::$TURNO['Sab']['M'][1]:
			case self::$TURNO['Dom']['M'][1]: 
				return '07h30 às 08h15';
			
			case self::$TURNO['Seg']['M'][2]:
			case self::$TURNO['Ter']['M'][2]:
			case self::$TURNO['Qua']['M'][2]:
			case self::$TURNO['Qui']['M'][2]:
			case self::$TURNO['Sex']['M'][2]:
			case self::$TURNO['Sab']['M'][2]:
			case self::$TURNO['Dom']['M'][2]:
				return '08h15 às 09h00';
			
			case self::$TURNO['Seg']['M'][3]:
			case self::$TURNO['Ter']['M'][3]:
			case self::$TURNO['Qua']['M'][3]:
			case self::$TURNO['Qui']['M'][3]:
			case self::$TURNO['Sex']['M'][3]:
			case self::$TURNO['Sab']['M'][3]:
			case self::$TURNO['Dom']['M'][3]:
				return '09h00 às 09h45';
			
			case self::$TURNO['Seg']['M'][4]:
			case self::$TURNO['Ter']['M'][4]:
			case self::$TURNO['Qua']['M'][4]:
			case self::$TURNO['Qui']['M'][4]:
			case self::$TURNO['Sex']['M'][4]:
			case self::$TURNO['Sab']['M'][4]:
			case self::$TURNO['Dom']['M'][4]:
				return '10h10 às 10h55';
				
			case self::$TURNO['Seg']['M'][5]:
			case self::$TURNO['Ter']['M'][5]:
			case self::$TURNO['Qua']['M'][5]:
			case self::$TURNO['Qui']['M'][5]:
			case self::$TURNO['Sex']['M'][5]:
			case self::$TURNO['Sab']['M'][5]:
			case self::$TURNO['Dom']['M'][5]:
				return '10h55 às 11h40';
				
			case self::$TURNO['Seg']['T'][1]:
			case self::$TURNO['Ter']['T'][1]:
			case self::$TURNO['Qua']['T'][1]:
			case self::$TURNO['Qui']['T'][1]:
			case self::$TURNO['Sex']['T'][1]:
			case self::$TURNO['Sab']['T'][1]:
			case self::$TURNO['Dom']['T'][1]:
				return '13h30 às 14h15';
			
			case self::$TURNO['Seg']['T'][2]:
			case self::$TURNO['Ter']['T'][2]:
			case self::$TURNO['Qua']['T'][2]:
			case self::$TURNO['Qui']['T'][2]:
			case self::$TURNO['Sex']['T'][2]:
			case self::$TURNO['Sab']['T'][2]:
			case self::$TURNO['Dom']['T'][2]:
				return '14h15 às 15h00';
			
			case self::$TURNO['Seg']['T'][3]:
			case self::$TURNO['Ter']['T'][3]:
			case self::$TURNO['Qua']['T'][3]:
			case self::$TURNO['Qui']['T'][3]:
			case self::$TURNO['Sex']['T'][3]:
			case self::$TURNO['Sab']['T'][3]:
			case self::$TURNO['Dom']['T'][3]:
				return '15h00 às 15h45';
			
			case self::$TURNO['Seg']['T'][4]:
			case self::$TURNO['Ter']['T'][4]:
			case self::$TURNO['Qua']['T'][4]:
			case self::$TURNO['Qui']['T'][4]:
			case self::$TURNO['Sex']['T'][4]:
			case self::$TURNO['Sab']['T'][4]:
			case self::$TURNO['Dom']['T'][4]:
				return '16h10 às 16h55';
			
			case self::$TURNO['Seg']['T'][5]:
			case self::$TURNO['Ter']['T'][5]:
			case self::$TURNO['Qua']['T'][5]:
			case self::$TURNO['Qui']['T'][5]:
			case self::$TURNO['Sex']['T'][5]:
			case self::$TURNO['Sab']['T'][5]:
			case self::$TURNO['Dom']['T'][5]:
				return '16h55 às 17h40';
			
			case self::$TURNO['Seg']['N'][1]:
			case self::$TURNO['Ter']['N'][1]:
			case self::$TURNO['Qua']['N'][1]:
			case self::$TURNO['Qui']['N'][1]:
			case self::$TURNO['Sex']['N'][1]:
			case self::$TURNO['Sab']['N'][1]:
			case self::$TURNO['Dom']['N'][1]:
				return '19h05 às 19h30';
			
			case self::$TURNO['Seg']['N'][2]:
			case self::$TURNO['Ter']['N'][2]:
			case self::$TURNO['Qua']['N'][2]:
			case self::$TURNO['Qui']['N'][2]:
			case self::$TURNO['Sex']['N'][2]:
			case self::$TURNO['Sab']['N'][2]:
			case self::$TURNO['Dom']['N'][2]:
				return '19h30 às 20h20';
			
			case self::$TURNO['Seg']['N'][3]:
			case self::$TURNO['Ter']['N'][3]:
			case self::$TURNO['Qua']['N'][3]:
			case self::$TURNO['Qui']['N'][3]:
			case self::$TURNO['Sex']['N'][3]:
			case self::$TURNO['Sab']['N'][3]:
			case self::$TURNO['Dom']['N'][3]:
				return '20h20 às 21h10';
			
			case self::$TURNO['Seg']['N'][4]:
			case self::$TURNO['Ter']['N'][4]:
			case self::$TURNO['Qua']['N'][4]:
			case self::$TURNO['Qui']['N'][4]:
			case self::$TURNO['Sex']['N'][4]:
			case self::$TURNO['Sab']['N'][4]:
			case self::$TURNO['Dom']['N'][4]:
				return '21h25 às 22h15';
			
			case self::$TURNO['Seg']['N'][5]:
			case self::$TURNO['Ter']['N'][5]:
			case self::$TURNO['Qua']['N'][5]:
			case self::$TURNO['Qui']['N'][5]:
			case self::$TURNO['Sex']['N'][5]:
			case self::$TURNO['Sab']['N'][5]:
			case self::$TURNO['Dom']['N'][5]:
				return '22h15 às 23h05';
			default: return '';
		}
	}

	public static function turno_txt($t) {
		return self::turno_dia($t) . self::turno_hora($t);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'ptd';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ano, semestre, usuario_id, curso_id', 'required'),
			array('ano, semestre', 'numerical', 'integerOnly'=>true),
			array('usuario_id, curso_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ano, semestre, usuario_id, curso_id', 'safe', 'on'=>'search'),
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
			'curso' => array(self::BELONGS_TO, 'Curso', 'curso_id'),
			'usuario' => array(self::BELONGS_TO, 'Usuario', 'usuario_id'),
			'atividades' => array(self::HAS_MANY, 'PTDAtividade', 'ptd_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ano' => 'Ano',
			'semestre' => 'Semestre',
			'usuario_id' => 'Usuário',
			'curso_id' => 'Curso',
		);
	}

	public function toString()
	{
		return $this->usuario->toString() . ' (' . $this->ano . '-' . $this->semestre . ')';
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
		
		$criteria->with = array('usuario','curso');
        $criteria->together = true;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('ano',$this->ano);
		$criteria->compare('semestre',$this->semestre);
		$criteria->compare('usuario_id',$this->usuario_id,true);
		$criteria->compare('curso_id',$this->curso_id,true);
		
		if (isset($_GET['PTD'])) {
			$this->unsetAttributes();  // clear any default values
			$this->attributes=$_GET['PTD'];
			$this->globalSearch=$_GET['PTD']['globalSearch'];

			$criteria->addSearchCondition('curso.nome', $this->globalSearch, true, 'OR');
			$criteria->addSearchCondition('usuario.nome', $this->globalSearch, true, 'OR');
			$criteria->addSearchCondition('ano', $this->globalSearch, true, 'OR');
			$criteria->addSearchCondition('semestre', $this->globalSearch, true, 'OR');
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PTD the static model class
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
