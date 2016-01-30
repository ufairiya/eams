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
 
   
  if(isset($aRequest['Update']))
  {
    if($oMaster->addBillEntry($aRequest, $_FILES))
	{
	  $msg = "New Maintenance Updated.";
	  echo '<script type="text/javascript">window.location.href="Maintenance.php?msg=updatesucess";</script>';
	}
	else $msg = "Sorry";
  } //update
 
  if($aRequest['action'] == 'bill')
  {
	$item_id = $aRequest['id'];
	$aStoreDeliveryInfo = $oMaster->getDeliveryInfo($item_id);
	$aStoreDeliveryItemList =  $oMaster->getDeliveryItemLists($item_id,'delivery');
	 
  } //edit
/* echo '<pre>';
  print_r($aAssetDeliveryDetail );
    print_r($bill_result );
  exit();*/

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Bill Entry</title>
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
                     Bill Entry
                    
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Company</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#"> Bill Entry</a></li>
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
                                    <a href="BillEntry.php" class="btn red mini active">Back to List</a>
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
                     
                         <?php if($aRequest['action'] == 'bill'){?>
                          <h4><i class="icon-reorder"></i>Add Bill</h4>
                     <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit Bill</h4>
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
                       
                                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_sample_3" method="post"  enctype="multipart/form-data">
									    <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
          			<div class="form-horizontal form-view">
                                    <h3 class="form-section">Bill Details</h3>
                                     <div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group error">
                                           
                                               <label class="control-label">Store Delivery Number:</label>
                                             <div class="controls">
                                               <span class="text"><b><?php echo $aStoreDeliveryInfo['issue_no'];?></b></span>
											   <input type="hidden" name="fStoreDeliveryId"  value="<?php echo $aStoreDeliveryInfo['id_asset_delivery'];?>"/>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       </div>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                              <label class="control-label">Store Name:</label>
                                             <div class="controls">
                                               <span class="text"><?php echo $aStoreDeliveryInfo['from_storename'];?></span>
											   <input type="hidden" name="fFromstoreId"  value="<?php echo $aStoreDeliveryInfo['from_id_store'];?>"/>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Vendor Name:</label>
                                             <div class="controls">
                                                 <span class="text"><?php echo $aStoreDeliveryInfo['vendor_name'];?></span>
												 <input type="hidden" name="fVendorId"  value="<?php echo $aStoreDeliveryInfo['to_id_vendor'];?>"/>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
									   </div>
									   <div class="row-fluid">
									   <div class="span6 ">
                                          <div class="control-group">
											  <label class="control-label">Start Date:</label>
											  <div class="controls" >
												   <span class="text"><?php echo date('d-m-Y',strtotime($aStoreDeliveryInfo['issue_date']));?></span>
												 </div>
											  </div>
										   </div>
                                       </div>
                                       <!--/span-->
									   
									
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                              <label class="control-label">Bill Number</label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap " placeholder="Bill Number" name="fBillNumber">
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
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fBillDate"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
										   </div>
                                       </div>
                                         </div>
									   
									    <div class="row-fluid">
									   <div class="span6 ">
                                          <div class="control-group">
                                              <label class="control-label">Bill Total Amount</label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap " placeholder="Bill Total Amount" name="fBillTotalAmount">
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
									 							      
                                    </div>  
									
									  <h3 > Delivery Item Details</h3>
                                      <div class="row-fluid">
     <table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>SLNO</th>
                                           	<th>Particulars</th>
                                            <th>Bill Amount</th>
                                            <th>Add to Depreciation</th>
                                           
                                         	</tr>
									</thead>
									<tbody>
                                    <?php 
									$i = 1;
									foreach($aStoreDeliveryItemList as $aDeliveryItem)
                                       {    ?>
                                    <tr>
                                    
                                    <td><?php echo $i;?><input  type="hidden" name="fAssetItemId[]" value="<?php echo $aDeliveryItem['id_asset_item'];?>"/></td>
                                   <td><?php echo $aDeliveryItem['itemgroup1_name'].'-'.$aDeliveryItem['itemgroup2_name'].'-'.$aDeliveryItem['item_name'];?></td>
                                    <td><input type="text" class="m-wrap " placeholder="Bill Amount" name="fBillAmount[]"></td>
                                    <td> <input type="checkbox" class="m-wrap"  name="fForDepreciation[]" value="<?php echo $aDeliveryItem['id_asset_item'];?>"></td>
                                    </tr>
                                    <?php $i++; } ?> 
                                    </tbody>
                                    </table>
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
                                      <input type="file" name="fUploadDocument"/>
                                        </span>
                                       <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
									 
									   
                                    </div>
                                 </div>
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
                                                <textarea class="large m-wrap" tabindex="18" rows="3" name="fRemarks"><?php echo $aFuelInfo['remarks'];?></textarea>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       
                                       
                                    </div>
                                    <div class="form-actions">
                                       <button type="submit" class="btn blue" name="Update"><i class="icon-ok"></i>Add Bill</button> 
									   <button type="button" class="btn">Cancel</button>
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
	
	  function getItemList(id)
		{
			//var id = $("#fFromStoreId").val();
		      	var dataStr = 'action=getItemList&fromstoreId='+id;
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				  $("#ItemList").html(result);
				
				 
			   }
          });
			}
	
		 
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
		 
		 	var dataStr = 'action=getGroupItemList1&Group1Id='+id+'&StoreId='+storeId;
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
			        $("#ItemsList").html(result);
				 
			   }
         
		  
		 });
		
		  
		 
		 }
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
			
			function ShowResult(id)
			{
			url = document.URL.split("?")[0];
			var dropresult = addParam(url, "asset",id);	
			var dropresult = addParam(dropresult, "action",'Add');	
			window.location.href = dropresult;
			}
			</script>
</body>
<!-- END BODY -->
</html>