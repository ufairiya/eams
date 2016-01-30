<?php
/*
 * SimpleModal Contact Form
 * http://simplemodal.com
 *
 * Copyright (c) 2013 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 */

//date_default_timezone_set('America/Los_Angeles');
include_once 'ApplicationHeader.php';
//$cityListHtml    = $oMaster->getCityListHTML();
$stateListHtml   = $oMaster->getStateListHTML();
$countryListHtml = $oMaster->getCountryListHTML();
$html            = $oMaster->getHTML();

	 $oAssetVendor = &Singleton::getInstance('Vendor');
	 $oAssetVendor->setDb($oDb);

$dropdown = "

<div class='control-group'>
                                       <label class='control-label'>Vendor Item Group<span class='required'>*</span></label>
                                       <div class='controls'>
                                         <select class='large m-wrap' tabindex='7' name='fVendorGroupId[]' id='fVendorGroupId'  multiple='multiple'>
											
											  <option value='0'>Choose the Item Group</option> ";
											  $aIGList = $oMaster->getItemGroup1List();
											  foreach($aIGList as $aItemGroup)
											  {
			  
											 
                                          $dropdown .= "<option value='".$aItemGroup['id_itemgroup1']."'";
											  if($edit_address['id_state'] == $aItemGroup['id_itemgroup1']) {  "selected=selected"; } 
											  $dropdown .= ">".$aItemGroup['itemgroup1_name']."</option>";
                                             
											  }
											
                                      $dropdown .= " </select>	 </div> </div>
";


// Process
$action = isset($_POST["action"]) ? $_POST["action"] : "";
if (empty($action)) {
	// Send back the contact form HTML
	$output = "<div style='display:none'>
	<div class='contact-top'></div>
	<div class='contact-content'>
		<h1 class='contact-title'>Add Vendor:</h1>
		<div class='contact-loading' style='display:none'></div>
		<div class='contact-message' style='display:none'></div>
		<form action='#' style='display:none'>
			<label for='contact-name'>*Vendor Name:</label>
			<input type='text' id='contact-name' class='contact-input' name='fVendorName' tabindex='1001' />
			<label for='contact-name'>*Lookup:</label>
			<input type='text' id='contact-lookup' class='contact-input' name='fLookup' tabindex='1002' />
			<label for='contact-name'>*Tin Number:</label>
			<input type='text' id='contact-tinnumber' class='contact-input' name='fTinNumber' tabindex='1003' />
			<label for='contact-name'>*CST Number:</label>
			<input type='text' id='contact-cstnumber' class='contact-input' name='fCSTNumber' tabindex='1004' />
			$dropdown
			\n";

	

	$output .= "
			<label>&nbsp;</label>
			<button type='submit' class='contact-send contact-button' tabindex='1006'>Add Vendor</button>
			<button type='submit' class='contact-cancel contact-button simplemodal-close' tabindex='1007'>Cancel</button>
			<br/>
			</form>
	</div>
	
</div>";

	echo $output;
}
else if ($action == "send") {
	// Send the email
	$aRequest = array();
	$aRequest['fVendorName']  = isset($_POST["fVendorName"]) ? $_POST["fVendorName"] : ""; 
	$aRequest['fUserType']     = isset($_POST["fUserType"]) ? $_POST["fUserType"] : "SUP";
	$aRequest['fLookup']     = isset($_POST["fLookup"]) ? $_POST["fLookup"] : "";
	$aRequest['fTinNumber']     = isset($_POST["fTinNumber"]) ? $_POST["fTinNumber"] : "";
	$aRequest['fCSTNumber']     = isset($_POST["fCSTNumber"]) ? $_POST["fCSTNumber"] : "";
	$aRequest["fStatus"]    = isset($_POST["fStatus"]) ? $_POST["fStatus"] : "1";
	$aRequest["fVendorGroupId"]  = isset($_POST["fVendorGroupId"]) ? $_POST["fVendorGroupId"] : "";
	//$cc = isset($_POST["cc"]) ? $_POST["cc"] : "";
	//$token = isset($_POST["token"]) ? $_POST["token"] : "";

	// make sure the token matches
	if($oAssetVendor->addVendor($aRequest)) {
	//smcf_send($name, $email, $subject, $message, $cc);
	  echo "Vendor Added. You have to update his contact details later.";
	} else {
	  echo $xx = implode(",",$aRequest);
	  //echo "Unfortunately, city could not be added.";
	}  
	
}


?>