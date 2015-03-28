<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $oAssetCategory = &Singleton::getInstance('AssetCategory');
  $oAssetCategory->setDb($oDb);
$aInventoryItems = $oMaster->getInventoryList('grn');
$inventoryId = $aRequest['fGrnId'];
$counts = $oMaster->assetCount();
   
	
		$aInvetoryItemInfo = $oMaster->getInventoryInfo($inventoryId,'id');
		 $aAssetItem = $oMaster->getAssetItemInfo($aRequest['fAssetNumber'],'id');
		   $aContactInfo =$oMaster->getContractInfoList($aRequest['fAssetNumber']);
		   $aContactDetails = $oMaster->geContractInfo($aRequest['fAssetNumber']);
		   $aVendorContact = $oMaster->getContractVendorContact($aContactDetails['id_contract'],'contract');

 if(isset($aRequest['add']))
  {
    if( $oMaster->addContract($aRequest,$_FILES))
	{
	   $msg = "New Contract Added.";
	  echo '<script type="text/javascript">window.location.href="AssetList.php?msg=updatesucess";</script>';
	}
	else $msg = "Sorry";
  } //submit 

if(($aRequest['fMultiple']== 'yes'))
{
	$AssetNumber = serialize($aRequest['fAssetNumber']);
}
else
{
	$AssetNumber = $aRequest['fAssetNumber'];
}
																	
								
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS | Contract </title>
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
                     Asset
                     <small>Asset  master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Asset</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Add Asset </a></li>
                  </ul>
               </div>
            </div>
            
                              <?php
							     if(isset($_GET['msg']))
								 {
							   ?>
							    <div class="alert alert-success">
									<button class="close" data-dismiss="alert"></button>
									<?php
									
									if($_GET['msg'] == 'success')
									{
										echo $msg = 'New Asset Added Successfully';
									}
									else if($_GET['msg'] == 'updatesucess')
									{
										echo $msg = 'New Asset Updated Successfully';
									}
									else if($_GET['msg'] =='delsuccess')
									{
										echo $msg = 'New Asset Deleted Successfully';
									}
									else if($_GET['msg'] =='undelsuccess')
									{
										echo $msg = 'This Asset is parent, so we can not delete';
									}
									   ?>
								</div>
                                
								<?php
								  }
								?> 
                                
            <!-- END PAGE HEADER-->
            
            
            <!-- BEGIN PAGE CONTENT-->
            
            <!-- BEGIN PAGE CONTENT-->
            <?php 
									
									$aContact_exist = $oMaster->getAssetContract($aRequest['fAssetNumber'],'assetexist');
									
									?>
                                  
                                 
                                 
                                    <?php if($aContact_exist == '0')
									{
										?>
							<div class="portlet box green">
                              <div class="portlet-title">
                                 <h4><i class="icon-reorder"></i>Contract </h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="javascript:;" class="reload"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <form action="#" class="form-horizontal" method="post"  id="contract" enctype="multipart/form-data">
                                 
                                 
                                  <div>
                                   
                                        <h3 class="form-section">Contract For</h3>
                                 <table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>Asset Number</th>
                                            <th>Item Group 1 </th>
                                             <th>Item Group 2 </th>
											<th class="hidden-480">Item Name</th>
											 <th>Current Unit </th>
                                             <th>Current Store </th>
                                             <th>Current Document Yes / No </th>
										</tr>
									</thead>
									<tbody>
                                    <?php 
									
									foreach($aRequest['fAssetNumber'] as $key => $value)
									{
																				
									$aAssetItemList = $oMaster->getAssetItemInfo($value,'id');
									$aContact_exist = $oMaster->getAssetContract($value,'assetexist');
									
									?>
										<tr class="odd gradeX">
											
											<td><?php echo $aAssetItemList['asset_no'];?></td>
                                            <td><?php echo $aAssetItemList['itemgroup1_name'];?></td>
                                            <td><?php echo $aAssetItemList['itemgroup2_name'];?></td>
											<td ><?php echo $aAssetItemList['item_name'];?></td>
                                            <td><?php echo $aAssetItemList['unit_name'];?></td>
											<td ><?php echo $aAssetItemList['store_name'];
											?></td>
                                            <td><?php if($aContact_exist == 0)
											{
												?>
                                                <span>No</span>
												<?php
											}else {?>
											 <span>Yes</span>
                                            <?php } ?>
                                             </td>
										</tr>
										<?php }
										
										?>
                                       
                       					<tr class="odd gradeX">
											
											<td><?php echo $aAssetItem['asset_no'];?></td>
                                            <td><?php echo $aAssetItem['itemgroup1_name'];?></td>
                                            <td><?php echo $aAssetItem['itemgroup2_name'];?></td>
											<td ><?php echo $aAssetItem['item_name'];?></td>
                                            <td><?php echo $aAssetItem['unit_name'];?></td>
											<td ><?php echo $aAssetItem['store_name'];
											?></td>
											 <td><?php if($aContact_exist == 0)
											{
												?>
                                                <span>No</span>
												<?php
											}else {?>
											 <span>Yes</span>
                                            <?php } ?>
                                             </td>
										</tr>
                                        
									</tbody>
								</table>
                               
                                 </div>
                                    
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
										  <label class="control-label">Contract Title </label>
										  <div class="controls" id="polist">
                                                <input type="text" class="m-wrap span10" placeholder="Contract Title" name="fContractTitle">
                                                <!--<span class="help-block">Purchase Order No.</span>-->
                                          </div>
										</div>
                                       </div>
                                       <!--/span-->
                                      <div class="span6 ">
                                          <div class="control-group">
										  <label class="control-label">Contract Reference Number</label>
										  <div class="controls" id="polist">
                                                <input type="text" class="m-wrap span10" placeholder="Contract Reference Number" name="fContractReferenceNo">
                                                <!--<span class="help-block">Purchase Order No.</span>-->
                                          </div>
										</div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Contract Order Value</label>
                                             <div class="controls">
                                             <?php 
											 if($aContact_exist == 0)
											{
												?>
                                           <input type="text" class="m-wrap span10" name="fContractOrderValue" value="<?php echo $aAssetItem['asset_amount'];?>"/>
                                           <?php } else {?>
                                            <input type="text" class="m-wrap span10" name="fContractOrderValue" value="<?php echo $aAssetItemList['asset_amount'];?>"/>
                                           <?php } ?>
                                                
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Contract Value As Per the Contract</label>
                                               <div class="controls">
												  <input type="text" class="m-wrap span10" name="fContractValue"/>
											  </div>
                                            
                                          </div>
                                       </div>
                                      
                                       <!--/span-->
                                    </div>
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Contract Type</label>
                                             <div class="controls">
                                             <select  class="span10" name="fContractType" >
											 <option value="">Choose the Contract Type</option>
                                             <?php $contractType = $oUtil->getContractType(); 
											 foreach ( $contractType as $key => $value )
											 {
											 ?>
                                             <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                             <?php } ?>
                                             </select>
                                                
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Contract Date</label>
                                               <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fContractDate"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
                                            <span for="fContractDate" class="help-inline"></span>
                                          </div>
                                       </div>
                                      
                                       <!--/span-->
                                    </div>
                                    
                                    
                                   <div class="row-fluid">
                                       <div class="span6 ">
									    <div class="control-group">
                                        
                                        
                                        <label class="control-label">Vendor / Supplier</label>
                                        
                                          <div class="controls">
                                             <select class="span10 chosen" data-placeholder="Choose a Vendor" tabindex="1" name="fVendorId" id="fVendorId" onChange="getVendorContact(this.id);">
     										    <option value="0">Choose a Vendor</option>
												  <?php
												  $avendorList = $oAssetVendor->getAllVendorInfo();
												  foreach($avendorList as $aVendor)
												  {
												 ?>
												 <option value="<?php echo $aVendor['id_vendor']; ?>" <?php if($aAssetItem['id_vendor'] == $aVendor['id_vendor']) { echo 'selected=selected' ;}?>><?php echo $aVendor['vendor_name']; ?></option>
												 <?php
												  }
												 ?>
                                             </select>
                                           </div>
                                         </div>
									  </div>
                                       <!--/span-->
                                      <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Contract Start Date (FROM)</label>
                                               <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fContractStartDate"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
                                            <span for="fContractStartDate" class="help-inline"></span>
                                          </div>
                                       </div>
                                       
                                       <!--/span-->
                                    </div>
                                    <!--/row-->        
                                    <div class="row-fluid">
                                     <div class="span6 ">
                                    <div class="control-group">
                              <label class="control-label">Vendor Contact Person</label>
                              <div class="controls" id="Contactlist">
                                 <select data-placeholder="Choose Multiple Contact Person" class="chosen span10" multiple="multiple" tabindex="6">
                                 <option value="0">Choose Contact Person</option>
                                  </select>
                              </div>
                           </div>
                                    </div>
                                       
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Contract End Date (TO)</label>
                                             <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fContractEndDate"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
											   <span for="fContractEndDate" class="help-inline"></span>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->                               
                                   <div class="row-fluid">
                                       <div class="span6 ">
                                         <div class="control-group">
                              <label class="control-label">Upload Multiple Contract Document</label>
                              <div class="controls">
                                 <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="input-append">
                                       <div class="uneditable-input">
                                          <i class="icon-file fileupload-exists"></i> 
                                          <span class="fileupload-preview"></span>
                                       </div>
                                       <span class="btn btn-file">
                                       <span class="fileupload-new">Select file</span>
                                       <span class="fileupload-exists">Change</span>
                                      <input type="file" name="files[]" multiple/>
                                        </span>
                                       <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                    </div>
                                 </div>
                              </div>
                           </div> 
                                       </div>
                                       
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Next Contract Renewal Date</label>
                                               <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fContractRenewalDate"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
                                            <span for="fContractRenewalDate" class="help-inline"></span>
                                          </div>
                                       </div>
                                    </div>
                                     <div class="row-fluid">
                                       <div class="span6 ">
                                    <div class="control-group">
                                       <label class="control-label">Remarks</label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fRemark"></textarea>
                                       </div>
                                    </div>
                                    </div>
                                    </div>
                                   
                                    <input type="hidden" name="fAssetNumber" value="<?php echo htmlentities($AssetNumber);?>" />
                                       <input type="hidden" name="fMultiple" value="<?php echo $aRequest['fMultiple'];?>" />
                                       
                                       <div class="form-actions">
                                       <button type="submit" class="btn blue" name="add"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn">Cancel</button>
                                    </div>
                                      
                                     
                                    <!--/row-->
                                    
                                 </form>
                                 <!-- END FORM-->                
                              </div>
                              </div>
                             
                                      
                          <?php } else { ?>
            
         	
            <div class="row-fluid profile">
					<div class="span12">
						<!--BEGIN TABS-->
						<div class="tabbable tabbable-custom">
							
							<div class="tab-content">
								<div class="tab-pane row-fluid active" id="tab_1_1">
									<ul class="unstyled profile-nav span3">
                                    
                                     <?php if($aAssetItem['asset_image']!='') {
										 ?>
                                          
										<li> <img src="uploads/assetimage/<?php echo $aAssetItem['asset_image'];?>" alt="" />
                                        
                                        <?php } else {?>
                                             <img src="assets/img/noimage.gif" alt="" />
                                             <?php } ?>
                                        </li>
										
									</ul>
									<div class="span9">
										<div class="row-fluid">
											
											
											<div class="span6">
												<div class="portlet sale-summary">
													<div class="portlet-title">
														<h4>Asset Summary</h4>
														
														
														
													</div>
													<ul class="unstyled">
														<li>
															<span class="sale-info">Asset Number</span> 
															<span class="sale-num"><b style="color:#FF0000;"><?php echo $aAssetItem['asset_no'];?></b></span>
														</li>
														<li>
															<span class="sale-info">Item Group 1</span> 
															<span class="sale-num"><?php echo $aAssetItem['itemgroup1_name'];?></span>
														</li>
														<li>
														<span class="sale-info">Item Group 2</span> 
															<span class="sale-num"><?php echo $aAssetItem['itemgroup2_name'];?></span>
														</li>
														<li>
															<span class="sale-info">Item Name</span> 
															<span class="sale-num"><?php echo $aAssetItem['item_name'];?></span>
														</li>
                                                        <li>
															<span class="sale-info">Unit</span> 
															<span class="sale-num"><?php echo $aAssetItem['unit_name'];?></span>
														</li>
                                                        <li>
															<span class="sale-info">Store</span> 
															<span class="sale-num"><?php echo $aAssetItem['store_name'];?></span>
														</li>
													</ul>
                                                    
												</div>
											</div>
											<!--end span4-->
                                            
                                            <div class="span6">
												<div class="portlet sale-summary">
													<div class="portlet-title">
														<h4>Contract Summary</h4>
														
														
														
													</div>
                                                    <ul class="unstyled">
														
														<li>
															<span class="sale-info">Contract Name</span> 
															<span class="sale-num"><?php echo $aContactDetails['contract_title'];?></span>
														</li>
                                                        <li>
															<span class="sale-info">Contract Type</span> 
															<span class="sale-num"><?php echo $aContactDetails['contract_type'];?></span>
														</li>
														 <li>
															<span class="sale-info">Contract Order Amount</span> 
															<span class="sale-num"><?php echo $aContactDetails['contract_order_value'];?></span>
														</li>
														
														 <li>
															<span class="sale-info">Contract  Amount</span> 
															<span class="sale-num"><?php echo $aContactDetails['contract_value'];?></span>
														</li>
														<li>
														<span class="sale-info">Contract Start Date</span> 
															<span class="sale-num"><?php echo date('m/d/Y',strtotime($aContactDetails['contract_start_date']));?></span>
														</li>
														<li>
															<span class="sale-info">Contract End Date</span> 
															<span class="sale-num"><?php echo date('m/d/Y',strtotime($aContactDetails['contract_end_date']));?></span>
														</li>
                                                        <li>
															<span class="sale-info">Vendor Name</span> 
															<span class="sale-num"><?php echo $aContactDetails['vendor_name'];?></span>
														</li>
                                                        <li>
															<span class="sale-info">Status</span> 
															<span class="sale-num"><?php echo $oUtil->AssetItemStatus($aContactDetails['status']);?></span>
														</li>
													</ul>
													
                                                    
												</div>
											</div>
										</div>
										<!--end row-fluid-->
										<div class="tabbable tabbable-custom tabbable-custom-profile">
											<ul class="nav nav-tabs">
												<li class="active"><a href="#tab_1_11" data-toggle="tab">Document List</a></li>
												<li class=""><a href="#tab_1_22" data-toggle="tab">Vendor Contact</a></li>
											</ul>
											<div class="tab-content">
												<div class="tab-pane active" id="tab_1_11">
													<div class="portlet-body" style="display: block;">
                                                 
														<table class="table table-striped table-bordered table-advance table-hover">
															<thead>
																<tr>
																	<th><i class="icon-briefcase"></i> Contact Id</th>
																	<th class="hidden-phone"><i class="icon-question-sign"></i> Document Name</th>
																	<th><i class="icon-bookmark"></i> Document Type</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>
                                                           
                                                             <?php 
									
									foreach($aContactInfo['contract_doc_details']  as $contract_doc)
									{
																				
									
									
									?>
                                   
                                   
										<tr>
											
											<td><?php echo $contract_doc['id_contract'];?></td>
                                            <td><?php echo $contract_doc['document_name'];?></td>
                                          <td><?php echo $contract_doc['document_type'];?></td>
											 <td><a class="fancybox fancybox.iframe" href="uploads/document/<?php echo $contract_doc['document_name'];?>" target="_new"><?php echo $contract_doc['document_name'];?></a></td>
										
											
										</tr>
										<?php }?>
                       
                                        
								
                                                                       <!--/row-->           
                                    
																
																

															</tbody>
														</table>
													</div>
												</div>
												<!--tab-pane-->
												<div class="tab-pane" id="tab_1_22">
													<div class="tab-pane active" id="tab_1_1_1">
														<table class="table table-striped table-bordered table-advance table-hover">
															<thead>
																<tr>
																	<th>Contact Person Name</th>
																	
																	<th>Person Address</th>
																</tr>
															</thead>
															<tbody>
                                                           
                                                             <?php 
									
									foreach($aVendorContact  as $VendorContact)
									{
																				
									
									
									?>
                                   
                                   
										<tr>
											
											<td><?php echo $VendorContact['vendor_address']['contact_name'];?></td>
                                            <td><?php echo $VendorContact['vendor_address']['address_format'];?></td>
                                         
											
										</tr>
										<?php }?>
                       
                                        
								
                                                                       <!--/row-->           
                                    
																
																

															</tbody>
														</table>
													</div>
												</div>
												<!--tab-pane-->
											</div>
										</div>
									</div>
									<!--end span9-->
								</div>
							
							</div>
						</div>
						<!--END TABS-->
					</div>
				</div>
            			
           <?php } ?>
           <!-- BEGIN PAGE CONTENT-->
				
				<!-- END PAGE CONTENT-->
            <!-- END PAGE CONTENT--> 
            </div>        
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      
      
      <!-- END PAGE -->  
 
   <!-- END CONTAINER -->
	<?php include_once 'Footer1.php'; ?>
     
    
    <script type="text/javascript">
	
	function ShowResult(id,grnid)
			{
				
			url = document.URL.split("?")[0];
			var dropresult = addParam(url, "Itemid",id);	
			var dropresult1 = addParam(dropresult, "id",grnid);	
			var dropresult2 = addParam(url, "id",id);	
			var dropresult3= addParam(dropresult1, "tab",1);	
			var dropresult4= addParam(dropresult2, "tab",1);	
			if(grnid !='')
			{
			window.location.href = dropresult3;
			}
			else
			{
				window.location.href = dropresult4;
			}
			}
			
			 jQuery(document).ready(function() { 
		 jQuery("#fAssetCategoryId").on('change', function() {
		   
		   var id = $("#fAssetCategoryId").val();
		   	var dataStr = 'action=getAssettype&catId='+id;
		    $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				 
					  jQuery("#Assettypeitemlist").html(result);
				 
			   }
          });
		  
		 });
		 
		  }); //
		  
		 function getVendorContact(id)
		 {
		   var id = $("#fVendorId").val();
		   	var dataStr = 'action=getVendorContact&vendorId='+id;
		    $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
					  jQuery("#Contactlist").html(result);
				 
			   }
          });
		  
		 }
	
	function addParam(url, param, value) {
    var a = document.createElement('a');
    a.href = url;
    a.search += a.search.substring(0,1) == "?" ? "&" : "?";
    a.search += encodeURIComponent(param);
    if (value)
        a.search += "=" + encodeURIComponent(value);
    return a.href;
}
jQuery(document).ready(function() { 
	
	$(function () {
	$("select#fVendorId").change();
	
	});

});


