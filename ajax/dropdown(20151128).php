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
  include_once LIB_PATH. '/Notification.php';
   
   $oNotify = new Notification();
   $oNotify->setDb($oDb);
   
	  
  $action = $aRequest['action'];
if($action == 'getOrdertype')
	{
	$id_order_type = $aRequest['OId'];
	$id_pr = $aRequest['PRId'];
	if($id_order_type == 'PR')
	{
	
		$avendorList = $oMaster->getAssignVendorToPrInfo($id_pr,'pr');									
		$Ordertype.='<option value="0">Choose the Supplier</option>';
		foreach($avendorList as $aVendor)
		{
		$Ordertype= '<option value="'.$aVendor['id_vendor'].'" >'.$aVendor['vendor_name'].'</option>';
	}
	echo trim($Ordertype);
	}
	else{
		
		$avendorList = $oAssetVendor->getAllVendorInfo();									
		$Ordertype.='<option value="0">Choose the Supplier</option>';
		foreach($avendorList as $aVendor)
		{
		$Ordertype= '<option value="'.$aVendor['id_vendor'].'" >'.$aVendor['vendor_name'].'</option>';
	}
	echo trim($Ordertype);
	}
}
if($action =='checkQty')
{
   $valid = array();
  $prid = $aRequest['Prid'];
  $pritemid = $aRequest['Pritemid'];
  $qty = $aRequest['qty'];
  $availableqty = $oMaster->checkQty($prid,$pritemid);
  if( $availableqty >= $qty )
  {
  $valid['status'] = 1;
  }
  else
  {
  
   $valid['avail_qty'] = $availableqty;
   $valid['status'] = 0;
     }
  echo json_encode($valid);
}
  if($action == 'getItemsList')
  {
	  $id_Group1 = $_REQUEST['Group1Id'];
	    $id_Group2 = $_REQUEST['Group2Id'];
		$storeId = $_REQUEST['StoreId'];
		$ItemList='<select class=" m-wrap" tabindex="7" name="fItemName" id="fItemName" onchange="getStockItem(this.value)"><option value="0" >Choose the Item</option>';
		$ItemListend='</select>';
		  $aItemList12 = $oMaster->getItemGroup2ByStore($id_Group2,$id_Group1,$storeId,'','item');
				foreach($aItemList12 as $Item)
				{
				 $ItemList.= '<option value="'.$Item['id_item'].'"> '.$Item['item_name'].'</option>';
         	 
				}
		
	echo trim($ItemList.=$ItemListend);
  } 
  
   if($action == 'getGroup2ItemList')
  {
	  $id_group1 = $aRequest['Group1Id'];
	  $aGroup1Item = $oMaster->getItemGroupMapList($id_group1,'group1');
	  $ItemList.= '<option value="" >All</option>';
	foreach($aGroup1Item as $aItem)
			  {
		 $ItemList.= '<option value="'.$aItem['id_itemgroup2'].'">'.$aItem['itemgroup2_name'].'</option>';
         	  }
	echo trim($ItemList);
  }
  
   if($action == 'getItemLists')
  {
	  $id_group2 = $aRequest['Group2Id'];
	  $aGroup2Item = $oMaster->getItemGroupMapList($id_group2,'group2');
	  $ItemList.= '<option value="" >All</option>';
	foreach($aGroup2Item as $aItem)
			  {
		 $ItemList.= '<option value="'.$aItem['id_item'].'">'.$aItem['item_name'].'</option>';
         	  }
	echo trim($ItemList);
  }
  
  if($action == 'getItemListsByGroup1')
  {
	  $id_group1 = $aRequest['Group1Id'];
	  $aGroup1Item = $oMaster->getItemGroupMapList($id_group1,'item');
	  $ItemList.= '<option value="">All</option>';
	foreach($aGroup1Item as $aItem)
			  {
		 $ItemList.= '<option value="'.$aItem['id_item'].'">'.$aItem['item_name'].'</option>';
         	  }
	echo trim($ItemList);
  }
  
  if($action == 'getCMR')
  {
   $id_asset = $aRequest['assetid'];
  $CMR = $oMaster->getTripCMR($id_asset);
  if($CMR!= '')
  {
   $cmr =  $CMR;
  }
  else
  {
   
	$cmr = 0;
  }
  echo $cmr ;
  }
  if($action == 'getUsedFuelcount')
  {
   $id_asset = $aRequest['assetid'];
  $Usedfuel = $oMaster->FuelUsedCount($id_asset);
  if($Usedfuel!= '')
  {
   $Usedfuel1 =  $Usedfuel;
  }
  else
  {
   
	$Usedfuel1 = 0;
  }
  echo $Usedfuel1 ;
  }
  
  
    if($action == 'getGroupsItemList1'){
	  $id_Group1 = $_REQUEST['Group1Id'];
	  $item_id  = $_REQUEST['itemId'];	 
	 
	 $ItemList1='<select class=" m-wrap" tabindex="7" name="fItemName" id="fItemName" onchange="getCMR(this.value);getUsedFuelcount(this.value);"><option value="0" >Choose the Item</option>';
		$ItemList1end='</select>';
		 $aItemList12 = $oMaster->getItemGroups($id_Group1,'','item');
		 
				foreach($aItemList12 as $Item)
				{
				$ItemList1.= '<optgroup label="'.$Item['item_name'].'">	';
				 $aItemsList4 = $oMaster->getItemGroups($id_Group1,$Item['id_item'],'item');
				
				foreach($aItemsList4 as $Items)
				{     						
            
		 $ItemList1.= '<option value="'.$Items['asset_item'].'"'; 
		 
		 if($item_id == $Items['asset_item']) { 
		 
		  $ItemList1.= 'selected=selected';
		 
		 }
		 $ItemList1.= '>'.$Items['asset_no'].' - '.$Items['machine_no'].'</option>';
         	 
				}
			  $ItemList1.= '</optgroup>';
				}
	 
	echo trim($ItemList1.=$ItemList1end);
	
  }
  if($action == 'getGroupsItemList2'){
	  $id_Group1 = $_REQUEST['Group1Id'];
	  $item_id  = $_REQUEST['itemId'];	 
	 
	 $ItemList1='<select class=" m-wrap" tabindex="7" name="fItemName" id="fItemName"><option value="0" >Choose the Item</option>';
		$ItemList1end='</select>';
		 $aItemList12 = $oMaster->getItemGroups($id_Group1,'','item');
		 
				foreach($aItemList12 as $Item)
				{
				$ItemList1.= '<optgroup label="'.$Item['item_name'].'">	';
				 $aItemsList4 = $oMaster->getItemGroups($id_Group1,$Item['id_item'],'item');
				
				foreach($aItemsList4 as $Items)
				{     						
            $itemgroup = $Items['asset_item'].'/'.$Item['id_item'];
			
		 $ItemList1.= '<option value="'. $itemgroup .'"'; 
		 
		 if($item_id == $Items['asset_item']) { 
		 
		  $ItemList1.= 'selected=selected';
		 
		 }
		 $ItemList1.= '>'.$Items['asset_no'].' - '.$Items['machine_no'].'</option>';
         	 
				}
			  $ItemList1.= '</optgroup>';
				}
	 
	echo trim($ItemList1.=$ItemList1end);
	
  }
  
   if($action == 'getItemList2'){
	  $id_Group1 = $_REQUEST['Group1Id'];
	  $id_Group2  = $_REQUEST['Group2Id'];	 
	 
	 $ItemList1='<select class=" m-wrap" tabindex="7" name="fItemName" id="fItemName"><option value="0" >Choose the Item</option>';
		$ItemList1end='</select>';
		 $aItemList12 = $oMaster->getItemGroupsInfo($id_Group1,$id_Group2,'','item');
		
			foreach($aItemList12 as $Item)
				{
				$ItemList1.= '<optgroup label="'.$Item['item_name'].'">	';
				 $aItemsList4 = $oMaster->getItemGroupsInfo($id_Group1,$id_Group2,$Item['id_item'],'item');
				
				foreach($aItemsList4 as $Items)
				{     						
            $itemgroup = $Items['asset_item'].'/'.$Item['id_item'];
			
		 $ItemList1.= '<option value="'. $itemgroup .'"'; 
		 
		 if($item_id == $Items['asset_item']) { 
		 
		  $ItemList1.= 'selected=selected';
		 
		 }
		 $ItemList1.= '>'.$Items['asset_no'].' - '.$Items['machine_no'].'</option>';
         	 
				}
			  $ItemList1.= '</optgroup>';
				}
	 
	echo trim($ItemList1.=$ItemList1end);
	
  }
   if($action == 'getItemsListBystock'){
	  $id_Group1 = $_REQUEST['Group1Id'];
	  $id_Group2 = $_REQUEST['Group2Id'];
	 $item_id = $_REQUEST['itemid'];
	 $ItemList1='<option value="0" >Choose the Item</option>';
		
		 $aItemList12 = $oMaster->getItemGroupMapList($id_Group2,'items',$id_Group1);
		 
				foreach($aItemList12 as $Item)
				{
	
		 $ItemList1.= '<option value="'.$Item['id_item'].'"'; 
		 
		 if($item_id == $Item['id_item']) { 
		 
		  $ItemList1.= 'selected=selected';
		 
		 }
		 $ItemList1.= '>'.$Item['item_name'].'</option>';
         	 
				}
			
	 
	echo trim($ItemList1);
	
  }
   if($action == 'getGroupsItemList')
  {
	   $id_Group1 = $_REQUEST['Group1Id'];
	    $id_group2 = $_REQUEST['group2Id'];
		
	  $aItemGroupList1 = $oMaster->getItemGroups($id_Group1,'','group2');
		
	  $ItemList='<option value="0" >Choose the Item Group2</option>';
		
	  foreach($aItemGroupList1 as $aItem)
			  {
		 $ItemList.= '<option value="'.$aItem['id_itemgroup2'].'"'; 
		 
		 if($id_group2 == $aItem['id_itemgroup2']) { 
		 
		  $ItemList.= 'selected=selected';
		 
		 }
		 $ItemList.= ' >'.$aItem['itemgroup2_name'].'</option>';
         	  }
	echo $itemGroup2 = trim($ItemList);
  }
  
  if($action == 'dashBoard')
 {
	$aDashcount= $oMaster->getDashboardCounts();
	echo  json_encode($aDashcount);
 }
 
 if($action == 'getWarranty')
 {
 $expireCount = $oNotify->getWarrantyExpireCount();
 $notifyWarrantytext = array('warrantycount' =>$expireCount,'msg' => ' Assets Warranty Will being expire');
  echo  json_encode($notifyWarrantytext);
 }

   if($action == 'getVendorItemList')
  {
	  $id_vendor = $aRequest['vendorId'];
	 $item_id = $aRequest['id'];
	 $aVendor =  $oMaster->getVendorItemGroup($id_vendor);
     $aVendorItemGroup =  $oMaster->getItemGroup1Lists($aVendor);
	  $ItemList.= '<option value="0" >Choose the Item Group 1</option>';
	foreach($aVendorItemGroup as $aItem)
			  {
		 $ItemList.= '<option value="'.$aItem['id_itemgroup1'].'"';
		 
		  if($item_id == $aItem['id_itemgroup1']) { 
		 
		  $ItemList.= 'selected=selected';
		 
		 }
		 
		 $ItemList.= '>'.$aItem['itemgroup1_name'].'</option>';
         	  }
	echo trim($ItemList);
  }
 
   
?>
