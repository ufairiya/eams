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
  
 if(isset($aRequest['send']))
 {
  if($result = $oMaster->addAssignVendorToPr($aRequest))
	{
	   
		 echo '<script type="text/javascript">window.location.href="PrVendorMapEdit.php?id='.$result.'&msg=success";</script>';
	}
	else
	{
	echo '<script type="text/javascript">window.location.href="PrVendorMapEdit.php?id='.$result.'&msg=unsuccess";</script>';
	}
	
	
 } 
if(isset($aRequest['id']))
{
  
	$item_id = $aRequest['id'];
	$edit_result = $oMaster->getPurchaseRequestInfo($item_id,'id');
	 $aItemInfo  = $oMaster->getPurchaseRequestItemInfo($item_id,'id');
	$aAssignVendorInfo = $oMaster->getAssignVendorToPrInfo($item_id,'id');
	
}
 foreach( $aItemInfo['iteminfo'] as $itemInfo)
{
$aItems = array($itemInfo['id_itemgroup1']);

}
$aIG = implode(",",$aItems);
  /*$aVendorItemGroup1 =  $oAssetVendor->getAllVendorInfos($aIG);
         echo '<pre>';
		 print_r($aIG);
  print_r($aVendorItemGroup1 );
   echo '</pre>';
   exit();*/
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Assign Vendor</title>
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
                     Assign Vendor
                     <small>Purchase Master</small>
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
                     <li><a href="#">Assign Vendor</a></li>
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
										echo $msg = 'Vendor Assign Successfully';
									}
									else if($aRequest['msg'] == 'unsuccess')
									{
										echo $msg = 'Vendor Assign UnSuccessfully';
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
            <div class="row-fluid">
               <div class="span12">
               <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue">
                     <div class="portlet-title">
                      <?php if($aRequest['action'] == 'edit')
							{ ?>
                         <h4><i class="icon-reorder"></i>Edit Assign Vendor</h4>
                         <?php } else {?>                      
                           <h4><i class="icon-reorder"></i>Create Assign Vendor</h4>
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
                       
                                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_sample_3" method="post">
									    <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
                           
                                      
                                  <?php /*?>  <div class="row-fluid">
									
									<div class="span6 ">
                                     <div class="control-group">
                                       <label class="control-label">Select Purchase Request<span class="required">*</span></label>
                                       <div class="controls">
                                        <select class="large m-wrap" tabindex="1" name="fPRId" id="fPRId" onChange="ShowResult(this.value);">
											 <option value="0">Choose a Purchase Request</option>
											 <?php
											  $aPurchaseRequestList = $oMaster->getPurchaseRequestStatus();
											  foreach($aPurchaseRequestList as $aPurchaseRequest)
											  {
											 ?>
                                             <option value="<?php echo $aPurchaseRequest['id_pr']; ?>" <?php if($aRequest['id'] == $aPurchaseRequest['id_pr']) { echo 'selected=selected' ;}?>><?php echo $aPurchaseRequest['pr_no']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                       </div>
                                    </div>
                                    </div>
                                    </div><?php */?>
									<div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group error">
                                          
                                               <label class="control-label">Purchase Request No:</label>
                                             <div class="controls">
                                               <span class="text"><b><?php echo $edit_result['request_no'];?></b><input type="hidden" name="fPRId" id="fPRId" value="<?php echo $edit_result['id_pr'];?>"/></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       </div>
                                     <div class="control-group">
                                      <label class="control-label">Select Vendor</label>
                                       <div class="controls">
                                       <select class="large m-wrap" tabindex="3" name="fVendorId[]" id="fVendorId" multiple="multiple">
											 <?php
											  $avendorList = $oAssetVendor->getAllVendorInfos($aIG);
											
											 ?>
                                             <option value="0">Choose the Supplier</option>
                                             <?php  foreach($avendorList as $aVendor)
											  {
												  ?>
                                             <option value="<?php echo $aVendor['id_vendor']; ?>"><?php echo $aVendor['vendor_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select> <!--<span><a href="#" class="vendor" title="Add New Vendor"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>-->
                                             </div>
                                   		 </div>
										  <?php if(!empty($aAssignVendorInfo))
										 {?>  
										   <h3 class="form-section">Assigned Vendors</h3>
										 <div class="row-fluid">  
										 
										   <table id="purchaseItems" name="purchaseItems" class="table table-striped table-bordered table-hover">
								<tr>
											 <th>SLNO</th>
											 <th>Vendor Name</th>
											  <th>Status</th>
											  <th>Print</th>
											 
                                           
								</tr>
								<?php
								$a = 1; 
                              	  foreach( $aAssignVendorInfo as $aAssignVendor)
	                              {
								  
	                             ?>
								 <tr>
								  <td><?php echo $a;?></td>
								  <td><?php echo $aAssignVendor['vendor_name'];?></td>
								 <td><?php echo $oUtil->AssetItemStatus($aAssignVendor['status']);?></td>
								 <td>
								   <a href="PurchaseRequestView.php?id=<?php echo  $aAssignVendor['id_pr']; ?>&vendorId=<?php echo $aAssignVendor['id_vendor'];?>" class="btn mini purple" target="_blank">Print View</a> &nbsp;&nbsp;
								     <a href="PurchaseRequestPDF.php?id=<?php echo  $aAssignVendor['id_pr']; ?>&vendorId=<?php echo $aAssignVendor['id_vendor'];?>" class="btn mini purple" target="_blank">Download PDF</a> 
								
								</td>
								   </tr>
	                         <?php $a ++;} ?>					
                                  </table>
								
								</div>
								<?php } ?>
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
                                           
								</tr>
                                
                              		<?php 
                              	  foreach( $aItemInfo['iteminfo'] as $itemInfo)
	                              {
	                             ?>
	 <tr>
	  <td><?php echo $itemInfo['itemgroup1_name'];?></td>
	  <td><?php echo $itemInfo['itemgroup2_name'];?></td>
	   <td><?php echo $itemInfo['item_name'];?></td>
	    <td><?php echo $itemInfo['uom_name'];?></td>
	 <td><?php echo $itemInfo['qty'];?></td>
	 <td><?php echo $itemInfo['unit_cost'];?></td>
	 
	  </tr>
	 <?php } ?>					
                                  </table>
                                 
                                 
                                
                                   </div>
								   <?php } ?>
                    <div class="form-actions">
					 <button type="submit" class="btn blue" id="sends" name="send"><i class="icon-ok"></i>Assign Vendor</button>       						
					<?php /*?>	<a href="QuotationList.php?id=<?php echo $item_id; ?>" class="btn blue"><i class="m-icon-swapleft"></i></i>Go Back </a><?php */?>
					<a href="PurchaseRequest.php" class="btn blue"><i class="m-icon-swapleft m-icon-white"></i></i> Go To Purchase Request </a>
						<a href="QuotationList.php?id=<?php echo $item_id; ?>" class="btn blue"><i class="m-icon-swapright m-icon-white"></i></i> View Quotation List </a>
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
<script type="text/javascript" >
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
function ShowResult(id)
			{
			
			url = document.URL.split("?")[0];
			var dropresult = addParam(url, "id",id);	
			window.location.href = dropresult;
			}
</script>
</body>
<!-- END BODY -->
</html>