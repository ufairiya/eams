<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $allResult = $oMaster->getInventoryList();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Goods Received Note </title>
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
                    Goods Received Note
                     
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
                     <li><a href="#">Goods Received Note</a></li>
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
										echo $msg = 'New Inventory Added Successfully';
									}
									else if($aRequest['msg'] == 'updatesucess')
									{
										echo $msg = 'Inventory Updated Successfully';
									}
									else if($aRequest['msg'] =='delsuccess')
									{
										echo $msg = 'Inventory Deleted Successfully';
									}
									else if($aRequest['msg'] =='trashsuccess')
									{
										echo $msg = 'Inventory Moved To Trash Successfully';
									}
									else if($aRequest['msg'] =='error')
									{
										echo $msg = 'Sorry Error occur, try again';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'This Inventory is parent, so we can not delete';
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
								<h4><i class="icon-globe"></i>Goods Received Note Details</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="btn-group">
                                <a href="AssetItemEdit.php?action=Add"  role="button" class="btn green" data-toggle="modal">Create GRN<i class="icon-plus"></i></a>								
									</div>
									
								</div>
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>SLNO</th>
                                            <th>GRN No</th>
											<th>Bill No</th>
											<th>Vendor Name</th>
											<th>PO</th>
                                            <th>Inspection Status</th>
											<th>Status</th>
											<th>View</th>
											<th>Action</th>	
										</tr>
									</thead>
									<tbody>
                                    	<?php 
										$a = 1;
										foreach ($allResult as $item){ ?>
                                       
										<tr class="odd gradeX">
                                            <td><?php echo $a; ?></td>
											<td><?php echo $item['grn_no']; ?></td>
											<td><?php echo $item['bill_number']; ?></td>
											<td><?php echo $item['vendor_name']; ?></td>
											<td><?php echo $item['po_number']; ?></td>
                                           <td><?php echo $oUtil->inspectionStatus($item['inspection_status']);?></td>
											<td><?php echo $oUtil->AssetItemStatus($item['status']);?></td>
											<td><a class="fancybox fancybox.iframe" href="PurchaseGoodsView.php?id=<?php echo $item['id_inventory']; ?>" target="_blank" class="btn mini purple"> Print View</a></td>
                                            <td>
                                            <div class="flash" id="flash_<?php echo  $item['id_inventory']; ?>"></div>
                                          <!--  <a href="AssetItemEdit.php?tab=2&grnId=<?php echo  $item['id_inventory']; ?>&action=edit" class="btn mini purple"><i class="icon-edit"></i>Change status</a> &nbsp; &nbsp;
                                            <?php if($item['inspection_status'] !=3 || $item['inspection_status'] != 4){?>
                                              <a href="AssetItemEdit.php?tab=1&grnId=<?php echo  $item['id_inventory']; ?>" class="btn mini purple"><i class="icon-edit"></i>Add More Item</a>-->
                                                
											 <a href="AssetItemEdit.php?tab=1&fInventoryId=<?php echo $item['id_inventory'];?>&action=edit" class="btn mini purple"><i class="icon-edit"></i>Item Edit</a>   
											 
											  <a href="AssetItemEdit.php?fInventoryId=<?php echo $item['id_inventory'];?>&type=grn&action=edit" class="btn mini purple"><i class="icon-edit"></i>GRN Edit</a>               
                                           
											  
											
                                         <?php } ?> 
										  <?php if($item['inspection_status']==1 || $item['inspection_status']==3 )
											{
											?>
                                           
                                            <a  class="delete btn mini black" href="javascript:void()" onclick=deleteBox('<?php echo  $item['id_inventory']; ?>','grndelete','Move')><i class="icon-trash"></i>Delete</a>                                              
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