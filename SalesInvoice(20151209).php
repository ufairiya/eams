<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $allResult = $oMaster->getSalesInvoiceList();
  $id_salesInvoice = $aRequest['id'];
  //$ItemList  = $oMaster->getSalesInvoiceItemInfoList($id_salesInvoice,'delivery');
 /* echo '<pre>';
  print_r( $ItemList );
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
   <title>EAMS| Sales Invoice List </title>
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
                    Sales  
                     <small>Sales master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Sales Invoice</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Sales Invoice </a></li>
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
										echo $msg = 'New Sales Invoice Added Successfully';
									}
									else if($aRequest['msg'] == 'updatesucess')
									{
										echo $msg = 'Sales Invoice Updated Successfully';
									}
									else if($aRequest['msg'] =='delsuccess')
									{
										echo $msg = 'Sales Invoice Deleted Successfully';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'This Sales Invoice is parent, so we can not delete';
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
								<h4><i class="icon-globe"></i>Sales Invoice Master</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="btn-group">
                                <a href="SalesInvoiceEdit.php?action=Add"  role="button" class="btn green" data-toggle="modal">Add New <i class="icon-plus"></i></a>								
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>SLNO</th>
                                            <th>Issue Number</th>
                                            <th>Issue Date</th>
                                          	<th>From Company</th>
                                            <th>To Vendor</th>
                                            <th>Delivery Type </th>
											 <th>Delivery Number</th>
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
                                           <td><?php echo $item['invoice_number']; ?></td>
                                            <td><?php echo date('d/m/Y',strtotime($item['invoice_date'])); ?></td>
                                           	<td><?php echo $item['company_name']; ?></td>
                                            <td><?php echo $item['vendor_name']; ?></td>
                                            <td><?php echo $item['delivery_type']; ?></td> 
											 <td><a href="StoreDeliveryView.php?id=<?php echo $oUtil->encode($item['id_asset_delivery']);?>" target="_blank"><?php echo $item['delivery_number']; ?></a></td>
										    <td><?php echo $oUtil->AssetItemStatus($item['status']);?></td>
                                          	<td>
                                            
                                            <?php if($item['status'] =='1')
											{?>
                                             <a href="SalesInvoice.php?id=<?php echo  $item['id_asset_delivery']; ?>&action=edit"  class="btn mini purple icn-only"><i class="icon-edit"></i></a> &nbsp; &nbsp;
                                            
                                            <a  href="javascript:void()" onclick=deleteBox(<?php echo  $item['id_asset_delivery']; ?>) class="btn mini red icn-only"><i class="icon-remove icon-white"></i></a> &nbsp;&nbsp;
                                            <?php /*?> <a href="ConfirmDelivery.php?id=<?php echo  $item['id_asset_delivery']; ?>"  class="btn mini purple"><i class="icon-edit"></i>Confirm Delivery</a> &nbsp; &nbsp;<?php */?>
                                           
                                            <?php } ?>
                                            <a href="?id=<?php echo  $item['id_asset_delivery']; ?>" class="btn mini purple"><i class="icon-edit"></i>View</a>
                                            
                                            <a href="SalesInvoiceView.php?id=<?php echo  $item['id_asset_delivery']; ?>" class="btn mini purple">Print</a>
                                            
                                            <!--<form action='SalesInvoiceView.php' target="_blank" method='post' enctype='multipart/form-data'><input type='hidden' name='AssetDeliveryId' value="<?php //echo $item['id_asset_delivery']; ?>"/>
                                              <button type='submit' class="btn mini purple" style="height: 20px; margin-top:10px;" >Print</button></form>-->   
                                           
                                           
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
                                    
                                       
         <!-- END PAGE CONTAINER-->
      </div>
      </div>
	  </div>
      
      <!-- END PAGE -->  
   </div>
   <!-- END CONTAINER -->
	<?php include_once 'Footer1.php'; ?>
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
	
	function deleteBox(id)
	{
	  if (confirm("Are you sure you want to delete this record?"))
	  {
		var dataString = 'deliverydata=Deliverylist&Did='+ id;
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