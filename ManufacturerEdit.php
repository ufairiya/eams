<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
   $action = 'Add';
   $tableName = 'manufacturer';
  $fieldName = 'manufacturer_name';
   $fieldName1 = 'lookup';
  $fieldValue = $aRequest['fManufacturerName']; 
  $fieldValue1 = $aRequest['fLookup']; 
  
  if(isset($aRequest['Update']))
  {
    if($aresult = $oMaster->updateManufacturer($aRequest, 'update'))
	{
	  
	   if($aresult == 1){	  
		 $msg = "Manufacturer Updated.";
	  echo '<script type="text/javascript">window.location.href="Manufacturer.php?msg=updatesucess";</script>';
		  }
		  elseif($aresult == 2)
		  {
		  $msg = 'Manufacture Name or Lookup already Exists'; 
		 
		  }
		  else
		  {
		  $msg = 'Sorry Could not updated';
		  }
	  
	}
	else $msg = "Sorry";
  } //update
  if(isset($aRequest['send']))
  {
    if(!$oMaster->checkExist1($tableName, $fieldName, $fieldValue,$fieldName1,$fieldValue1))
	{
	if($oMaster->addManufacturer($aRequest))
	{
	   $msg = "New Manufacturer Added.";
	  echo '<script type="text/javascript">window.location.href="Manufacturer.php?msg=success";</script>';
	}
	else $msg = "Sorry could not add..";
	} else { $errMsg = 'Manufacture Name or Lookup already Exists.'; }  
  } 
  if($aRequest['action'] == 'edit')
  {
  $action = 'Edit';
	$item_id = $aRequest['fManufacturerId'];
	$edit_result = $oMaster->getManufacturerInfo($item_id,'id');
	 
  } //edit
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|Manufacturer</title>
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
                     Manufacturer
                     <small>Manufacturer master</small>
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
                     <li><a href="#"><?php echo $action;?> Manufacturer</a></li>
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
                                    <a href="Manufacturer.php" class="btn red mini active">Back to List</a>
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
                        <h4><i class="icon-reorder"></i>Add Manufacturer</h4>
                         <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit Manufacturer</h4>
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
                       
                                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_manufacturer" method="post">
									    <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
                       					<?php
										  if(!empty($errMsg))
										  {
										?>
										  <div class="alert alert-success" id="error_msg">
									         <button class="close" data-dismiss="alert"></button>
											 <?php echo $errMsg; ?>
									      <div id= delete_info></div>
								         </div>
										<?php
										  }
										?>
                       						     	                                     
                                    <div class="control-group">
                                       <label class="control-label">Manufacturer Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="1" class="m-wrap large" name="fManufacturerName" data-required="1" value="<?php echo (!empty($edit_result['manufacturer_name'])? $edit_result['manufacturer_name']:$aRequest['fManufacturerName']); ?>">                                          <span class="help-inline">Enter Manufacturer name</span>
                                       </div>
                                    </div>
									                                       
                                    <div class="control-group">
                                       <label class="control-label">Lookup<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="2"  class="m-wrap small" name="fLookup" maxlength="3" data-required="1" value="<?php echo (!empty($edit_result['lookup'])? $edit_result['lookup']:$aRequest['fLookup']);?>"/>
                                          <span class="help-inline">Enter Lookup</span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" tabindex="3" value="1" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus']) == '1') { echo 'checked=checked' ;}?> />
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" tabindex="4" value="0" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus']) == '0') { echo 'checked=checked' ;}?> />
                                          In-Active
                                          </label>  
										   <div id="form_2_membership_error"></div> 
                                       </div>
                                    </div>
                                
									<div class="loading disabled"><p>Please wait until the Process will  Complete.</p></div>
                                    <div class="form-actions">
                                   <?php if($aRequest['action'] == 'Add')
								   {
								   ?>
								   <input type="hidden" name="action" value="Add">
                                   <button type="submit" tabindex="5" class="btn blue ajax_bt" name="send"><i class="icon-ok"></i>Add Manufacturer</button>                          
								   <?php
								   } else {
								   ?>
								   <input type="hidden" name="action" value="edit">
								     <input type="hidden" name="fManufacturerId" value="<?php echo $aRequest['fManufacturerId'];?>"/>
                                    <button type="submit" tabindex="5" class="btn blue ajax_bt" name="Update"><i class="icon-ok"></i>Update Manufacturer</button> 
                                   <?php
								   } 
								   ?>
								   
								   <button type="button" tabindex="6" class="btn">Cancel</button>
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