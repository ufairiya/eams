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
  
	$pageNum = 1;
	$rowsPerPage = 20;
	include("MPDF56/mpdf.php");
	$mpdf=new mPDF('utf-8','A4-L','','','10','10','10','31','5','5','5');					
		
	if(empty($arr_stock ))
  	{
  	$html='
  	<table class="table table-striped table-hover">
	<tbody>
    <tr><td colspan="10" style="text-align:center">No Result Found.</td></tr></tbody>
	</table>'; 
	} 
	else 
	{ 
	$html = '';
	foreach($arr_stock as $stock)
	{
		$total_counts = 0;
		$html .= '<h2 align="center">'.$stock['store_name'].'</h2>';
	$html .='
    <table class="table table-striped table-hover" border="1" cellspacing="0" cellpadding="6" style="border-color:#fefefe;">
	<thead>
		<tr>
			<th>S.No</th>
			<th>Item Group1</th>
			<th>Brand / Make</th>
			<th>Item</th>
			<th>Stock Count</th>			
		</tr>
	</thead>
	<tbody>'; 
	
	$sl_no = 1;
	 
	foreach($stock['stock'] as $aStore) { 
		$net_total +=$aStore['item_count']; 
			$total_counts+=$aStore['item_count'];
		$html.='
		<tr>
			<td>'.$sl_no.'</td>
			<td>'.$aStore['itemgroup1_name'].'</td>
			<td>'.$aStore['itemgroup2_name'].'</td>			
			<td>'.$aStore['item_name'].'</td>
			<td>'.$aStore['item_count'].'</td>
			</tr>';
			
			$sl_no++;
		}
		$html.='<tr>
		<td colspan="4" style="text-align:right;">Total:</td>
		<td><b>'.$total_counts.'</b></td>
		</tr>';
		$html.='</tbody></table><pagebreak />';
	}
	}
	
$stylesheet = file_get_contents('MPDF56/mpdfstylesheet.css');
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($html);
$time_pdf =strtotime("now");
$file_pdf_name = "Storewise_".$time_pdf.".pdf";
$mpdf->Output($file_pdf_name, 'D'); // Download PDF file in browser
//$mpdf->Output('PDF/'.$file_pdf_name, 'I'); // Display PDFin browser
$pdf_op =$mpdf->Output('PDF/'.$file_pdf_name, 'F'); // Downloadpdf file in specific folder
$mpdf->Output('PDF/'.$file_pdf_name, 'I'); // Display PDFin browser
$_SESSION['Storewisereport'] = $file_pdf_name;
?>
