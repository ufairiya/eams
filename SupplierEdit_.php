<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  
 $oAssetUnit = &Singleton::getInstance('AssetUnit');
 $oAssetUnit->setDb($oDb);
 
  $oAssetVendor = &Singleton::getInstance('Vendor');
  $oAssetVendor->setDb($oDb);
  $oAssetAddress = &Singleton::getInstance('Address');
  $oAssetAddress->setDb($oDb);
   
   $tableName = 'vendor';
  $fieldName = 'vendor_name';
  $fieldValue = $aRequest['fVendorName']; 
   $fieldName1 = 'lookup';
  $fieldValue1 = $aRequest['fLookup']; 
  $fieldName2 = 'id_vendor';
   $fieldValue2 = $aRequest['fVendorId'];  
   if(isset($aRequest['add']))
  {
if(!$oMaster->checkExist($tableName, $fieldName, $fieldValue))
	{
	if(!$oMaster->checkExist($tableName, $fieldName1, $fieldValue1))
	{
    if($newVendorId = $oAssetVendor->addVendor($aRequest))
	{
		if($newAddressId = $oMaster->addContact($aRequest,$newVendorId))
		{
		  
		   $oAssetVendor->updateAddress($newAddressId,$newVendorId);
		     $msg = "New Vendor Added.";
	  		 echo '<script type="text/javascript">window.location.href="Supplier.php?msg=success";</script>';
		}
		else
		{
			 echo '<script type="text/javascript">window.location.href="Supplier.php?action=edit&id='.$newVendorId.'&msg=unsuccess";</script>';
		}
	 
	}
	else $msg = "Sorry not added";
	}
	 else { $errMsg = 'Vendor Lookup already Exists.'; }   
	}
	 else { $errMsg = 'Vendor Name already Exists.'; }   
  }
  
 
  if($aRequest['action'] == 'edit')
  {
	 $item_id = $aRequest['fVendorId'];
	 $edit_result = $oAssetVendor->getVendorInfo($item_id,'id');
	 $edit_address = $oMaster->getContactInfo($edit_result['id_vendor_address'],'id');
	

	 //$edit_address = $oAssetAddress->getAddressInfo($edit_result['id_vendor_address']);
  } //edit
    if(isset($aRequest['update']))
    {
      if(!$oMaster->updateCheckExist($tableName, $fieldName, $fieldValue,$fieldName2,$fieldValue2))
	{
	 if(!$oMaster->updateCheckExist($tableName,$fieldName1,$fieldValue1,$fieldName2,$fieldValue2))
   {
	if($oAssetVendor->updateVendor($aRequest))
	{
		$VendorAddreess= $oAssetVendor->getVendorInfo($aRequest['fVendorId']);
		
		if($VendorAddreess['id_vendor_address']!='')
		{
			$newAddressId = $oMaster->updateContact($aRequest,'update');
		}
		else
		{
		  $newAddressId = $oMaster->addContact($aRequest);
		  $oAssetVendor->updateAddress($newAddressId,$aRequest['fVendorId']);
		}
		  
	   $msg = "New Vendor Updated.";
	 echo '<script type="text/javascript">window.location.href="Supplier.php?msg=updatesucess";</script>';
	}
	else $msg = "Sorry not updated";
	 }
	  else { $errMsg = 'Vendor Lookup already Exists.'; } 
	  }
	 else { $errMsg = 'Vendor Name already Exists.'; }   
  } //update
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|Vendor </title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <meta http-equiv="Cache-control" content="No-Cache">
   
   
  <?php include('Stylesheets.php');?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	<?php include_once 'Header.php'; ?>
	<!-- END HEADER -->
   <!-- BEGIN CONTAINER -->
   <div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
        <?php include_once 'LeftMenu.php'; ?>
		<!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->  
      <div class="page-content">
         <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
         <div id="portlet-config" class="modal hide">
            <div class="modal-header">
               <button data-dismiss="modal" class="close" type="button"></button>
               <h3>portlet Settings</h3>
            </div>
            <div class="modal-body">
               <p>Here will be a configuration form</p>
            </div>
         </div>
         <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN STYLE CUSTOMIZER -->
                 
                  <!-- END STYLE CUSTOMIZER -->  
                  <h3 class="page-title">
                    Vendor
                     <small>Vendor master</small>
                  </h3>
                  <ul class="breadcrumb">
                      <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                      <li>
                        <a href="#">Masters</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="AssetBuilding.php">Vendor</a>
                        <span class="icon-angle-right"></span>
                     </li>
                      <?php if($_REQUEST['action']=='edit')
					 {?>
                     <li><a href="#">Edit Vendor </a></li>
                     <?php } else {?>
                        <li><a href="#">Add Vendor </a></li>
                     <?php } ?>
                  </ul>
               </div>
            </div>
            
                              <?php
							     if(isset($msg))
								 {
							   ?>
							    <div class="alert alert-success">
									<button class="close" data-dismiss="alert"></button>
									<?php echo $msg; unset($msg); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="AssetBuilding.php" class="btn red mini active">Back to List</a>
								</div>
                                
								<?php
								  }
								?> 
                                <div class="alert alert-success" id="error_msg" style="display:none">
									<button class="close" data-dismiss="alert"></button>
									<div id= delete_info></div>
								</div>
                                <?php
							     if(isset($_GET['msg']))
								 {
							   ?>
							    <div class="alert alert-success">
									<button class="close" data-dismiss="alert"></button>
									<?php
									
									if($_GET['msg'] == 'unsuccess')
									{
										echo $msg = 'New Vendor Address is not inserted please try again';
									}
									
									   ?>
								</div>
                                
								<?php
								  }
								?> 
                                
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
        
            			
            <div class="row-fluid">
               <div class="span12">
               
               <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue">
                     <div class="portlet-title">
					  <?php if($_REQUEST['action'] == 'Add')
								   {?>
                        <h4><i class="icon-reorder"></i>Add Vendor Form</h4>
                         <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit Vendor Form</h4>
                        <?php } ?>
                       
                        <div class="tools">
                           <a href="javascript:;" class="collapse"></a>
                           <a href="#portlet-config" data-toggle="modal" class="config"></a>
                           <a href="javascript:;" class="reload"></a>
                           <a href="javascript:;" class="remove"></a>
                        </div>
                     </div>
                     <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                       
                                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_supplier_addnew" method="post">
									    <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
                       
								 <?php
										  if(!empty($errMsg))
										  {
										?>
										  <div class="alert alert-info" id="error_msg">
									         <button class="close" data-dismiss="alert"></button>
											 <?php echo $errMsg; ?>
									      <div id= delete_info></div>
								         </div>
										<?php
										  }
										?>      
                                       
                                    <div class="control-group">
                                       <label class="control-label">Vendor Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder=""  tabindex="1"  class="m-wrap large" name="fVendorName" data-required="1" value="<?php echo (!empty($edit_result['vendor_name'])? $edit_result['vendor_name']:$aRequest['fVendorName']);?>"/>
                                          <span class="help-inline">Enter Vendor name</span>
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Lookup<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder=""  tabindex="2" class="m-wrap xsmall" name="fLookup" data-required="1" value="<?php echo (!empty($edit_result['lookup'])? $edit_result['lookup']:$aRequest['fLookup']);?>" maxlength="3"/>
                                          <span class="help-inline">Enter Lookup</span>
                                       </div>
                                       </div>
									                                       
                                    <div class="control-group">
                                       <label class="control-label">Vendor Address1<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="3"  class="m-wrap large" name="fAddr1" data-required="1" value="<?php echo (!empty($edit_address['addr1'])? $edit_address['addr1']:$aRequest['fAddr1']);?>"/>
                                          <span class="help-inline">Enter Vendor Address1</span>
                                       </div>
                                    </div>
                                    
                                       <div class="control-group">
                                       <label class="control-label">Vendor Address2<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="4"  class="m-wrap large" name="fAddr2" data-required="1" value="<?php echo (!empty($edit_address['addr2'])? $edit_address['addr2']:$aRequest['fAddr2']);?>"/>
                                          <span class="help-inline">Enter Vendor Address2</span>
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Vendor Address3</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="4" class="m-wrap large" name="fAddr3" data-required="1" value="<?php echo (!empty($edit_address['addr3'])? $edit_address['addr3']:$aRequest['fAddr3']);?>"/>
                                          <span class="help-inline">Enter Vendor Address3</span>
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Vendor Pincode<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="5"  class="m-wrap large" name="fZipCode" data-required="1" value="<?php echo (!empty($edit_address['zipcode'])? $edit_address['zipcode']:$aRequest['fZipCode']);?>"/>
                                          <span class="help-inline">Enter Vendor Pincode</span>
                                       </div>
                                    </div>
                                      <div class="control-group">
                                       <label class="control-label">Vendor City<span class="required">*</span></label>
                                       <div class="controls">
                                         <select class="large m-wrap" tabindex="6" name="fCityId" id="fCityId">
											 <option value="0">Choose the City</option>
											 <?php
											  $aCityList = $oMaster->getCityList();
											  foreach($aCityList as $aCity)
											  {
			  
											 ?>
                                             <option value="<?php echo $aCity['id_city']; ?>" <?php if((!empty($edit_address['id_city'])? $edit_address['id_city']:$aRequest['fCityId']) == $aCity['id_city']) { echo 'selected=selected' ;}?>><?php echo $aCity['city_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										  <span><a href="#" class="contact" title="Add New City"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                          <span class="help-inline">Enter Vendor City</span>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Vendor State<span class="required">*</span></label>
                                       <div class="controls">
                                         <select class="large m-wrap" tabindex="7" name="fStateId" id="fStateId">
											
											  <option value="0">Choose the State</option> <?php
											  $aStateList = $oMaster->getStateList();
											  foreach($aStateList as $aState)
											  {
			  
											 ?>
                                             <option value="<?php echo $aState['id_state']; ?>" <?php if((!empty($edit_address['id_state'])? $edit_address['id_state']:$aRequest['fStateId']) == $aState['id_state']) { echo 'selected=selected' ;}?>><?php echo $aState['state_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										   <span><a href="#" class="state" title="Add New State"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                          <span class="help-inline">Enter Vendor State</span>
                                       </div>
                                    </div>
                                    
                                      
                                    
                                     <div class="control-group">
                                       <label class="control-label">Vendor Country<span class="required">*</span></label>
                                       <div class="controls">
                                        <select class="large m-wrap" tabindex="8" name="fCountryId" id="fCountryId">
											 <option value="0">Choose the Country</option>
											 <?php
											  $aCountryList = $oMaster->getCountryList();
											  foreach($aCountryList as $aCountry)
											  {
			  
											 ?>
                                             <option value="<?php echo $aCountry['id_country']; ?>" <?php if((!empty($edit_address['id_country'])? $edit_address['id_country']:$aRequest['fCountryId']) == $aCountry['id_country']) { echo 'selected=selected' ;}?>><?php echo $aCountry['country_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                       <span><a href="#" class="country" title="Add New Country"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                          <span class="help-inline">Enter Vendor Country</span>
                                       </div>
                                    </div>
                                    
                                     <div class="control-group">
                                       <label class="control-label">Vendor Phone<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="9"  class="m-wrap large" name="fPhone" data-required="1" value="<?php echo (!empty($edit_address['phone'])? $edit_address['phone']:$aRequest['fPhone']);?>"/>
                                          <span class="help-inline">Enter Vendor Phone</span>
                                       </div>
                                    </div>
                                    
                                      
                                    
                                       <div class="control-group">
                                       <label class="control-label">Vendor Email</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="10"  class="m-wrap large" name="fEmail" data-required="1" value="<?php echo (!empty($edit_address['email'])? $edit_address['email']:$aRequest['fEmail']);?>"/>
                                          <span class="help-inline">Enter Vendor Email</span>
                                       </div>
                                    </div>
                                    
                                      
                                    
                                      <div class="control-group">
                                       <label class="control-label">Vendor Fax</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="11" class="m-wrap large" name="fFax" data-required="1" value="<?php echo (!empty($edit_address['fax'])? $edit_address['fax']:$aRequest['fFax']);?>"/>
                                          <span class="help-inline">Enter Vendor Fax</span>
                                       </div>
                                    </div>
                                    
                                      
                                    
                                    <div class="control-group">
                                       <label class="control-label">Vendor Contact Person<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="12"  class="m-wrap large" name="fContactName" data-required="1" value="<?php echo (!empty($edit_address['contact_name'])? $edit_address['contact_name']:$aRequest['fContactName']);?>"/>
                                          <span class="help-inline">Enter Vendor Contact Person</span>
                                       </div>
                                    </div>
                                    
                                      <div class="control-group">
                                       <label class="control-label">TIN Number</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="13" class="m-wrap large" name="fTinNumber" data-required="1" value="<?php echo (!empty($edit_result['tin_no'])? $edit_result['tin_no']:$aRequest['fTinNumber']);?>"/>
                                          <span class="help-inline">Enter TIN</span>
                                       </div>
                                    </div>
									
                                    <div class="control-group">
                                       <label class="control-label">CST Number</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="14" class="m-wrap large" name="fCSTNumber" data-required="1" value="<?php echo (!empty($edit_result['cst_no'])? $edit_result['cst_no']:$aRequest['fCSTNumber']);?>"/>
                                          <span class="help-inline">Enter CST</span>
                                       </div>
                                    </div>
									
									
									 <div class="control-group">
                                       <label class="control-label">Vendor Item Group<span class="required">*</span></label>
                                       <div class="controls">
									 
                                         <select class="large m-wrap" tabindex="7" name="fVendorGroupId[]" id="fVendorGroupId"  multiple="multiple">
											
											  <option value="0">Choose the Item Group</option> <?php
											  $aIGList = $oMaster->getItemGroup1List();
											  foreach($aIGList as $aItemGroup)
											  {
											    $itemresult = explode(",",$edit_result['id_itemgroup1']);
												$result = in_array($aItemGroup['id_itemgroup1'], $itemresult);
											 ?>
                                             <option value="<?php echo $aItemGroup['id_itemgroup1']; ?>" <?php if((!empty($result)? $result :$aRequest['fVendorGroupId']) == $aItemGroup['id_itemgroup1']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup['itemgroup1_name']; ?></option>
                                             <?php
											
											  }
											 ?>
                                          </select>
										   <span><a href="#" class="state" title="Add New Item Group1"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                          <span class="help-inline">Multiple Item Groups can be selected</span>
                                       </div>
                                    </div>
									
									
									
									 <div class="control-group">
                                       <label class="control-label">Vendor Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" tabindex="15"  value="1" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus']) == 1) { echo 'checked=checked' ;}?> />
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" tabindex="16" value="0" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus']) == 0) { echo 'checked=checked' ;}?> />
                                          In-Active
                                          </label>  
										  <div id="form_2_membership_error"></div> 
                                       </div>
                                    </div>
                                
									<input type="hidden" name="fUserType" value="SUP"/>
                                    <div class="form-actions">
                                    <?php if($_REQUEST['action'] == 'Add')
								   {?>
								     <button type="submit" class="btn blue" name="add"><i class="icon-ok"></i>Add Vendor</button> 
                                     <input type="hidden" name="action" value="Add"/>
								    <?php } else if($_REQUEST['action'] == 'edit') {?>
                                     
									  <input type="hidden" name="fVendorId" value="<?php echo $aRequest['fVendorId'];?>"/>
                                      <input type="hidden" name="fContactId" value="<?php echo (!empty($edit_result['id_vendor_address'])? $edit_result['id_vendor_address']:$aRequest['fContactId']);?>"/>
                                      <button type="submit" class="btn blue" name="update"><i class="icon-ok"></i>Update Vendor</button> 
                                      <input type="hidden" name="action" value="edit"/>
                                      

								   <?php } else {?>
								     <button type="submit" class="btn blue" name="add"><i class="icon-ok"></i>Add Vendor</button> 
                                     <input type="hidden" name="action" value="Add"/>
								   <?php } ?>
                                                              <button type="button" class="btn">Cancel</button>
                                    </div>
                                 </form>
                               
                        <!-- END FORM-->           
                     </div>
                  </div>
                  <!-- END SAMPLE FORM PORTLET-->
                
               </div>
            </div>
            <!-- END PAGE CONTENT-->         
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      
      
      <!-- END PAGE -->  
   </div>
   <!-- END CONTAINER -->
	<?php include_once 'Footer1.php'; ?>
</body>
<!-- END BODY -->
</html>