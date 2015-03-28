<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  
  $oAssetUnit = &Singleton::getInstance('AssetUnit');
  $oAssetUnit->setDb($oDb);
  $oAssetVendor = &Singleton::getInstance('Vendor');
  $oAssetVendor->setDb($oDb);
  $oAssetDepartment = &Singleton::getInstance('Department');
  $oAssetDepartment->setDb($oDb);
  
  $id_salesInvoice = $aRequest['id'];
  
  $allResult = $oMaster->getSalesInvoiceList($id_salesInvoice);
  
  $allResultinvoice = $oMaster->getSalesInvoiceItemInfo($allResult[0]['id_asset_sales_invoice']);
  
  $sal_addr = $oMaster->getPrintUnitAddress($allResult[0]['id_company']);
  
  $aVendorInfo = $oAssetVendor->getVendorInfo($allResult[0]['id_vendor']);
  
  $salvendor_addr = $oMaster->getPrintUnitAddress($aVendorInfo['id_vendor_address']);
  /*print_r($salvendor_addr);
  print_r($allResultinvoice);
  print_r($aVendorInfo);*/
  ?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| SalesInvoice </title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <meta http-equiv="Cache-control" content="No-Cache">
   
   <script type="text/javascript">
<!--
    function printPartOfPage(elementId) {
        var printContent = document.getElementById(elementId);
        var windowUrl = 'PURCHASE';
        var uniqueName = new Date();
        var windowName = 'Print' + uniqueName.getTime();
        var printWindow = window.open(windowUrl, windowName, 'left=0,top=0,width=0,height=0');
        printWindow.document.write(printContent.innerHTML);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }
    // -->
    </script>

<STYLE>FONT.title {
	FONT-FAMILY: arial; FONT-SIZE: 12px;
}
FONT.subtitle {
	FONT-FAMILY: arial; FONT-SIZE: 11px;
}
FONT.detail {
	FONT-FAMILY: arial; FONT-SIZE: 11px;
}
FONT.HEADING {
	FONT-FAMILY: arial; FONT-SIZE: 11px;
}
BR.page {
	PAGE-BREAK-BEFORE: always;
}
TR.sRow {
	HEIGHT: 15px;
}
TR.TwoRow {
	HEIGHT: 30px;
}
TD {
	FONT-FAMILY: arial; FONT-SIZE: 11px;
}
TABLE.bor {
	BORDER-BOTTOM: black solid; BORDER-LEFT: black solid; BORDER-TOP: black solid; BORDER-RIGHT: black solid;
}
.font1 {
	FONT-FAMILY: arial; COLOR: #000099; FONT-SIZE: 9px;
}
.selsty {
	WIDTH: 250px; FONT-FAMILY: arial; BACKGROUND: #e7f8f7; COLOR: #91008b; FONT-SIZE: 12px; FONT-WEIGHT: bolder;
}
.SELDATE {
	FONT-FAMILY: arial; BACKGROUND: #e7f8f7; COLOR: #91008b; FONT-SIZE: 12px; FONT-WEIGHT: bolder;
}
.butsty {
	BORDER-BOTTOM: #104a7b 1px solid; BORDER-LEFT: #afc4d5 1px solid; FONT-FAMILY: arial,sans-serif; BACKGROUND: #efefef; HEIGHT: 24px; COLOR: #000066; FONT-SIZE: 12px; BORDER-TOP: #afc4d5 1px solid; CURSOR: hand; BORDER-RIGHT: #104a7b 1px solid; TEXT-DECORATION: none;
}
</STYLE>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body >
	
<DIV style="Z-INDEX: 1; POSITION: absolute; HEIGHT: 10px; VISIBILITY: visible; TOP: 10px; LEFT: 0px; RIGHT:100px" align="right" >
<TABLE border=0 cellSpacing=0 cellPadding=0 width="100%">
  <TBODY>
   <TR align="right">
    <TD width="100%"><a onClick="JavaScript:printPartOfPage('print_content');" style="cursor:pointer;"><img src="assets/img/printer.png" title="printer" height="50" width="50"></a> </TD>
    <TD></TD></TR></TBODY></TABLE>
 </DIV>
  
  <div id="print_content">
