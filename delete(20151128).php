<?php 
 include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
 
  $oAssetUnit = &Singleton::getInstance('AssetUnit');
  $oAssetUnit->setDb($oDb);


 $aRequest = $_REQUEST;

if($_REQUEST['data']=='Deliverylist')
{
	$delete_id = $_REQUEST['Did'];
	echo $oMaster->deleteAssetDelivery($delete_id);	
}
if($_REQUEST['data']=='delete')
{
	$item_id =  $_REQUEST['id'];
	$oItemCategory->deleteItemCategory($item_id);
}
if($_REQUEST['data']=='Unitdelete')
{
	$unit_id =  $_REQUEST['id'];
	if($oAssetUnit->deleteAssetUnit($unit_id))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
	 
}
  
if($_REQUEST['data']=='Buildingdelete')
{
	$building_id =  $_REQUEST['Bid'];
	if($oAssetBuilding->deleteBuilding($building_id))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}
if($_REQUEST['data']=='Departmentdelete')
{
	$depart_id =  $_REQUEST['Did'];
	if($oAssetDepartment->deleteDepartment($depart_id))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}
if($_REQUEST['data']=='Catdelete')
{
	$cat_id =  $_REQUEST['cid'];
	
	if($oAssetCategory->deleteCategory($cat_id))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}


if($_REQUEST['data']=='locationdelete')
{
	 $location_id =  $_REQUEST['lid'];
	
	if($oAssetLocation->deleteLocation($location_id))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}

if($_REQUEST['data']=='currencydelete')
{
	 $id_currency =  $_REQUEST['id'];
	
	if($oMaster->updateCurrency($id_currency,'delete'))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}

if($_REQUEST['data']=='portdelete')
{
	 $id_port =  $_REQUEST['id'];
	
	if($oMaster->updatePort($id_port,'delete'))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}

if($_REQUEST['data']=='uomdelete')
{
	 $id_uom =  $_REQUEST['id'];
	
	if($oMaster->updateUom($id_uom,'delete'))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}

if($_REQUEST['data']=='bankdelete')
{
	 $id_bank =  $_REQUEST['id'];
	
	if($oMaster->updateBank($id_bank,'delete'))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}


if($_REQUEST['data']=='countrydelete')
{
	 $id_country =  $_REQUEST['id'];
	
	if($oMaster->updateCountry($id_country,'delete'))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}

if($_REQUEST['data']=='statedelete')
{
	 $id_state =  $_REQUEST['id'];
	
	if($oMaster->updateState($id_state,'delete'))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}

if($_REQUEST['data']=='reasondelete')
{
	 $id =  $_REQUEST['id'];
	
	if($oMaster->updateReason($id,'delete'))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}
if($_REQUEST['data']=='faultdelete')
{
 $id =  $_REQUEST['fid'];

	if($oMaster->updateFault($id,'delete'))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}

if($_REQUEST['data']=='contactdelete')
{
 $id =  $_REQUEST['cpid'];

	if($oMaster->updateContact($id,'delete'))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}


if($_REQUEST['data']=='Vendordelete')
{
	 $vendor_id =  $_REQUEST['vid'];
	
	if($oAssetVendor->deleteVendor($vendor_id))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}
if($_REQUEST['data']=='employeedelete')
{
	 $employee_id =  $_REQUEST['eid'];
	
	if($oMaster->updateEmployee($employee_id,'','delete'))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}

