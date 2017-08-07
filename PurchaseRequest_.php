<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $allResult = $oMaster->getPurchaseRequestList();
/*  echo '<pre>';
  print_r($allResult);
  echo '</pre>';*/
  
  $oAssetDepartment = &Singleton::getInstance('Department');
  $oAssetDepartment->setDb($oDb);
  $item_id = $aRequest['id'];
  $edit_result = $oMaster->getPurchaseRequestItemInfo($item_id,'id');
  $oAssetVendor = &Singleton::getInstance('Vendor');
  $oAssetVendor->setDb($oDb);
  
  if(isset($aRequest['update']))
  {
    if($oMaster->updatePurchaseRequest($aRequest,'update'))
	{
	  $msg = "New Item  Updated.";
	  echo '<script type="text/javascript">window.location.href="PurchaseRequest.php?msg=success";</script>';
	}
	else $msg = "Sorry";
  } //update
  
 
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Purchase Request</title>
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
                     Purchase Request 
                     <small>Purchase Request master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.html">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Purchase</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Purchase Request</a></li>
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
										echo $msg = 'New Purchase Request Created Successfully';
									}
									else if($aRequest['msg'] == 'updatesucess')
									{
										echo $msg = 'Purchase Request Updated Successfully';
									}
									else if($aRequest['msg'] =='delsuccess')
									{
										echo $msg = 'Purchase Request Deleted Successfully';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'This Unit is parent, so we can not delete';
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
								<h4><i class="icon-globe"></i>Purchase Request List</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="btn-group">
                             <a href="PurchaseRequestEdit.php?action=Add" role="button" class="btn green" data-toggle="modal">Create Purchase Request <i class="icon-plus"></i></a>								
								</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>PR ID</th>
											<th>Unit</th>
                                            <th>Department</th>
											<th>Date</th>
											<th>Status</th>
                                            <th>Download PDF</th>
                                            <th>View</th>
											<th>Action</th>	
										</tr>
									</thead>
									<tbody>
                                    	<?php foreach ($allResult as $item): ?>
                                       
										<tr class="odd gradeX">
											<td><?php echo $item['id_pr']; ?></td>
											<td><?php 
											    $aUnitInfo = $oMaster->getUnitInfo($item['id_unit'], 'id');
											    echo $aUnitInfo['unit_name']; 
											?></td>
                                            <td><?php echo $oAssetDepartment->getDepartmentName($item['id_department']); ?></td>
											 <td>
											 <?php echo $item['format_date']; ?>
											 </td>
											<td><?php 
											    if( $item['status'] === '3')
												{ 
												  echo $status = '<span class="label label-success">Approved</span>';
											    }
												else if( $item['status'] === '2')
												{
												  echo $status = '<span class="label label-warning">Deleted</span>';
												}
												else if( $item['status'] === '1')
												{
												  echo $status = '<span class="label label-warning">Pending</span>';
												} 
											?></td>
                                            <td><form action='PurchaseRequestPDF.php' method='post' target="_blank" enctype='multipart/form-data'><input type='hidden' name='purchaseRequestId' value="<?php echo  $item['id_pr']; ?>"/><button type='submit' class="btn mini purple" style="height: 20px;">Download PDF</button></form></td>
                                            <td><form action='PurchaseRequestView.php' target="_blank" method='post' enctype='multipart/form-data'><input type='hidden' name='purchaseRequestId' value="<?php echo  $item['id_pr']; ?>"/>
                                              <button type='submit' class="btn mini purple" style="height: 20px;">View</button></form> </td>
                                            <td>
                                         <?php if( $item['status'] === '3')
											{ 

											}
											else
											{
											?>
                                            <a href="?id=<?php echo $item['id_pr'];?>" class="btn mini purple"><i class="icon-edit"></i>Approve</a>&nbsp;&nbsp;
                                            <a  class="delete btn mini black" href="#"><i class="icon-trash"></i>Cancel</a>&nbsp;&nbsp;
                                            <?php
											} 
											?>
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
                                    <?php if(isset($aRequest['id'])){?>
                                    <div class="row-fluid">
                                    <?php } else {?>
                                    <div class="row-fluid" style="display:none;">
                                     <?php } ?>
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
                                        
                             <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_sample_2" method="post">
                             
                           
                               <div class="control-group" style="padding:10px;">
                                 <table>
                             <tr>
                             <td>
                               <label class="control-label">Select Vendor</label>
                               <div class="controls">
                                      
                                       <select class="large m-wrap" tabindex="3" name="fvendorId">
											 <?php
											  $avendorList = $oAssetVendor->getAllVendorInfo();
											  ?>
											   <option value="">--------NONE-------</option>
											  <?php
                                              foreach($avendorList as $aVendor)
											  {
			  
											 ?>
                                             
                                              <option value="<?php echo $aVendor['id_vendor']; ?>" <?php if($edit_result[0]['id_vendor'] == $aVendor['id_vendor']) { echo 'selected=selected' ;}?>><?php echo $aVendor['vendor_name']; ?></option>
                                          
                                             <?php
											  }
											 ?>
                                          </select>
                                         
                                             </div>
                               </td>
                             <td style="padding-left:20px;"><a href="PurchaseRequestView.php?id=<?php echo  $oUtil->encode( $item_id); ?>" target="_blank" class="btn mini purple" style="float:right;">View</a>  </td>
                             </tr>
                             
                             </table>
                                    
                                      
                                   		 </div> 
                                                                               
                                          
                                        
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
                                        <th>Item ID</th>
											<th>Item Name</th>
											<th>Quantity</th>
                                         	<th>Delete</th>
										</tr>
									</thead>
									<tbody>
										 <?php foreach ($edit_result as $purchaseitem){ ?>
										<tr class="">
                                        <td><?php echo $purchaseitem['id_pr_item'];?><input type="hidden" name="fItemId[]" value="<?php echo $purchaseitem['id_pr_item'];?>" /></td>
                                        <td><input type="text" name="fItemName[]" value="<?php echo $purchaseitem['pr_item_name'];?>"/></td>
                                        <td><input type="text" name="fQuantity[]" value="<?php echo $purchaseitem['qty'];?>"/></td>
										
                                           
																				
											<td><a class="delete"  href="javascript:;" onclick=purchasedelete(<?php echo  $purchaseitem['id_pr_item']; ?>)>Delete</a>	<input type="hidden" name="fPurchaseRequestId" value="<?php echo  $purchaseitem['id_pr']; ?>"/></td>
										</tr>
										  <?php } ?>
									</tbody>
								</table>
                                
                                 <div class="form-actions">
                                   	
                                       <button type="submit" class="btn blue" name="update"><i class="icon-ok"></i>Approve Request Request</button>
									   <a href="<?php echo $_SERVER['PHP_SELF']; ?>"><button type="button" class="btn">Go Back</button></a>
                                    </div>
                                      </form>
							</div>
						</div>
                                    
				</div>
                </div>
          
            <!-- END PAGE CONTENT-->     
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