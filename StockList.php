<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $allResult = $oMaster->getStockList();
  //echo '<pre>';
  //print_r( $allResult );
  //echo '</pre>';
  //exit();
  //getAssetImage();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|Stock List </title>
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
                        <a href="#">Stock</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Stock </a></li>
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
										echo $msg = 'New Stock Added Successfully';
									}
									else if($aRequest['msg'] == 'updatesucess')
									{
										echo $msg = 'Stock Updated Successfully';
									}
									else if($aRequest['msg'] =='delsuccess')
									{
										echo $msg = 'Stock Deleted Successfully';
									}
									else if($aRequest['msg'] =='trashsuccess')
									{
										echo $msg = 'Stock Moved To Trash Successfully';
									}
									else if($aRequest['msg'] =='error')
									{
										echo $msg = 'Sorry Error occur, try again';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'Stock is used in Transaction,Delivery,Asset etc.So It cannot be deleted';
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
								<h4><i class="icon-globe"></i>Stock Master</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="btn-group">
                                <a href="AddStock.php?action=Add" role="button" class="btn green" data-toggle="modal">Add New <i class="icon-plus"></i></a>								
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>SLNO</th>
                                             <th>Item Group 1</th>
                                            <th>Item Group 2</th>
                                            <th>Item Name</th>
                                            <th>Asset Number</th>
											<th>Image</th>
                                            <th>Machine Number</th>
                                            <th>Unit Name</th>
                                             <th>Store Name</th>
                                            <th>Purchased Date</th>
                                          	<th>Action</th>	
										</tr>
									</thead>
									<tbody>
                                    	<?php 
										$a =1;
										foreach ($allResult as $item){
										//$asset_image = $oReport->getAssetFirstImage($item['id_asset_item'],'assetid');
									
										?>
                                       
										<tr class="odd gradeX">
                                            <td><?php echo $a; ?></td>
											<td><?php echo $item['itemgroup1_name']; ?></td>
                                            <td><?php echo $item['itemgroup2_name']; ?></td>
                                            <td><?php echo $item['item_name']; ?></td>
											<td><?php echo $item['asset_no']; ?></td>
											<td><img src="uploads/assetimage/<?php echo $item['asset_image'] != ''? $item['asset_image'] :'placeholder_image.jpg';?>" alt="" height="50" width="50"/></td>
											<td><?php echo $item['machine_no']; ?></td>
                                           	<td><?php echo $item['unit_name']; ?></td>
                                             <td><?php echo $item['store_name']; ?> <?php if($item['division_name']!='') {?><font size="1"> <b> (<?php echo $item['division_name'];?>)</b></font><?php } ?></td>
                                            <td><?php echo date('d/m/Y',strtotime($item['machine_date'])); ?></td>
                                           
                                          	<td>
                                            <div class="flash" id="flash_<?php echo  $item['id_asset_item']; ?>"></div>
                                      <a href="AddStock.php?id=<?php echo  $item['id_asset_item']; ?>&action=edit" class="btn mini purple"><i class="icon-edit"></i>Edit</a>
                                            
                                            <?php if($item['status']!=2)
											{
											?>
                                            <a  class="delete btn mini black" href="javascript:void()" onclick=deleteBox('<?php echo  $item['id_asset_item']; ?>','assetdelete','Move')><i class="icon-trash"></i>Delete</a>   
                                           <?php } else { ?>
										      <a  class="delete btn mini red" href="javascript:void()" onclick=deleteBox('<?php echo  $item['id_asset_item']; ?>','assetdelete','Permanent')><i class="icon-trash"></i>Delete</a>   
										   	<?php } ?>
                                           
                                            </td>
                                          
										</tr>
                                        <?php $a++;} ?>
										
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
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
    
</body>
<!-- END BODY -->
</html>