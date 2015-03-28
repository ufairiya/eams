<?php
/**
 * 
 * 
 * $Id$
 * 
 * @author 
 */
class ReportClass {
	
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
	public function getItemInfo($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	   $qry = "SELECT id_item, item_name, lookup,id_itemgroup2, status FROM item WHERE ";
	   if($type == 'lookup') {
	   	 $condition = " lookup = '$lookup'";
	   }
	   else {
	     $condition = " id_item = ".$lookup;
	   }
	   $qry = $qry.$condition;
	   $aItem = array();
	   if($row = $this->oDb->get_row($qry))
	   {
		$aItem['id_item']   = $row->id_item;
		$aItem['item_name'] = strtoupper($row->item_name);
		$aItem['lookup']    = strtoupper($row->lookup);
		$aItem['id_itemgroup2']    = strtoupper($row->id_itemgroup2);
		$aItem['status']    = $row->status;		  
	   }
	   return $aItem;
	   
	}  
		
	public function getAssetImage($lookup,$type=null)
	{
		if($type == 'assetid')
		{
			$qrys = "SELECT * FROM asset_image WHERE status!=2 and id_asset_item=".$lookup;			
			} else {
		$qrys = "SELECT * FROM asset_image WHERE status!=2 and id_inventory_item=".$lookup;
			}
				 $results = $this->oDb->get_results($qrys);
				foreach($results as $row)
				{
				$assetImage = array();
				$assetImage['id_image'] = $row->id_image;
				$assetImage['image'] = $row->image_path;
				}
				return $assetImage;
	}
	
	public function getAllAssetImages($lookup,$type=null)
	{
		if($type == 'assetid')
		{
			$qrys = "SELECT * FROM asset_image WHERE status != 2 and id_asset_item = ".$lookup;			
		} 
		else 
		{
		   $qrys = "SELECT * FROM asset_image WHERE status != 2 and id_inventory_item = ".$lookup;
		}
				$results = $this->oDb->get_results($qrys);
				$aAssetImageList = array();
				foreach($results as $row)
				{
				  $aImage = array();
				  $aImage['id_image']   = $row->id_image;
				  $aImage['image_path'] = $row->image_path;
				  $aAssetImageList[] = $aImage;
				}
				return $aAssetImageList;
	}//
	public function getAssetFirstImage($lookup,$type=null)
	{
		if($type == 'assetid')
		{
		   $qrys = "SELECT * FROM asset_image WHERE status != 2 and id_asset_item = ".$lookup. " limit 1 ";			
		} 
		else 
		{
		   $qrys = "SELECT * FROM asset_image WHERE status != 2 and id_inventory_item = ".$lookup. " limit 1 ";
		}
						
				$aImage = array();
				if($row = $this->oDb->get_row($qrys))
				{
				  $aImage['id_image']   = $row->id_image;
				  $aImage['image_path'] = $row->image_path; 
				}
				return $aImage;
	}//	
	
	public function stockReportList($aRequest,$type='', $offset='', $rowsPerPage='', $field='', $sort='' )
	{
	
		$condition = ''; $limit = ''; $orderBy = '';
	$qry = "SELECT
    item.item_name
    , itemgroup2.itemgroup2_name
    , itemgroup1.id_itemgroup1
    , asset_unit.unit_name
    , asset_item.machine_no
    , asset_item.asset_no
    , asset_item.id_asset_item
    , asset_item.id_inventory_item
     , itemgroup1.itemgroup1_name
     , asset_item.status,store.store_name,
	asset_item. machine_date,
	asset_stock.id_division
FROM
    asset_item
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item = asset_stock.id_asset_item)
    INNER JOIN itemgroup1 
        ON (asset_item.id_itemgroup1 = itemgroup1.id_itemgroup1)
    INNER JOIN asset_unit 
        ON (asset_item.id_unit = asset_unit.id_unit)
    INNER JOIN itemgroup2 
        ON (asset_item.id_itemgroup2 = itemgroup2.id_itemgroup2)
    INNER JOIN item 
        ON (asset_item.asset_name = item.id_item)
		INNER JOIN store 
        ON (asset_stock.id_store = store.id_store)
WHERE 
    ";
	$id_unit = $aRequest['fUnitId'];
	$id_store = $aRequest['fStoreId'];
	$id_itemGtoup1 = $aRequest['fGroup1'];
	$id_itemGtoup2 = $aRequest['fGroup2'];
	$id_item = $aRequest['fItemName'];
	if($aRequest['fStartDate'] !='' || $aRequest['fEndDate'] !='')
	{
	$start_date =date('Y-m-d',strtotime($aRequest['fStartDate']));
	$end_date = date('Y-m-d',strtotime($aRequest['fEndDate']));
	}
	$filter = '';
	if($id_unit != null)
	{
		$filter.= "  asset_stock.id_unit=".$id_unit;
	}
	if($id_store != null)
	{
		if($id_unit != null)
		{
			$filter.= ' AND ';
		}
		$filter.= "  asset_stock.id_store =".$id_store;
	}
	if($id_itemGtoup1 != null )
	{
		if($id_store != null || $id_unit !=null )
		{
			$filter.= ' AND ';
		}
		$filter.= "  itemgroup1.id_itemgroup1 =".$id_itemGtoup1;
	}
	if($id_itemGtoup2 != null )
	{
		if($id_store != null || $id_unit !=null || $id_itemGtoup1 != null )
		{
			$filter.= ' AND ';
		}
		$filter.= "  itemgroup2.id_itemgroup2 =".$id_itemGtoup2;
	}
		if($id_item != null )
	{
		if($id_store != null || $id_unit !=null || $id_itemGtoup1 != null || $id_itemGtoup2 != null )
		{
			$filter.= ' AND ';
		}
		$filter.= "   asset_item.asset_name =".$id_item;
	}
	if($start_date != null && $end_date !=null)
	{
		if($id_store != null || $id_unit !=null || $id_itemGtoup1 != null || $id_itemGtoup2 != null || $id_item != null)
		{
			$filter.= ' AND ';
		}
		$filter.= "   asset_item.machine_date between '".$start_date."' and '".$end_date."'";
	}
	if(!empty($rowsPerPage))
		{
			$limit 	= "LIMIT $offset, $rowsPerPage";
		}
		if(!empty($field))
		{
			$orderBy 		= " ORDER BY ".$field." ".$sort." ";
		}
		else $orderBy = " GROUP BY asset_item.id_asset_item ASC ";
	$query = $qry.$filter.$orderBy.$limit;
	
