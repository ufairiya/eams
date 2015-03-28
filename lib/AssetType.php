<?php
	/**
	  * AssetType class
	  *
	  * @author Subash Gopalaswamy <techhead.stallioni@gmail.com>
	  */
  
  class AssetType
  {
  	
	public function __construct()
	{
	   //
	}
	
	public function setDb($oDb)
	{
	   $this->oDb = $oDb;
	}
	
	public function addAssetType($aRequest)
	{
	  $asset_type_name       = strtoupper($aRequest['fAssetTypeName']);
	  $asset_type_desc       = $aRequest['fAssetTypeDesc'];
	  $id_asset_parent_type	 = $aRequest['fParentAssetTypeId'];
	  $id_asset_category	 = $aRequest['fAssetCategory'];
	  $status             = $aRequest['fStatus'];
	  $created_by         = $_SESSION['sesCustomerInfo']['user_id'];
	  $lookup             = strtoupper($aRequest['fLookup']);
	  
	  //check for duplicate values...
	  $dupqry = "SELECT asset_type_name, lookup FROM asset_type WHERE asset_type_name ='".$asset_type_name."' OR lookup = '".$lookup."'";
	  
	  if($result = $this->oDb->get_results($dupqry))
	  {
	     return false;
	  }
	  else {
	  
	  
	  
 $query = "INSERT INTO asset_type(id_asset_type,id_asset_parent_type,  id_asset_category, asset_type_name,asset_type_desc,	 lookup,	 created_by, created_on,modified_by, modified_on,  status ) VALUES ( null, '".$id_asset_parent_type."','". $id_asset_category."','". $asset_type_name."','". $asset_type_desc."','". $lookup."','".$created_by."',now(),'', '','".$status."')";

	
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
	    
	}//end function

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
	
	
	
	public function getAssetTypeInfo($lookup,$type)
	{
	    $query = "SELECT id_asset_type,id_asset_parent_type,id_asset_category, asset_type_name, asset_type_desc,lookup, created_by,created_on, modified_by, modified_on, status FROM asset_type WHERE ";
		   if($type == 'id') {
			 $condition = " id_asset_type = '$lookup'";
		   }
		   else {
			 $condition = " id_asset_category	 = ".$lookup;
		   }
		   $query = $query.$condition;
	   $aAssetTypeInfo = array();
	  
	   if($row = $this->oDb->get_row($query))
	   {
	      $aAssetTypeInfo['id_asset_type']         = $row->id_asset_type;
		  $aAssetTypeInfo['id_asset_parent_type']  = $row->id_asset_parent_type;
		  $aAssetTypeInfo['id_asset_category']      = $row->id_asset_category;
		  $aAssetTypeInfo['asset_type_name']    = $row->asset_type_name;
		  $aAssetTypeInfo['asset_type_desc']    = $row->asset_type_desc;
		  $aAssetTypeInfo['status']             = $row->status;
		  $aAssetTypeInfo['lookup']              = $row->lookup;
		 
	   }
	   return $aAssetTypeInfo;
	   
	}
	public function getAssetTypeName($assetTypeId)
	{
	   $asset_type_name = '';
	   $query = "SELECT asset_type_name FROM asset_type WHERE id_asset_type =".$assetTypeId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $asset_type_name = $row->asset_type_name;
	   }
	   return $asset_type_name;
	}
	//
	public function updateAssetType($aRequest)
	{
	  $done = 0;
	  $asset_type_id      = $aRequest['fAssetTypeId'];
	  $id_asset_category  = $aRequest['fAssetCategory'];
	  $asset_type_name    = $aRequest['fAssetTypeName'];
	  $asset_type_desc    = $aRequest['fAssetTypeDesc'];
	  $id_asset_parent_type  = $aRequest['fParentAssetTypeId'];
	  $lookup             = strtoupper($aRequest['fLookup']);
	  $modified_by        = $_SESSION['sesCustomerInfo']['user_id'];
	  $status             = $aRequest['fStatus'];
	  
	  $query = "UPDATE asset_type SET  id_asset_parent_type = '".$id_asset_parent_type."',  id_asset_category = '".$id_asset_category."',  asset_type_name ='".$asset_type_name."', asset_type_desc ='".$asset_type_desc."', lookup ='".$lookup."', status = '".$status."',  modified_by = '".$modified_by."',  modified_on = now() WHERE  id_asset_type = ".$asset_type_id;
				  
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
	
	public function deleteAssetType($assetTypeId)
	{
	  $done = 0;
		   $valid = true;
		   $chkqry = "SELECT 
		                 count(id_asset_parent_type) as numChild 
					  FROM 
					     asset_type 
					  WHERE 
					     id_asset_parent_type = $assetTypeId";
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
			 $query = "UPDATE asset_type SET status = 2 where id_asset_type = ".$assetTypeId;
			 if($this->oDb->query($query))
			 {
			   $done = 1;
			 }
	       }
		   return $done;
	   
	} //deleteAssetType
	
	public function deletePermanentAssetType($assetTypeId)
	{
	 $query = "DELETE FROM asset_type WHERE id_asset_type = ".$assetTypeId;
			 if($this->oDb->query($query))
			 {
			   $done = 1;
			 }
	      
		   return $done;
	
	}
	
	public function getAllAssetTypeList()
	{
	   
	   $aAllAssetTypeList = array();
	   $query = "SELECT * FROM asset_type";
	   if($result = $this->oDb->get_results($query))
	   {
		   foreach($result as $row)
		   {
			  $aAssetType = array();
			  $aAssetType['id_asset_type']  = $row->id_asset_type;
			  $aAssetType['id_asset_parent_type']= $row->id_asset_parent_type;
			  $aAssetType['id_asset_category']   = $row->id_asset_category;
			  $aAssetType['parent_AssetType_name']   = $this->getAssetTypeName($row->id_asset_parent_type);
			  $aAssetType['asset_type_name']     = $row->asset_type_name;
			  $aAssetType['asset_type_desc']     = $row->asset_type_desc;
			  $aAssetType['status']              = $row->status;
			  $aAssetType['lookup']              = $row->lookup;
			  $aAllAssetTypeList[] = $aAssetType;
		   }
		  
	   }
	   return $aAllAssetTypeList;
	   
	} //getAllBuildingList
	public function getAllAssetTypeListInfo($lookup,$type)
	{
	   
	   $aAllAssetTypeList = array();
	   
	   $query = "SELECT * FROM asset_type WHERE status != 2 and ";
	    if($type == 'id') {
			 $condition = " id_asset_type = '$lookup'";
		   }
		   else {
			 $condition = " id_asset_category	 = ".$lookup;
		   }
		  $query = $query.$condition;
		 
	   if($result = $this->oDb->get_results($query))
	   {
		   foreach($result as $row)
		   {
			  $aAssetType = array();
			  $aAssetType['id_asset_type']  = $row->id_asset_type;
			  $aAssetType['id_asset_parent_type']= $row->id_asset_parent_type;
			  $aAssetType['id_asset_category']   = $row->id_asset_category;
			  $aAssetType['parent_AssetType_name']   = $this->getAssetTypeName($row->id_asset_parent_type);
			  $aAssetType['asset_type_name']     = $row->asset_type_name;
			  $aAssetType['asset_type_desc']     = $row->asset_type_desc;
			  $aAssetType['status']              = $row->status;
			  $aAssetType['lookup']              = $row->lookup;
			  $aAllAssetTypeList[] = $aAssetType;
		   }
		  
	   }
	   return $aAllAssetTypeList;
	   
	} 
	
  } //end class
?>