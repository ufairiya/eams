<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
      $tableName = 'country';
  $fieldName = 'country_name';
  $fieldValue = $aRequest['fCountryName'];  
  if(isset($aRequest['Update']))
  {
    if($aresult =$oMaster->updateCountry($aRequest, 'update'))
	{
	  
	   if($aresult == 1){	  
		 $msg = "New Country Updated.";
	    echo '<script type="text/javascript">window.location.href="Country.php?msg=updatesucess";</script>';
		  }
		  elseif($aresult == 2)
		  {
		  $msg = 'Country Name already Exists'; 
		 
		  }
		  else
		  {
		  $msg = 'Sorry Could not updated';
		  }
	 
	 
	}
	else $msg = $_aErrorMsg['Duplicate']; //"Duplicate value. Please try again.";
  } //update
  if(isset($aRequest['send']))
  {
     if(!$oMaster->checkExist($tableName, $fieldName, $fieldValue))
	{
	if($oMaster->addCountry($aRequest))
	{
	   $msg = "New Country Added.";
	  echo '<script type="text/javascript">window.location.href="Country.php?msg=success";</script>';
	}
	else $msg = $_aErrorMsg['Duplicate']; //"Duplicate Entry. Please try with a different value.";
	} else { $errMsg = 'Country Name already Exists.'; }  
  } 
  if($aRequest['action'] == 'edit')
  {
	$item_id = $aRequest['fCountryId'];
	$edit_result = $oMaster->getCountryInfo($item_id,'id');
	 
  } //edit
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|Country</title>
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
                     Country
                     <small>Country master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Territory</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Country</a></li>
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
                                    <a href="Country.php" class="btn red mini active">Back to List</a>
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
                        <h4><i class="icon-reorder"></i>Add Country</h4>
                         <?php } else if($aRequest['action'] == 'edit'){?>
                          <h4><i class="icon-reorder"></i>Edit Country</h4>
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
                       
                                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_country_addnew" method="post">
									    <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
						   
						            <?php
										  if(!empty($errMsg))
										  {
										?>
										  <div class="alert  alert-info" id="error_msg">
									         <button class="close" data-dismiss="alert"></button>
											 <?php echo $errMsg; ?>
									      <div id= delete_info></div>
								         </div>
										<?php
										  }
										?>
                       						                                     
                                    <div class="control-group">
                                       <label class="control-label">Country Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fCountryName" data-required="1" value="<?php echo (!empty($edit_result['country_name'])? $edit_result['country_name']:$aRequest['fCountryName']); ?>"/>										  <span class="help-inline">Enter Country name</span>
                                       </div>
                                    </div>
									                                       
                                    <div class="control-group">
                                       <label class="control-label">Lookup<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fLookup" maxlength="3" data-required="1" value="<?php echo (!empty($edit_result['lookup'])? $edit_result['lookup']:$aRequest['fLookup']);?>"/>
                                          <span class="help-inline">Enter Lookup</span>
                                       </div>
                                    </div>
									
									
									 <div class="control-group">
                                       <label class="control-label">Currency<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fCurrency" data-required="1" value="<?php echo (!empty($edit_result['currency'])? $edit_result['currency']:$aRequest['fCurrency']);?>"/>
                                          <span class="help-inline">Enter Currency</span>
                                       </div>
                                    </div>
									
									
									 <div class="control-group">
                                       <label class="control-label">Currency Code<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fCurrencyCode" data-required="1" value="<?php echo (!empty($edit_result['currency_code'])? $edit_result['currency_code']:$aRequest['fCurrencyCode']);?>"/>
                                          <span class="help-inline">Enter Currency code</span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="1" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus']) === '1') { echo 'checked=checked' ;}?> />
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="0" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus']) == '0') { echo 'checked=checked' ;}?> />
                                          In-Active
                                          </label>  
                                          <div id="form_2_membership_error"></div> 
                                       </div>
                                    </div>
                               
									
                                    <div class="form-actions">
                                   <?php if($aRequest['action'] == 'Add')
								   {
								   ?>
                                   <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Add Country</button> 
                                   <input type="hidden" name="action" value="Add"/>                         
								   <?php
								   } else {
								   ?>
                                    <button type="submit" class="btn blue" name="Update"><i class="icon-ok"></i>Update Country</button> 
                                       <input type="hidden" name="fCountryId" value="<?php echo $aRequest['fCountryId'];?>"/>
                                       <input type="hidden" name="action" value="edit"/>
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