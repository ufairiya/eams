<?php 

  include_once 'ApplicationHeader.php'; 

  if(!$oCustomer->isLoggedIn())

  {

	header("Location: login.php");

  }

  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');

  $aRequest = $_REQUEST;

 

  $oAssetDepartment = &Singleton::getInstance('Department');

  $oAssetDepartment->setDb($oDb);

  $item_id =$aRequest['id'];

   $vendor_id =$aRequest['vendorId'];

  $aVendorAddressInfo =  $oMaster->getVendorAddress($vendor_id,'');	

  $edit_result = $oMaster->getPurchaseRequestItemInfo($item_id,'id');

  $oAssetVendor = &Singleton::getInstance('Vendor');

  $oAssetVendor->setDb($oDb);

 $allResult = $oMaster->getPurchaseRequestInfo($edit_result['iteminfo'][0]['id_pr'],'id');

include("MPDF56/mpdf.php");

$mpdf=new mPDF('utf-8','A4','','','10','10','10','31','5','5','5');

$html='

<TABLE cellSpacing="0" cellPadding="0" width="100%" align="center" style="face="arial">">

  <TBODY>

  <TR class="srow">

    <TD align="right">&nbsp;</TD></TR>

  <TR class="srow">

    <TD align="center"><FONT size=4 face="arial"><B>PURCHASE REQUEST</B></FONT></TD></TR></TBODY></TABLE><BR>

<TABLE border="1" cellSpacing="0" borderColor="black" cellPadding="0" width="100%" 

align="center">

  <TBODY>

  <TR bgColor="white">

    <TD bgColor="white">

      <TABLE border="0" cellSpacing="0"  cellPadding="0" width="100%" bgColor="white" align="center">

        <TBODY>

        <TR>

          <TD width="40%">'.$aCompany["address_format"].'</TD>

          <TD width="20%" align="center">

            <TABLE border="0" cellSpacing="0"cellPadding="0" width="100%" 

            align="center">

              <TBODY>

			  

              <TR align="center"><td><img style="vertical-align: top" src="uploads/companylogo/'.$aCompany["company_logo"].'" width="80" /></td> </TR></TBODY></TABLE></TD>

          <TD width="40%">

            <TABLE border="0" cellSpacing="0" cellPadding="0" width="100%" 

align="right">

              <TBODY>

              <TR class="srow">

                <TD>&nbsp;</TD></TR>

              <TR class="srow">

                <TD width="30%" align="left"><FONT class="subtitle">TIN 

                NO.</FONT></TD>

                <TD><FONT class="subtitle">: '. $aCompany["id_tin"].'</FONT></TD></TR>

              <TR class="srow">

                <TD width="30%" align="left"><FONT class="subtitle">CST 

                  NO./DATE</FONT></TD>

                <TD><FONT class="subtitle">: '.$aCompany["id_cst_date"].'</FONT></TD></TR>

              <TR class="srow">

                <TD width="30%" align="left"><FONT 

class="subtitle">PHONE</FONT></TD>

                <TD><FONT class="subtitle">: '. $aCompany["phone"].'</FONT></TD></TR>

              <TR class="srow">

                <TD width="30%" align="left"><FONT class="subtitle">FAX</FONT></TD>

                <TD><FONT class="subtitle">: '.$aCompany["fax"].'</FONT></TD></TR>

              <TR class="srow">

                <TD width="30%" align="left"><FONT 

class="subtitle">EMAIL</FONT></TD>

                <TD>: <FONT class="subtitle">'.$aCompany["email"].'</FONT> 

              </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE><BR>

<TABLE cellSpacing="0" cellPadding=0 width="100%" bgColor="black"  borderColor="black" align="right" border="1">

  <TBODY>

  <TR bgColor="white">

    <TD >

      <TABLE cellSpacing="0" cellPadding="0" width="100%" align="left">

        <TBODY>

        <TR class="srow" align="left">

          <TD vAlign="top" width="75%">

            <TABLE cellSpacing=0 cellPadding=0 width="100%">

              <TBODY>

              <TR class="srow">

                <TD> '.$aVendorAddressInfo["address_format"].' </TD></TR></TBODY></TABLE></TD>

          <TD width="25%">

            <TABLE cellSpacing="0" cellPadding="0" width="100%"  align="right">

              <TBODY>

              <TR class="srow" align="right">

                <TD width="30%"><B><FONT class="detail">&nbsp;PR NO.</FONT></B></TD>

                <TD width="70%"><B>:&nbsp;'.$edit_result['iteminfo'][0]["request_no"].'</B></TD></TR>

              <TR class="srow" align="right">

                <TD><FONT  class="detail">&nbsp;DATE</FONT></TD>

                <TD><FONT  class="detail">: &nbsp;'.date("d/m/Y").'</FONT></TD></TR>

				  <TR class="srow" align="right">

                <TD><FONT  class="detail">&nbsp;<B>DUE DATE</B></FONT></TD>

                <TD><FONT  class="detail">:<B> &nbsp;'.date('d/m/Y',strtotime($allResult['require_date'])).'</B></FONT></TD></TR>

				

             </TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE><BR>

