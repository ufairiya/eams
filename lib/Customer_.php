<?php
set_time_limit(0);
/**
 * 
 * 
 * $Id$
 * 
 * @author 
 */
 
  require_once('Master.php');

class Customer extends Master{
	
	public function __construct()
	{
		//$this->oDb = $oDb;
	}
	public function setDb($oDb)
	{
		$this->oDb = $oDb;
	}
	public function isLoggedIn()
	{
		//echo $_SESSION['LOGIN'];
		return $_SESSION['LOGIN'];
	}
	public function isAdmin()
	{
		//echo $_SESSION['LOGIN'];
		return $_SESSION['ADMIN'];
	}
	
	public function registerNewCustomer($aRequest)
	{
	
	   	$user_type = $aRequest['fUserType'];	
		$user_role = $aRequest['fUserRoleId'];
		$status = $aRequest['fStatus'];
		$aRoleInfo = $this->getUserRoleInfo($user_role,'id');
		$db_lcatId = $aRoleInfo['db_lcatId'];
		$db_lscatId = $aRoleInfo['db_lscatId'];
		
		if($user_type == 'New')
		{
		$first_name = $aRequest['fFirstName'];
		$last_name = $aRequest['fLastName'];
		$address1 = $aRequest['fAddr1'];
		$address2 = $aRequest['fAddr2'];
		$address3 = $aRequest['fAddr3'];
		$id_city = $aRequest['fCityId'];
		$id_state = $aRequest['fStateId'];
		$id_country = $aRequest['fCountryId'];
		$zip_code= $aRequest['fZipCode'];
		$email = $aRequest['fEmail'];
		$phone = $aRequest['fPhone'];
		
		}	
		else if($user_type == 'Existing')
		{
		 $aEmployeeInfo =  $this->getEmployeeInfo($aRequest['fEmployeeId'],'id');
		$first_name = $aEmployeeInfo['employee_first_name'];
		$last_name = $aEmployeeInfo['employee_last_name'];
		$address1 = $aEmployeeInfo['addr1'];
		$address2 = $aEmployeeInfo['addr2'];
		$address3 = $aEmployeeInfo['addr3'];
		$id_city = $aEmployeeInfo['id_city'];
		$id_state = $aEmployeeInfo['id_state'];
		$id_country = $aEmployeeInfo['id_country'];
		$zip_code= $aEmployeeInfo['zipcode'];
		$email = $aEmployeeInfo['email'];
		$phone = $aEmployeeInfo['phone'];
		}	
	   $inserted = 0;
			$created_date = date('Y-m-d H:i:s');
			
			$checkqry = "SELECT * FROM user WHERE login_id='".$aRequest['fLoginName']."'";

			$this->oDb->query($checkqry);
			 $num_rows = $this->oDb->num_rows;
			if(	$num_rows > 0)
			{	
			$done['msg'] = 2;
			return $done;
			}
			else
			{
			
			$insert_profile = "INSERT INTO user SET ";
				if(!empty($insert_profile))	
				{
				 
				 $insert_profile .="login_id = '".$aRequest['fLoginName']."'";
				 $insert_profile .=",password = '".$aRequest['fPassword']."'";  
				 $insert_profile .=",first_name = '".$first_name."'";
				 $insert_profile .=",last_name= '".$last_name."'";
				 $insert_profile .=",address1= '".$address1."'";
				 $insert_profile .=",address2= '".$address2."'";
				  $insert_profile .=",address3= '".$address3."'";
			 	 $insert_profile .=",city= '".$id_city."'";
			 	 $insert_profile .=",state= '".$id_state."'";
				  $insert_profile .=",id_country= '".$id_country."'";
				 $insert_profile .=",zipcode= '".$zip_code."'";
				 $insert_profile .=",email= '".$email."'";
				 
				  $insert_profile .=",db_roleId= '".$user_role."'";
				 $insert_profile .=",db_lcatId= '".$db_lcatId."'";
				 $insert_profile .=",db_lscatId= '".$db_lscatId."'";
				 
				 $insert_profile .=",employee_id= '".$aRequest['fEmployeeId']."'";
				 $insert_profile .=",phonenumber= '".$phone."'";
				 $insert_profile .=",created_date= '".$created_date."'";
				 $insert_profile .=",status= '".$status."'";
				 $insert_profile .=",modified_date= ''";
				}
			 $insert_profile;
	
			 if($this->oDb->query($insert_profile))
			  {
			   $inserted = 1;
			   $last=$this->oDb->insert_id;
			  $done['msg'] = 1;
			return $done;		
			   }
			   else
			   {
			     $done['msg'] = 0;
			    return $done;
			   }
			 }
			 	
	}
	
