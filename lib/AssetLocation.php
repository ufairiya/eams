<?php
	/**
	  * Location class
	  *
	  * @author Subash Gopalaswamy <techhead.stallioni@gmail.com>
	  */
  
  class AssetLocation
  {
  	
	public function __construct()
	{
	   //
	}
	
	public function setDb($oDb)
	{
	   $this->oDb = $oDb;
	}
	
	public function addLocation($aRequest)
	{
	  $location_name         = $aRequest['fLocationName'];
	  $location_desc         = $aRequest['fLocationDesc'];
	  $id_parent_location	 = $aRequest['fParentLocationId'];
	  $status             = $aRequest['fStatus'];
	  $created_by         = $_SESSION['sesCustomerInfo']['user_id'];
	  
	 $query = "INSERT INTO asset_location(
	            id_parent_location, 
				 
				 id_location_name, 
				 id_location_desc,
				 created_by,
				 created_on,
				 modified_by,
				 modified_on, 
				 status ) VALUES ( ".
				 $id_parent_location.",'".
				 $location_name."','".
				 $location_desc."','".
				 $created_by."',now(),'', now(),'".$status."')";
	
	  if($this->oDb->query($query))
	   {
	       //uploading the category image. 
		   /*$lastInsertId = $oDb->insert_id;
		   if($this->uploadCategoryImage($aRequest, $lastInsertId))
		   {
	         return true;
		   }
		   else
		     return false; 	 */
		return true;
	   }
	   else { //exit();
	     return false;
	   }	 
	}

/*	public function uploadCategoryImage($files, $lastInsertId)
	{
		if(!empty($files['fCategoryImage']['name']))
		{
		   $fileName = $files['fCategoryImage']['name']; //echo '<br>';
		   $ext = explode(".", $fileName);
		   $ext = array_pop($ext);
		   $newFileName = '_category.'.$ext;
		   $fileup = $files['fDealerLogo']['tmp_name']; //echo '<br>';
		   $targetPath 	= APP_ROOT."/uploads/categoryimages/"; //echo '<br>';
		   $dealerId = $aData['id']; //echo '<br>';
		   $targetFileName = $lastInsertId.$newFileName; //echo '<br>';
		   move_uploaded_file($fileup, $targetPath.$targetFileName);
		   //update database.
		   $query = "UPDATE asset_category SET category_image = '".$targetFileName."' WHERE id_category = ".$lastInsertId;
		   if($this->oDb->query($query))
		   {
			 $valid = true;
		   }	 
			return $valid;
		}
	} //upload category image*/
	
	
	
	public function getLocationInfo($locationId)
	{
	   $aLocationInfo = array();
	  $query = "SELECT id_location, 
	                    id_parent_location,
						id_location_name, 
				        id_location_desc,
						created_by,
						created_on, 
						modified_by, 
						modified_on, status FROM asset_location WHERE id_location =".$locationId; 
	   if($row = $this->oDb->get_row($query))
	   {
	      $aLocationInfo['id_location']         = $row->id_location;
		  $aLocationInfo['id_parent_location']  = $row->id_parent_location;
		  $aLocationInfo['id_location_name']    = $row->id_location_name;
		  $aLocationInfo['id_location_desc']    = $row->id_location_desc;
		  $aLocationInfo['status']             = $row->status;
	   }
	   return $aLocationInfo;
	   
	}
	public function getLocationName($locationId)
	{
	   $location_name = '';
	  $query = "SELECT id_location_name FROM asset_location WHERE id_location =".$locationId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $location_name = $row->id_location_name;
	   }
	   return $location_name;
	}
	//
	 
	public function updateLocation($aRequest)
	{
	  $done = 0;
	  $id_location         = $aRequest['fLocationId'];
	  $location_name     = $aRequest['fLocationName'];
	  $location_desc     = $aRequest['fLocationDesc'];
	  $id_location_parent_type  = $aRequest['fParentLocationId'];
	  
	  $modified_by        = $_SESSION['sesCustomerInfo']['user_id'];
	  $status             = $aRequest['fStatus'];
	  
	  $query = "UPDATE asset_location SET 
	                   id_parent_location	 = ".$id_location_parent_type.
					   ",  id_location_name ='".$location_name.
					   "', id_location_desc ='".$location_desc.
					   "', status = ".$status.
					   ",  modified_by = ".$modified_by.
					   ",  modified_on = now() 
			    WHERE 
				   	id_location = ".$id_location;
	 if($this->oDb->query($query))
	  {
	     $done = 1;
		 //Update the image uploaded here.....
		 /*if( $aRequest['fCategoryImage']['name'] != null )
		 {
		   $this->uploadCategoryImage($aRequest);
		 } */ 

	  }
	  return $done;
	  
	} //
	
	public function deleteLocation($locationId)
	{

	 $done = 0;
		   $valid = true;
		   $chkqry = "SELECT 
		                 count(id_parent_location) as numChild 
					  FROM 
					     asset_location 
					  WHERE 
					     id_parent_location = $locationId";
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
			 $query = "UPDATE asset_location SET status = 2 where id_location = ".$locationId;
			 if($this->oDb->query($query))
			 {
			   $done = 1;
			 }
	       }
		   return $done;
	   
	} //deleteLocation
	
	public function getAllLocationList()
	{
	   
	   $aAllLocationList = array();
	   $query = "SELECT * FROM asset_location WHERE status != 2";
	   if($result = $this->oDb->get_results($query))
	   {
		   foreach($result as $row)
		   {
			  $aLocation = array();
			  $aLocation['id_location']  = $row->id_location;
			  $aLocation['id_parent_location']= $row->id_parent_location;
			  $aLocation['parent_location_name']= $this->getLocationName($row->id_parent_location); 
			  $aLocation['id_location_name']     = $row->id_location_name;
			  $aLocation['id_location_desc']     = $row->id_location_desc;
			  $aLocation['status']              = $row->status;
			  $aAllLocationList[] = $aLocation;
		   }
		  
	   }
	   return $aAllLocationList;
	   
	} //getAllBuildingList
	
  } //end class
?>