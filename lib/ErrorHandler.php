<?php

/**

 * Error handler class maintains all errors in system

 *

 */

class ErrorHandler

{

	public $aUserMsg 			= array();

	public $aSystemMsg			= array();



	function __construct()

	{

		$this->email 			= ERROR_EMAIL;

		$this->logFile 			= LOG_FILE;

		$this->errorDisplay 	= ERROR_DISPLAY;

		$this->catchError 		= CATCH_ERROR;

		$this->logType 			= ERROR_LOG_TYPE;

			

		$this->errorCodes 		= array(E_ERROR , E_CORE_ERROR , E_COMPILE_ERROR , E_USER_ERROR);

		$this->warningCodes 	= array(E_WARNING , E_CORE_WARNING , E_COMPILE_WARNING , E_USER_WARNING);



		$this->aErrors 			= array( E_ERROR, E_PARSE, E_CORE_ERROR , E_CORE_WARNING ,

		E_COMPILE_ERROR , E_COMPILE_WARNING, E_USER_ERROR ,

		E_USER_WARNING, E_USER_NOTICE, E_RECOVERABLE_ERROR,

		E_WARNING, E_NOTICE, E_STRICT);

		//associate error codes with errno...

		$this->errorNames 		= array('E_ERROR','E_WARNING','E_PARSE','E_NOTICE','E_CORE_ERROR',

										'E_CORE_WARNING', 'E_COMPILE_ERROR','E_COMPILE_WARNING','E_USER_ERROR',

										'E_USER_WARNING', 'E_USER_NOTICE','E_STRICT','E_RECOVERABLE_ERROR');

			

		for($i=0,$j=1,$num=count($this->errorNames); $i<$num; $i++,$j=$j*2)

		$this->errorNumbers[$j] = $this->errorNames[$i];



		$this->createMsg();



	}



	/*

	 * The magic method __call() allows to capture invocation of non existing methods.

	 */

	public function __call($functionName, $arg)

	{

		trigger_error("Call to undefined function '$functionName()'");

	}



	/**

	 * Error handling Function. this is set in OtrackManager.php uisng php built-in function.

	 *

	 * @param int $errno error number

	 * @param string $errstr error message

	 * @param string $errfile file name

	 * @param int $errline line number

	 * @param string $errcontext full error message

	 * @return boolean

	 */



	function handler($errno, $errstr, $errfile, $errline, $errcontext)

	{

			

		$aErrList = $this->createErrorList();

			

		if (in_array($errno, $aErrList))

		{

			$this->errno = $errno;

			$this->errstr = $errstr;

			$this->errfile = $errfile;

			$this->errline = $errline;

			$this->errcontext = $errcontext;

			if(preg_match('/^sql/',$errstr))

			//if (eregi('^(sql)', $errstr))

			{

				$mysqlErrorNo 	= mysql_errno();

				$mysqlError 	= mysql_error();

				$this->errstr 	= "MySQL error: $mysqlErrorNo : $mysqlError\n<br>";

				$this->errstr	.= $errstr;



			}

			$this->logError();

			$this->errorDisplay();



			return true;

		}

	}



	/**

	 * Checks for what type of error should be displayed either Basic ot Detailed Error messages.

	 *

	 * @return unknown_type

	 */

	private function errorDisplay()

	{

		switch($this->errorDisplay)

		{

			case 0: // do not show error

				break;

			case 1: //show only Basic Error Message

				$this->errorMsgBasic();//if(in_array($this->errno, $this->errorCodes))

				exit();

				break;

			case 2: // show Detailed Error Mesage

				$this->errorMsgDetailed();

				break;

			default:

				break;

		}

	}



	/**

	 * Logs and Email the error depending on the preference specified in the Config.php

	 *

	 * @return unknown_type

	 */



	private function logError()

	{

		switch($this->logType)

		{

			case 1: // log error

				$this->logErrorMsg();

				break;

			case 2://send Email to the administrator about the error

				$this->sendErrorMsg();

				break;

			case 3: // log and send email to the administrator about the error

				$this->logErrorMsg();

				$this->sendErrorMsg();

				break;

			default:

				$this->logErrorMsg();

				break;

		}

	}



	/**

	 * Create the list of error messages depending on the prefernce specified in the config.php

	 *

	 * @return unknown_type

	 */

	private function createErrorList()

	{

		$aErrList = array();

		switch($this->catchError)

		{

			case 1:

				$aErrList = $this->errorCodes;

				break;

			case 2:

				$aErrList = $this->warningCodes;

				break;

			case 3:

				$aErrList = array_merge($this->errorCodes,$this->warningCodes);

				break;

			case 4:

				$aErrList = $this->aErrors;

				break;

			default:

				$aErrList = $this->errorCodes;

				break;

		}

		return $aErrList;

	}