if($_REQUEST['data']=='companydelete')
{
	 $company_id =  $_REQUEST['cpid'];
	
	if($oMaster->updateCompany($company_id,'','delete'))
	{
		echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
}

if($_REQUEST['stockdata']=='Stocklist')
{
	 $stock_id =  $_REQUEST['Sid'];
	
	if($result = $oMaster->deleteStockItem( $stock_id ))
	{
		
	  echo $result = '1';
	}
	else
	{
		echo $result = '0';
	}
	
}
if($action =='Fuellist')
{
	 $fuel_id =  $_REQUEST['Fid'];
	
	if($result = $oMaster->updateFuel($fuel_id,'delete' ))
	{
		
	  echo $result = '1';
	}
	else
	{
		
		echo $result = '0';
	}
}
if($action == 'Userdelete')
{
 $user_id = $aRequest['Uid'];

if($result = $oCustomer->userDelete($user_id))
	{
		
	  echo $result = '1';
	}
	else
	{
		
		echo $result = '0';
	}
}
if($_REQUEST['data']=='itemgroup1delete')
{
$tablename = 'itemgroup1';
$tablename1 = 'itemgroup2';
$field = 'id_itemgroup1';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
 if(!$oMaster->checkExist($tablename1,$field, $value))
	   {
	    	if($result =$oMaster->delete($tablename,$field,$value,$type))
						{
							
						  echo $result ;
						}
						else
						{
							
							echo $result;
						}
			}
			else
			{
			echo $result = '2';
			}
	
}
if($_REQUEST['data']=='assettypedelete')
{
$tablename = 'asset_type';
$tablename1 = 'asset_item';
$field = 'id_asset_type';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
 if(!$oMaster->checkExist($tablename1,$field, $value))
	   {
	    	if($result =$oMaster->delete($tablename,$field,$value,$type))
						{
							
						  echo $result ;
						}
						else
						{
							
							echo $result;
						}
			}
			else
			{
			echo $result = '2';
			}
	
}
if($_REQUEST['data']=='group2delete')
{
$tablename = 'itemgroup2';
$tablename1 = 'item';
$field = 'id_itemgroup2';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
 if(!$oMaster->checkExist($tablename1,$field, $value))
	   {
	    	if($result =$oMaster->delete($tablename,$field,$value,$type))
						{
							
						  echo $result ;
						}
						else
						{
							
							echo $result;
						}
			}
			else
			{
			echo $result = '2';
			}
	
}
if($_REQUEST['data']=='itemdelete')
{
$tablename = 'item';
$field = 'id_item';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
 if(!$oMaster->itemDelete($value))
	   {
	    	if($result =$oMaster->delete($tablename,$field,$value,$type))
						{
							$oMaster->delete('itemgroup_item_map',$field,$value,$type);
						  echo $result ;
						}
						else
						{
							
							echo $result;
						}
			}
			else
			{
			echo $result = '2';
			}
	
}

if($_REQUEST['data']=='prdelete')
{
$tablename = 'purchase_request';
$field = 'id_pr';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
 
if($result =$oMaster->delete($tablename,$field,$value,$type))
	{
		
	  echo $result ;
	}
	else
	{
		
		echo $result;
	}
}
if($_REQUEST['data']=='podelete')
{
$tablename = 'purchase_order';
$field = 'id_po';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
 
if($result =$oMaster->delete($tablename,$field,$value,$type))
	{
		
	  echo $result ;
	}
	else
	{
		
		echo $result;
	}
}	
if($_REQUEST['data']=='grndelete')
{
$tablename = 'inventory';
$field = 'id_inventory';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
 
if($result =$oMaster->delete($tablename,$field,$value,$type))
	{
		
	  echo $result ;
	}
	else
	{
		
		echo $result;
	}
}	
if($_REQUEST['data']=='currencydelete')
{
$tablename = 'currency';
$field = 'id_currency';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
 
if($result =$oMaster->delete($tablename,$field,$value,$type))
	{
		
	  echo $result ;
	}
	else
	{
		
		echo $result;
	}
}

		
if($_REQUEST['data']=='countrydelete')
{
$tablename = 'country';
$tablename1 = 'state';
$field = 'id_country';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
 if(!$oMaster->checkExist($tablename1,$field, $value))
	   {
	    	if($result =$oMaster->delete($tablename,$field,$value,$type))
						{
							
						  echo $result ;
						}
						else
						{
							
							echo $result;
						}
			}
			else
			{
			echo $result = '2';
			}
	
}
if($_REQUEST['data']=='statedelete')
{
$tablename = 'state';
$tablename1 = 'city';
$field = 'id_state';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
 if(!$oMaster->checkExist($tablename1,$field, $value))
	   {
	    	if($result =$oMaster->delete($tablename,$field,$value,$type))
						{
							
						  echo $result ;
						}
						else
						{
							
							echo $result;
						}
			}
			else
			{
			echo $result = '2';
			}
	
}
if($_REQUEST['data']=='citydelete')
{
$tablename = 'city';
$tablename1 = 'contact';
$field = 'id_city';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
 if(!$oMaster->checkExist($tablename1,$field, $value))
	   {
	    	if($result =$oMaster->delete($tablename,$field,$value,$type))
						{
							
						  echo $result ;
						}
						else
						{
							
							echo $result;
						}
			}
			else
			{
			echo $result = '2';
			}
	
}

if($_REQUEST['data']=='contactdelete')
{
$tablename = 'contact';
$field = 'id_contact';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
 $tablename1 = 'vendor_contact_map';
 $tablename2 = 'vendor';
 $field2 = 'id_vendor_address';
 if(!$oMaster->checkExist($tablename2,$field2, $value))
	   {
if($result =$oMaster->delete($tablename,$field,$value,$type))
	{
		$result =$oMaster->delete($tablename1,$field,$value,$type);
	    echo $result ;
	}
	else
	{
		
		echo $result;
	}
	}
			else
			{
			echo $result = '2';
			}
}

if($_REQUEST['data']=='supplierdelete')
{
$tablename = 'vendor';
$field = 'id_vendor';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
 $tablename1 = 'vendor_contact_map';
 $tablename2 = 'vendor';
 $field2 = 'id_vendor_address';
 $aChecktab = array(
		array('table' =>'pr_vendor_map','field' => 'id_vendor','value' =>$value),
		array('table' =>'purchase_request','field' => 'id_vendor','value' =>$value),
		array('table' =>'purchase_order','field' => 'id_vendor','value' =>$value),
		array('table' =>'asset_item','field' => 'id_vendor','value' =>$value),
		array('table' =>'asset_sales_invoice','field' => 'id_vendor','value' =>$value),
		array('table' =>'fuel','field' => 'id_vendor','value' =>$value),
		array('table' =>'asset_delivery','field' => 'to_id_vendor','value' =>$value),
		);
 
 if(!$oMaster->checkExistsMultiple($aChecktab))
	   {
if($result =$oMaster->delete($tablename,$field,$value,$type))
	{
		$result =$oMaster->delete($tablename1,$field,$value,$type);
	    echo $result ;
	}
	else
	{
		
		echo $result;
	}
	}
			else
			{
			echo $result = '2';
	
			}
}
if($_REQUEST['data']=='empdelete')
{
$tablename = 'employee';
$field = 'id_employee';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
  $aChecktab = array(
		array('table' =>'asset_unit','field' => $field,'value' =>$value),
		array('table' =>'asset_inspection','field' => $field,'value' =>$value),
		array('table' =>'division','field' => $field,'value' =>$value),
		array('table' =>'purchase_request','field' => $field,'value' =>$value),
		);
 
 if(!$oMaster->checkExistsMultiple($aChecktab))
	   {
if($result =$oMaster->delete($tablename,$field,$value,$type))
	{
		 echo $result ;
	}
	else
	{
		
		echo $result;
	}
	}
			else
			{
			echo $result = '2';
	
			}
}

if($_REQUEST['data']=='manufacturerdelete')
{
$tablename = 'manufacturer';
$field = 'id_manufacturer';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
  $aChecktab = array(
		array('table' =>'asset_item','field' => $field,'value' =>$value),
		array('table' =>'po_item','field' => $field,'value' =>$value),
		);
 
 if(!$oMaster->checkExistsMultiple($aChecktab))
	   {
if($result =$oMaster->delete($tablename,$field,$value,$type))
	{
		 echo $result ;
	}
	else
	{
		
		echo $result;
	}
	}
			else
			{
			echo $result = '2';
	
			}
}
if($_REQUEST['data']=='taxdelete')
{
$tablename = 'taxform';
$field = 'id_taxform';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
  $aChecktab = array(
		array('table' =>'po_tax','field' => $field,'value' =>$value),
		array('table' =>'inventory_tax','field' => $field,'value' =>$value),
		);
 
 if(!$oMaster->checkExistsMultiple($aChecktab))
	   {
if($result =$oMaster->delete($tablename,$field,$value,$type))
	{
		 echo $result ;
	}
	else
	{
		
		echo $result;
	}
	}
			else
			{
			echo $result = '2';
	
			}
}

if($_REQUEST['data']=='uomdelete')
{
$tablename = 'uom';
$field = 'id_uom';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
  $aChecktab = array(
		array('table' =>'po_item','field' => $field,'value' =>$value),
		array('table' =>'pr_item','field' => $field,'value' =>$value),
		array('table' =>'asset_item','field' => $field,'value' =>$value),
		);
 
 if(!$oMaster->checkExistsMultiple($aChecktab))
	   {
if($result =$oMaster->delete($tablename,$field,$value,$type))
	{
		 echo $result ;
	}
	else
	{
		
		echo $result;
	}
	}
			else
			{
			echo $result = '2';
	
			}
}
if($_REQUEST['data']=='termsdelete')
{
$tablename = 'terms_conditions';
$field = 'id_terms_conditions';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];

 
if($result =$oMaster->delete($tablename,$field,$value,$type))
	{
		 echo $result ;
	}
	else
	{
		
		echo $result;
	}
	
}

