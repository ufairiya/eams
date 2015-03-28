<?php

	//Login manager for users.

	$aRequest      = $_REQUEST;
	$userId        = $aRequest['username'];
	$password      = $aRequest['password'];
	$clearUserId   = $oSecurity->stripAllTags($userId);
	$clearPassword = $oSecurity->stripAllTags($password);
	$aCustomerInfo = $oCustomer->checkAdminLogin($clearUserId, $clearPassword);

	$oSession->setSession('sesCustomerInfo',$aCustomerInfo);
	$login = $_SESSION['sesCustomerInfo']['CheckLogin'];
	 $admin = md5(ADMIN);
	 if($login == 1 && $admin == $aCustomerInfo['db_roleId'])
	 {
		 
	 $oSession->setSession('LOGIN', 1);
	 $oSession->setSession('ADMIN', 1);
	 }
	 $isLogin = $oSession->getSession('LOGIN');
	 $isAdmin = $oSession->getSession('ADMIN');
	$oSession->setSession('sesAdminType' , $aCustomerInfo['adminType']);
     $oSession->setSession('starttime', time());
?>