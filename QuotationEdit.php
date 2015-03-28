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
 if(isset($aRequest['id']))
{
  
	
  $item_id = $aRequest['id'];
	$edit_result = $oMaster->getPurchaseRequestInfo($item_id,'id');
	 $aItemInfo  = $oMaster->getPurchaseRequestItemInfo($item_id,'id');
	 $aItemInfo =$aItemInfo['iteminfo'];
	 }
	 
 if($aRequest['action'] == 'edit')
{ 
	
     $id_quote = $aRequest['fQuoteId'];
	$item_id = $aRequest['id'];
	$edit_result = $oMaster->getPurchaseRequestInfo($item_id,'id');
	 $aItemInfos  = $oMaster->getQuotationItemInfo($id_quote,'id');
   $aItemInfo  = $aItemInfos['quotation_item'];
/*	
echo '<pre>';
	
	  print_r($aItemInfo);
	    echo '</pre>';
	  exit();*/
	  
	
	 }
	 
 if(isset($aRequest['Update']))
{ 
     $oFormValidator->setField("ALLTEXT", "Quotation Number", $aRequest['fQuotationNo'], 1, '', '', '', '');
		$oFormValidator->setField("ALLTEXT", " Quotation Amount", $aRequest['fQuotationAmount'], 1, '', '', '', '');
		
	  if($oFormValidator->validation())
	  {
    if($result = $oMaster->updateQuotation($aRequest,$_FILES))
  {
    $msg = "New Item Added.";
	 echo '<script type="text/javascript">window.location.href="QuotationList.php?id='.$result.'&msg=success";</script>';
  }
  else
  {
    $msg = "Sorry some error occur.";
  }	
  }
      else
	  {
	   $errMsg = $oFormValidator->createMsg("<br />");
	  } 
 }
  if(isset($aRequest['send']))
  {
  
    $oFormValidator->setField("ALLTEXT", "Quotation Number", $aRequest['fQuotationNo'], 1, '', '', '', '');
		$oFormValidator->setField("ALLTEXT", " Quotation Amount", $aRequest['fQuotationAmount'], 1, '', '', '', '');
		
	  if($oFormValidator->validation())
	  {
  if($result = $oMaster->addQuotation($aRequest,$_FILES))
  {
    $msg = "New Item Added.";
	 echo '<script type="text/javascript">window.location.href="QuotationList.php?id='.$result.'&msg=updatesucess";</script>';
  }
  else
  {
    $msg = "Sorry some error occur.";
  }
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
   <title>EAMS| Quotation</title>
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
                    Quotation
                     
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
                     <li><a href="#">Quotation</a></li>
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
                        <h4><i class="icon-reorder"></i>Add Quotation</h4>
                         <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit Quotation</h4>
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
                     <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal form-row-seperated" id="form_sample_3" method="post" enctype="multipart/form-data">
					
					 <div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group error">
                                          
                                               <label class="control-label">Purchase Request No:</label>
                                             <div class="controls">
                                               <span class="text"><b><?php echo $edit_result['request_no'];?></b><input type="hidden" name="fPRId" id="fPRId" value="<?php echo (!empty($edit_result['id_pr'])? $edit_result['id_pr']:$aRequest['fPRId']);?>"/></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       </div>
                                       
                                       
                                        <?php if($aRequest['action'] == 'Add')
							{ ?>
                                     <div class="control-group">

                                      <label class="control-label">Select Vendor</label>

                                       <div class="controls">

                                       <select class="large m-wrap" tabindex="3" name="fVendorId" id="fVendorId">

											 <?php

											  $avendorList = $oMaster->getAssignVendorToPrInfo($item_id,'lookup');
											 ?>

                                             <option value="0">Choose the Supplier</option>

                                             <?php  foreach($avendorList as $aVendor)

											  {

												  ?>

                                             <option value="<?php echo $aVendor['id_vendor']; ?>"  <?php if((!empty($edit_result['id_vendor'])? $edit_result['id_vendor']:$aRequest['fVendorId']) == $aVendor['id_vendor']) { echo 'selected=selected' ;}?>><?php echo $aVendor['vendor_name']; ?></option>

                                             <?php

											  }

											 ?>

                                          </select> 

                                             </div>

                                   		 </div>
                                          <?php } else {?>
                                          <div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group error">
                                          
                                               <label class="control-label">Vendor Name:</label>
                                             <div class="controls">
                                               <span class="text"><b><?php echo  (!empty($aItemInfos['quotationinfo']['vendor_name'])? $aItemInfos['quotationinfo']['vendor_name']:$aRequest['fVendorId']);?></b><input type="hidden" name="fVendorId" id="fVendorId" value="<?php echo $aItemInfos['quotationinfo']['id_vendor'];?>"/></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       </div>
                         
                        <?php } ?>
						
						<div class="row-fluid">
                                       <div class="span4 ">
                                          <div class="control-group error">
                                          
                                               <label class="control-label">Quotation No:</label>
                                             <div class="controls">
                                               <span class="text"><input type="text" name="fQuotationNo" id="fQuotationNo" value="<?php echo (!empty($aItemInfos['quotationinfo']['quote_number'])? $aItemInfos['quotationinfo']['quote_number']:$aRequest['fQuotationNo']);?>"/></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
									    <!--/span-->
										<div class="span4 ">
                                          <div class="control-group">
											  <label class="control-label" >Due Date:</label>
											  <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">  
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fDueDate" value="<?php 
													if($aItemInfos['quotationinfo']['quote_date']!= '')
													{
													echo  date('d-m-Y',strtotime($aItemInfos['quotationinfo']['quote_date']));
													}
													else
													{
													echo date('d-m-Y');
													}?>"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
										   </div>
                                       </div>
									   
                                       <!--/span-->
									   
									   <div class="span4 ">
                                          <div class="control-group">
											  <label class="control-label" >Valid Date:</label>
											  <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fValidDate" value="<?php if($aItemInfos['quotationinfo']['quote_valid_date']!= ''){ echo  date('d-m-Y',strtotime($aItemInfos['quotationinfo']['quote_valid_date']));}?>"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
										   </div>
                                       </div>
									   
                                       </div>
									   
						<div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group error">
                                          
                                               <label class="control-label">Quotation Amount:</label>
                                             <div class="controls">
                                               <span class="text"><input type="text" name="fQuotationAmount" id="fQuotationAmount" value="<?php echo (!empty($aItemInfos['quotationinfo']['quote_amount'])? $aItemInfos['quotationinfo']['quote_amount']:$aRequest['fQuotationAmount']);?>"/></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       </div>
						
					  <?php if(!empty($aItemInfo))
										 {?>
										  <h3 class="form-section">Purchase Request Item Info</h3>
										 <div class="row-fluid">               
                                         <table id="purchaseItems" name="purchaseItems" class="table table-striped table-bordered table-hover">
								<tr>
											 <th>Item Group1</th>
											<th>Brand / Make</th>
                                             <th>Item </th>
                                             <th>UOM</th>
                                            <th>Quantity</th>
                                           <th>Unit Price</th>
										   <th>Vendor Unit Price</th>
										   <th>Nego Unit Price</th>
                                           
								</tr>
                                
                              		<?php 
                              	  foreach( $aItemInfo as $itemInfo)
	                              {
	                             ?>
	 <tr>
	  <td><?php echo $itemInfo['itemgroup1_name'];?>
	  <input type="hidden" name="fItemId[]" value="<?php echo $itemInfo['id_pr_item'];?>" >
	   <input type="hidden" name="fQuoteItemId[]" value="<?php echo $itemInfo['id_quote_item'];?>" > 
	  </td>
	  <td><?php echo $itemInfo['itemgroup2_name'];?></td>
	   <td><?php echo $itemInfo['item_name'];?></td>
	    <td><?php echo $itemInfo['uom_name'];?></td>
	 <td><?php echo $itemInfo['qty'];?></td>
	 <td><?php echo $itemInfo['unit_cost'];?></td>
	  <td><input type="text" name="fVendorPrice[]" value="<?php echo $itemInfo['quote_unit_cost'];?>"></td>
	  <td><input type="text" name="fNegoPrice[]" value="<?php echo $itemInfo['negotiated_unit_cost'];?>"></td>
	 
	  </tr>
	 <?php } ?>					
                                  </table>
                                 
                                 
                                
                                   </div>
								   <?php } ?>
					 <div class="row-fluid">
                                       <div class="span12 ">
                                         <div class="control-group">
                              <label class="control-label">Upload Quotation Document</label>
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
                                      <input type="file" name="fUploadDocument"/>
                                        </span>
                                       <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
									   
									   
                                    </div>
                                 </div>
                              </div>
							    <?php if($aItemInfos['quotationinfo']['document_name']!='')
									 {
										 ?>
										 									
									<a class="fancybox fancybox.iframe" href="uploads/quotationdocument/<?php echo trim($aItemInfos['quotationinfo']['document_name']);?>">View Document</a>	
                                   <?php } ?>
                           </div> 
                                       </div>
								
                                       
									 </div>	  
									<input type="hidden" value="<?php echo $aItemInfos['quotationinfo']['document_name'];?>" name="fGrnDocName"/>
                                       <input type="hidden" value="<?php echo $_REQUEST['id'];?>" name="fPRId"/>
									   
									   <div class="control-group">

                                       <label class="control-label">Remarks</label>

                                       <div class="controls">

                                          <textarea class="large m-wrap" rows="3" cols="60" name="fRemarks"><?php echo (!empty($aItemInfos['quotationinfo']['remarks'])? $aItemInfos['quotationinfo']['remarks']:$aRequest['fRemarks']);?></textarea>

                                       </div>

                                    </div>
                                         <div class="form-actions">
										 
										  <?php if($aRequest['action'] == 'Add')
							{ ?>
							<input type="hidden" name="action" value="Add"/>
							<input type="hidden" name="id" value="<?php echo $aRequest['id'];?>"/>
                       <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Add</button>        
                                       <button type="button" class="btn">Cancel</button>
                         <?php } else if($aRequest['action'] == 'edit'){?>
						 <input type="hidden" name="action" value="edit"/>
						  <input type="hidden" name="id" value="<?php echo $aRequest['id'];?>"/>
						    <input type="hidden" value="<?php echo $aRequest['fQuoteId'];?>" name="fQuoteId"/>
                          <button type="submit" class="btn blue" name="Update"><i class="icon-ok"></i>Save</button>        
                                       <button type="button" class="btn">Cancel</button>
									   <?php } else {?>
									   <input type="hidden" name="action" value="Add"/>
                       <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Add</button>        
                                       <button type="button" class="btn">Cancel</button>
                        <?php } ?>
                                      
                                    </div>
									
																										
                             </form>   
							 </div>
							
                        <!-- END FORM-->           
                     </div>
					 </div>
                  </div>
                  <!-- END SAMPLE FORM PORTLET-->
                
               </div>
			   </div>
            </div>
            <!-- END PAGE CONTENT-->         
      
	<?php include_once 'Footer1.php'; ?>
	

</body>
<!-- END BODY -->
</html>