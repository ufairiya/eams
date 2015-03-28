<?php 
 include_once '../ApplicationHeader.php'; 
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
  $aRequest = $_REQUEST;
 
  $action = $aRequest['action'];
 if($action == 'checkusername')
 {
 
 $username = $aRequest['username'];
 echo $checkResult = $oCustomer->checkUsername($username);

 }
 if($action == 'getUserType')
 {
 $type = $aRequest['type'];
 $id_employee = $aRequest['id'];
 if($type =='Existing')
 {
 $aUser ='
                                        <select class="large m-wrap" tabindex="13" name="fEmployeeId" id="fEmployeeId">
											 <option value="0" >Choose the Employee  </option>
											';
											  $aEmployeeList = $oMaster->getEmployeeList();
											  foreach($aEmployeeList as $aEmployee)
											  {
			  
											$aUser .='
                                             <option value="'.$aEmployee['id_employee'].'"'; 
											  
											 if($id_employee == $aEmployee['id_employee']) { 
		 
		 									 $aUser.= 'selected=selected';
		 
		 										}
											$aUser .='>'.$aEmployee['employee_name'].'</option>';
                                           
											  }
										$aUser .='
                                          </select>			
';
}
echo trim($aUser);
 }
?>
