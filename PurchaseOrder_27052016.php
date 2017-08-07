<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  	if(isset($aRequest['action'] )) 
	{
		 $allResult = $oMaster->getPurchaseOrderList(null,$aRequest['action']);
	}
	else
	{
      $allResult = $oMaster->getPurchaseOrderList();
	}
  $oAssetDepartment = &Singleton::getInstance('Department');
  $oAssetDepartment->setDb($oDb);
  $oAssetVendor = &Singleton::getInstance('Vendor');
  $oAssetVendor->setDb($oDb);
  //echo '<pre>'; print_r($allResult); exit;
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| PurchaseOrder </title>
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
		  <?php if($aRequest['action'] == 'approval') {?>
							 	<div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN STYLE CUSTOMIZER -->
                 
                  <!-- END STYLE CUSTOMIZER -->  
                  <h3 class="page-title">
                     PurchaseOrder Approval
                 
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">PurchaseOrder</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">PurchaseOrder Approval</a></li>
                  </ul>
               </div>
            </div>
							   <?php } else { ?>
									<div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN STYLE CUSTOMIZER -->
                 
                  <!-- END STYLE CUSTOMIZER -->  
                  <h3 class="page-title">
                     PurchaseOrder 
                     <small>PurchaseOrder master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Purchase Request</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">PurchaseOrder</a></li>
                  </ul>
               </div>
            </div>
								  <?php }  ?>  
            <!-- BEGIN PAGE HEADER-->   
            
            
                              <?php
							     if(isset($aRequest['msg']))
								 {
							   ?>
							    <div class="alert alert-success">
									<button class="close" data-dismiss="alert"></button>
									<?php
									if($aRequest['msg'] == 'success')
									{
										echo $msg = 'New PurchaseOrder Added Successfully';
									}
									else if($aRequest['msg'] == 'approvesuccess')
									{
										echo $msg = 'PurchaseOrder Approved Successfully';
									}
									else if($aRequest['msg'] == 'unsuccess')
									{
										echo $msg = 'PurchaseOrder Unapproved Successfully';
									}
									
									else if($aRequest['msg'] == 'updatesucess')
									{
										echo $msg = 'PurchaseOrder Updated Successfully';
									}
									else if($aRequest['msg'] =='delsuccess')
									{
										echo $msg = 'PurchaseOrder Deleted Successfully';
									}
									else if($aRequest['msg'] =='trashsuccess')
									{
										echo $msg = 'PurchaseOrder Moved To Trash Successfully';
									}
									else if($aRequest['msg'] =='error')
									{
										echo $msg = 'Sorry Error occur, try again';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'This PurchaseOrder is parent, so we can not delete';
									}
									else if($aRequest['msg'] =='forcesuccess')
									{
										echo $msg = 'PurchaseOrder froce closed Successfully';
									}
									else if($aRequest['msg'] =='unforcesuccess')
									{
										echo $msg = 'PurchaseOrder Not Closed';
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
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
							 <?php if($aRequest['action'] == 'approval') {?>
							 	<h4><i class="icon-globe"></i>Purchase Order Approval List</h4>
							   <?php } else { ?>
									<h4><i class="icon-globe"></i>Purchase Order Master</h4>
								  <?php }  ?>  
							
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								<?php if($aRequest['action'] != 'approval') {?>
								<div class="clearfix">
                                <div class="btn-group">
                                <a href="PurchaseOrderCreate.php?action=Add&type=General"  role="button" class="btn green" data-toggle="modal">Create New PO <i class="icon-plus"></i></a>								
								<a href ="PoItemReport.php" role="button" class="btn blue" style="margin-left: 2%">PO Item Search</a>	
									</div>
								</div>
								<?php } ?>
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>SLNO</th>
                                            <th>PurchaseOrder ID</th>
											 <th>Date</th>
											<th>Vendor Name</th>
                                            <th>Po Type</th>
											<th>Status</th>
                                            <th>Download PDF</th>
                                             <th>View</th>
											<th>Action</th>	
										</tr>
									</thead>
									<tbody>
                                    	
										<?php 
											$a=1;
										foreach ($allResult as $item){
										 ?>
                                       
										<tr class="odd gradeX">
                                        		<td><?php echo $a; ?></td>
											<td><?php echo $item['po_number']; ?></td>
											<td><?php echo date('d/m/Y',strtotime($item['po_date'])); ?></td>
												<td><?php 
											    $avendorInfo = $oAssetVendor->getVendorInfo($item['id_vendor'], 'id');
											    echo $avendorInfo['vendor_name']; 
											?></td>
											<td><?php 
											if( $item['id_pr'] == 0)
											{
											echo 'General';
											}
											else
											{
											echo 'Purchase Request';
											} ?></td>
                                        <td><?php echo $oUtil->AssetItemStatus($item['status']);?>
										<?php if($item['return_status'] == 1)
										{
										echo '<span class="label label-return ">Purchase Return</span>';
										} ?>
										
										</td>
                                            <td>
											<a  href="PurchaseOrderPDF.php?id=<?php echo  $item['id_po']; ?>&action=view" download="purchaseorders">
											<?php /*?><form action='PurchaseOrderPDF.php' method='post' target="_blank" enctype='multipart/form-data'><input type='hidden' name='purchaseRequestId' value="<?php echo  $item['id_po']; ?>"/><button type='submit' class="btn mini purple" style="height: 20px;">Download PDF</button></form><?php */?>Download PDF
											</a></td>
                                           
                                            <td> 
											<a class="fancybox fancybox.iframe" href="PurchaseOrderView.php?id=<?php echo  $item['id_po']; ?>&action=view">View
											</a>
											<?php /*?><form action='PurchaseOrderView.php' target="_blank" method='post' enctype='multipart/form-data'><input type='hidden' name='purchaseRequestId' value="<?php echo  $item['id_po']; ?>"/>
                                              <button type='submit' class="btn mini purple" style="height: 20px;">View</button></form><?php */?> </td>
                                              <td>
                                                                                  
                                           <div class="flash" id="flash_<?php echo  $item['id_po']; ?>"></div>
                                           <?php if($item['status'] == '1')
											{ 
                                          	if(isset($aRequest['action'] )) 
	                                         {?>
                                            <a href="PurchaseOrderCreate.php?fPurchaseOrderId=<?php echo $item['id_po'];?>&action=edit&submits=approval" class="btn mini purple"><i class="icon-edit"></i>Approve</a>&nbsp;&nbsp; 
                                            
                                            <a  class="delete btn mini black" href="#"><i class="icon-trash"></i>Cancel</a>&nbsp;&nbsp;
											
                                            <?php } else {?>
                                            <?php if($item['status']== '1' || $item['status']== '3' )
										  {?>
                                              <a href="PurchaseOrderCreate.php?fPurchaseOrderId=<?php echo $item['id_po'];?>&action=edit" class="btn mini purple"><i class="icon-edit"></i>Edit</a>               
                                               <?php
											}
											?>
                                             <a  class="btn mini purple" href="javascript:void()" onclick=ModalPopupsAlert(<?php echo $item['id_po'];?>)><i class="icon-edit"></i>Force Close</a> 
											   <?php }  ?> 
                                            <?php } else if($item['status'] != '12'  && $item['status'] != '15' ){ ?> 
                                          
                                            <?php }  ?> 
											
											 <?php if($item['status']==1 || $item['status']==3 )
											{
											?>
                                           
                                            <a  class="delete btn mini black" href="javascript:void()" onclick=deleteBox('<?php echo  $item['id_po']; ?>','podelete','Move')><i class="icon-trash"></i>Delete</a>                                              
                                            <?php } ?>
											
                                            </td>
                                          
										</tr>
                                        <?php $a++; }  ?>
										
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
									</div>
                                  
                                    
            
            <!-- END PAGE CONTENT-->     
         </div>
         <!-- END PAGE CONTAINER-->
     
      <!-- END PAGE -->  
   </div></div></div>
   <!-- END CONTAINER -->
	 <!-- BEGIN JAVASCRIPTS -->    
   <!-- Load javascripts at bottom, this will reduce page load time -->
<?php include('Footer1.php');?>
  
   
   <!-- END JAVASCRIPTS -->  
    <link href="modalbox/SyntaxHighlighter.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="modalbox/shCore.js" language="javascript"></script>
    <script type="text/javascript" src="modalbox/shBrushJScript.js" language="javascript"></script>
    <script type="text/javascript" src="modalbox/ModalPopups.js" language="javascript"></script>
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
			 var dataString = 'data=PurchaseOrderdelete&pid='+ id;
			 $.ajax({
           type: 'POST',
           url: 'ajax/ajax.php',
           data: dataString,
           cache: false,
           success: function(result){
                if(result){
					if(result !=0)
						{
							alert("Item Deleted");
						}
					
					     }
            }
        });
			}
	
function ModalPopupsAlert(id_po) {
  var dataString = 'action=PurchaseOrderInfo&id_pos='+id_po;
 			
 $.ajax({
			   type: "POST",
			   url: "ajax/ajax.php",
			   data: dataString,
			   cache: false,
			   success: function(result){
				$("#StockReport").html(result);
				
				}
			});
	 ModalPopups.Confirm("idConfirm1",
        "Force Close Purchase Order",
		   "<div id='StockReport'  style='overflow:auto; height:300px;padding: 10px;'></div><div style='padding: 25px;'><b>Are you sure you want to force close?</b></div>", 
		           {
					   
            yesButtonText: "Yes",
            noButtonText: "No",
			width: 800,  
            height: 300,
			/*loadTextFile: "modalbox/TextFile.txt",*/
            onYes: "ModalPopupsConfirmYes("+id_po+")",
		    onNo: "ModalPopupsConfirmNo()"
        }
    );
	 
}
function ModalPopupsConfirmYes(id_po) {
   
   var dataString = 'data=PurchaseOrderclose&id_pos='+id_po;
		
		$("#flash_"+id_po).show();
		$("#flash_"+id_po).fadeIn(400).html('<img src="assets/img/loading.gif"/>');
		$.ajax({
			   type: "POST",
			   url: "update.php",
			   data: dataString,
			   cache: false,
			   success: function(result){
						
					if(result){
					url = document.URL.split("?")[0];
						if(result !=0)
						{
							var resultss = addParam(url, "msg", "approvesuccess");	
							window.location.href = resultss;
						}
						else if(result == 0)
						{
							 var resultss = addParam(url, "msg", "unsuccess");	
							window.location.href = resultss;
						}
						else
						{
							 window.location.href = url;
						}
						
							 }
				}
			});
   
    ModalPopups.Close("idConfirm1");
}
function ModalPopupsConfirmNo() {
   ModalPopups.Cancel("idConfirm1");
}   
	function closeBox(id_po)
	{
		
	 if (confirm("Are you sure you want to Force closed this record?"))
	  {
		var dataString = 'data=PurchaseOrderclose&id_pos='+id_po;
		
		$("#flash_"+id_po).show();
		$("#flash_"+id_po).fadeIn(400).html('<img src="assets/img/loading.gif"/>');
		$.ajax({
			   type: "POST",
			   url: "update.php",
			   data: dataString,
			   cache: false,
			   success: function(result){
					if(result){
					url = document.URL.split("?")[0];
						if(result !=0)
						{
							var resultss = addParam(url, "msg", "forcesuccess");	
							window.location.href = resultss;
						}
						else if(result == 0)
						{
							 var resultss = addParam(url, "msg", "unforcesuccess");	
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
	function approveBox(id_po,id_pr)
	{
		
	
	if (confirm("Are you sure you want to approve this record?"))
	  {
		var dataString = 'data=PurchaseOrderapprove&id_po='+id_po+'&id_pr='+id_pr;
		
		$("#flash_"+id_po).show();
		$("#flash_"+id_po).fadeIn(400).html('<img src="assets/img/loading.gif"/>');
		$.ajax({
			   type: "POST",
			   url: "update.php",
			   data: dataString,
			   cache: false,
			   success: function(result){
					if(result){
					url = document.URL.split("?")[0];
					
						if(result !=0)
						{
							var resultss = addParam(url, "action", "approval");	
							var resultss1 = addParam(resultss, "msg", "approvesuccess");	
							window.location.href = resultss1;
						}
						else if(result == 0)
						{
							 var resultss = addParam(url, "action", "approval");	
							 var resultss1 = addParam(url, "msg", "unsuccess");	
							window.location.href = resultss1;
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