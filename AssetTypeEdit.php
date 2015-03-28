<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  
  $oAssetType = &Singleton::getInstance('AssetType');
  $oAssetType->setDb($oDb);
	
  $oAssetCategory = &Singleton::getInstance('AssetCategory');
  $oAssetCategory->setDb($oDb);
	
  if(isset($aRequest['add']))
  {
    if($oAssetType->addAssetType($aRequest))
	{
	   $msg = "New Asset Type Added.";
	   echo '<script type="text/javascript">window.location.href="AssetType.php?msg=success";</script>';
	}
	else $msg = "Sorry. Possible duplicate values found.";
  } //submit
 $allResult = $oAssetType->getAllAssetTypeList();
   if(isset($aRequest['Update']))
  {
    if($oAssetType->updateAssetType($aRequest))
	{
	  $msg = "Asset Type Updated.";
	 $page = $_SERVER['PHP_SELF'];
     echo '<script type="text/javascript">window.location.href="AssetType.php?msg=updatesucess";</script>';
	}
	else $msg = "Sorry. Duplicate values found.";
  } //update
  if($_REQUEST['action'] == 'edit')
  {
	$item_id = $aRequest['fAssetTypeId'];
	$edit_result = $oAssetType->getAssetTypeInfo($item_id,'id');
	/*echo '<pre>';
	print_r($edit_result);
	echo '</pre>';*/
  } //edit
  
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS | AssetType</title>
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
                     AssetType
                     <small>AssetType  master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Asset Master</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Asset Type</a></li>
                  </ul>
               </div>
            </div>
            
                              <?php
							     if(isset($msg))
								 {
							   ?>
							    <div class="alert alert-success">
									<button class="close" data-dismiss="alert"></button>
									<?php echo $msg; unset($msg); ?>
								</div>
                                
								<?php
								  }
								?> 
                                <div class="alert alert-success" id="error_msg" style="display:none">
									<button class="close" data-dismiss="alert"></button>
									<div id="delete_info"></div>
								</div>
                                
            <!-- END PAGE HEADER-->
           
            <div class="row-fluid">
               <div class="span12">
               <div class="portlet box blue">
                     <div class="portlet-title">
                     <?php if($_REQUEST['action']=='edit')
					 {?>
                        <h4><i class="icon-reorder"></i>Edit AssetType Form</h4>
                        <?php } else if($_REQUEST['action']=='Add'){?>
                        <h4><i class="icon-reorder"></i>Add AssetType Form</h4>
                        <?php }?>
                        <div class="tools">
                           <a href="javascript:;" class="collapse"></a>
                          </div>
                     </div>
                     <div class="portlet-body form">
             <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="assettype" method="post">
									    <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
                          
                       					 
                                                                        
                                    <div class="control-group">
                                       <label class="control-label">AssetType Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fAssetTypeName" value='<?php echo (!empty($edit_result['asset_type_name'])? $edit_result['asset_type_name']:$aRequest['fAssetTypeName']);?>' data-required="1"/>
                                          <span class="help-inline">Enter AssetType name</span>
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">AssetType Lookup<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fLookup" value='<?php echo  (!empty($edit_result['lookup'])? $edit_result['lookup']:$aRequest['fLookup']);?>' data-required="1"/>
                                          <span class="help-inline">Enter Category name</span>
                                       </div>
                                    </div>
									                                       
                                    <div class="control-group">
                                       <label class="control-label">AssetType Description</label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fAssetTypeDesc"><?php echo (!empty($edit_result['asset_type_desc'])? $edit_result['asset_type_desc']:$aRequest['fAssetTypeDesc']) ;?></textarea>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">AssetType Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="1" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus']) == 1) { echo 'checked=checked' ;}?>/>
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="0" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus']) == 0) { echo 'checked=checked' ;}?>/>
                                          In-Active
                                          </label>  
										  <div id="form_2_membership_error"></div> 
                                       </div>
                                    </div>
                                   		 <div class="loading disabled"><p>Please wait until the Process will  Complete.</p></div>					
                                    <div class="form-actions">
                                   <?php if($_REQUEST['action']=='edit')
					        {?>
							 <input type="hidden" name="action" value="edit">
							 <input type="hidden" name="fAssetTypeId" value="<?php echo $aRequest['fAssetTypeId'];?>"/>	
                       <button type="submit" class="btn blue ajax_bt" name="Update" ><i class="icon-ok"></i> Update AssetType</button>
                           <?php } else if($_REQUEST['action']=='Add')
					        {?>
							 <input type="hidden" name="action" value="Add">
						 <button type="submit" class="btn blue ajax_bt" name="add"><i class="icon-ok"></i> Add AssetType</button>
						 <?php } else {?>
						  <input type="hidden" name="action" value="Add">
                         <button type="submit" class="btn blue ajax_bt" name="add"><i class="icon-ok"></i> Add AssetType</button>
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