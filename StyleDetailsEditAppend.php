<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  
  $oStyle = &Singleton::getInstance('StyleDetails');
  $oStyle->setDb($oDb);
  
  $oColor = &Singleton::getInstance('Color');
  $oColor->setDb($oDb);
  
  $oThreadCal = &Singleton::getInstance('ThreadCalculation');
  $oThreadCal->setDb($oDb);
     
	
    
  if(isset($aRequest['Update']))
  {    echo '<pre>';
  echo 'update:<br>';
	print_r($aRequest);
	echo '</pre>';
	exit();
    if($oStyle->updateStyle($aRequest))
	{
	  $msg = "Order Style Updated.";
	  echo '<script type="text/javascript">window.location.href="StyleDetails.php?msg=updatesucess";</script>';
	}
	else $msg = $_aErrorMsg['Duplicate']; //"Sorry";
  } //update
  if(isset($aRequest['send']))
  {
    echo '<pre>';
	 echo 'Add:<br>';
	print_r($aRequest);
	echo '</pre>';
	exit();
    if($oStyle->addStyle($aRequest))
	{ 
	   $msg = "New Order Style Added.";
	  echo '<script type="text/javascript">window.location.href="StyleDetails.php?msg=success";</script>';
	}
	else $msg = $_aErrorMsg['Duplicate']; //"Sorry";
  } 
  if($_REQUEST['action'] == 'edit')
  {
	$item_id = $_REQUEST['id'];
	$edit_result = $oStyle->getStyleInfo($item_id);
  } //edit
 // echo $_REQUEST['action'] ;
 // exit();

 //$aOrderColor = $oThreadCal->getAllOrderColorMap($aRequest['id']);
 //$aColorName = $aOrderColor['colornamearray'];
