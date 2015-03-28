<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;

   
  if(isset($aRequest['Update']))
  {
    if($oMaster->updateCompany($aRequest, $_FILES, 'update'))
	{
	  $msg = "New Company Updated.";
	  echo '<script type="text/javascript">window.location.href="Company.php?msg=updatesucess";</script>';
	}
	else $msg = $_aErrorMsg['Duplicate']; //"Sorry";
  } //update
  if(isset($aRequest['send']))
  {
    if($oMaster->addCompany($aRequest, $_FILES))
	{
	   $msg = "New Company Added.";
	  echo '<script type="text/javascript">window.location.href="Company.php?msg=success";</script>';
	}
	else $msg = $_aErrorMsg['Duplicate']; //"Sorry could not add..";
  } 
  if($aRequest['action'] == 'edit')
  {
	$item_id = $aRequest['fCompanyId'];
	$edit_result = $oMaster->getCompanyInfo($item_id,'id');
	 
  } //edit
  if(empty($edit_result))
  {
  $edit_result['status'] = 1;
  }
  
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|Company</title>
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
                     Company
                     <small>Company master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Company</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Company</a></li>
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
                                    <a href="Company.php" class="btn red mini active">Back to List</a>
								</div>
                                
								<?php
								  }
								?> 
                                <div class="alert alert-success" id="error_msg" style="display:none">
									<button class="close" data-dismiss="alert"></button>
									<div id= delete_info></div>
								</div>
                                
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
        
            			
            <div class="row-fluid">
               <div class="span12">
               
               <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue">
                     <div class="portlet-title">
                      <?php if($aRequest['action'] == 'Add')
							{ ?>
                        <h4><i class="icon-reorder"></i>Add Company</h4>
                         <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit Company</h4>
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
                       
                                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_company_addnew" method="post" enctype="multipart/form-data">
									<div class="alert alert-error hide">
									  <button class="close" data-dismiss="alert"></button>
									  You have some form errors. Please check below.
								   </div>
                       						                                     
                                    <div class="control-group">
                                       <label class="control-label">Company Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fCompanyName" data-required="1" tabindex="1" value="<?php echo (!empty($edit_result['company_name'])? $edit_result['company_name']:$aRequest['fCompanyName']); ?>"/>                                        
										   <span class="help-inline">Enter Company name</span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Prefix</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap small" name="fPrefix" tabindex="2" data-required="1" value="<?php echo (!empty($edit_result['prefix'])? $edit_result['prefix']:$aRequest['fPrefix']);?>" maxlength="3"/>                                          <span class="help-inline">Enter Company Prefix</span>
                                       </div>
                                    </div>
									                                       
                                    <div class="control-group">
                                       <label class="control-label">Lookup<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="3" class="m-wrap large" name="fLookup" data-required="1" value="<?php echo (!empty($edit_result['lookup'])? $edit_result['lookup']:$aRequest['fLookup']);?>"/>
                                          <span class="help-inline">Enter Lookup</span>
                                       </div>
                                    </div>
									
									
									 <div class="control-group">
                                       <label class="control-label">Addr Line1<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" tabindex="4" name="fAddr1" data-required="1" value="<?php echo (!empty($edit_result['addr1'])? $edit_result['addr1']:$aRequest['fAddr1']);?>"/>
                                          <span class="help-inline">Enter Address Line</span>
                                       </div>
                                    </div>
									
									
									 <div class="control-group">
                                       <label class="control-label">Addr Line2<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="5" class="m-wrap large" name="fAddr2" data-required="1" value="<?php echo (!empty($edit_result['addr2'])? $edit_result['addr2']:$aRequest['fAddr2']);?>"/>
                                          <span class="help-inline">Enter Address Line</span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Addr Line3</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="6" class="m-wrap large" name="fAddr3" data-required="1" value="<?php echo (!empty($edit_result['addr3'])? $edit_result['addr3']:$aRequest['fAddr3']);?>"/>
                                          <span class="help-inline">Enter Address Line</span>
                                       </div>
                                    </div>
									
									
									<div class="control-group">
                                       <label class="control-label">City</label>
                                       <div class="controls">
                                          <select class=" large m-wrap" tabindex="7" data-placeholder="Choose the City" name="fCityId" id="fCityId">
											 <option value="0">Choose the City</option>
											 <?php
											  $aCityList = $oMaster->getCityList();
											  foreach($aCityList as $aCity)
											  {
			  
											 ?>
                                             <option value="<?php echo $aCity['id_city']; ?>" <?php if((!empty($edit_result['id_city'])? $edit_result['id_city']:$aRequest['fCityId'])== $aCity['id_city']) { echo 'selected=selected' ;}?>><?php echo $aCity['city_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										  <span><a href="#" class="contact" title="Add New City"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                       </div>
                                    </div>
									
									<div class="control-group">
                                       <label class="control-label">State</label>
                                       <div class="controls">
                                          <select class=" large m-wrap" tabindex="8" data-placeholder="Choose the State"  name="fStateId" id="fStateId">
											  <option value="0">Choose the State</option>
											 <?php
											  $aStateList = $oMaster->getStateList();
											  foreach($aStateList as $aState)
											  {
			  
											 ?>
                                             <option value="<?php echo $aState['id_state']; ?>" <?php if((!empty($edit_result['id_state'])? $edit_result['id_state']:$aRequest['fStateId']) == $aState['id_state']) { echo 'selected=selected' ;}?>><?php echo $aState['state_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										    <span><a href="#" class="state" title="Add New State"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Country</label>
                                       <div class="controls">
                                          <select class=" large m-wrap" tabindex="9" data-placeholder="Choose the Country"  name="fCountryId" id="fCountryId">
											  <option value="0">Choose the Country</option>
											 <?php
											  $aCountryList = $oMaster->getCountryList();
											  foreach($aCountryList as $aCountry)
											  {
			  
											 ?>
                                             <option value="<?php echo $aCountry['id_country']; ?>" <?php if((!empty($edit_result['id_country'])? $edit_result['id_country']:$aRequest['fCountryId']) == $aCountry['id_country']) { echo 'selected=selected' ;}?>><?php echo $aCountry['country_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										  <span><a href="#" class="country" title="Add New Country"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Pincode<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder=""  tabindex="10" class="m-wrap large" name="fZipCode" data-required="1" value="<?php echo (!empty($edit_result['zipcode'])? $edit_result['zipcode']:$aRequest['fZipCode']);?>"/>
                                          <span class="help-inline">Enter Pincode</span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Telphone <span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder=""  tabindex="11" class="m-wrap large" name="fPhone" data-required="1" value="<?php echo (!empty($edit_result['phone'])? $edit_result['phone']:$aRequest['fPhone']);?>"/>
                                          <span class="help-inline">Enter Phone number</span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Fax<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="12" class="m-wrap large" name="fFax" data-required="1" value="<?php echo (!empty($edit_result['fax'])? $edit_result['fax']:$aRequest['fFax']);?>"/>
                                          <span class="help-inline">Enter Fax Number</span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Email<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="13" class="m-wrap large" name="fEmail" data-required="1" value="<?php echo (!empty($edit_result['email'])? $edit_result['email']:$aRequest['fEmail']);?>"/>
                                          <span class="help-inline">Enter Email Id</span>
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">TIN No<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="14" class="m-wrap large" name="fTinNo" data-required="1" value="<?php echo (!empty($edit_result['id_tin'])? $edit_result['id_tin']:$aRequest['fTinNo']);?>"/>
                                          <span class="help-inline">Enter TIN Number</span>
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">CST NO/Date <span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="CSTNO/DATE" tabindex="15" class="m-wrap large" name="fCstNoDate" data-required="1" value="<?php echo (!empty($edit_result['id_cst_date'])? $edit_result['id_cst_date']:$aRequest['fCstNoDate']);?>"/>
                                          <span class="help-inline">Enter CST NO/Date</span>
                                       </div>
                                    </div>
                                    
                                    
									
									<div class="control-group">
                                       <label class="control-label">Company Logo</label>
                                       <div class="controls">
                                     <input type="file" class="input-xlarge" tabindex="16" id="fCompanyLogo" name="fCompanyLogo">
                                     <br>
                                     <?php if($edit_result['company_logo']!='')
									 {
										 ?>
                                     <img src="<?php echo "uploads/companylogo/".$edit_result['company_logo'];?>" height="100" width="100"/>
                                     <?php } ?>
                                        </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" tabindex="17" value="1" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus'])== '1') { echo 'checked=checked' ;}?> />
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" tabindex="18" value="0" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus']) == '0') { echo 'checked=checked' ;}?> />
                                          In-Active
                                          </label>  
                                       </div>
                                    </div>
									 <div class="loading disabled"><p>Please wait until the Process will  Complete.</p></div>
                                    <div class="form-actions">
                                   <?php if($aRequest['action'] == 'Add')
								   {
								   ?>
                                   <button type="submit" class="btn blue ajax_bt" name="send"><i class="icon-ok"></i>Add Company</button>   
                                   <input type="hidden" name="action" value="Add"/>                       
								   <?php
								   } else if($aRequest['action'] == 'edit'){
								   ?>
                                    <button type="submit" class="btn blue ajax_bt" name="Update"><i class="icon-ok"></i>Update Company</button> 
                                    <input type="hidden" name="fCompanyId" value="<?php echo $aRequest['fCompanyId'];?>"/>
                                    <input type="hidden" name="action" value="edit"/>
									 <?php } else
								   {
								   ?>
                                   <button type="submit" class="btn blue ajax_bt" name="send"><i class="icon-ok"></i>Add Company</button>   
                                   <input type="hidden" name="action" value="Add"/> 
                                   <?php
								   } 
								   ?>
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