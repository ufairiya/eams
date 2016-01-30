<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  
  $oAssetDepartment = &Singleton::getInstance('Department');
  $oAssetDepartment->setDb($oDb);
  $item_id = $_REQUEST['id'];
  $avendorList = $oAssetVendor->getAllVendorInfo();
  if(isset($_REQUEST['id']) && $aRequest['action'] != 'edit')
  {
	   $edit_result = $oMaster->getPurchaseRequestItemInfo($item_id,'id');
	   $aPurchasedItem = $edit_result;
	   $apurchaserequest_info = $oMaster->getPurchaseRequestInfo($item_id,'id');
		$avendorList = $oMaster->getAssignVendorToPrInfo( $item_id,'pr');	

  }
  
   
   $oAssetVendor = &Singleton::getInstance('Vendor');
  $oAssetVendor->setDb($oDb);
    $oAssetUnit = &Singleton::getInstance('AssetUnit');
  $oAssetUnit->setDb($oDb);
   if(isset($aRequest['send']))
  {
    if($oMaster->addPurchaseOrder($aRequest))
	{
	   //$msg = "New Employee Added.";
	  echo '<script type="text/javascript">window.location.href="PurchaseOrder.php?msg=success";</script>';
	}
	else $msg = "Sorry could not add..";
  } 
    if(isset($aRequest['Update']))
  {
    if($oMaster->updatePurchaseOrder($aRequest, 'update'))
	{
	  $msg = "Purchase Order Updated.";
	  echo '<script type="text/javascript">window.location.href="PurchaseOrder.php?msg=updatesucess";</script>';
	}
	else 
	  $msg = "Sorry";
  } //update
 if($aRequest['action'] == 'edit')
  {
	$item_id = $aRequest['id'];
	$aEditPurchaseOrder = $oMaster->getPurchaseOrderInfo($item_id,'id');
    $aitemInfo  = $oMaster->getPurchaseOrderItemInfo($item_id,'');
	$apurchaserequest_info = $oMaster->getPurchaseRequestInfo($aEditPurchaseOrder['id_pr'],'id');
	if($apurchaserequest_info['id_pr']!=0)
	{
	$avendorList = $oMaster->getAssignVendorToPrInfo($aEditPurchaseOrder['id_pr'],'pr');	
	}
	else
	{
	 $avendorList = $oAssetVendor->getAllVendorInfo();
	}
 $aPurchasedItem = $aitemInfo;
/* echo '<pre>';
 print_r($aitemInfo);
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
   <title>EAMS| Purchase Order</title>
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
                     Purchase Order 
                     <small>Purchase Order master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Purchase</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Purchase Order</a></li>
                  </ul>
               </div>
            </div>
            
                              <?php
							     if(isset($aRequest['msg']))
								 {
							   ?>
							    <div class="alert alert-success">
									<button class="close" data-dismiss="alert"></button>
									<?php
									if($aRequest['msg'] == 'success')
									{
										echo $msg = 'New Purchase Order Created Successfully';
									}
									else if($aRequest['msg'] == 'updatesucess')
									{
										echo $msg = 'Purchase Order Updated Successfully';
									}
									else if($aRequest['msg'] =='delsuccess')
									{
										echo $msg = 'Purchase Order Deleted Successfully';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'This Unit is parent, so we can not delete';
									}
									?>
								</div>
								<?php
								  }
								?> 
            <!-- END PAGE HEADER-->
                    <!-- BEGIN PAGE CONTENT-->
						<div class="row-fluid">
               <div class="span12">
                  
                   
                     <div class="tab-content">
                        
                        <div class="tab-pane active" id="purchaseorder">
                           <div class="portlet box green">
                              <div class="portlet-title">
                                 <h4><i class="icon-reorder"></i>Purchase Order </h4>
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
                                        <h3 class="form-section">Purchase Request</h3>
										<div class="row-fluid">
										<div class="span6 ">
                                            <div class="control-group">
											<?php if($aRequest['action'] != 'edit')
											{
											?> 
                                      <div class="controls">
                                 <label class="radio">
                                 <input type="radio" name="fOrderType" id="fOrderType" value="General" tabindex="1"  onChange="getOrderType(this.value)" <?php if($aEditPurchaseOrder['id_pr']== '0' || $apurchaserequest_info['id_pr'] == 0 || $aRequest['type'] =='General'  ) { echo 'checked=checked' ;}?>/>
                                 General
                                 </label>
                                 <label class="radio">
                                 <input type="radio" name="fOrderType" id="fOrderType" value="PR"   tabindex="2"    onChange="getOrderType(this.value);ShowResultPR(this.value);" <?php if( $aEditPurchaseOrder['id_pr'] != 0 || $apurchaserequest_info['id_pr']!= 0 || $aRequest['type'] =='PR' ) { echo 'checked=checked' ;}?> />
                                Purchase Request
                                 </label>  
                               
                              </div>
							         <?php } else {?>
									 
									 <div class="control-group">
                                              <label class="control-label">PO Type:</label>
                                             <div class="controls">
                                               <span class="text"><b><?php  if($apurchaserequest_info['id_pr'] == 0) { echo 'General';
											   }
											   else { echo 'Purchase Request';}?></b></span>
                                               
                                             </div>
                                          </div>
									 <?php }?>
                           </div>                               
                                    </div>
									</div>
									<?php if(isset($aRequest['type']) || $aRequest['id'])
									{?>
									
									 <div class="row-fluid" >
									 <?php } else { ?>
									  <div class="row-fluid" style="display:none;" >
									 <?php } ?>
									 <?php if($aRequest['type'] !='General'){?>
									<div class="span12" id="purchaserequest" >
                                          <div class="control-group">
                                             <label class="control-label">Purchase Request Id</label>
                             
							   <div class="controls">
                                       <?php if( $aRequest['action']!='edit'){ ?> 
                                       <select class="span3" data-placeholder="Choose a Purchase Request Id"  tabindex="3"  name="fPurchaseRequestId" onChange="ShowResult(this.value);">
											 <?php
											  $apurchaseRequestList = $oMaster->getPurchaseRequestStatus($aRequest['action']);
											  ?>
											    <option value=""></option>
											  <?php
                                              foreach($apurchaseRequestList as $aPuchaseRequest)
											  {
			  
											 ?>
                                             
                                              <option value="<?php echo $aPuchaseRequest['id_pr']; ?>"<?php if($item_id ==$aPuchaseRequest['id_pr'] || $aEditPurchaseOrder['id_pr'] ==$aPuchaseRequest['id_pr'] ) { echo 'selected=selected' ;}?> onClick="ShowResult(this.value);"><?php echo $aPuchaseRequest['pr_no']; ?></option>
                                          
                                             <?php
											  }
											 ?>
                                          </select>
                                        
                                            
                                 <?php } else {?>  
								<span class="text"><strong><?php echo $aEditPurchaseOrder['request_no'];?></strong></span> 
								 <input type="hidden" name="fPurchaseRequestId" value="<?php echo $aEditPurchaseOrder['id_pr'];?>"/>
								 <?php } ?>    
								     </div>
                                       </div>
									   </div>
									   <?php } ?>
                                 <div class="row-fluid">
                                       
                                       <!--/span-->
                                   <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Unit</label>
                               <div class="controls">
                                       
                                       <select class="span8 chosen"   tabindex="4"  data-placeholder="Choose a Unit Id" name="fUnitId" id="fUnitId" onChange="getDivision(this.value);">
											  <option value=""></option>
											<?php
											  $aUnitList = $oAssetUnit->getAllAssetUnitInfo();
											  foreach($aUnitList as $aUnit)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aUnit['id_unit']; ?>" <?php if($apurchaserequest_info['id_unit'] == $aUnit['id_unit'] || $aEditPurchaseOrder['id_unit'] == $aUnit['id_unit']) { echo 'selected=selected' ;}?>><?php echo $aUnit['unit_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                           &nbsp;  &nbsp;
										  <span><a href="#" class="unit" title="Add New Unit"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                             </div>
                                          </div>
                                       </div>
                                       
                                         <!--/span-->
                                    </div>
                                    
                                    <div class="row-fluid">
									
									<div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Select Division</label>
                               <div class="controls" >
                                       
                                       <select class="span8 fDivisionId" data-placeholder="Choose a Division"  name="fDepartmentId" id="unitwisedivisionList"> 
											   <option value="0">Choose a Division</option>
											 <?php
											  $aDivisionList = $oMaster->getDivisionList();
											  foreach($aDivisionList as $aDivision)
											  {
											 ?>
                                             <option value="<?php echo $aDivision['id_division']; ?>" <?php if($apurchaserequest_info['id_department'] == $aDivision['id_division'] || $aEditPurchaseOrder['id_department'] == $aDivision['id_division']) { echo 'selected=selected' ;}?>><?php echo $aDivision['division_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                          &nbsp;  &nbsp;
										  <span><a href="#" class="division" title="Add New Division"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                             </div>
											  
                                          </div>
                                       </div>
									  <?php if(!empty($apurchaserequest_info['quote_approval'])){ ?>
									  <div class="control-group">
                                              <label class="control-label">Vendor Name : </label>
                                             <div class="controls">
                                               <span class="text"><b> <?php echo strtoupper($apurchaserequest_info['quote_approval']['vendor_name']); ?></b></span><input type="hidden" name="fvendorId" value="<?php echo $apurchaserequest_info['quote_approval']['id_vendor'];?>"
                                               
                                             </div>
                                          </div>
									  <?php } else { ?>
                                       <div class="span6">
                                          <div class="control-group">
                                             <label class="control-label">Select Vendor</label>
                               <div class="controls">
                                       
                                       <select class="span8" data-placeholder="Choose a Vendor" name="fvendorId" id="fVendorId">
											   <option value="0">Choose a Vendor</option>
											  <?php
                                              foreach($avendorList as $aVendor)
											  {
			  
											 ?>
                                             
                                              <option value="<?php echo $aVendor['id_vendor']; ?>" <?php if($edit_result[0]['id_vendor'] == $aVendor['id_vendor'] || $aEditPurchaseOrder['id_vendor'] == $aVendor['id_vendor'] || $apurchaserequest_info['quote_approval']['id_vendor'] ==$aVendor['id_vendor'] ) { echo 'selected=selected' ;}?>><?php echo $aVendor['vendor_name']; ?></option>
                                          
                                             <?php
											  }
											 ?>
                                          </select>
                                          &nbsp;  &nbsp;
										  <span><a href="#" class="vendor" title="Add New Vendor"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                   <?php } ?>
                                       
                                        
                                       </div>
                                
                                      
                                    <?php if(isset($_GET['id']) && $aRequest['action'] != 'edit'){?>
                                    
                                       <h3 class="form-section">Purchase Item Info</h3>
                                    <div class="row-fluid">
                                      <table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>Item Name</th>
											<th>Quantity/ UOM</th>
                                            <th>Unit Price (<?php echo Currencycode;?>)</th>
                                            <th>Total  (<?php echo Currencycode;?>)</th>
                                         	<th>Delete</th>
										</tr>
									</thead>
									<tbody>
										 <?php 
										 $i=1;
										 foreach ($aPurchasedItem['iteminfo'] as $purchaseitem){ 
										 ?>
										 
										 <?php
										if($purchaseitem['balanced_qty'] > 0 )
										{
										 ?>
										<tr class="">
                                      
                                        <td>
                                                                                
                                          <select class="m-wrap margin group1" name="fGroup1[]" id="fGroupItem1" onChange="getGroup2ItemListing(this.value,this.id);">
                                            <option value="0" selected="selected" >Choose the ItemGroup 1 </option>
											 <?php
											  $aItemGroup1List = $oMaster->getItemGroup1List();
											  foreach($aItemGroup1List as $aItemGroup1)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup1['id_itemgroup1']; ?>" <?php if($purchaseitem['id_itemgroup1'] == $aItemGroup1['id_itemgroup1']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup1['itemgroup1_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                        
                                          <select class="m-wrap group2" name="fGroup2[]" id="Group2ItemList1" onChange="getItemListing(this.value,this.id);">
                                               <option value="0" selected="selected" >Choose the ItemGroup 2 </option>
											 <?php
											  $aItemGroup2List = $oMaster->getItemGroup2List();
											  foreach($aItemGroup2List as $aItemGroup2)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup2['id_itemgroup2']; ?>" <?php if($purchaseitem['id_itemgroup2'] == $aItemGroup2['id_itemgroup2']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup2['itemgroup2_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                          
                                           <select class="m-wrap  nextRow margin items" name="fItemName[]" id="ItemList1">
                                    <option value="0" >Choose the Item</option>
											 <?php
											  $aItemList = $oMaster->getItemList();
											  foreach($aItemList as $aItem)
											  {
											 ?>
                                             <option value="<?php echo $aItem['id_item']; ?>" <?php if($purchaseitem['id_item'] == $aItem['id_item']) { echo 'selected=selected' ;}?>><?php echo $aItem['item_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                          
                                           <input type="hidden" class="items" name="fItemId[]" value="<?php echo $purchaseitem['id_po_item'];?>" />
										   <input type="hidden" class="items" name="fPRItemId[]" value="<?php echo $purchaseitem['id_pr_item'];?>" />
										   
										 
                                        </td>
                   <td><input type="text" class="m-wrap xsmall" name="fQuantity[]" value="<?php echo $purchaseitem['balanced_qty'];?>" onKeyUp="qtytotalpricecalc(this.id);  checkQty(this.id,this.value,'<?php echo $aRequest['id'];?>','<?php echo $purchaseitem['id_pr_item'];?>');"id="qty<?php echo $i;?>" style="margin-bottom: 5px;"/>
                                          <select class="small m-wrap chosen" data-placeholder="Choose a UOM" name="fUOMId[]">
                                               <option value=""></option>
											 <?php
											  $aUOMList= $oMaster->getUomList();
											  foreach($aUOMList as $aUOM)
											  {
			  
											 ?>
                                             <option value="<?php echo $aUOM['id_uom']; ?>" <?php if($purchaseitem['id_uom'] == $aUOM['id_uom']) { echo 'selected=selected' ;}?>><?php echo $aUOM['uom_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                                                             
                                         
                                       
												  <select class=" m-wrap margin" name="fManufactureId[]">
                                    <option value="0">Choose the Manufacturer</option>
											 <?php
											  $aManufacturerList = $oMaster->getManufacturerList();
											  foreach($aManufacturerList as $aManufacturer)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aManufacturer['id_manufacturer']; ?>" <?php if($edit_result['id_manufacturer'] == $aManufacturer['id_manufacturer']) { echo 'selected=selected' ;}?>><?php echo $aManufacturer['manufacturer_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
											 <input type="text" class=" m-wrap"  placeholder="Enter the Item Remarks" name="fRemark"/>
                                        
                                        
                                        </td>
                                         <td>
										 							 
										 <input type="text" name="fUnitPrice[]" class="price" id="unitprice<?php echo $i;?>" onKeyUp="unitcalc(this.id);" value="<?php $aPriceList = $oMaster->getPRNegoUnitPrice($purchaseitem['id_pr_item'],$apurchaserequest_info['quote_approval']['id_quote'],$apurchaserequest_info['quote_approval']['id_pr']); echo $aPriceList['negotiated_unit_cost'];
										 
										 ?>"/>
                                         <br>  <br>
                                         <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" placeholder="Required Date" size="10" type="text" name="fRequireDate[]" style="width:100px;"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
                                         
                                         </td>
                                          <td><span id="unittotals<?php echo $i;?>" style="float:right;font-weight:bold;"></span><input type="hidden" name="fUnitTotal[]" class="price"  value="0"  id="unittotal<?php echo $i;?>"/></td>
										
                                           
																				
											<td><a class="delete"  href="javascript:;" onclick=purchasedelete(<?php echo  $purchaseitem['id_pr_item']; ?>)>Delete</a>	<input type="hidden" name="fPurchaseRequestId" value="<?php echo  $purchaseitem['id_pr']; ?>"/></td>
										</tr>
										  <?php 
										  }
										  $i++;} ?>
									</tbody>
                         
                                    <tr>
                                    <td colspan="2">
                                   
                                    </td>
                                     <td style="text-align:right;"> Total (<?php echo Currencycode;?>) : </td>
                                    <td><span id="nettotals1" style="float:right;font-weight:bold;"></span><input type="hidden" class="price" name="fTotal" id="nettotal1"/></td>
                                    <td>&nbsp;</td>
                                    </tr>
                                  
								</table>
                                       </div>
                                        <div class="row-fluid"> 
                                      <table id="purchaseItems" name="purchaseItems" class="table table-striped table-bordered table-hover">
								<tr>
											<th>SNO</th>
                                            <th>Tax</th>
                                            <th>Add (+) / Less (-) </th>
                                            <th>Total </th>
                                         	<th>Action</th>
								</tr>
                                <?php 
								$i = 1;
								foreach ($aPurchasedItem[0]['po_tax'] as $atax){ ?>
								<tr>
                                <td></td>
									<td><select class="span12 " data-placeholder="Choose a Tax"  name="fTaxId[]" id="tax<?php echo $i;?>" value="0" onChange="javascript:taxcalc(this.id);">
											 <option value="0/+/0">Choose the Tax</option>
											 <?php
											  $aTaxList = $oMaster->getTaxFormList();
											  foreach($aTaxList as $aTax)
											  {
											 ?>
                                             <option value="<?php echo $aTax['tax_percentage']; ?>/<?php echo $aTax['addless'];?>/<?php echo $aTax['id_taxform']; ?>" <?php if($apurchaserequest_info['tax_percentage'] == $aTax['tax_percentage'] || $atax['id_taxform'] == $aTax['id_taxform']) { echo 'selected=selected' ;}?>><?php echo $aTax['taxform_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select></td>
									
                                    <td style="text-align:right;"><span id="addlesss<?php echo $i;?>"></span><input type="hidden" class="price xsmall" name="fAddLess[]" id="addless<?php echo $i;?>"/></td> <td><input type="text" class="price" name="fTaxTotal[]" id="taxprice<?php echo $i;?>" value="0"/>
                                
                                    </td>
                                    
									<td>
                                    
                                    <input type="button" name="addRow[]" class="add" value='+'> &nbsp; <input type="button" name="addRow[]" class="removeRow" value='-' id="remove1" onClick="recalc();"></td>
									
								</tr>
                                <?php $i++;} ?>
                                 <tr>
                                  <?php 
								 $i =1;
								if(empty($aPurchasedItem[0]['po_tax']))
								{
								
								 ?>
								 <tr>
                                <td></td>
									<td><select class="span12 " data-placeholder="Choose a Tax"  name="fTaxId[]" id="tax<?php echo $i;?>" value="0" onChange="javascript:taxcalc(this.id);">
											 <option value="0/+/0">Choose the Tax</option>
											 <?php
											  $aTaxList = $oMaster->getTaxFormList();
											  foreach($aTaxList as $aTax)
											  {
											 ?>
                                             <option value="<?php echo $aTax['tax_percentage']; ?>/<?php echo $aTax['addless'];?>/<?php echo $aTax['id_taxform']; ?>" <?php if($apurchaserequest_info['tax_percentage'] == $aTax['tax_percentage'] || $atax['id_taxform'] == $aTax['id_taxform']) { echo 'selected=selected' ;}?>><?php echo $aTax['taxform_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select></td>
									
                                    <td style="text-align:right;"><span id="addlesss<?php echo $i;?>"></span><input type="hidden" class="price xsmall" name="fAddLess[]" id="addless<?php echo $i;?>"/></td> <td><input type="text" class="price" name="fTaxTotal[]" id="taxprice<?php echo $i;?>" value="0"/>
                                
                                    </td>
                                    
									<td>
                                    
                                    <input type="button" name="addRow[]" class="add" value='+'> &nbsp; <input type="button" name="addRow[]" class="removeRow" value='-' id="remove1" onClick="recalc();"></td>
									
								</tr>
								<?php } ?>
                                     <td style="text-align:right;" colspan="3">Grant Total : </td>
                                    <td><input type="text" class="price" name="fGrantTotal" id="granttotal"/></td>
                                    <td>&nbsp;</td>
                                    </tr>
                                   
                                
                                    <tr>
                                  
                                     <td style="text-align:right;" colspan="3">Round Off : </td>
                                    <td><input type="text" class="price" name="fRoundOff" id="roundoff"/></td>
                                    <td>&nbsp;</td>
                                    </tr>
                                   
                                 
                                    <tr>
                                  
                                     <td style="text-align:right;" colspan="3">NET AMOUNT (<?php echo Currencycode;?>) : </td>
                                    <td><input type="text" class="price" name="fNetTotal" id="nettotal"/>
                                    
                                    <input type="button" class="m-btn btn-warning" name="recal"  value ="Recalculate" onClick="javascript:recalc();"/>
                                    
                                    </td>
                                     <td></td>
                                    </tr>
                                    
							</table> 
                                  </div>
                          
                           <?php }
						     else if(isset($_GET['id']) && $aRequest['action'] == 'edit'){?>
						                                    
                                       <h3 class="form-section">Purchase Item Info</h3>
                                    <div class="row-fluid">
                                      <table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>Item Name</th>
											<th>Quantity/ UOM</th>
                                            <th>Unit Price (<?php echo Currencycode;?>)</th>
                                            <th>Total  (<?php echo Currencycode;?>)</th>
                                         	<th>Delete</th>
										</tr>
									</thead>
									<tbody>
										 <?php 
										 $i=1;
										 foreach ($aPurchasedItem  as $purchaseitem){ 
										 ?>
										 
										 <?php
										if($purchaseitem['balanced_qty'] > 0 )
										{
										 ?>
										<tr class="">
                                      
                                        <td>
                                                                                
                                          <select class="m-wrap margin group1" name="fGroup1[]" id="fGroupItem1" onChange="getGroup2ItemListing(this.value,this.id);">
                                            <option value="0" selected="selected" >Choose the ItemGroup 1 </option>
											 <?php
											  $aItemGroup1List = $oMaster->getItemGroup1List();
											  foreach($aItemGroup1List as $aItemGroup1)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup1['id_itemgroup1']; ?>" <?php if($purchaseitem['id_itemgroup1'] == $aItemGroup1['id_itemgroup1']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup1['itemgroup1_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                        
                                          <select class="m-wrap group2" name="fGroup2[]" id="Group2ItemList1" onChange="getItemListing(this.value,this.id);">
                                               <option value="0" selected="selected" >Choose the ItemGroup 2 </option>
											 <?php
											  $aItemGroup2List = $oMaster->getItemGroup2List();
											  foreach($aItemGroup2List as $aItemGroup2)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup2['id_itemgroup2']; ?>" <?php if($purchaseitem['id_itemgroup2'] == $aItemGroup2['id_itemgroup2']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup2['itemgroup2_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                          
                                           <select class="m-wrap  nextRow margin items" name="fItemName[]" id="ItemList1">
                                    <option value="0" >Choose the Item</option>
											 <?php
											  $aItemList = $oMaster->getItemList();
											  foreach($aItemList as $aItem)
											  {
											 ?>
                                             <option value="<?php echo $aItem['id_item']; ?>" <?php if($purchaseitem['id_item'] == $aItem['id_item']) { echo 'selected=selected' ;}?>><?php echo $aItem['item_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                          
                                           <input type="hidden" class="items" name="fItemId[]" value="<?php echo $purchaseitem['id_po_item'];?>" />
										   <input type="hidden" class="items" name="fPRItemId[]" value="<?php echo $purchaseitem['id_pr_item'];?>" />
                                        </td>
                   <td><input type="text" class="m-wrap xsmall" name="fQuantity[]" value="<?php echo $purchaseitem['balanced_qty'];?>" onKeyUp="qtytotalpricecalc(this.id);  checkQty(this.id,this.value,'<?php echo $aRequest['id'];?>','<?php echo $purchaseitem['id_pr_item'];?>');"id="qty<?php echo $i;?>" style="margin-bottom: 5px;"/>
                                          <select class="small m-wrap chosen" data-placeholder="Choose a UOM" name="fUOMId[]">
                                               <option value=""></option>
											 <?php
											  $aUOMList= $oMaster->getUomList();
											  foreach($aUOMList as $aUOM)
											  {
			  
											 ?>
                                             <option value="<?php echo $aUOM['id_uom']; ?>" <?php if($purchaseitem['id_uom'] == $aUOM['id_uom']) { echo 'selected=selected' ;}?>><?php echo $aUOM['uom_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                                                             
                                         
                                       
												  <select class=" m-wrap margin" name="fManufactureId[]">
                                    <option value="0">Choose the Manufacturer</option>
											 <?php
											  $aManufacturerList = $oMaster->getManufacturerList();
											  foreach($aManufacturerList as $aManufacturer)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aManufacturer['id_manufacturer']; ?>" <?php if($edit_result['id_manufacturer'] == $aManufacturer['id_manufacturer']) { echo 'selected=selected' ;}?>><?php echo $aManufacturer['manufacturer_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
											 <input type="text" class=" m-wrap"  placeholder="Enter the Item Remarks" name="fRemark"/>
                                        
                                        
                                        </td>
                                         <td>
										 							 
										 <input type="text" name="fUnitPrice[]"  class="price" id="unitprice<?php echo $i;?>" onKeyUp="unitcalc(this.id);" value="<?php echo $purchaseitem['unit_cost'];?>"/>
                                         <br>  <br>
                                         <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" placeholder="Required Date" size="10" type="text" name="fRequireDate[]" style="width:100px;"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
                                         
                                         </td>
                                          <td><span id="unittotals<?php echo $i;?>" style="float:right;font-weight:bold;"></span><input type="hidden" name="fUnitTotal[]" class="price"  value="0"  id="unittotal<?php echo $i;?>"/></td>
										
                                           
																				
											<td><a class="delete"  href="javascript:;" onclick=purchaseOrderItemdelete(<?php echo  $purchaseitem['id_po_item']; ?>)>Delete</a>	<input type="hidden" name="fPurchaseOrderItemId" value="<?php echo  $purchaseitem['id_po_item']; ?>"/></td>
										</tr>
										  <?php 
										  }
										  $i++;} ?>
									</tbody>
                         
                                    <tr>
                                    <td colspan="2">
                                   
                                    </td>
                                     <td style="text-align:right;"> Total (<?php echo Currencycode;?>) : </td>
                                    <td><span id="nettotals1" style="float:right;font-weight:bold;"></span><input type="hidden" class="price" name="fTotal" id="nettotal1"/></td>
                                    <td>&nbsp;</td>
                                    </tr>
                                  
								</table>
                                       </div>
                                        <div class="row-fluid"> 
                                      <table id="purchaseItems" name="purchaseItems" class="table table-striped table-bordered table-hover">
								<tr>
											<th>SNO</th>
                                            <th>Tax</th>
                                            <th>Add (+) / Less (-) </th>
                                            <th>Total </th>
                                         	<th>Action</th>
								</tr>
                                <?php 
								$i = 1;
								foreach ($aPurchasedItem[0]['po_tax'] as $atax){ ?>
								<tr>
                                <td></td>
									<td><select class="span12 " data-placeholder="Choose a Tax"  name="fTaxId[]" id="tax<?php echo $i;?>" value="0" onChange="javascript:taxcalc(this.id);">
											 <option value="0/+/0">Choose the Tax</option>
											 <?php
											  $aTaxList = $oMaster->getTaxFormList();
											  foreach($aTaxList as $aTax)
											  {
											 ?>
                                             <option value="<?php echo $aTax['tax_percentage']; ?>/<?php echo $aTax['addless'];?>/<?php echo $aTax['id_taxform']; ?>" <?php if($apurchaserequest_info['tax_percentage'] == $aTax['tax_percentage'] || $atax['id_taxform'] == $aTax['id_taxform']) { echo 'selected=selected' ;}?>><?php echo $aTax['taxform_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select></td>
									
                                    <td style="text-align:right;"><span id="addlesss<?php echo $i;?>"></span><input type="hidden" class="price xsmall" name="fAddLess[]" id="addless<?php echo $i;?>"/></td> <td><input type="text" class="price" name="fTaxTotal[]" id="taxprice<?php echo $i;?>" value="0"/>
                                
                                    </td>
                                    
									<td>
                                    
                                    <input type="button" name="addRow[]" class="add" value='+'> &nbsp; <input type="button" name="addRow[]" class="removeRow" value='-' id="remove1" onClick="recalc();"></td>
									
								</tr>
                                <?php $i++;} ?>
                                 <tr>
                                  <?php 
								 $i =1;
								if(empty($aPurchasedItem[0]['po_tax']))
								{
								
								 ?>
								 <tr>
                                <td></td>
									<td><select class="span12 " data-placeholder="Choose a Tax"  name="fTaxId[]" id="tax<?php echo $i;?>" value="0" onChange="javascript:taxcalc(this.id);">
											 <option value="0/+/0">Choose the Tax</option>
											 <?php
											  $aTaxList = $oMaster->getTaxFormList();
											  foreach($aTaxList as $aTax)
											  {
											 ?>
                                             <option value="<?php echo $aTax['tax_percentage']; ?>/<?php echo $aTax['addless'];?>/<?php echo $aTax['id_taxform']; ?>" <?php if($apurchaserequest_info['tax_percentage'] == $aTax['tax_percentage'] || $atax['id_taxform'] == $aTax['id_taxform']) { echo 'selected=selected' ;}?>><?php echo $aTax['taxform_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select></td>
									
                                    <td style="text-align:right;"><span id="addlesss<?php echo $i;?>"></span><input type="hidden" class="price xsmall" name="fAddLess[]" id="addless<?php echo $i;?>"/></td> <td><input type="text" class="price" name="fTaxTotal[]" id="taxprice<?php echo $i;?>" value="0"/>
                                
                                    </td>
                                    
									<td>
                                    
                                    <input type="button" name="addRow[]" class="add" value='+'> &nbsp; <input type="button" name="addRow[]" class="removeRow" value='-' id="remove1" onClick="recalc();"></td>
									
								</tr>
								<?php } ?>
                                     <td style="text-align:right;" colspan="3">Grant Total : </td>
                                    <td><input type="text" class="price" name="fGrantTotal" id="granttotal"/></td>
                                    <td>&nbsp;</td>
                                    </tr>
                                   
                                
                                    <tr>
                                  
                                     <td style="text-align:right;" colspan="3">Round Off : </td>
                                    <td><input type="text" class="price" name="fRoundOff" id="roundoff"/></td>
                                    <td>&nbsp;</td>
                                    </tr>
                                   
                                 
                                    <tr>
                                  
                                     <td style="text-align:right;" colspan="3">NET AMOUNT (<?php echo Currencycode;?>) : </td>
                                    <td><input type="text" class="price" name="fNetTotal" id="nettotal"/>
                                    
                                    <input type="button" class="m-btn btn-warning" name="recal"  value ="Recalculate" onClick="javascript:recalc();"/>
                                    
                                    </td>
                                     <td></td>
                                    </tr>
                                    
							</table> 
                                  </div>
                          
                           <?php 
						   
						   } 
						    else { ?>
                                         <h3 class="form-section">Purchase Item Info</h3>
                                    <div class="row-fluid">
                                        <?php $j=1;  ?>                          
								<table id="purchaseItems" name="purchaseItems" class="table table-striped table-bordered table-hover">
                              
								<tr>
											 <th>Item Name</th>
											<th>Quantity/ UOM</th>
                                            <th>Unit Price (<?php echo Currencycode;?>)</th>
                                            <th>Total (<?php echo Currencycode;?>)</th>
                                         	<th>Action</th>
								</tr>
                                
								<tr>
                                  <td>
                                        
                                          
                                          <select class="m-wrap margin group1" name="fGroup1[]" id="fGroupItem1" onChange="getGroup2ItemListing(this.value,this.id);">
                                            <option value="0" selected="selected" >Choose the ItemGroup 1 </option>
											 <?php
											  $aItemGroup1List = $oMaster->getItemGroup1List();
											  foreach($aItemGroup1List as $aItemGroup1)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup1['id_itemgroup1']; ?>" <?php if($purchaseitem['id_itemgroup1'] == $aItemGroup1['id_itemgroup1']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup1['itemgroup1_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                        
                                          <select class="m-wrap group2" name="fGroup2[]" id="Group2ItemList1" onChange="getItemListing(this.value,this.id);">
                                               <option value="0" selected="selected" >Choose the ItemGroup 2 </option>
											 <?php
											  $aItemGroup2List = $oMaster->getItemGroup2List();
											  foreach($aItemGroup2List as $aItemGroup2)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup2['id_itemgroup2']; ?>" <?php if($purchaseitem['id_itemgroup2'] == $aItemGroup2['id_itemgroup2']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup2['itemgroup2_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                          <select class="m-wrap  nextRow margin items" name="fItemName[]" id="ItemList1">
                                    <option value="0" >Choose the Item</option>
											 <?php
											  $aItemList = $oMaster->getItemList();
											  foreach($aItemList as $aItem)
											  {
											 ?>
                                             <option value="<?php echo $aItem['id_item']; ?>" <?php if($purchaseitem['id_item'] == $aItem['id_item']) { echo 'selected=selected' ;}?>><?php echo $aItem['item_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                        </td>
                   <td><input type="text" class="m-wrap xsmall" name="fQuantity[]" value="<?php echo $purchaseitem['qty'];?>" onKeyUp="qtytotalpricecalc(this.id);"id="qty<?php echo $j;?>" style="margin-bottom: 5px;"/>
                                          <select class="small m-wrap " data-placeholder="Choose a UOM" name="fUOMId[]">
                                               <option value="">Choose a UOM</option>
											 <?php
											  $aUOMList= $oMaster->getUomList();
											  foreach($aUOMList as $aUOM)
											  {
			  
											 ?>
                                             <option value="<?php echo $aUOM['id_uom']; ?>" <?php if($purchaseitem['id_uom'] == $aUOM['id_uom']) { echo 'selected=selected' ;}?>><?php echo $aUOM['uom_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                                                             
                                         
                                       
									 <select class=" m-wrap margin"  name="fManufactureId[]">
                                    <option value="0">Choose the Manufacturer</option>
											 <?php
											  $aManufacturerList = $oMaster->getManufacturerList();
											  foreach($aManufacturerList as $aManufacturer)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aManufacturer['id_manufacturer']; ?>" <?php if($edit_result['id_manufacturer'] == $aManufacturer['id_manufacturer']) { echo 'selected=selected' ;}?>><?php echo $aManufacturer['manufacturer_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
											  <input type="text" class=" m-wrap" placeholder="Enter the Item Remarks" name="fRemark"/>
                                        
                                        
                                        </td>
                                         <td><input type="text" name="fUnitPrice[]" class="price"  value="0" id="unitprice<?php echo $j;?>" onKeyUp="unitcalc(this.id);"/>
                                         <br>  <br>
                                         <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" placeholder="Required Date" size="10" type="text" name="fRequireDate[]" style="width:100px;"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
                                         </td>
                                          <td><input type="hidden" name="fUnitTotal[]" class="price"  value="0"  id="unittotal<?php echo $j;?>"/><span class="SpanPrice" id="unittotals<?php echo $j;?>" style="float:right;font-weight:bold;"></span></td>
										
                                           
																				
											<td><input type="button" name="addRow[]" class="add" value='+'> <br>  <br>  <input type="button" name="addRow[]" class="removeRow" value='-' id="remove1" onClick="javascript:recalcs(this.id);"></td>
										</tr>
										 
									</tbody>
                           
                                   
                                    <tr>
                                    <td colspan="2">
                                   
                                    </td>
                                     <td style="text-align:right;"> Total (<?php echo Currencycode;?>) : </td>
                                    <td><span id="nettotals1" style="float:right;font-weight:bold;"></span><input type="hidden" class="price" name="fTotal" id="nettotal1"/></td>
                                    <td>&nbsp;</td>
                                    </tr>
							</table>
						
						 
                          </div>
                          
                          <div class="row-fluid"> 
                                      <table id="purchaseItems" name="purchaseItems" class="table table-striped table-bordered table-hover">
								<tr>
											<th>SNO</th>
                                            <th>Tax</th>
                                            <th>Add (+) / Less (-) </th>
                                            <th>Total </th>
                                         	<th>Action</th>
								</tr>
                                
								<tr>
                                <td></td>
									<td><select class="span12 " data-placeholder="Choose a Tax"  name="fTaxId[]" id="tax1" value="0" onChange="javascript:taxcalc(this.id);">
											 <option value="0/+/0">Choose the Tax</option>
											 <?php
											  $aTaxList = $oMaster->getTaxFormList();
											  foreach($aTaxList as $aTax)
											  {
											 ?>
                                             <option value="<?php echo $aTax['tax_percentage']; ?>/<?php echo $aTax['addless'];?>/<?php echo $aTax['id_taxform']; ?>" <?php if($apurchaserequest_info['tax_percentage'] == $aTax['tax_percentage']) { echo 'selected=selected' ;}?>><?php echo $aTax['taxform_name']; ?>&nbsp;-- <?php echo $aTax['tax_percentage'];?></option>
                                             <?php
											  }
											 ?>
                                          </select></td>
									
                                    <td style="text-align:right;"><span id="addlesss1"></span><input type="hidden" class="price xsmall" name="fAddLess[]" id="addless1"/></td> <td><input type="text" class="price" name="fTaxTotal[]" id="taxprice1" value="0"/>
                                
                                    </td>
                                    
									<td>
                                    
                                    <input type="button" name="addRow[]" class="add" value='+'> &nbsp; <input type="button" name="addRow[]" class="removeRow" value='-' id="remove1" onClick="recalc();"></td>
									
								</tr>
                                 <tr>
                                  
                                     <td style="text-align:right;" colspan="3">Grant Total : </td>
                                    <td><input type="text" class="price" name="fGrantTotal" id="granttotal"/></td>
                                    <td>&nbsp;</td>
                                    </tr>
                                   
                                
                                    <tr>
                                  
                                     <td style="text-align:right;" colspan="3">Round Off : </td>
                                    <td><input type="text" class="price" name="fRoundOff" id="roundoff"/></td>
                                    <td>&nbsp;</td>
                                    </tr>
                                   
                                 
                                    <tr>
                                  
                                     <td style="text-align:right;" colspan="3">NET AMOUNT (<?php echo Currencycode;?>) : </td>
                                    <td><input type="text" class="price" name="fNetTotal" id="nettotal"/>
                                    
                                    <input type="button" class="m-btn btn-warning" name="recal"  value ="Recalculate" onClick="javascript:recalc();"/>
                                    
                                    </td>
                                     <td></td>
                                    </tr>
							</table> 
                                  </div>
                          
                          <?php } ?>
                                     <h3 class="form-section">Despatch Information </h3>
                                     
                                     <div class="row-fluid">
                                       <div class="span6 ">
                                       
                                       <div class="control-group">
                                             <label class="control-label">Self/Unit</label>
                               <div class="controls">
                                       
                                       <select class="span12 chosen" data-placeholder="Choose a Unit Id"  name="fShippingId" id="fShippingId">
											    <option value=""></option>
                                              <option value="Self">Self</option>
											<?php
											  $aUnitList = $oAssetUnit->getAllAssetUnitInfo();
											  foreach($aUnitList as $aUnit)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aUnit['id_unit']; ?>" <?php if($aEditPurchaseOrder['id_shipping_addr'] == $aUnit['id_unit']) { echo 'selected=selected' ;}?>
                                             
                                             ><?php echo $aUnit['unit_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                         
                                             </div>
                                          </div>
                                          
                                       </div>
                                       <!--/span-->
                                    
										<div class="span6">
										
											<div class="well" id="address">
											<?php echo  $aEditPurchaseOrder['shipping_addr'];?>
												
										
										</div>
                                       <!--/span-->
                                  </div>
                                    </div>
                                   
                                    
                                    <!--/row-->
                                     <h3 class="form-section">Notes </h3> 
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                       <div class="control-group">
                              <label class="control-label">Require Date<span class="required">*</span></label>
                              <div class="controls">
                              
                                 <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text" name="fDuedate" data-required="1" value="<?php
								 if($edit_result['due_date']=="")
								 {
									 echo date('d-m-Y');
								 }
								 else
								 {
									 echo date('d-m-Y',strtotime($edit_result['due_date']));
								 }?>" />
                              </div>
                             
                           </div>
                                         <!--/span-->
                                    </div>
                                      </div>
                                 
                                     
                                   <div class="row-fluid">
                                       <div class="span6 ">
                                       <div class="control-group">
                                       <label class="control-label">Remarks</label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fRemarks"><?php echo $aEditPurchaseOrder['remarks'];?></textarea>
                                       </div>
                                    </div>
                                         <!--/span-->
                                    </div>
                                      </div>
									  
									   <div class="row-fluid">
									    <div class="span6 ">
                                       
                                       <div class="control-group">
                                             <label class="control-label">Terms and conditions </label>
                               <div class="controls">
                                       
                                       <select class="span12 chosen" data-placeholder="Choose a terms "  name="fTermsId" id="fTermsId" onChange="getTerms(this.id);">
											    <option value="">Choose a Terms and conditions </option>
                                             
											<?php
											  $aTerms = $oMaster->getTermsConditions();
											  foreach($aTerms as $Terms)
											  {
											 ?>
                                                
                                             <option value="<?php echo $Terms['id_terms_conditions']; ?>"><?php echo $Terms['name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                         
                                             </div>
                                          </div>
                                          
                                       </div>
                                     
                                      </div>
                                       <div class="row-fluid">                     
                                   
                                       <div class="control-group">
                                        <div class="controls" >
                                        <textarea class="span12 ckeditor m-wrap" rows="6" name="fTerms" id="Terms"><?php echo $aEditPurchaseOrder['terms_and_conditions'];?></textarea>
                                      
                                    </div>
                                         <!--/span-->
                                    </div>
									</div>
                                    
                                    <?php
if($aRequest['action'] == 'edit' && $aRequest['submits']=='approval') {
	
	?>
    
    <div class="control-group">
                                       <label class="control-label">Select Approval By</label>
                                       <div class="controls">
                                        <select class="large m-wrap"  name="fApprovalEmployeeId">
											<option value="0">Choose the Approval By</option>
											<?php
											  $aEmployeeList = $oMaster->getEmployeeList();
											  foreach($aEmployeeList as $aEmployee)
											  {
			  
											 ?>
                                             <option value="<?php echo $aEmployee['id_employee']; ?>" <?php if($aEditPurchaseOrder['approved_by'] == $aEmployee['id_employee']) { echo 'selected=selected' ;}?>><?php echo $aEmployee['employee_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                       </div>
                                    </div>
    
    <div class="control-group">
                                       <label class="control-label">Status</label>
                                       <div class="controls">
                                       <label class="radio line">
                                          <input type="radio" name="fStatus" value="1" <?php if($aEditPurchaseOrder['status'] == '1') { echo 'checked=checked' ;}?> />
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="0" <?php if($aEditPurchaseOrder['status'] == '0') { echo 'checked=checked' ;}?> />
                                          In-Active
                                          </label>  
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="3" <?php if($aEditPurchaseOrder['status'] == '3') { echo 'checked=checked' ;}?> />
                                          Approved
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="4" <?php if($aEditPurchaseOrder['status'] == '4') { echo 'checked=checked' ;}?> />
                                         UnApproved
                                          </label>  
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="17" <?php if($aEditPurchaseOrder['status'] == '17') { echo 'checked=checked' ;}?> />
                                         Cancel
                                          </label>  
                                       </div>
                                    </div>
						<?php } 
						?>
                        
                                        <div class="form-actions">
                        <?php if($aRequest['action'] == 'edit')
						{
						?>
							<input type="hidden" name="fPurchaseOrderId" value="<?php echo $aRequest['id'];?>"/>
                            <input type="hidden" name="fApproval" value="<?php echo $aRequest['submits'];?>"/>
							<button type="submit" class="btn blue" id="sends" name="Update"><i class="icon-ok"></i>Update</button>                   
						<?php
						} else {
						?>
                        <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Save</button>        
                                       <button type="button" class="btn">Cancel</button>
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
       </div>
      
      <!-- END PAGE -->  
   </div></div>
   <!-- END CONTAINER -->
	<!-- END FOOTER -->
    <?php include_once 'Footer1.php'; ?>
   <!-- BEGIN JAVASCRIPTS -->    
   <!-- Load javascripts at bottom, this will reduce page load time -->
   
    <script type="text/javascript">
		
			function addParam(url, param, value) 
			{
				var a = document.createElement('a');
				a.href = url;
				a.search += a.search.substring(0,1) == "?" ? "&" : "?";
				a.search += encodeURIComponent(param);
				if (value)
				a.search += "=" + encodeURIComponent(value);
				return a.href;
			}
			
			
			function purchasedelete(id)
				{
					if (confirm("Are you sure you want to delete this record?"))
					{
							var dataString = 'data=purchaserequestdelete&pid='+ id;
							$.ajax({
							type: 'POST',
							url: 'ajax/ajax.php',
							data: dataString,
							cache: false,
							success: function(result){
							window.location.href = document.URL;
										}
										});
					}
				}
			
				function unitcalc(id)
				{
					
					var ids= id.split("unitprice");
					var unitprice = $("#"+id).val();
					var qty = $("#qty"+ids[1]).val();
					if(parseInt(qty)>=0 && parseInt(unitprice)>=0 || qty =='' || unitprice == '')
					{
					var unittotal = parseFloat(unitprice) * parseFloat(qty);
					if(unitprice!='' && qty!='')
					{
					var unittotal = parseFloat(unitprice) * parseFloat(qty);
					}
					else
					{
						var unittotal = 0;
					}
					if(unittotal =='NaN')
					{
						$("#unittotal"+ids[1]).val(0);
						$("#unittotals"+ids[1]).html(0);
					}
					else
					{
						$("#unittotal"+ids[1]).val(unittotal.toFixed(2));
						$("#unittotals"+ids[1]).html(unittotal.toFixed(2));
					}
					}
					else
					{
						alert("Please Enter Correct Value");
						return false;
					}
					
					$("input[name='fTaxTotal[]']").each(function(){
					var taxprice = $(this).attr('id').split("taxprice");
					var taxid = "tax"+taxprice[1];
					taxcalc(taxid);
					}); 
					recalc();
					
					
					
				}
			
				function taxcalc(id)
				{ 
					var unitprice=0;
					$("input[name='fUnitTotal[]']").each(function(){
					unitprice+=parseFloat($(this).val());
					}); 
					var tax = $('#'+id).val();
					var tax_spilt = id.split("tax");
					var taxvalues = tax.split("/");
					var taxvalue = taxvalues[0];
					var addless = taxvalues[1];
					var taxtotal = parseFloat(unitprice)*parseFloat(tax);
					var taxtotals = parseFloat(taxtotal)/100;
				
					var TAXtotal=0;
					$("input[name='fTaxTotal[]']").each(function(){
					TAXtotal+= parseFloat($(this).val());
					});
					var netamount = parseFloat(unitprice);
					if(parseFloat(TAXtotal)==0)
					{
						
					if(addless == '+')
					{
				    var netamount = parseFloat(netamount) +  parseFloat(taxtotals);
					
					}
					else
					{
				     var netamount = parseFloat(netamount) -  parseFloat(taxtotals);
					}
					}
								
					else
					{
						var netamount = parseFloat(TAXtotal) + parseFloat(unitprice);
						
						if(addless == '+')
						{
						var netamount = parseFloat(netamount) +  parseFloat(taxtotals);
						
						}
						else
						{
						 var netamount = parseFloat(netamount) -  parseFloat(taxtotals);
						}
					}
					
					$('#taxprice'+tax_spilt[1]).val(addless+taxtotals.toFixed(2));
					$('#addless'+tax_spilt[1]).val(addless);
					$('#addlesss'+tax_spilt[1]).html(addless);
					var netamount= netamount.toFixed(2);
			
					recalc();
				}
			
			function qtytotalpricecalc(id)
			{
				var ids= id.split("qty");
				var unitprice = $("#"+id).val();
				var qty = $("#unitprice"+ids[1]).val();
					if(parseInt(qty)>=0 && parseInt(unitprice)>=0 || qty =='' || unitprice == '')
				{
				var unittotal = parseFloat(unitprice) * parseFloat(qty);
				var  unittotal= unittotal.toFixed(2);
				if(unitprice!='' && qty!='')
				{
				var unittotal = parseFloat(unitprice) * parseFloat(qty);
				var  unittotal= unittotal.toFixed(2);
				}
				else
				{
					var unittotal = 0;
				}
				if(unittotal =='NaN')
				{
					$("#unittotal"+ids[1]).val(0);
					$("#unittotals"+ids[1]).html(0);
				}
				else
				{
					$("#unittotal"+ids[1]).val(unittotal);
					$("#unittotals"+ids[1]).html(unittotal);
				}
				}
				else
				{
					alert("Please Enter Correct Value");
					return false;
				}
				
				$("input[name='fTaxTotal[]']").each(function(){
					var taxprice = $(this).attr('id').split("taxprice");
					var taxid = "tax"+taxprice[1];
					taxcalc(taxid);
					}); 
					recalc();	
				
				
			}
			
			function recalc()
			{
				var grantunitprice=0;
				$("input[name='fUnitTotal[]']").each(function(){
					grantunitprice+=parseFloat($(this).val());
				}); 
				$('#nettotal1').val(grantunitprice.toFixed(2));
				$('#nettotals1').html(grantunitprice.toFixed(2));
												
					var TAXtotal=0;
					$("input[name='fTaxTotal[]']").each(function(){
					TAXtotal+= parseFloat($(this).val());
					});
					
					var netamount = parseFloat(TAXtotal) +parseFloat(grantunitprice);
				$('#nettotal').val(netamount.toFixed(2));
				
				if(parseFloat(TAXtotal) == 0)
				{
					var netamounts = grantunitprice.toString();
				   var roundoff = netamounts.split(".");
				   var decimal = roundoff[1];
				   var numbers = roundoff[0];
				   
				   
				   var netamounts = grantunitprice.toString();
				   var roundoff = netamounts.split(".");
				   var decimal = roundoff[1];
				   var numbers = roundoff[0];
				  var RoundingVals = grantunitprice %10;
				   var RoundingVals1 = RoundingVals.toFixed(2);
				   	var RoundingVal = RoundingVals1.toString();
				var RoundingVal1 = RoundingVal.split(".");
				if(parseFloat(RoundingVal1[1])>49)
				{
					var string1 = 100 - parseInt(RoundingVal1[1]);
					var Result1 = parseFloat(grantunitprice)+parseFloat(string1/100);
						$('#nettotal').val(Result1.toFixed(2));
						$('#roundoff').val("+"+ parseFloat(string1/100));
				}
				else
				{
					var string2 = 100 - parseInt(RoundingVal1[1]);
					var Result2 = parseInt(grantunitprice);
								
					$('#nettotal').val(Result2.toFixed(2));
						$('#roundoff').val("-"+ parseFloat((RoundingVal1[1])/100));
				}
					
						$('#granttotal').val(grantunitprice.toFixed(2));
								  
								
				
				}
									
				
				  var netamounts = netamount.toString();
				   var roundoff = netamounts.split(".");
				   var decimal = roundoff[1];
				   var numbers = roundoff[0];
				  var RoundingVals = netamount %10;
				   var RoundingVals1 = RoundingVals.toFixed(2);
				   	var RoundingVal = RoundingVals1.toString();
				var RoundingVal1 = RoundingVal.split(".");
				if(parseFloat(RoundingVal1[1])>49)
				{
					var string1 = 100 - parseInt(RoundingVal1[1]);
					var Result1 = parseFloat(netamount)+parseFloat(string1/100);
						$('#nettotal').val(Result1.toFixed(2));
						$('#roundoff').val("+"+ parseFloat(string1/100) );
				}
				else
				{
					var string2 = 100 - parseInt(RoundingVal1[1]);
					var Result2 = parseInt(netamount);
								
					$('#nettotal').val(Result2.toFixed(2));
						$('#roundoff').val("-"+parseFloat((RoundingVal1[1]/ 100 )));
				}
					
						$('#granttotal').val(netamount.toFixed(2));
							  
								
					
				
				}
			function Caluclation()
				{
					var Qty=0;
				$("input[name='fQuantity[]']").each(function(){
					Qty=$(this).attr('id');
					qtytotalpricecalc(Qty);
					
				});
				}
			function refreshs()
			{
				var grantunitprice=0;
				$("input[name='fUnitTotal[]']").each(function(){
					grantunitprice+=parseFloat($(this).val());
				}); 
				$('#nettotal1').val(grantunitprice.toFixed(2));
				$('#nettotals1').html(grantunitprice.toFixed(2));
												
					var TAXtotal=0;
					$("input[name='fTaxTotal[]']").each(function(){
					TAXtotal+= parseFloat($(this).val());
					});
					
					var netamount = parseFloat(TAXtotal) +parseFloat(grantunitprice);
				
			}
			function ShowResult(id)
			{
			url = document.URL.split("?")[0];
			var dropresult = addParam(url, "id",id);	
			window.location.href = dropresult;
			}
			function ShowResultURL()
			{
			url = document.URL.split("?")[0];
			var dropresult = addParam(url, "type",'General');	
			window.location.href = dropresult;
			}
			function ShowResultPR(id)
			{
			url = document.URL.split("?")[0];
			var dropresult = addParam(url, "type",id);	
			window.location.href = dropresult;
			}
			
			
			 jQuery(document).ready(function() { 
		 jQuery("#fShippingId").on('change', function() {
		   
		   var id = $("#fShippingId").val();
		   	var dataStr = 'action=getvendoraddress&Unitid='+id;
			   $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
					  jQuery("#address").html(result);
				 
			   }
          });
		  
		 });
		 
		  }); //
			
					
			function deleteBox(id)
			{
				  if (confirm("Are you sure you want to delete this record?"))
				  {
					var dataString = 'data=PurchaseRequestdelete&id='+ id;
					$("#flash_"+id).show();
					$("#flash_"+id).fadeIn(400).html('<img src="assets/img/loading.gif"/>');
					$.ajax({
						   type: "POST",
						   url: "delete.php",
						   data: dataString,
						   cache: false,
						   success: function(result){
								if(result){
								url = document.URL.split("?")[0];
									if(result !=0)
									{
										var resultss = addParam(url, "msg", "delsuccess");	
										window.location.href = resultss;
									}
									else if(result == 0)
									{
										 var resultss = addParam(url, "msg", "undelsuccess");	
										window.location.href = resultss;
									}
									else
									{
										 window.location.href = url;
									}
									
										 }
							}
						});
					 }
			} //
</script>
 <script type="text/javascript">
 
 		function getGroup2ItemListing(value,id)
		 {
			
			var dataStr = 'action=getGroup2ItemList&Group1Id='+value;
			
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				   var ids = id.split("fGroupItem");
				    $("#Group2ItemList"+ids[1]).html(result);
				 
			   }
         
		  
		 });
		 }
		 function getItemListing(value,id)
		 {
			
			var dataStr = 'action=getItemLists&Group2Id='+value;
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				 var ids = id.split("Group2ItemList");
				    $("#ItemList"+ids[1]).html(result);
				 
			   }
         
		  
		 });
		 }
      function getOrderType(value)
	  {
	
	  if(value == 'General')
	  {
	  $('#purchaserequest').css('display','none');
	    ShowResultURL();
	  }
	   if(value == 'PR')
	  {
	  $('#purchaserequest').css('display','');
	  }
	  }
	  
	  function getTerms(id)
	  {
	  
		   var ids = $("#"+id).val();
		   	var dataStr = 'action=getTerms&TCId='+ids;
			
		    $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				  CKEDITOR.instances['Terms'].setData(result);	  
			
			   }
          });
		  
	  }
	  function checkQty(id,value,pr,pritemid)
	  {
	  
		  
		   	var dataStringqty = 'action=checkQty&Prid='+pr+'&Pritemid='+pritemid+'&qty='+value;
			
			    $.ajax({
			   type: 'POST',
			   url: 'ajax/dropdown.php',
			   data: dataStringqty,
			   cache: false,
			   success: function(dataStringqtyresult) {
			  
			  $results = jQuery.parseJSON(dataStringqtyresult);
			 if($results.status == 0)
				{
				alert("Please Enter the Quqntity less than or equal to Quantity : "+$results.avail_qty);
				$('#'+id).val($results.avail_qty);
				qtytotalpricecalc(id);
				return false;
				}
					
			   }
          });
		  
	  }
	  function getDivision(value,divisionid)
	  {
		    var dataStr = 'action=getDivisionPO&unitID='+value+'&divisionId='+divisionid;
			 $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
			    $("#unitwisedivisionList").html(result);
						 
			   }
          });
	  }
 $(document).ready(function () {
    $(document).on('click', '#purchaseItems .add', function () {
        var row = $(this).closest('tr');
        var clone = row.clone();
        // clear the values
		var tr = clone.closest('tr');
        tr.find('input[type=text]').val('');
		tr.find('input[name="fUnitPrice[]"]').val('0');
		tr.find('input[name="fUnitTotal[]"]').val('0');
			tr.find('input[name="fQuantity[]"]').val('0');
			tr.find('input[name="fTaxTotal[]"]').val('0');
		tr.find('input[name="fRequireDate[]"]').siblings('.ui-datepicker-trigger,.ui-datepicker-apply').remove();
		tr.find('input[name="fRequireDate[]"]').removeClass('hasDatepicker');
		tr.find('input[name="fRequireDate[]"]').removeData('datepicker');
		tr.find('input[name="fRequireDate[]"]').unbind();
		tr.find('input[name="fRequireDate[]"]').datepicker();
		
			clone.find('select').each(function() {
    $(this).find('option').each(function() {
        $(this).removeAttr('selected');
    });
});
		 clone.find('td').each(function(){
            var el = $(this).find(':first-child');
            var id = el.attr('id') || null;
            if(id) {
                var i = id.substr(id.length-1);
                var prefix = id.substr(0, (id.length-1));
		
              el.attr('id', prefix+(+i+1));
               
            }
        });
		
		
			 clone.find('td').each(function(){
            var el = $(this).find('.SpanPrice');
            var id = el.attr('id') || null;
            if(id) {
                var i = id.substr(id.length-1);
                var prefix = id.substr(0, (id.length-1));
		
              el.attr('id', prefix+(+i+1));
               
            }
        });
						
		 clone.find('td').each(function(){
            var el = $(this).find('.group2');
            var id = el.attr('id') || null;
            if(id) {
                var i = id.substr(id.length-1);
                var prefix = id.substr(0, (id.length-1));
		
              el.attr('id', prefix+(+i+1));
               
            }
        });
		
		 clone.find('td').each(function(){
            var el = $(this).find('.items');
            var id = el.attr('id') || null;
            if(id) {
                var i = id.substr(id.length-1);
                var prefix = id.substr(0, (id.length-1));
		
              el.attr('id', prefix+(+i+1));
               
            }
        });
	
	
		$(this).closest('tr').after(clone);
		
		
    });
    $(document).on('keypress', '#purchaseItems .next', function (e) {
        if (e.which == 13) {
            var v = $(this).index('input:text');
            var n = v + 1;
		    $('input:text').eq(n).focus();
				
            //$(this).next().focus();
        }
    });
    $(document).on('keypress', '#purchaseItems .nextRow', function (e) {
        if (e.which == 13) {
            $(this).closest('tr').find('.add').trigger('click');
            $(this).closest('tr').next().find('input:first').focus();
			  
			
        }
    });
    $(document).on('click', '#purchaseItems .removeRow', function () {
        if ($('#purchaseItems .add').length > 1) {
			$(this).closest('tr').remove();
        }
    });
});
jQuery(document).ready(function() { 
$(function () {
	Caluclation();
	recalc();
	});
	});
    </script>
   <script type="text/javascript">
function getParameterByName( name )
{
name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
var regexS = "[\\?&]"+name+"=([^&#]*)";
var regex = new RegExp( regexS );
var results = regex.exec( window.location.href );
if( results == null )
return "";
else
return decodeURIComponent(results[1].replace(/\+/g, " "));
}
   
   url = document.URL.split("?");
   var action =getParameterByName("action",url);
   
   if(action == 'edit')
   {
	
	  var OrderType = '<?php echo $aEditPurchaseOrder['id_pr'];?>';
	  if(OrderType == 0)
	  {
		  $('#purchaserequest').css('display','none');
		  
	  }
	  else
	  {
		   $('#purchaserequest').css('display','');
	  }
	  
	
	jQuery(document).ready(function() { 

$(function () {
	Caluclation();
	recalc();
	getDivision(<?php echo $aEditPurchaseOrder['id_unit'];?>,<?php echo $aEditPurchaseOrder['id_department'];?>);
	});
	});
	
   }
    
   
   </script>  
 
   <script type="text/javascript"> 
  jQuery(document).ready(function() { 
 $(':input[type=text]:visible, :input[type=submit]:visible, :input[type=reset]:visible, :radio:visible, :checkbox:visible, select:visible, textarea:visible')
.each(function(i){ $(this).attr('tabindex',i+1) });
});
   </script>	

</body>
<!-- END BODY -->
</html>