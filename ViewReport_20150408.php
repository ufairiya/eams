<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $aUnitReport = $oReport->getUnitWiseTotalStock();
  $aStoreReport = $oReport->getStoreWiseStockCount();
 $aStoreWiseReport = $oReport->StorewiseReport();
 $array_store =array();
	$array_stock =array();
    foreach($aStoreWiseReport as $storewise) { 
       foreach($aStoreReport as $aStoreReports)
	   {
	   $array_store[$aStoreReports['id_store']]=$aStoreReports['store_name'];
		   if(in_array($aStoreReports['id_store'],$storewise))
		   {
					if($aStoreReports['id_store'] == $storewise['id_store'])
					{
						$arr_stock[$aStoreReports['id_store']]['store_name'] = $storewise['store_name'];
						$arr_stock[$aStoreReports['id_store']]['stock'][] = $storewise;
					}
			}
		
		
	   }
	   
    }
	
	$aItemWiseReport = $oReport->ItemGroupReport();
	$aItemDetailReport = $oReport->ItemReport();

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
             <a href="Reports.php">BACK TO FORM</a>
            <!-- BEGIN PAGE CONTENT-->
			<?php if($aRequest['report'] == 'unit')
			{
			?>
             
              <div >SEARCH FOR :&nbsp;<b>Unit Report</b></div>
             <div class="row-fluid profile">
			<table class="table table-striped table-hover">
			<thead>
            <tr>
           
			 <th>Unit Name</th>
             <th>Stock Count</th>
             </tr>
            </thead>
            <?php foreach($aUnitReport as $aUnitItem) { 
			$total_Unitcount+=$aUnitItem['item_count'];
			?>
            <tr>
			 <td><?php echo $aUnitItem['unit_name'];?></td>
            <td><?php echo $aUnitItem['item_count'];?></td>
             </tr>
            <?php } ?>
			<tr>
			<td style="text-align:right;">Total: </td>
			<td><b> <?php echo $total_Unitcount;?></b></td>
			</tr>
			</table>
			</div>
			<br><br>
			<?php } ?>
			
			<?php if($aRequest['report'] == 'store')
			{
			?>
			<div >SEARCH FOR :&nbsp;<b>Store Report</b></div>
             <div class="row-fluid profile">
			<table class="table table-striped table-hover">
			<thead>
            <tr>
			 <th>Store Name</th>
            <th>Unit Name</th>
             <th>Stock Count</th>
             </tr>
            </thead>
            <?php foreach($aStoreReport as $aStoreReport) { 
			$total_storecount+=$aStoreReport['item_count'];
			?>
            <tr>
			  <td><?php echo $aStoreReport['store_name'];?></td>
            <td><?php echo $aStoreReport['unit_name'];?></td>
            <td><?php echo $aStoreReport['item_count'];?></td>
             </tr>
            <?php } ?>
			<tr>
			<td colspan="2" style="text-align:right;">Total: </td>
			<td><b> <?php echo $total_storecount;?></b></td>
			</tr>
			</table>
			
			
                </div>
			<?php } ?>	
				<?php /*?>	<div >SEARCH FOR :&nbsp;<b>Store Wise Report</b></div>
             <div class="row-fluid profile">
			<table class="table table-striped table-hover">
			<thead>
            <tr>
			 <th>Store Name</th>
            <th>Unit Name</th>
			<th>Item Group1</th>
			<th>Brand / Make</th>
			<th>Item</th>
             <th>Stock Count</th>
             </tr>
            </thead>
            <?php foreach($aStoreWiseReport as $aStoreWise) { 
			$total_count+=$aStoreWise['item_count'];
			?>
            <tr>
			  <td><?php echo $aStoreWise['store_name'];?></td>
            <td><?php echo $aStoreWise['unit_name'];?></td>
             <td><?php echo $aStoreWise['itemgroup1_name'];?></td>
            <td><?php echo $aStoreWise['itemgroup2_name'];?></td>
            <td><?php echo $aStoreWise['item_name'];?></td>
			 <td><?php echo $aStoreWise['item_count'];?></td>
             </tr>
            <?php } ?>
			<tr>
			<td colspan="5" style="text-align:right;">Total: </td>
			<td><b> <?php echo $total_count;?></b></td>
			</tr>
			</table>
			
			
                </div><?php */?>
               <?php if($aRequest['report'] == 'storewise')
			{
			?>
			  	<div >SEARCH FOR :&nbsp;<b>Store Wise Report</b></div>
				<br>
             <div class="row-fluid profile">
			 <?php 
			 foreach($arr_stock as $stock)
			{
			
			$total_counts = 0;
			?>
			<b><?php echo $stock['store_name'];?></b>
			<table class="table table-striped table-hover">
			<thead>
            <tr>
			
			<th>Item Group1</th>
			<th>Brand / Make</th>
			<th>Item</th>
             <th>Stock Count</th>
             </tr>
            </thead>
            <?php
			
		 foreach($stock['stock'] as $aStore) { 
		     $net_total +=$aStore['item_count']; 
			$total_counts+=$aStore['item_count'];
			?>
            <tr>
			<td><?php echo $aStore['itemgroup1_name'];?></td>
            <td><?php echo $aStore['itemgroup2_name'];?></td>
            <td><?php echo $aStore['item_name'];?></td>
			 <td><?php echo $aStore['item_count'];?></td>
             </tr>
            <?php  } ?>
			<tr>
			<td colspan="3" style="text-align:right;">Total: </td>
			<td><b> <?php echo $total_counts;?></b></td>
			</tr>
			 </table>
			 <?php 
			  } 
			  
			  ?>
			  <table class="table table-striped table-hover">
			  <tr>
			  <td colspan="4" style="text-align:right;">Net Total: </td>
			<td><b> <?php echo $net_total;?></b></td>
					 
			 </tr>
			 </table>
		
                </div>
			<?php } ?>		
			 <?php if($aRequest['report'] == 'groupwise')
			{
			?>
					<div >SEARCH FOR :&nbsp;<b>Item Group Wise Report</b></div>
				<br>
             <div class="row-fluid profile">
			 <?php 
			 foreach($aItemWiseReport as $aItemWise)
			{
			
			$total_counts1 = 0;
			?>
			<b><?php echo $aItemWise['store_name'];?></b>
			
			
           <?php 
		  
		    foreach($aItemWise['name'] as $key => $aname) { 
				?>
			
			 
			 <?php 
		   }
		    foreach($aItemWise['stock'] as  $IG1Key => $aItems) {
				?>
				 <br>
			<font color="#FF0000"> <b><?php echo $aItemWise['name'][$IG1Key]; ?></b></font>
		   <table class="table table-striped table-hover">
			<thead>
            <tr>
					
			<th>Brand / Make</th>
			<th>Item</th>
             <th>Stock Count</th>
             </tr>
            </thead>
			<?php
		    foreach($aItems as $aItem) { ?> 
            <tr>
			
            <td><?php echo $aItem['itemgroup2_name'];?> </td>
            <td><?php echo $aItem['item_name'];?></td>
			 <td><?php echo $aItem['item_count'];?></td>
             </tr>
			 
            <?php  } ?>
			 </table>
			
			 <?php 
			
			  }
			  ?>
			  
			 <?php 
			
			  }
			  ?>
			 
                </div>
				<?php } ?>	
				 <?php if($aRequest['report'] == 'item')
			{
			?>
				<div >SEARCH FOR :&nbsp;<b>Item Detail Report</b></div>
				<br>
             <div class="row-fluid profile">
			 <?php 
			 foreach($aItemDetailReport as $aItemDetail)
			{
			
			
			?>
			<b><?php echo $aItemDetail['store_name'];?></b>
			
			
           <?php 
		  
		    foreach($aItemDetail['name'] as $key => $aname) { 
				?>
			
			 
			 <?php 
		   }
		    foreach($aItemDetail['stock'] as  $IG1Key => $aItemDetails) {
				?>
				 <br>
			<font color="#FF0000"> <b><?php echo $aItemDetail['name'][$IG1Key]; ?></b></font>
		   <table class="table table-striped table-hover">
			<thead>
            <tr>
					
			<th>Brand / Make</th>
			<th>Item</th>
			<th>Asset No</th>
			<th>Machine No</th>
			
            <th>Stock Count</th>
             </tr>
            </thead>
			<?php
		    foreach($aItemDetails as $aItem) { ?> 
            <tr>
			
            <td><?php echo $aItem['itemgroup2_name'];?> </td>
            <td><?php echo $aItem['item_name'];?></td> 
			<td><?php echo $aItem['asset_no'];?></td>
			<td><?php echo $aItem['machine_no'];?></td>
			<td><?php echo $aItem['item_count'];?></td>
             </tr>
			 
            <?php  } ?>
			 </table>
			
			 <?php 
			
			  }
			  ?>
			  
			 <?php 
			
			  }
			  ?>
			 
                </div>
				
				<?php } ?>	
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