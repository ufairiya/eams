<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $allResult = $oMaster->getPurchaseRequestList();
  
    $oAssetVendor = &Singleton::getInstance('Vendor');
  $oAssetVendor->setDb($oDb);
  	$oAssetVendor = &Singleton::getInstance('Vendor');
    $oAssetVendor->setDb($oDb);
  if($_GET['id']!='')
  {
	 $item_id =$_GET['id'];
  }
  else
  {
     $item_id = $_POST['purchaseReturnId'];
  }

	$edit_result  = $oMaster->getPurchaseReturnItemInfo($item_id,'id');
	$aVendorInfo = $oAssetVendor->getVendorInfo($edit_result['purchasereturninfo']['id_vendor'],'id');
	

 /*
echo '<pre>';
 print_r($edit_result);
  print_r($aVendorInfo);
  echo '</pre>';*/
 /* exit();*/

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|Purchase Order </title>
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
	FONT-FAMILY: arial; FONT-SIZE: 12px
}
FONT.subtitle {
	FONT-FAMILY: arial; FONT-SIZE: 11px
}
FONT.detail {
	FONT-FAMILY: arial; FONT-SIZE: 11px
}
FONT.HEADING {
	FONT-FAMILY: arial; FONT-SIZE: 11px
}
BR.page {
	PAGE-BREAK-BEFORE: always
}
TR.sRow {
	HEIGHT: 15px
}
TR.TwoRow {
	HEIGHT: 30px
}
TD {
	FONT-FAMILY: arial; FONT-SIZE: 11px
}
TABLE.bor {
	BORDER-BOTTOM: black solid; BORDER-LEFT: black solid; BORDER-TOP: black solid; BORDER-RIGHT: black solid
}
.font1 {
	FONT-FAMILY: arial; COLOR: #000099; FONT-SIZE: 9px
}
.selsty {
	WIDTH: 250px; FONT-FAMILY: arial; BACKGROUND: #e7f8f7; COLOR: #91008b; FONT-SIZE: 12px; FONT-WEIGHT: bolder
}
.SELDATE {
	FONT-FAMILY: arial; BACKGROUND: #e7f8f7; COLOR: #91008b; FONT-SIZE: 12px; FONT-WEIGHT: bolder
}
.butsty {
	BORDER-BOTTOM: #104a7b 1px solid; BORDER-LEFT: #afc4d5 1px solid; FONT-FAMILY: arial,sans-serif; BACKGROUND: #efefef; HEIGHT: 24px; COLOR: #000066; FONT-SIZE: 12px; BORDER-TOP: #afc4d5 1px solid; CURSOR: hand; BORDER-RIGHT: #104a7b 1px solid; TEXT-DECORATION: none
}
</STYLE>
<BODY>
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
    <TD align="center"><FONT size=4 face=arial><B>PURCHASE RETURN</B></FONT></TD></TR></TBODY></TABLE><BR>
<TABLE border="1" cellSpacing="0" borderColor="black" cellPadding="0" width="100%" 
align="center">
  <TBODY>
  <TR bgColor="white">
    <TD bgColor="white">
      <TABLE border="0" cellSpacing="0"  cellPadding="0" width="100%" bgColor="white" align="center">
        <TBODY>
        <TR>
          <TD width="45%"><?php echo $aCompany['address_format'];?></TD>
          <TD width="15%" align="center">
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
                <TD align="left"><FONT size="2">TIN 
                NO.</FONT></TD>
                <TD><FONT size="2">:  <?php echo $aCompany['id_tin'];?></FONT></TD></TR>
              <TR class="srow">
                <TD align="left"><FONT size="2">CST 
                  NO./Dt</FONT></TD>
                <TD><FONT size="2">:  <?php echo $aCompany['id_cst_date'];?></FONT></TD></TR>
              <TR class="srow">
                <TD align="left"><FONT 
size="2">PHONE</FONT></TD>
                <TD><FONT size="2">: <?php echo $aCompany['phone'];?></FONT></TD></TR>
              <TR class="srow">
                <TD align="left"><FONT size="2">FAX</FONT></TD>
                <TD><FONT size="2">: <?php echo $aCompany['fax'];?></FONT></TD></TR>
              <TR class="srow">
                <TD align="left"><FONT 
