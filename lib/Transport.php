<?php
/**
 * 
 * 
 * $Id$
 * 
 * @author:Kmkesavan 
 */
 
 require_once('ReportClass.php');

class Transport extends ReportClass{
	
	public function __construct()
	{
		//$this->oDb = $oDb;
	}
	public function setDb($oDb)
	{
		$this->oDb = $oDb;
	}
	public function isLoggedIn()
	{
		//echo $_SESSION['LOGIN'];
		return $_SESSION['LOGIN'];
	}
	
	/*Functions for either selections of any of three dropdown in fuel report*/
	public function getFuelTokenInfoAll($aRequest)
	{
		$aCheck = $aRequest['fCheck'];
		$id_item = explode("/",$aRequest['fItemName']);
		$id_asset_item =$id_item[0]; 	 
		$lookup = $id_asset_item;
		$id_group1 = $aRequest['fGroup1'];
		$id_group2 = $aRequest['fItemGroup2'];
		
		$condition = '';
		if($aRequest['fStartDate'] !='' || $aRequest['fEndDate'] !='')
		{
		$start_date =date('Y-m-d',strtotime($aRequest['fStartDate']));
		$end_date = date('Y-m-d',strtotime($aRequest['fEndDate']));
		$condition = "  and  fuel_token.token_date between '".$start_date."' and '".$end_date."'";
		}
		else { $start_date = ''; $end_date = '';}
		
		if(($id_group1 != '' && $id_group1 != '0') && ($id_group2 != '' && $id_group2 != '0'))
		{
			$where ="asset_item.id_itemgroup1 ='$id_group1' AND asset_item.id_itemgroup2 ='$id_group2'";
		}
		if(($id_group1 != '' && $id_group1 != '0') && ($id_group2 == '' || $id_group2 == '0'))
		{
			$where = "asset_item.id_itemgroup1 ='$id_group1'";
		}
		if(($id_group1 != '' && $id_group1 != '0') && ($id_group2 != '' && $id_group2 != '0') && ($aRequest['fItemName'] != '' && $aRequest['fItemName'] != '0')) 
		{
			$where = "asset_item.id_asset_item ='$lookup'";
		}
			
		$qry ="SELECT
    asset_item.machine_no
    , asset_item.asset_no
    , asset_item.warranty_start_date
    , asset_item.warranty_end_date
    , asset_item.id_asset_item
	, asset_item.id_inventory_item

    , fuel_token.id_fuel_token
    , fuel_token.token_no
	, fuel_token.token_date
    , fuel_token.qty
    , fuel_token.oil_qty
    , fuel_token.id_asset_item
    , fuel_token.id_fuel_type
    , fuel_token.id_vendor
    , fuel_token.id_trip
    , fuel_token.remarks
    , fuel_token.status
	, trip.omr
    , trip.id_trip
    , trip.cmr
FROM
    asset_item
    INNER JOIN  fuel_token 
        ON (asset_item.id_asset_item = fuel_token.id_asset_item)
		INNER JOIN trip 
        ON (fuel_token.id_trip = trip.id_trip)
        WHERE ".$where." ORDER BY asset_item.machine_no";
		
			if($aCheck[0] == 'Fuel')
			{
			$qry = $qry.$condition;
			}			
			
		$results = $this->oDb->get_results($qry);
		$aFuelInfoList = array();
		//$aAssetInfo = array();
		foreach($results as $row)
		{
		$aFuelInfo = array();
		
		$aFuelInfo['token_date'] = $row->token_date;
		$aFuelInfo['id_asset_item'] = $row->id_asset_item;
		$aFuelInfo['asset_no'] = $row->asset_no;
		$aFuelInfo['machine_no'] = $row->machine_no;
		$aFuelInfo['id_fuel_token'] = $row->id_fuel_token;
		$aFuelInfo['token_no'] = $row->token_no;
		$aFuelInfo['qty'] = $row->qty;
		$aFuelInfo['oil_qty'] = $row->oil_qty;
		$aFuelInfo['id_fuel_type'] = $row->id_fuel_type;
		$aFuelInfo['id_vendor'] = $row->id_vendor;
		$aFuelInfo['id_trip'] = $row->id_trip;
		$aFuelInfo['remarks'] = $row->remarks;
		$aFuelInfo['status'] = $row->status;
		$aFuelInfo['omr'] = $row->omr;
		$aFuelInfo['cmr'] = $row->cmr;
		$aFuelInfo['warranty_start_date'] = $row->warranty_start_date;
		$aFuelInfo['warranty_end_date'] = $row->warranty_end_date;
		$aFuelInfoList[] = $aFuelInfo;	
		}
		return $aFuelInfoList;
	}
		
