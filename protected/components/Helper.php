<?php
class Helper extends CApplicationComponent {
	
	function checkProfessor($model) {
		return Yii::app()->helper->checkPermission($model->professor->id);
	}
	
	function checkPermission($papel_id) {
		return Yii::app()->helper->isAdmin() || !Yii::app()->user->isGuest 
			&& Yii::app()->user->papel_id == $papel_id;
	}
	
	function isAdmin() {
		return !Yii::app()->user->isGuest && Yii::app()->user->papel == UserIdentity::ROLE_ADMIN;
	}
	
	function user() {
		return Yii::app()->user->isGuest? null : Usuario::model()->findByAttributes(array('nome' => Yii::app()->user->name));
	}
	
	function set($val) {
		return isset($val) && $val != null && $val != '';
	}
	
	function currentTurmas() {
	    $criteria=new CDbCriteria;
		
		$criteria->with = array('professor');
	    $criteria->together = true;
	
		if (!Yii::app()->helper->isAdmin())
			$criteria->compare('professor.id',Yii::app()->user->papel_id,true);
		// $criteria->compare('t.ano',date('Y'),true);
		
		// $criteria->order = 't.semestre DESC, t.nome ASC';
		$criteria->order = 't.id DESC, t.ano DESC, t.semestre DESC';
		
		$criteria->limit = 10;
	
		return Turma::model()->findAll($criteria);
	}
	
	public function trace(){
		$message = ' --- ';
		for ($i=0; $i < (func_num_args()-1); $i++) { 
			$arg = func_get_arg($i);
			$message .= $this->dump($arg);
			$message .= ' -&- ';
		}
		$message .= $this->dump(func_get_arg(func_num_args()-1));
		$message .= ' --- ';
		
        Yii::trace($message);
    }
	
	public function dump($message){
        return CVarDumper::dumpAsString($message);
    }
	
	public function error($op, $e){
		$message = "Um erro aconteceu ao tentar ". $op;
        Yii::log($message . " - Rollback, exception: " . $e->getMessage(), CLogger::LEVEL_ERROR, __METHOD__);
        Yii::app()->user->setFlash('error', $message);
        $this->trace($e->getMessage(), $e);
    }
	
	public function mailsend($to,$subject,$message){
        $headers = 'From: Diário <' . Yii::app()->params['adminEmail']  . ">\r\n" .
		    'Reply-To: Diário <'.Yii::app()->params['adminEmail'] . ">\r\n" .
		    'X-Mailer: PHP/' . phpversion();
		
		try{
			@mail($to, $subject, $message, $headers);
			Yii::app()->user->setFlash('contact','Obrigado por entrar em contato =D');
			return true;
		} catch (Exception $e) {
			Yii::app()->user->setFlash('error','Sua mensagem não pode ser enviada, tente novamente mais tarde.');
			$this->trace($e);
			return false;
		}
    }
	
	public function titleCase($string, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), 
		$exceptions = array("de", "da", "dos", "das", "do", "I", "II", "III", "IV", "V", "VI"))
    {
        /*
         * Exceptions in lower case are words you don't want converted
         * Exceptions all in upper case are any words you don't want converted to title case
         *   but should be converted to upper case, e.g.:
         *   king henry viii or king henry Viii should be King Henry VIII
         */
        $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
        foreach ($delimiters as $dlnr => $delimiter) {
            $words = explode($delimiter, $string);
            $newwords = array();
            foreach ($words as $wordnr => $word) {
                if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
                    $word = mb_strtoupper($word, "UTF-8");
                } elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
                    $word = mb_strtolower($word, "UTF-8");
                } elseif (!in_array($word, $exceptions)) {
                    // convert to uppercase (non-utf8 only)
                    $word = ucfirst($word);
                }
                array_push($newwords, $word);
            }
            $string = join($delimiter, $newwords);
       }//foreach
       return $string;
    }
	
}