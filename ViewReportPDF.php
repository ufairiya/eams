<?php
ini_set('max_execution_time','3600');
ini_set('memory_limit','2048M');
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
	
	//echo '<pre>';
	//print_r($oDepreciation);
	//$currentFinaYear = $oDepreciation->getFinancialyearCal(date('Y-m-d'));
	//echo $currentFinaYear['fina_year'];
	
	//echo '</pre>';
include("MPDF56/mpdf.php");
$mpdf=new mPDF('utf-8','A4-L','','','10','10','10','31','5','5','5');
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
                
                   <?php
						if($aRequest['report'] == 'assetlist')
						{
							//echo 'assetlist';$aStockReportList
							$result = $oReport->assetStockReportList($aRequest);
							/*echo '<pre>';
							print_r($result);
							echo '</pre>';
							exit();*/
							$totalAssetValue = 0;
							$totalAssetDepValue = 0;
							$totalAssetDepValuedep = 0;
							
					?>
                    <?php
                    $html='
  	<table class="table table-striped table-hover" border=1>
                            <thead>
                            <tr>
                            <td><b>Item Group 1</b></td>
                            <td><b>Brand / Make</b></td>
                            <td><b>Item</b></td>
                            <td><b>Machine No</b></td>
                            <td><b>Asset no</b></td>
							<td><b>Ins.St.dt</b></td>
							<td><b>Ins.End.dt</b></td>
                            <td><b>Instal Date</b></td>
                            <td><b>Value</b></td>
                            <td>Depre %</td>
                            <td>End.Life.Val</td>
                            <td>Cur.Value</td>
                            </tr>
                            </thead>
							<tbody>';
                                        ?>
                            
                    <?php 
							foreach($result as $aItem)
							{
								$totalAssetValue += $aItem['machine_price'];
								
								
								if( ($aItem['date_of_install'] != '01-01-1970') && ($aItem['machine_price'] > 0) && ($aItem['depressation_percent'] > 0) )
									{
										$purchasedate = $aItem['date_of_install'];
										$purchasePrice = $aItem['machine_price'];
										$saledate = date('Y-m-d');
										$lifeTime  = $oDepreciation->getFinYearDiff($purchasedate,$saledate);
										$startYear = $purchasedate;
										$percent = $aItem['depressation_percent'];

										$deparray = $oDepreciation->reducingBalanceDepreciation($purchasePrice, $lifeTime, $startYear,$percent,$lookup);
										$totdep = count($deparray);
										$finalval = $totdep - 1;
										$writdownvalue = number_format($deparray[$finalval]['Written_Down_Value'],2);
										$totalAssetDepValue += $deparray[$finalval]['Written_Down_Value'];
										
										
										$lifeTimeActual  = $aItem['machine_life'];
										$deparray1 = $oDepreciation->reducingBalanceDepreciation($purchasePrice, $lifeTimeActual, $startYear,$percent,$lookup);
										$totdep1 = count($deparray1);
										$finalval1 = $totdep1 - 1;
										$writdownvalue1 = number_format($deparray1[$finalval1]['Written_Down_Value'],2);
										$totalAssetDepValuedep += $deparray1[$finalval1]['Written_Down_Value'];
										
										
									}
								
					?>
                      <?php
					    
                                $html .= '<tr>
                                <td>'.$aItem['itemgroup1_name'].'</td>
                                <td>'.$aItem['itemgroup2_name'].'</td>
                                <td>'.$aItem['item_name'].'</td> 
                                <td>'.$aItem['machine_no'].'</td>
                                <td>'.$aItem['asset_no'].'</td>
								<td>'.$aItem['ins_start_date'].'</td>
								<td>'.$aItem['ins_end_date'].'</td>
                                <td>'.$aItem['date_of_install'].'</td>
                                <td style="text-align:right;">'.number_format($aItem['machine_price'],2).'</td>
                                <td style="text-align:center;">'.$aItem['depressation_percent'].'</td>
                                <td style="text-align:right;">'.$writdownvalue1.'</td>
								<td style="text-align:right;">'.$writdownvalue.'</td>
                                </tr>';
								$writdownvalue = ''; $writdownvalue1 = '';
		
							} // forloop
							
							$assetDepValue = $totalAssetDepValue;
							$assetDepValueDep = $totalAssetDepValuedep;
			         
                                $html .= '<tr><td colspan="12" style="height:20px;">&nbsp;</td></tr>
								<tr>
                                <td colspan="4" style="text-align:right; font-weight:bold; font-size: 14px;">Total Asset Actual Value</td>
                                <td colspan="2" style="text-align:right; font-weight:bold;">'.number_format($totalAssetValue,2).'</td>
                                <td colspan="4" style="text-align:right; font-weight:bold; font-size: 14px;">Total Current Depreciated Value</td>
                                <td colspan="2" style="text-align:right; font-weight:bold;">'.number_format($assetDepValue,2).'</td>
                                </tr>
								<tr>
                                <td colspan="4" style="text-align:right; font-weight:bold; font-size: 14px;"></td>
                                <td colspan="2" style="text-align:right; font-weight:bold;"></td>
                                <td colspan="4" style="text-align:right; font-weight:bold; font-size: 14px;">Total End of Life Depreciated Value</td>
                                <td colspan="2" style="text-align:right; font-weight:bold;">'.number_format($assetDepValueDep,2).'</td>
                                </tr>
                                </tbody>
                           </table>';
                      
				      }//end if assetlist
					  //echo $html;
					  //exit();
				?>

<?php
$stylesheet = file_get_contents('MPDF56/mpdfstylesheet.css');
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($html);
$time_pdf =strtotime("now");
$file_pdf_name = "AssetReport_".$time_pdf.".pdf";
$mpdf->Output($file_pdf_name, 'D'); // Download PDF file in browser
//$mpdf->Output('PDF/'.$file_pdf_name, 'I'); // Display PDFin browser
$pdf_op =$mpdf->Output('PDF/'.$file_pdf_name, 'F'); // Downloadpdf file in specific dolder
$mpdf->Output('PDF/'.$file_pdf_name, 'I'); // Display PDFin browser
$_SESSION['stockreport'] = $file_pdf_name;
//echo 'PDF/'.$file_pdf_name;
//echo $file_pdf_name;
//exit();
header("Location: PDFList.php");
?>