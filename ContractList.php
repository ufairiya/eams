<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $allResult = $oMaster->getContractList();
$id_item = $aRequest['Id'];
$ItemList = $oMaster->getContractItemInfo($id_item);

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Contract List </title>
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
                     Asset 
                     <small>Inventry Items</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Contract</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Contract List</a></li>
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
										echo $msg = 'New Contract Added Successfully';
									}
									else if($aRequest['msg'] == 'updatesucess')
									{
										echo $msg = 'Contract Updated Successfully';
									}
									else if($aRequest['msg'] =='delsuccess')
									{
										echo $msg = 'Contract Deleted Successfully';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'This Contract is parent, so we can not delete';
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
								<h4><i class="icon-globe"></i>Contract Details</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="btn-group">
                                <a href="Contracts.php?action=Add"  role="button" class="btn green" data-toggle="modal">Add New Contract<i class="icon-plus"></i></a>								
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>S.No</th>
                                            <th>Contract Id</th>
											<th>Contract Title</th>
											<th>Contract Type</th>
											<th>Start Date</th>
                                            <th>End Date</th>
											<th>Status</th>
											<th>Action</th>	
										</tr>
									</thead>
									<tbody>
                                    	<?php 
										$i=1;
										foreach ($allResult as $item): ?>
                                       
										<tr class="odd gradeX">
                                        	<td><?php echo $i; ?></td>
											<td><?php echo $item['id_contract']; ?></td>
											<td><?php echo $item['contract_title']; ?></td>
											<td><?php echo $item['contract_type']; ?></td>
											<td><?php echo date('d/m/Y',strtotime($item['contract_start_date'])); ?></td>
                                            <td><?php echo date('d/m/Y',strtotime($item['contract_end_date'])); ?></td>
										    <td><?php echo $oUtil->AssetItemStatus($item['status']);?></td>
                                            <td>
                                            <div class="flash" id="flash_<?php echo  $item['id_contract']; ?>"></div>
                                            <a href="Contracts.php?action=edit&fContractId=<?php echo $item['id_contract']; ?>" class="btn mini purple"><i class="icon-edit"></i>Edit</a>&nbsp;&nbsp;  <a href="?Id=<?php echo  $item['id_contract']; ?>&action=list" class="btn mini purple"><i class="icon-edit"></i>View</a>
                                             
                                           
                                            </td>
                                          
										</tr>
                                        <?php 
										$i++;
										endforeach; ?>
										
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
									</div>
				
                 <?php if(isset($aRequest['Id'])){?>
                                    <div class="row-fluid">
                                    <?php } else {?>
                                    <div class="row-fluid" style="display:none;">
                                     <?php } ?>
									<div class="span12">
                                    <div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-globe"></i>Contract Item Details</h4>
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
                                            <th>Item Name</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
                                    	<?php foreach ($ItemList as $item){ 
										
										?>
                                       
										<tr class="odd gradeX">
											<td><?php echo $item['asset_no']; ?></td>
											<td><?php echo $item['itemgroup1_name']; ?></td>
											<td><?php echo $item['itemgroup2_name']; ?></td>
											<td><?php echo $item['item_name']; ?></td>
                                         
                                           <td>
                                            <form action='Contract.php' method='post' target="_blank" ><input type='hidden' name='fAssetNumber' value="<?php echo $item['id_asset_item'];  ?>"/>
		    <button type='submit' class='btn mini purple' style="height: 30px;">View Contract</button>
                                             </form></td>
                                          
                                          
										</tr>
                                        <?php } ?>
										
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
		var dataString = 'data=citydelete&id='+ id;
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