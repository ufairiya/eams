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
  $aEmptype = $oUtil->getEmployeeType();
  //$aEmployeeList = $oMaster->getEmployeeList();
  foreach($aEmptype as $emptype)
  {
  ?>
   <optgroup label="<?php echo $emptype; ?>">
   <?php  $aEmployeeList = $oMaster->getAllEmployee($emptype);
   foreach($aEmployeeList as $aEmployee)
  {
   ?>
    <option value="<?php echo $aEmployee['id_employee']; ?>" <?php if($edit_result['id_employee'] == $aEmployee['id_employee']) { echo 'selected=selected' ;}?>><?php echo $aEmployee['employee_name']; ?></option>
	<?php } ?>
	 </optgroup>
  <?php
  }
  ?>
  </select>