	public function getUserList()
		{
	       
		   $query = "SELECT * FROM user" ;
			 $aProfileInfoList = array();
            if($result = $this->oDb->get_results($query))
		     {
			foreach($result as $row)
			{
			 $aProInfo = array();
				$aProInfo['user_id'] = $row->id;
				$aProInfo['login_name'] = $row->login_id;
				$aProInfo['password'] = $row->password;
				$aProInfo['first_name'] = $row->first_name;
				$aProInfo['last_name'] = $row->last_name;
				$aProInfo['user_name'] = $aProInfo['first_name'].' '.$aProInfo['last_name'];
				$aProInfo['address1'] = $row->address1;
				$aProInfo['address2'] = $row->address2;
				$aProInfo['address3'] = $row->address3;
				$aProInfo['id_city'] = $row->city;
				$aProInfo['id_state'] = $row->state;
				$aProInfo['id_country'] = $row->id_country;
				$aProInfo['zipcode'] = $row->zipcode;
				$aProInfo['email'] = $row->email;
				$aProInfo['employee_id'] = $row->employee_id;
				$aProInfo['phonenumber'] = $row->phonenumber;
				$aProInfo['status'] = $row->status;
				$aProInfo['created_date'] = $row->created_date;
				$city    = $this->getCityInfo($row->city,'id');
				$state   = $this->getStateInfo($row->state,'id');
				$country = $this->getCountryInfo($row->id_country,'id');
				$aProInfo['city_name']      = $city['city_name'];	
				$aProInfo['state_name']      = $state['state_name'];	
				$aProInfo['country_name']      = $id_country['country_name'];	
				$aProfileInfoList[] = $aProInfo;
		}
		     }	
		
	return $aProfileInfoList;
	}
	
	public function getUserInfo($lookup,$type)
		{
	       
		   $query = "SELECT * FROM user WHERE " ;
		   if($type =='userrole')
		   {
		   $conditions =  "   db_roleId='$lookup'";
		   }
		   else
		   {
		    $conditions =  "   id='$lookup'";
		   }
		    $query = $query.$conditions;
		    $aProInfo = array();
            if($row = $this->oDb->get_row($query))
		     {			
				$aProInfo['user_id'] = $row->id;
				$aProInfo['login_name'] = $row->login_id;
				$aProInfo['password'] = $row->password;
				$aProInfo['first_name'] = $row->first_name;
				$aProInfo['last_name'] = $row->last_name;
				$aProInfo['user_name'] = $aProInfo['first_name'].' '.$aProInfo['last_name'];
				$aProInfo['address1'] = $row->address1;
				$aProInfo['address2'] = $row->address2;
				$aProInfo['address3'] = $row->address3;
				$aProInfo['id_city'] = $row->city;
				$aProInfo['id_state'] = $row->state;
				$aProInfo['id_country'] = $row->id_country;
				$aProInfo['zipcode'] = $row->zipcode;
				$aProInfo['email'] = $row->email;
				$aProInfo['employee_id'] = $row->employee_id;
				$aProInfo['phonenumber'] = $row->phonenumber;
				$aProInfo['status'] = $row->status;
				$aProInfo['db_roleId'] = $row->db_roleId;
				
				
				$aProInfo['created_date'] = $row->created_date;
				$city    = $this->getCityInfo($row->city,'id');
				$state   = $this->getStateInfo($row->state,'id');
				$country = $this->getCountryInfo($row->id_country,'id');
				$aProInfo['city_name']      = $city['city_name'];	
				$aProInfo['state_name']      = $state['state_name'];	
				$aProInfo['country_name']      = $id_country['country_name'];	
				
		     }	
		
	return $aProInfo;
	}
	
