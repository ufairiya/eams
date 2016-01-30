<?php
 include_once 'ApplicationHeader.php';
 $oSession->setSession('LOGIN', 0);
 $oSession->killSession();
 session_destroy();
 header("Location: login.php");
?>