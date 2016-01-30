<?php
 ob_start();
  include_once ('../config/config.php');
	//no  cache headers 
	header("Expires: Mon, 26 Jul 2000 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	include_once LIB_PATH."/Singleton.php";
	$oSession 		= &Singleton::getInstance('SessionController');
	$oError 		= &Singleton::getInstance('ErrorHandler');
	$oSecurity 		= &Singleton::getInstance('Security');
	$oFormValidator	= &Singleton::getInstance('FormValidator');
	define('COMPANY','1');
	$oAdmin        = &Singleton::getInstance('Admin');
    $oAdmin->setDb($oDb);
	
	$oCustomer        = &Singleton::getInstance('Customer');
	$oCustomer->setDb($oDb);
	
	$oUserRights        = &Singleton::getInstance('UserRights');
	$oUserRights->setDb($oDb);
	$aRights = $oUserRights->getAllMenuList();
	
	$aLscrudList =$oUserRights->getCrudList();
	
	$aAllRights = array();
	$aCrud = array();	
	foreach($aRights as $aRight)
	{
	
	$aAllRights[$aRight['db_lscatId']] = $aRight['db_lscatLink'].'.php';
	}
	
	foreach($aLscrudList as $aLscrud)
	{
	
	$aCrud[$aLscrud['db_lscrudId']] = $aLscrud['db_lscatLink'].'.php';
	}
	
    $oSession->setSession('sesAllMenuList',$aAllRights);
	$oSession->setSession('sesAllCRUDList',$aCrud);
	$oTransport       = &Singleton::getInstance('Transport');
	$oTransport->setDb($oDb);
	define("Currencycode","INR");
	
	$oReport        = &Singleton::getInstance('ReportClass');
	$oReport->setDb($oDb);
	$oDepreciation        = &Singleton::getInstance('Depreciation');
	$oDepreciation->setDb($oDb);
	 $oAssetCategory = &Singleton::getInstance('AssetCategory');
     $oAssetCategory->setDb($oDb);
	 
	 $oAssetType = &Singleton::getInstance('AssetType');
     $oAssetType->setDb($oDb);
	 
	  $oAssetVendor = &Singleton::getInstance('Vendor');
 	 $oAssetVendor->setDb($oDb);
  $_aQuote = array(
  'NEW' => 'New Quotation Added',
  'UPDATE' => 'Quotation Updated',
  'DELETE' => 'Quotation Deleted',
  'CLOSE' => 'Remaining Quotation Closed',
  'APPROVE' => 'Quotation Approved',
  'UNAPPROVE' => 'Quotation Approval Cancelled',
  
   );
	
	$oMaster = &Singleton::getInstance('Master');
	$oMaster->setDb($oDb);
	$oMaster->setQuoteStatus($_aQuote);
	$oUtil = &Singleton::getInstance('Util');
	$aEmptype = $oUtil->getEmployeeType();
	$aCompany = $oMaster->getCompanyAddress(COMPANY,'id');
	$_aFuelType =$oUtil->getFuelType();
	$_aServiceType =$oUtil->getServiceType();
//Account Type
  $aAccountType = array('--ALL--','BANK','CASH','CREDITORS','DEBTORS','EXPENDITURE','INCOME','OTHERS','PURCHASE','SALES','SUB-TAX','TAX &amp; DUTIES');
  
  $_aErrorMsg = array(
  	                  'Duplicate' => 'Possible Duplicate Entry. Please try with a different value.',
					  'Error' => 'An Error occurred. Please try again.'
	            );
	set_error_handler(array(&$oError, 'handler'));
	$aVariables	= array();
	$aSplit 	= explode('/', $_SERVER['REQUEST_URI']);
	$count 		= count($aSplit);
	$file 		= $aSplit[2];
	if($aSplit = explode('?', $file))
	  $file = $aSplit[0];
	$aVar 		= array();
	
	for($i=4; $i<=$count; $i=$i+2) {
		$aVar[$aSplit[$i-2]] = $aSplit[$i-1];
	}
	
	if(count($_POST)>0) {
		foreach($_POST as $key=>$value) {
			$aVar[$key] = $value;
		}
	}
 	
	$aVariables = getVariables($aVar);
	function getVariables($aVar) {
		if(count($aVar)) {
			foreach($aVar as $key=>$value) {
				if($value=='')
					$aVariables[$key] = "";
				elseif(is_array($value)) {
					$count =  count($aVar[$key]);
					$str="";
					for($i=0;$i<$count;$i++) {
						$str.= str_replace(","," ",$aVar[$key][$i]).",";// For array of check box.
					}
					$aVariables[$key]=$str;
				}
				else
					$aVariables[$key] = strip_tags($value);
			}
			return $aVariables;
		}
		return $aVar;
	}
	if($oSession->isValidFingerPrint()) {
		$oSession->setSessionIdleTimeout(60*120); // session timeout made to 2 hours
	}	

	$oMaster->changeContractStatus();
	$oMaster->changeInsuranceStatus();
	
 $urls =  $_SERVER['PHP_SELF'];
 $explodes = explode("/", $urls);
 $current_page = $explodes[3];



	?>