	 if($type =='count')
	 {
		
		if($this->oDb->query($query))
		{
		
		$num_rows = $this->oDb->num_rows;
		}
		return $num_rows;
	 }
	 else {
	$aStockReportList = array();
		if($result = $this->oDb->get_results($query))
		{
			foreach($result as $row)
			{
				$aStockReport = array();
				$aStockReport['id_itemgroup1'] = $row->id_itemgroup1;
				
				$aStockReport['itemgroup1_name']   = $row->itemgroup1_name;
				$aStockReport['itemgroup2_name'] = $row->itemgroup2_name;
				$aStockReport['item_name']    =$row->item_name;
				$aStockReport['machine_no']  = strtoupper($row->machine_no);
				$aStockReport['asset_no']    = $row->asset_no;
				$aStockReport['unit_name']    = $row->unit_name;
				$aStockReport['id_division']    = $row->id_division;
				$aStockReport['division_name']    =$this->getDivisionName($row->id_division);
				$aStockReport['store_name']    = $row->store_name;
				$aStockReport['stock_quantity']    = $row->stock_quantity;
				if($row->id_inventory_item > 0)
				{
				$aAssetItems =$this->getAssetImage($row->id_inventory_item);
				$aStockReport['asset_image'] = $aAssetItems['image'];
				$aStockReport['id_image'] = $aAssetItems['id_image'];
				}
				else
				{
				$aAssetItems =$this->getAssetImage($row->id_asset_item,'assetid');
				$aStockReport['asset_image'] = $aAssetItems['image'];
				$aStockReport['id_image'] = $aAssetItems['id_image'];
				}
					$aStockReport['machine_date']    =date('d-m-Y',strtotime($row->machine_date));			
				$aStockReport['status']    = $row->status;
				$aStockReportList[]        = $aStockReport;
			}
		}
		return $aStockReportList;	
		}
	}
	
	
	public function DetailReportList($aRequest,$type='', $offset='', $rowsPerPage='', $field='', $sort='' )
	{
	
		$condition = ''; $limit = ''; $orderBy = '';
	$qry = "SELECT
    item.item_name
    , itemgroup2.itemgroup2_name
    , itemgroup1.id_itemgroup1
    , asset_unit.unit_name
    , asset_item.machine_no
    , asset_item.asset_no
    , asset_item.id_asset_item
    , asset_item.id_inventory_item
     , itemgroup1.itemgroup1_name
     , asset_item.status,store.store_name,
	asset_item. machine_date,
	asset_stock.id_division
FROM
    asset_item
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item = asset_stock.id_asset_item)
    INNER JOIN itemgroup1 
        ON (asset_item.id_itemgroup1 = itemgroup1.id_itemgroup1)
    INNER JOIN asset_unit 
        ON (asset_item.id_unit = asset_unit.id_unit)
    INNER JOIN itemgroup2 
        ON (asset_item.id_itemgroup2 = itemgroup2.id_itemgroup2)
    INNER JOIN item 
        ON (asset_item.asset_name = item.id_item)
		INNER JOIN store 
        ON (asset_stock.id_store = store.id_store)
WHERE asset_item.status!=2  
    ";
	$criteria = $aRequest['fCriteria'];
	$searchType = $aRequest['fSearchType'];
	$id_unit = $aRequest['fUnitId'];
	$id_store = $aRequest['fStoreId'];
	$id_itemGtoup1 = $aRequest['fGroup1'];
	$id_itemGtoup2 = $aRequest['fGroup2'];
	$id_item = $aRequest['fItemName'];
	if($aRequest['fDateRange'] !='')
	{
	$daterange = explode("/",$aRequest['fDateRange']);
	$start_date =date('Y-m-d',strtotime($daterange[0]));
	$end_date = date('Y-m-d',strtotime($daterange[1]));
	}
	$filter = ' AND';
	if($id_unit != null)
	{
		$filter.= "  asset_stock.id_unit=".$id_unit;
	}
	if($id_store != null)
	{
		if($id_unit != null)
		{
			$filter.= ' AND ';
		}
		$filter.= "  asset_stock.id_store =".$id_store;
	}
	if($id_itemGtoup1 != null )
	{
		if($id_store != null || $id_unit !=null )
		{
			$filter.= ' AND ';
		}
		$filter.= "  itemgroup1.id_itemgroup1 =".$id_itemGtoup1;
	}
	if($id_itemGtoup2 != null )
	{
		if($id_store != null || $id_unit !=null || $id_itemGtoup1 != null )
		{
			$filter.= ' AND ';
		}
		$filter.= "  itemgroup2.id_itemgroup2 =".$id_itemGtoup2;
	}
		if($id_item != null )
	{
		if($id_store != null || $id_unit !=null || $id_itemGtoup1 != null || $id_itemGtoup2 != null )
		{
			$filter.= ' AND ';
		}
		$filter.= "   asset_item.asset_name =".$id_item;
	}
	if($start_date != null && $end_date !=null)
	{
		if($id_store != null || $id_unit !=null || $id_itemGtoup1 != null || $id_itemGtoup2 != null || $id_item != null)
		{
			$filter.= ' AND ';
		}
		$filter.= "   asset_item.created_on between '".$start_date."' and '".$end_date."'";
	}
	if(!empty($rowsPerPage))
		{
			$limit 	= "LIMIT $offset, $rowsPerPage";
		}
		if(!empty($field))
		{
			$orderBy 		= " ORDER BY ".$field." ".$sort." ";
		}
		else $orderBy = " GROUP BY asset_item.id_asset_item ASC ";
	   $query = $qry.$filter.$orderBy.$limit;

	 switch($type)
	 {
	 
	 	case 'count' :
						if($this->oDb->query($query))
						{
						$num_rows = $this->oDb->num_rows;
						}
		return $num_rows;
		       break;
			   
	   case 'list' :
	   $aStockReportList = array();
		if($result = $this->oDb->get_results($query))
		{
			foreach($result as $row)
			{
				$aStockReport = array();
				$aStockReport['itemgroup1_name']   = $row->itemgroup1_name;
				$aStockReport['itemgroup2_name'] = $row->itemgroup2_name;
				$aStockReport['item_name']    =$row->item_name;
				$aStockReport['machine_no']  = strtoupper($row->machine_no);
				$aStockReport['asset_no']    = $row->asset_no;
				$aStockReport['unit_name']    = $row->unit_name;
				$aStockReport['id_division']    = $row->id_division;
				$aStockReport['division_name']    =$this->getDivisionName($row->id_division);
				$aStockReport['store_name']    = $row->store_name;
				$aStockReport['stock_quantity']    = $row->stock_quantity;
				if($row->id_inventory_item > 0)
				{
				$aAssetItems =$this->getAssetImage($row->id_inventory_item);
				$aStockReport['asset_image'] = $aAssetItems['image'];
				$aStockReport['id_image'] = $aAssetItems['id_image'];
				}
				else
				{
				$aAssetItems =$this->getAssetImage($row->id_asset_item,'assetid');
				$aStockReport['asset_image'] = $aAssetItems['image'];
				$aStockReport['id_image'] = $aAssetItems['id_image'];
				}
					$aStockReport['machine_date']    =date('d-m-Y',strtotime($row->machine_date));			
				$aStockReport['status']    = $row->status;
				$aStockReportList[]        = $aStockReport;
			}
		}
		return $aStockReportList;	
	          break;
		default :
		
		 $aStockReportList = array();
		if($result = $this->oDb->get_results($query))
		{
			foreach($result as $row)
			{
				$aStockReport = array();
				$aStockReport['itemgroup1_name']   = $row->itemgroup1_name;
				$aStockReport['itemgroup2_name'] = $row->itemgroup2_name;
				$aStockReport['item_name']    =$row->item_name;
				$aStockReport['machine_no']  = strtoupper($row->machine_no);
				$aStockReport['asset_no']    = $row->asset_no;
				$aStockReport['unit_name']    = $row->unit_name;
				$aStockReport['id_division']    = $row->id_division;
				$aStockReport['division_name']    =$this->getDivisionName($row->id_division);
				$aStockReport['store_name']    = $row->store_name;
				$aStockReport['stock_quantity']    = $row->stock_quantity;
				if($row->id_inventory_item > 0)
				{
				$aAssetItems =$this->getAssetImage($row->id_inventory_item);
				$aStockReport['asset_image'] = $aAssetItems['image'];
				$aStockReport['id_image'] = $aAssetItems['id_image'];
				}
				else
				{
				$aAssetItems =$this->getAssetImage($row->id_asset_item,'assetid');
				$aStockReport['asset_image'] = $aAssetItems['image'];
				$aStockReport['id_image'] = $aAssetItems['id_image'];
				}
					$aStockReport['machine_date']    =date('d-m-Y',strtotime($row->machine_date));			
				$aStockReport['status']    = $row->status;
				$aStockReportList[]        = $aStockReport;
			}
		}
		return $aStockReportList;	
		break;	  
	 }
	
	}
	
	
	
	public function idleStockReportList($aRequest, $offset='', $rowsPerPage='', $field='', $sort='' )
	{
	$condition = ''; $limit = ''; $orderBy = '';
	$qry = "SELECT
    asset_unit.unit_name
    , asset_item.machine_no
	 , asset_item.id_itemgroup1
	  , asset_item.id_itemgroup2
	   , asset_item.asset_name
    , asset_item.asset_no
    , asset_item.id_asset_item
    , asset_item.id_inventory_item
      , asset_item.status,store.store_name,
	asset_item. created_on,
	asset_stock.id_division,
	DATEDIFF(now(), asset_item.created_on) as idle_days
	
FROM
    asset_item
	 INNER JOIN asset_unit 
        ON (asset_item.id_unit = asset_unit.id_unit)
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item = asset_stock.id_asset_item)
    INNER JOIN store 
        ON (asset_stock.id_store = store.id_store)
