<?php
	/**
	  * Vendor class
	  *
	  * @author Subash Gopalaswamy <techhead.stallioni@gmail.com>
	  */
  
  class Vendor
  {
  	
	public function __construct()
	{
	   //
	}
	
	public function setDb($oDb)
	{
	   $this->oDb = $oDb;
	}
	
	public function addVendor($aRequest)
	{
		
	  $asset_vendorname   = strtoupper($aRequest['fVendorName']);
	   $usertype   = $aRequest['fUserType'];
	  $lookup   = strtoupper($aRequest['fLookup']);
	  $asset_vendorstatus = $aRequest['fStatus'];
	  $tin_no = $aRequest['fTinNumber'];
	  $cst_no = $aRequest['fCSTNumber'];
      $id_itemgroup1 = implode(",",$aRequest['fVendorGroupId']);
	  
	   $asset_create_by = $_SESSION['sesCustomerInfo']['user_id'];
	 $query = "INSERT INTO vendor (vendor_name,user_type,tin_no,cst_no,lookup, id_itemgroup1, created_by,created_on,modified_by, modified_on,status) VALUES ('".$asset_vendorname."','".$usertype."','".$tin_no."','".$cst_no."','". $lookup."','".$id_itemgroup1."','".$asset_create_by."',now(),'', now(),'".$asset_vendorstatus."')";
	
	
	  if($this->oDb->query($query))
	   {
	     //exit();
	      $lastInsertId = $this->oDb->insert_id;
		  foreach( $aRequest['fVendorGroupId'] as $key => $value)
			{
			
		$checkqry = "SELECT * FROM vendor_group_map WHERE id_vendor=' $lastInsertId' and id_itemgroup1='$value'";
		 $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{	
			$sql_update = "UPDATE vendor_group_map SET status ='1' ";
			$this->oDb->query($sql_update);
		
		}
		else
		{			
		 $sql = "INSERT INTO `vendor_group_map`(`id_vendor_group_map`, `id_vendor`, `id_itemgroup1`, `status`) VALUES (NULL,'$lastInsertId','$value','1')";
		$this->oDb->query($sql);
		}
	}
		 return $lastInsertId;
	   
	   }
	   else { //exit();
	     return false;
	   }	 
	}
public function updateAddress($lastInsertId,$reff_id)
{
	 $query = "UPDATE vendor SET  id_vendor_address = '". $lastInsertId."' WHERE id_vendor = ".$reff_id;
		   if($this->oDb->query($query))
		   {
			 $valid = true;
		   }	 
		
	    
	    else { //exit();
	     $valid =  false;
	   }
	 
	   return $valid;	 
}
	public function getVendorInfo($lookup, $type)
	{
	   
	   $avendorInfo = array();
	   $query = "SELECT id_vendor,user_type,tin_no,cst_no,lookup, id_itemgroup1, id_vendor_address, vendor_name,status FROM vendor WHERE";
	   if($type == 'lookup') {
	   	 $condition = " lookup = '$lookup'";
	   }
	    else {
	     $condition = " user_type='SUP' and id_vendor = ".$lookup;
	   }
	   $qry = $query.$condition; 
	   if($row = $this->oDb->get_row($qry))
	   {
	      $avendorInfo['id_vendor']          = $row->id_vendor;
		  $avendorInfo['id_vendor_address']   = $row->id_vendor_address;
		  $avendorInfo['user_type']   = $row->user_type;
		  $avendorInfo['vendor_name']    = strtoupper($row->vendor_name);
		   $avendorInfo['tin_no']    = $row->tin_no;
		    $avendorInfo['cst_no']    = $row->cst_no;
		  
		   $avendorInfo['lookup']   = strtoupper($row->lookup);
           $avendorInfo['id_itemgroup1']    = $row->id_itemgroup1;
		  $avendorInfo['status']    = $row->status;
	   }
	   return $avendorInfo;
	   
	}
	public function getVendorName($vendorId)
	{
	   $asset_unit_name = '';
	   $query = "SELECT vendor_name FROM vendor WHERE id_vendor =".$vendorId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $asset_unit_name = $row->vendor_name;
	   }
	   return $asset_unit_name;
	}
	
	public function updateVendor($aRequest)
	{
	  $done = 0;
	  $vendorId       = $aRequest['fVendorId'];
	  $asset_vendorname   = $aRequest['fVendorName'];
	 $asset_modified_by = $_SESSION['sesCustomerInfo']['user_id'];
	  $status = $aRequest['fStatus'];
	   $lookup   = $aRequest['fLookup'];
	   $tin_no = $aRequest['fTinNumber'];
	  $cst_no = $aRequest['fCSTNumber'];
	  $id_itemgroup1 = implode(",",$aRequest['fVendorGroupId']);
	  
	 $query = "UPDATE vendor SET vendor_name ='".$asset_vendorname."',tin_no = '".$tin_no."',cst_no='".$cst_no ."',lookup ='".$lookup."', id_itemgroup1 = '".$id_itemgroup1."', status = ".$status.",modified_by = '".$asset_modified_by."', modified_on = now() WHERE id_vendor = ".$vendorId;
 $sql_updates= "UPDATE vendor_group_map SET status ='2' WHERE id_vendor='$vendorId'";
			$this->oDb->query($sql_updates);
	 foreach( $aRequest['fVendorGroupId'] as $key => $value)
			{
			
	$checkqry = "SELECT * FROM vendor_group_map WHERE id_vendor='$vendorId' and id_itemgroup1='$value'";
		 $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{	
			$sql_update = "UPDATE vendor_group_map SET status ='1' where id_vendor='$vendorId' and id_itemgroup1='$value'";
			$this->oDb->query($sql_update);
		
		}
		else
		{			
		 $sql = "INSERT INTO `vendor_group_map`(`id_vendor_group_map`, `id_vendor`, `id_itemgroup1`, `status`) VALUES (NULL,'$vendorId','$value','1')";
		$this->oDb->query($sql);
		}
		
			}
	
	if($this->oDb->query($query))
	  {
	     $done = 1;
	  }
	  return $done;
	  
	}
	
	public function deleteVendor($vendorId)
	{
	   $done = 0;
	  $query = "UPDATE vendor SET status=2 where id_vendor = ".$vendorId;
	
	   if($this->oDb->query($query))
	   {
	     $done = 1;
	   }
	   return $done;
	}
	
	public function getAssetSubUnitList($parentvendorId)  //sub unit under a parent asset unit
	{
	  $aSubUnitList = array();
	  $query = "SELECT id_vendor, vendor_name, vendor_desc,status FROM vendor WHERE id_unit =".$parentvendorId;
	  if($result = $this->oDb->get_results($query))
	  {
	     foreach($result as $row)
		 {
		   $aSubUnitList[] = $row->vendor_name;
		 }
	  }
	  return $aSubUnitList;
 
	}
	
	public function getAssetParentvendorInfo($vendorId)
	{
	   $aParentUnitInfo = array();
	   $query = "SELECT id_parent_build FROM vendor WHERE id_vendor = ".$vendorId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $parent_Unit_id = $row->id_parent_unit;
		  $aParentUnitInfo = $this->getvendorInfo($parent_cat_id);
	   }
	   return $aParentUnitInfo;
	}
	
	public function getAllVendorInfo()
	{
	   
	   $avendorInfo = array();
	   $query = "SELECT * FROM vendor WHERE status !=2 and user_type='SUP' ";
	   if($result = $this->oDb->get_results($query))
	   {
		   foreach($result as $row)
		   {
			  $avendor = array();
			  $avendor['id_vendor']          = $row->id_vendor;
			  $avendor['id_address'] = $row->id_vendor_address;
			  $avendor['vendor_name']    = $row->vendor_name;
			   $avendor['tin_no']    = $row->tin_no;
		    $avendor['cst_no']    = $row->cst_no;
			  $avendor['user_type']   = $row->user_type;
			   $avendor['lookup']   = $row->lookup;
			  $avendor['status']    = $row->status;
			  $avendorInfo[] = $avendor;
		   }
		  
	   }
	   return $avendorInfo;
	   
	}
	
	public function getAllVendorInfos($lookup)
	{
	   
	   $avendorInfo = array();
	 $query = "SELECT * FROM vendor_group_map WHERE status !=2 AND id_itemgroup1 IN($lookup) ";
	 $aItems = explode(",",$lookup);
	
	   if($result = $this->oDb->get_results($query))
	   {
		   foreach($result as $row)
		   {
			 
			   $avendor = array();
			 // $avendor['id_vendor']          = $row->id_vendor;
			 $avendor = $this->getVendorInfo($row->id_vendor);
			  $avendorInfo[] = $avendor;
		   }
		  
	   }
	  
	   return $avendorInfo;
	   
	}
	
	public function getUsertypeList($type)
	{
	   $aVendorInfo = array();
	  $query = "SELECT * FROM vendor WHERE user_type='".$type."' ORDER BY id_vendor DESC";
	   	   if($result = $this->oDb->get_results($query))
	   {
		   foreach($result as $row)
		   {
			  $aVendor = array();
			  $aVendor['id_vendor']     = $row->id_vendor;
		      $aVendor['id_address']    = $row->id_vendor_address;
		      $aVendor['vendor_name']   = $row->vendor_name;
			  $aVendor['user_type']     = $row->user_type;
  		      $aVendor['lookup']        = $row->lookup;
			  $aVendor['id_itemgroup1'] = $row->id_itemgroup1;
			  
			  $qry   = "SELECT itemgroup1_name FROM itemgroup1 WHERE id_itemgroup1 in(".$row->id_itemgroup1.")";
			  $igresult = $this->oDb->get_results($qry);
			  $xx = '';
			  foreach($igresult as $igrow)
			  {
			    $xx .= $igrow->itemgroup1_name.",";
			  }
			  $xx = substr($xx,0,(strlen($xx) -1));

			  $igres = $xx; //implode(",",$xx);
		  
			  $aVendor['itemgroup1_name'] = $igres; //$igrow->itemgroup1_name;
			  $aVendor['status']          = $row->status;
			  $aVendorInfo[] = $aVendor;
		   }
	   }
	   return $aVendorInfo;
	}//
	
	public function getVendorByGroup($groupId)
	{
	   $avendorInfo = array();
       $query = "SELECT * FROM vendor WHERE status !=2 and id_itemgroup1 ='".$groupId."'";
       if($result = $this->oDb->get_results($query))
	   {
		   foreach($result as $row)
		   {
			  $avendor = array();
			  $avendor['id_vendor']     = $row->id_vendor;
			  $avendor['id_address']    = $row->id_vendor_address;
			  $avendor['vendor_name']   = $row->vendor_name;
			  $avendor['user_type']     = $row->user_type;
    	      $avendor['lookup']        = $row->lookup;
			  $avendor['id_itemgroup1'] = $row->id_itemgroup1;
			  $avendor['status']        = $row->status;
			  $avendorInfo[]            = $avendor;
		   }
	   }
	   return $avendorInfo;
   }
  } //end class
?>