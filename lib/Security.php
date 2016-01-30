<?php
/**
 * 
 * 
 * $Id$
 * 
 * @author Subash Gopalaswamy <mailto:gsubash@ocenture.in> (29-Dec-2009)
 */

class Security
{
    function __construct()
    {
    	$this->oDb = new Db(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
    	$this->oSession 		= &Singleton::getInstance('SessionController');
    }

    public function checkInt($value) 
    {
	   if(is_numeric($value))  
	   {
		 return (int)$value;
	   }
	   else  
	   {
		 return false;
	   }
	}

	public function stripAllTags($value){
		$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
					   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
					   '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
					   '@<![\s\S]*?--[ \t\n\r]*>@'        // Strip multi-line comments including CDATA
		);
		$text = preg_replace($search, '', $value);
		return stripslashes($text);
	}
	
	/*strip slashes for array input (even for multidimensional arrays too ) */
	public function stripSlashesArray($value)
	{
		$value = is_array($value) ? array_map('stripSlashesArray',$value) : stripslashes($value);
		return $value;
	}
	public function addSlashesArray($value)
	{
		$value = is_array($value) ? array_map('addSlashesArray',$value) : addslashes($value);
		return $value;
	}
	
	public function addSlashesExtended($value)
	{
		if(is_array($value))
		{
			foreach($value as $va)
			{
			  is_array($va) ? addSlasheExtended($va): $va = addslashes($va);
			}
		}
		else {
		 $va = addslashes($value);
		}
		return $va; 
		 
	}
	

	public function clearXSS($value)
	{
		$val = ereg_replace("~<script[^>]*>.+</script[^>]*>~isU", "", stripAllTags(rawurldecode($value)));
		return(ereg_replace(")","",$val));
	}
	
	public function escapeString($string) {
		// depreciated function
		if (version_compare(phpversion(),"4.3.0", "<")) mysql_escape_string($string);
		// current function
		else mysql_real_escape_string($string);
		return $string;
	}
	
	public function filterData($input)
	{
		return filter_var($input,FILTER_SANITIZE_STRING);
	
	}
	
	public function sanitize($value) 
	{
	  $matchpattern = "[^a-zA-Z0-9.,]@+";  
	  if(eregi($matchpattern,$value))
	  {
		$sanitizedInput = ereg_replace("[^a-zA-Z0-9.,[:space:]@]","",$value);
		$value = $sanitizedInput;
	  }	
	  return $value;
	}
	
	public function sanitizeEmail($emailId)
	{
		$emailId = filter_var($emailId, FILTER_SANITIZE_EMAIL);  
		return $emailId;
	}
	
	public function sanitizeURL($url)
	{
		$url = filter_var($url, FILTER_SANITIZE_URL);  
		return $url;
	}
	
	public function sanitizeIP($ipAddress)
	{
		$ipAddress = filter_var($ipAddress, FILTER_SANITIZE_IP);  
		return $ipAddress;
	}
	
	public function checkUserPermission($tMenu)
	{
		if(empty($tMenu))
		{
			return 'Default';
		}
		elseif($tMenu == "Search")
		{
			$aPerm 		= $this->oSession->getSession('sesMenuPermission'); //adds Orderdetails permission for search
			if($rOtherLinks = $this->oDb->getResults("SELECT db_lscatId FROM linksubcattable WHERE ls_catParentId = '6' AND ls_catMenuType = 2", ARRAY_A))
							{
								foreach($rOtherLinks as $other)
								{
									if(!in_array($other['db_lscatId'], $aPerm))
									{
										$aPerm[] = $other['db_lscatId'];
										$this->oSession->setSession('sesMenuPermission',$aMenuPerm);
									}
								}
							}
			$this->oSession->setSession('sesMenuPermission',$aPerm);
			return $tMenu;
		}
		else
		{
			$tMenu = trim($tMenu);
			if($rMenuId = $this->oDb->getRow("SELECT db_lscatId FROM linksubcattable WHERE db_lscatLink = '$tMenu'"))
			{
				$menuId = $rMenuId->db_lscatId;
				if(!in_array($menuId, $this->oSession->getSession('sesMenuPermission')))
				{
					
					return 'Error';
				}
				else
				{
					return $tMenu;
				}
			}
			else
			{
				return $tMenu;
			}
		}
	}

}
?>