WHERE  asset_stock.id_division = 0    ";
	$id_unit = $aRequest['fUnitId'];
	$id_store = $aRequest['fStoreId'];
	$id_itemGtoup1 = $aRequest['fGroup1'];
	$id_itemGtoup2 = $aRequest['fGroup2']; 
	$id_item = $aRequest['fItemName'];
	$idle_days = $aRequest['fIdledays'];
	$oper = $aRequest['fOperation'];
	if($aRequest['fStartDate'] !='' || $aRequest['fEndDate'] !='')
	{
	$start_date =date('Y-m-d',strtotime($aRequest['fStartDate']));
	$end_date = date('Y-m-d',strtotime($aRequest['fEndDate']));
	}
	if($id_store != null ||  $id_itemGtoup1 != null || $id_itemGtoup2 != null || $id_item != null || $idle_days!=null)
	{
	$filter = 'AND';
	}
	else
	{
	$filter = '';
	}
	if($id_store != null)
	{
		
		$filter.= "  asset_stock.id_store ='$id_store'";
	}
	if($id_itemGtoup1 != null )
	{
		if($id_store != null  )
		{
			$filter.= ' AND ';
		}
		$filter.= "  asset_item.id_itemgroup1 ='$id_itemGtoup1'";
	}
	if($id_itemGtoup2 !='')
	{
	
		if($id_store != null ||  $id_itemGtoup1 != null )
		{
			$filter.= ' AND ';
		}
		$filter.= "  asset_item.id_itemgroup2 ='$id_itemGtoup2'";
	}
		if($id_item != '' )
	{
		if($id_store != null ||  $id_itemGtoup1 != null || $id_itemGtoup2 != null )
		{
			$filter.= ' AND ';
		}
		$filter.= "   asset_item.asset_name ='$id_item'";
	}
	if($start_date != null && $end_date !=null)
	{
		if($id_store != null ||  $id_itemGtoup1 != null || $id_itemGtoup2 != null || $id_item != null)
		{
			$filter.= ' AND ';
		}
		$filter.= "   asset_item.created_on between '".$start_date."' and '".$end_date."'";
	}
	if(!empty($idle_days))
	{
	$filter.= " DATEDIFF(now(), asset_item.created_on) $oper  $idle_days ";
	}
	if(!empty($rowsPerPage))
		{
			$limit 	= "LIMIT $offset, $rowsPerPage";
		}
		if(!empty($field))
		{
			$orderBy 		= " ORDER BY ".$field." ".$sort." ";
		}
		else $orderBy = " GROUP BY asset_item.id_asset_item   ASC ";
	 $query = $qry.$filter.$orderBy.$limit;
	
	$aStockReportList = array();
		if($result = $this->oDb->get_results($query))
		{
			foreach($result as $row)
			{
				$aStockReport = array();
				$aStockReport['itemgroup1_name']   =$this->getItemGroup1Name($row->id_itemgroup1);
				$aStockReport['itemgroup2_name'] = $this->getItemGroup2Name($row->id_itemgroup2);
				$aStockReport['item_name']    =$this->getItemName($row->asset_name);
				$aStockReport['machine_no']  = strtoupper($row->machine_no);
				$aStockReport['asset_no']    = $row->asset_no;
				$aStockReport['unit_name']    = $row->unit_name;
				$aStockReport['idle_days']    = $row->idle_days;
				$aStockReport['id_division']    = $row->id_division;
				$aStockReport['division_name']    =$this->getDivisionName($row->id_division);
				$aStockReport['store_name']    = $row->store_name;
				$aStockReport['stock_quantity']    = $row->stock_quantity;
				if($row->id_inventory_item > 0)
				{
				$aAssetItems =$this->getAssetImage($row->id_inventory_item);
				$aStockReport['asset_image'] = $aAssetItems['image'];
				$aStockReport['id_image'] = $aAssetItems['id_image'];
				}
				else
				{
				$aAssetItems =$this->getAssetImage($row->id_asset_item,'assetid');
				$aStockReport['asset_image'] = $aAssetItems['image'];
				$aStockReport['id_image'] = $aAssetItems['id_image'];
				}
					$aStockReport['machine_date']    =date('d-m-Y',strtotime($row->machine_date));			
				$aStockReport['status']    = $row->status;
				$aStockReportList[]        = $aStockReport;
			}
		}
		return $aStockReportList;	
	}
	public function idleStockReportListCount($aRequest,$offset='', $rowsPerPage='', $field='', $sort='' )
	{
		
		$condition = ''; $limit = ''; $orderBy = '';
	
	$qry = "SELECT
    asset_unit.unit_name
    , asset_item.machine_no
    , asset_item.asset_no
	 , asset_item.id_itemgroup1
	  , asset_item.id_itemgroup2
	   , asset_item.asset_name
    , asset_item.id_asset_item
    , asset_item.id_inventory_item
      , asset_item.status,store.store_name,
	asset_item. created_on,
	asset_stock.id_division,
	DATEDIFF(now(), asset_item.created_on) as idle_days
FROM
    asset_item
	 INNER JOIN asset_unit 
        ON (asset_item.id_unit = asset_unit.id_unit)
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item = asset_stock.id_asset_item)
    INNER JOIN store 
        ON (asset_stock.id_store = store.id_store)