       public function checkLogin($userId, $password)
       {
               $custInfo = array();
               $custInfo['CheckLogin'] = 0;
               $query = "SELECT id,first_name, login_id,password,status, db_roleId, db_lcatId, db_lscatId,create_crud,retrieve_crud,update_crud,delete_crud,download_crud FROM user WHERE login_id='".$userId."' AND password ='".$password."' AND status = 1";
			 
               if($row = $this->oDb->get_row($query))
               {
                   $sesFirstName = ucwords(strtolower($row->first_name));
                   $aSubMenu     = explode(",", $row->db_lscatId);        
                   $aMainMenu    = explode(",", $row->db_lcatId); 
				   $aCreateCrud =  explode(",", $row->create_crud); 
				   $aUpdateCrud =  explode(",", $row->update_crud); 
				   $aRetrieveCrud =  explode(",", $row->retrieve_crud); 
				   $aDeleteCrud =  explode(",", $row->delete_crud); 
				   $aDownCrud =  explode(",", $row->download_crud); 
				   
                   //get admin role from roletable
                   $qAdminRole = "SELECT db_roleName FROM roletable WHERE db_roleId = ".$row->db_roleId;
                   $adminRole  = $this->oDb->get_row($qAdminRole);
                   $adminType  = $adminRole->db_roleName;        
                       
                       $custInfo['adminType']  = $adminType;
                       $custInfo['aCreateCrud']   = $aCreateCrud;
						$custInfo['aUpdateCrud']   = $aUpdateCrud;
						$custInfo['aDeleteCrud']   = $aDeleteCrud;
						$custInfo['aRetrieveCrud']   = $aRetrieveCrud;
						$custInfo['aDownCrud']   =  $aDownCrud ;
						$custInfo['aSubMenu']   = $aSubMenu;
					   $custInfo['aMainMenu']  = $aMainMenu;
                       $custInfo['user_id']    = $row->id;
                       $custInfo['first_name'] = $row->first_name;
                       $custInfo['login_id']   = $row->login_id;
                       $custInfo['password']   = $row->password;
                       $custInfo['status']     = $row->status;
                       $custInfo['CheckLogin'] = 1;
                       $checkLogin = 1;
               }
               return $custInfo;
       } //end checkLogin
 
 
 public function checkAdminLogin($userId, $password)
	{
		
		 $custInfo = array();
               $custInfo['CheckLogin'] = 0;
              $query = "SELECT admin_name,login_id,password,status,db_roleId FROM admin WHERE login_id='".$userId."' AND password ='".md5($password)."' AND status = 1";
			    if($row = $this->oDb->get_row($query))
               {
                   $sesFirstName = ucwords(strtolower($row->admin_name));
                  
                   //get admin role from roletable
                       
                       $custInfo['user_id']    = $row->id;
                       $custInfo['first_name'] = $row->admin_name;
                       $custInfo['login_id']   = $row->login_id;
                       $custInfo['password']   = $row->password;
                       $custInfo['status']     = $row->status;
					   $custInfo['db_roleId']     = $row->db_roleId;
					   $custInfo['CheckLogin'] = 1;
					   $custInfo['adminType']  = 'ADMIN';
                       $checkLogin = 1;
               }
               return $custInfo;
		
	} //end checkLogin
		public function userDeletestatus($lookup)
		{
		$qry = "UPDATE user SET status=2 WHERE id='$lookup'";
		if($this->oDb->query($qry))
			{
			$done = '1';		
			}
			else
			{
			$done = '0';	
			}
			return $done;
		}
		public function userDelete($lookup)
		{
		$qry = "DELETE FROM user WHERE id='$lookup'";
		if($this->oDb->query($qry))
			{
			$done = '1';		
			}
			else
			{
			$done = '0';	
			}
			return $done;
		}
	
