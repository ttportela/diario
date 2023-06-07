<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {
	private $_id;
	
	const ROLE_ADMIN = 'admin';
	const ROLE_PROFE = 'profe';
	const ROLE_ALUNO = 'aluno';
	const ROLE_INSTI = 'insti';
	const ROLE_COPE  = 'cope';

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
		$record = Usuario::model()->findByAttributes(array('nome' => $this->username));
		
		if ($record === null)
			$this -> errorCode = self::ERROR_USERNAME_INVALID;
		else if ($record->initialPassword !== crypt($this->password, $record->initialPassword))
			$this -> errorCode = self::ERROR_PASSWORD_INVALID;
		else {
			$this -> _id = $record -> id;
			$this -> setState('papel', $record->papel);
			
			if ($record->papel == self::ROLE_PROFE) 
			{
				$this -> setState('papel_id', $record->professor->id);
			} else if ($record->papel == self::ROLE_ALUNO) 
			{
				$this -> setState('papel_id', $record->aluno->id);
			} else if ($record->papel == self::ROLE_INSTI) 
			{
				$this -> setState('papel_id', $record->instituicao->id);
			} else if ($record->papel == self::ROLE_COPE) 
			{
				$this -> setState('papel_id', $record->professor->id);
			} else if ($record->papel == self::ROLE_ADMIN) 
			{
				$this -> setState('papel_id', self::ROLE_ADMIN);
				// $this -> setState('isAdmin', true);
			}
			
			$this -> errorCode = self::ERROR_NONE;
		}
		return !$this -> errorCode;
	}

	public function getId() {
		return $this -> _id;
	}
	
	// public function getIsAdmin() {
		// return !$this->isGuest && $this->papel == self::ROLE_ADMIN;
	// }

	// public function authenticate()
	// {
	// $users=array(
	// // username => password
	// 'demo'=>'demo',
	// 'admin'=>'admin',
	// );
	// if(!isset($users[$this->username]))
	// $this->errorCode=self::ERROR_USERNAME_INVALID;
	// elseif($users[$this->username]!==$this->password)
	// $this->errorCode=self::ERROR_PASSWORD_INVALID;
	// else
	// $this->errorCode=self::ERROR_NONE;
	// return !$this->errorCode;
	// }

}
