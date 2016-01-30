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
  

if($_REQUEST['data']=='PurchaseOrderapprove')
{
	 $id_po =  $_REQUEST['id_po'];
	 $id_pr =  $_REQUEST['id_pr'];
	
	$result = $oMaster->approvePurchaseOrder($id_po,$id_pr);
	echo $result;
	
}

if($_REQUEST['data']=='PurchaseOrderclose')
{
	 $id_pos =  $_REQUEST['id_pos'];
	$result1=$oMaster->closePurchaseOrder($id_pos);	
	echo $result1;
}



?>