<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
	
	  $oAssetLocation = &Singleton::getInstance('AssetLocation');
  $oAssetLocation->setDb($oDb);
	
  if(isset($aRequest['add']))
  {
    if($oAssetLocation->addLocation($aRequest))
	{
	   $msg = "New Location Added.";
	  echo '<script type="text/javascript">window.location.href="AssetLocation.php?msg=success";</script>';
	}
	else $msg = "Sorry";
  } //submit
 $allResult = $oAssetLocation->getAllLocationList();
   if(isset($aRequest['Update']))
  {
    if($oAssetLocation->updateLocation($aRequest))
	{
	  $msg = "New Location Updated.";
	  echo '<script type="text/javascript">window.location.href="AssetLocation.php?msg=updatesucess";</script>';
	}
	else $msg = "Sorry";
  } //update
  if($_REQUEST['action'] == 'edit')
  {
	$item_id = $_REQUEST['id'];
	$edit_result = $oAssetLocation->getLocationInfo($item_id);
  } //edit
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS | Location</title>
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
                     Location
                     <small>Location  master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Form Stuff</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Form Layouts</a></li>
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
            <!-- BEGIN PAGE CONTENT-->
    
            <div class="row-fluid">
               <div class="span12">
               <div class="portlet box blue">
                     <div class="portlet-title">
                     <?php if($_REQUEST['action']=='edit')
					 {?>
                        <h4><i class="icon-reorder"></i>Edit Location Form</h4>
                        <?php } else {?>
                        <h4><i class="icon-reorder"></i>Add Location Form</h4>
                        <?php }?>
                        <div class="tools">
                           <a href="javascript:;" class="collapse"></a>
                          </div>
                     </div>
                     <div class="portlet-body form">
             <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_sample_3" method="post">
									    <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
                       				 <div class="control-group">
                                       <label class="control-label">Parent Location Name</label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="1" name="fParentLocationId">
                                             <option value="0">No Parent</option>
                                             <?php
											  $aLocationInfo = $oAssetLocation->getAllLocationList();
											  foreach($aLocationInfo as $aAssetLocation)
											  {
			  
											 ?>
                                             <option value="<?php echo $aAssetLocation['id_location']; ?>"<?php if($edit_result['id_parent_location'] == $aAssetLocation['id_location']) { echo 'selected=selected' ;}?>><?php echo $aAssetLocation['id_location_name']; ?></option>
                                             <?php
											  }
											 ?>
											  </select>
                                            <!--  <a href="AssetUnitEdit.php?action=Add">Add New Unit</a>-->
                                       </div>
                                    </div>
 									
                                    
                                    <div class="control-group">
                                       <label class="control-label">Location Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fLocationName" value='<?php echo  $edit_result['id_location_name'];?>' data-required="1"/>
                                          <span class="help-inline">Enter Location name</span>
                                       </div>
                                    </div>
									                                       
                                    <div class="control-group">
                                       <label class="control-label">Location Description<span class="required">*</span></label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fLocationDesc"><?php echo  $edit_result['id_location_desc'];?></textarea>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Location Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="1" <?php if($edit_result['status'] == 1) { echo 'checked=checked' ;}?>/>
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="0" <?php if($edit_result['status'] == 0) { echo 'checked=checked' ;}?>/>
                                          In-Active
                                          </label>  
                                       </div>
                                    </div>
                                   			 <input type="hidden" name="fLocationId" value="<?php echo $_GET['id'];?>"/>					
                                    <div class="form-actions">
                                   <?php if($_REQUEST['action']=='edit')
					 {?>
                       <button type="submit" class="btn blue" name="Update"><i class="icon-ok"></i> Update Location</button>
                         <?php } else {?>
                         <button type="submit" class="btn blue" name="add"><i class="icon-ok"></i> Add Location</button>
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