<TABLE cellSpacing="0" cellPadding="0" width="100%" align="center">
  <TBODY>
  <TR class="srow">
    <TD align="right">&nbsp;</TD></TR>
  <TR class="srow">
    <TD align="center"><FONT size=4 face=arial><B> SALES INVOICE</B></FONT></TD></TR></TBODY></TABLE><BR>
<TABLE border="1" cellSpacing="0" borderColor="black" cellPadding="0" width="100%" 
align="center">
  <TBODY>
  <TR bgColor="white">
    <TD bgColor="white">
      <TABLE border="0" cellSpacing="0"  cellPadding="0" width="100%" bgColor="white" align="center">
        <TBODY>
        <TR>
          <TD width="40%"><?php echo $aCompany['address_format'];?></TD>
          <TD width="20%" align="center">
            <TABLE border="0" cellSpacing="0"cellPadding="0" width="100%" 
            align="center">
              <TBODY>
              <TR align="center"><img src="uploads/companylogo/<?php echo $aCompany['company_logo'];?>" width="75" height="75"> </TR></TBODY></TABLE></TD>
          <TD width="40%">
            <TABLE border="0" cellSpacing="0" cellPadding="0" width="100%" 
align="right">
              <TBODY>
              <TR class="srow">
                <TD>&nbsp;</TD></TR>
              <TR class="srow">
                <TD width="30%" align="left"><FONT class="subtitle">TIN 
                NO.</FONT></TD>
                <TD><FONT class="subtitle">:  <?php echo $aCompany['id_tin'];?></FONT></TD></TR>
              <TR class="srow">
                <TD width="30%" align="left"><FONT class="subtitle">CST 
                  NO./DATE</FONT></TD>
                <TD><FONT class="subtitle">:  <?php echo $aCompany['id_cst_date'];?></FONT></TD></TR>
              <TR class="srow">
                <TD width="30%" align="left"><FONT 
class="subtitle">PHONE</FONT></TD>
                <TD><FONT class="subtitle">: <?php echo $aCompany['phone'];?></FONT></TD></TR>
              <TR class="srow">
                <TD width="30%" align="left"><FONT class="subtitle">FAX</FONT></TD>
                <TD><FONT class="subtitle">: <?php echo $aCompany['fax'];?></FONT></TD></TR>
              <TR class="srow">
                <TD width="30%" align="left"><FONT 
class="subtitle">EMAIL</FONT></TD>
                <TD>: <FONT class="subtitle"><?php echo $aCompany['email'];?></FONT> 
              </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE><BR>
              
              <TABLE cellSpacing="0" cellPadding=0 width="100%" bgColor="black"  borderColor="black" align="center" border="1">
  <TBODY>
  <TR bgColor="white">
    <TD >
<TABLE cellSpacing="0" cellPadding=0 width="100%" bgColor="black"  borderColor="black" align="center" border="0">
  <TBODY>
  <TR bgColor="white">
   <TD vAlign="top" width="30%">
             <span><b>&nbsp;FROM :</b></span>
			 
			  <TABLE border="0" cellSpacing="0" cellPadding="0" width="100%" 
align="left" style="font-family:Arial, Helvetica, sans-serif;margin-left: 15px;" >
              <TBODY>
              <TR class="srow">
               <TD align="left"><FONT size="2"><b><?php echo $allResult[0]['company_name'];?></b></FONT></TD></TR>
               <TR class="srow">
               <TD><?php echo $sal_addr[address_format];?></TD>
               </TR>
                </TBODY>
              </TABLE> 
	
           </TD>
   <TD vAlign="top" width="30%">
             <span><b>&nbsp;TO :</b></span>
	 <TABLE border="0" cellSpacing="0" cellPadding="0" width="100%" 
