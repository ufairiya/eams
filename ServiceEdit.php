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
  
   $id_service = $aRequest['fServiceId'];
  $aServiceInfo =$oMaster->getServiceInfo($id_service,'id');
/* echo '<pre>';
 print_r($aServiceInfo);
 echo '</pre>';*/
 if(isset($aRequest['send']))
  {
    $oFormValidator->setField("LIST", " Vendor", $aRequest['fVendorId'], 1, '', '', '', '');
$oFormValidator->setField("LIST", " Item Group 1", $aRequest['fGroup1'], 1, '', '', '', '');
$oFormValidator->setField("LIST", " Brand / Make", $aRequest['fItemGroup2'], 1, '', '', '', '');
$oFormValidator->setField("LIST", " Item Name", $aRequest['fItemName'], 1, '', '', '', '');
$oFormValidator->setField("ALLTEXT", " Mileage at service",  $aRequest['fMileageAtService'], 1, '', '', '', '');

if($oFormValidator->validation())
	  {
	
	if($result = $oMaster->addService($aRequest))
	{
	  $msg = "New Service Added.";
		 
	 echo '<script type="text/javascript">window.location.href="ServiceList.php?msg=success"</script>'; 
	}
	else $msg = $_aErrorMsg['Duplicate']; //"Sorry could not add..";
	}
	 else
	  {
	   $errMsg = $oFormValidator->createMsg("<br />");
	  }
  } 
   if(isset($aRequest['update']))
  {
    $oFormValidator->setField("ALLTEXT", "Bill Number", $aRequest['fBillNumber'], 1, '', '', '', '');
$oFormValidator->setField("ALLTEXT", " Bill Amount", $aRequest['fBillAmount'], 1, '', '', '', '');
$oFormValidator->setField("ALLTEXT", " Current Mileage", $aRequest['fOMR'], 1, '', '', '', '');
	if($oFormValidator->validation())
	  {
	
	if($result = $oMaster->updateService($aRequest))
	{
	  $msg = "Update Successfully.";
		 
	 echo '<script type="text/javascript">window.location.href="ServiceList.php?msg=updatesucess"</script>'; 
	}
	else $msg = $_aErrorMsg['Duplicate']; //"Sorry could not add..";
}
	 else
	  {
	   $errMsg = $oFormValidator->createMsg("<br />");
	  }
  } 
 
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Service Details</title>
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
                    Service
                     
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Service</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Service</a></li>
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
                      <?php if($aRequest['action'] == 'Add')
							{ ?>
                        <h4><i class="icon-reorder"></i>Add Service Details</h4>
                         <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit Service Details</h4>
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
                 
                                 <!-- BEGIN FORM-->
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal form-row-seperated" id="form_sample_3" method="post">
								  
								 <?php if($aRequest['action'] == 'Add')
							{ ?>  
							 <h3 class="form-section">Enter Service Details</h3> 
								<div class="row-fluid">
								<div class="span12 ">
								<div class="control-group">
								<label class="control-label">Item Group1 <span class="required">*</span></label>
								<div class="controls">
								<select class="m-wrap margin" tabindex="1" name="fGroup1" onChange="getGroup2ItemListing(this.value);" >
								<option value="0" selected="selected" >Choose the ItemGroup 1 </option>
								<?php
								$aItemGroup1List = $oMaster->getItemGroup1List();
								foreach($aItemGroup1List as $aItemGroup1)
								{
								?>
								
								<option value="<?php echo $aItemGroup1['id_itemgroup1']; ?>" <?php if((!empty($aServiceInfo['id_itemgroup1'])? $aServiceInfo['id_itemgroup1']:$aRequest['fGroup1']) == $aItemGroup1['id_itemgroup1']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup1['itemgroup1_name']; ?></option>
								<?php
								}
								?>
								</select>
								</div>
								</div>
								</div>
								</div>
								
								<div class="row-fluid">
								<div class="span12 ">
								<div class="control-group">
								<label class="control-label">Brand / Make <span class="required">*</span></label>
								<div class="controls" id="Group2ItemList">
								<select class="m-wrap" tabindex="2" name="fGroup2">
								<option value="0" selected="selected" >Choose the Brand / Make </option>
								
								</select>
								</div>
								</div>
								</div>
								</div>
								
								<div class="row-fluid">
								
								<div class="span12 ">
								<div class="control-group" >
								<label class="control-label">Item<span class="required">*</span></label>
								<div class="controls" id="ItemsList">
								<select class="m-wrap  nextRow margin" tabindex="3" name="fItemName">
								<option value="0" >Choose the Item</option>
								
								</select>
								</div>
								</div>
								</div>
								</div>
								
								<div class="row-fluid">
									<div class="span12 ">
										<div class="control-group">
										<label class="control-label">Vendor / Supplier <span class="required">*</span></label>
											<div class="controls">
											<select class="span3 m-wrap" data-placeholder="Choose a Vendor" tabindex="4" name="fVendorId" id="fVendorId">
											  <option value="0">Choose a Vendor</option>
											<?php
											$avendorList = $oAssetVendor->getAllVendorInfo();
											foreach($avendorList as $aVendor)
											{
											?>
											<option value="<?php echo $aVendor['id_vendor']; ?>" <?php if((!empty($aServiceInfo['id_vendor'])? $aServiceInfo['id_vendor']:$aRequest['fVendorId']) == $aVendor['id_vendor']) { echo 'selected=selected' ;}?>><?php echo $aVendor['vendor_name']; ?></option>
											<?php
											}
											?>
											</select>
											&nbsp;&nbsp;
											<span><a href="#" class="vendor" title="Add New Vendor"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
											</div>
										</div>
									</div>
								
								</div>
								<div class="row-fluid">
									<div class="span12 ">
									<div class="control-group">
                                              <label class="control-label">Mileage At Service<span class="required">*</span></label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap "  tabindex="5" placeholder="Mileage At Service" name="fMileageAtService" value="<?php echo (!empty($aServiceInfo['mileage'])? $aServiceInfo['mileage']:$aRequest['fMileageAtService']);?>" >
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
									</div>
								</div>
							<div class="row-fluid">	
								<div class="span6 ">
                                          <div class="control-group">
											  <label class="control-label" >Service Date</label>
											  <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10"  tabindex="6" type="text" value="<?php echo (!empty($aServiceInfo['service_date'])? date('d-m-Y',strtotime($aServiceInfo['service_date'])):$aRequest['fServiceDate']);?>" name="fServiceDate"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
										   </div>
                                       </div>
								   <div class="span6 ">
                                          <div class="control-group">
											  <label class="control-label" >Service Return Date</label>
											  <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10"  tabindex="7" type="text" value="<?php echo (!empty($aServiceInfo['service_return_date'])? date('d-m-Y',strtotime($aServiceInfo['service_return_date'])):$aRequest['fServiceReturnDate']);?>" name="fServiceReturnDate"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
										   </div>
                                       </div>
							   </div>
								
								 <?php } else { ?>  
								 
								 	<div class="form-horizontal form-view">
                                    <h3 class="form-section">Service Details</h3>
                                     <div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group error">
                                           
                                               <label class="control-label">Service No:</label>
                                             <div class="controls">
                                               <span class="text"><b><?php echo $aServiceInfo['service_no'];?></b></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       </div>
									    <div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group">
                                              <label class="control-label">Asset Number:</label>
                                             <div class="controls">
                                               <span class="text"><?php echo $aServiceInfo['asset_no'];?></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
									    </div>
									    <div class="row-fluid">
									   <div class="span12 ">
                                          <div class="control-group">
                                              <label class="control-label">Vehicle Number:</label>
                                             <div class="controls">
                                               <span class="text"><?php echo $aServiceInfo['machine_no'];?></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
									   </div>
									   
									   <div class="row-fluid">
									   <div class="span12 ">
                                          <div class="control-group">
                                              <label class="control-label">Vendor Name:</label>
                                             <div class="controls">
                                               <span class="text"><b><?php echo $aServiceInfo['vendor_name'];?></b></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
									   </div>
                                    <div class="row-fluid">
                                       <div class="span4 ">
                                          <div class="control-group">
                                              <label class="control-label">Item Group 1:</label>
                                             <div class="controls">
                                               <span class="text"><?php echo $aServiceInfo['itemgroup1_name'];?></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label">Brand / Make:</label>
                                             <div class="controls">
                                                 <span class="text"><?php echo $aServiceInfo['itemgroup2_name'];?></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
									   <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label">Item Name:</label>
                                             <div class="controls">
                                                 <span class="text"><?php echo $aServiceInfo['item_name'];?></span>
                                             </div>
                                          </div>
										   </div>
                                       </div>
                                       <!--/span-->
                                    </div> 
									<div class="row-fluid">
                                       <div class="span4 ">
                                          <div class="control-group">
                                              <label class="control-label">Mileage At Service:</label>
                                             <div class="controls">
                                               <span class="text"><?php echo $aServiceInfo['mileage_at_service'];?></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label">Service Sent On:</label>
                                             <div class="controls">
                                                 <span class="text"><?php echo date('d-m-Y',strtotime($aServiceInfo['service_date']));?></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
									   <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label">Service Return Date:</label>
                                             <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10"  tabindex="1" type="text"  value="<?php echo (!empty($aServiceInfo['service_return_date'])? date('d-m-Y',strtotime($aServiceInfo['service_return_date'])):$aRequest['fServiceReturnDate']); ?>" name="fServiceReturnDate"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
                                          </div>
										   </div>
                                       </div>
									   
									   <div class="row-fluid">
                                         <div class="span6 ">
									    <div class="control-group" >
                                        <label class="control-label">Service Type</label>
                                          <div class="controls" id="ItemsList">
                                             <select class="m-wrap  nextRow margin" tabindex="2" name="fServiceType">
                                    <option value=" " selected="selected">Choose  Service Type </option>
											 <?php
											  $aItemList =$oUtil->getServiceType();;
											  foreach($aItemList as $key => $value)
											  {
											 ?>
                                             <option value="<?php echo $key; ?>" <?php if((!empty($aServiceInfo['id_fuel_type'])? $aServiceInfo['id_fuel_type']:$aRequest['fServiceType']) == $key) { echo 'selected=selected' ;}?>><?php echo $value; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                           </div>
                                         </div>
									  </div>
									    <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" >Payment Type</label>
                                             <div class="controls" >
                                               <select class=" chosen" data-placeholder="Choose Payment type" tabindex="3" name="fPaymentType" id="fPaymentType">
                                                
                                                <?php $apaymentType =  $oUtil->getPaymentType();
												 foreach($apaymentType as $key => $value)
												  {
												 ?>
                                                  <option value="<?php echo $key; ?>" <?php if((!empty($aServiceInfo['payment_type'])? $aServiceInfo['payment_type']:$aRequest['fPaymentType']) == $key) { echo 'selected=selected' ;}?>><?php echo $value; ?></option>
                                                 <?php }
												 ?>
                                                 </select>
                                             </div>
                                          </div>
                                       </div>
                                      </div>
                                      <div class="row-fluid">
                                       <div class="span4">
                                          <div class="control-group">
                                              <label class="control-label">Bill Number<span class="required">*</span></label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap " tabindex="4"  placeholder="Bill Number" name="fBillNumber" value="<?php echo (!empty($aServiceInfo['bill_number'])? $aServiceInfo['bill_number']:$aRequest['fBillNumber']);?>">
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
									   
									   <div class="span4">
                                          <div class="control-group">
                                              <label class="control-label">Bill Amount<span class="required">*</span></label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap " tabindex="5"  placeholder="Bill Amount" name="fBillAmount" value="<?php echo (!empty($aServiceInfo['bill_amount'])? $aServiceInfo['bill_amount']:$aRequest['fBillAmount']);?>" >
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span4">
                                          <div class="control-group">
											  <label class="control-label" >Bill Date</label>
											  <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" tabindex="6"  type="text" value="<?php if($aServiceInfo['bill_date']!='' && $aServiceInfo['bill_date']!='0000-00-00' ) {echo date('d-m-Y',strtotime($aServiceInfo['bill_date']));} else { }?>" name="fBillDate"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
										   </div>
                                       </div>
                                         </div>
                                         
                                    <!--/row-->
									  	
									  
                                    <!--/row-->
							      
                                    
                                  <div class="row-fluid">
								  <div class="span4 ">
                                          <div class="control-group">
                                              <label class="control-label">Current Mileage (OMR) <span class="required">*</span></label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap " tabindex="7"  placeholder="Current Mileage" name="fOMR" value="<?php 
												if($aServiceInfo['mileage_after_service']!='')
												{
												echo  (!empty($aServiceInfo['mileage_after_service'])? $aServiceInfo['mileage_after_service']:$aRequest['fOMR']);
												}
												else
												{
												echo (!empty($aServiceInfo['mileage_at_service'])? $aServiceInfo['mileage_at_service']:$aRequest['fOMR']); }?>">
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <div class="span4 ">
                                          <div class="control-group">
                                              <label class="control-label">Next Service Mileage </label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap " tabindex="8"  placeholder="Service Mileage" name="fNextServiceMileage" value="<?php echo (!empty($aServiceInfo['next_service_mileage'])? $aServiceInfo['next_service_mileage']:$aRequest['fNextServiceMileage']);?>">
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span4">
                                          <div class="control-group">
											  <label class="control-label" >Next Service Date</label>
											  <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10"  tabindex="9" type="text" value="<?php if($aServiceInfo['next_service_date']!='' && $aServiceInfo['next_service_date']!='0000-00-00' ) {echo (!empty($aServiceInfo['next_service_date'])? date('d-m-Y',strtotime($aServiceInfo['next_service_date'])):$aRequest['fNextServiceDate']);} else { }?>" name="fNextServiceDate"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
										   </div>
                                       </div>
                                         </div>
                                      
								    <div class="row-fluid">
                                       <div class="span12">
                                          <div class="control-group">
                                             <label class="control-label">Remark</label>
                                             <div class="controls">
                                                <textarea class="large m-wrap" rows="3" tabindex="10"  name="fRemark"><?php echo (!empty($aServiceInfo['remarks'])? $aServiceInfo['remarks']:$aRequest['fRemark']);?></textarea>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       
                                       
                                    </div>
									
									<?php }?>   
                                    
								  <div class="form-actions">
                                   <?php if($aRequest['action'] == 'Add')
							{ ?>  
							 <input name="action" type="hidden" value="Add"/>  
							<button type="submit" class="btn blue" tabindex="8" name="send"><i class="icon-ok"></i>Add </button>     
                                      <?php } else if($aRequest['action'] == 'edit') { ?>
									   <input name="action" type="hidden" value="edit"/>  
                                    <input type="hidden" name="fServiceId" value="<?php echo $aRequest['fServiceId']; ?>"/>
                                        <button type="submit" tabindex="11" class="btn blue" name="update"><i class="icon-ok"></i>Update </button> 
                                       <a href="ServiceList.php"><button type="button" class="btn">Go Back</button></a>
                                        <?php } else { ?>
										 <input name="action" type="hidden" value="Add"/>  
							<button type="submit" class="btn blue" tabindex="8" name="send"><i class="icon-ok"></i>Add </button>     
										<?php } ?>
                                    </div>
								   </form>
                                  
                             
                                 <!-- END FORM-->                
                            
                        
									
									
									
									
									
									
                               
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
 function getGroup2ItemListing(id,group2id,itemid)
		 {
			 
			var dataStr = 'action=getGroupsItemList&Group1Id='+id+'&group2Id='+group2id;
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				          $("#Group2ItemList").html(result);
				 
			   }
         
		  
		 });
		 
		 	var dataStr = 'action=getGroupsItemList2&Group1Id='+id+'&itemId='+itemid;
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
			
</script>
</body>
<!-- END BODY -->
</html>