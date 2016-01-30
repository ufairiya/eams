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
 $aDeliveryList = $oMaster->getDeliveryList('Delivery');
 $DeliveryId = $aRequest['id'];
 $aDeliveryInfo =$oMaster->getDeliveryPrint($DeliveryId);
 $aRequest = $_REQUEST;
  $allResult = $oMaster->getDeliveryList('Receipt');
  $id_delivery_item = $aRequest['id'];
  $ItemList  = $oMaster->getDeliveryItemInfoList($id_delivery_item,'delivery');
/* echo '<pre>';
  print_r($allResult);
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
   <title>EAMS|Confirm Delivery</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <meta http-equiv="Cache-control" content="No-Cache">
  <?php include('Stylesheets.php');?>
  <style>
  .chzn-drop { width: 500px !important;}
  .chosen { width: 500px !important;}
  .chzn-container,.chzn-container-single (width: 505px !important;)
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
                    Confirm Delivery
                     
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
                     <li><a href="#">Confirm Delivery</a></li>
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
                                
                                 <?php
							     if(isset($aRequest['msg']))
								 {
							   ?>
							    <div class="alert alert-success">
									<button class="close" data-dismiss="alert"></button>
									<?php
									if($aRequest['msg'] == 'success')
									{
										echo $msg = 'New Delivery Added Successfully';
									}
									else if($aRequest['msg'] == 'updatesucess')
									{
										echo $msg = 'Delivery Updated Successfully';
									}
									else if($aRequest['msg'] =='delsuccess')
									{
										echo $msg = 'Delivery Deleted Successfully';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'This Delivery is parent, so we can not delete';
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
        
            		    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_sample_3" method="post" enctype="multipart/form-data">
						
                        <div class="row-fluid">
                       
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue">
                     <div class="portlet-title">
                        <h4><i class="icon-reorder"></i>Delivery Details</h4>
                        <div class="tools">
                           <a href="javascript:;" class="collapse"></a>
                          
                        </div>
                     </div>
                     <div class="portlet-body form">
                    
                       <div class="row-fluid">
                                       <div class="span12">
                                          <div class="control-group error">
                                             <label class="control-label">Store Delivery No:</label>
                                             <div class="controls" style="width:500px;">
                                              <select class="chosen" data-placeholder="Store Delivery No" tabindex="1" name="fStoreDeliveryId" id="fStoreDeliveryId" onChange="ShowResult(this.value)">
     										    <option value="0"></option>
												  <?php
												 
												  foreach($aDeliveryList as $aDeliveryList)
												  {
												 ?>
												 <option value="<?php echo $aDeliveryList['id_asset_delivery']; ?>" <?php if($DeliveryId == $aDeliveryList['id_asset_delivery']) { echo 'selected=selected' ;}?> ><?php echo $aDeliveryList['issue_no']; ?>&nbsp;&nbsp;From: <?php echo $aDeliveryList['from_storename']; ?>&nbsp;&nbsp;To:<?php echo $aDeliveryList['to_storename']; ?></option>
												 <?php
												  }
												 ?>
                                             </select>
                                              </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       
                                       
                                       
                                        
                                       </div>
                                  <?php if(isset($aRequest['id']))
								  {?>     
                        <div class="form-horizontal form-view">
                                   <h3 class="form-section"></h3>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                              <div class="control-group">
                                              <label class="control-label">Issue Number:</label>
                                             <div class="controls">
                                               <span class="text"><?php echo $aDeliveryInfo['issue_no'];?></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       
                                       <div class="span6 ">
                                          <div class="control-group">
											  <label class="control-label" style="width:100px; text-align:left;">Issue Date:</label>
											  <div class="controls" style="margin-left:60px;">
												   <span class="text"><?php echo date('d-m-Y',strtotime($aDeliveryInfo['issue_date']));?></span>
												 </div>
											  </div>
										   </div>
                                     </div>
                                    <!--/row-->
                                    <div class="row-fluid">
                                       
                                        <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">From Store Address:</label>
                                             <div class="controls">
                                                 <span class="text">
                                                 <input type="hidden" name="fFromStoreId" id="fFromStoreId" value="<?php echo $aDeliveryInfo['from_id_store'];?>"/>
												
												 
                                                 	 <TABLE border="0" cellSpacing="0" cellPadding="0" width="100%" 
align="left">
              <TBODY>
              <TR class="srow">
                <TD  align="left"><FONT size="2"><b><?php echo $aDeliveryInfo['from_address_format']['name'];?></b></FONT></TD></TR>
                <TR class="srow">
                <?php if($aDeliveryInfo['to_address_format']['contact_name']!='') { ?>
                 <TD  align="left"><FONT size="2"><?php echo $aDeliveryInfo['from_address_format']['contact_name'];?></FONT></TD></TR>
                 <?php } ?>
                    <TR class="srow">
                  <TD  align="left"><FONT size="2"><?php echo $aDeliveryInfo['from_address_format']['addr1'];?></FONT></TD></TR>
                  <TR class="srow">
                  <?php if($aDeliveryInfo['to_address_format']['addr2']!='') { ?>
                  <TD  align="left"><FONT size="2"><?php echo $aDeliveryInfo['from_address_format']['addr2'];?></FONT></TD></TR>
                   <?php } ?>
                  <TR class="srow">
                  <?php if($aDeliveryInfo['to_address_format']['addr3']!='') { ?>
                   <TD  align="left"><FONT size="2"><?php echo $aDeliveryInfo['from_address_format']['addr3'];?></FONT></TD></TR>
                   <TR class="srow">
                   <?php } ?>
                    <TD  align="left"><FONT size="2"><?php echo  $aDeliveryInfo['from_address_format']['city_name'].'-'.$aDeliveryInfo['from_address_format']['zipcode'];?></FONT></TD></TR>
              </TBODY>
              </TABLE></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
									   <div class="span6 ">
                                          <div class="control-group">
											  <label class="control-label" style="text-align:left;">To Address:</label>
											  <div class="controls" style="margin-left:60px;">
												   <span class="text">
                                                    <input type="hidden" name="fToStoreId" value="<?php echo $aDeliveryInfo['to_id_store'];?>"/>
													 <input type="hidden" name="fToVendorId" value="<?php echo $aDeliveryInfo['to_id_vendor'];?>"/>
													  <input type="hidden" name="fDeliveryType" value="<?php echo $aDeliveryInfo['delivery_type'];?>"/>
                                                    <TABLE border="0" cellSpacing="0" cellPadding="0" width="100%" 
align="left">
              <TBODY>
              <TR class="srow">
                <TD  align="left"><FONT size="2"><b><?php echo $aDeliveryInfo['to_address_format']['name'];?></b></FONT></TD></TR>
                <TR class="srow">
                <?php if($aDeliveryInfo['to_address_format']['contact_name']!='') { ?>
                 <TD  align="left"><FONT size="2"><?php echo $aDeliveryInfo['to_address_format']['contact_name'];?></FONT></TD></TR>
                     <?php } ?>
                     <TR class="srow">
                  <TD  align="left"><FONT size="2"><?php echo $aDeliveryInfo['to_address_format']['addr1'];?></FONT></TD></TR>
                  <TR class="srow">
                  <?php if($aDeliveryInfo['to_address_format']['addr2']!='') { ?>
                  <TD  align="left"><FONT size="2"><?php echo $aDeliveryInfo['to_address_format']['addr2'];?></FONT></TD></TR>
                   <?php } ?>
                   <TR class="srow">
                  <?php if($aDeliveryInfo['to_address_format']['addr3']!='') { ?>
                   <TD  align="left"><FONT size="2"><?php echo $aDeliveryInfo['to_address_format']['addr3'];?></FONT></TD></TR>
                   <?php } ?>
                   <TR class="srow">
                    <TD  align="left"><FONT size="2"><?php echo  $aDeliveryInfo['to_address_format']['city_name'].'-'.$aDeliveryInfo['to_address_format']['zipcode'];?></FONT></TD></TR>
              </TBODY>
              </TABLE></span>
												 </div>
											  </div>
										   </div>
                                    </div>
                                    <!--/row-->        
        <h3 class="form-section"> </h3>                             
     <h3 > Delivery Item Details</h3>
     <div class="row-fluid">
     <table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>SLNO</th>
                                             <th>Asset Number</th>
											<th>Particulars</th>
                                            <th>Quantity</th>
                                            <th>Uom</th>
											  
                                           
                                         	</tr>
									</thead>
									<tbody>
                                    <?php 
									$i = 1;
									
									foreach($aDeliveryInfo['DeliveryItem'] as $aDeliveryItem)
                                       {    
									   ?>
                                    <tr>
                                    <td><?php echo $i;?></td>
                                    <td> <input  type="checkbox" name="fAssetItemId[]" value="<?php echo $aDeliveryItem['id_asset_item'];?>"/><?php echo $aDeliveryItem['asset_no'];?></td>
                                    <td><?php echo $aDeliveryItem['itemgroup1_name'].'-'.$aDeliveryItem['itemgroup2_name'].'-'.$aDeliveryItem['item_name'];?></td>
                                    <td><?php echo $aDeliveryItem['issue_quantitiy'];?></td>
                                    <td><?php echo $aDeliveryItem['uom_name'];?></td>
									
                                    </tr>
                                    <?php $i++; } ?> 
                                    </tbody>
                                    </table>
                 </div>  
                      <div class="row-fluid">
                                       <div class="span12 ">
                                              <div class="control-group">
                                              <label class="control-label">Remarks:</label>
                                             <div class="controls">
                                               <span class="text">  <?php echo $aDeliveryInfo['remark'];?></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                 
                   </div>
                   <div class="control-group">

                                       <label class="control-label">Select Receiver Name</label>

                                       <div class="controls">

                                        <select class="large m-wrap" tabindex="1" name="fReceiverEmployeeId" id="fEmployeeId">

											<option value="0">Choose Receiver Name</option>

											<?php

											  $aEmployeeList = $oMaster->getEmployeeList();

											  foreach($aEmployeeList as $aEmployee)

											  {
											  ?>

                                             <option value="<?php echo $aEmployee['id_employee']; ?>" <?php if($edit_result['approved_by'] == $aEmployee['id_employee']) { echo 'selected=selected' ;}?>><?php echo $aEmployee['employee_name']; ?></option>

                                             <?php

											  }

											 ?>

                                          </select>
											<span><a href="#" class="employee" title="Add New Employee"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                       </div>

                                    </div>
									
					<h3 class="form-section"> </h3> 
         			 <div class="row-fluid">              
                          <div class="control-group">
                                       <label class="control-label">Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" id="fStatus" value="16"  />
                                          Delivery Received
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" id="fStatus" value="17"  />
                                         Cancel
                                          </label> 
                                         
                                       </div>
                                       </div> 
                     	</div>    
                     
                	<div class="form-actions">
                					   <input type="hidden" name="fConId" value="<?php echo $aRequest['id'];?>"/>
                                       <button type="submit" class="btn blue" name="update" id="submitButton"><i class="icon-ok"></i> Update</button>
                                       
                                    </div>                                       
                                 </div>
                                   <?php } ?>
                        <!-- END FORM-->           
                     </div>
                  </div>
                  <!-- END SAMPLE FORM PORTLET-->
               </div>
            </div>	
            </form>
            <!-- BEGIN PAGE CONTENT-->
									<div class="row-fluid">
									<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-globe"></i>Delivery Received List</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>SLNO</th>
                                            <th>Issue Number</th>
                                            <th>Issue Date</th>
                                          	<th>From Store</th>
                                            <th>To store</th>
                                             <th>To Vendor</th>
                                            <th>Delivery Type </th>
                                            <th>Status</th>
                                          	<th>Action</th>	
										</tr>
									</thead>
									<tbody>
                                    	<?php 
										$a = 1;
										foreach ($allResult as $item){ ?>
                                       
										<tr class="odd gradeX">
											<td><?php echo $a; ?></td>
                                           <td><?php echo $item['issue_no']; ?></td>
                                            <td><?php echo date('d/m/Y',strtotime($item['issue_date'])); ?></td>
                                           	<td><?php echo $item['from_storename']; ?></td>
                                           <td><?php echo $item['to_storename']; ?></td>
                                             <td><?php echo $item['vendor_name']; ?></td>
                                            <td><?php echo $item['delivery_type']; ?></td>
                                            <td><?php echo $oUtil->AssetItemStatus($item['status']);?></td>
                                          	<td>
                                            
                                            <?php if($item['status'] =='1')
											{?>
                                             <a href="StoreDelivery.php?id=<?php echo  $item['id_asset_delivery']; ?>&action=edit"  class="btn mini purple icn-only"><i class="icon-edit"></i></a> &nbsp; &nbsp;
                                            
                                            <a  href="javascript:void()" onclick=deleteBox(<?php echo  $item['id_asset_delivery']; ?>) class="btn mini red icn-only"><i class="icon-remove icon-white"></i></a> &nbsp;&nbsp;
                                            <?php /*?> <a href="ConfirmDelivery.php?id=<?php echo  $item['id_asset_delivery']; ?>"  class="btn mini purple"><i class="icon-edit"></i>Confirm Delivery</a> &nbsp; &nbsp;<?php */?>
                                           
                                            <?php } ?>
											<?php if($item['delivery_type'] == 'ESD' && $item['bill_count'] > 0)
											{
											
											?>
                                             <a href="javascript:void()" class="btn mini purple" onclick=ModalPopupsConfirm(<?php echo $item['id_asset_delivery'];?>)><i class="icon-edit"></i>Add Bill</a>
											 <?php } ?>
                                            
                                            <form action='StoreDeliveryView.php' target="_blank" method='post' enctype='multipart/form-data'><input type='hidden' name='AssetDeliveryId' value="<?php echo  $item['id_asset_delivery']; ?>"/>
                                              <button type='submit' class="btn mini purple" style="height: 20px; margin-top:10px;" >Print</button></form>   
                                           
                                           
                                            </td>
                                          
										</tr>
                                        <?php $a++;}?>
										
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
									</div>
                                    
                                     
									
                                </div>
				
									<!-- END PAGE CONTENT-->
            </div>
            <!-- END PAGE CONTENT-->         
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
	
	function ShowResult(id)
			{
				
			url = document.URL.split("?")[0];
			var dropresult = addParam(url, "id",id);	
			
				window.location.href = dropresult;
			
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

$('#submitButton').on('click', function(e){
	var id = $('#fStoreDeliveryId option:selected').val();
	var status = $('input[name=fStatus]:checked').val();
	var emp = $('#fEmployeeId option:selected').val();
	var storeid = $('#fFromStoreId').val();
	var delivery_type = $('input[name=fDeliveryType]').val();
		var to_store = $('input[name=fToStoreId]').val();
	
	 var assets = new Array();
				$("input[name='fAssetItemId[]']:checked").each(function(){
					var assets1 = $(this).val();
				   assets.push(assets1);	
			});

	   var dataString = 'action=confirm&fStoreDeliveryId='+id+'&fStatus='+status+'&fReceiverEmployeeId='+emp+'&fAssetItemId='+assets+'&fFromStoreId='+storeid+'&fDeliveryType='+delivery_type+'&fToStoreId='+to_store;
 	$.ajax({
			   type: "POST",
			   url: "ajax/form.php",
			   data: dataString,
			   cache: false,
			   success: function(result){
			    if(result == 1)
				 {
					 if(delivery_type == 'ESD')
					 {					 
					 ModalPopupsConfirm(id);
					 }
					 else
					 {
					 window.location.href="ConfirmDelivery.php?msg=updatesucess";
					 }
				 }
				 else
				 {
					 url = document.URL.split("?")[0];
					var resultss = addParam(url, "msg", "error");	
					window.location.href = resultss;
						
				 }
				}
			});
        e.preventDefault();
       
    });

function ModalPopupsConfirm(id ) {

    ModalPopups.Confirm("idConfirm1",
        "Confirm Add Bill Entry",
        "<div style='padding: 25px;'>Would You Like to Add Bill For this ESD.<br/><br/><b>Are you sure?</b></div>", 
        {
            yesButtonText: "Yes",
            noButtonText: "No",
            onYes: "ModalPopupsConfirmYes("+id+")",
            onNo: "ModalPopupsConfirmNo()"
			
        }
    );
}
function ModalPopupsConfirmYes(id) {
	window.location.href="BillEntryEdit.php?action=bill&id="+id;
    ModalPopups.Close("idConfirm1");
}
function ModalPopupsConfirmNo() {
	window.location.href="ConfirmDelivery.php?msg=updatesucess";
     ModalPopups.Cancel("idConfirm1");
}


</script>  
</body>
<!-- END BODY -->
</html>