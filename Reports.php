<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
 
 	
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|  Report List </title>
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
                      Report 
                 
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="StockReport.php"> Report</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#"> Report List</a></li>
                  </ul>
               </div>
            </div>
            
                                
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            
            <!-- BEGIN PAGE CONTENT-->
            
           
			
				<div class="span12">
				
				<table width="100%">
				<tr>
				<td><a href="ViewReport.php?report=unit"  >
				Unitwise Total Stock Count <i class="m-icon-swapright m-icon-black"></i>
				</a></td>
				<td><a href="ViewReport.php?report=store"  >
				Storewise Total Stock Count <i class="m-icon-swapright m-icon-black"></i>
				</a></td>
				<td><a href="ViewReport.php?report=storewise"  >
				Store - Itemwise Stock Count   <i class="m-icon-swapright m-icon-black"></i>
				</a></td>
				<td><a href="ViewReport.php?report=groupwise"  >
				Storewise - Item Group Count  <i class="m-icon-swapright m-icon-black"></i>
				</a></td>
				
				</tr>
				
				<tr>
				
				<td><a href="ViewReport.php?report=item"  >
				Storewise - Item List  <i class="m-icon-swapright m-icon-black"></i>
				</a></td>
				
				<td><a href="StockReport.php"  >
				Stock Search <i class="m-icon-swapright m-icon-black"></i>
				</a></td>
				
				<td><a href="IdleStockReport.php"  >
				Idle Stock Search  <i class="m-icon-swapright m-icon-black"></i>
				</a></td>
				<td><a href="TransportReport.php"  >
				Transport Search  <i class="m-icon-swapright m-icon-black"></i>
				</a></td>
				</tr>
				</table>
				
				
				
				
					
				
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