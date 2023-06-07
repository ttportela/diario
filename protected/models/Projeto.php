<?php

/**
 * This is the model class for table "projeto".
 *
 * The followings are the available columns in table 'projeto':
 * @property string $id
 * @property integer $status
 * @property string $nroprocesso
 * @property string $inicio
 * @property string $fim
 * @property string $documento_id
 *
 * The followings are the available model relations:
 * @property Interessado[] $interessados
 * @property Parecer[] $parecers
 * @property Documento $documento
 * @property Relatorio[] $relatorios
 */
class Projeto extends ActiveRecord
{
	
	const STATUS_NOVO			= 0; // Novo
	const STATUS_REC			= 5; // Recebido
	const STATUS_AP				= 10; // Aprovado
	const STATUS_APP			= 15; // Aprovado com Pendências
	const STATUS_RP				= 20; // Reprovado
	const STATUS_EX				= 25; // Excluído
	const STATUS_FN				= 30; // Finalizado
	
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return Yii::app()->params['tablePrefix'] . 'projeto';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('inicio, status', 'required'),
            array('status', 'numerical', 'integerOnly'=>true),
            array('documento_id', 'length', 'max'=>20),
            array('nroprocesso, fim', 'safe'),
            array('inicio','default',
              'value'=>new CDbExpression('NOW()'),
              'setOnEmpty'=>true,'on'=>'insert'),
            array('status','default',
              'value'=>self::STATUS_NOVO,
              'setOnEmpty'=>true,'on'=>'insert'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, status, nroprocesso, inicio, fim, documento_id', 'safe', 'on'=>'search'),
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
            'interessados' => array(self::HAS_MANY, 'Interessado', 'projeto_id'),
            'coordenador' => array(self::HAS_ONE, 'Interessado', 'projeto_id',
								'condition'=>'??.funcao = '.Interessado::FUNC_COORD),
            'vice' => array(self::HAS_ONE, 'Interessado', 'projeto_id',
								'condition'=>'??.funcao = '.Interessado::FUNC_VICE),
            'docentes' => array(self::HAS_ONE, 'Interessado', 'projeto_id',
								'condition'=>'??.funcao = '.Interessado::FUNC_COL_DOC),
            'discentes' => array(self::HAS_ONE, 'Interessado', 'projeto_id',
								'condition'=>'??.funcao = '.Interessado::FUNC_COL_DIS),
            'pareceres' => array(self::HAS_MANY, 'Parecer', 'projeto_id'),
            'documento' => array(self::BELONGS_TO, 'Documento', 'documento_id'),
            'relatorios' => array(self::HAS_MANY, 'Relatorio', 'projeto_id'),
        );
    }
	
	public function defaultScope() {
		if (Yii::app()->user->papel == UserIdentity::ROLE_PROFE) {
		    return array(
		        'with'=> array("interessados" => array(
			        'condition'=> "interessados.professor_id = :pid",
			        'on'=>"interessados.projeto_id = t.id",
			        'params'=>array(':pid'=>Yii::app()->user->papel_id),
			        'order' => 'inicio DESC',
			    ))
		    );
		} else {
			return array(
		        'order' => 'inicio DESC',
		    );
		}
	}

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'status' => 'Status',
            'nroprocesso' => 'Número no SIPAC',
            'inicio' => 'Data de Início',
            'fim' => 'Data de Encerramento',
            'documento_id' => 'Documento',
            'coordenador' => 'Coordenador',
            'vice' => 'Vice - Coordenador',
            'docentes' => 'Colaboradores Docentes ou Técnicos  Administrativos',
            'discentes' => 'Colaboradores Discentes',
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
        $criteria->compare('status',$this->status);
        $criteria->compare('nroprocesso',$this->nroprocesso,true);
        $criteria->compare('inicio',$this->inicio,true);
        $criteria->compare('fim',$this->fim,true);
        $criteria->compare('documento_id',$this->documento_id,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Projeto the static model class
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
