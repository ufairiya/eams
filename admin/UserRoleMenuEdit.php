<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isAdmin())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  
  if(isset($aRequest['Update']))
  {
     //echo '<pre>';
	 //print_r($aRequest);  
	 //echo '</pre>';
   $valid = $oCustomer->updateLinkSubCat($aRequest);
    if($valid)
	{
	  $msg = "Menu assigning Updated.";
	  echo '<script type="text/javascript">window.location.href="UserRole.php?msg=updatesucess";</script>';
	}
	else $msg = "Sorry";
  } //update
  
  if($_REQUEST['action'] == 'edit')
  {
	$item_id = $_REQUEST['id'];
	$edit_result = $oCustomer->getUserMenuAccessInfo($item_id);
	
  } //edit
  
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Menu</title>
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
                     Menu Item
                     <small>Menu Item master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Menu</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Menu Item</a></li>
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
                                    <a href="UserRole.php" class="btn red mini active">Back to List</a>
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
                        <h4><i class="icon-reorder"></i>Add Menu </h4>
                         <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit Menu</h4>
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
                                     <!-- <div class="control-group">
                                       <label class="control-label">Parent Menu</label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="1" name="fAssetParentUnit">
                                             <option value="0">No Parent</option>
											 <?php
											  $aLinkCat = $oMaster->getLinkCatList();
											  foreach($aLinkCat as $link)
											  {
			  
											 ?>
                                             <option value="<?php echo $link['db_lcatId']; ?>" <?php if($edit_result['db_lcatId'] == $link['db_lcatId']) { echo 'selected=selected' ;}?>><?php echo $link['db_lcatName']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                       </div>
                                    </div>-->
									
									
									
									
									<div class="control-group">
                                       <label class="control-label">Assigned Menus</label>
									  
									     <label style="margin-left: 30%; color:#FF0000;"><input type="checkbox" id="set1all">Select All </label>
                                       <div class="controls">
									    <section id="section">
									 <article id="set1" >
									 
									      <?php
										 $aMainMenuList = $oMaster->getLinkCatList();
										
										 foreach($aMainMenuList as $aMainMenu)
										 {
										 ?>
										   <label >
                                         <input type="checkbox" value="<?php echo $aMainMenu['db_lcatId']; ?>" <?php if($oCustomer->isLinkAssignedMenu($aMainMenu['db_lcatId'],$item_id) ) { echo 'checked=checked' ;}?> name="fParentLinks[]"><b> <?php echo $aMainMenu['db_lcatName']; ?></b>
                                          </label>
										
										
										 <?php
										 
										  
										  $aSubLinkList = $oMaster->getLinkSubCatList($aMainMenu['db_lcatId']);
										  foreach($aSubLinkList as $subLink)
										  {
										    
										  ?>
                                          <div style="margin-left: 60px;">
										 <input type="checkbox" value="<?php echo $subLink['db_lscatId']; ?>" <?php if($oCustomer->isLinkAssigned($subLink['db_lscatId'],$item_id) ) { echo 'checked=checked' ;}?> name="fLinks[]"> <?php echo $subLink['db_lscatName']; ?>
                                        
										  </div>
										  <?php
										  }
										  ?>
										   <?php
										 }
										 ?>
                                       </div>
									   	</article>
									</section>
                                    </div>
									
                                  <input type="hidden" name="fUserId" value="<?php echo $_GET['id'];?>"/>
									
                                    <div class="form-actions">
                                   <?php if($_REQUEST['action'] == 'Add')
								   {?>
                                   <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Add Unit</button>                          
									   <?php
								   } else {
								   ?>
                                       <button type="submit" class="btn blue" name="Update"><i class="icon-ok"></i>Update User Menu Assignment</button> 
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
	<script type="text/javascript" src="../assets/js/jquery.min.js"></script>
<script>
    $(document).ready(function() {
             $('input[id="set1all"]').click(function() {
             $("#set1 :checkbox").attr('checked', $(this).attr('checked'));
        });
             $('input[id="set2all"]').click(function() {
             $("#set2 :checkbox").attr('checked', $(this).attr('checked'));
        })
             $('input[id="set3all"]').click(function() {
             $("#set3 :checkbox").attr('checked', $(this).attr('checked'));
        });
		  });
		  </script>
</body>
<!-- END BODY -->
</html>