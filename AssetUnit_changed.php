<?php
	/**
	  * AssetUnit class
	  *
	  * @author Subash Gopalaswamy <techhead.stallioni@gmail.com>
	  */
  
  class AssetUnit
  {
	public function __construct()
	{
	   //
	}
	
	public function setDb($oDb)
	{
	   $this->oDb = $oDb;
	}
	
	public function addAssetUnit($aRequest)
	{
	  $asset_name   = strtoupper($aRequest['fAssetUnitName']);
	  $unit_desc    = $aRequest['fAssetUnitDesc'];
	  $asset_parent_unit = $aRequest['fAssetParentUnit'];
	  $asset_status      = $aRequest['fStatus'];
	  $asset_create_by   = $_SESSION['sesCustomerInfo']['user_id'];
	 $incharge = $aRequest['fEmployeeId'];
	$query = "INSERT INTO asset_unit (id_parent_unit, unit_name,id_employee, unit_desc,created_by,created_on,modified_by, modified_on,status) VALUES (".$asset_parent_unit.",'".$asset_name."','".$incharge."','".$unit_desc."','".$asset_create_by."',now(),'', now(),'".$asset_status."')";
	
	  if($this->oDb->query($query))
	   {
	     //exit();
		    $lastInsertId = $this->oDb->insert_id;
		
	     return  $lastInsertId;
	   }
	   else { //exit();
	     return false;
	   }	 
	}
	public function getAssetUnitInfo($unitId)
	{
	   
	   $aAssetUnitInfo = array();
	   $query = "SELECT id_unit, id_parent_unit,id_unit_address,id_employee, unit_name, unit_desc,created_by,created_on,modified_by, modified_on,status FROM asset_unit WHERE id_unit =".$unitId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $aAssetUnitInfo['id_unit']          = $row->id_unit;
		  $aAssetUnitInfo['id_parent_unit']   = $row->id_parent_unit;
		   $aAssetUnitInfo['id_unit_address']   = $row->id_unit_address;
		     $aAssetUnitInfo['id_employee']   = $row->id_employee;
		   $aAssetUnitInfo['asset_parent_unit_name'] = strtoupper($this->getAssetUnitName($row->id_parent_unit)); 
		  $aAssetUnitInfo['unit_name']    = strtoupper($row->unit_name);
		  $aAssetUnitInfo['unit_desc']    = $row->unit_desc;
		  $aAssetUnitInfo['status']       = $row->status;
	   }
	   return $aAssetUnitInfo;
	   
	}
	public function getAssetUnitName($unitId)
	{
	   $asset_unit_name = '';
	   if($unitId == '0')
	   {
	     $asset_unit_name = 'No Parent';
	   }
	   else {
	   $query = "SELECT unit_name FROM asset_unit WHERE id_unit =".$unitId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $asset_unit_name = $row->unit_name;
	   }
	   }
	   return $asset_unit_name;
	}
	
	public function updateAssetUnit($aRequest)
	{
	  $done = 0;
	  $assetunitId       = $aRequest['fAssetUnitID'];
	  $asset_name        = strtoupper($aRequest['fAssetUnitName']);
	  $unit_desc         = $aRequest['fAssetUnitDesc'];
	  $asset_parent_unit = $aRequest['fAssetParentUnit'];
	  $asset_modified_by = $_SESSION['sesCustomerInfo']['user_id'];
	  $status = $aRequest['fStatus'];
	   $incharge = $aRequest['fEmployeeId'];
	 $query = "UPDATE asset_unit SET id_parent_unit =".$asset_parent_unit.", unit_name ='".$asset_name."',id_employee='".$incharge."', unit_desc ='".$unit_desc."', status = ".$status.",modified_by = ".$asset_modified_by.", modified_on = now() WHERE id_unit = ".$assetunitId;
	//echo '<br>';
	 $this->oDb->query($qry);
	 //echo mysql_affected_rows();
	 //exit();
				if( mysql_affected_rows() >= 0)
				{
				 $done = 1;
				}
	  return 1; //$done;
	  
	}
	
	public function deleteAssetUnit($unitId)
	{
		   $done = 0;
		   $valid = true;
		  $chkqry = "SELECT count(id_parent_unit) as numChild FROM asset_unit WHERE id_parent_unit = $unitId";
		   if($row = $this->oDb->get_row($chkqry))
		   {
			 $numChild = $row->numChild;
			 
			   if($numChild > 0)
			   {
				   $valid = false;
			   }
		   }
		   if($valid)
		   {
			 $query = "UPDATE asset_unit SET status = 2 where id_unit = ".$unitId;
			 if($this->oDb->query($query))
			 {
			   $done = 1;
			 }
	       }
		   return $done;
	   
	} //deleteAssetUnit
	
	public function getAssetSubUnitList($parentUnitId)  //sub unit under a parent asset unit
	{
	  $aSubUnitList = array();
	  $query = "SELECT id_unit, unit_name, unit_desc,status FROM asset_unit WHERE id_parent_unit =".$parentUnitId;
	  if($result = $this->oDb->get_results($query))
	  {
	     foreach($result as $row)
		 {
		   $aSubUnitList[] = $row->unit_name;
		 }
	  }
	  return $aSubUnitList;
 
	}
	
	public function getAssetParentUnitInfo($unitId)
	{
	   $aParentUnitInfo = array();
	   $query = "SELECT id_parent_unit FROM asset_unit WHERE id_unit = ".$unitId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $parent_Unit_id = $row->id_parent_unit;
		  $aParentUnitInfo = $this->getAssetUnitInfo($parent_cat_id);
	   }
	   return $aParentUnitInfo;
	}
	
	public function getAllAssetUnitInfo()
	{
	   
	   $aAssetUnitInfo = array();
	   $query = "SELECT * FROM asset_unit ORDER BY id_unit DESC ";
	   if($result = $this->oDb->get_results($query))
	   {
		   foreach($result as $row)
		   {
			  $aAssetUnit = array();
			  $aAssetUnit['id_unit']          = $row->id_unit;
			  $aAssetUnit['id_parent_unit']   = $row->id_parent_unit;
			   $aAssetUnit['id_unit_address']   = $row->id_unit_address;
			  $aAssetUnit['id_employee']   = $row->id_employee;
			  $aAssetUnit['asset_parent_unit_name'] = strtoupper($this->getAssetUnitName($row->id_parent_unit)); 
			  $aAssetUnit['unit_name']    = strtoupper($row->unit_name);
			  $aAssetUnit['unit_desc']    = $row->unit_desc;
			  $aAssetUnit['status']       = $row->status;
			  $aAssetUnitInfo[]           = $aAssetUnit;
		   }
		  
	   }
	   return $aAssetUnitInfo;
	   
	}
  } //end class
?>