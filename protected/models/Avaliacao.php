<?php

/**
 * This is the model class for table "dia_avaliacao".
 *
 * The followings are the available columns in table 'dia_avaliacao':
 * @property integer $id
 * @property string $nome
 * @property integer $bimestre
 * @property integer $peso
 * @property integer $notamaxima
 * @property integer $turma_id
 *
 * The followings are the available model relations:
 * @property DiaTurma $turma
 * @property DiaAluno[] $diaAlunos
 */
class Avaliacao extends ActiveRecord
{
	
	public static $BIM_1 = 1;
	public static $BIM_2 = 2;
	public static $EXAME = 0;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'avaliacao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, bimestre, peso, notamaxima, turma_id', 'required'),
			array('bimestre, peso, notamaxima, turma_id', 'numerical', 'integerOnly'=>true),
			array('nome', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, bimestre, peso, notamaxima, turma_id', 'safe', 'on'=>'search'),
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
			'avaliacoes' => array(self::HAS_MANY, 'AvaliacaoAluno', 'avaliacao_id'),
			// 'avaliacoes' => array(self::MANY_MANY, 'AvalicaoAluno', Yii::app()->params['tablePrefix'] . 'avaliacao_has_aluno(avaliacao_id, aluno_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'this' => 'Avaliação',
			'id' => 'ID',
			'nome' => 'Nome',
			'bimestre' => 'Bimestre',
			'peso' => 'Peso',
			'notamaxima' => 'Nota Máxima',
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
		
		$criteria->with = array('turma');
		$criteria->together = true;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.nome',$this->nome,true);
		$criteria->compare('t.bimestre',$this->bimestre);
		$criteria->compare('t.peso',$this->peso);
		$criteria->compare('t.notamaxima',$this->notamaxima);
		$criteria->compare('t.turma_id',$this->turma_id);

		if (Yii::app()->user->papel == UserIdentity::ROLE_PROFE) {
			$criteria->compare('turma.professor_id',Yii::app()->user->papel_id, true);
		} else if (Yii::app()->user->papel == UserIdentity::ROLE_INSTI) {
			// TODO selecionar da instituição apenas
		}

		$criteria->order = "turma.ano DESC, turma.semestre DESC, t.bimestre DESC";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Avaliacao the static model class
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
	
	public function nota($aluno)
	{
		// Yii::app()->helper->trace($this->avaliacoes);
		foreach ($this->avaliacoes as $avaliacao) {
			// echo var_dump($this->avaliacoes);
			if ($avaliacao->aluno_id == $aluno->id) {
				if ($avaliacao->nota < 0) break;
				return $avaliacao;
			}
		}
		return null;
	}
	
	public function stars($aluno)
	{
		$itav = $this->nota($aluno);	
							
		if (!Yii::app()->helper->set($itav) || (!($itav->nota > 0) && !Yii::app()->helper->set($itav->observacoes))) {
			return 0; 
		} else if (!($itav->nota > 0) && Yii::app()->helper->set($itav->observacoes)) {
			return 1; 
		} else {
			return 2; 
		}
	}
	
	public function notaBase($aluno)
	{
		$itemAv = $this->nota($aluno);	
		return (isset($itemAv))? $itemAv->nota : 0;
	}
	
	public function notaBase10($aluno)
	{
		$itemAv = $this->nota($aluno);	
		return (isset($itemAv))? ($itemAv->nota * 10)/$this->notamaxima : 0;
	}
	
	/*public static function mediaBimestral($avaliacoes, $aluno, $bimestre, $arredondar=false) {
		$soma = 0;
		$nroAv = 0;
		foreach ($avaliacoes as $av) {
			if ($av->bimestre == $bimestre) {
				$soma += $av->notaBase10($aluno);
				$nroAv++;
			}
		}
		$media = ($nroAv > 0)? $soma / $nroAv : 0;
		return ($arredondar)? $this->roundUp($media) : $media;
	}*/
	
	public static function roundUp($val){
	    $auxReal = (($val*100) % 100);
	    $auxInt = intval($val);
		
		if ($auxReal < 50 && $auxReal >= 25) {
			$auxReal = 50;
		} else if ($auxReal < 100 && $auxReal >= 75) {
			$auxReal = 100;
		}
		
		return $auxInt + ($auxReal / 100);
	}
}
