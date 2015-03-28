<?php
 ob_start();
  include_once ('config/config.php');
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
    $_aStatus = array(
  '3' => 'APPROVE',
  '4' => 'UNAPPROVE',
 
   );
	 $_aTrans = array(
	  'PR' => array('desc'=>'Purchase Request',
	    "trans_type"=>array('NEW' => 'New Purchase Request Added','UPDATE' => 'Purchase Request Updated',
		'DELETE' => 'Purchase Request Deleted','CLOSE' => 'Purchase Request Closed',		'APPROVE' => 'Purchase Request Approved',
		'UNAPPROVE' => 'Purchase Request Approval Cancelled',		'CANCEL' => 'Purchase Request Cancelled',
		'ASSIGN' => 'New Vendor Assigned for PR','QUOTE' => 'Quotation','QUOTEUPDATE' => 'Quotation Updated for PR','APPROVEQUOTE' => 'Quotation Approved for PR','QUOTESTATUS' => 'Quotation Received from Vendor','FINALQUOTE' => 'Quotation Finalized for PR'),
		),
		
		 'PO' => array('desc'=>'Purchase Order',
	    "trans_type"=>array('NEW' => 'New Purchase Request Order Added','UPDATE' => 'Purchase Order Updated',
		'DELETE' => 'Purchase Order Deleted','CLOSE' => 'Purchase Order Closed','APPROVE' => 'Purchase Order Approved',
		'UNAPPROVE' => 'Purchase Order Approval Cancelled','CANCEL' => 'Purchase Order Cancelled',
		'FORCECLOSE' => 'Purchase Order Force Closed'),
		),
		
		 'GRN' => array('desc'=>'Goods Receieved Note',
	    "trans_type"=>array('NEW' => 'New Goods Receieved Note Added','UPDATE' => 'Goods Receieved Note Updated',
		'DELETE' => 'Goods Receieved Note Deleted','CLOSE' => 'Goods Receieved Note Closed','CANCEL' => 'Goods Receieved Note Cancelled'),
		),
		
		 'INSP' => array('desc'=>'Inspection',
	    "trans_type"=>array('NEW' => 'New Inspection Added','UPDATE' => 'Inspection Updated',
		'DELETE' => 'Inspection Deleted','CLOSE' => 'Inspection Closed','CANCEL' => 'Inspection Cancelled'),
		),
		
		 'ASSET' => array('desc'=>'Asset',
	    "trans_type"=>array('NEW' => 'New Asset Added','UPDATE' => 'Asset Updated',
		'DELETE' => 'Asset Deleted','CLOSE' => 'Asset Closed','CANCEL' => 'Asset Cancelled','SOLD' => 'Asset Sold',
		'NEWSTOCK' => 'New Stock','NEWIMAGE' => 'New Asset Image Added','DELETEIMAGE' => 'New Asset Image Deleted'),
		),
	
	 );
	 
		
	$oMaster = &Singleton::getInstance('Master');
	$oMaster->setDb($oDb);
	$oMaster->setQuoteStatus($_aQuote);
	$ERROR_DISPLAY = DEBUG_ERROR;
	$oMaster->setLogDisplay($ERROR_DISPLAY);
	$oMaster->getStatus($_aStatus);
	$oMaster->getTransStatus($_aTrans);
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
 
 $Explode = explode(".", $explodes[2]);

 $sesMenuPermission = $_SESSION['sesMenuPermission'];
 $sesAllMenuList = $_SESSION['sesAllMenuList'];
$sesAllCRUDList = $_SESSION['sesAllCRUDList'];
$sesUpdatePermission = $_SESSION['sesUpdatePermission'];
$sesCreatePermission = $_SESSION['sesCreatePermission'];
$sesDeletePermission = $_SESSION['sesDeletePermission'];
$sesRetrievePermission = $_SESSION['sesRetrievePermission'];
$query_str =  $_SERVER['QUERY_STRING'];
parse_str($query_str, $aOutQueryStr);

  $file = $explodes[2];
  $aAllowPage = array('login.php','ajax','ajax.php','form.php','index.php','Notification.php','session.php','admin','DetailReportList.php','report.php','getCity.php','CityEditajax.php','getCountry.php','CountryEditajax.php','getDivision.php','DivisionEditajax.php','getEmployee.php','EmployeeEditajax.php','getItem.php','ItemEditajax.php','getItemGroup1.php','ItemGroup1Editajax.php','getItemGroup2.php','ItemGroup2Editajax.php','getState.php','StateEditajax.php','getStore.php','StoreEditajax.php','getUnit.php','UnitEditajax.php','getVendor.php','VendorEditajax.php','BillEntryEdit.php','delete.php');
 $aDefaultAllow = in_array($file, $aAllowPage);

  if(empty($aDefaultAllow))
 {

 $key =  array_search ($file, $sesAllMenuList);
 $current_page = $key;
 
 $allowed = in_array($key, $sesMenuPermission);
	if( $allowed == 0)
	{
	 $allowed = in_array ($file, $sesAllCRUDList);
     $key =  array_search ($file, $sesAllCRUDList);
	 $current_page = $oCustomer->getGrandParentId($key);
	}

 if(isset($aOutQueryStr['action']))
 { 
	 
	 if($aOutQueryStr['action'] =='edit')
	 {
		
		 $key =  array_search ($file, $sesAllCRUDList);
		 $allowed = in_array($key, $sesUpdatePermission);
		 $current_page = $oCustomer->getGrandParentId($key);
	 }
	 else if($aOutQueryStr['action'] =='Add')
	 {
		 $key =  array_search ($file, $sesAllCRUDList);
		 $allowed = in_array($key, $sesCreatePermission);
		  $current_page = $oCustomer->getGrandParentId($key);
	 }
	 else if($aOutQueryStr['action'] =='view')
	 {
		 $key =  array_search ($file, $sesAllCRUDList);
		 $allowed = in_array($key, $sesRetrievePermission);
		$current_page = $oCustomer->getGrandParentId($key);
	
	 }
	 else if($aOutQueryStr['action'] =='Delete')
	 {
		 $key =  array_search ($file, $sesAllCRUDList);
		 $allowed = in_array($key, $sesDeletePermission);
		 $current_page = $oCustomer->getGrandParentId($key);
	 }
	  else if($aOutQueryStr['action'] =='Download')
	 {
		   $key =  array_search ($file, $sesAllCRUDList);
		  $allowed = in_array($key, $sesDownloadPermission);
		 $current_page = $oCustomer->getGrandParentId($key);
		
	 }
 }//
 if(!empty($allowed))
 {
 $allowRight['right'] = 1;
  
 }
 else
 {
 $msg = 'Your are not able to view this page';
 header("Location: index.php");

 }
 }
 else
 {
  $key =  array_search ($file, $aAllowPage);
  $current_page = $aAllowPage[$key];

$allowRight['right'] = 1;
 }

$back = $_SERVER['HTTP_REFERER'];
	?>