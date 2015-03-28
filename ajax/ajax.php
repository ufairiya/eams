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
  
	if($aRequest['data'] == 'purchaserequestdelete')
	{
		$item_id =  $aRequest['pid'];
		if($oMaster->updatePurchaseRequest($item_id,'delete'))
		{
			echo $result = '1';
		}
		else
		{
			echo $result = '0';
		}
		
	}
	if($aRequest['editdata'] == 'purchaserequestedit')
	{
		 $aValue = array();
		 $aValue['fItemName'] = $aRequest['item'];
		 $aValue['fQuantity'] = $aRequest['quanity'];
		 $aValue['fItemId']   = $aRequest['itemid'];
		 if($results =$oMaster->updatePurchaseRequest($aValue,'update'))
		 {
			echo $results;
		 }
	}

  
  $action = $aRequest['action'];
  if($action == 'getpo')
  {
     $vendorId = $aRequest['vendorId'];
	 $vendorPOList = $oMaster->getPurchaseOrderListByGrn($vendorId);
	 //echo count($vendorPOList).'good job.';
	 $poList = '<select class="span12 " data-placeholder="Choose a PO" tabindex="8" name="fPOId" id="fPOId" onchange="getPoDate(this.value);"><option value="0">Choose a PO</option>';
	 $poListend = '</select>';
	 foreach($vendorPOList as $po)
	 {
	 	$poList.= '<option value="'.$po['id_po'].'" >'.$po['po_number'].'</option>';
	 }
	 echo trim($poList .= $poListend);
  } //
  
    if($action == 'getassetitem')
  {
    $grnIds = $aRequest['grnId'];
	 $assetItemList = $oMaster->getAssetItemList($grnIds,'grn');
	 //echo count($vendorPOList).'good job.';
	 $ItemList = '<select class="span6 chosen" data-placeholder="Choose a Inventory Item" tabindex="1" name="fInventoryItemd" id="fInventoryItemd" onchange="ShowResult(this.value,'.$grnId.')"><option value="0">Choose a Inventory Item</option>';
	 $ItemListend = '</select>';
	//print_r( $assetItemList);
	foreach($assetItemList as $assetItem)
	 {
	  	$ItemList.= '<option value="'.$assetItem['id_inventory_item'].'" >'.$assetItem['item_name'].'</option>';
	 }
	 echo trim($ItemList .= $ItemListend);
  } //
  
   if($action == 'getinventoryitem')
  {
    $grnId = $aRequest['grnId'];
	 $inventoryItemList = $oMaster->getInventoryItemList($grnId);
	 //echo count($vendorPOList).'good job.';
	 $ItemList = '<select class="span6 chosen" data-placeholder="Choose a Inventory Item" tabindex="1" name="fInventoryItemd" id="fInventoryItemd" onchange="ShowResult(this.value,'.$grnId.')"><option value="0">Choose a Inventory Item</option>';
	 $ItemListend = '</select>';
	
	foreach($inventoryItemList as $inventoryItem)
	 {
	  	$ItemList.= '<option value="'.$inventoryItem['id_inventory_item'].'" >'.$inventoryItem['item_name'].'</option>';
	 }
	 echo trim($ItemList .= $ItemListend);
  } //
  
  
  
 // getVendorContact
  
  
   if($action == 'getVendorContact')
  {
    $vendorId = $aRequest['vendorId'];
	 $vendorContactList = $oMaster->getVendorContactMapList($vendorId);
	 //echo count($vendorPOList).'good job.';
	 $ItemList = '<select data-placeholder="Choose Multiple Contact Person" class="chosen span10" multiple="multiple" name="fVendorContactId[]" tabindex="1">';
	 $ItemListend = '</select>';
	foreach($vendorContactList as $vendorContact)
	 {
	  	$ItemList.= '<option value="'.$vendorContact['id_contact'].'" >'.$vendorContact['contact_name'].'</option>';
	 }
	 echo trim($ItemList .= $ItemListend);
  } //
  
    if($action == 'getAssettype')
  {
    $catId = $aRequest['catId'];
	 $assettypeList = $oAssetType->getAllAssetTypeListInfo($catId,'');
	 //echo count($vendorPOList).'good job.';
	 $assettypes = '<select class="span6 chosen" data-placeholder="Choose a Asset Type" tabindex="5" name="fAssetTypeId" id="fAssetTypeId"><option value="0">Choose a Asset Type</option>';
	 $assettypesend = '</select>';
	
	foreach($assettypeList as $Assettype)
	 {
	  	$assettypes.= '<option value="'.$Assettype['id_asset_type'].'" >'.$Assettype['asset_type_name'].'</option>';
	 }
	 echo trim($assettypes .= $assettypesend);
  } //
  
   if($action == 'getStore')
  {
    $unitId = $aRequest['unitId'];
	 $aStoreList = $oMaster->getStoreListInfo($unitId,'unit');
	 //echo count($vendorPOList).'good job.';
	 $Storetype = '<select class="m-wrap chosen" data-placeholder="Choose a Store" tabindex="5" name="fStoreId" id="fStoreId1">';
	 $Storetypeend = '</select>';
	
	foreach($aStoreList as $aStore)
	 {
	  	$Storetype.= '<option value="'.$aStore['id_store'].'" >'.$aStore['store_name'].'</option>';
	 }
	 echo trim($Storetype .= $Storetypeend);
  } //
  
  
  
  if($action == 'getvendoraddress')
  {
	$id_unit = $aRequest['Unitid'];
	if($id_unit !='Self')
	{
	$aUnitInfo = $oMaster->getUnitInfo($id_unit,'id');
	$aUnitaddress = $oMaster->getUnitAddress($aUnitInfo['id_unit_address'],$aUnitInfo['unit_name'],'id'); 
	echo '<address>'.$aUnitaddress['address_format'].'</address>';										 
	}
	else
	{
			echo '<address>'.'Self'.'</address>';
	}
  }
  if($action == 'getDeliverytype')
  {
	$id_delivery_type = $aRequest['dId'];
	if($id_delivery_type == 'ISD')
	{
		 $Storetype = '
		    <div class="control-group">
                                             <label class="control-label">To Store</label>
                               <div class="controls" id="StoreList">
		 
		 <select class="large m-wrap chosen" data-placeholder="Choose a To Store" tabindex="5" name="fToStoreId">
                                          <option value="">Choose a To Store</option>';
                                         
											  $aUnitList = $oAssetUnit->getAllAssetUnitInfo();
											  foreach($aUnitList as $aUnit)
											  {
										   $Storetype.= ' <optgroup label="'.$aUnit['unit_name'].'">';
											  $aStoreList = $oMaster->getStoreListInfo($aUnit['id_unit'],'unit');
											  foreach($aStoreList as $aStore)
											  {
											                                          
                                             	$Storetype.= '<option value="'.$aStore['id_store'].'" >'.$aStore['store_name'].'</option>';
                                              }
											
                                          $Storetype.='</optgroup>';
                                           }
											
                                            $Storetype.='</select></div><div>';
											 echo trim($Storetype);
	}
	else{
		 $Storetype = '<div class="control-group">
                                      <label class="control-label">Select Vendor</label>
                                       <div class="controls">
                                       <select class="large m-wrap" tabindex="5" name="fvendorId">';
									    $aItemGroup = $oMaster->getDistIgroup();
												  foreach( $aItemGroup as $ItemGroup)
												  {
												 $Storetype.='<optgroup label="'.$ItemGroup['itemgroup1_name'].'">';										
											  $avendorList = $oAssetVendor->getAllVendorInfos($ItemGroup['id_itemgroup1']);										
                                            $Storetype.='<option value="0">Choose the Supplier</option>';
                                             foreach($avendorList as $aVendor)
											  {
											 $Storetype.= '<option value="'.$aVendor['id_vendor'].'" >'.$aVendor['vendor_name'].'</option>';
                                             }
											 }
										
                                            $Storetypeend = '<optgroup></select></div><div>';
											 echo trim($Storetype.=$Storetypeend);
	}
  }
  
   if($action == 'getDivisionPR')
  {
     $id_unit = $_REQUEST['unitID'];
	 $division_id = $_REQUEST['divisionId'];
	$aDivisionInfo = $oMaster->getDivisionInfoList($id_unit ,'unit');
	
	$Divisiontype = '
	<option value="0">Choose the Division</option>
	';
											
											 
											  foreach($aDivisionInfo as $aDivision)
											  {
											
                                             $Divisiontype.= ' <option value="'.$aDivision['id_division'].'"';
											 
											 if($division_id == $aDivision['id_division']) { 
		 
		 									 $Divisiontype.= 'selected=selected';
		 
		 										}
											  $Divisiontype.='>'.$aDivision['division_name'].'</option>';
                                             
											  }
											
                                          $Divisiontype.= '';
	 echo trim($Divisiontype);									  
  }
   if($action == 'getDivisionPO')
  {
     $id_unit = $_REQUEST['unitID'];
	 $division_id = $_REQUEST['divisionId'];
	$aDivisionInfo = $oMaster->getDivisionInfoList($id_unit ,'unit');
	
	$Divisiontype = '';
											
											 
											  foreach($aDivisionInfo as $aDivision)
											  {
											
                                             $Divisiontype.= ' <option value="'.$aDivision['id_division'].'"';
											 
											 if($division_id == $aDivision['id_division']) { 
		 
		 									 $Divisiontype.= 'selected=selected';
		 
		 										}
											  $Divisiontype.='>'.$aDivision['division_name'].'</option>';
                                             
											  }
											
                                          $Divisiontype.= '';
	 echo trim($Divisiontype);									  
  }
  if($action == 'getDivisionList')
  {
    $id_store = $_REQUEST['storeID'];
	$astore =$oMaster->getStoreInfo($id_store ,'id');
	$id_unit = $astore['id_unit'];
	$aDivisionInfo = $oMaster->getDivisionInfoList($id_unit ,'unit');
	$Divisiontype = '<select class="span12 m-wrap" tabindex="2" name="fDivisionId" id="fDivisionId"> <option value="0">Choose the Division</option>';
											
											 
											  foreach($aDivisionInfo as $aDivision)
											  {
											
                                             $Divisiontype.= ' <option value="'.$aDivision['id_division'].'">'.$aDivision['division_name'].'</option>';
                                             
											  }
											
                                          $Divisiontype.= '</select>';
	 echo trim($Divisiontype);									  
  }
  
  if($action == 'getStoreList')
  {
	  	$id_store = $_REQUEST['fromstoreId'];
		 $Storetype = ' <select class="large m-wrap chosen" data-placeholder="Choose a To Store" tabindex="4" name="fToStoreId" id="fToStoreId">
                                          <option value="">Choose a To Store</option>';
                                         
											  $aUnitList = $oAssetUnit->getAllAssetUnitInfo();
											  foreach($aUnitList as $aUnit)
											  {
										   $Storetype.= ' <optgroup label="'.$aUnit['unit_name'].'">';
											  $aStoreList = $oMaster->getStoreListInfo($aUnit['id_unit'],'unit');
											  foreach($aStoreList as $aStore)
											  {
											    if($aStore['id_store'] != $id_store)												
												{ 
											$Storetype.= '<option value="'.$aStore['id_store'].'" >'.$aStore['store_name'].'</option>';
												}
                                              }
											
                                          $Storetype.='</optgroup>';
                                           }
											
                                            $Storetype.='</select>';
											 echo trim($Storetype);
  }
  if($action =='getGroup2ItemDisp')
  {
	  
	  $id_group1 = $aRequest['Group1Id'];
	   $id_group2 = $aRequest['group2Id'];
	  
	  $aGroup1Item = $oMaster->getGroup2ItemDisp($id_group1,'group1');
	  $ItemList= '<option value="0" >Choose the Brand / Make</option>';
	foreach($aGroup1Item as $aItem)
			  {
		 $ItemList.= '<option value="'.$aItem['id_itemgroup2'].'"';
		 if($id_group2 == $aItem['id_itemgroup2']) { 
		 
		  $ItemList.= 'selected=selected';
		 
		 }
		 
		$ItemList.='>'.$aItem['itemgroup2_name'].'</option>';
         	  }
	echo trim($ItemList);
  
  }
   if($action =='getItemDisp')
  {
	  
	 $id_group2 = $aRequest['Group2Id'];
	  $id_item = $aRequest['id'];
	  $aGroup2Item = $oMaster->getItemDisp($id_group2,'group2');
	  $ItemList.= '<option value="0" >Choose the Item</option>';
	foreach($aGroup2Item as $aItem)
			  {
		 $ItemList.= '<option value="'.$aItem['id_item'].'"';
		 
		  if($id_item == $aItem['id_item']) { 
		 
		  $ItemList.= 'selected=selected';
		 
		 }
		 $ItemList.=' >'.$aItem['item_name'].'</option>';
         	  }
	echo trim($ItemList);
  
  }
  
  
  if($action == 'getGroup2ItemList')
  {
	  $id_group1 = $aRequest['Group1Id'];
	   $id_group2 = $aRequest['group2Id'];
	  
	  $aGroup1Item = $oMaster->getItemGroupMapList($id_group1,'group1');
	  $ItemList= '<option value="0" >Choose the Brand / Make</option>';
	foreach($aGroup1Item as $aItem)
			  {
		 $ItemList.= '<option value="'.$aItem['id_itemgroup2'].'"';
		 if($id_group2 == $aItem['id_itemgroup2']) { 
		 
		  $ItemList.= 'selected=selected';
		 
		 }
		 
		$ItemList.='>'.$aItem['itemgroup2_name'].'</option>';
         	  }
	echo trim($ItemList);
  }
  
   if($action == 'getGroupI')
  {
	  $id_group1 = $aRequest['Group1Id'];
	   
	  $aGroup1Item =  $aItemGroup1List = $oMaster->getItemGroup1List();
	  $ItemList= '<option value="0" >Choose the ItemGroup 1 </option>';
	foreach($aGroup1Item as $aItem)
			  {
		 $ItemList.= '<option value="'.$aItem['id_itemgroup1'].'"';
		 if($id_group2 == $aItem['id_itemgroup1']) { 
		 
		  $ItemList.= 'selected=selected';
		 
		 }
		 
		$ItemList.='>'.$aItem['itemgroup1_name'].'</option>';
         	  }
	echo trim($ItemList);
  }
  
   if($action == 'getItemLists')
  {
	  $id_group2 = $aRequest['Group2Id'];
	  $id_item = $aRequest['id'];
	  $aGroup2Item = $oMaster->getItemGroupMapList($id_group2,'group2');
	  $ItemList.= '<option value="0" >Choose the Item</option>';
	foreach($aGroup2Item as $aItem)
			  {
		 $ItemList.= '<option value="'.$aItem['id_item'].'"';
		 
		  if($id_item == $aItem['id_item']) { 
		 
		  $ItemList.= 'selected=selected';
		 
		 }
		 $ItemList.=' >'.$aItem['item_name'].'</option>';
         	  }
	echo trim($ItemList);
  }
  
  if($action == 'getItemListsByGroup1')
  {
	  $id_group1 = $aRequest['Group1Id'];
	  $aGroup1Item = $oMaster->getItemGroupMapList($id_group1,'item');
	  $ItemList.= '<option value="0">Choose the Item</option>';
	foreach($aGroup1Item as $aItem)
			  {
		 $ItemList.= '<option value="'.$aItem['id_item'].'">'.$aItem['item_name'].'</option>';
         	  }
	echo trim($ItemList);
  }
  
    if($action == 'getItemListDiv')
  {
		  	$id_store = $aRequest['fromstoreId'];
		
		 $aItemList1 = $oMaster->getItemGroup1ByStore($id_store,'','','store');
	   $ItemList='<div class="span4 "><select class=" m-wrap" tabindex="5" name="fItemGroup1" id="fItemGroup1" onChange="getGroup2ItemListing(this.value);"><option value="0" >Choose the Item Group1</option>';
		$ItemListend='</select></div>';
	  foreach($aItemList1 as $aItem)
			  {
		 $ItemList.= '<option value="'.$aItem['id_itemgroup1'].'">'.$aItem['itemgroup1_name'].'</option>';
         	  }
	echo trim($ItemList.=$ItemListend);
	
	
	 $aItemList1 = $oMaster->getItemGroup2ByStore('','',$id_store,'','store');
	   $ItemList='<div class="span4 " id="Group2ItemList" ><select class=" m-wrap" tabindex="6" name="fItemGroup2" id="fItemGroup2"><option value="0" >Choose the Item Group2</option>';
		$ItemListend='</select></div>';
	  foreach($aItemList1 as $aItem)
			  {
		 $ItemList.= '<option value="'.$aItem['id_itemgroup2'].'">'.$aItem['itemgroup2_name'].'</option>';
         	  }
	echo trim($ItemList.=$ItemListend);
	
	    
		
	   $ItemList='<div class="span4 " id="ItemsList"><select class=" m-wrap" tabindex="7" name="fItemName" id="fItemName"  onchange="getStockItem(this.value);"><option value="0" >Choose the Item</option>';
		
		         $aItemList12 = $oMaster->getItemByStore($id_store,'','id');                      
	      
				foreach($aItemList12 as $Item)
				{
				            
		 $ItemList.= '<option value="'.$Item['id_item'].'"> '.$Item['item_name'].'</option>';
         	 
				}
			 
				
	echo trim($ItemList.=$ItemListend);
		
	
  }
  if($action == 'getItemList')
  {
	
	  
	  	$id_store = $aRequest['fromstoreId'];
		
		 $aItemList1 = $oMaster->getItemGroup1ByStore($id_store,'','','store');
	   $ItemList='<div class="span4 "><select class=" m-wrap" tabindex="5" name="fItemGroup1" id="fItemGroup1" onChange="getGroup2ItemListing(this.value);"><option value="0" >Choose the Item Group1</option>';
		$ItemListend='</select></div>';
	  foreach($aItemList1 as $aItem)
			  {
		 $ItemList.= '<option value="'.$aItem['id_itemgroup1'].'">'.$aItem['itemgroup1_name'].'</option>';
         	  }
	echo trim($ItemList.=$ItemListend);
	
	
	 $aItemList1 = $oMaster->getItemGroup2ByStore('','',$id_store,'','store');
	   $ItemList='<div class="span4 " id="Group2ItemList" ><select class=" m-wrap" tabindex="6" name="fItemGroup2" id="fItemGroup2"><option value="0" >Choose the Item Group2</option>';
		$ItemListend='</select></div>';
	  foreach($aItemList1 as $aItem)
			  {
		 $ItemList.= '<option value="'.$aItem['id_itemgroup2'].'">'.$aItem['itemgroup2_name'].'</option>';
         	  }
	echo trim($ItemList.=$ItemListend);
	
	    
		
	   $ItemList='<div class="span4 " id="ItemsList"><select class=" m-wrap" tabindex="7" name="fItemName" id="fItemName"  onchange="AddItem(this.value);"><option value="0" >Choose the Item</option>';
		
		         $aItemList12 = $oMaster->getItemByStore($id_store,'','id');                      
	      
				foreach($aItemList12 as $Item)
				{
				$ItemList.= '<optgroup label="'.$Item['item_name'].'">	';
				$aItemList1 = $oMaster->getItemByStore($id_store,$Item['id_item'],'item');
				foreach($aItemList1 as $Items)
				{     						
            
		 $ItemList.= '<option value="'.$Items['asset_item'].'"> '.$Items['asset_no'].' - '.$Items['machine_no'].'</option>';
         	 
				}
			  $ItemList.= '</optgroup>';
				}
	echo trim($ItemList.=$ItemListend);
		
	
  }
  if($action == 'getGroupsItemList')
  {
	   $id_Group1 = $_REQUEST['Group1Id'];
	    $id_group2 = $_REQUEST['group2Id'];
		
	  $aItemGroupList1 = $oMaster->getItemGroups($id_Group1,'','group2');
		
	  $ItemList='<select class=" m-wrap" tabindex="6" name="fItemGroup2" id="fItemGroup2" onChange="getItemLising(this.value);"><option value="0" >Choose the Item Group2</option>';
		$ItemListend='</select>';
	  foreach($aItemGroupList1 as $aItem)
			  {
		 $ItemList.= '<option value="'.$aItem['id_itemgroup2'].'"'; 
		 
		 if($id_group2 == $aItem['id_itemgroup2']) { 
		 
		  $ItemList.= 'selected=selected';
		 
		 }
		 $ItemList.= ' >'.$aItem['itemgroup2_name'].'</option>';
         	  }
	echo $itemGroup2 = trim($ItemList.=$ItemListend);
  }
  if($action == 'getGroupsItemList1'){
	  $id_Group1 = $_REQUEST['Group1Id'];
	  $item_id  = $_REQUEST['itemId'];	 
	 
	 $ItemList1='<select class=" m-wrap" tabindex="7" name="fItemName" id="fItemName" onchange="AddItem(this.value)"><option value="0" >Choose the Item</option>';
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
	  /*foreach($aItemsList1 as $aItems)
			  {
		 $ItemList1.= '<optgroup label="'.$aItems['item_name'].'"><option value="'.$aItems['asset_item'].'"> '.$aItems['asset_no'].' - '.$aItems['machine_no'].'</option></optgroup>';
         	  }*/
	echo trim($ItemList1.=$ItemList1end);
	
  }
  if($action == 'getGroupItemList')
  {
	 $id_Group1 = $_REQUEST['Group1Id'];
	 $storeId = $_REQUEST['StoreId'];
	   $aItemGroupList1 = $oMaster->getItemGroup1ByStore($id_Group1,$storeId,'','group2');
	    
	   $ItemList='<select class=" m-wrap" tabindex="6" name="fItemGroup2" id="fItemGroup2" onChange="getItemLising(this.value);"><option value="0" >Choose the Item Group2</option>';
		$ItemListend='</select>';
	  foreach($aItemGroupList1 as $aItem)
			  {
		 $ItemList.= '<option value="'.$aItem['id_itemgroup2'].'">'.$aItem['itemgroup2_name'].'</option>';
         	  }
	echo $itemGroup2 = trim($ItemList.=$ItemListend);
	
	/* $aItemsList1 = $oMaster->getItemGroup1ByStore($id_Group1,$storeId,'item');
	 
	 $ItemList1=' <select class=" m-wrap" tabindex="3" name="fItemName" id="fItemName" onchange="AddItem(this.value)"><option value="0" >Choose the Item</option>';
		$ItemList1end='</select>';
	  foreach($aItemsList1 as $aItems)
			  {
		 $ItemList1.= '<option value="'.$aItems['asset_item'].'">'.$aItems['item_name'].'( '.$aItems['asset_no'].' )</option>';
         	  }
		 $item =  trim($ItemList1.=$ItemList1end);
	echo   $itemGroup2.$item;*/
	
  }
