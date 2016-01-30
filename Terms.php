<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $action = 'Add';
  $tableName = 'terms_conditions';
  $fieldName = 'name';
  $fieldValue = $aRequest['fTitle']; 
  
	if(isset($aRequest['update']))
  {
    if(!$oMaster->updateCheckExist($tableName,$fieldName,$fieldValue,'id_terms_conditions',$aRequest['fTermsId']))
   {
	if($oMaster->updateTermscondition($aRequest))
	{
	  $msg = "Terms and condition Updated.";
	  echo '<script type="text/javascript">window.location.href="TermsList.php?msg=updatesucess";</script>';
	}
	else 
	  $msg = "Sorry";
	  }
	 else { $errMsg = 'Title already Exists.'; }  
  } //updat
	
  if(isset($aRequest['add']))
  {
    if(!$oMaster->checkExist($tableName, $fieldName, $fieldValue))
	{
		if($oMaster->addTermscondition($aRequest))
		{
		   $msg = "New terms and condition Added.";
			echo '<script type="text/javascript">window.location.href="TermsList.php?msg=success";</script>';
		 
		}
		else $msg = $_aErrorMsg['Duplicate']; //"Sorry";
	}
	 else { $errMsg = 'Title already Exists.'; }  
  } //submit
 
   if($aRequest['action'] == 'edit')
  {
    $action = 'Edit';
	$item_id = $aRequest['fTermsId'];
	
	$edit_result = $oMaster->getTermsConditionsInfo($item_id);
  /*
	 echo '<pre>';
	 print_r($edit_result);
	  echo '</pre>';
*/
  } //edit
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <title>EAMS | Terms and Condition</title>
   <meta charset="utf-8" />
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
                    Terms and Condition
                     <small> Terms and Condition  master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#"> Terms and Condition</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#"> <?php echo $action;?> Terms and Condition</a></li>
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
                                    <a href="TermsList.php" class="btn red mini active">Back to List</a>
								</div>
                                
								<?php
								  }
								?> 
                                <div class="alert alert-success" id="error_msg" style="display:none">
									<button class="close" data-dismiss="alert"></button>
									<div id="delete_info"></div>
								</div>
                                
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
                       
            		
            <div class="row-fluid">
               <div class="span12">
               <div class="portlet box blue">
                     <div class="portlet-title">
                     <?php if($_REQUEST['action']=='edit')
					 {?>
                        <h4><i class="icon-reorder"></i>Edit  Terms and Condition </h4>
                        <?php } else {?>
                        <h4><i class="icon-reorder"></i>Add  Terms and Condition </h4>
                        <?php }?>
                        <div class="tools">
                           <a href="javascript:;" class="collapse"></a>
                          </div>
                     </div>
                     <div class="portlet-body form">
             <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_terms_addnew" method="post">
									    <!--<div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>-->
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
                                       <label class="control-label">Title<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fTitle" value='<?php echo  (!empty($edit_result['name'])? $edit_result['name']:$aRequest['fTitle']);?>' data-required="1" />
                                            </div>
                                    </div>
									                                       
                                    <div class="control-group">
                                       <label class="control-label"> Description<span class="required">*</span></label>
                                       <div class="controls">
                                          <textarea class="span12 ckeditor m-wrap" rows="6" name="fDescription"><?php echo  (!empty($edit_result['description'])? $edit_result['description']:$aRequest['fDescription']);?></textarea>
                                           
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Status<span class="required">*</span></label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="1" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus']) == '1') { echo 'checked=checked' ;}?> />
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="0" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus']) == '0') { echo 'checked=checked' ;}?>  />
                                          In-Active
                                          </label>  
										  <div id="form_2_membership_error"></div> 
                                       </div>
                                    </div>
                                   		 <div class="loading disabled"><p>Please wait until the Process will  Complete.</p></div>	 					
                                    <div class="form-actions">
                                   <?php if($_REQUEST['action']=='edit')
					 {?>
                     <input type="hidden" name="fTermsId" value="<?php echo $aRequest['fTermsId'];?>"/>
					 <input type="hidden" name="action" value="edit"/>
                       <button type="submit" class="btn blue ajax_bt" name="update"><i class="icon-ok"></i> Update </button>
                         <?php } else {?>
						  <input type="hidden" name="action" value="Add"/>
                         <button type="submit" class="btn blue ajax_bt" name="add"><i class="icon-ok"></i> Add </button>
                        <?php }?>
                                     
                                  
                                       <input type="reset" class="btn" value="Reset" name="reset" id="resetform"/>
                                    </div>
                                 </form>
                                
                </div>
                </div>
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