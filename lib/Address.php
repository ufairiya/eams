<?php
	/**
	  * Address class
	  *
	  * @author Subash Gopalaswamy <techhead.stallioni@gmail.com>
	  */
  
  class Address
  {
  	
	public function __construct()
	{
	   //
	}
	
	public function setDb($oDb)
	{
	   $this->oDb = $oDb;
	}
	
	public function addAddress($aRequest)
	{
		$asset_address1 = strtoupper($aRequest['fAddress1']);
		$asset_address2 = strtoupper($aRequest['fAddress2']);
		$asset_address3 = strtoupper($aRequest['fAddress3']);
		$asset_city = $aRequest['fCityId'];
		$asset_state = $aRequest['fStateId'];
		$asset_pincode = $aRequest['fPincode'];
		$asset_country= $aRequest['fCountryId'];
		$asset_phone1= $aRequest['fPhone1'];
		$asset_phone2= $aRequest['fPhone2'];
		$asset_email1= $aRequest['fEmail1'];
		$asset_email2= $aRequest['fEmail2'];
		$asset_fax1= $aRequest['fFax1'];
		$asset_fax2= $aRequest['fFax2'];
		$asset_contactperson1= strtoupper($aRequest['fContactPerson1']);
		$asset_contactperson2= strtoupper($aRequest['fContactPerson2']);
		$asset_companyname= strtoupper($aRequest['fCompanyName']);
		$asset_vendorstatus = $aRequest['fStatus'];
	   $asset_create_by = $_SESSION['sesCustomerInfo']['user_id'];
	 $query = "INSERT INTO addresses(addr1,addr2,addr3,city,state,pincode,country,phone1,phone2,email1,email2,fax1,fax2,contact_person1,contact_person2,company_name	,created_by,created_on,modified_by, modified_on,status) VALUES ('".$asset_address1."','".$asset_address2."','".$asset_address3."','".$asset_city."','".$asset_state."','".$asset_pincode."','".$asset_country."','".$asset_phone1."','".$asset_phone2."','".$asset_email1."','".$asset_email2."','".$asset_fax1."','".$asset_fax2."','".$asset_contactperson1."','".$asset_contactperson2."','".$asset_companyname."','".$asset_create_by."',now(),'', now(),'".$asset_vendorstatus."')";
		
	  if($this->oDb->query($query))
	   {
	     $lastInsertId = $this->oDb->insert_id;
		  
		 return $lastInsertId;
	     
	   }
	   else { //exit();
	     return false;
	   }	 
	}
		public function updateAddress($aRequest,$Addressid)
	{
	  $done = 0;
	 
	   $asset_address1 = strtoupper($aRequest['fAddress1']);
		$asset_address2 = strtoupper($aRequest['fAddress2']);
		$asset_address3 = strtoupper($aRequest['fAddress3']);
		$asset_city = $aRequest['fCityId'];
		$asset_state = $aRequest['fStateId'];
		$asset_pincode = $aRequest['fPincode'];
		$asset_country = $aRequest['fCountryId'];
		$asset_phone1 = $aRequest['fPhone1'];
		$asset_phone2 = $aRequest['fPhone2'];
		$asset_email1 = $aRequest['fEmail1'];
		$asset_email2 = $aRequest['fEmail2'];
		$asset_fax1 = $aRequest['fFax1'];
		$asset_fax2 = $aRequest['fFax2'];
		$asset_contactperson1 = strtoupper($aRequest['fContactPerson1']);
		$asset_contactperson2 = strtoupper($aRequest['fContactPerson2']);
		$asset_companyname = strtoupper($aRequest['fCompanyName']);
	    $status = $aRequest['fStatus'];
	    $asset_modified_by = $_SESSION['sesCustomerInfo']['user_id'];
	  $query = "UPDATE addresses SET addr1 ='".$asset_address1."', addr2 ='".$asset_address2."',addr3 ='".$asset_address3."', city ='".$asset_city."',state ='".$asset_state."',pincode ='".$asset_pincode."',country ='".$asset_country."',phone1 ='".$asset_phone1."',phone2 ='".$asset_phone2."',email1 ='".$asset_email1."',email2 ='".$asset_email2."',fax1 ='".$asset_fax1."',fax2 ='".$asset_fax2."',contact_person1 ='".$asset_contactperson1."',contact_person2 ='".$asset_contactperson2."',status = ".$status.",modified_by = ".$asset_modified_by.", modified_on = now() WHERE 	id_address = ".$Addressid;
	if($this->oDb->query($query))
	  {
	     $done = 1;
	  }
	  return $done;
	  
	}
	public function getAddressInfo($addressId)
	{
	   
	   $aaddressInfo = array();
	   $query = "SELECT addr1, addr2, city,state,pincode,country,phone1,phone2,email1,email2,fax1,fax2,contact_person1,contact_person2,company_name FROM addresses WHERE id_address =".$addressId;
	   if($row = $this->oDb->get_row($query))
	   {
			$aaddressInfo['address1']            = strtoupper($row->addr1);
			$aaddressInfo['address2']            = strtoupper($row->addr2);
			$aaddressInfo['address3']            = strtoupper($row->addr3);
			$aaddressInfo['city']                = $row->city;
			$aaddressInfo['state']               = $row->state;
			$aaddressInfo['pincode']             = $row->pincode;
			$aaddressInfo['country']             = $row->country;
			$aaddressInfo['phone1']              = $row->phone1;
			$aaddressInfo['phone2']              = $row->phone2;
			$aaddressInfo['email1']              = $row->email1;
			$aaddressInfo['email2']              = $row->email2;
			$aaddressInfo['fax1']                = $row->fax1;
			$aaddressInfo['fax2']                = $row->fax2;
			$aaddressInfo['contactperson1']     = strtoupper($row->contact_person1);
			$aaddressInfo['contactperson2']     = strtoupper($row->contact_person2);
			$aaddressInfo['companyname']        = strtoupper($row->company_name);
			$aaddressInfo['status']             = $row->status;
	   }
	   return $aaddressInfo;
	   
	}
	
	public function getAllAddressInfo()
	{
	   
	   $aaddressInfo = array();
	   $query = "SELECT * FROM addresses WHERE status !=2";
	   if($result = $this->oDb->get_results($query))
	   {
		   foreach($result as $row)
		   {
			$aaddress = array();
			$aaddress['address1']               = strtoupper($row->addr1);
			$aaddress['address2']               = strtoupper($row->addr2);
			$aaddress['address3']               = strtoupper($row->addr3);
			$aaddress['city']                = $row->city;
			$aaddress['state']               = $row->state;
			$aaddress['pincode']             = $row->pincode;
			$aaddress['country']             = $row->country;
			$aaddress['phone1']              = $row->phone1;
			$aaddress['phone2']              = $row->phone2;
			$aaddress['email1']              = $row->email1;
			$aaddress['email2']              = $row->email2;
			$aaddress['fax1']                = $row->fax1;
			$aaddress['fax2']                = $row->fax2;
			$aaddress['contactperson1']     = strtoupper($row->contact_person1);
			$aaddress['contactperson2']     = strtoupper($row->contact_person2);
			$aaddress['companyname']        = strtoupper($row->company_name);
			$aaddress['status']             = $row->status;
			$aaddressInfo[] = $aaddress;
		   }
		  
	   }
	   return $aaddressInfo;
	   
	}
  }
?>