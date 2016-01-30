<?php
	/**
	  * Category class
	  *
	  * @author Subash Gopalaswamy <techhead.stallioni@gmail.com>
	  */
  
  class AssetCategory
  {
  	
	public function __construct()
	{
	   //
	}
	
	public function setDb($oDb)
	{
	   $this->oDb = $oDb;
	}
	
	public function addCategory($aRequest,$files)
	{
	  $category_name      = $aRequest['fCategoryName'];
	  $category_desc      = $aRequest['fCategoryDesc'];
	  $id_parent_category = $aRequest['fParentCategoryId'];
	  $status             = $aRequest['fStatus'];
	  $created_by         = $_SESSION['sesCustomerInfo']['user_id'];
	  $lookup             = strtoupper($aRequest['fLookup']);
	  $query = "INSERT INTO asset_category(
	             id_parent_category, 
				 category_name, 
				 category_desc,
				 lookup,
				 created_by,
				 created_on,
				 modified_by,
				 modified_on, 
				 status ) VALUES (".
				 $id_parent_category.",'".
				 $category_name."','".
				 $category_desc."','".
				  $lookup."','".
				 $created_by."',now(),'', now(),'".$status."')";
	
	  if($this->oDb->query($query))
	   {
	       //uploading the category image. 
		   $lastInsertId = $this->oDb->insert_id;
		   if($this->uploadCategoryImage($files, $lastInsertId))
		   {
	         return true;
		   }
		   else
		     return false; 	 
	   }
	   else { //exit();
	     return false;
	   }	 
	}
	public function uploadCategoryImage($files, $lastInsertId)
	{
		 $files['fCategoryImage']['name'];
		if(!empty($files['fCategoryImage']['name']))
		{
		   $fileName = $files['fCategoryImage']['name']; //echo '<br>';
		   $ext = explode(".", $fileName);
		   $ext = array_pop($ext);
		   $newFileName = '_category.'.$ext;
		   $fileup = $files['fCategoryImage']['tmp_name']; //echo '<br>';
		   $targetPath 	= APP_ROOT."/uploads/categoryimages/"; //echo '<br>';
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
	} //upload category image
	
	
	
	public function getCategoryInfo($lookup,$type)
	{
	   $aCategoryInfo = array();
	   $query = "SELECT id_category, 
	                    id_parent_category, 
						category_name, 
						category_desc,
						category_image,
						lookup, 
						created_by,
						created_on, 
						modified_by, 
						modified_on, status FROM asset_category WHERE ";
						
						if($type == 'id') {
			 $condition = " id_category = '$lookup'";
		   }
		   else {
			 $condition = " lookup	 = ".$lookup;
		   }
		   $query = $query.$condition;
	   if($row = $this->oDb->get_row($query))
	   {
	      $aCategoryInfo['id_category']         = $row->id_category;
		  $aCategoryInfo['id_parent_category']  = $row->id_parent_category;
		  $aCategoryInfo['category_image']      = $row->category_image;
		  //$aBuildingInfo['parent_department_name'] = $this->getDepartmentName($row->id_parent_department); 
		  $aCategoryInfo['category_name']    = $row->category_name;
		  $aCategoryInfo['category_desc']    = $row->category_desc;
		  $aCategoryInfo['status']           = $row->status;
		  $aCategoryInfo['lookup']           = $row->lookup;
	   }
	   return $aCategoryInfo;
	   
	}
	public function getCategoryName($categoryId)
	{
	   $category_name = '';
	   $query = "SELECT category_name FROM asset_category WHERE id_category =".$categoryId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $category_name = $row->category_name;
	   }
	   return $category_name;
	}
	//
	public function updateCategory($aRequest,$files)
	{
	  $done = 0;
	  $category_id      = $aRequest['fCategoryId'];
	  
	  $category_name    = $aRequest['fCategoryName'];
	  $category_desc    = $aRequest['fCategoryDesc'];
	  $parent_category_id  = $aRequest['fParentCategoryId'];
	  //$parent_department  = $aRequest['fParentDepartment'];
	  $modified_by        = $_SESSION['sesCustomerInfo']['user_id'];
	  $status             = $aRequest['fStatus'];
	  $lookup             = strtoupper($aRequest['fLookup']);
	 $query = "UPDATE asset_category SET 
	                   id_parent_category = ".$parent_category_id.
					   ",  category_name ='".$category_name.
					   "', category_desc ='".$category_desc.
					   "', lookup ='".$lookup.
					   "', status = ".$status.
					   ",  modified_by = ".$modified_by.
					   ",  modified_on = now() 
			    WHERE 
				   id_category = ".$category_id;
				  
	 if($this->oDb->query($query))
	  {
	     $done = 1;
		  
		 //Update the image uploaded here.....
		 if( $files['fCategoryImage']['name'] != null )
		 {
		   $this->uploadCategoryImage($files,$category_id);
		 }  
	  }
	  return $done;
	  
	} //
	
	public function deleteCategory($categoryId)
	{
	  $done = 0;
		   $valid = true;
		   $chkqry = "SELECT 
		                 count(id_parent_category) as numChild 
					  FROM 
					     asset_category 
					  WHERE 
					     id_parent_category = $categoryId";
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
			 $query = "UPDATE asset_category SET status = 2 where id_category = ".$categoryId;
			 if($this->oDb->query($query))
			 {
			   $done = 1;
			 }
	       }
		   return $done;
	   
	} //deleteBuilding
	
	public function getAllCategoryList()
	{
	   
	   $aAllCategoryList = array();
	   $query = "SELECT * FROM asset_category WHERE status != 2";
	   if($result = $this->oDb->get_results($query))
	   {
		   foreach($result as $row)
		   {
			  $aCategory = array();
			  $aCategory['id_category']  = $row->id_category;
			  $aCategory['id_parent_category']   = $row->id_parent_category;
			  $aCategory['parent_category_name']= $this->getCategoryName($row->id_parent_category); 
			  $aCategory['category_name']        = $row->category_name;
			  $aCategory['category_image']        = $row->category_image;
			  $aCategory['category_desc']        = $row->category_desc;
			  $aCategory['status']               = $row->status;
			  $aCategory['lookup']               = $row->lookup;
			  $aAllCategoryList[] = $aCategory;
		   }
		  
	   }
	   return $aAllCategoryList;
	   
	} //getAllBuildingList
	
  } //end class
?>