	public function getFuelInfoallItems($aRequest)
	{
	$aCheck = $aRequest['fCheck'];
	$id_item = explode("/",$aRequest['fItemName']);
	$id_asset_item =$id_item[0]; 	 
	$lookup = $id_asset_item;
	$id_group1 = $aRequest['fGroup1'];
	$id_group2 = $aRequest['fItemGroup2'];
	
	$condition = '';
	if($aRequest['fStartDate'] !='' || $aRequest['fEndDate'] !='')
	{
	$start_date =date('Y-m-d',strtotime($aRequest['fStartDate']));
	$end_date = date('Y-m-d',strtotime($aRequest['fEndDate']));
	$condition = "  and  fuel.bill_date between '".$start_date."' and '".$end_date."'";
	}
	else { $start_date = ''; $end_date = '';}
	
	if(($id_group1 != '' && $id_group1 != '0') && ($id_group2 != '' && $id_group2 != '0'))
	{
		$where ="asset_item.id_itemgroup1 ='$id_group1' AND asset_item.id_itemgroup2 ='$id_group2'";
	}
	if(($id_group1 != '' && $id_group1 != '0') && ($id_group2 == '' || $id_group2 == '0'))
	{
		$where = "asset_item.id_itemgroup1 ='$id_group1'";
	}
	if(($id_group1 != '' && $id_group1 != '0') && ($id_group2 != '' && $id_group2 != '0') && ($aRequest['fItemName'] != '' && $aRequest['fItemName'] != '0')) 
	{
		$where = "asset_item.id_asset_item ='$lookup'";
	}
	
	$assetqry ="SELECT
    asset_item.machine_no
    , asset_item.asset_no
    , asset_item.warranty_start_date
    , asset_item.warranty_end_date
    , asset_item.id_asset_item
	, asset_item.id_inventory_item FROM
    asset_item WHERE ".$where."";
	
	$result = $this->oDb->get_results($assetqry);
		
	$aAssetInfo = array();
	$aAssetInfores = array();
	foreach($result as $row)
	{
	$aAssetInfo['machine_no'] = strtoupper($row->machine_no);
	$aAssetInfo['asset_no'] = $row->asset_no;
	$aAssetInfo['warranty_start_date'] = $row->warranty_start_date;
	$aAssetInfo['warranty_end_date'] = $row->warranty_end_date;
	$aAssetInfo['id_asset_item'] = $row->id_asset_item;
	$aAssetInfo['id_inventory_item'] = $row->id_inventory_item;
	if($row->id_inventory_item > 0)
			{
			$aAssetItems =$this->getAssetImage($row->id_inventory_item);
			$aAssetInfo['asset_image'] = $aAssetItems['image'];
			$aAssetInfo['id_image'] = $aAssetItems['id_image'];
			}
			else
			{
			$aAssetItems =$this->getAssetImage($row->id_asset_item,'assetid');
			$aAssetInfo['asset_image'] = $aAssetItems['image'];
			$aAssetInfo['id_image'] = $aAssetItems['id_image'];
			}
			$aAssetInfores[] =  $aAssetInfo;
	}
	
	
	$qry ="SELECT
    asset_item.machine_no
    , asset_item.asset_no
    , asset_item.warranty_start_date
    , asset_item.warranty_end_date
    , asset_item.id_asset_item
	, asset_item.id_inventory_item
    , fuel.bill_no
    , fuel.bill_date
    , fuel.id_fuel
    , fuel.token_no
    , fuel.payment_type
    , fuel.bill_amount
    , fuel.total_price
    , fuel.qty
    , fuel.id_uom
    , fuel.unit_price
    , fuel.net_amount
    , fuel.id_asset_item
    , fuel.id_fuel_type
    , fuel.id_vendor
    , fuel.id_trip
    , fuel.remarks
    , fuel.status
	, trip.omr
    , trip.id_trip
    , trip.cmr
FROM
    asset_item
    INNER JOIN  fuel 
        ON (asset_item.id_asset_item = fuel.id_asset_item)
		INNER JOIN trip 
        ON (fuel.id_trip = trip.id_trip)
		WHERE ".$where." ORDER BY asset_item.machine_no";
		
	if($aCheck[0] == 'Fuel')
			{
			$qry = $qry.$condition;
			}
			$results = $this->oDb->get_results($qry);
			$aFuelInfoList = array();
			//$aAssetInfo = array();
			foreach($results as $row)
			{
			$aFuelInfo = array();
			$aFuelInfo['bill_no'] = $row->bill_no;
			$aFuelInfo['bill_date'] = $row->bill_date;
			$aFuelInfo['bill_amount'] = $row->bill_amount;
			$aFuelInfo['id_fuel'] = $row->id_fuel;
			$aFuelInfo['token_no'] = $row->token_no;
			$aFuelInfo['payment_type'] = $row->payment_type;
			$aFuelInfo['total_price'] = $row->total_price;
			$aFuelInfo['qty'] = $row->qty;
			$aFuelInfo['id_uom'] = $row->id_uom;
			$aFuelInfo['unit_price'] = $row->unit_price;
			$aFuelInfo['net_amount'] = $row->net_amount;
			$aFuelInfo['id_fuel_type'] = $row->id_fuel_type;
			$aFuelInfo['id_vendor'] = $row->id_vendor;
			$aFuelInfo['id_trip'] = $row->id_trip;
			$aFuelInfo['remarks'] = $row->remarks;
			$aFuelInfo['status'] = $row->status;
			$aFuelInfo['omr'] = $row->omr;
			$aFuelInfo['cmr'] = $row->cmr;
				
			if($aCheck[0] == 'Fuel')
					{
					$aFuelInfoList['fuelinfo'][] = $aFuelInfo;
					}
			}
			$lookup = '';
			$aFuelInfoList['assetinfo'][] = $aAssetInfores;
			if($aCheck[0] == 'Service' || $aCheck[1] == 'Service')
			{
			$aFuelInfoList['serviceinfo'] = $this->getServiceInfo($lookup);
			}
			return $aFuelInfoList ;
	}
	
