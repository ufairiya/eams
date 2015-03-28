<?php
	/**
	  * UserRights class
	  *
	  * @author Subash Gopalaswamy <techhead.stallioni@gmail.com>
	  */
  
  class UserRights
  {
  	
	public function __construct()
	{
	   //
	}
	
	public function setDb($oDb)
	{
	   $this->oDb = $oDb;
	}
	
	public function getAllMenuList()
	{
	    $qry = "SELECT db_lscatId, db_lscatName,db_lscatLink,db_lcatId FROM linksubcattable WHERE db_lscatStatus=1";
		$result = $this->oDb->get_results($qry, ARRAY_A);
		return $result;
	  }
	public function getCrudList()
	{
	    $qry = "SELECT db_lscrudId, db_lscatName,db_lscatLink,db_lcatId FROM lscrud WHERE db_lscatStatus=1";
		$result = $this->oDb->get_results($qry, ARRAY_A);
		return $result;
	  }
	
	
  } //end class
?>