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
		
		 $allResult = $oMaster->getPurchaseRequestList($aRequest);
	}
	else
	{
  $allResult = $oMaster->getPurchaseRequestList();
	}
   $oAssetDepartment = &Singleton::getInstance('Department');
  $oAssetDepartment->setDb($oDb);
  $oAssetVendor = &Singleton::getInstance('Vendor');
  $oAssetVendor->setDb($oDb);
    if(isset($aRequest['id']))
  {
    $item_id = $aRequest['id'];
	$pr_result   = $oMaster->getPurchaseRequestInfo($item_id,'id');
    $edit_result = $oMaster->getPurchaseRequestItemInfo($item_id,'id');
  }	
  
  if(isset($aRequest['update']))
  {
    if($oMaster->updatePurchaseRequest($aRequest,'update'))
	{
	  $msg = "New Item Updated.";
	  echo '<script type="text/javascript">window.location.href="PurchaseRequest.php?action=approval&msg=updatesucess";</script>';
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
			  <?php if($aRequest['action'] == 'approval') {?>
			  
			  <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN STYLE CUSTOMIZER -->
                  <!-- END STYLE CUSTOMIZER -->  
				
                  <h3 class="page-title">
                     Purchase Request Approval 
                     
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="PurchaseRequest.php">Purchase Request</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Purchase Approval</a></li>
                  </ul>
               </div>
            </div>
				  <?php } else { ?>
				   
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
                        <a href="index.php">Home</a> 
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
             <?php }  ?>  
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
									else if($aRequest['msg'] =='trashsuccess')
									{
										echo $msg = 'Purchase Request Moved To Trash Successfully';
									}
									else if($aRequest['msg'] =='error')
									{
										echo $msg = 'Sorry Error occur, try again';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'This Purchase Request is parent, so we can not delete';
									}
									?>
								</div>
								<?php
								  }
								?> 
            <!-- END PAGE HEADER-->
                    <!-- BEGIN PAGE CONTENT-->
						<?php if(!isset($aRequest['id'])){?>
                                    <div class="row-fluid">
                                    <?php } else {?>
                                    <div class="row-fluid" style="display:none;">
                                     <?php } ?>
						<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
							  <?php if($aRequest['action'] == 'approval') {?>
							  <h4><i class="icon-globe"></i>Purchase Request Approval List</h4>
							   <?php } else { ?>
								<h4><i class="icon-globe"></i>Purchase Request List</h4>
								  <?php }  ?>  
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
							<?php if($aRequest['action'] != 'approval') {?>
								<div class="clearfix">
                                <div class="btn-group">
                             <a href="PurchaseRequestEdit.php?action=Add" role="button" class="btn green" data-toggle="modal">Create Purchase Request <i class="icon-plus"></i></a>								
								</div>
								</div>
								  <?php }  ?> 
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>SLNO</th>
                                            <th>PR ID</th>
											<th>Unit</th>
                                            <th>Division</th>
                                           	<th>Request Date</th>
                                            <th>Requester Name</th>
											<th>Status</th>
                                            <th>Download PDF</th>
                                            <th>Print View</th>
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
											<td><?php 
											    $aUnitInfo = $oMaster->getUnitInfo($item['id_unit'], 'id');
											    echo $aUnitInfo['unit_name']; 
											?></td>
                                            <td><?php $aDivision = $oMaster->getDivisionInfo($item['id_department'],'id'); 
											echo $aDivision['division_name'];
											?></td>
											<td>
											 <?php echo $item['format_date']; ?>
											 </td>
                                             <td> <?php echo $item['employee_name']; ?></td>
											 <td><?php echo $oUtil->AssetItemStatus($item['status']);?></td>
                                            <td>
											
											<?php /*?><form action='PurchaseRequestPDF.php' method='post' target="_blank" enctype='multipart/form-data'><input type='hidden' name='id' value="<?php echo  $item['id_pr']; ?>"/><button type='submit' class="btn mini purple" style="height: 20px;">Download PDF</button></form><?php */?>
											<a class="fancybox fancybox.iframe" href="PurchaseRequestPDF.php?id=<?php echo  $item['id_pr']; ?>&action=view">Download PDF</a>
											
											</td>
                                            <td><?php /*?><form action='PurchaseRequestView.php' target="_blank" method='post' enctype='multipart/form-data'><input type='hidden' name='id' value="<?php echo  $item['id_pr']; ?>"/>
                                              <button type='submit' class="btn mini purple" style="height: 20px;">Print View</button></form> <?php */?>
											  
											  <a class="fancybox fancybox.iframe" href="PurchaseRequestView.php?id=<?php echo  $item['id_pr']; ?>&action=view">Print View</a>
											  
											  </td>
                                              <td>
                                            <?php if($item['status'] == 1 && $aRequest['action']=='approval')
											{
											?>											
                                            <a href="PurchaseRequestApproval.php?id=<?php echo $item['id_pr'];?>&action=edit&submits=approval" class="btn mini purple"><i class="icon-edit"></i>Approve</a>&nbsp;&nbsp;
                                            <a  class="delete btn mini black" href="#"><i class="icon-trash"></i>Cancel</a>&nbsp;&nbsp;
                                             <?php
											} else { 
											?>
											 <?php if($item['status']== '1')
										  {?>
											  <a href="PurchaseRequestEdit.php?id=<?php echo $item['id_pr'];?>&action=edit" class="btn mini purple"><i class="icon-edit"></i>Edit</a>   <?php
											}
											?>
                                          <?php if($item['status']== '3' )
										  {
										  if(empty($item['quote_approval']))
										  {
										  ?>
                                            
											   <a href="PrVendorMapEdit.php?id=<?php echo $item['id_pr'];?>" class="btn mini purple"><i class="icon-edit"></i>Assign Vendors</a>   <br>
											  <form action='QuotationList.php' target="_blank" method='post' enctype='multipart/form-data'><input type='hidden' name='fPRId' value="<?php echo  $item['id_pr']; ?>"/>
                                              <button type='submit' class="btn mini purple" style="height: 20px;">Add Quotation</button></form> 
											                
                                               <?php
											   }
											   else 
											   {
											   ?>
											     <a href="CompareQuotation.php?id=<?php echo $item['id_pr'];?>" class="btn mini purple"><i class="icon-edit"></i>View Quotation</a>   <br>
											   
											   <?php
											   }
											}
											?>
											  <?php
											}
											?>
											 <?php if($item['status']!=2)
											{
											?>
                                           
                                            <a  class="delete btn mini black" href="javascript:void()" onclick=deleteBox('<?php echo  $item['id_pr']; ?>','prdelete','Move')><i class="icon-trash"></i>Delete</a>                                              
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
    </body>
<!-- END BODY -->
</html>