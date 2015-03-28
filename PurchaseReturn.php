<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  
 $allResult = $oMaster->getPurchaseReturnList();
	 $oAssetDepartment = &Singleton::getInstance('Department');
  $oAssetDepartment->setDb($oDb);
  $oAssetVendor = &Singleton::getInstance('Vendor');
  $oAssetVendor->setDb($oDb);
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Purchase Return </title>
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
		 
									<div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN STYLE CUSTOMIZER -->
                 
                  <!-- END STYLE CUSTOMIZER -->  
                  <h3 class="page-title">
                     PurchaseReturn 
                     <small>PurchaseReturn master</small>
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
                     <li><a href="#">Purchase Return</a></li>
                  </ul>
               </div>
            </div>
								 
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
										echo $msg = 'New Purchase Return Added Successfully';
									}
									else if($aRequest['msg'] == 'approvesuccess')
									{
										echo $msg = 'Purchase Return Approved Successfully';
									}
									else if($aRequest['msg'] == 'unsuccess')
									{
										echo $msg = 'Purchase Return Unapproved Successfully';
									}
									
									else if($aRequest['msg'] == 'updatesucess')
									{
										echo $msg = 'Purchase Return Updated Successfully';
									}
									else if($aRequest['msg'] =='delsuccess')
									{
										echo $msg = 'Purchase Return Deleted Successfully';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'This Unit is parent, so we can not delete';
									}
									else if($aRequest['msg'] =='forcesuccess')
									{
										echo $msg = 'Purchase Return froce closed Successfully';
									}
									else if($aRequest['msg'] =='unforcesuccess')
									{
										echo $msg = 'Purchase Return Not Closed';
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
						
									<h4><i class="icon-globe"></i>Purchase Return Master</h4>
								
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>SLNO</th>
                                            <th>PurchaseReturn ID</th>
											 <th>Date</th>
											<th>Vendor Name</th>
											<th>GRN Number</th>
											<th>Po Number</th>
                                            <th>Po Type</th>
											<th>Status</th>
                                            <th>Print View</th>
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
											<td><?php echo $item['rtn_number']; ?></td>
											<td><?php echo date('d/m/Y',strtotime($item['date'])); ?></td>
												<td><?php 
											    $avendorInfo = $oAssetVendor->getVendorInfo($item['id_vendor'], 'id');
											    echo $avendorInfo['vendor_name']; 
											?></td>
											<td><?php echo $item['grn_number']; ?></td>
											<td><?php echo $item['po_number']; ?></td>
											<td><?php 
											if( $item['id_pr'] == 0)
											{
											echo 'General';
											}
											else
											{
											echo 'Purchase Request';
											} ?></td>
                                         
											<td><?php echo $oUtil->AssetItemStatus($item['status']);?></td>
                                                                                    
                                            <td> 
                                              <a class="fancybox fancybox.iframe" href="PurchaseReturnView.php?id=<?php echo  $item['id_purchase_return']; ?>&action=view">Print View</a>
                                            
                                            <?php /*?><form action='PurchaseReturnView.php' target="_blank" method='post' enctype='multipart/form-data'><input type='hidden' name='purchaseReturnId' value="<?php echo  $item['id_purchase_return']; ?>"/>
                                              <button type='submit' class="btn mini purple" style="height: 20px;">Print View</button></form> <?php */?></td>
                                              <td>
                                                  <a  class="btn mini purple" href="javascript:void()" onclick=ModalPopupsAlert(<?php echo $item['id_purchase_return'];?>)><i class="icon-edit"></i>View Return Item</a>                                    
                                           <div class="flash" id="flash_<?php echo  $item['id_purchase_return']; ?>"></div>
                                          
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
			 var dataString = 'data=PurchaseReturndelete&pid='+ id;
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
	function deleteBox(id)
	{
	  if (confirm("Are you sure you want to delete this record?"))
	  {
		var dataString = 'data=PurchaseReturndelete&id='+ id;
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
function ModalPopupsAlert(id_purchase_return) {
  var dataString = 'action=PurchaseReturnInfo&id_purchase_returns='+id_purchase_return;
 			
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
        "Purchase Return",
		   "<div id='StockReport'  style='overflow:auto; height:300px;padding: 10px;'></div><div style='padding: 25px;'><b>Are you sure you want to close?</b></div>", 
		           {
			
          
			width: 800,  
            height: 200
			
        }
    );
	 
}
  

</script>
</body>
<!-- END BODY -->
</html>