WHERE  asset_stock.id_division = 0  ";
	$id_unit = $aRequest['fUnitId'];
	$id_store = $aRequest['fStoreId'];
	$id_itemGtoup1 = $aRequest['fGroup1'];
	$id_itemGtoup2 = $aRequest['fGroup2'];
	$id_item = $aRequest['fItemName'];
	$idle_days = $aRequest['fIdledays'];
	$oper = $aRequest['fOperation'];
	if($aRequest['fStartDate'] !='' || $aRequest['fEndDate'] !='')
	{
	$start_date =date('Y-m-d',strtotime($aRequest['fStartDate']));
	$end_date = date('Y-m-d',strtotime($aRequest['fEndDate']));
	}
	if($id_store != null ||  $id_itemGtoup1 != null || $id_itemGtoup2 != null || $id_item != null || $idle_days!=null)
	{
	$filter = 'AND';
	}
	else
	{
	$filter = '';
	}
	if($id_store != null)
	{		
		$filter.= "  asset_stock.id_store ='$id_store'";
	}
	if($id_itemGtoup1 != null )
	{
		if($id_store != null  )
		{
			$filter.= ' AND ';
		}
		$filter.= "  asset_item.id_itemgroup1 ='$id_itemGtoup1'";
	}
	if($id_itemGtoup2 != null )
	{
		if($id_store != null ||  $id_itemGtoup1 != null )
		{
			$filter.= ' AND ';
		}
		$filter.= "  asset_item.id_itemgroup2 ='$id_itemGtoup2'";
	}
	if($id_item != null )
	{
		if($id_store != null || $id_itemGtoup1 != null || $id_itemGtoup2 != null )
		{
			$filter.= ' AND ';
		}
		$filter.= "   asset_item.asset_name ='$id_item'";
	}
	if($start_date != null && $end_date !=null)
	{
		if($id_store != null ||  $id_itemGtoup1 != null || $id_itemGtoup2 != null || $id_item != null)
		{
			$filter.= ' AND ';
		}
		$filter.= "   asset_item.machine_date between '".$start_date."' and '".$end_date."'";
	}
	 if(!empty($idle_days))
	{
	$filter.= " DATEDIFF(now(), asset_item.created_on) $oper $idle_days ";
	}
	 if(!empty($rowsPerPage))
		{
			$limit 	= "LIMIT $offset, $rowsPerPage";
		}
		if(!empty($field))
		{
			$orderBy 		= " ORDER BY ".$field." ".$sort." ";
		}
		else $orderBy = " GROUP BY asset_item.id_asset_item ASC ";
	  $query = $qry.$filter.$orderBy.$limit;
	
	$aStockReportList = array();
	 if($this->oDb->query($query))
	 {
	 $num_rows = $this->oDb->num_rows;
	}
	return $num_rows;
		
	}
	
	/*public function searchStock($aRequest)
	{
	$id_unit = $aRequest['fUnitId'];
	$id_store = $aRequest['fStoreId'];
	$id_itemGtoup1 = $aRequest['fGroup1'];
	$id_itemGtoup2 = $aRequest['fGroup2'];
	$id_item = $aRequest['fItemName'];
		
		$qry = "SELECT 
		GROUP_CONCAT(CONCAT_WS(',', itemgroup1.itemgroup1_name,itemgroup2.itemgroup2_name, item.item_name,asset_unit.unit_name,store.store_name)) As search
FROM
    asset_item
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item = asset_stock.id_asset_item)
    INNER JOIN itemgroup1 
        ON (asset_item.id_itemgroup1 = itemgroup1.id_itemgroup1)
    INNER JOIN asset_unit 
        ON (asset_item.id_unit = asset_unit.id_unit)
    INNER JOIN itemgroup2 
        ON (asset_item.id_itemgroup2 = itemgroup2.id_itemgroup2)
    INNER JOIN item 
        ON (asset_item.asset_name = item.id_item)
		INNER JOIN store 
        ON (asset_stock.id_store = store.id_store)
WHERE 
    ";
	
	$filter = '';
	if($id_unit != null)
	{
		$filter.= "  asset_stock.id_unit=".$id_unit;
	}
	if($id_store != null)
	{
		if($id_unit != null)
		{
			$filter.= ' AND ';
		}
		$filter.= "  asset_stock.id_store =".$id_store;
	}
	if($id_itemGtoup1 != null )
	{
		if($id_store != null || $id_unit !=null )
		{
			$filter.= ' AND ';
		}
		$filter.= "  itemgroup1.id_itemgroup1 =".$id_itemGtoup1;
	}
	if($id_itemGtoup2 != null )
	{
		if($id_store != null || $id_unit !=null || $id_itemGtoup1 != null )
		{
			$filter.= ' AND ';
		}
		$filter.= "  itemgroup2.id_itemgroup2 =".$id_itemGtoup2;
	}
	if($id_item != null )
	{
		if($id_store != null || $id_unit !=null || $id_itemGtoup1 != null || $id_itemGtoup2 != null )
		{
			$filter.= ' AND ';
		}
		$filter.= "   asset_item.asset_name =".$id_item;
	}
	 
	 if(!empty($rowsPerPage))
		{
			$limit 	= "LIMIT $offset, $rowsPerPage";
		}
		if(!empty($field))
		{
			$orderBy 		= " ORDER BY ".$field." ".$sort." ";
		}
		else $orderBy = " GROUP BY asset_item.id_asset_item ASC ";
	  $query = $qry.$filter.$orderBy.$limit;
	 
	 if($row = $this->oDb->get_row($query))
		{
			$aresult = $row->search;
		}
	$aexpResult = explode(',',$aresult);
	if($id_unit != null)
	{
		$results =$aexpResult[3].','; 
	}
	if($id_store != null)
	{
		
		$results.=$aexpResult[4].',';
	}
	if($id_itemGtoup1 != null )
	{
		$results.=$aexpResult[0].',';
	}
	if($id_itemGtoup2 != null )
	{
		$results.=$aexpResult[1].',';
	}
	if($id_item != null )
	{
		$results.=$aexpResult[2].',';
	}
	$results=substr($results,0,(strlen($results)-1));
	return $results;
	}*/
	
	public function getAvailablestock()
	{
	 
	 $qry ="
	 
	SELECT
 item.id_item,
   item.item_name
    , COUNT(asset_item.asset_name)AS availablestock
       , asset_stock.id_division
     , store.store_name
    , asset_unit.unit_name
    , asset_unit.id_unit
    , store.id_store
   
FROM
    asset_item
    INNER JOIN item 
        ON (asset_item.asset_name = item.id_item)
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item = asset_stock.id_asset_item)
    INNER JOIN store 
        ON (asset_stock.id_store = store.id_store)
    INNER JOIN asset_unit 
        ON (asset_stock.id_unit = asset_unit.id_unit)
   WHERE (asset_stock.id_division =0)
