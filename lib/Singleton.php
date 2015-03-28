<?php
/**
 * 
 * 
 * $Id$
 * 
 * @author Subash Gopalaswamy <mailto:subashchandraa@gmail.com> (29-Dec-2011)
 */

class Singleton
{
	/**
	 * provides a single method which will work for any and all classes and subclasses to work in Singleton
	 * It does not require a method to be duplicated within each class or subclass.
	 *
	 * If the class already creates the object for one class, it returns it, or creates a new object.
	 *
	 * @param string $className
	 * @return object
	 */
	static public function &getInstance ($className)
	{
		static $aInstances = array();
		if(!class_exists($className))
		{
			require_once(LIB_PATH.'/'.$className.'.php');
			//echo LIB_PATH.'/'.$className.'.php';
			//echo "<br/>";
		}
		if(!array_key_exists($className, $aInstances))
		{
			$aInstances[$className] 	= new $className();
		}
		$aInstance				= $aInstances[$className];
		return $aInstance;
	}

	/*
	 * The magic method __call() allows to capture invocation of non existing methods.
	 */
	public function __call($functionName, $arg)
    {
    	trigger_error("Call to undefined function '$functionName()'");
    }

     /**
      * Disallow cloning
      *
      */
     private function __clone()
     {
	 }

}
?>