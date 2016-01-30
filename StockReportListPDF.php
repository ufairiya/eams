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
  
  $oAssetType = &Singleton::getInstance('AssetType');
  $oAssetType->setDb($oDb);
  
  $sesReportItemList = $oSession->getSession('ses_ReportItemlist');
  $aRequest = $sesReportItemList;



	$pageNum = 1;
	$rowsPerPage = 20;
 $aSearchList =	$oMaster->getSearchLabel($sesReportItemList);

 $astockReportListcount = $oReport->stockReportList($sesReportItemList,'count');

 $astockReportList 	= $oReport->stockReportList( $sesReportItemList,'' );
include("MPDF56/mpdf.php");
$mpdf=new mPDF('utf-8','A4-L','','','10','10','10','31','5','5','5');					
	
?>

                               
                              
 <?php  if(empty($astockReportListcount))
  {
	  
  ?> 
  <?php 
  $html='
  	<table class="table table-striped table-hover">
	<thead>
											<tr>
												<th>SLNO</th>
                                                <th>Asset Type</th>
                                                <th>Item Group 1</th>
                                                <th>Item Group 2</th>
                                                <th>Item</th>
                                                <th>Machine Number</th>
                                                <th>Asset Number</th>
                                                <th>Image</th>
												
                                                <th>Store Name</th>
                                                <th>Unit Name</th>
                                                <th>Status</th>
                                               
											</tr>
										</thead>
										<tbody>
    <tr><td colspan="10" style="text-align:center">No Result Found.</td></tr>
	</table>'; 
	
	?>
	<?php
     
	 
  } else { ?>
									<?php
									$html='
                                    <table class="table table-striped table-hover" border="1" cellspacing="0" cellpadding="1" style="border-color:#fefefe;">
										<thead>
											<tr>
												<th>S.No</th>
                                                <th>Asset Type</th>
                                                <th>Item Group 1</th>
                                                <th>Item Group 2</th>
                                                <th>Item</th>
                                                <th>Machine Number</th>
                                                <th>Asset Number</th>
                                                <th>Store</th>
                                                <th>Unit Name</th>
                                                <th>Status</th>
                                               
											</tr>
										</thead>
										<tbody>'; ?>
                                        
                                        <?php
                                        }
										
										 
										 $offset 		= ($pageNum - 1 )	* $rowsPerPage; 
										 $sl_no = $offset +1;
										foreach($astockReportList as $stockReport) {
																						
                                            $html.='
											<tr>
												<td>'.$sl_no.'</td>
                                                <td>'.$oAssetType->getAssetTypeName($stockReport['id_itemgroup1']).'</td>
                                                <td>'.$stockReport['itemgroup1_name'].'</td>
												<td>'.$stockReport['itemgroup2_name'].'</td>
                                                <td>'.$stockReport['item_name'].'</td>
                                                <td>'.$stockReport['machine_no'].'</td>
                                                <td>'.$stockReport['asset_no'].'</td>
                                                
                                                <td>'.$stockReport['store_name'].'</td>
                                                <td>'.$stockReport['unit_name'].'</td>
                                                <td>'.$oUtil->AssetItemStatus($stockReport['status']).'</td>
                                              	</tr>'; ?>
											<?php 
											$sl_no++; 
											} ?>
                                            
											<?php $html.='
										</tbody>
									</table>'; ?>
                                    <?php //} ?>
                                    
                                    <?php
									
									
$stylesheet = file_get_contents('MPDF56/mpdfstylesheet.css');
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($html);
$time_pdf =strtotime("now");
$file_pdf_name = "StockReport_".$time_pdf.".pdf";
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
