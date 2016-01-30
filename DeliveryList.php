<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $allResult = $oMaster->getDeliveryList();
  $edit_result = $oMaster->getDeliveryItemInfoList($item_id,'delivery');
  //echo '<pre>';
  //print_r($allResult);
 /* foreach($allResult as $item)
  {
	  $edit_result = $oMaster->getDeliveryItemInfoList($item['id_asset_delivery'],'delivery');
	   print_r($edit_result);
  }*/
 
  //echo '</pre>';
  $id_delivery_item = $aRequest['id'];
  $ItemList  = $oMaster->getDeliveryItemInfoList($id_delivery_item,'delivery');
 
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Delivery List </title>
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
                     Stock  
                     <small>Stock master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Delivery</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Delivery </a></li>
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
                              
                                
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            
            <!-- BEGIN PAGE CONTENT-->
									<div class="row-fluid">
									<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-globe"></i>Delivery Master</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="btn-group">
                                <a href="StoreDelivery.php?action=Add"  role="button" class="btn green" data-toggle="modal">Add New <i class="icon-plus"></i></a>								
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>SLNO</th>
                                            <th>Issue Number</th>
                                            <th>Issue Date</th>
                                          	<th>Asset Item</th>
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
                                            <td>
                                              <?php
											    
												  foreach($item['delivery_items'] as $ed)
												  {
													  echo $ed['itemgroup1_name']." : ".$ed['itemgroup2_name']." : ".$ed['item_name'].'<br>';  
												  }
												
											  
											  ?>
                                            
                                            </td>
                                          <!-- 	<td><?php //echo $item['from_storename']; ?></td>
                                           <td><?php //echo $item['to_storename']; ?></td>-->
                                             <td><?php echo $item['vendor_name']; ?></td>
                                            <td><?php echo $item['delivery_type']; ?></td>
                                            <td><?php echo $oUtil->AssetItemStatus($item['status']);?></td>
                                          	<td>
                                            
                                            <?php if($item['status'] =='1' || $item['status'] =='23' )
											{?>
                                             <a href="StoreDelivery.php?id=<?php echo  $item['id_asset_delivery']; ?>&action=edit"  class="btn mini purple icn-only"><i class="icon-edit"></i></a> &nbsp; &nbsp;
                                            
                                            <a  href="javascript:void()" onclick=deleteBox(<?php echo  $item['id_asset_delivery']; ?>) class="btn mini red icn-only"><i class="icon-remove icon-white"></i></a> &nbsp;&nbsp;
                                            <?php /*?> <a href="ConfirmDelivery.php?id=<?php echo  $item['id_asset_delivery']; ?>"  class="btn mini purple"><i class="icon-edit"></i>Confirm Delivery</a> &nbsp; &nbsp;<?php */?>
                                           
                                            <?php } ?>
											<?php if($item['delivery_type'] == 'ESD' && $item['bill_count'] > 0 && 
											$item['status'] !='23')
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
                                    
                                       <?php if(isset($aRequest['id'])){?>
                                    <div class="row-fluid">
                                    <?php } else {?>
                                    <div class="row-fluid" style="display:none;">
                                     <?php } ?>
									<div class="span12">
                                    <div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-globe"></i>Delivery Item Details</h4>
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
											<th>Asset Number</th>
											<th>Item Group 1</th>
											<th>Item Group 2</th>
                                            <th>Item </th>
                                            <th>Issue Quantity </th>
                                            <th>Status</th>
											<th>Action</th>	
										</tr>
									</thead>
									<tbody>
                                    	<?php foreach ($ItemList as $item): ?>
                                       
										<tr class="odd gradeX">
											<td><?php echo $item['asset_no']; ?></td>
											<td><?php echo $item['itemgroup1_name']; ?></td>
											<td><?php echo $item['itemgroup2_name']; ?></td>
                                            <td><?php echo $item['item_name']; ?>&nbsp;<?php echo $item['uom_name'];?></td>
											<td><?php echo $item['issue_quantitiy']; ?></td>
											<td><?php  $status = $item['status']; 
											if($status == 1)
											{
												echo $status = '<span class="label label-success">Active</span>';
											}
											
											?></td>
										 	<td>
                                            
                                            </td>
                                           
                                          
										</tr>
                                        <?php endforeach; ?>
										
									</tbody>
								</table>
							</div>
                				</div>	
                                </div>
                                </div>
				
									<!-- END PAGE CONTENT-->
            
            
            
            <!-- END PAGE CONTENT-->         
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      
      
      <!-- END PAGE -->  
   </div>
   <!-- END CONTAINER -->
   </div>
	<?php include_once 'Footer1.php'; ?>
	<link href="modalbox/SyntaxHighlighter.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="modalbox/shCore.js" language="javascript"></script>
    <script type="text/javascript" src="modalbox/shBrushJScript.js" language="javascript"></script>
    <script type="text/javascript" src="modalbox/ModalPopups.js" language="javascript"></script>
    <script type="text/javascript">

function ModalPopupsConfirm(asset_delivery_id ) {
 var dataString = 'action=StoreDeliveryInfo&storedeliveryid='+asset_delivery_id;
 			
 $.ajax({
			   type: "POST",
			   url: "ajax/form.php",
			   data: dataString,
			   cache: false,
			   success: function(result){
				$("#StockReport").html(result);
				
				}
			});
  ModalPopups.Confirm("idConfirm1",
        "Add Bill",
		   "<div id='StockReport'  style='overflow:auto; height:300px;padding: 10px;'></div><div style='padding: 25px;'><b>Are you sure you want to Add bill?</b></div>", 
        {
            yesButtonText: "Yes",
            noButtonText: "No",
            onYes: "ModalPopupsConfirmYes("+asset_delivery_id+")",
            onNo: "ModalPopupsConfirmNo()",
				width: 800,  
            height: 200
        }
    );
}
function ModalPopupsConfirmYes(asset_delivery_id) {
var status = $('input[name=fDeliverystatus]').val();
if(status !=1)
{
window.location.href="BillEntryEdit.php?action=bill&id="+asset_delivery_id;
}
else
{
window.location.href="ConfirmDelivery.php?id="+asset_delivery_id;

}	
    ModalPopups.Close("idConfirm1");
}
function ModalPopupsConfirmNo() {
	
     ModalPopups.Cancel("idConfirm1");
}
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
	
	function deleteBox(id)
	{
	  if (confirm("Are you sure you want to delete this record?"))
	  {
		var dataString = 'data=Deliverylist&Did='+ id;
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
</body>
<!-- END BODY -->
</html>