	public function getServiceInfo($lookup)
	{
	$qry = "
	 SELECT
    trip.omr
    , trip.id_trip
    , trip.cmr
    , service.service_no
    , service.id_itemgroup1
    , service.id_itemgroup2
    , service.id_item
    , service.id_vendor
    , service.id_asset_item
    , service.mileage_at_service
    , service.mileage_after_service
    , service.service_date
    , service.service_return_date
    , service.bill_number
    , service.bill_date
    , service.bill_amount
    , service.service_type
    , service.idledays
    , service.next_service_date
    , service.next_service_mileage
    , service.status
    , asset_item.machine_no
    , asset_item.warranty_start_date
    , asset_item.warranty_end_date
    , asset_item.asset_no
FROM
    trip
    INNER JOIN asset_item 
        ON (trip.id_asset_item = asset_item.id_asset_item)
    INNER JOIN service 
        ON (service.id_service = trip.id_service)
           WHERE asset_item.id_asset_item ='$lookup';   
   	";
	$results = $this->oDb->get_results($qry);
	$aServiceInfoList = array();
	
	foreach($results as $row)
	{
	$aServiceInfo= array();
	$aServiceInfo['service_no'] = $row->service_no;
	$aServiceInfo['id_vendor'] = $row->id_vendor;
	$aServiceInfo['id_asset_item'] = $row->id_asset_item;
	$aServiceInfo['mileage_at_service'] = $row->mileage_at_service;
	$aServiceInfo['mileage_after_service'] = $row->mileage_after_service;
	$aServiceInfo['service_date'] = $row->service_date;
	$aServiceInfo['service_return_date'] = $row->service_return_date;
	$aServiceInfo['bill_number'] = $row->bill_number;
	$aServiceInfo['bill_date'] = $row->bill_date;
	$aServiceInfo['bill_amount'] = $row->bill_amount;
	$aServiceInfo['service_type'] = $row->service_type;
	$aServiceInfo['next_service_date'] = $row->next_service_date;
	$aServiceInfo['next_service_mileage'] = $row->next_service_mileage;
	$aServiceInfo['vendor_name'] = $this->getVendorName($row->id_vendor);
	$aServiceInfoList[] = $aServiceInfo;
	}
	return $aServiceInfoList;
	}
	
	public function getFuelQty($fueltype,$tokennumber)
	{
		$fuelqty ="SELECT qty FROM fuel_token WHERE id_fuel_type ='$fueltype' AND token_no = '$tokennumber'";
	
		$resultfuelqty = $this->oDb->get_results($fuelqty);
		return $resultfuelqty; 
	}
		
}//end class