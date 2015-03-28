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
  if($action == 'searchType')
  {
    $search_type = $aRequest['stype'];
	
	switch($search_type)
	{
		 case 'unit':
						$aUnits ='<div class="span6"><select class="m-wrap " tabindex="1" name="fUnitId" onChange="getstore(this.value)">
						<option value=""> Choose a  Unit</option>';$aUnitList = $oAssetUnit->getAllAssetUnitInfo();
						foreach($aUnitList as $aUnit){
						   $aUnits .='<option value="'.$aUnit['id_unit'].'" >'.$aUnit['unit_name'].'</option>';
						 }$aUnits .='</select> </div>';
						  echo trim($aUnits);
		   break;
		    case 'store':
						$Store ='  <select class="m-wrap" tabindex="2" name="fStoreId" >
						<option value="">Choose a  Store</option>';$aStoreList = $oMaster->getStoreList();
						foreach($aStoreList as $aStore)
						 {
						  $Store .='<option value="'.$aStore['id_store'].'" >'.$aStore['store_name'].'</option>';
						 }$Store .='</select> </div>';
						  echo trim($Store);
		   break;
		   case 'itemgroup':
		   $itemlist ='<div class="span6">
		     <select class="m-wrap" tabindex="2" name="fGroup1" id="group1" onChange="getGroup2ItemListing(this.id,this.value)">
                                            <option value="0" selected="selected" >Choose the ItemGroup 1 </option>';
											  $aItemGroup1List = $oMaster->getItemGroup1List();
											  foreach($aItemGroup1List as $aItemGroup1)
											  {
											$itemlist .='                                                
                                             <option value="'.$aItemGroup1['id_itemgroup1'].'">'.$aItemGroup1['itemgroup1_name'].'</option>';
                                             
											  }
											$itemlist .='</select> 
											 <select class="m-wrap group2" tabindex="3" style="margin-top: 20px;" name="fGroup2" id="itemgroup1"        onChange="getItemLising(this.id,this.value);">
                                               <option value="" selected="selected" >Choose the ItemGroup 2 </option>
											 </select>
											 <select class="m-wrap nextRow items" style="margin-top: 20px;" tabindex="1" name="fItemName"   id="fItemName1" onChange="getAsset(this.value,this.id);">
                                    <option value="" >Choose the Item</option> </select>
											</div>';
											  echo trim($itemlist);
		   break;
	}
	}
	
	if($action == 'getItemsListBystock'){
	  $id_Group1 = $_REQUEST['Group1Id'];
	  $id_Group2 = $_REQUEST['Group2Id'];
	 $item_id = $_REQUEST['itemid'];
	 $ItemList1='<option value="" >Choose the Item</option>';
		
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
  
   if($action == 'getGroup2ItemList')
  {
	  $id_group1 = $aRequest['Group1Id'];
	   $id_group2 = $aRequest['group2Id'];
	  
	  $aGroup1Item = $oMaster->getItemGroupMapList($id_group1,'group1');
	  $ItemList= '<option value="" >Choose the Brand / Make</option>';
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
  
	 

     
?>
