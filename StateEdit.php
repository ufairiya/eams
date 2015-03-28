<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
     $tableName = 'state';
  $fieldName = 'state_name';
  $fieldValue = $aRequest['fStateName'];     
  if(isset($aRequest['Update']))
  {
    if($aresult = $oMaster->updateState($aRequest, 'update'))
	{
	 
	 if($aresult == 1){	  
		  $msg = "New State Updated.";
	  echo '<script type="text/javascript">window.location.href="State.php?msg=updatesucess";</script>';
		  }
		  elseif($aresult == 2)
		  {
		  $msg = 'State Name already Exists'; 
		 
		  }
		  else
		  {
		  $msg = 'Sorry Could not updated';
		  }
	 
	
	}
	else $msg = $_aErrorMsg['Duplicate']; //"Sorry";
  } //update
  if(isset($aRequest['send']))
  {
    
	 if(!$oMaster->checkExist($tableName, $fieldName, $fieldValue))
	{
	if($oMaster->addState($aRequest))
	{
	   $msg = "New State Added.";
	  echo '<script type="text/javascript">window.location.href="State.php?msg=success";</script>';
	}
	else $msg = $_aErrorMsg['Duplicate']; //"Sorry could not add..";
	} else { $errMsg = 'State Name already Exists.'; }  
  } 
  if($aRequest['action'] == 'edit')
  {
	$item_id = $aRequest['fStateId'];
	$edit_result = $oMaster->getStateInfo($item_id,'id');
	 
  } //edit
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|State</title>
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
                     State
                     <small>State master</small>
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
                     <li><a href="#">State</a></li>
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
                                    <a href="State.php" class="btn red mini active">Back to List</a>
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
                        <h4><i class="icon-reorder"></i>Add State</h4>
                         <?php } else if($aRequest['action'] == 'edit'){?>
                          <h4><i class="icon-reorder"></i>Edit State</h4>
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
                       
                                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_state_addnew" method="post">
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
                                       <label class="control-label">State Name<span class="required">*</span></label>
                                       <div class="controls">
                                       <input type="text" placeholder="" class="m-wrap large" name="fStateName" data-required="1" value="<?php echo (!empty($edit_result['state_name'])? $edit_result['state_name']:$aRequest['fStateName']); ?>">     
									                                       <span class="help-inline">Enter State name</span>
                                       </div>
                                    </div>
									                                       
                                    <div class="control-group">
                                       <label class="control-label">Lookup<span class="required">*</span></label>
                                       <div class="controls">
									    <input type="text" placeholder="" class="m-wrap large" name="fLookup" maxlength="3" data-required="1" value="<?php echo (!empty($edit_result['lookup'])? $edit_result['lookup']:$aRequest['fLookup']);?>" />
                                          <span class="help-inline">Enter Lookup</span>
                                       </div>
                                    </div>
									
									
									 <div class="control-group">
                                       <label class="control-label">Country<span class="required">*</span></label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="1" name="fCountryId" id="fCountryId">
                                          <option value="">Choose the Country</option>
											 <?php
											  $aCountryList = $oMaster->getCountryList();
											  foreach($aCountryList as $aCountry)
											  {
			  
											 ?>
                                             <option value="<?php echo $aCountry['id_country']; ?>" <?php if((!empty($edit_result['id_country'])? $edit_result['id_country']:$aRequest['fCountryId']) == $aCountry['id_country']) { echo 'selected=selected' ;}?>><?php echo $aCountry['country_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select> &nbsp;&nbsp;
										   <span><a href="#" class="country" title="Add New Country"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
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
                                   <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Add State</button>  
                                   <input type="hidden" name="action" value="Add"/>                        
								   <?php
								   } else {
								   ?>
                                    <button type="submit" class="btn blue" name="Update"><i class="icon-ok"></i>Update State</button> 
                                    <input type="hidden" name="fStateId" value="<?php echo $aRequest['fStateId'];?>"/>
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