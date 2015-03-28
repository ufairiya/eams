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


  ?>
  
  <select>
  <option value="0">Choose the Vendor</option>

  <?php
	$aItemGroup = $oMaster->getDistIgroup();
	  foreach( $aItemGroup as $ItemGroup)
	  {
	  ?>
	  <optgroup label="<?php echo $ItemGroup['itemgroup1_name']; ?>">
	  <?php
  $aVendorList = $oAssetVendor->getAllVendorInfos($ItemGroup['id_itemgroup1']);
  foreach($aVendorList as $aVendor)
  {
  ?>
    <option value="<?php echo $aVendor['id_vendor']; ?>" <?php if($edit_result['id_vendor'] == $aVendor['id_vendor']) { echo 'selected=selected' ;}?>><?php echo $aVendor['vendor_name'];?></option>
  <?php
  }
  ?>
   </optgroup>
												 <?php } ?>
  </select>