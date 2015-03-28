<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo   = $oSession->getSession('sesCustomerInfo');
  $aRequest        = $_REQUEST;
  $oAssetCategory  = &Singleton::getInstance('AssetCategory');
  $oAssetCategory->setDb($oDb);
  $aInventoryItems = $oMaster->getInventoryList('grn');
  $inventoryId     = $aRequest['fGrnId'];
  $counts          = $oMaster->assetCount();
  
 
  
  $aInvetoryItemInfo = $oMaster->getInventoryInfo($inventoryId,'id');
  $aAssetItem        = $oMaster->getAssetItemInfo($aRequest['fAssetNumber'],'id');
  $aInsuranceDocInfo      = $oMaster->getInsuranceInfoList($aRequest['fAssetNumber']);
  $aInsuranceDetails   = $oMaster->getInsuranceInfo($aRequest['fAssetNumber']);
  $aVendorContact    = $oMaster->getInsuranceVendorContact($aInsuranceDetails['id_insurance'],'insurance');
/*echo '<pre>';
	
			print_r($aInsuranceInfo);
echo '</pre>';
exit();

*/  if(isset($aRequest['add']))
  {
    if( $oMaster->addInsurance($aRequest,$_FILES))
	{
	   $msg = "New Insurance Added.";
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
if($aRequest['action'] == 'edit')
{
 $asset_id = $aRequest['fAssetNumber'];
 $aInsuranceinfo   = $oMaster->getInsuranceInfo($asset_id);
/*echo '<pre>';
	
			print_r($aInsuranceinfo);
echo '</pre>';
exit();*/
} 															
 	 if(isset($aRequest['update']))
  {
   if( $oMaster->updateInsurance($aRequest,$_FILES))
	{
	   $msg = "New Insurance Updated.";
	  echo '<script type="text/javascript">window.location.href="Insurance.php?fAssetNumber='.$aRequest['fAssetNumber'].'";</script>';
	}
	else $msg = "Sorry";
  }						
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|Insurance </title>
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
                     <small>Insurance</small>
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
                     <li><a href="#">Insurance </a></li>
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
										echo $msg = 'New Insurance Added Successfully';
									}
									else if($_GET['msg'] == 'updatesucess')
									{
										echo $msg = 'Insurance Updated Successfully';
									}
									else if($_GET['msg'] =='delsuccess')
									{
										echo $msg = 'Insurance Deleted Successfully';
									}
									else if($_GET['msg'] =='undelsuccess')
									{
										echo $msg = 'This Insurance is parent, so we can not delete';
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
									
									$aInsurance_exist = $oMaster->getAssetInsurance($aRequest['fAssetNumber'],'assetexist');
									
									?>
                                  
                                 
                                 
                                    <?php if($aInsurance_exist == '0' || $aRequest['action'])
									{
										?>
							<div class="portlet box green">
                              <div class="portlet-title">
                                 <h4><i class="icon-reorder"></i>Insurance </h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="javascript:;" class="reload"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <form action="#" class="form-horizontal" method="post" id="insurance" enctype="multipart/form-data">
                                 
                                 
                                  <div>
                                   
                                        <h3 class="form-section">Insurance For</h3>
                                 <table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>Asset Number</th>
											<th>vehicle Number</th>
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
									
									 $aInsurance_exist = $oMaster->getAssetInsurance($value,'assetexist');
									?>
										<tr class="odd gradeX">
											
											<td><?php echo $aAssetItemList['asset_no'];?></td>
											<td><?php echo $aAssetItemList['machine_no'];?></td>
                                            <td><?php echo $aAssetItemList['itemgroup1_name'];?></td>
                                            <td><?php echo $aAssetItemList['itemgroup2_name'];?></td>
											<td ><?php echo $aAssetItemList['item_name'];?></td>
                                            <td><?php echo $aAssetItemList['unit_name'];?></td>
											<td ><?php echo $aAssetItemList['store_name'];
											?></td>
                                            <td><?php if($aInsurance_exist == 0)
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
											<td><b><?php echo $aAssetItem['machine_no'];?></b></td>
                                            <td><?php echo $aAssetItem['itemgroup1_name'];?></td>
                                            <td><?php echo $aAssetItem['itemgroup2_name'];?></td>
											<td ><?php echo $aAssetItem['item_name'];?></td>
                                            <td><?php echo $aAssetItem['unit_name'];?></td>
											<td ><?php echo $aAssetItem['store_name'];
											?></td>
											 <td><?php if($aInsurance_exist == 0)
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
										  <label class="control-label">Insurance Title </label>
										  <div class="controls" id="polist">
                                                <input type="text" class="m-wrap span10" placeholder="Insurance Title" name="fInsuranceTitle" value=" <?php echo (!empty($aInsuranceinfo['insurance_policy_name'])? $aInsuranceinfo['insurance_policy_name']:$aRequest['fInsuranceTitle']);?>">
                                                <!--<span class="help-block">Purchase Order No.</span>-->
                                          </div>
										</div>
                                       </div>
                                       <!--/span-->
                                      <div class="span6 ">
                                          <div class="control-group">
										  <label class="control-label">Insurance Reference Number</label>
										  <div class="controls" id="polist">
                                                <input type="text" class="m-wrap span10" placeholder="Insurance Reference Number" name="fInsuranceReferenceNo" value=" <?php echo (!empty($aInsuranceinfo['reference'])? $aInsuranceinfo['reference']:$aRequest['fInsuranceReferenceNo']);?>">
                                                <!--<span class="help-block">Purchase Order No.</span>-->
                                          </div>
										</div>
                                       </div>
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Policy Amount</label>
                                             <div class="controls">
                                             <?php 
											 if($aContact_exist == 0)
											{
												?>
                                           <input type="text" class="m-wrap span10" name="fInsuranceOrderValue" value="<?php echo (!empty($aAssetItem['asset_amount'])? $aAssetItem['asset_amount']:$aRequest['fInsuranceOrderValue']) ;?>"/>
                                           <?php } else {?>
                                            <input type="text" class="m-wrap span10" name="fInsuranceOrderValue" value="<?php echo (!empty( $aAssetItemList['asset_amount'])?  $aAssetItemList['asset_amount']:$aRequest['fInsuranceOrderValue']);?>"/>
                                           <?php } ?>
                                                
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Premium Amount</label>
                                               <div class="controls">
												  <input type="text" class="m-wrap span10" name="fInsuranceValue"  value="<?php echo (!empty($aInsuranceinfo['premium_amount'])? $aInsuranceinfo['premium_amount']:$aRequest['fInsuranceValue']) ;?>"/>
											  </div>
                                            
                                          </div>
                                       </div>
                                      
                                       <!--/span-->
                                    </div>
                                    
                                    <div class="row-fluid">
                                       <?php /*?><div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Insurance Type</label>
                                             <div class="controls">
                                             <select  class="span10 chosen" name="fContractType" >
                                             <?php $contractType = $oUtil->getContractType(); 
											 foreach ( $contractType as $key => $value )
											 {
											 ?>
                                             <option value="<?php echo $key;?>"><?php echo $value;?></option>
                                             <?php } ?>
                                             </select>
                                                
                                             </div>
                                          </div>
                                       </div><?php */?>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Insurance Date</label>
                                               <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fInsuranceDate" value="<?php echo (!empty($aInsuranceinfo['created_on'])? date('d-m-Y',strtotime($aInsuranceinfo['created_on'])):$aRequest['fInsuranceDate']) ;?>"/>
													<span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
                                            <span for="fInsuranceDate" class="help-inline"></span>
                                          </div>
                                       </div>
                                      
                                       <!--/span-->
                                    </div>
                                    
                                    
                                   <div class="row-fluid">
                                       <div class="span6 ">
									    <div class="control-group">
                                        
                                        
                                        <label class="control-label">Insurance Provider</label>
                                        
                                          <div class="controls">
                                             <select class="span10 " data-placeholder="Choose a Provider" tabindex="1" name="fVendorId" id="fVendorId" onChange="getVendorContact(this.id);">
     										    <option value="">Choose a Provider</option>
												  <?php
												   $aItemGroup = $oMaster->getDistIgroup();
												  foreach( $aItemGroup as $ItemGroup)
												  {
												  ?>
												  <optgroup label="<?php echo $ItemGroup['itemgroup1_name']; ?>">
												  <?php
												  $avendorList = $oAssetVendor->getAllVendorInfos($ItemGroup['id_itemgroup1']);
												  foreach($avendorList as $aVendor)
												  {
												 ?>
												 <option value="<?php echo $aVendor['id_vendor']; ?>" <?php if($aInsuranceinfo['id_vendor'] == $aVendor['id_vendor']) { echo 'selected=selected' ;}?>><?php echo $aVendor['vendor_name']; ?></option>
												 <?php
												  }
												 ?>
												  </optgroup>
												 <?php } ?>
                                             </select>
											 &nbsp; &nbsp; <span><a href="#" class="vendor" title="Add New Vendor"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                           </div>
                                         </div>
									  </div>
                                       <!--/span-->
                                      <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Insurance Start Date (FROM)</label>
                                               <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fInsuranceStartDate"
													value="<?php echo (!empty($aInsuranceinfo['ins_start_date'])? date('d-m-Y',strtotime($aInsuranceinfo['ins_start_date'])):$aRequest['fInsuranceStartDate']) ;?>"/>
													<span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
                                              <span for="fInsuranceStartDate" class="help-inline"></span>
                                          </div>
                                       </div>
                                       
                                       <!--/span-->
                                    </div>
                                    <!--/row-->        
                                    <div class="row-fluid">
                                     <div class="span6 ">
                                    <div class="control-group">
                              <label class="control-label">Insurance Contact Person</label>
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
                                             <label class="control-label">Insurance End Date (TO)</label>
                                             <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fInsuranceEndDate"
													value="<?php echo (!empty($aInsuranceinfo['ins_end_date'])? date('d-m-Y',strtotime($aInsuranceinfo['ins_end_date'])):$aRequest['fInsuranceStartDate']) ;?>"/>
													<span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
											    <span for="fInsuranceEndDate" class="help-inline"></span>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->                               
                                   <div class="row-fluid">
                                       <div class="span6 ">
                                         <div class="control-group">
                              <label class="control-label">Upload Multiple Insurance Documents</label>
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
                                             <label class="control-label">Next Insurance Renewal Date</label>
                                               <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fInsuranceRenewalDate"
													value="<?php echo (!empty($aInsuranceinfo['renewal_date'])? date('d-m-Y',strtotime($aInsuranceinfo['renewal_date'])):$aRequest['fInsuranceRenewalDate']) ;?>"/>
													<span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
                                              <span for="fInsuranceRenewalDate" class="help-inline"></span>
                                          </div>
                                       </div>
                                    </div>
                                     <div class="row-fluid">
                                       <div class="span6 ">
                                    <div class="control-group">
                                       <label class="control-label">Remarks</label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fRemark"><?php echo (!empty($aInsuranceinfo['remarks'])? $aInsuranceinfo['remarks']:$aRequest['fRemark'])?></textarea>
                                       </div>
                                    </div>
                                    </div>
                                    </div>
                                   
                                    <input type="hidden" name="fAssetNumber" value="<?php echo htmlentities($AssetNumber);?>" />
                                       <input type="hidden" name="fMultiple" value="<?php echo $aRequest['fMultiple'];?>" />
                                       
                                       <div class="form-actions">
									   <?php if($aRequest['action'] == 'Add') { ?>
									    <input type="hidden" name="action" value="Add"/>
                                       <button type="submit" class="btn blue" name="add"><i class="icon-ok"></i> Save</button>
									     <?php } else if($aRequest['action'] == 'edit') { ?>
										  <input type="hidden" name="action" value="edit"/>
										   									  
										  <input type="hidden" name="fInsuranceId" value="<?php echo $aInsuranceinfo['id_insurance'];?>"/>
										  
										    <button type="submit" class="btn blue" name="update"><i class="icon-ok"></i> Update Insurance</button>
											<?php } else { ?>
											 <input type="hidden" name="action" value="Add"/>
											<button type="submit" class="btn blue" name="add"><i class="icon-ok"></i> Save</button>
									   <?php } ?>
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
									<ul>
									<li> <a href="?fAssetNumber=<?php echo $AssetNumber;?>&action=edit" class="btn mini green"><i class="icon-edit"></i>Edit Insurance</a></li>
									</ul>
									
									 <br>
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
														<h4>Insurance Summary</h4>
													</div>
                                                    <ul class="unstyled">
														
														<li>
															<span class="sale-info">Insurance Name</span> 
															<span class="sale-num"><?php echo $aInsuranceDetails['insurance_policy_name'];?></span>
														</li>
														<li>
															<span class="sale-info">Insurance Policy Amount</span> 
															<span class="sale-num"><?php echo $aInsuranceDetails['policy_amount'];?></span>
														</li>
														<li>
															<span class="sale-info">Insurance Premium Amount</span> 
															<span class="sale-num"><?php echo $aInsuranceDetails['premium_amount'];?></span>
														</li>
                                                       	<li>
														<span class="sale-info">Insurance Start Date</span> 
															<span class="sale-num"><?php echo date('m/d/Y',strtotime($aInsuranceDetails['ins_start_date']));?></span>
														</li>
														<li>
															<span class="sale-info">Insurance End Date</span> 
															<span class="sale-num"><?php echo date('m/d/Y',strtotime($aInsuranceDetails['ins_end_date']));?></span>
														</li>
                                                        <li>
															<span class="sale-info">Provider Name</span> 
															<span class="sale-num"><?php echo $aInsuranceDetails['vendor_name'];?></span>
														</li>
                                                        <li>
															<span class="sale-info">Status</span> 
															<span class="sale-num"><?php echo $oUtil->AssetItemStatus($aInsuranceDetails['status']);?></span>
														</li>
													</ul>
													
                                                    
												</div>
											</div>
										</div>
										<!--end row-fluid-->
										<div class="tabbable tabbable-custom tabbable-custom-profile">
											<ul class="nav nav-tabs">
												<li class="active"><a href="#tab_1_11" data-toggle="tab">Document List</a></li>
												<li class=""><a href="#tab_1_22" data-toggle="tab">Provider Contact</a></li>
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
															 									
									foreach($aInsuranceDocInfo['insurance_doc_details']  as $insurance_doc)
									{
																				
									
									
									?>
                                   
                                   
										<tr>
											
											<td><?php echo $insurance_doc['id_insurance'];?></td>
                                            <td><?php echo $insurance_doc['document_name'];?></td>
                                          <td><?php echo $insurance_doc['document_type'];?></td>
											 <td>
														 <a class="fancybox fancybox.iframe" href="uploads/document/<?php echo $insurance_doc['document_name'];?>" target="_new"><?php echo $insurance_doc['document_name'];?></a></td>
										
											
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

var contractform =  $("#insurance");
  contractform.validate({
	errorElement: 'span', //default input error message container
            errorClass: 'help-inline', // default input error message class
  rules: {
            fInsuranceTitle: {
                required: true
            },
			
			fInsuranceDate: {
			required: true
			},
			
			fInsuranceOrderValue: {
			required: true
			},
			fInsuranceValue: {
			required: true
			},
			fVendorId: {
			required: true
			},
			fInsuranceStartDate: {
			required: true
			},
			fInsuranceEndDate: {
			required: true
			},
			fInsuranceRenewalDate: {
			required: true
			},			
			
			
        },
		 messages: { // custom messages for radio buttons and checkboxes
              
				 fInsuranceTitle: {
                    required: "Please Enter the Insurance Title"
                },
				
				fInsuranceDate: {
                    required: "Please Enter the Insurance Date"
                },
				
				fInsuranceOrderValue: {
                    required: "Please Enter the Insurance Order Value"
                },
				
				fInsuranceValue: {
                    required: "Please Enter the Insurance Value"
                },
				fVendorId: {
                    required: "Select  the Insurance Provider"
                },
				fInsuranceStartDate: {
                    required: "Please Enter the Insurance Start Date"
                },
				fInsuranceEndDate: {
                    required: "Please Enter the Insurance End Date"
                },
				fInsuranceRenewalDate: {
                    required: "Please Enter the Insurance Next Renewal Date"
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
        $('.chosen, .chosen-with-diselect', $("#insurance")).change(function () {
           $("#insurance").validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
        });	
});


</script>
</body>
<!-- END BODY -->
</html>