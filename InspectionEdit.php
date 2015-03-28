<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
    $item_id = $aRequest['fGrnId'];
  $allResult = $oMaster->getPrintPurchaseGoodsInfoList($item_id,'id','');
 if(isset($aRequest['send']))
  {
    $oFormValidator->setField("ALLTEXT", " Employee Name", $aRequest['fEmployeeId'], 1, '', '', '', '');
		$oFormValidator->setField("ALLTEXT", " Inspection Description", $aRequest['fInspectionDesc'], 1, '', '', '', '');
		
	  if($oFormValidator->validation())
	  {

	
			if($result = $oMaster->addInspection($aRequest, $_FILES))
			{
			  
				$msg = "New Image Added.";
			   echo '<script type="text/javascript">window.location.href="InspectionEdit.php?msg=success&fGrnId='.$result.'";</script>';
			}
			else $msg = "Sorry could not add..";
	
	}
      else
	  {
	   $errMsg = $oFormValidator->createMsg("<br />");
	  }
  } 
  if(isset($aRequest['update']))
  {
    if($result = $oMaster->updateInspection($aRequest, $_FILES))
	{
	  
	    $msg = "Inventory Item Details Updated Successfully.";
	   echo '<script type="text/javascript">window.location.href="InspectionEdit.php?msg=updatesucess&fGrnId='.$result.'";</script>';
	}
	else $msg = "Sorry could not add..";
  } 
  if(isset($aRequest['return']))
  {
    if($oMaster->addPurchaseReturn($aRequest))
	{
	  
	    $msg = "New Purchase Return Created.";
 echo '<script type="text/javascript">window.location.href="PurchaseReturn.php?msg=success";</script>';
	}
	else $msg = "Sorry could not add..";
  }
  
  
  if(isset($aRequest['fMode']))
  {
   $aReturnItemList = $oMaster->getPurchaseReturnItemList($item_id,'id');
/*echo '<pre>';
print_r($aReturnItemList);
echo '</pre>'*/;
/*exit();*/
  }
