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
  
  $oAssetType  = &Singleton::getInstance('AssetType');
  $oAssetType->setDb($oDb);
  
  $aInventoryItems = $oMaster->getInventoryList('grn');
  $inventoryId     = $aRequest['fGrnId'];
  $counts          = $oMaster->assetCount();
  if(isset($aRequest['id']))
  {
  $itemid = $aRequest['id'];
  }
  else
  {
  $itemid = $aRequest['fAssetNumber'];
  }
  $aInvetoryItemInfo = $oMaster->getInventoryInfo($inventoryId,'id');
  $aAssetItem        = $oMaster->getAssetDetails($itemid,'id');
  $aInsuranceInfo      = $oMaster->getInsuranceInfoList($itemid);
  $aInsuranceDetails   = $oMaster->getInsuranceInfo($itemid);
 
  $aVendorContact    = $oMaster->getInsuranceVendorContact($aInsuranceDetails['id_insurance'],'insurance');

  $aMaintenance = $aAssetItem['AssetMaintenanaceinfo']['maintenance'];
 $aSalesInfo =  $oMaster->getSalesInvoiceItemInfo($itemid);
 
/* 
echo '<pre>';
print_r($aAssetItem );
echo '</pre>';
exit();*/

//contract
$aContactInfo =$oMaster->getContractInfoList($itemid);
/* 
echo '<pre>';
print_r($aContactInfo );
echo '</pre>';*/

$aContactDetails = $oMaster->geContractInfo($itemid);
$aContractVendorContact = $oMaster->getContractVendorContact($aContactDetails['id_contract'],'contract');
	
//insurance
 $aInsuranceInfo      = $oMaster->getInsuranceInfoList($itemid);
  $aInsuranceDetails   = $oMaster->getInsuranceInfo($itemid);
  $aInsuranceVendorContact    = $oMaster->getInsuranceVendorContact($aInsuranceDetails['id_insurance'],'insurance');

$purchasePrice=$aAssetItem['machine_price'] ;
 $lifeTime = $aAssetItem['machine_life'];
 if($aAssetItem['date_of_install']!='1970-01-01')
 {
 $startYear= $aAssetItem['date_of_install'];
 }
 else
 {
  $startYear='0000-00-00';
 }
$aDepreciation = $oDepreciation->straightLineDepreciation($purchasePrice, $lifeTime, $startYear,'');
/* $salvageValue = '500';
$aDepreciation_sv = $oDepreciation->straightLineDepreciation($purchasePrice, $lifeTime, $startYear,$salvageValue);*/
$factor = 2 * (1/$lifeTime);
$aDepreciation_dec  = $oDepreciation->decliningBalanceDepreciation($purchasePrice, $lifeTime, $startYear,$factor);
$aDepreciation_sum  = $oDepreciation->sumOfYearsDigits($purchasePrice, $startYear, $lifeTime);	

$percent = $aAssetItem['depressation_percent'];
$aDepreciation_redu = $oDepreciation->reducingBalanceDepreciation($purchasePrice, $lifeTime, $startYear,$percent,$itemid);


