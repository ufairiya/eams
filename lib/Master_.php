<?php
	/**
	  * Master class
	  * This class lists miscellaneous master table CRUD functions.
	  * 
	  * @author Subash Gopalaswamy <techhead.stallioni@gmail.com,kesav@stallioni.com>
	  * //Bank, Country,
	  */
	  
	  
class Master
{
	function __construct()
	{
	
	}
	
	public function setDb($oDb)
	{
	   $this->oDb = $oDb;
	}
 public function setQuoteStatus($aQuote)
   {
		   $this->_aQuote = $aQuote;
   }
   public function setLogDisplay($log)
   {
		    $this->DEBUGS = $log;
   }
   public function getStatus($status)
   {
		    $this->status = $status;
   }
   public function getTransStatus($aTrans)
   {
				   
		    $this->aTrans = $aTrans;
   }
   
   
	//Bank 
	public function addBank($aRequest)
	{
		//add a new bank.
		$bankName = strtoupper($aRequest['fBankName']);
		$lookup   = strtoupper($aRequest['fLookup']);
		$bsr_code = $aRequest['fBsrCode'];
		$status   = $aRequest['fStatus'];
		$qry = "INSERT INTO bank (id_bank, bank_name, lookup, bsr_code, status) VALUES (null, '$bankName','$lookup','$bsr_code', '$status')";
		
		if($this->oDb->query($qry))	{
		  return true;
		}
		else{
		  return false;
		}
	}
	public function getBankList()
	{
		$qry = "SELECT * FROM bank";
		$aBankList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aBank = array();
				$aBank['id_bank']   = $row->id_bank;
				$aBank['bank_name'] = strtoupper($row->bank_name);
				$aBank['lookup']    = strtoupper($row->lookup);
				$aBank['bsr_code']  = $row->bsr_code;
				$aBank['status']    = $row->status;
				$aBankList[]        = $aBank;
			}
		}
		return $aBankList;
	} //
	public function getBankInfo($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	   $qry = "SELECT id_bank, bank_name, lookup, bsr_code, status FROM bank WHERE ";
	   if($type == 'lookup') {
	   	 $condition = " lookup = '$lookup'";
	   }
	   else {
	     $condition = " id_bank = ".$lookup;
	   }
	   $qry = $qry.$condition;
	   $aBank = array();
	   if($row = $this->oDb->get_row($qry))
	   {
	      $aBank['id_bank']   = $row->id_bank;
		  $aBank['bank_name'] = strtoupper($row->bank_name);
		  $aBank['lookup']    = strtoupper($row->lookup);
		  $aBank['bsr_code']  = $row->bsr_code;	
		  $aBank['status']  = $row->status;		  
	   }
	   return $aBank;
	   
	}
	public function updateBank($aRequest, $action) //action -> update, delete
	{
		if($action == 'update')
		{
		  $id_bank  = $aRequest['fBankId'];
		  $bankName = strtoupper($aRequest['fBankName']);
		  $lookup   = strtoupper($aRequest['fLookup']);
		  $bsr_code = $aRequest['fBsrCode'];
		  $status   = $aRequest['fStatus'];
          $qry = "UPDATE bank SET bank_name = '$bankName', lookup = '$lookup', bsr_code = '$bsr_code', status = '$status' WHERE id_bank = ".$id_bank;
		}
		else if($action == 'delete')
		{
		  $id_bank  = $aRequest['fBankId'];
		  $qry = "UPDATE bank SET status = 2 WHERE id_bank =".$id_bank;
		}
		$valid = false;
		if($this->oDb->query($qry)) {
		 $valid = true;
		} 
		return $valid;
	}
/////////////////////////////////////////////////////////////////////////////////////////	
	
	//Territory Management functions.
	//Country, currency, city, 
    
	//Country
	
	public function addCountry($aRequest)
	{
		$country_name  = strtoupper($aRequest['fCountryName']);
		$lookup        = strtoupper($aRequest['fLookup']);
		$currency      = strtoupper($aRequest['fCurrency']);
		$currency_code = strtoupper($aRequest['fCurrencyCode']);
		$status        = $aRequest['fStatus'];
		$qry = "INSERT INTO country (id_country, country_name, lookup, currency, currency_code, status) VALUES (null, '$country_name','$lookup','$currency','$currency_code','$status')";
		if($this->oDb->query($qry))	{
		  return true;
		}
		else{
		  return false;
		}
	
	}
	
	public function getCountryList()
	{
		$qry = "SELECT * FROM country order by id_country DESC";
		$aCountryList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aCountry = array();
				$aCountry['id_country']   = $row->id_country;
				$aCountry['country_name'] = strtoupper($row->country_name);
				$aCountry['lookup']       = strtoupper($row->lookup);
				$aCountry['currency']     = strtoupper($row->currency);
				$aCountry['currency_code']= strtoupper($row->currency_code);
				$aCountry['status']       = $row->status;
				$aCountryList[]           = $aCountry;
			}
		}
		return $aCountryList;
	}
	public function getCountryInfo($lookup,$type)
	{
	   $qry = "SELECT id_country, country_name, lookup, currency, currency_code, status FROM country WHERE ";
	   if($type == 'lookup') {
	   	 $condition = " lookup = '$lookup'";
	   }
	   else {
	     $condition = " id_country = ".$lookup;
	   }
	   $qry = $qry.$condition;
	   $aCountry = array();
	   if($row = $this->oDb->get_row($qry))
	   {
	      $aCountry['id_country']    = $row->id_country;
		  $aCountry['country_name']  = strtoupper($row->country_name);
		  $aCountry['lookup']        = strtoupper($row->lookup);
		  $aCountry['currency']      = strtoupper($row->currency);	
		  $aCountry['currency_code'] = strtoupper($row->currency_code);	
		  $aCountry['status']        = $row->status;	
		  	  
	   }
	   return $aCountry;
	   
	}
	public function updateCountry($aRequest, $action)
	{
	if($action == 'update')
		{
		  $id_country    = $aRequest['fCountryId'];
		  $country_name  = strtoupper($aRequest['fCountryName']);
		  $lookup        = strtoupper($aRequest['fLookup']);
		  $currency      = strtoupper($aRequest['fCurrency']);
		  $currency_code = strtoupper($aRequest['fCurrencyCode']);
		  $status        = $aRequest['fStatus'];
		  
		   $checkqry = "SELECT * FROM  country WHERE country_name = '$country_name' AND id_country!='$id_country'";
		  $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{
		
			$valid = '2';
			
		}
		else
		{
          $qry = "UPDATE country SET country_name = '$country_name', lookup = '$lookup', currency = '$currency', currency_code = '$currency_code', status = '$status' WHERE id_country = ".$id_country;
		   $this->oDb->query($qry);
		     if( mysql_affected_rows() >= 0)
				{
				$valid = '1';
				}
				else
				{
				$valid = '0';
				}
		 }
		}
		else if($action == 'delete')
		{
		  $id_country  = $aRequest['fCountryId'];
		  $qry = "UPDATE country SET status = 2 WHERE id_country =".$id_country;
		  $valid = false;
		if($this->oDb->query($qry)) {
		 $valid = true;
		} 
		}
		
		return $valid;
	}
	
	//Currency
	public function addCurrency($aRequest)
	{
		//add a new currency.
			$currencyName = strtoupper($aRequest['fCurrencyName']);
			$lookup       = strtoupper($aRequest['fLookup']);
			$qry = "INSERT INTO currency (id_currency, currency_name, lookup, status) VALUES (null, '$currencyName','$lookup', 1)";
			
			if($this->oDb->query($qry))	{
			  return true;
			}
			else{
			  return false;
			}
	}
	public function getCurrencyList()
	{
	    $qry = "SELECT * FROM currency";
		$aCurrencyList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aCurrency = array();
				$aCurrency['id_currency']   = $row->id_currency;
				$aCurrency['currency_name'] = strtoupper($row->currency_name);
				$aCurrency['lookup']        = strtoupper($row->lookup);
				$aCurrency['status']        = $row->status;
				$aCurrencyList[]            = $aCurrency;
			}
		}
		return $aCurrencyList;
	}
	public function getCurrencyInfo($lookup,$type)
	{
			$qry = "SELECT id_currency, currency_name, lookup, status FROM currency WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_currency = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aCurrency = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			  $aCurrency['id_currency']   = $row->id_currency;
			  $aCurrency['currency_name'] = strtoupper($row->currency_name);
			  $aCurrency['lookup']        = strtoupper($row->lookup);
			  $aCurrency['status']        = $row->status;
		   }
		   return $aCurrency;
	   
	}
	public function updateCurrency($aRequest, $action)
	{
	   if($action == 'update')
		{
		  $id_currency   = $aRequest['fCurrencyId'];
		  $currency_name = strtoupper($aRequest['fCurrencyName']);
		  $lookup        = strtoupper($aRequest['fLookup']);
		  $status        = $aRequest['fStatus'];
		  $qry = "UPDATE currency SET currency_name = '$currency_name', lookup = '$lookup', status = '$status' WHERE id_currency = ".$id_currency;
		}
		else if($action == 'delete')
		{
		  if(is_array($aRequest)) 
		    $id_currency  = $aRequest['fCurrencyId'];
		  else 
		    $id_currency = $aRequest;
		  $qry = "UPDATE currency SET status = 2 WHERE id_currency =".$id_currency;
		}
		$valid = false;
		if($this->oDb->query($qry)) {
		 $valid = true;
		} 
		return $valid;
	}
	
	
	//State
	public function addState($aRequest)
	{
	  $stateName  = strtoupper($aRequest['fStateName']);
	  $lookup     = strtoupper($aRequest['fLookup']);
	  $id_country = $aRequest['fCountryId'];
	  $status = $aRequest['fStatus'];
	  $qry = "INSERT INTO state (id_state, id_country, state_name, lookup, status) VALUES (null, $id_country, '$stateName', '$lookup', $status)";
			if($this->oDb->query($qry))	{
			  return true;
			}
			else {
			  return false;
			}
	}
	
	public function getStateList()
	{
	    $qry = "SELECT * FROM state ORDER BY id_state DESC";
		$aStateList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aState = array();
				$aState['id_state']   = $row->id_state;
				$aState['id_country'] = $row->id_country;
				$aCountry = $this->getCountryInfo($row->id_country,'id');
				$aState['country_name'] = strtoupper($aCountry['country_name']);
				$aState['state_name'] = strtoupper($row->state_name);
				$aState['lookup']     = strtoupper($row->lookup);
				$aState['status']     = $row->status;
				$aStateList[]         = $aState;
			}
		}
		return $aStateList;
	}
	public function getStateInfo($lookup, $type)
	{
	       $qry = "SELECT id_state, id_country, state_name, lookup, status FROM state WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_state = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aState = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			  $aState['id_state']   = $row->id_state;
			  $aState['id_country'] = $row->id_country;
			  $aState['state_name'] = strtoupper($row->state_name);
			  $aState['lookup']     = strtoupper($row->lookup);
			  $aState['status']     = $row->status;
		   }
		   return $aState;
	}
	
	public function updateState($aRequest, $action)
	{
	    if($action == 'update')
		{
		  $id_state   = $aRequest['fStateId'];
		  $state_name = strtoupper($aRequest['fStateName']);
  		  $id_country = $aRequest['fCountryId'];
		  $lookup     = strtoupper($aRequest['fLookup']);
		  $status     = $aRequest['fStatus'];
		  $checkqry = "SELECT * FROM  state WHERE state_name = '$state_name' AND id_state!='$id_state'";
		  $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{
		
			$valid = '2';
			
		}
		else
		{
		  $qry = "UPDATE state SET state_name = '$state_name', id_country = '$id_country', lookup = '$lookup', status = '$status' WHERE id_state = ".$id_state;			 $this->oDb->query($qry);
		     if( mysql_affected_rows() >= 0)
				{
				$valid = '1';
				}
				else
				{
				$valid = '0';
				}
		}
		
		}
		return $valid;
	}
	
	
	//City
	public function addCity($aRequest)
	{
	   //add a new city.
			$cityName   = strtoupper($aRequest['fCityName']);
			$lookup     = strtoupper($aRequest['fLookup']);
			$id_state   = $aRequest['fStateId'];
			$id_country = $aRequest['fCountryId'];
			$status     = $aRequest['fStatus'];
			$qry = "INSERT INTO city (id_city, id_state, id_country, city_name, lookup, status) VALUES (null, $id_state, $id_country, '$cityName','$lookup', $status)";
			if($this->oDb->query($qry))	{
			  return true;
			}
			else{
			  return false;
			}
	}
	public function getCityList()
	{
	    $qry = "SELECT * FROM city ORDER BY id_city DESC";
		$aCityList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aCity = array();
				$aCity['id_city']      = $row->id_city;
				$aCity['id_state']     = $row->id_state;
				$aState = $this->getStateInfo($aCity['id_state'],'id');
				$aCity['state_name']   = strtoupper($aState['state_name']);
				$aCity['id_country']   = $row->id_country;
				$aCountry = $this->getCountryInfo($aCity['id_country'],'id');
				$aCity['country_name'] = strtoupper($aCountry['country_name']);
				$aCity['city_name']    = strtoupper($row->city_name);
				$aCity['lookup']       = strtoupper($row->lookup);
				$aCity['status']       = $row->status;
				$aCityList[]           = $aCity;
			}
		}
		return $aCityList;
	}
	public function getCityInfo($lookup, $type)
	{
	       $qry = "SELECT id_city, id_state, id_country, city_name, lookup, status FROM city WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_city = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aCity = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			  $aCity['id_city']   = $row->id_city;
			  $aCity['city_name'] = strtoupper($row->city_name);
			  $aCity['id_state']  = $row->id_state;
			  $aCity['id_country']= $row->id_country;
			  $aCity['lookup']    = strtoupper($row->lookup);
			  $aCity['status']    = $row->status;
		   }
		   return $aCity;
	}
	public function updateCity($aRequest, $action)
	{
	    if($action == 'update')
		{
		  $id_city    = $aRequest['fCityId'];
		  $city_name  = strtoupper($aRequest['fCityName']);
		  $lookup     = strtoupper($aRequest['fLookup']);
		  $id_state   = $aRequest['fStateId'];
		  $id_country = $aRequest['fCountryId'];
		  $status     = $aRequest['fStatus'];
		   $checkqry = "SELECT * FROM  city WHERE city_name = '$city_name' AND id_city!='$id_city'";
		  $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{
		
			$valid = '2';
			
		}
		else
		{
		  $qry = "UPDATE city SET city_name = '$city_name', id_country = $id_country, id_state = $id_state, lookup = '$lookup', status = $status WHERE id_city = ".$id_city;
		  
		  $this->oDb->query($qry);
		if( mysql_affected_rows() >= 0)
				{
				$valid = '1';
				}
				else
				{
				$valid = '0';
				}
		  }
		  
		  
		}
		
		
		return $valid;
	}
	
	//Port
	public function addPort($aRequest)
	{
	    $portName = strtoupper($aRequest['fPortName']);
		$lookup   = strtoupper($aRequest['fLookup']);
		$qry = "INSERT INTO port (id_port, port_name, lookup, status) VALUES (null, '$portName','$lookup', '1')";
		  if($this->oDb->query($qry))	{
			  return true;
			}
			else{
			  return false;
			}
	}
	public function getPortList()
	{
	   $qry = "SELECT * FROM port";
		$aPortList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aPort = array();
				$aPort['id_port']   = $row->id_port;
				$aPort['port_name'] = strtoupper($row->port_name);
				$aPort['lookup']    = strtoupper($row->lookup);
				$aPort['status']    = $row->status;
				$aPortList[]        = $aPort;
			}
		}
		return $aPortList;
	}
	public function getPortInfo($lookup, $type)
	{
	   $qry = "SELECT id_port, port_name, lookup, status FROM port WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_port = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aPort = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			  $aPort['id_port']   = $row->id_port;
			  $aPort['port_name'] = strtoupper($row->port_name);
			  $aPort['lookup']    = strtoupper($row->lookup);
			  $aPort['status']    = $row->status;
		   }
		   return $aPort;
	}
	public function updatePort($aRequest, $action)
	{
	    if($action == 'update')
		{
		  $id_port   = $aRequest['fPortId'];
		  $port_name = strtoupper($aRequest['fPortName']);
		  $lookup    = strtoupper($aRequest['fLookup']);
		  $status    = $aRequest['fStatus'];
		  $qry = "UPDATE port SET port_name = '$port_name', lookup = '$lookup', status = '$status' WHERE id_port = ".$id_port;
		}
		else if($action == 'delete')
		{
		  if(is_array($aRequest))
		    $id_port  = $aRequest['fPortId'];
		  else 
		    $id_port = $aRequest;	
		  $qry = "UPDATE port SET status = 2 WHERE id_port = ".$id_port;
		}
		$valid = false;
		if($this->oDb->query($qry)) {
		 $valid = true;
		} 
		return $valid;
	}
	//Shift  intime/outtime
	public function addShift($aRequest)
	{
		$shiftName = strtoupper($aRequest['fShiftName']);
		$id_unit   = $aRequest['fUnitId'];
		$in_time   = $aRequest['fInTime'];
		$out_time  = $aRequest['fOutTime'];
		$status    = $aRequest['fStatus'];
		$qry = "INSERT INTO shift (id_shift, shift_name, id_unit, in_time, out_time, status) VALUES (null, '$shiftName',$id_unit, '$in_time','$out_time','$status')";
		if($this->oDb->query($qry))	{
		  return true;
		}
		else{
		  return false;
		}
		
	}
	public function getShiftList()
	{
	  $qry = "SELECT * FROM shift";
		$aShiftList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aShift = array();
				$aShift['id_shift']  = $row->id_shift;
				$aShift['shift_name']= strtoupper($row->shift_name);
				$aShift['id_unit']   = $row->id_unit;
				$aUnit = $this->getUnitInfo($aShift['id_unit'],'id');
				$aShift['unit_name'] = strtoupper($aUnit['unit_name']);
				$aShift['in_time']   = $row->in_time;
				$aShift['out_time']  = $row->out_time;
				$aShift['status']    = $row->status;
				$aShiftList[]        = $aShift;
			}
		}
		return $aShiftList;
	}
	public function getShiftInfo($lookup, $type)
	{
	   $qry = "SELECT id_shift, id_unit, shift_name, in_time, out_time, status FROM shift WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_shift = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aShift = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			  $aShift['id_shift']  = $row->id_shift;
			  $aShift['shift_name']= strtoupper($row->shift_name);
			  //$aShift['lookup']    = strtoupper($row->lookup);
			  $aShift['id_unit']   = $row->id_unit;
			  $aUnit  = $this->getUnitInfo($aShift['id_unit'],'id');
			  $aShift['unit_name'] = strtoupper($aUnit['unit_name']);
			  $aShift['in_time']   = $row->in_time;
			  $aShift['out_time']  = $row->out_time;
			  $aShift['status']    = $row->status;
		   }
		   return $aShift;
	}
	public function updateShift($aRequest, $action)
	{
	   if($action == 'update')
		{
		  $id_shift   = $aRequest['fShiftId'];
		  $shift_name = strtoupper($aRequest['fShiftName']);
		  $id_unit    = $aRequest['fUnitId'];
		  $in_time    = $aRequest['fInTime'];
		  $out_time   = $aRequest['fOutTime'];
		  $status     = $aRequest['fStatus'];
		  $qry = "UPDATE shift SET shift_name = '$shift_name', id_unit = '$id_unit', in_time = '$in_time', out_time = '$out_time', status = '$status'  WHERE id_shift = ".$id_shift;
		  
		}
		else if($action == 'delete')
		{
		  $id_shift  = $aRequest['fShiftId'];
		  $qry = "UPDATE shift SET status = 2 WHERE id_shift =".$id_shift;
		}
		$valid = false;
		if($this->oDb->query($qry)) {
		 $valid = true;
		} 
		return $valid;
	}
	
	
	//Store
	public function addStore($aRequest)
	{
	    $storeName = strtoupper($aRequest['fStoreName']);
		$lookup    = strtoupper($aRequest['fLookup']);
		$id_unit   = $aRequest['fUnitId'];
		$status    = $aRequest['fStatus'];
		$qry = "INSERT INTO store (id_store, store_name, lookup, id_unit, status) VALUES (null, '$storeName','$lookup', $id_unit, '$status')";
			if($this->oDb->query($qry))	{
			  return true;
			}
			else{
			  return false;
			}
	}
	public function getStoreList()
	{
	    $qry = "SELECT * FROM store ORDER BY id_store DESC";
		$aStoreList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aStore = array();
				$aStore['id_store']  = $row->id_store;
				$aStore['store_name']= strtoupper($row->store_name);
				$aStore['id_unit']   = $row->id_unit;
				//$oAssetUnit = &Singleton::getInstance('AssetUnit');
                //$oAssetUnit->setDb($this->oDb);
                //$aStore['unit_name'] = $oAssetUnit->getUnitName($aStore['id_unit']);
				//$aStore['unit_name'] = $this->getUnitName($aStore['id_unit'],'id');
				$aStore['lookup']    = strtoupper($row->lookup);
				$aStore['status']    = $row->status;
				$aStoreList[]        = $aStore;
			}
		}
		return $aStoreList;
	}
	
	public function getStoreListInfo($lookup, $type)
	{
	     $qry = "SELECT id_store, id_unit, store_name, lookup, status FROM store WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else if($type =='unit'){
			 $condition = " id_unit = ".$lookup;
		   }
		   else {
			 $condition = " id_store = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aStoreList = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			  foreach($result as $row)
			  {
			  $aStore = array();
			  $aStore['id_store']   = $row->id_store;
			  $aStore['store_name'] = strtoupper($row->store_name);
			  $aStore['lookup']     = strtoupper($row->lookup);
			  $aStore['id_unit']    = $row->id_unit;
			  //$aStore['unit_name']  = $this->getUnitName($aStore['id_unit'],'id');
			  $aStore['status'] = $row->status;
			  $aStoreList[] = $aStore;
			  }
		   }
		   return $aStoreList;
	}
	
	public function getStoreInfo($lookup, $type)
	{
	     $qry = "SELECT id_store, id_unit, store_name, lookup, status FROM store WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else if($type =='unit'){
			 $condition = " id_unit = ".$lookup;
		   }
		   else {
			 $condition = " id_store = ".$lookup;
		   }
		  $qry = $qry.$condition;
		 
		 
		   if($row = $this->oDb->get_row($qry))
		   {
			    $aStore = array();
			  $aStore['id_store']   = $row->id_store;
			  $aStore['store_name'] = strtoupper($row->store_name);
			  $aStore['lookup']     = strtoupper($row->lookup);
			  $aStore['id_unit']    = $row->id_unit;
				$aUnitInfo = $this->getUnitInfo( $row->id_unit);
				$aUnitAddressId = $aUnitInfo['id_unit_address'];
				$aUnitaddress = $this->getPrintUnitAddress($aUnitAddressId,$aStore['store_name'],'id'); 
				$aStore['unitname'] = $aUnitaddress['unitname'];
				$aStore['addr1'] = $aUnitaddress['addr1'];
				$aStore['addr2'] = $aUnitaddress['addr2'];
				$aStore['addr3'] = $aUnitaddress['addr3'];
				$aStore['city_name'] = $aUnitaddress['city_name'];
				$aStore['zipcode'] = $aUnitaddress['zipcode'];	
				$aStore['address_format'] = $aUnitaddress['address_format'];
			  $aStore['status'] = $row->status;
		   }
		  
		  
		   return $aStore;
	}
	public function updateStore($aRequest, $action)
	{
	   if($action == 'update')
		{
		  $id_store   = $aRequest['fStoreId'];
		  $store_name = strtoupper($aRequest['fStoreName']);
		  $lookup     = strtoupper($aRequest['fLookup']);
		  $id_unit    = $aRequest['fUnitId'];
		  $status     = $aRequest['fStatus'];
		  $qry = "UPDATE store SET store_name = '$store_name', id_unit = '$id_unit', lookup = '$lookup', status='$status' WHERE id_store = ".$id_store;
		  
		}
		else if($action == 'delete')
		{
		  $id_store  = $aRequest['fStoreId'];
		  $qry = "UPDATE store SET status = 2 WHERE id_store =".$id_store;
		}
		$valid = false;
		 $this->oDb->query($qry);
				if( mysql_affected_rows() >= 0)
				{
				$valid = true;
				}
		return $valid;
	}
	
	//Division
	
	public function addDivision($aRequest)
	{
		$divisionName = strtoupper($aRequest['fDivisionName']);
		$lookup       = strtoupper($aRequest['fLookup']);
		$incharge = $aRequest['fEmployeeId'];
		$id_unit      = $aRequest['fUnitId'];
		$status       = $aRequest['fStatus'];
		$qry = "INSERT INTO division (id_division, id_unit, division_name, lookup,id_employee, status) VALUES (null, $id_unit, '$divisionName','$lookup','$incharge', '$status')";
			if($this->oDb->query($qry))	{
			  return true;
			}
			else{
			  return false;
			}
	}
	public function getDivisionList()
	{
	    $qry = "SELECT * FROM division ORDER BY id_division DESC ";
		$aDivisionList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aDivision = array();
				$aDivision['id_division']  = $row->id_division;
				$aDivision['division_name']= strtoupper($row->division_name);
				$aDivision['id_unit']      = $row->id_unit;
				$aDivision['id_employee']      = $row->id_employee;
				$aEmployeeInfo = $this->getEmployeeInfo($row->id_employee);
				$aDivision['incharge']      = $aEmployeeInfo['employee_name'];
				//$aDivision['unit_name'] = $this->getUnitName($aDivision['id_unit'],'id');
				$aDivision['lookup']       = strtoupper($row->lookup);
				$aDivision['status']       = $row->status;
				$aDivisionList[]           = $aDivision;
			}
		}
		return $aDivisionList;
	}
	public function getDivisionInfo($lookup, $type)
	{
	     $qry = "SELECT id_division, id_unit,id_employee, division_name, lookup, status FROM division WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else if($type == 'unit')
		   {
		   $condition = " id_unit = '$lookup'";
		   }
		   else {
			 $condition = " id_division = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aDivision = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			  $aDivision['id_division']   = $row->id_division;
			  $aDivision['division_name'] = strtoupper($row->division_name);
			  $aDivision['lookup']        = strtoupper($row->lookup);
			  $aDivision['id_unit']       = $row->id_unit;
			  $aDivision['id_employee']       = $row->id_employee;
			  //$aDivision['unit_name'] = $this->getUnitName($aDivision['id_unit'],'id');
			  $aDivision['status'] = $row->status;
		   }
		   return $aDivision;
	}
	public function getDivisionInfoList($lookup, $type)
	{
	     $qry = "SELECT id_division, id_unit,id_employee, division_name, lookup, status FROM division WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else if($type == 'unit')
		   {
		   $condition = " id_unit = '$lookup'";
		   }
		   else {
			 $condition = " id_division = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aDivisionList = array();
		  
		   if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
			  $aDivision = array();
			  $aDivision['id_division']   = $row->id_division;
			  $aDivision['division_name'] = strtoupper($row->division_name);
			  $aDivision['lookup']        = strtoupper($row->lookup);
			  $aDivision['id_unit']       = $row->id_unit;
			  $aDivision['id_employee']       = $row->id_employee;
			  //$aDivision['unit_name'] = $this->getUnitName($aDivision['id_unit'],'id');
			  $aDivision['status'] = $row->status;
			  $aDivisionList[] = $aDivision;
		   }
		   }
		   return $aDivisionList;
	}
	
	public function updateDivision($aRequest, $action)
	{
	   if($action == 'update')
		{
		  $id_division   = $aRequest['fDivisionId'];
		  $division_name = strtoupper($aRequest['fDivisionName']);
		  $lookup   = strtoupper($aRequest['fLookup']);
		  $id_unit  = $aRequest['fUnitId'];
          $status   = $aRequest['fStatus'];
		  $incharge = $aRequest['fEmployeeId'];
		  
		  $qry = "UPDATE division SET division_name = '$division_name', id_unit = $id_unit,id_employee='$incharge', lookup = '$lookup', status = '$status' WHERE id_division = ".$id_division;
		  
		}
		else if($action == 'delete')
		{
		  $id_division  = $aRequest['fDivisionId'];
		  $qry = "UPDATE division SET status = 2 WHERE id_division =".$id_division;
		}
		$valid = false;
		 $this->oDb->query($qry);
				if( mysql_affected_rows() >= 0)
				{
				$valid = true;
				}
				
		return $valid;
	}
	
	
	//UOM unit of measurement.
	//UOM
	public function addUom($aRequest)
	{
	    $uomName = strtoupper($aRequest['fUomName']);
		$lookup = strtoupper($aRequest['fLookup']);
		$qry = "INSERT INTO uom (id_uom, uom_name, lookup, status) VALUES (null, '$uomName','$lookup', 1)";
			if($this->oDb->query($qry))	{
			  return true;
			}
			else{
			  return false;
			}
	}
	public function getUomList()
	{
	   $qry = "SELECT * FROM uom";
		$aUomList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aUom = array();
				$aUom['id_uom']   = $row->id_uom;
				$aUom['uom_name'] = strtoupper($row->uom_name);
				$aUom['lookup']   = strtoupper($row->lookup);
				$aUom['status']   = $row->status;
				$aUomList[]       = $aUom;
			}
		}
		return $aUomList;
	}
	public function getUomInfo($lookup, $type)
	{
	  $qry = "SELECT id_uom, uom_name, lookup, status FROM uom WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_uom = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aUom = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			  $aUom['id_uom']   = $row->id_uom;
			  $aUom['uom_name'] = strtoupper($row->uom_name);
			  $aUom['lookup'] = strtoupper($row->lookup);
			  $aUom['status'] = $row->status;
		   }
		   return $aUom;
	}
	
	public function updateCheckExist($table,$field,$fieldvalue,$field1,$fieldvalue1)
	{
	 $exists = false;
	 $qry = "select * from $table where $field = '".$fieldvalue."' AND $field1!='".$fieldvalue1."'";
	
	  if($row = $this->oDb->query($qry))
	   {
         $exists = true; 	       
	   }
       return $exists;	
	}
	
	public function updateUom($aRequest, $action)
	{
	   if($action == 'update')
		{
		  $id_uom   = $aRequest['fUomId'];
		  $uom_name = strtoupper($aRequest['fUomName']);
		  $lookup   = strtoupper($aRequest['fLookup']);
		
		   $checkqry = "SELECT * FROM uom WHERE uom_name = '$uom_name' AND lookup = '$lookup' AND id_uom != ".$id_uom;
		
		  $this->oDb->query($checkqry);
		   $num_rows = $this->oDb->num_rows;
	  if($num_rows > 0)
		{
		
			$valid = '2';
			
		}
		else
		{
         $qry = "UPDATE uom SET uom_name = '$uom_name', lookup = '$lookup' WHERE id_uom = ".$id_uom;
			  
			$this->oDb->query($qry);
				if( mysql_affected_rows() >= 0)
				{
				$valid = '1';
				}
				else
				{
				$valid = '0';
				}
		  
		  
		}
		
		}
		else if($action == 'delete')
		{
		  $id_uom  = $aRequest['fUomId'];
		  $qry = "UPDATE uom SET status = 2 WHERE id_uom = ".$id_uom;
		  $valid = false;
		if($this->oDb->query($qry)) {
		 $valid = true;
		} 
		}
		
		return $valid;
	}
	
	
	//Unit
	public function addUnit($aRequest)
	{
	    $unitName = strtoupper($aRequest['fUnitName']);
		$lookup  = strtoupper($aRequest['fLookup']);
		$addr1   = strtoupper($aRequest['fAddr1']);
		$addr2   = strtoupper($aRequest['fAddr2']);
		$addr3   = strtoupper( $aRequest['fAddr3']);
		$city    = $aRequest['fCity'];
		$state   = $aRequest['fState'];
		$country = $aRequest['fCountry'];
		$zipcode = $aRequest['fZipCode'];
		$currency = $aRequest['fCurrency'];
		$bank = $aRequest['fBank'];
		$prefix = $aRequest['fPrefix'];
		
		$qry = "INSERT INTO unit (id_unit, unit_name, lookup, prefix, addr1, addr2, addr3, id_city, id_state, id_country, zipcode, id_currency, id_bank, status) VALUES (null, '$uniName','$lookup','$prefix', '$addr1','$addr2', '$addr3', '$id_city', $id_state, $id_country, '$zipcode', $id_currency, $id_bank, 1)";
			if($this->oDb->query($qry))	{
			  return true;
			}
			else{
			  return false;
			}
	}
	
	
	public function getUnitList()
	{
	    $qry = "SELECT * FROM asset_unit WHERE status!=2";
		$aUnitList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aUnit = array();
				$aUnit['id_unit']   = $row->id_unit;
				$aUnit['unit_name'] = strtoupper($row->unit_name);
				$aUnit['lookup']    = strtoupper( $row->lookup);
				$aUnit['prefix']    = $row->prefix;
				$aUnit['addr1']     = $row->addr1;
				$aUnit['addr2']     = $row->addr2;
				$aUnit['addr3']     = $row->addr3;
				$aUnit['id_city']   = $row->id_city;
				$aCity = $this->getCityInfo($aUnit['id_city'], 'id');
				$aUnit['city_name'] = $aCity['city_name'];
				$aUnit['id_state']  = $row->id_state;
				//$aUnit['state_name']= ($this->getStateName($aUnit['id_city'], 'id'))['city_name'];
				$aUnit['id_country']= $row->id_country;
				$aUnit['zipcode']   = $row->zipcode;
				$aUnit['id_currency'] = $row->id_currency;
				$aUnit['id_bank']     = $row->id_bank;
				$aUnitList[]          = $aUnit;
			}
		}
		return $aUnitList;
	}
	
	public function getUnitInfo($lookup, $type)
	{
	  $qry = "SELECT * FROM asset_unit WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_unit = ".$lookup;
		   }
		   $qry = $qry.$condition;
		 
		   $aUnit = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			  $aUnit['id_unit']   = $row->id_unit;
			  $aUnit['unit_name'] = strtoupper($row->unit_name);
			  $aUnit['id_unit_address'] = $row->id_unit_address;
			  $aUnit['lookup']    = $row->lookup;
			  $aUnit['status']    = $row->status;
		   }
		   return $aUnit;
	}
	
	// Reason
	public function addReason($aRequest)
	{
	    $reasonName = $aRequest['fReasonName'];
		$lookup = $aRequest['fLookup'];
		$category = $aRequest['fCategory'];
		$eff_effect = $aRequest['fEfficiency'];
		$sequence = $aRequest['fSequence'];
		$status = $aRequest['fStatus'];
		$qry = "INSERT INTO reason (id_reason, reason_name, lookup, category, efficiency_effect, sequence, status) VALUES (null, '$reasonName','$lookup','$category','$eff_effect','$sequence', '$status')";
			if($this->oDb->query($qry))	{
			  return true;
			}
			else{
			  return false;
			}
	}
	public function getReasonList()
	{
	   $qry = "SELECT * FROM reason";
		$aReasonList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aReason = array();
				$aReason['id_reason']   = $row->id_reason;
				$aReason['reason_name'] = $row->reason_name;
				$aReason['lookup']      = $row->lookup;
				$aReason['category']    = $row->category;
				$aReason['efficiency_effect'] = $row->efficiency_effect;
				$aReason['sequence']     = $row->sequence;
				$aReason['status']       = $row->status;
				$aReasonList[]           = $aReason;
			}
		}
		return $aReasonList;
	}
	public function getReasonInfo($lookup, $type)
	{
	  $qry = "SELECT * FROM reason WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_reason = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aReason = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			    $aReason['id_reason']   = $row->id_reason;
				$aReason['reason_name'] = $row->reason_name;
				$aReason['lookup']      = $row->lookup;
				$aReason['category']    = $row->category;
				$aReason['efficiency_effect'] = $row->efficiency_effect;
				$aReason['sequence']     = $row->sequence;
				$aReason['status']       = $row->status;
		   }
		   return $aReason;
	}
	public function updateReason($aRequest, $action)
	{
	   if($action == 'update')
		{
		    $id_reason   = $aRequest['fReasonId'];
			$reasonName = $aRequest['fReasonName'];
			$lookup     = $aRequest['fLookup'];
			$category   = $aRequest['fCategory'];
			$eff_effect = $aRequest['fEfficiency'];
			$sequence   = $aRequest['fSequence'];
			$status     = $aRequest['fStatus'];
		  
		  $qry = "UPDATE reason SET reason_name = '$reasonName', lookup = '$lookup', category = '$category', efficiency_effect = '$eff_effect', sequence = '$sequence', status = '$status' WHERE id_reason = ".$id_reason;
		}
		else if($action == 'delete')
		{
		  $id_uom  = $aRequest['fUomId'];
		  $qry = "UPDATE reason SET status = 2 WHERE id_reason = ".$id_reason;
		}
		$valid = false;
		if($this->oDb->query($qry)) {
		 $valid = true;
		} 
		return $valid;
	}
	
	
	//Company
	public function addCompany($aRequest,$files)
	{
	    $companyName = strtoupper($aRequest['fCompanyName']);
		$prefix = strtoupper($aRequest['fPrefix']);
		$lookup = strtoupper($aRequest['fLookup']);
		
		$addr1   = strtoupper($aRequest['fAddr1']);
		$addr2   = strtoupper($aRequest['fAddr2']);
		$addr3   = strtoupper($aRequest['fAddr3']);
		$city    = $aRequest['fCityId'];
		$state   = $aRequest['fStateId'];
		$country = $aRequest['fCountryId'];
		$zipcode = $aRequest['fZipCode'];
		$phone   = $aRequest['fPhone'];
		$fax     = $aRequest['fFax'];
		$email   = $aRequest['fEmail'];
		$id_tin  = $aRequest['fTinNo'];
		$cstnoDate = $aRequest['fCstNoDate'];
		$status    = $aRequest['fStatus'];
		$qry = "INSERT INTO company (id_company, company_name, prefix, lookup, addr1, addr2, addr3, id_city, id_state, id_country, zipcode, phone, fax, email, id_tin,id_cst_date,status) VALUES (null, '$companyName', '$prefix', '$lookup','$addr1','$addr2','$addr3', '$city','$state','$country','$zipcode','$phone','$fax','$email','$id_tin','$cstnoDate', '$status')";
		
			if($this->oDb->query($qry))	{
			  $lastInsertId = $this->oDb->insert_id;
			  if($this->uploadCompanyLogo($files, $lastInsertId))
			   {
				 return true;
			   }
			   else
				 return false; 
	//			 return true;
			}
			else{
			  return false;
			}
	}
	public function uploadCompanyLogo($files, $lastInsertId)
	{
		
		$files['fCompanyLogo']['name'];
		if(!empty($files['fCompanyLogo']['name']))
		{
		   $fileName = $files['fCompanyLogo']['name']; //echo '<br>';
		   $ext      = explode(".", $fileName);
		   $ext      = array_pop($ext);
		   $newFileName = '_logo.'.$ext;
		   $fileup      = $files['fCompanyLogo']['tmp_name']; //echo '<br>';
		   $targetPath 	= APP_ROOT."/uploads/companylogo/"; //echo '<br>';
		   $targetFileName = $lastInsertId.$newFileName; //echo '<br>';
		   move_uploaded_file($fileup, $targetPath.$targetFileName);
		   //update database.
		   $query = "UPDATE company SET company_logo = '".$targetFileName."' WHERE id_company = ".$lastInsertId;
		   
		   if($this->oDb->query($query))
		   {
			 $valid = true;
		   }	 
			return $valid;
		}
	} //upload category image
	public function getCompanyList()
	{
	   $qry = "SELECT * FROM company WHERE status !=2";
		$aCompanyList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aCompany = array();
				$aCompany['id_company']   = $row->id_company;
				$aCompany['company_name'] = strtoupper($row->company_name);
				$aCompany['prefix']       = strtoupper($row->prefix);
				$aCompany['lookup']     = strtoupper($row->lookup);
				$aCompany['addr1']      = strtoupper($row->addr1);
				$aCompany['addr2']      = strtoupper($row->addr2);
				$aCompany['addr3']      = strtoupper($row->addr3);
				$aCompany['id_city']    = $row->id_city;
				$aCompany['id_state']   = $row->id_state;
				$aCompany['id_country'] = $row->id_country;
				$aCompany['zipcode']    = $row->zipcode;
				$aCompany['phone']      = $row->phone;
				$aCompany['fax']        = $row->fax;
				$aCompany['email']      = $row->email;
				$aCompany['company_logo'] = $row->company_logo;
				$aCompany['status']       = $row->status;
				$aCompanyList[]           = $aCompany;
			}
		}
		return $aCompanyList;
	}
	
	public function updateCompany($aRequest, $files, $action)
	{
	   $valid = false;
	   if($action == 'update')
		{
		    $id_company  = $aRequest['fCompanyId'];
			$companyName = strtoupper($aRequest['fCompanyName']);
			$prefix  = strtoupper($aRequest['fPrefix']);
			$lookup  = strtoupper($aRequest['fLookup']);
			$addr1   = strtoupper($aRequest['fAddr1']);
			$addr2   = strtoupper($aRequest['fAddr2']);
			$addr3   = strtoupper($aRequest['fAddr3']);
			$city    = $aRequest['fCityId'];
			$state   = $aRequest['fStateId'];
			$country = $aRequest['fCountryId'];
			$zipcode = $aRequest['fZipCode'];
			$phone   = $aRequest['fPhone'];
			$fax     = $aRequest['fFax'];
			$email   = $aRequest['fEmail'];
			$status  = $aRequest['fStatus'];
			$id_tin  = $aRequest['fTinNo'];
			$cstnoDate = $aRequest['fCstNoDate'];
		  
		  $qry = "UPDATE company SET company_name = '$companyName', prefix = '$prefix',lookup = '$lookup', addr1 = '$addr1', addr2 = '$addr2', addr3 = '$addr3', id_city = '$city',id_state = '$state',id_country = '$country',zipcode = '$zipcode',phone = '$phone',fax = '$fax',email = '$email',id_tin='$id_tin',id_cst_date='$cstnoDate', status = '$status' WHERE id_company = ".$id_company;
		}
		else if($action == 'delete')
		{
		  $id_company  = $aRequest['fCompanyId'];
		  $qry = "UPDATE company SET status = 2 WHERE id_company = ".$id_company;
		}
		
		$this->oDb->query($qry);
			if( mysql_affected_rows() >= 0)
				{
				 $valid = true;
		 if(isset($files))
		  {
		  	if($this->uploadCompanyLogo($files, $id_company))
			   {
				 $valid = true;
			   }
			   
		  }
		}
		 
		return $valid;
	}//
	
	public function getCompanyInfo($lookup, $type)
	{
		$qry = "SELECT * FROM company WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_company = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aCompany = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			   	$aCompany['id_company']   = $row->id_company;
				$aCompany['company_name'] = strtoupper($row->company_name);
				$aCompany['prefix']       = strtoupper($row->prefix);
				$aCompany['lookup']     = strtoupper($row->lookup);
				$aCompany['addr1']      = strtoupper($row->addr1);
				$aCompany['addr2']      = strtoupper($row->addr2);
				$aCompany['addr3']      = strtoupper($row->addr3);
				$aCompany['id_city']    = $row->id_city;
				$aCompany['id_state']   = $row->id_state;
				$aCompany['id_country'] = $row->id_country;
				$aCompany['zipcode']    = $row->zipcode;
				$aCompany['phone']      = $row->phone;
				$aCompany['fax']        = $row->fax;
				$aCompany['email']      = $row->email;
				$aCompany['id_tin']     = $row->id_tin;
				$aCompany['id_cst_date']  = $row->id_cst_date;
				$aCompany['company_logo'] = $row->company_logo;
				$aCompany['status']       = $row->status;
		   }
		   return $aCompany;
	}
	
	public function getPrintCompanyAddress($lookup, $type)
	{
		$qry = "SELECT * FROM company WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_company = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aCompany = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			   	   
			   	$aCompany['id_company']  = $row->id_company;
				$aCompany['company_name']= strtoupper($row->company_name);
				$aCompany['prefix']      = strtoupper($row->prefix);
				$aCompany['phone']       = $row->phone;
				$aCompany['fax']         = $row->fax;
				$aCompany['email']       = $row->email;
				$aCompany['id_tin']      = $row->id_tin;
				$aCompany['id_cst_date'] = $row->id_cst_date;
				$aCompany['company_logo']= $row->company_logo;
				$aCompany['addr1']       = strtoupper($row->addr1);	
				$aCompany['addr2']       = strtoupper($row->addr2);	
				$aCompany['addr3']       = strtoupper($row->addr3);	
				$aCompany['id_city']     = $row->id_city;	
				$aCompany['id_state']    = $row->id_state;	
				$aCompany['id_country']  = $row->id_country;	
				$aCompany['zipcode']     = $row->zipcode;	
				$aCompany['status']      = $row->status;	
				
							
				$city    = $this->getCityInfo($row->id_city,'id');
				$state   = $this->getStateInfo($row->id_state,'id');
				$country = $this->getCountryInfo($row->id_country,'id');
				$aCompany['city_name']      = $city['city_name'];	
				$aCompany['state_name']      = $state['state_name'];	
				$aCompany['country_name']      = $country['country_name'];	
				
						
				$addressFormat='<table style="padding-left: 5px;" >
				<tr><td>'.'<span style="font-size:14px;"><b >'.$aCompany['company_name'].'</b></span><br>'.$row->addr1.'<br>'.$row->addr2.'<br>';if($row->addr3 !="")
				{$addressFormat.=''.$row->addr3.'<br>';}if($city['city_name'] !="" && $row->zipcode !=='')
				{$addressFormat.=''.$city['city_name'].' - '.$row->zipcode.'<br>';}else if($city['city_name'] !="")
				{$addressFormat.=''.$city['city_name'].'<br>';}else if($row->zipcode !="")
				{$addressFormat.=''.$row->zipcode;}
				$addressFormat.='</td></tr>
				</table>
				';
				$aCompany['address_format'] =$addressFormat;
		   }
		   return $aCompany;
	}
	
	public function getCompanyAddress($lookup, $type)
	{
		$qry = "SELECT * FROM company WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_company = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aCompany = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			   	   
			   	$aCompany['id_company']  = $row->id_company;
				$aCompany['company_name']= strtoupper($row->company_name);
				$aCompany['prefix']      = strtoupper($row->prefix);
				$aCompany['phone']       = $row->phone;
				$aCompany['fax']         = $row->fax;
				$aCompany['email']       = $row->email;
				$aCompany['id_tin']      = $row->id_tin;
				$aCompany['id_cst_date'] = $row->id_cst_date;
				$aCompany['company_logo']= $row->company_logo;
				$aCompany['addr1']       = strtoupper($row->addr1);	
				$aCompany['addr2']       = strtoupper($row->addr2);	
				$aCompany['addr3']       = strtoupper($row->addr3);	
				$aCompany['id_city']     = $row->id_city;	
				$aCompany['id_state']    = $row->id_state;	
				$aCompany['id_country']  = $row->id_country;	
				$aCompany['zipcode']     = $row->zipcode;	
				$aCompany['status']      = $row->status;	
				
							
				$city    = $this->getCityInfo($row->id_city,'id');
				$state   = $this->getStateInfo($row->id_state,'id');
				$country = $this->getCountryInfo($row->id_country,'id');
			/*	$addressFormat='<table style="padding-left: 5px;">
				<tr><td style="font-size: 16px;">'.'<b>'.$aCompany['company_name'].'</b></td></tr>
				<td>'.$row->addr1.'</td>
				</tr>';
				if($row->addr2 !="")
				{
					$addressFormat.='
				<tr>
				<td>'.$row->addr2.'</td>
				</tr>';
				}
				if($row->addr3 !="")
				{
					$addressFormat.='
				<tr>
				<td>'.$row->addr3.'</td>
				</tr>';
				}
				if($city['city_name'] !="" && $row->zipcode !=='')
				{
					$addressFormat.='
				<tr>
				<td>'.$city['city_name'].' - '.$row->zipcode.'</td>
				</tr>';
				}
				else if($city['city_name'] !="")
				{
				$addressFormat.='
				<tr>
				<td>'.$city['city_name'].'</td>
				</tr>';
				}
				else if($row->zipcode !="")
				{
				$addressFormat.='
				<tr>
				<td>'.$row->zipcode.'</td>
				</tr>';
				}
				if( $state['state_name'] !="")
				{
					$addressFormat.='
				<tr>
				<td>'. $state['state_name'].'</td>
				</tr>';
				}
				if($country['country_name'] !="")
				{
				$addressFormat.='
				<tr>
				<td>'.$country['country_name'].'</td>
				</tr>';
				}
				$addressFormat.='
				</table>
				';*/
				
				$addressFormat='<table style="padding-left: 5px;" >
				<tr><td>'.'<span style="font-size:14px;"><b >'.$aCompany['company_name'].'</b></span><br>'.$row->addr1.'<br>'.$row->addr2.'<br>';if($row->addr3 !="")
				{$addressFormat.=''.$row->addr3.'<br>';}if($city['city_name'] !="" && $row->zipcode !=='')
				{$addressFormat.=''.$city['city_name'].' - '.$row->zipcode.'<br>';}else if($city['city_name'] !="")
				{$addressFormat.=''.$city['city_name'].'<br>';}else if($row->zipcode !="")
				{$addressFormat.=''.$row->zipcode.'<br>';}if( $state['state_name'] !="")
				{$addressFormat.=''.$state['state_name'].'<br>';}if( $country['country_name'] !="")
				{$addressFormat.=''.$country['country_name'].'<br>';}
				$addressFormat.='</td></tr>
				</table>
				';
				$aCompany['address_format'] =$addressFormat;
		   }
		   return $aCompany;
	}
	
	
	
	//Maintenance - MaintenanceGroup
	public function addMaintenanceGroup($aRequest)
	{
	    $mgName = $aRequest['fMaintenanceGroupName'];
		$status = $aRequest['fStatus'];
		$qry = "INSERT INTO maintenance_group (id_maintenance_group, maintenance_group_name, status) VALUES (null, '$mgName', '$status')";
		//exit();
			if($this->oDb->query($qry))	{
			  return true;
			}
			else{
			  return false;
			}
	}
	public function getMaintenanceGroupList()
	{
	    $qry = "SELECT * FROM maintenance_group";
		$aMaintenanceGroupList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aGroup = array();
				$aGroup['id_maintenance_group']   = $row->id_maintenance_group;
				$aGroup['maintenance_group_name'] = $row->maintenance_group_name;
				$aGroup['status']                 = $row->status;
				$aMaintenanceGroupList[]        = $aGroup;
			}
		}
		return $aMaintenanceGroupList;
	}
	public function getMaintenanceGroupInfo($lookup, $type)
	{
	   $qry = "SELECT * FROM maintenance_group WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_maintenance_group = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aGroup = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			   	$aGroup['id_maintenance_group']   = $row->id_maintenance_group;
				$aGroup['maintenance_group_name'] = $row->maintenance_group_name;
				$aGroup['status']                 = $row->status;
		   }
		   return $aGroup;
	}
	public function updateMaintenanceGroup($aRequest, $action)
	{
	   if($action == 'update')
		{
		    $id_maintenance_group  = $aRequest['fMaintenanceGroupId'];
			$mgName                = $aRequest['fMaintenanceGroupName'];
			$status                = $aRequest['fStatus'];
		  
		   $qry = "UPDATE maintenance_group SET maintenance_group_name = '$mgName', status = '$status' WHERE id_maintenance_group = ".$id_maintenance_group;
		  
		}
		else if($action == 'delete')
		{
		  $id_maintenance_group  = $aRequest['fMaintenanceGroupId'];
		  $qry = "UPDATE maintenance_group SET status = 2 WHERE id_maintenance_group = ".$id_maintenance_group;
		}
		$valid = false;
		if($this->oDb->query($qry)) {
		 $valid = true;
		} 
		return $valid;
	}
	//Maintenance  - Maintenance
	public function addMaintenance($aRequest)
	{
	 /* echo '<pre>';
	  print_r($aRequest);
	  exit();
	  */
	  $from_id_store = $aRequest['fFromStoreId'];
	  $to_id_vendor = $aRequest['fvendorId'];
	  $start_date = $aRequest['fStartDate'];
	  if($start_date !='')
	  {
	  $start_date = date('Y-m-d',strtotime($start_date));
	  }
	  $remarks = $aRequest['fRemarks'];
	  $id_asset_item = $aRequest['fAssetNumber'];
	  $status = '19';
	   $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
	  $qry = "INSERT INTO asset_maintenance(id_asset_maintenance, id_asset_item,id_asset_delivery,from_id_store,to_id_vendor, idle_start_date, idle_end_date, remarks, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$id_asset_item','','$from_id_store','$to_id_vendor',' $start_date','','$remarks','$created_by',now(),'','','$status')";
	  
	  $update_asset = "UPDATE asset_item SET status='$status' WHERE id_asset_item='$id_asset_item'";
	  $this->oDb->query($update_asset);
	  $update_stock = "UPDATE asset_stock SET status='$status' WHERE id_asset_item='$id_asset_item'";
	   $this->oDb->query($update_stock);
	     $valid = false;
		if($this->oDb->query($qry)) {
		 $valid = true;
		} 
		return $valid;
	  
	}
	/*public function getMaintenanceId($lookup)
	{
		$checkqry = "SELECT * FROM asset_maintenance WHERE id_asset_delivery='$lookup'";
		 $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{	
		   $row = $this->oDb->get_row($checkqry);
		   $maintenanceid = $row['id_asset_maintenance'];  
		}
		else
		{
			$aAssetDeliveryDetail = $this->getDeliveryInfo($lookup);
			$aDeliveryItem = $this->getDeliveryItemInfoList($lookup,'delivery');
		
			if($aAssetDeliveryDetail['delivery_type'] =='ESD')
			{
			foreach ($aDeliveryItem  as $AssetItem)
			{
			$aAssetDeliveryItem[] =$AssetItem['id_asset_item'];
			$aMaintenance = array(
			'fFromStoreId' => $aAssetDeliveryDetail['from_id_store'],
			'fvendorId' => $aAssetDeliveryDetail['to_id_vendor'],
			'fStartDate' => $aAssetDeliveryDetail['issue_date'],
			'fAssetNumber' => $aAssetDeliveryItem,
			);
			}
			}
		}
		return $maintenanceid;
	}*/
	
	public function getMaintenanceList($lookup, $type)
	{
	 $qry = "SELECT * FROM asset_maintenance WHERE status != 2 ORDER BY id_asset_maintenance DESC";
		$aMaintenanceList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aMaintenance = array();
				$aMaintenance['id_asset_maintenance']    = $row->id_asset_maintenance;
				$aMaintenance['id_asset_item']    = $row->id_asset_item;
				$aMaintenance['asset_no']    = $this->getAssetNumber( $row->id_asset_item );
				$aMaintenance['from_id_store']    = $row->from_id_store;
				$aMaintenance['store_name']    = $this->getStoreName($row->from_id_store);
				$aMaintenance['vendor_name']    = $this->getVendorName($row->to_id_vendor);
				$aMaintenance['to_id_vendor']     = $row->to_id_vendor;
				$aMaintenance['idle_start_date']  = $row->idle_start_date;
				$aMaintenance['status']     = $row->status;
				$aMaintenanceList[]        = $aMaintenance;
			}
		}
		return $aMaintenanceList;
	}
	
	public function getServiceInvoiceListInfo($lookup)
	{
		$qry = "SELECT * FROM service_invoice WHERE status != 2 AND id_asset_maintenance ='$lookup' ORDER BY id_asset_maintenance DESC";
	
		$aService = array();
		if($row = $this->oDb->get_row($qry))
		{
				$aService['id_service_invoice']    = $row->id_service_invoice;
				$aService['id_asset_item']    = $row->id_asset_item;
				$aService['asset_no']    = $this->getAssetNumber( $row->id_asset_item );
				$aService['from_id_store']    = $row->from_id_store;
				$aService['store_name']    = $this->getStoreName($row->from_id_store);
				$aService['vendor_name']    = $this->getVendorName($row->to_id_vendor);
				$aService['to_id_vendor']     = $row->to_id_vendor;
				$aService['id_asset_maintenance	']  = $row->id_asset_maintenance	;
				$aService['service_type']  = $row->service_type;
				$aService['id_asset_delivery']  = $row->id_asset_delivery;
				$aService['id_vendor']  = $row->id_vendor;
				$aService['for_depreciation']  = $row->for_depreciation;
				$aService['bill_number']  = $row->bill_number;
				$aService['bill_amount']  = $row->bill_amount;
				$aService['bill_date']  = $row->bill_date;
				$aService['created_on']  = $row->created_on;
				$aService['remarks']  = $row->remarks;
				$aService['status']     = $row->status;
			    $aDocument =  $this->getMaintenanceDocument($row->id_service_invoice);
				$aService['document_path']     =  $aDocument['document_path'];
		
			}
			return $aService;
	}
	
	public function getMaintenanceDocument($lookup)
	{
	$qry = "SELECT * FROM maintenance_doc WHERE status != 2 AND id_service_invoice ='$lookup' ORDER BY id_service_invoice DESC";
	
		$aDocument = array();
		if($row = $this->oDb->get_row($qry))
		{
		$aDocument['document_path'] = $row->document_name;
		}
		return 	$aDocument ;
	}
	
	public function getMaintenanceListInfo($lookup)
	{
	$qry = "SELECT * FROM asset_maintenance WHERE status != 2 AND id_asset_item ='$lookup' ORDER BY id_asset_maintenance DESC";
	
		$aMaintenanceListInfo = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aMaintenance = array();
				$aMaintenance['id_asset_maintenance']    = $row->id_asset_maintenance;
				$aMaintenance['id_asset_item']    = $row->id_asset_item;
				$aMaintenance['asset_no']    = $this->getAssetNumber( $row->id_asset_item );
				$aMaintenance['from_id_store']    = $row->from_id_store;
				$aMaintenance['store_name']    = $this->getStoreName($row->from_id_store);
				$aMaintenance['vendor_name']    = $this->getVendorName($row->to_id_vendor);
				$aMaintenance['to_id_vendor']     = $row->to_id_vendor;
				if($row->idle_start_date !='0000-00-00 00:00:00')
				{
				$aMaintenance['idle_start_date']  = date('d-m-Y',strtotime($row->idle_start_date));
				}
				
				$aMaintenance['status']     = $row->status;
				$aServiceInvoice = $this->getServiceInvoiceListInfo($row->id_asset_maintenance);
				$aMaintenance['bill_number']     = $aServiceInvoice['bill_number'];
				$aMaintenance['bill_amount']     = $aServiceInvoice['bill_amount'];
				$aMaintenance['bill_date']     = $aServiceInvoice['bill_date'];
				
				if($aServiceInvoice['created_on'] !='0000-00-00 00:00:00')
				{
				$aMaintenance['bill_created_on'] = date('d-m-Y',strtotime($aServiceInvoice['created_on']));
				}
				
				if($aServiceInvoice['for_depreciation'] == 1)
				{
				$aMaintenance['for_depreciation']  = 'yes';
				}
				else
				{
				$aMaintenance['for_depreciation']  = 'no';
				}
				$aMaintenance['remarks']     = $aServiceInvoice['remarks'];
				$aMaintenance['document_path']     = $aServiceInvoice['document_path'];
				
				$aMaintenanceListInfo['maintenance'][]        = $aMaintenance;
			}
		}
		return $aMaintenanceListInfo;
	}
	public function getMaintenanceInfo($lookup, $type,$lookup1 = '')
	{
	 $qry = "SELECT * FROM asset_maintenance WHERE status != 2";
	 if($type == 'id_asset_item')
	 {
	 $conditions = " AND id_asset_item='$lookup'";
	 }
	  if($type == 'delivery')
	 {
	 $conditions = " AND id_asset_item='$lookup' AND id_asset_delivery='$lookup1'";
	 }
	 else
	 {
	  $conditions = " AND id_asset_maintenance='$lookup'";
	 }
	  $qry =  $qry.$conditions;
	  $aMaintenanceInfo = array();
		if($row = $this->oDb->get_row($qry))
		{		$aMaintenanceInfo['id_asset_maintenance']    = $row->id_asset_maintenance;
				$aMaintenanceInfo['id_asset_item']    = $row->id_asset_item;
				$aMaintenanceInfo['asset_no']    = $this->getAssetNumber( $row->id_asset_item );
				$aMaintenanceInfo['from_id_store']    = $row->from_id_store;
				$aMaintenanceInfo['store_name']    = $this->getStoreName($row->from_id_store);
				$aMaintenanceInfo['vendor_name']    = $this->getVendorName($row->to_id_vendor);
				$aMaintenanceInfo['to_id_vendor']     = $row->to_id_vendor;
				$aMaintenanceInfo['idle_start_date']  = $row->idle_start_date;
				$aMaintenanceInfo['status']     = $row->status;
		}
		return $aMaintenanceInfo;
	}
	public function addBillEntry($aRequest,$files)
	{
	
$storeDeliveryId = $aRequest['fStoreDeliveryId'];
$from_storeid = $aRequest['fFromstoreId'];
$vendor_id = $aRequest['fVendorId'];
$remarks = $aRequest['fRemarks'];
$created_by        = $_SESSION['sesCustomerInfo']['user_id'];
$bill_no =$aRequest['fBillNumber']; 
$bill_tot_amount =$aRequest['fBillTotalAmount']; 
 $bill_date = $aRequest['fBillDate'];
	  if( $bill_date!='')
	  {
	   $bill_date = date('Y-m-d',strtotime( $bill_date));
	  }
 $aInsertvalues = array_map(null,$aRequest['fAssetItemId'],$aRequest['fBillAmount']);
	 $checkqry = "SELECT * FROM asset_maintenance WHERE id_asset_delivery='$storeDeliveryId'";
		 $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{	
			  if($result = $this->oDb->get_results($checkqry))
			{
				foreach($result as $row)
				{
				 $id_maintenance=$row->id_asset_maintenance; 
				 	foreach($aInsertvalues as $aItem)
		           {		
		$asset_value = in_array($value,array_values($aRequest['fForDepreciation']));
								if(!( in_array($value,array_values($aRequest['fForDepreciation'])))) {
								$dep = 1;
								}
								else
								{
								$dep = 0;
								}
			
				 $query   = "INSERT INTO service_invoice(id_service_invoice, id_asset_item, id_asset_maintenance, service_type, id_asset_delivery, id_vendor, for_depreciation, service_cost, bill_number, bill_amount,bill_total_amt, bill_date, remarks, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$aItem[0]','$id_maintenance','','$storeDeliveryId','$vendor_id','$dep','','$bill_no','$aItem[1]','$bill_tot_amount','$bill_date','$remarks','$created_by',now(),'','','1')";
		
		 $update_asset = "UPDATE asset_item SET status='1' WHERE id_asset_item='$aItem[0]'";
	  $this->oDb->query($update_asset);
	  
	   $update_mainten = "UPDATE asset_maintenance SET status='1',idle_end_date=now(),modified_by='$created_by',modified_on=now() WHERE id_asset_maintenance	='$id_maintenance'";
	  $this->oDb->query($update_mainten);
							if($this->oDb->query($query))	{
							 $update_dely= "UPDATE asset_delivery_item SET bill_status='1' WHERE id_asset_item='$aItem[0]' AND id_asset_delivery='$storeDeliveryId'";
	  $this->oDb->query($update_dely);
							$lastInsertId = $this->oDb->insert_id;
		  	   if($this->uploadServiceBillDocument($aRequest,$files,$lastInsertId))
			   {
			    return true; 
			   }
							return true;
							}
							else
							{
							return false;
							}
	
				} // end for item
			}// foreach end for maintenance
		 } // if end for row
		}
		else
		{
		foreach($aInsertvalues as $aItem)
		{		
		$asset_value = in_array($value,array_values($aRequest['fForDepreciation']));
		if(!( in_array($value,array_values($aRequest['fForDepreciation'])))) {
		$dep = 1;
		}
		else
		{
		$dep = 0;
		}
		 $qry_mainat = "INSERT INTO asset_maintenance(id_asset_maintenance, id_asset_item,id_asset_delivery,from_id_store,to_id_vendor, idle_start_date, idle_end_date, remarks, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$aItem[0]','$storeDeliveryId','$from_storeid','$vendor_id',now(),'','$remarks','$created_by',now(),'','','1')";
		   $this->oDb->query($qry_mainat);
		   	$lastInsertId = $this->oDb->insert_id;
		  $query   = "INSERT INTO service_invoice(id_service_invoice, id_asset_item, id_asset_maintenance, service_type, id_asset_delivery, id_vendor, for_depreciation, service_cost, bill_number, bill_amount,bill_total_amt, bill_date, remarks, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$aItem[0]','$lastInsertId','','$storeDeliveryId','$vendor_id','$dep','','$bill_no','$aItem[1]','$bill_tot_amount','$bill_date','$remarks','$created_by',now(),'','','1')";
		
		 $update_asset = "UPDATE asset_item SET status='1' WHERE id_asset_item='$aItem[0]'";
	  $this->oDb->query($update_asset);
	  
	   $update_mainten = "UPDATE asset_maintenance SET status='1',idle_end_date=now(),modified_by='$created_by',modified_on=now() WHERE id_asset_maintenance	='$lastInsertId'";
	  $this->oDb->query($update_mainten);
	if($this->oDb->query($query))	{
	 $update_dely= "UPDATE asset_delivery_item SET bill_status='1' WHERE id_asset_item='$aItem[0]' AND id_asset_delivery='$storeDeliveryId'";
	  $this->oDb->query($update_dely);
	$lastInsertId = $this->oDb->insert_id;
		  	   if($this->uploadServiceBillDocument($aRequest,$files,$lastInsertId))
			   {
			    return true; 
			   }
	return true;
	}
	else
	{
	return false;
	}
	
		 }
		}
			
	}
	public function updateMaintenance($aRequest,$files)
	{
	/*echo '<pre>'; print_r($aRequest); print_r($files);echo '</pre>'; exit();*/
	
	   $bill_no    = $aRequest['fBillNumber'];
	  $bill_date = $aRequest['fBillDate'];
	  $bill_amount = $aRequest['fBillAmount'];
	  $for_depr= $aRequest['fForDepreciation'];
	  $id_asset_item = $aRequest['fAssetNumber']; 
	  $remarks = $aRequest['fRemarks'];
	  $id_maintenance = $aRequest['fMaintenanceId'];
	   $id_vendor = $aRequest['fVendorId'];
	   $depr = 0;
	  if($for_depr == 'on')
	  {
	  $depr = '1';
	  }
	  
	  if( $bill_date!='')
	  {
	   $bill_date = date('Y-m-d',strtotime( $bill_date));
	  }
    $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		 $query   = "INSERT INTO service_invoice(id_service_invoice, id_asset_item, id_asset_maintenance, service_type, id_asset_delivery, id_vendor, for_depreciation, service_cost, bill_number, bill_amount, bill_date, remarks, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$id_asset_item','$id_maintenance','','','$id_vendor','$depr','','$bill_no','$bill_amount','$bill_date','$remarks','$created_by',now(),'','','1')";
		
		 $update_asset = "UPDATE asset_item SET status='1' WHERE id_asset_item='$id_asset_item'";
	  $this->oDb->query($update_asset);
	  
	   $update_mainten = "UPDATE asset_maintenance SET status='12',idle_end_date=now(),modified_by='$created_by',modified_on=now() WHERE id_asset_maintenance	='$id_maintenance'";
	  $this->oDb->query($update_mainten);
	  
	  $update_stock = "UPDATE asset_stock SET status='1' WHERE id_asset_item='$id_asset_item'";
	   $this->oDb->query($update_stock);
		
				if($this->oDb->query($query))	{
				$lastInsertId = $this->oDb->insert_id;
		  	   if($this->uploadServiceBillDocument($aRequest,$files,$lastInsertId))
			   {
			    return true; 
			   }
		     return true; 	 
		}
		else{
		  return false;
		  
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  
		}	}
		
	 public function uploadServiceBillDocument($aRequest,$files,$lastInsertId)
	{
		 $id_maintenance = $aRequest['fMaintenanceId'];
		   $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		
		 $files['fUploadDocument']['name'];
		if(!empty($files['fUploadDocument']['name']))
		{
		
		 $fileName = $files['fUploadDocument']['name']; //echo '<br>';
		 		   
		  $ext = explode(".", $fileName);
		   $ext = array_pop($ext);
		   $name = strtotime(date('Y-m-d h:i:s'));
		   $newFileName = $name.'_document.'.$ext;
		   $fileup = $files['fUploadDocument']['tmp_name']; //echo '<br>';
		    $targetPath 	= APP_ROOT."/uploads/servicedocument/"; //echo '<br>';
		   $targetFileName = $lastInsertId.'_'.$newFileName; //echo '<br>';
		   move_uploaded_file($fileup, $targetPath.$targetFileName);
		
		   //update database.
		   
		  $checkqry = "SELECT * FROM maintenance_doc WHERE id_service_invoice='$lastInsertId'";
		 $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{		   
		  $query = "UPDATE maintenance_doc SET id_service_invoice='".$lastInsertId."',document_name='".$targetFileName."',modified_by='".$created_by."',modified_on=now() WHERE id_service_invoice = ".$lastInsertId;
		   }
		   else
		   {
		 $query = "INSERT INTO maintenance_doc(id_maintenance_doc, id_service_invoice, id_maintenance, document_name, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'".$lastInsertId."','$id_maintenance','".$targetFileName."','".$created_by."',now(),'','','1')";
		   }
		   
		   if($this->oDb->query($query))
		   {
			 $valid = true;
		   }
		   else
		   {
		   $valid = false;
		   }
		  		  
			return $valid;
		}
		
		
	} 
	
	//Maintenance - Fault
	public function addFault($aRequest)
	{
	  $faultName = $aRequest['fFaultName'];
	  $lookup = $aRequest['fLookup'];
	  $status = $aRequest['fStatus'];
	  $qry = "INSERT INTO fault (id_fault, fault_name, lookup, status) VALUES (null, '$faultName', '$lookup', '$status')";
	 
		   if($this->oDb->query($qry))	{
			  return true;
			}
			else{
			  return false;
			}
	}
	public function getFaultList($lookup, $type)
	{
	    $qry = "SELECT * FROM fault WHERE status != 2";
		$aFaultList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aFault = array();
				$aFault['id_fault']   = $row->id_fault;
				$aFault['fault_name'] = $row->fault_name;
				$aFault['lookup']     = $row->lookup;
				$aFault['status']     = $row->status;
				$aFaultList[]        = $aFault;
			}
		}
		return $aFaultList;
	}
	public function getFaultInfo($lookup, $type)
	{
	       $qry = "SELECT * FROM fault WHERE status != 2 and ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_fault = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aFault = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			   	$aFault['id_fault']   = $row->id_fault;
				$aFault['fault_name'] = $row->fault_name;
				$aFault['lookup'] = $row->lookup;
				$aFault['status'] = $row->status;
		   }
		   return $aFault;
	}
	public function updateFault($aRequest, $action)
	{
	  if($action == 'update')
		{
		    $id_fault  = $aRequest['fFaultId'];
			$faultName = $aRequest['fFaultName'];
			$lookup    = $aRequest['fLookup'];
			$status    = $aRequest['fStatus'];
		    $qry = "UPDATE fault SET fault_name = '$faultName', lookup = '$lookup', status = '$status' WHERE id_fault = ".$id_fault;
		  
		}
		else if($action == 'delete')
		{
		  $id_fault  = $aRequest['fFaultId'];
		 $qry = "UPDATE fault SET status = 2 WHERE id_fault = ".$id_fault;
		
		}
		$valid = false;
		if($this->oDb->query($qry)) {
		 $valid = true;
		} 
		return $valid;
	}
	
	
	
	//Setup = TaxForm
	public function addTaxForm($aRequest)
	{
	  $taxformName = strtoupper($aRequest['fTaxFormName']);
	  $addless= $aRequest['fAddLess'];
	  $tax_percentage= $aRequest['fTaxPercentage'];
	  $lookup = strtoupper($aRequest['fLookup']);
	  $status = $aRequest['fStatus'];
	  $qry = "INSERT INTO taxform (id_taxform, taxform_name,tax_percentage,addless,lookup, status) VALUES (null, '$taxformName','$tax_percentage','$addless' ,'$lookup', '$status')";
	 
		   if($this->oDb->query($qry))	{
			  return true;
			}
			else{
			  return false;
			}
	}
	public function getTaxFormList($lookup, $type)
	{
	    $qry = "SELECT * FROM taxform ORDER BY id_taxform DESC";
		$aTaxFormList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aTaxForm = array();
				$aTaxForm['id_taxform']   = $row->id_taxform;
				$aTaxForm['taxform_name'] = $row->taxform_name;
				$aTaxForm['tax_percentage'] = $row->tax_percentage;
				$aTaxForm['addless'] = $row->addless;
				$aTaxForm['lookup']     = $row->lookup;
				$aTaxForm['status']     = $row->status;
				$aTaxFormList[]        = $aTaxForm;
			}
		}
		return $aTaxFormList;
	}
	public function getTaxFormInfo($lookup, $type)
	{
	       $qry = "SELECT * FROM taxform WHERE status != 2 and ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_taxform = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aTaxForm = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			   	$aTaxForm['id_taxform']   = $row->id_taxform;
				$aTaxForm['taxform_name'] = $row->taxform_name;
				$aTaxForm['tax_percentage'] = $row->tax_percentage;
				$aTaxForm['addless'] = $row->addless;
				$aTaxForm['lookup'] = $row->lookup;
				$aTaxForm['status'] = $row->status;
		   }
		   return $aTaxForm;
	}
	public function updateTaxForm($aRequest, $action)
	{
	  if($action == 'update')
		{
		    $id_taxform  = $aRequest['fTaxFormId'];
			$taxFormName = strtoupper($aRequest['fTaxFormName']);
			$lookup    = strtoupper($aRequest['fLookup']);
			$status    = $aRequest['fStatus'];
			 $addless= $aRequest['fAddLess'];
	  $tax_percentage= $aRequest['fTaxPercentage'];
	   $checkqry = "SELECT * FROM  taxform WHERE taxform_name = '$taxFormName' AND id_taxform != ".$id_taxform;
		  $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
	  if(	$num_rows > 0)
		{
		
			$valid = '2';
			
		}
		else
		{
         $qry = "UPDATE taxform SET taxform_name = '$taxFormName',tax_percentage='$tax_percentage', addless='$addless',lookup = '$lookup', status = '$status' WHERE id_taxform = ".$id_taxform;
			   $this->oDb->query($qry);
				if( mysql_affected_rows() >= 0)
				{
				$valid = '1';
				}
				else
				{
				$valid = '0';
				}
		  
		  
		}
		}
		else if($action == 'delete')
		{
		  $id_taxform  = $aRequest['fTaxFormId'];
		  $qry = "UPDATE taxform SET status = 2 WHERE id_taxform = ".$id_taxform;
		  $valid = false;
		if($this->oDb->query($qry)) {
		 $valid = true;
		} 
		}
		
		return $valid;
	}
	
	
	
	
	
	
	//Address of various entities: Unit address, Vendor/supplier address, 
	public function addAddress($aRequest)
	{
	}
	public function getAddressList($lookup, $type)
	{
	}
	public function getAddressInfo($lookup, $type)
	{
	}
	public function updateAddress($aRequest, $action)
	{
	}
	
	//Unit Address
	
	public function addUnitAddress($aRequest,$unitId)
	{
		//add a new Contact.
		
		if($unitId == '')
		{
		$unitId    = $aRequest['fUnitId'];
		}
		else
		{
			$unitId;
		}
		$contactName = strtoupper($aRequest['fContactName']);
		$addr1     = $aRequest['fAddr1'];
		$addr2     = $aRequest['fAddr2'];
		$addr3     = $aRequest['fAddr3'];
		$id_city   = $aRequest['fCityId'];
		$id_state     =  $aRequest['fStateId'];
		$id_country   =  $aRequest['fCountryId'];
		$zipcode = $aRequest['fZipCode'];
		$phone = $aRequest['fPhone'];
		$fax = $aRequest['fFax'];
		$email = $aRequest['fEmail'];
		$website = $aRequest['fWebsite'];
		$status   = $aRequest['fStatus'];
		  $qry = "INSERT INTO contact (id_contact, contact_name, addr1, addr2,addr3,id_city,id_state,id_country,zipcode,phone,fax,email,website,status) VALUES (null, '$contactName','$addr1','$addr2','$addr3','$id_city','$id_state','$id_country','$zipcode','$phone','$fax','$email','$website','$status')";
		
		
		if($this->oDb->query($qry))	{
		   $lastInsertId = $this->oDb->insert_id;
		   if($this->updateUnitAddressId($unitId,$lastInsertId))
		   {
	        $done=1;
		   }
		   else
		   {
		    $done=0;
		   }
		   if($done == 1)
		   {
		   return $lastInsertId;
		   }
		   else
		   {
			   return false;
		   }
		}
		else{
		  return false;
		}
	}
	
	public function getUnitAddress($lookup, $unitname,$type)
	{
		$qry = "SELECT id_contact, contact_name, addr1, addr2,id_city,id_state,id_country, zipcode,phone,fax,email,website,status FROM contact WHERE ";
	   if($type == 'lookup') {
	   	 $condition = " contact_name = '$lookup'";
	   }
	   else {
	     $condition = " id_contact = ".$lookup;
	   }
	  $qry = $qry.$condition;
	 
	   $aContact = array();
	   if($row = $this->oDb->get_row($qry))
	   {
	            $city = $this->getCityInfo($row->id_city,'id');
				$state = $this->getStateInfo($row->id_state,'id');
				$country = $this->getCountryInfo($row->id_country,'id');
				
				$addressFormat='<table style="padding-left: 10px;">
				<tr><td>'.'<span style="font-size:12px;"><b >'.strtoupper($unitname).'</b></span><br>'.strtoupper($row->addr1).'<br>';if($row->addr2 !="")
				{$addressFormat.=''.strtoupper($row->addr2).'<br>';}
				if($row->addr3 !="")
				{$addressFormat.=''.strtoupper($row->addr3).'<br>';}
				if($city['city_name'] !="" && $row->zipcode !=='')
				{$addressFormat.=''.$city['city_name'].' - '.$row->zipcode.'<br>';}else if($city['city_name'] !="")
				{$addressFormat.=''.$city['city_name'].'<br>';}else if($row->zipcode !="")
				{$addressFormat.=''.$row->zipcode.'<br>';}if( $state['state_name'] !="")
				{$addressFormat.=''.$state['state_name'].'<br>';}if( $country['country_name'] !="")
				{$addressFormat.=''.$country['country_name'].'<br>';}if( $row->phone !="")
				{$addressFormat.='PHONE :'.$row->phone.'; ';}if( $row->fax !="")
				{$addressFormat.='FAX :'.$row->fax.'; <br>';}if( $row->email !="")
				{$addressFormat.='EMAIL :'.$row->email.' ';}
				$addressFormat.='<br></td></tr>
				</table>
				';
				$aContact['address_format'] =$addressFormat;
						
	   }
	   return $aContact;
	}
	
	public function getPrintUnitAddress($lookup, $unitname,$type)
	{
		$qry = "SELECT id_contact, contact_name, addr1, addr2,id_city,id_state,id_country, zipcode,phone,fax,email,website,status FROM contact WHERE ";
	   if($type == 'lookup') {
	   	 $condition = " contact_name = '$lookup'";
	   }
	   else {
	     $condition = " id_contact = ".$lookup;
	   }
	  $qry = $qry.$condition;
	 
	   $aContact = array();
	   if($row = $this->oDb->get_row($qry))
	   {
	            $city = $this->getCityInfo($row->id_city,'id');
				$state = $this->getStateInfo($row->id_state,'id');
				$country = $this->getCountryInfo($row->id_country,'id');
				$aContact['unitname'] = strtoupper($unitname);
				$aContact['addr1'] = strtoupper($row->addr1);	
				$aContact['addr2'] =strtoupper($row->addr2);
				$aContact['addr3'] = strtoupper($row->addr3);
				$aContact['city_name'] =$city['city_name'];
				$aContact['zipcode'] = $row->zipcode;
				$addressFormat='<table style="padding-left: 10px;">
				<tr><td>'.'<span style="font-size:12px;"><b >'.strtoupper($unitname).'</b></span><br>'.strtoupper($row->addr1).'<br>';if($row->addr2 !="")
				{$addressFormat.=''.strtoupper($row->addr2).'<br>';}
				if($row->addr3 !="")
				{$addressFormat.=''.strtoupper($row->addr3).'<br>';}
				if($city['city_name'] !="" && $row->zipcode !=='')
				{$addressFormat.=''.$city['city_name'].' - '.$row->zipcode.'<br>';}else if($city['city_name'] !="")
				{$addressFormat.=''.$city['city_name'].'<br>';}else if($row->zipcode !="")
				{$addressFormat.=''.$row->zipcode;}
				$addressFormat.='</td></tr>
				</table>
				';
				$aContact['address_format'] =$addressFormat;
						
	   }
	   return $aContact;
	}
	
	public function updateUnitAddress($aRequest, $action) //action -> update, delete
	{
		if($action == 'update')
		{
			$id_contact = $aRequest['fContactId'];
			$contactName= strtoupper($aRequest['fContactName']);
			$addr1      = strtoupper($aRequest['fAddr1']);
			$addr2      = strtoupper($aRequest['fAddr2']);
			$addr3      = strtoupper($aRequest['fAddr3']);
			$id_city    = $aRequest['fCityId'];
			$id_state   = $aRequest['fStateId'];
			$id_country = $aRequest['fCountryId'];
			$zipcode    = $aRequest['fZipCode'];
			$phone      = $aRequest['fPhone'];
			$fax     = $aRequest['fFax'];
			$email   = $aRequest['fEmail'];
			$website = $aRequest['fWebsite'];
			$status  = $aRequest['fStatus'];
          $qry = "UPDATE contact SET contact_name = '$contactName', addr1 = '$addr1', addr2 = '$addr2',addr3 = '$addr3', id_city = '$id_city', id_state = '$id_state', id_country = '$id_country', zipcode = '$zipcode', phone = '$phone', fax = '$fax', email = '$email', website = '$website', status = '$status' WHERE id_contact = ".$id_contact;
		}
		else if($action == 'delete')
		{
		  if(is_array($aRequest)) {
		  $id_contact  = $aRequest['fContactId'];
		  }
		  else $id_contact = $aRequest;
		  $qry = "UPDATE contact SET status = 2 WHERE id_contact =".$id_contact;
		  $qry = "DELETE FROM vendor_contact_map WHERE id_contact = ".$id_contact;	
		 $this->oDb->query($qry);
			 $valid = true;	 
		}
		
		$valid = false;
		if($this->oDb->query($qry)) {
		 $valid = true;
		} 
		return $valid;
	}
	
	
	public function updateUnitAddressId($reff_id,$lastInsertId)
   {
	  $query = "UPDATE asset_unit SET  id_unit_address = '". $lastInsertId."' WHERE id_unit = ".$reff_id;
		  
		 
		   if($this->oDb->query($query))
		   {
			 $valid = true;
		   }	 
		
	    
	    else { //exit();
	     $valid =  false;
	   }
	  
	   return $valid;	 
}
	//Vendor Contact 
	public function addContact($aRequest,$vendorid=null)
	{
		//add a new Contact.
		
		if($vendorid != '')
		{
			$vendorid;
		}
		else
		{
			
			$vendorid    = $aRequest['fVendorId'];
		}
		
		$contactName = strtoupper($aRequest['fContactName']);
		$addr1     = strtoupper($aRequest['fAddr1']);
		$addr2     = strtoupper($aRequest['fAddr2']);
		$addr3     = strtoupper($aRequest['fAddr3']);
		$id_city   = $aRequest['fCityId'];
		$id_state     =  $aRequest['fStateId'];
		$id_country   =  $aRequest['fCountryId'];
		$zipcode = $aRequest['fZipCode'];
		$phone = $aRequest['fPhone'];
		$fax = $aRequest['fFax'];
		$email = $aRequest['fEmail'];
		$website = $aRequest['fWebsite'];
		$status   = $aRequest['fStatus'];
		$qry = "INSERT INTO contact (id_contact, contact_name, addr1, addr2,addr3,id_city,id_state,id_country,zipcode,phone,fax,email,website,status) VALUES (null, '$contactName','$addr1','$addr2','$addr3','$id_city','$id_state','$id_country','$zipcode','$phone','$fax','$email','$website','$status')";
		
		if($this->oDb->query($qry))	{
		   $lastInsertId = $this->oDb->insert_id;
		   if($this->addVendorContactMap($vendorid , $lastInsertId))
		   {
	        $done=1;
		   }
		   else
		   {
		    $done=0;
		   }
		   if($done == 1)
		   {
		   return $lastInsertId;
		   }
		   else
		   {
			   return false;
		   }
		}
		else{
		  return false;
		}
	}
	public function addVendorContactMap($vendorid,$contactid)
	{
		$qry = "INSERT INTO vendor_contact_map (id_vendor_contact_map, id_vendor, id_contact)VALUES (null, '$vendorid','$contactid')";
		if($this->oDb->query($qry))	{
		  return true;
		}
		else{
		  return false;
		}
	}
	public function getContactList()
	{
		$qry = "SELECT * FROM contact WHERE status != 2";
		$aContactList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aContact = array();
				$aContact['id_contact']   = $row->id_contact;
				$aContact['contact_name'] = strtoupper($row->contact_name);
				$aContact['addr1']       = $row->addr1;
				$aContact['addr2']       = $row->addr2;
				$aContact['id_city']     = $row->id_city;
				$aContact['id_state']    = $row->id_state;
				$aContact['id_country']  = $row->id_country;
				$aContact['zipcode']     = $row->zipcode;
				$aContact['phone']       = $row->phone;
				$aContact['fax']         = $row->fax;
				$aContact['email']       = $row->email;
				$aContact['website']     = $row->website;
				$aContact['status']      = $row->status;
				$aContactList[]          = $aContact;
			}
		}
		return $aContactList;
	} //
	public function getVendorAddressFormat($lookup,$vendorname,$type )
	{
		
		$qry = "SELECT addr1, addr2,addr3,city,state,country,pincode,phone1,phone2,email1,email2,fax1,fax2,contact_person1,contact_person2,company_name,status FROM addresses WHERE ";
	   if($type == 'lookup') {
	   	 $condition = " company_name = '$lookup'";
	   }
	   else {
	     $condition = " id_address = ".$lookup;
	   }
	   $qry = $qry.$condition;
	   
	   $aContact = array();
	   if($row = $this->oDb->get_row($qry))
	   {
	            $city = $this->getCityInfo($row->city,'id');
				$state = $this->getStateInfo($row->state,'id');
				$country = $this->getCountryInfo($row->country,'id');
		$addressFormat='<table style="padding-left: 10px;">
				<tr><td>'.'<span style="font-size:12px;"><b >'.strtoupper($vendorname).'</b></span><br>'.strtoupper($row->contact_person1).'<br>'.strtoupper($row->addr1).'<br>';if($row->addr2 !="")
				{$addressFormat.=''.strtoupper($row->addr2).'<br>';}
				if($row->addr3 !="")
				{$addressFormat.=''.strtoupper($row->addr3).'<br>';}
				if($city['city_name'] !="" && $row->pincode !=='')
				{$addressFormat.=''.$city['city_name'].' - '.$row->pincode.'<br>';}else if($city['city_name'] !="")
				{$addressFormat.=''.$city['city_name'].'<br>';}else if($row->pincode !="")
				{$addressFormat.=''.$row->pincode;}/*if( $state['state_name'] !="")
				{$addressFormat.=''.$state['state_name'].'<br>';}if( $country['country_name'] !="")
				{$addressFormat.=''.$country['country_name'].'<br>';}if( $row->phone1 !="")
				{$addressFormat.='PHONE :'.$row->phone1.'; ';}if( $row->fax1 !="")
				{$addressFormat.='FAX :'.$row->fax1.'; <br>';}if( $row->email1 !="")
				{$addressFormat.='EMAIL :'.$row->email1.' ';}*/
				$addressFormat.='</td></tr>
				</table>
				';
				$aContact['address_format'] =$addressFormat;
	}
	   return $aContact;
	}
	public function getAddressFormat($lookup,$vendorname,$type)
	{
		if($lookup != '')
		{
		$qry = "SELECT id_contact, contact_name, addr1, addr2,id_city,id_state,id_country, zipcode,phone,fax,email,website,status FROM contact WHERE ";
	   if($type == 'lookup') {
	   	 $condition = " contact_name = '$lookup'";
	   }
	   else {
	     $condition = " id_contact = ".$lookup;
	   }
	   $qry = $qry.$condition;
	   $aContact = array();
	   if($row = $this->oDb->get_row($qry))
	   {
	            $city = $this->getCityInfo($row->id_city,'id');
				$state = $this->getStateInfo($row->id_state,'id');
				$country = $this->getCountryInfo($row->id_country,'id');
				$addressFormat='<table style="padding-left: 10px;">
				<tr><td style="font-size:12px;">'.'<span><b >'.strtoupper($vendorname).'</b></span><br>'.strtoupper($row->contact_name).'<br>'.strtoupper($row->addr1).'<br>';if($row->addr2 !="")
				{$addressFormat.=''.strtoupper($row->addr2).'<br>';}
				if($row->addr3 !="")
				{$addressFormat.=''.strtoupper($row->addr3).'<br>';}
				if($city['city_name'] !="" && $row->zipcode !=='')
				{$addressFormat.=''.$city['city_name'].' - '.$row->zipcode.'<br>';}else if($city['city_name'] !="")
				{$addressFormat.=''.$city['city_name'].'<br>';}else if($row->zipcode !="")
				{$addressFormat.=''.$row->zipcode;}/*if( $state['state_name'] !="")
				{$addressFormat.=''.$state['state_name'].'<br>';}if( $country['country_name'] !="")
				{$addressFormat.=''.$country['country_name'].'<br>';}if( $row->phone !="")
				{$addressFormat.='PHONE :'.$row->phone.'; ';}if( $row->fax !="")
				{$addressFormat.='FAX :'.$row->fax.'; <br>';}if( $row->email !="")
				{$addressFormat.='EMAIL :'.$row->email.' ';}*/
				$addressFormat.='</td></tr>
				</table>
				';
				$aContact['address_format'] =$addressFormat;
			
				
	   }
		}
		else
		{
			$addressFormat='<table style="padding-left: 10px;">
				<tr><td style="font-size:12px;">'.'<span><b >'.strtoupper($vendorname).'</b></span><br>'.strtoupper($row->contact_name).'<br>'.strtoupper($row->addr1).'<br>';if($row->addr2 !="")
				{$addressFormat.=''.strtoupper($row->addr2).'<br>';}
				if($row->addr3 !="")
				{$addressFormat.=''.strtoupper($row->addr3).'<br>';}
				if($city['city_name'] !="" && $row->zipcode !=='')
				{$addressFormat.=''.$city['city_name'].' - '.$row->zipcode.'<br>';}else if($city['city_name'] !="")
				{$addressFormat.=''.$city['city_name'].'<br>';}else if($row->zipcode !="")
				{$addressFormat.=''.$row->zipcode;}/*if( $state['state_name'] !="")
				{$addressFormat.=''.$state['state_name'].'<br>';}if( $country['country_name'] !="")
				{$addressFormat.=''.$country['country_name'].'<br>';}if( $row->phone !="")
				{$addressFormat.='PHONE :'.$row->phone.'; ';}if( $row->fax !="")
				{$addressFormat.='FAX :'.$row->fax.'; <br>';}if( $row->email !="")
				{$addressFormat.='EMAIL :'.$row->email.' ';}*/
				$addressFormat.='</td></tr>
				</table>
				';
				$aContact['address_format'] =$addressFormat;
		}
		
	   return $aContact;
	}
	
	public function getFullAddressFormat($lookup,$vendorname,$type)
	{
		 $qry = "SELECT id_contact,contact_name, addr1, addr2,id_city,id_state,id_country, zipcode,phone,fax,email,website,status FROM contact WHERE ";
	   if($type == 'lookup') {
	   	 $condition = " contact_name = '$lookup'";
	   }
	   else {
	     $condition = " id_contact = ".$lookup;
	   }
	  $qry = $qry.$condition;
	   $aContact = array();
	   if($row = $this->oDb->get_row($qry))
	   {
	            $city = $this->getCityInfo($row->id_city,'id');
				$state = $this->getStateInfo($row->id_state,'id');
				$country = $this->getCountryInfo($row->id_country,'id');
				$aContact['contact_name'] = $row->contact_name ;
				
				$addressFormat='<table style="padding-left: 10px;">
				<tr><td style="font-size:12px;">'.'<span><b >'.strtoupper($vendorname).'</b></span><br>'.strtoupper($row->contact_name).'<br>'.strtoupper($row->addr1).'<br>';if($row->addr2 !="")
				{$addressFormat.=''.strtoupper($row->addr2).'<br>';}
				if($row->addr3 !="")
				{$addressFormat.=''.strtoupper($row->addr3).'<br>';}
				if($city['city_name'] !="" && $row->zipcode !=='')
				{$addressFormat.=''.$city['city_name'].' - '.$row->zipcode.'<br>';}else if($city['city_name'] !="")
				{$addressFormat.=''.$city['city_name'].'<br>';}else if($row->zipcode !="")
				{$addressFormat.=''.$row->zipcode;}if( $state['state_name'] !="")
				{$addressFormat.=''.$state['state_name'].'<br>';}if( $country['country_name'] !="")
				{$addressFormat.=''.$country['country_name'].'<br>';}if( $row->phone !="")
				{$addressFormat.='PHONE :'.$row->phone.'; ';}if( $row->fax !="")
				{$addressFormat.='FAX :'.$row->fax.'; <br>';}if( $row->email !="")
				{$addressFormat.='EMAIL :'.$row->email.' ';}
				$addressFormat.='</td></tr>
				</table>
				';
				$aContact['address_format'] =$addressFormat;
			
				
	   }
	
	   return $aContact;
	}
	
	public function getPrintAddressFormat($lookup,$vendorname,$type)
	{
		$aContact = array();
		 if(empty($lookup))
		{
		
		$aContact['vendorname'] =$vendorname;
	
				
		}
		else
		{
		$qry = "SELECT id_contact, contact_name, addr1, addr2,id_city,id_state,id_country, zipcode,phone,fax,email,website,status FROM contact WHERE ";
	   if($type == 'lookup') {
	   	 $condition = " contact_name = '$lookup'";
	   }
	   else {
	     $condition = " id_contact = ".$lookup;
	   }
	  $qry = $qry.$condition;
	   
	   
	 
	   if($row = $this->oDb->get_row($qry))
	   {
	            $city = $this->getCityInfo($row->id_city,'id');
				$state = $this->getStateInfo($row->id_state,'id');
				$country = $this->getCountryInfo($row->id_country,'id');
				$aContact['vendorname'] =$vendorname;
				$aContact['contact_name'] =$row->contact_name;
				$aContact['addr1'] =$row->addr1;
				$aContact['addr2'] =$row->addr2;
				$aContact['addr3'] =$row->addr3;
				$aContact['city_name'] =$city['city_name'];
				$aContact['zipcode'] =$row->zipcode;
				
				
				$addressFormat='<table style="padding-left: 10px;">
				<tr><td  style="font-size:12px;">'.'<span ><b >'.strtoupper($vendorname).'</b></span><br>'.strtoupper($row->contact_name).'<br>'.strtoupper($row->addr1).'<br>';if($row->addr2 !="")
				{$addressFormat.=''.strtoupper($row->addr2).'<br>';}
				if($row->addr3 !="")
				{$addressFormat.=''.strtoupper($row->addr3).'<br>';}
				if($city['city_name'] !="" && $row->zipcode !=='')
				{$addressFormat.=''.$city['city_name'].' - '.$row->zipcode.'<br>';}else if($city['city_name'] !="")
				{$addressFormat.=''.$city['city_name'].'<br>';}else if($row->zipcode !="")
				{$addressFormat.=''.$row->zipcode;}
				$addressFormat.='</td></tr>
				</table>
				';
				$aContact['address_format'] =$addressFormat;
			
				
	   }
	    
	 }
	 
	   return $aContact;
	}
	
	
	public function getContactInfo($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	   $qry = "SELECT id_contact, contact_name, addr1, addr2,addr3,id_city,id_state,id_country, zipcode,phone,fax,email,website,status FROM contact WHERE ";
	   if($type == 'lookup') {
	   	 $condition = " contact_name = '$lookup'";
	   }
	   else {
	     $condition = " id_contact = ".$lookup;
	   }
	 $qry = $qry.$condition;
	
	   $aContact = array();
	   if($row = $this->oDb->get_row($qry))
	   {
	    		$city    = $this->getCityInfo($row->id_city,'id');
				$state   = $this->getStateInfo($row->id_state,'id');
				$country = $this->getCountryInfo($row->id_country,'id');
				$aContact['id_contact']   = $row->id_contact;
				$aContact['contact_name'] = strtoupper($row->contact_name);
				$aContact['addr1']        = strtoupper($row->addr1);
				$aContact['addr2']        = strtoupper($row->addr2);
				$aContact['addr3']        = strtoupper($row->addr3);
				$aContact['id_city']      = $row->id_city;
				$aContact['id_state']     = $row->id_state;
				$aContact['id_country']   = $row->id_country;
				$aContact['city_name']    = $city['city_name'];
				$aContact['state_name']   = $state['state_name'];
				$aContact['country_name'] = $country['country_name'];
				$aContact['zipcode']      = $row->zipcode;
				$aContact['phone']        = $row->phone;
				$aContact['fax']     = $row->fax;
				$aContact['email']   = $row->email;
				$aContact['website'] = $row->website;
				$aContact['status']  = $row->status;
	   }
	   return $aContact;
	   
	}
	public function updateContact($aRequest, $action) //action -> update, delete
	{
		if($action == 'update')
		{
			$id_contact = $aRequest['fContactId'];
			$contactName= strtoupper($aRequest['fContactName']);
			$addr1      = strtoupper($aRequest['fAddr1']);
			$addr2      = strtoupper($aRequest['fAddr2']);
			$addr3      = strtoupper($aRequest['fAddr3']);
			$id_city    = $aRequest['fCityId'];
			$id_state   = $aRequest['fStateId'];
			$id_country = $aRequest['fCountryId'];
			$zipcode    = $aRequest['fZipCode'];
			$phone      = $aRequest['fPhone'];
			$fax     = $aRequest['fFax'];
			$email   = $aRequest['fEmail'];
			$website = $aRequest['fWebsite'];
			$status  = $aRequest['fStatus'];
          $qry = "UPDATE contact SET contact_name = '$contactName', addr1 = '$addr1', addr2 = '$addr2',addr3 = '$addr3', id_city = '$id_city', id_state = '$id_state', id_country = '$id_country', zipcode = '$zipcode', phone = '$phone', fax = '$fax', email = '$email', website = '$website', status = '$status' WHERE id_contact = ".$id_contact;
		}
		else if($action == 'delete')
		{
		  if(is_array($aRequest)) {
		  $id_contact  = $aRequest['fContactId'];
		  }
		  else $id_contact = $aRequest;
		  $qry = "UPDATE contact SET status = 2 WHERE id_contact =".$id_contact;
		  $qry = "DELETE FROM vendor_contact_map WHERE id_contact = ".$id_contact;	
		 $this->oDb->query($qry);
			 $valid = true;	 
		}
		
		$valid = false;
		if($this->oDb->query($qry)) {
		 $valid = true;
		} 
		return $valid;
	}
	
	//Vendor Contact Map
	public function getVendorContactMapList($id)
	{
		 $qry = "SELECT * FROM vendor_contact_map WHERE id_vendor='".$id."' ORDER BY id_vendor_contact_map DESC";
			
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
			$aVendorList    = array();
			$aVendorList    = $this->getContactInfo($row->id_contact,'id');
			$aVendorLists[] = $aVendorList;
			}
		}
	
		return $aVendorLists;
	}
	public function getPrintVendorAddress($vendorid,$type )
	{
		  $query   = "SELECT id_vendor_address,vendor_name FROM vendor WHERE id_vendor =".$vendorid;
	   $results = $this->oDb->get_row($query);
	  	
		if(empty($results->id_vendor_address))
		{
		 $aVendorAddress       = $this->getPrintAddressFormat('',$results->vendor_name,'id');
		}
		else
		{		
	   $aVendorAddress       = $this->getPrintAddressFormat($results->id_vendor_address,$results->vendor_name,'id');
		}	
		
		
	   return $aVendorAddress ;
	}
	
	
	public function getVendorAddress($vendorid,$type )
	{
		  $query   = "SELECT id_vendor_address,vendor_name FROM vendor WHERE id_vendor =".$vendorid;
	      $results = $this->oDb->get_row($query);
	    $aVendorAddress       = $this->getAddressFormat($results->id_vendor_address,$results->vendor_name,'id');
			
			
			
	   return $aVendorAddress ;
	}
	
	
	//Vendor Contact Formatted Address
	public function getVendorContactAddress($vendorid,$contactid)
	{
		 $qry = "SELECT * FROM vendor_contact_map WHERE ";
			 if($contactid !='') {
	   	 $condition = " id_contact = '$contactid' and  id_vendor= ".$vendorid;
	   }
	   
	   else {
	     $condition = " id_vendor= ".$vendorid;
	   }
	   
	   $qry = $qry.$condition;
	   $query   = "SELECT vendor_name FROM vendor WHERE id_vendor =".$vendorid;
	   $results = $this->oDb->get_row($query);
	   
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aVendorContact       = array();
				$aVendorContact       = $this->getAddressFormat($row->id_contact,$results->vendor_name,'id');
				$aVendorContactInfo[] = $aVendorContact;
			}
		}
		return $aVendorContactInfo;
	}
	
	//Employee
	public function addEmployee($aRequest,$files)
	{
	    $employeefirstName = strtoupper($aRequest['fEmployeeFirstName']);
		$employeelastName = strtoupper($aRequest['fEmployeeLastName']);
		$prefix = strtoupper($aRequest['fPrefix']);
		$lookup = strtoupper($aRequest['fLookup']);
		$addr1   = strtoupper($aRequest['fAddr1']);
		$addr2   = strtoupper($aRequest['fAddr2']);
		$addr3   = strtoupper($aRequest['fAddr3']);
		$city    = $aRequest['fCityId'];
		$state   = $aRequest['fStateId'];
		$country = $aRequest['fCountryId'];
		$zipcode = $aRequest['fZipCode'];
		$phone = $aRequest['fPhone'];
		$email = $aRequest['fEmail'];
		$employeeType = $aRequest['fEmployeeType'];
		$employeeCategory = $aRequest['fEmployeeCategory'];
		$id_department = $aRequest['fDepartmentId'];
		$employeeDesignation = strtoupper($aRequest['fEmployeeDesignation']);
		$dateofjoin = date('Y-m-d',strtotime($aRequest['fDateOfJoin']));
		$id_unit =  $aRequest['fUnitId'];
		$bankname = strtoupper($aRequest['fBankName']);
		$accountnumber =  $aRequest['fAccountNumber'];
		$basicsalary =  $aRequest['fBasicSalary'];
		$da =  $aRequest['fDa'];
		$workercategory =  $aRequest['fWorkerCategory'];
		$id_contractor = $aRequest['fVendorId'];
		$status = $aRequest['fStatus'];
		$id_company = $aRequest['fCompanyId'];
		 $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		$qry = "INSERT INTO employee (id_employee, first_name,last_name, prefix, lookup, addr1, addr2, addr3, id_city, id_state, id_country, zipcode, phone, email,employee_type,employee_category,	id_department,employee_designation, date_of_join,id_company,id_unit,bank_name,account_number, basic_salary,da,worker_category,id_contractor,status,created_by,created_on,modified_by,modified_on) VALUES (null, '$employeefirstName',  '$employeelastName','$prefix', '$lookup','$addr1','$addr2','$addr3', '$city','$state','$country','$zipcode','$phone','$email','$employeeType', '$employeeCategory', '$id_department', '$employeeDesignation', '$dateofjoin', '$id_company','$id_unit', '$bankname', '$accountnumber', '$basicsalary', '$da', '$workercategory', '$id_contractor',  '$status','$created_by',now(),'',now())";
		
			if($this->oDb->query($qry))	{
			  $lastInsertId = $this->oDb->insert_id;
			  $empid = $lastInsertId + 1000;
			  $employeecode = "DEP".$empid;
			  $this->oDb->query( "UPDATE employee SET employee_code = '".$employeecode."' WHERE id_employee = ".$lastInsertId);
			  if($this->uploadEmployeeImage($files, $lastInsertId))
			   {
				 $done = 1;
			   }
			   else
			   {
				 $done = 0;
			   }
			  $done = 1;
			}
			else{
			   $done = 0;
			}
			if($done==1){
				return true;
			}
			else
			{
				return false;
			}
	}
	public function uploadEmployeeImage($files, $lastInsertId)
	{
		
		$files['fEmployeeImage']['name'];
		if(!empty($files['fEmployeeImage']['name']))
		{
		   $fileName = $files['fEmployeeImage']['name']; //echo '<br>';
		   $ext = explode(".", $fileName);
		   $ext = array_pop($ext);
		   $newFileName = '_logo.'.$ext;
		   $fileup = $files['fEmployeeImage']['tmp_name']; //echo '<br>';
		   $targetPath 	= APP_ROOT."/uploads/employeeimage/"; //echo '<br>';
		   $targetFileName = $lastInsertId.$newFileName; //echo '<br>';
		   move_uploaded_file($fileup, $targetPath.$targetFileName);
		   //update database.
		   $query = "UPDATE employee SET employee_image = '".$targetFileName."' WHERE id_employee = ".$lastInsertId;
		   
		   if($this->oDb->query($query))
		   {
			 $valid = true;
		   }	 
			return $valid;
		}
	} //upload category image
	public function getEmployeeList()
	{
	   $qry = "SELECT * FROM employee ORDER BY first_name ASC";
		$aEmployeeList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aEmployee = array();
				$aEmployee['id_employee']   = $row->id_employee;
				$aEmployee['employee_code'] = $row->employee_code;
				$aEmployee['employee_first_name'] = strtoupper($row->first_name);
				$aEmployee['employee_last_name'] = strtoupper($row->last_name);
				$aEmployee['employee_name'] = $aEmployee['employee_first_name'].' '.$aEmployee['employee_last_name'];
				$aEmployee['prefix']       = strtoupper($row->prefix);
				$aEmployee['lookup']     = strtoupper($row->lookup);
				$aEmployee['addr1']      = strtoupper($row->addr1);
				$aEmployee['addr2']      = strtoupper($row->addr2);
				$aEmployee['addr3']      = strtoupper($row->addr3);
				$aEmployee['id_city']    = $row->id_city;
				$aEmployee['id_state']   = $row->id_state;
				$aEmployee['id_country'] = $row->id_country;
				$aEmployee['zipcode']    = $row->zipcode;
				$aEmployee['phone']      = $row->phone;
				$aEmployee['email']      = $row->email;
				$aEmployee['employee_image']    = $row->employee_image;
				$aEmployee['employee_type']     = $row->employee_type;
				$aEmployee['employee_category'] = $row->employee_category;
				$aEmployee['id_department']     = $row->id_department;
				$aEmployee['employee_designation'] = strtoupper($row->employee_designation);
				$aEmployee['id_unit']         = $row->id_unit;
				$aEmployee['date_of_join']    = $row->date_of_join;
				$aEmployee['bank_name']       = strtoupper($row->bank_name);
				$aEmployee['account_number']  = $row->account_number;
				$aEmployee['basic_salary']    = $row->basic_salary;
				$aEmployee['da']              = $row->da;
				$aEmployee['worker_category'] = $row->worker_category;
				$aEmployee['id_contractor']   = $row->id_contractor;
				$aEmployee['status']       = $row->status;				
				$aEmployeeList[]           = $aEmployee;
			}
		}
		return $aEmployeeList;
	}
	
	public function updateEmployee($aRequest, $files, $action)
	{
	   $valid = false;
	   if($action == 'update')
		{
		    $id_employee  = $aRequest['fEmployeeId'];
			 $employeefirstName = strtoupper($aRequest['fEmployeeFirstName']);
		$employeelastName = strtoupper($aRequest['fEmployeeLastName']);
			$prefix  = strtoupper($aRequest['fPrefix']);
			$lookup  = strtoupper($aRequest['fLookup']);
			$addr1   = strtoupper($aRequest['fAddr1']);
			$addr2   = strtoupper($aRequest['fAddr2']);
			$addr3   = strtoupper($aRequest['fAddr3']);
			$city    = $aRequest['fCityId'];
			$state   = $aRequest['fStateId'];
			$country = $aRequest['fCountryId'];
			$zipcode = $aRequest['fZipCode'];
			$phone   = $aRequest['fPhone'];
			$email   = $aRequest['fEmail'];
		$employee_type     = $aRequest['fEmployeeType'];
		$employee_category = $aRequest['fEmployeeCategory'];
		$id_department     = $aRequest['fDepartmentId'];
		$employee_designation = $aRequest['fEmployeeDesignation'];
		$date_of_join         = date('Y-m-d',strtotime($aRequest['fDateOfJoin']));
		$id_unit   =  $aRequest['fUnitId'];
		$bank_name = $aRequest['fBankName'];
		$account_number =  $aRequest['fAccountNumber'];
		$basic_salary   =  $aRequest['fBasicSalary'];
		$da =  $aRequest['fDa'];
		$worker_category =  $aRequest['fWorkerCategory'];
		$id_contractor   = $aRequest['fVendorId'];
		$status  = $aRequest['fStatus'];
		$id_company = $aRequest['fCompanyId'];
		$modified_by        = $_SESSION['sesCustomerInfo']['user_id'];
		 $qry = "UPDATE employee SET first_name = '$employeefirstName',last_name = '$employeelastName', prefix = '$prefix',lookup = '$lookup', addr1 = '$addr1', addr2 = '$addr2', addr3 = '$addr3', id_city = '$city',id_state = '$state',id_country = '$country',zipcode = '$zipcode',phone = '$phone',email = '$email',employee_type = '$employee_type',employee_category = '$employee_category',id_department = '$id_department',employee_designation = '$employee_designation',date_of_join = '$date_of_join',id_company='$id_company',id_unit = '$id_unit',bank_name = '$bank_name',account_number = '$account_number',basic_salary = '$basic_salary',da = '$da',worker_category = '$worker_category',id_contractor = '$id_contractor', status = '$status',modified_by ='$modified_by',modified_on = now() WHERE id_employee = ".$id_employee;
		
		}
		
		else if($action == 'delete')
		{
		  //$id_employee  = $aRequest['fEmployeeId'];
		 $qry = "UPDATE employee SET status = 2 WHERE id_employee = ".$aRequest;
		}
		
		if($this->oDb->query($qry)) {
		 $valid = true;
		 if(isset($files))
		  {
		  	if($this->uploadEmployeeImage($files, $id_employee))
			   {
				 $valid = true;
			   }
			   
		  }
		}
		
		
		return $valid;
	}//
	
	public function getEmployeeInfo($lookup, $type)
	{
		$qry = "SELECT * FROM employee WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_employee = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aemployee = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			   	$aEmployee['id_employee']   = $row->id_employee;
				$aEmployee['employee_code'] = $row->employee_code;
				$aEmployee['employee_first_name'] = strtoupper($row->first_name);
				$aEmployee['employee_last_name'] = strtoupper($row->last_name);
				$aEmployee['employee_name'] = $aEmployee['employee_first_name'].' '.$aEmployee['employee_last_name'];
				$aEmployee['prefix']        = strtoupper($row->prefix);
				$aEmployee['lookup']     = strtoupper($row->lookup);
				$aEmployee['addr1']      = strtoupper($row->addr1);
				$aEmployee['addr2']      = strtoupper($row->addr2);
				$aEmployee['addr3']      = strtoupper($row->addr3);
				$aEmployee['id_city']    = $row->id_city;
				$aEmployee['id_state']   = $row->id_state;
				$aEmployee['id_country'] = $row->id_country;
				$aEmployee['zipcode']    = $row->zipcode;
				$aEmployee['phone']      = $row->phone;
				$aEmployee['email']      = $row->email;
				$aEmployee['employee_image'] = $row->employee_image;
				$aEmployee['employee_type']  = $row->employee_type;
				$aEmployee['employee_category'] = $row->employee_category;
				$aEmployee['id_department']     = $row->id_department;
				$aEmployee['employee_designation'] = $row->employee_designation;
				$aEmployee['date_of_join']         = $row->date_of_join;
				$aEmployee['bank_name']      = strtoupper($row->bank_name);
				$aEmployee['account_number'] = $row->account_number;
				$aEmployee['basic_salary']   = $row->basic_salary;
				$aEmployee['da']             = $row->da;
				$aEmployee['id_company']        = $row->id_company;
				$aEmployee['id_unit']        = $row->id_unit;
				$aEmployee['worker_category']= $row->worker_category;
				$aEmployee['id_contractor']  = $row->id_contractor;
				$aEmployee['status']         = $row->status;		
					   }
		   return $aEmployee;
	}
	
	//Purchase Request
public function addPurchaseRequest($aRequest)
	{
	 
	
		$id_department = $aRequest['fDepartmentId'];
		$id_unit =  $aRequest['fUnitId'];
		$remarks = $aRequest['fRemarks'];
		if($aRequest['fRequireDate'] != '')
		{
		$requiredate =  date('Y-m-d',strtotime($aRequest['fRequireDate']));
		}
		$created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		 $arequest_no = $this->purchaseRequestCount();
		 $acompany = $this->getCompanyInfo('1','id');
		 $purchase_request_Number = $acompany['lookup'].'-'.'PR'.$arequest_no['count'];
		 $unit_price = $aRequest['fPrice'];
		 $id_employee = $aRequest['fEmployeeId'];
		 $terms_condtions = $aRequest['fTerms'];
		 $id_vendor = $aRequest['fVendorId'];		 
  $qry = "INSERT INTO purchase_request (id_pr,request_no,id_department,id_unit,id_vendor,id_employee,terms_and_conditions,require_date,request_by,remarks,request_date,status) VALUES (null, '$purchase_request_Number','$id_department', '$id_unit','$id_vendor','$id_employee',' $terms_condtions','$requiredate','$created_by','$remarks',now(),'1')";
		
		
			if($this->oDb->query($qry))	
			{
			  $lastInsertId = $this->oDb->insert_id;
			  $qry_map = "INSERT INTO pr_vendor_map(id_pr_vendor_map, id_pr, id_vendor, created_by, creatred_on, modified_by, modified_on, status) VALUES (NULL,'$lastInsertId','$id_vendor','$created_by',now(),'','','1')";
			$this->addHistoryTransLog($aRequest,'','','PR','NEW',$purchase_request_Number,$lastInsertId,'1',$qry,'New Purchase Request Created','');
		
			  if($this->oDb->query($qry_map))
			  {
			  	$MAP_lastInsertId = $this->oDb->insert_id;
				$this->addHistoryTransLog($aRequest,$MAP_lastInsertId,'VMAP','PR','ASSIGN',$purchase_request_Number,$lastInsertId,'1',$qry_map,'New Vendor Assigned For this PR','');
			  }
			  else
			  {
			  $error_log = $this->oDb->debug();
			  $this->addHistoryTransLog($aRequest,$MAP_lastInsertId,'VMAP','PR','ERROR',$purchase_request_Number,$lastInsertId,'1',$qry_map,'Some Error Occur For Assign Vendor', $error_log);
			  }
			  if($this->addPurchaseItem($aRequest,$lastInsertId))
			   {
								
				$done = 1;
				   }
			   else
			   {
				   
				 $done = 0;
				 
			   }
	//			 return true;
			}
			else
			{
			 $error_log = $this->oDb->debug();
			  $this->addHistoryTransLog($aRequest,'','','PR','ERROR',$purchase_request_Number,$lastInsertId,'1',$qry,'Some Error Occur For create PR', $error_log);
			}
			if($done == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
			
	}
	
	public function addPurchaseItem($aRequest,$lastInsertId)
	{
	
		$aitem       = $aRequest['fItemName'];
		$aGroup1       = $aRequest['fGroup1'];
		$aGroup2       = $aRequest['fGroup2'];
		$aUom = $aRequest['fUOMId'];
		$aitem       = $aRequest['fItemName'];
		$unit_price = $aRequest['fPrice'];
		$aquanity    = $aRequest['fQuanity'];
		$created_by = $_SESSION['sesCustomerInfo']['user_id'];
	
		$aInsertvalues = array_map(null,$aitem,$aGroup1,$aGroup2,$aquanity,$aUom,$unit_price);
		$id_vendor = $aRequest['fvendorId'];
		
			foreach($aInsertvalues as $items)
			 {
				 //$Item_name = $this->getItemInfo($items[0],'id');
			if($items[0]>0)
			{	 
			 $qry= "INSERT INTO pr_item (id_pr_item, id_po, id_pr, id_vendor, po_number, id_asset, vendor_part_no,id_itemgroup1,id_itemgroup2,id_item, pr_item_name, unit_cost, qty, qty_received,balanced_qty, id_uom, due_date, modified_by, modified_date, approved_by, approved_date, status) VALUES (NULL, '', '$lastInsertId', '$id_vendor', '', '', '','".$items[1]."', '".$items[2]."','".$items[0]."','', '".$items[5]."', '".$items[3]."', '', '".$items[3]."','".$items[4]."', '', '', '', '$created_by', now(), '1')";
			
			 
			if($this->oDb->query($qry))	{
			$PRlastInsertId = $this->oDb->insert_id;
			 $this->addPRItemTransLog($aRequest,'NEW',$lastInsertId,$PRlastInsertId,$qry,'New Item created for Purchase Request');
			$done = 1;
			}
			else{
			  $done = 0;
			  $error_log = $this->oDb->debug();
			   $this->addPRItemTransLog($aRequest,'ERROR',$lastInsertId,$PRlastInsertId,$qry,'Some Error Occur',$error_log);
			}
			}
			 
		 }
		   
		   if($done ==1)
		   {
			  return true;
		   }
		   else
		   {
			  return false;
		   }
	}//
	
	public function updatePurchaseRequest($aRequest,$action)
	{
	  
	   $valid = false;
	   if($action == 'update')
		{
		    //status =3 means Ordercreated
			$id_pr            = $aRequest['fPurchaseRequestId'];
			$apurchaseItemName =$aRequest['fItemName'];
			$id_purchaseItem  = $aRequest['fItemId'];
			$quantity         = $aRequest['fQuanity'];
			$id_vendor        = $aRequest['fVendorId'];
			$modified_by        = $_SESSION['sesCustomerInfo']['user_id'];
			 $terms_condtions = $aRequest['fTerms'];	
			$aGroup1       = $aRequest['fGroup1'];
			$aGroup2       = $aRequest['fGroup2'];
			$aUom = $aRequest['fUOMId'];
			$unit_cost =$aRequest['fPrice'];
			$id_department = $aRequest['fDepartmentId'];
			$id_unit =  $aRequest['fUnitId'];
			$remarks = $aRequest['fRemarks'];
			$requiredate =  date('Y-m-d',strtotime($aRequest['fRequireDate']));
			$id_employee = $aRequest['fEmployeeId'];
			$created_by    = $_SESSION['sesCustomerInfo']['user_id'];
			$status = $aRequest['fStatus'];	
			$approved_by = $aRequest['fApprovalEmployeeId'];
			
			$submits = $aRequest['fApproval'];
			
		if($submits == 'approval')
		{
					
			$status = $aRequest['fStatus'];	
			$qry = "UPDATE purchase_request SET approved_by='".$approved_by."',approved_on='".$approved_date."',status='".$status."' WHERE id_pr=".$id_pr;
			$this->oDb->query($qry);
			$Trans = $this->status[$status];
			$PRNumber = $this->getPRNumbers($id_pr);
			$this->addHistoryTransLog($aRequest,'','','PR',$Trans,$PRNumber,$id_pr,$status,$qry,'Purchase Request Approved','');
		}		
			 $qry = "UPDATE purchase_request SET id_vendor='".$id_vendor."',id_department='".$id_department."',id_unit='".$id_unit."',id_employee='".$id_employee."',terms_and_conditions='".$terms_condtions."',require_date='".$requiredate."',remarks='".$remarks."',modified_by='$created_by',modified_on=now() WHERE id_pr = ".$id_pr;
			  
			    $qry_pr = "UPDATE pr_vendor_map SET id_vendor='".$id_vendor."',modified_by='$created_by',modified_on=now() WHERE id_pr = ".$id_pr;
                $this->oDb->query($qry_pr);
			  $PRNumber = $this->getPRNumbers($id_pr);
			  $this->addHistoryTransLog($aRequest,'','','PR','UPDATE',$PRNumber,$id_pr,$status,$qry,'Purchase Request Updated','');
		
	        	$this->oDb->query($qry);
			
			
			$aUpdatevalues = array_map(null,$id_purchaseItem,$apurchaseItemName,$aGroup1,$aGroup2 ,$quantity ,$aUom,$unit_cost);
			
		/*$del_qry ="DELETE FROM pr_item WHERE id_pr=".$id_pr;
		 $this->oDb->query($del_qry);*/
		  $qry_pr = "SELECT * FROM pr_item WHERE id_pr=".$id_pr;
		          $result = $this->oDb->get_results($qry_pr);
					 foreach($result as $row)
					{
		           $id_pr_item =$row->id_pr_item;
				  $qry = "UPDATE pr_item SET status='2' WHERE id_pr_item = ".$id_pr_item;
					$this->oDb->query($qry);
					
					}
			foreach($aUpdatevalues as $updatitems)
			{
				 
				 //$Item_name = $this->getItemInfo($updatitems[1],'id');
		 $checkqry = "SELECT * FROM pr_item WHERE id_pr_item='$updatitems[0]'";
		 $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{		   
		  $qry = "UPDATE pr_item SET id_vendor='".$id_vendor."',id_itemgroup1='".$updatitems[2]."',id_itemgroup2='".$updatitems[3]."',id_item='".$updatitems[1]."',unit_cost='".$updatitems[6]."',qty='".$updatitems[4]."',balanced_qty='".$updatitems[4]."',id_uom='".$updatitems[5]."',modified_by='".$created_by."',modified_date=now(),status='1' WHERE id_pr_item = ".$updatitems[0];
		   if($this->oDb->query($qry)) 
			 {
			 	  $this->addPRItemTransLog($aRequest,'UPDATE',$id_pr,$updatitems[0],$qry,'Update the current PR Item');
    			$valid = true;
			 }
			 else
			 {
			 
			  $error_log = $this->oDb->debug();
			  $this->addPRItemTransLog($aRequest,'ERROR',$id_pr,$updatitems[0],$qry,'Some Error Occur While Updatiing the PR Item',$error_log);
			   $qry = "UPDATE pr_item SET status='1' WHERE id_pr_item = ".$updatitems[0];
				$this->oDb->query($qry);
			  $valid = false;
			 }
		 
		   }
		   else
		   {	
				 $qry= "INSERT INTO pr_item (id_pr_item, id_po, id_pr, id_vendor, po_number, id_asset, vendor_part_no,id_itemgroup1,id_itemgroup2,id_item, pr_item_name, unit_cost, qty, qty_received,balanced_qty,id_uom, due_date, modified_by, modified_date, approved_by, approved_date, status) VALUES (NULL, '', '$id_pr', '$id_vendor', '', '', '','".$updatitems[2]."', '".$updatitems[3]."','".$updatitems[1]."','', '".$updatitems[6]."', '".$updatitems[4]."', '','".$updatitems[4]."' ,'".$updatitems[5]."', '', '', '', '$created_by', now(), '1')";
			 if($this->oDb->query($qry)) 
			 {
			     $PRlastInsertId = $this->oDb->insert_id;
			 	  $this->addPRItemTransLog($aRequest,'NEW',$id_pr, $PRlastInsertId,$qry,'New Purchase Prequest Item Added during Update');
    			$valid = true;
			 }
			 else
			 {
			
			  $error_log = $this->oDb->debug();
			  $this->addPRItemTransLog($aRequest,'ERROR',$id_pr, $PRlastInsertId,$qry,'Some Error Occur While New Item Added',$error_log);
			 
			  $valid = false;
			 }
				
			}
			
		
			 
			}
			
		 
          
		 } 
		 else if($action == 'delete')
		 {
		      if(is_array($aRequest)) {
		         $id_purchaseItem  = $aRequest['fItemId'];
		      }
		      else $id_purchaseItem = $aRequest;
		        $qry = "UPDATE pr_item SET status = 2 WHERE id_pr_item = ".$id_purchaseItem;
		        if($this->oDb->query($qry))	{
				$this->addPRItemTransLog($aRequest,'DELETE',$id_pr, $id_purchaseItem,$qry,'Purchase Prequest Item Deleted');
			      $valid = true;
			    } else {
				 $error_log = $this->oDb->debug();
				$this->addPRItemTransLog($aRequest,'ERROR',$id_pr,$id_purchaseItem,$qry,'Purchase Prequest Item Deleted',$error_log);
			      $valid = false;
			    }
		 }
	
		return $valid;
	}//
	
	public function getPurchaseRequestItem($lookup, $type,$itemId='')
	{
	$qry = "SELECT * FROM pr_item WHERE status!=2 and ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_pr = ".$lookup;
		   }
		   $qry = $qry.$condition;
		 
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				
				
				$aPurchaseRequestItem = array();
				$aPurchaseRequestItem['id_pr_item']   = $row->id_pr_item;
				$aPurchaseRequestItem['id_po'] = $row->id_po;
				$aPurchaseRequestItem['id_pr'] = $row->id_pr;
				$apurchaseRequest = $this->getPurchaseRequestInfo($row->id_pr);
				$aPurchaseRequestItem['request_no'] = $apurchaseRequest['request_no'];
				$aPurchaseRequestItem['require_date'] = $apurchaseRequest['require_date'];
				$aPurchaseRequestItem['id_vendor']       = $row->id_vendor;
				$aPurchaseRequestItem['po_number']     = $row->po_number;
				$aPurchaseRequestItem['id_asset']      = $row->id_asset;
				$aPurchaseRequestItem['vendor_part_no']      = $row->vendor_part_no;
				$aPurchaseRequestItem['id_itemgroup1']      = $row->id_itemgroup1;
				$aPurchaseRequestItem['id_itemgroup2']      = $row->id_itemgroup2;
				$aPurchaseRequestItem['id_item']      = $row->id_item;
				$aPurchaseRequestItem['pr_item_name']      = $row->pr_item_name;
				$aPurchaseRequestItem['unit_cost']    = $row->unit_cost;
				$aPurchaseRequestItem['qty']   = $row->qty;
				$aPurchaseRequestItem['qty_received'] = $row->qty_received;
				$aPurchaseRequestItem['balanced_qty'] = $row->balanced_qty;
				$aPurchaseRequestItem['id_uom']    = $row->id_uom;
				$aPurchaseRequestItem['due_date']      = $row->due_date;
				$aPurchaseRequestItem['approved_by']      = $row->approved_by;
				$aPurchaseRequestItem['approved_date'] = $row->approved_date;
				$aPurchaseRequestItem['status']       = $row->status;
				$aPurchaseRequestItem['unit_cost']= $row->unit_cost;
				
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aPurchaseRequestItem['uom_name']       = $aUom['lookup'];
				
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aPurchaseRequestItem['item_name']       = $aItem['item_name'];
				
				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aPurchaseRequestItem['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aPurchaseRequestItem['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				
				$aPurchaseRequestItem['vendor_contact']  = $this->getVendorAddress($row->id_vendor,'');
				$aPurchaseRequestItemList[]           = $aPurchaseRequestItem;	
					
					   }
		   }
		   return $aPurchaseRequestItemList;
	}
	
	
	public function getPurchaseRequestStatus($type = null)
	{
	   if($type == 'edit')
	   {
	   $qry = "SELECT * FROM purchase_request WHERE status = 3 OR status = 12  ORDER BY id_pr DESC";
	   }else
	   {
		    $qry = "SELECT * FROM purchase_request WHERE status = 3  ORDER BY id_pr DESC";
	   }
		$aPurchaseRequestList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aPurchaseRequest = array();
				$aPurchaseRequest['id_pr']        = $row->id_pr;
				$apurchaseRequests = $this->getPurchaseRequestInfo($row->id_pr);
				$aPurchaseRequest['pr_no'] = $apurchaseRequests['request_no'];			
				$aPurchaseRequest['id_department']= $row->id_department;
				$aPurchaseRequest['id_unit']      = $row->id_unit;
				$aPurchaseRequest['require_date']      = $row->require_date;
				$aPurchaseRequest['request_by']   = $row->request_by;
				$aPurchaseRequest['remarks']      = $row->remarks;
				$aPurchaseRequest['request_date'] = $row->request_date;
				$aPurchaseRequest['status']       = $row->status;
				$aPurchaseRequestList[]           = $aPurchaseRequest;
			}
		}
		return $aPurchaseRequestList;
	} 
	public function getPurchaseRequestList($aRequest=null)
	{
   
	   if($aRequest !=null)
	   {
		   $qry= "SELECT id_pr, id_department,id_employee, id_unit,require_date, request_by, remarks, request_date, DATE_FORMAT(request_date,'%d %b, %Y') as format_date,status FROM purchase_request WHERE status=1 OR approved_by!=0 ORDER BY status=1 DESC";
	   }
	   else
	   {
	   $qry = "SELECT id_pr, id_department,id_employee, id_unit,require_date, request_by, remarks, request_date, DATE_FORMAT(request_date,'%d %b, %Y') as format_date, DATE_FORMAT(require_date,'%d %b, %Y') as format_required_date, status  FROM purchase_request order by id_pr DESC  ";
	   }
		$aPurchaseRequestList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aPurchaseRequest = array();
				$aPurchaseRequest['id_pr']         = $row->id_pr;
				$aPurchaseRequest['id_department'] = $row->id_department;
				$aPurchaseRequestItem = $this->getPurchaseRequestInfo($row->id_pr);
				$aPurchaseRequest['request_no'] = $aPurchaseRequestItem['request_no'];
				$aPurchaseRequest['id_unit']       = $row->id_unit;
				$aPurchaseRequest['require_date']      = $row->require_date;
				$aPurchaseRequest['format_required_date']      = $row->format_required_date;
				$aPurchaseRequest['request_by']    = $row->request_by;
				$aPurchaseRequest['remarks']       = $row->remarks;
				$aPurchaseRequest['request_date']  = $row->request_date;
				$aPurchaseRequest['format_date']  = $row->format_date;
				$aPurchaseRequest['id_employee']  = $row->id_employee;
				$aEmployeeInfo = $this->getEmployeeInfo($row->id_employee);
				$aPurchaseRequest['employee_name']      = $aEmployeeInfo['employee_name'];
			    $aPurchaseRequest['status'] = $row->status;
				$aPurchaseRequest['quote_approval'] = $this->getQuotationApproval($row->id_pr,'pr');
				$aPurchaseRequestList[]     = $aPurchaseRequest;
				
			}
			
		}
		return $aPurchaseRequestList;
	} 
	
	public function getPurchaseRequestInfo($lookup, $type)
	{
	    $qry = "SELECT * FROM purchase_request WHERE status != 2 and ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_pr = ".$lookup;
		   }
		 $qry = $qry.$condition;
		
		$aPurchaseRequestInfo = array();
		if($row = $this->oDb->get_row($qry))
		{
				
    		  $aPurchaseRequestInfo['id_pr']        = $row->id_pr;
			   $aPurchaseRequestInfo['request_no']= $row->request_no;
		      $aPurchaseRequestInfo['id_department']= $row->id_department;
			  $aPurchaseRequestInfo['department_name'] = $row->id_department;
			  $aPurchaseRequestInfo['require_date']      = $row->require_date;
			  $aPurchaseRequestInfo['id_employee']      = $row->id_employee;
			   $aEmployeeInfo = $this->getEmployeeInfo($row->id_employee);
			  $aPurchaseRequestInfo['employee_name']      = $aEmployeeInfo['employee_name'];
			  $aPurchaseRequestInfo['id_vendor']      = $row->id_vendor;
			  $aPurchaseRequestInfo['id_unit']      = $row->id_unit;
			  $aPurchaseRequestInfo['request_by']   = $row->request_by;
			  $aPurchaseRequestInfo['remarks']      = $row->remarks;
			  $aPurchaseRequestInfo['terms_and_conditions']      = $row->terms_and_conditions;
			  $aPurchaseRequestInfo['request_date'] = $row->request_date;
			  $aPurchaseRequestInfo['status']       = $row->status;
			 $aPurchaseRequestInfo['quote_approval'] = $this->getQuotationApproval($row->id_pr,'pr');
			
		}
		return $aPurchaseRequestInfo;
	}// 
	
	public function getPurchaseRequestItemInfo($lookup, $type)
	{
	$qry = "SELECT * FROM pr_item WHERE status!=2 and ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_pr = ".$lookup;
		   }
		   $qry = $qry.$condition;
		 
		   if($result = $this->oDb->get_results($qry))
		   {
			 foreach($result as $row)
			{
				$aPurchaseRequestItem = array();
				$aPurchaseRequestItem['id_pr_item']   = $row->id_pr_item;
				$aPurchaseRequestItem['id_po'] = $row->id_po;
				$aPurchaseRequestItem['id_pr'] = $row->id_pr;
				$apurchaseRequest = $this->getPurchaseRequestInfo($row->id_pr);
				$aPurchaseRequestItem['request_no'] = $apurchaseRequest['request_no'];
				$aPurchaseRequestItem['require_date'] = $apurchaseRequest['require_date'];
				$aPurchaseRequestItem['po_number']     = $row->po_number;
				$aPurchaseRequestItem['id_asset']      = $row->id_asset;
				$aPurchaseRequestItem['vendor_part_no']      = $row->vendor_part_no;
				$aPurchaseRequestItem['id_itemgroup1']      = $row->id_itemgroup1;
				$aPurchaseRequestItem['id_itemgroup2']      = $row->id_itemgroup2;
				$aPurchaseRequestItem['id_item']      = $row->id_item;
				$aPurchaseRequestItem['pr_item_name']      = $row->pr_item_name;
				$aPurchaseRequestItem['unit_cost']    = $row->unit_cost;
				$aPurchaseRequestItem['qty']   = $row->qty;
				$aPurchaseRequestItem['qty_received'] = $row->qty_received;
				$aPurchaseRequestItem['balanced_qty'] = $row->balanced_qty;
				$aPurchaseRequestItem['id_uom']    = $row->id_uom;
				$aPurchaseRequestItem['due_date']      = $row->due_date;
				$aPurchaseRequestItem['approved_by']      = $row->approved_by;
				$aPurchaseRequestItem['approved_date'] = $row->approved_date;
				$aPurchaseRequestItem['status']       = $row->status;
				$aPurchaseRequestItem['unit_cost']= $row->unit_cost;
				
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aPurchaseRequestItem['uom_name']       = $aUom['lookup'];
				
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aPurchaseRequestItem['item_name']       = $aItem['item_name'];
				
				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aPurchaseRequestItem['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aPurchaseRequestItem['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				
				$aPurchaseRequestItem['groupMapId']  = $this->getGroupMapId($row->id_itemgroup1,$row->id_itemgroup2,$row->id_item);
				$aPurchaseRequestItemList['iteminfo'][]           = $aPurchaseRequestItem;	
					
					   }
		   }
		   return $aPurchaseRequestItemList;
	}
	
	
	public function getPurchaseRequestItemList($lookup,$vendorid,$type)
	{
	$qry = "SELECT * FROM pr_item WHERE status!=2 and ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_pr = '".$lookup."' and id_vendor=".$vendorid;
		   }
		   $qry = $qry.$condition;
		 
		   if($result = $this->oDb->get_results($qry))
		   {
			  foreach($result as $row)
			  {
				$aPurchaseRequestItem = array();
				$aPurchaseRequestItem['id_pr_item']   = $row->id_pr_item;
				$aPurchaseRequestItem['id_po'] = $row->id_po;
				$aPurchaseRequestItem['id_pr'] = $row->id_pr;
				$aPurchaseRequestItem['id_vendor']       = $row->id_vendor;
				$aPurchaseRequestItem['po_number']     = $row->po_number;
				$aPurchaseRequestItem['id_asset']      = $row->id_asset;
				$aPurchaseRequestItem['vendor_part_no']      = $row->vendor_part_no;
				$aPurchaseRequestItem['id_itemgroup1']      = $row->id_itemgroup1;
				$aPurchaseRequestItem['id_itemgroup2']      = $row->id_itemgroup2;
				$aPurchaseRequestItem['id_item']      = $row->id_item;
				$aPurchaseRequestItem['pr_item_name']      = $row->pr_item_name;
				$aPurchaseRequestItem['unit_cost']    = $row->unit_cost;
				$aPurchaseRequestItem['qty']   = $row->qty;
				$aPurchaseRequestItem['qty_received'] = $row->qty_received;
				$aPurchaseRequestItem['id_uom']    = $row->id_uom;
				$aPurchaseRequestItem['due_date']      = $row->due_date;
				$aPurchaseRequestItem['approved_by']      = $row->approved_by;
				$aPurchaseRequestItem['approved_date'] = $row->approved_date;
				$aPurchaseRequestItem['status']       = $row->status;
				$aPurchaseRequestItem['unit_cost']= $row->unit_cost;
				$aPurchaseRequestItemList[]           = $aPurchaseRequestItem;		
			  }
		   }
		   return $aPurchaseRequestItemList;
	}
		
	//Purchase Order
	public function approvePurchaseOrder($id_po,$id_pr)
	{
		$valid =false;
	   $qry = "UPDATE purchase_order SET status = '3' WHERE id_po = ".$id_po;
	   if($this->oDb->query($qry))
	   {
	   	 $qrys = "UPDATE purchase_request SET status = '3' WHERE id_pr = ".$id_pr;
		 $this->oDb->query($qrys);
		 $valid = true;
	   }
	   
	    
	   return $valid;
	}
	public function closePurchaseOrder($id_po)
	{
		
	   $qry = "UPDATE purchase_order SET status = '15' WHERE id_po = ".$id_po;
	 if($this->oDb->query($qry))
	 {
	 $valid =true;
	 }
	 else
	 {
	 $valid =false;
	 }
	   return $valid;
	}
	
	
	public function updatePurchaseOrder($aRequest)
	{
	   		
		$id_pr         = $aRequest['fPurchaseRequestId'];
		$id_vendor     = $aRequest['fvendorId'];
		$id_unit       =  $aRequest['fUnitId'];
		$id_department = $aRequest['fDepartmentId'];
		$id_shippingAddress      =  $aRequest['fShippingId'];
		
		$total   = $aRequest['fTotal'];
		$grant_total   = $aRequest['fGrantTotal'];
		$net_total = $aRequest['fNetTotal'];
		$round_off = $aRequest['fRoundOff'];
		
		$due_date      = date('Y-m-d H:i:s',strtotime($aRequest['fDuedate']));
		$remarks       = $aRequest['fRemarks'];
		$created_by    = $_SESSION['sesCustomerInfo']['user_id'];
			
		 $terms_condtions = $aRequest['fTerms'];
		 $id_tax   = $aRequest['fTaxId'];
		 
		$id_po = $aRequest['fPurchaseOrderId'];
		$approved_by = $aRequest['fApprovalEmployeeId'];
		if($approved_by != '')
		{
			$approved_date =date('Y-m-d H:i:s');
		}
		$submits = $aRequest['fApproval'];
		if($submits == 'approval')
		{
			$status = $aRequest['fStatus'];	
			$qry = "UPDATE purchase_order SET approved_by='".$approved_by."',approved_date='".$approved_date."',status='".$status."' WHERE id_po=".$id_po;
			$this->oDb->query($qry);
			 $PONumber = $this->getPurchaseOrderNumber($id_po);
			 $Trans = $this->status[$status];
			 $this->addHistoryTransLog($aRequest,'','','PO',$Trans,$PONumber,$id_po,$status,$qry,'Purchase Order Approved');
		}
		
		$qry = "UPDATE purchase_order SET id_pr='".$id_pr."',id_unit='".$id_unit."',id_department='".$id_department."',id_division='".$id_department."',id_shipping_addr='".$id_shippingAddress."',id_vendor='".$id_vendor."',grant_total='".$grant_total."',total='".$total."',net_total='".$net_total."',round_off='".$round_off."',po_duedate='".$due_date."',remarks='".$remarks."',terms_and_conditions='".$terms_condtions."',modified_by='".$created_by."',modified_date=now() WHERE id_po=".$id_po;
		  if($id_tax !=null)
			  {
				  $del_qry = "DELETE FROM po_tax WHERE id_po =".$id_po;
				  $this->oDb->query($del_qry);
				  
			  if($this->addPurchaseOrderTax($aRequest,$id_po))
			  {
				    $done = 1;
				}
				else
				{
				   $done = 0;
				}
			  }
			  
			   if($this->updatePurchaseOrderItem($aRequest,$lastInsertId))
			   {
				   $done = 1;
				}
				else
				{
				   $done = 0;
				} 
			if($this->oDb->query($qry))	{
			  $lastInsertId = $this->oDb->insert_id;
			  $PONumber = $this->getPurchaseOrderNumber($id_po);
			 $this->addHistoryTransLog($aRequest,'','','PO','UPDATE',$PONumber,$id_po,'1',$qry,'Purchase Order Updated');
			
			  
	//			 return true;
			}
			else
			{
			$error_log = $this->oDb->debug();
			 $this->addHistoryTransLog($aRequest,'','','PO','ERROR',$PONumber,$id_po,'1',$qry,'Some Error Occur during Purchase Order Updation',$error_log);
			}
			if($done ==1)
				{
				   return true;
				}
				else
				{
				    return false;
				}
		 
	}
	public function addPurchaseOrder($aRequest)
	{
	 
		
		$id_pr         = $aRequest['fPurchaseRequestId'];
		$id_vendor     = $aRequest['fvendorId'];
		$id_unit       =  $aRequest['fUnitId'];
		$id_department = $aRequest['fDepartmentId'];
		$id_shippingAddress      =  $aRequest['fShippingId'];
		
		$total   = $aRequest['fTotal'];
		$grant_total   = $aRequest['fGrantTotal'];
		$net_total = $aRequest['fNetTotal'];
		$round_off = $aRequest['fRoundOff'];
		
		$due_date      = date('Y-m-d H:i:s',strtotime($aRequest['fDuedate']));
		$remarks       = $aRequest['fRemarks'];
		$created_by    = $_SESSION['sesCustomerInfo']['user_id'];
		
		 $aOrder_no = $this->purchaseOrderCount();
		 $acompany = $this->getCompanyInfo('1','id');
		 $purchase_Order_Number = $acompany['lookup'].'-'.'PO'.$aOrder_no['count'];
		 $terms_condtions = $aRequest['fTerms'];
		 $id_tax   = $aRequest['fTaxId'];
		/*$addr1   = $aRequest['fAddr1'];
		$addr2   = $aRequest['fAddr2'];
		$addr3   = $aRequest['fAddr3'];
		$city    = $aRequest['fCityId'];
		$state   = $aRequest['fStateId'];
		$country = $aRequest['fCountryId'];
		$zipcode = $aRequest['fZipCode'];
		$phone   = $aRequest['fPhone'];
		$email   = $aRequest['fEmail'];
		$fax   = $aRequest['fFax'];	*/
			
	/*	$qrys="		INSERT INTO address (id_address, addr1, addr2, addr3, id_city, id_state, zipcode, id_country, phone1, phone2, email1, email2, fax1, fax2, status) VALUES (NULL, '$addr1', '$addr2', '$addr3', '$city', '$state', '$zipcode', '$country', '$phone', '', '$email', '', '$fax', '', '1');";	
		
		if($this->oDb->query($qrys))	{
			  $lastInsertId = $this->oDb->insert_id;
			 $done = 1; 
			}
			else{
			 $done = 0; 
			}*/	
		 
		 $qry = "
		 INSERT INTO purchase_order(id_po, po_number, id_pr, id_company, id_unit, id_department, id_division, id_store, id_status, id_state, id_billing_addr, id_shipping_addr, id_vendor, id_vendor_contact, po_date, tax_percent, tax_value, grant_total,total,net_total,round_off, po_duedate, id_po_tax, remarks,terms_and_conditions, created_by, created_date, modified_by, modified_date, approved_by, approved_date, status) VALUES (NULL, '$purchase_Order_Number','$id_pr', '1', '$id_unit', '$id_department', ' ', ' ', ' ', ' ', '1', '$id_shippingAddress', '$id_vendor', '', now(), '$tax_percent', '$tax_value', '$grant_total', '$total','$net_total','$round_off', '$due_date','','$remarks','".$terms_condtions."', '$created_by', now(), '', '', '', '', '1')
		 ";
		
			if($this->oDb->query($qry))	{
			  $lastInsertId = $this->oDb->insert_id;
			$this->addHistoryTransLog($aRequest,'','','PO','NEW',$purchase_Order_Number,$lastInsertId,'1',$qry,'New Purchase Order Created');
			  if($id_tax !=null)
			  {
			  if($this->addPurchaseOrderTax($aRequest,$lastInsertId))
			  {
				    $done = 1;
				}
				
			  }
			  
			   if($this->addPurchaseOrderItem($aRequest,$lastInsertId))
			   {
				   $done = 1;
				}
				else
				{
				   $done = 0;
				 				 
				} 
	//			 return true;
			}
			else
			{
			  $error_log = $this->oDb->debug();
			  $this->addHistoryTransLog($aRequest,'','','PO','NEW',$purchase_Order_Number,$lastInsertId,'1',$qry,'New Purchase Order Created',$error_log); 
			}
			if($done ==1)
				{
				   return true;
				}
				else
				{
				    return false;
				}
	}
	public function addPurchaseOrderTax($aRequest,$lastInsertId)
	{
		$id_tax   = $aRequest['fTaxId'];
		$addless     = $aRequest['fAddLess'];
		$tax_total   = $aRequest['fTaxTotal'];
		$aTaxList = array_map(null,$id_tax,$addless,$tax_total);
		foreach($aTaxList as $aTax)
			 {
				  $atax = explode("/",$aTax[0]);
				  
				  $qry = "INSERT INTO po_tax(id_po_tax,id_po, id_taxform, addless, tax_price, status) VALUES (NULL,'$lastInsertId','$atax[2]','$aTax[1] ','$aTax[2]','1')";
			 
			 
				if($this->oDb->query($qry))
				{
				   $done = 1;
				}
				else
				{
				   $done = 0;
				    
				}
					 
	        }
		   
				if($done ==1)
				{
				   return true;
				}
				else
				{
				    return false;
				}
	}
	public function addPurchaseOrderItem($aRequest,$lastInsertId)
	{
		
		
		$aItemGroup1 = $aRequest['fGroup1'];
		$aItemGroup2 = $aRequest['fGroup2'];
		$aitem = $aRequest['fItemName'];
		
		$quanity = $aRequest['fQuantity'];	
		$uom = $aRequest['fUOMId'];
		$id_manufacturer = $aRequest['fManufactureId'];
		$unitprice = $aRequest['fUnitPrice'];
		$unittotal = $aRequest['fUnitTotal'];
		$created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		$item_remark = $aRequest['fRemark'];
		$item_requireddate = $aRequest['fRequireDate'];
		$id_pr = $aRequest['fPurchaseRequestId'];
		$aid_pr_item = $aRequest['fPRItemId'];
		 $id_vendor = $aRequest['fvendorId'];
		 if($aRequest['fDuedate'] != '')
		 {
		 $due_date = date('Y-m-d H:i:s',strtotime($aRequest['fDuedate']));
		 }
		 if($id_pr == '')
		{
	
		  $aInsertvalues_pr = array_map(null,$aItemGroup1,$aItemGroup2,$aitem,$quanity,$uom,$id_manufacturer,$unitprice,$item_requireddate);
		
		foreach($aInsertvalues_pr as $items)
			 {
			 if($items[7] !='')
			 {
			 $req_date = date('Y-m-d H:i:s',strtotime($items[7]));
			 }
 $qry ="INSERT INTO po_item(id_po_item,id_po, id_pr, id_vendor, po_number, id_asset, vendor_part_no, id_itemgroup1, id_itemgroup2, id_item, po_item_name, unit_cost, qty, qty_received,balanced_qty,id_uom,id_manufacturer, due_date, remark, modified_by, modified_date, approved_by, approved_date, status) VALUES (NULL, '$lastInsertId','','$id_vendor', '', '', '','$items[0]','$items[1]','$items[2]','','$items[6]','$items[3]','','$items[3]','$items[4]','$items[5]','".$req_date."','$item_remark', '', '', '$created_by', now(), '1')";
			
			if($this->oDb->query($qry))	{
			 $POlastInsertId = $this->oDb->insert_id;
			 $this->addPOItemTransLog($aRequest,'NEW',$lastInsertId,$id_pr,$POlastInsertId,$qry,'New Item created for Purchase Order');
			  $done = 1;
			}
			else{
				  $done = 0;
				 
			   $this->oDb->debug();
			 
			}
	
	
		}
		}
		else
		{
	
		 $aInsertvalues = array_map(null,$aItemGroup1,$aItemGroup2,$aitem,$quanity,$uom,$id_manufacturer,$unitprice,$item_requireddate,$aid_pr_item);
		
						
			foreach($aInsertvalues as $items)
			 {
		
		$checkqty = $this->CheckPOBalancedQty($id_pr,$items[8]);
		if(	$checkqty > 0)
		{	
			 if($items[7] !='')
			 {
			 $req_date = date('Y-m-d H:i:s',strtotime($items[7]));
			 }
			
			$qry ="
			INSERT INTO po_item(id_po_item,id_po, id_pr, id_vendor, po_number, id_asset, vendor_part_no, id_itemgroup1, id_itemgroup2, id_item, po_item_name, unit_cost, qty, qty_received,balanced_qty,id_uom,id_manufacturer, due_date, remark, modified_by, modified_date, approved_by, approved_date, status) VALUES (NULL, '$lastInsertId','','$id_vendor', '', '', '','$items[0]','$items[1]','$items[2]','','$items[6]','$items[3]','','$items[3]','$items[4]','$items[5]','".$req_date."','$item_remark', '', '', '$created_by', now(), '1')";
			
			if($this->oDb->query($qry))	{
			$id_po = $lastInsertId;
			 $POlastInsertId = $this->oDb->insert_id;
			 $this->addPOItemTransLog($aRequest,'NEW',$id_po,$id_pr,$POlastInsertId,$qry,'New Item created for Purchase Order');
						 if($this->addPoOrderQty($id_po,$id_pr,$items[8],$items[3],$status = ''))
						 {
							$done = 1;
						 }
						 else
						 {
						 
						  $this->oDb->debug();
						  
						 }
			$done = 1;
			}
			else{
				  $done = 0;
				 $error_log = $this->oDb->debug();
			  $this->addPOItemTransLog($aRequest,'ERROR',$id_po,$id_pr, $POlastInsertId,$qry,'Purchase Order Item Updated', $error_log);
			 
			}
		 
		 }
		else
		{
		
		 $qry_update_Postatus = "UPDATE purchase_request SET status=12 WHERE id_pr=".$id_pr;
		 $this->oDb->query($qry_update_Postatus);
		 }
		
		
	
		} 
		
		 
		
		 $qry_po_status = "SELECT count(id_pr) as pr FROM pr_item WHERE id_pr =".$id_pr;
		
		 $results = $this->oDb->get_results($qry_po_status);
			 foreach($results as $row)
			{
				 $TotalPoCount = $row->pr;
			}
			
			 $qry_po_rece_status = "SELECT count(id_pr_item)as res  FROM pr_item WHERE status =9 and id_pr =".$id_pr;
		
		 $results1 = $this->oDb->get_results($qry_po_rece_status);
			 foreach($results1 as $row)
			{
				 $TotalResCount1 = $row->res;
			}
			
			if($TotalPoCount == $TotalResCount1)
			{
				
				 $qry_update_Postatus = "UPDATE purchase_request SET status=12 WHERE id_pr=".$id_pr;
					$this->oDb->query($qry_update_Postatus);
					
			}
			
			}
					   
		   if($done ==1)
		   {
			   return true;
		   }
		   else
		   {
			     return false;
		   }
		 
	}
	
	public function updatePurchaseOrderItem($aRequest,$lastInsertId)
	{
		
		
		$aItemGroup1 = $aRequest['fGroup1'];
		$aItemGroup2 = $aRequest['fGroup2'];
		$aitem = $aRequest['fItemName'];
		
		$quanity = $aRequest['fQuantity'];	
		$uom = $aRequest['fUOMId'];
		$id_manufacturer = $aRequest['fManufactureId'];
		$unitprice = $aRequest['fUnitPrice'];
		$unittotal = $aRequest['fUnitTotal'];
		$created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		$item_remark = $aRequest['fRemark'];
		$item_requireddate = $aRequest['fRequireDate'];
		$id_po_item = $aRequest['fItemId'];
		 $aInsertvalues = array_map(null,$aItemGroup1,$aItemGroup2,$aitem,$quanity,$uom,$id_manufacturer,$unitprice,$item_requireddate,$id_po_item);
		 $id_vendor = $aRequest['fvendorId'];
		 $due_date = date('Y-m-d H:i:s',strtotime($aRequest['fDuedate']));
	$id_po = $aRequest['fPurchaseOrderId'];
	$id_pr         = $aRequest['fPurchaseRequestId'];
	$id_vendor     = $aRequest['fvendorId'];
				
			foreach($aInsertvalues as $items)
			 {	
			
			  if($items[7] !='' && $items[7] !='01-01-1970')
			 {
			 $req_date = date('Y-m-d H:i:s',strtotime($items[7]));
			 }
			 else
			 {
			$req_date = date('Y-m-d');
			 }		
			 $qry = "UPDATE po_item SET id_po='".$id_po."',id_pr='".$id_pr."',id_vendor='".$id_vendor."',id_itemgroup1='".$items[0]."',id_itemgroup2='".$items[1]."',id_item='".$items[2]."',unit_cost='".$items[6]."',qty='".$items[3]."',balanced_qty='".$items[3]."',id_uom='".$items[4]."',id_manufacturer='".$items[5]."',due_date='". $req_date."',remark='$item_remark',modified_by='$created_by',modified_date=now() WHERE id_po_item=".$items[8];
			
			if($this->oDb->query($qry))	{
			 $this->addPOItemTransLog($aRequest,'UPDATE',$id_po,$id_pr,$items[8],$qry,'Purchase Order Item Updated');
			$done = 1;
			}
			else{
			  $done = 0;
			
		  
			   $error_log = $this->oDb->debug();
			  $this->addPOItemTransLog($aRequest,'ERROR',$id_po,$id_pr,$items[8],$qry,'Purchase Order Item Updated', $error_log);
			  
			}
			 
		 }
				   
		   if($done ==1)
		   {
			   return true;
		   }
		   else
		   {
			     return false;
		   }
	}
	
	public function getPurchaseOrderId($vendorId,$purchaseRequestId)
	{
	   $query = "SELECT 
	               id_po 
				 FROM 
				   purchase_order 
				 WHERE 
				   id_vendor ='$vendorId' 
				 AND 
				   id_pr ='".$purchaseRequestId."'";
				   
	   if($row = $this->oDb->get_row($query))
	   {
	      $aPurchaseOrderId = $row->id_po;
		  
	   }
	   return $aPurchaseOrderId;
	}
	
	public function getPurchaseOrderListByGrn($vendorId)
	{
	   $qry = "SELECT * FROM purchase_order ";
	   if($vendorId != null) {
	      $qry .= " WHERE status != 2 AND status != 12  AND id_vendor = ".$vendorId;
	   } 
	   $order = ' ORDER BY id_po DESC';	 
	    $qry = $qry.$order;
	    
		$aPurchaseOrderList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aPurchaseOrder = array();
				$aPurchaseOrder['id_po']      = $row->id_po;
				$aPurchaseOrder['po_number']  = $row->po_number;
				$aPurchaseOrder['id_pr']      = $row->id_pr;
				$aPurchaseOrder['id_company'] = $row->id_company;
				$aPurchaseOrder['id_unit']    = $row->id_unit;
				$aPurchaseOrder['id_department'] = $row->id_department;
				$aPurchaseOrder['id_division']   = $row->id_division;
				$aPurchaseOrder['id_store']      = $row->id_store;
				$aPurchaseOrder['id_status']     = $row->id_status;
				$aPurchaseOrder['id_state']      = $row->id_state;
				$aPurchaseOrder['id_billing_addr'] = $row->id_billing_addr;
				$aPurchaseOrder['id_shipping_addr']= $row->id_shipping_addr;
				$aPurchaseOrder['id_vendor']       = $row->id_vendor;
				$aPurchaseOrder['id_vendor_contact'] = $row->id_vendor_contact;
				$aPurchaseOrder['po_date']      = $row->po_date;
				$aPurchaseOrder['remarks']      = $row->remarks;
				$aPurchaseOrder['tax_percent']  = $row->tax_percent;
				$aPurchaseOrder['tax_value']    = $row->tax_value;
				$aPurchaseOrder['grant_total']  = $row->grant_total;
				$aPurchaseOrder['po_duedate']   = $row->po_duedate;
				$aPurchaseOrder['status']       = $row->status;
				$aPurchaseOrderList[]           = $aPurchaseOrder;
			}
		}
		return $aPurchaseOrderList;
	}
	
	public function getPurchaseOrderList($vendorId = null,$aRequest=null)
	{
	 
	   if($vendorId != null) {
	      $qry= "SELECT * FROM purchase_order WHERE status != 2 AND id_vendor ='".$vendorId."' ORDER BY id_po DESC";
	   }
	   else if($aRequest != null)
	   {
		  $qry= "SELECT * FROM purchase_order WHERE status != 2  ORDER BY status=1 DESC";
	   }
	   
	   else
	   {
		    $qry= "SELECT * FROM purchase_order WHERE status != 2  ORDER BY id_po DESC";
	   }
	   
	
		$aPurchaseOrderList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aPurchaseOrder = array();
				$aPurchaseOrder['id_po']      = $row->id_po;
				$aPurchaseOrder['po_number']  = $row->po_number;
				$aPurchaseOrder['id_pr']      = $row->id_pr;
				$aPurchaseOrder['id_company'] = $row->id_company;
				$aPurchaseOrder['id_unit']    = $row->id_unit;
				$aPurchaseOrder['id_department'] = $row->id_department;
				$aPurchaseOrder['id_division']   = $row->id_division;
				$aPurchaseOrder['id_store']      = $row->id_store;
				$aPurchaseOrder['id_status']     = $row->id_status;
				$aPurchaseOrder['id_state']      = $row->id_state;
				$aPurchaseOrder['id_billing_addr'] = $row->id_billing_addr;
				$aPurchaseOrder['id_shipping_addr']= $row->id_shipping_addr;
				$aPurchaseOrder['id_vendor']       = $row->id_vendor;
				$aPurchaseOrder['id_vendor_contact'] = $row->id_vendor_contact;
				$aPurchaseOrder['po_date']      = $row->po_date;
				$aPurchaseOrder['remarks']      = $row->remarks;
				$aPurchaseOrder['tax_percent']  = $row->tax_percent;
				$aPurchaseOrder['tax_value']    = $row->tax_value;
				$aPurchaseOrder['grant_total']  = $row->grant_total;
				$aPurchaseOrder['po_duedate']   = $row->po_duedate;
				$aPurchaseOrder['return_status']       = $row->return_status;
				$aPurchaseOrder['status']       = $row->status;
				$aPurchaseOrder['terms_and_conditions']       = $row->terms_and_conditions;
				
				
				$aPurchaseOrderList[]           = $aPurchaseOrder;
			}
		}
		return $aPurchaseOrderList;
	}
	public function getForceStockInfo($lookup, $type)
	{
		$qry = "SELECT po_item.id_po,purchase_order.po_number, DATE_FORMAT(purchase_order.po_date, '%D, %b %Y') as po_date, CONCAT_WS('-',  itemgroup1.itemgroup1_name ,itemgroup2.itemgroup2_name 
    , item.item_name) AS item , po_item.unit_cost , po_item.qty , po_item.qty_received , po_item.balanced_qty ,vendor.vendor_name
  FROM
    purchase_order
    INNER JOIN po_item 
        ON (purchase_order.id_po = po_item.id_po)
    INNER JOIN item 
        ON (po_item.id_item = item.id_item)
    INNER JOIN itemgroup1 
        ON (po_item.id_itemgroup1 = itemgroup1.id_itemgroup1)
    INNER JOIN itemgroup2 
        ON (po_item.id_itemgroup2 = itemgroup2.id_itemgroup2)
    INNER JOIN vendor 
        ON (po_item.id_vendor = vendor.id_vendor)
WHERE po_item.status !=2 and  ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else if($type== 'status'){
			 $condition = " po_item.status !=9 and po_item.id_po = ".$lookup;
		   }
		    else if($type== 'print'){
			 $condition = " po_item.status =9 and po_item.id_po = ".$lookup;
		   }
		   else {
			 $condition = " po_item.id_po = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aPODetails = array();
		   $aPODetail = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			  foreach($result as $row)
			  {
				 $aPODetail['po_number']   =   $row->po_number;
				 $aPODetail['po_date']     =   $row->po_date;
				 $aPODetail['vendor_name'] =   $row->vendor_name;
				 
    		    $aPurchaseOrderItem = array();
				$aPurchaseOrderItem['id_po']         = $row->id_po;
				$aPurchaseOrderItem['po_number']     = $row->po_number;
				$aPurchaseOrderItem['item']          = $row->item;
			    $aPurchaseOrderItem['unit_cost']     = $row->unit_cost;
				$aPurchaseOrderItem['qty']           = $row->qty;
				$aPurchaseOrderItem['qty_received']  = $row->qty_received;
				$aPurchaseOrderItem['balanced_qty']  = $row->balanced_qty;
				$aPurchaseOrderItem['vendor_name']   = $row->vendor_name;
				$aPODetails[]            = $aPurchaseOrderItem;		
			  }
			  $aPurchaseOrderItemList['po_item_details'] = $aPODetails;
			  $aPurchaseOrderItemList['po_detail']       = $aPODetail;
			  return $aPurchaseOrderItemList;
		   }
	}
	
	public function getPurchaseOrderItem($lookup, $type)
	{
		$qry = "SELECT * FROM po_item WHERE status != 2 and ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else if($type== 'status'){
			 $condition = " status !=9 and id_po = ".$lookup;
		   }
		    else if($type== 'print'){
			 $condition = " status =9 and id_po = ".$lookup;
		   }
		    else if($type== 'id'){
			 $condition = "  id_po_item = ".$lookup;
		   }
		   else {
			 $condition = " id_po = ".$lookup;
		   }
		   $qry = $qry.$condition;
		 
		 $aPurchaseOrderItem = array();
		 if($row = $this->oDb->get_row($qry))
		   {
				$aPurchaseOrderItem['id_po_item']       = $row->id_po_item;
				$aPurchaseOrderItem['id_po']            = $row->id_po;
				$aPurchaseOrderItem['id_pr']            = $row->id_pr;
				$aPurchaseOrderItem['id_vendor']        = $row->id_vendor;
				$aPurchaseOrderItem['po_number']        = $row->po_number;
				$aPurchaseOrderItem['id_asset']         = $row->id_asset;
				$aPurchaseOrderItem['vendor_part_no']   = $row->vendor_part_no;
				$aPurchaseOrderItem['po_item_name']     = $row->po_item_name	;
				$aPurchaseOrderItem['unit_cost']        = $row->unit_cost;
				$aPurchaseOrderItem['qty']              = $row->qty;
				$aPurchaseOrderItem['qty_received']     = $row->qty_received;
				$aPurchaseOrderItem['balanced_qty']     = $row->balanced_qty;
				$aPurchaseOrderItem['id_uom']           = $row->id_uom;
		   }
		   return  $aPurchaseOrderItem;
	}
	
	public function getPurchaseOrderItemInfo($lookup, $type)
	{
	$qry = "SELECT * FROM po_item WHERE status != 2 and ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else if($type== 'status'){
			 $condition = " status !=9 and id_po = ".$lookup;
		   }
		    else if($type== 'print'){
			 $condition = " status =9 and id_po = ".$lookup;
		   }
		    else if($type== 'id'){
			 $condition = "  id_po_item = ".$lookup;
		   }
		   else {
			 $condition = " id_po = ".$lookup;
		   }
		   $qry = $qry.$condition;
		
		   if($result = $this->oDb->get_results($qry))
		   {
			  foreach($result as $row)
			  {
    		    $aPurchaseOrderItem = array();
				$aPurchaseOrderItem['id_po_item']       = $row->id_po_item;
				$aPurchaseOrderItem['id_po']            = $row->id_po;
				$aPurchaseOrderItem['purchaseorderinfo']= $this->getPurchaseOrderInfo($row->id_po);
				$aPurchaseOrderItem['id_pr']            = $row->id_pr;
				$aPurchaseOrderItem['id_vendor']        = $row->id_vendor;
				$aPurchaseOrderItem['po_number']        = $row->po_number;
				$aPurchaseOrderItem['id_asset']         = $row->id_asset;
				$aPurchaseOrderItem['vendor_part_no']   = $row->vendor_part_no;
				$aPurchaseOrderItem['po_item_name']     = $row->po_item_name	;
				$aPurchaseOrderItem['unit_cost']        = $row->unit_cost;
				$aPurchaseOrderItem['qty']              = $row->qty;
				$aPurchaseOrderItem['qty_received']     = $row->qty_received;
				$aPurchaseOrderItem['balanced_qty']     = $row->balanced_qty;
				$aPurchaseOrderItem['id_uom']           = $row->id_uom;
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aPurchaseOrderItem['uom_name']         = $aUom['lookup'];
				$aPurchaseOrderItem['due_date']         = $row->due_date;
				$aPurchaseOrderItem['approved_by']      = $row->approved_by;
				$aPurchaseOrderItem['approved_date']    = $row->approved_date;
				$aPurchaseOrderItem['status']           = $row->status;
				
				
				$aPurchaseOrderItem['id_itemgroup1']      = $row->id_itemgroup1;
				$aPurchaseOrderItem['id_itemgroup2']      = $row->id_itemgroup2;
				$aPurchaseOrderItem['id_item']      = $row->id_item;
				
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aPurchaseOrderItem['uom_name']       = $aUom['lookup'];
				
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aPurchaseOrderItem['item_name']       = $aItem['item_name'];
				
				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aPurchaseOrderItem['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aPurchaseOrderItem['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				$aPurchaseOrderItem['item_remark']           = $row->remark;
				$aPurchaseOrderItem['id_manufacturer']           = $row->id_manufacturer;
				$aManufacturer = $this->getManufacturerInfo($row->id_manufacturer,'id');
				$aPurchaseOrderItem['manufacturer_name'] = $aManufacturer['manufacturer_name'];
				$aPurchaseOrderItem['vendor_contact']   = $this->getVendorAddress($row->id_vendor,'');
				$aPOTaxList = $this->getPOTaxInfoList($row->id_po,'id');
				$aPurchaseOrderItem['po_tax'] = $aPOTaxList;
												 
				$aPurchaseOrderItemList[]               = $aPurchaseOrderItem;		
			  }//for
		   }
		   return $aPurchaseOrderItemList;
	}//
	
	
	public function getPurchaseOrderItemInfoDetail($lookup, $type)
	{
	$qry = "SELECT * FROM po_item WHERE status != 2 and ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else if($type== 'status'){
			 $condition = " status !=9 and id_po = ".$lookup;
		   }
		    else if($type== 'print'){
			 $condition = " status =9 and id_po = ".$lookup;
		   }
		    else if($type== 'id'){
			 $condition = "  id_po_item = ".$lookup;
		   }
		   else {
			 $condition = " id_po = ".$lookup;
		   }
		   $qry = $qry.$condition;
		 
		   if($result = $this->oDb->get_results($qry))
		   {
			  foreach($result as $row)
			  {
    		    $aPurchaseOrderItem = array();
				$aPurchaseOrderItem['id_po_item']       = $row->id_po_item;
				$aPurchaseOrderItem['id_po']            = $row->id_po;
				$aPurchaseOrderItem['id_pr']            = $row->id_pr;
				$aPurchaseOrderItem['id_vendor']        = $row->id_vendor;
				$aPurchaseOrderItem['po_number']        = $row->po_number;
				$aPurchaseOrderItem['id_asset']         = $row->id_asset;
				$aPurchaseOrderItem['vendor_part_no']   = $row->vendor_part_no;
				$aPurchaseOrderItem['po_item_name']     = $row->po_item_name	;
				$aPurchaseOrderItem['unit_cost']        = $row->unit_cost;
				$aPurchaseOrderItem['qty']              = $row->qty;
				$aPurchaseOrderItem['qty_received']     = $row->qty_received;
				$aPurchaseOrderItem['balanced_qty']     = $row->balanced_qty;
				$aPurchaseOrderItem['id_uom']           = $row->id_uom;
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aPurchaseOrderItem['uom_name']         = $aUom['lookup'];
				$aPurchaseOrderItem['due_date']         = $row->due_date;
				$aPurchaseOrderItem['approved_by']      = $row->approved_by;
				$aPurchaseOrderItem['approved_date']    = $row->approved_date;
				$aPurchaseOrderItem['status']           = $row->status;
				
				
				$aPurchaseOrderItem['id_itemgroup1']      = $row->id_itemgroup1;
				$aPurchaseOrderItem['id_itemgroup2']      = $row->id_itemgroup2;
				$aPurchaseOrderItem['id_item']      = $row->id_item;
				
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aPurchaseOrderItem['uom_name']       = $aUom['lookup'];
				
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aPurchaseOrderItem['item_name']       = $aItem['item_name'];
				
				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aPurchaseOrderItem['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aPurchaseOrderItem['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				$aPurchaseOrderItem['item_remark']           = $row->remark;
				$aPurchaseOrderItem['id_manufacturer']           = $row->id_manufacturer;
				$aManufacturer = $this->getManufacturerInfo($row->id_manufacturer,'id');
				$aPurchaseOrderItem['manufacturer_name'] = $aManufacturer['manufacturer_name'];
				$aPurchaseOrderItem['vendor_contact']   = $this->getVendorAddress($row->id_vendor,'');
				$aPOTaxList = $this->getPOTaxInfoList($row->id_po,'id');
				$aPurchaseOrderItem['po_tax'] = $aPOTaxList;
												 
				$aPurchaseOrderItemList[]               = $aPurchaseOrderItem;		
			  }//for
		   }
		   return $aPurchaseOrderItemList;
	}//
	
	
	public function getPurchaseOrderInfo($lookup, $type)
	{
	$qry = "SELECT * FROM purchase_order WHERE status != 2 AND ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_po = ".$lookup;
		   }
		   $qry = $qry.$condition;
		 
		   if($result = $this->oDb->get_results($qry))
		   {
			  foreach($result as $row)
			  {
				$aPurchaseOrder['id_po']         = $row->id_po;
				$aPurchaseOrder['po_number']     = $row->po_number;
				$aPurchaseOrder['id_pr']         = $row->id_pr;
				$aPurchaseOrder['id_company']    = $row->id_company;
				$aPurchaseOrder['id_unit']       = $row->id_unit;
				$aPurchaseOrder['id_department'] = $row->id_department;
				$aPurchaseOrder['id_division']   = $row->id_division;
				$aPurchaseOrder['id_store']      = $row->id_store;
				$aPurchaseOrder['id_status']     = $row->id_status;
				$aPurchaseOrder['id_state']      = $row->id_state;
				$aPurchaseOrder['id_billing_addr'] = $row->id_billing_addr;
				$aPurchaseOrder['id_shipping_addr']= $row->id_shipping_addr;
				$apurchaseRequest = $this->getPurchaseRequestItem($row->id_pr,'id');
				$aPurchaseOrder['request_no']= $this->getPRNumbers($row->id_pr);
				
				if($aPurchaseOrder['id_shipping_addr']>0)
				{
				$aUnitInfo = $this->getUnitInfo($row->id_shipping_addr,'id');
	$aUnitaddress = $this->getUnitAddress($aUnitInfo['id_unit_address'],$aUnitInfo['unit_name'],'id'); 
	
				
				//$aShippingAddress = $this->getShippingAddress($row->id_shipping_addr);
				$aPurchaseOrder['shipping_addr']   = $aUnitaddress['address_format'];
				}
				else
				{
					$aPurchaseOrder['shipping_addr'] = "Self";
				}
				$aPurchaseOrder['id_vendor']       = $row->id_vendor;
				$aPurchaseOrder['id_vendor_contact'] = $row->id_vendor_contact;
				$aPurchaseOrder['po_date']           = $row->po_date;
				$aPurchaseOrder['po_duedate']        = $row->po_duedate;
				$aPurchaseOrder['po_duedate']        = $row->po_duedate;
				$aPurchaseOrder['status']            = $row->status;
				$aPurchaseOrder['tax_percent']       = $row->tax_percent;
				$aPurchaseOrder['tax_value']         = $row->tax_value;
				$aPurchaseOrder['grant_total']       = $row->grant_total;
				$aPurchaseOrder['net_total']       = $row->net_total;
				$aPurchaseOrder['round_off']       = $row->round_off;
				$aPurchaseOrder['po_duedate']        = $row->po_duedate;
				$aPurchaseOrder['remarks']           = $row->remarks;
				$aPurchaseOrder['terms_and_conditions']           = $row->terms_and_conditions;
				//$aPurchaseOrder['item_details']   = $this->getPurchaseRequestItemList($row->id_pr,$row->id_vendor);
				
					   }
		   }
		   return $aPurchaseOrder;
	} 
	
	//User Role Management
	//====================
	
	public function getAllUserList()
	{
		$qry = "SELECT * FROM user WHERE status = 1";
		if($result = $this->oDb->get_results($qry))
		{
			$aUserList = array();
			foreach($result as $row)
			{
				$aUser = array();
				$aUser['id'] = $row->id;
				$aUser['first_name']= $row->first_name;
				$aUser['last_name'] = $row->last_name;
				$aUser['address1']  = $row->address1;
				$aUser['address2']  = $row->address2;
				$aUser['city']    = $row->city;
				$aUser['state']   = $row->state;
				$aUser['zipcode'] = $row->zipcode;
				$aUser['email']   = $row->email;
				$aUser['phonenumber'] = $row->phonenumber;
				$aUser['login_id'] = $row->login_id;
				$aUser['password'] = $row->password;
				$aUser['db_roleId']  = $row->db_roleId;
				$aUser['db_roleName'] = $this->getUserRoleName($row->id, $row->db_roleId, 'id');
				$aUser['db_lcatId']  = $row->db_lcatId;
				$aUser['db_lscatId'] = $row->db_lscatId;
				$aUser['status'] = $row->status;
				$aUserList[] = $aUser;
			}
		}
		
		return $aUserList;
		
	}
	public function getLinkCatList()
	{
		$qry = "select db_lcatId, db_lcatName from linkcattable where db_lcatStatus = 1";
		$result = $this->oDb->get_results($qry, ARRAY_A);
		return $result;
	}
	public function getLinkCatName($lCatId)
	{
		$qry = "select db_lCatName from linkcattable where db_lCatId = ".$lCatId;
		$row = $this->oDb->get_row($qry);
		$linkCatName = $row->db_lCatName;
		return $linkCatName;
	}
	public function getLinkSubCatList($maincat)
	{
		$qry = "SELECT db_lscatId, db_lscatName FROM linksubcattable WHERE db_lscatStatus=1 AND db_lcatId='$maincat'";
		$result = $this->oDb->get_results($qry, ARRAY_A);
		return $result;
	}
	public function isLinkAssigned($db_lscatId,$userId)
	{
	  $valid = false;
	  $aMenuList = $this->getUserMenuAccessInfo($userId);
	  foreach($aMenuList as $menu)
	  {
	    if($menu['db_lscatId'] == $db_lscatId)
		{
		  $valid = true;
		  //break;
		}
	  }
	  return $valid;
	}
	
	
	public function isLinkAssignedCrud($db_lscatId,$userId,$cattype)
	{
	  $valid = false;
	  $aMenuList = $this->getUserCrudMenuAccessInfo($userId,$cattype);
	  foreach($aMenuList as $menu)
	  {
	    if($menu['db_lcatId'] == $db_lscatId)
		{
		 
		  $valid = true;
		  //break;
		}
	  }
	
	  return $valid;
	  
	}
	
	
	public function getUserCrudMenuAccessInfo($userId,$cattype)
	{
		$qry = 'SELECT * FROM user WHERE id = '.$userId;
			if($row = $this->oDb->get_row($qry))
		{
				switch($cattype)
				{
				case '1':
						$crud = $row->create_crud;
				        break;
				case '2':
						$crud = $row->update_crud;
				        break;
				case '3':
						$crud = $row->delete_crud;
				        break;
				case '4':
				         $crud = $row->retrieve_crud;
				        break;
				case '5':
				         $crud = $row->download_crud;
				        break;
				}
	
		}
		 $qry = "SELECT * from lscrud where db_lscrudId in($crud)";
		if($result = $this->oDb->get_results($qry))
		{
			$aMenuList = array();
			foreach($result as $row)
			{
				$aMenu = array();
				$aMenu['db_lscrudId']   = $row->db_lscrudId;
				$aMenu['db_lscatName'] = $row->db_lscatName;
				$aMenu['db_lcatId']    = $row->db_lcatId;
				$aMenu['db_lcatName']  = $this->getLinkCatName($row->db_lcatId);
				$aMenuList[] = $aMenu;
			}
		}
		
		
		return $aMenuList;
	}
	
	
	
	
	
	public function isLinkAssignedMenu($db_lcatId,$userId)
	{
	  $valid = false;
	  $aMenuList = $this->getUserMenuAccessInfo($userId);
	  foreach($aMenuList as $menu)
	  {
	    if($menu['db_lcatId'] == $db_lcatId)
		{
		  $valid = true;
		  //break;
		}
	  }
	  return $valid;
	}
	public function getUserMenuAccessInfo($userId)
	{
		$qry = 'SELECT * FROM user WHERE id = '.$userId;
		if($row = $this->oDb->get_row($qry))
		{
			$db_lscatId = $row->db_lscatId;
			//$aUserMenu = explode(',',$db_lscatId);
		}
		$qry = "SELECT db_lscatId, db_lscatName, db_lcatId from linksubcattable where db_lscatId in($db_lscatId)";
		if($result = $this->oDb->get_results($qry))
		{
			$aMenuList = array();
			foreach($result as $row)
			{
				$aMenu = array();
				$aMenu['db_lscatId']   = $row->db_lscatId;
				$aMenu['db_lscatName'] = $row->db_lscatName;
				$aMenu['db_lcatId']    = $row->db_lcatId;
				$aMenu['db_lcatName']  = $this->getLinkCatName($row->db_lcatId);
				$aMenuList[] = $aMenu;
			}
		}
		return $aMenuList;
	}
	
	public function getUserRoleName($userId, $roleId, $lookup)
	{
	   $qry = "SELECT * FROM user WHERE ";
	   if($lookup == 'login_id') {
		 $condition = " login_id = '$userId'";
	   }
	   else {
		 $condition = " id = ".$userId;
	   }
	   $qry = $qry.$condition;
	   if($row = $this->oDb->get_row($qry))
	   {
		 $userRoleId =  $row->db_roleId;
		 $qry = "SELECT db_roleId, db_roleName, db_roleStatus FROM roletable WHERE db_roleId = ".$userRoleId;
		 $r = $this->oDb->get_row($qry);
		 $userRoleName = $r->db_roleName;
	   }
	   return $userRoleName;
	}//
	
	public function updateLinkSubCat($aRequest)
	{
	   $aAddPermission = $aRequest['fAdd'];
	   $aEditPermission = $aRequest['fEdit'];
	   $aDeletePermission = $aRequest['fDelete'];
	   $aViewPermission = $aRequest['fView'];
		$aPdfPermission = $aRequest['fPdf'];
	  $aCreate =$this->getCatTypeList($aAddPermission,'1');
	  $aUpdate =$this->getCatTypeList($aEditPermission,'2');
	  $aView =$this->getCatTypeList($aViewPermission,'3');
	  $aDelete=$this->getCatTypeList($aDeletePermission,'4');
	  $aPdf =$this->getCatTypeList($aPdfPermission,'5');
	  $userId = $aRequest['fUserId']; 
	
	   $linksubcat = implode(",", $aRequest['fLinks']);
	   $linkmaincat = implode(",", $aRequest['fParentLinks']);
	  $qry = "UPDATE user SET db_lcatId='". $linkmaincat."',db_lscatId = '".$linksubcat."' ,create_crud='". $aCreate."',retrieve_crud='". $aView."',update_crud='".$aUpdate."',delete_crud='".$aDelete."',download_crud='".$aPdf."' WHERE id = ".$userId;
	 
	   if($this->oDb->query($qry))
	   {
	   	 $valid = true;
	   }
	   return $valid;
	}
	
	public function getCatTypeList($aResult,$values)
	{
	   foreach($aResult as $key => $value)
	    {
	   	  $res_val = $this->getCrudInfo($value,$values);
		   if($res_val == "") { 
               unset($array[$key]); 
            } 
			else
			{
			foreach($res_val as $val)
			{
			$results[] =$val ;
			}
			}
			
		 }
	 return  $aCreate = implode(",", array_unique($results));
	}
	
	public function getCrudInfo($lookup,$lookup2)
	{
	
	 $qry = " SELECT db_lscrudId,db_linkcat_type FROM lscrud WHERE db_lcatId='$lookup'";
	if($result = $this->oDb->get_results($qry))
	{
	foreach ($result  as $row)
	{
	$acattype     = explode(",", $row->db_linkcat_type);
	$acheck =  in_array($lookup2, $acattype);
	
	if(!empty($acheck))
	{
	$qry_link = " SELECT distinct db_lscrudId FROM lscrud WHERE db_lcatId='$lookup' AND db_linkcat_type='$row->db_linkcat_type'";
	  if($result1 = $this->oDb->get_results($qry_link))
		     {
			  foreach ($result1  as $rows)
	          {
			  $aCat_id[] = $rows->db_lscrudId;
			  }
			  }
	  }
	  }
	  }
	  return  $aCat_id;
	}
	
	//Shipping Address
	
	public function getShippingAddress($lookup, $type)
	{
		$qry = "SELECT * FROM address WHERE ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_address = ".$lookup;
		   }
		   $qry = $qry.$condition;
		   $aShipping = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			   	   
			   	$aShipping['id_address']  = $row->id_Shipping;
				$aShipping['addr1']       = strtoupper($row->addr1);	
				$aShipping['addr2']       = strtoupper($row->addr2);	
				$aShipping['addr3']       = strtoupper($row->addr3);	
				$aShipping['id_city']     = $row->id_city;	
				$aShipping['id_state']    = $row->id_state;	
				$aShipping['id_country']  = $row->id_country;
				$aShipping['phone1']      = $row->phone1;
				$aShipping['fax1']        = $row->fax1;
				$aShipping['email1']      = $row->email1;	
				$aShipping['zipcode']     = $row->zipcode;	
				$aShipping['status']      = $row->status;	
				$aCompany = $this->getCompanyAddress(1,'id');	
				$city     = $this->getCityInfo($row->id_city,'id');
				$state    = $this->getStateInfo($row->id_state,'id');
				$country  = $this->getCountryInfo($row->id_country,'id');
						
				$addressFormat='<table style="padding-left: 5px;" width="100%" cellpadding="5" cellspacing="0">
				<tr><td>'.'<span style="font-size:18px;"><b >'.$aCompany['company_name'].'</b></span><br>'.$aShipping['addr1'].'<br>'.$aShipping['addr2'].'<br>';if($aShipping['addr3'] != "")
				{$addressFormat.=''.$aShipping['addr3'].'<br>';}if($city['city_name'] !="" && $aShipping['zipcode'] !=='')
				{$addressFormat.=''.$city['city_name'].' - '.$aShipping['zipcode'].'<br>';}else if($city['city_name'] !="")
				{$addressFormat.=''.$city['city_name'].'<br>';}else if($aShipping['zipcode'])
				{$addressFormat.=''.$aShipping['zipcode'].'<br>';}if( $state['state_name'] !="")
				{$addressFormat.=''.$state['state_name'].'<br>';}if( $country['country_name'] !="")
				{$addressFormat.=''.$country['country_name'].'<br>';}
				$addressFormat.='<br></td></tr>
				</table>
				';
				$aShipping['address_format'] =$addressFormat;
		   }
		   return $aShipping;
	}
	
	//CurrencyText
	
	public function convert_number($number) 
	{ 
    if (($number < 0) || ($number > 10000000000))
    { 
    throw new Exception("Number is out of range");
    } 
    $Cr      = floor($number / 10000000);/* crore */
	$number -= $Cr * 10000000;
    $Lk      = floor($number / 100000);  /* Lakh */ 
    $number -= $Lk * 100000;
    $Tn      = floor($number / 1000);    /* Thousands (kilo) */ 
    $number -= $Tn * 1000; 
	$Hn      = floor($number / 100);     /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn      = floor($number / 10);      /* Tens (deca) */ 
    $n       = $number % 10;             /* Ones */ 
   
    $res = ""; 
	if ($Cr)
	{
	  $res .= $this->convert_number($Cr) . " Crore ";
	}
    if ($Lk) 
    { 
	  $res .= $this->convert_number($Lk) . " Lakh "; 
    }
    if ($Tn) 
    {
	  $res .=  (empty($res) ? "" : " ") . 
      $this->convert_number($Tn) . " Thousand "; 
    } 
    if ($Hn) 
    { 
      $res .= (empty($res) ? "" : " ") . 
      $this->convert_number($Hn) . " Hundred "; 
    } 
    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety");	
    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 
        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 
            if ($n) 
            { 
                $res .= " " . $ones[$n]; 
            } 
        } 
    } 
		
    if (empty($res)) 
    { 
        $res = "zero"; 
    } 
    return strtoupper($res); 
} 
public function display_paise($number2)
{
	
	if ( $number2 != floor($number2))
	{
		$val="";
	$result= explode( '.',$number2);
	//print_r($result);
	$val= $result[1];
	//echo $val;	
		if($val >=1 || $val <= 99)
  		{
	  $Dn1=floor($val / 10);
	  $n1=$val % 10;
	  $paise="";
	  $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety");	
    	  
	  if($Dn1==0)
	  {
		  $paise .= " and " . $ones[$n1] . " Paise";
	  }
	  else
	  {
		  $paise .=  " and " . $tens[$Dn1];
		  
		  if($n1)
		  {
			  $paise .=  " " . $ones[$n1] . " Paise";
		  }
	  }	  
  }
  return strtoupper($paise);
}
}
public function currencyText($amt)
{
return strtoupper("".$this->convert_number($amt).$this->display_paise($amt). " only.");
}
//end currencytext
//Inventory
public function addInventory($aRequest,$files)
	{
		//add a new Inventory.
		$bill_no    = $aRequest['fBillNumber'];
		$dc_number = $aRequest['fDcNumber'];
		$dc_date = date('Y-m-d H:i:s',strtotime($aRequest['fDcDate']));
		$id_vendor = $aRequest['fVendorId'];
		$id_po = $aRequest['fPOId'];
		$GRNno = $aRequest['fGRNNumber'];
		$bill_date =  date('Y-m-d H:i:s',strtotime($aRequest['fBillDate']));
		$po_date = date('Y-m-d H:i:s',strtotime($aRequest['fPoDate']));
		$remark = $aRequest['fRemarks'];
		$direct_order = $aRequest['fDirectOrder'];
		$id_store = $aRequest['fStoreId'];
		$qry = "INSERT INTO inventory(id_inventory, grn_no, dc_number, dc_date,direct_order, id_po, po_date, id_vendor,id_store, bill_number, bill_date, grant_total, total, net_total, round_off, remark,id_inventory_tax, invendory_date, inspection_status, asset_status, status) VALUES (NULL, '$GRNno', '$dc_number', '$dc_date','$direct_order', '$id_po', '$po_date', '$id_vendor', '$id_store','$bill_no','$bill_date','','','','','".$remark."','', now(),'1', '1', '1');";
		
		if($this->oDb->query($qry))	{
		   $lastInsertId = $this->oDb->insert_id;
		   $this->addHistoryTransLog($aRequest,'','','GRN','NEW',$GRNno,$lastInsertId,'1',$qry,'GRN Created');
		   if($this->uploadBillDocument($aRequest,$files,$lastInsertId))
			   {
			    return $lastInsertId; 	 
			   }
		     return $lastInsertId; 	 
		}
		
		else{
		$error_log = $this->oDb->debug();
		$this->addHistoryTransLog($aRequest,'','','GRN','ERROR',$GRNno,$lastInsertId,'1',$qry,'Some Error Occur during GRN creation',$error_log);
		  return false;
		}
		
		
	}	
	
	public function checkQuanityByPO($poitemId,$receivedqty)
	{
		  $qry_po = "SELECT * FROM po_item WHERE id_po_item=".$poitemId;
		$result = $this->oDb->get_results($qry_po);
			 foreach($result as $row)
			{
				$ordered_qty = $row->qty;
				$balanced_qty = $row->balanced_qty;
				
				$id_po_items = $row->id_po_item;
				if($ordered_qty >= $receivedqty )
				{
					$quantity = $balanced_qty - $receivedqty;
					$qry_update_status = "UPDATE po_item SET status=13,qty_received='".$receivedqty."',balanced_qty='".$quantity."' WHERE id_po_item=".$poitemId;
					$this->oDb->query($qry_update_status);
					
		
				}
				else if($ordered_qty < $receivedqty)
				{
					$quantity = $balanced_qty - $receivedqty;
					$qry_update_status = "UPDATE po_item SET status=14,qty_received='".$receivedqty."',balanced_qty='".$quantity."' WHERE id_po_item=".$poitemId;
					$this->oDb->query($qry_update_status);
				}
					
				
				
			}
			return $quantity;
	}
	
	public function checkQuanityByPR($pritemId,$receivedqty)
	{
		  $qry_po = "SELECT * FROM pr_item WHERE id_pr_item=".$pritemId;
		$result = $this->oDb->get_results($qry_po);
			 foreach($result as $row)
			{
				$ordered_qty = $row->qty;
				$balanced_qty = $row->balanced_qty;
				
				$id_po_items = $row->id_po_item;
				if($ordered_qty >= $receivedqty )
				{
					$quantity = $balanced_qty - $receivedqty;
					$qry_update_status = "UPDATE pr_item SET status=13,qty_received='".$receivedqty."',balanced_qty='".$quantity."' WHERE id_pr_item=".$pritemId;
					$this->oDb->query($qry_update_status);
					
		
				}
				else if($ordered_qty < $receivedqty)
				{
					$quantity = $balanced_qty - $receivedqty;
					$qry_update_status = "UPDATE pr_item SET status=14,qty_received='".$receivedqty."',balanced_qty='".$quantity."' WHERE id_pr_item=".$pritemId;
					$this->oDb->query($qry_update_status);
				}
					
				
				
			}
			return $quantity;
	}
	public function addInventoryItem($aRequest)
	{
	
		$aItemGroup1 = $aRequest['fGroup1'];
		$aItemGroup2 = $aRequest['fGroup2'];
		$aitem = $aRequest['fItemName'];
		
		$quanity = $aRequest['fQuantity'];	
		$uom = $aRequest['fUOMId'];
		$id_manufacturer = $aRequest['fManufactureId'];
		$unitprice = $aRequest['fUnitPrice'];
		$unittotal = $aRequest['fUnitTotal'];
		$created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		$item_remark = $aRequest['fRemark'];
		$item_requireddate = $aRequest['fRequireDate'];
		$aid_po_item = $aRequest['fPoItemId'];
		 $aInsertvalues = array_map(null,$aItemGroup1,$aItemGroup2,$aitem,$quanity,$uom,$id_manufacturer,$unitprice,$item_requireddate,$aid_po_item,$item_remark);
		 $id_vendor = $aRequest['fvendorId'];
		
		 $due_date = date('Y-m-d H:i:s',strtotime($aRequest['fDuedate']));
		$id_grn = $aRequest['fGrnId'];	
		$total =$aRequest['fTotal'];
		$grand_total =$aRequest['fGrantTotal'];
		$net_total =$aRequest['fNetTotal'];
		$round_off =$aRequest['fRoundOff'];
	    $id_po = $aRequest['fPoId'];
		
			foreach($aInsertvalues as $items)
			 {
			
		 $qry ="
			INSERT INTO inventory_item(id_inventory_item, id_po, id_vendor, id_grn, po_number,id_po_item, id_itemgroup1, id_itemgroup2, id_item, unit_cost, qty, qty_received, id_uom, id_manufacturer, due_date, remark, modified_by, modified_date, approved_by, approved_date, status, inspection_status, asset_status)VALUES(NULL, '$id_po ','$id_vendor','$id_grn','','$items[8]' , '$items[0]','$items[1]','$items[2]','$items[6]','$items[3]','','$items[4]','$items[5]','".date('Y-m-d H:i:s',strtotime($items[7]))."','$items[9]', '', '', '$created_by', now(), '1','1','1')";
			
			 $qtys = $this->checkQuanityByPO($items[8],$items[3],$id_po);
		
			if($this->oDb->query($qry))	{
			 $lastInsertId = $this->oDb->insert_id;
			$this->addGRNItemTransLog($aRequest,'NEW',$id_grn,$lastInsertId,$id_po,$id_pr,$items[8],$qry,'New GRN Item Created');
					$done = 1;
			}
			else{
			    $error_log = $this->oDb->debug();
			$this->addGRNItemTransLog($aRequest,'ERROR',$id_grn,$lastInsertId,$id_po,$id_pr,$items[8],$qry,'Some Error Occur during GRN item creation',  $error_log) ;
			  $done = 0;
		 
			}
			 
		 }
		 
		 if( $qtys == 0)
					{
				$qry_pos = "SELECT * FROM po_item WHERE id_po=".$id_po;
		$result1 = $this->oDb->get_results($qry_pos);
						 foreach($result1 as $row)
						{
							 $ordered_qty = $row->qty;
							 $id_po_items = $row->id_po_item;
							
							if(in_array($id_po_items,$aid_po_item))
							{
								
								 $qry_update_status = "UPDATE po_item SET status=9 WHERE id_po_item=".$id_po_items;
								 $this->oDb->query($qry_update_status);
							}
							else
							{
								 $qry_update_status1 = "UPDATE po_item SET status=10 WHERE status!=9 and id_po_item=".$id_po_items;
								$this->oDb->query($qry_update_status1);
							}
							
						} 
					}
		
		  
			
		 $qry_po_status = "SELECT count(id_po) as po FROM po_item WHERE id_po =".$id_po;
		
		 $results = $this->oDb->get_results($qry_po_status);
			 foreach($results as $row)
			{
				$TotalPoCount = $row->po;
			}
			
			 $qry_po_rece_status = "SELECT count(id_po_item)as res  FROM po_item WHERE  status =9 and id_po =".$id_po;
		
		 $results1 = $this->oDb->get_results($qry_po_rece_status);
			 foreach($results1 as $row)
			{
				$TotalResCount1 = $row->res;
			}
		
			if($TotalPoCount == $TotalResCount1)
			{
				 $qry_update_Postatus = "UPDATE purchase_order SET status=12 WHERE id_po=".$id_po;
				  $this->addHistoryTransLog($aRequest,'','','PO','CLOSE','',$id_po,'1',$qry_update_Postatus,'Purchase Order Closed');
				 $this->oDb->query($qry_update_Postatus);
			}
			
				
		
			$qry_update = "UPDATE inventory SET grant_total='$grand_total',total='$total',net_total='$net_total',round_off='$round_off' WHERE id_inventory=".$id_grn;
			if($this->oDb->query($qry_update))	{
				
			if($this->addInventoryItemTax($aRequest,$id_grn))	{
					$done = 1;
				}	
			}
			else{
			  $done = 0;
			  	}
		   
		   if($done ==1)
		   {
			   return true;
		   }
		   else
		   {
			     return false;
		   }
		
		
	}
	
	public function updateInventoryItem($aRequest)
	{
			
		
		$aItemGroup1 = $aRequest['fGroup1'];
		$aItemGroup2 = $aRequest['fGroup2'];
		$aitem = $aRequest['fItemName'];
		
		$quanity = $aRequest['fQuantity'];	
		$uom = $aRequest['fUOMId'];
		$id_manufacturer = $aRequest['fManufactureId'];
		$unitprice = $aRequest['fUnitPrice'];
		$unittotal = $aRequest['fUnitTotal'];
		$created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		$item_remark = $aRequest['fRemark'];
		$item_requireddate = $aRequest['fRequireDate'];
		$aid_po_item = $aRequest['fPoItemId'];
		$id_inventory_item = $aRequest['fInventoryItemId'];
		 $aInsertvalues = array_map(null,$aItemGroup1,$aItemGroup2,$aitem,$quanity,$uom,$id_manufacturer,$unitprice,$item_requireddate,$aid_po_item,$id_inventory_item,$item_remark);
		 
		 
		 
		 $id_vendor = $aRequest['fvendorId'];
		
		$id_grn = $aRequest['fGrnId'];	
		$total =$aRequest['fTotal'];
		$grand_total =$aRequest['fGrantTotal'];
		$net_total =$aRequest['fNetTotal'];
		$round_off =$aRequest['fRoundOff'];
	    $id_po = $aRequest['fPoId'];
		$id_inventory = $aRequest['fInventoryId'];
			foreach($aInsertvalues as $items)
			 {
		if($items[7]!= '')
		{
		 $due_date = date('Y-m-d H:i:s',strtotime($items[7]));
		}
		 $qry = "
		UPDATE inventory_item SET id_itemgroup1='".$items[0]."',id_itemgroup2='".$items[1]."',id_item='".$items[2]."',unit_cost='".$items[6]."',qty='".$items[3]."',id_uom='".$items[4]."',id_manufacturer='".$items[5]."',due_date='".$due_date."',remark='".$items[10]."',modified_by='".$created_by."',modified_date=now() WHERE id_inventory_item =".$items[9];
		
		$this->addGRNItemTransLog($aRequest,'UPDATE',$id_grn,$items[9],$id_po,'',$items[8],$qry,'GRN Item Updated');
		
			
		$qry_update = "UPDATE inventory SET grant_total='$grand_total',total='$total',net_total='$net_total',round_off='$round_off' WHERE id_inventory=".$id_inventory;
		$this->oDb->query($qry_update);
			
			if($this->oDb->query($qry))	{
				$del_qry = "DELETE FROM inventory_tax WHERE id_inventory =".$id_inventory;
				$this->oDb->query($del_qry);
				  
					if($this->addInventoryItemTax($aRequest,$id_inventory))
					{
					  $done = 1;
					}
					else
					{
					  $done = 0;
					}
			
			 						
			$done = 1;
			}
			else{
			  $done = 0;
			  
	
			  $this->oDb->debug();
			
			
			}
			
			
			 
		 }
		 
		
		   if($done ==1)
		   {
			   return true;
		   }
		   else
		   {
			     return false;
				 
			  $this->oDb->debug();
			
		   }
		
		
	
	}
	
	
	
	public function addInventoryItemTax($aRequest,$id_grn)
	{
		$id_tax   = $aRequest['fTaxId'];
		$addless     = $aRequest['fAddLess'];
		$tax_total   = $aRequest['fTaxTotal'];
		$aTaxList = array_map(null,$id_tax,$addless,$tax_total);
		foreach($aTaxList as $aTax)
			 {
				  $atax = explode("/",$aTax[0]);
				  
				  $qry = "INSERT INTO inventory_tax(id_inventory_tax, id_inventory, id_taxform, addless, tax_price, status) VALUES (NULL,'$id_grn','$atax[2]','$aTax[1] ','$aTax[2]','1')";
			 
			 
				if($this->oDb->query($qry))
				{
				   $done = 1;
				}
				else
				{
				   $done = 0;
				    if($DEBUGS !=0)
			  {
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  }
				}
					 
	        }
		   
				if($done ==1)
				{
				   return true;
				}
				else
				{
				    return false;
				}
	}
	
		
	public function getPrintPurchaseGoodsInfoList($lookup, $type,$status=null)
	{
		$qry = "SELECT * FROM inventory_item WHERE status!=2 and ";
		   if($type == 'lookup') {
			 $condition = " id_inventory_item = '$lookup'";
		   }
		   else {
			 $condition = " id_grn	 = ".$lookup;
		   }
		   $qry = $qry.$condition;
		$aInventoryItemInfoList = array();
			  
		   if($result = $this->oDb->get_results($qry))
		   {
			foreach($result as $row)
			{
				$aInventoryItemInfo = array();
				$aInventoryItemInfo['id_inventory_item']   = $row->id_inventory_item;
				$aInventoryItemInfo['id_po']   = $row->id_po;
				$aInventoryItemInfo['id_grn']   = $row->id_grn;
				$aInventoryItemInfo['id_vendor']   = $row->id_vendor;
				$aInventoryItemInfo['po_number']   = $row->po_number;
				$aInventoryItemInfo['id_itemgroup1']   = $row->id_itemgroup1;
				$aInventoryItemInfo['id_itemgroup2']   = $row->id_itemgroup2;
				$aInventoryItemInfo['id_item']   = $row->id_item;
				$aInventoryItemInfo['unit_cost']   = $row->unit_cost;
				$aInventoryItemInfo['qty']   = $row->qty;
				$aInventoryItemInfo['id_uom']   = $row->id_uom;
				$aInventoryItemInfo['id_manufacturer']   = $row->id_manufacturer;
				$aInventoryItemInfo['due_date']   = $row->due_date;
				$aInventoryItemInfo['remark']   = $row->remark;
				$aInventoryItemInfo['status']   = $row->status;
							
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aInventoryItemInfo['uom_name']       = $aUom['lookup'];
				
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aInventoryItemInfo['item_name']       = $aItem['item_name'];
				
				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aInventoryItemInfo['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aInventoryItemInfo['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				$aInventoryItemInfo['status']   = $row->status;
				$aInventoryItemInfo['inspection_status']   = $row->inspection_status;
				$aInventoryItemInfo['asset_status']   = $row->asset_status;
				$aInventoryItemInfo['return_status']   = $row->return_status;
				
				$aInventoryItemInfoList[] = $aInventoryItemInfo;
			}
		   }
		   return $aInventoryItemInfoList;
	}
		
	public function addInspection($aRequest,$files)
	{
		$inspectiondetails    = $aRequest['fInspectionDesc'];
		$remarks = $aRequest['fRemarks'];
		$grn_no = $aRequest['fGrnId'];
		$id_inventory = $aRequest['fInventoryItemid'];
		$status = $aRequest['fStatus'];
		$id_employee = $aRequest['fEmployeeId'];
		 $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		 $image_desc = $aRequest['fImageDesc'];
		$qry = "
		INSERT INTO asset_inspection(id_asset_inspection, grn_no, id_inventory_item,inspection_details,image_description,remarks,id_employee, status,created_by, created_on) VALUES (NULL,'$grn_no ' , '$id_inventory','$inspectiondetails', '$image_desc', '$remarks', '$id_employee', '$status', '$created_by',now())";
		
		if($this->multiUploadAssetImage($aRequest,$files))
					{
					$done = 1;
					}
					else
					{
					$done = 0; 
		  
			  $this->oDb->debug();
			  	}
					
			if($this->oDb->query($qry))	{
			 $lastInsertId = $this->oDb->insert_id;
				
				  $query   = "UPDATE inventory_item SET inspection_status= $status WHERE id_inventory_item=".$id_inventory;
				$this->oDb->query($query);	
				$this->addGRNItemTransLog($aRequest,'UPDATE',$id_grn,$id_inventory,'','','',$qry,'GRN Item Updated');
				
				  $this->addHistoryTransLog($aRequest,$lastInsertId,'ASTINP','INSP','NEW','',$grn_no,'1',$qry,'New GRN item Inspection Created');
						
				 $qry_grn_status = "SELECT count(id_grn) as grn FROM inventory_item WHERE id_grn =".$grn_no;
		
		 $results = $this->oDb->get_results($qry_grn_status);
			 foreach($results as $row)
			{
				$TotalPoCount = $row->grn;
			}
			
			 $qry_grn_res_status = "SELECT count(id_inventory_item)as res  FROM inventory_item WHERE  inspection_status =3 and id_grn =".$grn_no;
		
		 $results1 = $this->oDb->get_results($qry_grn_res_status);
			 foreach($results1 as $row)
			{
				$TotalResCount1 = $row->res;
			}
		
			if($TotalPoCount == $TotalResCount1)
			{
				  $qry_update_Postatus = "UPDATE inventory SET inspection_status=3 , status=12 WHERE id_inventory=".$grn_no;
					$this->oDb->query($qry_update_Postatus);
			}
					
			}
			else
			{
					$done = 0;
				  $this->oDb->debug();
			
			}
		if($done = 1)
		{
			return $grn_no;
		}
		else
		{
			return false;
		}
	}
	public function multiUploadAssetImage($aRequest,$files,$assetitemId=null)
	{
		  $counts =$this->countAssetImage();
		 $image_desc    = $aRequest['fImageDesc'];
		$image_title = strtoupper($aRequest['fImageName']);
		$grn_no = $aRequest['fGrnId'];
		$id_inventory = $aRequest['fInventoryItemid'];
		$status = $aRequest['fStatus'];
		$files['fImage']['name'];
					
				
		 if(isset($_FILES['fImage'])){
    $errors= array();
	foreach($_FILES['fImage']['tmp_name'] as $key => $tmp_name ){
		
		
	   $name = strtotime(date('Y-m-d h:i:s'));
		$file_name = $name.'_'.$_FILES['fImage']['name'][$key];
		$file_size =$_FILES['fImage']['size'][$key];
		$file_tmp =$_FILES['fImage']['tmp_name'][$key];
		$file_type=$_FILES['fImage']['type'][$key];	
        if($file_size > 60097152){
			$errors[]='File size must be less than 60 MB';
        	
		}
		
        $desired_dir="uploads/assetimage";
        if(empty($errors)==true){
		
            
		if(is_dir($desired_dir)==false){
                mkdir("$desired_dir", 0700);		// Create directory if it does not exist
            }
				
            if(is_dir("$desired_dir/".$file_name)==false){
                move_uploaded_file($file_tmp, "uploads/assetimage/".$file_name);
            }else{									//rename the file if another one exist
                $new_dir="uploads/document/".$file_name.time();
                 rename($file_tmp,$new_dir) ;				
            }
		
			if(!empty($_FILES['fImage']['name'][$key]))
			{
		
		 $qry = "INSERT INTO asset_image (id_image, grn_no, id_inventory_item,id_asset_item, image_title, image_description, image_path, remarks, status, created_date) VALUES (NULL, '$grn_no', '$id_inventory', '$assetitemId','$image_title', '$image_desc', '$file_name', '', '1', now())";
		if($this->oDb->query($qry))	{
		 $lastInsertId = $this->oDb->insert_id;
		  $this->addAssetTransLog($aRequest,'NEWIMAGE',$assetitemId,'','',$assetitemId,'ASSET','','',$qry,'Asset Image Added','');
			
		  	$done = 1;
			
		}
		else{
		  $done = 0;
		   
			  $this->oDb->debug();
			
		}
		 }
			
		
        }else{
              /* print_r($errors);*/
			  	$done = 0;
				
			  $this->oDb->debug();
			
        }
		
    }
	
				
	}
		
		
			if(empty($error)){
					if($done = 1)
					{
					return true;
					}
					else
					{
					return false;
					}
			
			}
	}
	
public function updateInspection($aRequest,$files)
	{
		$inspectiondetails    = $aRequest['fInspectionDesc'];
		$remarks = $aRequest['fRemarks'];
		$grn_no = $aRequest['fGrnId'];
		$id_inventory = $aRequest['fInventoryItemid'];
		$status = $aRequest['fStatus'];
		$id_employee = $aRequest['fEmployeeId'];
		 $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		 $image_desc = $aRequest['fImageDesc'];
		 $qry = "UPDATE `asset_inspection` SET `inspection_details`='".$inspectiondetails."',`image_description`='".$image_desc."',`remarks`='".$remarks."',`id_employee`='".$id_employee."',`status`='".$status."' WHERE id_inventory_item='$id_inventory'";
		
		if($this->addAssetImagesEdit($aRequest,$files))
					{
					$done = 1;
					}
					else
					{
					$done = 0; 
		  
			  $this->oDb->debug();
			  	}
					
			if($this->oDb->query($qry))	{
			 $lastInsertId = $this->oDb->insert_id;
				
				  $query   = "UPDATE inventory_item SET inspection_status= $status WHERE id_inventory_item=".$id_inventory;
				$this->oDb->query($query);	
				$this->addGRNItemTransLog($aRequest,'UPDATE',$id_grn,$id_inventory,'','','',$qry,'GRN Item Updated');
				
				  $this->addHistoryTransLog($aRequest,$lastInsertId,'ASTINP','INSP','NEW','',$grn_no,'1',$qry,'New GRN item Inspection Created');
						
				 $qry_grn_status = "SELECT count(id_grn) as grn FROM inventory_item WHERE id_grn =".$grn_no;
		
		 $results = $this->oDb->get_results($qry_grn_status);
			 foreach($results as $row)
			{
				$TotalPoCount = $row->grn;
			}
			
			 $qry_grn_res_status = "SELECT count(id_inventory_item)as res  FROM inventory_item WHERE  inspection_status =3 and id_grn =".$grn_no;
		
		 $results1 = $this->oDb->get_results($qry_grn_res_status);
			 foreach($results1 as $row)
			{
				$TotalResCount1 = $row->res;
			}
		
			if($TotalPoCount == $TotalResCount1)
			{
				  $qry_update_Postatus = "UPDATE inventory SET inspection_status=3 , status=12 WHERE id_inventory=".$grn_no;
					$this->oDb->query($qry_update_Postatus);
			}
					
			}
			else
			{
					$done = 0;
				  $this->oDb->debug();
			
			}
		if($done = 1)
		{
			return $grn_no;
		}
		else
		{
			return false;
		}
	}
public function addAssetImagesEdit($aRequest,$files,$asseetid=null)
{
                 $add_images =  $aRequest['fAddImgeCheckbox'];
				$aRemoveimages =  $aRequest['fDeleteImageCheckbox'];
				
				$aresult = array();	
				$aresult['inventoryitem'] = $aRequest['fInventoryItemId'];
				
				foreach($aRemoveimages as $key => $value)
				{
					$qrys = "DELETE FROM asset_image WHERE id_image=".$value;
					$this->addAssetTransLog($aRequest,'DELETEIMAGE',$asseetid,'','',$asseetid,'ASSET','','',$qrys,'Asset Image Deleted','');
					$this->oDb->query($qrys);
					
					
					$done = 2;
				}
				if($add_images == 'on')
				{
									
						if($this->multiUploadAssetImage($aRequest,$files, $asseetid))
						{
					
						
						$done = 1;
						}
						else
						{
						
						
					   $done = 0;
					
						}
										
					
				}
				return $aresult;
}
	public function addAssetImage($aRequest,$files)
	{
		//add a new Inventory.
		
		$image_desc    = $aRequest['fImageDesc'];
		$image_title = strtoupper($aRequest['fImageName']);
		$remarks    = $aRequest['fInspectionDesc'];
		$grn_no = $aRequest['fGrnId'];
		$id_inventory = $aRequest['fInventoryItemid'];
		$status = $aRequest['fStatus'];
		$files['fImage']['name'];
		
		if(!empty($files['fImage']['name']))
		{
		   $fileName = $files['fImage']['name']; //echo '<br>';
		   $ext = explode(".", $fileName);
		   $ext = array_pop($ext);
		   $name = strtotime(date('Y-m-d h:i:s'));
		   $newFileName = $name.'_asset.'.$ext;
		   $fileup = $files['fImage']['tmp_name']; //echo '<br>';
		   $targetPath 	= APP_ROOT."/uploads/assetimage/"; //echo '<br>';
		   $targetFileName = $lastInsertId.$newFileName; //echo '<br>';
		   move_uploaded_file($fileup, $targetPath.$targetFileName);
		}
		
		$qry = "INSERT INTO asset_image (id_image, grn_no, id_inventory_item, image_title, image_description, image_path, remarks, status, created_date) VALUES (NULL, '$grn_no', '$id_inventory', '$image_title', '$image_desc', '$newFileName', '$remarks', '1', now())";
		
		
		
		if($this->oDb->query($qry))	{
		  // $lastInsertId = $this->oDb->insert_id;
		 		
		  
			 return $grn_no; 	 
		}
		else{
		  return false;
		 
			  $this->oDb->debug();
			
		}
		
		
		
	}	
	
	public function updateAssetImage($aRequest,$files)
	{
		 $grn_no = $aRequest['fGrnId'];
		 $id_inventory = $aRequest['fInventoryItemid'];
		 $files['fImage']['name'];
		
		if(!empty($files['fImage']['name']))
		{
		   $fileName = $files['fImage']['name']; //echo '<br>';
		   $ext = explode(".", $fileName);
		   $ext = array_pop($ext);
		   $name = strtotime(date('Y-m-d h:i:s'));
		   $newFileName = $name.'_asset.'.$ext;
		   $fileup = $files['fImage']['tmp_name']; //echo '<br>';
		   $targetPath 	= APP_ROOT."/uploads/assetimage/"; //echo '<br>';
		   $targetFileName = $lastInsertId.$newFileName; //echo '<br>';
		   move_uploaded_file($fileup, $targetPath.$targetFileName);
		   
		  $query   = "UPDATE asset_image SET image_path='$newFileName' WHERE id_inventory_item=".$id_inventory;
			if($this->oDb->query($query))	{
			  return true; 	 
			}
			else{
			  return false;
			
			  $this->oDb->debug();
			
			}
			
			
		}
	}
	public function updateInventory($aRequest,$files)
	{
		 
		  $bill_no    = $aRequest['fBillNumber'];
		$dc_number = $aRequest['fDcNumber'];
		$dc_date = date('Y-m-d H:i:s',strtotime($aRequest['fDcDate']));
		$id_vendor = $aRequest['fVendorId'];
		$id_po = $aRequest['fPOId'];
		$GRNno = $aRequest['fGRNNumber'];
		$bill_date =  date('Y-m-d H:i:s',strtotime($aRequest['fBillDate']));
		$po_date = date('Y-m-d H:i:s',strtotime($aRequest['fPoDate']));
		$remark = $aRequest['fRemarks'];
		$direct_order = $aRequest['fDirectOrder'];
		$id_store = $aRequest['fStoreId'];
		  $id_grn = $aRequest['fGrnId'];
		  $status = $aRequest['fStatus'];
		  $id_stores = explode("/",$id_store);
		  
		 $query   = "UPDATE inventory SET dc_number='$dc_number',dc_date='$dc_date ',direct_order='$direct_order',id_po='$id_po',po_date='$po_date',id_vendor='$id_vendor',id_store='$id_stores[0]',bill_number=' $bill_no',bill_date='$bill_date',remark='$remark' WHERE id_inventory=".$id_grn;
		
				if($this->oDb->query($query))	{
				 	      $this->addHistoryTransLog($aRequest,'','','GRN','UPDATE',$GRNno,$id_grn,'1',$query,'GRN Created');
		  	   if($this->uploadBillDocument($aRequest,$files,$id_grn))
			   {
			    return true; 
			   }
		     return true; 	 
		}
		else{
		  return false;
		 
			  $this->oDb->debug();
			
			  
		}	}
		
		 public function uploadBillDocument($aRequest,$files,$lastInsertId)
	{
		
		
		 $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
			$id_inventory = $aRequest['fGrnId'];
		 $files['fUploadDocument']['name'];
		if(!empty($files['fUploadDocument']['name']))
		{
		
		 $fileName = $files['fUploadDocument']['name']; //echo '<br>';
		 		   
		  $ext = explode(".", $fileName);
		   $ext = array_pop($ext);
		   $name = strtotime(date('Y-m-d h:i:s'));
		   $newFileName = $name.'_document.'.$ext;
		   $fileup = $files['fUploadDocument']['tmp_name']; //echo '<br>';
		    $targetPath 	= APP_ROOT."/uploads/grndocument/"; //echo '<br>';
		   $targetFileName = $lastInsertId.'_'.$newFileName; //echo '<br>';
		   move_uploaded_file($fileup, $targetPath.$targetFileName);
		
		   //update database.
		   
		  $checkqry = "SELECT * FROM grn_document WHERE id_inventory='$lastInsertId'";
		 $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{		   
		  $query = "UPDATE grn_document SET id_inventory='".$lastInsertId."',document_name='',document_path='".$targetFileName."',document_file_type='',modified_by='".$created_by."',modified_on=now() WHERE id_inventory = ".$lastInsertId;
		   }
		   else
		   {
		 $query = "INSERT INTO grn_document(id_grn_document, id_inventory, document_name, document_path, document_file_type, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'".$lastInsertId."','','".$targetFileName."','','$created_by ',now(),'','','1')";
		   }
		   
		   if($this->oDb->query($query))
		   {
			 $valid = true;
		   }
		   else
		   {
		   $valid = false;
		   }
		  		  
			return $valid;
		}
		
		
	} 
		
	public function getInventoryItemInfo($lookup, $type)
	{
		
		$qry = "SELECT * FROM inventory_item WHERE status!=2 and ";
		   if($type == 'lookup') {
			 $condition = " id_inventory_item = '$lookup'";
		   }
		   else {
			 $condition = " id_grn	 = ".$lookup;
		   }
		   $qry = $qry.$condition;
		
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				$aInventoryItemInfo['id_inventory_item']   = $row->id_inventory_item;
				$aInventoryItemInfo['id_grn']   = $row->id_grn;
				$aInventoryItemInfo['id_po']   = $row->id_po;
				$aInventoryItemInfo['id_grn']   = $row->id_grn;
				$aInventoryItemInfo['id_vendor']   = $row->id_vendor;
				$aInventoryItemInfo['po_number']   = $row->po_number;
				$aInventoryItemInfo['id_itemgroup1']   = $row->id_itemgroup1;
				$aInventoryItemInfo['id_itemgroup2']   = $row->id_itemgroup2;
				$aInventoryItemInfo['id_item']   = $row->id_item;
				$aInventoryItemInfo['unit_cost']   = $row->unit_cost;
				$aInventoryItemInfo['qty']   = $row->qty;
				$aInventoryItemInfo['id_uom']   = $row->id_uom;
				$aInventoryItemInfo['id_manufacturer']   = $row->id_manufacturer;
				$aInventoryItemInfo['due_date']   = $row->due_date;
				$aInventoryItemInfo['remark']   = $row->remark;
				$aInventoryItemInfo['status']   = $row->status;
				
				$aInventoryItemInfo['balanced_qty']      = $row->balanced_qty;
				$aInventoryItemInfo['return_qty']      = $row->return_qty;
				$aInventoryItemInfo['return_status']      = $row->return_status;
				
				$aInventoryItemInfo['id_item']      = $row->id_item;
				$aInventoryItemInfo['id_itemgroup1']      = $row->id_itemgroup1;
				$aInventoryItemInfo['id_itemgroup2']      = $row->id_itemgroup2;
				$aInventoryItemInfo['id_UOM']      = $row->id_UOM;
							
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aInventoryItemInfo['uom_name']       = $aUom['lookup'];
				
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aInventoryItemInfo['item_name']       = $aItem['item_name'];
				
				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aInventoryItemInfo['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aInventoryItemInfo['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				$aInventoryItemInfo['status']   = $row->status;
				$aInventoryItemInfo['inspection_status']   = $row->inspection_status;
				 $qrys = "SELECT * FROM asset_image WHERE status!=2 and id_inventory_item=".$row->id_inventory_item;
				 $results = $this->oDb->get_results($qrys);
				foreach($results as $row)
				{
				$aImage = array();
				$aImage['id_image'] = $row->id_image;
				$aImage['image_path'] = $row->image_path;
				$aInventoryItemInfo['images'][] = $aImage;
				
				}
				
		
					
				
					   }
		   }
		   return $aInventoryItemInfo;
	}
	
	
	
	public function getInventoryItemList($lookup, $type,$status=null) //getInventoryItemList
	{
		
		$qry = "SELECT * FROM inventory_item WHERE status != 2 ";
		   if($type == 'lookup') {
			 $condition = " AND id_inventory_item = '$lookup'";
		   }
		    else if($type == 'status') {
			 $condition = " AND asset_status != '$status' AND id_grn = ".$lookup;
		   }
		   else if($type == 'inspection') {
			 $condition = " AND asset_status != 3 AND return_status!=1 AND id_grn = ".$lookup;
		   }
		   else {
			 $condition = " AND id_grn = ".$lookup;
		   }
		  $qry = $qry.$condition;
		 	
		   if($result = $this->oDb->get_results($qry))
		   {
        	 foreach($result as $row)
			 {
				$aInventoryItemInfo = array();
				$aInventoryItemInfo['id_inventory_item'] = $row->id_inventory_item;
				$aInventoryItemInfo['id_po']   = $row->id_po;
				$aInventoryItemInfo['id_po_item']   = $row->id_po_item;
				$aInventoryItemInfo['id_vendor']   = $row->id_vendor;
				$aInventoryItemInfo['id_grn']   = $row->id_grn;
				$aInventoryItemInfo['unit_cost']   = $row->unit_cost;
				$aInventoryItemInfo['grn_no']   = $row->grn_no;
				$aInventoryItemInfo['qty']   = $row->qty;
				$aInventoryItemInfo['qty_received']   = $row->qty_received;
				$aInventoryItemInfo['id_manufacturer']   = $row->id_manufacturer;
				$aInventoryItemInfo['due_date']   = $row->due_date;
				$aInventoryItemInfo['remark']   = $row->remark;
				$aInventoryItemInfo['status']   = $row->status;
				$aInventoryItemInfo['inspection_status'] = $row->inspection_status;
				$aInventoryItemInfo['asset_status']      = $row->inspection_status;
				
				$aInventoryItemInfo['id_item']      = $row->id_item;
				$aInventoryItemInfo['id_itemgroup1']      = $row->id_itemgroup1;
				$aInventoryItemInfo['id_itemgroup2']      = $row->id_itemgroup2;
				$aInventoryItemInfo['id_uom']      = $row->id_uom;
				
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aInventoryItemInfo['item_name']       = $aItem['item_name'];
				
				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aInventoryItemInfo['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aInventoryItemInfo['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				
				$UOM  = $this->getUomInfo($row->id_UOM);
				$aInventoryItemInfo['uom_name']         = $UOM['lookup'];
				$aInventoryItemInfoList[]               = $aInventoryItemInfo;	
			 }
		   }
		   return $aInventoryItemInfoList;
	}
	
	public function getVendorName($vendorid)
	{
		 $query   = "SELECT vendor_name FROM vendor WHERE id_vendor =".$vendorid;
	  	 $results = $this->oDb->get_row($query);
		 return $results->vendor_name;
	}
		
	public function getInventoryList($type)
	{
		 
		 $querys = "SELECT Distinct id_grn FROM inventory_item WHERE asset_status !=3 and inspection_status != 1";
		 $res = $this->oDb->get_results($querys);
		  foreach($res as $row)
			{
			$strings_id.="'".$row->id_grn."',";
		
			}
		 $strings_ids=substr($strings_id,0,strlen($strings_id)-1);
		 
		  $querys1 = "SELECT Distinct id_grn FROM asset_item WHERE status!=2 ";
		 $res1 = $this->oDb->get_results($querys1);
		  foreach($res1 as $row)
			{
			$strings_id1.="'".$row->id_grn."',";
		
			}
		 $strings_ids1=substr($strings_id1,0,strlen($strings_id1)-1);
		 $qry = "SELECT * FROM inventory  ";
		 if($type == 'grn') {
			$condition = " WHERE id_inventory IN( $strings_ids) ORDER BY id_inventory DESC";
		   }
		   else if($type == 'asset') {
			$condition = " WHERE id_inventory IN( $strings_ids1) ORDER BY id_inventory DESC";
		   }
		   else
		   {
			   $condition = "ORDER BY id_inventory DESC";
		   }
		    $qry = $qry.$condition;
		   
		 if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				
				$aInventoryItem = array();
				$aInventoryItem['id_inventory']   = $row->id_inventory;
				$aInventoryItem['dc_number']   = $row->dc_number;
				$aInventoryItem['dc_date']   = $row->dc_date;
				$aInventoryItem['grn_no']   = $row->grn_no;
				$aPurchaseOrderInfo= $this->getPurchaseOrderInfo($row->id_po);
				$aInventoryItem['po_number']   = $aPurchaseOrderInfo['po_number'];
				$aInventoryItem['id_po']   = $row->id_po;
				$aInventoryItem['po_date']   = $row->po_date;
				$aInventoryItem['id_vendor']   = $row->id_vendor;
				$aInventoryItem['vendor_name']   = $this->getVendorName($row->id_vendor);
				$aInventoryItem['bill_number']   = $row->bill_number;
				$aInventoryItem['status']   = $row->status;
				$aInventoryItem['inspection_status']   = $row->inspection_status;
					$aInventoryItemList[] = $aInventoryItem;	
				
					   }
		   }
		   return $aInventoryItemList;
	}
	
	public function getInventoryDocumentInfo($lookup, $type='')
	{
	$qry = "SELECT * FROM grn_document WHERE status!=2 and ";
		   if($type == 'id') {
			 $condition = " id_grn_document = '$lookup'";
		   }
		   else {
			 $condition = " id_inventory = ".$lookup;
		   }
		  $qry = $qry.$condition;
		
		 $aInventoryDoc= array();
		   if($row = $this->oDb->get_row($qry))
		   {
			 
			   $aInventoryDoc['id_grn_document']= $row->id_grn_document;
			   $aInventoryDoc['id_inventory']= $row->id_inventory;
			   $aInventoryDoc['document_path']= $row->document_path;
			   $aInventoryDoc['document_name']= $row->document_name;
			   $aInventoryDoc['status']= $row->status;
				
				}
				return $aInventoryDoc;
	}
	
	
public function getInventoryInfo($lookup, $type)
	{
		
		$qry = "SELECT * FROM inventory WHERE status!=2 and ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_inventory = ".$lookup;
		   }
		  $qry = $qry.$condition;
		
		 $aInventoryItem = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				
				
				$aInventoryItem['id_inventory']   = $row->id_inventory;
				$aInventoryItem['dc_number']   = $row->dc_number;
				$aInventoryItem['grn_no']   = $row->grn_no;
				$aInventoryItem['direct_order']   = $row->direct_order;
				$aInventoryItem['dc_date']   = $row->dc_date;
				$aInventoryItem['id_po']   = $row->id_po;
				$aPurchaseOrderInfo= $this->getPurchaseOrderInfo($row->id_po);
				$aInventoryItem['po_number']   = $aPurchaseOrderInfo['po_number'];
				$aInventoryItem['po_date']   = $row->po_date;
				$aInventoryItem['id_vendor']   = $row->id_vendor;
				$aInventoryItem['id_store']   = $row->id_store;
				$aInventoryItem['vendor_name']   = $this->getVendorName($row->id_vendor);
				$aInventoryItem['bill_number']   = $row->bill_number;
				$aInventoryItem['bill_date']   = $row->bill_date;
				$aInventoryItem['grant_total']   = $row->grant_total;
				$aInventoryItem['total']   = $row->total;
				$aInventoryItem['net_total']   = $row->net_total;
				$aInventoryItem['round_off']   = $row->grant_total;
				$aInventoryItem['id_inventory_tax']   = $row->id_inventory_tax;
				$aInventoryItem['remark']   = $row->remark;
				$aInventoryItem['status']   = $row->status;
				$aInventoryItem['invendory_date']   = $row->invendory_date;	
					
				$aVendorInfos = $this->getPrintVendorAddress($row->id_vendor,'id'); 
				$avendorAddress =array();
				$avendorAddress['name'] = $this->getVendorName($row->id_vendor);
				$avendorAddress['contact_name'] = $aVendorInfos['contact_name'];
				$avendorAddress['addr1'] = $aVendorInfos['addr1'];
				$avendorAddress['addr2'] = $aVendorInfos['addr2'];$avendorAddress['addr3'] = $aVendorInfos['addr3'];
				$avendorAddress['city_name'] = $aVendorInfos['city_name'];$avendorAddress['zipcode'] = $aVendorInfos['zipcode'];
				$aInventoryItem['vendor_address_format'] =  $avendorAddress;	
				
				 $aStoreInfos1 = $this->getStoreInfo($row->id_store,'id'); 
				$aStoreAddress1 =array();
				$aStoreAddress1['name'] = $aStoreInfos1['unitname'];
				$aStoreAddress1['addr1'] = $aStoreInfos1['addr1'];
				$aStoreAddress1['addr2'] = $aStoreInfos1['addr2'];$aStoreAddress1['addr3'] = $aStoreInfos1['addr3'];
				$aStoreAddress1['city_name'] = $aStoreInfos1['city_name'];$aStoreAddress1['zipcode'] = $aStoreInfos1['zipcode'];
				$aInventoryItem['store_address_format'] = $aStoreAddress1;							
					   }
		   }
		   return $aInventoryItem;
	}
	
		
 // Stock list
	public function getAssetStock($lookup,$type)
	{
		$qry = "SELECT * FROM asset_stock WHERE status!=2 and ";
		   if($type == 'asset') {
			 $condition = " id_asset_item = '$lookup'";
		   }
		    else if($type == 'unit') {
			 $condition = " id_unit = '$lookup'";
		   }
		   else {
			 $condition = " id_asset_stock = ".$lookup;
		   }
		  $qry = $qry.$condition;
		  
		 $aStock = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				$aStock['id_asset_stock	']   = $row->id_asset_stock	;
				$aStock['id_asset_item']   = $row->id_asset_item;
				$aStock['id_unit']   = $row->id_unit;
				$aStock['id_store']   = $row->id_store;
				$aStock['stock_quantity']   = $row->stock_quantity;
				$aStock['status']   = $row->status;
				$aStoreInfo = $this->getStoreInfo($row->id_store,'id');
			   $aStock['store_name']   = $aStoreInfo['store_name'];
			}
			return $aStock;
		   }
	}
	
	public function addAssetStock($assetitemId,$unitId,$storeId,$quantity )
	{
		 // FOR Transaction purpose Only
		 $aRequest = array();
		$aRequest['assetitemId'] = $assetitemId;
		$aRequest['unitId'] = $unitId;
		$aRequest['storeId'] = $storeId;
		$aRequest['quantity'] = $quantity;
		//
		$created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		if($storeId == '' || $storeId == 0)
		{
		$aStoreInfo   = $this->getStoreInfo($unitId,'unit');
		$storeId = $aStoreInfo['id_store'];
		}
		else
		{
			$storeId;
		}
		$qry  = "
		INSERT INTO asset_stock(id_asset_stock, id_asset_item, id_unit, id_store, stock_quantity, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$assetitemId','$unitId','$storeId','$quantity','$created_by',now(),'','','1')";
		
		if($this->oDb->query($qry))	{
		 $lastInsertId = $this->oDb->insert_id;
					$this->addAssetTransLog($aRequest,'NEW',$assetitemId,$assetitemId,'AST',$storeId,'STR',$id_grn,$id_invendoryitem,$qry,'New Asset Added To Stock','');
					$asset_no = $this->getAssetNumber($assetitemId);
					$this->addHistoryTransLog($aRequest,$storeId,'STR','ASSET','NEWSTOCK',$asset_no,$assetitemId,'1',$qry,'New Asset Stock Added');	 	
		               return true;
					}
					else
					{
						  return false;
						  
			 $error_log =  $this->oDb->debug();
			 	$this->addAssetTransLog($aRequest,'ERROR',$assetitemId,$assetitemId,'AST',$lastInsertId,'STOCK',$id_grn,$id_invendoryitem,$qry,'Some Error occur during assign to stock ',$error_log );	
					}
	}
	public function addStockItem($aRequest)
	{
		$company = $this->getCompanyInfo(1,'id');
		$created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		$aItem = array_map(null,$aRequest['fItemName'],$aRequest['fGroup1'],$aRequest['fGroup2'],$aRequest['fQuanity'],$aRequest['fUOMId'],$aRequest['fvendorId'],$aRequest['fManufactureId'],$aRequest['fRefAssetNo'] ,$aRequest['fStoreId'],$aRequest['fMachineNo'],$aRequest['fMachineDate'],$aRequest['fMachineLife'],$aRequest['fDepressation'],$aRequest['fDateofInstall'],$aRequest['fWarrantyStartDate'],$aRequest['fWarrantyEndDate'],$aRequest['fMachinePrice']);
		foreach($aItem as $Item)
		{
		
		$aItemgroup = explode("/",$Item[8]);
		$aCountItem = array_keys($aItem);
			
		$asset_no = $this->assetCount();
		$item_lookup = $this->getItemInfo($Item[0] ,'id');
		$asset_number=$asset_no['count'];
		$Asset_numbers = $company['lookup'].'-'.$item_lookup['lookup'].'-'.$asset_number;
		if($Item[14]!='')
		{
		$Warranty_start = date('Y-m-d',strtotime($Item[14]));
		}
		if($Item[15]!='')		{
		$Warranty_end= date('Y-m-d',strtotime($Item[15]));
		}
		if($Item[0]>0)
		{
		$qry = "INSERT INTO asset_item(id_asset_item, id_asset_category, id_asset_type, id_itemgroup1, id_itemgroup2, quantity, id_uom, id_vendor, id_manufacturer, id_unit,machine_no,warranty_start_date,warranty_end_date,asset_no,ref_asset_no,id_grn, id_inventory_item, id_po, asset_name, asset_amount, depressation_percent, remark, date_of_install,machine_date,machine_life, machine_price,created_by,created_on,modified_by,modified_on,status) VALUES (NULL,'', '','$Item[1]','$Item[2]','$Item[3]','$Item[4]','$Item[5]','$Item[6]','$aItemgroup[1]','".strtoupper($Item[9])."','$Warranty_start','$Warranty_end','".$Asset_numbers."','$Item[7]','','','','$Item[0]','$Item[16]','$Item[12]','','".date('Y-m-d',strtotime($Item[13]))."','".date('Y-m-d',strtotime($Item[10]))."','$Item[11]','','$created_by',now(),'','','1')";
			
		if($this->oDb->query($qry))	{
			
			                       $lastInsertId = $this->oDb->insert_id;
								   $this->addAssetTransLog($aRequest,'NEW',$lastInsertId,'','','','','','',$qry,'New Asset Added Directly','');	
								   	$this->addHistoryTransLog($aRequest,'','','ASSET','NEW',$Asset_numbers,$lastInsertId,'1',$qry,'New Asset Added Directly');	 	
								   if($Item[14]!='' && $Item[15]!='')
		                            {
										if($this->addWarranty($aRequest,$Item[14],$Item[15],$lastInsertId))
										{
										$done = 1;
										}
										else
										{
										$done = 0;
										
									$this->oDb->debug();
								
									
										}
								   }
									if($this->addAssetStock($lastInsertId,$aItemgroup[1],$aItemgroup[0],$Item[3]))
									{
									
									$done = 1;
									}
									else
									{
									$done = 0;
															
									$this->oDb->debug();
								
									}
								    $done = 1;
			}
			else
			{
				 $done = 0;
				
			  $this->oDb->debug();
						 
			}
		} //if
		$asset_no = '';	
		} //for each
			
		
		if($done == 1)
		{
			return true;
		}
		else
		{
			return false;
		 $this->oDb->debug();
		}
				
	}
	public function updateStockItem($aRequest)
	{
		
		$stock_item =$aRequest['fItemName'];
		$stock_group1 =$aRequest['fGroup1'];
		$stock_group2 =$aRequest['fGroup2'];
		$stock_qty =$aRequest['fQuanity'];
		$stock_uom =$aRequest['fUOMId'];
		$id_vendor = $aRequest['fvendorId'];
		$id_manufacturer=$aRequest['fManufactureId'];
		$asset_no =$aRequest['fAssetNo'];
		$ref_asset_no =$aRequest['fRefAssetNo'];
		$id_store = $aRequest['fStoreId'];
		$aItemgroup = explode("/",$id_store);
		$machine_no = strtoupper($aRequest['fMachineNo']);
		$machine_date =date('Y-m-d',strtotime($aRequest['fMachineDate']));
		$machine_life = $aRequest['fMachineLife'];
		$stock = $aRequest['fAssetStockId'];
		
		$aResult = array();
		$aResult['url'] = $aRequest['fUrl'];
		
		 $modified_by        = $_SESSION['sesCustomerInfo']['user_id'];
		$deprisation =  $aRequest['fDepressation'];
		$machine_price = $aRequest['fMachinePrice'];
		if($aRequest['fWarrantyStartDate']!='')
		{
		$Warranty_start = date('Y-m-d',strtotime($aRequest['fWarrantyStartDate']));
		}
		if($aRequest['fWarrantyEndDate']!='')
		{
		$Warranty_end= date('Y-m-d',strtotime($aRequest['fWarrantyEndDate']));
		}
		
		if($aRequest['fDateofInstall'] != '')
		{
		$dateof_install = date('Y-m-d',strtotime($aRequest['fDateofInstall']));
		}
	
	                               if($aRequest['fWarrantyStartDate']!='' && $aRequest['fWarrantyEndDate']!='')
		                            {
							if($this->addWarranty($aRequest,$aRequest['fWarrantyStartDate'],$aRequest['fWarrantyEndDate'],$stock))
										{
										$done = 1;
										}
										else
										{
										$done = 0;
										
									$this->oDb->debug();
									
									
										}
										}
	
	
	 $qry = " UPDATE asset_item SET id_itemgroup1='".$stock_group1."',id_itemgroup2='".$stock_group2."',quantity='".$stock_qty."',id_uom='".$stock_uom."',id_vendor='".$id_vendor."',id_manufacturer='".$id_manufacturer."',id_unit='".$aItemgroup[1]."',asset_name = '".$stock_item."',machine_no='".$machine_no."',warranty_start_date='".$Warranty_start."',warranty_end_date='".$Warranty_end."',asset_no='".$asset_no."',machine_date='".$machine_date."',depressation_percent ='".$deprisation."',
	 ref_asset_no ='".$ref_asset_no."',
	 date_of_install= '".$dateof_install."',	 
	 machine_life='".$machine_life."',asset_amount='".$machine_price."',modified_by='".$modified_by ."',modified_on=now() WHERE id_asset_item=".$stock;
	
		 if($this->oDb->query($qry)){
		 $asset_no = $this->getAssetNumber($stock);
			  $this->addAssetTransLog($aRequest,'UPDATE',$stock,'','','','','','',$qry,'Asset Updated','');	
			$this->addHistoryTransLog($aRequest,'','','ASSET','UPDATE',$asset_no,$stock,'1',$qry,'Asset Updated');
			 		$qrys = "UPDATE asset_stock SET id_store='".$aItemgroup[0]."' ,id_unit ='".$aItemgroup[1]."',stock_quantity='".$stock_qty."' WHERE id_asset_item=".$stock;
					
		              if($this->oDb->query($qrys))	{ $done = 1;}else{$done=0;}
					  $done = 1;
					}
					else
					{
						$done = 0;
			
			  $this->oDb->debug();
			
					}
				
					if($done == 1)
					{
							$aResult['msg'] = 1;
						
					}
					else
					{
						$aResult['msg'] = 0;
			
		 
			  $this->oDb->debug();
			
					}
				
		return $aResult;
		
	}
	public function deleteStockItem($delvalue)
	{
				
		 $qrys = "UPDATE asset_item SET status = 2 WHERE id_asset_item = ".$delvalue;
		
		   if($this->oDb->query($qrys))	{
		              return true;
					}
					else
					{
						return false;
						 if($DEBUGS !=0)
			  {
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  }
					}
		
		
	}
	
	
	
 public function getStockList($type='')
  {
		if(empty($type))
		{
		$qry = "SELECT * FROM asset_stock WHERE status !=2 ORDER BY id_asset_stock DESC ";
		 }
		 else
		 {
		 $qry = "SELECT * FROM asset_stock WHERE status !=2 and  status !=19  ORDER BY id_asset_stock DESC ";
		 }
		$aStockList = array();
		
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aStock['id_asset_item']   = $row->id_asset_item;
				$aStock['id_store']   = $row->id_store;
				
					$aStore  = $this->getStoreInfo($row->id_store,'id');
				$aStock['store_name'] = $aStore['store_name'];
				
				$aStock['stock_quantity']   = $row->stock_quantity;
				$aStock['status']   = $row->status;
				$aAssetItemInfo =$this->getAssetItemInfo($row->id_asset_item,'id');
				$aStock['id_itemgroup1']   = $aAssetItemInfo['id_itemgroup1'];
				$aStock['itemgroup2_name'] = $aAssetItemInfo['itemgroup2_name'];
				$aStock['itemgroup1_name'] = $aAssetItemInfo['itemgroup1_name'];
				$aStock['asset_image'] = $aAssetItemInfo['asset_image'];
				$aStock['item_name'] = $aAssetItemInfo['item_name'];
				$aStock['manufacturer_name'] = $aAssetItemInfo['manufacturer_name'];
				$aStock['id_itemgroup2']   = $aAssetItemInfo['id_itemgroup2'];
				$aStock['quantity']   = $aAssetItemInfo['quantity'];
				$aStock['id_uom']   = $aAssetItemInfo['id_uom'];
				$aStock['id_vendor']   = $aAssetItemInfo['id_vendor'];
				$aStock['id_manufacturer']   =$aAssetItemInfo['id_manufacturer'];
				$aStock['id_unit']   = $aAssetItemInfo['id_unit'];
				$aStock['unit_name'] = $aAssetItemInfo['unit_name'];
				$aStock['machine_no']   = strtoupper($aAssetItemInfo['machine_no']);
				$aStock['asset_no']   = $aAssetItemInfo['asset_no'];
				$aStock['machine_date']   =$aAssetItemInfo['machine_date'];
				$aStock['machine_life']   = $aAssetItemInfo['machine_life'];
				$aStock['asset_name']   = $aAssetItemInfo['asset_name'];
				$aStock['asset_amount']   = $aAssetItemInfo['asset_amount'];
				 $DivisionInfo = $this->getDivisionInfo($row->id_division,'id');
			   $aStock['division_name']   = $DivisionInfo['division_name'];
				$aStockList[]        = $aStock;
			}
		}
		return $aStockList;
  } //	
  
   public function getStockInfo($lookup, $type )
  {
		
					
		$qry = "SELECT * FROM asset_stock WHERE status !=2  ";
		   if($type == 'asset') {
			 $condition = " and id_asset_item = '$lookup'";
		   }
		   else {
			 $condition = " and id_asset_stock = ".$lookup;
		   }
		  $qry = $qry.$condition;
		   
		 $aStockList = array();
		$aStock = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				
				$aStock['id_asset_item']   = $row->id_asset_item;
				$aStock['id_store']   = $row->id_store;
				$aStock['stock_quantity']   = $row->stock_quantity;
				$aStock['status']   = $row->status;
				$aAssetItemInfo =$this->getAssetItemInfo($row->id_asset_item,'id');
			
				$aStock['id_itemgroup1']   = $aAssetItemInfo['id_itemgroup1'];
				$aStock['itemgroup2_name'] = $aAssetItemInfo['itemgroup2_name'];
				$aStock['itemgroup1_name'] = $aAssetItemInfo['itemgroup1_name'];
				$aStock['item_name'] = $aAssetItemInfo['item_name'];
				$aStock['manufacturer_name'] = $aAssetItemInfo['manufacturer_name'];
				$aStock['id_itemgroup2']   = $aAssetItemInfo['id_itemgroup2'];
				$aStock['quantity']   = $aAssetItemInfo['quantity'];
				$aStock['id_uom']   = $aAssetItemInfo['id_uom'];
				$aStock['id_vendor']   = $aAssetItemInfo['id_vendor'];
				$aStock['id_manufacturer']   =$aAssetItemInfo['id_manufacturer'];
				$aStock['id_unit']   = $aAssetItemInfo['id_unit'];
				$aStock['unit_name'] = $aAssetItemInfo['unit_name'];
				$aStock['machine_no']   =strtoupper($aAssetItemInfo['machine_no']);
				$aStock['asset_no']   = $aAssetItemInfo['asset_no'];
				if($aAssetItemInfo['id_inventory_item'] > 0)
				{
				$aStock['machine_price'] = $this->getMachineUnitPrice($aAssetItemInfo['id_inventory_item']);
				}
				else
				{
				$aStock['machine_price']   = $aAssetItemInfo['asset_amount'];
				}
				$aWarranty = $this->getWarrantyDates($row->id_asset_item);
				$aStock['warranty_start_date']   =$aWarranty['warranty_start_date'];
				$aStock['warranty_end_date']   =$aWarranty['warranty_end_date'];
				
				$aStock['machine_date']   =$aAssetItemInfo['machine_date'];
				$aStock['machine_life']   = $aAssetItemInfo['machine_life'];
				$aStock['ref_asset_no']   =$aAssetItemInfo['ref_asset_no'];
				$aStock['date_of_install']   =$aAssetItemInfo['date_of_install'];
				$aStock['depressation_percent']   = $aAssetItemInfo['depressation_percent'];
				$aStock['asset_name']   = $aAssetItemInfo['asset_name'];
						
				//$aStockList[]        = $aStock;
			}
		}
		return $aStock;
  } //	
	
 // Asset Item
 public function addAssetItem($aRequest,$files)
	{
		//add a new Inventory.
		$id_grn    = $aRequest['fgrnId'];
		$asset_name = strtoupper($aRequest['fItemName']);
		$id_invendoryitem    = $aRequest['fInventoryItemid'];
		$id_asset_group1 = $aRequest['fGroup1'];
		$id_asset_group2 = $aRequest['fGroup2'];
		$asset_amt = $aRequest['fAssetAmount'];
		$id_po = $aRequest['fPoId'];
		$asset_no = $this->assetCount();
		$inventoryitemqty = $aRequest['fInventoryItemqty'];
		$id_vendor = $aRequest['fVendorId'];
		$asset_name = strtoupper($aRequest['fItemName']);
		$item_lookup = $this->getItemInfo($asset_name ,'id');
		$company = $this->getCompanyInfo(1,'id');
		$depressation_percent = $aRequest['fDepressation'];	
		$remark = $aRequest['fRemark'];	
		$store_unit = $aRequest['fStoreId'];	
		$date_of_install = date('Y-m-d',strtotime($aRequest['fDateofInstall']));
		$created_by        = $_SESSION['sesCustomerInfo']['user_id'];
        $aUnitStore = explode("/",$store_unit);
		$id_store = $aUnitStore[0];
		$id_unit = $aUnitStore[1];
		$id_uom = $aRequest['fUOMId'];
		$machine_date = date('Y-m-d',strtotime($aRequest['fMachineDate']));
		$machine_life = $aRequest['fMachineLife'];
		$id_manufacture = $aRequest['fManufactureId'];
		$id_contract = $aRequest['fContractID'];
		$aContractInfo = $this->getContractInfos($id_contract,'id');
		$contract_start_date =date('Y-m-d',strtotime($aContractInfo['contract_start_date']));
		$contract_end_date =date('Y-m-d',strtotime($aContractInfo['contract_end_date']));
		$id_image = $aRequest['fImageId'];
		 $maxCount = $this->contractMaxCount($contractId);
		 $id_asset_type = $aRequest['fAssetTypeId'];
		for($i=1;$i<=$inventoryitemqty;$i++)
			 {
				 $quantity = 1;
				$asset_number=$asset_no['count']+$i-1;
			$Asset_numbers = $company['lookup'].'-'.$item_lookup['lookup'].'-'.$asset_number;
			//$Asset_numbers = $company['lookup'].'-'.$item_lookup['lookup'].'-'.$asset_number;
			//$asset_names = $asset_name.'-'.$i;
			  $qry = "INSERT INTO asset_item(id_asset_item, id_asset_category, id_asset_type, id_itemgroup1, id_itemgroup2, quantity, id_uom, id_vendor, id_manufacturer, id_unit, machine_no,warranty_start_date,warranty_end_date, asset_no,ref_asset_no, id_grn, id_inventory_item, id_po, asset_name, asset_amount, depressation_percent, remark, date_of_install, machine_date, machine_life,id_image, created_by, created_on, modified_by, modified_on, status) VALUES  (NULL, '', '$id_asset_type', '$id_asset_group1','$id_asset_group2', '$quantity', '$id_uom', '$id_vendor', '$id_manufacture','$id_unit','".strtoupper($aRequest['fMachineNumber'.$i])."','".date('Y-m-d',strtotime($aRequest['fWarrantyStartDate'.$i]))."','".date('Y-m-d',strtotime($aRequest['fWarrantyEndDate'.$i]))."','".$Asset_numbers."','','$id_grn','$id_invendoryitem','$id_po','$asset_name','$asset_amt','$depressation_percent','$remark','$date_of_install','$machine_date ','$machine_life','$id_image','$created_by',now(),'','','1')";
			
		if($this->oDb->query($qry))	{
			 $lastInsertId = $this->oDb->insert_id;
			$this->addAssetTransLog($aRequest,'NEW',$lastInsertId,'','','','',$id_grn,$id_invendoryitem,$qry,'New Asset Added','');	
			$this->addHistoryTransLog($aRequest,'','','ASSET','NEW',$Asset_numbers,$lastInsertId,'1',$qry,'New Asset Created','');	 
			  if($aRequest['fWarrantyStartDate'.$i]!='' && $aRequest['fWarrantyEndDate'.$i]!='')
		                            {
							if($this->addWarranty($aRequest,$aRequest['fWarrantyStartDate'.$i],$aRequest['fWarrantyEndDate'.$i],$lastInsertId))
										{
										$done = 1;
										}
										else
										{
										$done = 0;
										$this->oDb->debug();
										}
										}
			 
			  $balanceCount = $this->contractBalanceCount($id_contract);	
			 if($balanceCount!=0)
			 {
						 $query_multiple = "INSERT INTO asset_contract (id_asset_contract, id_asset_item, id_contract, contract_start_date, contract_end_date, remarks, status) VALUES (NULL, ' $lastInsertId', '$id_contract', '$contract_start_date', '$contract_end_date ', '', '1')";
						$this->oDb->query($query_multiple);
			 }
			
			         $this->addAssetStock($lastInsertId,$id_unit,$id_store,$quantity );
			  		$qrys = "UPDATE inventory_item SET asset_status=3 WHERE id_inventory_item=".$id_invendoryitem;
					if( $this->oDb->get_results($qrys))
					{
					   $done = 1;
					}
					else
					{
						 $done = 0;
						 /* echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';*/
					}
					$done = 1;
				
			}
			else{
			  $done = 0;
			 /*  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';*/
			}
		 }
		
		 		/*echo '<pre>';
				print_r($aRequest['fDeleteImageCheckbox']);
				    echo '<pre>';*/
			$add_images =  $aRequest['fAddImgeCheckbox'];
				$aRemoveimages =  $aRequest['fDeleteImageCheckbox'];
				foreach($aRemoveimages as $key => $value)
				{
					$qrys = "DELETE FROM asset_image WHERE id_image=".$value;
					$this->oDb->query($qrys);
				}
				if($add_images == 'on')
				{
										
						if($this->multiUploadAssetImage($aRequest,$files, $lastInsertId))
						{
						$done = 1;
						}
						else
						{
						$done = 0;
						/* echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';*/
						}
										
					
				}
			
		
		//single 
		/* $asset_number=$asset_no['count'];
		  $qry = "INSERT INTO asset_item (id_asset_item, id_asset_category, id_asset_type,asset_no, id_grn, id_inventory_item, id_po, asset_name, asset_amount) VALUES (NULL, '$id_asset_category', '$id_asset_type', '$asset_number','$id_grn', '$id_invendoryitem', '$id_po', '$asset_name', '$asset_amt')";
			 
			if($this->oDb->query($qry))	{
			 $lastInsertId = $this->oDb->insert_id;
			  		$qrys = "UPDATE inventory_item SET asset_status=3 WHERE id_inventory_item=".$id_invendoryitem;
					if( $this->oDb->get_results($qrys))
					{
					   $done = 1;
					}
					else
					{
						 $done = 0;
					}
					$done = 1;
				if(!empty($files['fImage']['name']))
				{	
					if($this->updateAssetImage($aRequest,$files))
					{
					$done = 1;
					}
					else
					{
					$done = 0;
					}
				}
			}
			else{
			  $done = 0;
			}*/
			// end single
		
		   if($done == 1)
		   {
			   /*$aasset['asset_no'] = $lastInsertId+10000;
			   $aasset['id_vendor'] = $id_vendor;
			   return $aasset;*/
			   return true;
		   }
		   else
		   {
			     return false;
				
			  $this->oDb->debug();
			  
		   }
		
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
				$assetImage['image_description'] = $row->image_description;
				
				}
				return $assetImage;
	}
	
	
	
	public function getAssetItemList($lookup, $type)
	{
		
		 if($type == 'grn') {
			  $qry = "SELECT DISTINCT(id_inventory_item),asset_name FROM asset_item WHERE status!=2";
			 $condition = " AND id_grn = '$lookup'";
		   }
		   else {
		    $qry = "SELECT * FROM asset_item WHERE status!=2 ORDER BY id_asset_item DESC " ;
			 $condition = " ";
		   }
		 $qry = $qry.$condition;
		 
		 if($result = $this->oDb->get_results($qry))
		   {
			foreach($result as $row)
			{	$aAssetItem = array();
				$aAssetItem['id_asset_item']   = $row->id_asset_item;
				$aAssetItem['id_itemgroup1']   = $row->id_itemgroup1;
				$aAssetItem['id_itemgroup2']   = $row->id_itemgroup2;
				$aAssetItem['status']   = $row->status;
				
				$aItemGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aAssetItem['itemgroup2_name'] = $aItemGroup2['itemgroup2_name'];
				$aItemGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aAssetItem['itemgroup1_name'] = $aItemGroup1['itemgroup1_name'];
				$aItem = $this->getItemInfo($row->asset_name,'id');
				$aAssetItem['item_name'] = $aItem['item_name'];
				
				$aAssetItem['asset_no']   = $row->asset_no;
				$aAssetItem['id_grn']   = $row->id_grn;
				$aAssetItem['id_inventory_item']   = $row->id_inventory_item;
				$aAssetItem['id_po']   =$row->id_po;
				 $result_image =  $this->checkInventoryItem($row->id_inventory_item);
				if($result_image > 0)
				{
				$aAssetItems =$this->getAssetImage($row->id_inventory_item);
				$aAssetItem['asset_image'] = $aAssetItems['image'];
				$aAssetItem['id_image'] = $aAssetItems['id_image'];
				}
				else
				{
				$aAssetItems =$this->getAssetImage($row->id_asset_item,'assetid');
				$aAssetItem['asset_image'] = $aAssetItems['image'];
				$aAssetItem['id_image'] = $aAssetItems['id_image'];
				}
				$aAssetItem['asset_name']   = $row->asset_name;
				$aAssetItem['asset_amount']   = $row->asset_amount;
				$aInventoryIteminfo = $this->getInventoryInfo($row->id_grn,'id');
				$aAssetItem['id_vendor']	= $aInventoryIteminfo['id_vendor'];
				$aAssetItemList[] = $aAssetItem;	
			   }
		   }
		   return $aAssetItemList;
	}
	
	
	
	public function getAssetItemByGrn($grnid, $inventoryId)
	{
		 $qry = "SELECT * FROM asset_item WHERE status!=2 AND id_grn='".$grnid."' AND id_inventory_item =".$inventoryId;
		 $aAssetItemInfo = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				
				
				$aAssetItemInfo['id_asset_item']   = $row->id_asset_item;
				$aAssetItemInfo['id_asset_category']   = $row->id_asset_category;
				$aAssetItemInfo['id_asset_type']   = $row->id_asset_type;
				$aAssetItemInfo['asset_no']   = $row->asset_no;
				$aAssetItemInfo['id_grn']   = $row->id_grn;
				$aAssetItemInfo['id_inventory_item']   = $row->id_inventory_item;
				$aAssetItemInfo['id_po']   =$row->id_po;
				$aAssetItemInfos  =$this->getAssetImage($row->id_inventory_item);
				$aAssetItemInfo['asset_image'] = $aAssetItemInfos['image'];
				$aAssetItemInfo['id_image'] = $aAssetItemInfos['id_image'];
				$aAssetItemInfo['id_itemgroup1']   = $row->id_itemgroup1;
				$aAssetItemInfo['id_itemgroup2']   = $row->id_itemgroup2;
				
				$aItemGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aAssetItemInfo['itemgroup2_name'] = $aItemGroup2['itemgroup2_name'];
				$aItemGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aAssetItemInfo['itemgroup1_name'] = $aItemGroup1['itemgroup1_name'];
				$aItem = $this->getItemInfo($row->asset_name,'id');
				$aAssetItemInfo['item_name'] = $aItem['item_name'];
				$aAssetItemInfo['asset_amount']   = $row->asset_amount;
				$aInventoryIteminfo = $this->getInventoryItemInfo($row->id_inventory_item,'lookup');
				$aAssetItemInfo['inventory_item_reference']	= $aInventoryIteminfo['item_ref_number'];
				$aAssetItemInfoLists[] =$aAssetItemInfo; 
					   }
		   }
		   return $aAssetItemInfoLists;
	}
	public function getAssetItemInfo($lookup, $type)
	{
		
		 $qry = "SELECT * FROM asset_item WHERE status!=2";
		   if($type == 'id') {
			 $condition = " AND id_asset_item = '$lookup'";
		   }
		   else if($type == 'grn') {
			 $condition = " AND id_grn = '$lookup'";
		   }
		   else {
			 $condition = " AND asset_no = ".$lookup;
		   }
		  $qry = $qry.$condition;
		 
		 $aAssetItemInfo = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				
				
				$aAssetItemInfo['id_asset_item']   = $row->id_asset_item;
				$aAssetItemInfo['id_asset_category']   = $row->id_asset_category;
				$aAssetItemInfo['id_asset_type']   = $row->id_asset_type;
				$aAssetItemInfo['asset_no']   = $row->asset_no;
				$aAssetItemInfo['id_grn']   = $row->id_grn;
				$aAssetItemInfo['id_inventory_item']   = $row->id_inventory_item;
				$aAssetItemInfo['id_po']   =$row->id_po;
				$aAssetItemInfos =$this->getAssetImage($row->id_inventory_item);
				$aAssetItemInfo['asset_image'] = $aAssetItemInfos['image'];
				$aAssetItemInfo['id_image'] = $aAssetItemInfos['id_image'];
				$aAssetItemInfo['asset_name']   = $row->asset_name;
				$aAssetItemInfo['asset_amount']   = $row->asset_amount;
				$aInventoryIteminfo = $this->getInventoryItemInfo($row->id_inventory_item,'lookup');
				$aAssetItemInfo['inventory_item_reference']	= $aInventoryIteminfo['item_ref_number'];
				
				$aAssetItemInfo['id_itemgroup1']   = $row->id_itemgroup1;
				$aItemGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aAssetItemInfo['itemgroup2_name'] = $aItemGroup2['itemgroup2_name'];
				$aItemGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aAssetItemInfo['itemgroup1_name'] = $aItemGroup1['itemgroup1_name'];
				$aItem = $this->getItemInfo($row->asset_name,'id');
				$aAssetItemInfo['item_name'] = $aItem['item_name'];
				$aManufacturer = $this->getManufacturerInfo($row->id_manufacturer,'id');
				$aAssetItemInfo['manufacturer_name'] = $aManufacturer['manufacturer_name'];
				$aAssetItemInfo['id_itemgroup2']   = $row->id_itemgroup2;
				$aAssetItemInfo['quantity']   = $row->quantity;
				$aAssetItemInfo['id_uom']   = $row->id_uom;
				$aAssetItemInfo['id_vendor']   = $row->id_vendor;
				$aAssetItemInfo['id_manufacturer']   = $row->id_manufacturer;
				$aAssetItemInfo['id_unit']   = $row->id_unit;
				
				$aAssetItemInfo['ref_asset_no']   =$row->ref_asset_no;
				$aAssetItemInfo['date_of_install']   =$row->date_of_install;
				$aAssetItemInfo['depressation_percent']   = $row->depressation_percent;
				
				$aUnit = $this->getUnitInfo( $row->id_unit,'id');
				$aAssetItemInfo['unit_name'] = strtoupper($aUnit['unit_name']);
				$aAssetItemInfo['machine_no']   = strtoupper($row->machine_no);
				$aAssetItemInfo['machine_date']   = $row->machine_date;
				$aAssetItemInfo['warranty_start_date']   =$row->warranty_start_date;
				$aAssetItemInfo['warranty_end_date']   =$row->warranty_end_date;
				$aAssetItemInfo['machine_life']   = $row->machine_life;
				if($row->id_inventory_item > 0)
				{
				$aAssetItemInfo['machine_price'] = $this->getMachineUnitPrice($row->id_inventory_item);
				}
				else
				{
				$aAssetItemInfo['machine_price']   = $row->asset_amount;
				}
				
				
				$aAssetItemInfo['status']    = $row->status;
				$aStockInfo = $this->getAssetStock($row->id_asset_item,'asset');
				$aAssetItemInfo['from_id_store'] = $aStockInfo['id_store'];
				$aAssetItemInfo['store_name'] = $aStockInfo['store_name'];
					   }
		   }
		   return $aAssetItemInfo;
	}
	
	public function addContracts($aRequest,$files)
	{
		 $vendor_contact = $aRequest['fVendorContactId'];
		$remark = $aRequest['fRemark'];
		$contract_title = $aRequest['fContractTitle'];
		$contract_type = $aRequest['fContractType'];
		$id_vendor = $aRequest['fVendorId'];
		$contract_start_date = date('Y-m-d H:i:s',strtotime($aRequest['fContractStartDate']));
		$contract_end_date = date('Y-m-d H:i:s',strtotime($aRequest['fContractEndDate']));
		$contract_reference_number = $aRequest['fContractReferenceNo'];
		$contract_date = date('Y-m-d H:i:s',strtotime($aRequest['fContractDate']));
		$renewal_contract_date = date('Y-m-d H:i:s',strtotime($aRequest['fContractRenewalDate']));
		$no_items = $aRequest['fMaxContract'];	
		$terms = $aRequest['fTerms'];	
		$contractorder_value = $aRequest['fContractOrderValue'];
		$contract_value = $aRequest['fContractValue'];			
		
		  $qry = "INSERT INTO  contract (id_contract ,contract_type ,contract_title,id_vendor,contract_order_value,contract_value,contract_start_date ,contract_end_date ,contract_reference_number ,remark,contract_date ,renewal_date,no_items, terms_and_conditions)VALUES (NULL ,  '$contract_type','$contract_title','$id_vendor', '$contractorder_value','$contract_value', '$contract_start_date',  '$contract_end_date',  '$contract_reference_number','$remark', '$contract_date',  '$renewal_contract_date','$no_items','$terms');";
if($this->oDb->query($qry))	{
			 $lastInsertId = $this->oDb->insert_id;
				 	if($this->multiUploadDocument($aRequest,$lastInsertId,$files))
					{
					
					$done = 1;
					}
					else
					{
					$done = 0;
					
			  $this->oDb->debug();
			 
					}
		foreach($vendor_contact as $key => $value)
			 {
			 			 $contact_qry ="INSERT INTO contract_contact (id_contract_contact, id_contract, id_vendor_contact, status) VALUES (NULL,'$lastInsertId', '$value','1')";
			$this->oDb->query($contact_qry);
			 }
					$done = 1;
}
else
{
	$done = 0;
	
			  $this->oDb->debug();
			
}
  if($done == 1)
		   {
			   return  true;
		   }
		   else
		   {
			     return false;
				  if($DEBUGS !=0)
			  {
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  }
		   }
	}
		public function updateContract($aRequest,$files)
	{
	  $vendor_contact = $aRequest['fVendorContactId'];
		$remark = $aRequest['fRemark'];
		$contract_title = $aRequest['fContractTitle'];
		$contract_type = $aRequest['fContractType'];
		$id_vendor = $aRequest['fVendorId'];
		$contract_start_date = date('Y-m-d H:i:s',strtotime($aRequest['fContractStartDate']));
		$contract_end_date = date('Y-m-d H:i:s',strtotime($aRequest['fContractEndDate']));
		$contract_reference_number = $aRequest['fContractReferenceNo'];
		$contract_date = date('Y-m-d H:i:s',strtotime($aRequest['fContractDate']));
		$renewal_contract_date = date('Y-m-d H:i:s',strtotime($aRequest['fContractRenewalDate']));
		$no_items = $aRequest['fMaxContract'];	
		$terms = $aRequest['fTerms'];	
		$contractorder_value = $aRequest['fContractOrderValue'];
		$contract_value = $aRequest['fContractValue'];	
		$created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		$contractid = $aRequest['fContractId'];
		$sql = "UPDATE `contract` SET `contract_type`='".$contract_type."',`contract_title`='".$contract_title."',`id_vendor`='".$id_vendor."',`contract_order_value`='".$contractorder_value."',`contract_value`='".$contract_value."',`contract_start_date`='".$contract_start_date."',`contract_end_date`='".$contract_end_date."',`contract_reference_number`='".$contract_reference_number."',`remark`='".$remark."',`contract_date`='".$contract_date."',`renewal_date`='".$renewal_contract_date."',`no_items`='".$no_items."',`terms_and_conditions`='".$terms."' WHERE id_contract='".$contractid."'";
		$this->oDb->query($sql);
		 foreach($vendor_contact as $key => $value)
			 {
					  $checkqry = "SELECT * FROM contract_contact WHERE id_contract='$contractid' AND id_vendor_contact='$value'";
					$this->oDb->query($checkqry);
					$num_rows = $this->oDb->num_rows;
					if($num_rows > 0)
					{
					  $contact_qry ="UPDATE contract_contact SET id_contract ='".$contractid."', id_vendor_contact='".$value."',status = '1'";
					 $this->oDb->query($contact_qry);
					}
					else
					{			 
						 $contact_qry ="INSERT INTO contract_contact (	id_contract_contact, id_contract, id_vendor_contact, status) VALUES (NULL,'$contractid', '$value','1')";
					$this->oDb->query($contact_qry);
					}
			 }
			
			 foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
			 if(!empty($_FILES['files']['name'][$key]))
			 {
			 if($this->multiUploadDocument($aRequest,$contractid,$files))
					{
					
					$done = true;
					}
					
					}
					}
			if( mysql_affected_rows() >= 0)
				{
				$done = true;
				
				}
				else
				{
				$done = false;
				}
		return 	$done;	
	}
	
	public function addContract($aRequest,$files)
	{
		
	   if($aRequest['fMultiple'] == 'yes')
	   {
		$asset_no = unserialize($aRequest['fAssetNumber']); 
		
	   }
	   else
	   {
		   $asset_no = $aRequest['fAssetNumber'];
	   }
	  
	   	$vendor_contact = $aRequest['fVendorContactId'];
		$remark = $aRequest['fRemark'];
		$contract_title = $aRequest['fContractTitle'];
		$contract_type = $aRequest['fContractType'];
		$id_vendor = $aRequest['fVendorId'];
		$contract_start_date = date('Y-m-d H:i:s',strtotime($aRequest['fContractStartDate']));
		$contract_end_date = date('Y-m-d H:i:s',strtotime($aRequest['fContractEndDate']));
		$contract_reference_number = $aRequest['fContractReferenceNo'];
		$contract_date = date('Y-m-d H:i:s',strtotime($aRequest['fContractDate']));
		$renewal_contract_date = date('Y-m-d H:i:s',strtotime($aRequest['fContractRenewalDate']));
		$no_items = $aRequest['fMaxContract'];	
		$terms = $aRequest['fTerms'];
		$contractorder_value = $aRequest['fContractOrderValue'];
		$contract_value = $aRequest['fContractValue'];
		
		  $qry = "INSERT INTO  contract (id_contract ,contract_type ,contract_title,id_vendor,contract_order_value,contract_value,contract_start_date ,contract_end_date ,contract_reference_number ,remark,contract_date ,renewal_date,no_items, terms_and_conditions)VALUES (NULL ,  '$contract_type','$contract_title','$id_vendor', '$contractorder_value','$contract_value','$contract_start_date',  '$contract_end_date',  '$contract_reference_number','$remark', '$contract_date',  '$renewal_contract_date','$no_items','$terms');";
			
			if($this->oDb->query($qry))	{
			 $lastInsertId = $this->oDb->insert_id;
			 foreach($vendor_contact as $key => $value)
			 {
			 			 $contact_qry ="INSERT INTO contract_contact (id_contract_contact, id_contract, id_vendor_contact, status) VALUES (NULL,'$lastInsertId', '$value','1')";
			$this->oDb->query($contact_qry);
			 }
			  foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
					 if(!empty($_FILES['files']['name'][$key]))
					 {
			if($this->multiUploadDocument($aRequest,$lastInsertId,$files))
					{
					
					$done = 1;
					}
					else
					{
					$done = 0;
					 if($DEBUGS !=0)
			  {
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  }
					}
			 }
			 }
			
						$aAssetCount=count($asset_no);	
						
						if($aRequest['fMultiple'] == 'yes')
	                        {
							
						for($i=0;$i<=$aAssetCount-1;$i++)
						{	
					 $query_multiple = "INSERT INTO asset_contract (id_asset_contract, id_asset_item, id_contract, contract_start_date, contract_end_date, remarks, status) VALUES (NULL, '$asset_no[$i]', '$lastInsertId', '$contract_start_date', '$contract_end_date ', '', '1')";
						$this->oDb->query($query_multiple);
						}
						}
						
						else
						{
					
					$query_single= "INSERT INTO asset_contract (id_asset_contract, id_asset_item, id_contract, contract_start_date, contract_end_date, remarks, status) VALUES (NULL, '$asset_no', '$lastInsertId', '$contract_start_date', '$contract_end_date ', '', '1')";
						$this->oDb->query($query_single);
						}
					
			 $done = 1;
			}
			else{
			  $done = 0;
			   if($DEBUGS !=0)
			  {
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  }
			}
		
		
		   if($done == 1)
		   {
			   return  true;
		   }
		   else
		   {
			     return false;
				  if($DEBUGS !=0)
			  {
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  }
		   }
		
	}
	
	public function multiUploadDocument($aRequest,$insertId,$files)
	{
		
				
		  /* $ext = explode(".", $fileName);
		   $ext = array_pop($ext);
		   $name = strtotime(date('Y-m-d h:i:s'));
		   $newFileName = $name.'_asset.'.$ext;
		   $fileup = $files['fImage']['tmp_name']; //echo '<br>';
		   $targetPath 	= APP_ROOT."/uploads/assetimage/"; //echo '<br>';
		   $targetFileName = $lastInsertId.$newFileName; //echo '<br>';
		   move_uploaded_file($fileup, $targetPath.$targetFileName);*/
				
		 if(isset($_FILES['files'])){
    $errors= array();
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
	   $name = strtotime(date('Y-m-d h:i:s'));
		$file_name = $name.'-'.$_FILES['files']['name'][$key];
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];	
        if($file_size > 60097152){
			$errors[]='File size must be less than 60 MB';
        	
		}
		
        $desired_dir="uploads/document";
        if(empty($errors)==true){
		
            
		if(is_dir($desired_dir)==false){
                mkdir("$desired_dir", 0700);		// Create directory if it does not exist
            }
            if(is_dir("$desired_dir/".$file_name)==false){
                move_uploaded_file($file_tmp,"uploads/document/".$file_name);
            }else{									//rename the file if another one exist
                $new_dir="uploads/document/".$file_name.time();
                 rename($file_tmp,$new_dir) ;				
            }
		
			 $query="INSERT INTO document(id_document ,document_name ,document_type ,status)
VALUES (NULL ,   '$file_name',  '$file_type', '1');";
				
		 
			if($this->oDb->query($query))	{
				 $lastInsertId = $this->oDb->insert_id;
				
				
				
		$querys = "INSERT INTO contract_doc (id_contract_doc, id_contract, id_document, status) VALUES (NULL, '$insertId', '$lastInsertId', '1')";
						$this->oDb->query($querys);
						$done = 1;
					}
					else
					{
					$done = 0;
					 if($DEBUGS !=0)
			  {
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  }
					}
				
		
            
				
        }else{
              /* print_r($errors);*/
			  	$done = 0;
				 if($DEBUGS !=0)
			  {
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  }
        }
		
    }
	if(empty($error)){
		if($done = 1)
		{
			return true;
		}
		
	}
}
		
	}
	
	
	
	
	
  public function getItemGroup1List()
  {
		$qry = "SELECT * FROM itemgroup1";
		$aIGList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aItemGroup = array();
				$aItemGroup['id_itemgroup1']   = $row->id_itemgroup1;
				$aItemGroup['itemgroup1_name'] = strtoupper($row->itemgroup1_name);
				$aItemGroup['lookup']          = strtoupper($row->lookup);
				$aItemGroup['status']          = $row->status;
				$aIGList[]                     = $aItemGroup;
			}
		}
		return $aIGList;
  } //
  
  	
	public function checkExist($table,$field,$fieldvalue)
	{
	   $exists = false;
	  $qry = "select * from $table where $field = '".$fieldvalue."'";

	   if($row = $this->oDb->query($qry))
	   {
         $exists = true; 	       
	   }
       return $exists;	   
		/* $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{
		}*/
	}
		
	public function checkExist1($table,$field,$fieldvalue,$field1,$fieldvalue1)
	{
	   $exists = false;
	   $qry = "select * from $table where $field = '".$fieldvalue."' AND $field1 = '".$fieldvalue1."'";
	 
	   if($row = $this->oDb->query($qry))
	   {
         $exists = true; 	       
	   }
       return $exists;	   
		/* $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{
		}*/
	}
	
	public function addItemGroup1($aRequest)
	{
		//add a new bank.
		$itemgroup1_name = strtoupper($aRequest['fItemGroup1Name']);
		$lookup          = strtoupper($aRequest['fItemGroup1Name']); //strtoupper($aRequest['fLookup']);
		$status          = $aRequest['fStatus'];
		$qry = "INSERT INTO itemgroup1 (id_itemgroup1, itemgroup1_name, lookup, status) VALUES (null, '$itemgroup1_name','$lookup', '$status')";
		
		if($this->oDb->query($qry))	{
		 return 'ItemGroup1.php?msg=success';
		}
		else{
		 return 'ItemGroup1Edit.php';
		}
	}
	
	public function getDistIgroup()
	{
	 $qry = "SELECT Distinct id_itemgroup1 FROM vendor_group_map WHERE status!=2";
	 $aIGList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aItemGroup = array();
				$aItemGroup = $this->getItemGroup1Info($row->id_itemgroup1);
				$aIGList[]                     = $aItemGroup;
			}
		}
		return $aIGList;
	}
	public function getItemGroup1Info($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	   $qry = "SELECT id_itemgroup1, itemgroup1_name, lookup, status FROM itemgroup1 WHERE ";
	   if($type == 'lookup') {
	   	 $condition = " lookup = '$lookup'";
	   }
	   else {
	     $condition = " id_itemgroup1 = ".$lookup;
	   }
	   $qry = $qry.$condition;
	   $aItemGroup = array();
	   if($row = $this->oDb->get_row($qry))
	   {
	      $aItemGroup['id_itemgroup1']   = $row->id_itemgroup1;
		  $aItemGroup['itemgroup1_name'] = strtoupper($row->itemgroup1_name);
		  $aItemGroup['lookup']    = strtoupper($row->lookup);
		  $aItemGroup['status']    = $row->status;		  
	   }
	   return $aItemGroup;
	   
	}
	
	public function updateItemGroup1($aRequest, $action) //action -> update, delete
	{
		if($action == 'update')
		{
		  $id_itemgroup1  = $aRequest['fItemGroup1Id'];
		  $itemGroupName = strtoupper($aRequest['fItemGroup1Name']);
		  //$lookup   = strtoupper($aRequest['fLookup']);
		  $status   = $aRequest['fStatus'];
		 $checkqry = "SELECT * FROM  itemgroup1 WHERE itemgroup1_name = '$itemGroupName' AND id_itemgroup1!='$id_itemgroup1'";
		  $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{
		
			$valid = '2';
			
		}
		else
		{
          $qry = "UPDATE itemgroup1 SET itemgroup1_name = '$itemGroupName', lookup = '$itemGroupName', status = '$status' WHERE id_itemgroup1 = ".$id_itemgroup1;
			   $this->oDb->query($qry);
				if( mysql_affected_rows() >= 0)
				{
				$valid = '1';
				}
				else
				{
				$valid = '0';
				}
				
			
		  }
		  
		 
		}
			
		
		return $valid;
	}		
  
  
  
  public function getItemGroup2List()
  {
		$qry = "SELECT * FROM itemgroup2";
		$aIGList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aItemGroup = array();
				$aItemGroup['id_itemgroup2']   = $row->id_itemgroup2;
				$aItemGroup['id_itemgroup1']   = $row->id_itemgroup1;
				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aItemGroup['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aItemGroup['itemgroup2_name'] = strtoupper($row->itemgroup2_name);
				
				
				$aItemGroup['lookup']    = strtoupper($row->lookup);
				$aItemGroup['status']    = $row->status;
				$aIGList[]               = $aItemGroup;
			}
		}
		return $aIGList;
  } //
  
  	public function addItemGroup2($aRequest)
	{
		//add a new bank.
		$itemgroup2_name = strtoupper($aRequest['fItemGroup2Name']);
		$lookup          = strtoupper($aRequest['fItemGroup2Name']); //strtoupper($aRequest['fLookup']);
		$id_group1 = $aRequest['fGroup1'];
		$status          = $aRequest['fStatus'];
		  $checkqry = "SELECT * FROM  itemgroup2 WHERE itemgroup2_name = '$itemgroup2_name'";
		
		  $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{
			$valid = '2';
			
		}
		else
		{
		 $qry = "INSERT INTO itemgroup2 (id_itemgroup2, itemgroup2_name, lookup,id_itemgroup1,status) VALUES (null, '$itemgroup2_name','', '$id_group1','$status')";
		
			$this->oDb->query($qry);
			if( mysql_affected_rows() >= 0)
				{
				$valid = '1';
				}
				else
				{
				$valid = '0';
				}
		}
		return  $valid;
	}
	
	public function updateItemGroup2($aRequest, $action) //action -> update, delete
	{
	$valid = '0';
		if($action == 'update')
		{
		  $id_itemgroup2  = $aRequest['fItemGroup2Id'];
		  $itemGroupName = strtoupper($aRequest['fItemGroup2Name']);
		  //$lookup   = strtoupper($aRequest['fLookup']);
		  $status   = $aRequest['fStatus'];
		  $id_group1 = $aRequest['fGroup1'];
		   $checkqry = "SELECT * FROM  itemgroup2 WHERE itemgroup2_name = '$itemGroupName' AND id_itemgroup2!='$id_itemgroup2'";
		  $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{
			$valid = '2';
			
		}
		else
		{
          $qry = "UPDATE itemgroup2 SET itemgroup2_name = '$itemGroupName', lookup = '$itemGroupName',id_itemgroup1 = '$id_group1', status = '$status' WHERE id_itemgroup2 = ".$id_itemgroup2;
				$this->oDb->query($qry);
				if( mysql_affected_rows() >= 0)
				{
				$valid = '1';
				}
				else
				{
				$valid = '0';
				}
				
				
		}
		
		}
		
		
		return $valid;
	}	
	
	public function getItemGroup2Info($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	   $qry = "SELECT id_itemgroup2, itemgroup2_name, lookup,id_itemgroup1, status FROM itemgroup2 WHERE ";
	   if($type == 'lookup') {
	   	 $condition = " lookup = '$lookup'";
	   }
	   else if($type == 'group1') {
	   	 $condition = " id_itemgroup1 = '$lookup'";
	   }
	   else {
	     $condition = " id_itemgroup2 = ".$lookup;
	   }
	  $qry = $qry.$condition;
	  
	   $aItemGroup = array();
	   if($row = $this->oDb->get_row($qry))
	   {
	      $aItemGroup['id_itemgroup2']   = $row->id_itemgroup2;
		  $aItemGroup['itemgroup2_name'] = strtoupper($row->itemgroup2_name);
		  $aItemGroup['lookup']    = strtoupper($row->lookup);
		   $aItemGroup['id_itemgroup1']    = strtoupper($row->id_itemgroup1);
		   $aItemGroup['status']    = $row->status;		  
	   }
	   return $aItemGroup;
	   
	}	
	
	public function getGroupMapId($lookup,$lookup1,$lookup2)
	{
	  $qry = "SELECT Distinct id_itemgroup2,id_item,id_item ,id_itemgroup1,id_itemgroup_item_map FROM itemgroup_item_map WHERE ";
	     $condition = " id_item = '$lookup2' AND id_itemgroup2 ='$lookup1' AND id_itemgroup1 =".$lookup;
		 $qry = $qry.$condition;
		  if($row = $this->oDb->get_row($qry))
	     {
		  $aGroupId   = $row->id_itemgroup_item_map;
		}
		return 	$aGroupId;
		
	}
	
	
	public function getItemGroupMapList($lookup, $type,$lookup1 = '',$lookup2='')  //lookup may be 'id' or 'Lookup text'
	{
	  
	   if($type == 'lookup') {
	    $qry = "SELECT * FROM itemgroup_item_map WHERE ";
	   	 $condition = " lookup = '$lookup'";
	   }
	   else if($type == 'group1') {
	   $qry = "SELECT Distinct id_itemgroup2 FROM itemgroup_item_map WHERE ";
	   	 $condition = " id_itemgroup1 = '$lookup'";
	   }
	   else if($type == 'item'){
	    $qry = "SELECT Distinct id_item FROM itemgroup_item_map WHERE ";
	     $condition = " id_itemgroup1 = ".$lookup;
	   }	   
	   else if($type == 'items'){
	    $qry = "SELECT Distinct id_itemgroup2,id_itemgroup1,id_item,id_itemgroup_item_map FROM itemgroup_item_map WHERE ";
	     $condition = " id_itemgroup2 = ".$lookup;
		 if($lookup1 !='')
		 {
		 $condition .= "  AND id_itemgroup1 =".$lookup1;
		 }
	   }
	     else if($type == 'itemsid'){
	    $qry = "SELECT Distinct id_itemgroup2,id_item,id_item ,id_itemgroup1,id_itemgroup_item_map FROM itemgroup_item_map WHERE ";
	     $condition = " id_item = ".$lookup;
		 if($lookup1 !='')
		 {
		 $condition .= "  AND id_itemgroup2 ='$lookup1' AND id_itemgroup1 =".$lookup2;
		 }
	   }
	   else {
	    $qry = "SELECT Distinct id_item FROM itemgroup_item_map WHERE ";
	     $condition = " id_itemgroup2 = ".$lookup;
	   }
	  $qry = $qry.$condition;
	 
	  $aItemGroupList = array();
	   if($result = $this->oDb->get_results($qry))
	   {
	      foreach($result as $row)
			{
		  $aItemGroup = array();
		  $aItemGroup['id_itemgroup1']   = $row->id_itemgroup1;
		 $aItemGroup['id_itemgroup2']   = $row->id_itemgroup2;
		 $aItemGroup['id_item']   = $row->id_item;
		  $aItemGroup['id_item_map']   = $row->id_itemgroup_item_map;
		 
		 
		 $aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
			$aGroup1 = $this->getItemGroup1Info( $row->id_itemgroup1,'id');
			$aItemGroup['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
			$aItemGroup['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
			$aItem = $this->getItemInfo($row->id_item,'id');
			$aItemGroup['item_name']       = $aItem['item_name'];
		   $aItemGroup['status']    = $row->status;	
		   $aItemGroupList[] = 	$aItemGroup ; 
			}
	   }
	   return $aItemGroupList;
	   
	}	
	
	
	
	
	public function getItemGroup2InfoList($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	   $qry = "SELECT id_itemgroup2, itemgroup2_name, lookup,id_itemgroup1, status FROM itemgroup2 WHERE ";
	   if($type == 'lookup') {
	   	 $condition = " lookup = '$lookup'";
	   }
	   else if($type == 'group1') {
	   	 $condition = " id_itemgroup1 = '$lookup'";
	   }
	   else {
	     $condition = " id_itemgroup2 = ".$lookup;
	   }
	   $qry = $qry.$condition;
	  
	   $aItemGroupList = array();
	   if($result = $this->oDb->get_results($qry))
	   {
	      foreach($result as $row)
			{
		  $aItemGroup = array();
		  $aItemGroup['id_itemgroup2']   = $row->id_itemgroup2;
		  $aItemGroup['itemgroup2_name'] = strtoupper($row->itemgroup2_name);
		  $aItemGroup['lookup']    = strtoupper($row->lookup);
		   $aItemGroup['id_itemgroup1']    = strtoupper($row->id_itemgroup1);
		   $aItemGroup['status']    = $row->status;	
		   $aItemGroupList[] = 	$aItemGroup ; 
			}
	   }
	   return $aItemGroupList;
	   
	}	
	
	
	
  	public function addItem($aRequest)
	{
		
		//add a new item.
		$item_name = strtoupper($aRequest['fItemName']);
		$lookup    = strtoupper($aRequest['fLookup']); 
		$status    = $aRequest['fStatus'];
		$id_group2 = $aRequest['fGroup2'];
		$itemType = $aRequest['fItemType'];
		$id_group1 = $aRequest['fGroup1'];
		if($itemType == 'New')
		{
		  $qry = "INSERT INTO item (id_item,item_name, lookup,id_itemgroup2, status) VALUES (null, '$item_name','$lookup','$id_group2', '$status')";
		
				if($this->oDb->query($qry))	{
				$insertId = $this->oDb->insert_id;
				$done = $this->addItemMap($aRequest,$insertId);
				}
				else
				{
				$done = 0;
				}
		}
		else
		{
			$done = $this->addItemMap($aRequest,'');
						
		}
	return $done;
	}
	public function addItemMap($aRequest,$insertId)
	{
		if($insertId!='')
		{
		$item_name = $insertId;
		
		}
		else
		{
		$item_name = strtoupper($aRequest['fItemName']);
		}
		$lookup    = strtoupper($aRequest['fLookup']); 
		$status    = $aRequest['fStatus'];
		$id_group2 = $aRequest['fGroup2'];
		$itemType = $aRequest['fItemType'];
		/*$aGroup2 = $this->getItemGroup2Info($id_group2,'id');
		$id_group1 = $aGroup2['id_itemgroup1'];*/
		$id_group1 = $aRequest['fGroup1'];
		 $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		 
		 $checkqry = "SELECT id_itemgroup1,id_itemgroup2,id_item FROM itemgroup_item_map WHERE id_itemgroup1='$id_group1' AND id_itemgroup2='$id_group2' AND id_item='$item_name'";
		 $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{
			$aItem = array();
			$aItem['group2'] = $id_group2;
			$aItem['id_item'] = $item_name;
			$aItem['item_type'] = $itemType;
			$aItem['status'] =  $status;
			$done = $aItem;
		}
		else
		{
	
		$qry = "INSERT INTO itemgroup_item_map (id_itemgroup_item_map, id_itemgroup1, id_itemgroup2, id_item, created_by, created_on, modified_by, modified_on, status) VALUES (NULL, '$id_group1', '$id_group2', '$item_name', '$created_by', now(), '', '', '$status');";
		
			if($this->oDb->query($qry))	{
			$done = 1;
			}
			else{
			 $done = 0;
			}
		}
		return $done ;
	}
  public function getItemList()
  {
		$qry = "SELECT * FROM item";
		$aItemList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aItem = array();
				$aItem['id_item']   = $row->id_item;
				$aItem['item_name'] = strtoupper($row->item_name);
				$aItem['lookup']    = strtoupper($row->lookup);
				$aItem['id_itemgroup2']    = strtoupper($row->id_itemgroup2);
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
			$aGroup1 = $this->getItemGroup1Info($aGroup2['id_itemgroup1'],'id');
			$aItem['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
			$aItem['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				$aItem['status']    = $row->status;
				$aItemList[]        = $aItem;
			}
		}
		return $aItemList;
  } //	
  
	public function getItemInfo($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	   $qry = "SELECT id_item, item_name, lookup,id_itemgroup2 ,status FROM item WHERE ";
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
		
		$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
		$aItem['id_itemgroup1']    = strtoupper($aGroup2['id_itemgroup1']);
		$aGroup1 = $this->getItemGroup1Info($aGroup2['id_itemgroup1'],'id');
		$aItem['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
		$aItem['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
		$aItem['status']    = $row->status;		  
	   }
	   return $aItem;
	   
	}  
	public function getItemInfoList($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	   $qry = "SELECT id_item, item_name, lookup, status ,id_itemgroup2 FROM item WHERE ";
	   if($type == 'lookup') {
	   	 $condition = " lookup = '$lookup'";
	   }
	   	else if($type == 'group2') {
	   	 $condition = " id_itemgroup2 = '$lookup'";
	   }
	   else {
	     $condition = " id_item = ".$lookup;
	   }
	 $qry = $qry.$condition;
	 
	   $aItemList = array();
	   if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aItem = array();
				$aItem['id_item']   = $row->id_item;
				$aItem['item_name'] = strtoupper($row->item_name);
				$aItem['lookup']    = strtoupper($row->lookup);
				$aItem['id_itemgroup2']    = strtoupper($row->id_itemgroup2);
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
			$aGroup1 = $this->getItemGroup1Info($aGroup2['id_itemgroup1'],'id');
			$aItem['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
			$aItem['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				$aItem['status']    = $row->status;
				$aItemList[]        = $aItem;
			}
		}
	   return $aItemList;
	   
	}  
	
	public function updateItem($aRequest, $action) //action -> update, delete
	{
		
		if($action == 'update')
		{
		  $id_item  = $aRequest['fItemId'];
		  $itemName = strtoupper($aRequest['fItemName']);
		  $lookup   = strtoupper($aRequest['fLookup']);
		  $status   = $aRequest['fStatus'];
		  $id_group2 = $aRequest['fGroup2'];
          $qry = "UPDATE item SET item_name = '$itemName', lookup = '$lookup', id_itemgroup2='$id_group2', status = '$status' WHERE id_item = ".$id_item;
		}
		else if($action == 'delete')
		{
		  $id_item  = $aRequest['fItemId'];
		  $qry = "UPDATE item SET status = 2 WHERE id_item = ".$id_item;
		}
		$valid = false;
		 $this->oDb->query($qry);
				if( mysql_affected_rows() >= 0)
				{
				$valid = true;
				}
				
		return $valid;
	}
  //Manufacturer
	public function addManufacturer($aRequest)
	{
		//add a new item.
		$manufacturer_name = strtoupper($aRequest['fManufacturerName']);
		$lookup    = strtoupper($aRequest['fLookup']); 
		$status    = $aRequest['fStatus'];
		$qry = "INSERT INTO manufacturer (id_manufacturer, manufacturer_name, lookup, status) VALUES (null, '$manufacturer_name','$lookup', '$status')";
		if($this->oDb->query($qry))	{
		  return true;
		}
		else{
		  return false;
		}
	}
	
  public function getManufacturerList()
  {
		$qry = "SELECT * FROM manufacturer ORDER BY id_manufacturer DESC";
		$aManuList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aItem = array();
				$aItem['id_manufacturer']   = $row->id_manufacturer;
				$aItem['manufacturer_name'] = strtoupper($row->manufacturer_name);
				$aItem['lookup']    = strtoupper($row->lookup);
				$aItem['status']    = $row->status;
				$aManuList[]        = $aItem;
			}
		}
		return $aManuList;
  } //	
  
	public function getManufacturerInfo($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	   $qry = "SELECT id_manufacturer, manufacturer_name, lookup, status FROM manufacturer WHERE ";
	   if($type == 'lookup') {
	   	 $condition = " lookup = '$lookup'";
	   }
	   else {
	     $condition = " id_manufacturer = ".$lookup;
	   }
	   $qry = $qry.$condition;
	   $aItem = array();
	   if($row = $this->oDb->get_row($qry))
	   {
	      $aItem['id_manufacturer']   = $row->id_manufacturer;
		  $aItem['manufacturer_name'] = strtoupper($row->manufacturer_name);
		  $aItem['lookup']    = strtoupper($row->lookup);
		  $aItem['status']    = $row->status;		  
	   }
	   return $aItem;
	   
	}  
	
	public function updateManufacturer($aRequest, $action) //action -> update, delete
	{
		if($action == 'update')
		{
		  $id_manufacturer  = $aRequest['fManufacturerId'];
		  $manufacturerName = strtoupper($aRequest['fManufacturerName']);
		  $lookup           = strtoupper($aRequest['fLookup']);
		  $status           = $aRequest['fStatus'];
		  
		   $checkqry = "SELECT * FROM  manufacturer WHERE manufacturer_name = '$manufacturerName' AND  lookup = '$lookup' AND id_manufacturer != ".$id_manufacturer;
		  $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{
			$valid = '2';
			
		}
		else
		{
          $qry = "UPDATE manufacturer SET manufacturer_name = '$manufacturerName', lookup = '$lookup', status = '$status' WHERE id_manufacturer = ".$id_manufacturer;
		    $this->oDb->query($qry);
				if( mysql_affected_rows() >= 0)
				{
				$valid = '1';
				}
				else
				{
				$valid = '0';
				}
		  }
		}
		else if($action == 'delete')
		{
		  $id_manufacturer  = $aRequest['fManufacturerId'];
		  $qry = "UPDATE manufacturer SET status = 2 WHERE id_manufacturer = ".$id_manufacturer;
		  $valid = false;
		if($this->oDb->query($qry)) {
		 $valid = true;
		} 
		}
		
		return $valid;
	}
public function getPOTaxInfo($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	   $qry = "SELECT id_po, id_taxform, addless, tax_price FROM po_tax  WHERE ";
	   if($type == 'id') {
	   	 $condition = " id_po = '$lookup'";
	   }
	   
	   $qry = $qry.$condition;
	   $aItem = array();
	   if($row = $this->oDb->get_row($qry))
	   {
	      $aItem['id_po']   = $row->id_po;
		  $aItem['id_taxform'] = $row->id_taxform;
		  $aItem['addless']    = $row->addless;
		  $aItem['tax_price']    = $row->tax_price;		  
	   }
	   return $aItem;
	   
	}  
	public function getPOTaxInfoList($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	   $qry = "SELECT id_po, id_taxform, addless, tax_price FROM po_tax  WHERE ";
	   if($type == 'id') {
	   	 $condition = " id_po = '$lookup'";
	   }
	   
	   $qry = $qry.$condition;
	 
	   $aItemList = array();
	   if($result = $this->oDb->get_results($qry))
	   {
	     foreach($result as $row)
			{
		  $aItem = array();
		  $aItem['id_po']   = $row->id_po;
		  $aItem['id_taxform'] = $row->id_taxform;
		  $aTaxform =$this->getTaxFormInfo($row->id_taxform,'id');
		  $aItem['tax_name']    = $aTaxform['taxform_name'];
		  $aItem['addless']    = $row->addless;
		  $aItem['tax_price']    = $row->tax_price;	
		  $aItemList[]= $aItem; 
			}
	   }
	   return $aItemList;
	   
	}  
	public function getInventoryTaxInfoList($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	   $qry = "SELECT id_inventory_tax, id_inventory, id_taxform, addless, tax_price, status FROM inventory_tax WHERE ";
	   if($type == 'id') {
	   	 $condition = " id_inventory = '$lookup'";
	   }
	   
	    $qry = $qry.$condition;
	   $aItemList = array();
	   if($result = $this->oDb->get_results($qry))
	   {
	     foreach($result as $row)
			{
		  $aItem = array();
		  $aItem['id_inventory']   = $row->id_inventory;
		  $aItem['id_taxform'] = $row->id_taxform;
		  
		  $aTaxform =$this->getTaxFormInfo($row->id_taxform,'id');
		   $aItem['tax_percentage'] = $aTaxform['tax_percentage'];
		  $aItem['tax_name']    = $aTaxform['taxform_name'];
		  $aItem['addless']    = $row->addless;
		  $aItem['tax_price']    = $row->tax_price;	
		  $aItemList[]= $aItem; 
			}
	   }
	   return $aItemList;
	   
	}  
	
	public function getStateListHTML()
	{
	    $qry = "SELECT * FROM state where status != 2";
		$html .= '<select name="fStateId" class="contact-input" id="contact-state" tabindex="1003">';
		$html .= '<option value="0">--Select State--</option>';
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$html .= '<option value="'.$row->id_state.'">'.strtoupper($row->state_name).'</option>';
			}
		}
		$html .= '</select>';
		return $html;
	}
	
	public function getCountryListHTML()
	{
	    $qry = "SELECT * FROM country where status != 2";
		$html .= '<select name="fCountryId" class="contact-input" id="contact-country" tabindex="1004">';
		$html .= '<option value="0">--Select Country--</option>';
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$html .= '<option value="'.$row->id_country.'">'.strtoupper($row->country_name).'</option>';
			}
		}
		$html .= '</select>';
		return $html;
	}
	
	public function getEmployeeListHTML()
	{
	   $qry = "SELECT * FROM employee WHERE status!=2";
		$html .= '<select name="fEmployeeId" class="contact-input" id="contact-country" tabindex="1004">';
		$html .= '<option value="0">--Select Employee--</option>';
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$html .= '<option value="'.$row->id_employee.'">'.strtoupper($row->first_name.' '.$row->last_name).'</option>';
			}
		}
		$html .= '</select>';
		return $html;
	}
	
	public function getCompanyListHTML()
	{
	   $qry = "SELECT * FROM company WHERE status!=2";
		$html .= '<select name="fCompanyId" class="contact-input" id="contact-country" tabindex="1004">';
		$html .= '<option value="0">--Select Company--</option>';
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$html .= '<option value="'.$row->id_company.'">'.strtoupper($row->company_name).'</option>';
			}
		}
		$html .= '</select>';
		return $html;
	}
	public function getUnitListHTML()
	{
	    $qry = "SELECT * FROM asset_unit WHERE status!=2";
		$html .= '<select name="fUnitId" class="contact-input" id="contact-country" tabindex="1004">';
		$html .= '<option value="0">--Select Unit--</option>';
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$html .= '<option value="'.$row->id_unit.'">'.strtoupper($row->unit_name).'</option>';
			}
		}
		$html .= '</select>';
		return $html;
	}
	public function getItemGroup1ListHTML()
	{
	    $qry = "SELECT * FROM itemgroup1 WHERE status != 2";
		$html .= '<select name="fGroup1" class="contact-input" id="contact-country" tabindex="1004">';
		$html .= '<option value="0">--Select Item Group1--</option>';
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$html .= '<option value="'.$row->id_itemgroup1.'">'.strtoupper($row->itemgroup1_name).'</option>';
			}
		}
		$html .= '</select>';
		return $html;
	}
	
	public function getItemGroup2ListHTML()
	{
	    $qry = "SELECT * FROM itemgroup2 WHERE status != 2";
		$html .= '<select name="fGroup2" class="contact-input" id="contact-country" tabindex="1003">';
		$html .= '<option value="0">--Select Item Group2--</option>';
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$html .= '<option value="'.$row->id_itemgroup2.'">'.strtoupper($row->itemgroup2_name).'</option>';
			}
		}
		$html .= '</select>';
		return $html;
	}
	
	 
	public function getHTML()
	{
	   $html .= '<select style="display:none;">';
	   $html .= '<option></option>';
	   $html .= '</select>';
	   $html .= '';
	   $html .= '';
	}	
	
	public function moneyFormat($number){
	$numarr = explode(".",$number);
	$num = $numarr[0];
	$dec = $numarr[1];
    $explrestunits = "" ;
    if(strlen($num)>3){
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++){
            // creates each of the 2's group and adds a comma to the end
            if($i==0)
            {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            }else{
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
	if(!empty($dec))
	{
		$RESULT = $thecash.'.'.$dec;
	}
	else
	{
	$RESULT = $thecash.'.00';
	}
    return 	$RESULT; // writes the final format where $currency is the currency symbol.
}
public function getItemGroups($lookup,$item,$type)
{
	if($type == "group2")
		{
		 $qry="SELECT DISTINCT asset_item.id_itemgroup2 AS ItemGroup2 FROM asset_item,asset_stock
WHERE asset_stock.id_asset_item = asset_item.id_asset_item  and asset_item.id_itemgroup1=".$lookup;
	$aItemGroup1List = array();
		
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aItemGroup1=array();
				$aItemGroup1['id_itemgroup2'] = $row->ItemGroup2;
				$aGroup2 = $this->getItemGroup2Info($row->ItemGroup2,'id');
				$aItemGroup1['itemgroup2_name'] = $aGroup2['itemgroup2_name'];
				
				$aItemGroup1['asset_no'] = $row->asset_no;
				$aItemGroup1['asset_item'] = $row->asset_item;
				$aItemGroup1['id_item'] = $row->id_item;
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aItemGroup1['item_name']       = $aItem['item_name'];
				
				 $aItemGroup1List[] = $aItemGroup1;
			}
		}
		}
		else if($type=='item')
		{
		 
		 if($item !='')
		{
	  $qry="SELECT
    asset_item.machine_no
    , asset_item.asset_no
    , asset_stock.id_store
    , itemgroup1.itemgroup1_name
    , itemgroup1.id_itemgroup1
	, item.item_name
	 , item.id_item,
	 asset_item.id_asset_item
FROM
    asset_item
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item = asset_stock.id_asset_item)
		 INNER JOIN item 
        ON (asset_item.asset_name = item.id_item)
    INNER JOIN itemgroup1 
        ON (asset_item.id_itemgroup1 = itemgroup1.id_itemgroup1)
WHERE (itemgroup1.id_itemgroup1 ='".$lookup."' AND asset_item.asset_name IN('".$item."'));";
		}
		else
		{
			$qry="SELECT DISTINCT
			 asset_item.asset_name
			 , item.item_name
	 , item.id_item
FROM
   asset_item
    INNER JOIN asset_stock 
        ON ( asset_item.id_asset_item = asset_stock.id_asset_item)
		 INNER JOIN item 
        ON (asset_item.asset_name = item.id_item)
    INNER JOIN itemgroup1 
        ON (asset_item.id_itemgroup1 = itemgroup1.id_itemgroup1)
 WHERE (itemgroup1.id_itemgroup1 ='".$lookup."' 
  );";
		}
		
		
	$aItemGroup1List = array();
		
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aItemGroup1=array();
				$aItemGroup1['asset_no'] = $row->asset_no;
				$aItemGroup1['machine_no'] = strtoupper($row->machine_no);
				$aItemGroup1['asset_item'] = $row->id_asset_item;
				$aItemGroup1['id_item'] = $row->id_item;
				$aItemGroup1['item_name']       = $row->item_name;
				
				 $aItemGroup1List[] = $aItemGroup1;
			}
		}
	
		}
		return $aItemGroup1List;
}
public function getItemGroupsInfo($lookup,$lookup1,$item,$type)
{
	 if($type=='item')
		{
		if($item !='')
		{
	 $qry="SELECT 
    asset_item.machine_no
    , asset_item.asset_no
    , asset_stock.id_store
    , itemgroup1.itemgroup1_name
    , itemgroup1.id_itemgroup1
	 
	, item.item_name
	 , item.id_item,
	 asset_item.id_asset_item
FROM
    asset_item
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item = asset_stock.id_asset_item)
		 INNER JOIN item 
        ON (asset_item.asset_name = item.id_item)
		
    INNER JOIN itemgroup1 
        ON (asset_item.id_itemgroup1 = itemgroup1.id_itemgroup1)
WHERE (itemgroup1.id_itemgroup1 ='".$lookup."' AND  asset_item.id_itemgroup2 ='".$lookup1."' AND asset_item.asset_name IN('".$item."'))";
		}
		else
		{
		   $qry="SELECT DISTINCT
		  item.id_item,
		  asset_item.id_asset_item,
    asset_item.machine_no
    , asset_item.asset_no
    , asset_stock.id_store
    , itemgroup1.itemgroup1_name
    , itemgroup1.id_itemgroup1
	, item.item_name
	 , item.id_item
	 
FROM
    asset_item
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item = asset_stock.id_asset_item)
		 INNER JOIN item 
        ON (asset_item.asset_name = item.id_item)
    INNER JOIN itemgroup1 
        ON (asset_item.id_itemgroup1 = itemgroup1.id_itemgroup1)
		
WHERE (itemgroup1.id_itemgroup1 ='".$lookup."' AND  asset_item.id_itemgroup2 ='".$lookup1."')
GROUP BY  item.id_item;
";
		}
		}
	$aItemGroup1List = array();
		
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aItemGroup1=array();
				$aItemGroup1['asset_no'] = $row->asset_no;
				$aItemGroup1['machine_no'] = strtoupper($row->machine_no);
				$aItemGroup1['asset_item'] = $row->id_asset_item;
				$aItemGroup1['id_item'] = $row->id_item;
				$aItemGroup1['item_name']       = $row->item_name;
				
				 $aItemGroup1List[] = $aItemGroup1;
			}
		}
	
		
		return $aItemGroup1List;
}
 public function getItemGroup1ByStore($lookup,$storeId,$item,$type)
	{
		if($type == "store")
		{
		$qry="SELECT DISTINCT asset_item.id_itemgroup1 AS ItemGroup1 FROM asset_item,asset_stock
WHERE asset_stock.id_asset_item = asset_item.id_asset_item and asset_stock.id_store = ".$lookup;
	$aItemGroup1List = array();
		
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aItemGroup1=array();
				$aItemGroup1['id_itemgroup1'] = $row->ItemGroup1;
				$aGroup1 = $this->getItemGroup1Info($row->ItemGroup1,'id');
				$aItemGroup1['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				 $aItemGroup1List[] = $aItemGroup1;
			}
		}
		}
		else if($type == "group2")
		{
		 $qry="SELECT DISTINCT asset_item.id_itemgroup2 AS ItemGroup2 FROM asset_item,asset_stock
WHERE asset_stock.id_asset_item = asset_item.id_asset_item and asset_stock.id_store ='".$storeId."' and asset_item.id_itemgroup1=".$lookup;
	$aItemGroup1List = array();
		
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aItemGroup1=array();
				$aItemGroup1['id_itemgroup2'] = $row->ItemGroup2;
				$aGroup2 = $this->getItemGroup2Info($row->ItemGroup2,'id');
				$aItemGroup1['itemgroup2_name'] = $aGroup2['itemgroup2_name'];
				
				$aItemGroup1['asset_no'] = $row->asset_no;
				$aItemGroup1['asset_item'] = $row->asset_item;
				$aItemGroup1['id_item'] = $row->id_item;
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aItemGroup1['item_name']       = $aItem['item_name'];
				
				 $aItemGroup1List[] = $aItemGroup1;
			}
		}
		}
		else if($type=='item')
		{
		 
			 
		 if($item !='')
		{
	  $qry="SELECT
    asset_item.machine_no
    , asset_item.asset_no
    , asset_stock.id_store
    , itemgroup1.itemgroup1_name
    , itemgroup1.id_itemgroup1
	, item.item_name
	 , item.id_item
	 ,
	 asset_item.id_asset_item
FROM
    asset_item
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item = asset_stock.id_asset_item)
		 INNER JOIN item 
        ON (asset_item.asset_name = item.id_item)
    INNER JOIN itemgroup1 
        ON (asset_item.id_itemgroup1 = itemgroup1.id_itemgroup1)
WHERE (itemgroup1.id_itemgroup1 ='".$lookup."' AND asset_stock.id_store = '".$storeId."' AND asset_item.asset_name IN('".$item."') AND asset_stock.status!=8);";
		}
		else
		{
			$qry="SELECT DISTINCT
			 asset_item.asset_name
			 , item.item_name
	 , item.id_item
FROM
   asset_item
    INNER JOIN asset_stock 
        ON ( asset_item.id_asset_item = asset_stock.id_asset_item)
		 INNER JOIN item 
        ON (asset_item.asset_name = item.id_item)
    INNER JOIN itemgroup1 
        ON (asset_item.id_itemgroup1 = itemgroup1.id_itemgroup1)
 WHERE (itemgroup1.id_itemgroup1 ='".$lookup."' AND  asset_stock.id_store = '".$storeId."' AND asset_stock.status!=8
  );";
		}
		/* if($item !='')
		{
	  $qry="SELECT DISTINCT asset_item.asset_no AS asset_no,asset_item.machine_no As machine_no,asset_item.asset_name AS id_item ,asset_item.id_asset_item AS asset_item FROM asset_item,asset_stock
WHERE asset_stock.id_asset_item = asset_item.id_asset_item and asset_stock.status!=8 and  asset_item.asset_name IN('".$item."') and asset_stock.id_store ='".$storeId."' and asset_item.id_itemgroup1=".$lookup;
		}
		else
		{
		$qry="SELECT DISTINCT asset_item.asset_name AS id_item  FROM asset_item,asset_stock WHERE asset_stock.id_asset_item = asset_item.id_asset_item and asset_stock.status!=8 and asset_stock.id_store = ".$storeId;
		}*/
		
	$aItemGroup1List = array();
		
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aItemGroup1=array();
				$aItemGroup1['asset_no'] = $row->asset_no;
				$aItemGroup1['machine_no'] = strtoupper($row->machine_no);
				$aItemGroup1['asset_item'] = $row->id_asset_item;
				$aItemGroup1['id_item'] = $row->id_item;
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aItemGroup1['item_name']       = $aItem['item_name'];
				
				 $aItemGroup1List[] = $aItemGroup1;
			}
		}
	
		}
		return $aItemGroup1List;
	}
	
	public function getItemGroup2ByStore($lookup1,$lookup2,$storeId,$item,$type)
	{
		if($type == 'store')
		{
		$qry="SELECT DISTINCT asset_item.id_itemgroup2 AS ItemGroup2 FROM asset_item,asset_stock
WHERE asset_stock.id_asset_item = asset_item.id_asset_item and asset_stock.id_store = ".$storeId;
	$aItemGroup2List = array();
		
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aItemGroup2=array();
				$aItemGroup2['id_itemgroup2'] = $row->ItemGroup2;
				$aGroup2 = $this->getItemGroup2Info($row->ItemGroup2,'id');
				$aItemGroup2['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				 $aItemGroup2List[] = $aItemGroup2;
			}
		}
		}
		else if($type == 'item')
		{
			 if($item !='')
		{
		$qry="SELECT DISTINCT asset_item.asset_no AS asset_no,asset_item.machine_no As machine_no,asset_item.asset_name AS id_item ,asset_item.id_asset_item AS asset_item FROM asset_item,asset_stock
WHERE asset_stock.id_asset_item = asset_item.id_asset_item and asset_stock.status!=8 and  asset_item.asset_name IN('".$item."') and   asset_stock.id_store ='".$storeId."' and asset_item.id_itemgroup1='".$lookup2."' and asset_item.id_itemgroup2=".$lookup1;
		}
		else
		{
			$qry="SELECT DISTINCT asset_item.asset_name AS id_item  FROM asset_item,asset_stock
WHERE asset_stock.id_asset_item = asset_item.id_asset_item and asset_stock.status!=8 and  asset_stock.id_store ='".$storeId."' and asset_item.id_itemgroup1='".$lookup2."' and asset_item.id_itemgroup2=".$lookup1;
		}
	$aItemGroup2List = array();
		
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aItemGroup2=array();
				$aItemGroup2['asset_no'] = $row->asset_no;
				$aItemGroup2['machine_no'] = strtoupper($row->machine_no);
				$aItemGroup2['asset_item'] = $row->asset_item;
				$aItemGroup2['id_item'] = $row->id_item;
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aItemGroup2['item_name']       = $aItem['item_name'];
				 $aItemGroup2List[] = $aItemGroup2;
			}
		}
		}
		return $aItemGroup2List;
	}
	
	
	public function getItemByStore($storeId,$item,$type)
	{
		if($type=="item")
		{
	 $qry="SELECT DISTINCT asset_item.asset_no AS asset_no,asset_item.machine_no As machine_no,asset_item.asset_name AS id_item ,asset_item.id_asset_item AS asset_item FROM asset_item,asset_stock WHERE asset_stock.id_asset_item = asset_item.id_asset_item and asset_stock.status!=8 and asset_item.asset_name IN('".$item."')and asset_stock.id_store = ".$storeId;
		}
		else
		{
			 $qry="SELECT DISTINCT asset_item.asset_name AS id_item  FROM asset_item,asset_stock WHERE asset_stock.id_asset_item = asset_item.id_asset_item and asset_stock.status!=8 and asset_stock.id_store = ".$storeId;
		}
	$aItemList = array();
		
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aItems = array();
				$aItems['asset_no'] = $row->asset_no;
				$aItems['machine_no'] = strtoupper($row->machine_no);
				$aItems['asset_item'] = $row->asset_item;
				$aItems['id_item'] = $row->id_item;
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aItems['item_name']       = $aItem['item_name'];
				$aItemList[] = $aItems ;
				
			}
		}
		
		return $aItemList;
	}
	public function getStockItemDiv($lookup,$storeId,$type=null,$lookup1)
	{
	if($type=='id')
		{
	$qry ="
SELECT
    asset_item.id_itemgroup1 AS ItemGroup1
    , asset_item.id_itemgroup2 AS ItemGroup2
    , asset_item.quantity
    , asset_item.id_uom
    , asset_item.id_vendor
    , asset_item.id_manufacturer
    , asset_item.id_unit
    , asset_item.machine_no
    , asset_item.asset_no AS asset_no 
    , asset_item.id_grn
    , asset_item.id_inventory_item
    , asset_item.id_po
    , asset_item.asset_name AS  id_item
    , asset_item.asset_amount
    , asset_item.depressation_percent
    , asset_item.remark
    , asset_item.date_of_install
    , asset_item.machine_date
    , asset_item.id_image
    , asset_item.status
    , asset_item.id_asset_item AS asset_item
    , asset_stock.id_store
    , asset_stock.id_unit
    , asset_stock.id_asset_item
	, asset_stock.id_division
	,asset_stock.stock_quantity AS stock_quantity 
FROM
    asset_item
    INNER JOIN asset_stock 
        ON (asset_item.id_asset_item = asset_stock.id_asset_item)
WHERE (asset_item.asset_name = '".$lookup."' AND asset_item.id_itemgroup2 = '".$lookup1."'
    AND asset_stock.id_store  = '".$storeId."' AND asset_stock.id_division = 0);
		";
		}
		
		$aStockItemList = array();
		
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aStockItems = array();
				$aStockItems['asset_no'] = $row->asset_no;
				$aStockItems['asset_item'] = $row->asset_item;
				$aStockItems['id_item'] = $row->id_item;
				$aStockItems['id_uom'] = $row->id_uom;
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aStockItems['uom_name']         = $aUom['lookup'];
				$aStockItems['issue_quantity']         = $issueqty;
				$aStockItems['id_itemgroup1']         =$row->ItemGroup1;
				$aStockItems['id_division']         =$row->id_division;
				$aStockItems['id_itemgroup2']         = $row->ItemGroup2;
			    $aStockItems['stock_quantity'] = $row->stock_quantity;
				$aGroup1 = $this->getItemGroup1Info($row->ItemGroup1,'id');
				$aStockItems['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->ItemGroup2,'id');
				$aStockItems['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aStockItems['item_name']       = $aItem['item_name'];
				$aStockItemList[] = $aStockItems ;
				
			}
		}
	
		return $aStockItemList;
		
	}
	public function getStockItem($lookup,$storeId,$issueqty = 0)
	{
		
		$qry =" SELECT asset_stock.id_store,asset_stock.id_unit,asset_stock.stock_quantity AS stock_quantity ,asset_item.id_asset_item, asset_item.id_itemgroup1 AS ItemGroup1,asset_item.id_itemgroup2 AS ItemGroup2,asset_item.id_uom AS id_uom,asset_item.asset_name AS id_item,asset_item.asset_no AS asset_no ,asset_item.machine_no ,asset_item.id_asset_item AS asset_item FROM asset_item,asset_stock
WHERE asset_stock.id_asset_item = asset_item.id_asset_item and asset_stock.id_store ='".$storeId."' and asset_item.id_asset_item =".$lookup;
		
	
		$aStockItemList = array();
		
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aStockItems = array();
				$aStockItems['asset_no'] = $row->asset_no;
				$aStockItems['asset_item'] = $row->asset_item;
				$aStockItems['id_item'] = $row->id_item;
				$aStockItems['id_uom'] = $row->id_uom;
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aStockItems['uom_name']         = $aUom['lookup'];
				$aStockItems['issue_quantity']         = $issueqty;
				$aStockItems['id_itemgroup1']         =$row->ItemGroup1;
				$aStockItems['id_itemgroup2']         = $row->ItemGroup2;
			    $aStockItems['stock_quantity'] = $row->stock_quantity;
				$aGroup1 = $this->getItemGroup1Info($row->ItemGroup1,'id');
				$aStockItems['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->ItemGroup2,'id');
				$aStockItems['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aStockItems['item_name']       = $aItem['item_name'];
				$aStockItemList[] = $aStockItems ;
				
			}
		}
	
		return $aStockItemList;
		
	}
	
	public function getStockItemBySale($lookup,$issueqty = 0)
	{
		
		$qry =" SELECT asset_stock.id_store,asset_stock.id_unit,asset_item.asset_amount AS asset_amount ,asset_item.id_asset_item, asset_item.id_itemgroup1 AS ItemGroup1,asset_item.id_itemgroup2 AS ItemGroup2,asset_item.id_uom AS id_uom,asset_item.asset_name AS id_item,asset_item.asset_no AS asset_no ,asset_item.machine_no ,asset_item.id_asset_item AS asset_item,asset_item.date_of_install,asset_item.depressation_percent FROM asset_item,asset_stock
WHERE asset_stock.id_asset_item = asset_item.id_asset_item and asset_stock.status!=21 and asset_item.id_asset_item =".$lookup;
		
	
		$aStockItemList = array();
		
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aStockItems = array();
				$aStockItems['asset_no'] = $row->asset_no;
				$aStockItems['asset_item'] = $row->asset_item;
				$aStockItems['id_item'] = $row->id_item;
				$aStockItems['id_store'] = $row->id_store;
				$aStockItems['id_unit'] = $row->id_unit;
				$aStockItems['id_uom'] = $row->id_uom;
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aStockItems['uom_name']         = $aUom['lookup'];
				$aStockItems['issue_quantity']         = $issueqty;
				$aStockItems['id_itemgroup1']         =$row->ItemGroup1;
				$aStockItems['id_itemgroup2']         = $row->ItemGroup2;
			    $aStockItems['asset_amount'] = $row->asset_amount;
				 $aStockItems['date_of_install'] = $row->date_of_install;
				 $aStockItems['depressation_percent'] = $row->depressation_percent;
				$aGroup1 = $this->getItemGroup1Info($row->ItemGroup1,'id');
				$aStockItems['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->ItemGroup2,'id');
				$aStockItems['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aStockItems['item_name']       = $aItem['item_name'];
				$aStockItemList[] = $aStockItems ;
				
			}
		}
	
		return $aStockItemList;
		
	}
	public function addAssetDivisionDelivery($aRequest)
	{
	$id_fromstore = $aRequest['fFromStoreId'];
	$delivery_type = 'DSD';
	$astore =$this->getStoreInfo($id_fromstore ,'id');
	$id_unit = $astore['id_unit'];
	$remark = $aRequest['fRemark'];
	$id_division = $aRequest['fDivisionId'];
	 $received_by = $aRequest['fReceiverEmployeeId'];
	
	 $aItems = array_map(null,$aRequest['fAssetNumber'],$aRequest['fAssetItemId'],$aRequest['fStockQuqntity'],$aRequest['fUomId'],$aRequest['fItemGroup1Id'],$aRequest['fItemGroup2Id'],$aRequest['fItemId']);
		
			foreach($aItems as $aItem)
			  {
			  if($aItem[1] > 0)
			  {
	 $tran_qry = " INSERT INTO transaction(id_transaction, from_store, to_store, from_division, to_division, from_unit, to_unit,transaction_type,id_vendor, id_asset_item, id_itemgroup1, id_itemgroup2, id_item, asset_no, qty,id_uom, remarks, transaction_date, created_by,received_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$id_fromstore','$id_fromstore','','$id_division','$id_unit','$id_unit','$delivery_type','$id_vendor','$aItem[1]','$aItem[4]','$aItem[5]','$aItem[6]','$aItem[0]','$aItem[2]','$aItem[3]','$remark',now(),'$created_by ','$received_by',now(),'','','1') ";
if($this->oDb->query($tran_qry))
{
$done = 1;
}
else
{
$done = 0;
}			
			
	 $update_qry = "UPDATE asset_stock SET id_division='$id_division',assigned_on=now() WHERE id_store= '$id_fromstore' and id_asset_item = '$aItem[1]'";	
if($this->oDb->query($update_qry))
{
$done = 1;
}
else
{
$done = 0;
}  
  }
  
				}
		if($done == 1)
		{
		return true;
		}
		else
		{
		return false;
		echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
		}
				 
	
	}
	public function addAssetDelivery($aRequest)
	{
		$delivery_type = $aRequest['fDeliveryType'];
		
		$id_fromstore = $aRequest['fFromStoreId'];
		if($delivery_type == 'ESD')
		{
			 $id_vendor = $aRequest['fvendorId'];
		}
		else
		{
			$id_tostore = $aRequest['fToStoreId'];
		}
		$service_type = $aRequest['fServiceType'];
		$astore =$this->getStoreInfo($id_fromstore,'id');
		$from_unit = $astore['id_unit'];
		$astores =$this->getStoreInfo($id_tostore ,'id');
		$to_unit = $astores['id_unit'];
		$from_id_company = $aRequest['fCompanyId'];	
		$remark = $aRequest['fRemark'];
		$issue_date = date('Y-m-d',strtotime($aRequest['fRequireDate']));
		$id_isd = $this->internalStoreDeliveryCount();
		$issue_no = $aRequest['fCompanyLookup'].'-'.$delivery_type.'-'.$id_isd['count'];
	    $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
	
	
		
	 $qry ="INSERT INTO asset_delivery(id_asset_delivery, delivery_type, from_id_store,from_id_company, to_id_store, to_id_vendor, remark, issue_no, issue_date, prepared_by, verified_by, authorised_by, received_by, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$delivery_type','$id_fromstore','$from_id_company','$id_tostore','$id_vendor','$remark','".trim($issue_no)."','$issue_date','','','','','$created_by',now(),'','','1')";
		
		
		if($this->oDb->query($qry))	{
			  $delivery_lastInsertId = $this->oDb->insert_id;
			
		}
		else
		{
			$done = 0;
			 if($DEBUGS !=0)
			  {
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  }
		}
		
			 $qry_gate = "INSERT INTO asset_gate_pass(id_asset_gate_pass, gate_pass_date, id_asset_delivery, vehicle_no, id_gate_pass_item, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$issue_date','$delivery_lastInsertId','','','$created_by',now(),'','','1')";
			 if($this->oDb->query($qry_gate))	{
				  $gatepass_lastInsertId = $this->oDb->insert_id;
			 }
			 $aItems = array_map(null,$aRequest['fAssetNumber'],$aRequest['fAssetItemId'],$aRequest['fStockQuqntity'],$aRequest['fIssueQuantity'],$aRequest['fUomId'],$aRequest['fItemGroup1Id'],$aRequest['fItemGroup2Id'],$aRequest['fItemId']);
			
			  foreach($aItems as $aItem)
			  {
			$qry1 = " INSERT INTO asset_delivery_item(id_asset_delivery_item, asset_no,id_asset_item,id_asset_delivery,current_stock_quantity, issue_quantitiy,id_uom, id_itemgroup1, id_itemgroup2, id_item,created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$aItem[0]','$aItem[1]','$delivery_lastInsertId','$aItem[2]','$aItem[3]','$aItem[4]','$aItem[5]','$aItem[6]','$aItem[7]','$created_by ',now(),'','','1')";
		
			$tran_qry = " INSERT INTO transaction(id_transaction, from_store, to_store, from_division, to_division, from_unit, to_unit,id_vendor, id_asset_item, id_itemgroup1, id_itemgroup2, id_item, asset_no, qty,id_uom, remarks, transaction_date, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$id_fromstore','$id_tostore','','','$from_unit','$to_unit','$id_vendor','$aItem[1]','$aItem[5]','$aItem[6]','$aItem[7]','$aItem[0]','$aItem[3]','$aItem[4]','$remark',now(),'$created_by ',now(),'','','1') ";
			  $this->oDb->query($tran_qry);	
			  
			  $qry_gate_Item ="INSERT INTO gate_pass_item(id_gate_pass_item, id_asset_gate_pass, id_asset_item, quantity, id_uom, id_itemgroup1, id_itemgroup2, id_item, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$gatepass_lastInsertId','$aItem[1]','$aItem[3]','$aItem[4]','$aItem[5]','$aItem[6]','$aItem[7]','$created_by ',now(),'','','1')";
			          $this->oDb->query($qry_gate_Item);
					  		 
					  if($this->oDb->query($qry1))	{
	/// MAintance 
		if($service_type == 'on' && $delivery_type == 'ESD')
		{
	 $qry_mainat = "INSERT INTO asset_maintenance(id_asset_maintenance, id_asset_item,id_asset_delivery,from_id_store,to_id_vendor, idle_start_date, idle_end_date, remarks, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$aItem[1]','$delivery_lastInsertId','$id_fromstore','$id_vendor',now(),'','$remarks','$created_by',now(),'','','19')";
	  
	 $update_asset = "UPDATE asset_item SET status='19' WHERE id_asset_item='$aItem[1]'";
	  $this->oDb->query($update_asset);
	  $update_stock = "UPDATE asset_stock SET status='19' WHERE id_asset_item='$aItem[1]'";
	  $this->oDb->query($update_stock);
	  $this->oDb->query($qry_mainat);
	
		}
	////									
						  				$qrys = "UPDATE asset_stock SET status='8' WHERE id_asset_item=".$aItem[1];
										  $this->oDb->query($qrys);	
						               $done = 1;
								   }
								   else
								   {
										$done = 0;
										 if($DEBUGS !=0)
			  {
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  }
								   }
			  
			  }
			  
			
			  
			$qry2 = "INSERT INTO delivery_map(id_delivery_map, id_asset_delivery, id_asset_gate_pass, status) VALUES (NULL,'$delivery_lastInsertId','$gatepass_lastInsertId','1')";
								   if($this->oDb->query($qry2))	{
									   $done = 1;
								   }
								   else
								   {
										$done = 0;
										 if($DEBUGS !=0)
			  {
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  }
								   }
		
		
		
		
		if($done == 1)
		{
			$result['lastinsertid'] = $delivery_lastInsertId;
			$result['msg'] = 1;
			return $result;
		}
		else
		{
			return false;
			 if($DEBUGS !=0)
			  {
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  }
		}
		
	}
	
	public function updateAssetDelivery($aRequest)
	{
		$delivery_type = $aRequest['fDeliveryType'];
		$id_fromstore = $aRequest['fFromStoreId'];
		if($delivery_type == 'ESD')
		{
			 $id_vendor = $aRequest['fvendorId'];
		}
		else
		{
			$id_tostore = $aRequest['fToStoreId'];
		}
		$remark = $aRequest['fRemark'];
		$issue_date = date('Y-m-d',strtotime($aRequest['fRequireDate']));
		//$id_isd = $this->internalStoreDeliveryCount();
		$issue_no = $aRequest['fIssueNumber'];
	    $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		
		$id_delivery = $aRequest['fDeliveryId'];
		
		
		 $aItems = array_map(null,$aRequest['fAssetNumber'],$aRequest['fAssetItemId'],$aRequest['fStockQuqntity'],$aRequest['fIssueQuantity'],$aRequest['fUomId'],$aRequest['fItemGroup1Id'],$aRequest['fItemGroup2Id'],$aRequest['fItemId']);
		
		$qry = "
		UPDATE asset_delivery SET delivery_type='$delivery_type', from_id_store='$id_fromstore ',to_id_store='$id_tostore',to_id_vendor=' $id_vendor',remark='$remark',issue_no='$issue_no',issue_date='$issue_date',modified_by='$created_by ',modified_on=now(),status=1 WHERE id_asset_delivery=".$id_delivery;
		$this->oDb->query($qry);
		 $gate_qry =" UPDATE asset_gate_pass SET gate_pass_date='$issue_date',modified_by='$created_by',modified_on=now(),status='1' WHERE id_asset_delivery=".$id_delivery;
		$this->oDb->query($gate_qry);
		
	 $qry3 = "SELECT id_asset_gate_pass FROM asset_gate_pass WHERE id_asset_delivery=".$id_delivery;
		if($row = $this->oDb->get_row($qry3))
		{
			 $_id_gate_pass = $row->id_asset_gate_pass;
		}
		
		$qry2= "DELETE FROM asset_delivery_item WHERE id_asset_delivery=".$id_delivery;
	 $qry4 = "DELETE FROM gate_pass_item WHERE id_asset_gate_pass=".$_id_gate_pass;	
		
		$this->oDb->query($qry4);
		if($this->oDb->query($qry2))	{
								  
									  
			 foreach($aItems as $aItem)
			  {
			$qry1 = " INSERT INTO asset_delivery_item(id_asset_delivery_item, asset_no,id_asset_item,id_asset_delivery,current_stock_quantity, issue_quantitiy,id_uom, id_itemgroup1, id_itemgroup2, id_item,created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$aItem[0]','$aItem[1]','$id_delivery','$aItem[2]','$aItem[3]','$aItem[4]','$aItem[5]','$aItem[6]','$aItem[7]','$created_by ',now(),'','','1')";
			  
			  $qry_gate_Item ="INSERT INTO gate_pass_item(id_gate_pass_item, id_asset_gate_pass, id_asset_item, quantity, id_uom, id_itemgroup1, id_itemgroup2, id_item, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$_id_gate_pass','$aItem[1]','$aItem[3]','$aItem[4]','$aItem[5]','$aItem[6]','$aItem[7]','$created_by ',now(),'','','1')";
			          $this->oDb->query($qry_gate_Item);		 
					  if($this->oDb->query($qry1))	{
						  				$qrys = "UPDATE asset_stock SET status='8' WHERE id_asset_item=".$aItem[1];
										  $this->oDb->query($qrys);	
						               $done = 1;
								   }
								   else
								   {
										$done = 0;
										 if($DEBUGS !=0)
			  {
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  }
								   }
			  
			  }
			  
								   }
								   else
								   {
										$done = 0;
										 if($DEBUGS !=0)
			  {
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  }
								   }
		
		
		
		if($done == 1)
		{
			
			
			return true;
		}
		else
		{
			return false;
			 if($DEBUGS !=0)
			  {
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  }
		}
	}
	
public function getDeliveryItemList()
  {
		$qry = "SELECT * FROM asset_delivery_item WHERE status !=2  ";
		 
		$aDeliveryItemList = array();
		
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aDeliveryItem['id_asset_delivery_item']   = $row->	id_asset_delivery_item;
				$aDeliveryItem['id_asset_item']   = $row->id_asset_item;
				$aDeliveryItem['asset_no']   = $row->asset_no;
				$aDeliveryItem['stock_quantity']   = $row->stock_quantity;
				$aDeliveryItem['current_stock_quantity']   = $row->current_stock_quantity;
				$aDeliveryItem['id_asset_delivery']   = $row->id_asset_delivery;
				$aDeliveryItem['issue_quantitiy']   = $row->issue_quantitiy;
						
				$aDeliveryItem['id_itemgroup1']   = $row->id_itemgroup1;
				$aDeliveryItem['id_itemgroup2']   = $row->id_itemgroup2;
				$aDeliveryItem['id_item']   = $row->id_item;
				$aDeliveryItem['id_uom']   = $row->id_uom;
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aDeliveryItem['uom_name']       = $aUom['uom_name'];
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aDeliveryItem['item_name']       = $aItem['item_name'];
				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aDeliveryItem['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aDeliveryItem['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				$aDeliveryItem['status']   = $row->status;
				$aDeliveryItemList[]        = $aDeliveryItem;
			}
		}
		return $aDeliveryItemList;
  } 	
  
  	 public function getDeliveryList($type=null)
  {
		if($type == 'Delivery')
		{
			$qry = "SELECT * FROM asset_delivery WHERE status =1 ";
		}
		else
		{
		$qry = "SELECT * FROM asset_delivery WHERE status !=2  ORDER BY id_asset_delivery DESC ";
		}
		$aDeliveryList = array();
		
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aDelivery['id_asset_delivery']   = $row->id_asset_delivery;
				$aDelivery['delivery_type']   = $row->delivery_type;
				$aDelivery['from_id_store']   = $row->from_id_store;
				$aStore  = $this->getStoreInfo($row->from_id_store,'id');
				$aDelivery['from_storename'] = $aStore['store_name'];
				$aStore1  = $this->getStoreInfo($row->to_id_store,'id');
				$aDelivery['to_storename'] = $aStore1['store_name'];
				$aDelivery['to_id_store']   = $row->to_id_store;
				$aDelivery['to_id_vendor']   = $row->to_id_vendor;
				$avendorName = $this->getVendorName($row->to_id_vendor);
				$aDelivery['vendor_name'] =  $avendorName;
				$aDelivery['bill_count'] =$this->getDeliveryItemBillStatus($row->id_asset_delivery);
				$aDelivery['remark']   = $row->remark;
				$aDelivery['issue_no']   = $row->issue_no;
				$aDelivery['issue_date']   = $row->issue_date;
				$aDelivery['status']   = $row->status;
				$aDeliveryList[]        = $aDelivery;
			}
		}
		return $aDeliveryList;
  } //	
  
   public function getDeliveryInfo($lookup, $type)
  {
		
		$qry = "SELECT * FROM asset_delivery WHERE status!=2 ";
	   if($type == 'deliveryType') {
	   	 $condition = " and delivery_type = '$lookup'";
	   }
	   else {
	     $condition = " and id_asset_delivery = ".$lookup;
	   }
	   $qry = $qry.$condition; 
		$aDelivery = array();
		
		if($row = $this->oDb->get_row($qry))
		{
			
				$aDelivery['id_asset_delivery']   = $row->id_asset_delivery;
				$aDelivery['delivery_type']   = $row->delivery_type;
				$aDelivery['from_id_store']   = $row->from_id_store;
				$aStore  = $this->getStoreInfo($row->from_id_store,'id');
				$aDelivery['from_storename'] = $aStore['store_name'];
				$aStore1  = $this->getStoreInfo($row->to_id_store,'id');
				$aDelivery['to_storename'] = $aStore1['store_name'];
				$aDelivery['to_id_store']   = $row->to_id_store;
				$aDelivery['to_id_vendor']   = $row->to_id_vendor;
				$aDelivery['vendor_name']    = $this->getVendorName($row->to_id_vendor);
				$aDelivery['remark']   = $row->remark;
				$aDelivery['issue_no']   = $row->issue_no;
				$aDelivery['issue_date']   = $row->issue_date;
				$aDelivery['status']   = $row->status;
			
		}
		return $aDelivery;
  } //
  
  public function getGatePass($assetDeliveryId)
  {
	 $qry = "SELECT id_delivery_map, id_asset_gate_pass, status FROM delivery_map WHERE id_asset_delivery=".$assetDeliveryId;  
	if($row = $this->oDb->get_row($qry))
		{
			 $_id_gate_pass = $row->id_asset_gate_pass;
		}
	 $qry2 = "SELECT id_gate_pass_item, id_asset_item, quantity, id_uom, id_itemgroup1, id_itemgroup2, id_item, created_by, created_on, modified_by, modified_on, status FROM gate_pass_item WHERE id_asset_gate_pass=".$_id_gate_pass;
	$aGateDeliveryItemList = array();
	if($result = $this->oDb->get_results($qry2))
	   {
	            foreach($result as $row)
				{
				$aGateDeliveryItem= array();
			   $aGateDeliveryItem['id_gate_pass_item']   = $row->	id_gate_pass_item;
				$aGateDeliveryItem['id_asset_item']   = $row->id_asset_item;
				$aGateDeliveryItem['quantitiy']   = $row->quantity;
						
				$aGateDeliveryItem['id_itemgroup1']   = $row->id_itemgroup1;
				$aGateDeliveryItem['id_itemgroup2']   = $row->id_itemgroup2;
				$aGateDeliveryItem['id_item']   = $row->id_item;
				$aGateDeliveryItem['id_uom']   = $row->id_uom;
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aGateDeliveryItem['uom_name']       = $aUom['uom_name'];
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aGateDeliveryItem['item_name']       = $aItem['item_name'];
				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aGateDeliveryItem['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aGateDeliveryItem['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				
				$aGateDeliveryItem['status']   = $row->status;	
				$aGateDeliveryItemList[] =  $aGateDeliveryItem;
				
				}
	   }
	   return $aGateDeliveryItemList;	
  }
  
  public function getDeliveryPrint($assetDeliveryId)
  {
	  $aPrint = array();
	  
	  $aDeliveryDetails = $this->getDeliveryInfo($assetDeliveryId,'id');
	  $aPrint['issue_no'] = $aDeliveryDetails['issue_no'];
	   $aPrint['remark'] = $aDeliveryDetails['remark'];
	 $aPrint['issue_date'] = $aDeliveryDetails['issue_date'];
	 $aPrint['from_id_store'] = $aDeliveryDetails['from_id_store'];
	 $aPrint['delivery_type'] = $aDeliveryDetails['delivery_type'];
	 $aStoreInfos1 = $this->getStoreInfo($aDeliveryDetails['from_id_store'],'id'); 
	  $aStoreAddress1 =array();
		 $aStoreAddress1['name'] = $aStoreInfos1['unitname'];
		 $aStoreAddress1['addr1'] = $aStoreInfos1['addr1'];
		$aStoreAddress1['addr2'] = $aStoreInfos1['addr2'];$aStoreAddress1['addr3'] = $aStoreInfos1['addr3'];
		$aStoreAddress1['city_name'] = $aStoreInfos1['city_name'];$aStoreAddress1['zipcode'] = $aStoreInfos1['zipcode'];
		$aPrint['from_address_format'] = $aStoreAddress1;
	 if($aDeliveryDetails['delivery_type'] == 'ESD')
	 {
		 $aPrint['to_id_vendor'] = $aDeliveryDetails['to_id_vendor'];
		 $aVendorInfos = $this->getPrintVendorAddress($aDeliveryDetails['to_id_vendor'],'id'); 
		
		 $avendorAddress =array();
		 $avendorAddress['name'] = $aVendorInfos['vendorname'];
		  $avendorAddress['contact_name'] = $aVendorInfos['contact_name'];
		 $avendorAddress['addr1'] = $aVendorInfos['addr1'];
		$avendorAddress['addr2'] = $aVendorInfos['addr2'];$avendorAddress['addr3'] = $aVendorInfos['addr3'];
		$avendorAddress['city_name'] = $aVendorInfos['city_name'];$avendorAddress['zipcode'] = $aVendorInfos['zipcode'];
		 $aPrint['to_address_format'] =  $avendorAddress;
	 }
	 else
	 {
		 $aPrint['to_id_store'] = $aDeliveryDetails['to_id_store'];
		$aStoreInfos = $this->getStoreInfo($aDeliveryDetails['to_id_store'],'id'); 
		 $aStoreAddress =array();
		 $aStoreAddress['name'] = $aStoreInfos['unitname'];
		 $aStoreAddress['addr1'] = $aStoreInfos['addr1'];
		$aStoreAddress['addr2'] = $aStoreInfos['addr2'];$aStoreAddress['addr3'] = $aStoreInfos['addr3'];
		$aStoreAddress['city_name'] = $aStoreInfos['city_name'];$aStoreAddress['zipcode'] = $aStoreInfos['zipcode'];
		$aPrint['to_address_format'] =  $aStoreAddress;
	 }
	 $aDeliveryItem = $this->getDeliveryItemInfoList($assetDeliveryId,'delivery');
	 $aPrint['DeliveryItem'] = $aDeliveryItem ;
	 $aGatePassItemInfo = $this->getGatePass($assetDeliveryId);
	$aPrint['GateItem'] =  $aGatePassItemInfo ;
	return  $aPrint;
	 
	  
  }
  
  public function getDeliveryItemInfo($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	   $qry = "SELECT * FROM asset_delivery_item WHERE status!=2 ";
	   if($type == 'delivery') {
	   	 $condition = " and id_asset_delivery = '$lookup'";
	   }
	   else {
	     $condition = " and id_asset_delivery_item = ".$lookup;
	   }
	  $qry = $qry.$condition;
	  
	   $aDeliveryItem = array();
	   if($row = $this->oDb->get_row($qry))
	   {
	           $aDeliveryItem['id_asset_delivery_item']   = $row->	id_asset_delivery_item;
				$aDeliveryItem['id_asset_item']   = $row->id_asset_item;
				$aDeliveryItem['asset_no']   = $row->asset_no;
				$aDeliveryItem['stock_quantity']   = $row->stock_quantity;
				$aDeliveryItem['current_stock_quantity']   = $row->current_stock_quantity;
				$aDeliveryItem['id_asset_delivery']   = $row->id_asset_delivery;
				$aDeliveryItem['issue_quantitiy']   = $row->issue_quantitiy;
						
				$aDeliveryItem['id_itemgroup1']   = $row->id_itemgroup1;
				$aDeliveryItem['id_itemgroup2']   = $row->id_itemgroup2;
				$aDeliveryItem['id_item']   = $row->id_item;
				$aDeliveryItem['id_uom']   = $row->id_uom;
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aDeliveryItem['uom_name']       = $aUom['uom_name'];
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aDeliveryItem['item_name']       = $aItem['item_name'];
				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aDeliveryItem['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aDeliveryItem['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				$aDeliveryItem['status']   = $row->status;
				
				$aDeliveryInfo = $this->getDeliveryInfo($row->id_asset_delivery,'id');	
				$aDeliveryItem['delivery_type']   = $aDeliveryInfo['delivery_type']; 
				$aDeliveryItem['from_id_store']   = $aDeliveryInfo['from_id_store']; 
				$aDeliveryItem['to_id_store']   = $aDeliveryInfo['to_id_store']; 
				$aDeliveryItem['to_id_vendor'] =$aDeliveryInfo['to_id_vendor'];
				
				$aDeliveryItem['issue_no'] =$aDeliveryInfo['issue_no'];
				$aDeliveryItem['issue_date'] =$aDeliveryInfo['issue_date']; 
	   }
	   return $aDeliveryItem;
	   
	}  
	
	
	
	 public function getDeliveryItemInfoList($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	 
	   
	   $qry = "SELECT DISTINCT id_asset_delivery,id_asset_delivery_item,id_asset_item,asset_no ,current_stock_quantity,id_asset_delivery,issue_quantitiy,id_itemgroup1,id_itemgroup2,id_item,id_uom,status FROM asset_delivery_item WHERE status!=2 and status!=16 and bill_status!=1";
	   if($type == 'delivery') {
	   	 $condition = " and id_asset_delivery = '$lookup'";
	   }
	   else {
	     $condition = " and id_asset_delivery_item = ".$lookup;
	   }
	 $qry = $qry.$condition;
	 $aDeliveryItemList = array();
	 	 			
	   if($result = $this->oDb->get_results($qry))
	   {
	            foreach($result as $row)
				{
				$aDeliveryItem= array();
			   $aDeliveryItem['id_asset_delivery_item']   = $row->	id_asset_delivery_item;
				$aDeliveryItem['id_asset_item']   = $row->id_asset_item;
				$aDeliveryItem['asset_no']   = $row->asset_no;
				$aDeliveryItem['stock_quantity']   = $row->stock_quantity;
				$aDeliveryItem['current_stock_quantity']   = $row->current_stock_quantity;
				$aDeliveryItem['id_asset_delivery']   = $row->id_asset_delivery;
				$aDeliveryItem['issue_quantitiy']   = $row->issue_quantitiy;
						
				$aDeliveryItem['id_itemgroup1']   = $row->id_itemgroup1;
				$aDeliveryItem['id_itemgroup2']   = $row->id_itemgroup2;
				$aDeliveryItem['id_item']   = $row->id_item;
				$aDeliveryItem['id_uom']   = $row->id_uom;
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aDeliveryItem['uom_name']       = $aUom['lookup'];
				
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aDeliveryItem['item_name']       = $aItem['item_name'];
				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aDeliveryItem['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aDeliveryItem['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				
				$aDeliveryItem['status']   = $row->status;	
				$aDeliveryItemList[] =  $aDeliveryItem;
				
				}
	   }
	   
	 
	   return $aDeliveryItemList;
	   
	}
	
	 public function getDeliveryItemLists($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	 
	   
	   $qry = "SELECT DISTINCT id_asset_delivery,id_asset_delivery_item,id_asset_item,asset_no ,current_stock_quantity,id_asset_delivery,issue_quantitiy,id_itemgroup1,id_itemgroup2,id_item,id_uom,status FROM asset_delivery_item WHERE status=16 and bill_status!=1";
	   if($type == 'delivery') {
	   	 $condition = " and id_asset_delivery = '$lookup'";
	   }
	   else {
	     $condition = " and id_asset_delivery_item = ".$lookup;
	   }
	 $qry = $qry.$condition;
	 $aDeliveryItemList = array();
	 	 			
	   if($result = $this->oDb->get_results($qry))
	   {
	            foreach($result as $row)
				{
				$aDeliveryItem= array();
			   $aDeliveryItem['id_asset_delivery_item']   = $row->	id_asset_delivery_item;
				$aDeliveryItem['id_asset_item']   = $row->id_asset_item;
				$aDeliveryItem['asset_no']   = $row->asset_no;
				$aDeliveryItem['stock_quantity']   = $row->stock_quantity;
				$aDeliveryItem['current_stock_quantity']   = $row->current_stock_quantity;
				$aDeliveryItem['id_asset_delivery']   = $row->id_asset_delivery;
				$aDeliveryItem['issue_quantitiy']   = $row->issue_quantitiy;
						
				$aDeliveryItem['id_itemgroup1']   = $row->id_itemgroup1;
				$aDeliveryItem['id_itemgroup2']   = $row->id_itemgroup2;
				$aDeliveryItem['id_item']   = $row->id_item;
				$aDeliveryItem['id_uom']   = $row->id_uom;
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aDeliveryItem['uom_name']       = $aUom['lookup'];
				
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aDeliveryItem['item_name']       = $aItem['item_name'];
				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aDeliveryItem['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aDeliveryItem['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				
				$aDeliveryItem['status']   = $row->status;	
				$aDeliveryItemList[] =  $aDeliveryItem;
				
				}
	   }
	   
	 
	   return $aDeliveryItemList;
	   
	}
	
	
	 public function getDeliveryItemListForPopup($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	 
	   
	   $qry = "SELECT DISTINCT id_asset_delivery,id_asset_delivery_item,id_asset_item,asset_no ,current_stock_quantity,id_asset_delivery,issue_quantitiy,id_itemgroup1,id_itemgroup2,id_item,id_uom,status FROM asset_delivery_item WHERE bill_status!=1";
	   if($type == 'delivery') {
	   	 $condition = " and id_asset_delivery = '$lookup'";
	   }
	   else {
	     $condition = " and id_asset_delivery_item = ".$lookup;
	   }
	 $qry = $qry.$condition;
	 $aDeliveryItemList = array();
	 	 			
	   if($result = $this->oDb->get_results($qry))
	   {
	            foreach($result as $row)
				{
				$aDeliveryItem= array();
			   $aDeliveryItem['id_asset_delivery_item']   = $row->	id_asset_delivery_item;
				$aDeliveryItem['id_asset_item']   = $row->id_asset_item;
				$aDeliveryItem['asset_no']   = $row->asset_no;
				$aDeliveryItem['stock_quantity']   = $row->stock_quantity;
				$aDeliveryItem['current_stock_quantity']   = $row->current_stock_quantity;
				$aDeliveryItem['id_asset_delivery']   = $row->id_asset_delivery;
				$aDeliveryItem['issue_quantitiy']   = $row->issue_quantitiy;
						
				$aDeliveryItem['id_itemgroup1']   = $row->id_itemgroup1;
				$aDeliveryItem['id_itemgroup2']   = $row->id_itemgroup2;
				$aDeliveryItem['id_item']   = $row->id_item;
				$aDeliveryItem['id_uom']   = $row->id_uom;
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aDeliveryItem['uom_name']       = $aUom['lookup'];
				
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aDeliveryItem['item_name']       = $aItem['item_name'];
				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aDeliveryItem['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aDeliveryItem['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				
				$aDeliveryItem['status']   = $row->status;	
				$aDeliveryItemList[] =  $aDeliveryItem;
				
				}
	   }
	   
	 
	   return $aDeliveryItemList;
	   
	}
	public function getContractInfos($lookup,$type)
	{
	
	$qry = "SELECT * FROM contract WHERE status!=2 and ";
		 if($type == 'id') {
			 $condition = " id_contract = '$lookup'";
		   }
		   
		 $qry = $qry.$condition;
		  
		 $aContractInfo = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				$aContractInfo['id_contract'] =$row->id_contract;
				$aContractInfo['contract_type'] =$row->contract_type;
				$aContractInfo['contract_title'] =$row->contract_title;
				$aContractInfo['id_vendor'] =$row->id_vendor;
				$aContractInfo['contract_start_date'] =$row->contract_start_date;
				$aContractInfo['contract_end_date'] =$row->contract_end_date;
				$aContractInfo['contract_order_value'] =$row->contract_order_value;
				$aContractInfo['contract_value'] =$row->contract_value;
				$aContractInfo['contract_reference_number'] =$row->contract_reference_number;
				$aContractInfo['remark'] =$row->remark;
				$aContractInfo['contract_date'] =$row->contract_date;
				$aContractInfo['renewal_date'] =$row->renewal_date;
				$aContractInfo['no_items'] =$row->no_items;
				$aContractInfo['terms_and_conditions'] =$row->terms_and_conditions;
			
			}
			return $aContractInfo;
		   }	
	}
	public function getContractGroupList($type=null,$lookup=null)
	{
		 if($type == 'group') {
	  	$qry = "SELECT * FROM contract WHERE status!=2 and contract_type IN ('".$lookup."')";
	   }
	    $aContractList = array();
	
	
		   if($result= $this->oDb->get_results($qry))
		   {
			  foreach($result as $row)
			  {
			  
			     if($this->isContractAssignable($row->id_contract,$row->no_items))
				 {
				 
			   $aContract = array();
				$aContract['id_contract'] =$row->id_contract;
				
				
				$aContract['contract_type'] =$row->contract_type;
				$aContract['contract_title'] =$row->contract_title;
				$aContract['id_vendor'] =$row->id_vendor;
				$aContract['contract_start_date'] =$row->contract_start_date;
				$aContract['contract_end_date'] =$row->contract_end_date;
				$aContract['contract_reference_number'] =$row->contract_reference_number;
				$aContract['remark'] =$row->remark;
				$aContract['contract_date'] =$row->contract_date;
				$aContract['renewal_date'] =$row->renewal_date;
				$aContract['no_items'] =$row->no_items;
				$aContract['terms_and_conditions'] =$row->terms_and_conditions;
				  $aContractList[] = $aContract;
				  }
			  }
		   }
		   return $aContractList;
	}
	public function getContractList($type=null)
	{
		
	    if($type == 'list') {
	   	$qry = "SELECT DISTINCT contract_type FROM contract WHERE status!=2";
	   }
	   else {
	    $qry = "SELECT * FROM contract WHERE status!=2";
	   }
		$aContractList = array();
	
	
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				$aContract = array();
				$aContract['id_contract'] =$row->id_contract;
				$aContract['contract_type'] =$row->contract_type;
				$aContract['contract_title'] =$row->contract_title;
				$aContract['id_vendor'] =$row->id_vendor;
				$aContract['contract_start_date'] =$row->contract_start_date;
				$aContract['contract_end_date'] =$row->contract_end_date;
				$aContract['contract_reference_number'] =$row->contract_reference_number;
				$aContract['remark'] =$row->remark;
				$aContract['contract_date'] =$row->contract_date;
				$aContract['renewal_date'] =$row->renewal_date;
				$aContract['no_items'] =$row->no_items;
				$aContract['terms_and_conditions'] =$row->terms_and_conditions;
				$aContractList[] = $aContract ;
			}
		   }
		
		   return $aContractList;
	}
	public function getContractItemInfo($lookup)
	{
		$aContractList = array();
		$aContractInfoList=$this->getAssetContractList($lookup,'contract');
		
		foreach($aContractInfoList as $aContractInfo)
		{
		$aContractAsset = array();
		$aContractAsset['id_asset_item'] = $aContractInfo['id_asset_item'];
		
		$aAssetItemInfo =$this->getAssetItemInfo($aContractInfo['id_asset_item'],'id');
		
		$aContractAsset['id_itemgroup1']   = $aAssetItemInfo['id_itemgroup1'];
		$aContractAsset['itemgroup2_name'] = $aAssetItemInfo['itemgroup2_name'];
		$aContractAsset['itemgroup1_name'] = $aAssetItemInfo['itemgroup1_name'];
		$aContractAsset['item_name'] = $aAssetItemInfo['item_name'];
		$aContractAsset['asset_no'] = $aAssetItemInfo['asset_no'];
		$aContractAsset['id_contract'] = $aContractInfo['id_contract'];
		$aContractAsset['id_asset_contract'] = $aContractInfo['id_asset_contract'];
		$aContractList[] = $aContractAsset ;
		}
		return $aContractList;
	}
	public function getContractInfo($lookup)
	{
		$aContract = array();
		$aAssetContract = $this->getAssetContract($lookup,'asset');
		$aContract ['id_asset_item']  = $aAssetContract['id_asset_item'];
		$aContract['id_contract']  = $aAssetContract['id_contract'];
		$aContract ['contract_start_date']  = $aAssetContract['contract_start_date'];
		$aContract ['contract_end_date']  = $aAssetContract['contract_end_date'];
		$aContract ['remarks']  = $aAssetContract['remarks'];
		$aAssetContractDocument = $this->getContractDocument($aContract['id_contract'],'id');
		
		$aContract ['id_contract_doc']  = $aAssetContractDocument['id_contract_doc'];
		$aContract['id_document']  = $aAssetContractDocument['id_document'];
		$aAssetContractDocumentInfo =$this->getContactDocumentInfo($aContract['id_document'],'id');
		$aContract['document_name']   =$aAssetContractDocumentInfo['document_name']  ;
		$aContract['document_type']   =$aAssetContractDocumentInfo['document_type'];
		
		return $aContract;
	}
	
	public function getContractInfoList($lookup)
	{
		$qry = "SELECT * FROM asset_contract WHERE status!=2 and id_asset_item = ".$lookup;
		 
		$aContractList = array();
	
	
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
					$aContract = array();
				   $aContract['id_contract']   = $row->id_contract;
				   $aAssetContractDocument = $this->getContractDocumentInfoList($aContract['id_contract'],'');
				$aContract['contract_doc_details']= $aAssetContractDocument;
		       $aContractList = $aContract;
			}
		   }
		
	
		return $aContractList;
	}
	public function getAssetContractList($lookup,$type )
	{
		$qry = "SELECT * FROM asset_contract WHERE status!=2 and ";
		   if($type == 'asset') {
			 $condition = " id_asset_item = '$lookup'";
		   }
		    else if($type == 'contract') {
			 $condition = " id_contract = '$lookup'";
		   }
		   else if($type == 'assetexist') {
			 $condition = " id_asset_item = '$lookup'";
		   }
		   else {
			 $condition = " id_asset_stock = ".$lookup;
		   }
		  $qry = $qry.$condition;
		  
		  if($type =='assetexist')
		  {
			 $result = $this->oDb->query($qry);
			 $num_rows = $this->oDb->num_rows;
			 return  $num_rows ;
		  }
		 $aContractList = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				$aContract = array();
				$aContract['id_asset_contract']   = $row->id_asset_contract;
				$aContract['id_asset_item']   = $row->id_asset_item;
				$aContract['id_contract']   = $row->id_contract;
				$aContract['contract_start_date']   = $row->contract_start_date;
				$aContract['contract_end_date']   = $row->contract_end_date;
				$aContract['remarks']   = $row->remarks;
				$aContract['status']   = $row->status;
				$aContractList[] = $aContract ;
			}
			return $aContractList;
		   }
	}
	public function getAssetContract($lookup,$type )
	{
		$qry = "SELECT * FROM asset_contract WHERE status!=2 and ";
		   if($type == 'asset') {
			 $condition = " id_asset_item = '$lookup'";
		   }
		    else if($type == 'contract') {
			 $condition = " id_contract = '$lookup'";
		   }
		   else if($type == 'assetexist') {
			 $condition = " id_asset_item = '$lookup'";
		   }
		   else {
			 $condition = " id_asset_stock = ".$lookup;
		   }
		  $qry = $qry.$condition;
		  
		  if($type =='assetexist')
		  {
			  $valid = '0';
			 $result = $this->oDb->get_results($qry);
			 {
					  foreach($result as $row)
					 {
					 $id_contract = $row->id_contract;
					 $checkqry_ins = "SELECT contract_end_date, DATEDIFF( contract_end_date,now()) As days FROM contract WHERE id_contract='$id_contract'";
							if($rows = $this->oDb->get_row($checkqry_ins))
							{
							 $days = $rows->days;
								 if($days > 0)
								 {
								 $valid = '1';
								 }
								 else
								 {
								  $valid = '0';
								 }
							}
						}
				}
			 return $valid ;
		  }
		 $aContract = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				$aContract['id_asset_contract']   = $row->id_asset_contract;
				$aContract['id_asset_item']   = $row->id_asset_item;
				$aContract['id_contract']   = $row->id_contract;
				$aContract['contract_start_date']   = $row->contract_start_date;
				$aContract['contract_end_date']   = $row->contract_end_date;
				$aContract['remarks']   = $row->remarks;
				$aContract['status']   = $row->status;
			
			}
			return $aContract;
		   }
	}
	public function geContractInfo($lookup)
	{
		
		 $qry1 = "SELECT * FROM asset_contract WHERE status=1 and id_asset_item = ".$lookup;
		
		 $aContract = array();
	
	
		   if($row = $this->oDb->get_row($qry1))
		   {
			$aContract['status']   = $row->status;
		 $qry = "SELECT * FROM contract WHERE id_contract = ".$row->id_contract;
		   }
		   
		
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
					$aContract['id_contract']   = $row->id_contract;
					$aContract['contract_type']   = $row->contract_type;
					$aContract['contract_title']   = $row->contract_title;
					$aContract['contract_order_value']   = $row->contract_order_value;
					$aContract['contract_value']   = $row->contract_value;
					$aContract['id_vendor']   = $row->id_vendor;
					$aContract['vendor_name']   = $this->getVendorName($row->id_vendor);
					$aContract['contract_start_date']   = $row->contract_start_date;
					$aContract['contract_end_date']   = $row->contract_end_date;
					$aContract['contract_reference_number']   = $row->contract_reference_number;
					$aContract['renewal_date']   = $row->renewal_date;
					$aContract['contract_date']   = $row->contract_date;
					$aContract['remarks']   = $row->remarks;
		
			}
		   
			return $aContract;
		   }
	}
	public function getContractVendorContact($lookup,$type)
	{
		$qry = "SELECT * FROM contract_contact WHERE status!=2 and ";
		 if($type == 'contract') {
			 $condition = " id_contract = '$lookup'";
		   }
		  $qry = $qry.$condition;
		 $aContractVendorContactList= array();
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				$aContractVendorContact['id_contract_contact']   = $row->id_contract_contact;
				$aContractVendorContact['id_contract']   = $row->id_contract;
				$aContractVendorContact['id_vendor_contact']   = $row->id_vendor_contact;
				$aContractVendorContact['status']   = $row->status;
				$aContractVendorAddress=$this->getFullAddressFormat($row->id_vendor_contact,'','id');
				$aContractVendorContact['vendor_address'] = $aContractVendorAddress;
				$aContractVendorContactList[] = $aContractVendorContact;
			}
			return $aContractVendorContactList;
		   }
	}
	
	public function getContractDocument($lookup,$type )
	{
		$qry = "SELECT * FROM contract_doc WHERE status!=2 and ";
		 if($type == 'id') {
			 $condition = " id_contract_doc = '$lookup'";
		   }
		   
		 $qry = $qry.$condition;
		  
		 $aContractDocument = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				$aContractDocument['id_contract_doc']   = $row->id_contract_doc;
				$aContractDocument['id_contract']   = $row->id_contract;
				$aContractDocument['id_document']   = $row->id_document;
				$aContractDocument['status']   = $row->status;
			
			}
			return $aContractDocument;
		   }
	}
	
	public function getContractDocumentInfoList($lookup,$type )
	{
		
		$qry = "SELECT * FROM contract_doc WHERE status!=2 and ";
		 if($type == 'id') {
			 $condition = " id_contract_doc = '$lookup'";
		   }
		   else
		   {
		    $condition = " id_contract = '$lookup'";
		   
		   }
		   
		 $qry = $qry.$condition;
		 
		 $aContractDocumentList = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				 $aContractDocument = array();
				$aContractDocument['id_contract_doc']   = $row->id_contract_doc;
				$aContractDocument['id_contract']   = $row->id_contract;
				$aContractDocument['id_document']   = $row->id_document;
				$aContractDocument['status']   = $row->status;
				$aContract_doc = $this->getContactDocumentInfo($row->id_document,'id');
				
				$aContractDocument['id_document'] = $aContract_doc['id_document'];
				$aContractDocument['document_name'] = $aContract_doc['document_name'];
				$aContractDocument['document_type'] = $aContract_doc['document_type'];
				$aContractDocument['doc_status'] = $aContract_doc['status'];
				$aContractDocumentList[] = $aContractDocument;
			}
			return $aContractDocumentList;
		   }
	}
	public function getContactDocumentInfo($lookup,$type )
	{
		$qry = "SELECT * FROM document WHERE status!=2 and ";
		 if($type == 'id') {
			 $condition = " id_document = '$lookup'";
		   }
		   
		  $qry = $qry.$condition;
		  
		 $aContractDocumentInfo = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				$aContractDocumentInfo['id_document']   = $row->id_document;
				$aContractDocumentInfo['document_name']   = $row->document_name;
				$aContractDocumentInfo['document_type']   = $row->document_type;
				$aContractDocumentInfo['status']   = $row->status;
			
			}
			return $aContractDocumentInfo;
		   }
	}
	
	
	public function assetCount()
	{
			 $Count = array();
			$qry = "SELECT Max(id_asset_item) As id FROM asset_item WHERE 1=1";
			$result = $this->oDb->get_results($qry);
			 foreach($result as $row)
			{
			$Count['count'] = $row->id+1+10000;
			}
			return $Count;
	}
	
	public function purchaseRequestCount()
	{
			 $Count = array();
			$qry = "SELECT Max(id_pr) As id FROM purchase_request WHERE 1=1";
			$result = $this->oDb->get_results($qry);
			 foreach($result as $row)
			{
			$Count['count'] = $row->id+1+10000;
			}
			return $Count;
	}
	
	public function purchaseOrderCount()
	{
			 $Count = array();
			$qry = "SELECT Max(id_po) As id FROM purchase_order WHERE 1=1";
			$result = $this->oDb->get_results($qry);
			 foreach($result as $row)
			{
			$Count['count'] = $row->id+1+10000;
			}
			return $Count;
	}
	
	public function purchaseReturnCount()
	{
			 $Count = array();
			$qry = "SELECT Max(id_purchase_return) As id FROM purchase_return WHERE 1=1";
			$result = $this->oDb->get_results($qry);
			 foreach($result as $row)
			{
			$Count['count'] = $row->id+1+10000;
			}
			return $Count;
	}
	
	
	public function ServiceCount()
	{
			 $Count = array();
			$qry = "SELECT Max(id_service) As id FROM service WHERE 1=1";
			$result = $this->oDb->get_results($qry);
			 foreach($result as $row)
			{
			$Count['count'] = $row->id+1+10000;
			}
			return $Count;
	}
	
	public function internalStoreDeliveryCount()
	{
			 $Count = array();
			$qry = "SELECT Max(id_asset_delivery) As id FROM asset_delivery WHERE 1=1";
			$result = $this->oDb->get_results($qry);
			 foreach($result as $row)
			{
				
		        $Count['count'] = $row->id+1+10000;
				// $acompany = $this->getCompanyInfo('1','id');
				//$ISDNumber = $acompany['lookup'].'-'.'ISD'.$Count['count'];
			}
			
			return $Count;
	}
	
	public function GoodsReceivedNumberCount()
	{
			 $Count = array();
			$qry = "SELECT Max(id_inventory) As id FROM inventory WHERE 1=1";
			$result = $this->oDb->get_results($qry);
			 foreach($result as $row)
			{
				
		        $Count['count'] = $row->id+1+10000;
				 $acompany = $this->getCompanyInfo('1','id');
				$GRNNumber = $acompany['lookup'].'-'.'GRN'.'-'.$Count['count'];
			}
			
			return $GRNNumber;
	}
	public function contractMaxCount($contractId)
	{
		$qry = "SELECT no_items FROM contract WHERE id_contract=".$contractId;
			$result = $this->oDb->get_row($qry);
			 $maxCount  = $result->no_items;
			
			return $maxCount;
	}
	public function isContractAssignable($contractId,$maxCount)
	{
		$valid = false;
		$used_count = $this->contractUsedCount($contractId);
		if($used_count < $maxCount)
		{
			$valid = true;
		}
		return $valid;
	}
	public function contractBalanceCount($contractId)
	{
		 $maxCount = $this->contractMaxCount($contractId);
		$usedCount = $this->contractUsedCount($contractId);
		$balanceCount = $maxCount - $usedCount;
		if($balanceCount < 0)
		{
			$balanceCount = 0;
		}
		return $balanceCount;
	}
	public function contractUsedCount($lookup)
	{
			
			$qry = "SELECT COUNT(id_contract) As used_count FROM asset_contract WHERE id_contract=".$lookup;
			$result = $this->oDb->get_row($qry);
			 $Count  = $result->used_count;
			
			return $Count;
	}
	public function countAssetImage()
	{
			
			$qry = "SELECT Max(id_image) As image_count FROM asset_image";
			$result = $this->oDb->get_row($qry);
			 $Count  = $result->image_count;
			
			return $Count+1;
	}
	public function addTermscondition($aRequest)
	{
	
	  $title         = strtoupper($aRequest['fTitle']);
	  $desc         = $aRequest['fDescription'];
	 $status            = $aRequest['fStatus'];
	  $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
	  
	  $query = "INSERT INTO terms_conditions(id_terms_conditions, name, description, status) VALUES (NULL,'$title','$desc','$status')";
	
	  if($this->oDb->query($query))
	   {
	     //exit();
	     return true;
	   }
	   else { //exit();
	     return false;
	   }	 
	}
	
	public function updateTermscondition($aRequest)
	{
 
	 $id_terms = $aRequest['fTermsId'];
	  $title         = strtoupper($aRequest['fTitle']);
	  $desc         = $aRequest['fDescription'];
	 $status            = $aRequest['fStatus'];
	  $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
	  
	  $query = "UPDATE terms_conditions SET name='".$title."',description='".$desc."',status='".$status."' WHERE id_terms_conditions=".$id_terms;
	$this->oDb->query($query);
	if( mysql_affected_rows() >= 0)
				{
				 return true;
				
				}
				else
				{
				return false;
				}
	 
	}
	
	
	public function getTermsConditions()
	{
	$qry = "SELECT * FROM terms_conditions ORDER BY  id_terms_conditions DESC";
		$aTermsList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aTerms = array();
				$aTerms['id_terms_conditions']   = $row->id_terms_conditions;
				$aTerms['name'] = $row->name;
				$aTerms['status'] = $row->status;
				$aTerms['description']       = $row->description;
				
				$aTermsList[]          = $aTerms;
			}
		}
		return $aTermsList;
	}
	public function getTermsConditionsInfo($lookup)
	{
	    $qry = "SELECT * FROM terms_conditions WHERE status != 2 and id_terms_conditions=".$lookup;
		   
		   
		$aTermsInfo = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
    		  
				$aTermsInfo['id_terms_conditions']   = $row->id_terms_conditions;
				$aTermsInfo['name'] = $row->name;
				$aTermsInfo['description']       = $row->description;
				$aTermsInfo['status'] = $row->status;
			}
		}
		return $aTermsInfo;
	}// 
	
	public function assetItemCount()
	{
			
			$qry = "SELECT COUNT(id_asset_item) As item FROM asset_item WHERE 1=1";
			$result = $this->oDb->get_row($qry);
			 $Count  = $result->item;
			
			return $Count;
	}
	public function getSearchName($aRequest)
	{
	$critria =$aRequest['fCriteria'];
	$id_unit = $aRequest['fUnitId'];
	$id_store = $aRequest['fStoreId'];
	$id_itemGtoup1 = $aRequest['fGroup1'];
	$id_itemGtoup2 = $aRequest['fGroup2'];
	$id_item = $aRequest['fItemName'];
	$results = 'Asset';
	if($id_unit != null)
	{
		$aUnit = $this->getUnitInfo($id_unit,'id');
		$results=strtoupper($aUnit['unit_name']); 
	}
	if($id_store != null)
	{
		$aStoreInfo = $this->getStoreInfo($id_store,'id');
		$results=$aStoreInfo['store_name'].',';
	}
			
	if($id_itemGtoup1 != null )
	{
		$aGroup1 = $this->getItemGroup1Info($id_itemGtoup1,'id');
		$results=$aGroup1['itemgroup1_name'].'-';
	}
	if($id_itemGtoup2 != null )
	{
		$aGroup2 = $this->getItemGroup2Info($id_itemGtoup2,'id');
		$results.=$aGroup2['itemgroup2_name'].'-';
	}
	if($id_item != null )
	{
		$aItem = $this->getItemInfo($id_item,'id');
		$results.=$aItem['item_name'].'';
	}
	return $results;
	}
	public function getSearchLabel($aRequest)
	{
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
	
	if($id_unit != null)
	{
		$aUnit = $this->getUnitInfo($id_unit,'id');
		$results=strtoupper($aUnit['unit_name']).','; 
	}
	if($id_store != null)
	{
		$aStoreInfo = $this->getStoreInfo($id_store,'id');
		$results.=$aStoreInfo['store_name'].',';
	}
			
	if($id_itemGtoup1 != null )
	{
		$aGroup1 = $this->getItemGroup1Info($id_itemGtoup1,'id');
		$results.=$aGroup1['itemgroup1_name'].',';
	}
	if($id_itemGtoup2 != null )
	{
		$aGroup2 = $this->getItemGroup2Info($id_itemGtoup2,'id');
		$results.=$aGroup2['itemgroup2_name'].',';
	}
	if($id_item != null )
	{
		$aItem = $this->getItemInfo($id_item,'id');
		$results.=$aItem['item_name'].',';
	}
	if($start_date != null && $end_date != null)
	{
		$results.= date('d-M-Y',strtotime($start_date)).' TO '.date('d-M-Y',strtotime($end_date)).',';
	}
	if($idle_days != null && $oper != null)
	{
		$results.= 'Idle Days '.$oper.$idle_days.',';
	}
	if(empty($results))
	{
	$results='All,';
	}
	$results=substr($results,0,(strlen($results)-1));
	return $results;
	}
	
	public function addFuel($aRequest)
	{
		
		$bill_number = $aRequest['fBillNumber'];
		$bill_date = date('Y-m-d',strtotime($aRequest['fBillDate']));
		$token_number = $aRequest['fTkNumber'];
		$payment_type = $aRequest['fPaymentType'];
		$bill_amount = $aRequest['fBillAmount'];
		$total_price = $aRequest['fTotalPrice'];
		$qty = $aRequest['fQuantity'];
		$id_uom = $aRequest['fUOMId'];
		$unit_price = $aRequest['fUnitPrice'];
		$net_amount = $aRequest['fTotal'];
		$id_asset_item = $aRequest['fItemName'];
		$id_vendor = $aRequest['fVendorId'];
		$remarks = $aRequest['fRemark'];
		$fuel_type = $aRequest['fFuelType'];
		
		$OMR = $aRequest['fOMR'];
		$CMR = $aRequest['fCMR'];
		
		 $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		 
		 $trip_qry = "INSERT INTO trip(id_trip, omr, cmr,id_asset_item,remarks,created_by, created_on) VALUES (NULL,'$OMR','$CMR','$id_asset_item','Fuel','$created_by',now())";
		  if($this->oDb->query($trip_qry))
	      {
	     $lastInsertId = $this->oDb->insert_id;
	      }
	  
		 
		 $qry = "INSERT INTO fuel(id_fuel, bill_no, bill_date, token_no, payment_type, bill_amount, total_price, qty, id_uom, unit_price, net_amount, id_asset_item, id_fuel_type, id_vendor, id_trip, remarks, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$bill_number','$bill_date','$token_number','$payment_type','$bill_amount','$total_price','$qty','$id_uom','$unit_price','$net_amount','$id_asset_item','$fuel_type','$id_vendor','$lastInsertId','$remarks','$created_by ',now(),'','','1')";
		 if($this->oDb->query($qry))
	   {
	     //exit();
	     return true;
	   }
	   else { //exit();
	     return false;
	   }	 
	}
	
	public function updateFuel($aRequest,$action = null)
	{
		if($action == 'delete')
		{
	
		  $id_fuel  = $aRequest;
		  $qry = "UPDATE fuel SET status = 2 WHERE id_fuel = ".$id_fuel ;
		
		}
		else
		{
		$bill_number = $aRequest['fBillNumber'];
		$bill_date = date('Y-m-d',strtotime($aRequest['fBillDate']));
		$token_number = $aRequest['fTkNumber'];
		$payment_type = $aRequest['fPaymentType'];
		$bill_amount = $aRequest['fBillAmount'];
		$total_price = $aRequest['fTotalPrice'];
		$qty = $aRequest['fQuantity'];
		$id_uom = $aRequest['fUOMId'];
		$unit_price = $aRequest['fUnitPrice'];
		$net_amount = $aRequest['fTotal'];
		$id_asset_item = $aRequest['fItemName'];
		$id_vendor = $aRequest['fVendorId'];
		$remarks = $aRequest['fRemark'];
		$fuel_type = $aRequest['fFuelType'];
		$id_fuel = $aRequest['fFuelId'];
		$id_trip = $aRequest['fTripId'];
				
		$OMR = $aRequest['fOMR'];
		$CMR = $aRequest['fCMR'];
		
		 $checkqry = "SELECT * FROM fuel_limit WHERE status=1 and id_asset_item='$id_asset_item'";
 		 $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{	
		 $result_fuel  = $this->oDb->get_row($checkqry);
		 $fuel_limit = $result_fuel->id_fuel_limit;
		}
		
		
		 $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		 $qry = "UPDATE fuel SET bill_no='".$bill_number."',bill_date='".$bill_date."',token_no='".$token_number."',payment_type='".$payment_type."',bill_amount='".$bill_amount."',total_price='".$total_price."',qty='".$qty."',id_uom='".$id_uom."',unit_price='".$unit_price."',net_amount='".$net_amount."',id_asset_item='".$id_asset_item."',id_fuel_type='".$fuel_type."',id_fuel_limit='".$fuel_limit."',id_vendor='".$id_vendor."',id_trip='".$id_trip."',remarks='".$remarks."',modified_by='".$created_by."',modified_on=now() WHERE id_fuel=".$id_fuel;
		 $trip_qry = "UPDATE trip SET omr='".$OMR."', cmr='".$CMR."',id_asset_item='".$id_asset_item."' WHERE id_asset_item='".$id_asset_item."' AND id_trip=".$id_trip;
		 $this->oDb->query($trip_qry);
		}
		 if($this->oDb->query($qry))
	   {
	     //exit();
	     return true;
	   }
	   else { //exit();
	     return false;
	   }	 
	}
	public function getFuelList()
	{
		
		$qry = "SELECT
    asset_item.machine_no
    , asset_item.asset_no
    , asset_item.asset_name
  	 , fuel.id_fuel
    , fuel.bill_no
    , fuel.bill_date
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
    , fuel.id_asset_item
  
	, vendor.vendor_name
FROM
    asset_item
    INNER JOIN fuel 
        ON (asset_item.id_asset_item = fuel.id_asset_item)
		  INNER JOIN vendor 
        ON (fuel.id_vendor = vendor.id_vendor)
    WHERE  fuel.status !=2 ";
		  $order = 'ORDER BY fuel.id_fuel DESC';
		$qry =$qry.$order;
		$aFuelList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aFuel = array();
				$aFuel['id_fuel']   = $row->id_fuel;
				$aFuel['bill_no'] = $row->bill_no;
				$aFuel['bill_date']    = $row->bill_date;
				$aFuel['token_no']  = $row->token_no;
				$aFuel['payment_type']    = $row->payment_type;
				$aFuel['bill_amount']    = $row->bill_amount;
				$aFuel['total_price']    = $row->total_price;
				$aFuel['qty']    = $row->qty;
				$aFuel['id_uom']    = $row->id_uom;
				$aFuel['unit_price']    = $row->unit_price;
				$aFuel['net_amount']    = $row->net_amount;
				$aFuel['id_asset_item']    = $row->id_asset_item;
				$aFuel['id_fuel_type']    = $row->id_fuel_type;
				$aFuel['id_vendor']    = $row->id_vendor;
				$aFuel['asset_no']    = $row->asset_no;
				$aFuel['machine_no']    = strtoupper($row->machine_no);
				$aFuel['id_trip']    = $row->id_trip;
				$aFuel['remarks']    = $row->remarks;
				$aFuel['vendor_name']    = $row->vendor_name;
				$aFuel['status']    = $row->status;
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aFuel['uom_name']       = $aUom['lookup'];
				$aItem = $this->getItemInfo($row->asset_name,'id');
				$aFuel['item_name']       = $aItem['item_name'];
				$aFuelList[]        = $aFuel;
			}
		}
		return $aFuelList;
	}
	 public function getFuelInfo($lookup, $type )
  {
	
	  $qry = "SELECT
    asset_item.machine_no
    , asset_item.asset_no
    , asset_item.asset_name
    , fuel.id_fuel_type
	 , fuel.id_fuel
    , fuel.bill_no
    , fuel.bill_date
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
    , fuel.id_asset_item
    , item.item_name AS fuel_type
	, vendor.vendor_name
	  , itemgroup2.itemgroup2_name
    , itemgroup1.itemgroup1_name
    , itemgroup2.id_itemgroup2
    , itemgroup1.id_itemgroup1
	, asset_item.id_asset_item
	,item.id_item
FROM
    asset_item
    INNER JOIN fuel 
        ON (asset_item.id_asset_item = fuel.id_asset_item)
		  INNER JOIN vendor 
        ON (fuel.id_vendor = vendor.id_vendor)
		INNER JOIN itemgroup1 
        ON (asset_item.id_itemgroup1 = itemgroup1.id_itemgroup1)
    INNER JOIN itemgroup2 
        ON (asset_item.id_itemgroup2 = itemgroup2.id_itemgroup2)
    INNER JOIN item 
        ON (asset_item.asset_name= item.id_item) WHERE  asset_item.status !=2 ";
		
		if($type == 'asset') {
			 $condition = " and fuel.id_asset_item = '$lookup'";
		   }
		  
		   else {
			 $condition = " and fuel.id_fuel= ".$lookup;
		   }
		 
		 $qry = $qry.$condition;
	
		$aFuelInfo = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				
				$aFuelInfo['id_fuel']   = $row->id_fuel;
				$aFuelInfo['bill_no'] = $row->bill_no;
				$aFuelInfo['bill_date']    = $row->bill_date;
				$aFuelInfo['token_no']  = $row->token_no;
				$aFuelInfo['payment_type']    = $row->payment_type;
				$aFuelInfo['bill_amount']    = $row->bill_amount;
				$aFuelInfo['total_price']    = $row->total_price;
				$aFuelInfo['qty']    = $row->qty;
				$aFuelInfo['id_uom']    = $row->id_uom;
				$aFuelInfo['unit_price']    = $row->unit_price;
				$aFuelInfo['net_amount']    = $row->net_amount;
				$aFuelInfo['id_asset_item']    = $row->id_asset_item;
				$aFuelInfo['id_fuel_type']    = $row->id_fuel_type;
			
				$aFuelInfo['id_vendor']    = $row->id_vendor;
				$aFuelInfo['asset_no']    = $row->asset_no;
				$aFuelInfo['machine_no']    = strtoupper($row->machine_no);
				$aFuelInfo['id_trip']    = $row->id_trip;
			
				$aFuelInfo['remarks']    = $row->remarks;
				$aFuelInfo['vendor_name']    = $row->vendor_name;
				$aFuelInfo['id_itemgroup2']    = $row->id_itemgroup2;
				$aFuelInfo['itemgroup2_name']    = $row->itemgroup2_name;
				$aFuelInfo['id_itemgroup1']    = $row->id_itemgroup1;
				$aFuelInfo['itemgroup1_name']    = $row->itemgroup1_name;
				$aFuelInfo['asset_name']    = $row->asset_name;
					$aFuelInfo['id_asset_item']    = $row->id_asset_item;
				$aFuelInfo['status']    = $row->status;
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aFuelInfo['uom_name']       = $aUom['lookup'];
				$aItem = $this->getItemInfo($row->asset_name,'id');
				$aFuelInfo['item_name']       = $aItem['item_name'];
				$aTrip = $this->getTripInfo($row->id_trip,'id');
				$aFuelInfo['omr']       = $aTrip['omr'];
				$aFuelInfo['id_trip']       = $aTrip['id_trip'];
				$aFuelInfo['cmr']       = $aTrip['cmr'];
				
			}
		}
		return $aFuelInfo;
  }
  
 public function getTripInfo($lookup,$tripid)
 {
 $qry = "SELECT * FROM trip WHERE";
 if($type == 'date') {
			 $condition = "  created_on = '$lookup'";
		   }
		   else {
			 $condition = "  id_trip= ".$lookup;
		   }
		 
		 $qry = $qry.$condition; 
		$aTripInfo = array();
		if($row = $this->oDb->get_row($qry))
		{
		$aTripInfo['id_trip'] = $row->id_trip;
		$aTripInfo['omr'] = $row->omr;
		$aTripInfo['cmr'] = $row->cmr;
		}
		return $aTripInfo;
 } 
 public function updateDelivery($aRequest,$files)
 {
	 $storeDeliverId = $aRequest['fStoreDeliveryId'];
	 $id_tostore = $aRequest['fToStoreId'];
	 $id_fromstore = $aRequest['fFromStoreId'];
	 $aAssetId = $aRequest['fAssetItemId'];
	 $status = $aRequest['fStatus'];
	 $delivery_type = $aRequest['fDeliveryType'];
	 $received_by = $aRequest['fReceiverEmployeeId'];
	 	$astores =$this->getStoreInfo($id_tostore ,'id');
		$to_unit = $astores['id_unit'];
		 $updated_by        = $_SESSION['sesCustomerInfo']['user_id'];
		 if($delivery_type == 'ESD')
		 {
		 $id_tostore = $id_fromstore;
		 }
				 
		foreach($aAssetId as $key => $value )
		{
	
			if($status !='17')
			{
			
			$qrys = "UPDATE asset_stock SET status='1',id_unit='".$to_unit."',id_store = '".$id_tostore."' WHERE id_asset_item=".$value;
			 $this->oDb->query($qrys);	
			 $qry = "UPDATE transaction SET status='".$status."',modified_by='".$updated_by."',modified_on=now() WHERE id_asset_item=".$value;
			  $this->oDb->query($qry);
			   $qry_item = "UPDATE asset_delivery_item SET status='".$status."',modified_by='".$updated_by."',modified_on=now() WHERE id_asset_item='$value' AND id_asset_delivery='$storeDeliverId'";
			  $this->oDb->query($qry_item);
			}
			else
			{
				$qrys = "UPDATE asset_stock SET status='1' WHERE id_asset_item=".$value;
			 $this->oDb->query($qrys);	
			 $qry = "UPDATE transaction SET status='".$status."',modified_by='".$updated_by."',modified_on=now() WHERE id_asset_item=".$value;
			  $this->oDb->query($qry);
			   $qry_item = "UPDATE asset_delivery_item SET status='".$status."',modified_by='".$updated_by."',modified_on=now() WHERE id_asset_item='$value' AND id_asset_delivery='$storeDeliverId'";
			  $this->oDb->query($qry_item);
			}
		}
		
	 $checkqty = $this->getTotalStoreDeliveryItem($storeDeliverId);
		
		if(	$checkqty > 0)
		{
			 return true;	
		}
		else
		{
	$qry = "UPDATE asset_delivery SET received_by='".$received_by."',status='".$status."' WHERE id_asset_delivery=".$storeDeliverId;
	if($this->oDb->query($qry))
	   {
	     
	     return true;
	   }
	   else { //exit();
	     return false;
	   }
		
		}
 }
 
 public function countAssetNumber($itemid,$type=null)
 {
	
	 $qry = "SELECT
  item.id_item
   , item.item_name
    
    , item.lookup
     , COUNT(asset_item.asset_name) AS counts
FROM
    asset_item
    INNER JOIN item 
        ON (asset_item.asset_name = item.id_item)
           WHERE (item.id_item = $itemid)";
		 
		 if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
			 $Counts = array();
			 $Counts['counts']  = $row->counts;
			  $Counts['count'] =  $Counts['counts'] +1;
			   $Counts['lookup']  = $row->lookup;
			}
		}
	if($type=='asset')
	{ 
	$asset_number = $Counts['counts'];
	}
	else
	{
		  $acompany = $this->getCompanyInfo('1','id');
				$asset_number = $acompany['lookup'].'-'.$Counts['lookup'].'-'.$Counts['count'];
	}
				return $asset_number;
 }
 
public function addAssignVendorToPr($aRequest)
{
//assign vendor for pr
		$id_pr = $aRequest['fPRId'];
		$aid_vendor   = $aRequest['fVendorId'];
		$created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		foreach($aid_vendor  as $id_vendor)
		{
		 $checkqry = "SELECT * FROM pr_vendor_map WHERE id_vendor='$id_vendor' AND id_pr='$id_pr'";
		 $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		 
		if(	$num_rows == 0)
		{		   
		$qry = "INSERT INTO pr_vendor_map(id_pr_vendor_map, id_pr, id_vendor, created_by, creatred_on, modified_by, modified_on, status) VALUES (NULL,'$id_pr','$id_vendor','$created_by',now(),'','','1')";
		}
		if($this->oDb->query($qry))	{
		 $MAP_lastInsertId = $this->oDb->insert_id;
		  $PRNumber = $this->getPRNumbers($id_pr);
		$this->addHistoryTransLog($aRequest,$MAP_lastInsertId,'VMAP','PR','ASSIGN',$PRNumber,$id_pr,'1',$qry,'New Vendor Added For this PR','');
		  $done = $id_pr;
		}
		else{
		   $done = $id_pr;
		}
		}
		return $done;
}
public function getAssignVendorToPrInfo($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	   $qry = "SELECT * FROM pr_vendor_map WHERE  ";
	   if($type == 'lookup') {
	   	 $condition = " quote_received_status=0 AND id_pr = '$lookup'";
	   }
	   else {
	     $condition = " id_pr = ".$lookup;
	   }
	 $qry = $qry.$condition;
	   $aAssignVendorList = array();
	    if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
			 $aAssignVendor = array();
		$aAssignVendor['id_pr_vendor_map']   = $row->id_pr_vendor_map;
		$aAssignVendor['vendor_name'] = strtoupper($this->getVendorName($row->id_vendor));
		$aAssignVendor['id_pr']    =$row->id_pr;
		$aAssignVendor['id_vendor']    =$row->id_vendor;
		$aAssignVendor['status']    = $row->status;	
		$aAssignVendor['quote_received_status']    = $row->quote_received_status;	
		$aAssignVendorList[] = 	$aAssignVendor;  
	   }
	   }
	   return $aAssignVendorList;
	   
	} 
	public function getQuotationList($lookup)
	{
	     $qry = "SELECT id_quote, id_pr, po_number, id_vendor, id_division, id_unit, quote_number, quote_date, quote_amount, quote_valid_date, created_by, created_on, approved_by, status, DATE_FORMAT(approved_on,'%d %b, %Y') as format_date FROM quote WHERE   ";  		 
	    $condition = " id_pr = ".$lookup;
	  
		$order = " quote order by id_quote DESC";
	  $qry = $qry.$condition;
		$aQutationList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aQutation = array();
				$aQutation['id_quote'] = $row->id_quote;
				$aQutation['id_pr'] = $row->id_pr;
				$apurchaseRequest = $this->getPurchaseRequestItem($row->id_pr,'id');
				$aQutation['request_no']= $apurchaseRequest[0]['request_no'];
				$aQutation['id_division'] = $row->id_division;
				$aQutation['id_unit'] = $row->id_unit;
				$aQutation['quote_number'] = $row->quote_number;
				$aQutation['quote_date'] = $row->quote_date;
				$aQutation['quote_amount'] = $row->quote_amount;
				$aQutation['approved_by'] = $row->approved_by;
				$aQutation['approved_on'] = $row->format_date;
				$aEmployeeInfo = $this->getEmployeeInfo($row->approved_by);
				$aQutation['employee_name']      = $aEmployeeInfo['employee_name'];
				$aQutation['quote_valid_date'] = $row->quote_valid_date;
				$aQutation['id_vendor'] = $row->id_vendor;
				$aQutation['vendor_name'] = strtoupper($this->getVendorName($row->id_vendor));
				$aQutation['status'] = $row->status;
				$aQutationList[]     = $aQutation;
			}
		}
		return $aQutationList;
	}  
	
	public function getQuotationListInfo($lookup,$type = '')
	{
	      		 
	   $qry = "SELECT * FROM quote WHERE   ";
	   if($type == 'id')
	   {
	     $condition = " id_quote = ".$lookup;
	   }
	   else
	   {	    $condition = " id_pr = ".$lookup;
	   }
		$order = " quote order by id_quote DESC";
	    $qry = $qry.$condition;
		$aQutation = array();
		if($row = $this->oDb->get_row($qry))
		{
			
				
				$aQutation['id_quote'] = $row->id_quote;
				$aQutation['id_pr'] = $row->id_pr;
				$apurchaseRequest = $this->getPurchaseRequestItem($row->id_pr,'id');
				$aQutation['request_no']= $apurchaseRequest[0]['request_no'];
				$aQutation['id_division'] = $row->id_division;
				$aQutation['id_unit'] = $row->id_unit;
				$aQutation['quote_number'] = $row->quote_number;
				$aQutation['quote_date'] = $row->quote_date;
				$aQutation['quote_amount'] = $row->quote_amount;
				$aQutation['quote_valid_date'] = $row->quote_valid_date;
				$aQutation['id_vendor'] = $row->id_vendor;
				$aQutation['remarks']       = $row->remarks;
				$aQutation['vendor_name'] = strtoupper($this->getVendorName($row->id_vendor));
				$aQutation['status'] = $row->status;
				
		}
		return $aQutation;
	}  
	
	public function getQuotationInfo($lookup,$type = '')
	{
	    
	   $qry = "
	   
	   SELECT
    quote_document.id_quote
    , quote_document.id_document
    , quote_document.id_quote_document
    , quote.id_pr
    , quote.po_number
    , quote.id_vendor
    , quote.id_division
    , quote.id_unit
    , quote.quote_number
    , quote.quote_date
    , quote.quote_amount
    , quote.quote_amount
	 , quote.remarks
    , quote.quote_valid_date
    , quote.status
    , document.document_name
    , document.document_type
    , document.status As doc_status
	, quote.status
FROM
     quote
    INNER JOIN quote_document 
        ON (quote.id_quote = quote_document.id_quote)
    INNER JOIN document 
        ON (quote_document.id_document = document.id_document)
WHERE  
	      ";
		  $order = "  order by id_quote DESC";
		 if($type =='pr')
		 {
		   $condition = " quote.id_pr  = '$lookup'";
		 $qry = $qry.$condition.$order;
	
		   $aQutation = array();
		   if($result = $this->oDb->get_results($qry))
		{
				foreach($result as $row)
			{	
				$aQutationItem = array();
				$aQutationItem['id_quote'] = $row->id_quote;
				$aQutationItem['id_pr'] = $row->id_pr;
				$apurchaseRequest = $this->getPurchaseRequestItem($row->id_pr,'id');
				$aQutationItem['request_no']= $apurchaseRequest[0]['request_no'];
				$aQutationItem['id_division'] = $row->id_division;
				$aQutationItem['id_unit'] = $row->id_unit;
				$aQutationItem['quote_number'] = $row->quote_number;
				$aQutationItem['quote_date'] = $row->quote_date;
				$aQutationItem['quote_amount'] = $row->quote_amount;
				$aQutationItem['quote_valid_date'] = $row->quote_valid_date;
				$aQutationItem['id_vendor'] = $row->id_vendor;
				$aQutationItem['id_document'] = $row->id_document;
				$aQutationItem['document_name'] = $row->document_name;
				$aQutationItem['document_type'] = $row->document_type;
				$aQutationItem['id_vendor'] = $row->id_vendor;
				$aQuotationItem['remarks']       = $row->remarks;
				$aQutationItem['vendor_name'] = strtoupper($this->getVendorName($row->id_vendor));
				$aQutationItem['status'] = $row->status;
				 $aQutation[] = $aQutationItem;
				}
				
		}
		 } else
		 {
	    $condition = " quote.id_quote  = '$lookup'";
		  $qry = $qry.$condition.$order;
		$aQutation = array();
		if($row = $this->oDb->get_row($qry))
		{
						
				$aQutation['id_quote'] = $row->id_quote;
				$aQutation['id_pr'] = $row->id_pr;
				$apurchaseRequest = $this->getPurchaseRequestItem($row->id_pr,'id');
				$aQutation['request_no']= $apurchaseRequest[0]['request_no'];
				$aQutation['id_division'] = $row->id_division;
				$aQutation['id_unit'] = $row->id_unit;
				$aQutation['quote_number'] = $row->quote_number;
				$aQutation['quote_date'] = $row->quote_date;
				$aQutation['quote_amount'] = $row->quote_amount;
				$aQutation['quote_valid_date'] = $row->quote_valid_date;
				$aQutation['id_vendor'] = $row->id_vendor;
				$aQutation['id_document'] = $row->id_document;
				$aQutation['document_name'] = $row->document_name;
				$aQutation['document_type'] = $row->document_type;
				$aQutation['id_vendor'] = $row->id_vendor;
				$aQutation['vendor_name'] = strtoupper($this->getVendorName($row->id_vendor));
				$aQutation['status'] = $row->status;
		}
		
	 
				
			
		}
		if(empty($aQutation))
				{
				
				$aQutation = $this->getQuotationListInfo($lookup,'id');
				
				}
		
	return $aQutation;
	}  
	
public function getQuotationItemInfo($lookup,$type)
{
	$qry = "SELECT * FROM quote_item WHERE status!=2 and ";
		   if($type == 'pr') {
			 $condition = " id_pr = '$lookup'";
		   }
		   else {
			 $condition = " id_quote = ".$lookup;
		   }
		 $qry = $qry.$condition;
		 $aQuotationItemList = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			foreach($result as $row)
			{						
				$aQuotationItem = array();
				$aQuotationItem['id_quote']   = $row->id_quote;
				$aQuotationItem['id_quote_item']   = $row->id_quote_item;
				$aQuotationItem['id_pr_item'] = $row->id_pr_item;
				$aQuotationItem['id_pr'] = $row->id_pr;
				$aQuotationItem['id_itemgroup1']      = $row->id_itemgroup1;
				$aQuotationItem['id_itemgroup2']      = $row->id_itemgroup2;
				$aQuotationItem['id_item']      = $row->id_item;
				$aQuotationItem['pr_item_name']      = $row->pr_item_name;
				$aQuotationItem['unit_cost']    = $row->unit_cost;
				$aQuotationItem['qty']   = $row->qty;
				$aQuotationItem['id_uom']    = $row->id_uom;
				$aQuotationItem['quote_item_name']      = $row->quote_item_name;
				$aQuotationItem['quote_unit_cost']      = $row->quote_unit_cost;
				$aQuotationItem['quote_qty'] = $row->quote_qty;
				$aQuotationItem['negotiated_unit_cost']       = $row->negotiated_unit_cost;
				$aQuotationItem['tax_percent']= $row->tax_percent;
				$aQuotationItem['due_date']      = $row->due_date;
				$aQuotationItem['quote_due_date']      = $row->quote_due_date;
				$aQuotationItem['quote_due_date'] = $row->quote_due_date;
				$aQuotationItem['remarks']       = $row->remarks;
				$aQuotationItem['status']= $row->status;
				
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aQuotationItem['uom_name']       = $aUom['lookup'];
				
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aQuotationItem['item_name']       = $aItem['item_name'];
				
				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aQuotationItem['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aQuotationItem['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
					 $aQuotationItemList['quotation_item'][]           = $aQuotationItem;	
						
					   }
			   if($type == 'pr') {
			  $aQuotationItemList['quotationinfo']= $this->getQuotationInfo($lookup,'pr');
			  
			 
		   }
		   else {
					  $aQuotationItemList['quotationinfo']= $this->getQuotationInfo($lookup,'id'); 
					   }
		   }
		   return $aQuotationItemList;
}
public function getQuotationItemInfoList($lookup,$type)
{
	$qry = "SELECT * FROM quote_item WHERE status!=2 and ";
		   if($type == 'pr') {
			 $condition = " id_pr = '$lookup'";
		   }
		   else {
			 $condition = " id_quote = ".$lookup;
		   }
		 $qry = $qry.$condition;
		 $aQuotationItemList = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			foreach($result as $row)
			{						
				$aQuotationItem = array();
				$aQuotationItem['id_quote']   = $row->id_quote;
				$aQuotationItem['id_quote_item']   = $row->id_quote_item;
				$aQuotationItem['id_pr_item'] = $row->id_pr_item;
				$aQuotationItem['id_pr'] = $row->id_pr;
				$aQuotationItem['id_itemgroup1']      = $row->id_itemgroup1;
				$aQuotationItem['id_itemgroup2']      = $row->id_itemgroup2;
				$aQuotationItem['id_item']      = $row->id_item;
				$aQuotationItem['pr_item_name']      = $row->pr_item_name;
				$aQuotationItem['unit_cost']    = $row->unit_cost;
				$aQuotationItem['qty']   = $row->qty;
				$aQuotationItem['id_uom']    = $row->id_uom;
				$aQuotationItem['quote_item_name']      = $row->quote_item_name;
				$aQuotationItem['quote_unit_cost']      = $row->quote_unit_cost;
				$aQuotationItem['quote_qty'] = $row->quote_qty;
				$aQuotationItem['negotiated_unit_cost']       = $row->negotiated_unit_cost;
				$aQuotationItem['tax_percent']= $row->tax_percent;
				$aQuotationItem['due_date']      = $row->due_date;
				$aQuotationItem['quote_due_date']      = $row->quote_due_date;
				$aQuotationItem['quote_due_date'] = $row->quote_due_date;
				$aQuotationItem['remarks']       = $row->remarks;
				$aQuotationItem['status']= $row->status;
				
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aQuotationItem['uom_name']       = $aUom['lookup'];
				
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aQuotationItem['item_name']       = $aItem['item_name'];
				
				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aQuotationItem['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aQuotationItem['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
					 $aQuotationItemList[]           = $aQuotationItem;	
						
					   }
					 
					   }
		   return $aQuotationItemList;
}
public function compareQuotation($lookup)
{
$aCompareQuotation = array();
 $qry = "SELECT * FROM quote WHERE status!=2 AND id_pr=".$lookup;
          if($result = $this->oDb->get_results($qry))
		   {
			foreach($result as $row)
			{
			
			$aCompareQuotation['quotation_iteminfo'][] = $this->getQuotationItemInfo($row->id_quote,'id');
			}
			}
return $aCompareQuotation;
}
public function addQuotation($aRequest,$files)
{
                
				$id_pr = $aRequest['fPRId'];	
				$id_vendor = $aRequest['fVendorId'];
				$quote_no = $aRequest['fQuotationNo'];
				$quote_amt = $aRequest['fQuotationAmount'];
				$quote_due_date =date('Y-m-d',strtotime($aRequest['fDueDate']));
				$quote_valid_date =date('Y-m-d',strtotime($aRequest['fValidDate']));
					 $created_by        = $_SESSION['sesCustomerInfo']['user_id'];	
					 $remarks = $aRequest['fRemarks'];		
				$qry = "INSERT INTO quote(id_quote, id_pr, po_number, id_vendor, id_division, id_unit, quote_number, quote_date, quote_amount, quote_valid_date,remarks, created_by, created_on, approved_by, approved_on, status) VALUES (NULL,'$id_pr','','$id_vendor ','','','$quote_no','$quote_due_date','$quote_amt','$quote_valid_date','$remarks','$created_by',now(),'','','1')";
		
		if($this->oDb->query($qry))	{
		   $lastInsertId = $this->oDb->insert_id;
		   //log 
		    $this->addQuoteTransLog($aRequest,$lastInsertId,'NEW',$qry,'New Quotation for vendors');
			$PRNumber = $this->getPRNumbers($id_pr);
			$this->addHistoryTransLog($aRequest,$lastInsertId,'QUOTE','PR','QUOTE',$PRNumber,$id_pr,'1',$qry,'New Quotation For PR ('.$PRNumber.')','');
		   
		  		$qry_map = "UPDATE pr_vendor_map SET quote_received_status=1 WHERE id_vendor='$id_vendor' AND id_pr=".$id_pr;
				if($this->oDb->query($qry_map))
				{
				$this->addHistoryTransLog($aRequest,$id_vendor,'VEN','PR','QUOTESTATUS',$PRNumber,$id_pr,'1',$qry_map,'Quotation Received','');
			    }
		    if($this->uploadQuotationDocument($aRequest,$files,$lastInsertId))
			   {
			    
			    $done=1;
			   }
			   else
			   {
			   $done = 0;
			   }
			   
			    if($this->addQuotationItem($aRequest,$lastInsertId))
			   {
				//log 
				 $this->addQuoteTransLog($aRequest,$lastInsertId,'NEW','', 'New Quotation Items are added');				
				$done = 1;
				
			   }
			   else
			   {
				   
				 $done = 0;
			   }
		     $done = 1; 
		}
		else{
		$done = 0;
		}
	if($done == 1)
	{
	return $id_pr;
	}
	else
	{
	return false;
	}
		
}
public function addQuotationItem($aRequest,$lastInsertId)
{
               
			   $aInsertvalues = array_map(null,$aRequest['fItemId'],$aRequest['fVendorPrice'],$aRequest['fNegoPrice']);
	
			foreach($aInsertvalues as $items)
			 { 
				
					$id_pr = $aRequest['fPRId'];
					$apurchaseRequest = $this->getPurchaseRequestItem($id_pr,'quote',$items[0]);
				$id_pr_number= $apurchaseRequest[0]['request_no'];
				$id_group1      = $apurchaseRequest[0]['id_itemgroup1'];
			    $id_group2     = $apurchaseRequest[0]['id_itemgroup2'];
				$id_item     = $apurchaseRequest[0]['id_item'];
				$unit_cost    = $apurchaseRequest[0]['unit_cost'];
				$qty   = $apurchaseRequest[0]['qty'];
				$id_uom = $apurchaseRequest[0]['id_uom'];
			 $qry = "
				
				 INSERT INTO quote_item(id_quote_item, id_quote, id_pr, id_pr_item, id_itemgroup1, id_itemgroup2, id_item, pr_item_name, unit_cost, qty, id_uom, quote_item_name, quote_unit_cost, quote_qty, negotiated_unit_cost, tax_percent, due_date, quote_due_date, terms_conditions, remarks, status) VALUES (NULL,'$lastInsertId','$id_pr','$items[0]','$id_group1','$id_group2','$id_item ','','$unit_cost','$qty','$id_uom','','$items[1]','','$items[2]','','','','','','1')
				";
				
			
				if($this->oDb->query($qry))	{
						
			$done = 1;
			}
			else{
			  $done = 0;
			}
			
			}
			
				
}
public function uploadQuotationDocument($aRequest,$files,$lastInsertId)
	{
		
		
		 $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
			$id_inventory = $aRequest['fGrnId'];
		 $files['fUploadDocument']['name'];
		if(!empty($files['fUploadDocument']['name']))
		{
		
		 $fileName = $files['fUploadDocument']['name']; //echo '<br>';
		 		   
		  $ext = explode(".", $fileName);
		   $ext = array_pop($ext);
		   $name = strtotime(date('Y-m-d h:i:s'));
		   $newFileName = $name.'_document.'.$ext;
		   $fileup = $files['fUploadDocument']['tmp_name']; //echo '<br>';
		    $targetPath 	= APP_ROOT."/uploads/quotationdocument/"; //echo '<br>';
		   $targetFileName = $lastInsertId.'_'.$newFileName; //echo '<br>';
		   move_uploaded_file($fileup, $targetPath.$targetFileName);
		
		   //update database.
		   
		 $checkqry = "SELECT * FROM quote_document WHERE id_quote='$lastInsertId'";
		 $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		  if($row = $this->oDb->get_row($checkqry))
	     {
	      $id_document   = $row->id_document;
		  }
		if(	$num_rows > 0)
		{		   
		  $query = "UPDATE document SET document_name='".$targetFileName."' WHERE id_document = ".$id_document;
		   if($this->oDb->query($query))
		   {
			 //log 
				 $this->addQuoteTransLog($aRequest,$lastInsertId,'UPDATE',$query, 'Update Quotation Documnent uploaded for vendor');
			 $valid = true;
		   }
		   else
		   {
		   $valid = false;
		   }
		   }
		   else
		   {
	 $query="INSERT INTO document(id_document ,document_name ,document_type ,status)
VALUES (NULL ,   '$targetFileName ',  '', '1');";
			 if($this->oDb->query($query))
		   {
			  $doc_lastInsertId = $this->oDb->insert_id;
			  $query1="INSERT INTO quote_document(id_quote_document ,id_quote ,id_document)
VALUES (NULL ,   '$lastInsertId ',  '$doc_lastInsertId');";
$this->oDb->query($query1);
                      //log 
				 $this->addQuoteTransLog($aRequest,$lastInsertId,'NEW',$query1, 'New Quotation Documnent uploaded for vendor');
			 $valid = true;
		   }
		   else
		   {
		   $valid = false;
		   }
			 	
		   }
		   
		         
		  		  
			return $valid;
		}
		
		
	} 
public function updateQuotation($aRequest,$files)
{		
			
				$id_quote = $aRequest['fQuoteId'];
				$quote_no = $aRequest['fQuotationNo'];
				$quote_amt = $aRequest['fQuotationAmount'];
				$quote_due_date =date('Y-m-d',strtotime($aRequest['fDueDate']));
				$quote_valid_date =date('Y-m-d',strtotime($aRequest['fValidDate']));
				$id_pr = $aRequest['fPRId'];	
				$remarks = $aRequest['fRemarks'];
				$id_vendor = $aRequest['fVendorId'];			
           $qry = "UPDATE quote SET quote_number='".$quote_no."',remarks='".$remarks."',quote_date='".$quote_due_date."',quote_amount='".$quote_amt."',quote_valid_date='".$quote_valid_date."' WHERE id_quote=".$id_quote;
		           //log 
				   $PRNumber = $this->getPRNumbers($id_pr);
			  $this->addHistoryTransLog($aRequest,$id_quote,'QUOTE','PR','QUOTEUPDATE',$PRNumber,$id_pr,'1',$qry,'Quotation  updated For PR','');
				 $this->addQuoteTransLog($aRequest,$id_quote,'UPDATE',$qry, 'Update Quotation');
				 $this->oDb->query($qry);
				if( mysql_affected_rows() >= 0)
				{
				  $done = 1; 
		        }else{   $done = 0;}
		  
				if(!empty($files))
				{
			 if($this->uploadQuotationDocument($aRequest,$files,$id_quote))
			   {
			      //log 
				 $this->addQuoteTransLog($aRequest,$id_quote,'UPDATE',$qry, 'Update Quotation document for vendor');
				$done=1;
			   }
			   else
			   {
			    $done=0;
			   }
			   }
			 if($result = $this->updateQuotationItem($aRequest,$id_quote))
			   {
				//log 
				 $this->addQuoteTransLog($aRequest,$id_quote,'UPDATE',$qry, 'Update Quotation Items for vendor');
				$done = $result;
			   }
		 
   
	if($done == 1)
	{
	return $id_pr;
	}
	else
	{
	return $id_pr;
	}
		
}
public function updateQuotationItem($aRequest,$lastInsertId)
{
               
			   $aInsertvalues = array_map(null,$aRequest['fQuoteItemId'],$aRequest['fVendorPrice'],$aRequest['fNegoPrice'],$aRequest['fItemId']);
		
			foreach($aInsertvalues as $items)
			 { 
				$id_pr = $aRequest['fPRId'];	
				$apurchaseRequest = $this->getPurchaseRequestItem($id_pr,'quote',$items[0]);
				$id_pr_number= $apurchaseRequest[0]['request_no'];
				$id_group1      = $apurchaseRequest[0]['id_itemgroup1'];
			    $id_group2     = $apurchaseRequest[0]['id_itemgroup2'];
				$id_item     = $apurchaseRequest[0]['id_item'];
				$unit_cost    = $apurchaseRequest[0]['unit_cost'];
				$qty   = $apurchaseRequest[0]['qty'];
				$id_uom = $apurchaseRequest[0]['id_uom'];
			 $qry = "
				
				UPDATE quote_item SET id_pr_item='".$items[3]."',id_itemgroup1='".$id_group1."',id_itemgroup2='".$id_group2 ."',id_item='".$id_item."',id_uom='".$id_uom."',qty='".$qty."',unit_cost='".$unit_cost."',quote_unit_cost='".$items[1]."',negotiated_unit_cost='".$items[2]."',remarks='".$aRequest['remarks']."' WHERE id_quote_item=".$items[0];
				if($this->oDb->query($qry))	{
				
				 $done=1;
			}
			else{
			 $done=0;
			}
			}
		
	return $done;			
				
}
public function addQuotationApproval($aRequest)
{
		$aid_vendor = $aRequest['fApprovedVendorId'];
		$id_approver = $aRequest['fApprovalEmployeeId'];
		$id_pr = $aRequest['fPRId'];
		$aVendor = explode("/",$aid_vendor);
	$qry = " INSERT INTO quote_approval(id_quote_approval, id_quote, id_pr, id_vendor, approved_by, approved_on, status) VALUES (NULL,'$aVendor[1]','$id_pr','$aVendor[0]','$id_approver',now(),'1')";
	
	              //log 
				   $PRNumber = $this->getPRNumbers($id_pr);
			  $this->addHistoryTransLog($aRequest,$aVendor[1],'QUOTE','PR','APPROVEQUOTE',$PRNumber,$id_pr,'1',$qry,'Quotation approved for PR','');
				 $this->addQuoteTransLog($aRequest,$aVendor[1],'APPROVE',$qry, 'Quotation approved for PR');
	
	$qry_update = "UPDATE quote SET status=3,approved_by='".$id_approver."',approved_on=now() WHERE id_quote=".$aVendor[1];
	$this->oDb->query($qry_update);
	$this->oDb->query($qry_update);
	if($this->oDb->query($qry))	{
		$qry_update_status = "UPDATE quote SET status =12 WHERE id_vendor!='".$aVendor[0]."' AND id_pr=".$id_pr;
		          //log 
				    $this->addHistoryTransLog($aRequest,$aVendor[1],'QUOTE','PR','FINALQUOTE',$PRNumber,$id_pr,'1',$qry,'Quotation approved for PR and close other vendor','');
				 $this->addQuoteTransLog($aRequest,$aVendor[1],'CLOSE',$qry, 'Quotation approved for PR and close other vendor ');
		$this->oDb->query($qry_update_status);
			return $id_pr;
			}
			else{
			return $id_pr;
			}
}
public function updateQuotationApproval($aRequest)
{
		
	
		$id_quote_approval = $aRequest['fQuoteApprovalId'];
		$id_approver = $aRequest['fApprovalEmployeeId'];
		$id_pr = $aRequest['fPRId'];
		$aid_vendor = $aRequest['fApprovedVendorId'];
		$aVendor = explode("/",$aid_vendor);
		
			 $qry = "UPDATE quote_approval SET id_quote ='".$aVendor[1]."', id_pr='".$id_pr."', id_vendor='".$aVendor[0]."', approved_by='".$id_approver."', approved_on=now() WHERE id_quote_approval=".$id_quote_approval;
	$qry_update_unapprove = "UPDATE quote SET status =18 WHERE status=3 AND id_pr=".$id_pr;
	              //log
				    $PRNumber = $this->getPRNumbers($id_pr); 
				   $this->addHistoryTransLog($aRequest,$aVendor[1],'QUOTE','PR','UNAPPROVE',$PRNumber,$id_pr,'1',$qry,'Quotation Unapproved','');
				 $this->addQuoteTransLog($aRequest,$aVendor[1],'UNAPPROVE',$qry, 'Quotation Unapproved');
	$this->oDb->query($qry_update_unapprove);
	$qry_update = "UPDATE quote SET status=3, approved_by='".$id_approver."',approved_on=now() WHERE id_quote=".$aVendor[1];
	             //log 
				  $this->addHistoryTransLog($aRequest,$aVendor[1],'QUOTE','PR','APPROVE',$PRNumber,$id_pr,'1',$qry,'Quotation approved for this vendor','');
				 $this->addQuoteTransLog($aRequest,$aVendor[1],'APPROVE',$qry, 'Quotation approved for this vendor');
	$this->oDb->query($qry_update);
	if($this->oDb->query($qry))	{
	   $qry_update_status = "UPDATE quote SET status =12 WHERE id_vendor!='".$aVendor[0]."' AND status=!18 AND id_pr=".$id_pr;
	              //log 
				   $this->addHistoryTransLog($aRequest,$aVendor[1],'QUOTE','PR','FINALQUOTE',$PRNumber,$id_pr,'1',$qry,'Quotation approved for PR and close other vendor','');
				 $this->addQuoteTransLog($aRequest,$aVendor[1],'CLOSE',$qry, 'Quotation approved for PR and close oter vendor');
	   
		$this->oDb->query($qry_update_status);
			return $id_pr;
			}
			else{
			return $id_pr;
			}
			
}
public function getQuoteItemInfo($lookup, $type)
	{
	$qry = "SELECT * FROM quote_item WHERE status!=2 and ";
		   if($type == 'lookup') {
			 $condition = " lookup = '$lookup'";
		   }
		   else {
			 $condition = " id_pr_item = ".$lookup;
		   }
		   $qry = $qry.$condition;
		 $aQuoteItemInfo = array();
		   if($row = $this->oDb->get_row($qry))
		   {
				$aQuoteItemInfo['id_quote_item']   = $row->id_quote_item;
				$aQuoteItemInfo['id_quote']   = $row->id_quote;
				$aQuoteItemInfo['id_pr']   = $row->id_pr;
				$aQuoteItemInfo['id_pr_item']   = $row->id_pr_item;
				$aQuoteItemInfo['id_itemgroup1']   = $row->id_itemgroup1;
				$aQuoteItemInfo['id_itemgroup2']   = $row->id_itemgroup2;
				$aQuoteItemInfo['id_item']   = $row->id_item;
				$aQuoteItemInfo['unit_cost']   = $row->unit_cost;
				$aQuoteItemInfo['qty']   = $row->qty;
				$aQuoteItemInfo['id_uom']   = $row->id_uom;
				$aQuoteItemInfo['quote_unit_cost']   = $row->quote_unit_cost;
				$aQuoteItemInfo['quote_qty'] = $row->quote_qty;
				$aQuoteItemInfo['negotiated_unit_cost'] = $row->negotiated_unit_cost	;
				$aQuoteItemInfo['tax_percent'] = $row->tax_percent	;
				$aQuoteItemInfo['due_date'] = $row->due_date	;
				$aQuoteItemInfo['quote_due_date'] = $row->quote_due_date	;
				$aQuoteItemInfo['terms_conditions'] = $row->terms_conditions	;
				$aQuoteItemInfo['remarks'] = $row->remarks;
				$aQuoteItemInfo['status'] = $row->status;
				
		   }
		   return $aQuoteItemInfo;
	}
public function getQuotationApproval($lookup,$type = '')
{
 $qry = "SELECT * FROM quote_approval WHERE status != 2 and ";
		   if($type == 'id') {
			 $condition = " id_quote_approval = '$lookup'";
		   }
		   else {
			 $condition = " id_pr = ".$lookup;
		   }
		   $qry = $qry.$condition;
		 
		$aQuotationList = array();
		if($row = $this->oDb->get_row($qry))
		{
			$aQuotationList['id_quote_approval']   = $row->id_quote_approval;
			$aQuotationList['id_quote']  = $row->id_quote;	
			$aQuotationList['id_pr']   = $row->id_pr;
			$aQuotationList['id_vendor']  = $row->id_vendor;
			$aQuotationList['vendor_name']   = $this->getVendorName($row->id_vendor);	
			$aQuotationList['approved_by']  = $row->approved_by;	
			$aQuotationList['approved_on']  = $row->approved_on;
			$aQuotationList['status']  = $row->status;			
		}
		return $aQuotationList;
}
public function getPRNegoUnitPriceList($lookup,$prId)
{
 $qry = "SELECT * FROM quote_item WHERE id_quote='$lookup' AND id_pr='$prId'";
$aQuotationItemInfoList = array();
		if($result = $this->oDb->get_results($qry))
		{
		foreach($result as $row)
			{
			$aQuotationItemInfo = array();
		$aQuotationItemInfo['id_pr_item'] = $row->id_pr_item;
		$aQuotationItemInfo['unit_cost'] = $row->unit_cost;
		$aQuotationItemInfo['quote_unit_cost'] = $row->quote_unit_cost;
		$aQuotationItemInfo['negotiated_unit_cost'] = $row->negotiated_unit_cost;
		$aQuotationItemInfoList[] = $aQuotationItemInfo;
		}
		}
		return $aQuotationItemInfoList;
}
public function getPRNegoUnitPrice($ItemprId,$lookup,$prId)
{
$qry = "SELECT * FROM quote_item WHERE id_pr_item='$ItemprId' AND id_quote='$lookup' AND id_pr='$prId'";
$aQuotationItemInfo = array();
		if($row = $this->oDb->get_row($qry))
		{
		
		$aQuotationItemInfo['id_pr_item'] = $row->id_pr_item;
		$aQuotationItemInfo['unit_cost'] = $row->unit_cost;
		$aQuotationItemInfo['quote_unit_cost'] = $row->quote_unit_cost;
		$aQuotationItemInfo['negotiated_unit_cost'] = $row->negotiated_unit_cost;
			
		}
		return $aQuotationItemInfo;
}
public function checkPRBalancedQty($itemId)
{
	 $checkqry = "SELECT * FROM pr_item WHERE id_pr_item='$itemId'";
	 $row = $this->oDb->get_row($checkqry);
	 $qty = $row->balanced_qty;
	return $qty;
}
public function getPRQty($itemId)
{
	 $checkqry = "SELECT * FROM pr_item WHERE id_pr_item='$itemId'";
	 $row = $this->oDb->get_row($checkqry);
	 $qty = $row->qty;
	return $qty;
}
public function getBalancedQty($prid,$itemId)
{
	 $checkqry = "SELECT Max(id_po_order_qty),balanced_qty FROM po_order_qty WHERE id_pr='$prid' AND id_pr_item='$itemId'";
	 $row = $this->oDb->get_row($checkqry);
	 $qty = $row->balanced_qty;
	return $qty;
}
public function getTotalPoQty($prid,$pritemid)
{
	$checkqry = "SELECT SUM(po_qty) As qty FROM po_order_qty WHERE id_pr='$prid' AND id_pr_item='$pritemid' AND po_status != 2";
	$row = $this->oDb->get_row($checkqry);
	$qtys = $row->qty;
	if($qtys == 'NULL')
	{
	$qtys = 0;
	}
	
	return $qtys;
}
public function getTotalStoreDeliveryItem($asset_delivery_id)
{
	$checkqry = "SELECT COUNT(id_asset_delivery_item) AS count_item FROM asset_delivery_item WHERE id_asset_delivery='$asset_delivery_id' AND status=1";
	$row = $this->oDb->get_row($checkqry);
	$items = $row->count_item;
	if($items == 'NULL')
	{
	$items = 0;
	}
	
	return $items;
}
public function getDeliveryItemBillStatus($asset_delivery_id)
{
	$checkqry = "SELECT COUNT(id_asset_delivery_item) AS count_item FROM asset_delivery_item WHERE id_asset_delivery='$asset_delivery_id' AND bill_status!=1";
	$row = $this->oDb->get_row($checkqry);
	$items = $row->count_item;
	if($items == 'NULL')
	{
	$items = 0;
	}
	
	return $items;
}
public function CheckPOBalancedQty($prid,$pritemid)
{
$orderQty = $this->getPRQty($pritemid);
$totalPoQty = $this->getTotalPoQty($prid,$pritemid);
$balancedqty = $orderQty - $totalPoQty;
return $balancedqty;
}
public function getOrderedPOQty($prid,$pritemid)
{
   //returns the balance remaining quantity that is not ordered.
   $ordered_qty = 0;
   $qry = "SELECT sum(po_qty) AS ordered_qty FROM po_order_qty WHERE id_pr='$prid' AND id_pr_item='$pritemid' AND po_status != 2";
   if($row = $this->oDb->get_row($qry))
   {
      $ordered_qty = $row->ordered_qty;
	  if($ordered_qty == NULL)
	  {
	    $ordered_qty = 0;
	  }
   }
  
   return $ordered_qty;
}
public function checkQty($prid,$pritemid)
{
$orderqty = $this->getPRQty($pritemid);  //totalorder quantity - from pr.
$ordered_qty = $this->getOrderedPOQty($prid, $pritemid); //already ordered.
if($ordered_qty >=0)
  {
  $remainQty = $orderqty - $ordered_qty;
  }
 
  return  $remainQty;
}
public function addPoOrderQty($poid,$prid,$pritemid,$poqty,$status = '')
{
  
  $orderqty = $this->getPRQty($pritemid);  //totalorder quantity - from pr.
  $ordered_qty = $this->getOrderedPOQty($prid, $pritemid); //already ordered.
  if($ordered_qty > 0)
  {
  $remainQty = $orderqty - $ordered_qty;
  $balancedQty = $remainQty - $poqty;
  }
  else
  {
  $balancedQty = $orderqty - $poqty;
  }
 $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
$qry ="INSERT INTO po_order_qty(id_po_order_qty, id_po, id_pr, id_pr_item, order_qty, po_qty, balanced_qty, po_status, created_by, created_on) VALUES (NULL,'$poid','$prid','$pritemid','$orderqty','$poqty','$balancedQty','$status','$created_by',now())";
		if($this->oDb->query($qry))	{
			$done = 1;
			$qry_update_status = "UPDATE pr_item SET qty_received='".$poqty."',balanced_qty='".$balancedQty."' WHERE id_pr_item=".$pritemid;
			$this->oDb->query($qry_update_status);
			if($balancedQty == 0)
			{
			$qry_update_status = "UPDATE pr_item SET status=9 WHERE id_pr_item=".$pritemid;
			$this->oDb->query($qry_update_status);
			}
			
			}
			else{
			  $done = 0;
			   echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			}
			return $done;
}
	 public function getDivisionDeliveryList($lookup, $type)  //lookup may be 'id' or 'Lookup text'
	{
	 
	   
	   $qry = "SELECT * FROM transaction WHERE status!=2 ";
	   if($type == 'transaction') {
	   	 $condition = " and transaction_type = '$lookup' ";
	   }
	   else {
	     $condition = " and id_transaction = ".$lookup;
	   }
	   $order = " order by transaction_date DESC" ;
	 $qry = $qry.$condition.$order;
	 
	 $aDeliveryItemList = array();
	 	 			
	   if($result = $this->oDb->get_results($qry))
	   {
	            foreach($result as $row)
				{
				$aDeliveryItem= array();
				$aDeliveryItem['id_transaction']   = $row->id_transaction;
				$aDeliveryItem['from_store']   = $row->from_store;
				$aDeliveryItem['to_store']   = $row->to_store;
				$aDeliveryItem['from_division']   = $row->from_division;
				$aDeliveryItem['to_division']   = $row->to_division;
				$aDeliveryItem['from_unit']   = $row->from_unit;
				$aDeliveryItem['to_unit']   = $row->to_unit;
			   $aDeliveryItem['transaction_type']   = $row->transaction_type;
			    $aDeliveryItem['id_vendor']   = $row->id_vendor;
			   	$aDeliveryItem['id_asset_item']   = $row->id_asset_item;
				$aDeliveryItem['asset_no']   = $row->asset_no;
				$aDeliveryItem['qty']   = $row->qty;
				$aDeliveryItem['id_itemgroup1']   = $row->id_itemgroup1;
				$aDeliveryItem['id_itemgroup2']   = $row->id_itemgroup2;
				$aDeliveryItem['id_item']   = $row->id_item;
				
				$aDeliveryItem['remarks']   = $row->remarks;
				$aDeliveryItem['transaction_date']   = $row->transaction_date;
				
				$aDeliveryItem['id_uom']   = $row->id_uom;
				$aUom = $this->getUomInfo($row->id_uom,'id');
				$aDeliveryItem['uom_name']       = $aUom['lookup'];
				$aDeliveryItem['received_by']   = $row->received_by;
				$aEmployeeInfo = $this->getEmployeeInfo($row->received_by);
				$aDeliveryItem['employee_name']     = $aEmployeeInfo['employee_name'];
				
				$aItem = $this->getItemInfo($row->id_item,'id');
				$aDeliveryItem['item_name']       = $aItem['item_name'];
				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');
				$aDeliveryItem['itemgroup1_name']       = $aGroup1['itemgroup1_name'];
				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');
				$aDeliveryItem['itemgroup2_name']       = $aGroup2['itemgroup2_name'];
				$aFromStoreInfo = $this->getStoreInfo($row->from_store,'id');
			   $aDeliveryItem['from_store_name']   = $aFromStoreInfo['store_name'];
			   $aToStoreInfo = $this->getStoreInfo($row->to_store,'id');
			   $aDeliveryItem['to_store_name']   = $aToStoreInfo['store_name'];
			   $ToDivisionInfo = $this->getDivisionInfo($row->to_division,'id');
			   $aDeliveryItem['to_division_name']   = $ToDivisionInfo['division_name'];
			    $FromDivisionInfo = $this->getDivisionInfo($row->to_division,'id');
			   $aDeliveryItem['from_division_name']   = $FromDivisionInfo['from_division'];
				$aDeliveryItem['status']   = $row->status;	
				$aDeliveryItemList[] =  $aDeliveryItem;
				
				}
	   }
	   
	 
	   return $aDeliveryItemList;
	   
	}
	
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	   //Transaction Quote
	   
public function addQuoteTransLog($aRequest,$id_quote, $action, $SQLquery = '', $remarks = '') 
{
  $SQLquery = mysql_escape_string(serialize($SQLquery));
  $action_name =$this->_aQuote[$action];
  $request = mysql_escape_string(serialize($aRequest));
	  $qry = " INSERT INTO transaction_quote(id_trans_quote, id_quote, id_vendor, action_by, action_name, action_date, remarks, db_query,request_arr, status) VALUES(null,'".$id_quote."','".$aRequest['fVendorId']."', '".$_SESSION['sesCustomerInfo']['user_id']."', '$action_name', now(),'$remarks', '$SQLquery','$request','1') ";
	  if($this->oDb->query($qry ))
	  {
		 
	  }
  
} 
//////////////////////////////////////////////////////////////////////////////////////////////////////
	   //Transaction PR Item
	   
public function addPRItemTransLog($aRequest,$action,$id_pr,$id_pr_item,$SQLquery = '', $remarks = '',$Error_log = '') 
{
  $SQLquery = mysql_escape_string(serialize($SQLquery));
  $request = mysql_escape_string(serialize($aRequest));
  $Error_log = mysql_escape_string(serialize($Error_log));
	  $qry = " INSERT INTO transaction_pr_item(id_transaction_pr_item, id_pr, id_pr_item, action_by, action_date, action_name, remarks, db_query, request_arr,error_log, status) VALUES(null,'".$id_pr."','".$id_pr_item."', '".$_SESSION['sesCustomerInfo']['user_id']."', now(),'$action', '$remarks', '$SQLquery','$request','$Error_log','1') ";
	 $this->oDb->query($qry);
	  
  
} 
//////////////////////////////////////////////////////////////////////////////////////////////////////
	   //Transaction PO Item
	   
public function addPOItemTransLog($aRequest,$action,$id_po,$id_pr,$id_po_item,$SQLquery = '', $remarks = '',$Error_log = '') 
{
  $SQLquery = mysql_escape_string(serialize($SQLquery));
  $request = mysql_escape_string(serialize($aRequest));
  $Error_log = mysql_escape_string(serialize($Error_log));
	  $qry = " INSERT INTO transaction_po_item(id_transaction_po_item,id_po,id_pr, id_po_item, action_by, action_date, action_name, remarks, db_query, request_arr,error_log, status) VALUES(null,'".$id_po."','".$id_pr."','".$id_po_item."', '".$_SESSION['sesCustomerInfo']['user_id']."', now(),'$action', '$remarks', '$SQLquery','$request','$Error_log','1') ";
 $this->oDb->query($qry);
	  
  
} 
//////////////////////////////////////////////////////////////////////////////////////////////////////
	   //Transaction GRN Item
	   
public function addGRNItemTransLog($aRequest,$action,$id_grn,$id_grn_item,$id_po,$id_pr,$id_po_item,$SQLquery = '', $remarks = '',$Error_log = '') 
{
  $SQLquery = mysql_escape_string(serialize($SQLquery));
  $request = mysql_escape_string(serialize($aRequest));
  $Error_log = mysql_escape_string(serialize($Error_log));
	  $qry = "INSERT INTO transaction_grn_item(id_transaction_grn_item,id_grn,id_inventory_item,id_po,id_pr, id_po_item, action_by, action_date, action_name, remarks, db_query, request_arr,error_log, status) VALUES(null,'".$id_grn."','".$id_grn_item."','".$id_po."','".$id_pr."','".$id_po_item."', '".$_SESSION['sesCustomerInfo']['user_id']."', now(),'$action', '$remarks', '$SQLquery','$request','$Error_log','1') ";
 $this->oDb->query($qry);
	  
  
} 
public function addAssetTransLog($aRequest,$action,$assetid,$fromasset,$from_ref,$toasset,$toref,$id_grn,$id_grn_item,$SQLquery = '', $remarks = '',$Error_log = '') 
{
  $SQLquery = mysql_escape_string(serialize($SQLquery));
  $request = mysql_escape_string(serialize($aRequest));
  $Error_log = mysql_escape_string(serialize($Error_log));
	   $qry = "INSERT INTO transaction_asset(id_transaction_asset, id_asset_item, id_grn, id_inventory_item, from_location, from_ref_table, to_location, to_ref_table, action_name, action_by, action_date, remarks, db_query, request_arr, error_log) VALUES(null,'".$assetid."','".$id_grn."','".$id_grn_item."','".$fromasset."','".$from_ref."','".$toasset."','".$toref."','".$action."', '".$_SESSION['sesCustomerInfo']['user_id']."', now(),'$remarks', '$SQLquery','$request','$Error_log') ";
	
 $this->oDb->query($qry);
  
} 
//////////////////////////////////////////////////////////////////////////////////////////////////////
	   //Transaction History
	   
public function addHistoryTransLog($aRequest,$refer_number,$refer_table,$trans_head,$action,$trans_number,$trans_id,$trans_status,$SQLquery = '', $remarks = '',$Error_log = '') 
{
  $SQLquery = mysql_escape_string(serialize($SQLquery));
  $request = mysql_escape_string(serialize($aRequest));
  $Error_log = mysql_escape_string(serialize($Error_log));
 $qry ="INSERT INTO history(id_history, id_refer_history,refer_table,trans_head, trans_type, trans_head_number, id_trans_head, trans_description, trans_status, sql_query, request_params, error_log,ip_address, created_by, created_on) VALUES (NULL,'".$refer_number."','".$refer_table."','".$trans_head."','".$action."','".$trans_number."','".$trans_id."','".$remarks."','".$trans_status."','".$SQLquery."','".$request."','".$Error_log."','".$_SERVER['REMOTE_ADDR']."','".$_SESSION['sesCustomerInfo']['user_id']."', now())";
	  
	 $this->oDb->query($qry);
	  
  
} 
///////////////////////////////////////////////////////////////////////////////////////////////////////////
//SERVICE 
public function getServiceInfo($lookup,$type)
{
	  $qry = "SELECT * FROM service WHERE status != 2";
	   if($type == 'asset') {
	   	 $condition = "  and id_asset_item = '$lookup'";
	   }
	   else {
	     $condition = " and id_service = ".$lookup;
	   }
	   $qry = $qry.$condition;
	    $aServiceInfo = array();
	   if($row = $this->oDb->get_row($qry ))
	     {
			
				$aServiceInfo['id_itemgroup1']   = $row->id_itemgroup1;
				$aServiceInfo['id_itemgroup2']   = $row->id_itemgroup2;
				$aServiceInfo['id_item']   = $row->id_item;
				$aServiceInfo['id_vendor']   = $row->id_vendor;
				$aServiceInfo['vendor_name']   =$this->getVendorName($row->id_vendor);
				$aServiceInfo['id_service']   = $row->id_service;
				$aServiceInfo['service_no']   = $row->service_no;
				$aServiceInfo['id_asset_item']   = $row->id_asset_item;
				$aServiceInfo['mileage_at_service']   = $row->mileage_at_service;
				$aServiceInfo['mileage_after_service']   = $row->mileage_after_service;
				$aServiceInfo['service_date']   = $row->service_date;
				$aServiceInfo['service_return_date']   = $row->service_return_date;
				$aServiceInfo['bill_number']   = $row->bill_number;
				$aServiceInfo['bill_date']   = $row->bill_date;
				$aServiceInfo['bill_amount']   = $row->bill_amount;
				$aServiceInfo['idledays']   = $row->idledays;
				$aServiceInfo['service_type']   = $row->service_type;
				$aServiceInfo['next_service_date']   = $row->next_service_date;
				$aServiceInfo['next_service_mileage']   = $row->next_service_mileage;
				$aServiceInfo['status']   = $row->status;
				$aServiceInfo['asset_no']   =$this->getAssetNumber( $row->id_asset_item );
				$aServiceInfo['itemgroup1_name']   =$this->getItemGroup1Name($row->id_itemgroup1);
			    $aServiceInfo['itemgroup2_name'] = $this->getItemGroup2Name($row->id_itemgroup2);
			    $aServiceInfo['item_name']    =$this->getItemName($row->id_item);
				$aServiceInfo['machine_no']   =strtoupper($this->getMachineNumber( $row->id_asset_item ));
	     }
		 return $aServiceInfo;
}
  
public function getServiceList()
{
$qry = "SELECT * FROM service WHERE status != 2";
		$aServiceList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aService = array();
				$aService['id_itemgroup1']   = $row->id_itemgroup1;
				$aService['id_itemgroup2']   = $row->id_itemgroup2;
				$aService['id_item']   = $row->id_item;
				$aService['id_vendor']   = $row->id_vendor;
				$aService['vendor_name']   =$this->getVendorName($row->id_vendor);
				$aService['id_service']   = $row->id_service;
				$aService['service_no']   = $row->service_no;
				$aService['id_asset_item']   = $row->id_asset_item;
				$aService['mileage_at_service']   = $row->mileage_at_service;
				$aService['mileage_after_service']   = $row->mileage_after_service;
				$aService['service_date']   = $row->service_date;
				$aService['service_return_date']   = $row->service_return_date;
				$aService['bill_number']   = $row->bill_number;
				$aService['bill_date']   = $row->bill_date;
				$aService['bill_amount']   = $row->bill_amount;
				$aService['idledays']   = $row->idledays;
				$aService['service_type']   = $row->service_type;
				$aService['next_service_date']   = $row->next_service_date;
				$aService['next_service_mileage']   = $row->next_service_mileage;
				$aService['status']   = $row->status;
				$aService['asset_no']   =$this->getAssetNumber( $row->id_asset_item );
				$aService['itemgroup1_name']   =$this->getItemGroup1Name($row->id_itemgroup1);
			    $aService['itemgroup2_name'] = $this->getItemGroup2Name($row->id_itemgroup2);
			    $aService['item_name']    =$this->getItemName($row->id_item);
				$aService['machine_no']   =strtoupper($this->getMachineNumber( $row->id_asset_item ));
				
				$aServiceList[]               = $aService;
			}
		}
		return $aServiceList;
}
public function addService($aRequest)
{
		$item_group1 = $aRequest['fGroup1'];
		$item_group2 = $aRequest['fItemGroup2'];
		$itemname = $aRequest['fItemName'];
		$id_vendor = $aRequest['fVendorId'];
		$mileage_at_service = $aRequest['fMileageAtService'];
		$service_date = $aRequest['fServiceDate'];
		$service_return_date = $aRequest['fServiceReturnDate'];
		if($service_date !='')
		{
		$service_date = date('Y-m-d',strtotime($aRequest['fServiceDate']));
		}
		if($service_return_date !='')
		{
		$service_return_date = date('Y-m-d',strtotime($aRequest['fServiceReturnDate']));
		}
		$items = explode('/',$itemname);
		$id_item = $items[1];
		$id_asset_item = $items[0];
	 $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
	 
	$aAssetInfo = $this->getAssetStoreInfo($id_asset_item);
	$id_store = $aAssetInfo['id_store'];
	$id_unit = $aAssetInfo['id_unit'];
	$id_division = $aAssetInfo['id_division'];
	$delivery_type = 'SER';
		 $aService_no = $this->ServiceCount();
		 $acompany = $this->getCompanyInfo('1','id');
		 $Service_Number = $acompany['lookup'].'-'.'SER'.$aService_no['count'];
$qry = "INSERT INTO service(id_service, service_no, id_itemgroup1, id_itemgroup2, id_item,id_vendor, id_asset_item, mileage_at_service, mileage_after_service, service_date, service_return_date, bill_number, bill_date, bill_amount, idledays, service_type, next_service_date, next_service_mileage, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$Service_Number','$item_group1','$item_group2','$id_item','$id_vendor','$id_asset_item','$mileage_at_service','','$service_date','$service_return_date','','','','','','','','$created_by',now(),'','','1')";
 if($this->oDb->query($qry ))
	  {
		
		 $tran_qry = " INSERT INTO transaction(id_transaction, from_store, to_store, from_division, to_division, from_unit, to_unit,transaction_type,id_vendor, id_asset_item, id_itemgroup1, id_itemgroup2, id_item, asset_no, qty,id_uom, remarks, transaction_date, created_by,received_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$id_store','','$id_division','','$id_unit','','$delivery_type','$id_vendor','$id_asset_item','$item_group1','$item_group2','$id_item ','','1','','go to service',now(),'$created_by ','',now(),'','','1') ";
		if($this->oDb->query($tran_qry))
		{
		$done = 1;
		}
		else
		{
		$done = 0;
		}			
			
	 $update_qry = "UPDATE asset_stock SET status=19 WHERE id_asset_item = '$id_asset_item'";	
		if($this->oDb->query($update_qry))
		{
		$done = 1;
		}
		else
		{
		$done = 0;
		}  
		
		return true; 
	  }
	  else
	  {
	  return false; 
	  }
  
}
public function updateService($aRequest)
{
	$id_service = $aRequest['fServiceId'];
	$service_type = $aRequest['fServiceType'];
	$payment_type = $aRequest['fPaymentType'];
	$bill_no = $aRequest['fBillNumber'];
	$bill_amount = $aRequest['fBillAmount'];
	$OMR = $aRequest['fOMR'];
	$next_mileage_service = $aRequest['fNextServiceMileage'];
	$next_service_date = $aRequest['fNextServiceDate'];
	$bill_date = $aRequest['fBillDate'];
	
	if($bill_date !='')
		{
		$bill_date = date('Y-m-d',strtotime($aRequest['fBillDate']));
		}
		
	if($next_service_date !='')
		{
		$next_service_date = date('Y-m-d',strtotime($aRequest['fNextServiceDate']));
		}
	$service_return_date = $aRequest['fServiceReturnDate'];	
		if($service_return_date !='')
		{
		$service_return_date = date('Y-m-d',strtotime($aRequest['fServiceReturnDate']));
		}
$remarks = $aRequest['fRemark'];
 $mileage_at_service = $this->getServiceMileage($id_service);
 $id_asset_item = $this->getAssetItemNumber($id_service);
  $trip_check = $this->checkServiceId($id_service);
   
		if($trip_check > 0)
		{
		   $trip_qry = " UPDATE trip SET id_asset_item='".$id_asset_item."',omr='".$mileage_at_service."',cmr='".$OMR."' WHERE id_service='".$id_service."'";
		
		}
		else
		{
			 $trip_qry = "INSERT INTO trip(id_trip, omr, cmr,id_asset_item,id_service,remarks,created_by, created_on) VALUES (NULL,'$mileage_at_service','$OMR','$id_asset_item','$id_service','Service','$created_by',now())";
		
		}
		
	 $qry = "UPDATE service SET mileage_after_service='".$OMR."',service_return_date='".$service_return_date."',bill_number='".$bill_no."',bill_date='".$bill_date."',bill_amount='".$bill_amount."',service_type='".$service_type."',next_service_date='".$next_service_date."',next_service_mileage='".$next_mileage_service."' WHERE id_service='".$id_service."'";
		
		if($this->oDb->query($qry))
		{
		  	$this->oDb->query($trip_qry);  
			 $update_qry = "UPDATE asset_stock SET status=1 WHERE id_asset_item = '$id_asset_item'";	
			 $this->oDb->query($update_qry);
			 $trans_qry = "UPDATE transaction SET status='12',modified_by='".$updated_by."',modified_on=now() WHERE id_asset_item=".$id_asset_item;
			 $this->oDb->query($trans_qry);	  
	        return true;
		}
		else
		{
		 return false;
		} 
			
	
	  
 
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//General
public function getAssetNumber($lookup)
{
$qry = "SELECT asset_no FROM asset_item WHERE id_asset_item='$lookup'";
	 	 			
	   if($row = $this->oDb->get_row($qry))
	   {
	      $aAsssetNumber = $row->asset_no;
		 
	   }
	   return $aAsssetNumber;
}
public function getStoreName($lookup)
{
$qry = "SELECT store_name FROM store WHERE id_store='$lookup'";
	 	 			
	   if($row = $this->oDb->get_row($qry))
	   {
	      $StoreName= $row->store_name;
		 
	   }
	   return $StoreName;
}
public function getMachineNumber($lookup)
{
$qry = "SELECT machine_no FROM asset_item WHERE id_asset_item='$lookup'";
	 	 			
	   if($row = $this->oDb->get_row($qry))
	   {
	      $aAsssetNumber = strtoupper($row->machine_no);
		 
	   }
	   return $aAsssetNumber;
}
public function getAssetStoreInfo($lookup)
{
$qry = "SELECT id_store,id_unit,id_division FROM asset_stock WHERE id_asset_item='$lookup'";
 $aAsssetInfo = array();
	 	 			
	   if($row = $this->oDb->get_row($qry))
	   {
	      $aAsssetInfo['id_store'] = $row->id_store;
		  $aAsssetInfo['id_unit'] = $row->id_unit;
		  $aAsssetInfo['id_division'] = $row->id_division;
	   }
	   return $aAsssetInfo;
}
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
	public function getServiceMileage($lookup)
	{
	$qry = "SELECT mileage_at_service FROM service WHERE id_service =".$lookup;
	if($row = $this->oDb->get_row($qry ))
	{
	 $mileage = $row->mileage_at_service;
	 
	}
	return $mileage;
	}
	public function getAssetItemNumber($lookup)
	{
	$qry = "SELECT id_asset_item FROM service WHERE id_service =".$lookup;
	if($row = $this->oDb->get_row($qry ))
	{
	 $iditem = $row->id_asset_item;
	 
	}
	return $iditem;
	}
	public function checkServiceId($lookup)
	{
	 $checkqry = "SELECT * FROM trip WHERE id_service='$lookup'";
	 $this->oDb->query($checkqry);
	 $num_rows = $this->oDb->num_rows;
		return  $num_rows ; 
	}
	public function getTripCMR($lookup)
	{
	 $qry = "SELECT Max(cmr) as cmr FROM trip WHERE id_asset_item =".$lookup;
	
	if($row = $this->oDb->get_row($qry ))
	{
	 $cmr = $row->cmr;
	 
	}
	return $cmr;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Insurance
	
	public function addInsurance($aRequest,$files)
	{
	  
	   
	   if($aRequest['fMultiple'] == 'yes')
	   {
		$asset_no = unserialize($aRequest['fAssetNumber']); 
		
	   }
	   else
	   {
		  $asset_no = $aRequest['fAssetNumber'];
	   }
	/*  echo '<pre>';
	  print_r($files);
	   print_r($aRequest);
	  exit();*/
	  
		   
	  $insurance_title = $aRequest['fInsuranceTitle'];
	  $insurance_reference_number = $aRequest['fInsuranceReferenceNo'];
	  $insurance_ordervalue = $aRequest['fInsuranceOrderValue'];
	  $insurance_value = $aRequest['fInsuranceValue'];
	  	$id_vendor = $aRequest['fVendorId'];
	  $insurance_date = date('Y-m-d H:i:s',strtotime($aRequest['fInsuranceDate']));
		$remark = $aRequest['fRemark'];
		$insurance_type = $aRequest['fContractType'];
		$insurance_start_date = date('Y-m-d H:i:s',strtotime($aRequest['fInsuranceStartDate']));
		$insurance_end_date = date('Y-m-d H:i:s',strtotime($aRequest['fInsuranceEndDate']));
		$renewal_insurance_date = date('Y-m-d H:i:s',strtotime($aRequest['fInsuranceRenewalDate']));
		 $vendor_contact = $aRequest['fVendorContactId'];
		$terms = $aRequest['fTerms'];
				 $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		$qry = "
		INSERT INTO insurance(id_insurance, id_vendor, policy_amount, premium_amount, insurance_policy_name, reference,ins_start_date, ins_end_date, remark, renewal_date,created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$id_vendor','$insurance_ordervalue','$insurance_value',' $insurance_title','$insurance_reference_number','$insurance_start_date','$insurance_end_date','$remark','$renewal_insurance_date',' $created_by ',now(),'','','1')
		";
		  
			if($this->oDb->query($qry))	{
			 $lastInsertId = $this->oDb->insert_id;
			 foreach($vendor_contact as $key => $value)
			 {
			 			 $contact_qry ="INSERT INTO insurance_contact (	id_insurance_contact, id_insurance, id_vendor_contact, status) VALUES (NULL,'$lastInsertId', '$value','1')";
			$this->oDb->query($contact_qry);
			 }
			 		$aAssetCount=count($asset_no);	
						
						if($aRequest['fMultiple'] == 'yes')
	                        {
							
						for($i=0;$i<=$aAssetCount-1;$i++)
						{	
					 $query_multiple = "INSERT INTO asset_insurance (id_asset_ins_map, id_asset,id_insurance,status) VALUES (NULL, '$asset_no[$i]', '$lastInsertId','1')";
						$this->oDb->query($query_multiple);
						}
						}
						
						else
						{
					
					$query_single= "INSERT INTO asset_insurance (id_asset_ins_map, id_asset,id_insurance,status) VALUES (NULL, '$asset_no', '$lastInsertId', '1')";
						$this->oDb->query($query_single);
						}
					
				 foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
					 if(!empty($_FILES['files']['name'][$key]))
					 {
					if($this->multiUploadDocumentInsurance($aRequest,$lastInsertId,$files))
							{
							
							$done = 1;
							}
									
					 }
				 }
				 $done = 1;
			}
			
			else{
			  $done = 0;
			
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			 
			}
		
		
		   if($done == 1)
		   {
			   return  true;
		   }
		   else
		   {
			     return false;
				 
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			
		   }
		
	}
	
	public function multiUploadDocumentInsurance($aRequest,$insertId,$files)
	{
		
			
		  /* $ext = explode(".", $fileName);
		   $ext = array_pop($ext);
		   $name = strtotime(date('Y-m-d h:i:s'));
		   $newFileName = $name.'_asset.'.$ext;
		   $fileup = $files['fImage']['tmp_name']; //echo '<br>';
		   $targetPath 	= APP_ROOT."/uploads/assetimage/"; //echo '<br>';
		   $targetFileName = $lastInsertId.$newFileName; //echo '<br>';
		   move_uploaded_file($fileup, $targetPath.$targetFileName);*/
			 $created_by        = $_SESSION['sesCustomerInfo']['user_id'];	
		 if(isset($_FILES['files'])){
		 
    		$errors= array();
			foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
	   $name = strtotime(date('Y-m-d h:i:s'));
		$file_name = $name.'-'.$_FILES['files']['name'][$key];
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];	
        if($file_size > 60097152){
			$errors[]='File size must be less than 60 MB';
        	
		}
		
        $desired_dir="uploads/document";
        if(empty($errors)==true){
		
            
		if(is_dir($desired_dir)==false){
                mkdir("$desired_dir", 0700);		// Create directory if it does not exist
            }
            if(is_dir("$desired_dir/".$file_name)==false){
                move_uploaded_file($file_tmp,"uploads/document/".$file_name);
            }else{									//rename the file if another one exist
                $new_dir="uploads/document/".$file_name.time();
                 rename($file_tmp,$new_dir) ;				
            }
		if($_FILES['files']['name'][$key] !='')
		{
			 $query="INSERT INTO document(id_document ,document_name ,document_type ,status)
VALUES (NULL ,   '$file_name',  '$file_type', '1');";
		}
		 
			if($this->oDb->query($query))	{
				 $lastInsertId = $this->oDb->insert_id;
	
		$querys = "INSERT INTO insurance_doc (id_ins_doc, id_insurance, id_document,created_by,created_on,modified_by,modified_on,status) VALUES (NULL, '$insertId', '$lastInsertId','$created_by ',now(),'','','1')";
						$this->oDb->query($querys);
						$done = 1;
					}
					else
					{
					$done = 0;
					 if($DEBUGS !=0)
			  {
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  }
					}
				
		
            
				
        }else{
              /* print_r($errors);*/
			  	$done = 0;
				 if($DEBUGS !=0)
			  {
		  echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';
			  $this->oDb->debug();
			  echo '</font></div>';
			  }
        }
		
    }
	if(empty($error)){
		if($done = 1)
		{
			return true;
		}
		
	}
}
		
	}
	
	public function updateInsurance($aRequest,$files)
	{
	 $insurance_title = $aRequest['fInsuranceTitle'];
	  $insurance_reference_number = $aRequest['fInsuranceReferenceNo'];
	  $insurance_ordervalue = $aRequest['fInsuranceOrderValue'];
	  $insurance_value = $aRequest['fInsuranceValue'];
	  	$id_vendor = $aRequest['fVendorId'];
	  $insurance_date = date('Y-m-d H:i:s',strtotime($aRequest['fInsuranceDate']));
		$remark = $aRequest['fRemark'];
		$insurance_type = $aRequest['fContractType'];
		$insurance_start_date = date('Y-m-d H:i:s',strtotime($aRequest['fInsuranceStartDate']));
		$insurance_end_date = date('Y-m-d H:i:s',strtotime($aRequest['fInsuranceEndDate']));
		$renewal_insurance_date = date('Y-m-d H:i:s',strtotime($aRequest['fInsuranceRenewalDate']));
		 $vendor_contact = $aRequest['fVendorContactId'];
		$terms = $aRequest['fTerms'];
		$insuranceid = $aRequest['fInsuranceId'];
		$created_by        = $_SESSION['sesCustomerInfo']['user_id'];
		
		$sql = "UPDATE `insurance` SET `id_vendor`='".$id_vendor."',`policy_amount`='".$insurance_ordervalue."',`premium_amount`='".$insurance_value."',`insurance_policy_name`='".$insurance_title."',`reference`='".$insurance_reference_number."',`ins_start_date`='".$insurance_start_date."',`ins_end_date`='".$insurance_end_date."',`remark`='".$remark."',`renewal_date`='".$renewal_insurance_date."',`modified_by`='".$created_by."',`modified_on`=now() WHERE `id_insurance`='".$insuranceid."'";
		$this->oDb->query($sql);
		 foreach($vendor_contact as $key => $value)
			 {
					 $checkqry = "SELECT * FROM insurance_contact WHERE id_insurance='$insuranceid' AND id_vendor_contact='$value'";
					$this->oDb->query($checkqry);
					$num_rows = $this->oDb->num_rows;
					if($num_rows > 0)
					{
					 $contact_qry ="UPDATE insurance_contact SET id_insurance ='".$insuranceid."', id_vendor_contact='".$value."',status = '1'";
					 $this->oDb->query($contact_qry);
					}
					else
					{			 
						 $contact_qry ="INSERT INTO insurance_contact (	id_insurance_contact, id_insurance, id_vendor_contact, status) VALUES (NULL,'$insuranceid', '$value','1')";
					$this->oDb->query($contact_qry);
					}
			 }
			 foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
			 if(!empty($_FILES['files']['name'][$key]))
			 {
			 if($this->multiUploadDocumentInsurance($aRequest,$insuranceid,$files))
					{
					
					$done = true;
					}
					
					}
					}
			if( mysql_affected_rows() >= 0)
				{
				$done = true;
				
				}
				else
				{
				$done = false;
				}
		return 	$done;	
	}
	
	public function getAssetInsurance($lookup,$type )
	{
		$qry = "SELECT * FROM asset_insurance WHERE status=1 and ";
		   if($type == 'asset') {
			 $condition = " id_asset = '$lookup'";
		   }
		    else if($type == 'assetexist') {
			 $condition = " id_asset = '$lookup'";
		   }
		   else {
			 $condition = " id_insurance = ".$lookup;
		   }
		  $qry = $qry.$condition;
		  
		  if($type =='assetexist')
		  {
			  $valid = '0';
			 $result = $this->oDb->get_results($qry);
			 {
					  foreach($result as $row)
					 {
					 $id_insurance = $row->id_insurance;
					 $checkqry_ins = "SELECT ins_end_date, DATEDIFF( ins_end_date,now()) As days FROM insurance WHERE id_insurance='$id_insurance'";
							if($rows = $this->oDb->get_row($checkqry_ins))
							{
							 $days = $rows->days;
								 if($days > 0)
								 {
								 $valid = '1';
								 }
								 else
								 {
								  $valid = '0';
								 }
							}
						}
				}
			 return $valid ;
		  }
		 $aInsurance = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				$aInsurance['id_asset_ins_map']   = $row->id_asset_ins_map;
				$aInsurance['id_asset']   = $row->id_asset;
				$aInsurance['id_insurance']   = $row->id_insurance;
				$aContract['status']   = $row->status;
			
			}
			return $aInsurance;
		   }
	}
	
	
	public function getInsuranceInfo($lookup)
	{
		
		$qry1 = "SELECT * FROM asset_insurance WHERE status=1 and id_asset = ".$lookup;
		$aInsurance = array();
		   if($row = $this->oDb->get_row($qry1))
		   {
			$aInsurance['status'] = $row->status;
		 $qry = "SELECT * FROM insurance WHERE id_insurance = ".$row->id_insurance;
		   }
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
					$aInsurance['id_insurance']   = $row->id_insurance;
					$aInsurance['insurance_policy_name']   = $row->insurance_policy_name;
					$aInsurance['policy_amount']   = $row->policy_amount;
					$aInsurance['premium_amount']   = $row->premium_amount;
					$aInsurance['id_vendor']   = $row->id_vendor;
					$aInsurance['vendor_name']   = $this->getVendorName($row->id_vendor);
					$aInsurance['ins_start_date']   = $row->ins_start_date;
					$aInsurance['ins_end_date']   = $row->ins_end_date;
					$aInsurance['renewal_date']   = $row->renewal_date;
					$aInsurance['created_on']   = $row->created_on;
					$aInsurance['remarks']   = $row->remark;
					$aInsurance['reference']   = $row->reference;
				
			
			}
		   
			return $aInsurance;
		   }
	}
	public function getInsuranceVendorContact($lookup,$type)
	{
		$qry = "SELECT * FROM insurance_contact WHERE status!=2 and ";
		 if($type == 'insurance') {
			 $condition = " id_insurance = '$lookup'";
		   }
		  $qry = $qry.$condition;
		
		 $aInsuranceVendorContactList= array();
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				$aInsuranceVendorContact['id_insurance_contact']   = $row->id_insurance_contact;
				$aInsuranceVendorContact['id_insurance']   = $row->id_insurance;
				$aInsuranceVendorContact['id_vendor_contact']   = $row->id_vendor_contact;
				$aInsuranceVendorContact['status']   = $row->status;
				$aInsuranceVendorAddress=$this->getFullAddressFormat($row->id_vendor_contact,'','id');
				$aInsuranceVendorContact['vendor_address'] = $aInsuranceVendorAddress;
				$aInsuranceVendorContactList[] = $aInsuranceVendorContact;
			}
			return $aInsuranceVendorContactList;
		   }
	}
	
	public function getInsuranceDocument($lookup,$type )
	{
		$qry = "SELECT * FROM insurance_doc WHERE status!=2 and ";
		 if($type == 'id') {
			 $condition = " id_ins_doc = '$lookup'";
		   }
		   
		 $qry = $qry.$condition;
		  
		 $aInsuranceDocument = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				$aInsuranceDocument['id_ins_doc']   = $row->id_ins_doc;
				$aInsuranceDocument['id_insurance']   = $row->id_insurance;
				$aInsuranceDocument['id_document']   = $row->id_document;
				$aInsuranceDocument['status']   = $row->status;
			
			}
			return $aInsuranceDocument;
		   }
	}
	
	public function getInsuranceDocumentInfoList($lookup,$type )
	{
		$qry = "SELECT * FROM insurance_doc WHERE status!=2 and ";
		 if($type == 'insurance') {
			 $condition = " id_insurance = '$lookup'";
		   }
		   else
		   {
		    $condition = " id_ins_doc = '$lookup'";
		   }
			 $qry = $qry.$condition;

		 $aInsuranceDocumentList = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				 $aInsuranceDocument = array();
				$aInsuranceDocument['id_ins_doc']   = $row->id_ins_doc;
				$aInsuranceDocument['id_insurance']   = $row->id_insurance;
				$aInsuranceDocument['id_document']   = $row->id_document;
				$aInsuranceDocument['status']   = $row->status;
				$aInsurance_doc = $this->getContactDocumentInfo($row->id_document,'id');
				$aInsuranceDocument['id_document'] = $aInsurance_doc['id_document'];
				$aInsuranceDocument['document_name'] = $aInsurance_doc['document_name'];
				$aInsuranceDocument['document_type'] = $aInsurance_doc['document_type'];
				$aInsuranceDocument['doc_status'] = $aInsurance_doc['status'];
				$aInsuranceDocumentList[] = $aInsuranceDocument;
			}
			
			return $aInsuranceDocumentList;
		   }
	}
	
		public function getInsuranceInfoList($lookup)
	{
		 $qry = "SELECT * FROM asset_insurance WHERE status=1 and id_asset = ".$lookup;
		$aInsuranceList = array();
	
	
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
					$aInsurance = array();
					$aInsurance['id_insurance']   = $row->id_insurance;
					$aAssetContractDocument = $this->getInsuranceDocumentInfoList($row->id_insurance,'insurance');
					$aInsurance['insurance_doc_details']= $aAssetContractDocument;
					$aInsuranceList = $aInsurance;
			}
		   }
		
	
		return $aInsuranceList;
	}
	
	public function getMachineUnitPrice($inventoryitemid)
	{
	 $qry = "SELECT unit_cost FROM inventory_item WHERE status!=2 and  id_inventory_item = '$inventoryitemid'";
	
	  if($row = $this->oDb->get_row($qry ))
	{
	 $machine_price = $row->unit_cost;
	 
	}
	return $machine_price;
	}
	
/*	public function getContactDocumentInfo($lookup,$type )
	{
		$qry = "SELECT * FROM document WHERE status!=2 and ";
		 if($type == 'id') {
			 $condition = " id_document = '$lookup'";
		   }
		   
		  $qry = $qry.$condition;
		  
		 $aInsuranceDocumentInfo = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				$aInsuranceDocumentInfo['id_document']   = $row->id_document;
				$aInsuranceDocumentInfo['document_name']   = $row->document_name;
				$aInsuranceDocumentInfo['document_type']   = $row->document_type;
				$aInsuranceDocumentInfo['status']   = $row->status;
			
			}
			return $aInsuranceDocumentInfo;
		   }
	}
	*/
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Asset Inspection
public function getAssetInspectionInfo($lookup,$type)
{
 $qry = "SELECT * FROM asset_inspection WHERE status!=2";
if($type =='item')
{
 $condition = " AND id_inventory_item = '$lookup'";
}
else
{
 $condition = " AND id_asset_inspection = '$lookup'";
}
  $qry = $qry.$condition;
		 
		 $aAssetInspection = array();
		   if($row = $this->oDb->get_row($qry))
		   {
			  $aAssetInspection['id_asset_inspection'] = $row->id_asset_inspection;
			   $aAssetInspection['grn_no'] = $row->grn_no;
			    $aAssetInspection['id_inventory_item'] = $row->id_inventory_item;
				$aAssetInspection['id_employee'] = $row->id_employee;
				$aAssetInspection['inspectiondetails'] = $row->inspection_details;
				$aAssetInspection['remarks'] = $row->remarks;
				$aAssetInspection['status'] = $row->status;
			}
			return $aAssetInspection;
}	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
//Asset
	public function getAssetDetails($lookup, $type)
	{
		
		 $qry = "SELECT * FROM asset_item WHERE status!=2";
		   if($type == 'id') {
			 $condition = " AND id_asset_item = '$lookup'";
		   }
		   else if($type == 'grn') {
			 $condition = " AND id_grn = '$lookup'";
		   }
		   else {
			 $condition = " AND asset_no = ".$lookup;
		   }
		  $qry = $qry.$condition;
		 
		 $aAssetItemInfo = array();
		   if($result = $this->oDb->get_results($qry))
		   {
			   	 foreach($result as $row)
			{
				
				
				$aAssetItemInfo['id_asset_item']   = $row->id_asset_item;
				$aAssetItemInfo['id_asset_category']   = $row->id_asset_category;
				$aAssetItemInfo['id_asset_type']   = $row->id_asset_type;
				$aAssetItemInfo['asset_no']   = $row->asset_no;
				$aAssetItemInfo['id_grn']   = $row->id_grn;
				
				$aAssetItemInfo['id_po']   =$row->id_po;
				$aAssetItemInfo['id_inventory_item']   = $row->id_inventory_item;
				 $result_image =  $this->checkInventoryItem($row->id_inventory_item);
				if($result_image > 0)
				{
				$aAssetItems =$this->getAssetImage($row->id_inventory_item);
				$aAssetItemInfo['asset_image'] = $aAssetItems['image'];
				$aAssetItemInfo['id_image'] = $aAssetItems['id_image'];
				}
				else
				{
				$aAssetItems =$this->getAssetImage($row->id_asset_item,'assetid');
				$aAssetItemInfo['asset_image'] = $aAssetItems['image'];
				$aAssetItemInfo['id_image'] = $aAssetItems['id_image'];
				}
				
				
				$aAssetItemInfo['asset_name']   = $row->asset_name;
				$aAssetItemInfo['asset_amount']   = $row->asset_amount;
				$aInventoryIteminfo = $this->getInventoryItemInfo($row->id_inventory_item,'lookup');
				$aAssetItemInfo['inventory_item_reference']	= $aInventoryIteminfo['item_ref_number'];
				$aAssetItemInfo['id_itemgroup1']   = $row->id_itemgroup1;

				$aItemGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');

				$aAssetItemInfo['itemgroup2_name'] = $aItemGroup2['itemgroup2_name'];

				$aItemGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');

				$aAssetItemInfo['itemgroup1_name'] = $aItemGroup1['itemgroup1_name'];

				$aItem = $this->getItemInfo($row->asset_name,'id');

				$aAssetItemInfo['item_name'] = $aItem['item_name'];

				$aManufacturer = $this->getManufacturerInfo($row->id_manufacturer,'id');

				$aAssetItemInfo['manufacturer_name'] = $aManufacturer['manufacturer_name'];

				$aAssetItemInfo['id_itemgroup2']   = $row->id_itemgroup2;

				$aAssetItemInfo['quantity']   = $row->quantity;

				$aAssetItemInfo['id_uom']   = $row->id_uom;

				$aAssetItemInfo['id_vendor']   = $row->id_vendor;

				$aAssetItemInfo['id_manufacturer']   = $row->id_manufacturer;

				$aAssetItemInfo['id_unit']   = $row->id_unit;

				

				$aAssetItemInfo['ref_asset_no']   =$row->ref_asset_no;

				$aAssetItemInfo['date_of_install']   =$row->date_of_install;

				$aAssetItemInfo['depressation_percent']   = $row->depressation_percent;

				

				$aUnit = $this->getUnitInfo( $row->id_unit,'id');

				$aAssetItemInfo['unit_name'] = strtoupper($aUnit['unit_name']);

				$aAssetItemInfo['machine_no']   = strtoupper($row->machine_no);

				$aAssetItemInfo['machine_date']   = $row->machine_date;

				$aAssetItemInfo['warranty_start_date']   =$row->warranty_start_date;

				$aAssetItemInfo['warranty_end_date']   =$row->warranty_end_date;

				$aAssetItemInfo['machine_life']   = $row->machine_life;

				if($row->id_inventory_item > 0)

				{

				$aAssetItemInfo['machine_price'] = $this->getMachineUnitPrice($row->id_inventory_item);

				}

				else

				{

				$aAssetItemInfo['machine_price']   = $row->asset_amount;

				}

				

				

				$aAssetItemInfo['status']    = $row->status;

				$aStockInfo = $this->getAssetStock($row->id_asset_item,'asset');

				$aAssetItemInfo['store_name'] = $aStockInfo['store_name'];

				$aAssetItemInfo['PurchaseOrderinfo']= $this->getPurchaseOrderInfo($row->id_po);

				$aAssetItemInfo['purchaseOrderIteminfo']= $this->getPurchaseOrderItemInfoDetail($aAssetItemInfo['PurchaseOrderinfo']['id_po'],'');

				$aAssetItemInfo['PurchaseRequestinfo']= $this->getPurchaseRequestInfo($aAssetItemInfo['PurchaseOrderinfo']['id_pr']);

				$aAssetItemInfo['PurchaseRequestIteminfo']= $this->getPurchaseRequestItemInfo($aAssetItemInfo['PurchaseOrderinfo']['id_pr'],'id');

				$aAssetItemInfo['AssignVendorinfo']['vendorinfo']= $this->getAssignVendorToPrInfo($aAssetItemInfo['PurchaseOrderinfo']['id_pr'],'id');

				$aAssetItemInfo['AssignVendorinfo']['docinfo']=$this->getQuotationItemInfo($aAssetItemInfo['PurchaseOrderinfo']['id_pr'],'pr');

				$aAssetItemInfo['Inventoryinfo']= $this->getInventoryInfo($row->id_grn,'id');

				$aAssetItemInfo['InventoryinfoDoc']=$this->getInventoryDocumentInfo($row->id_grn,'');

				$aAssetItemInfo['InventoryIteminfo'] = $this->getPrintPurchaseGoodsInfoList($row->id_inventory_item,'lookup');

				$aAssetItemInfo['AssetInspectioninfo'] = $this->getAssetInspectionInfo($row->id_inventory_item,'item');

				$aAssetItemInfo['AssetMaintenanaceinfo'] = $this->getMaintenanceListInfo($row->id_asset_item);

					   }

		   }

		   return $aAssetItemInfo;

	}

	

	public function getQuotationDocument($prId,$vendorid)

	{

	 $qry = "

	   

	   SELECT

    quote_document.id_quote

    , quote_document.id_document

    , quote_document.id_quote_document

    , quote.id_pr

    , quote.po_number

    , quote.id_vendor

    , quote.id_division

    , quote.id_unit

    , quote.quote_number

    , quote.quote_date

    , quote.quote_amount

    , quote.quote_amount

	 , quote.remarks

    , quote.quote_valid_date

    , quote.status

    , document.document_name

    , document.document_type

    , document.status As doc_status

	, quote.status

FROM

     quote

    INNER JOIN quote_document 

        ON (quote.id_quote = quote_document.id_quote)

    INNER JOIN document 

        ON (quote_document.id_document = document.id_document)

WHERE   quote.id_pr='$prId' AND quote.id_vendor = '$vendorid'

	      ";

		  $order = "  order by id_quote DESC";

		   $qry = $qry.$condition.$order;

	

		   $aQutation = array();

		   if($row = $this->oDb->get_row($qry))

		   {

				

				$document = $row->document_name;

				

				}

			return  $document;	

		

		

	}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



public function getPurchaseReturnItemList($lookup,$type)

{

$qry = "SELECT * FROM inventory_item WHERE inspection_status=4 and ";

		   if($type == 'lookup') {

			 $condition = " id_inventory_item = '$lookup'";

		   }

		   else {

			 $condition = " id_grn= ".$lookup;

		   }

		$qry = $qry.$condition;

		

		$aInventoryItemInfoList = array();

		$aInventoryDetail = array();	  

		   if($result = $this->oDb->get_results($qry))

		   {

			foreach($result as $row)

			{

				$aInventoryItemInfo = array();

				

				$aInventoryDetail['id_po']   = $row->id_po;

				$aInventoryDetail['id_grn']   = $row->id_grn;

				$aInventoryDetail['id_vendor']   = $row->id_vendor;

				$aPurchaseOrderInfo= $this->getPurchaseOrderInfo($row->id_po);

				$aInventoryDetail['po_number']   = $aPurchaseOrderInfo['po_number'];

				$aInventoryDetail['vendor_name']   = $this->getVendorName($row->id_vendor);

				

				

				$aInventoryItemInfo['id_inventory_item']   = $row->id_inventory_item;

				$aInventoryItemInfo['id_itemgroup1']   = $row->id_itemgroup1;

				$aInventoryItemInfo['id_itemgroup2']   = $row->id_itemgroup2;

				$aInventoryItemInfo['id_item']   = $row->id_item;

				$aInventoryItemInfo['unit_cost']   = $row->unit_cost;

				$aInventoryItemInfo['qty']   = $row->qty;

				$aInventoryItemInfo['id_uom']   = $row->id_uom;

				$aInventoryItemInfo['id_manufacturer']   = $row->id_manufacturer;

				$aInventoryItemInfo['due_date']   = $row->due_date;

				$aInventoryItemInfo['remark']   = $row->remark;

				$aInventoryItemInfo['status']   = $row->status;

							

				$aUom = $this->getUomInfo($row->id_uom,'id');

				$aInventoryItemInfo['uom_name']       = $aUom['lookup'];

				

				$aItem = $this->getItemInfo($row->id_item,'id');

				$aInventoryItemInfo['item_name']       = $aItem['item_name'];

				

				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');

				$aInventoryItemInfo['itemgroup1_name']       = $aGroup1['itemgroup1_name'];

				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');

				$aInventoryItemInfo['itemgroup2_name']       = $aGroup2['itemgroup2_name'];

				$aInventoryItemInfo['status']   = $row->status;

				$aInventoryItemInfo['inspection_status']   = $row->inspection_status;

				$aInventoryItemInfo['asset_status']   = $row->asset_status;

				$aInventoryItemInfoList['iteminfo'][] = $aInventoryItemInfo;

			}

			$aInventoryItemInfoList['inventoryinfo'] = $aInventoryDetail;

		   }

		   return $aInventoryItemInfoList;

	  }



public function addPurchaseReturn($aRequest)

{



$id_po = $aRequest['fPoId'];

$id_vendor = $aRequest['fVendorId'];

$id_grn = $aRequest['fGrnId'];

$id_sender = $aRequest['fSenderEmployeeId'];

$remarks = $aRequest['fRemarks'];

$id_group1 = $aRequest['fGroup1'];

$id_group2 = $aRequest['fGroup2'];

$id_item = $aRequest['fItem'];

$purchased_qty = $aRequest['fPurchasedqty'];

$return_qty = $aRequest['fReturnQty'];

$id_pr =  $this->getPurchaseRequestNumber($aRequest['fPoId']);

 $created_by        = $_SESSION['sesCustomerInfo']['user_id'];

 $aOrder_no = $this->purchaseReturnCount();

		 $acompany = $this->getCompanyInfo('1','id');

		 $purchase_retutn_Number = $acompany['lookup'].'-'.'RTN'.$aOrder_no['count'];

 $qry = "

		INSERT INTO purchase_return(id_purchase_return,rtn_number,id_po, id_vendor, id_pr, id_grn, remarks, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$purchase_retutn_Number','$id_po','$id_vendor','$id_pr','$id_grn','$remarks','$created_by',now(),'','','1')

		 ";

		$update_qry = "UPDATE purchase_order SET return_status=1 WHERE id_po='$id_po'";

		$this->oDb->query($update_qry);

			if($this->oDb->query($qry))	{

			  $lastInsertId = $this->oDb->insert_id;

			   if($this->addPurchaseReturnItem($aRequest,$lastInsertId))

			   {

				   $done = 1;

				}

				else

				{

				   $done = 0;

				 				 

				} 

				 $done = 1;

	//			 return true;

			}

		

			if($done ==1)

				{

				   return true;

				}

				else

				{

				    return false;

				}



}



public function addPurchaseReturnItem ($aRequest,$lastInsertId)

{



$id_po = $aRequest['fPoId'];

$id_vendor = $aRequest['fVendorId'];

$id_grn = $aRequest['fGrnId'];

$id_sender = $aRequest['fSenderEmployeeId'];

$remarks = $aRequest['fRemarks'];

$id_group1 = $aRequest['fGroup1'];

$id_group2 = $aRequest['fGroup2'];

$id_item = $aRequest['fItem'];

$purchased_qty = $aRequest['fPurchasedqty'];

$return_qty = $aRequest['fReturnQty'];

$id_pr =  $this->getPurchaseRequestNumber($aRequest['fPoId']);

 $created_by        = $_SESSION['sesCustomerInfo']['user_id'];

 $unitprice = $aRequest['fUnitPrice'];

 $uom = $aRequest['fUom'];

 $id_inventory_item = $aRequest['fInventoryItemId'];

$aInsertvalues_pr = array_map(null,$id_group1,$id_group2,$id_item,$purchased_qty,$uom,$unitprice,$return_qty,$id_inventory_item);

		

		foreach($aInsertvalues_pr as $items)

			 {

 $qry ="

			INSERT INTO purchase_return_item(id_purchase_return_item, id_po, id_pr, id_grn, id_inventory_item,id_purchase_return, id_itemgroup1, id_itemgroup2, id_item, qty, id_uom, unit_price, return_qty, sender_id, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$id_po', '$id_pr' , '$id_grn' ,'$items[7]','$lastInsertId', '$items[0]' , '$items[1]' ,'$items[2]' , '$items[3]' ,'$items[4]' ,'$items[5]','$items[6]' ,'$id_sender' ,'$created_by' ,now(),' ' ,' ' ,'1' )";

		

		$balanced_qty = (intval($items[3]) - intval($items[6]));

		$update_qry = "UPDATE inventory_item SET balanced_qty='$balanced_qty',return_qty='$items[6]',return_status='1' WHERE id_inventory_item='$items[7]'";

		$this->oDb->query($update_qry);

		if($this->oDb->query($qry))	{

			

			$done = 1;

			}

			else{

				  $done = 0;

				 

			   $this->oDb->debug();

			 

			}

			}



}



public function getPurchaseReturnItemInfo($lookup, $type)

	{

	$qry = "SELECT * FROM purchase_return_item WHERE status != 2 and ";

		   if($type == 'lookup') {

			 $condition = " lookup = '$lookup'";

		   }

		   else if($type== 'status'){

			 $condition = " status !=9 and id_purchase_return_item = ".$lookup;

		   }

		    else if($type== 'print'){

			 $condition = " status =9 and id_purchase_return_item = ".$lookup;

		   }

		    else if($type== 'id'){

			 $condition = "  id_purchase_return = ".$lookup;

		   }

		   else {

			 $condition = " id_purchase_return_item	 = ".$lookup;

		   }

		  $qry = $qry.$condition;

		

		   if($result = $this->oDb->get_results($qry))

		   {

			  foreach($result as $row)

			  {

    		    $aPurchaseReturnItem = array();

				$aPurchaseReturnItem['id_purchase_return_item']       = $row->id_purchase_return_item;

				$aPurchaseReturnItem['id_po']            = $row->id_po;

				$aPurchaseReturnItem['id_pr']            = $row->id_pr;

				$aPurchaseReturnItem['id_vendor']        = $row->id_vendor;

				$aPurchaseReturnItem['id_grn']        = $row->id_grn;

				$aPurchaseReturnItem['id_inventory_item']        = $row->id_inventory_item;

				$aPurchaseReturnItem['id_purchase_return']        = $row->id_purchase_return;

				$aPurchaseReturnItem['unit_cost']        = $row->unit_price;

				$aPurchaseReturnItem['qty']              = $row->qty;

				$aPurchaseReturnItem['id_uom']           = $row->id_uom;

				$aPurchaseReturnItem['return_qty']     = $row->return_qty;

				$aPurchaseReturnItem['sender_id']     = $row->sender_id;

				$aPurchaseReturnItem['id_itemgroup1']      = $row->id_itemgroup1;

				$aPurchaseReturnItem['id_itemgroup2']      = $row->id_itemgroup2;

				$aPurchaseReturnItem['id_item']      = $row->id_item;

				

				$aUom = $this->getUomInfo($row->id_uom,'id');

				$aPurchaseReturnItem['uom_name']       = $aUom['lookup'];

				

				$aItem = $this->getItemInfo($row->id_item,'id');

				$aPurchaseReturnItem['item_name']       = $aItem['item_name'];

				

				$aGroup1 = $this->getItemGroup1Info($row->id_itemgroup1,'id');

				$aPurchaseReturnItem['itemgroup1_name']       = $aGroup1['itemgroup1_name'];

				$aGroup2 = $this->getItemGroup2Info($row->id_itemgroup2,'id');

				$aPurchaseReturnItem['itemgroup2_name']       = $aGroup2['itemgroup2_name'];

																		 

				$aPurchaseReturnItemList['iteminfo'][]               = $aPurchaseReturnItem;		

			  }//for

			  if($type== 'id'){

			  $aPurchaseReturnItemList['purchasereturninfo'] = $this->getPurchaseReturnInfo($lookup,'id');

			  }

		   }

		   return $aPurchaseReturnItemList;

	}//

	



public function getPurchaseReturnInfo($lookup,$type)

	{

	

	$qry = "SELECT * FROM purchase_return WHERE status != 2 AND ";

		   if($type == 'lookup') {

			 $condition = " lookup = '$lookup'";

		   }

		   else {

			 $condition = " id_purchase_return = ".$lookup;

		   }

		   $qry = $qry.$condition;

		 

		   if($result = $this->oDb->get_results($qry))

		   {

			  foreach($result as $row)

			  {

				$aPurchaseReturn['id_purchase_return']         = $row->id_purchase_return;

				$aPurchaseReturn['rtn_number']     = $row->rtn_number;

				$aPurchaseReturn['id_pr']         = $row->id_pr;

				$aPurchaseReturn['id_po']    = $row->id_po;

				$aPurchaseReturn['id_vendor']       = $row->id_vendor;

				$aPurchaseReturn['id_grn'] = $row->id_grn;

				$aPurchaseReturn['remarks']   = $row->remarks;

				$aPurchaseReturn['created_on']      = $row->created_on;

				$apurchaseRequest = $this->getPurchaseOrderInfo($row->id_po);

				$aPurchaseReturn['request_no']= $apurchaseRequest['po_number'];

				$aInventory = $this->getInventoryInfo($row->id_grn);

				$aPurchaseReturn['grn_no']= $aInventory['grn_no'];

				$aPurchaseReturn['id_store']= $aInventory['id_store'];

				$aPurchaseReturn['dc_date']= $aInventory['dc_date'];

				$aPurchaseReturn['dc_number']= $aInventory['dc_number'];

				$aPurchaseReturn['bill_number']= $aInventory['bill_number'];

				$aPurchaseReturn['bill_date']= $aInventory['bill_date'];

				               

			   $aVendorInfos = $this->getPrintVendorAddress($row->id_vendor,'id'); 

				$avendorAddress =array();

				$avendorAddress['name'] = $this->getVendorName($row->id_vendor);

				$avendorAddress['contact_name'] = $aVendorInfos['contact_name'];

				$avendorAddress['addr1'] = $aVendorInfos['addr1'];

				$avendorAddress['addr2'] = $aVendorInfos['addr2'];$avendorAddress['addr3'] = $aVendorInfos['addr3'];

				$avendorAddress['city_name'] = $aVendorInfos['city_name'];$avendorAddress['zipcode'] = $aVendorInfos['zipcode'];

				$aPurchaseReturn['vendor_address_format'] =  $avendorAddress;	

				

				 $aStoreInfos1 = $this->getStoreInfo($aInventory['id_store'],'id'); 

				$aStoreAddress1 =array();

				$aStoreAddress1['name'] = $aStoreInfos1['unitname'];

				$aStoreAddress1['addr1'] = $aStoreInfos1['addr1'];

				$aStoreAddress1['addr2'] = $aStoreInfos1['addr2'];$aStoreAddress1['addr3'] = $aStoreInfos1['addr3'];

				$aStoreAddress1['city_name'] = $aStoreInfos1['city_name'];$aStoreAddress1['zipcode'] = $aStoreInfos1['zipcode'];

				$aPurchaseReturn['store_address_format'] = $aStoreAddress1;	

			   

	       }

		   }

		   return $aPurchaseReturn;

	}

	

public function checkInventoryItem($inventoryitemid)

{

  $checkqry = "SELECT * FROM asset_image WHERE id_inventory_item='$inventoryitemid'";

 $this->oDb->query($checkqry);

 $num_rows = $this->oDb->num_rows;

 

 return  $num_rows;

}



public function getAssetImages($inventoryitemid,$assetid)

{

  $qry = "SELECT * FROM asset_image WHERE id_inventory_item='$inventoryitemid' OR id_asset_item='$assetid'";

  $aAssetImageList = array();

if($result = $this->oDb->get_results($qry))

		{

			foreach($result as $row)

			{

				$aAssetImage = array();

				$aAssetImage['id_image']      = $row->id_image;

				$aAssetImage['id_inventory_item']  = $row->id_inventory_item;	

				$aAssetImage['id_asset_item']  = $row->id_asset_item;

				$aAssetImage['image_path']      = $row->image_path;

			

				$aAssetImageList[]           = $aAssetImage;

			}

		}

		return $aAssetImageList;

}



public function addAssetImages($aRequest,$files,$asseetid=null)

{



                 $add_images =  $aRequest['fAddImgeCheckbox'];

				$aRemoveimages =  $aRequest['fDeleteImageCheckbox'];

				

				$aresult = array();	

				$aresult['url'] = $aRequest['fUrl'];

				$aresult['inventoryitem'] = $aRequest['fInventoryItemId'];

				$aresult['assetid'] = $asseetid;

				foreach($aRemoveimages as $key => $value)

				{

					$qrys = "DELETE FROM asset_image WHERE id_image=".$value;

					$this->addAssetTransLog($aRequest,'DELETEIMAGE',$asseetid,'','',$asseetid,'ASSET','','',$qrys,'Asset Image Deleted','');

					$this->oDb->query($qrys);

					

					

					$aresult['msg'] = 2;

				}



				if($add_images == 'on')

				{

									

						if($this->multiUploadAssetImage($aRequest,$files, $asseetid))

						{

					

						

						$aresult['msg'] = 1;

						}

						else

						{

						

						

					    $aresult['msg'] = 0;

					

						}

										

					

				}

				return $aresult;

}





public function getPurchaseReturnList()

{

 $qry= "SELECT * FROM purchase_return WHERE status != 2  ORDER BY id_purchase_return DESC";

	 

		$aPurchaseReturnList = array();

		if($result = $this->oDb->get_results($qry))

		{

			foreach($result as $row)

			{

				$aPurchaseReturn = array();

				$aPurchaseReturn['id_purchase_return']      = $row->id_purchase_return;

				$aPurchaseReturn['id_po']  = $row->id_po;	

				$aPurchaseReturn['rtn_number']  = $row->rtn_number;

				$aPurchaseReturn['id_pr']      = $row->id_pr;

				$aPurchaseReturn['date']      = $row->created_on;

				$aPurchaseReturn['id_vendor']       = $row->id_vendor;

				$aPurchaseReturn['id_grn'] = $row->id_grn;

				$aPurchaseReturn['remarks']      = $row->remarks;

				$aPurchaseReturn['po_number']      =$this->getPurchaseOrderNumber($row->id_po);

				$aPurchaseReturn['grn_number']      =$this->getGoodsReceivedNoteNumber($row->id_grn);

				$aPurchaseReturnList[]           = $aPurchaseReturn;

			}

		}

		return $aPurchaseReturnList;

}

public function getPurchaseRequestNumber($poid)

{

$qry = "SELECT id_pr FROM purchase_order WHERE id_po='$poid'";

 if($row = $this->oDb->get_row($qry)){

$id_pr = $row->id_pr;

}

return $id_pr ;

}



public function getPRNumbers($prid)

{

$qry = "SELECT request_no FROM purchase_request WHERE id_pr='$prid'";

 if($row = $this->oDb->get_row($qry)){

$request_no = $row->request_no;

}

return $request_no ;

}



public function getPurchaseOrderNumber($poid)

{

$qry = "SELECT po_number FROM purchase_order WHERE id_po='$poid'";

 if($row = $this->oDb->get_row($qry)){

$po_number = $row->po_number;

}

return $po_number ;

} 

public function getGoodsReceivedNoteNumber($grnid)

{

$qry = "SELECT grn_no FROM inventory WHERE id_inventory='$grnid'";

 if($row = $this->oDb->get_row($qry)){

$grn_no = $row->grn_no;

}

return $grn_no ;

} 

 

 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 

 //Dashboard

 

 public function getDashboardCounts()

{

$aDashBoardCount = array();

$qry = "select count(*) as total_asset_count from asset_item";

if($row = $this->oDb->get_row($qry))

{

$aDashBoardCount['Total_Asset_Count'] = $row->total_asset_count;

}

$qry = "select count(id_po) as new_po_count from purchase_order where status = 1";

if($row = $this->oDb->get_row($qry))

{

$aDashBoardCount['New_PO_Count'] = $row->new_po_count;

}

$qry = "select count(id_pr) as new_pr_count from purchase_request where status = 1";

if($row = $this->oDb->get_row($qry))

{

$aDashBoardCount['New_PR_Count'] = $row->new_pr_count;

}



$qry = "SELECT COUNT(id_inventory_item)As add_asset FROM inventory_item WHERE asset_status !=3 and inspection_status != 1";

if($row = $this->oDb->get_row($qry))

{

$aDashBoardCount['Add_Asset_Count'] = $row->add_asset;

}



return $aDashBoardCount;

}

 

public function CheckWarrantyPeriod($assetid)

{

       $checkqry = "SELECT warranty_end_date, DATEDIFF( warranty_end_date,now()) As days FROM asset_warranty WHERE id_asset_item='$assetid'";

		 $this->oDb->query($checkqry);

		 $num_rows = $this->oDb->num_rows;

         return $num_rows;

} 



public function CheckContractPeriod($assetid)

{

       $checkqry = "SELECT id_contract FROM asset_contract WHERE status=1 and id_asset_item='$assetid'";

	   if($result = $this->oDb->get_results($checkqry))

	   {

			  foreach($result as $row)

			  {

			  $id_contract = $row->id_contract;

		    $checkqry = "SELECT contract_end_date, DATEDIFF( contract_end_date,now()) As days FROM contract WHERE id_contract='$id_contract'";

			   if($row = $this->oDb->get_row($checkqry))

			   {

					$days = $row->days;

			

			   } 

		   }

	   }

		 

         return $days ;

} 



public function CheckWarrantys($assetid)

{

     

	  $checkqry = "SELECT warranty_end_date, DATEDIFF( warranty_end_date,now()) As days FROM asset_warranty WHERE id_asset_item='$assetid'";

	   if($row = $this->oDb->get_row($checkqry))

	   {

			 $days = $row->days;

			

	   } 

		 

      return $days ;   

} 



public function CheckInsurance($assetid)

{

     

	   $checkqry = "SELECT id_insurance FROM asset_insurance WHERE status=1 and id_asset='$assetid'";

	   if($result = $this->oDb->get_results($checkqry))

	   {

	      foreach($result as $row)

		  {

	     $id_insurance = $row->id_insurance;

	     $checkqry_ins = "SELECT ins_end_date, DATEDIFF( ins_end_date,now()) As days FROM insurance WHERE id_insurance='$id_insurance'";

			   if($rows = $this->oDb->get_row($checkqry_ins))

			   {

					 $days = $rows->days;

						if($days > 0)

						{

							$status = 'Existing';

							$label ="label-info";

						} else

						{

							$status = 'Expired';

							$label ="label-info";

						}

						

			   } 

			  }

	   }

	   else

	   {

			$status = 'Not Available / Expired';

			$label ="label-info";

	   }

	

			$status = '<span class="label '.$label.' ">'.$status.'</span>';

			return $status;

} 







public function CheckAssetDeliveryInMaintenance($lookup)

{

       $checkqry = "SELECT id_asset_delivery FROM asset_maintenance WHERE id_asset_delivery='$lookup'";

		 $this->oDb->query($checkqry);

		 $num_rows = $this->oDb->num_rows;

         return $num_rows;

} 

public function CheckWarranty($assetid)

{

        $today = date('Y-m-d');

		 $checkqry = "SELECT warranty_end_date, DATEDIFF( warranty_end_date,now()) As days FROM asset_warranty WHERE '$today' between warranty_start_date and warranty_end_date AND id_asset_item='$assetid'";

		

		if($row = $this->oDb->get_row($qry))

		{

		$days = $row->days;

		}

		return $days;

} 

 

public function getWarrantyDates($assetid)

{

 $qry= "SELECT * FROM asset_warranty WHERE id_asset_item='$assetid'";

	 

		$aWarrantyDate = array();

		if($row = $this->oDb->get_row($qry))

		{

		$aWarrantyDate['warranty_start_date'] = $row->warranty_start_date;

		$aWarrantyDate['warranty_end_date'] = $row->warranty_end_date;

		}

return $aWarrantyDate ;

} 

 

public function addWarranty($aRequest,$startdate,$enddate,$lastinsertid)

{

		

		/*print_r($aRequest);

		echo $startdate.'<br>';

		echo $enddate.'<br>';

		echo $lastinsertid.'<br>';

		exit();*/

		$checkqry = "SELECT * FROM asset_warranty WHERE id_asset_item='$lastinsertid'";

		$this->oDb->query($checkqry);

		$created_by        = $_SESSION['sesCustomerInfo']['user_id'];

		$num_rows = $this->oDb->num_rows;

		if($num_rows > 0)

		{

			$qry = "UPDATE asset_warranty SET warranty_start_date='".date('Y-m-d',strtotime($startdate))."',warranty_end_date='".date('Y-m-d',strtotime($enddate))."',modified_by='".$created_by."',modified_on=now(),remark='',status='1' WHERE id_asset_item='$lastinsertid'";

		}

		else

		{

			$qry = "INSERT INTO asset_warranty(id_asset_warranty, id_asset_item, warranty_start_date, warranty_end_date, created_by, created_on, modified_by, modified_on, remark, status) VALUES (NULL,'$lastinsertid','".date('Y-m-d',strtotime($startdate))."','".date('Y-m-d',strtotime($enddate))."','$created_by ',now(),'','','','1')";

		}

		

		if($this->oDb->query($qry))	{

			$done = 1;

		}

		else{

		     $done = 0;

			 echo '<div style=" margin-top:50px;color:#FFF;background-color: gold;" ><font color="#FFFFFF">';

									$this->oDb->debug();

									echo '</font></div>';

									

		}

		

		return $done;



}

 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



public function getAdditionAssetAmount($lookup)

{

$qry ="SELECT

   SUM(service_invoice.bill_amount) AS sum_amount

    

FROM

    asset_maintenance

    INNER JOIN service_invoice 

     ON (asset_maintenance.id_asset_maintenance = service_invoice.id_asset_maintenance)

        WHERE  asset_maintenance.id_asset_item = '$lookup' AND  service_invoice.for_depreciation=1;";

		

		if($row = $this->oDb->get_row($qry))

		{

		$aAdditionalAmount  = $row->sum_amount;

		}

		return $aAdditionalAmount ;

}



public function checkMaintenace($lookup)

{



$result = $this->CheckWarrantys($lookup);



  if($result > 0 )

  {

  $status= "Under Warranty";

  $label ="label-success";

  }

else if($results = $this->CheckContractPeriod($lookup))

 {

  if($results > 0 )

  {

	$status= "Under Contract";

    $label ="label-warning";

   }

   else

	 {

	 $status = 'Not Available / Expired';

	 $label ="label-info";

	 }

 }

 else

 {

 $status = 'Not Available / Expired';

 $label ="label-info";

 }



 

  $status = '<span class="label '.$label.' ">'.$status.'</span>';

 return $status;

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//Drp



	public function getItemsDrop($lookup1,$lookup2,$item,$type)

	{

	

		if($type == 'item')

		{

			 if($item !='')

		{

		 $qry="SELECT DISTINCT asset_item.asset_no AS asset_no,asset_item.machine_no As machine_no,asset_item.asset_name AS id_item ,asset_item.id_asset_item AS asset_item FROM asset_item,asset_stock

WHERE asset_stock.id_asset_item = asset_item.id_asset_item and asset_stock.status!=8 and  asset_stock.status!=21 and asset_item.asset_name IN('".$item."') and asset_item.id_itemgroup1='".$lookup1."' and asset_item.id_itemgroup2=".$lookup2;

		}

		else

		{

	$qry="SELECT DISTINCT asset_item.asset_name AS id_item  FROM asset_item,asset_stock

WHERE asset_stock.id_asset_item = asset_item.id_asset_item and asset_stock.status!=8 and asset_stock.status!=21 and asset_item.id_itemgroup1='".$lookup1."' and asset_item.id_itemgroup2=".$lookup2;

		}

	$aItemGroup2List = array();

		

		if($result = $this->oDb->get_results($qry))

		{

			foreach($result as $row)

			{

				$aItemGroup2=array();

				$aItemGroup2['asset_no'] = $row->asset_no;

				$aItemGroup2['machine_no'] = strtoupper($row->machine_no);

				$aItemGroup2['asset_item'] = $row->asset_item;

				$aItemGroup2['id_item'] = $row->id_item;

				$aItem = $this->getItemInfo($row->id_item,'id');

				$aItemGroup2['item_name']       = $aItem['item_name'];

				 $aItemGroup2List[] = $aItemGroup2;

			}

		}

		}

		return $aItemGroup2List;

	}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



public function salesInvoiceCount()

	{

			 $Count = array();

			$qry = "SELECT Max(id_asset_sales_invoice) As id FROM asset_sales_invoice WHERE 1=1";

			$result = $this->oDb->get_results($qry);

			 foreach($result as $row)

			{

				

		        $Count['count'] = $row->id+1+10000;

				$acompany = $this->getCompanyInfo('1','id');

				$aNumber = $acompany['lookup'].'-'.'SAL'.$Count['count'];

			}

			

			return $aNumber;

	}





public function addSalesInvoice($aRequest)

{

  $id_company = $aRequest['fCompanyId'];

  $id_vendor = $aRequest['fvendorId'];

  $invoice_no = $this->salesInvoiceCount();

 if($aRequest['fRequireDate'] !='')

 {

 $invoice_date = date('Y-m-d',strtotime($aRequest['fRequireDate']));

 }

  $created_by        = $_SESSION['sesCustomerInfo']['user_id'];

$qry = "INSERT INTO asset_sales_invoice(id_asset_sales_invoice, id_company, id_vendor, invoice_number, invoice_date, id_asset_delivery, id_asset_gate_pass, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$id_company','$id_vendor',' $invoice_no','$invoice_date','','','$created_by',now(),'','','1')";



  if($this->oDb->query($qry))	{

			  $lastInsertId = $this->oDb->insert_id;

			   $DeliveryInfo =  $this->addAssetDelivery($aRequest);

				 	$DeliveryId =  $DeliveryInfo['lastinsertid'];

					$update_asset = "UPDATE asset_sales_invoice SET id_asset_delivery='$DeliveryId' WHERE id_asset_sales_invoice='$lastInsertId'";

			  		   $this->oDb->query($update_asset);

		     		   if($this->addSalesInvoiceItem($aRequest,$lastInsertId))

					   {

						   $done = 1;

						}

						else

						{

						   $done = 0;

										 

						} 

				}

			if($done ==1)

				{

				   return true;

				}

				else

				{

				    return false;

				}

}



public function addSalesInvoiceItem($aRequest,$salesinvoiceid)

{

   $aid_asset_item = $aRequest['fAssetItemId'];

   $aid_itemgroup1 = $aRequest['fItemGroup1Id'];

   $aid_itemgroup2 = $aRequest['fItemGroup2Id'];

   $aid_item = $aRequest['fItemId'];

   $aUom = $aRequest['fUomId'];

    $aquanity = $aRequest['fIssueQuantity'];

	$aunitprice = $aRequest['fUnitPrice'];

	$adepprice = $aRequest['fDepPrice'];

	$asaleprice = $aRequest['fSalePrice'];

   	$aTaxid = $aRequest['fTaxId'];

    $created_by        = $_SESSION['sesCustomerInfo']['user_id'];

$aInsertvalues = array_map(null,$aid_asset_item,$aid_itemgroup1,$aid_itemgroup2,$aid_item,$aquanity,$aUom,$aunitprice,$adepprice,$asaleprice,$aTaxid);

foreach ($aInsertvalues as $Item)

{

$aTax = explode("/",$Item[9]);

$tax_price = ($aTax[0] * $Item[8]) / 100;

$total_price = ($Item[4] * $Item[8] );



$qry =" INSERT INTO asset_sales_invoice_item(id_asset_sales_invoice_item,id_asset_sales_invoice, id_asset_item, id_itemgroup1, id_itemgroup2, id_item, quantity, id_uom, purchased_price, depreciation_price, sale_price, id_taxform, tax_percentage, tax_price, total_price, created_by, created_on, modified_by, modified_on, status) VALUES (NULL,'$salesinvoiceid','$Item[0]','$Item[1]','$Item[2]','$Item[3]','$Item[4]','$Item[5]','$Item[6]','$Item[7]','$Item[8]','$aTax[2]','$aTax[0]','$tax_price','$total_price','$created_by',now(),'','','1')";

				if($this->oDb->query($qry)){

	  $update_asset = "UPDATE asset_item SET status='21' WHERE id_asset_item='$Item[0]'";

	  $this->oDb->query($update_asset);

	  $update_stock = "UPDATE asset_stock SET status='21' WHERE id_asset_item='$Item[0]'";

	   $this->oDb->query($update_stock);

					$done = 1;

					}

					else

					{

					$done = 0;

					} 

				}

				if($done ==1)

				{

				    return true;

				}

				else

				{

				    return false;

				}

}



public function getAssetLocation($lookup)

{

$qry = "SELECT

    asset_stock.id_store

    , asset_stock.id_unit

    , asset_stock.id_division

FROM

    asset_item

    INNER JOIN asset_stock 

        ON (asset_item.id_asset_item = asset_stock.id_asset_item)

        WHERE asset_item.id_asset_item='$lookup'";

		$aAssetLocationInfo = array();

	if($row = $this->oDb->get_row($qry))

		{

		$aAssetLocationInfo['id_store'] = $row->id_store;

		$aAssetLocationInfo['id_unit'] = $row->id_unit;

		$aAssetLocationInfo['id_division'] = $row->id_division;

		}

		return $aAssetLocationInfo;	

}



public function getSalesInvoiceList($type=null,$lookup='')

  {

		if($type == 'Sales')

		{

		 $qry = "SELECT * FROM asset_sales_invoice WHERE status =1 and id_asset_sales_invoice=".$lookup;

		}

		else

		{

		$qry = "SELECT * FROM asset_sales_invoice WHERE status !=2  ORDER BY id_asset_sales_invoice DESC ";

		}

		$aSalesInvoiceList = array();

		

		if($result = $this->oDb->get_results($qry))

		{

			foreach($result as $row)

			{

				$aSalesInvoice = array();

				$aSalesInvoice['id_asset_sales_invoice']   = $row->id_asset_sales_invoice;

				$aSalesInvoice['id_company']   = $row->id_company;

				$aCompanyInfo = $this->getCompanyInfo($row->id_company,'id');

				$aSalesInvoice['company_name']   = $aCompanyInfo['company_name'];

				$aSalesInvoice['id_vendor']   = $row->id_vendor;

				$avendorName = $this->getVendorName($row->id_vendor);

				$aSalesInvoice['vendor_name'] =  $avendorName;

				$aSalesInvoice['remark']   = $row->remark;

				$aSalesInvoice['invoice_number']   = $row->invoice_number;

				$aSalesInvoice['invoice_date']   = $row->invoice_date;

				$aSalesInvoice['id_asset_delivery']   = $row->id_asset_delivery;

				$aDeliveryInfo = $this->getDeliveryInfo($row->id_asset_delivery,'id');

				$aSalesInvoice['delivery_number']   = $aDeliveryInfo['issue_no'];

				$aSalesInvoice['delivery_type']   = $aDeliveryInfo['delivery_type'];

				$aSalesInvoice['status']   = $row->status;

				$aSalesInvoiceList[]        = $aSalesInvoice;

			}

		}

		return $aSalesInvoiceList;

  } //	



public function getSalesInvoiceItemInfo($lookup,$type)

{

$qry = "SELECT * FROM asset_sales_invoice_item WHERE status !=2 ";

 if($type =='asset')

 {

 $conditions = ' AND id_asset_item='.$lookup;

 }

 else

 {

  $conditions = ' AND id_asset_sales_invoice_item='.$lookup;

 }

 $qry = $qry.$conditions;

 $aSalesInvoiceItemInfo = array();

 if($row = $this->oDb->get_row($qry))

		{

		$aSalesInvoiceItemInfo['id_asset_sales_invoice_item'] = $row->id_asset_sales_invoice_item;

		$aSalesInvoiceItemInfo['id_asset_sales_invoice'] = $row->id_asset_sales_invoice;

		$aSalesInvoiceItemInfo['id_asset_item'] = $row->id_asset_item;

		$aSalesInvoiceItemInfo['id_itemgroup1'] = $row->id_itemgroup1;

		$aSalesInvoiceItemInfo['id_itemgroup2'] = $row->id_itemgroup2;

		$aSalesInvoiceItemInfo['id_item'] = $row->id_item;

		$aSalesInvoiceItemInfo['quantity'] = $row->quantity;

		$aSalesInvoiceItemInfo['id_uom'] = $row->id_uom;

		$aSalesInvoiceItemInfo['purchased_price'] = $row->purchased_price;

		$aSalesInvoiceItemInfo['depreciation_price'] = $row->depreciation_price;

		$aSalesInvoiceItemInfo['sale_price'] = $row->sale_price;

		$aSalesInvoiceItemInfo['id_taxform'] = $row->id_taxform;

		$aSalesInvoiceItemInfo['tax_percentage'] = $row->tax_percentage;

		$aSalesInvoiceItemInfo['tax_price'] = $row->tax_price;

		$aSalesInvoiceItemInfo['total_price'] = $row->total_price;

		$aSalesInvoiceItemInfo['status'] = $row->status;

		$aTaxinfo = $this->getTaxFormInfo($row->id_taxform,'id');

		$aSalesInvoiceItemInfo['tax_name'] = $aTaxinfo['taxform_name'];

		$aSalesInvoiceDetails = $this->getSalesInvoiceList('Sales',$row->id_asset_sales_invoice);

		$aSalesInvoiceItemInfo['invoice_number'] = $aSalesInvoiceDetails[0]['invoice_number'];

		$aSalesInvoiceItemInfo['invoice_date'] = $aSalesInvoiceDetails[0]['invoice_date'];

		$aSalesInvoiceItemInfo['delivery_number'] = $aSalesInvoiceDetails[0]['delivery_number'];

		$aSalesInvoiceItemInfo['vendor_name'] = $aSalesInvoiceDetails[0]['vendor_name'];

		

		}

		return $aSalesInvoiceItemInfo;

}





public function getMainMenuNames($aMainMenuId)

{

$aMainMenuList = array();

	foreach($aMainMenuId as $menuId)

	{

		$qry = "select db_lcatId, db_lcatName, db_lcatStatus from linkcattable WHERE db_lcatId = $menuId ORDER BY db_lsOrder ASC";

		if($row = $this->oDb->get_row($qry)) 

		{ 

			$aMenu = array();

			$aMenu['db_lcatId'] = $row->db_lcatId;

			$aMenu['db_lcatName'] = $row->db_lcatName;

			$aMainMenuList[] = $aMenu;

		 }

	}

    return $aMainMenuList;

}//end func.



public function changeContractStatus()

{

$qry ="SELECT

     contract.contract_end_date

    , contract.contract_start_date

    , asset_contract.id_asset_item

     ,contract.id_contract

   

FROM

   contract

    INNER JOIN asset_contract 

        ON (contract.id_contract = asset_contract.id_contract)

        WHERE  DATEDIFF( contract.contract_end_date,NOW()) < 0;";

		

	if($result = $this->oDb->get_results($qry))

		{

			foreach($result as $row)

			{

			$id_contract=$row->id_contract;

			$qry_update  = "UPDATE asset_contract SET status=22 WHERE id_contract='$id_contract'";

			$this->oDb->query($qry_update);

			}

		}	

}





public function changeInspectionStatus()

{



$qry_grn = "SELECT DISTINCT id_grn FROM inventory_item";

if($result1 = $this->oDb->get_results($qry_grn))

		{

		foreach($result1 as $row1)

		{

$qry ="SELECT COUNT(id_inventory_item) as count FROM 

     inventory_item WHERE inspection_status=1 AND id_grn ='$row1->id_grn'";

	if($row = $this->oDb->get_row($qry))

	{



	 if($row->count == 0)

	 {

	 	 $qry_update  = "UPDATE inventory SET inspection_status=12 WHERE id_inventory='$row1->id_grn'";

		$this->oDb->query($qry_update);

	 }

	 else

	 {

	  $qry_update  = "UPDATE inventory SET inspection_status=1 WHERE id_inventory='$row1->id_grn'";

		$this->oDb->query($qry_update);

	 }

		  }

		  }

		 

		}	

}



public function changeInsuranceStatus()

{

$qry ="  SELECT

    asset_insurance.id_asset

    , insurance.ins_start_date

    , insurance.ins_end_date

    , asset_insurance.status

	, asset_insurance.id_insurance

FROM

    asset_insurance

    INNER JOIN insurance 

        ON (asset_insurance.id_insurance = insurance.id_insurance) WHERE  DATEDIFF( insurance.ins_end_date,NOW()) < 0;";

		

	if($result = $this->oDb->get_results($qry))

		{

			foreach($result as $row)

			{

			$id_insurance=$row->id_insurance;

			$qry_update  = "UPDATE asset_insurance SET status=22 WHERE id_insurance='$id_insurance'";

			$this->oDb->query($qry_update);

			}

		}	

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



public function getTransactionList($lookup,$type)

{

 $qry = "SELECT * FROM history WHERE id_trans_head='$lookup' AND trans_head='$type'";



$aHistoryList = array();

if($result = $this->oDb->get_results($qry))

		{

			foreach($result as $row)

			{

			$aHistory = array();

			$aHistory['id_history'] = $row->id_history;

			$aHistory['id_refer_history'] = $row->id_refer_history;

			$aHistory['refer_table'] = $row->refer_table;

			$aHistory['trans_head'] = $row->trans_head;

			$aHistory['trans_type'] = $row->trans_type;

			$aHistory['trans_head_number'] = $row->trans_head_number;

			$aHistory['id_trans_head'] = $row->id_trans_head;

			$aHistory['trans_description'] = $row->trans_description;

			$aHistory['trans_disc'] =  $this->aTrans[$row->trans_head]['trans_type'][$row->trans_type];

			$aHistory['created_on'] = date('d/m/Y',strtotime($row->created_on));

			

			$aHistoryList[] = $aHistory;

			}

		}	

		return $aHistoryList;

}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



public function getAssetTransaction($lookup)

{

 $qry = "SELECT * FROM transaction_asset WHERE id_asset_item='$lookup'";



$aHistoryList = array();

if($result = $this->oDb->get_results($qry))

		{

			foreach($result as $row)

			{

			$aHistory = array();

			$aHistory['id_transaction_asset'] = $row->id_transaction_asset;

			$aHistory['id_asset_item'] = $row->id_asset_item;

			$aHistory['id_grn'] = $row->id_grn;

			$aHistory['id_inventory_item'] = $row->id_inventory_item;

			$aHistory['from_location'] = $row->from_location;

			$aHistory['from_ref_table'] = $row->from_ref_table;

			$aHistory['to_location'] = $row->to_location;

			$aHistory['to_ref_table'] = $row->to_ref_table;

			$aHistory['action_name'] = $row->action_name;

			$aHistory['action_by'] = $row->action_by;

			$aHistory['remarks'] = $row->remarks;

			if($row->to_ref_table == 'STR')

			{

			 $aHistory['to_location_name'] = $this->getStoreName($row->to_location);

			 }

			 if($row->from_ref_table == 'AST')

			{

			 $aHistory['from_location_name'] = 'ASSET';

			 }

			 

			$aHistory['trans_disc'] =  $this->aTrans['ASSET']['trans_type'][$row->action_name];

			$aHistory['action_date'] = date('d/m/Y',strtotime($row->action_date));

			

			$aHistoryList[] = $aHistory;

			}

		}	

		return $aHistoryList;

}

      

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



public function getInspectionInfo($itemid)

{

$qry_inspection = "SELECT * FROM asset_inspection WHERE id_inventory_item='$itemid'";



if($row = $this->oDb->get_row($qry_inspection))

	{

	$aInspection = array();

	$aInspection['id_asset_inspection'] = $row->id_asset_inspection;

	$aInspection['grn_no'] = $row->grn_no;

	$aInspection['id_inventory_item'] = $row->id_inventory_item;

	$aInspection['inspection_details'] = $row->inspection_details;

	$aInspection['remarks'] = $row->remarks;

	$aInspection['status'] = $row->status;

	$aInspection['id_employee'] = $row->id_employee;

	$aInspection['image_description'] = $row->image_description;

	

	}

	return $aInspection;

}

public function getInventoryImage($itemid)
{
$qry_inspection = "SELECT * FROM asset_image WHERE id_inventory_item='$itemid'";
$aInspectionList = array();
if($result = $this->oDb->get_results($qry_inspection))
	{
	foreach($result as $row)
	{
	$aInspectionImage = array();
	$aInspectionImage['id_image'] = $row->id_image;
	$aInspectionImage['image_path'] = $row->image_path;
	$aInspectionList[] = 	$aInspectionImage;
		}
	}
	return $aInspectionList;

}

public function getItemInspectionInfo($itemid)
{
$qry = "SELECT * FROM inventory_item WHERE id_inventory_item='$itemid'";
$aInventoryInfo = array();
if($row = $this->oDb->get_row($qry))
	{
	  $aInventoryInfo['inspectiondetails'] = $this->getInspectionInfo($row->id_inventory_item);
  $aInventoryInfo['assetimage']=$this->getInventoryImage($row->id_inventory_item,'');
     }
return $aInventoryInfo;

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
public function addFuelLimit($aRequest)
{

$id_asset_item = $aRequest['fAssetNumber'];
$fuel_limit = $aRequest['fFuelLimit'];
$remarks = $aRequest['fRemarks'];
 $created_by        = $_SESSION['sesCustomerInfo']['user_id'];
 $checkqry = "SELECT * FROM fuel_limit WHERE status=1 and id_asset_item='$id_asset_item'";
 		 $this->oDb->query($checkqry);
		 $num_rows = $this->oDb->num_rows;
		if(	$num_rows > 0)
		{	
		$qry_update = "UPDATE `fuel_limit` SET `status`='2',created_on=now() WHERE id_asset_item='$id_asset_item'";
		$this->oDb->query($qry_update);
		 $qry = "INSERT INTO `fuel_limit`(`id_fuel_limit`, `id_asset_item`, `fuel_limit`, `remarks`, `created_by`, `created_on`, `status`) VALUES (NULL,'$id_asset_item','$fuel_limit','$remarks','$created_by',now(),'1')";
		}
		else
	{
		 $qry = "INSERT INTO `fuel_limit`(`id_fuel_limit`, `id_asset_item`, `fuel_limit`, `remarks`, `created_by`, `created_on`, `status`) VALUES (NULL,'$id_asset_item','$fuel_limit','$remarks','$created_by',now(),'1')";
		}

if($this->oDb->query($qry))	{

		  return true;

		}

		else{

		  return false;

		}

}

public function FuelUsedCount($lookup)

	{

			$today = date('Y-m-d');

			$timestamp    = strtotime($today);

 $first_second = date('Y-m-01 00:00:00', $timestamp);

 $last_second  = date('Y-m-t 12:59:59', $timestamp);

 $Count = 0;

 $qry = "SELECT SUM(qty) As used_count FROM fuel WHERE id_asset_item='$lookup' and created_on >= '$first_second'  and  created_on<='$last_second' ";

$result = $this->oDb->get_row($qry);

$Count  = $result->used_count;

return $Count;

	}

	public function getFuelLimitList()
	{
		
		$qry = "SELECT
    asset_item.machine_no
    , asset_item.asset_no
    , asset_item.asset_name
    , fuel_limit.id_fuel_limit
	 , fuel_limit.id_asset_item
    , fuel_limit.fuel_limit
      , fuel_limit.remarks
	    , fuel_limit.created_on
	    , fuel_limit.status
  FROM
    asset_item
    INNER JOIN fuel_limit 
        ON (asset_item.id_asset_item = fuel_limit.id_asset_item)
		         WHERE  fuel_limit.status !=2 ";
		  $order = 'ORDER BY fuel_limit.id_fuel_limit DESC';
		$qry =$qry.$order;
		$aFuelLimitList = array();
		if($result = $this->oDb->get_results($qry))
		{
			foreach($result as $row)
			{
				$aFuelLimit = array();
				$aFuelLimit['id_asset_item']    = $row->id_asset_item;
				$aFuelLimit['id_fuel_limit']    = $row->id_fuel_limit;
				$aFuelLimit['fuel_limit']    = $row->fuel_limit;
				$aFuelLimit['created_on']    = $row->created_on;
				$aFuelLimit['asset_no']    = $row->asset_no;
				$aFuelLimit['machine_no']    = strtoupper($row->machine_no);
				$aFuelLimit['remarks']    = $row->remarks;
				$aFuelLimit['status']    = $row->status;
				$aItem = $this->getItemInfo($row->asset_name,'id');
				$aFuelLimit['item_name']       = $aItem['item_name'];
				$aFuelLimitList[]        = $aFuelLimit;
			}
		}
		return $aFuelLimitList;
	}
public function getVendorItemGroup($lookup)
{
	$sql = " SELECT id_itemgroup1 FROM vendor WHERE id_vendor='$lookup'";
	if($result = $this->oDb->get_row($sql))
	{
	$aItemList = $result->id_itemgroup1;
	}
	return $aItemList;
}
public function getItemGroup1Lists($lookup)
  {

	 $qry = "SELECT * FROM itemgroup1 WHERE status != 2 and `id_itemgroup1` IN($lookup)";
		$aIGList = array();
	if($result = $this->oDb->get_results($qry))
		{
		foreach($result as $row)
		{
				$aItemGroup = array();
				$aItemGroup['id_itemgroup1']   = $row->id_itemgroup1;
				$aItemGroup['itemgroup1_name'] = strtoupper($row->itemgroup1_name);
			$aItemGroup['lookup']          = strtoupper($row->lookup);
				$aItemGroup['status']          = $row->status;
				$aIGList[]                     = $aItemGroup;
			}

		}

		return $aIGList;

  } //



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

public function delete($tablename,$field,$value,$type = '')
{
 
 $exists = 0;
 if($type == 'Permanent')
 {
		$query = "DELETE FROM $tablename WHERE $field = ".$value;
		if($this->oDb->query($query))
		{
		$exists = '1';
		}
$this->addHistoryTransLog($tablename,$value,'TBL',$tablename,'','',$value,'1',$query,'Deleted','');
 }
 else
 {
	  
	$query = "UPDATE $tablename SET status = 2 where $field = ".$value;

		if($this->oDb->query($query))
		{
		$exists = '3';
		}
		$this->addHistoryTransLog($tablename,$value,'TBL',$tablename,'','',$value,'1',$query,'Deleted','');
		
 }
return $exists ;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

public function itemDelete($lookup)
{
	 	
	
	$sql = "SELECT * FROM pr_item WHERE id_item='$lookup'";
	$sql1 = "SELECT * FROM po_item WHERE id_item='$lookup'";
	$sql2 = "SELECT * FROM asset_item WHERE asset_name='$lookup'";
	if($row = $this->oDb->query($sql))
	{
	$exists = true; 	       
	}
	else if($row = $this->oDb->query($sql1))
	{
	$exists = true; 
	}
	else if($row = $this->oDb->query($sql2))
	{
	$exists = true; 
	}
	else
	{
	$exists = false;
	}
	return $exists;
}

public function checkExistsMultiple($aRequest)
{ 

    $exist = false;
	foreach($aRequest as $avalue)
	{
	 $sql = "SELECT * FROM ".$avalue['table']." WHERE ".$avalue['field']."  = '".$avalue['value']."'";
	 if($row = $this->oDb->query($sql))
	{
	 $exists = true; 	       
	}
	}
	
	return $exists;
}

public function checkInspection($lookup)
{
$exist = false;
 $sql = "SELECT * FROM asset_inspection WHERE id_inventory_item='$lookup'";
if($result = $this->oDb->get_row($sql))
	{
	$exist = true;
	}
	return $exist;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
} //end Master

?>