if($aRequest['action'] == 'edit')
{
$aEditResult = $oMaster->getItemInspectionInfo($aRequest['fInventoryItemid']);
/*echo '<pre>';
print_r($aEditResult);
echo '</pre>';*/
/*exit();*/
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Inspection </title>
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
                     Add Inspection 
                    
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
                     <li><a href="#">Inspection</a></li>
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
										echo $msg = 'Inspection Added Successfully';
									}
									else if($aRequest['msg'] == 'updatesucess')
									{
										echo $msg = 'Inspection Updated Successfully';
									}
									else if($aRequest['msg'] =='delsuccess')
									{
										echo $msg = 'Inspection Deleted Successfully';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'This Inspection is parent, so we can not delete';
									}
									?>
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
            
            <!-- BEGIN PAGE CONTENT-->
									<div class="row-fluid">
									<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-globe"></i>Deivery Details</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
								</div>
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>Item Number</th>
											<th>Item Name</th>
                                            <th>Asset Status</th>
											<th>Inspection Status</th>
                                            <th>Action</th>	
										</tr>
									</thead>
									<tbody>
                                    	<?php foreach ($allResult as $item): ?>
                                       
										<tr class="odd gradeX">
											<td><?php echo $item['id_inventory_item']; ?></td>
												<td><?php echo $item['itemgroup1_name'].'-'.$item['itemgroup2_name'].'-'.$item['item_name']; ?></td>
                                            <td><?php echo $oUtil->AssetItemStatus($item['asset_status']);?></td>
										 <td><?php echo $oUtil->inspectionStatus($item['inspection_status']);
																 
										 ?></td>
                                            <td>
											<?php if($oMaster->checkInspection($item['id_inventory_item'])) {?>
											  <a href="?fInventoryItemid=<?php echo  $item['id_inventory_item']; ?>&fGrnId=<?php echo  $item['id_grn']; ?>&action=edit" class="btn mini purple"><i class="icon-edit"></i>Edit</a> &nbsp; <br>
											  <?php } ?>
											<?php if($item['inspection_status'] == 4 && $item['return_status']!=1)
											{?>
											<a href="?fGrnId=<?php echo  $item['id_grn']; ?>&fMode=return" class="btn mini purple"><i class="icon-edit"></i>>Purchase Return</a>
											<?php
											}?>
											
                                            <div class="flash" id="flash_<?php echo  $item['id_inventory']; ?>"></div>
                                            <?php if($item['inspection_status']==1 && $item['return_status']!=1) { 
											?>
                                            <a href="?fInventoryItemid=<?php echo  $item['id_inventory_item']; ?>&fGrnId=<?php echo  $item['id_grn']; ?>" class="btn mini red"><i class="icon-edit"></i>Add Inspection</a> &nbsp; <br>
                                            <?php }
											if($item['asset_status']!=3 and $item['inspection_status']==3 )
											 {?>
                                            <a href="AssetDetails.php?fInventoryItemid=<?php echo  $item['id_inventory_item']; ?>&fGrnId=<?php echo  $item['id_grn']; ?>&tab=1" class="btn mini green"><i class="icon-edit"></i> Go to Add Asset</a>
                                             <?php } ?>
											 
											
                                            </td>
                                         
                                          
										</tr>
                                         <?php endforeach; ?>
										
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
									</div>
                                    
                                        
                                    <div class="row-fluid" <?php if(isset($aRequest['fInventoryItemid'])){ } else {?> style="display:none;" <?php } ?>>
									
									
                                    
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box light-grey">
							<div class="portlet-title">
								<h4><i class="icon-globe"></i>Item Details</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
                           
							<div class="portlet-body">
                                        
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
                             <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_sample_4" method="post" enctype="multipart/form-data">								<div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group error">
                                           
                                               <label class="control-label">Item Name:</label>
                                             <div class="controls">
                                               <span class="text"><b><?php
											  
											  $aItemInfo = $oMaster->getInventoryItemInfo($aRequest['fInventoryItemid'],'lookup');
											 echo $aItemInfo['itemgroup1_name'].'-'.$aItemInfo['itemgroup2_name'].'-'.$aItemInfo['item_name'];
											   
											   ?></b></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       </div>
									   <?php if(isset($aEditResult['assetimage']))
									   {
									   ?>
                             	
                                     <div class="row-fluid"> 
                                    <div class="span6">
                                    <table id="purchaseItems" name="purchaseItems">
                              <?php if(isset($aEditResult['assetimage']))
							  {
								  $a = 1;
							  ?>
								 <?php foreach($aEditResult['assetimage'] as $image ) {
									
									?>
                                   
                                <tr>
                               
                                <td>
                                <div class="control-group">
                              <label class="control-label">Image Upload#<?php echo $a;?></label>
                              <div class="controls">
                                 <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <?php if(isset($image['image_path'])){
									 ?>
                                       <img src="uploads/assetimage/<?php echo $image['image_path'];?>" alt="" />
                                         <?php } else if($aRequest['assetId']) { 
										 if($aassetItemInfo['asset_image']!='') {
										 ?>
                                           <img src="uploads/assetimage/<?php echo $aassetItemInfo['asset_image'];?>" alt="" />
                                     		<?php } else {?>
                                             <img src="assets/img/noimage.gif" alt="" />
                                            <?php } ?>							   
									   <?php } else { ?>
                                          <img src="assets/img/noimage.gif" alt="" />
                                       <?php } ?>
                                       <img src="assets/img/noimage.gif" alt="" />
                                    </div>
                                   
                                       <input type="hidden" name="fimages[]" value="<?php echo $image['image'];?>"/>
                                <input type="hidden" name="fImageId[]" value="<?php echo $image['id_image'];?>"/> 
                                    </div>
                                 </div>
                               
                              </div>
                          
                                </td>
                               <td> <input type="checkbox"  name="fDeleteImageCheckbox[]" value='<?php echo $image['id_image'];?>' /> Delete Image</td>
									
                                </tr>
                                <?php $a++ ; } ?>
                                <?php } ?>
                                </table>
                                    
                                    
                                    <div class="control-group">
                              <label class="control-label">Image </label>
                              <div class="controls">
                                 <label class="checkbox">
                                 <input type="checkbox"  name="fAddImgeCheckbox" id="fAddImgeCheckbox" /> Add Image
                                 </label>
                                
                              </div>
                                        </div>
                                    <div id="addimage" style="display:none">
                                     <table id="purchaseItems" name="purchaseItems">
                                      <tr>
                               
                                <td>
                                <div class="control-group">
                              <label class="control-label">Image Upload<span class="countimage">#1</span></label>
                              <div class="controls">
                                 <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                  
								
                                          <img src="assets/img/noimage.gif" alt="" />
                                     
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                       <span class="btn btn-file"><span class="fileupload-new">Select image</span>
                                       <span class="fileupload-exists">Change</span>
                                       <input type="file" class="default" name="fImage[]" /></span>
                                       <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                    </div>
                                 </div>
                               
                              </div>
                           </div>
                                </td>
                               <td><input type="button" name="addRow[]" class="add" value='+'></td>
									<td><input type="button" name="addRow[]" class="removeRow" value='-'>
                                   
                                    </td>
                                </tr>
                               
                                </table>  
                                </div>
                           			</div>
                                     
                                      </div>
									  
									  <?php } else {?>
									  
									  <table id="purchaseItems" name="purchaseItems">
								<tr>
                                <td>
                                <div class="control-group">
                              <label class="control-label">Image Upload</label>
                              <div class="controls">
                                 <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                       <img src="assets/img/noimage.gif" alt="" />
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                       <span class="btn btn-file"><span class="fileupload-new">Select image</span>
                                       <span class="fileupload-exists">Change</span>
                                       <input type="file" class="default" name="fImage[]"/></span>
                                       <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                    </div>
                                 </div>
                               
                              </div>
                           </div>
                                </td>
                               <td><input type="button" name="addRow[]" class="add" value='+'></td>
									<td><input type="button" name="addRow[]" class="removeRow" value='-'></td>
                                </tr></table>
								<?php } ?>
									  
                            <?php /*?><div class="control-group">
                                       <label class="control-label">Imge Name</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fImageName" data-required="1" value=""/>
                                          
                                       </div>
                                    </div><?php */?>
									
									<div class="control-group">
                                       <label class="control-label">Select Employee Name<span class="required">*</span></label>
                                       <div class="controls">
                                        <select class="large m-wrap" tabindex="1" name="fEmployeeId" id="fEmployeeId">
											<option value="0">Choose Employee Name</option>
											<?php
											  $aEmployeeList = $oMaster->getEmployeeList();
											  foreach($aEmployeeList as $aEmployee)
											  {
											 ?>
                                             <option value="<?php echo $aEmployee['id_employee']; ?>" <?php if((!empty($aEditResult['inspectiondetails']['id_employee'])? $aEditResult['inspectiondetails']['id_employee']:$aRequest['fEmployeeId']) == $aEmployee['id_employee']) { echo 'selected=selected' ;}?>><?php echo $aEmployee['employee_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										  &nbsp; &nbsp;<span><a href="#" class="employee" title="Add New Employee"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                       </div>
 
                                    </div>
                                    
                                     <div class="control-group">
                                       <label class="control-label">Image Description</label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fImageDesc"><?php echo (!empty($aEditResult['inspectiondetails']['image_description'])? $aEditResult['inspectiondetails']['image_description']:$aRequest['fImageDesc']);?></textarea>
                                       </div>
                                    </div>  
                           
                            <div class="control-group">
                                       <label class="control-label">Inspection details<span class="required">*</span></label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fInspectionDesc"><?php echo (!empty($aEditResult['inspectiondetails']['inspection_details'])? $aEditResult['inspectiondetails']['inspection_details']:$aRequest['fInspectionDesc']);?></textarea>
                                       </div>
                                    </div>
                                    
									<div class="row-fluid">
                                       <div class="span6 ">
                                       <div class="control-group">
                                       <label class="control-label">Remarks</label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fRemarks"><?php echo  (!empty($aEditResult['inspectiondetails']['remarks'])? $aEditResult['inspectiondetails']['remarks']:$aRequest['fRemarks']);?></textarea>
                                       </div>
                                    </div>
                                         <!--/span-->
                                    </div>
                                      </div>
                                    <div class="control-group">
                                       <label class="control-label">Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="3" <?php if((!empty($aEditResult['inspectiondetails']['status'])? $aEditResult['inspectiondetails']['status']:$aRequest['fStatus']) == '3'){ echo "checked=checked"; } ?>  />
                                          Passed
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="4" <?php if((!empty($aEditResult['inspectiondetails']['status'])? $aEditResult['inspectiondetails']['status']:$aRequest['fStatus']) == '4'){ echo "checked=checked"; } ?>  />  
                                         Rejected
                                          </label> 
                                         <label class="radio line">
                                          <input type="radio" name="fStatus" value="12" <?php if((!empty($aEditResult['inspectiondetails']['status'])? $aEditResult['inspectiondetails']['status']:$aRequest['fStatus']) == '12'){ echo "checked=checked"; } ?>  /> 
                                          Closed
                                          </label>
                                         
                                       </div>
                                       </div>
                                       <input type="hidden" value="<?php echo $aRequest['fInventoryItemid'];?>" name="fInventoryItemid"/>
                                       <input type="hidden" value="<?php echo $aRequest['fGrnId'];?>" name="fGrnId"/>
                                 <div class="form-actions">
                                   	<?php if($aRequest['action'] == 'edit') { ?>
									  <input type="hidden" name="action" value="edit"/>
									  
									 <button type="submit" class="btn blue" name="update"><i class="icon-ok"></i>Edit Inspection</button>
									<?php } else if($aRequest['action'] == 'Add') { ?>
									  <input type="hidden" name="action" value="Add"/>
									  
                                       <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Approve  Request</button>
									   <?php } else { ?>
									    
									   <input type="hidden" name="action" value="Add"/>
									   <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Approve  Request</button>
									   <?php } ?>
									   <a href="Inspection.php"><button type="button" class="btn">Go Back</button></a>
                                    </div>
                                      </form>
							</div>
						</div>
                                    
				</div>
                </div>
				
									<div class="row-fluid" <?php if(isset($aRequest['fMode'])){ } else {?> style="display:none;" <?php } ?>>
                                    
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box light-grey">
							<div class="portlet-title">
								<h4><i class="icon-globe"></i>Purchase Return</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
                           
							<div class="portlet-body">
                                        
                             <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_sample_4" method="post" enctype="multipart/form-data">								
							
							 <div class="form-horizontal form-view">
                                    <h3 class="form-section">Purchase Details</h3>
									
									 <div class="row-fluid">
									   <div class="span12 ">
									    <div class="control-group">
										  <label class="control-label">PO Number:</label>
										  <div class="controls" id="polist">
                                                <span class="text"><b style="color:#0000FF;"><?php echo  $aReturnItemList['inventoryinfo']['po_number'];?></b></span> <input type="hidden" name="fPoId" value="<?php echo $aReturnItemList['inventoryinfo']['id_po'];?>"/>
                                          </div>
										</div>  
									  </div>
									 </div>
									 
									  <div class="row-fluid">
									  <div class="span12 ">
									    <div class="control-group">
                                        <label class="control-label">Vendor Name:</label>
                                          <div class="controls">
                                             <span class="text"><?php echo $aReturnItemList['inventoryinfo']['vendor_name'];?>
											   <input type="hidden" name="fVendorId" value="<?php echo $aReturnItemList['inventoryinfo']['id_vendor'];?>"/>
											 
											 </span>
                                           </div>
                                         </div>
									  </div>
									  </div>
                                       <!--/span-->
									   
									</div>
							
							
							 <table class="table table-striped table-bordered table-hover dataTable" id="sample_1">
							 <thead>
							 <th>SlNO</th>
							 <th>Item Group 1</th>
							 <th>Brand / Make</th>
							  <th>Item</th>
							  <th>Purchased Qty</th>
							  <th>Return Quantity</th>
							 </thead>
							   <?php
							   $a=1;
							    foreach($aReturnItemList['iteminfo'] as $aItemDetails)
							   
							   { ?>
													
							 <tr>
							 <td><?php echo $a;?>
							 <input type="hidden" name="fInventoryItemId[]" value="<?php echo $aItemDetails['id_inventory_item'];?>"/>
							 
							 </td>
							 <td><?php echo $aItemDetails['itemgroup1_name'];?>
							 <input type="hidden" name="fGroup1[]" value="<?php echo $aItemDetails['id_itemgroup1'];?>"/>
							 </td>
							 <td><?php echo $aItemDetails['itemgroup2_name'];?>
							  <input type="hidden" name="fGroup2[]" value="<?php echo $aItemDetails['id_itemgroup2'];?>"/>
							 </td>
							 <td><?php echo $aItemDetails['item_name'];?>
							   <input type="hidden" name="fItem[]" value="<?php echo $aItemDetails['id_item'];?>"/>
							 </td>
							 <td><?php echo $aItemDetails['qty'];?>
							  <input type="hidden" name="fPurchasedqty[]" value="<?php echo $aItemDetails['qty'];?>"/>
							   <input type="hidden" name="fUom[]" value="<?php echo $aItemDetails['id_uom'];?>"/>
							    <input type="hidden" name="fUnitPrice[]" value="<?php echo $aItemDetails['unit_cost'];?>"/>
							 </td>
							  <td>
							  <select name="fReturnQty[]">
							  <?php
							  for($i=0;$i<= $aItemDetails['qty'];$i++)
							  {
							  
							  ?>
							  <option value="<?php echo $i;?>"><?php echo $i;?></option>
							  <?php } ?>
							  </select>
							  
							  </td>
							 </tr>
							  <?php $a++;} ?>
							 </table>
							 
							  <br>
							
                                       <input type="hidden" value="<?php echo $aRequest['fMode'];?>" name="fMode"/>
                                       <input type="hidden" value="<?php echo $aRequest['fGrnId'];?>" name="fGrnId"/>
									  
									  <div class="control-group">
                                       <label class="control-label">Select Sender Name</label>
                                       <div class="controls">
                                        <select class="large m-wrap" tabindex="1" name="fSenderEmployeeId">
											<option value="0">Choose Sender Name</option>
											<?php
											  $aEmployeeList = $oMaster->getEmployeeList();
											  foreach($aEmployeeList as $aEmployee)
											  {
			  
											 ?>
                                             <option value="<?php echo $aEmployee['id_employee']; ?>"><?php echo $aEmployee['employee_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                       </div>
                                    </div>
									   
									    <div class="row-fluid">
                                       <div class="span12">
                                          <div class="control-group">
                                             <label class="control-label">Remark</label>
                                             <div class="controls">
                                                <textarea class="large m-wrap" rows="3" name="fRemark"><?php echo $edit_result['remarks'];?></textarea>
                                             </div>
                                          </div>
                                       </div>
									   </div>
							 <br>
                                 <div class="form-actions">
                                   	
                                       <button type="submit" class="btn blue" name="return"><i class="icon-ok"></i>Create Purchase Return</button>
									   <a href="Inspection.php"><button type="button" class="btn">Go Back</button></a>
                                    </div>
                                      </form>
							</div>
						</div>
                                    
				</div>
                </div>
          
            <!-- END PAGE CONTENT-->     
         </div>
				
									<!-- END PAGE CONTENT-->
            
            
            
            <!-- END PAGE CONTENT-->         
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      
      
      <!-- END PAGE -->  
   </div>
   <!-- END CONTAINER -->
	<?php include_once 'Footer1.php'; ?>
     <script type="text/javascript">
     
	 jQuery(document).ready(function() { 
		 $('#fAddImgeCheckbox').click(function() {
    $("#addimage").toggle(this.checked);
});
		 
		  }); //
	  
 $(document).ready(function () {
    $(document).on('click', '#purchaseItems .add', function () {
        var row = $(this).closest('tr');
        var clone = row.clone();
        // clear the values
        var tr = clone.closest('tr');
        tr.find('input[type=text]').val('');
		 clone.find('td').each(function(){
            var el = $(this).find('.countimage');
            var id = el.text() || null;
			
            if(id) {
                var i = id.substr(id.length-1);
                var prefix = id.substr(0, (id.length-1));
		
              el.html(prefix+(+i+1));
               
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
    </script>
</body>
<!-- END BODY -->
</html>