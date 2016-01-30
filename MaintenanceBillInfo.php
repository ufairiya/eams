<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $aMaintenance = $oMaster->getMaintenanceListInfo($aRequest['fassetid']);
  $aMaintenance = $aMaintenance['maintenance'];
 ?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Maintenance Bill Info </title>
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
                     Maintenance 
                     <small>Maintenance Bill info</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Maintenance</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Maintenance Bill Info</a></li>
                  </ul>
               </div>
            </div>
                     
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            
            <!-- BEGIN PAGE CONTENT-->
									<div class="row-fluid">
									<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-globe"></i>Maintenance Bill info</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="btn-group">
                                <a href="<?php echo APP_HTTP.'/Maintenance.php'?>"  role="button" class="btn green" data-toggle="modal">
                                Back to Maintenance </a>								
									</div>
									
								</div>
                                
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
															<thead>
																<tr>
																	
																	<th>Bill Number</th>																	
																	<th>Bill Date</th>
                                                                    <th>Bill Amount</th>
																	<th>Service Invoice Date</th>																													                                                                    <th>Document</th>
																</tr>
															</thead>
															<tbody>
															<?php foreach($aMaintenance as $aMaintenanceItem) {
																$fileName = $aMaintenanceItem['document_path'];
																$ext      = explode(".", $fileName);
																$acond = array('png','jpeg','jpg');
																if(isset($ext[1]) && in_array(strtolower($ext[1]),$acond) )
																{
																	$url = 'MaintenanceBillView.php?fdocument='.$aMaintenanceItem['document_path'];
																}
																else
																{
																	$url = 'uploads/servicedocument/'.$aMaintenanceItem['document_path'];
																}
																?>
															<tr>															
															<td><?php echo $aMaintenanceItem['bill_number'];?></td>															
															<td><?php echo $aMaintenanceItem['bill_date'];?></td>
                                                            <td><?php echo $aMaintenanceItem['bill_amount'];?></td>
															<td><?php echo $aMaintenanceItem['bill_created_on'];?></td>
                                                            <td><a href="<?php echo $url;?>" target="_new"><?php echo $aMaintenanceItem['document_path'];?></a></td>
															</tr>
															<?php } ?>
															</tbody>
															</table>
								
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
									</div>
				
									<!-- END PAGE CONTENT-->
            
            
            <div class="row-fluid">
               <div class="span12">
               </div>
            </div>
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