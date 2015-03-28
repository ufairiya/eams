<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  if(isset($aRequest['id']))
  {
   $id_pr  = $aRequest['id'];
  }
  else
  {
  $id_pr = $aRequest['fPRId'];
  }
    
  $allResult = $oMaster->getQuotationList($id_pr);

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Quotation List</title>
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
                     Quotation List 
                    
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
                     <li><a href="#">Quotation List</a></li>
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
										echo $msg = 'New Quotation List Created Successfully';
									}
									else if($aRequest['msg'] == 'updatesucess')
									{
										echo $msg = 'Quotation List Updated Successfully';
									}
									else if($aRequest['msg'] =='delsuccess')
									{
										echo $msg = 'Quotation List Deleted Successfully';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'This Quotation List is parent, so we can not delete';
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
								<h4><i class="icon-globe"></i>Quotation List</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="btn-group">
                             <a href="QuotationEdit.php?id=<?php echo $id_pr;?>&action=Add" role="button" class="btn green" data-toggle="modal">Add Quotation <i class="icon-plus"></i></a>								
								</div>
															
								<div class="btn-group">
                             <a href="CompareQuotation.php?id=<?php echo $id_pr;?>" role="button" class="btn green" data-toggle="modal">Comparision Quotation <i class="icon-plus"></i></a>								
								</div>
								<div class="btn-group">
								<a href="PurchaseRequest.php" class="btn blue"><i class="m-icon-swapleft m-icon-white"></i></i> Go To Purchase Request </a>
								</div>
								<div class="btn-group">
						<a href="PurchaseOrderCreate.php?type=PR" class="btn blue"><i class="m-icon-swapright m-icon-white"></i></i> Create Purchase Order </a>	</div>
								
								</div>
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>SLNO</th>
                                            <th>PR ID</th>
											<th>Vendor Name</th>
											<th>Status</th>
											<th>Approved by </th>
											<th>Approved Date</th>
											 <th>Action</th>
                                                                                     
										</tr>
									</thead>
									<tbody>
                                    	<?php 
										$a=1;
										foreach ($allResult as $item){ ?>
                                       
										<tr class="odd gradeX">
                                        	<td><?php echo $a; ?></td>
											<td><?php echo $item['request_no']; ?></td>
											<td><?php echo $item['vendor_name']; ?></td>
											 <td><?php echo $oUtil->AssetItemStatus($item['status']);?></td>
											 <td><?php echo $item['employee_name']; ?></td>
											 <td><?php echo $item['approved_on']; ?></td>
                                            <td>
										  <?php  if($item['status']=='1')
										  {?>
										 
										    <a href="QuotationEdit.php?id=<?php echo $item['id_pr'];?>&fQuoteId=<?php echo $item['id_quote'];?>&action=edit" class="btn mini purple"><i class="icon-edit"></i>Edit</a>  
											 
										   <?php } ?>
										  </td>
                                           
										</tr>
                                        <?php $a++ ;}?>
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
									</div>
                                  
         <!-- END PAGE CONTAINER-->
      </div>
      
      
      <!-- END PAGE -->  
   </div></div>
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
</body>
<!-- END BODY -->
</html>