if($action == 'getGroupItemList1'){
	  $id_Group1 = $_REQUEST['Group1Id'];
	  $storeId = $_REQUEST['StoreId'];
	 
	 
	 
	 $ItemList1='<select class=" m-wrap" tabindex="7" name="fItemName" id="fItemName" onchange="AddItem(this.value)"><option value="0" >Choose the Item</option>';
		$ItemList1end='</select>';
		 $aItemList12 = $oMaster->getItemGroup1ByStore($id_Group1,$storeId,'','item');
		  
				foreach($aItemList12 as $Item)
				{
				$ItemList1.= '<optgroup label="'.$Item['item_name'].'">	';
				 $aItemsList4 = $oMaster->getItemGroup1ByStore($id_Group1,$storeId,$Item['id_item'],'item');
				
				foreach($aItemsList4 as $Items)
				{     						
            
		 $ItemList1.= '<option value="'.$Items['asset_item'].'"> '.$Items['asset_no'].' - '.$Items['machine_no'].'</option>';
         	 
				}
			  $ItemList1.= '</optgroup>';
				}
	  /*foreach($aItemsList1 as $aItems)
			  {
		 $ItemList1.= '<optgroup label="'.$aItems['item_name'].'"><option value="'.$aItems['asset_item'].'"> '.$aItems['asset_no'].' - '.$aItems['machine_no'].'</option></optgroup>';
         	  }*/
	echo trim($ItemList1.=$ItemList1end);
	
  }
  
  if($action == 'getItemsList')
  {
	  $id_Group1 = $_REQUEST['Group1Id'];
	    $id_Group2 = $_REQUEST['Group2Id'];
		$storeId = $_REQUEST['StoreId'];
		$ItemList='<select class=" m-wrap" tabindex="7" name="fItemName" id="fItemName" onchange="AddItem(this.value)"><option value="0" >Choose the Item</option>';
		$ItemListend='</select>';
		  $aItemList12 = $oMaster->getItemGroup2ByStore($id_Group2,$id_Group1,$storeId,'','item');
		
				foreach($aItemList12 as $Item)
				{
				$ItemList.= '<optgroup label="'.$Item['item_name'].'">	';
				 $aItemsList4 = $oMaster->getItemGroup2ByStore($id_Group2,$id_Group1,$storeId,$Item['id_item'],'item');
				
				foreach($aItemsList4 as $Items)
				{     						
            
		 $ItemList.= '<option value="'.$Items['asset_item'].'"> '.$Items['asset_no'].' - '.$Items['machine_no'].'</option>';
         	 
				}
			  $ItemList.= '</optgroup>';
				}
		
	  /* 
	  foreach($aItemsList1 as $aItem)
			  {
		 $ItemList.= '<optgroup label="'.$aItem['item_name'].'"><option value="'.$aItem['asset_item'].'"> '.$aItem['asset_no'].' - '.$aItem['machine_no'].'</option></optgroup>';
         	  }*/
	echo trim($ItemList.=$ItemListend);
  }
  
  if($action == 'getCompanyLookup')
  {
	 $id_company = $_REQUEST['cmpyID']; 
	$acompany = $oMaster->getCompanyInfo($id_company,'id');
	echo $CompanyLookup = $acompany['lookup'];

  }
  if($action =='addQuantity')
  {
	   $jqty = $_REQUEST['qty'];
	   $jid_asset_item = $_REQUEST['asset_item'];
	   $aqtys =   json_decode($jqty);
	   $aid_item =   json_decode($jid_asset_item);
	$aItemQuantity  = array_combine($aid_item,$aqtys);
	 $sesItemList = $oSession->getSession('ses_Itemlist');
	 foreach($sesItemList as $key => $value)
	 {
		 $sesItemList[$key] = $aItemQuantity[$key];
		 
	 }
 $oSession->setSession('ses_Itemlist',$sesItemList);	
  }
  
    if($action == 'getItem')
  {
	  $id_item = $_REQUEST['ItemId'];
	  $id_store = $_REQUEST['StoreId'];
	  $group2 = $_REQUEST['group2'];
	  $astockItem = $oMaster->getStockItemDiv($id_item,$id_store,'id',$group2);
	  	 $sesItemList = $oSession->getSession('ses_DeliveryItemlist');
	
	 if(empty($sesItemList))
		{
		   $sesItemList = array();
		}
	$SesItem = array_keys($sesItemList);
	
	if(!(in_array($id_item, $SesItem))) {
		  $sesItemList[$id_item] = $group2;
		$oSession->setSession('ses_DeliveryItemlist',$sesItemList);	
	   foreach( $astockItem as $stock)
	  {
	  echo '<tr>
	  <td>'.$stock['itemgroup1_name'].'<input type="hidden" name="fItemGroup1Id[]" value="'.$stock['id_itemgroup1'].'"/></td>
	  <td>'.$stock['itemgroup2_name'].'<input type="hidden" name="fItemGroup2Id[]" value="'.$stock['id_itemgroup2'].'"/></td>
	   <td>'.$stock['item_name'].'<input type="hidden" name="fItemId[]" value="'.$stock['id_item'].'"/></td>
	  
	   <td>'.$stock['uom_name'].'<input type="hidden" name="fUomId[]" value="'.$stock['id_uom'].'"/></td>
	   <td>'.$stock['stock_quantity'].'<input type="hidden" name="fStockQuqntity[]" value="'.$stock['stock_quantity'].'"/></td>
	  <td>'.$stock['asset_no'].'<input type="hidden" name="fAssetNumber[]" value="'.$stock['asset_no'].'"/></td>
	  
	  <td><input type="checkbox" name="fAssetItemId[]" value="'.$stock['asset_item'].'"/></td>
	  </tr>';
	  }
	  }
	
  }
  
  if($action == 'addItem')
  {
	  $id_item = $_REQUEST['ItemId'];
	  $id_store = $_REQUEST['StoreId'];
	  $astockItem = $oMaster->getStockItem($id_item,$id_store);
	 $sesItemList = $oSession->getSession('ses_Itemlist');
	
	 if(empty($sesItemList))
		{
		   $sesItemList = array();
		}
	$SesItem = array_keys($sesItemList);
	
	if(!(in_array($id_item, $SesItem))) {
		  $sesItemList[$id_item] ='';
		$oSession->setSession('ses_Itemlist',$sesItemList);	
		
	  foreach( $astockItem as $stock)
	  {
	  echo '<tr>
	  <td>'.$stock['itemgroup1_name'].'<input type="hidden" name="fItemGroup1Id[]" value="'.$stock['id_itemgroup1'].'"/></td>
	  <td>'.$stock['itemgroup2_name'].'<input type="hidden" name="fItemGroup2Id[]" value="'.$stock['id_itemgroup2'].'"/></td>
	   <td>'.$stock['item_name'].'<input type="hidden" name="fItemId[]" value="'.$stock['id_item'].'"/></td>
	  
	   <td>'.$stock['uom_name'].'<input type="hidden" name="fUomId[]" value="'.$stock['id_uom'].'"/></td>
	   
	  <td>'.$stock['stock_quantity'].'<input type="hidden" name="fStockQuqntity[]" value="'.$stock['stock_quantity'].'"/></td>
	  <td><input type="text" name="fIssueQuantity[]" size="15" onKeyup="addQuanitity('.$stock['asset_item'].')" value="'.$stock['stock_quantity'].'"/></td>
	   <td>'.$stock['asset_no'].'<input type="hidden" name="fAssetNumber[]" value="'.$stock['asset_no'].'"/></td>
	  <td>'.$oMaster->checkMaintenace($stock['asset_item']).'</td>
	  <td><a href="#" id="RemoveItem" onClick="removeItem('.$stock['asset_item'].')">Remove Item</a><input type="hidden" name="fAssetItemId[]" value="'.$stock['asset_item'].'"/></td>
	  </tr>';
	  }
	  
	}// inarray 
  }
  if($action == 'remove')
  {
	 $id_item = $_REQUEST['removeId'];
	 $sesItemList = $oSession->getSession('ses_Itemlist');
	 $SesItem = array_keys($sesItemList);
	if(!empty($sesItemList))
		{
			foreach($sesItemList as $key => $value)
			{
				if($key == $id_item)
				{
			      unset($sesItemList[$key]);
				}
			}
		//$sesItemList = array_values($sesItemList);
		$oSession->setSession('ses_Itemlist',$sesItemList);
	foreach($sesItemList as $key => $value )
	{		
	   $id_store = $_REQUEST['StoreId'];
	  $astockItem = $oMaster->getStockItem($key,$id_store,$value);
	
	  foreach( $astockItem as $stock)
	  {
	  echo '<tr>
	  <td>'.$stock['itemgroup1_name'].'<input type="hidden" name="fItemGroup1Id[]" value="'.$stock['id_itemgroup1'].'"/></td>
	  <td>'.$stock['itemgroup2_name'].'<input type="hidden" name="fItemGroup2Id[]" value="'.$stock['id_itemgroup2'].'"/></td>
	   <td>'.$stock['item_name'].'<input type="hidden" name="fItemId[]" value="'.$stock['id_item'].'"/></td>
	  
	   <td>'.$stock['uom_name'].'<input type="hidden" name="fUomId[]" value="'.$stock['id_uom'].'"/></td>
	   
	  <td>'.$stock['stock_quantity'].'<input type="hidden" name="fStockQuqntity[]" value="'.$stock['stock_quantity'].'"/></td>
	  <td><input type="text" name="fIssueQuantity[]" size="15" onKeyup="addQuanitity('.$stock['asset_item'].')" value="'.$stock['issue_quantity'].'"/></td>
	   <td>'.$stock['asset_no'].'<input type="hidden" name="fAssetNumber[]" value="'.$stock['asset_no'].'"/></td>
	    <td>'.$oMaster->checkMaintenace($stock['asset_item']).'</td>
	  <td><a href="#" id="RemoveItem" onClick="removeItem('.$stock['asset_item'].')">Remove Item</a><input type="hidden" name="fAssetItemId[]" value="'.$stock['asset_item'].'"/></td>
	  </tr>';
	  }
	   }
		}
	  }
 
  
  if($action == 'getpodate')
  {
  	$id_po = $aRequest['poId'];
	$podate = $oMaster->getPurchaseOrderInfo($id_po,'id');
	echo date('d-m-Y',strtotime($podate['po_date'])); 
  }
  if($action == 'getTerms')
  {
  	$id_terms = $aRequest['TCId'];
	$aTermsInfo = $oMaster->getTermsConditionsInfo($id_terms);
	
	$Terms =$aTermsInfo['description']; 
	echo $Terms;
  }
 /* if($action == 'getAssetNumber')
  {
	  $id_itme = $aRequest['itemId'];
	  $asset_no = $oMaster->countAssetNumber( $id_itme);
	  echo $asset_no;
  }*/
   if($action == 'getAssetNumber')
  {
	  $id_itme = $aRequest['itemId'];
	 $asset_no = $aRequest['asset_no'];
	 $item_lookup = $oMaster->getItemInfo( $id_itme ,'id');
	 $asset_number = explode("-",$asset_no );
	 $new_asset_no = $asset_number[0].'-'.$item_lookup['lookup'].'-'.$asset_number[2];
	 echo $new_asset_no ;
  }
  if($action == 'PurchaseOrderInfo')
  {
	$id_po = $aRequest['id_pos']; 
	$aPOIteminfo = $oMaster->getForceStockInfo($id_po,'id');
	$Reporttable = '
	<h5><b>Purchase Order Details :</b></h5>
	<table width="100%" border="1">
	<tr bgcolor="#0099FF">
	<th>PO NUMBER</th>
	<th>PO DATE</th>
	<th>VENDOR NAME</th>
	</tr>
	<tr>
	<td>'.$aPOIteminfo['po_detail']['po_number'].'</td>
	<td>'.$aPOIteminfo['po_detail']['po_date'].'</td>
	<td>'.$aPOIteminfo['po_detail']['vendor_name'].'</td>
	</tr>
	
	</table>
	
	<h5><b>Purchase Order Item Details :</b></h5>
	<table width="100%" border="1" style="text-align:center;">
	<tr bgcolor="#FFFFFF">
	<th>ITEM NAME</th>
	<th>PURCHASED QUANTITY</th>
	<th>QUANTITY RECEIVED</th>
	<th>BALANCED QUANTITY </th>
	<th>UNIT COST </th>
	</tr>';
	foreach($aPOIteminfo['po_item_details'] as $aPOitem)
	{
	$Reporttable.= '<tr>
	<td>'.$aPOitem['item'].'</td>
	<td>'.$aPOitem['qty'].'</td>
	<td>'.$aPOitem['qty_received'].'</td>
	<td>'.$aPOitem['balanced_qty'].'</td>
	<td>'.$aPOitem['unit_cost'].'</td>
	</tr>';	
	}
	$Reporttable.='</table>
	
	';
	echo trim($Reporttable);
  }
  if($action =='StockInfo')
  {
  $lookup = $aRequest['itemId'];
  $stocklist = $oReport->getUnitWiseItemStock($lookup);

$StockTable='
<h5><b>'.$stocklist['itemname'].'</b></h5>';
if(!empty($stocklist['stock']))
{
$StockTable.='<table border="1"  style="text-align:center" cellspacing="1" cellpadding="2" width="100%">
<tr>
<th>AVAILABLE STOCK</th>
<th>USED STOCK</th>
<th>TOTAL STOCK</th>
</tr>
<tr>
<td>'.$stocklist['stock']['availablestock'].'</td>
<td>'.$stocklist['stock']['usedstock'].'</td>
<td>'.$stocklist['stock']['totalstock'].'</td>
</tr>
</table>';
}

if(!empty($stocklist['unitwisestock']))
{
$StockTable.='<h5><b>AVAILABLE STOCK DETAILS</b></h5>
<table border="1" style="text-align:center" cellspacing="1" cellpadding="2" width="100%">
<tr>
<th>BRAND / MAKE</th>
<th>STORE NAME</th>
<th>UNIT NAME</th>
<th>AVAILABLE STOCK</th>

</tr>';
foreach($stocklist['unitwisestock'] as $aUsedItem) {
$StockTable.='<tr>
<td>'.$aUsedItem['itemgroup2_name'].'</td>
<td>'.$aUsedItem['store_name'].'</td>
<td>'.$aUsedItem['unit_name'].'</td>
<td>'.$aUsedItem['unitwiseitemcount'].'</td>
</tr>';
 } 
$StockTable.='</table>';
}

if(!empty($stocklist['usedstockitem']))
{

$StockTable.='

<h5><b>USED STOCK DETAILS</b></h5>
<table border="1"  style="text-align:center" cellspacing="1" cellpadding="2" width="100%">
<tr>
<th>BRAND / MAKE</th>
<th>STORE NAME</th>
<th>UNIT NAME</th>
<th>USED STOCK</th>

</tr>';

foreach($stocklist['usedstockitem'] as $aUsedItem) {
$StockTable.='<tr>
<td>'.$aUsedItem['itemgroup2_name'].'</td>
<td>'.$aUsedItem['store_name'].'</td>
<td>'.$aUsedItem['unit_name'].'</td>
<td>'.$aUsedItem['activeitem'].'</td>
</tr>';
} 
$StockTable.='</table>';
}

echo trim($StockTable);
  }
  
  if($action =='getItemType')
  {
  $type = $aRequest['type'];
  $id_iteam = $aRequest['id'];
  if($type =='New')
  {
     $ItemType = '  <div class="control-group">
                                       <label class="control-label">Item Name<span class="required">*</span></label>
                                       <div class="controls" >
									   <input type="text" placeholder="Enter the Item Name" class="m-wrap large" name="fItemName" data-required="1" value=""/>
									     </div>
                                    </div>
									 <div class="control-group">
                                       <label class="control-label">Lookup<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" maxlength="3" class="m-wrap small" name="fLookup" data-required="1" value=""/>
                                          <span class="help-inline">Enter Lookup</span>
                                       </div>
                                    </div>  
									   ';
  }
  else if($type == 'Item')
  {
    $ItemType = '<div class="control-group">
                                       <label class="control-label">Item Name<span class="required">*</span></label>
                                       <div class="controls" ><select class="large  m-wrap nextRow " tabindex="1" name="fItemName"  id="fItemName1">
                                    <option value="0" >Choose the Item</option>';
											
											  $aItemList = $oMaster->getItemList();
											  foreach($aItemList as $aItem)
											  {
											
                                             $ItemType.= '<option value="'.$aItem['id_item'].'"';
											 
											 if($id_iteam == $aItem['id_item']) { 
		 
		 									 $ItemType.= 'selected=selected';
		 
		 										}
											  $ItemType.='>'.$aItem['item_name'].'</option>';
                                            
											  }
											
                                          $ItemType.= '</select> </div>
                                    </div>';
  }
  echo trim($ItemType);
  }
  
  
  if($action == 'addPRItem')
  {
	$id_item = $_REQUEST['ItemId'];
	  $id_group2= $_REQUEST['group2Id'];
	  $id_group1 = $aRequest['group1Id'];
	   $astockItemPR = $oMaster->getItemGroupMapList($id_item,'itemsid',$id_group2, $id_group1);
	
	 $sesItemList = $oSession->getSession('ses_PRItemlist');
	
	 if(empty($sesItemList))
		{
		   $sesItemList = array();
		}
	$SesItem = array_keys($sesItemList);
	 $aGroupId = $oMaster->getGroupMapId($id_group1,$id_group2,$id_item);

	if(!(in_array($aGroupId, $SesItem))) {
		  $sesItemList[$aGroupId] = array("group2"=>$id_group2,"group1"=>$id_group1,"item"=>$id_item,"uom"=>'',"qty"=>'',"price"=>'');
		$oSession->setSession('ses_PRItemlist',$sesItemList);	
		
		$UOM='<select class="m-wrap" style="width:100px;" tabindex="9" data-placeholder="Choose a UOM" name="fUOMId[]" >
     <option value="0">UOM</option>';
											  $aUOMList= $oMaster->getUomList();
											  foreach($aUOMList as $aUOM)
											  {
                                            $UOM.='<option value="'.$aUOM['id_uom'].'" >'.$aUOM['uom_name'].'</option>';
                                           }
  $UOM.='</select>';

	  foreach( $astockItemPR as $stock)
	  {
	  echo '<tr>
	  <td>'.$stock['itemgroup1_name'].'<input type="hidden" name="fGroup1[]"  value="'.$stock['id_itemgroup1'].'"/></td>
	  <td>'.$stock['itemgroup2_name'].'<input type="hidden" name="fGroup2[]"  value="'.$stock['id_itemgroup2'].'"/></td>
	   <td>'.$stock['item_name'].'<input type="hidden" name="fItemName[]" value="'.$stock['id_item'].'"/></td>
	  
	   <td>'.$UOM.'</td>
	   
	  <td><input type="text" name="fQuanity[]" tabindex="10" value=""/></td>
	 <td><input type="text" name="fPrice[]" tabindex="11" value=""/></td>
	  <td><a href="#" id="RemoveItem" onClick="removeItem('.$stock['id_item_map'].')">Remove Item</a><input type="hidden" name="fItemId[]" value="'.$stock['id_item_map'].'"/></td>
	  </tr>';
	  }
	  
	}// inarray 
  }
  if($action == 'removePR')
  {
	 $removeid = $_REQUEST['removeId'];
	 $agroup=   json_decode($aRequest['groupmapid']);
	 $auom=   json_decode($aRequest['uoms']);
	 $aprice=   json_decode($aRequest['price']);
	 $sesItemList = $oSession->getSession('ses_PRItemlist');
	 $SesItem = array_keys($sesItemList);
	
	 function objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}
 
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);
		}
		else {
			// Return array
			return $d;
		}
	}
	 $agroup1 =objectToArray($agroup);
	 	$agroup1keys = array_keys($agroup1);
		 $auom1 =objectToArray($auom);
	 	 $aprice1 =objectToArray($aprice);
	 	
		 $i= 0;
	if(!empty($sesItemList))
		{
			foreach($sesItemList as $key => $value)
			{
				if($key == $removeid)
				{
			      unset($sesItemList[$key]);
				}
				if($key == $agroup1keys[$i] && $key!=$removeid)
				{				
				$sesItemList[$key]['qty'] = $agroup1[$agroup1keys[$i]];
				$sesItemList[$key]['uom'] = $auom1[$agroup1keys[$i]];
				$sesItemList[$key]['price'] = $aprice1[$agroup1keys[$i]];
				}
				$i++;
			}
			$oSession->setSession('ses_PRItemlist',$sesItemList);
			$sesItemList = $oSession->getSession('ses_PRItemlist');
		
	foreach($sesItemList as $value )
	{
	
	$UOMList='<select class="m-wrap" style="width:100px;" data-placeholder="Choose a UOM " tabindex="9" name="fUOMId[]" >
     <option value="0">UOM</option>';
											  $aUOMList= $oMaster->getUomList();
											  foreach($aUOMList as $aUOM)
											  {
                                            $UOMList.='<option value="'.$aUOM['id_uom'].'" ';											  
											 if($value['uom'] == $aUOM['id_uom']) { 
		 
		 									 $UOMList.= 'selected=selected';
		 
		 										}
											$UOMList .='>'.$aUOM['uom_name'].'</option>';
                                           }
										    $UOMList.='</select>';
	 $astockItemPRs = $oMaster->getItemGroupMapList($value['item'],'itemsid',$value['group2'],$value['group1']);
	 foreach( $astockItemPRs as $stock)
	  {
	  echo '<tr>
	  <td>'.$stock['itemgroup1_name'].'<input type="hidden" name="fGroup1[]" value="'.$stock['id_itemgroup1'].'"/>
	   <input type="hidden" class="items" name="fItemId[]" value="'.$value['itemId'].'" />
	  </td>
	  <td>'.$stock['itemgroup2_name'].'<input type="hidden" name="fGroup2[]" value="'.$stock['id_itemgroup2'].'"/></td>
	   <td>'.$stock['item_name'].'<input type="hidden" name="fItemName[]" value="'.$stock['id_item'].'"/></td>
	  
	    <td>'.$UOMList.'</td>
	   
	  <td><input type="text" name="fQuanity[]" tabindex="10" value="'.$value['qty'].'"/></td>
	 <td><input type="text" name="fPrice[]" tabindex="11" value="'.$value['price'].'"/></td>
	  <td><a href="#" id="RemoveItem" onClick="removeItem('.$stock['id_item_map'].')">Remove Item</a></td>
	  </tr>';
	  }
	   }
		}
	  }
	  
	  
