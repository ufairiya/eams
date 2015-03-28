<?php


	/**
	  * Building class
	  *
	  * @author Subash Gopalaswamy <techhead.stallioni@gmail.com>
	  */
  
  class Building
  {
  	
	public function __construct()
	{
	   //
	}
	
	public function setDb($oDb)
	{
	   $this->oDb = $oDb;
	}
	
	public function addBuilding($aRequest)
	{
	  $asset_buildingname   = $aRequest['fBuildingName'];
	  $building_desc   = $aRequest['fBuildingDesc'];
	  $asset_buildingstatus = $aRequest['fStatus'];
	  $asset_unit_id =$aRequest['fAssetUnitID'];
	  $asset_create_by = $_SESSION['sesCustomerInfo']['user_id'];
	$query = "INSERT INTO asset_building (	id_unit,building_name,building_desc,created_by,created_on,modified_by, modified_on,status) VALUES (".$asset_unit_id.",'".$asset_buildingname."','".$building_desc."','".$asset_create_by."',now(),'', now(),'".$asset_buildingstatus."')";
	
	  if($this->oDb->query($query))
	   {
	     //exit();
	     return true;
	   }
	   else { //exit();
	     return false;
	   }	 
	}

	public function getBuildingInfo($buildingId)
	{
	   
	   $aBuildingInfo = array();
	   $query = "SELECT id_building, id_unit, building_name, building_desc,created_by,created_on,modified_by, modified_on,status FROM asset_building WHERE id_building =".$buildingId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $aBuildingInfo['id_building']          = $row->id_building;
		  $aBuildingInfo['id_unit']   = $row->id_unit;
		  $aBuildingInfo['building_name']    = $row->building_name;
		  $aBuildingInfo['building_desc']    = $row->building_desc;
		  $aBuildingInfo['status']    = $row->status;
	   }
	   return $aBuildingInfo;
	   
	}
	public function getBuildingName($buildingId)
	{
	   $asset_unit_name = '';
	   $query = "SELECT building_name FROM asset_building WHERE id_building =".$buildingId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $asset_unit_name = $row->building_name;
	   }
	   return $asset_unit_name;
	}
	
	public function updateBuilding($aRequest)
	{
	  $done = 0;
	  $BuildingId       = $aRequest['fBuildingID'];
	  $asset_buildingname   = $aRequest['fBuildingName'];
	  $building_desc   = $aRequest['fBuildingDesc'];
	  $asset_modified_by = $_SESSION['sesCustomerInfo']['user_id'];
	  $asset_unit_id  = $aRequest['fAssetUnitID'];
	  $status = $aRequest['fStatus'];
	 $query = "UPDATE asset_building SET id_unit =".$asset_unit_id.", building_name ='".$asset_buildingname."', building_desc ='".$building_desc."', status = ".$status.",modified_by = ".$asset_modified_by.", modified_on = now() WHERE id_building = ".$BuildingId;

	if($this->oDb->query($query))
	  {
	     $done = 1;
	  }
	  return $done;
	  
	}
	
	public function deleteBuilding($buildingId)
	{
	   $done = 0;
	  $query = "UPDATE asset_building SET status=2 where id_building = ".$buildingId;
	
	   if($this->oDb->query($query))
	   {
	     $done = 1;
	   }
	   return $done;
	}
	
	public function getAssetSubUnitList($parentbuildingId)  //sub unit under a parent asset unit
	{
	  $aSubUnitList = array();
	  $query = "SELECT id_building, building_name, building_desc,status FROM asset_building WHERE id_unit =".$parentbuildingId;
	  if($result = $this->oDb->get_results($query))
	  {
	     foreach($result as $row)
		 {
		   $aSubUnitList[] = $row->building_name;
		 }
	  }
	  return $aSubUnitList;
 
	}
	
	public function getAssetParentBuildingInfo($buildingId)
	{
	   $aParentUnitInfo = array();
	   $query = "SELECT id_parent_build FROM asset_building WHERE id_building = ".$buildingId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $parent_Unit_id = $row->id_parent_unit;
		  $aParentUnitInfo = $this->getBuildingInfo($parent_cat_id);
	   }
	   return $aParentUnitInfo;
	}
	
	public function getAllBuildingInfo()
	{
	   
	   $aBuildingInfo = array();
	   $query = "SELECT * FROM asset_building WHERE status !=2";
	   if($result = $this->oDb->get_results($query))
	   {
		   foreach($result as $row)
		   {
			  $aBuilding = array();
			  $aBuilding['id_building']          = $row->id_building;
			  $aBuilding['id_unit']   = $row->id_unit;
			  $aBuilding['building_name']    = $row->building_name;
			  $aBuilding['building_desc']    = $row->building_desc;
			  $aBuilding['status']    = $row->status;
			  $aBuildingInfo[] = $aBuilding;
		   }
		  
	   }
	   return $aBuildingInfo;
	   
	}
  } //end class
?>