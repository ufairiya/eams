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
  $oAssetVendor = &Singleton::getInstance('Vendor');
  $oAssetVendor->setDb($oDb);
  $oAssetDepartment = &Singleton::getInstance('Department');
  $oAssetDepartment->setDb($oDb);
  $astoreNumber = $oMaster->internalStoreDeliveryCount(); 

  
  if(isset($aRequest['send']))
  {
    if($oMaster->addAssetDivisionDelivery($aRequest))
	{
	   $msg = 'Division delivery Added';
	    echo '<script type="text/javascript">window.location.href="StoreDeliveryList.php?msg=success";</script>';
	}
	else 
	  $msg = "Sorry could not add..";
  } 
  if($aRequest['action'] == 'Add')
  {
	  $_SESSION['ses_DeliveryItemlist'] = '';
  }
  
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Store Delivery </title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <meta http-equiv="Cache-control" content="No-Cache">
  <?php include('Stylesheets.php');?>
  <style>
	  input.add {
		-moz-border-radius: 4px;
		border-radius: 4px;
		background-color: #33CC00;
		-moz-box-shadow: 0 0 4px rgba(0, 0, 0, .75);
		box-shadow: 0 0 4px rgba(0, 0, 0, .75);
	}
	input.add:hover {
		background-color:#1EFF00;
		-moz-border-radius: 4px;
		border-radius: 4px;
	}
	input.removeRow {
		-moz-border-radius: 4px;
		border-radius: 4px;
		background-color:#FFBBBB;
		-moz-box-shadow: 0 0 4px rgba(0, 0, 0, .75);
		box-shadow: 0 0 4px rgba(0, 0, 0, .75);
	}
	input.removeRow:hover {
		background-color:#FF0000;
		-moz-border-radius: 4px;
		border-radius: 4px;
	}
  </style>
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
                     Store - Division -Delivery
                     <small> Store - Division -Delivery Master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#"> Store - Division -Delivery</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#"> Store - Division -Delivery</a></li>
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
                  
                   
                     <div class="tab-content">
                        
                        <div class="tab-pane active" id="purchaseorder">
                           <div class="portlet box green">
                              <div class="portlet-title">
                                 <h4><i class="icon-reorder"></i> Store - Division -Delivery</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="javascript:;" class="reload"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_sample_3" method="post" enctype="multipart/form-data">
                                        <h3 class="form-section"> Store - Division -Delivery</h3>
                                   
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">From Store</label>
                               <div class="controls">
                                       
                                        <select class="span12 chosen" data-placeholder="Choose a From Store" tabindex="4" name="fFromStoreId" id="fFromStoreId" onChange="getItemList(this.value);">
                                          <option value=""></option>
                                          <?php
											  $aUnitList = $oAssetUnit->getAllAssetUnitInfo();
											  foreach($aUnitList as $aUnit)
											  {
											 ?>
                                              <optgroup label="<?php echo  $aUnit['unit_name'];?>">
                                              
                                          <?php
											  $aStoreList = $oMaster->getStoreListInfo($aUnit['id_unit'],'unit');
											  foreach($aStoreList as $aStore)
											  {
											 ?>
                                             
                                             
                                             <option value="<?php echo $aStore['id_store']; ?>"<?php if($aDeliveryDetails['from_id_store'] == $aStore['id_store']) { echo 'selected=selected' ;}?>><?php echo $aStore['store_name']; ?></option>
                                           
                                             <?php
											  }
											 ?>
                                           </optgroup>
                                            <?php
											  }
											 ?>
                                             </select>
                                         
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                   
                                          
                                             
                                       <div class="span6">
                                          
                                           <div class="control-group">
                                       <label class="control-label">Work Division<span class="required">*</span></label>
                                       
                                       <div class="controls" id="unitwisedivisionList"> 
                                        <select class="span12 m-wrap" tabindex="2" name="fDivisionId" id="fDivisionId">
										<option value="">Choose the Work Division</option>
											 <?php /*?><?php
											  $aDivisionList = $oMaster->getDivisionList();
											  foreach($aDivisionList as $aDivision)
											  {
											 ?>
                                             <option value="<?php echo $aDivision['id_division']; ?>" <?php if($edit_result['id_department'] == $aDivision['id_division']) { echo 'selected=selected' ;}?>><?php echo $aDivision['division_name']; ?></option>
                                             <?php
											  }
											 ?><?php */?>
                                          </select>
                                          
                                         
                                       </div>
                                       <div style="float:right;"><span><a href="#" class="division" title="Add New Division"><i class="icon-plus-sign" style="color:#009900;"></i></a></span></div>
                                          
                                    </div>
                                   
										  
                                          
                                            </div>
                                         
                                     
                                         <!--/span-->
                                    </div>
                                    
                           <h3 class="form-section"></h3>          
                                 <div class="row-fluid" id="ItemList" style="width: 75%;margin-left: 180px;">
                                                                        
                                        <div class="span4">
                                       <select class="m-wrap" tabindex="6" name="fItemGroup1" id="fItemGroup1" onChange="getGroup2ItemListing(this.value);">
                                            <option value="0" selected="selected" >Choose the ItemGroup 1 </option>
                                            
                                             <?php
											  $aItemGroup1List = $oMaster->getItemGroup1ByStore($aDeliveryDetails['from_id_store'],'','store');
											  foreach($aItemGroup1List as $aItemGroup1)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup1['id_itemgroup1']; ?>"><?php echo $aItemGroup1['itemgroup1_name']; ?></option>
                                             <?php
											  }
											 ?>
										     </select> 
                                       </div>
                                     
                                        <div class="span4" id="Group2ItemList">
                                       <select class="m-wrap" tabindex="7" name="fItemGroup2" id="fItemGroup2">
                                               <option value="0" selected="selected" >Choose the ItemGroup 2 </option>
											
                                          </select>
                                       </div>
                                       
                                       <div class="span4" id="ItemsList">
                                       <select class=" m-wrap  " tabindex="8" name="fItemName" id="fItemName">
                                    <option value="0" >Choose the Item</option>
											</select>
                                       </div>
                                       </div>
                                       
                                   <br>
                                    
                                      <div class="row-fluid">               
                                         <table id="purchaseItems" name="purchaseItems" class="table table-striped table-bordered table-hover">
								<tr>
											 <th>Item Group1</th>
											<th>Item Group2</th>
                                             <th>Item </th>
                                             <th>UOM</th>
											<th>Quantity</th>
                                            <th>Asset Number</th>
                                         	<th>Action</th>
								</tr>
                      
                                  </table>
                            
                                   </div>          
                            
                                             
                                    <h3 class="form-section"></h3>   
									<div class="control-group">

                                       <label class="control-label">Select Receiver Name</label>

                                       <div class="controls">

                                        <select class="large m-wrap" tabindex="1" name="fReceiverEmployeeId">

											<option value="0">Choose Receiver Name</option>

											<?php

											  $aEmployeeList = $oMaster->getEmployeeList();

											  foreach($aEmployeeList as $aEmployee)

											  {

			  

											 ?>

                                             <option value="<?php echo $aEmployee['id_employee']; ?>" <?php if($edit_result['approved_by'] == $aEmployee['id_employee']) { echo 'selected=selected' ;}?>><?php echo $aEmployee['employee_name']; ?></option>

                                             <?php

											  }

											 ?>

                                          </select>

                                       </div>

                                    </div>    
                                   <div class="row-fluid">
                                       <div class="span6 ">
                                       <div class="control-group">
                                       <label class="control-label">Remarks</label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fRemark"><?php echo $aDeliveryDetails['remark'];?></textarea>
                                       </div>
                                    </div>
                                         <!--/span-->
                                    </div>
                                      </div>
                                   
                                    <div class="form-actions">
                                    
                                    <?php if($aRequest['action'] == 'edit')
						{
						?>
							<button type="submit" class="btn blue" id="sends" name="Update"><i class="icon-ok"></i>Save</button>  
                            <input type="hidden" name="fDeliveryId" value="<?php echo $aRequest['id'];?>"/>                 
						<?php
						} else {
						?>
							  <button type="submit" class="btn blue" id="sends" name="send"><i class="icon-ok"></i>Add</button>       
						<?php
						} 
						?>
                                     
                                    </div>
                                 </form>
                                 <!-- END FORM-->                
                              </div>
                           </div>
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
   <script type="text/javascript">
   var itemtable = "<table id='purchaseItems' name='purchaseItems' class='table table-striped table-bordered table-hover'><tr> <th>Item Group1</th>	<th>Item Group2</th><th>Item </th><th>UOM</th><th>Quantity</th><th>Asset Number</th><th>Action</th></tr> </table>";
   
   function getGroup2ItemListing(id)
		 {
			  var storeId =  $('#fFromStoreId').val();	  
			var dataStr = 'action=getGroupItemList&Group1Id='+id+'&StoreId='+storeId;
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
			           $("#Group2ItemList").html(result);
				 
			   }
         
		  
		 });
		 		 					 
		 }
		  function getItemLising(id)
		  {
		 var Group1id = $("#fItemGroup1").val();
		  var storeId =  $('#fFromStoreId').val();
		var dataStr = 'action=getItemsList&Group1Id='+Group1id+'&StoreId='+storeId+'&Group2Id='+id;
		  $.ajax({
			   type: 'POST',
			   url: 'ajax/dropdown.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				  $("#ItemsList").html(result);
				 
			   }
          });
		  
		  }
		 
    function getItemList(id)
		{
			//var id = $("#fFromStoreId").val();
		      	var dataStr = 'action=getItemListDiv&fromstoreId='+id;
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				  $("#ItemList").html(result);
				
				 
			   }
			   
          });
		  
		  var dataStr = 'action=getDivisionList&storeID='+id;
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
			    $("#unitwisedivisionList").html(result);
				   
				 $('#purchaseItems').html(itemtable);
				 
			   }
          });
		  
		  
		}
		
		 		
		 function getStockItem(id)
		 {
			 var id = $('#fItemName').val();
			 var storeId =  $('#fFromStoreId').val();
			 var group2 = $('#fItemGroup2').val();
			var dataStr = 'action=getItem&StoreId='+storeId+'&ItemId='+id+'&group2='+group2;
			
		  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
			  
				  $('#purchaseItems').append(result);
				
			   }
          });
			
			
    //$('#purchaseItems').append('<tr><td>COL1</td><td>COL2</td><td>COL1</td><td>COL2</td><td>COL1</td><td>COL2</td><td>COL1</td></tr>');
		 }
   
   </script>
</body>
<!-- END BODY -->
</html>