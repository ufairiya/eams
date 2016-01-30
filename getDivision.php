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

  <?php
  $aDivisionList = $oMaster->getDivisionList();
  foreach($aDivisionList as $aDivision)
  {
  ?>
    <option value="<?php echo $aDivision['id_division']; ?>" <?php if($edit_result['id_division'] == $aDivision['id_division']) { echo 'selected=selected' ;}?>><?php echo $aDivision['division_name']; ?></option>
  <?php
  }
  ?>
  </select>