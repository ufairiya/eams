<?php
/**
 * 
 * 
 * $Id$
 * 
 * @author Subash Gopalaswamy <mailto:subashchandraa@gmail.com> (29-Dec-2011)
 */

class SessionController
{
	private $lockList;
	private $checkBrowser  	= true;
	private $checkIpBlocks 	= 0;
	private $secureWord    	= 'RAMANS';
	private $endtime	   	= "";
	private $regenerate_id;
	private static $instance;

	function __construct ()
	{
		session_cache_limiter ('nocache');
		$this->regenerateId();
		$_SESSION['sFingerPrint']	= $this->getFingerprint();
		$this->endtime 				= time();
		if (!$this->isSession("lockList"))
		{
			$lockList 				= array();
			$lockList[] 			= "lockList";
			$_SESSION["lockList"] 	= $lockList;
		}
	}


	/*
	 * The magic method __call() allows to capture invocation of non existing methods.
	 */
	public function __call($functionName, $arg)
    {
    	trigger_error("Call to undefined function '$functionName()'");
    }


	/**
	 * Create the finger print by using the combination of browser variables , IP's and secure word
	 *
	 * @return string  MD5 from finger print
	 */
	private function getFingerprint()
	{
		$fingerPrint = $this->secureWord;

		if ($this->checkBrowser) {
			$fingerPrint .= @$_SERVER['HTTP_USER_AGENT'];
			//$fingerPrint .= @$_SERVER['HTTP_ACCEPT_LANGUAGE'];
		}


		if ($this->checkIpBlocks) {
			$numBlocks = abs(intval($this->checkIpBlocks));
			if ($numBlocks > 4) {
				$numBlocks = 4;
			}
			$blocks = explode('.', $_SERVER['REMOTE_ADDR']);
			for ($i=0; $i<$numBlocks; $i++) {
				$fingerPrint .= $blocks[$i] . '.';
			}
		}
		return md5($fingerPrint);
	}

	/**
	 * Create the finger print by using the combination of browser variables , IP's and secure word
	 *
	 * @return string  MD5 from finger print
	 */
	public function isValidFingerPrint()
	{
		return (isset($_SESSION['sFingerPrint']) && $_SESSION['sFingerPrint'] == $this->getFingerprint());
	}

	/**
	 * singleton pattern (not used now)
	 *
	 * @return object
	 */
	public static function &getInstance()
	{
		if (!isset(self::$instance))
		{
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}


	/**
	 * Looks for a valid Session Name and sets the session name and value.
	 * If the name of the session to be set is on Locklist it will return with Error
	 *
	 * @param string $name Name of the Session
	 * @param string $value
	 */

	public function setSession($name, $value)
	{
		if (preg_match("!^[a-zA-Z_x7f-xff][a-zA-Z0-9_x7f-xff]*$!i", $name))
		{
			$lockList = array();
			$lockList = $this->getSession("lockList");
			if(count($lockList)>0)
			{
				if (in_array($name, $lockList))
				{
					trigger_error("'<i>$name</i>' is locked and cannot be set", E_USER_NOTICE);
				} else
				{
					$_SESSION[$name] = $value;
				}
			}
		}
		else
		{
			trigger_error("Invalid variable name", E_USER_NOTICE);
		}
	}



	/**
	 * Check the inactive timelimit for the user. If the time Exceeds, Session will be killed.
	 *
	 * @param int $pass
	 */

	public function setSessionIdleTimeout($pass)
	{
		$inactive = $pass;
		if($this->isSession('startTime'))
		{
			$sessionLife = time() - $this->getSession('startTime');
			if($sessionLife > $inactive)
			{
				$this->killSession();
			}
		}
		$this->setSession('startTime',time());
		return 1;
	}



	/**
	 * Used to get the value of a session with the passes Session Name.
	 *
	 * @param string $name Name of the Session
	 * @return string
	 */

	public function getSession($name)
	{
		if (isset($_SESSION[$name]))
		{
			return $_SESSION[$name];
		}
		else
		{
			return null;
		}
	}

	/**
	 * Checks the session time out.
	 *
	 * @return 1
	 */

	public function setSessionTimeout()
	{
		$totalseconds=0;
		if(isset($_SESSION['starttime']))
		{
			$diff = $this->endtime - $_SESSION['starttime'];
			$daysDiff = floor($diff/60/60/24);
			$diff -= $daysDiff*60*60*24;
			$hrsDiff = floor($diff/60/60);
			$diff -= $hrsDiff*60*60;
			$minsDiff = floor($diff/60);
			$diff -= $minsDiff*60;
			$secsDiff = $diff;
			$totalseconds = ($hrsDiff*60*60)+($minsDiff*60)+$secsDiff;
			if($totalseconds >= $_SESSION['timeout']*60)
			{
				$totalseconds=0;
				$this->killSession();
				return 1;
			}
		}
	}


	/**
	 * Checks whether the session exists or not
	 *
	 * @param string $name Name of the Session
	 * @return string
	 */

	public function isSession($name)
	{
		return ($this->getSession($name) !== null);
	}


	/**
	 * Empties the session value with the passes session name/
	 *
	 * @param string $name Name of the Session
	 * @return boolean
	 */

	public function deleteSession($name)
	{
		$lockList = $this->getSession("lockList");

		if (in_array($name, $lockList))
		{
			trigger_error("'<i>$name</i>' is locked and cannot be deleted", E_USER_NOTICE);
		}
		else
		{
			if (isset($_SESSION[$name]))
			{
				unset($_SESSION[$name]);
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	/**
	 * Lock the session variable, and prevents rewriting and deleting the values until it is unloacked.
	 *
	 * @param string $name Name of the Session
	 */

	public function lockSession($name)
	{
		$lockList = $this->getSession("lockList");
		if ($this->isSession($name))
		{
			if (in_array($name, $lockList))
			{
				trigger_error("'<i>$name</i>' has already been locked", E_USER_NOTICE);
			}
			else
			{
				$lockList[] = $name;
				$_SESSION["lockList"] = $lockList;
			}
		}
		else
		{
			trigger_error("There is no session variable called '<i>$name</i>'", E_USER_NOTICE);
		}
	}



	/**
	 * Unlock the session variable and can be used for resting the values, or deleting the session
	 *
	 * @param string $name Name of the Session
	 */

	public function unlockSession($name)
	{
		$lockList = $this->getSession("lockList");
		if ($key = array_search($name, $lockList))
		{
			unset($lockList[$key]);
			$_SESSION["lockList"] = $lockList;
		}
		else
		{
			trigger_error("'<i>$name</i>' is not locked.", E_USER_NOTICE);
		}
	}



	/**
	 * Destroys the Session with the values.
	 *
	 * @return boolean
	 */

	public function killSession()
	{
		foreach ($_SESSION as $sesVarName => $sesVarValue) {
			if (isset($_SESSION)) {
				unset($sesVarName);
			}
		}
		@session_destroy();
		$_SESSION = array();
		return true;
	}

	/**
	 * Regenerates session ID
	 *
	 */
	public function regenerateId()
	{
		//$this->regenerate_id &&
		if (function_exists('session_regenerate_id')) {
			if (version_compare('5.1.0', phpversion(), '>=')) {
				session_regenerate_id(true);
			} else {
				session_regenerate_id();
			}
		}
	}
}
?>