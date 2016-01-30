<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  
  if(isset($aRequest['id']))
  {
   $id_pr  = $aRequest['id'];
  }
  else
  {
  $id_pr = $aRequest['fPRId'];
  }
  $aQuotationInfo = $oMaster->getQuotationApproval($id_pr,'pr');  
$allResult = $oMaster->compareQuotation($id_pr);
/*echo '<pre>';
print_r( $aQuotationInfo);
echo '</pre>';
exit();*/
 if(isset($aRequest['send']))

  {

    if($result=$oMaster->addQuotationApproval($aRequest))

	{

	 
	   echo '<script type="text/javascript">window.location.href="QuotationList.php?id='.$result.'&msg=success";</script>';

	}

	else 

	  $msg = "Sorry could not add..";

  } 
if(isset($aRequest['Update']))

  {

    if($result=$oMaster->updateQuotationApproval($aRequest))

	{

	 
	   echo '<script type="text/javascript">window.location.href="QuotationList.php?id='.$result.'&msg=updatesucess";</script>';

	}

	else 

	  $msg = "Sorry could not add..";

  } 

	
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|Compare Quotations </title>
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
                      Compare Quotations
                 
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="QuotationList.php?id=<?php echo  $id_pr;?>">Quotation List</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#"> Compare Quotations</a></li>
                  </ul>
               </div>
            </div>
            
                             
                              
                                
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            
            <!-- BEGIN PAGE CONTENT-->
            <div class="portlet-body">
                                                              								
             <div class="row-fluid profile">
					<div class="tabbable tabbable-custom">
					 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal form-row-seperated" id="form_sample_3" method="post">
			<?php foreach($allResult['quotation_iteminfo'] as $aCompareResult) {?>				              
 <table width="100%" border="1" cellspacing="0" cellpadding="0" class="table table-striped table-hover" >
  <tr>
    <td width="20%" rowspan="2" align="left" valign="middle"> 
										 <label class="radio line">
                                         <input type="radio" name="fApprovedVendorId" <?php if($aQuotationInfo['id_vendor'] == $aCompareResult['quotationinfo']['id_vendor']) { echo 'checked=checked' ;}?> value="<?php echo $aCompareResult['quotationinfo']['id_vendor']?>/<?php echo $aCompareResult['quotationinfo']['id_quote'];?>"/>
										  <?php echo $aCompareResult['quotationinfo']['vendor_name']?> 
                                          </label>
                                          
	<br>
	 <a href="QuotationEdit.php?id=<?php echo $id_pr;?>&Qid=<?php echo $aCompareResult['quotationinfo']['id_quote'];?>&action=edit" class="btn mini purple"><i class="icon-edit"></i>Edit</a>  
	</td>
    <td align="left" valign="middle"><table width="100%" border="1" cellspacing="0" cellpadding="0">
       <tr>
		<th>Vendor</th>
		<th>Quote No</th>
		<th>Quote Amt</th>
		<th>Due Date</th>
		<th>Valid Date</th>
		<th>Quote Document</th>
      </tr>
	  <tr>
        <td align="left" valign="middle"><?php echo $aCompareResult['quotationinfo']['vendor_name']?>
		
		</td>
        <td align="left" valign="middle"><?php echo $aCompareResult['quotationinfo']['quote_number']?></td>
        <td align="left" valign="middle"><?php echo $aCompareResult['quotationinfo']['quote_amount']?></td>
        <td align="left" valign="middle"><?php echo date('d-m-Y',strtotime($aCompareResult['quotationinfo']['quote_date']));?></td>
        <td align="left" valign="middle"><?php echo date('d-m-Y',strtotime($aCompareResult['quotationinfo']['quote_valid_date']));?></td>
		<td align="left" valign="middle"><a class="fancybox fancybox.iframe" href="uploads/quotationdocument/<?php echo trim($aCompareResult['quotationinfo']['document_name']);?>">View Document</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="654" align="left" valign="middle"><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
			<th>Item Group1</th>
			<th>Brand / Make</th>
			<th>Item </th>
			<th>UOM</th>
			<th>Quantity</th>
			<th>Unit Price</th>
			<th>Vendor Unit Price</th>
			<th>Nego Unit Price</th>
			
      </tr>
	  <?php foreach($aCompareResult['quotation_item'] as $aItemInfo) {
	  
	  ?>		
      <tr>
        <td align="left" valign="middle"><?php echo $aItemInfo['itemgroup1_name']?></td>
        <td align="left" valign="middle"><?php echo $aItemInfo['itemgroup2_name']?></td>
        <td align="left" valign="middle"><?php echo $aItemInfo['item_name']?></td>
        <td align="left" valign="middle"><?php echo $aItemInfo['uom_name']?></td>
        <td align="left" valign="middle"><?php echo $aItemInfo['qty']?></td>
        <td align="left" valign="middle"><?php echo $aItemInfo['unit_cost']?></td>
        <td align="left" valign="middle"><?php echo $aItemInfo['quote_unit_cost']?></td>
        <td align="left" valign="middle"><?php echo $aItemInfo['negotiated_unit_cost']?></td>
           </tr>
	 <?php } ?>	
 
    </table></td>
  </tr>
</table>	
<?php } ?>	
<div class="control-group">

                                       <label class="control-label">Select Approval By</label>

                                       <div class="controls">

                                        <select class="large m-wrap" tabindex="1" name="fApprovalEmployeeId">

											<option value="0">Choose the Approval By</option>

											<?php

											  $aEmployeeList = $oMaster->getEmployeeList();

											  foreach($aEmployeeList as $aEmployee)

											  {

			  

											 ?>

                                             <option value="<?php echo $aEmployee['id_employee']; ?>" <?php if($aQuotationInfo['approved_by'] == $aEmployee['id_employee']) { echo 'selected=selected' ;}?>><?php echo $aEmployee['employee_name']; ?></option>

                                             <?php

											  }

											 ?>

                                          </select>

                                       </div>

 <?php if(empty( $aQuotationInfo)){ ?>                                   </div>
 <div class="form-actions">
 <input type="hidden" value="<?php echo $_REQUEST['id'];?>" name="fPRId"/>
					 <button type="submit" class="btn blue" id="send" name="send"><i class="icon-ok"></i>Save</button>       						
						<a href="QuotationList.php?id=<?php echo  $id_pr;?>"><button type="button" class="btn">Go Back</button></a>

						</div>
   <?php } else {?> 
   
   <div class="form-actions">
 <input type="hidden" value="<?php echo $_REQUEST['id'];?>" name="fPRId"/>
 <input type="hidden" value="<?php echo $aQuotationInfo['id_quote_approval'];?>" name="fQuoteApprovalId"/>
					 <button type="submit" class="btn blue" id="send" name="Update"><i class="icon-ok"></i>Update</button>       						
						<a href="QuotationList.php?id=<?php echo  $id_pr;?>"><button type="button" class="btn">Go Back</button></a>

						</div>
   <?php } ?>
	</form>
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