/*echo '<pre>';
print_r( $aDepreciation_redu );
echo '</pre>';
*/
			
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|Asset Details </title>
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
                     <small>Asset Details</small>
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
                     <li><a href="#">Add Asset Details </a></li>
                  </ul>
               </div>
            </div>
            
                             
            <!-- END PAGE HEADER-->
            
            
            <!-- BEGIN PAGE CONTENT-->
            
            <!-- BEGIN PAGE CONTENT-->
               <div class="row-fluid profile">
					<div class="span12">
						<!--BEGIN TABS-->
						<div class="tabbable tabbable-custom">
							
							<div class="tab-content">
								<div class="tab-pane row-fluid active" id="tab_1_1">
								
							
								
									<ul class="unstyled profile-nav span3">
									
									 
                                    
                                     <?php if($aAssetItem['asset_image']!='') {
										 ?>
                                          
										<li>
										
											<a class="fancybox-button" data-rel="fancybox-button" title="Photo" href="uploads/assetimage/<?php echo $aAssetItem['asset_image'];?>">
												<div class="zoom">
													<img src="uploads/assetimage/<?php echo $aAssetItem['asset_image'];?>" alt="Photo">							
													<div class="zoom-icon"></div>
												</div>
											</a>
											<div class="details">
												
												 <form action='AssetImage.php' method='post' ><input type='hidden' name='fAssetNumber' value="<?php echo $aAssetItem['id_asset_item'];  ?>"/> <input type='hidden' name='fInventoryItem' value="<?php echo $aAssetItem['id_inventory_item'];  ?>"/>
												 <input type='hidden' name='fReturnURL' value="AssetInfo.php"/>
												 <button type='submit' class='btn mini purple' style="height: 30px;">Edit Image</button>
												</form>
											</div>
								
										                                       
                                        <?php } else {?>
										
										<a class="fancybox-button" data-rel="fancybox-button" title="Photo" href="uploads/assetimage/<?php echo $aAssetItem['asset_image'];?>">
												<div class="zoom">
													   <img src="assets/img/noimage.gif" alt="" />					
													<div class="zoom-icon"></div>
												</div>
											</a>
											<br>
											<div class="details">
												
												
												 <form action='AssetImage.php' method='post' ><input type='hidden' name='fAssetNumber' value="<?php echo $aAssetItem['id_asset_item'];  ?>"/><input type='hidden' name='fInventoryItem' value="<?php echo $aAssetItem['id_inventory_item'];  ?>"/>
												 <input type='hidden' name='fReturnURL' value="AssetInfo.php"/>
												 <button type='submit' class='btn mini purple' style="height: 30px;">Add Image</button>
												</form>
											
											</div>
                                           
                                             <?php } ?>
                                        </li>
										
										<li>
										<table>
										<tr>
										<td>Asset Status</td>
										<td>:</td>
										<td><?php echo $oUtil->AssetItemStatus($aAssetItem['status']);?></td>
										</tr>
										<tr>
										<td>Maintenance </td>
										<td>:</td>
										<td><?php echo $oMaster->checkMaintenace($aAssetItem['id_asset_item']);?></td>
										</tr>
										<tr>
										<td>Insurance</td>
										<td>:</td>
										<td><?php 
										echo $oMaster->CheckInsurance($aAssetItem['id_asset_item']);
										
										?></td>
										</tr>
										</table>
										</li>
														
										
									</ul>
									<div class="span9">
										<div class="row-fluid">
											
											
											<div class="span12">
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
															<span class="sale-info">Asset Type</span> 
															<span class="sale-num"><?php echo $oAssetType->getAssetTypeName($aAssetItem['id_asset_type']);?></span>
														</li>
														<li>
															<span class="sale-info">Item Group 1</span> 
															<span class="sale-num"><?php echo $aAssetItem['itemgroup1_name'];?></span>
														</li>
														<li>
														<span class="sale-info">Brand / Make</span> 
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
                                            
                                            
										</div>
										<!--end row-fluid-->
										<div class="tabbable tabbable-custom tabbable-custom-profile">
											<ul class="nav nav-tabs">
												<li class="active"><a href="#tab_1_11" data-toggle="tab">Purchase Info </a></li>
												<li ><a href="#tab_1_22" data-toggle="tab">Warranty </a></li>
												<li class=""><a href="#tab_1_33" data-toggle="tab">Contract</a></li>
												<li class=""><a href="#tab_1_44" data-toggle="tab">Insurance</a></li>
												<li class=""><a href="#tab_1_55" data-toggle="tab">Depreciation</a></li>
												<li class=""><a href="#tab_1_66" data-toggle="tab">Maintenance</a></li>
												<li class=""><a href="#tab_1_77" data-toggle="tab">Sales Info</a></li>
												<li class=""><a href="#tab_1_88" data-toggle="tab"> Trans History</a></li>
											</ul>
											<div class="tab-content">
											
											<div class="tab-pane active" id="tab_1_11">
													<div class="portlet-body" style="display: block;">
													
													
													<div class="span12">
												<div class="portlet sale-summary">
													<div class="portlet-title">
														<h4><strong>Purchase Request</strong></h4>
											
													</div>
													<ul class="unstyled">
														<li>
															<span class="sale-info">Purchase Request Number</span> 
															<span class="sale-num"><b style="color:#FF0000;"><?php echo $aAssetItem['PurchaseRequestinfo'] ['request_no'];?></b></span>
														</li>
														<li>
															<span class="sale-info">Requester Name</span> 
															<span class="sale-num"><?php echo $aAssetItem['PurchaseRequestinfo']['employee_name'];?></span>
														</li>
														<li>
														<span class="sale-info">Date</span> 
															<span class="sale-num"><?php echo date('d-m-Y',strtotime($aAssetItem['PurchaseRequestinfo']['request_date']));?></span>
														</li>
														
													</ul>
                                                    
												
													<table class="table table-striped table-bordered table-advance table-hover">
															<thead>
																<tr>
																	<th>Particulars</th>
																	<th>Quantity</th>
																	<th>Unit Price</th>
																</tr>
															</thead>
															<tbody>
															<?php if(!empty($aAssetItem['PurchaseRequestIteminfo']['iteminfo'])){
															foreach($aAssetItem['PurchaseRequestIteminfo']['iteminfo'] as $aPurchaseItem)
															{
															?>
															<tr>
															<td>&nbsp;&nbsp;<?php echo $aPurchaseItem['itemgroup1_name'].'-'. $aPurchaseItem['itemgroup2_name'].'-'. $aPurchaseItem['item_name'];?>&nbsp;&nbsp;</td>
															<td><?php echo $aPurchaseItem['qty'].'  '.$aPurchaseItem['uom_name'];?></td>
															<td><strong><?php echo $aPurchaseItem['unit_cost'];?></strong></td>
															</tr>
															<?php } } ?>
															</tbody>
															</table>
															
															
														
														<h4><strong>Quotation Vendor List</strong></h4>
											            
                                                    <table class="table table-striped table-bordered table-advance table-hover">
															<thead>
																<tr>
																	<th>Vendor Name</th>
																	<th>Quotation Received Status</th>
																	<th>Quotation Document</th>
																	<th>Approved Status</th>
																</tr>
															</thead>
															<tbody>
															<?php if(!empty($aAssetItem['AssignVendorinfo']['vendorinfo'])){
															foreach($aAssetItem['AssignVendorinfo']['vendorinfo'] as $aVendorAssign)
															{
															$quote_approval = $oMaster->getQuotationApproval($aVendorAssign['id_pr'],'pr');
															$approved = $quote_approval['id_vendor'];
															?>
															<tr>
															<td><?php echo $aVendorAssign['vendor_name'];?></td>
															<td><?php  if($aVendorAssign['quote_received_status'] == 1)
															{
															echo ' Quotation Received';
															}else {
															echo ' Quotation NOt Received';
															}?></td>
															<td>
															<a class="fancybox fancybox.iframe" href="uploads/quotationdocument/<?php echo $oMaster->getQuotationDocument($aVendorAssign['id_pr'],$aVendorAssign['id_vendor']);?>">View Document</a>
															
															</td>
															<td><?php if($aVendorAssign['id_vendor'] == $approved)
															{
															echo 'Approved';
															}
															else
															{
															echo 'Un Approved';
															}
																														
															?></td>
															</tr>
															<?php } } ?>
															</tbody>
															</table>
															<br>
															<div class="portlet-title">
														<h4><strong>Purchase Order</strong></h4>
											
													</div>
													<ul class="unstyled">
														<li>
															<span class="sale-info">Purchase Order Number</span> 
															<span class="sale-num"><b style="color:#FF0000;"><?php echo $aAssetItem['PurchaseOrderinfo'] ['po_number'];?></b></span>
														</li>
														<li>
														<span class="sale-info">Date</span> 
															<span class="sale-num"><?php echo date('d-m-Y',strtotime($aAssetItem['PurchaseOrderinfo']['po_date']));?></span>
														</li>
														
													</ul>
													
													<table class="table table-striped table-bordered table-advance table-hover">
															<thead>
																<tr>
																	<th>Particulars</th>
																	<th>Quantity</th>
																	<th>Unit Price</th>
																</tr>
															</thead>
															<tbody>
															<?php if(!empty($aAssetItem['purchaseOrderIteminfo'])){
															foreach($aAssetItem['purchaseOrderIteminfo'] as $aPurchaseOrderItem)
															{
															?>
															<tr>
															<td>&nbsp;&nbsp;<?php echo $aPurchaseOrderItem['itemgroup1_name'].'-'. $aPurchaseOrderItem['itemgroup2_name'].'-'. $aPurchaseOrderItem['item_name'];?>&nbsp;&nbsp;</td>
															<td><?php echo $aPurchaseOrderItem['qty'].'  '.$aPurchaseOrderItem['uom_name'];?></td>
															<td><strong><?php echo $aPurchaseOrderItem['unit_cost'];?></strong></td>
															</tr>
															<?php } } ?>
															</tbody>
															</table>
													
													<!--GRN START-->
													<div class="portlet-title">
														<h4><strong>Goods Received Note </strong></h4>
											
													</div>
													<ul class="unstyled">
														<li>
															<span class="sale-info">GRN Number</span> 
															<span class="sale-num"><b style="color:#FF0000;"><?php echo $aAssetItem['Inventoryinfo'] ['grn_no'];?></b></span>
														</li>
														
														<li>
															<span class="sale-info">DC Number</span> 
															<span class="sale-num"><?php echo $aAssetItem['Inventoryinfo'] ['dc_number'];?></span>
														</li>
														<li>
															<span class="sale-info">DC Date</span> 
															<span class="sale-num"><?php echo  date('d-m-Y',strtotime($aAssetItem['Inventoryinfo'] ['dc_date']));?></span>
														</li>
														<li>
															<span class="sale-info">Bill Number</span> 
															<span class="sale-num"><?php echo $aAssetItem['Inventoryinfo'] ['bill_number'];?></span>
														</li>
														<li>
															<span class="sale-info">Bill Date</span> 
															<span class="sale-num"><?php echo  date('d-m-Y',strtotime($aAssetItem['Inventoryinfo'] ['bill_date']));?></span>
														</li>
														
														<li>
															<span class="sale-info">GRN Document</span> 
															<span class="sale-num"><a class="fancybox fancybox.iframe" href="uploads/grndocument/<?php echo $aAssetItem['InventoryinfoDoc']['document_path'];?>" target="_new">View Document</a></span>
														</li>
														
													</ul>
													
													<table class="table table-striped table-bordered table-advance table-hover">
															<thead>
																<tr>
																	<th>Particulars</th>
																	<th>Quantity</th>
																	<th>Unit Price</th>
																</tr>
															</thead>
															<tbody>
															<?php if(!empty($aAssetItem['InventoryIteminfo'])){
															foreach($aAssetItem['InventoryIteminfo'] as $aInventoryItem)
															{
															?>
															<tr>
															<td>&nbsp;&nbsp;<?php echo $aInventoryItem['itemgroup1_name'].'-'. $aInventoryItem['itemgroup2_name'].'-'. $aInventoryItem['item_name'];?>&nbsp;&nbsp;</td>
															<td><?php echo $aInventoryItem['qty'].'  '.$aInventoryItem['uom_name'];?></td>
															<td><strong><?php echo $aInventoryItem['unit_cost'];?></strong></td>
															</tr>
															<?php } } ?>
															</tbody>
															</table>
													
													
														<!--GRN END-->
													
													<div class="portlet-title">
														<h4><strong>Asset Inspection </strong></h4>
											
													</div>
													<ul class="unstyled">
														<li>
															<span class="sale-info">Review</span> 
															<span class="sale-num" style="color:#FF0000; font-size:12px;"> <?php echo $aAssetItem['AssetInspectioninfo']['inspectiondetails'];?></span>
														</li>
														
														
													</ul>
													
													</div>
											</div>
													
															
											</div>
											</div>
												
												<!--tab-pane-->
													
												<!--tab-pane-->
												
												<div class="tab-pane" id="tab_1_22">
													<div class="tab-pane active" id="tab_1_1_1">
													<?php if(!empty($aAssetItem)){?>
													<div class="span12" style="text-align:center;">
												<div class="portlet sale-summary">
													<div class="portlet-title">
														<h4>Warranty Summary</h4>
																								
													</div>
                                                    <ul class="unstyled">
																<li>
														<span class="sale-info">Warranty Start Date</span> 
															<span class="sale-num"><?php echo date('d/m/Y',strtotime($aAssetItem['warranty_start_date']));?></span>
														</li>
														<li>
															<span class="sale-info">Warranty End Date</span> 
															<span class="sale-num"><?php echo date('d/m/Y',strtotime($aAssetItem['warranty_end_date']));?></span>
													
													</ul>
													
                                                    
												</div>
											</div>
													<?php } ?>
													</div>
												</div>
												
												<div class="tab-pane" id="tab_1_33">
													<div class="tab-pane active" id="tab_1_1_1">
                                                  
													
													<div class="span12">
													<?php $aContact_exist = $oMaster->getAssetContract($aAssetItem['id_asset_item'],'assetexist');
											if( $aContact_exist == 0)
											{
                                                 ?>
                                                    <form action='Contract.php' method='post' ><input type='hidden' name='fAssetNumber' value="<?php echo $aAssetItem['id_asset_item'];  ?>"/><input type='hidden' name='fMultiple' value="no"/><input type='hidden' name='fGrnId' value="<?php echo $aAssetItem['id_grn'];  ?>"/>
												<button type='submit' class='btn mini purple' style="height: 30px;">Add Contract</button></form>
												<?php } ?>
												<?php if(!empty($aContactDetails)){?>
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
															<span class="sale-num"><?php echo date('d/m/Y',strtotime($aContactDetails['contract_start_date']));?></span>
														</li>
														<li>
															<span class="sale-info">Contract End Date</span> 
															<span class="sale-num"><?php echo date('d/m/Y',strtotime($aContactDetails['contract_end_date']));?></span>
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
                                                <?php } ?>
											</div>
													
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
													if(!empty($aContactInfo))
													{
													 foreach($aContactInfo['contract_doc_details']  as $contract_doc){	?><tr>
												<td><?php echo $contract_doc['id_contract'];?></td>
                                            <td><?php echo $contract_doc['document_name'];?></td>
                                          <td><?php echo $contract_doc['document_type'];?></td>
											 <td><a class="fancybox fancybox.iframe" href="uploads/document/<?php echo $contract_doc['document_name'];?>" target="_new"><?php echo $contract_doc['document_name'];?></a></td>
										
											
										</tr>
										<?php }
										}else {?>
										<tr>
										<td colspan="3" style="text-align:center"><b>No Contract Document Found</b></td>
										</tr>
                                        <?php }?>
                                        
								
                                                                       <!--/row-->           
                                    
																
																

															</tbody>
														</table>
														<br>
														<table class="table table-striped table-bordered table-advance table-hover">
															<thead>
																<tr>
																	<th>Contact Person Name</th>
																	
																	<th>Person Address</th>
																</tr>
															</thead>
															<tbody>
                                                           
                                                             <?php 	
															 	if(!empty($aContractVendorContact))
													            {
															 foreach($aContractVendorContact  as $aContractVendorContact){?>
                                   
                                   
										<tr>
											
											<td><?php echo $aContractVendorContact['vendor_address']['contact_name'];?></td>
                                            <td><?php echo $aContractVendorContact['vendor_address']['address_format'];?></td>
                                         
											
										</tr>
										<?php }
										} 
										else { ?>
                       					<tr><td colspan="2" style="text-align:center; font-weight:bold;"> No Contract Contact Found</td></tr>
                                        <?php } ?>
								
                                                                       <!--/row-->           
                                    
																
																

															</tbody>
														</table>
													</div>
												</div>
												<!--tab-pane-->
												
												<div class="tab-pane" id="tab_1_44">
													<div class="tab-pane active" id="tab_1_1_1">
                                                   
							
												
													<div class="span12" >
													
												<?php	$aInsurance_exist = $oMaster->getAssetInsurance($aAssetItem['id_asset_item'],'assetexist');  if($aInsurance_exist == 0 ) {?>
                                                     <form action="Insurance.php" method="post">
                                                    <input type='hidden' name='fAssetNumber' value="<?php echo $aAssetItem['id_asset_item'];  ?>"/><input type='hidden' name='fMultiple' value="no"/><input type='hidden' name='fGrnId' value="<?php echo $aAssetItem['id_grn'];  ?>"/>
											<input type="hidden" name="fMultiple" value="fMultiple">
											<button type='submit' class='btn mini purple' style="height: 30px;">Add Insurance</button>
                                                                                  </form>
																				  <?php } ?>
                                                            	<?php if(!empty($aInsuranceDetails)){?>
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
															<span class="sale-num"><?php echo date('d/m/Y',strtotime($aInsuranceDetails['ins_start_date']));?></span>
														</li>
														<li>
															<span class="sale-info">Insurance End Date</span> 
															<span class="sale-num"><?php echo date('d/m/Y',strtotime($aInsuranceDetails['ins_end_date']));?></span>
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
                                                 <?php }?>
											</div>
											       
													<table class="table table-striped table-bordered table-advance table-hover">
															<thead>
																<tr>
																	<th><i class="icon-briefcase"></i> Insurance Id</th>
																	<th class="hidden-phone"><i class="icon-question-sign"></i> Document Name</th>
																	<th><i class="icon-bookmark"></i> Document Type</th>
																	<th></th>
																</tr>
															</thead>
															<tbody>
                                                           
                                                             <?php 
									if(!empty($aInsuranceInfo))
									         {
									foreach($aInsuranceInfo['insurance_doc_details']  as $insurance_doc)
									{
																		
									?>
                                   
                                   
										<tr>
											
											<td><?php echo $insurance_doc['id_insurance'];?></td>
                                            <td><?php echo $insurance_doc['document_name'];?></td>
                                          <td><?php echo $insurance_doc['document_type'];?></td>
											 <td>
														 <a class="fancybox fancybox.iframe" href="uploads/document/<?php echo $insurance_doc['document_name'];?>" target="_new"><?php echo $insurance_doc['document_name'];?></a></td>
										
											
										</tr>
										<?php }
										} else {
										?>
										<tr><td  colspan="4" style="text-align:center; font-weight:bold;">No Insurance Document Found </td></tr>
                       	<?php }?>
                                        
								
                                                                       <!--/row-->           
                                    
																
																

															</tbody>
														</table>
														<br>
														<table class="table table-striped table-bordered table-advance table-hover">
															<thead>
																<tr>
																	<th>Contact Person Name</th>
																	
																	<th>Person Address</th>
																</tr>
															</thead>
															<tbody>
                                    <?php 
									if(!empty($aInsuranceVendorContact))
									         {
									foreach($aInsuranceVendorContact  as $aInsuranceVendorContact)
									{
    								?>
                                    <tr>
									 <td><?php echo $aInsuranceVendorContact['vendor_address']['contact_name'];?></td>
                                     <td><?php echo $aInsuranceVendorContact['vendor_address']['address_format'];?></td>
									</tr>
								<?php }
										} else {
										?>
										<tr><td  colspan="2" style="text-align:center; font-weight:bold;">No Insurance Contact Found </td></tr>
                       	<?php }?>
                       
                                        
								
                                                                       <!--/row-->           
                                    
																
																

															</tbody>
														</table>
													</div>
												</div>
													
												
												<div class="tab-pane" id="tab_1_55">
													<div class="tab-pane active" id="tab_1_1_1">
                                                 
														<b>Date of Install : <?php echo  date('d-m-Y',strtotime($startYear)) ; ?></b>                          
																
														 <h3>Reducing balance depreciation method.</h3>
															
															 <table cellpadding="3" border="1" class="table table-striped table-hover">
															
															<tr>
															
															   <th colspan="5">Asset Purchase Price</th>
															
															   <th><?php echo number_format($purchasePrice,2); ?></th>
															
															 </tr>
															
															 <tr>
															
															   <th colspan="5">LifeTime</th>
															
															   <th><?php echo $lifeTime; ?> Years</th>
															
															 </tr>
															
															 
															
															  <tr>
															
															   <th colspan="5">Percentage</th>
															
															   <th><?php echo $percent; ?> %</th>
															
															 </tr>
															
															
															
															 <tr>
															
															  <th>Financial Year</th>
															  <th>Additional Amount </th>
															  <th>Depreciable Basis</th>
															  <th>Depreciation Expense</th>
															  <th>Accumulated Depreciation</th>
														      <th>Written Down Value</th>
															 </tr>
															
															 <?php
															
															   foreach($aDepreciation_redu as $aDep)
															
															   {
															
															 ?>
															
															   <tr>
															
															   <td><?php echo $aDep['Year']; ?></td>
															   <td><?php echo $aDep['AdditionalDepreciable_Basis'];?></td>
															   <td style="text-align:right;"><?php echo number_format($aDep['Depreciable_Basis'],2); ?></td>
															
															   <td style="text-align:right;"><?php echo number_format($aDep['Dep_Expense'],2); ?></td>
																
															   <td style="text-align:right;"><?php echo number_format($aDep['Accumulated_Dep'],2); ?></td>
															    <td style="text-align:right;"><?php echo number_format($aDep['Written_Down_Value'],2); ?></td>
															
															   </tr>
															
															 <?php
															
															   }
															
															 ?>
															
															 </table>
															
															<?php /*?><br>		
																
																						 
															<h3>StraightLine method - Without Salvage value.</h3>
															
															<table cellpadding="3" border="1"  class="table table-striped table-hover">
															
															<tr>
															
															   <th colspan="2">Asset Purchase Price</th>
															
															   <th><?php echo $purchasePrice; ?></th>
															
															 </tr>
															
															 <tr>
															
															   <th colspan="2">LifeTime</th>
															
															   <th><?php echo $lifeTime; ?></th>
															
															 </tr>
															
															
															
															 <tr>
															
															   <th>Financial Year</th>
															
															   <th>Annual Depreciation</th>
															
															   <th>Dep.Asset.Price</th>
															
															 </tr>
															
															 <?php
															
															   foreach($aDepreciation as $aDep)
															
															   {
															
															 ?>
															
															   <tr>
															
															   <td><?php echo $aDep['Year']; ?></td>
															
															   <td><?php echo $aDep['Annual_Dep']; ?></td>
															
															   <td><?php echo $aDep['Dep_Asset_Price']; ?></td>
															
															   </tr>
															
															 <?php
															
															   }
															
															 ?>
															
															 </table>
															
															 <br>
															 
															  <br>
															<?php if(!empty($aDepreciation_sv) ){ ?>
															<h3>StraightLine method - With Salvage value.</h3>
															
															 <table cellpadding="3" border="1" class="table table-striped table-hover">
															
															<tr>
															
															   <th colspan="2">Asset Purchase Price</th>
															
															   <th><?php echo $purchasePrice; ?></th>
															
															 </tr>
															
															 <tr>
															
															   <th colspan="2">LifeTime</th>
															
															   <th><?php echo $lifeTime; ?></th>
															
															 </tr>
															
															 
															
															  <tr>
															
															   <th colspan="2">Salvage Value</th>
															
															   <th><?php echo $salvageValue; ?></th>
															
															 </tr>
															
															
															
															 <tr>
															
															   <th>Financial Year</th>
															
															   <th>Annual Depreciation</th>
															
															   <th>Dep.Asset.Price</th>
															
															 </tr>
															
															 <?php
															
															   foreach($aDepreciation_sv as $aDep)
															
															   {
															
															 ?>
															
															   <tr>
															
															   <td><?php echo $aDep['Year']; ?></td>
															
															   <td><?php echo $aDep['Annual_Dep']; ?></td>
															
															   <td><?php echo $aDep['Dep_Asset_Price']; ?></td>
															
															   </tr>
															
															 <?php
															
															   }
															
															 ?>
															
															 </table>
															 
															 
															  <br>
															  <?php } ?>
															
															<h3>Declining balance depreciation method.</h3>
															
															 <table cellpadding="3" border="1" class="table table-striped table-hover">
															
															<tr>
															
															   <th colspan="3">Asset Purchase Price</th>
															
															   <th><?php echo $purchasePrice; ?></th>
															
															 </tr>
															
															 <tr>
															
															   <th colspan="3">LifeTime</th>
															
															   <th><?php echo $lifeTime; ?></th>
															
															 </tr>
															
															 
															
															  <tr>
															
															   <th colspan="3">Factor</th>
															
															   <th><?php echo $factor; ?></th>
															
															 </tr>
															
															
															
															 <tr>
															
															   <th>Financial Year</th>
															
															   <th>Depreciable Basis</th>
															
															   <th>Depreciation Expense</th>
															
															   <th>Accumulated Depreciation</th>
															
															 </tr>
															
															 <?php
															
															   foreach($aDepreciation_dec as $aDep)
															
															   {
															
															 ?>
															
															   <tr>
															
															   <td><?php echo $aDep['Year']; ?></td>
															
															   <td><?php echo $aDep['Depreciable_Basis']; ?></td>
															
															   <td><?php echo $aDep['Dep_Expense']; ?></td>
															
															   <td><?php echo $aDep['Accumulated_Dep']; ?></td>
															
															   </tr>
															
															 <?php
															
															   }
															
															 ?>
															
															 </table>
															
															<br>
															
															<h3>Sum of the Years Digits</h3>
															
															<table cellpadding="3" border="1" class="table table-striped table-hover">
															
															<tr>
															
															   <th colspan="2">Asset Purchase Price</th>
															
															   <th><?php echo $purchasePrice; ?></th>
															
															 </tr>
															
															 <tr>
															
															   <th colspan="2">LifeTime</th>
															
															   <th><?php echo $lifeTime; ?></th>
															
															 </tr>
															
															
															
															 <tr>
															
															   <th>Financial Year</th>
															
															   <th>Depreciation Calculation</th>
															
															   <th>Dep.Asset.Price</th>
															
															 </tr>
															
															 <?php
															
															   foreach($aDepreciation_sum as $aDep)
															
															   {
															
															 ?>
															
															   <tr>
															
															   <td><?php echo $aDep['Year']; ?></td>
															
															   <td><?php echo $aDep['Dep_Calculation']; ?></td>
															
															   <td><?php echo $aDep['Dep_Amount']; ?></td>
															
															   </tr>
															
															 <?php
															
															   }
															
															 ?>
															
															 </table>
				<?php */?>									</div>
												</div>
													
													<div class="tab-pane" id="tab_1_66">
													<div class="tab-pane active" id="tab_1_1_1">
														<table class="table table-striped table-bordered table-advance table-hover">
															<thead>
																<tr>
																	<th>Start Date</th>
																	<th>Return Date </th>
																	<th>Bill Number</th>
																	<th>Bill Amount</th>
																	<th>Bill Date</th>
																	<th>Service Invoice Date</th>
																	<th>Add to Depriceation</th>
																	<th>Document</th>
																</tr>
															</thead>
															<tbody>
															<?php foreach($aMaintenance as $aMaintenanceItem) {?>
															<tr>
															<td><?php echo $aMaintenanceItem['idle_start_date'];?></td>
															<td><?php echo $aMaintenanceItem['idle_end_date'];?></td>
															<td><?php echo $aMaintenanceItem['bill_number'];?></td>
															<td><?php echo $aMaintenanceItem['bill_amount'];?></td>
															<td><?php echo $aMaintenanceItem['bill_date'];?></td>
															<td><?php echo $aMaintenanceItem['bill_created_on'];?></td>
															
															<td><?php echo $aMaintenanceItem['for_depreciation'];?></td>
															<td><a class="fancybox fancybox.iframe" href="uploads/servicedocument/<?php echo $aMaintenanceItem['document_path'];?>" target="_new"><?php echo $aMaintenanceItem['document_path'];?></a></td>
															</tr>
															<?php } ?>
															</tbody>
															</table>
															
													</div>
													</div>
												<div class="tab-pane" id="tab_1_77">
													<div class="tab-pane active" id="tab_1_1_1">
														<?php if(!empty($aSalesInfo)){?>
												<div class="portlet sale-summary">
													<div class="portlet-title">
														<h4>Sales Invoice Summary</h4>
													</div>
                                                    <ul class="unstyled">
														
														<li>
															<span class="sale-info">Sales Invoice Number</span> 
															<span class="sale-num"><?php echo $aSalesInfo['invoice_number'];?></span>
														</li>
                                                       	<li>
														<span class="sale-info">Sales Invoice Date</span> 
															<span class="sale-num"><?php echo date('d/m/Y',strtotime($aSalesInfo['invoice_date']));?></span>
														</li>
														<li>
															<span class="sale-info">Delivery  Number</span> 
															<span class="sale-num"><?php echo $aSalesInfo['delivery_number'];?></span>
														</li>
                                                        <li>
															<span class="sale-info">Vendor Name</span> 
															<span class="sale-num"><?php echo $aSalesInfo['vendor_name'];?></span>
														</li>
														 <li>
															<span class="sale-info">Tax Name</span> 
															<span class="sale-num"><?php echo $aSalesInfo['tax_name'];?></span>
														</li>
														 <li>
															<span class="sale-info">Tax Percentage</span> 
															<span class="sale-num"><?php echo $aSalesInfo['tax_percentage'];?> % </span>
														</li>
                                                        <li>
															<span class="sale-info">Purchased Price</span> 
															<span class="sale-num"><?php echo $aSalesInfo['purchased_price'];?></span>
														</li>
														
														 <li>
															<span class="sale-info">Depreciation Price</span> 
															<span class="sale-num"><b><?php echo $aSalesInfo['depreciation_price'];?></b></span>
														</li>
														 <li>
															<span class="sale-info">Sold Price</span> 
															<span class="sale-num"><b><?php echo $aSalesInfo['sale_price'];?></b></span>
														</li>
														 <li>
															<span class="sale-info">Tax Price</span> 
															<span class="sale-num"><?php echo $aSalesInfo['tax_price'];?></span>
														</li>
														
														 <li>
															<span class="sale-info">Net Amount</span> 
															<span class="sale-num"><b><?php echo $total = $aSalesInfo['tax_price'] + $aSalesInfo['total_price'];?></b></span>
														</li>
														
														<li>
															<span class="sale-info">Profit / Loss</span> 
															<span class="sale-num" ><?php 
															$net_total = $total - $aSalesInfo['depreciation_price'];
															if($net_total > 0)
															{
															echo '<span style="color:#3cc051;font-weight:bold;">'.$net_total.'<span>';
															}
															else
															{
															echo '<span style="color:#FF0000;font-weight:bold;">'.$net_total.'<span>';
															}
															?></span>
														</li>
													</ul>
													
                                                    
												</div>
                                                 <?php } else {?>
												   No Sales Record Found
												 <?php } ?>
													</div>
													</div>
												
												<div class="tab-pane" id="tab_1_88">
													<div class="tab-pane active" id="tab_1_1_1">
												<div class="span12">
												<div class="portlet sale-summary">
												<div class="portlet-title">
												<h4><strong>Purchase Request</strong></h4>
												
												</div>
												<ul class="unstyled">
												<li>
												<span class="sale-info">Purchase Request Number</span> 
												<span class="sale-num"><b style="color:#FF0000;"><?php echo $aAssetItem['PurchaseRequestinfo'] ['request_no'];?></b></span>
												</li>
												</ul>
												</div>
												
												
												
												<?php $aPRTrans =$oMaster->getTransactionList($aAssetItem['PurchaseRequestinfo']['id_pr'],"PR"); /*echo '<pre>';
												print_r($aPRTrans);echo '</pre>';*/
												?>
												<table class="table table-striped table-bordered table-advance table-hover">
												<thead>
												<tr>
												<th> Date </th>
												<th> Transaction Type </th>
												<th> Transaction Description </th>
												
												</tr>
												</thead>
												<?php foreach($aPRTrans as $PRTran) {?>
												<tr>
												<td><?php echo $PRTran['created_on'];?>	</td>
												<td><?php echo $PRTran['trans_type'];?></td>			
												<td><?php echo $PRTran['trans_disc'];?>	</td>
												</tr>
												<?php } ?>
												</table>
												</div>
												<br>
												
												<div class="span12" style="margin-left: 0px;">
												<div class="portlet sale-summary">
												<div class="portlet-title">
												<h4><strong>Purchase Order</strong></h4>
												
												</div>
												<ul class="unstyled">
												<li>
												<span class="sale-info">Purchase Order Number</span> 
												<span class="sale-num"><b style="color:#FF0000;"><?php echo $aAssetItem['PurchaseOrderinfo'] ['po_number'];?></b></span>
												</li>
												</ul>
												</div>
												
												
												
												<?php $aPOTrans =$oMaster->getTransactionList($aAssetItem['PurchaseOrderinfo']['id_po'],"PO"); /*echo '<pre>';
												print_r($aPOTrans);echo '</pre>';*/
												?>
												<table class="table table-striped table-bordered table-advance table-hover">
												<thead>
												<tr>
												<th>Date</th>
												<th>Transaction Type</th>
												<th>Transaction Description</th>
												
												</tr>
												</thead>
												<?php foreach($aPOTrans as $POTran) {?>
												<tr>
												<td><?php echo $POTran['created_on'];?></td>
												<td><?php echo $POTran['trans_type'];?></td>			
												<td><?php echo $POTran['trans_disc'];?></td>
												</tr>
												<?php } ?>
												</table>		
												</div>	
												
												<div class="span12" style="margin-left: 0px;">
												<div class="portlet sale-summary">
												<div class="portlet-title">
												<h4><strong>GRN</strong></h4>
												
												</div>
												<ul class="unstyled">
												<li>
												<span class="sale-info">GRN Number</span> 
												<span class="sale-num"><b style="color:#FF0000;"><?php echo $aAssetItem['Inventoryinfo'] ['grn_no'];?></b></span>
												</li>
												</ul>
												</div>
												
												<?php $aGRNTrans =$oMaster->getTransactionList($aAssetItem['Inventoryinfo']['id_inventory'],"GRN"); /*echo '<pre>';
												print_r($aPOTrans);echo '</pre>';*/
												?>
												<table class="table table-striped table-bordered table-advance table-hover">
												<thead>
												<tr>
												<th> Date </th>
												<th> Transaction Type </th>
												<th> Transaction Description </th>
												
												</tr>
												</thead>
												<?php foreach($aGRNTrans as $GRNTran) {?>
												<tr>
												<td><?php echo $GRNTran['created_on'];?>	</td>
												<td><?php echo $GRNTran['trans_type'];?></td>			
												<td><?php echo $GRNTran['trans_disc'];?>	</td>
												</tr>
												<?php } ?>
												</table>		
												</div>		
												
												<div class="span12" style="margin-left: 0px;">
												<div class="portlet sale-summary">
												<div class="portlet-title">
												<h4><strong>Asset </strong></h4>
												
												</div>
												
												</div>
												
												<?php $aAssetrans =$oMaster->getAssetTransaction($aAssetItem['id_asset_item']); /*echo '<pre>';
												print_r($aAssetrans);echo '</pre>';*/
												?>
												<table class="table table-striped table-bordered table-advance table-hover">
												<thead>
												<tr>
												<th> Date </th>
												<th> Transaction Type </th>
												<th>FROM Location</th>
												<th>To Location</th>
												<th> Transaction Description </th>
												
												</tr>
												</thead>
												<?php foreach($aAssetrans as $aAsseTran) {?>
												<tr>
												<td><?php echo $aAsseTran['action_date'];?>	</td>
												<td><?php echo 'ASSET';?></td>
												<td><?php echo $aAsseTran['from_location_name'];?></td>	
												<td><?php echo $aAsseTran['to_location_name'];?></td>		
												<td><?php echo $aAsseTran['trans_disc'];?>	</td>
												</tr>
												<?php } ?>
												</table>		
												</div>
												</div>
											</div>													
													</div>
													</div>
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
	<link href="modalbox/SyntaxHighlighter.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="modalbox/shCore.js" language="javascript"></script>
    <script type="text/javascript" src="modalbox/shBrushJScript.js" language="javascript"></script>
    <script type="text/javascript" src="modalbox/ModalPopups.js" language="javascript"></script>
  <script type="text/javascript">
  
  function ModalPopupsAlert99(id) {
    var dataString = 'AssetImage.php?fAssetNumber='+id;
    ModalPopups.Alert("jsAlert99",
        "UploadImage",
        "", {
            okButtonText: "Close",
            loadTextFile: ""+dataString,
            width: 800,
            height: 400});
}   

  </script>
</body>
<!-- END BODY -->
</html>