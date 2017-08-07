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
  
  $sessReportFuelList = $oSession->getSession('sess_ReportFuellist');
  $aRequest = $sessReportFuelList;
  
	$pageNum = 1;
	$rowsPerPage = 20;
	if($aRequest['fItemName'] == '' || $aRequest['fItemName'] == '0')
  	  {
	  	$atransReportList = $oTransport->getFuelTokenInfoAll($aRequest);
  	  }
	  else
	  {
 	$atransReportList 	= $oTransport->getFuelTokenInfo($aRequest);
	  }
	  if($aRequest['fItemName'] == '' || $aRequest['fItemName'] == '0')
	  {
	  $aFuelDetails = $oTransport->getFuelInfoallItems($aRequest);
	  }
	  else
	  {
		$aFuelDetails = $oTransport->getFuelInfo($aRequest);
	  }
	
	include("MPDF56/mpdf.php");
	$mpdf=new mPDF('utf-8','A4-L','','','10','10','10','31','5','5','5');					
		
	if(empty($atransReportList))
  	{
  	$html='
  	<table class="table table-striped table-hover">
	<tbody>
    <tr><td colspan="10" style="text-align:center">No Result Found.</td></tr></tbody>
	</table>'; 
	} 
	else 
	{ 
	$html='
    <table class="table table-striped table-hover" border="1" cellspacing="0" cellpadding="6" style="border-color:#fefefe;">
	<thead>
		<tr>
			<th>S.No</th>
			<th>Vehicle Number</th>
			<th>Asset Number</th>
			<th>Token Date</th>
			<th>Token Number</th>
			<th>Fuel Type</th>
			<th>Fuel Qty</th>
			<th>Oil Qty</th>
			<th>OMR</th>
			<th>CMR</th>
		</tr>
	</thead>
	<tbody>'; 
	}
	$sl_no = 1;
if($aRequest['fItemName'] == '' || $aRequest['fItemName'] == '0')
  {
foreach($aFuelDetails['assetinfo'] as $fueldetailsres) 
{ 
foreach($fueldetailsres as $fueldetailsresults) 
{ 
$machine_no = $fueldetailsresults['machine_no'];
$asset_no = $fueldetailsresults['asset_no'];
}
}
}
else
{
$machine_no = $aFuelDetails['assetinfo']['machine_no'];
$asset_no = $aFuelDetails['assetinfo']['asset_no'];	
}
	
	foreach($atransReportList as $transReport) 
	{
		$html.='
		<tr>
			<td>'.$sl_no.'</td>
			<td>'.$machine_no.'</td>
			<td>'.$asset_no.'</td>
			<td>'.date('d-m-Y',strtotime($transReport['token_date'])).'</td>
			<td>'.$transReport['token_no'].'</td>
			<td>'.$_aFuelType[$transReport['id_fuel_type']].'</td>
			<td>'.$transReport['qty'].'</td>
			<td>'.$transReport['oil_qty'].'</td>
			<td>'.$transReport['omr'].'</td>
			<td>'.$transReport['cmr'].'</td>
			</tr>';
			$fuel_amt += $transReport['qty'];
			$oil_amt += $transReport['oil_qty']; 
			$sl_no++;
		}
		$html.='<tr><td><b>TOTAL :</b></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><b>'.$fuel_amt.'</b></td><td><b>'.$oil_amt.'</b></td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table>';
						
$stylesheet = file_get_contents('MPDF56/mpdfstylesheet.css');
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($html);
$time_pdf =strtotime("now");
$file_pdf_name = "TransportReport_".$time_pdf.".pdf";
$mpdf->Output($file_pdf_name, 'D'); // Download PDF file in browser
//$mpdf->Output('PDF/'.$file_pdf_name, 'I'); // Display PDFin browser
$pdf_op =$mpdf->Output('PDF/'.$file_pdf_name, 'F'); // Downloadpdf file in specific dolder
$mpdf->Output('PDF/'.$file_pdf_name, 'I'); // Display PDFin browser
$_SESSION['transportreport'] = $file_pdf_name;
?>
