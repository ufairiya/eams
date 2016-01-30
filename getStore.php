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

   <option value="0">Choose a Store</option>
	  <?php
          $aUnitList = $oAssetUnit->getAllAssetUnitInfo();
          foreach($aUnitList as $aUnit)
          {
         ?>
          <optgroup label="<?php echo  $aUnit['unit_name'];?>">
          
      <?php
          $aStoreList = $oMaster->getStoreListInfo($aUnit['id_unit'],'unit');
          foreach($aStoreList as $aStore)
          {
         ?>
<option value="<?php echo $aStore['id_store']; ?>/<?php echo $aUnit['id_unit'];?>" <?php if($aStockItem['id_store'] == $aStore['id_store']) { echo 'selected=selected' ;}?>><?php echo $aStore['store_name']; ?></option>
       
         <?php
          }
         ?>
       </optgroup>
        <?php
          }
         ?>
         </select>
  
 
 