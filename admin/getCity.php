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
 <option value="0">Choose the City</option>
  <?php
  $aCityList = $oMaster->getCityList();
 
  foreach($aCityList as $aCity)
  {
  ?>
    <option value="<?php echo $aCity['id_city']; ?>" <?php if($edit_result['id_city'] == $aCity['id_city']) { echo 'selected=selected' ;}?>><?php echo $aCity['city_name']; ?></option>
  <?php
  }
  ?>
  </select>