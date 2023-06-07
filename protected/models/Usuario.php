<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $id
 * @property string $nome
 * @property string $senha
 * @property string $papel
 * @property integer $professor_id
 * @property integer $aluno_id
 * @property integer $instituicao_id
 *
 * The followings are the available model relations:
 * @property Professor $professor
 * @property Aluno $aluno
 * @property Instituicao $instituicao
 */
class Usuario extends ActiveRecord
{
	// holds the password confirmation word
    public $repeat_senha;
 
    //will hold the encrypted password for update actions.
    public $initialPassword;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->params['tablePrefix'] . 'usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, senha, papel', 'required'),
			array('professor_id, aluno_id, instituicao_id', 'numerical', 'integerOnly'=>true),
			array('nome, senha', 'length', 'max'=>20),
			array('papel', 'length', 'max'=>10),
			//password and repeat password
            array('senha, repeat_senha', 'required', 'on'=>'insert'),
            array('senha, repeat_senha', 'length', 'min'=>3, 'max'=>20),
            array('senha', 'compare', 'compareAttribute'=>'repeat_senha'),
			array('nome','unique', 'className' => 'Usuario'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, senha, papel, professor_id, aluno_id, instituicao_id', 'safe', 'on'=>'search'),
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
			'professor' => array(self::BELONGS_TO, 'Professor', 'professor_id'),
			'aluno' => array(self::BELONGS_TO, 'Aluno', 'aluno_id'),
			'instituicao' => array(self::BELONGS_TO, 'Instituicao', 'instituicao_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nome' => 'Nome de Usuário',
			'senha' => 'Senha',
			'repeat_senha' => 'Repetir Senha',
			'papel' => 'Papel',
			'professor_id' => 'Professor',
			'aluno_id' => 'Aluno',
			'instituicao_id' => 'Instituição',
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
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('senha',$this->senha,true);
		$criteria->compare('papel',$this->papel,true);
		$criteria->compare('professor_id',$this->professor_id);
		$criteria->compare('aluno_id',$this->aluno_id);
		$criteria->compare('instituicao_id',$this->instituicao_id);
		
		if (isset($_GET['Usuario'])) {
			$this->unsetAttributes();  // clear any default values
			$this->attributes=$_GET['Usuario'];
		}
		
		if (isset($_GET['Usuario']['globalSearch'])) {
			$this->globalSearch=$_GET['Usuario']['globalSearch'];

			$criteria->addISearchCondition('t.nome', $this->globalSearch, true, 'OR');
			$criteria->addISearchCondition('professor.nome', $this->globalSearch, true, 'OR');
			$criteria->addISearchCondition('aluno.nome', $this->globalSearch, true, 'OR');
			$criteria->addISearchCondition('instituicao.nome', $this->globalSearch, true, 'OR');
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function toString()
	{
		switch ($this->papel) {
			case UserIdentity::ROLE_PROFE:
			case UserIdentity::ROLE_COPE:
				return $this->professor->nome;
				
			case UserIdentity::ROLE_INSTI:
				return $this->instituicao->nome;
				
			case UserIdentity::ROLE_ALUNO:
				return $this->aluno->nome;
				
			case UserIdentity::ROLE_ADMIN:
				return 'Administrador';
				
			default:
				return $this->nome;
				
		}
	}
	
	public function getText() {
		return $this->toString() . ' ('.$this->papel.' | '.$this->nome.')';
	}
	
	public function getPerfil() {
		switch ($this->papel) {
			case UserIdentity::ROLE_PROFE:
			case UserIdentity::ROLE_COPE:
				return $this->professor;
				
			case UserIdentity::ROLE_INSTI:
				return $this->instituicao;
				
			case UserIdentity::ROLE_ALUNO:
				return $this->aluno;
				
			default:
				return null;
				
		}
	}
	

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function beforeSave() {
		// in this case, we will use the old hashed password.
        // if(empty($this->password) && empty($this->repeat_password) && !empty($this->initialPassword))
            // $this->password=$this->repeat_password=$this->initialPassword;
        // Cript. da senha:
		$salt = openssl_random_pseudo_bytes(22);
		$salt = '$2a$%13$' . strtr($salt, array('_' => '.', '~' => '/'));
		
		//add the password hash if it's a new record
        if ($this->getIsNewRecord())
        {
            //creates the password hash from the plaintext password
            $this->senha = crypt($this->senha, $salt);                         
        }       
        else if (!empty($this->senha)&&!empty($this->repeat_senha)&&($this->senha===$this->repeat_senha)) 
        //if it's not a new password, save the password only if it not empty and the two passwords match
        {
            $this->senha = crypt($this->senha, $salt);
        }
		
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
 
    public function afterFind()
    {
        //reset the password to null because we don't want the hash to be shown.
        $this->initialPassword = $this->senha;
        $this->senha = null;
 
        parent::afterFind();
    }
}
