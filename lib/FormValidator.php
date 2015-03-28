<?php 
/**
 * Validates the form
 * 
 * Validates the Form and displays the appropriate error on failure.
 * 
 */
class FormValidator
{

	var $aFields       = array();
	var $aErrMsg       = array();
	var $check_4html   = false;
	var $language;
	var $msgIndex      = 0;
	var $isCustomError = 0;
    var $aReturn;

	/**
	 * Constructor FormValidator
	 * Intialize language
	 */
	function FormValidator()
	{
		$this->language = 'us';
	}

	/**
	 * Set the text field item
	 *
	 * @param string  $type
	 * @param string  $label
	 * @param string  $value
	 * @param boolean $required
	 * @param integer $minLen
	 * @param string  $maxLen
	 * @param string  $addValue
	 */

	function setField($type, $label, $value, $required = 1, $minLen = 0, $maxLen = 0, $addValue='', $validationPattern = '')
	{
		$this->aFields[] = array (
			'type'     => $type,
			'label'    => $label,
			'value'    => $value,
			'required' => $required,
			'minLen'   => $minLen,
			'maxLen'   => $maxLen,
			'addValue' => $addValue,
			'validationPattern' => $validationPattern

		);
	}

	function setCustomErrorMsg($customErrMessage)
	{
		$this->aErrMsg[$this->msgIndex++] = $customErrMessage;
		$this->isCustomError = 1;
	}

	/**
	 * Do validation call the appropiate function
	 *
	 * @return boolean
	 * 0 # No errors
	 * 1 # Error in the form
	 */
	function validation()
	{
		$status = 0;
		foreach ($this->aFields as $val) {

			switch ($val['type']) {

				case 'TEXT':
					if ($this->checkText($val['label'], trim( $val['value'] ), $val['required'], $val['minLen'], $val['maxLen'])) {
						$status++;
					}
					break;
				
				case 'ALLTEXT':
					if ($this->checkCharacters($val['label'], trim( $val['value'] ), $val['required'], $val['minLen'], $val['maxLen'])) {
						$status++;
					}
					break;

				case 'NUMBER':
					if ($this->checkNumVal($val['label'], $val['value'], $val['required'], $val['minLen'], $val['maxLen'])) {
						$status++;
					}
					break;

				case 'ALPHANUM':
					if ($this->checkAlphaNum($val['label'], $val['value'], $val['required'], $val['minLen'], $val['maxLen'])) {
						$status++;
					}
					break;

				case 'DECIMAL':
					if ($this->checkDecimal($val['label'], $val['value'], $val['required'], $val['addValue'])) {
						$status++;
					}
					break;
					
				case 'AMOUNT':
					if ($this->checkAmount($val['label'], $val['value'], $val['required'], $val['addValue'])) {
						$status++;
					}
					break;	

				case 'DATE':
					if ($this->checkDate($val['label'], $val['value'], $val['required'], $val['addValue'])) {
						$status++;
					}
					break;

				case 'LIST':
					if ($this->checkListBox($val['label'], $val['value'], $val['required'])) {
						$status++;
					}
					break;

				case 'CHECKBOX':
					if ($this->checkCheckBox($val['label'], $val['value'], $val['required'])) {
						$status++;
					}
					break;

				case 'RADIO':
					if ($this->checkRadioBox($val['label'], $val['value'], $val['required'])) {
						$status++;
					}
					break;

				case 'EMAIL':
					$val['value'] = trim($val['value']);
					if ($this->checkEmail($val['label'], $val['value'], $val['required'], $val['addValue'])) {
						$status++;
					}
					break;

                case 'ACCOUNT':
                    if ($this->checkAccount( $val['label'], $val['value'], $val['required'], $val['minLen'], $val['maxLen'] )) {
                        $status++;
                    }
                    break;

				case 'USERNAME':
					if ($this->checkUsername($val['label'], $val['value'], $val['required'], $val['minLen'], $val['maxLen'])) {
						$status++;
					}
					break;

				case 'PASSWORD':
					if ($this->checkPassword($val['label'], $val['value'], $val['required'], $val['minLen'], $val['maxLen'], $val['addValue'])) {
						$status++;
					}
					break;

				case 'URL':
					if ($this->checkUrl($val['label'], $val['value'], $val['required'])) {
						$status++;
					}
					break;

				case 'CREDITCARD':
					if ($this->checkCreditCard($val['label'], $val['value'], $val['addValue'])) {
						$status++;
					}
					break;
				case 'SITE_NAME':
					if ($this->checkSitename($val['label'], $val['value'], $val['required'], $val['minLen'], $val['maxLen'])) {
						$status++;
					}
					break;
				case 'SITE_DISPLAYNAME':
					if ($this->checkSiteDisplayname($val['label'], $val['value'], $val['required'], $val['minLen'], $val['maxLen'])) {
						$status++;
					}
					break;
				case 'SESSION_USER_ID':
					if ($this->checkSessionUserId($val['value'], $val['required'])) {
						$status++;
					}
					break;
				case 'SSN':
					if ($this->checkSSN( $val['label'], $val['value'], $val['required'] ) ) {
						$status++;
					}
					break;
				case 'USPS':
					if ($this->checkUSPS( $val['label'], $val['value'], $val['required'] ) ) {
						$status++;
					}
					break;
				default:               
					if ($this->checkCustom($val['label'], $val['value'], $val['required'], $val['minLen'], $val['maxLen'], $val['addValue'], $val[                        'validationPattern'] )) 
					{
						$status++;
					}

			}
			if ($this->check_4html) {
				if ($this->checkHtmlTags($val['label'], $val['value'])) {
					$status++;
				}
			}
		}
        
		if ($this->checkCustomErrorMsg()) {
			$status++;
		}
		if ($status == 0) {
			return 1;
		} else {
			return 0;
		}

	}


