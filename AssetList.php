<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $allResult = $oMaster->getAssetItemList();
$aInventoryItems = $oMaster->getInventoryList('asset');
/*echo '<pre>';
print_r( $allResult );
exit();*/
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Asset List </title>
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
                    
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Asset</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Asset List</a></li>
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
										echo $msg = 'New Asset Added Successfully';
									}
									else if($aRequest['msg'] == 'updatesucess')
									{
										echo $msg = 'Asset Updated Successfully';
									}
									else if($aRequest['msg'] =='delsuccess')
									{
										echo $msg = 'Asset Deleted Successfully';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'This Asset is parent, so we can not delete';
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
								<h4><i class="icon-globe"></i>Asset List</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="btn-group">
                                <a href="AssetDetails.php?action=Add"  role="button" class="btn green" data-toggle="modal">Add New Asset<i class="icon-plus"></i></a>								
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>S.No</th>
                                            <th>Asset Number</th>
											<th>Asset Item Group1</th>
											<th>Asset Item Group2</th>
											<th>Asset Item Name</th>
                                            <th>Image</th>
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
											<td><?php echo $item['asset_no']; ?></td>
											<td><?php echo $item['itemgroup1_name']; ?></td>
											<td><?php echo $item['itemgroup2_name']; ?></td>
                                          <td><?php echo $item['item_name']; ?></td>
											<td>
                                           <?php  
										    if($item['asset_image']!='')
											{ ?>
                                            <img src="<?php
											
											 echo "uploads/assetimage/".$item['asset_image'];?>" height="50" width="50"/>
                                            <?php } else {?>
                                             <form action='AssetImage.php' method='post' ><input type='hidden' name='fAssetNumber' value="<?php echo $item['id_asset_item'];  ?>"/><input type='hidden' name='fInventoryItem' value="<?php echo $item['id_inventory_item'];  ?>"/>
												 <input type='hidden' name='fReturnURL' value="AssetList.php"/>
		      <button type='submit' class='btn mini purple' style="height: 30px;">Add Image</button></form>
                                          
                                             <?php } ?>
                                            </td>
                                           <td><?php echo $oUtil->AssetItemStatus($item['status']);?></td>
                                            <td>
											<a href="AddStock.php?id=<?php echo $item['id_asset_item'];?>&action=edit"><button type='submit' class='btn mini purple' style="height: 26px;margin-bottom: 9px;">Edit</button> </a>
											<?php if($item['itemgroup1_name'] == 'TRANSPORT') { 
											
											?>
											<form action="FuelDetailEdit.php" method="post">
											<input type="hidden" name="fAssetNumber" value="<?php echo $item['id_asset_item']; ?>">
											<input type="hidden" name="action" value="Add">
											<button type='submit' class='btn mini purple' style="height: 30px;">Add Fuel Limit</button>
											    </form>
											<?php
											
											} ?>
                                            <div class="flash" id="flash_<?php echo  $item['id_asset_item']; ?>"></div>
											<form action="AssetInfo.php" method="post">
											<input type="hidden" name="fAssetNumber" value="<?php echo $item['id_asset_item']; ?>">
											<input type="hidden" name="fMultiple" value="fMultiple">
											<button type='submit' class='btn mini purple' style="height: 30px;">View Asset</button>
											    </form>
												<?php if($item['status'] != '21' ) {?>
										<?php /*?>	<?php if($item['status'] != '19' ) {?>
											
											<form action="MaintenanceEdit.php" method="post">
											<input type="hidden" name="fAssetNumber" value="<?php echo $item['id_asset_item']; ?>">
											<input type="hidden" name="action" value="Add">
											<button type='submit' class='btn mini purple' style="height: 30px;">Add Maintenance</button>
											    </form>
												<?php } ?><?php */?>
											
								   <?php  $aInsurance_exist = $oMaster->getAssetInsurance($item['id_asset_item'],'assetexist');
									   
											if( $aInsurance_exist == 0)
											{
											?>
											
											<form action="Insurance.php" method="post">
											<input type="hidden" name="fAssetNumber" value="<?php echo $item['id_asset_item']; ?>">
											<input type="hidden" name="fGrnId" value="<?php echo $item['id_grn']; ?>">
											<input type="hidden" name="fMultiple" value="fMultiple">
											<button type='submit' class='btn mini purple' style="height: 30px;">Add Insurance</button>
                                                                                       </form>
							 <?php  } else {?>
							 
							    <form action='Insurance.php' method='post' ><input type='hidden' name='fAssetNumber' value="<?php echo $item['id_asset_item'];  ?>"/>
		      <button type='submit' class='btn mini purple' style="height: 30px;">View Insurance</button></form>
							  <?php  } ?>
							  
							 
                                            <?php 
											$Warranty = $oMaster->CheckWarrantyPeriod($item['id_asset_item']);
											$aWarranty = $oMaster->CheckWarranty($item['id_asset_item']);
											if($Warranty == 0 )
											{
											?>
											<form action='AddStock.php' method='post' ><input type='hidden' name='id' value="<?php echo $item['id_asset_item'];  ?>"/><input type='hidden' name='action' value="edit"/><input type='hidden' name='fReturnUrl' value="AssetList.php"/>
											
           <button type='submit' class='btn mini purple' style="height: 30px;">Add Warranty</button>	  </form>
											<?php
											}
											
											if( $aWarranty <= 7 && $Warranty != 0)
											{							
											$aContact_exist = $oMaster->getAssetContract($item['id_asset_item'],'assetexist');
											if( $aContact_exist == 0)
											{
											?>
												<form action='Contract.php' method='post' ><input type='hidden' name='fAssetNumber' value="<?php echo $item['id_asset_item'];  ?>"/><input type='hidden' name='fGrnId' value="<?php echo $item['id_grn'];  ?>"/><input type='hidden' name='fMultiple' value="no"/><input type='hidden' name='fGrnId' value="<?php echo $item['id_grn'];  ?>"/>
												<button type='submit' class='btn mini purple' style="height: 30px;">Add Contract</button></form>
                                         
                                          <?php  } else {?>
                                            <form action='Contract.php' method='post' ><input type='hidden' name='fAssetNumber' value="<?php echo $item['id_asset_item'];  ?>"/>
		      <button type='submit' class='btn mini purple' style="height: 30px;">View Contract</button></form>
                                            <?php  } 
											
											} else
											{
											?>
											
		
											<?php
											}
											?>
											<?php
											}
											?>
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
	
	 jQuery(document).ready(function() { 
		 jQuery("#fgrnId").on('change', function() {
		   
		   var id = $("#fgrnId").val();
		   	var dataStr = 'action=getassetitem&grnId='+id;
		    $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				 
					  jQuery("#AssetItemList").html(result);
				 
			   }
          });
		  
		 });
		 
		  }); //
	
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