if($action == 'PurchaseReturnInfo')
{
$item_id =  $aRequest['id_purchase_returns'];
$aResult  = $oMaster->getPurchaseReturnItemInfo($item_id,'id');

$Return_table =' 
<TABLE cellSpacing="0" cellPadding="0" width="100%"  align="center">
              <TBODY>
			  
			    <TR class="srow" align="left">
                <TD ><B><FONT class="detail">&nbsp;PO NO</FONT></B></TD>
                <TD >:&nbsp; &nbsp;<B style="color:#EB4A0C">'.$aResult['purchasereturninfo']['request_no'].'</B></TD></TR>
              <TR class="srow" align="left">
                <TD ><B><FONT class="detail">&nbsp;GRN NO</FONT></B></TD>
                <TD >:&nbsp; &nbsp;<B style="color:#420CEB">'.$aResult['purchasereturninfo']['grn_no'].'</B></TD></TR>
				
				
                <TR class="srow" align="left">
                <TD><FONT  class="detail">&nbsp;DATE</FONT></TD>
                <TD><FONT  class="detail">: &nbsp;'.date('d/m/Y',strtotime($aResult['purchasereturninfo']['created_on'])).'</FONT></TD></TR>
                 <TR class="srow" align="left">
                <TD><FONT  class="detail">&nbsp;DC NO</FONT></TD>
                <TD><FONT  class="detail">: &nbsp;'.$aResult['purchasereturninfo']['dc_number'].'</FONT></TD></TR>
              <TR class="srow" align="left">
                <TD><FONT  class="detail">&nbsp;DC DATE</FONT></TD>
                <TD><FONT  class="detail">: &nbsp;'.date('d/m/Y',strtotime($aResult['purchasereturninfo']['dc_date'])).'</FONT></TD></TR>
                 <TR class="srow" align="left">
                <TD><FONT  class="detail">&nbsp;BILL NO</FONT></TD>
                <TD><FONT  class="detail">: &nbsp;'.$aResult['purchasereturninfo']['bill_number'].'</FONT></TD></TR>
                 <TR class="srow" align="left">
                <TD><FONT  class="detail">&nbsp;BILL DATE</FONT></TD>
                <TD><FONT  class="detail">: &nbsp;'.date('d/m/Y',strtotime($aResult['purchasereturninfo']['bill_date'])).'</FONT></TD></TR>
                
                
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
	 <TD width="5%"><B>RETURN QUANTITY </B></TD>
    <TD width="4%"><B>RATE IN '.Currencycode.'</B></TD>
    <TD width="5%"><B>AMOUNT IN '.Currencycode.'</B></TD>
   </TR>
    ';
	
	$sl_no = 1;
	foreach ($aResult['iteminfo'] as $purchaseitem){
		$net_qty +=$purchaseitem['return_qty']; 
		
$Return_table .='		
  <TR class="srow" bgColor="white">
    <TD align="right">'.$sl_no.'&nbsp;&nbsp;</TD>
    <TD>&nbsp;&nbsp;'.$purchaseitem['itemgroup1_name'].'-'.$purchaseitem['itemgroup2_name'].'-'.$purchaseitem['item_name'].'&nbsp;&nbsp;</TD>
    <TD  align="right">'.$purchaseitem['qty'].'&nbsp;&nbsp;.'.$purchaseitem['uom_name'].' &nbsp;</TD>
	 <TD  align="right">'.$purchaseitem['return_qty'].'&nbsp;&nbsp;'.$purchaseitem['uom_name'].' &nbsp;</TD>
      <TD noWrap align="right">'.$oMaster->moneyFormat($purchaseitem['unit_cost']).' &nbsp;</TD>
    <TD noWrap align="right">';
	
	 $unittotal =  $purchaseitem['return_qty'] * $purchaseitem['unit_cost'] ;
	$Return_table .=''.$oMaster->moneyFormat($unittotal).' &nbsp;</TD>
      </TR>';
       
	 
	  $net_total +=$unittotal;
	  $sl_no ++;
	  } 
$Return_table.='     
 <TR class="srow" bgColor="white">
    <TD colSpan="3" align="right">Total Qty&nbsp;</TD>
   <TD align="right"><B>&nbsp;'.$net_qty .'&nbsp;</B></TD>
    <TD>&nbsp;</TD>
    
   <TD align="right"><B>&nbsp;'.$oMaster->moneyFormat($net_total).'&nbsp;&nbsp;</B></TD>
   </TR>
   
   
    
</TBODY></TABLE>

';
echo $Return_table;
}	  
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
