<?php 
class DocumentHelper extends CApplicationComponent {
	
	public function createForm($model) {
		$form = new DocumentForm;
		$form->readFields($model);
		return $form;
	}
	
	public function readForm($model) {
		$form = new DocumentForm;
		$form->readFields($model);
		
		if (isset($_POST['DocumentForm']['nome'])) {
			$form->nome = $_POST['DocumentForm']['nome'];
		}
		
		if (isset($_POST['DocumentForm']['modelo_id'])) {
			$form->modelo_id = $_POST['DocumentForm']['modelo_id'];
		}
		
		foreach ($form->fields as $field) {
			// Yii::app()->helper->trace($field->getFormName(), $_POST['DocumentForm'][$field->getFormName()]);
			if (isset($_POST['DocumentForm'][$field->getFormName()])) {
				// Yii::app()->helper->trace($_POST['DocumentForm'][$field->getFormName()]);
				$field->value = $_POST['DocumentForm'][$field->getFormName()];
			}
		}
		
		return $form;
	}
	
	public static function valorPorExtenso( $valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false )
    {
 
        //$valor = self::removerFormatacaoNumero( $valor );
 
        $singular = null;
        $plural = null;
 
        if ( $bolExibirMoeda )
        {
            $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
        else
        {
            $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("", "", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
 
        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
 
 
        if ( $bolPalavraFeminina )
        {
 
            if ($valor == 1) 
            {
                $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
            else 
            {
                $u = array("", "um", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
 
 
            $c = array("", "cem", "duzentas", "trezentas", "quatrocentas","quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");
 
 
        }
 
 
        $z = 0;
 
        $valor = number_format( $valor, 2, ".", "." );
        $inteiro = explode( ".", $valor );
 
        for ( $i = 0; $i < count( $inteiro ); $i++ ) 
        {
            for ( $ii = mb_strlen( $inteiro[$i] ); $ii < 3; $ii++ ) 
            {
                $inteiro[$i] = "0" . $inteiro[$i];
            }
        }
 
        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count( $inteiro ) - ($inteiro[count( $inteiro ) - 1] > 0 ? 1 : 2);
        for ( $i = 0; $i < count( $inteiro ); $i++ )
        {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
 
            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count( $inteiro ) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ( $valor == "000")
                $z++;
            elseif ( $z > 0 )
                $z--;
 
            if ( ($t == 1) && ($z > 0) && ($inteiro[0] > 0) )
                $r .= ( ($z > 1) ? " de " : "") . $plural[$t];
 
            if ( $r )
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }
 
        $rt = mb_substr( $rt, 1 );
 
        return($rt ? trim( $rt ) : "zero");
 
    }

	public static function dataPorMascara($data, $mask) {
		// setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
		setlocale(LC_ALL,"pt_BR.UTF8");
		date_default_timezone_set('America/Sao_Paulo');
		
		$data = strtotime($data);
		// Yii::app()->helper->trace($this->mask);
		switch ($mask) {
			case NowField::FORMAT_YYMMDD:
				return strftime('%y/%m/%d', $data);
			case NowField::FORMAT_YYYYMMDD:
				return strftime('%Y/%m/%d', $data);
			case NowField::FORMAT_YYYY_MM_DD:
				return strftime('%Y-%m-%d', $data);
			case NowField::FORMAT_DD_MM_YYYY:
				return strftime('%d-%m-%Y', $data);
			case NowField::FORMAT_DDMMYY:
				return strftime('%d/%m/%y', $data);
			case NowField::FORMAT_DDMMYYYY:
				return strftime('%d/%m/%Y', $data);
			case NowField::FORMAT_DD:
				return strftime('%d', $data);
			case NowField::FORMAT_MM:
				return strftime('%m', $data);
			case NowField::FORMAT_YY:
				return strftime('%y', $data);
			case NowField::FORMAT_YYYY:
				return strftime('%Y', $data);
			case NowField::FORMAT_WK:
				return strftime('%u', $data);
			case NowField::FORMAT_DD_TEXT:
				return DocumentHelper::valorPorExtenso(strftime('%d', $data), false, false); //strftime('%d', $data);
			case NowField::FORMAT_MM_TEXT:
				// return DocumentHelper::valorPorExtenso(strftime('%m', $data), false, false);
				return strftime('%B', $data);
			case NowField::FORMAT_YY_TEXT:
				return DocumentHelper::valorPorExtenso(strftime('%Y', $data), false, false);
			case NowField::FORMAT_WK_TEXT:
				return strftime('%A', $data);
			case NowField::FORMAT_TEXT:
				return DocumentHelper::valorPorExtenso(strftime('%d', $data), false, false) . 
					((date('j') > 1)? ' dias de ' : ' dia de ' ) .
					strtolower(strftime('%B', $data)) . ' de ' .
 					DocumentHelper::valorPorExtenso(strftime('%Y', $data), false, false);
			case NowField::FORMAT_TRADITIONAL:
			default:
				return strftime('%A, %d de %B de %Y', $data);
		}
	}

	public static function replaceDataMask($nome) {
		$data = 'today';
		$nome = DocumentHelper::replaceNow(NowField::FORMAT_YYYYMMDD, $data, $nome);
		$nome = DocumentHelper::replaceNow(NowField::FORMAT_YYYY_MM_DD, $data, $nome);
		$nome = DocumentHelper::replaceNow(NowField::FORMAT_DDMMYYYY, $data, $nome);
		$nome = DocumentHelper::replaceNow(NowField::FORMAT_DDMMYY, $data, $nome);
		$nome = DocumentHelper::replaceNow(NowField::FORMAT_YYMMDD, $data, $nome);
		$nome = DocumentHelper::replaceNow(NowField::FORMAT_DD, $data, $nome);
		$nome = DocumentHelper::replaceNow(NowField::FORMAT_MM, $data, $nome);
		$nome = DocumentHelper::replaceNow(NowField::FORMAT_YYYY, $data, $nome);
		$nome = DocumentHelper::replaceNow(NowField::FORMAT_YY, $data, $nome);
		return $nome;
	}

	private static function replaceNow($mask, $data, $txt) {
		$maskTAG = DocumentField::OPEN_TAG.$mask.DocumentField::CLOSE_TAG;
		if (strpos($txt, $maskTAG) !== false)
			return str_replace($maskTAG, DocumentHelper::dataPorMascara($data, $mask), $txt);
		else
			return $txt;
	}
	
	public static function decodeHTML($txt) {
		$txt = html_entity_decode($txt);
		return DocumentHelper::removePHP($txt);
	}
	
	public static function removePHP($txt) {
		return preg_replace('~<\?(.+?)\?>~', '', $txt);
	}
	
}