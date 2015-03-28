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
    
   if(isset($aRequest['add']))
  {
    if($newVendorId = $oAssetVendor->addVendor($aRequest))
	{
		if($newAddressId = $oAssetAddress->addAddress($aRequest))
		{
		   $oAssetVendor->updateAddress($newAddressId,$newVendorId);
		     $msg = "New Vendor Added.";
	  		 echo '<script type="text/javascript">window.location.href="Customer.php?msg=success";</script>';
		}
		else
		{
			 
			   echo '<script type="text/javascript">window.location.href="CustomerEdit.php?action=edit&id='.$newVendorId.'&msg=unsuccess";</script>';
		}
	 
	}
	else $msg = $_aErrorMsg['Duplicate']; //"Sorry not added";
  }
  
 
  if($aRequest['action'] == 'edit')
  {
	 $item_id = $_REQUEST['id'];
	$edit_result = $oAssetVendor->getVendorInfo($item_id,'id');
	$edit_address = $oAssetAddress->getAddressInfo($edit_result['id_vendor_address']);
  } //edit
    if(isset($aRequest['update']))
  {
	
    if($oAssetVendor->updateVendor($aRequest))
	{
		$VendorAddreess= $oAssetVendor->getVendorInfo($aRequest['fVendorID']);
		if($VendorAddreess['id_vendor_address']!='')
		{
			$newAddressId = $oAssetAddress->updateAddress($aRequest,$VendorAddreess['id_vendor_address']);
		}
		else
		{
		 $newAddressId = $oAssetAddress->addAddress($aRequest);
		 $oAssetVendor->updateAddress($newAddressId,$aRequest['fVendorID']);
		}
		  
	   $msg = "New Vendor Updated.";
	 echo '<script type="text/javascript">window.location.href="Customer.php?msg=updatesucess";</script>';
	}
	else $_aErrorMsg['Duplicate']; //$msg = "Sorry not updated";
  } //update
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|Customer</title>
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
                        <a href="#">Participants</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="AssetBuilding.php">Customer</a>
                        <span class="icon-angle-right"></span>
                     </li>
                      <?php if($_REQUEST['action']=='edit')
					 {?>
                     <li><a href="#">Edit Customer </a></li>
                     <?php } else {?>
                        <li><a href="#">Add Customer </a></li>
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
                        <h4><i class="icon-reorder"></i>Add Customer Form</h4>
                         <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit Customer Form</h4>
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
                       
                                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_sample_3" method="post">
									    <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
                       
								 
                                       
                                    <div class="control-group">
                                       <label class="control-label">Customer Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fVendorName" data-required="1" value="<?php echo $edit_result['vendor_name'];?>"/>
                                          <span class="help-inline">Enter Customer name</span>
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Lookup<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fLookup" data-required="1" value="<?php echo $edit_result['lookup'];?>"/>
                                          <span class="help-inline">Enter Lookup</span>
                                       </div>
                                       </div>
									                                       
                                    <div class="control-group">
                                       <label class="control-label">Customer Address1<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fAddress1" data-required="1" value="<?php echo $edit_address['address1'];?>"/>
                                          <span class="help-inline">Enter Customer Address1</span>
                                       </div>
                                    </div>
                                    
                                       <div class="control-group">
                                       <label class="control-label">Customer Address2</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fAddress2" data-required="1" value="<?php echo $edit_address['address2'];?>"/>
                                          <span class="help-inline">Enter Customer Address2</span>
                                       </div>
                                    </div>
                                    
                                      <div class="control-group">
                                       <label class="control-label">Customer City<span class="required">*</span></label>
                                       <div class="controls">
                                         <select class="large m-wrap" tabindex="1" name="fCityId">
											 <?php
											  $aCityList = $oMaster->getCityList();
											  foreach($aCityList as $aCity)
											  {
			  
											 ?>
                                             <option value="<?php echo $aCity['id_city']; ?>" <?php if($edit_address['city'] == $aCity['id_city']) { echo 'selected=selected' ;}?>><?php echo $aCity['city_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                          <span class="help-inline">Enter Customer City</span>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Customer State<span class="required">*</span></label>
                                       <div class="controls">
                                         <select class="large m-wrap" tabindex="1" name="fStateId">
											 <?php
											  $aStateList = $oMaster->getStateList();
											  foreach($aStateList as $aState)
											  {
			  
											 ?>
                                             <option value="<?php echo $aState['id_state']; ?>" <?php if($edit_address['state'] == $aState['id_state']) { echo 'selected=selected' ;}?>><?php echo $aState['state_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                          <span class="help-inline">Enter Customer State</span>
                                       </div>
                                    </div>
                                    
                                      <div class="control-group">
                                       <label class="control-label">Customer Pincode<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fPincode" data-required="1" value="<?php echo $edit_address['pincode'];?>"/>
                                          <span class="help-inline">Enter Customer Pincode</span>
                                       </div>
                                    </div>
                                    
                                     <div class="control-group">
                                       <label class="control-label">Customer Country<span class="required">*</span></label>
                                       <div class="controls">
                                        <select class="large m-wrap" tabindex="1" name="fCountryId">
											 <?php
											  $aCountryList = $oMaster->getCountryList();
											  foreach($aCountryList as $aCountry)
											  {
			  
											 ?>
                                             <option value="<?php echo $aCountry['id_country']; ?>" <?php if($edit_address['country'] == $aCountry['id_country']) { echo 'selected=selected' ;}?>><?php echo $aCountry['country_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                       
                                          <span class="help-inline">Enter Customer Country</span>
                                       </div>
                                    </div>
                                    
                                     <div class="control-group">
                                       <label class="control-label">Customer Phone1<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fPhone1" data-required="1" value="<?php echo $edit_address['phone1'];?>"/>
                                          <span class="help-inline">Enter Customer Phone1</span>
                                       </div>
                                    </div>
                                    
                                      <div class="control-group">
                                       <label class="control-label">Customer Phone2</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fPhone2" data-required="1" value="<?php echo $edit_address['phone2'];?>"/>
                                          <span class="help-inline">Enter Customer Phone2</span>
                                       </div>
                                    </div>
                                    
                                       <div class="control-group">
                                       <label class="control-label">Customer Email1</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fEmail1" data-required="1" value="<?php echo $edit_address['email1'];?>"/>
                                          <span class="help-inline">Enter Customer Email1</span>
                                       </div>
                                    </div>
                                    
                                      <div class="control-group">
                                       <label class="control-label">Customer Email2</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fEmail2" data-required="1" value="<?php echo $edit_address['email2'];?>"/>
                                          <span class="help-inline">Enter Customer Email2</span>
                                       </div>
                                    </div>
                                    
                                      <div class="control-group">
                                       <label class="control-label">Customer Fax1</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fFax1" data-required="1" value="<?php echo $edit_address['fax1'];?>"/>
                                          <span class="help-inline">Enter Customer Fax1</span>
                                       </div>
                                    </div>
                                    
                                      <div class="control-group">
                                       <label class="control-label">Customer Fax2</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fFax2" data-required="1" value="<?php echo $edit_address['fax2'];?>"/>
                                          <span class="help-inline">Enter Customer Fax2</span>
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Customer Contact Person1<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fContactPerson1" data-required="1" value="<?php echo $edit_address['contactperson1'];?>"/>
                                          <span class="help-inline">Enter Customer Contact Person1</span>
                                       </div>
                                    </div>
                                    
                                      <div class="control-group">
                                       <label class="control-label">Customer Contact Person2</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fContactPerson2" data-required="1" value="<?php echo $edit_address['contactperson2'];?>"/>
                                          <span class="help-inline">Enter Customer Contact Person2</span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Customer Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="1" <?php if($edit_result['status'] == 1) { echo 'checked=checked' ;}?> />
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="0" <?php if($edit_result['status'] == 0) { echo 'checked=checked' ;}?> />
                                          In-Active
                                          </label>  
                                       </div>
                                    </div>
                                  <input type="hidden" name="fVendorID" value="<?php echo $_GET['id'];?>"/>
										<input type="hidden" name="fUserType" value="CUS"/>
                                    <div class="form-actions">
                                    <?php if($_REQUEST['action'] == 'Add')
								   {?>
								     <button type="submit" class="btn blue" name="add"><i class="icon-ok"></i>Add Customer</button> 
								    <?php } else {?>
									  <button type="submit" class="btn blue" name="update"><i class="icon-ok"></i>Update Customer</button> 
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