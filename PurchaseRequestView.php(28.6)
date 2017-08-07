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
  
  if($aRequest['id']!='')
  {
	 $item_id =$aRequest['id'];
	  $vendor_id =$aRequest['vendorId'];
  }
  else
  {
     $item_id = $aRequest['purchaseRequestId'];
  }
  $edit_result = $oMaster->getPurchaseRequestItemInfo($item_id,'id');
  $allResult = $oMaster->getPurchaseRequestInfo($edit_result['iteminfo'][0]['id_pr'],'id');
  $aVendorAddressInfo =  $oMaster->getVendorAddress($vendor_id,'');	
  $oAssetVendor = &Singleton::getInstance('Vendor');
  $oAssetVendor->setDb($oDb);
   ?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| PurchaseRequest </title>
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
    <TD align="center"><FONT size=4 face=arial><B> PURCHASE REQUEST</B></FONT></TD></TR></TBODY></TABLE><BR>
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
      <TABLE cellSpacing="0" cellPadding="0" width="100%" align="center">
        <TBODY>
        <TR class="srow" align="left">
          <TD vAlign="top" width="60%">
            <TABLE cellSpacing=0 cellPadding=0 width="100%" align="center">
              <TBODY>
              <TR class="srow">
                <TD> <?php echo $aVendorAddressInfo['address_format'];?> </TD></TR></TBODY></TABLE></TD>
          <TD width="40%">
            <TABLE cellSpacing="0" cellPadding="0" width="100%"  align="center">
              <TBODY>
              <TR class="srow" align="left">
                <TD width="30%"><B><FONT class="detail">&nbsp;PR NO.</FONT></B></TD>
                <TD width="70%"><B>:&nbsp;<?php echo $edit_result['iteminfo'][0]['request_no']; ?></B></TD></TR>
              <TR class="srow" align="left">
                <TD><FONT  class="detail">&nbsp;DATE</FONT></TD>
                <TD><FONT  class="detail">: &nbsp;<?php echo date('d/m/Y');?></FONT></TD></TR>
                 <TR class="srow" align="left">
                <TD><FONT  class="detail">&nbsp;<B>DUE DATE</B></FONT></TD>
               
                <TD><FONT  class="detail">: &nbsp;<B><?php echo date('d/m/Y',strtotime($allResult['require_date']));?></B></FONT></TD></TR>
                </TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE><BR>
                
                
<TABLE border="1" cellSpacing="0" cellPadding="0" width="100%" bgColor="black" align="center" bordercolor="#000000">
  <TBODY>
  <TR align="center" bgColor="white">
    <TD width="5%"><B>SLNO</B></TD>
    <TD width="35%"><B>PARTICULARS </B></TD>
    <TD width="10%"><B>QUANTITY</B></TD>
	 <TD width="10%"><B>RATE IN <?php echo Currencycode;?></B></TD>
    <TD width="15%"><B>AMOUNT IN <?php echo Currencycode;?></B></TD>
   </TR>
    <?php 
	$sl_no = 1;
	foreach ($edit_result['iteminfo'] as $purchaseitem){
		$net_qty +=$purchaseitem['qty']; ?>
  <TR class="srow" bgColor="white">
    <TD align="right"><?php echo $sl_no;?>&nbsp;&nbsp;</TD>
	<TD>&nbsp;&nbsp;<?php echo $purchaseitem['itemgroup1_name'].'-'.$purchaseitem['itemgroup2_name'].'-'.$purchaseitem['item_name'];?>&nbsp;&nbsp;</TD>
   
    <TD noWrap align="right"><B><?php echo $purchaseitem['qty'];?></B> &nbsp; <?php echo $purchaseitem['uom_name'];?> &nbsp;</TD>
	 <TD noWrap align="right"><?php echo $oMaster->moneyFormat($purchaseitem['unit_cost']);?> &nbsp;</TD>
    <TD noWrap align="right"><?php  $unittotal =  $purchaseitem['qty'] * $purchaseitem['unit_cost'] ;
	echo $oMaster->moneyFormat($unittotal);
	?> &nbsp;</TD>
      <?php 
	  $net_total +=$unittotal;
	  $sl_no ++;
	  } ?>
  <TR class="srow" bgColor="white">
   
    <TD>&nbsp;</TD>
    <TD>&nbsp;</TD>
    <TD>&nbsp;</TD>
    <TD>&nbsp;</TD>
	 <TD>&nbsp;</TD>
    </TR>
  <TR class="srow" bgColor="white">
    <TD colSpan="2" align="right">Total Qty&nbsp;</TD>
    <TD align="right"><B>&nbsp;<?php echo $net_qty ;?>&nbsp;</B>&nbsp;</TD>
	 <TD>&nbsp;</TD>
    <TD align="right"><B>&nbsp;<?php echo  $oMaster->moneyFormat($net_total);?>&nbsp;&nbsp;</B></TD>
   </TR>
   <TR class="srow" bgColor="white">
    <TD colSpan="4" align="right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total Amount( <?php echo Currencycode;?> )</b> &nbsp;&nbsp;
      </TD>
 
    <TD align="right"><B><?php echo $oMaster->moneyFormat($net_total) ;?>&nbsp;&nbsp;</B></TD></TR>
     </TR>
   
</TBODY></TABLE>
<BR>
<?php if($allResult['terms_and_conditions']!='')
{?>
       
<TABLE cellSpacing="0" cellPadding="0" width="100%" bgColor="black" align="center" border="1">
  <TBODY>
  <TR class="srow" align="left" bgColor="white">
    <TD ><B>&nbsp;TERMS AND CONTIDION </B></TD>
     <TR class='srow' align='left' bgColor='white'>
    <TD><FONT class="subtitle">&nbsp;&nbsp;<?php echo $allResult['terms_and_conditions'];?></FONT></TD>
   </TR></TBODY></TABLE>
<?php } ?> 
<?php if($allResult['remarks']!='')
{?>
<BR>       
<TABLE cellSpacing="0" cellPadding="0" width="100%" bgColor="black" align="center" border="1">
  <TBODY>
  <TR class="srow" align="left" bgColor="white">
    <TD ><B>&nbsp;Remarks </B></TD>
     <TR class='srow' align='left' bgColor='white'>
    <TD><FONT class="subtitle">&nbsp;&nbsp;<?php echo $allResult['remarks'];?></FONT></TD>
   </TR></TBODY></TABLE>
<?php } ?> 
<BR>
<TABLE border='0' cellSpacing='0' borderColor='black' cellPadding='0' width="100%" 
align='center'>
  <TBODY>
  <tr><B>REQUESTER NAME :</B> &nbsp;&nbsp;<?php echo $allResult['employee_name'];?></tr>
  </TBODY></TABLE>
<BR>
<TABLE border='0' cellSpacing='0' borderColor='black' cellPadding='0' width="100%" 
align='center'>
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
     </div>
    
</body>
<!-- END BODY -->
</html>