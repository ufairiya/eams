<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;

	$aFuelDetails = $oTransport->getFuelInfo($aRequest);
	/*echo '<pre>';
	print_r($aFuelDetails);
	exit();*/
			
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Transport Report List </title>
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
   <div class="page-container row-fluid full-width-page">
		<!-- BEGIN SIDEBAR -->
      
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
                     Transport Report 
                 
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="TransportReport.php">Transport Report</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Transport Report List</a></li>
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
										echo $msg = 'New Transport Report Added Successfully';
									}
									else if($aRequest['msg'] == 'updatesucess')
									{
										echo $msg = 'Transport Report Updated Successfully';
									}
									else if($aRequest['msg'] =='delsuccess')
									{
										echo $msg = 'Transport Report Deleted Successfully';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'This Transport Report is parent, so we can not delete';
									}
									?>
								</div>
								<?php
								  }
								?> 
                              
                                
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            
            <!-- BEGIN PAGE CONTENT-->
            
             <div class="row-fluid profile">
					<div class="tabbable tabbable-custom">
									<div id="tab_1_5" class="tab-pane">
								
								<div class="portlet-body">
                                <div style="float:left";>
                                <a href="TransportReport.php">BACK TO FORM</a>
                                 </div>
                             

<table class="table table-striped table-hover">
<thead>
<tr>
<th>Vehicle Number</th>
<th>Asset Number</th>
<th>Asset Image</th>
<th>Warranty Start Date</th>
<th>Warranty End Date</th>
</tr>
<tr>
<td><?php echo $aFuelDetails['assetinfo']['machine_no']?></td>
<td><?php echo $aFuelDetails['assetinfo']['asset_no']?></td>
<td>
<?php if($aFuelDetails['assetinfo']['asset_image']!='') {
										 ?>
                                          
										<span class="photo"> <img src="uploads/assetimage/<?php echo $aFuelDetails['assetinfo']['asset_image'];?>" alt="" height="50" width="50"/></span>
                                        
                                        <?php } else {?>
                                          <span class="photo">   <img src="assets/img/noimage.gif" alt="" height="50" width="50" /></span>
                                             <?php } ?>

</td>
<td><?php echo date('d-m-Y',strtotime($aFuelDetails['assetinfo']['warranty_start_date']));?></td>
<td><?php echo date('d-m-Y',strtotime($aFuelDetails['assetinfo']['warranty_end_date']));?></td>
</tr>
</thead>
</table>
<?php if(!empty($aFuelDetails['fuelinfo'])){ ?>
<h3>Fuel Info</h3>
<table class="table table-striped table-hover">
<thead>
<tr>
<th>Bill Date</th>
<th>Bill Number</th>
<th>Quantity</th>
<th>Fuel Type</th>
<th>OMR</th>
<th>CMR</th>
<th>Bill Amount</th>
</tr>
<?php foreach($aFuelDetails['fuelinfo'] as $aFuel) {
$total_amt +=$aFuel['bill_amount'];
 ?>
<tr>
<td><?php echo date('d-m-Y',strtotime($aFuel['bill_date']));?></td>
<td><?php echo $aFuel['bill_no'];?></td>
<td><?php echo $aFuel['qty'];?></td>
<td><?php echo $_aFuelType[$aFuel['id_fuel_type']];?></td>
<td><?php echo $aFuel['omr'];?></td>
<td><?php echo $aFuel['cmr'];?></td>
<td><?php echo $aFuel['bill_amount'];?></td>
</tr>
<?php } ?>
<tr>
<td colspan="6" style="text-align:right;">TOTAL :</td>
<td><b><?php echo $total_amt?></b></td>
</tr>
</thead>
</table>
<?php } ?> 
 <?php if(!empty($aFuelDetails['serviceinfo'])){ ?>
 <h3>Service Info</h3>
<table class="table table-striped table-hover">
<thead>
<tr>
<th>Service Number</th>
<th>Bill Date</th>
<th>Bill Number</th>
<th>Service Type</th>
<th>Service Sent Date</th>
<th>Service Return Date</th>
<th>Next Service Date </th>
<th>OMR</th>
<th>CMR</th>
<th>Next Service Milieage </th>
<th>Bill Amount</th>
</tr>
<?php foreach($aFuelDetails['serviceinfo'] as $aService) {
$service_total_amt +=$aService['bill_amount'];
 ?>
<tr>
<td><?php echo $aService['service_no'];?></td>
<td><?php echo date('d-m-Y',strtotime($aService['bill_date']));?></td>
<td><?php echo $aService['bill_number'];?></td>
<td><?php echo $_aServiceType[$aService['service_type']];?></td>
<td><?php echo date('d-m-Y',strtotime($aService['service_date']));?></td>
<td><?php echo date('d-m-Y',strtotime($aService['service_return_date']));?></td>
<td><?php echo date('d-m-Y',strtotime($aService['next_service_date']));?></td>
<td><?php echo $aService['mileage_at_service'];?></td>
<td><?php echo $aService['mileage_after_service'];?></td>
<td><?php echo $aService['next_service_mileage'];?></td>
<td><?php echo $aService['bill_amount'];?></td>
</tr>
<?php } ?>
<tr>
<td colspan="10" style="text-align:right;">TOTAL :</td>
<td><b><?php echo $service_total_amt?></b></td>
</tr>
</thead>
</table>
<?php } ?>
 
								</div>
								<div class="space5"></div>
								
							</div>
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
  
</body>
<!-- END BODY -->
</html>