size="2">EMAIL</FONT></TD>
                <TD>: <FONT size="2"><?php echo $aCompany['email'];?></FONT> 
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
                <TD  align="left"><FONT size="2"><b><?php echo $edit_result['purchasereturninfo']['store_address_format']['name'];?></b></FONT></TD></TR>
                <TR class="srow">
                <?php if($edit_result['purchasereturninfo']['store_address_format']['contact_name']!='') { ?>
                 <TD  align="left"><FONT size="2"><?php echo $edit_result['purchasereturninfo']['store_address_format']['contact_name'];?></FONT></TD></TR>
                 <?php } ?>
                    <TR class="srow">
                  <TD  align="left"><FONT size="2"><?php echo $edit_result['purchasereturninfo']['store_address_format']['addr1'];?></FONT></TD></TR>
                  <TR class="srow">
                  <?php if($edit_result['purchasereturninfo']['store_address_format']['addr2']!='') { ?>
                  <TD  align="left"><FONT size="2"><?php echo $edit_result['purchasereturninfo']['store_address_format']['addr2'];?></FONT></TD></TR>
                   <?php } ?>
                  <TR class="srow">
                  <?php if($edit_result['purchasereturninfo']['store_address_format']['addr3']!='') { ?>
                   <TD  align="left"><FONT size="2"><?php echo $edit_result['purchasereturninfo']['store_address_format']['addr3'];?></FONT></TD></TR>
                   <TR class="srow">
                   <?php } ?>
                    <TD  align="left"><FONT size="2"><?php echo  $edit_result['purchasereturninfo']['store_address_format']['city_name'].'-'.$edit_result['purchasereturninfo']['store_address_format']['zipcode'];?></FONT></TD></TR>
              </TBODY>
              </TABLE> 
	
           </TD>
   <TD vAlign="top" width="30%">
             <span><b>&nbsp;TO :</b></span>
	 <TABLE border="0" cellSpacing="0" cellPadding="0" width="100%" 
align="left" style="font-family:Arial, Helvetica, sans-serif;margin-left: 15px;" >
              <TBODY>
              <TR class="srow">
                <TD  align="left"><FONT size="2"><b><?php echo $edit_result['purchasereturninfo']['vendor_address_format']['name'];?></b></FONT></TD></TR>
                <TR class="srow">
                <?php if($edit_result['purchasereturninfo']['vendor_address_format']['contact_name']!='') { ?>
                 <TD  align="left"><FONT size="2"><?php echo $edit_result['purchasereturninfo']['vendor_address_format']['contact_name'];?></FONT></TD></TR>
                 <?php } ?>
                    <TR class="srow">
                  <TD  align="left"><FONT size="2"><?php echo $edit_result['purchasereturninfo']['vendor_address_format']['addr1'];?></FONT></TD></TR>
                  <TR class="srow">
                  <?php if($edit_result['purchasereturninfo']['vendor_address_format']['addr2']!='') { ?>
                  <TD  align="left"><FONT size="2"><?php echo $edit_result['purchasereturninfo']['vendor_address_format']['addr2'];?></FONT></TD></TR>
                   <?php } ?>
                  <TR class="srow">
                  <?php if($edit_result['purchasereturninfo']['vendor_address_format']['addr3']!='') { ?>
                   <TD  align="left"><FONT size="2"><?php echo $edit_result['purchasereturninfo']['vendor_address_format']['addr3'];?></FONT></TD></TR>
                   <TR class="srow">
                   <?php } ?>
                    <TD  align="left"><FONT size="2"><?php echo  $edit_result['purchasereturninfo']['vendor_address_format']['city_name'].'-'.$edit_result['purchasereturninfo']['vendor_address_format']['zipcode'];?></FONT></TD></TR>
              </TBODY>
              </TABLE> 
           </TD>
    <TD width="35%">
            <TABLE cellSpacing="0" cellPadding="0" width="100%"  align="center">
              <TBODY>
			  
			    <TR class="srow" align="left">
                <TD ><B><FONT class="detail">&nbsp;PO NO</FONT></B></TD>
                <TD >:&nbsp; &nbsp;<B><?php echo $edit_result['purchasereturninfo']['request_no']; ?></B></TD></TR>
              <TR class="srow" align="left">
                <TD ><B><FONT class="detail">&nbsp;GRN NO</FONT></B></TD>
                <TD >:&nbsp; &nbsp;<B><?php echo $edit_result['purchasereturninfo']['grn_no']; ?></B></TD></TR>
				
				
                <TR class="srow" align="left">
                <TD><FONT  class="detail">&nbsp;DATE</FONT></TD>
                <TD><FONT  class="detail">: &nbsp;<?php echo date('d/m/Y',strtotime($edit_result['purchasereturninfo']['created_on']));?></FONT></TD></TR>
                 <TR class="srow" align="left">
                <TD><FONT  class="detail">&nbsp;DC NO</FONT></TD>
                <TD><FONT  class="detail">: &nbsp;<?php echo $edit_result['purchasereturninfo']['dc_number'];?></FONT></TD></TR>
              <TR class="srow" align="left">
                <TD><FONT  class="detail">&nbsp;DC DATE</FONT></TD>
                <TD><FONT  class="detail">: &nbsp;<?php echo date('d/m/Y',strtotime($edit_result['purchasereturninfo']['dc_date']));?></FONT></TD></TR>
                 <TR class="srow" align="left">
                <TD><FONT  class="detail">&nbsp;BILL NO</FONT></TD>
                <TD><FONT  class="detail">: &nbsp;<?php echo $edit_result['purchasereturninfo']['bill_number'];?></FONT></TD></TR>
                 <TR class="srow" align="left">
                <TD><FONT  class="detail">&nbsp;BILL DATE</FONT></TD>
                <TD><FONT  class="detail">: &nbsp;<?php echo date('d/m/Y',strtotime($edit_result['purchasereturninfo']['bill_date']));?></FONT></TD></TR>
                
                
             </TBODY></TABLE></TD>