	/**

	 * Error reporting functions

	 *

	 * Creates custom error messages in brief

	 *

	 */

	private function errorMsgBasic()

	{

		$message 	= NULL;

		$aErrList 	= array_merge($this->errorCodes,$this->warningCodes);

		if(in_array($this->errno,$aErrList))

		{

			$message = "<b>Error:</b> Some Error Occured";

		}

		echo $message;

		exit();

	}



	/**

	 * Creates custom error messages in detail

	 *

	 */

	private function errorMsgDetailed()

	{

		$message  = "<div class='errbox'>";

		$message .= "<pre style='color:red;'>\n\n";

		//$message .= "File: ".print_r( $this->errfile, true)."\n";

		//$message .= "Line: ".print_r( $this->errline, true)."\n\n";

		//$message .= "Error Type: ".print_r( $this->errorNumbers[$this->errno], true)."\n";

		//$message .= "Message: ".print_r( $this->errstr, true)."\n\n";

		$message .= "File: ". $this->errfile. "\n";

		$message .= "Line: ". $this->errline. "\n\n";

		$message .= "Error Type: ". $this->errorNumbers[$this->errno]. "\n";

		$message .= "Message: " .$this->errstr. "\n\n";

		$message .= "</pre>\n";

		$message .= "</div>";

		echo $message;

	}



	/**

	 * Create Message and sends an email to the adminstator/ developer

	 *

	 */

	private function sendErrorMsg()

	{

		$message  = "Some Error Occured in the ". MODE. " Server. Please check the error Message below.";

		$message .= "<pre>";

		//$message .= "File: ".print_r( $this->errfile, true)."\n";

		//$message .= "Line: ".print_r( $this->errline, true)."\n\n";

		//$message .= "Code: ".print_r( $this->errorNumbers[$this->errno], true)."\n";

		//$message .= "Message: ".print_r( $this->errstr, true)."\n\n";

		$message .= "File: ".$this->errfile."\n";

		$message .= "Line: ".$this->errline."\n\n";

		$message .= "Code: ".$this->errorNumbers[$this->errno]."\n";

		$message .= "Message: ".$this->errstr."\n\n";

		

		$message .= "<pre>";



		$mailTo 	= $this->email;

		$nameTo 	= TO_NAME;

		$subject 	= "CarsAndAuto - Error";

		$mailFrom 	= "From: ".ERROR_FROM_ADDR;

		$nameFrom 	= MODE;

		$oUtil 		= &Singleton::getInstance('Util');

		$oUtil->htmlEmail($mailTo, $nameTo, $mailFrom, $nameFrom, $subject, $message, $attFile='');



	}



	/**

	 * Logs the error message in the folder specified

	 *

	 */

	private function logErrorMsg()

	{

		/*

		$message  =  "time: ".date("j M y - g:i:s A (T)", mktime())."\n";

		$message .= "file: ".print_r( $this->errfile, true)."\n";

		$message .= "line: ".print_r( $this->errline, true)."\n\n";

		$message .= "code: ".print_r( $this->errorNumbers[$this->errno], true)."\n";

		$message .= "message: ".print_r( $this->errstr, true)."\n";

		$message .= "##################################################\n\n";  */

		

		$message  =  "time: ".date("j M y - g:i:s A (T)", time())."\n";

		$message .= "file: ". $this->errfile."\n";

		$message .= "line: ".$this->errline."\n\n";

		$message .= "code: ".$this->errorNumbers[$this->errno]."\n";

		$message .= "message: ". $this->errstr."\n";

		$message .= "##################################################\n\n";

			

		if ($this->logFile != '') {

			error_log($message, 3, $this->logFile);

		}

	}



	/**

	 * Creates an Array for the custom Error messages, such in all over all Errors, System failures, Messages and Information

	 * comes from this array.

	 *

	 * To call this values, $errObj->aUserMsg['ROLES_UPDATED'], will prints the appropriate message.

	 *

	 */

	public function createMsg()

	{

		$this->aUserMsg = array(

			 'NO_RECORDS_FOUND' => "No Records Found"

			 );



			 $this->aSystemMsg = array(

				 'CANNOT_LOG'				=> "System cannot Log",

				 'MAIL_NOT_SENT'			=> "Mail Cannot be sent at this time",

				 'SYSTEM_FAILED' 			=> "Cars System Cannot be used at this time. Please try after some time",

			 	 'NO_CURD_UPDATE'			=> "CURD Table is not updated. Please refer to information below for CURD Activity"

			 	 );

	}

}

?>