GROUP BY item.item_name;
	 ";
	 $query = $qry;
	$aAvailableStockList = array();
		if($result = $this->oDb->get_results($query))
		{
			foreach($result as $row)
			{
			$aAvailableStock = array();
			$aAvailableStock['id_item']   = $row->id_item;
			$aAvailableStock['availablestock'] = $row->availablestock;
			$aAvailableStock['item_name']    =$row->item_name;
			$aAvailableStock['id_division']    =$row->id_division;
			$aAvailableStock['id_unit']    =$row->id_unit;
			$aAvailableStock['unit_name']    =$row->unit_name;
			$aAvailableStock['id_store']    =$row->id_store;
			$aAvailableStock['store_name']    =$row->store_name;
			$aAvailableStockList[] = $aAvailableStock;
			}
			}
			return $aAvailableStockList;
	}
	
	public function getAvailablestockinfo($lookup)
	{
	 
	 $qry ="
	 
	SELECT
 item.id_item,
   item.item_name
    , COUNT(asset_item.asset_name)AS availablestock
       , asset_stock.id_division
     , store.store_name
    , asset_unit.unit_name
    , asset_unit.id_unit
    , store.id_store
   ,itemgroup2.itemgroup2_name
  ,itemgroup2.id_itemgroup2
FROM
    asset_item
    INNER JOIN item 
        ON (asset_item.asset_name = item.id_item)
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item = asset_stock.id_asset_item)
		 INNER JOIN itemgroup2
        ON (asset_item.id_itemgroup2 =itemgroup2.id_itemgroup2 )
    INNER JOIN store 
        ON (asset_stock.id_store = store.id_store)
    INNER JOIN asset_unit 
        ON (asset_stock.id_unit = asset_unit.id_unit)
   WHERE (asset_stock.id_division =0 AND item.id_item ='$lookup')
GROUP BY item.item_name;
	 ";
	$query = $qry;
	$aAvailableStock = array();
		if($row = $this->oDb->get_row($query))
		{
			
			
			$aAvailableStock['id_item']   = $row->id_item;
			$aAvailableStock['availablestock'] = $row->availablestock;
			$aAvailableStock['item_name']    =$row->item_name;
			$aAvailableStock['id_division']    =$row->id_division;
			$aAvailableStock['id_unit']    =$row->id_unit;
			$aAvailableStock['unit_name']    =$row->unit_name;
			$aAvailableStock['id_store']    =$row->id_store;
			$aAvailableStock['store_name']    =$row->store_name;
			$aAvailableStock['itemgroup2_name']    =$row->itemgroup2_name;
			
			}
			return $aAvailableStock;
	}
	public function getTotalstock()
	{
	 
	 $qry ="
	 
	SELECT
 item.id_item,
   item.item_name
    , COUNT(asset_item.asset_name) AS totalstock
       , asset_stock.id_division
     , store.store_name
    , asset_unit.unit_name
    , asset_unit.id_unit
    , store.id_store
   
FROM
    asset_item
    INNER JOIN item 
        ON (asset_item.asset_name = item.id_item)
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item = asset_stock.id_asset_item)
    INNER JOIN store 
        ON (asset_stock.id_store = store.id_store)
    INNER JOIN asset_unit 
        ON (asset_stock.id_unit = asset_unit.id_unit)
  GROUP BY item.item_name;
	 ";
	 $query = $qry;
	$aTotalstockList = array();
		if($result = $this->oDb->get_results($query))
		{
			foreach($result as $row)
			{
			$aTotalstock = array();
			$aTotalstock['id_item']   = $row->id_item;
			$aTotalstock['totalstock'] = $row->totalstock;
			$aTotalstock['item_name']    =$row->item_name;
			$aTotalstock['id_division']    =$row->id_division;
			$aTotalstock['id_unit']    =$row->id_unit;
			$aTotalstock['unit_name']    =$row->unit_name;
			$aTotalstock['id_store']    =$row->id_store;
			$aTotalstock['store_name']    =$row->store_name;
			$aTotalstockList[] = $aTotalstock;
			}
			}
			return $aTotalstockList;
	}
	
	public function getTotalstockInfo($lookup)
	{
	 
	 $qry ="
	 
	SELECT
 item.id_item,
   item.item_name
    , COUNT(asset_item.asset_name) AS totalstock
       , asset_stock.id_division
     , store.store_name
    , asset_unit.unit_name
    , asset_unit.id_unit
    , store.id_store
   
FROM
    asset_item
    INNER JOIN item 
        ON (asset_item.asset_name = item.id_item)
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item = asset_stock.id_asset_item)
    INNER JOIN store 
        ON (asset_stock.id_store = store.id_store)
    INNER JOIN asset_unit 
        ON (asset_stock.id_unit = asset_unit.id_unit)
		WHERE item.id_item ='$lookup'
  GROUP BY item.item_name;
	 ";
	 $query = $qry;
	$aTotalstock = array();
		if($row = $this->oDb->get_row($query))
		{
			$aTotalstock['id_item']   = $row->id_item;
			$aTotalstock['totalstock'] = $row->totalstock;
			$aTotalstock['item_name']    =$row->item_name;
			$aTotalstock['id_division']    =$row->id_division;
			$aTotalstock['id_unit']    =$row->id_unit;
			$aTotalstock['unit_name']    =$row->unit_name;
			$aTotalstock['id_store']    =$row->id_store;
			$aTotalstock['store_name']    =$row->store_name;
					
			}
			return $aTotalstock;
	}
	
	public function getUsedStockByItem($lookup)
	{
	 
	 $qry ="
	 SELECT
 item.id_item,
   item.item_name
    , COUNT(asset_item.asset_name)AS activeitem
       , asset_stock.id_division
     , store.store_name
    , asset_unit.unit_name
    , asset_unit.id_unit
    , store.id_store
    ,itemgroup2.itemgroup2_name
  ,itemgroup2.id_itemgroup2 
FROM
   asset_item
    INNER JOIN item 
        ON (asset_item.asset_name = item.id_item)
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item = asset_stock.id_asset_item)
		 INNER JOIN itemgroup2
        ON (asset_item.id_itemgroup2 =itemgroup2.id_itemgroup2 )
    INNER JOIN store 
        ON (asset_stock.id_store = store.id_store)
    INNER JOIN asset_unit 
        ON (asset_stock.id_unit = asset_unit.id_unit)
   WHERE (asset_stock.id_division !=0 AND item.id_item ='$lookup')
GROUP BY  itemgroup2.id_itemgroup2;
	 ";
	$query = $qry;
	$aUsedItemStockList = array();
		if($result = $this->oDb->get_results($query))
		{
			foreach($result as $row)
			{
			$aUsedItemStock = array();
			$aUsedItemStock['id_item']   = $row->id_item;
			$aUsedItemStock['activeitem'] = $row->activeitem;
			$aUsedItemStock['item_name']    =$row->item_name;
			$aUsedItemStock['id_division']    =$row->id_division;
			$aUsedItemStock['id_unit']    =$row->id_unit;
			$aUsedItemStock['unit_name']    =$row->unit_name;
			$aUsedItemStock['id_store']    =$row->id_store;
			$aUsedItemStock['store_name']    =$row->store_name;
			$aUsedItemStock['itemgroup2_name']    =$row->itemgroup2_name;	
				$aUsedItemStockList[] = $aUsedItemStock;
			}
			}
			return $aUsedItemStockList;
	}
	public function getUsedStockByItemInfo($lookup)
	{
	 
	 $qry ="
	 SELECT
 item.id_item,
   item.item_name
    , COUNT(asset_item.asset_name)AS activeitem
       , asset_stock.id_division
     , store.store_name
    , asset_unit.unit_name
    , asset_unit.id_unit
    , store.id_store
   ,itemgroup2.itemgroup2_name
  ,itemgroup2.id_itemgroup2 
FROM
   asset_item
    INNER JOIN item 
        ON (asset_item.asset_name = item.id_item)
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item = asset_stock.id_asset_item)
		 INNER JOIN itemgroup2
        ON (asset_item.id_itemgroup2 =itemgroup2.id_itemgroup2 )
    INNER JOIN store 
        ON (asset_stock.id_store = store.id_store)
    INNER JOIN asset_unit 
        ON (asset_stock.id_unit = asset_unit.id_unit)
   WHERE (asset_stock.id_division !=0 AND item.id_item ='$lookup')
