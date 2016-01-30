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
    if($oMaster->updateAccountHead($aRequest, 'update'))
	{
	  $msg = "New AccountHead Updated.";
	  echo '<script type="text/javascript">window.location.href="AccountHead.php?msg=updatesucess";</script>';
	}
	else $msg = "Sorry";
  } //update
  if(isset($aRequest['send']))
  {
    if($oMaster->addAccountHead($aRequest))
	{
	   $msg = "New AccountHead Added.";
	  echo '<script type="text/javascript">window.location.href="AccountHead.php?msg=success";</script>';
	}
	else $msg = "Sorry could not add..";
  } 
  if($aRequest['action'] == 'edit')
  {
	$item_id = $aRequest['id'];
	$edit_result = $oMaster->getAccountHeadInfo($item_id,'id');
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
   <title>EAMS| AccountHead</title>
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
                     AccountHead
                     <small>Account Head master</small>
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
                     <li><a href="#">Account Head</a></li>
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
                                    <a href="AccountHead.php" class="btn red mini active">Back to List</a>
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
                        <h4><i class="icon-reorder"></i>Add Account Head</h4>
                         <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit Account Head</h4>
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
                                       <label class="control-label">Account Head Type<span class="required">*</span></label>
                                    <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fAccountHeadType" value="Others" <?php if($edit_result['accounthead_type'] == 'Others') { echo 'checked=checked' ;}?> />
                                          Others
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fAccountHeadType" value="Main Tax" <?php if($edit_result['accounthead_type'] == 'Main Tax') { echo 'checked=checked' ;}?> />
                                          Main Tax
                                          </label>  
     									  <label class="radio line">
                                          <input type="radio" name="fAccountHeadType" value="Sub Tax" <?php if($edit_result['accounthead_type'] == 'Sub Tax') { echo 'checked=checked' ;}?> />
                                          Sub Tax
                                          </label>  
                                       </div>
                                    </div>
								   
								    <div class="control-group">
                                       <label class="control-label">Account Head Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fAccountHeadName" data-required="1" value="<?php echo $edit_result['accounthead_name']; ?>"/>                <span class="help-inline">Enter Account Head name</span>
                                       </div>
                                    </div>
									
									<div class="control-group">
                                       <label class="control-label">Account Type</label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="1" name="fAccountType">
											 <?php
											  $aList = $oMaster->getAccountTypeList();
											  foreach($aList as $item)
											  {
											 ?>
                                  <option value="<?php echo $item; ?>" <?php if($edit_result['account_type'] == $item) { echo 'selected=selected' ;}?>><?php echo $item; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                       </div>
                                    </div>
									                                       
                                    <div class="control-group">
                                       <label class="control-label">Account Percent<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fAccountPercent" data-required="1" value="<?php echo $edit_result['account_percent'];?>"/>
                                          <span class="help-inline">Enter Account Percent</span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">% of Gross<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fPercentOfGross" data-required="1" value="<?php echo $edit_result['percent_of_gross'];?>"/>
                                          <span class="help-inline">Enter % of Gross</span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Add / Less</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fAddLess" value="1" <?php if($edit_result['add_less'] == '1') { echo 'checked=checked' ;}?> />
                                          + (Add)
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fAddLess" value="0" <?php if($edit_result['add_less'] == '0') { echo 'checked=checked' ;}?> />
                                          - (Less)
                                          </label>  
                                       </div>
                                    </div>
									
									
					               <div class="control-group">
                                       <label class="control-label">Main Tax</label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="1" name="fMainTax">
											 <?php
											  $aList = $oMaster->getMainTaxList();
											  foreach($aList as $item)
											  {
											 ?>
                                  <option value="<?php echo $item; ?>" <?php if($edit_result['main_tax'] == $item) { echo 'selected=selected' ;}?>><?php echo $item; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
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
                                  <input type="hidden" name="fAccountHeadId" value="<?php echo $aRequest['id'];?>"/>
									
                                    <div class="form-actions">
                                   <?php if($aRequest['action'] == 'Add')
								   {
								   ?>
                                   <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Add Account Head</button>                          
								   <?php
								   } else {
								   ?>
                                    <button type="submit" class="btn blue" name="Update"><i class="icon-ok"></i>Update Account Head</button> 
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