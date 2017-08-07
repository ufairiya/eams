<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
 $GRNNumber = $oMaster->GoodsReceivedNumberCount();
 $oAssetUnit = &Singleton::getInstance('AssetUnit');
  $oAssetUnit->setDb($oDb);
  if(isset($aRequest['send']))
  {
		$oFormValidator->setField("ALLTEXT", " DC Number", $aRequest['fDcNumber'], 1, '', '', '', '');
		$oFormValidator->setField("ALLTEXT", " DC Date", $aRequest['fDcDate'], 1, '', '', '', '');
		$oFormValidator->setField("ALLTEXT", " Vendor", $aRequest['fVendorId'], 1, '', '', '', '');
		$oFormValidator->setField("ALLTEXT", " Store", $aRequest['fStoreId'], 1, '', '', '', '');
		$oFormValidator->setField("ALLTEXT", " Purchase Order", $aRequest['fPOId'], 1, '', '', '', '');
		
	  if($oFormValidator->validation())
	  {

	 
    if($result = $oMaster->addInventory($aRequest,$_FILES))
	{
	  $msg = "New GRN Added.";
	   echo '<script type="text/javascript">window.location.href="AssetItemEdit.php?tab=1&fGrnId='.$result.'";</script>';
	}
	else $msg = $_aErrorMsg['Duplicate']; //"Sorry could not add..";
	 }
      else
	  {
	   $errMsg = $oFormValidator->createMsg("<br />");
	  }
  } 
 if(isset($aRequest['tab']))
 {
 
	 $item_id = $aRequest['fGrnId'];
	$aInvetoryItem = $oMaster->getInventoryInfo($item_id,'id');
	//$aInvetoryItemInfo = $oMaster->getInventoryItemList($item_id,'id');
	 $edit_result = $oMaster->getPurchaseOrderItemInfo($aInvetoryItem['id_po'],'status');
	 $aPOTax=$oMaster->getPOTaxInfoList($aInvetoryItem['id_po'],'id');
	/* echo '<pre>';
	 print_r($edit_result);
	// print_r($aPOTax);
	  echo '</pre>';
	  exit();*/
	  if(isset($aRequest['fInventoryId']))
	  {
		   $item_id = $aRequest['fInventoryId'];
	       $aInvetoryItem = $oMaster->getInventoryInfo($item_id,'id');
		  $edit_result = $oMaster->getInventoryItemList($item_id,'id');
		   $aPOTax=$oMaster->getInventoryTaxInfoList($item_id,'id');
			
			/* echo '<pre>';
	 print_r($aPOTax);
	
	  echo '</pre>';
	  exit();*/
	  }
	  
 }
 if($aRequest['action'] == 'edit' && $aRequest['type']=='grn')
 {
           $item_id = $aRequest['fInventoryId'];
	       $aInvetoryDetails = $oMaster->getInventoryInfo($item_id,'id');
		   $aGrnDoc=$oMaster->getInventoryDocumentInfo($item_id,'');
		  /*echo '<pre>';
		   print_r($aGrnDoc);
		     echo '</pre>';
		   exit();*/
		   
 }
 
    if(isset($aRequest['Update']))
  {
      
				if($oMaster->updateInventoryItem($aRequest, 'update'))
				{
				  $msg = "GRN Updated.";
				  echo '<script type="text/javascript">window.location.href="AssetItem.php?msg=updatesucess";</script>';
				}
				else 
				  $msg = "Sorry";
		
  } //update
  
    if(isset($aRequest['update']))
  {
    if($oMaster->updateInventory($aRequest,$_FILES))
	{
	  $msg = "GRN Updated.";
	  echo '<script type="text/javascript">window.location.href="AssetItem.php?msg=updatesucess";</script>';
	}
	else 
	  $msg = "Sorry";
  } //update
 if(isset($aRequest['add']))
  {
    if($result = $oMaster->addInventoryItem($aRequest))
	{
	  $msg = "New Item Added.";
	 /*  echo '<script type="text/javascript">window.location.href="AssetItemEdit.php?tab=1&grnId='.$result.'";</script>';*/
	 
	 echo '<script type="text/javascript">window.location.href="AssetItem.php?msg=success"</script>'; 
	}
	else $msg = $_aErrorMsg['Duplicate']; //"Sorry could not add..";
  } 
 
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|Goods Received Note</title>
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
                     Goods Received Note
                     
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
                     <li><a href="#">Goods Received Note</a></li>
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
                                    <a href="AssetItem.php" class="btn red mini active">Back to List</a>
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
                        <h4><i class="icon-reorder"></i>Add Goods Received Note</h4>
                         <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit Goods Received Note</h4>
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
                       			
							<?php if($_REQUEST['tab']==1){?>	
							
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
							
                             <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal form-row-seperated" id="form_sample_3" method="post">
                            			  
                                  <div class="form-horizontal form-view">
                                    <h3 class="form-section">Delivery Details</h3>
                                     <div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group error">
                                           
                                               <label class="control-label">GRN No:</label>
                                             <div class="controls">
                                               <span class="text"><b><?php echo $aInvetoryItem['grn_no'];?></b></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span4 ">
                                          <div class="control-group">
                                              <label class="control-label">Bill Number:</label>
                                             <div class="controls">
                                               <span class="text"><?php echo $aInvetoryItem['bill_number'];?></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label">Party D C No:</label>
                                             <div class="controls">
                                                 <span class="text"><?php echo $aInvetoryItem['dc_number'];?></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
									   <div class="span4 ">
                                          <div class="control-group">
											  <label class="control-label" style="width:60px; text-align:left;">Party DC Date:</label>
											  <div class="controls" style="margin-left:60px;">
												   <span class="text"><?php echo date('d-m-Y',strtotime($aInvetoryItem['dc_date']));?></span>
										    </div>
									     </div>
								      </div>
                                    </div>
                                       <!--/span-->
                               </div>
                                    <!--/row-->
									<?php if($aInvetoryItem['direct_order']=='on')
									{
									?>
                                    
                                    <div class="row-fluid">
									  
									  <div class="span6 ">
									    <div class="control-group">
                                        <label class="control-label">Vendor / Supplier:</label>
                                          <div class="controls">
                                             <span class="text"><?php echo $aInvetoryItem['vendor_name'];?></span>
                                          </div>
                                        </div>
									  </div>
                                       <!--/span-->
									   <div class="span6 ">
									    <div class="control-group">
										  <label class="control-label">Direct Order:</label>
										  <div class="controls" id="polist">
                                                <span class="text">1</span>
                                          </div>
										</div>  
									  </div>
                                       <!--/span-->
									  
                               </div>
                                     <?php } else {?> 
									<div class="row-fluid">
									  
									  <div class="span4 ">
									    <div class="control-group">
                                        <label class="control-label">Vendor / Supplier:</label>
                                          <div class="controls">
                                             <span class="text"><?php echo $aInvetoryItem['vendor_name'];?></span>
                                          </div>
                                        </div>
									  </div>
                                       <!--/span-->
									   <div class="span4 ">
									    <div class="control-group">
										  <label class="control-label">PO No:</label>
										  <div class="controls" id="polist">
                                                <span class="text"><b style="color:#0000FF;"><?php echo $aInvetoryItem['po_number'];?></b></span>
                                          </div>
										</div>  
									  </div>
                                       <!--/span-->
									  <div class="span4 ">
                                          <div class="control-group">
											  <label class="control-label" style="width:60px; text-align:left;">PO Date:</label>
											  <div class="controls" style="margin-left:60px;">
												   <span class="text" ><?php echo date('d-m-Y',strtotime($aInvetoryItem['po_date']));?></span>
										    </div>
									    </div>
								      </div>
                               </div>
                                       <!--/span-->
									   
										<?php } ?>
                                    <!--/row-->                            
                                                                       
                                    
                                  
                                
                                <h3 class="form-section">Add Item </h3>
                                  <?php if($aInvetoryItem['direct_order']!='on')
									{
									?> 
                                <div class="row-fluid">
                                <?php $j=1; 
                                ?>                          
                                <table id="purchaseItems" name="purchaseItems" class="table table-striped table-bordered table-hover">
                                
                                <tr>
                                <th>Item Name</th>
                                <th>Quantity/ UOM</th>
                                <th>Unit Price (<?php echo Currencycode;?>)</th>
                                <th>Total (<?php echo Currencycode;?>)</th>
                                <th>Action</th>
                                </tr>
                                <?php foreach ($edit_result as $purchaseitem){ ?>
                                <tr>
                                <td>
                                <input type="hidden" name="fPoItemId[]" value="<?php echo $purchaseitem['id_po_item'];?>"/>                                     
                                <select class="m-wrap margin nextRow" tabindex="2" name="fGroup1[]">
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
                                
                                <select class="m-wrap nextRow" tabindex="3" name="fGroup2[]">
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
                                
                                <select class="m-wrap  nextRow margin" tabindex="1" name="fItemName[]">
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
                                <td>
                                <?php if($aRequest['action'] == 'edit') {?>
                                <input type="text" class="m-wrap xsmall" name="fQuantity[]" readonly value="<?php echo $purchaseitem['qty'];?>" onKeyUp="qtytotalpricecalc(this.id);"id="qty<?php echo $j;?>" style="margin-bottom: 5px;"/>
                                <input type="hidden" class="m-wrap xsmall" name="fInventoryItemId[]" value="<?php echo $purchaseitem['id_inventory_item'];?>"/>
                                 <?php } else {?>
                                 <input type="text" class="m-wrap xsmall" name="fQuantity[]" value="<?php echo $purchaseitem['balanced_qty'];?>" onKeyUp="qtytotalpricecalc(this.id);"id="qty<?php echo $j;?>" style="margin-bottom: 5px;"/>
                                 <?php }?>
                                
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
                                
                                
                                
                                <select class=" m-wrap margin" tabindex="1" name="fManufactureId[]">
                                <option value="0">Choose the Manufacturer</option>
                                <?php
                                $aManufacturerList = $oMaster->getManufacturerList();
                                foreach($aManufacturerList as $aManufacturer)
                                {
                                ?>
                                
                                <option value="<?php echo $aManufacturer['id_manufacturer']; ?>" <?php if($purchaseitem['id_manufacturer'] == $aManufacturer['id_manufacturer']) { echo 'selected=selected' ;}?>><?php echo $aManufacturer['manufacturer_name']; ?></option>
                                <?php
                                }
                                ?>
                                </select>
                                <input type="text" class=" m-wrap" placeholder="Enter the Item Remarks" name="fRemark[]" value="<?php echo $purchaseitem['remark']; ?>"/>
                                
                                
                                </td>
                                <td>
                              <?php  $aPOItemDetails= $oMaster->getPurchaseOrderItem($purchaseitem['id_po_item'],'id'); ?>
                               <input type="hidden" name="fPOUnitPrice[]" class="price"  value="<?php echo $aPOItemDetails['unit_cost'];?>"/>
                                <input type="text" name="fUnitPrice[]" class="price"  value="<?php echo $purchaseitem['unit_cost'];?>" id="unitprice<?php echo $j;?>" onKeyUp="unitcalc(this.id);CheckPrice();" />
                                <br>  <br>
                                <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
                                <input class="m-wrap m-ctrl-small date-picker span8" placeholder="Required Date" size="10" type="text" name="fRequireDate[]" value="<?php if($purchaseitem['due_date'] !='1970-01-01' || $purchaseitem['due_date'] !='0000-00-00' ) { echo date('d-m-Y'); } else { echo date('d-m-Y',strtotime($purchaseitem['due_date']));}	
								 ?>" style="width:100px;"><span class="add-on"><i class="icon-calendar"></i></span>
                                </div>
                                </td>
                                <td><input type="hidden" name="fUnitTotal[]" class="price"  value="0"  id="unittotal<?php echo $j;?>"/><span class="SpanPrice" id="unittotals<?php echo $j;?>" style="float:right;font-weight:bold;"></span></td>
                                
                                
                                
                                <td>
                                 <?php if($aRequest['action'] != 'edit') {?>
                                 
                                <input type="button" name="addRow[]" class="add" value='+'> <br>  <br>  <input type="button" name="addRow[]" class="removeRow" value='-' id="remove1" onClick="javascript:recalcs(this.id);">
                                
								<?php } ?>
                                </td>
                                </tr>
                                
                                <?php $j++;} ?>
                                                               
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
								$count_po = count($aPOTax);
                                if($count_po > 0)
								{
									foreach($aPOTax as $Potax) { ?>
                                <tr>
                                <td></td>
                                <td><select class="span12 " data-placeholder="Choose a Tax" tabindex="4" name="fTaxId[]" id="tax<?php echo $i;?>" value="0" onChange="javascript:taxcalc(this.id);">
                                <option value="0/+/0">Choose the Tax</option>
                                <?php
                                $aTaxList = $oMaster->getTaxFormList();
                                foreach($aTaxList as $aTax)
                                {
                                ?>
                                <option value="<?php echo $aTax['tax_percentage']; ?>/<?php echo $aTax['addless'];?>/<?php echo $aTax['id_taxform']; ?>" <?php if($Potax['tax_name'] == $aTax['taxform_name']) { echo 'selected=selected' ;}?>><?php echo $aTax['taxform_name'];?>&nbsp;-- <?php echo $aTax['tax_percentage'];?></option>
                                <?php
                                }
                                ?>
                                </select></td>
                                
                                <td style="text-align:right;"><span id="addlesss1"></span><input type="hidden" class="price xsmall" name="fAddLess[]" id="addless<?php echo $i;?>"/></td> <td><input type="text" class="price" name="fTaxTotal[]" id="taxprice<?php echo $i;?>" value="0"/>
                                
                                </td>
                                
                                <td>
                                
                                <input type="button" name="addRow[]" class="add" value='+'> &nbsp; <input type="button" name="addRow[]" class="removeRow" value='-' id="remove1" onClick="recalc();"></td>
                                
                                </tr>
                                <?php $i++;}} else { ?>
                                
                                <tr>
                                <td></td>
                                <td><select class="span12 " data-placeholder="Choose a Tax" tabindex="4" name="fTaxId[]" id="tax<?php echo $i;?>" value="0" onChange="javascript:taxcalc(this.id);">
                                <option value="0/+/0">Choose the Tax</option>
                                <?php
                                $aTaxList = $oMaster->getTaxFormList();
                                foreach($aTaxList as $aTax)
                                {
                                ?>
                                <option value="<?php echo $aTax['tax_percentage']; ?>/<?php echo $aTax['addless'];?>/<?php echo $aTax['id_taxform']; ?>" <?php if($Potax['tax_name'] == $aTax['taxform_name']) { echo 'selected=selected' ;}?>><?php echo $aTax['taxform_name'];?>&nbsp;-- <?php echo $aTax['tax_percentage'];?></option>
                                <?php
                                }
                                ?>
                                </select></td>
                                
                                <td style="text-align:right;"><span id="addlesss1"></span><input type="hidden" class="price xsmall" name="fAddLess[]" id="addless<?php echo $i;?>"/></td> <td><input type="text" class="price" name="fTaxTotal[]" id="taxprice<?php echo $i;?>" value="0"/>
                                
                                </td>
                                
                                <td>
                                
                                <input type="button" name="addRow[]" class="add" value='+'> &nbsp; <input type="button" name="addRow[]" class="removeRow" value='-' id="remove1" onClick="recalc();"></td>
                                
                                </tr>
                                <?php } ?>
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
                                 
                                    <?php } else {?>    
                                    <div class="row-fluid">  
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
                                                                               
                                          <select class="m-wrap margin" tabindex="2" name="fGroup1[]">
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
                                        
                                          <select class="m-wrap" tabindex="3" name="fGroup2[]">
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
                                          
                                          <select class="m-wrap  nextRow margin" tabindex="1" name="fItemName[]">
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
                                                                             
                                         
                                       
									 <select class=" m-wrap margin" tabindex="1" name="fManufactureId[]">
                                    <option value="0">Choose the Manufacturer</option>
											 <?php
											  $aManufacturerList = $oMaster->getManufacturerList();
											  foreach($aManufacturerList as $aManufacturer)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aManufacturer['id_manufacturer']; ?>" <?php if($purchaseitem['id_manufacturer'] == $aManufacturer['id_manufacturer']) { echo 'selected=selected' ;}?>><?php echo $aManufacturer['manufacturer_name']; ?></option>
                                             <?php
											  }
											 ?>
                      </select>
											  <input type="text" class=" m-wrap" placeholder="Enter the Item Remarks" name="fRemark" value="<?php echo $purchaseitem['item_remark']; ?>"/>
                                    
                                        
                                      </td>
                                         <td><input type="text" name="fUnitPrice[]" class="price"  value="<?php echo $purchaseitem['unit_cost'];?>" id="unitprice<?php echo $j;?>" onKeyUp="unitcalc(this.id);"/>
                                         <br>  <br>
                                         <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" placeholder="Required Date" size="10" type="text" name="fRequireDate[]" value="<?php echo date('m-d-Y',strtotime($purchaseitem['due_date'])); ?>" style="width:100px;"><span class="add-on"><i class="icon-calendar"></i></span>
										   </div>
                                         </td>
                                          <td><input type="hidden" name="fUnitTotal[]" class="price"  value="0"  id="unittotal<?php echo $j;?>"/><span class="SpanPrice" id="unittotals<?php echo $j;?>" style="float:right;font-weight:bold;"></span></td>
										
                                           
																				
											<td><input type="button" name="addRow[]" class="add" value='+'> <br>  <br>  <input type="button" name="addRow[]" class="removeRow" value='-' id="remove1" onClick="javascript:recalcs(this.id);"></td>
									  </tr>
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
									<td><select class="span12 " data-placeholder="Choose a Tax" tabindex="4" name="fTaxId[]" id="tax<?php echo $i;?>" value="0" onChange="javascript:taxcalc(this.id);">
											 <option value="0/+/0">Choose the Tax</option>
											 <?php
											  $aTaxList = $oMaster->getTaxFormList();
											  foreach($aTaxList as $aTax)
											  {
											 ?>
                                             <option value="<?php echo $aTax['tax_percentage']; ?>/<?php echo $aTax['addless'];?>/<?php echo $aTax['id_taxform']; ?>" <?php if($Potax['tax_name'] == $aTax['taxform_name']) { echo 'selected=selected' ;}?>><?php echo $aTax['taxform_name'];?>&nbsp;-- <?php echo $aTax['tax_percentage'];?></option>
                                             <?php
											  }
											 ?>
                                          </select></td>
									
                                    <td style="text-align:right;"><span id="addlesss1"></span><input type="hidden" class="price xsmall" name="fAddLess[]" id="addless<?php echo $i;?>"/></td> <td><input type="text" class="price" name="fTaxTotal[]" id="taxprice<?php echo $i;?>" value="0"/>
                                
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
                                                        
                                 
                                  
                                     <input type="hidden" name="fvendorId" value="<?php echo $aInvetoryItem['id_vendor'];?>"/>
                                       <input type="hidden" name="fPoId" value="<?php echo $aInvetoryItem['id_po'];?>"/>
                                       <!--/span-->
                                       <br>                                       
                                       <br>  
                                     
                                    
                                    <div class="form-actions">
									<?php if($aRequest['action'] == 'edit')
						{
						?>
						 <button type="submit" class="btn blue" name="Update"><i class="icon-pencil"></i>  Update</button>
						  <input type="hidden" name="action" value="edit"/>
						   <input type="hidden" name="fInventoryId" value="<?php echo $aRequest['fInventoryId'];?>"/>
						 <input type="hidden" name="fGrnId" value="<?php echo $aInvetoryItem['id_inventory'];?>"/>
						  <input type="hidden" name="tab" value="1"/>
                                       <a href="AssetItem.php"><button type="button" class="btn">Back</button></a>
						<?php } else { ?>
						          <input type="hidden" name="fGrnId" value="<?php echo $aRequest['fGrnId'];?>"/>
                                       <button type="submit" class="btn blue" name="add"><i class="icon-pencil"></i> Add Item</button>
                                       <a href="AssetItem.php"><button type="button" class="btn">Back</button></a>
									   <?php } ?>
                                    </div>
                                 </div>
                                 <!-- END FORM-->  
                                 
                    </form>
                            <?php } else if($_REQUEST['action']=='Add') { ?>
                                 <!-- BEGIN FORM-->
								 
								 
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal form-row-seperated" id="from_grn" method="post" enctype="multipart/form-data">
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
							
								   <h3 class="form-section">Enter Delivery Details</h3>
                                   <div class="row-fluid">
								   
								   
                                       <div class="span12 ">
                                          <div class="control-group error">
                                           
                                               <label class="control-label">GRN No.</label>
                                             <div class="controls">
                                             <span class="text"><b><?php echo  $GRNNumber;?></b></span>
                                                <input type="hidden" class="m-wrap span4" name="fGRNNumber"  placeholder="GRN Number" value="<?php echo  $GRNNumber;?>">
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                              </div>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                              <label class="control-label">Bill Number </label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap " placeholder="Bill Number" name="fBillNumber" value="<?php echo $aRequest['fBillNumber'];?>">
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
											  <label class="control-label" >Bill Date</label>
											  <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fBillDate" value="<?php echo $aRequest['fBillDate'];?>"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
									     </div>
                                       </div>
                              </div>
                                         	<div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" >Party D C No.<span class="required">*</span></label>
                                             <div class="controls" >
                                                <input type="text" class="m-wrap " placeholder="Delivery Challan No." name="fDcNumber" value="<?php echo $aRequest['fDcNumber'];?>">
                                                <!--<span class="help-block">Delivery Challan No.</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
									   <div class="span6 ">
                                          <div class="control-group">
											  <label class="control-label" >Party D C Date<span class="required">*</span></label>
											  <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fDcDate" value="<?php echo $aRequest['fDcDate'];?>"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
									     </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->
									  
									<div class="row-fluid">
									  
									  <div class="span6 ">
									    <div class="control-group">
                                        <label class="control-label">Vendor / Supplier <span class="required">*</span></label>
                                          <div class="controls">
                                             <select  class="m-wrap" data-placeholder="Choose a Vendor" tabindex="1" name="fVendorId" id="fVendorId">
     										    <option value="0">Choose a Vendor</option>
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
												 <option value="<?php echo $aVendor['id_vendor']; ?>" <?php if((!empty($edit_result[0]['id_vendor'])? $edit_result[0]['id_vendor']:$aRequest['fVendorId']) == $aVendor['id_vendor']) { echo 'selected=selected' ;}?>><?php echo $aVendor['vendor_name']; ?></option>
												 <?php
												 }
												  
												 ?>
												 </optgroup>
												 <?php } ?>
                                             </select>
											 &nbsp;&nbsp;
											  <?php /*?><span><a href="#" class="vendor" title="Add New Vendor"><i class="icon-plus-sign" style="color:#009900;"></i></a></span><?php */?>
                                          </div>
                                        </div>
									  </div>
                                      <div class="span6 ">
                                      <div class="control-group">
                                        <label class="control-label">To Store<span class="required">*</span></label>
                                          <div class="controls">
                                    <select class="m-wrap" data-placeholder="Choose a Store"  name="fStoreId" id="fStoreId">
                                          
                                          <option value="0">Choose a Store</option>
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
                                             
                                             
                                             <option value="<?php echo $aStore['id_store']; ?>/<?php echo $aUnit['id_unit'];?>" <?php if((!empty($aStockItem['id_store'])? $aStockItem['id_store']: $aRequest['fStoreId']) == $aStore['id_store']) { echo 'selected=selected' ;}?>><?php echo $aStore['store_name']; ?></option>
                                           
                                             <?php
											  }
											 ?>
                                           </optgroup>
                                            <?php
											  }
											 ?>
                                            </select>
											  &nbsp;&nbsp;
											  <span><a href="#" class="store" title="Add New Store"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                   </div>
                                      </div>
                                     
                                      </div>
                              </div>
                                      	<div class="row-fluid">
                                       <!--/span-->
                                       
									   <div class="span4 ">
									    <div class="control-group">
										  <label class="control-label">PO No.<span class="required">*</span></label>
										  <div class="controls" id="polist">
                                                <input type="hidden" class="m-wrap " placeholder="Purchase Order No." name="fPOId" value="<?php echo $aRequest['fPOId'];?>">
                                                
                                                <!--<span class="help-block">Purchase Order No.</span>-->
                                          </div>
                                          
										</div>  
									  </div>
                                      
                                       <!--/span-->
									  <div class="span4 ">
                                          <div class="control-group">
											  <label class="control-label" >PO Date</label>
											  <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fPoDate" id="fPoDate" value="<?php echo $aRequest['fPoDate'];?>"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
									    </div>
                                       </div>
                                       <!--/span-->
									   <div class="span4 ">
									    <div class="control-group" style="margin-top:12px;">
										  
										  <div class="controls">
                                              <input type="checkbox" name="fDirectOrder" value="<?php echo $aRequest['fDirectOrder'];?>"/> Direct Order
                                          </div>
                                          
										</div>  
									  </div>
									</div>
                                    <!--/row-->
                                 
								    <div class="row-fluid">
                                       <div class="span12">
                                          <div class="control-group">
                                             <label class="control-label">Description</label>
                                             <div class="controls">
                                                <textarea class="large m-wrap" rows="3" name="fRemarks"><?php echo (!empty($edit_result['remarks'])? $edit_result['remarks']:$aRequest['fRemarks']);?></textarea>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       
                                       
                                    </div>
									<div class="row-fluid">
                                       <div class="span6 ">
                                         <div class="control-group">
                              <label class="control-label">Upload Bill Document</label>
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
                                      <input type="file" name="fUploadDocument" value="<?php echo $aRequest['fUploadDocument'];?>"/>
                                      </span>
                                       <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
									 
									   
                                    </div>
                                 </div>
                              </div>
                           </div> 
                                       </div>
                                       
                                       
                                    </div>
                                    
								  <div class="form-actions">
								  
						<?php if($aRequest['action'] == 'edit')
						{
						?>
						 <button type="submit" class="btn blue" name="update"><i class="icon-ok"></i>Update</button> 
						  <input type="hidden" name="action" value="edit"/>
						   <input type="hidden" name="type" value="grn"/> 
						     <input type="hidden" name="fInventoryId" value="<?php echo $aRequest['fInventoryId'];?>"/>           
                          <button type="button" class="btn">Cancel</button>
						<?php } else if($aRequest['action'] == 'Add') { ?>
						
                                       <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Add Item</button> 
									   <input type="hidden" name="action" value="Add"/>       
                                       <button type="button" class="btn">Cancel</button>
									   <?php } ?>
                              </div>
				    </form>
                                  
                                <?php } else if($_REQUEST['action'] == 'edit') { ?>
                                   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal form-row-seperated" id="form_sample_3" method="post" enctype="multipart/form-data">
                                   
                                       <div class="form-horizontal form-view">
                                    <h3 class="form-section">Edit Delivery Details</h3>
                                    <div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group error">
                                           
                                               <label class="control-label">GRN No.</label>
                                             <div class="controls">
                                             <span class="text"><b><?php echo $aInvetoryDetails['grn_no']; ?></b></span>
                                                <input type="hidden" class="m-wrap span4" name="fGRNNumber"  placeholder="GRN Number" value="<?php echo  $aInvetoryDetails['grn_no'];?>">
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       </div>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                              <label class="control-label">Bill Number</label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap " tabindex="1" placeholder="Bill Number" name="fBillNumber" value='<?php echo  $aInvetoryDetails['bill_number'];?>'>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
											  <label class="control-label" >Bill Date</label>
											  <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" tabindex="2" size="10" type="text" name="fBillDate" value='<?php echo date('d-m-Y',strtotime($aInvetoryDetails['bill_date']));?>'><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
									     </div>
                                       </div>
                                         </div>
                                     <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" >Party D C No.</label>
                                             <div class="controls" >
                                                <input type="text" class="m-wrap " tabindex="3" placeholder="Delivery Challan No." name="fDcNumber"  value='<?php echo  $aInvetoryDetails['dc_number'];?>'>
                                                <!--<span class="help-block">Delivery Challan No.</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
									   <div class="span6 ">
                                          <div class="control-group">
											  <label class="control-label" >Party D C Date</label>
											  <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" tabindex="4"  size="10" type="text" name="fDcDate" value='<?php echo date('d-m-Y',strtotime($aInvetoryDetails['dc_date']));?>'><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
									     </div>
                                       </div>
                                       <!--/span-->
                                    </div>    	
                                    <!--/row-->
									  
									<div class="row-fluid">
									  
									  <div class="span6 ">
									    <div class="control-group">
                                        <label class="control-label">Vendor / Supplier</label>
                                          <div class="controls">
                                             <select class=" m-wrap" data-placeholder="Choose a Vendor" tabindex="5" name="fVendorId" id="fVendorId" disabled="disabled" >
     										    <option value="0">Choose a Vendor</option>
												  <?php
												  $avendorList = $oAssetVendor->getAllVendorInfo();
												  foreach($avendorList as $aVendor)
												  {
												 ?>
												 <option value="<?php echo $aVendor['id_vendor']; ?>" <?php if($aInvetoryDetails['id_vendor'] == $aVendor['id_vendor']) { echo 'selected=selected' ;}?>><?php echo $aVendor['vendor_name']; ?></option>
												 <?php
												  }
												 ?>
                                             </select>
											 <input type="hidden" class="m-wrap " tabindex="7"  name="fVendorId" value='<?php echo  $aInvetoryDetails['id_vendor'];?>'>
                                          </div>
                                        </div>
									  </div>
                                      <div class="span6 ">
                                      <div class="control-group">
                                        <label class="control-label">To Store</label>
                                          <div class="controls">
                                    <select class="m-wrap" data-placeholder="Choose a Store"  tabindex="6"  name="fStoreId" id="fStoreId" >
                                          
                                          <option value="0">Choose a Store</option>
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
                                             
                                             
                                             <option value="<?php echo $aStore['id_store']; ?>/<?php echo $aUnit['id_unit'];?>" <?php if($aInvetoryDetails['id_store'] == $aStore['id_store']) { echo 'selected=selected' ;}?> ><?php echo $aStore['store_name']; ?></option>
                                           
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
                                      </div>
                                      	<div class="row-fluid">
                                       <!--/span-->
                                       
									   <div class="span4 ">
									    <div class="control-group">
										  <label class="control-label">PO No.</label>
										  <div class="controls" id="polist">
                                                <input type="text" class="m-wrap "  tabindex="7" placeholder="Purchase Order No." readonly="readonly" name="fPONumber" value='<?php echo  $aInvetoryDetails['po_number'];?>'>
												<input type="hidden" class="m-wrap " tabindex="7" placeholder="Purchase Order No." name="fPOId" value='<?php echo  $aInvetoryDetails['id_po'];?>'>
                                                
                                                <!--<span class="help-block">Purchase Order No.</span>-->
                                          </div>
                                          
										</div>  
									  </div>
                                      
                                       <!--/span-->
									  <div class="span4 ">
                                          <div class="control-group">
											  <label class="control-label" >PO Date</label>
											  <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" tabindex="8" type="text" name="fPoDate" id="fPoDate" value='<?php echo date('d-m-Y',strtotime($aInvetoryDetails['po_date']));?>'><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
									    </div>
                                       </div>
                                       <!--/span-->
									   <div class="span4 ">
									    <div class="control-group" style="margin-top:12px;">
										  
										  <div class="controls">
                                              <input type="checkbox" tabindex="9" name="fDirectOrder" /> Direct Order
                                          </div>
                                          
										</div>  
									  </div>
									</div>
                                    <!--/row-->
                                 
								    <div class="row-fluid">
                                       <div class="span12">
                                          <div class="control-group">
                                             <label class="control-label">Description</label>
                                             <div class="controls">
                                                <textarea class="large m-wrap" tabindex="10" rows="3" name="fRemarks"><?php echo $aInvetoryDetails['remark'];?></textarea>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       
                                       
                                    </div>
                                    </div>
                                    <!--/row-->
									<div class="row-fluid">
                                       <div class="span6 ">
                                         <div class="control-group">
                              <label class="control-label">Upload Bill Document</label>
                              <div class="controls">
                                 <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="input-append">
                                       <div class="uneditable-input">
                                          <i class="icon-file fileupload-exists"></i> 
                                          <span class="fileupload-preview"></span>
                                       </div>
                                       <span class="btn btn-file">
                                       <span  tabindex="11" class="fileupload-new">Select file</span>
                                       <span class="fileupload-exists">Change</span>
                                      <input type="file" name="fUploadDocument"/>
                                      </span>
                                       <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
									   
									   
                                    </div>
                                 </div>
                              </div>
							    
                           </div> 
                                       </div>
                                        <?php if($aGrnDoc['document_path']!='')
									 {
										 ?>
                                    <a class="fancybox fancybox.iframe"  href="uploads/grndocument/<?php echo $aGrnDoc['document_path'];?> " target="_blank" style="margin-left:50px;">View Document</a>
                                     <?php } ?>
                                       
                                    </div>
									
									 
                                         <div class="form-actions">
										   <input type="hidden" name="action" value="edit"/>
						                   <input type="hidden" name="type" value="grn"/> 
						                   <input type="hidden" value="<?php echo $aGrnDoc['document_path'];?>" name="fGrnDocName"/>
                                           <input type="hidden" value="<?php echo $aRequest['fInventoryId'];?>" name="fGrnId"/>
                                       <button type="submit" tabindex="12" class="btn blue" name="update"><i class="icon-ok"></i>Update</button>        
                                       <button type="button" class="btn">Cancel</button>
                                    </div>
                    </form>
                                <?php } ?>
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
	<script>
	 
	 function callvendor()
	 {
	 	//alert("vendor called");
	 }
	 jQuery(document).ready(function() { 
		 jQuery("#fVendorId").on('change', function() {
		   //alert($("#fVendorId option:selected").text());
		   //alert($("#fVendorId").val());
		   var vendorId = $("#fVendorId").val();
		   var dataStr = 'action=getpo&vendorId='+ vendorId;
          $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				  jQuery("#polist").html(result);
			   }
          });
		 });
		 }); // 
	function getPoDate(value)
	{
		  // var PoId = $("#fPOId").val();
		   var dataStr = 'action=getpodate&poId='+ value;
		       $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
			  jQuery("#fPoDate").val(result);
			   }
          });
	}
		 
		 
	  /*onChange="javascript: callvendor();"*/
	</script>
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
      
 $(document).ready(function () {
    $(document).on('click', '#purchaseItems .add', function () {
        var row = $(this).closest('tr');
        var clone = row.clone();
        // clear the values
		var tr = clone.closest('tr');
        tr.find('input[type=text]').val('');
		tr.find('input[name="fUnitPrice[]"]').val('0');
		tr.find('input[name="fInventoryItemId[]"]').val('0');
		tr.find('input[name="fUnitTotal[]"]').val('0');
			tr.find('input[name="fQuantity[]"]').val('0');
			tr.find('input[name="fTaxTotal[]"]').val('0');
		tr.find('input[name="fRequireDate[]"]').siblings('.ui-datepicker-trigger,.ui-datepicker-apply').remove();
		tr.find('input[name="fRequireDate[]"]').removeClass('hasDatepicker');
		tr.find('input[name="fRequireDate[]"]').removeData('datepicker');
		tr.find('input[name="fRequireDate[]"]').unbind();
		tr.find('input[name="fRequireDate[]"]').datepicker();
		 clone.find('td').each(function(){
            var el = $(this).find(':first-child');
            var id = el.attr('id') || null;
            if(id) {
                var i = id.substr(id.length-1);
                var prefix = id.substr(0, (id.length-1));
		
              el.attr('id', prefix+(+i+1));
               
            }
        });
		clone.find('select').each(function() {
    $(this).find('option').each(function() {
        $(this).removeAttr('selected');
    });
});
			 clone.find('td').each(function(){
            var el = $(this).find('.SpanPrice');
            var id = el.attr('id') || null;
			el.text('0');
            if(id) {
                var i = id.substr(id.length-1);
                var prefix = id.substr(0, (id.length-1));
		       el.attr('val','0');
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
		function CheckPrice()
		  {
			  
			  
			  var qty = new Array();
				$("input[name='fUnitPrice[]']").each(function(){
					var quantity = $(this).val();
					qty.push(quantity);
				});
				
				  var stockqty = new Array();
				$("input[name='fPOUnitPrice[]']").each(function(){
					var Stockquantity = $(this).val();
					stockqty.push(Stockquantity);
				});
				
								 
				
				Array.prototype.compare = function(testArr) {
      for (var i = 0; i < testArr.length; i++) {
		if(parseFloat(this[i]) > parseFloat(testArr[i]))
		{
			return true;	
		}
       	
		
    }
    return false;
}
				if(stockqty.compare(qty)) {
			  } else {
				  $("input[name='fUnitPrice[]']").each(function(){
					var quantity = $(this).val(stockqty);
					
				});
		     alert("Please Enter the unit price is less than Purchase Order Price");
	  
	 return false;
}
		  }
	</script>
</body>
<!-- END BODY -->
</html>