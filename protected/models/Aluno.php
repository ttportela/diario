<?php

/**
 * This is the model class for table "aluno".
 *
 * The followings are the available columns in table 'aluno':
 * @property integer $id
 * @property string $nome
 * @property string $ra
 * @property string $email
 * @property integer $instituicao_id
 *
 * The followings are the available model relations:
 * @property Instituicao $instituicao
 * @property Avaliacao[] $avaliacaos
 * @property Diario[] $diarios
 * @property Turma[] $turmas
 * @property Usuario[] $usuarios
 */
class Aluno extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'aluno';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instituicao_id', 'required'),
			array('instituicao_id', 'numerical', 'integerOnly'=>true),
			array('nome, email', 'length', 'max'=>50),
			array('nome', 'filter', 'filter'=>'trim'),
			array('ra', 'length', 'max'=>20),
			array('ra', 'filter', 'filter'=>'trim'),
			array('ra','unique', 'message'=>'Este ra já foi cadastrado.'),
			array('email','email'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, ra, email, instituicao_id', 'safe', 'on'=>'search'),
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
			'instituicao' => array(self::BELONGS_TO, 'Instituicao', 'instituicao_id'),
			'avaliacaos' => array(self::MANY_MANY, 'Avaliacao', Yii::app()->params['tablePrefix'] . 'avaliacao_has_aluno(aluno_id, avaliacao_id)'),
			'diarios' => array(self::MANY_MANY, 'Diario', Yii::app()->params['tablePrefix'] . 'diario_has_aluno(aluno_id, diario_id)'),
			'turmas' => array(self::MANY_MANY, 'Turma', Yii::app()->params['tablePrefix'] . 'turma_has_aluno(aluno_id, turma_id)', 'order'=>'ano DESC, semestre DESC'),
			'usuarios' => array(self::HAS_MANY, 'Usuario', 'aluno_id'),
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
			'ra' => 'Ra',
			'email' => 'E-mail',
			'instituicao_id' => 'Instituição',
		);
	}
	
	public function toString()
	{
		return $this->nome;
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
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('ra',$this->ra,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('instituicao_id',$this->instituicao_id);
		
		if (isset($_GET['Aluno'])) {
			$this->unsetAttributes();  // clear any default values
			$this->attributes=$_GET['Aluno'];
		}
		
		if (isset($_GET['Aluno']['globalSearch'])) {
			$this->globalSearch=$_GET['Aluno']['globalSearch'];
			$criteria->addISearchCondition('t.nome', $this->globalSearch, true, 'OR');
			$criteria->addISearchCondition('t.ra', $this->globalSearch, true, 'OR');
			$criteria->addISearchCondition('t.email', $this->globalSearch, true, 'OR');			
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Aluno the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave() {
	    // Altera case do nome:
	    $this->nome = Yii::app()->helper->titleCase($this->nome);
	 
	    return parent::beforeSave();
	}
	
	// ------ Funções de Avaliação ------ //
	public function mediaBimestral($turma, $bimestre, $arredondar=false) {
		$soma = 0;
		$nroAv = 0;
		foreach ($turma->avaliacoes as $av) {
			if ($av->bimestre == $bimestre) {
				$soma += $av->notaBase10($this) * $av->peso;
				// $nroAv++;
				$nroAv += $av->peso;
			}
		}
		$media = ($nroAv > 0)? $soma / $nroAv : 0;
		
		if ($arredondar)
			return Avaliacao::roundUp($media);
		else
			return $media;
	}
	
	public function faltas($turma, $bimestre) {
		$criteria=new CDbCriteria(array(
			'condition'=>'turma.id='.$turma->id,
			'order'=>'data ASC',
			'with'=>'turma',
		));
		$lsdiarios = Diario::model()->findAll($criteria);
		
		$faltas = 0;
		$from = 0;
		$to = round(count($lsdiarios) / 2);
		
		if ($bimestre == 2) {
			$from = $to;
			$to = count($lsdiarios);
		}
		
		for ($i = $from ; $i < $to ; $i++ ) {
			$d = $lsdiarios[$i];
			$faltas += $d->getFrequencia($this)->faltas;
		}
		
		return $faltas;
	}
	
	public function totalFaltas($turma, $faltasB1=null, $faltasB2=null) {
		// if ($faltasB1 != null && $faltasB2 != null) {
			// return $faltasB1 + $faltasB2;
		// }
		
		$criteria=new CDbCriteria(array(
			'condition'=>'turma.id='.$turma->id,
			'order'=>'data ASC',
			'with'=>'turma',
		));
		
		$totalFaltas = 0;
		$lsdiarios = Diario::model()->findAll($criteria);
		foreach ($lsdiarios as $d) {
			$totalFaltas += $d->getFrequencia($this)->faltas;
		}
		
		return $totalFaltas;
	}
	
	public function percentualFaltas($turma, $totalFaltas=null) {
		if ($totalFaltas == null)
			$totalFaltas = $this->totalFaltas($turma);
		
		return ($turma->chaula - $totalFaltas)*100/$turma->chaula;
	}
	
	public function mediaParcial($turma, $notaB1=null, $notaB2=null) {
		if ($notaB1 == null)
			$notaB1 = $this->mediaBimestral($turma, 1, true);
		
		if ($notaB2 == null)
			$notaB2 = $this->mediaBimestral($turma, 2, true);
		
		return (($notaB1 + $notaB2) / 2);
	}
	
	public function mediaFinal($turma, $mediaParcial=null, $notaB1=null, $notaB2=null, $porcFaltas=null, $totalFaltas=null) {
		if ($mediaParcial == null)
			$mediaParcial = $this->mediaParcial($turma, $notaB1, $notaB2);
		if ($porcFaltas == null)
			$porcFaltas = $this->percentualFaltas($turma, $totalFaltas);
		
		if ($mediaParcial >= 4 && $mediaParcial < 7 && $porcFaltas >= 75) {
		
			$avExame = $turma->exame;
			
			if (isset($avExame))
				return (($mediaParcial + $avExame->nota($this)->nota) / 2);
			
		}
	
		return $mediaParcial;
	}
	
	public function resultado($turma, $mediaParcial=null, $notaB1=null, $notaB2=null, $porcFaltas=null, $totalFaltas=null) {
		if ($mediaParcial == null)
			$mediaParcial = $this->mediaParcial($turma, $notaB1, $notaB2);
		if ($porcFaltas == null)
			$porcFaltas = $this->percentualFaltas($turma, $totalFaltas);
		
		// Resultado do aluno:
        $resultado = array('Não Disponível', 'N/D', false);

		if ($porcFaltas < 75) {
            $resultado = array("Reprovado por Frequência", "RQ", false); // Reprovado por Frequência
		} else if ($mediaParcial >= 7) {
            $resultado = array("Aprovado por Média", "A", true); // "Aprovado por Média"
        } else if ($mediaParcial < 4) {
            $resultado = array("Reprovado por Média", "R", false); // Reprovado por Média
        } else if ($mediaParcial >= 4 && $mediaParcial < 7) {
            // Exame:
            $avExame = $turma->exame;
            if (!isset($avExame)) {
                $resultado = array("EXAME", "EXAME", false);
            } else {
            	$mediaFinal = $this->mediaFinal($turma, $mediaParcial);
				//$mediaFinal = round($mediaFinal, 1);
				
                if ($mediaFinal >= 5) {
                    $resultado = array("Aprovado na Prova Final", "AF", true); //Aprovado na Prova Final
                } else {
                    $resultado = array("Reprovado na Prova Final", "RF", false); // Reprovado na Prova Final 
                }
            }
        }
		
		return $resultado;
	}
	
	public function emExame($mediaParcial, $porcFaltas) {
		return $porcFaltas >= 75 && $mediaParcial >= 4 && $mediaParcial < 7;
	}

}
