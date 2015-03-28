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
     echo '<pre>';
	 print_r($aRequest);  
	 echo '</pre>';
  
    if($oMaster->updateLinkSubCat($aRequest))
	{
	  $msg = "Menu assigning Updated.";
	  /*echo '<script type="text/javascript">window.location.href="User.php?msg=updatesucess";</script>';*/
	}
	else $msg = "Sorry";
  } //update
 
  if($_REQUEST['action'] == 'edit')
  {
	$item_id = $_REQUEST['id'];
	$edit_result = $oMaster->getUserMenuAccessInfo($item_id);
  } //edit
  
  $aMEnu = $oMaster->getUserCrudMenuAccessInfo($item_id);
   /* echo '<pre>';
	 print_r($aMEnu);  
	 echo '</pre>';
	 exit();*/
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
                        <h4><i class="icon-reorder"></i>Add Unit Form</h4>
                         <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit Unit Form</h4>
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
						   <?php /*?> <label class="checkbox line">
                                          <div class="checker" id="uniform-undefined"><span class=""><input type="checkbox" id="selectall"/></span></div><b> SELECT ALL</b>
                                          </label><?php */?>
						   
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
									   <section id="section">
									<div class="control-group">
                                       <label class="control-label">Assigned Menus</label>
                                       <div class="controls">
									   <table width="80%">
									   <tr>
									   <td><label><input type="checkbox" id="set1all">Select All Main Menu</label>
									   <label><input type="checkbox" id="set2all"> Select All Sub Menu</label>
									   </td>
									    <td><label><input type="checkbox" id="set3all"> Select All Add</label>
									   <label><input type="checkbox" id="set4all"> Select All Edit</label>
									  <label><input type="checkbox" id="set5all"> Select All Delete</label>
									   <label><input type="checkbox" id="set6all"> Select All View</label>
									   <label><input type="checkbox" id="set7all"> Select All Download PDF</label></td>
									   </tr>
									 									   
									   </table>
								
									
									      <?php
										 $aMainMenuList = $oMaster->getLinkCatList();
										
										 foreach($aMainMenuList as $aMainMenu)
										 {
										 ?>
										  <article id="set1" >
										   <input type="checkbox" value="<?php echo $aMainMenu['db_lcatId']; ?>" <?php if($oMaster->isLinkAssignedMenu($aMainMenu['db_lcatId'],$item_id) ) { echo 'checked=checked' ;}?> name="fParentLinks[]"><b> <?php echo $aMainMenu['db_lcatName']; ?></b>
                                            
										</article>
										<div style="margin-left: 60px;">
										 <?php
										 
										  
										  $aSubLinkList = $oMaster->getLinkSubCatList($aMainMenu['db_lcatId']);
										  foreach($aSubLinkList as $subLink)
										  {
										    
										  ?>
                                          
										  <table width="100%">
										  <tr>
										 
										  <td colspan="6"> <article id="set2">
										  <label  style="float:left;"> 
                                          <input type="checkbox" value="<?php echo $subLink['db_lscatId']; ?>" <?php if($oMaster->isLinkAssigned($subLink['db_lscatId'],$item_id) ) { echo 'checked=checked' ;}?>  name="fLinks[]"> <?php echo $subLink['db_lscatName']; ?> </label>
								           <br>
										   </article></td>
										  </tr>
										  <tr>
										 <td>
										 <table style="margin-left: 50px;">
										 <tr>
										 <td>
										  <article id="set3" >
									 <label  style="float:left; color: red;"> 
											<input type="checkbox" value="<?php echo $subLink['db_lscatId']; ?>"   <?php if($oMaster->isLinkAssignedCrud($subLink['db_lscatId'],$item_id,'1') ) { echo 'checked=checked' ;}?> name="fAdd[]"> Add
											</label>
											 </article>
										  
										  </td>
										  <td>
										   <article id="set4" >
											 <label  style="margin-left: 10px;float:left;color: blue;"> 
											<input type="checkbox" value="<?php echo $subLink['db_lscatId']; ?>"   <?php if($oMaster->isLinkAssignedCrud($subLink['db_lscatId'],$item_id,'2') ) { echo 'checked=checked' ;}?>name="fEdit[]"> Edit
											</label>
											</article>
										  
										  </td>
										  <td>
										  <article id="set5" >
											 <label  style="margin-left: 10px;float:left;color: red;"> 
											<input type="checkbox" value="<?php echo $subLink['db_lscatId']; ?>"   <?php if($oMaster->isLinkAssignedCrud($subLink['db_lscatId'],$item_id,'3') ) { echo 'checked=checked' ;}?> name="fDelete[]"> Delete
											</label>
											</article>
										  </td>
										  <td>
										  <article id="set6" >
											 <label  style="margin-left: 10px;float:left;color: blue;"> 
											<input type="checkbox" value="<?php echo $subLink['db_lscatId']; ?>"   <?php if($oMaster->isLinkAssignedCrud($subLink['db_lscatId'],$item_id,'4') ) { echo 'checked=checked' ;}?>  name="fView[]"> View
											</label>
											</article>
										  </td>
										  <td>
										  <article id="set7" >
											 <label  style="margin-left: 10px;float:left;color: red;"> 
											<input type="checkbox" value="<?php echo $subLink['db_lscatId']; ?>"   <?php if($oMaster->isLinkAssignedCrud($subLink['db_lscatId'],$item_id,'5') ) { echo 'checked=checked' ;}?> name="fPdf[]"> Download PDF
											</label>
											</article>
										  </td>
										 </tr>
										 </table>
										 </td>
										 
										  
										  </tr>
										  
										  </table>
										  
										  
										  <?php
										  }
										  ?>
										  </div>	
										   <?php
										 }
										 ?>
										 
                                       </div>
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
									</section>
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
        })
             $('input[id="set4all"]').click(function() {
             $("#set4 :checkbox").attr('checked', $(this).attr('checked'));
        })
             $('input[id="set5all"]').click(function() {
             $("#set5 :checkbox").attr('checked', $(this).attr('checked'));
             })
			  $('input[id="set6all"]').click(function() {
             $("#set6 :checkbox").attr('checked', $(this).attr('checked'));
             })
			  $('input[id="set7all"]').click(function() {
             $("#set7 :checkbox").attr('checked', $(this).attr('checked'));
             });
            
     });
</script>
	<?php /*?><SCRIPT language="javascript">
$(function(){
 
    // add multiple select / deselect functionality
    $("#selectall").click(function () {
   
		  $("input[name='fAdd[]']").attr('checked', this.checked);
    });
 
   
   
});
</SCRIPT><?php */?>

</body>
<!-- END BODY -->
</html>