//exit();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|Style Details</title>
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
   <div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
        <?php include_once 'LeftMenu.php'; ?>
		<!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->  
      <div class="page-content">
        
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN STYLE CUSTOMIZER -->
                 
                  <!-- END STYLE CUSTOMIZER -->  
                  <h3 class="page-title">
                     Order Style Details
                     <small></small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Thread Consumption</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="StyleDetails.php">Style Details</a></li>
                  </ul>
               </div>
            </div>
            
                              <?php
							     if(isset($msg))
								 {
							   ?>
							    <div class="alert alert-success">
									<button class="close" data-dismiss="alert"></button>
									<?php echo $msg; unset($msg); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="StyleDetails.php" class="btn red mini active">Back to List</a>
								</div>
                                
								<?php
								  }
								?> 
                                <div class="alert alert-success" id="error_msg" style="display:none">
									<button class="close" data-dismiss="alert"></button>
									<div id= delete_info></div>
								</div>
                                
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
        
            			
            <div class="row-fluid">
               <div class="span12">
               
               <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue">
                     <div class="portlet-title">
                      <?php if($_REQUEST['action'] == 'Add')
								   {?>
                        <h4><i class="icon-reorder"></i>Add Style Details Form</h4>
                         <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit Style Details Form</h4>
                        <?php } ?>
                       
                     </div>
                     <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                       
                           <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="" method="post">
							  <div class="alert alert-error hide">
                                 <button class="close" data-dismiss="alert"></button>
                                  You have some form errors. Please check below.
                              </div>
                       
								 
                                      <div class="control-group">
                                       <label class="control-label">Order Number<span class="required">*</span></label>
                                       <div class="controls">
                                      <input type="text" placeholder="" class="m-wrap large" name="fOrderNumber" data-required="1" value="<?php echo (!empty($edit_result['ordernumber'])? $edit_result['ordernumber']:$aRequest['fOrderNumber']);?>" />
                                          <span class="help-inline">Enter Order Number</span>
                                       </div>
                                    </div>
 
                                  
									                                       
                                    <div class="control-group">
                                       <label class="control-label">Buyer Reference</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fBuyerRef" data-required="1" value="<?php echo (!empty($edit_result['buyerref'])? $edit_result['buyerref']:$aRequest['fBuyerRef']);?>" />
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Style Number</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fStyleNumber" data-required="1" value="<?php echo (!empty($edit_result['stylenumber'])? $edit_result['stylenumber']:$aRequest['fStyleNumber']);?>" />
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Order Colors<span class="required">*</span></label>
                                       <div class="controls">
									 
                                         <select class="large m-wrap" tabindex="7" name="fColorId[]" id="fColorId"  multiple="multiple">
											
											  <option value="0">Choose the Colors</option> <?php
											  //$aColorList = $oColor->getAllColorInfo();
											  if(isset($aRequest['id'])) {
											     //$aOrderColor = $oThreadCal->getAllOrderColorMap($aRequest['id']);
												 $aColorArray = $aOrderColor['colorarray'];
												 $aColorName = $aOrderColor['colornamearray'];
												 
											  }
											  foreach($aColorList as $aColor)
											  {
											    //if(in_array($aColorArray,$aColor['id_color']))
												//{
											 ?>
                                             <option value="<?php echo $aColor['id_color']; ?>"><?php echo $aColor['colorname']; ?></option>
                                             <?php
											    //}
											   
											  }
											 ?>
                                          </select>
										   <span><a href="#" class="colorr" title="Add New Color"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                          <span class="help-inline">Multiple Colors can be selected</span><br>
										  <span>Current Order Colors are: <strong><?php echo implode(', ',$aColorName); ?></strong></span>
                                       </div>
                                    </div>
																										
									 <div class="control-group">
                                       <label class="control-label">Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="1" <?php if($edit_result['status'] == 1) { echo 'checked=checked' ;}?> />
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="0" <?php if($edit_result['status'] == 0) { echo 'checked=checked' ;}?> />
                                          In-Active
                                          </label>  
                                       </div>
                                    </div>
                                    
       <!-- clone starts-->
       <h3 class="form-section">Purchase Item Info</h3>
                                    <div class="row-fluid">
                                      <table class="table table-striped table-bordered table-hover appendo">
									<thead>
										<tr>
											<th>Item Name</th>
											<th>Quantity/ UOM</th>
                                            <th>Unit Price (<?php echo Currencycode;?>)</th>
                                            <th>Total  (<?php echo Currencycode;?>)</th>
                                         	<th>Delete</th>
										</tr>
									</thead>
									<tbody>
                                    
                                    <tr>
                                     <td><input type="text" class=" m-wrap"  placeholder="Enter the Item Remarks" name="fOperationName[]"/><br><br>

                                     <select name="s_type[]">
                                       <option value="">--Select ISO--</option>
                                       <option value="iso1">iso1</option>
                                       <option value="iso2">iso2</option>
                                       <option value="iso3">iso3</option>
                                     </select>
                                     </td>
                                     <td><input type="text" class=" m-wrap"  placeholder="Enter the Item Remarks" name="fSPI[]"/><br><br>
                                         <select name="t_type[]">
                                       <option value="">--Select T--</option>
                                       <option value="t1">t1</option>
                                       <option value="t2">t2</option>
                                       <option value="t3">t3</option>
                                     </select>
                                     </td>
                                     <td><input type="text" class=" m-wrap"  placeholder="Enter the Item Remarks" name="fRemark[]"/></td>
                                     <td><input type="text" class=" m-wrap"  placeholder="Enter the Item Remarks" name="fRemark[]"/></td>
                                     <td><input type="text" class=" m-wrap"  placeholder="Enter the Item Remarks" name="fRemark[]"/></td>
                                     
                                    </tr>
                                    </tbody>
                                    </table>
                                    
 
                                    
                                   
                                    
        <!-- clone ends -->                            
                                    
                                  
									
                                    <div class="form-actions">
                                   <?php if($_REQUEST['action'] == 'Add')
								   {?>
                                   <button type="submit" id="submit_button" class="btn blue" name="send"><i class="icon-ok"></i>Add Style Details</button>                          
									   <?php
								   } else {
								   ?>
								      <input type="hidden" name="fOrderId" value="<?php echo $_GET['id'];?>" />
                                       <button type="submit" id="submit_button" class="btn blue" name="Update"><i class="icon-ok"></i>Update Style Details</button> 
                                          <?php
								   } 
								   ?>                         <button type="button" class="btn">Cancel</button>
                                    </div>
                                 </form>
                               
                        <!-- END FORM-->           
                     </div>
                  </div>
                  <!-- END SAMPLE FORM PORTLET-->
                
               </div>
            </div>
            <!-- END PAGE CONTENT-->         
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      
      
      <!-- END PAGE -->  
   </div>
   <!-- END CONTAINER -->
	<?php include_once 'Footer1.php'; ?>
    <script language="javascript" src="js/clone-form-td.js"></script>
    <script src="js/jquery.appendo.js"></script>
    <script>
	jQuery(function() { 
	jQuery('#demo4').appendo({ onDel: confirm_filled });
});

function confirm_filled($row)
{
	var filled = 0;
	$row.find('input,select').each(function() {
		if (jQuery(this).val()) filled++;
	});
	if (filled) return confirm('Do you really want to remove this row?');
	return true;
};
	</script>
</body>
<!-- END BODY -->
</html>