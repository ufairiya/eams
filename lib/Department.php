<?php
	/**
	  * AssetDepartment class
	  *
	  * @author Subash Gopalaswamy <techhead.stallioni@gmail.com>
	  */
  
  class Department
  {
	public function __construct()
	{
	   //
	}
	public function setDb($oDb)
	{
	   $this->oDb = $oDb;
	}
	
	public function addDepartment($aRequest)
	{
	  $dept_name         = strtoupper($aRequest['fDepartmentName']);
	  $dept_desc         = $aRequest['fDepartmentDesc'];
	  $parent_department = $aRequest['fParentDepartment'];
	  $status            = $aRequest['fStatus'];
	  $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
	  
	  $query = "INSERT INTO asset_department(
	             id_department,
	             id_parent_department, 
				 department_name, 
				 department_desc,
				 created_by,
				 created_on,
				 modified_by,
				 modified_on, 
				 status ) VALUES ( null, ".
				 $parent_department.",'".
				 $dept_name."','".
				 $dept_desc."','".
				 $created_by."',now(),'', now(),'".$status."')";
	
	  if($this->oDb->query($query))
	   {
	     //exit();
	     return true;
	   }
	   else { //exit();
	     return false;
	   }	 
	}
	public function getDepartmentInfo($deptId)
	{
	   $aDepartmentInfo = array();
	   $query = "SELECT id_department, 
	                    id_parent_department, 
						department_name, 
						department_desc, 
						created_by,
						created_on, 
						modified_by, 
						modified_on, status FROM asset_department WHERE id_department =".$deptId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $aDepartmentInfo['id_department']          = $row->id_department;
		  $aDepartmentInfo['id_parent_department']   = $row->id_parent_department;
		  $aDepartmentInfo['parent_department_name'] = strtoupper($this->getDepartmentName($row->id_parent_department)); 
		  $aDepartmentInfo['department_name']    = strtoupper($row->department_name);
		  $aDepartmentInfo['department_desc']    = $row->department_desc;
		  $aDepartmentInfo['status']             = $row->status;
	   }
	   return $aDepartmentInfo;
	   
	}
	public function getDepartmentName($deptId)
	{
	   $department_name = '';
	   $query = "SELECT department_name FROM asset_department WHERE id_department =".$deptId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $department_name = strtoupper($row->department_name);
	   }
	   return $department_name;
	}
	//
	public function updateDepartment($aRequest)
	{
	  $done = 0;
	  $department_id      = $aRequest['fDepartmentId'];
	  $department_name    = strtoupper($aRequest['fDepartmentName']);
	  $department_desc    = $aRequest['fDepartmentDesc'];
	  $parent_department  = $aRequest['fParentDepartment'];
	  $modified_by        = $_SESSION['sesCustomerInfo']['user_id'];
	  $status             = $aRequest['fStatus'];
	  
	 $query = "UPDATE asset_department SET 
	                   id_parent_department = ".$parent_department.
					   ", department_name ='".$department_name.
					   "', department_desc ='".$department_desc.
					   "', status = ".$status.
					   ",modified_by = ".$modified_by.
					   ", modified_on = now() 
			    WHERE 
				   id_department = ".$department_id;
	 if($this->oDb->query($query))
	  {
	     $done = 1;
	  }
	  return $done;
	  
	} //
	
	public function deleteDepartment($deptId)
	{
		   $done = 0;
		   $valid = true;
		   $chkqry = "SELECT 
		                 count(id_parent_department) as numChild 
					  FROM 
					     asset_department 
					  WHERE 
					     id_parent_department = $deptId";
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
			 $query = "UPDATE asset_department SET status = 2 where id_department = ".$deptId;
			 if($this->oDb->query($query))
			 {
			   $done = 1;
			 }
	       }
		   return $done;
	   
	} //deleteAssetDepartment
	
	public function getSubDepartmentList($deptId)  //child departments under a parent department
	{
	  $aSubDeptList = array();
	  $query = "SELECT 
	              id_department, 
				  department_name, 
				  department_desc, 
				  status 
				FROM 
				  asset_department 
				WHERE 
				  id_parent_department =".$deptId;
	  if($result = $this->oDb->get_results($query))
	  {
	     foreach($result as $row)
		 {
		   $aSubDeptList[] = strtoupper($row->department_name);
		 }
	  }
	  return $aSubDeptList;
	}//
	
	public function getParentDepartmentInfo($deptId)
	{
	   $aParentDeptInfo = array();
	   $query = "SELECT id_parent_department FROM asset_department WHERE id_department = ".$deptId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $parent_department_id = $row->id_parent_department;
		  $aParentDeptInfo = $this->getDepartmentInfo($parent_department_id);
	   }
	   return $aParentDeptInfo;
	}
	
	public function getAllDepartmentList()
	{
	   
	   $aAllDepartmentList = array();
	   $query = "SELECT * FROM asset_department WHERE status != 2";
	   if($result = $this->oDb->get_results($query))
	   {
		   foreach($result as $row)
		   {
			  $aDepartment = array();
			  $aDepartment['id_department']    = $row->id_department;
			  $aDepartment['id_parent_department']   = $row->id_parent_department;
			  $aDepartment['parent_department_name'] = strtoupper($this->getDepartmentName($row->id_parent_department)); 
			  $aDepartment['department_name']        = strtoupper($row->department_name);
			  $aDepartment['department_desc']        = $row->department_desc;
			  $aDepartment['status']                 = $row->status;
			  $aAllDepartmentList[] = $aDepartment;
		   }
		  
	   }
	   return $aAllDepartmentList;
	   
	} //getAllDepartmentInfo
	
  } //end class
?>