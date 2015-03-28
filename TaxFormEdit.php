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
$action = 'Add';
    $tableName = 'taxform';
  $fieldName = 'taxform_name';
  $fieldValue = $aRequest['fTaxFormName']; 
   $fieldName1 = 'lookup';
  $fieldValue1 = $aRequest['fLookup']; 
  $fieldName2 = 'id_taxform';
   $fieldValue2 = $aRequest['fTaxFormId']; 
  if(isset($aRequest['Update']))
  {
  if(!$oMaster->updateCheckExist($tableName,$fieldName1,$fieldValue1,$fieldName2,$fieldValue2))
   {
    if($aresult= $oMaster->updateTaxForm($aRequest, 'update'))
	{
	  
	   if($aresult == 1){	  
		  $msg = "New TaxForm Updated.";
	  echo '<script type="text/javascript">window.location.href="TaxForm.php?msg=updatesucess";</script>';
		  }
		  elseif($aresult == 2)
		  {
		  $msg = 'Tax Name already Exists'; 
		 
		  }
		  else
		  {
		  $msg = 'Sorry Could not updated';
		  }
		 
	}
	else $msg = "Sorry";
	}
	 else { $errMsg = 'Tax Lookup already Exists.'; } 
  } //update
  if(isset($aRequest['send']))
  {
    if(!$oMaster->checkExist($tableName, $fieldName, $fieldValue))
	{
	
	if($oMaster->addTaxForm($aRequest))
	{
	   $msg = "New TaxForm Added.";
	  echo '<script type="text/javascript">window.location.href="TaxForm.php?msg=success";</script>';
	}
	else $msg = "Sorry could not add..";
	} else { $errMsg = 'Value already Exists.'; }
  } 
  if($aRequest['action'] == 'edit')
  {
$action = 'Edit';
	$item_id = $aRequest['fTaxFormId'];
	$edit_result = $oMaster->getTaxFormInfo($item_id,'id');
	
  } //edit
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| TaxForm</title>
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
                     TaxForm
                     <small>TaxForm master</small>
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
                     <li><a href="#"><?php echo $action;?> TaxForm</a></li>
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
                                    <a href="TaxForm.php" class="btn red mini active">Back to List</a>
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
                        <h4><i class="icon-reorder"></i>Add TaxForm</h4>
                         <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit TaxForm</h4>
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
                       
                                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_taxform_addnew" method="post">
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
                                       <label class="control-label">TaxForm Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fTaxFormName" data-required="1" value="<?php echo (!empty($edit_result['taxform_name'])?$edit_result['taxform_name']:$aRequest['fTaxFormName']); ?>"/>                                         <span class="help-inline">Enter TaxForm name</span>
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">AddLess (+/-)<span class="required">*</span></label>
                                       <div class="controls">
                                           <select class="large m-wrap chosen" name="fAddLess" >
                                           <option value="0">Choose the Option</option>
                                          <option value="+" <?php if((!empty($edit_result['addless'])?$edit_result['addless']:$aRequest['fAddLess']) == '+') { echo 'selected=selected' ;}?>>Add (+)</option>
                                           <option value="-" <?php if((!empty($edit_result['addless'])?$edit_result['addless']:$aRequest['fAddLess']) == '-') { echo 'selected=selected' ;}?>>Less (-)</option>
                                          </select>                              
                                       </div>
                                    </div>
									     
                                         <div class="control-group">
                                       <label class="control-label">Tax Percentage<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fTaxPercentage" data-required="1" value="<?php echo (!empty($edit_result['tax_percentage'])?$edit_result['tax_percentage']:$aRequest['fTaxPercentage']); ?>"/>                                        
                                       </div>
                                    </div>                                  
                                    <div class="control-group">
                                       <label class="control-label">Lookup<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fLookup" data-required="1" value="<?php echo (!empty($edit_result['lookup'])?$edit_result['lookup']:$aRequest['fLookup']);?>" maxlength="3"/>
                                          <span class="help-inline">Enter Lookup</span>
                                       </div>
                                    </div>
																	
									 <div class="control-group">
                                       <label class="control-label">Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="1" <?php if((!empty($edit_result['status'])?$edit_result['status']:$aRequest['fStatus']) == '1') { echo 'checked=checked' ;}?> />
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="0" <?php if((!empty($edit_result['status'])?$edit_result['status']:$aRequest['fStatus']) == '0') { echo 'checked=checked' ;}?> />
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
                                   <input type="hidden" name="action" value="Add"/>
                                   <button type="submit" class="btn blue ajax_bt" name="send"><i class="icon-ok"></i>Add TaxForm</button>                          
                                    
								   <?php
								   } else if($aRequest['action'] == 'edit') {
								   ?>
 									 <input type="hidden" name="fTaxFormId" value="<?php echo $aRequest['fTaxFormId'];?>"/>
                                     <input type="hidden" name="action" value="edit"/>
                                    <button type="submit" class="btn blue ajax_bt" name="Update"><i class="icon-ok"></i>Update TaxForm</button> 
                                   <?php
								   } 
								   else
								   {
								   ?>
								   <input type="hidden" name="action" value="Add"/>
                                   <button type="submit" class="btn blue ajax_bt" name="send"><i class="icon-ok"></i>Add TaxForm</button>
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