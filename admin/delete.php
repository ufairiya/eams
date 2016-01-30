<?php 
 include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  
  $oItemCategory = &Singleton::getInstance('ItemCategory');
  $oItemCategory->setDb($oDb);
  
  $oAssetUnit = &Singleton::getInstance('AssetUnit');
  $oAssetUnit->setDb($oDb);
  
  $oAssetBuilding = &Singleton::getInstance('Building');
  $oAssetBuilding->setDb($oDb);
  
  $oAssetDepartment = &Singleton::getInstance('Department');
  $oAssetDepartment->setDb($oDb);
  
  $oAssetCategory = &Singleton::getInstance('AssetCategory');
  $oAssetCategory->setDb($oDb);
  
  $oAssetType = &Singleton::getInstance('AssetType');
  $oAssetType->setDb($oDb);
  
  $oAssetVendor = &Singleton::getInstance('Vendor');
  $oAssetVendor->setDb($oDb);
  
   $oAssetLocation = &Singleton::getInstance('AssetLocation');
  $oAssetLocation->setDb($oDb);
  
  $oMaster = &Singleton::getInstance('Master');
  $oMaster->setDb($oDb);
    $aRequest = $_REQUEST;
 $action = $aRequest['data'];


if($action=='Userdelete')
{
	 $userid =  $_REQUEST['Uid'];
	
	if($oCustomer->userDeletestatus($userid))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}
if($action=='PermanentUserdelete')
{
	 $userid =  $_REQUEST['Uid'];
	
	if($oCustomer->userDelete($userid))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}

if($action=='userRoleDelete')
{
	 $userroleid =  $_REQUEST['id'];
	
	if($oCustomer->userRoleDeletestatus($userroleid))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}
if($action=='PermanentUserRoledelete')
{
	 $userid =  $_REQUEST['Uid'];
	
	if($oCustomer->userRoleDelete($userid))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}

?>