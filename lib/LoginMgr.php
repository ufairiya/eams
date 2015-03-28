<?php

	//Login manager for users.

	$aRequest      = $_REQUEST;
	$userId        = $aRequest['username'];
	$password      = $aRequest['password'];
	$clearUserId   = $oSecurity->stripAllTags($userId);
	$clearPassword = $oSecurity->stripAllTags($password);
	$aCustomerInfo = $oCustomer->checkLogin($clearUserId, $clearPassword);
    print_r($aCustomerInfo);
	
	$oSession->setSession('sesCustomerInfo',$aCustomerInfo);
	 $login = $_SESSION['sesCustomerInfo']['CheckLogin'];
	 if($login == 1)
	 {
		 
	 $oSession->setSession('LOGIN', 1);
	 }
	 $isLogin = $oSession->getSession('LOGIN');
	$oSession->setSession('sesAdminType' , $aCustomerInfo['adminType']);
    $oSession->setSession('sesMenuPermission' , $aCustomerInfo['aSubMenu']);
	$oSession->setSession('sesCreatePermission' , $aCustomerInfo['aCreateCrud']);
	$oSession->setSession('sesUpdatePermission' , $aCustomerInfo['aUpdateCrud']);
	$oSession->setSession('sesDeletePermission' , $aCustomerInfo['aDeleteCrud']);
	$oSession->setSession('sesRetrievePermission' , $aCustomerInfo['aRetrieveCrud']);
	$oSession->setSession('sesDownloadPermission' , $aCustomerInfo['aDownCrud']);
	
	
    $oSession->setSession('starttime', time());
	//echo '<pre>';
	//print_r($_SESSION);
	//echo '</pre>';
	//exit();
?>