</script>
<script>

$(document).ready(function() {

var contractform =  $("#contract");
  contractform.validate({
	errorElement: 'span', //default input error message container
            errorClass: 'help-inline', // default input error message class
  rules: {
            fContractTitle: {
                required: true
            },
			fContractType: {
			required: true
			},
			fContractDate: {
			required: true
			},
			fMaxContract: {
			required: true
			},
			fContractOrderValue: {
			required: true
			},
			fContractValue: {
			required: true
			},
			fVendorId: {
			required: true
			},
			fContractStartDate: {
			required: true
			},
			fContractEndDate: {
			required: true
			},
			fContractRenewalDate: {
			required: true
			},			
			
			
        },
		 messages: { // custom messages for radio buttons and checkboxes
              
				 fContractTitle: {
                    required: "Please Enter the Contract Title"
                },
				fContractType: {
                    required: "Select  the Contract Type"
                },
				fContractDate: {
                    required: "Please Enter the Contract Date"
                },
				fMaxContract: {
                    required: "Select  the Maximum Contract Item"
                },
				fContractOrderValue: {
                    required: "Please Enter the Contract Order Value"
                },
				
				fContractValue: {
                    required: "Please Enter the Contract Value"
                },
				fVendorId: {
                    required: "Select  the Contract Provider"
                },
				fContractStartDate: {
                    required: "Please Enter the Contract Start Date"
                },
				fContractEndDate: {
                    required: "Please Enter the Contract End Date"
                },
				fContractRenewalDate: {
                    required: "Please Enter the Contract Next Renewal Date"
                }
				
				
				
            },
			  invalidHandler: function (event, validator) { //display error alert on form submit   
               $('.alert-success').hide();
               $('.alert-error').show();
               
            },
			 highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.help-inline').removeClass('ok'); // display OK icon
                $(element)
                    .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
            },
			unhighlight: function (element) { // revert the change dony by hightlight
                $(element)
                    .closest('.control-group').removeClass('error'); // set error class to the control group
            },
			
    submitHandler: function (form) { // for demo
           $('.alert-success').show();
		    $('.alert-error').hide();
		   form.submit();
           
        }
       
		
    });
	
	//apply validation on chosen dropdown value change, this only needed for chosen dropdown integration.
        $('.chosen, .chosen-with-diselect', $("#contract")).change(function () {
           $("#contract").validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });	
});


</script>
</body>
<!-- END BODY -->
</html>