	public function updateProfileInfo($aRequest)
	{
		
		$first_name = $aRequest['fFirstName'];
		$last_name = $aRequest['fLastName'];
		$address1 = $aRequest['fAddr1'];
		$address2 = $aRequest['fAddr2'];
		$address3 = $aRequest['fAddr3'];
		$id_city = $aRequest['fCityId'];
		$id_state = $aRequest['fStateId'];
		$id_country = $aRequest['fCountryId'];
		$zip_code= $aRequest['fZipCode'];
		$email = $aRequest['fEmail'];
		$phone = $aRequest['fPhone'];
		$user_role = $aRequest['fUserRoleId'];
		$status = $aRequest['fStatus'];
		$aRoleInfo = $this->getUserRoleInfo($user_role,'id');
		$db_lcatId = $aRoleInfo['db_lcatId'];
		$db_lscatId = $aRoleInfo['db_lscatId'];
		$updated = 0;
		$updated_date = date('Y-m-d H:i:s');
		$checkqry = "SELECT * FROM user WHERE login_id='".$aRequest['fLoginName']."'";

			$this->oDb->query($checkqry);
			 $num_rows = $this->oDb->num_rows;
			if(	$num_rows > 0)
			{	
			$done['msg'] = 2;
			return $done;
			}
			else
			{
		$update_profile = "UPDATE user SET ";
		if(!empty($update_profile))	
				{
				
				/* if(!empty($aRequest['fUpdateNewPassword']))
				 {
				 $update_profile .=",password= '".$aRequest['fUpdateNewPassword']."'";
				 }else
				 {
                 $update_profile .=",password= '".$aRequest['fUpdatePassword']."'";
 				 }*/
				 $update_profile .="login_id = '".$aRequest['fLoginName']."'";
				 $update_profile .=",password = '".$aRequest['fPassword']."'";  
				 $update_profile .=",first_name = '".$first_name."'";
				 $update_profile .=",last_name= '".$last_name."'";
				 $update_profile .=",address1= '".$address1."'";
				 $update_profile .=",address2= '".$address2."'";
				  $update_profile .=",address3= '".$address3."'";
			 	 $update_profile .=",city= '".$id_city."'";
			 	 $update_profile .=",state= '".$id_state."'";
				  $update_profile .=",id_country= '".$id_country."'";
				 $update_profile .=",zipcode= '".$zip_code."'";
				 $update_profile .=",email= '".$email."'";
				 
				  $update_profile .=",db_roleId= '".$user_role."'";
				 $update_profile .=",db_lcatId= '".$db_lcatId."'";
				 $update_profile .=",db_lscatId= '".$db_lscatId."'";
				 
				   $update_profile .=",employee_id= '".$aRequest['fEmployeeId']."'";
				 $update_profile .=",phonenumber= '".$phone."'";
				$update_profile .=",status= '".$status."'";
				 $update_profile .=",modified_date= '".$updated_date."'";
 				 
				}
		
		$whereCondition = " WHERE id='".$aRequest['fUserId']."'";
		 $qry = $update_profile.$whereCondition;
	
			if($this->oDb->query($qry))
			{
			$done['msg'] = 1;
			return $done;	
			}
			else
			{
			$done['msg'] = 0;
			return $done;
			}
		}
}

public function checkUsername($username)
{
  $valid = '1';
 $checkqry = "SELECT login_id FROM user WHERE login_id='$username'";
		 $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{
		 $valid = '0';
         }

	return $valid;
}

public function addUserRole($aRequest)
{
$role_name = strtoupper($aRequest['fRoleName']);
$role_desc = $aRequest['fRoleDesc'];
$status = $aRequest['fStatus'];
$created_by        = $_SESSION['sesCustomerInfo']['user_id'];
 $checkqry = "SELECT * FROM user_role WHERE role_name='$role_name'";

			$this->oDb->query($checkqry);
			 $num_rows = $this->oDb->num_rows;
			if(	$num_rows > 0)
			{	
			   $done['role_name'] = $aRequest['fRoleName'];
			   $done['description'] = $aRequest['fRoleDesc'];
			   $done['status'] = $aRequest['fStatus'];
			   $done['msg'] = '2'; 
				 return  $done;		   
			}
			else
			{
		
		$qry = "INSERT INTO user_role(db_roleId, role_name, description, db_lcatId, db_lscatId, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$role_name','$role_desc','','','$created_by ',now(),'','','$status')";
		if($this->oDb->query($qry))
					{
					   $done['msg'] = '1'; 
					  return $done;	
					}
					else
					{
					  $done['msg'] = '0'; 
					   return $done;	
					}
			}
			
}

public function updateUserRole($aRequest)
{
$role_name = strtoupper($aRequest['fRoleName']);
$role_desc = $aRequest['fRoleDesc'];
$status = $aRequest['fStatus'];
$role_id = $aRequest['fRoleId'];
$modified_by        = $_SESSION['sesCustomerInfo']['user_id'];
$qry ="UPDATE user_role SET role_name='".$role_name."',description='".$role_desc."',modified_by='".$modified_by."',modified_on=now(),status='$status' WHERE db_roleId='$role_id'";
if($this->oDb->query($qry))
			{
			return true;		
			}
			else
			{
			return false;	
			}

}

public function getUserRoleInfo($lookup,$type)
{
			$qry = "SELECT * FROM user_role WHERE ";
			if($type=='role')
			{
			$conditions = "   role_name='$lookup'";
			}
			else
			{
			$conditions = "   db_roleId='$lookup'";
			}

             $qry = $qry.$conditions;
			
             $aRoleInfo = array();
            if($row = $this->oDb->get_row($qry))
		     {
			 $aRoleInfo['role_id'] = $row ->db_roleId; 
			 $aRoleInfo['role_name'] = $row ->role_name;
			 $aRoleInfo['description'] = $row ->description;
			 $aRoleInfo['db_lcatId'] = $row ->db_lcatId;
			 $aRoleInfo['db_lscatId'] = $row ->db_lscatId;
			 $aRoleInfo['status'] = $row ->status;
			 }
return  $aRoleInfo;
}


public function getUserRoleList()
{
			$qry = "SELECT * FROM user_role";
			$aRoleInfoList = array();
           if($result = $this->oDb->get_results($qry))
		   {
			foreach($result as $row)
			{
			 $aRoleInfo = array();
			 $aRoleInfo['role_id'] = $row ->db_roleId; 
			 $aRoleInfo['role_name'] = $row ->role_name;
			 $aRoleInfo['description'] = $row ->description;
			 $aRoleInfo['db_lcatId'] = $row ->db_lcatId;
			 $aRoleInfo['db_lscatId'] = $row ->db_lscatId;
			 $aRoleInfo['status'] = $row ->status;
			 $aRoleInfoList[] =$aRoleInfo;
			 }
			 }
return  $aRoleInfoList;
}

public function updateLinkSubCat($aRequest)
	{
	   $valid = false;
	   $userId = $aRequest['fUserId']; 
	   $linksubcat = implode(",", $aRequest['fLinks']);
	   $linkmaincat = implode(",", $aRequest['fParentLinks']);
	   $qry = "UPDATE user_role SET db_lcatId='". $linkmaincat."',db_lscatId = '".$linksubcat."' WHERE db_roleId = ".$userId;
	   if($this->oDb->query($qry))
	   {
	   	 $valid = true;
	   }
	   return $valid;
	}