GROUP BY itemgroup2.id_itemgroup2;
	 ";
	$query = $qry;
	$aUsedItemStockList = array();
		if($row = $this->oDb->get_row($query))
		{
			$aUsedItemStock = array();
			$aUsedItemStock['id_item']   = $row->id_item;
			$aUsedItemStock['activeitem'] = $row->activeitem;
			$aUsedItemStock['item_name']    =$row->item_name;
			$aUsedItemStock['id_division']    =$row->id_division;
			$aUsedItemStock['id_unit']    =$row->id_unit;
			$aUsedItemStock['unit_name']    =$row->unit_name;
			$aUsedItemStock['id_store']    =$row->id_store;
			$aUsedItemStock['store_name']    =$row->store_name;
			$aUsedItemStock['itemgroup2_name']    =$row->itemgroup2_name;	
			
			}
			return $aUsedItemStock;
	}
	
	public function getUnitWiseItemStock($lookup)
	{
	 
	 $qry ="
	SELECT
 item.id_item,
   item.item_name
    , COUNT(asset_item.asset_name)AS unitwiseitemcount
       , asset_stock.id_division
     , store.store_name
    , asset_unit.unit_name
    , asset_unit.id_unit
    , store.id_store
   ,itemgroup2.itemgroup2_name
  ,itemgroup2.id_itemgroup2
FROM
    asset_item
    INNER JOIN item 
        ON (asset_item.asset_name = item.id_item)
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item = asset_stock.id_asset_item)
		 INNER JOIN itemgroup2
        ON (asset_item.id_itemgroup2 =itemgroup2.id_itemgroup2 )
    INNER JOIN store 
        ON (asset_stock.id_store = store.id_store)
    INNER JOIN asset_unit 
        ON (asset_stock.id_unit = asset_unit.id_unit)
   WHERE (asset_stock.id_division =0 AND item.id_item ='$lookup')
