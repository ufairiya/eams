<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  /*echo '<pre>';
  print_r($aRequest);
 
  echo '</pre>'; 

  exit();*/

	if(isset($_REQUEST['send']))
		{
	 if(empty($sesReportItemList))
		{
		   $sesReportItemList = array();
		}
		
		$sesReportItemList = $aRequest;
		
		$oSession->setSession('ses_ReportItemlist',$sesReportItemList);
		}

 $aSearchList =	$oMaster->getSearchLabel($sesReportItemList);

 $aPoItemReportList = $oReport->PoItemReportList($sesReportItemList);
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| PO Item Search List </title>
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
                    PO Item Search Report
                 
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="PurchaseOrder.php">Purchase Order</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="PoItemReport.php">Purchase Order Item Search</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Purchase Order Item List</a></li>
                  </ul>
               </div>
            </div>       
                                
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            
            <!-- BEGIN PAGE CONTENT-->
            
             <div class="row-fluid profile">
					<div class="tabbable tabbable-custom">
									<div id="tab_1_5" class="tab-pane">
								<div style="float:left";>
                                <a href="PoItemReport.php">BACK TO FORM</a>
                                <div >SEARCH FOR :&nbsp;<b><?php echo $aSearchList;?></b>
                                
                                </div>
                                </div>
								<div class="portlet-body">
                                
                               
 									<table class="table table-striped table-bordered table-hover" id="sample_1">
										<thead>
											<tr>
												
                                                <th>PO Number</th>
                                                <th>PO Date</th>
                                                <th>Item Group 1</th>
                                                <th>Item Group 2</th>
                                                <th>Item Name</th>
                                                <th>Vendor Name</th>
                                                <th>Unit Cost</th>
                                               
											</tr>
										</thead>
										<tbody>
                                        <?php 
										foreach($aPoItemReportList as $stockReport) {
												$po_dates = ($stockReport->po_date !='' && $stockReport->po_date !='0000-00-00 00:00:00') ? date('d/m/Y',strtotime($stockReport->po_date)) : '-';									
											?>
											<tr>
												
                                                <td>
                                                  <a class="fancybox fancybox.iframe" href="PurchaseOrderView.php?id=<?php echo $stockReport->id_po; ?>&action=view"> <?php echo $stockReport->po_number;?>
                      </a>
                                                  </td>
                                                <td><?php echo $po_dates;?></td>
                                                <td><?php echo $stockReport->itemgroup1_name;?></td>
												<td><?php echo $stockReport->itemgroup2_name;?></td>
                                                <td><?php echo $stockReport->item_name;?></td>                                                
                                                <td><?php echo $stockReport->vendor_name;?></td> 
                                                <td><?php echo $stockReport->unit_cost;?></td>                                                
											</tr>
											<?php } ?>
										</tbody>
									</table>
                                    
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