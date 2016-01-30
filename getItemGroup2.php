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
  $aItemGroup2List = $oMaster->getItemGroup2List();
  foreach($aItemGroup2List as $aItemGroup2)
  {
  ?>
    <option value="<?php echo $aItemGroup2['id_itemgroup2']; ?>" <?php if($edit_result['id_itemgroup2'] == $aCountry['id_itemgroup2']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup2['itemgroup2_name']; ?></option>
  <?php
  }
  ?>
  </select>