	function checkSize($val, $minLen = 0, $maxLen = 0)
	{
		$valLen = strlen($val);

		if (!empty($minLen) && !empty($maxLen)) {
			if ($minLen == $maxLen) {
				if ($maxLen != $valLen) {
					return 3;
				}
			} else {
				if ($minLen > $valLen ||  $maxLen < $valLen) {
					return 2;
				}
			}
		} else if (empty($minLen) && !empty($maxLen)) {
			if ($maxLen > $valLen) {
				return 4;
			}
		}
		return 0;
	}

	function checkText($label, $value, $required, $minLen, $maxLen)
	{
		if (empty($value)) {
			if ($required == 1) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(1, $label);
				return 1;
			}
		} else {
			/*$ret = $this->checkSize($value, $minLen, $maxLen);
			if ($ret > 0) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText($ret, $label, $minLen, $maxLen);
				return 1;
			}*/
			$pattern =  '/^[a-zA-Z[:space:]]+$/i';
			if (preg_match($pattern, $value) == 0) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(11, $label);
				return 1;
			} else {
				$ret = $this->checkSize($value, $minLen, $maxLen);
				if ($ret > 0) {
					$this->aErrMsg[$this->msgIndex++] = $this->getErrorText($ret, $label, $minLen, $maxLen);
					return 1;
				}
			}
		}
		return 0;
	}
	
	function checkCharacters($label, $value, $required, $minLen, $maxLen)
	{
		if (empty($value)) {
			if ($required == 1) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(1, $label);
				return 1;
			}
		} else {
			$ret = $this->checkSize($value, $minLen, $maxLen);
			if ($ret > 0) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText($ret, $label, $minLen, $maxLen);
				return 1;
			}
		}
		return 0;
	}

	function checkNumVal($label, $value, $required, $minLen, $maxLen)
	{
		if ($value == '') {
			if ($required == 1) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(1, $label);
				return 1;
			}
		} else {
			$pattern = "/^\-?[0-9]*$/";
			if (preg_match($pattern, $value) == 0) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(12, $label);
				return 1;
			} else {
				$ret = $this->checkSize($value, $minLen, $maxLen);
				if ($ret > 0) {
					$this->aErrMsg[$this->msgIndex++] = $this->getErrorText($ret+3, $label, $minLen, $maxLen);
					return 1;
				}
			}
		}
		return 0;
	}

	function checkAlphaNum($label, $value, $required, $minLen, $maxLen)
	{
		if ($value == '') {
			if ($required == 1) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(1, $label);
				return 1;
			}
		} else {
			$pattern =  '/^[a-z0-9]+$/i';
			if (preg_match($pattern, $value) == 0) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(13, $label);
				return 1;
			} else {
				$ret = $this->checkSize($value, $minLen, $maxLen);
				if ($ret > 0) {
					$this->aErrMsg[$this->msgIndex++] = $this->getErrorText($ret+6, $label, $minLen, $maxLen);
					return 1;
				}
			}
		}
		return 0;
	}

	function checkDecimal($label, $value, $required, $addValue=2)
	{
		$addValue = !empty($addValue) ? $addValue : 2;
         //echo $value;
		if ($value == '') {
			if ($required == 1) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(1, $label);
				return 1;
			}
		} else {
		    //echo 'matching pattern......';
			$pattern = "/^[-]*[0-9][0-9]*\.[0-9]{'. $addValue . '}$/";
			//echo $pattern;
			if (preg_match($pattern, $value) == 0) {
			    //echo '<br>pattern matched....';
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(14, $label);
				return 1;
			}
		}
		return 0;
	}
	
	function checkAmount($label, $value, $required, $addValue=2)
	{
		$addValue = !empty($addValue) ? $addValue : 2;
         if ($value == '') {
			if ($required == 1) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(1, $label);
				return 1;
			}
		} else {
		    //echo 'matching pattern......';
			$pattern = "/^[0-9](\.[0-9]{". $addValue . "})?$/";
			//echo $pattern;
			if (preg_match($pattern, $value) == 0) {
			    //echo '<br>pattern matched....';
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(14, $label);
				return 1;
			}
		}
		return 0;
	}

	function checkDate($label, $value, $required, $addValue='eu')
	{   
		$addValue = !empty($addValue) ? $addValue : 'eu';

		if (empty($value)) {
			if ($required == 1) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(1, $label);
				return 1;
			}
		} else {
			if ($addValue == 'eu') {
				//$pattern = "/^(19|20)[0-9]{2}$/";
				$pattern = "/^(19|20)[0-9]{2}-[0-9]{2}-[0-9]{2}$/";
			} else {
				$pattern = "/^(19|20)[0-9]{2}$/";
			}
			if (preg_match($pattern, $value) == 0) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(15, $label);
				return 1;
			}
		}
		return 0;
	}

	function checkListBox($label, $value, $required)
	{
		if (empty($value)) {
			if ($required == 1) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(16, $label);
				return 1;
			}
		}
		return 0;
	}

	function checkRadioBox($label, $value, $required)
	{
		if (empty($value)) {
			if ($required == 1) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(16, $label);
				return 1;
			}
		}
		return 0;
	}

	function checkCheckBox($label, $value, $required)
	{
		if (empty($value)) {
			if ($required == 1) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(17, $label);
				return 1;
			}
		}
		return 0;
	}

	function checkEmail($label, $value, $required, $addValue='')
	{
		if (empty($value)) {
			if ($required == 1) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(1, $label);
				return 1;
			}
		} else {
			$pattern = "/^[0-9a-z]+(([\.\-_])[0-9a-z]+)*@[0-9a-z]+(([\.\-])[0-9a-z-]+)*\.[a-z]{2,4}$/i";
			if (preg_match($pattern, $value) == 0) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(18, $label);
				return 1;
			} else {
				if ($addValue != '') {
					if ($value != $addValue) {
						$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(20, $label);
						return 1;
					}
				}
			}
		}
		return 0;
	}

	function checkUrl($label, $value, $required)
	{
		if (empty($value)) {
			if ($required == 1) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(1, $label);
				return 1;
			}
		} else {
			$urlPattern = "http\:\/\/[[:alnum:]\-\.]+(\.[[:alpha:]]{2,4})+";
			$urlPattern .= "(\/[\w\-]+)*"; // folders like /val_1/45/
			$urlPattern .= "((\/[\w\-\.]+\.[[:alnum:]]{2,4})?"; // filename like index.html
			$urlPattern .= "|"; // end with filename or ?
			$urlPattern .= "\/?)"; // trailing slash or not
			$errorCount = 0;
			if (strpos($value, '?')) {
				$urlParts = explode('?', $value);
				if (!preg_match('/^'.$urlPattern.'$/', $urlParts[0])) {
					$errorCount++;
				}
				if (!preg_match('/^(&?[\w\-]+=\w*)+$/', $urlParts[1])) {
					$errorCount++;
				}
			} else {
				if (!preg_match('/^'.$urlPattern.'$/', $value)) {
					$errorCount++;
				}
			}
			if ($errorCount > 0) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(16, $label);
				return 1;
			}
		}
		return 0;
	}

	function checkUsername($label, $value, $required, $minLen, $maxLen)
	{
		if (empty($value)) {
			if ($required == 1) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(1, $label);
				return 1;
			}
		} else {
			$pattern =  '/^[a-z0-9_]+$/i';
			if (preg_match($pattern, $value) == 0) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(13, $label, $minLen, $maxLen, 'Also allowed: _');
				return 1;
			} else {
				$ret = $this->checkSize($value, $minLen, $maxLen);
				if($ret > 0) {
					$this->aErrMsg[$this->msgIndex++] = $this->getErrorText($ret+6, $label, $minLen, $maxLen);
					return 1;
				}
			}
		}
		return 0;
	}

	function checkPassword($label, $value, $required, $minLen, $maxLen, $addValue='')
	{
		if (empty($value)) {
			if ($required == 1) {
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(1, $label);
				return 1;
			}
		} else {
			//$pattern =  '/^[a-z0-9_!@]+$/i';
			$pattern = '/((?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,15})/'; //one uppercase,one lowercase one digit...
			$ret = $this->checkSize($value, $minLen, $maxLen);
			if (preg_match($pattern, $value) == 0) {
				//$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(13, $label, $minLen, $maxLen, 'Also allowed: _,!,@');
				$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(51, $label, $minLen, $maxLen);
				return 1;
			} else {
				if ($ret > 0) {
					$this->aErrMsg[$this->msgIndex++] = $this->getErrorText($ret+6, $label, $minLen, $maxLen);
					return 1;
				} else {
					if ($value != $addValue) {
						$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(21, $label);
						return 1;
					}
				}
			}
		}
		return 0;
	}


	function checkHtmlTags($label, $value)
	{
		$pattern = "#(on(.*?)\=|script|xmlns|expression|javascript|\>|\<|http)#si";
		if (preg_match($pattern, $value) == 1) {
			$this->aErrMsg[$this->msgIndex++] = $this->getErrorText(50, $label);
			return 1;
		}
		return 0;
	}
	function checkCustom( $label = "", $value = "", $required = false, $minLen = 0, $maxLen = "", $addValue= "", $validationPattern = "" ) {
		$ret = $this->checkSize( $value, $minLen, $maxLen );        
		if ( $value != "" ) {
			if ( $validationPattern != "" ) {             
				if ( !preg_match ( $validationPattern, $value ) ) {
					$this->aErrMsg[ $this->msgIndex++ ] = $this->getErrorText(22, $label, $minLen, $maxLen );                    
					return 1;
				}
				elseif ( $ret ) {
					$this->aErrMsg[ $this->msgIndex++ ] = $this->getErrorText( $ret, $label, $minLen, $maxLen );
					return 1;
				}
			}
		}
		elseif ( $required ) {
			$this->aErrMsg[ $this->msgIndex++ ] = $this->getErrorText( 1, $label );
			return 1;
		}
        return 0;
	}


	function checkCustomErrorMsg()
	{
		return $this->isCustomError;
	}

	function createMsg($breakElem = "<br />")
	{
		$theMsg = "";
		$errorMap = array ();
		ksort($this->aErrMsg);
		$theMsg .='<img src="'.APP_HTTP.'/images/icon_error_pulse.gif" alt="Error" hspace="5" align="absmiddle"><b>Please fill out required information in the        following fields:</b>' . $breakElem . $breakElem . "\n";
		foreach ($this->aErrMsg as $value) {
			$errorMap [ $value ] = $value;
		}
		foreach ($errorMap as $value) {
			$theMsg .= '<img src="'.APP_HTTP.'/images/icon_error_dot.gif" hspace="5" alt="' . $value . '"> ' . $value . $breakElem . "\n";
		}
		return $theMsg;
	}

	function getErrorText($msgId, $label, $minLen=0, $maxLen=0, $str='')
	{

		$label = str_replace('_', ' ', $label);
		switch ($this->language) {

			case "us":

				$aMsg[1] = 'Please specify a ' . $label . '.';

				$aMsg[2]  =  $label . " is Invalid. Please ensure " . $label . " contains " . $minLen . " to " . $maxLen . " characters.";
				$aMsg[3]  =  $label . " is Invalid. Please ensure " . $label . " contains " . $minLen . " characters.";
				$aMsg[4]  =  $label . " is Invalid. Please ensure " . $label . " is greater than " . $maxLen . " characters.";

				$aMsg[5]  =  $label . " is Invalid. Please ensure " . $label . " contains " . $minLen . " to " . $maxLen . " numeric digits (0-9).";
				$aMsg[6]  =  $label . " is Invalid. Please ensure " . $label . " contains " . $minLen . " numeric digits (0-9).";
				$aMsg[7]  =  $label . " is Invalid. Please ensure " . $label . " is greater than " . $maxLen . " numeric digits (0-9).";

				$aMsg[8]  =  $label . " is Invalid. Please ensure " . $label . " contains " . $minLen . " to " . $maxLen . " alpha-numeric characters.";
				$aMsg[9]  =  $label . " is Invalid. Please ensure " . $label . " contains " . $minLen . " alpha-numeric characters.";
				$aMsg[10] =  $label . " is Invalid. Please ensure " . $label . " is greater than " . $maxLen . " alpha-numeric characters.";

				$aMsg[11] =  "Invalid characters in " . $label ." field. The " . $label . " must contain only characters.";
				$aMsg[12] =  "Invalid characters in " . $label ." field. The " . $label . " must contain only numeric digits (0-9).";
				$aMsg[13] =  "Invalid characters in " . $label ." field. The " . $label . " must contain only alpha-numeric characters.";
				$aMsg[14] =  "Invalid characters in " . $label ." field. The " . $label . " needs to be numeric with an explicit decimal point.";

				$aMsg[15] =  "You didn't specify a valid year for your " . $label . ".";
				$aMsg[16] =  "Please select " . $label . ".";
				$aMsg[17] =  "Please check " . $label . ".";

				$aMsg[18] =  "You didn't specify a valid " . $label . " eg: john@examples.com.";
				$aMsg[19] =  "You didn't specify a valid " . $label . " eg: http://www.examples.com.";

				$aMsg[20] =  "Your desired email address does not match confirm email address";
				$aMsg[21] =  "Your desired password does not match confirm password";

				$aMsg[22] =  "Invalid " . $label . ".";

				$aMsg[23] =  $label . " is already in use.";
				$aMsg[24] =  $label . " is invalid. " . $label . " contains badwords";

				$aMsg[50] =  "There is html code in field " . $label . ", this is not allowed.";
				$aMsg[51] =  "Invalid characters in " . $label ." field. The " .$label . " must contain atleast one uppercase, one lower case, one digit ";

				break;
		}
		return $aMsg[$msgId] . " $str";
	}
    function getReturn()
    {
        return $this->aReturn;
    }
}
?>