GROUP BY  itemgroup2.id_itemgroup2;
	 ";
	 $query = $qry;
	
	 $aUnitwiseStock = array();
	 $aUnitWiseItemStocks = array();
	 $aUnitWiseItemStockList = array();
	 $aUsedItemStocks = array();
	      
		   $aAvailablestock = $this->getAvailablestockinfo($lookup);
		   $aUnitwiseStock['availablestock'] = $aAvailablestock['availablestock'];
		   if(empty($aUnitwiseStock['availablestock']))
			{
			$aUnitwiseStock['availablestock'] = 0;
			}
	       $aTotalstock = $this->getTotalstockInfo($lookup);
	       $aUnitwiseStock['totalstock'] = $aTotalstock['totalstock'];
		   if(empty($aUnitwiseStock['totalstock']))
			{
			$aUnitwiseStock['totalstock'] = 0;
			}
			$aUsedStockItem = $this->getUsedStockByItem($lookup);
			$aUsedInfo = $this->getUsedStockByItemInfo($lookup);
			$aUnitwiseStock['usedstock'] = $aUsedInfo['activeitem'];
			if(empty($aUnitwiseStock['usedstock']))
			{
			$aUnitwiseStock['usedstock'] = 0;
			}
			$aItemInfo = $this->getItemInfo($lookup,'id');
		if($result = $this->oDb->get_results($query))
		{
			
			foreach($result as $row)
			{
			$aUnitWiseItemStock = array();
			$aUnitWiseItemStock['id_item']   = $row->id_item;
			$aUnitWiseItemStock['unitwiseitemcount'] = $row->unitwiseitemcount;
			$aUnitWiseItemStock['item_name']    =$row->item_name;
			$aUnitWiseItemStock['id_division']    =$row->id_division;
			$aUnitWiseItemStock['id_unit']    =$row->id_unit;
			$aUnitWiseItemStock['unit_name']    =$row->unit_name;
			$aUnitWiseItemStock['id_store']    =$row->id_store;
			$aUnitWiseItemStock['store_name']    =$row->store_name;
			$aUnitWiseItemStock['itemgroup2_name']    =$row->itemgroup2_name;
			
			  $aUnitWiseItemStocks[] = $aUnitWiseItemStock;
			}
			}
			 $aUnitWiseItemStockList['unitwisestock'] = $aUnitWiseItemStocks;
			 $aUnitWiseItemStockList['stock']       = $aUnitwiseStock;
			 $aUnitWiseItemStockList['usedstockitem'] =$aUsedStockItem ;
			 $aUnitWiseItemStockList['itemname'] = $aItemInfo['item_name'];
			 
			return $aUnitWiseItemStockList;
	}
	
	
	public function getUnitWiseTotalStock()
	{
	 
	 $qry ="
	SELECT COUNT( asset_item.asset_name ) AS item_count, store.store_name, asset_unit.unit_name, asset_unit.id_unit, store.id_store
FROM asset_item
RIGHT JOIN asset_stock ON ( asset_item.id_asset_item = asset_stock.id_asset_item ) 
INNER JOIN store ON ( asset_stock.id_store = store.id_store ) 
INNER JOIN asset_unit ON ( asset_stock.id_unit = asset_unit.id_unit ) 
GROUP BY asset_stock.id_unit
	 ";
	 $query = $qry;
	 $aUnitWiseItemStocks = array();
		if($result = $this->oDb->get_results($query))
		{
			
			foreach($result as $row)
			{
			$aUnitWiseItemStock = array();
			$aUnitWiseItemStock['item_count'] = $row->item_count;
			$aUnitWiseItemStock['id_unit']    =$row->id_unit;
			$aUnitWiseItemStock['unit_name']    =$row->unit_name;
			$aUnitWiseItemStock['id_store']    =$row->id_store;
			$aUnitWiseItemStock['store_name']    =$row->store_name;
			
			
			  $aUnitWiseItemStocks[] = $aUnitWiseItemStock;
			}
			}
						 
			return $aUnitWiseItemStocks;
	}
	public function getStoreWiseStockCount()
	{
	 
	 $qry ="

	SELECT
    COUNT(asset_item.id_asset_item)AS item_count
    ,store.store_name
    ,asset_unit.unit_name
     ,store.id_store
    ,asset_unit.id_unit
FROM
   asset_item
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item =asset_stock.id_asset_item)
    INNER JOIN store 
        ON (asset_stock.id_store =store.id_store)
    INNER JOIN asset_unit 
        ON (store.id_unit =asset_unit.id_unit)
       
       GROUP BY store.id_store;
	 ";
	$query = $qry;
	
	 $StoreWiseStockCountList = array();
		if($result = $this->oDb->get_results($query))
		{
			
			foreach($result as $row)
			{
			$StoreWiseStockCount = array();
			$StoreWiseStockCount['item_count'] = $row->item_count;
			$StoreWiseStockCount['id_unit']    =$row->id_unit;
			$StoreWiseStockCount['unit_name']    =$row->unit_name;
			$StoreWiseStockCount['id_store']    =$row->id_store;
			$StoreWiseStockCount['store_name']    =$row->store_name;
			
			
			  $StoreWiseStockCountList[] = $StoreWiseStockCount;
			}
			}
						 
			return $StoreWiseStockCountList;
	}
	
	
	public function getDivisionName($divisionid)
	{
	$qry = "SELECT division_name FROM division WHERE id_division='$divisionid'";
	if($row = $this->oDb->get_row($qry ))
	{
	$division_name = $row->division_name;
	}
	return $division_name;
	}
	public function getIdleDaysTimes($lookup)
	{
	   $qry ="SELECT DATEDIFF(now(), created_on) AS days ,now() As today, created_on,CONCAT(
	   FLOOR(HOUR(TIMEDIFF(now(), created_on)) / 24), ' days ',
MOD(HOUR(TIMEDIFF(now(), created_on)), 24), ' hours ',
MINUTE(TIMEDIFF(now(), created_on)), ' minutes') as days_times FROM asset_item WHERE id_asset_item=".$lookup;
	if($row = $this->oDb->get_row($qry ))
	{
	 $no_days_times = $row->days_times;
	 
	}
	return $no_days_times;
	}
	public function getUsedDaysTimes($lookup)
	{
	   $qry ="SELECT DATEDIFF(now(), assigned_on) AS days ,now() As today, assigned_on,CONCAT(
FLOOR(HOUR(TIMEDIFF(now(), assigned_on)) / 24), ' days ',
MOD(HOUR(TIMEDIFF(now(), assigned_on)), 24), ' hours ',
MINUTE(TIMEDIFF(now(), assigned_on)), ' minutes') as day_times FROM asset_stock WHERE id_asset_item=".$lookup;
	if($row = $this->oDb->get_row($qry ))
	{
	 $no_days_times = $row->day_times;
	}
	return $no_days_times;
	}
	
	public function getIdleDays($lookup)
	{
	   $qry ="SELECT DATEDIFF(now(), created_on) AS days ,now() As today, created_on FROM asset_item WHERE id_asset_item=".$lookup;
	if($row = $this->oDb->get_row($qry ))
	{
	 $no_days = $row->days;
	 
	}
	return $no_days;
	}
	
	public function getTotalDays($lookup)
	{
	   $qry ="SELECT DATEDIFF(now(), created_on) AS days ,now() As today, created_on FROM asset_item WHERE id_asset_item=".$lookup;
	if($row = $this->oDb->get_row($qry ))
	{
	 $no_days = $row->days;
	 
	}
	return $no_days;
	}
	
	public function getUsedDays($lookup)
	{
	   $qry ="SELECT DATEDIFF(now(), assigned_on) AS days ,now() As today, assigned_on FROM asset_stock WHERE id_asset_item=".$lookup;
	if($row = $this->oDb->get_row($qry ))
	{
	 $used_days= $row->days;
	}
	return $used_days;
	}
	/*public function getUnitwiseStockList($lookup)
	{
	$aUnitwiseStockList = array();
	$aUnitwiseStock= array();
	
	$aAvailablestock = $this->getAvailablestockinfo($lookup);
	$aUnitwiseStock['availablestock'] = $aAvailablestock['availablestock'];
	$aTotalstock = $this->getTotalstockInfo($lookup);
	$aUnitwiseStock['totalstock'] = $aTotalstock['totalstock'];
	
	}*/
	public function getItemName($lookup)
	{
	$qry = "SELECT item_name FROM item WHERE id_item=".$lookup;
	if($row = $this->oDb->get_row($qry ))
	{
	 $item_name = $row->item_name;
	 
	}
	return $item_name;
	}
	public function getItemGroup1Name($lookup)
	{
	$qry = "SELECT itemgroup1_name FROM itemgroup1 WHERE id_itemgroup1 =".$lookup;
	if($row = $this->oDb->get_row($qry ))
	{
	 $itemgroup1_name = $row->itemgroup1_name;
	 
	}
	return $itemgroup1_name;
	}
	
	
	public function getItemGroup2Name($lookup)
	{
	$qry = "SELECT itemgroup2_name FROM itemgroup2 WHERE id_itemgroup2 =".$lookup;
	if($row = $this->oDb->get_row($qry ))
	{
	 $itemgroup2_name = $row->itemgroup2_name;
	 
	}
	return $itemgroup2_name;
	}
	public function getItemGroup1List()
	{
		$qry = "SELECT id_itemgroup1,itemgroup1_name FROM itemgroup1 WHERE status!=2";
		$aItemGroup1List = array();
		if($result = $this->oDb->get_results($qry ))
		{ 
		           
					 
				foreach($result as $row)
				{
					  $aItemGroup1 = array();
					 $aItemGroup1['id_itemgroup1'] = $row->id_itemgroup1;
					 $aItemGroup1['itemgroup1_name'] = $row->itemgroup1_name;
					 $aItemGroup1List[] = $aItemGroup1;
				 }
				      $aItemGroup1['id_itemgroup1'] = '0';
					  $aItemGroup1['itemgroup1_name'] = ' ';
			          $aItemGroup1List[] = $aItemGroup1;
		}
	return $aItemGroup1List;
	}
	public function StorewiseReport()
	{
	$qry = "SELECT
    COUNT(asset_item.id_asset_item)AS item_count
    ,store.store_name
    ,asset_unit.unit_name
    ,store.id_store
    ,asset_unit.id_unit
    ,asset_item.id_itemgroup1 
    ,asset_item.id_itemgroup2 
   ,asset_item.asset_name 
 
FROM
  asset_item
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item =asset_stock.id_asset_item)
    INNER JOIN store 
        ON (asset_stock.id_store =store.id_store)
     INNER JOIN asset_unit 
        ON (store.id_unit =asset_unit.id_unit)
      GROUP BY asset_stock.id_store ,asset_item.id_itemgroup1  ,asset_item.id_itemgroup2  ,asset_item.asset_name";
		 $query = $qry;
	 $StorewiseReportList = array();
		if($result = $this->oDb->get_results($query))
		{
			
			foreach($result as $row)
			{
			$StorewiseReport=array();
			
			$StorewiseReport['item_count']=$row->item_count;
			$StorewiseReport['store_name']=$row->store_name;
			$StorewiseReport['unit_name']=$row->unit_name;
			$StorewiseReport['id_store']=$row->id_store;
			$StorewiseReport['id_unit']=$row->id_unit;
			$StorewiseReport['id_asset_item']=$row->id_asset_item;
			$StorewiseReport['asset_no']=$row->asset_no;
			$StorewiseReport['id_itemgroup1']=$row->id_itemgroup1;
			$StorewiseReport['id_itemgroup2']=$row->id_itemgroup2;
			$StorewiseReport['asset_name']=$row->asset_name;
			$StorewiseReport['itemgroup1_name']   =$this->getItemGroup1Name($row->id_itemgroup1);
			$StorewiseReport['itemgroup2_name'] = $this->getItemGroup2Name($row->id_itemgroup2);
			$StorewiseReport['item_name']    =$this->getItemName($row->asset_name);
			$StorewiseReportList[] = $StorewiseReport;
			}
		}
		return $StorewiseReportList;
	}
	
	
 public function itemwiseReport()
 {
 $qry ='SELECT
    COUNT(asset_item.id_asset_item)AS item_count
    ,store.store_name
    ,asset_unit.unit_name
    ,store.id_store
    ,asset_unit.id_unit
    ,asset_item.id_itemgroup1 ,asset_item.id_itemgroup2 ,asset_item.asset_name
  FROM
    asset_item
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item =asset_stock.id_asset_item)
    INNER JOIN store 
        ON (asset_stock.id_store =store.id_store)
     INNER JOIN asset_unit 
        ON (store.id_unit =asset_unit.id_unit)
      GROUP BY asset_stock.id_store ,asset_item.id_itemgroup1,asset_item.id_itemgroup2,asset_item.asset_name';
  $query = $qry;
	 $itemwiseReportList = array();
		if($result = $this->oDb->get_results($query))
		{
			
			foreach($result as $row)
			{
			$itemwiseReport=array();
			
			$itemwiseReport['item_count']=$row->item_count;
			$itemwiseReport['store_name']=$row->store_name;
			$itemwiseReport['unit_name']=$row->unit_name;
			$itemwiseReport['id_store']=$row->id_store;
			$itemwiseReport['id_unit']=$row->id_unit;
			$itemwiseReport['id_asset_item']=$row->id_asset_item;
			$itemwiseReport['id_itemgroup1']=$row->id_itemgroup1;
			$itemwiseReport['id_itemgroup2']=$row->id_itemgroup2;
			$itemwiseReport['asset_name']=$row->asset_name;
			$itemwiseReport['itemgroup1_name']   =$this->getItemGroup1Name($row->id_itemgroup1);
			$itemwiseReport['itemgroup2_name'] = $this->getItemGroup2Name($row->id_itemgroup2);
			$itemwiseReport['item_name']    =$this->getItemName($row->asset_name);
			$itemwiseReportList[] = $itemwiseReport;
			}
		}
		return $itemwiseReportList;
	}
	
	public function ItemDetailsReport()
	{
	$qry = 'SELECT
		COUNT(asset_item.id_asset_item)AS item_count
		,store.store_name
		,asset_unit.unit_name
		,store.id_store
		,asset_unit.id_unit
		,asset_item.id_itemgroup1 ,asset_item.id_itemgroup2 ,asset_item.asset_name
		,asset_item.asset_no
		,asset_item.id_inventory_item
		,asset_item.date_of_install
		,asset_item.warranty_start_date
		,asset_item.warranty_end_date
        ,asset_item.machine_no  
  FROM
    asset_item
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item =asset_stock.id_asset_item)
    INNER JOIN store 
        ON (asset_stock.id_store =store.id_store)
     INNER JOIN asset_unit 
        ON (store.id_unit =asset_unit.id_unit)
      GROUP BY asset_stock.id_store ,asset_item.id_itemgroup1,asset_item.id_itemgroup2,asset_item.asset_name,asset_item.id_asset_item';
	  
	  $query = $qry;
	 $itemDetailReportList = array();
		if($result = $this->oDb->get_results($query))
		{
			
			foreach($result as $row)
			{
			 $itemDetailReport = array();
			$itemDetailReport['item_count'] = $row->item_count;
			$itemDetailReport['store_name'] = $row->store_name;
			$itemDetailReport['unit_name'] = $row->unit_name;
			$itemDetailReport['id_store'] = $row->id_store;
			$itemDetailReport['id_unit'] = $row->id_unit;
			$itemDetailReport['id_itemgroup1'] = $row->id_itemgroup1;
			$itemDetailReport['id_itemgroup2'] = $row->id_itemgroup2;
			$itemDetailReport['asset_name'] = $row->asset_name;
			$itemDetailReport['asset_no'] = $row->asset_no;
			$itemDetailReport['machine_no'] = strtoupper($row->machine_no);
			$itemDetailReport['id_inventory_item'] = $row->id_inventory_item;
			$itemDetailReport['date_of_install'] = $row->date_of_install;
			$itemDetailReport['warranty_start_date'] = $row->warranty_start_date;
			$itemDetailReport['warranty_end_date'] = $row->warranty_end_date;
			$itemDetailReport['itemgroup1_name']   =$this->getItemGroup1Name($row->id_itemgroup1);
			$itemDetailReport['itemgroup2_name'] = $this->getItemGroup2Name($row->id_itemgroup2);
			$itemDetailReport['item_name']    =$this->getItemName($row->asset_name);
			$itemDetailReportList[] = $itemDetailReport;
			}
		}
		return  $itemDetailReportList;	
	}
	
    public function ItemReport()
	{
	$aItemWiseReport = $this->ItemDetailsReport();
		$aStoreReport = $this->getStoreWiseStockCount();
		$aStoreWiseReport = $this->StorewiseReport();
		$array_store =array();
		$arr_stock =array();
		$aItemGroup1 =  $this->getItemGroup1List();
		foreach($aItemWiseReport as $aItemWise)
		 {
			foreach($aStoreReport as $aStoreReports)
			{
			           if($aStoreReports['id_store'] == $aItemWise['id_store'])
						{
							 foreach($aItemGroup1 as $aItemGroup)
							 {						
									  if(in_array($aItemGroup['id_itemgroup1'],$aItemWise))
									  {										
											if($aItemWise['id_itemgroup1'] == $aItemGroup['id_itemgroup1'])
											{
											
											$arr_stock[$aStoreReports['id_store']]['store_name'] = $aItemWise['store_name'];
											$arr_stock[$aStoreReports['id_store']]['name'][$aItemWise['id_itemgroup1']]=$aItemWise['itemgroup1_name'];
											$arr_stock[$aStoreReports['id_store']]['stock'][$aItemWise['id_itemgroup1']][] = $aItemWise;

											}
									}
							}
						}
			}
		}
	return $arr_stock;
	}	
	
	public function ItemGroupReport()
	{
		$aItemWiseReport = $this->itemwiseReport();
		$aStoreReport = $this->getStoreWiseStockCount();
		$aStoreWiseReport = $this->StorewiseReport();
		$array_store =array();
		$arr_stock =array();
		$aItemGroup1 =  $this->getItemGroup1List();
		foreach($aItemWiseReport as $aItemWise)
		 {
			foreach($aStoreReport as $aStoreReports)
			{
			           if($aStoreReports['id_store'] == $aItemWise['id_store'])
						{
							 foreach($aItemGroup1 as $aItemGroup)
							 {						
									  if(in_array($aItemGroup['id_itemgroup1'],$aItemWise))
									  {										
											if($aItemWise['id_itemgroup1'] == $aItemGroup['id_itemgroup1'])
											{
											
											$arr_stock[$aStoreReports['id_store']]['store_name'] = $aItemWise['store_name'];
											$arr_stock[$aStoreReports['id_store']]['name'][$aItemWise['id_itemgroup1']]=$aItemWise['itemgroup1_name'];
											$arr_stock[$aStoreReports['id_store']]['stock'][$aItemWise['id_itemgroup1']][] = $aItemWise;

											}
									}
							}
						}
			}
		}
	return $arr_stock;
	}	
	public function getVendorName($vendorid)
	{
		 $query   = "SELECT vendor_name FROM vendor WHERE id_vendor =".$vendorid;
	  	 $results = $this->oDb->get_row($query);
		 return $results->vendor_name;
	}
}