align="left" style="font-family:Arial, Helvetica, sans-serif;margin-left: 15px;" >
              <TBODY>
              <TR class="srow">
                <TD align="left"><FONT size="2"><b><?php echo $allResult[0]['vendor_name'];?></b></FONT></TD></TR>
                <TR><TD><?php echo $salvendor_addr['address_format']; ?></TD></TR>
              </TBODY>
              </TABLE> 
           </TD>
    <TD width="35%">
            <TABLE cellSpacing="0" cellPadding="0" width="100%"  align="center">
              <TBODY>
			  
			    <TR class="srow" align="left">
                <TD><FONT  class="detail">&nbsp;INVOICE DATE</FONT></TD>
                <TD><FONT  class="detail">: &nbsp;<?php echo date('d/m/Y',strtotime($allResult[0]['invoice_date']));?></FONT></TD></TR>
                 <TR class="srow" align="left">
                <TD><FONT  class="detail">&nbsp;INVOICE NO</FONT></TD>
                <TD><FONT  class="detail">: &nbsp;<?php echo $allResult[0]['invoice_number'];?></FONT></TD></TR>
              <TR class="srow" align="left">
                <TD><FONT  class="detail">&nbsp;DELIVERY NO</FONT></TD>
                <TD><FONT  class="detail">: &nbsp;<?php echo $allResult[0]['delivery_number'];?></FONT></TD></TR>
                 <TR class="srow" align="left">
                <TD><FONT  class="detail">&nbsp;DELIVERY TYPE</FONT></TD>
                <TD><FONT  class="detail">: &nbsp;<?php echo $allResult[0]['delivery_type'];?></FONT></TD></TR>
                
                
             </TBODY></TABLE></TD>
</TR>
</TBODY>
</TABLE>
</TD></TR></TBODY></TABLE>
<BR><BR>

<TABLE border="1" cellSpacing="0" cellPadding="0" width="100%" bgColor="black" align="center" bordercolor="#000000">
  <TBODY>
  <TR align="center" bgColor="white">
    <TD width="3%"><B>SLNO</B></TD>
    <TD width="20%"><B>PARTICULARS</B></TD>
    <TD width="5%"><B> + / - </B></TD>
     <TD width="5%"><B>AMOUNT IN <?php echo Currencycode;?></B></TD>
   </TR>
 
  <?php 
   $sl_nos = 1;
 ?>
  <TR class="srow" bgColor="white">
    <TD align="center"><?php echo $sl_nos;?>&nbsp;&nbsp;</TD>
    <TD align="left">&nbsp;&nbsp;<?php echo $allResultinvoice['itemgroup1_name'].'('.$allResultinvoice['itemgroup2_name'].')';?>&nbsp;&nbsp;</TD>
    <TD  align="right"><?php echo '<b>Tax Price&nbsp;('.$allResultinvoice['tax_percentage'].'%)</b>';?> &nbsp;</TD>
    
    <TD noWrap align="right"><?php echo $oMaster->moneyFormat($allResultinvoice['tax_price']);?> &nbsp;</TD>
      </TR>
      
    <?php $sl_nos++; 
	  ?>
      <TR class="srow" bgColor="white">
    <TD colSpan="3" align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Sold Price </b> &nbsp;&nbsp;
      </TD>
      <TD align="right"><B><?php echo $oMaster->moneyFormat($allResultinvoice['total_price']);?>&nbsp;&nbsp;</B></TD></TR>
       
    <TR class="srow" bgColor="white">
    <TD colSpan="3" align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total Amount ( <?php echo Currencycode;?> )</b> &nbsp;&nbsp; </TD>
 
    <TD align="right"><B><?php echo $total = $allResultinvoice['tax_price'] + $allResultinvoice['total_price'];?>&nbsp;&nbsp;</B></TD></TR>
  
</TBODY></TABLE>
<BR><BR><BR><BR>
<TABLE border='0' cellSpacing='0' borderColor='black' cellPadding='0 'width="100%" 
align='center'>
  <TBODY>
   <TR><TD width="25%" align='left'><?php echo $allResultinvoice[employee_invoiceprepname];?></TD>
    <TD width="25%" colSpan=2 align='center'></TD>
<TD width="25%" align='right'></TD></TR>
  <TR class='srow' align='center'>
    <TD width="25%" align='left'><FONT class=subtitle><B>PREPARED 
    BY</B></FONT></TD>
    <TD width="25%" colSpan=2 align='center'><FONT class=subtitle><B>VERIFIED 
      BY</B></FONT></TD>
    <TD width="25%" align='right'><FONT class=subtitle><B>APPROVED 
    BY</B></FONT></TD></TR>
   <TR class='srow'>
    <TD colSpan='4'>
      <HR width="100%" bordercolor="black" border="1">
    </TD></TR></TBODY></TABLE></TD></TR></TABLE>
    </div></BODY></HTML>