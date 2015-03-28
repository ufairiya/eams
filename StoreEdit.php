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
     $tableName = 'store';
  $fieldName = 'store_name	';
  $fieldValue = $aRequest['fStoreName']; 
   $fieldName1 = 'lookup';
  $fieldValue1 = $aRequest['fLookup']; 
  $fieldName2 = 'id_store';
   $fieldValue2 = $aRequest['fStoreId'];
  if(isset($aRequest['Update']))
  {
     if(!$oMaster->updateCheckExist($tableName, $fieldName, $fieldValue,$fieldName2,$fieldValue2))
	{
	 if(!$oMaster->updateCheckExist($tableName,$fieldName1,$fieldValue1,$fieldName2,$fieldValue2))
   {
	if($oMaster->updateStore($aRequest, 'update'))
	{
	  $msg = "New Store Updated.";
	  echo '<script type="text/javascript">window.location.href="Store.php?msg=updatesucess";</script>';
	}
	else $msg = "Sorry";
	 }
	  else { $errMsg = 'Store Lookup already Exists.'; } 
	  }
	 else { $errMsg = 'Store Name already Exists.'; }   
  } //update
  if(isset($aRequest['send']))
  {
   if(!$oMaster->checkExist($tableName, $fieldName, $fieldValue))
	{
	if(!$oMaster->checkExist($tableName, $fieldName1, $fieldValue1))
	{
    if($oMaster->addStore($aRequest))
	{
	   $msg = "New Store Added.";
	  echo '<script type="text/javascript">window.location.href="Store.php?msg=success";</script>';
	}
	else $msg = "Sorry could not add..";
	}
	 else { $errMsg = 'Store Lookup already Exists.'; }   
	}
	 else { $errMsg = 'Store Name already Exists.'; }   
  } 
  if($aRequest['action'] == 'edit')
  {
	$item_id = $aRequest['fStoreId'];
	$edit_result = $oMaster->getStoreInfo($item_id,'id');
	 
  } //edit
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|Store</title>
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
                     Store
                     <small>Store master</small>
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
                     <li><a href="#">Store</a></li>
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
                                    <a href="Store.php" class="btn red mini active">Back to List</a>
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
                        <h4><i class="icon-reorder"></i>Add Store</h4>
                         <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit Store</h4>
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
                       
                                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_store_addnew" method="post">
									    <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
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
                                       <label class="control-label">Store Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="1"  class="m-wrap large" name="fStoreName" data-required="1" value="<?php echo (!empty($edit_result['store_name'])? $edit_result['store_name']:$aRequest['fStoreName']); ?>"/>                                         <span class="help-inline">Enter Store name</span>
                                       </div>
                                    </div>
									                                       
                                    <div class="control-group">
                                       <label class="control-label">Lookup<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="2"  class="m-wrap small" maxlength="3" name="fLookup" data-required="1" value="<?php echo (!empty($edit_result['lookup'])? $edit_result['lookup']:$aRequest['fLookup']);?>"/>
                                          <span class="help-inline">Enter Lookup</span>
                                       </div>
                                    </div>
									
									<div class="control-group">
                                       <label class="control-label">Unit</label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="3" name="fUnitId" id="fUnitId">
											  <option value="0" >Choose the Unit  </option>
											 <?php
											  $aUnitList = $oAssetUnit->getAllAssetUnitInfo();
											  foreach($aUnitList as $aUnit)
											  {
			  
											 ?>
                                             <option value="<?php echo $aUnit['id_unit']; ?>" <?php if((!empty($edit_result['id_unit'])? $edit_result['id_unit']:$aRequest['fUnitId']) == $aUnit['id_unit']) { echo 'selected=selected' ;}?>><?php echo $aUnit['unit_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										   <span><a href="#" class="unit" title="Add New Unit"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                       </div>
                                    </div>
									
 
									 <div class="control-group">
                                       <label class="control-label">Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus"   tabindex="5" value="1" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus']) == '1') { echo 'checked=checked' ;}?> />
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus"  tabindex="6"  value="0" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus']) == '0') { echo 'checked=checked' ;}?> />
                                          In-Active
                                          </label>  
                                       </div>
                                    </div>
									<div class="loading disabled"><p>Please wait until the Process will  Complete.</p></div>
                                    <div class="form-actions">
                                   <?php if($aRequest['action'] == 'Add')
								   {
								   ?>
                                   <button type="submit" class="btn blue ajax_bt" name="send"><i class="icon-ok"></i>Add Store</button>  
                                   <input type="hidden" name="action" value="Add"/>                      
								   <?php
								   } else {
								   ?>
                                    <button type="submit" class="btn blue ajax_bt" name="Update"><i class="icon-ok"></i>Update Store</button> 
                                    <input type="hidden" name="fStoreId" value="<?php echo $aRequest['fStoreId'];?>"/>
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