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
    if($oCustomer->updateUserRole($aRequest))
	{
	  $msg = "User data Updated.";
	  echo '<script type="text/javascript">window.location.href="UserRole.php?msg=updatesucess";</script>';
	}
	else $msg = "Sorry";
  } //update
  if(isset($aRequest['send']))
  {
    if($oCustomer->addUserRole($aRequest))
	{
	   $msg = "New User Added.";
	  echo '<script type="text/javascript">window.location.href="UserRole.php?msg=success";</script>';
	}
	else $msg = "Sorry";
  } 
  if($_REQUEST['action'] == 'edit')
  {
	$item_id = $aRequest['id'];
	$edit_result = $oCustomer->getUserRoleInfo($item_id,'id');
  } //edit
  
   
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| User Role</title>
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
                  <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN STYLE CUSTOMIZER -->
                 
                  <!-- END STYLE CUSTOMIZER -->  
                  <h3 class="page-title">
                    User Role
                     <small>User master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">User</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">User Role</a></li>
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
                                    <a href="#" class="btn red mini active">Back to List</a>
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
                      <?php if($_REQUEST['action'] == 'Add')
								   {?>
                        <h4><i class="icon-reorder"></i>Add User Role</h4>
                         <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit User Role</h4>
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
                                       <label class="control-label">Role Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fRoleName" data-required="1" value="<?php echo $edit_result['role_name'];?>"/>
                                          <span class="help-inline">Enter Role name</span>
                                       </div>
                                    </div>
									                                       
                                    <div class="control-group">
                                       <label class="control-label">Role Description<span class="required">*</span></label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fRoleDesc"><?php echo $edit_result['description'];?></textarea>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Status</label>
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
                                 
									
                                    <div class="form-actions">
                                   <?php if($_REQUEST['action'] == 'Add')
								   {?>
                                   <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Add User Role</button>                          
									   <?php
								   } else {
								   ?>
                                       <button type="submit" class="btn blue" name="Update"><i class="icon-ok"></i>Update User Role</button> 
									    <input type="hidden" name="fRoleId" value="<?php echo $aRequest['id'];?>"/>
                                          <?php
								   } 
								   ?>                         <button type="button" class="btn">Cancel</button>
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