if($_REQUEST['data']=='assetdelete')
{
$tablename = 'asset_stock';
$field = 'id_asset_item';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
  $aChecktab = array(
		array('table' =>'asset_delivery_item','field' => $field,'value' =>$value),
		array('table' =>'pr_item','field' => $field,'value' =>$value),
		array('table' =>'asset_item','field' => $field,'value' =>$value),
		array('table' =>'transaction','field' => $field,'value' =>$value),
		array('table' =>'service','field' => $field,'value' =>$value),
		array('table' =>'service_invoice','field' => $field,'value' =>$value),
		array('table' =>'fuel','field' => $field,'value' =>$value),
		array('table' =>'trip','field' => $field,'value' =>$value),
		array('table' =>'fuel_limit','field' => $field,'value' =>$value),
		);
 
 if(!$oMaster->checkExistsMultiple($aChecktab))
	   {
if($result =$oMaster->delete($tablename,$field,$value,$type))
	{
		 echo $result ;
	}
	else
	{
		
		echo $result;
	}
	}
			else
			{
			echo $result = '2';
	
			}
}

if($_REQUEST['data']=='companydelete')
{
$tablename = 'company';
$field = 'id_company';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
  $aChecktab = array(
		array('table' =>'employee','field' => $field,'value' =>$value),
		array('table' =>'asset_delivery','field' => 'from_id_company','value' =>$value),
		);
 
 if(!$oMaster->checkExistsMultiple($aChecktab))
	   {
if($result =$oMaster->delete($tablename,$field,$value,$type))
	{
		 echo $result ;
	}
	else
	{
		
		echo $result;
	}
	}
			else
			{
			echo $result = '2';
	
			}
}
if($_REQUEST['data']=='unitdelete')
{
$tablename = 'asset_unit';
$field = 'id_unit';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
  $aChecktab = array(
		array('table' =>'asset_stock','field' => $field,'value' =>$value),
		array('table' =>'asset_item','field' => $field,'value' =>$value),
		array('table' =>'store','field' => $field,'value' =>$value),
		);
 
 if(!$oMaster->checkExistsMultiple($aChecktab))
	   {
if($result =$oMaster->delete($tablename,$field,$value,$type))
	{
		 echo $result ;
	}
	else
	{
		
		echo $result;
	}
	}
			else
			{
			echo $result = '2';
	
			}
}

if($_REQUEST['data']=='divisiondelete')
{
$tablename = 'division';
$field = 'id_division';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
  $aChecktab = array(
		array('table' =>'asset_stock','field' => $field,'value' =>$value),
		array('table' =>'store','field' => $field,'value' =>$value),
		);
 
 if(!$oMaster->checkExistsMultiple($aChecktab))
	   {
if($result =$oMaster->delete($tablename,$field,$value,$type))
	{
		 echo $result ;
	}
	else
	{
		
		echo $result;
	}
	}
			else
			{
			echo $result = '2';
	
			}
}
if($_REQUEST['data']=='storedelete')
{
$tablename = 'store';
$field = 'id_store';
 $value = $aRequest['did'];
$type =  $aRequest['msg'];
  $aChecktab = array(
		array('table' =>'asset_stock','field' => $field,'value' =>$value),
		);
 
 if(!$oMaster->checkExistsMultiple($aChecktab))
	   {
if($result =$oMaster->delete($tablename,$field,$value,$type))
	{
		 echo $result ;
	}
	else
	{
		
		echo $result;
	}
	}
			else
			{
			echo $result = '2';
	
			}
}

?>