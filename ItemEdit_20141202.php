<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
   
     $tableName = 'item';
  $fieldName = 'lookup';
  $fieldValue = $aRequest['fLookup']; 
  $fieldName1 = 'item_name';
  $fieldValue1 = $aRequest['fItemName']; 
  $fieldName2 = 'id_item';
   $fieldValue2 = $aRequest['fItemId'];
  if(isset($aRequest['Update']))
  {
      if(!$oMaster->updateCheckExist($tableName, $fieldName1, $fieldValue1,$fieldName2,$fieldValue2))
	{
	 if(!$oMaster->updateCheckExist($tableName,$fieldName,$fieldValue,$fieldName2,$fieldValue2))
   {
    if($oMaster->updateItem($aRequest, 'update'))
	{
	  $msg = "Item Updated.";
	  echo '<script type="text/javascript">window.location.href="Item.php?msg=updatesucess";</script>';
	}
	else $msg = "Sorry";
	}
	 else { $errMsg = 'Item Lookup already Exists.'; } 
	  }
	 else { $errMsg = 'Item Name already Exists.'; } 
	
  } //update
  if(isset($aRequest['send']))
  {
  
  if(!$oMaster->checkExist1($tableName, $fieldName, $fieldValue,$fieldName1, $fieldValue1))
	{
	
    if($result = $oMaster->addItem($aRequest))
	{
	  
	  if($result == 1)
	  {
	  $msg = "New Item Added.";
	   echo '<script type="text/javascript">window.location.href="Item.php?msg=success";</script>';
	  }
	  else if($result == 0)
	  {
	  $msg = "Sorry";
	  }
	   else
	  {
	  
	   $msg = "Item Already Exist.";
	 
	/*   $edit_result['item_type'] = $result['item_type'];
       $edit_result['status'] =$result['status'];
	   $edit_result['id_itemgroup2'] =$result['group2'];
	   $edit_result['id_item'] =$result['id_item']; 	*/
	  }
	     
	}
	} else { $errMsg = 'Value already Exists.'; }   
		
  } 
  if($aRequest['action'] == 'edit')
  {
	$item_id = $aRequest['fItemId'];
	$edit_result = $oMaster->getItemInfo($item_id,'id');
	 
  } //edit
  if($aRequest['action'] == 'Add')
  {
  $edit_result['item_type'] ='New';
  $edit_result['status'] =1;
  }
  
  if($aRequest['action'] == 'Cancel')
  {
	 echo '<script type="text/javascript">window.location.href="Item.php";</script>'; 
  } //cancel
  
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|Item </title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <meta http-equiv="Cache-control" content="No-Cache">
  <?php include('Stylesheets.php');?>
  </head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top" onLoad="getItemType('<?php echo $edit_result['item_type']?>','<?php echo $edit_result['id_item']?>');">
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
                     Item 
                     <small>Item master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Asset Masters</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Item </a></li>
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
                                    <a href="Item.php" class="btn red mini active">Back to List</a>
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
                        <h4><i class="icon-reorder"></i>Add Item</h4>
                         <?php } else if($aRequest['action'] == 'edit') {?>
                          <h4><i class="icon-reorder"></i>Edit Item</h4>
                        <?php } ?>
                        <div class="tools">
                           <a href="javascript:;" class="collapse"></a>
                        
                        </div>
                     </div>
                     <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                       
                                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="item_form" method="post">
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
                       				
									<?php if($aRequest['action'] !='edit')
									{?>
									<div class="control-group">
                                      <div class="controls">
                                 <label class="radio">
                                 <input type="radio" name="fItemType" id="fItemType" value="New" tabindex="2" <?php if((!empty($edit_result['item_type'])? $edit_result['item_type']:$aRequest['fItemType']) == 'New') { echo 'checked=checked' ;}?> onChange="getItemType(this.value);"/>
                                 Add New Item
                                 </label>
                                 <label class="radio">
                                 <input type="radio" name="fItemType" id="fItemType" value="Item" tabindex="3" <?php if((!empty($edit_result['item_type'])? $edit_result['item_type']:$aRequest['fItemType']) == 'Item') { echo 'checked=checked' ;}?> onChange="getItemType(this.value);" />
                                Choose Item
                                 </label>  
                               
                              </div>
                                                       
                                    </div>	
									
									<?php } ?>
									 <div class="control-group" id="group1">
                                       <label class="control-label">Item Group I<span class="required">*</span></label>
                                       <div class="controls">
									 <select class="large m-wrap fItemGroup1Id" tabindex="2" name="fGroup1">
                                            <option value="0" selected="selected" >Choose the ItemGroup 1 </option>
											 <?php
											  $aItemGroup1List = $oMaster->getItemGroup1List();
											  foreach($aItemGroup1List as $aItemGroup1)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup1['id_itemgroup1']; ?>" <?php if((!empty($edit_result['id_itemgroup1'])? $edit_result['id_itemgroup1']:$aRequest['fGroup1']) == $aItemGroup1['id_itemgroup1']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup1['itemgroup1_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										   <span><a href="#" class="itemgroup1" title="Add New Item Group 1"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                           </div>
										  
                                    </div> 
										                                     
                                  <div class="control-group">
                                       <label class="control-label">Brand/Make<span class="required">*</span></label>
                                       <div class="controls">
                                         <select class="large m-wrap fItemGroup2Id" tabindex="1" name="fGroup2" id="fGroup2">
											 <option value="">Choose the Brand/Make</option>
											 <?php
											  $aGroup2List = $oMaster->getItemGroup2List();
											  foreach($aGroup2List as $aGroup2)
											  {
			  
											 ?>
                                             <option value="<?php echo $aGroup2['id_itemgroup2']; ?>" <?php if((!empty($edit_result['id_itemgroup2'])? $edit_result['id_itemgroup2']:$aRequest['fGroup2']) == $aGroup2['id_itemgroup2']) { echo 'selected=selected' ;}?>><?php echo $aGroup2['itemgroup2_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                           <span><a href="#" class="itemgroup2" title="Add New Item Group 2"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                       </div>
                                    </div>
									<?php if($aRequest['action'] !='edit')
									{?>								
                                            
									<div id="ItemList">
                                    </div>
									   <?php } else {?>     
									   
									   <div class="control-group">
                                       <label class="control-label">Item Name<span class="required">*</span></label>
                                       <div class="controls" >
									   <input type="text" placeholder="Enter the Item Name" class="m-wrap large" name="fItemName" data-required="1" value="<?php echo (!empty($edit_result['item_name'])? $edit_result['item_name']:$aRequest['fItemName']);?>"/>
									     </div>
                                    </div>
									 <div class="control-group">
                                       <label class="control-label">Lookup<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" maxlength="3" class="m-wrap small" name="fLookup" data-required="1" value="<?php echo (!empty($edit_result['lookup'])? $edit_result['lookup']:$aRequest['fLookup']);?>"/>
                                          <span class="help-inline">Enter Lookup</span>
                                       </div>
                                    </div>                                
                                      <?php } ?>     
									
									 <div class="control-group">
                                       <label class="control-label">Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="1" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus']) == '1') { echo 'checked=checked' ;}?> />
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="0" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus']) == '0') { echo 'checked=checked' ;}?> />
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
								   <input type="hidden" name="action" value="Add">
                                   <button type="submit" class="btn blue ajax_bt" name="send"><i class="icon-ok"></i>Add Item </button>                          
								   <?php
								   } else if($aRequest['action'] == 'edit'){
								   ?>
								   <input type="hidden" name="action" value="edit">
								    <input type="hidden" name="fItemId" value="<?php echo $aRequest['fItemId'];?>"/>
                                    <button type="submit" class="btn blue ajax_bt" name="Update"><i class="icon-ok"></i>Update Item </button> 
									 <?php
								   } else {
								   ?>
								   <input type="hidden" name="action" value="Add">
								     <button type="submit" class="btn blue ajax_bt" name="send"><i class="icon-ok"></i>Add Item </button>            
                                   <?php
								   } 
								   ?>
								   <button type="submit" class="btn" name="action" value="Cancel">Cancel</button>
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
	<script type="text/javascript">
	 function getItemType(value,id)
		 {
			
			var dataStr = 'action=getItemType&type='+value+'&id='+id;
			
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				  $("#ItemList").html(result);
				 
			   }
         
		  
		 });
		 }
		 jQuery(document).ready(function() { 
	
	$(function () {
	 $('input[type="radio"]:checked').change();
	
	});

});


		 
	</script>
</body>
<!-- END BODY -->
</html>