	public function getUserMenuAccessInfo($userId)
	{
		$qry = 'SELECT * FROM user_role WHERE db_roleId = '.$userId;
		if($row = $this->oDb->get_row($qry))
		{
			$db_lscatId = $row->db_lscatId;
			//$aUserMenu = explode(',',$db_lscatId);
		}
		$qry = "SELECT db_lscatId, db_lscatName, db_lcatId from linksubcattable where db_lscatId in($db_lscatId)";
		if($result = $this->oDb->get_results($qry))
		{
			$aMenuList = array();
			foreach($result as $row)
			{
				$aMenu = array();
				$aMenu['db_lscatId']   = $row->db_lscatId;
				$aMenu['db_lscatName'] = $row->db_lscatName;
				$aMenu['db_lcatId']    = $row->db_lcatId;
				$aMenu['db_lcatName']  = $this->getLinkCatName($row->db_lcatId);
				$aMenuList[] = $aMenu;
			}
		}
		return $aMenuList;
	}
	
	public function getParentId($childid)
	{
	$qry = 'SELECT * FROM linksubcattable WHERE db_lscatId = '.$childid;
		if($row = $this->oDb->get_row($qry))
		{
			$parentid = $row->db_lcatId;
		
		}
		return $parentid;
	}
	
	public function getGrandParentId($childid)
	{
	$qry = 'SELECT * FROM lscrud WHERE db_lscrudId = '.$childid;
		if($row = $this->oDb->get_row($qry))
		{
			$parentid = $row->db_lcatId;
		
		}
		return $parentid;
	}
	
	public function isLinkAssignedMenu($db_lcatId,$userId)
	{
	  $valid = false;
	  $aMenuList = $this->getUserMenuAccessInfo($userId);
	  foreach($aMenuList as $menu)
	  {
	    if($menu['db_lcatId'] == $db_lcatId)
		{
		  $valid = true;
		  //break;
		}
	  }
	  return $valid;
	}
	
	public function isLinkAssigned($db_lscatId,$userId)
	{
	  $valid = false;
	  $aMenuList = $this->getUserMenuAccessInfo($userId);
	  foreach($aMenuList as $menu)
	  {
	    if($menu['db_lscatId'] == $db_lscatId)
		{
		  $valid = true;
		  //break;
		}
	  }
	  return $valid;
	}
	
	public function userRoleDeletestatus($lookup)
		{
			$checkqry = "SELECT * FROM user WHERE db_roleId='$lookup'";
			$this->oDb->query($checkqry);
			$num_rows = $this->oDb->num_rows;
			if(	$num_rows > 0)
			{	
			     $done = '0';		   
			}
			else
			{
				$qry = "UPDATE user_role SET status=2 WHERE db_roleId='$lookup'";
				if($this->oDb->query($qry))
				{
				$done = '1';		
				}
				else
				{
				$done = '0';	
				}
			}
			return $done;
		}
		public function userRoleDelete($lookup)
		{
		$qry = "DELETE FROM user_role WHERE db_roleId='$lookup'";
		if($this->oDb->query($qry))
			{
			$done = '1';		
			}
			else
			{
			$done = '0';	
			}
			return $done;
		}
}