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
    if($oMaster->updateCostCenter($aRequest, 'update'))
	{
	  $msg = "New CostCenter Updated.";
	  echo '<script type="text/javascript">window.location.href="CostCenter.php?msg=updatesucess";</script>';
	}
	else $msg = "Sorry";
  } //update
  if(isset($aRequest['send']))
  {
    if($oMaster->addCostCenter($aRequest))
	{
	   $msg = "New CostCenter Added.";
	  echo '<script type="text/javascript">window.location.href="CostCenter.php?msg=success";</script>';
	}
	else $msg = "Sorry could not add..";
  } 
  if($aRequest['action'] == 'edit')
  {
	$item_id = $aRequest['id'];
	$edit_result = $oMaster->getCostCenterInfo($item_id,'id');
	 print_r($edit_result);
  } //edit
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| CostCenter</title>
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
                     CostCenter
                     <small>CostCenter master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Setup</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">CostCenter</a></li>
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
                                    <a href="CostCenter.php" class="btn red mini active">Back to List</a>
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
                        <h4><i class="icon-reorder"></i>Add CostCenter</h4>
                         <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit CostCenter</h4>
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
                                       <label class="control-label">Cost Center Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fCostCenterName" data-required="1" value="<?php echo $edit_result['costcenter_name']; ?>"/>        <span class="help-inline">Enter Cost Center name</span>
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
                                       <label class="control-label">Cost Group</label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="1" name="fCostGroupId">
											 <?php
											  $aList = $oMaster->getCostGroupList();
											  foreach($aList as $aItem)
											  {
											 ?>
                                             <option value="<?php echo $aItem['id_costgroup']; ?>" <?php if($edit_result['id_costgroup'] == $aItem['id_costgroup']) { echo 'selected=selected' ;}?>><?php echo $aItem['costgroup_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                       </div>
                                    </div>
									<div class="control-group">
                                       <label class="control-label">Account Head</label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="1" name="fAccountHeadId">
											 <?php
											  $aList = $oMaster->getAccountHeadList();
											  foreach($aList as $aItem)
											  {
											 ?>
                                             <option value="<?php echo $aItem['id_accounthead']; ?>" <?php if($edit_result['id_accounthead'] == $aItem['id_accounthead']) { echo 'selected=selected' ;}?>><?php echo $aItem['accounthead_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                       </div>
                                    </div>
									
									
									
									 <div class="control-group">
                                       <label class="control-label">Standard / Kg<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fStandardUnit" data-required="1" value="<?php echo $edit_result['standard_unit']; ?>"/>        <span class="help-inline">Enter Cost Center name</span>
                                       </div>
                                    </div>
																	
									 <div class="control-group">
                                       <label class="control-label">Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="1" <?php if($edit_result['status'] == '1') { echo 'checked=checked' ;}?> />
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="0" <?php if($edit_result['status'] == '0') { echo 'checked=checked' ;}?> />
                                          In-Active
                                          </label>  
                                       </div>
                                    </div>
                                  <input type="hidden" name="fCostCenterId" value="<?php echo $aRequest['id'];?>"/>
									
                                    <div class="form-actions">
                                   <?php if($aRequest['action'] == 'Add')
								   {
								   ?>
                                   <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Add CostCenter</button>                          
								   <?php
								   } else {
								   ?>
                                    <button type="submit" class="btn blue" name="Update"><i class="icon-ok"></i>Update CostCenter</button> 
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