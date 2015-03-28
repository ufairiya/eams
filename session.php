<?php
 

 include_once 'ApplicationHeader.php';
 $sesPR = $oSession->getSession('notifycount');

 if(empty( $sesPR))
  {
 $oSession->setSession('notifycount',$_REQUEST['count']);
 }
 if(isset($_REQUEST['PRcounts']))
{
 $oSession->setSession('notifycount',$_REQUEST['PRcounts']);
 }
 
 if($_REQUEST['action'] == 'Warranty')
 {
  $sesWarranty = $oSession->getSession('notifywarrantycount');
 
   if(empty($sesWarranty))
  {
  $oSession->setSession('notifywarrantycount',$_REQUEST['count']);
  }
if(isset($_REQUEST['counts']))
{
	 $oSession->regenerateId();
	$sesWarranty = $oSession->setSession('notifywarrantycount',$_REQUEST['counts']);
}
if(isset($_REQUEST['count']))
{
	 $oSession->regenerateId();
	$sesWarranty = $oSession->setSession('notifywarrantycount',$_REQUEST['count']);
}
  
echo $sesWarranty ;
 
 
 }
?>