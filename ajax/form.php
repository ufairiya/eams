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
   if($action == 'confirm')
   {
	$assetid = $aRequest['fAssetItemId'];
	$asset1 = explode(",",$assetid);
	$aRequest = array(
	'fAssetItemId' => $asset1,
	'fStoreDeliveryId' => $aRequest['fStoreDeliveryId'],
	'fStatus' => $aRequest['fStatus'],
	'fReceiverEmployeeId' => $aRequest['fReceiverEmployeeId'],
	'fFromStoreId' => $aRequest['fFromStoreId'],
	'fDeliveryType' =>$aRequest['fDeliveryType'],
	'fToStoreId' =>$aRequest['fToStoreId'],
	
	);
		if( $oMaster->updateDelivery($aRequest))
		{
		echo $msg = "1";
		}
		else 
		{echo $msg = "0" ;}
		}
 if($action == 'StoreDeliveryInfo')
{
$item_id =  $aRequest['storedeliveryid'];
$aStoreDeliveryInfo = $oMaster->getDeliveryInfo($item_id);
$aDeliveryInfo =$oMaster->getDeliveryItemListForPopup($item_id,'delivery');
$Return_table =' 
<TABLE cellSpacing="0" cellPadding="0" width="100%"  align="center">
              <TBODY>
			  
			    <TR class="srow" align="left">
                <TD ><B><FONT class="detail">&nbsp;Store Delivery Number</FONT></B></TD>
                <TD >:&nbsp; &nbsp;<B style="color:#EB4A0C">'.$aStoreDeliveryInfo['issue_no'].'</B>
				 <input type="hidden" name="fStoreDeliveryId"  value="'.$aStoreDeliveryInfo['id_asset_delivery'].'"/>
				 
				</TD></TR>
                           
             </TBODY></TABLE>
			 <br><br>
			 
			 ';


$Return_table .='
<TABLE border="1" cellSpacing="0" cellPadding="0" width="100%" bgColor="black" align="center" bordercolor="#000000">
  <TBODY>
  <TR align="center" bgColor="white">
    <TD width="2%"><B>SLNO</B></TD>
    <TD width="35%"><B>PARTICULARS</B></TD>
    <TD width="5%"><B>QUANTITY I</B></TD>
	 <TD width="5%"><B>UOM</B></TD>
      </TR>
    ';
	
	$sl_no = 1;
	foreach ($aDeliveryInfo as $aDeliveryItem){
				
$Return_table .='		
  <TR class="srow" bgColor="white">
    <TD align="right">'.$sl_no.'&nbsp;&nbsp; <input type="hidden" name="fDeliverystatus"  value="'.$aDeliveryItem['status'].'"/></TD>
    <TD>&nbsp;&nbsp;'.$aDeliveryItem['itemgroup1_name'].'-'.$aDeliveryItem['itemgroup2_name'].'-'.$aDeliveryItem['item_name'].'&nbsp;&nbsp;</TD>
    <TD  align="right">'.$aDeliveryItem['issue_quantitiy'].'</TD>
	 <TD  align="right">'.$aDeliveryItem['uom_name'].'</TD>
    
      </TR>';
	   $sl_no ++;
 	  } 
$Return_table.='     
 </TBODY></TABLE>

';
echo $Return_table;
}
 
?>
