<?php
   //notificationtest.php
   
   include_once 'ApplicationHeader.php';
   include_once LIB_PATH. '/Notification.php';
   
   $oNotify = new Notification();
   $oNotify->setDb($oDb);
   
   $action = $_REQUEST['action'];
   
   switch($action)
   {
   	  case 'getNewPr':
	    $newPrCount = $oNotify->getNewPrCount();
		if( $newPrCount > 0)
		   {
		   $notifytext = array('prcount' =>$newPrCount,'msg' => 'Purchase Requests Waiting for Approval');
				echo  json_encode($notifytext);			
		   }
		   else
		   {
			 $notifytext = array('prcount' =>0,'msg' => '');
			 	echo  json_encode($notifytext);
		   }
		break;
	   
	   case 'xxx':
	        $notifytext = array('prcount' =>'','msg' => 'xxx called');
				echo  json_encode($notifytext);
	    break;
		case 'warrantyList':
				 $WarrantyCount = $oNotify->getWarrantyExpireList();
				  $WarrantyCountText['warrantyinfo']='<ul class="feeds">';
				   $WarrantyCountTextend='</ul>';
				 foreach($WarrantyCount as $aWarrantydetail)
				 {
					 
		         $WarrantyCountText['warrantyinfo'].= '<li><div class="col1"><div class="cont"><div class="cont-col1"><div class="label label-success">	<i class="icon-bell"></i></div></div><div class="cont-col2"><div class="desc"><span><a href="AssetInfo.php?id='.$aWarrantydetail['id_asset_item'].'">'.$aWarrantydetail['asset_no'].'</a></span> is will begin expire on
						 <span>'.date('d/m/Y',strtotime($aWarrantydetail['warranty_end_date'])).'</span>
				 	<a href="AssetInfo.php?id='.$aWarrantydetail['id_asset_item'].'"><span class="label label-important label-mini">Take action <i class="icon-share-alt"></i></span></a></div></div></div></div><div class="col2"><div class="date">Just now</div></div></li>';
				
				 }
				
				 
			 echo  trim($WarrantyCountText['warrantyinfo'].$WarrantyCountTextend);
		break;		
		case 'contractList':
				 $ContractCount = $oNotify->getContractExpireList();
				  $ContractCountText['Contractinfo']='<ul class="feeds">';
				   $ContractCountTextend='</ul>';
				 foreach($ContractCount as $aContractdetail)
				 {
					 
		         $ContractCountText['Contractinfo'].= '<li><div class="col1"><div class="cont"><div class="cont-col1"><div class="label label-success">	<i class="icon-bell"></i></div></div><div class="cont-col2"><div class="desc"><span><a href="AssetInfo.php?id='.$aContractdetail['id_asset_item'].'">'.$aContractdetail['asset_no'].'</a></span> is will begin expire on
						 <span>'.date('d/m/Y',strtotime($aContractdetail['contract_end_date'])).'</span>
				 	<a href="AssetInfo.php?id='.$aContractdetail['id_asset_item'].'"><span class="label label-important label-mini">Take action <i class="icon-share-alt"></i></span></a></div></div></div></div><div class="col2"><div class="date">Just now</div></div></li>';
				
				 }
				
				 
			 echo  trim($ContractCountText['Contractinfo'].$ContractCountTextend);
		break;		
		
			case 'insuranceList':
				 $InsuranceCount = $oNotify->getInsuranceExpireList();
				  $InsuranceCountText['Insuranceinfo']='<ul class="feeds">';
				   $InsuranceCountTextend='</ul>';
				 foreach($InsuranceCount as $aInsurancedetail)
				 {
					 
		         $InsuranceCountText['Insuranceinfo'].= '<li><div class="col1"><div class="cont"><div class="cont-col1"><div class="label label-success">	<i class="icon-bell"></i></div></div><div class="cont-col2"><div class="desc"><span><a href="AssetInfo.php?id='.$aInsurancedetail['id_asset_item'].'">'.$aInsurancedetail['asset_no'].'</a></span> is will begin expire on
						 <span>'.date('d/m/Y',strtotime($aInsurancedetail['ins_end_date'])).'</span>
				 	<a href="AssetInfo.php?id='.$aInsurancedetail['id_asset_item'].'"><span class="label label-important label-mini">Take action <i class="icon-share-alt"></i></span></a></div></div></div></div><div class="col2"><div class="date">Just now</div></div></li>';
				
				 }
				
				 
			 echo  trim($InsuranceCountText['Insuranceinfo'].$InsuranceCountTextend);
		break;		
		
		
	  default:
	
   }
 
?>