<TABLE border="1" cellSpacing="0" cellPadding="0" width="100%" bgColor="black" align="center" bordercolor="#000000">

  <TBODY>

  <TR align="center" bgColor="white">

    <TD width="2%"><B>SLNO</B></TD>

    <TD width="35%"><B>PARTICULARS </B></TD>

    <TD width="5%"><B>QUANTITY</B></TD>

	<TD width="4%"><B>RATE IN '.Currencycode.'</B></TD>

    <TD width="5%"><B>AMOUNT IN '.Currencycode.'</B></TD>

   </TR>

   ';

 

	$sl_no = 1;

	foreach ($edit_result['iteminfo'] as $purchaseitem){

		$net_qty +=$purchaseitem["qty"]; 

		$unittotal1 = $purchaseitem["qty"] * $purchaseitem["unit_cost"];

          $html.='

  <TR class="srow" bgColor="white">

    <TD align="right">'.$sl_no.'&nbsp;&nbsp;</TD>

    <TD>&nbsp;&nbsp;'. $purchaseitem['itemgroup1_name'].'-'.$purchaseitem['itemgroup2_name'].'-'.$purchaseitem['item_name'].'&nbsp;&nbsp;</TD>

    <TD  align="right">'. $purchaseitem["qty"].'&nbsp;&nbsp;'. $purchaseitem["uom_name"].' &nbsp;</TD>

	  <TD noWrap align="right">'. $oMaster->moneyFormat($purchaseitem["unit_cost"]).' &nbsp;</TD>

    <TD noWrap align="right">'. $unittotal = $oMaster->moneyFormat($unittotal1).' &nbsp;</TD>

     ';

	 $net_total +=$unittotal1;

	  $sl_no ++;

	}

	  $html.='

  <TR class="srow" bgColor="white">

   

    <TD>&nbsp;</TD>

    <TD>&nbsp;</TD>

    <TD>&nbsp;</TD>

	<TD>&nbsp;</TD>

    <TD>&nbsp;</TD>

    </TR>

  <TR class="srow" bgColor="white">

    <TD colSpan=2 align="right">Total Qty&nbsp;</TD>

    <TD align="right"><B>&nbsp;'.$net_qty.'&nbsp;</B></TD>

	 <TD>&nbsp;</TD>

    <TD align="right"><B>&nbsp;'.$oMaster->moneyFormat($net_total).'&nbsp;&nbsp;</B></TD>

   </TR>

   <TR class="srow" bgColor="white">

    <TD colSpan="4" align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total Amount ( '.Currencycode.' )</b> &nbsp;&nbsp;

      </TD>

 

    <TD align="right"><B>'. $oMaster->moneyFormat($net_total) .'&nbsp;&nbsp;</B></TD></TR>

</TBODY></TABLE>

<BR>';



if($allResult['terms_and_conditions']!='')

{

  $html.='      

<TABLE cellSpacing="0" cellPadding="0" width="100%" bgColor="black" align="center" border="1">

  <TBODY>

  <TR class="srow" align="left" bgColor="white">

    <TD ><B>&nbsp;TERMS AND CONTIDION </B></TD>

     <TR class="srow" align="left" bgColor="white">

    <TD><FONT class="subtitle">&nbsp;&nbsp;'.$allResult['terms_and_conditions'].'</FONT></TD>

   </TR></TBODY></TABLE>

';

}



if($allResult['remarks']!='')

{

  $html.='      

<BR>

<TABLE cellSpacing="0" cellPadding="0" width="100%" bgColor="black" align="center" border="1">

  <TBODY>

  <TR class="srow" align="left" bgColor="white">

    <TD ><B>&nbsp;Remarks </B></TD>

     <TR class="srow" align="left" bgColor="white">

    <TD><FONT class="subtitle">&nbsp;&nbsp;'.$allResult['remarks'].'</FONT></TD>

   </TR></TBODY></TABLE>

';

}

 $html.='

 <BR>

 

 <TABLE cellSpacing="0" cellPadding="0" width="100%" bgColor="black" align="center" border="0">

  <TBODY>

  <TR class="srow" align="left" bgColor="white">

    <TD ><B>&nbsp;REQUESTER NAME :</B> <FONT class="subtitle">&nbsp;&nbsp;'.strtoupper($allResult['employee_name']).'</FONT></TD>

     

   </TR></TBODY></TABLE>

  

  

   

 <BR>

<TABLE border="0" cellSpacing="0" borderColor="black" cellPadding="0" width="100%" 

align="center">

  <TBODY></TBODY></TABLE>

<HR>

<BR><BR>

<TABLE border="0" cellSpacing="0" borderColor="black" cellPadding=0 width="100%" 

align="center">

  <TBODY>

  <TR class="srow" align="center">

    <TD width="25%" align="left"><FONT class="subtitle"><B>PREPARED 

    BY</B></FONT></TD>

    <TD width="25%" colSpan=2 align="center"><FONT class="subtitle"><B>VERIFIED 

      BY</B></FONT></TD>

    <TD width="25%" align="right"><FONT class="subtitle"><B>APPROVED 

    BY</B></FONT></TD></TR>

  <TR class="srow">

    <TD colSpan=4>

      <HR width="100%" bordercolor="black" border="1">

    </TD></TR></TBODY></TABLE>

   

';

$stylesheet = file_get_contents('MPDF56/mpdfstylesheet.css');

$mpdf->WriteHTML($stylesheet,1);

$mpdf->WriteHTML($html);

$time_pdf =strtotime("now");

$file_pdf_name = "PurchaseRequest_".$item_id.$time_pdf.".pdf";

/*$mpdf->Output('PDF/'.$file_pdf_name, 'D');*/ // Download PDF file in browser

$mpdf->Output('PDF/'.$file_pdf_name, 'I'); // Display PDFin browser

$pdf_op =$mpdf->Output('PDF/'.$file_pdf_name, 'F'); // Downloadpdf file in specific folder

?>

<?php /*?><h1 align="center">View to the Last Report </h1>

<div align="center">

<a href="PDF/<?php echo $file_pdf_name;?>" >Click to view</a></div><?php */?>