</TR>
</TBODY>
</TABLE>
</TD></TR></TBODY></TABLE>


<BR>
             
             <TABLE border="1" cellSpacing="0" cellPadding="0" width="100%" bgColor="black" align="center" bordercolor="#000000">
  <TBODY>
  <TR align="center" bgColor="white">
    <TD width="2%"><B>SLNO</B></TD>
    <TD width="35%"><B>PARTICULARS</B></TD>
    <TD width="5%"><B>QUANTITY I</B></TD>
	 <TD width="5%"><B>RETURN QUANTITY </B></TD>
    <TD width="4%"><B>RATE IN <?php echo Currencycode;?></B></TD>
    <TD width="5%"><B>AMOUNT IN <?php echo Currencycode;?></B></TD>
   </TR>
    <?php 
	$sl_no = 1;
	foreach ($edit_result['iteminfo'] as $purchaseitem){
		$net_qty +=$purchaseitem['return_qty']; ?>
  <TR class="srow" bgColor="white">
    <TD align="right"><?php echo $sl_no;?>&nbsp;&nbsp;</TD>
    <TD>&nbsp;&nbsp;<?php echo $purchaseitem['itemgroup1_name'].'-'.$purchaseitem['itemgroup2_name'].'-'.$purchaseitem['item_name'];?>&nbsp;&nbsp;</TD>
    <TD  align="right"><?php echo $purchaseitem['qty'];?>&nbsp;&nbsp;<?php echo $purchaseitem['uom_name'];?> &nbsp;</TD>
	 <TD  align="right"><?php echo $purchaseitem['return_qty'];?>&nbsp;&nbsp;<?php echo $purchaseitem['uom_name'];?> &nbsp;</TD>
      <TD noWrap align="right"><?php echo $oMaster->moneyFormat($purchaseitem['unit_cost']);?> &nbsp;</TD>
    <TD noWrap align="right"><?php  $unittotal =  $purchaseitem['return_qty'] * $purchaseitem['unit_cost'] ;
	echo $oMaster->moneyFormat($unittotal);
	?> &nbsp;</TD>
      </TR>
       
	  <?php 
	  $net_total +=$unittotal;
	  $sl_no ++;
	  } ?>
     
 <?php /*?> <TR class="srow" bgColor="white">
   
    <TD>&nbsp;</TD>
    <TD>&nbsp;</TD>
    <TD>&nbsp;</TD>
    <TD>&nbsp;</TD>
    <TD>&nbsp;</TD>
    <TD>&nbsp;</TD>
    <TD>&nbsp;</TD>
  
    </TR><?php */?>
 <TR class="srow" bgColor="white">
    <TD colSpan="3" align="right">Total Qty&nbsp;</TD>
   <TD align="right"><B>&nbsp;<?php echo $net_qty ;?>&nbsp;</B></TD>
    <TD>&nbsp;</TD>
    
   <TD align="right"><B>&nbsp;<?php echo  $oMaster->moneyFormat($net_total);?>&nbsp;&nbsp;</B></TD>
   </TR>
   
   
    
</TBODY></TABLE>
   
<BR><BR>
<TABLE border='0' cellSpacing='0' borderColor='black' cellPadding='0' width="100%" 
align='center'>
  <TBODY></TBODY></TABLE>  
<?php if($edit_result['purchasereturninfo']['remarks']!='')
{?>
       
<TABLE cellSpacing="0" cellPadding="0" width="100%" bgColor="black" align="center" border="1">
  <TBODY>
  <TR class="srow" align="left" bgColor="white">
    <TD ><B>&nbsp;REMARK </B></TD>
     <TR class='srow' align='left' bgColor='white'>
    <TD><FONT class="subtitle">&nbsp;&nbsp;<?php echo $edit_result['purchasereturninfo']['remarks'];?></FONT></TD>
   </TR></TBODY></TABLE><BR><BR>
<TABLE border='0' cellSpacing='0' borderColor='black' cellPadding='0' width="100%" 
align='center'>
  <TBODY></TBODY></TABLE>
<?php } ?>  

<?php
$preturnapproval  = $oMaster->getPurchaseReturnItemInfo($item_id);
//print_r($preturnapproval);
?>
<HR>
<BR><BR>
<TABLE border='0' cellSpacing='0' borderColor='black' cellPadding='0 'width="100%" 
align='center'>
  <TBODY>
  <TR><TD width="25%" align='left'></TD>
  <TD width="25%" colSpan=2 align='center'></TD>
  <TD width="25%" align='right'><?php echo $preturnapproval['iteminfo'][0]['employee_preturnapprname'];?></TD></TR>
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
