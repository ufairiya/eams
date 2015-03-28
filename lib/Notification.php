<?php
include_once 'Master.php';

class  Notification extends Master
{
   	function __construct()
	{
		
	}
	public function setDb($oDb)
	{
	   $this->oDb = $oDb;
	}
	public function getNewPrCount()
	{
		$newPrCount = 0;
		$qry = "select count(*) as newprcount FROM purchase_request WHERE status = 1";
		if($row = $this->oDb->get_row($qry))
		{
			$newPrCount = $row->newprcount;
		}
		return $newPrCount;
	}
	
	public function getWarrantyExpireCount()
	{
	$qry ="SELECT count(asset_warranty.id_asset_item) AS to_expire_count FROM asset_warranty
	 INNER JOIN asset_item 
        ON (asset_item.id_asset_item = asset_warranty.id_asset_item)
	 WHERE DATEDIFF( asset_warranty.warranty_end_date,now())between 0 AND 7
	";
	if($row = $this->oDb->get_row($qry))
		{
			$to_expire_count = $row->to_expire_count;
		}
		return $to_expire_count;
	}
	
	public function getWarrantyExpireList()
	{
	$qry ="SELECT asset_item.id_asset_item,asset_item.asset_no,asset_warranty.warranty_end_date,DATEDIFF( asset_warranty.warranty_end_date,now()) as days FROM asset_item 
	 INNER JOIN asset_warranty 
        ON (asset_item.id_asset_item = asset_warranty.id_asset_item)
	WHERE DATEDIFF( asset_warranty.warranty_end_date,now()) between 0 AND 7";
	$aWarrantyList = array();
	if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
					$aWarrantyInfo= array();
					$aWarrantyInfo['id_asset_item'] = $row->id_asset_item;
					$aWarrantyInfo['asset_no'] = $row->asset_no;
					$aWarrantyInfo['warranty_end_date'] = $row->warranty_end_date;
					$aWarrantyInfo['days'] = $row->days;
					$aWarrantyList[] = $aWarrantyInfo;
			}
		}
		
		return $aWarrantyList;
	}
	public function getContractExpireCount()
	{
	$qry ="SELECT count(asset_contract.id_asset_item) AS to_expire_count FROM asset_contract
	 INNER JOIN asset_item 
        ON (asset_item.id_asset_item = asset_contract.id_asset_item)
	 WHERE asset_contract.status=1 and DATEDIFF( asset_contract.contract_end_date,now())between 0 AND 7
	";
	if($row = $this->oDb->get_row($qry))
		{
			$to_expire_count = $row->to_expire_count;
		}
		return $to_expire_count;
	}
	
	public function getContractExpireList()
	{
	$qry ="SELECT asset_item.id_asset_item,asset_item.asset_no,asset_contract.contract_end_date,DATEDIFF( asset_contract.contract_end_date,now()) as days FROM asset_item 
	 INNER JOIN asset_contract 
        ON (asset_item.id_asset_item = asset_contract.id_asset_item)
	WHERE asset_contract.status=1 and DATEDIFF( asset_contract.contract_end_date,now()) between 0 AND 7";
	$aContractList = array();
	if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
					$aContractInfo= array();
					$aContractInfo['id_asset_item'] = $row->id_asset_item;
					$aContractInfo['asset_no'] = $row->asset_no;
					$aContractInfo['contract_end_date'] = $row->contract_end_date;
					$aContractInfo['days'] = $row->days;
					$aContractList[] = $aContractInfo;
			}
		}
		
		return $aContractList;
	}
	public function getInsuranceExpireList()
	{
	$qry ="SELECT
   asset_insurance.id_asset
    ,insurance.ins_start_date
    ,insurance.ins_end_date
    ,insurance.renewal_date
    ,asset_item.asset_no
,DATEDIFF( insurance.ins_end_date,now()) as days 
FROM asset_insurance
    INNER JOIN insurance 
        ON (asset_insurance.id_insurance = insurance.id_insurance)
    INNER JOIN asset_item 
        ON (asset_item.id_asset_item = asset_insurance.id_asset)
		WHERE asset_insurance.status=1 and  DATEDIFF( insurance.ins_end_date,now()) between 0 AND 7
		";
	$aInsuranceList = array();
	if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
					$aInsuranceInfo= array();
					$aInsuranceInfo['id_asset_item'] = $row->id_asset;
					$aInsuranceInfo['asset_no'] = $row->asset_no;
					$aInsuranceInfo['ins_end_date'] = $row->ins_end_date;
					$aInsuranceInfo['days'] = $row->days;
					$aInsuranceList[] = $aInsuranceInfo;
			}
		}
		
		return $aInsuranceList;
	}
	
	
	
	


}//end class


?>