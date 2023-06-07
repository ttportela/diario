<?php

/**
 * This is the model class for table "turma".
 *
 * The followings are the available columns in table 'turma':
 * @property integer $id
 * @property integer $ano
 * @property integer $semestre
 * @property string $classe
 * @property integer $chrelogio
 * @property integer $chaula
 * @property string $horarios
 * @property string $observacoes
 * @property integer $professor_id
 * @property integer $disciplina_id
 *
 * The followings are the available model relations:
 * @property Avaliacao[] $avaliacaos
 * @property Diario[] $diarios
 * @property Professor $professor
 * @property Disciplina $disciplina
 * @property Aluno[] $alunos
 */
class Turma extends ActiveRecord	
{
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'turma';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ano, semestre, chrelogio, chaula, professor_id, disciplina_id', 'required'),
			// array('nome, ano, semestre, chrelogio, chaula, professor_id, disciplina_id', 'required'),
			array('ano, semestre, chrelogio, chaula, professor_id, disciplina_id, publicarpe', 'numerical', 'integerOnly'=>true),
			// array('nome', 'length', 'max'=>50),
			array('classe, professor_id, disciplina_id, sala_id', 'length', 'max'=>20),
			array('horarios', 'length', 'max'=>100),
			array('observacoes', 'length', 'max'=>400),
			array('objetivosgerais, objetivosespecificos, conteudo, metodologia, recursos, bibcomplementar', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			// array('id, nome, ano, semestre, classe, chrelogio, chaula, horarios, observacoes, professor_id, disciplina_id', 'safe', 'on'=>'search'),
			array('id, ano, semestre, classe, chrelogio, chaula, horarios, observacoes, professor_id, disciplina_id, objetivosgerais, objetivosespecificos, conteudo, metodologia, recursos, bibcomplementar, publicarpe, sala_id', 'safe', 'on'=>'search'),
			// To related alunos
			array('aluno_ids', 'type', 'type' => 'array', 'allowEmpty' => true),
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
			'avaliacoes' => array(self::HAS_MANY, 'Avaliacao', 'turma_id'),
			'diarios' => array(self::HAS_MANY, 'Diario', 'turma_id'),
			'professor' => array(self::BELONGS_TO, 'Professor', 'professor_id'),
			'disciplina' => array(self::BELONGS_TO, 'Disciplina', 'disciplina_id'),
			'alunos' => array(self::MANY_MANY, 'Aluno', Yii::app()->params['tablePrefix'] . 'turma_has_aluno(turma_id, aluno_id)','order'=>'alunos.nome ASC'),
			'relatedAlunos' => array(self::HAS_MANY, 'TurmaAluno', 'turma_id'),
			'sala' => array(self::BELONGS_TO, 'Sala', 'sala_id'),
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
			'ano' => 'Ano',
			'semestre' => 'Semestre',
			'classe' => 'Classe',
			'chrelogio' => 'Carga Horária Relógio',
			'chaula' => 'Carga Horária Aulas',
			'horarios' => 'Horários',
			'observacoes' => 'Observações',
			'professor_id' => 'Professor',
			'disciplina_id' => 'Disciplina',
			'avaliacoes' => 'Avaliação',
			'notamedia' => 'Média',
			'nroap' => 'Aprovados',
			'nrorp' => 'Reprovados',
			'objetivosgerais' => 'Objetivos Gerais',
			'objetivosespecificos' => 'Objetivos Específicos',
			'conteudo' => 'Conteúdo',
			'metodologia' => 'Metodologia',
			'recursos' => 'Recursos Didáticos',
			'bibcomplementar' => 'Bibliografia Complementar',
			'publicarpe' => 'Publicar Plano de Ensino?',
			'sala_id' => 'Ensalamento',
			'aluno_ids' => 'Alunos',
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
		
		$criteria->with = array('professor','disciplina');
        $criteria->together = true;

		$criteria->compare('t.id',$this->id);
		// $criteria->compare('t.nome',$this->nome,true);
		$criteria->compare('t.ano',$this->ano);
		$criteria->compare('t.semestre',$this->semestre);
		$criteria->compare('t.classe',$this->classe,true);
		$criteria->compare('t.chrelogio',$this->chrelogio);
		$criteria->compare('t.chaula',$this->chaula);
		$criteria->compare('t.horarios',$this->horarios,true);
		$criteria->compare('t.observacoes',$this->observacoes,true);
		$criteria->compare('t.disciplina_id',$this->disciplina_id);
		
		$criteria->compare('objetivosgerais',$this->objetivosgerais,true);
		$criteria->compare('objetivosespecificos',$this->objetivosespecificos,true);
		$criteria->compare('conteudo',$this->conteudo,true);
		$criteria->compare('metodologia',$this->metodologia,true);
		$criteria->compare('recursos',$this->recursos,true);
		$criteria->compare('bibcomplementar',$this->bibcomplementar,true);
		$criteria->compare('publicarpe',$this->publicarpe);
		
		$criteria->compare('sala_id',$this->sala_id,true);
		
		if (isset($_GET['Turma'])) {
			$this->unsetAttributes();  // clear any default values
			$this->attributes=$_GET['Turma'];
		}
		
		if (isset($_GET['Turma']['globalSearch'])) {
			$this->globalSearch=$_GET['Turma']['globalSearch'];
			$criteria->addISearchCondition('t.nome', $this->globalSearch, true, 'OR');
			$criteria->addISearchCondition('professor.nome', $this->globalSearch, true, 'OR');
			$criteria->addISearchCondition('disciplina.nome', $this->globalSearch, true, 'OR');
			$criteria->addISearchCondition('t.ano', $this->globalSearch, true, 'OR');
			$criteria->addISearchCondition('t.semestre', $this->globalSearch, true, 'OR');
		}
		
		if (Yii::app()->user->papel == UserIdentity::ROLE_PROFE) {
			$criteria->compare('t.professor_id',Yii::app()->user->papel_id, true);
		} else if (Yii::app()->user->papel == UserIdentity::ROLE_INSTI) {
			// TODO selecionar as turmas da instituição apenas
		} else {
			$criteria->compare('t.professor_id',$this->professor_id);
		}

		$criteria->order = "t.ano DESC, t.semestre DESC";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Turma the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function behaviors()
    {
        // return array('ESaveRelatedBehavior' => array(
                // 'class' => 'application.components.ESaveRelatedBehavior')
        // );
		return array(
	        'withRelated'=>array(
	            'class'=>'ext.wr.WithRelatedBehavior',
	        ),
	    );
    }
	
	public function limiteFaltas()
    {
    	return $this->chaula / 4;
	}
	
	public function faltas($aluno)
    {
    	$faltas = 0;
    	foreach ($this->diarios as $d) {
			$faltas = $faltas + $d->getFrequencia($aluno)->faltas;
		}
		return $faltas;
	}
	
	public function getNome() {
		if (!isset($this->id)) return null;
		return $this->ano ."-". $this->semestre ." - ". $this->disciplina->nome;
	}
	
	public function getNotamedia() {
		if ( !isset($this->avaliacoes) || !isset($this->alunos)
				|| empty($this->avaliacoes) || empty($this->alunos) ) return 'Não Disponível';
		
		$notaMedia = 0;
		$ct = 0;
		foreach ($this->alunos as $aluno) {
			$notaMedia += $aluno->mediaFinal($this);
			$ct++;
		}
		
		return Yii::app()->format->number($notaMedia / $ct);
	}
	
	public function getNroap() {
		if ( !isset($this->avaliacoes) || !isset($this->alunos)
				|| empty($this->avaliacoes) || empty($this->alunos) ) return 'Não Disponível';
		
		$ct = 0;
		foreach ($this->alunos as $aluno) {
			$resultado = $aluno->resultado($this);
			if ($resultado[2])
				$ct++;
		}
		
		return $ct;
	}
	
	public function getNrorp() {
		if ( !isset($this->avaliacoes) || !isset($this->alunos)
				|| empty($this->avaliacoes) || empty($this->alunos) ) return 'Não Disponível';
		
		$ct = 0;
		foreach ($this->alunos as $aluno) {
			$resultado = $aluno->resultado($this);
			if (!$resultado[2])
				$ct++;
		}
		
		return $ct;
	}
	
	public function getExame() {
		
		foreach ($this->avaliacoes as $av) {
			if ($av->bimestre == Avaliacao::$EXAME) {
				return $av;
			}
		}
		
		return null;
	}
	
	public function horarios_txt() {
		if ($this->horarios[0] == '@') {
			$txt = '';
			for ($i = 1 ; $i <= ($this->chaula/20); $i++ ) {
				$txt .= PTD::turno_txt($this->horarios[$i]);
			}
			return $txt;
		} else {
			$this->horarios[$c];
		}
	}
	
	public $aluno_stored_ids = array();
  	public $aluno_ids = array();
	
	public function afterFind() {
		$this->setAttribute('nome',$this->getNome());
		
		$this->aluno_ids = array();
        foreach ($this->relatedAlunos as $r) {
            $this->aluno_ids[] = $r->aluno_id;
        }
 
        $this->aluno_stored_ids = $this->aluno_ids;
		
		return parent::afterFind();
	}
 
    public function afterSave() {
        if (!$this->aluno_ids) //if nothing selected set it as an empty array
            $this->aluno_ids = array();
 
        //save the new selected ids that are not exist in the stored ids
        $ids_to_update = array_diff($this->aluno_ids, $this->aluno_stored_ids);
 
 		// Yii::app()->helper->trace($ids_to_update);
 
        foreach ($ids_to_update as $uid) {
            $p = TurmaAluno::model()->findByAttributes(array('aluno_id'=>$uid,'turma_id'=>$this->id)); 
            if (!$p) {
            	$p = new TurmaAluno;
            }
            $p->turma_id = $this->id;
			$p->aluno_id = $uid;
            $p->save();
        }
 
 
        //remove the stored ids that are not exist in the selected ids
        $ids_to_remove = array_diff($this->aluno_stored_ids, $this->aluno_ids);
 
 
        foreach ($ids_to_remove as $did) {            
            if ($p = TurmaAluno::model()->findByAttributes(array('aluno_id'=>$did,'turma_id'=>$this->id))) {
                
				// Remove Avaliações
				$criteria=new CDbCriteria;
		
				$criteria->with = array('aluno','avaliacao');
			    $criteria->together = true;
			
				$criteria->compare('aluno.id',$p->aluno_id,true);
				$criteria->compare('avaliacao.turma_id',$this->id,true);
				
				$avs = AvaliacaoAluno::model()->findAll($criteria);
				foreach ($avs as $av) {
					$av->delete();
				}
				
				// Remove Frequências
				$criteria=new CDbCriteria;
		
				$criteria->with = array('aluno','diario');
			    $criteria->together = true;
			
				$criteria->compare('aluno.id',$p->aluno_id,true);
				$criteria->compare('diario.turma_id',$this->id,true);
				
				$freqs = Frequencia::model()->findAll($criteria);
				foreach ($freqs as $f) {
					$f->delete();
				}	
				
                $p->delete();
				
            }
        }
 
        parent::afterSave();
    }
	
}
