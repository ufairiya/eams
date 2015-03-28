<?php
	/**
	  * ItemCategory class
	  *
	  * @author Subash Gopalaswamy <techhead.stallioni@gmail.com>
	  */
  
  class ItemCategory
  {
  	
	public function __consruct()
	{
	   //
	}
	
	public function setDb($oDb)
	{
	   $this->oDb = $oDb;
	}
	
	public function addItemCategory($aRequest)
	{
	   $item_cat_name   = $aRequest['fItemCatName'];
	   $item_cat_desc   = $aRequest['fItemCatDesc'];
	   $item_parent_cat = $aRequest['fItemParentCat'];
	  $query = "INSERT INTO itemcategory (item_cat_id, item_parent_cat_id, item_cat_name, item_cat_desc,status, created_on, modified_on) VALUES (null,".$item_parent_cat.",'".$item_cat_name."','".$item_cat_desc."',1, now(), now())";

	   if($this->oDb->query($query))
	   {
	     //exit();
	     return true;
	   }
	   else { //exit();
	     return false;
	   }	 
	}

	public function getItemCategoryInfo($itemCatId)
	{
	   
	   $aItemCategoryInfo = array();
	   $query = "SELECT item_cat_id, item_parent_cat_id, item_cat_name, item_cat_desc FROM itemcategory WHERE item_cat_id =".$itemCatId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $aItemCategoryInfo['item_cat_id']          = $row->item_cat_id;
		  $aItemCategoryInfo['item_parent_cat_id']   = $row->item_parent_cat_id;
		  $aItemCategoryInfo['item_parent_cat_name'] = $this->getItemCategoryName($row->item_parent_cat_id); 
		  $aItemCategoryInfo['item_cat_name']    = $row->item_cat_name;
		  $aItemCategoryInfo['item_cat_desc']    = $row->item_cat_desc;
	   }
	   return $aItemCategoryInfo;
	   
	}
	public function getItemCategoryName($itemCatId)
	{
	   $item_cat_name = '';
	   $query = "SELECT item_cat_name FROM itemcategory WHERE item_cat_id =".$itemCatId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $item_cat_name = $row->item_cat_name;
	   }
	   return $item_cat_name;
	}
	
	public function updateItemCategory($aRequest)
	{
	 
	 
	  $done = 0;
	  $itemCatId       = $aRequest['fItemCatID'];
	  $itemParentCatId = $aRequest['fItemParentCat'];
	  $itemCatName     = $aRequest['fItemCatName'];
	  $itemCatDesc     = $aRequest['fItemCatDesc'];
	  $status = $aRequest['fStatus'];
	 $query = "UPDATE itemcategory SET item_parent_cat_id =".$itemParentCatId.", item_cat_name ='".$itemCatName."', item_cat_desc ='".$itemCatDesc."', status = ".$status.", modified_on = now() WHERE item_cat_id = ".$itemCatId;
	
	  if($this->oDb->query($query))
	  {
	     $done = 1;
	  }
	  return $done;
	  
	}
	
	public function deleteItemCategory($itemCatId)
	{
	   $done = 0;
	   $query = "DELETE from itemcategory where item_cat_id = ".$itemCatId;
	   if($this->oDb->query($query))
	   {
	     $done = 1;
	   }
	   return $done;
	}
	
	public function getItemSubCategoryList($parentCatId)  //sub categories under a parent category
	{
	  $aSubCategoryList = array();
	  $query = "SELECT item_cat_id, item_cat_name, item_cat_desc FROM itemcategory WHERE item_parent_cat_id =".$parentCatId;
	  if($result = $this->oDb->get_results($query))
	  {
	     foreach($result as $row)
		 {
		   $aSubCategoryList[] = $row->item_cat_name;
		 }
	  }
	  return $aSubCategoryList;
 
	}
	
	public function getItemParentCatInfo($itemCatId)
	{
	   $aParentCatInfo = array();
	   $query = "SELECT item_parent_cat_id FROM itemcategory WHERE item_cat_id = ".$itemCatId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $parent_cat_id = $row->item_parent_cat_id;
		  $aParentCatInfo = $this->getItemCategoryInfo($parent_cat_id);
	   }
	   return $aParentCatInfo;
	}
	
	public function getAllItemCategoryInfo()
	{
	   
	   $aItemCategoryInfo = array();
	   $query = "SELECT item_cat_id, item_parent_cat_id, item_cat_name, item_cat_desc,status FROM itemcategory";
	   if($result = $this->oDb->get_results($query))
	   {
		   foreach($result as $row)
		   {
			  $aItemCategory = array();
			  $aItemCategory['item_cat_id']          = $row->item_cat_id;
			  $aItemCategory['item_parent_cat_id']   = $row->item_parent_cat_id;
			  $aItemCategory['item_parent_cat_name'] = $this->getItemCategoryName($row->item_parent_cat_id); 
			  $aItemCategory['item_cat_name']    = $row->item_cat_name;
			  $aItemCategory['item_cat_desc']    = $row->item_cat_desc;
			   $aItemCategory['item_cat_status']    = $row->status;
			  $aItemCategoryInfo[] = $aItemCategory;
		   }
		  
	   }
	   return $aItemCategoryInfo;
	   
	}
  } //end class
?>