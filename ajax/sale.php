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
  
 if($action == 'getGroupItemList1'){
	  $id_Group1 = $_REQUEST['Group1Id'];
	    $id_Group2 = $_REQUEST['Group2Id'];
	   
	   	 $ItemList1='<select class=" m-wrap" tabindex="7" name="fItemName" id="fItemName" onchange="AddItem(this.value)"><option value="0" >Choose the Item</option>';
		$ItemList1end='</select>';
		 $aItemList12 = $oMaster->getItemsDrop($id_Group1,$id_Group2,'','item');

			foreach($aItemList12 as $Item)
				{
				$ItemList1.= '<optgroup label="'.$Item['item_name'].'">	';
				 $aItemsList4 = $oMaster->getItemsDrop($id_Group1,$id_Group2,$Item['id_item'],'item');
				
				foreach($aItemsList4 as $Items)
				{     						
            
		 $ItemList1.= '<option value="'.$Items['asset_item'].'"> '.$Items['asset_no'].' - '.$Items['machine_no'].'</option>';
         	 
				}
			  $ItemList1.= '</optgroup>';
				}
	 
	echo trim($ItemList1.=$ItemList1end);
	
  }
    if($action == 'addItem')
  {
	  $id_item = $_REQUEST['ItemId'];
	 $astockItem = $oMaster->getStockItemBySale($id_item);
	 $sesItemList = $oSession->getSession('ses_SaleItemlist');
	
	$tax = '
<select class="span12 " data-placeholder="Choose a Tax"  name="fTaxId[]" value="0">
 <option value="0/+/0">Choose the Tax</option>
										';
	$aTaxList = $oMaster->getTaxFormList();
	foreach($aTaxList as $aTax)
	{
	$tax.='
	<option value="'.$aTax['tax_percentage'].'/'.$aTax['addless'].'/'.$aTax['id_taxform'].'">'.$aTax['taxform_name'].'</option>';
	}
	$tax.='</select>';

	 if(empty($sesItemList))
		{
		   $sesItemList = array();
		}
	$SesItem = array_keys($sesItemList);
	
	if(!(in_array($id_item, $SesItem))) {
		  $sesItemList[$id_item] ='';
		$oSession->setSession('ses_SaleItemlist',$sesItemList);	
		
	  foreach( $astockItem as $stock)
	  {
	          /*DEPRICEATION */
	             $startYear = $stock['date_of_install'];
				 $alifetime = $oDepreciation->getFinYearDiff($startYear,date('Y-m-d'));
				$aDepreciation_redu = $oDepreciation->reducingBalanceDepreciation($stock['asset_amount'],$alifetime,$startYear,$stock['depressation_percent'],$stock['asset_item']);
				$aCount = count($aDepreciation_redu);
				$Dep_price =  $aDepreciation_redu[$aCount-1]['Written_Down_Value'];		
				  /*DEPRICEATION */							   
	  $item = $stock['itemgroup1_name'].'-'.$stock['itemgroup2_name'].'-'.$stock['item_name'];
	  
	  echo '<tr>
	   <td><a href="AssetInfo.php?id='.$stock['asset_item'].'" target="_blank"  >'.$stock['asset_no'].'</a><input type="hidden" name="fAssetNumber[]" value="'.$stock['asset_no'].'"/></td>
	   
	  <td>'.$item.'<input type="hidden" name="fItemGroup1Id[]" value="'.$stock['id_itemgroup1'].'"/><input type="hidden" name="fItemGroup2Id[]" value="'.$stock['id_itemgroup2'].'"/><input type="hidden" name="fItemId[]" value="'.$stock['id_item'].'"/></td>
	<td>1 '.$stock['uom_name'].'<input type="hidden" name="fUomId[]" value="'.$stock['id_uom'].'"/><input type="hidden" name="fIssueQuantity[]" size="15" value="1"/><input type="hidden" name="fStockQuqntity[]" value="'.$stock['stock_quantity'].'"/></td>
	  <td>'.$stock['asset_amount'].'<input type="hidden" name="fUnitPrice[]" size="15"  value="'.$stock['asset_amount'].'"/></td>
	   <td>'.$Dep_price.'<input type="hidden" name="fDepPrice[]" size="15"  value="'.$Dep_price.'"/></td> 
	   <td><input type="text" name="fSalePrice[]" size="15"  value=""/></td>
	   <td>'.$tax.'</td>
	  <td><a href="#" id="RemoveItem" onClick="removeItem('.$stock['asset_item'].')">Remove Item</a><input type="hidden" name="fAssetItemId[]" value="'.$stock['asset_item'].'"/></td>
	  </tr>';
	  }
	  
	}// inarray 
  }
  if($action == 'remove')
  {
	 $id_item = $_REQUEST['removeId'];
	 $sesItemList = $oSession->getSession('ses_SaleItemlist');
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
		$oSession->setSession('ses_SaleItemlist',$sesItemList);
		
		$tax = '
<select class="span12 " data-placeholder="Choose a Tax"  name="fTaxId[]" value="0">
 <option value="0/+/0">Choose the Tax</option>
										';
		$aTaxList = $oMaster->getTaxFormList();
		foreach($aTaxList as $aTax)
		{
		
		$tax.='
		<option value="'.$aTax['tax_percentage'].'/'.$aTax['addless'].'/'.$aTax['id_taxform'].'">'.$aTax['taxform_name'].'</option>';
		}
		$tax.='</select>';

	foreach($sesItemList as $key => $value )
	{		
	  
	  $astockItem = $oMaster->getStockItemBySale($key,$value);
	
	  foreach( $astockItem as $stock)
	  {
	  /*DEPRICEATION */
	             $startYear = $stock['date_of_install'];
				 $alifetime = $oDepreciation->getFinYearDiff($startYear,date('Y-m-d'));
				$aDepreciation_redu = $oDepreciation->reducingBalanceDepreciation($stock['asset_amount'],$alifetime,$startYear,$stock['depressation_percent'],$stock['asset_item']);
				$aCount = count($aDepreciation_redu);
				$Dep_price =  $aDepreciation_redu[$aCount-1]['Written_Down_Value'];		
				  /*DEPRICEATION */							   
	  $item = $stock['itemgroup1_name'].'-'.$stock['itemgroup2_name'].'-'.$stock['item_name'];
	  
	  echo '<tr>
	   <td><a href="AssetInfo.php?id='.$stock['asset_item'].'" target="_blank" >'.$stock['asset_no'].'</a><input type="hidden" name="fAssetNumber[]" value="'.$stock['asset_no'].'"/></td>
	   
	  <td>'.$item.'<input type="hidden" name="fItemGroup1Id[]" value="'.$stock['id_itemgroup1'].'"/><input type="hidden" name="fItemGroup2Id[]" value="'.$stock['id_itemgroup2'].'"/><input type="hidden" name="fItemId[]" value="'.$stock['id_item'].'"/></td>
	<td>1 '.$stock['uom_name'].'<input type="hidden" name="fUomId[]" value="'.$stock['id_uom'].'"/><input type="hidden" name="fIssueQuantity[]" size="15" value="1"/><input type="hidden" name="fStockQuqntity[]" value="'.$stock['stock_quantity'].'"/></td>
	  <td>'.$stock['asset_amount'].'<input type="hidden" name="fUnitPrice[]" size="15"  value="'.$stock['asset_amount'].'"/></td>
	    <td>'.$Dep_price.'<input type="hidden" name="fDepPrice[]" size="15"  value="'.$Dep_price.'"/></td> 
	   <td><input type="text" name="fSalePrice[]" size="15"  value=""/></td>
	   <td>'.$tax.'</td>
	  <td><a href="#" id="RemoveItem" onClick="removeItem('.$stock['asset_item'].')">Remove Item</a><input type="hidden" name="fAssetItemId[]" value="'.$stock['asset_item'].'"/></td>
	  </tr>';
	  }
	   }
		}
	  }
 
?>
