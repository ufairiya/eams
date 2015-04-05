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
	print_r($_FILES);
	echo '</pre>';
	exit();
    if($oStyle->addStyle($aRequest, $_FILES))
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
                       
                           <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="" method="post" enctype="multipart/form-data">
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
                                       <label class="control-label">Upload Image</label>
                                       <div class="controls">
                                     <input type="file" class="input-xlarge" tabindex="16" id="fStyleImage" name="fStyleImage">
                                     <br>
                                     <?php if($edit_result['style_images']!='')
									 {
										 ?>
                                     <img src="<?php echo "uploads/styleimages/".$edit_result['style_images'];?>" height="100" width="100"/>
                                     <?php } ?>
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
      
       <div id="entry1" class="clonedInput">
          <h2 id="reference" name="reference" class="heading-reference">Oper #1</h2>
          <fieldset>

        <div class="control-group">
        
         <!-- Text input-->
        <div class="form-group">
          <label class="label_fn control-label" for="first_name">First name:</label>
          <input id="first_name" name="first_name" type="text" placeholder="" class="input_fn form-control" required>
          <p class="help-block">This field is required.</p>
        </div>
        
        
        
        <!-- Select Basic -->
        <label class="control-label" for="title">Title:</label>
        <div class="form-group controls">
            <select class="select_ttl form-control" name="title" id="title">
              <option value="" selected="selected" disabled="disabled">Select your title</option>
              <option value="Dr.">Dr.</option>
              <option value="Mr.">Mr.</option>
              <option value="Mrs.">Mrs.</option>
              <option value="Ms.">Ms.</option>
              <option value="Sir">Sir</option>
            </select> <!-- end .select_ttl -->
          </div>
          </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="label_fn control-label" for="first_name">First name:</label>
          <input id="first_name" name="first_name" type="text" placeholder="" class="input_fn form-control" required>
          <p class="help-block">This field is required.</p>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="label_ln control-label" for="last_name">Last name:</label>
          <input id="last_name" name="last_name" type="text" placeholder="" class="input_ln form-control">
        </div>

        <!-- Prepended text-->
        <label class="label_twt control-label" for="twitter_handle">Twitter:</label>
        <div class="input-group form-group">
          <span class="input-group-addon">@</span>
          <input id="twitter_handle" name="twitter_handle" class="input_twt form-control" placeholder="" type="text">
        </div>
        <!-- Text input-->
        <div class="form-group">
          <label class="label_email control-label" for="email_address">Email:</label>
          <input id="email_address" name="email_address" type="text" placeholder="like this: billybob@example.com" class="input_email form-control">
        </div>

        <!-- Multiple Checkboxes (inline) -->
       <!-- <label class="label_checkboxitem control-label" for="checkboxitem">What flavors?</label>
        <div class="input-group form-group">
          <label class="checkbox-inline" for="checkboxitem-0">
            <input class="input_checkboxitem" type="checkbox" name="checkboxitem" id="checkboxitem-0" value="Apple">
            Apple
          </label>
          <label class="checkbox-inline" for="checkboxitem-1">
            <input class="input_checkboxitem" type="checkbox" name="checkboxitem" id="checkboxitem-1" value="Berry">
            Berry
          </label>
          <label class="checkbox-inline" for="checkboxitem-2">
            <input class="input_checkboxitem" type="checkbox" name="checkboxitem" id="checkboxitem-2" value="Peach">
            Peach
          </label>
          <label class="checkbox-inline" for="checkboxitem-3">
            <input class="input_checkboxitem" type="checkbox" name="checkboxitem" id="checkboxitem-3" value="Grape">
            Grape
          </label>
        </div>-->

        <!-- Multiple Radios -->
       <!-- <label class="label_radio control-label" for="radioitem">Do you skate?</label>
        <div class="input-group form-group">
          <label class="radio" for="radioitem-0">
              <input class="input_radio" type="radio" name="radioitem" id="radioitem-0" value="Yes">
              Yes
            </label>
            <label class="radio" for="radioitem-1">
              <input class="input_radio" type="radio" name="radioitem" id="radioitem-1" value="No">
              No
            </label>
        </div>-->
        </div><!-- end #entry1 -->
         <!-- clone ends -->
        
        
        <!-- Button (Double) -->
        <p>
        <button type="button" id="btnAdd" name="btnAdd" class="btn btn-info">add section</button>
          <button type="button" id="btnDel" name="btnDel" class="btn btn-danger">remove section above</button>
        </p>

        <!-- Textarea -->
        <label class="control-label" for="notes">Notes:</label>
        <textarea id="notes" name="notes" class="form-control">Do you want to add a message?</textarea>

        <!-- Multiple Checkboxes (inline) -->
        <div class="checkbox">
          <label>
            <input type="checkbox" value="">Yes, I accept the terms of service.</label>
        </div>

        <!-- Button -->
       <!-- <p>
          <button id="submit_button" name="submit_button" class="btn btn-primary">Submit</button>
        </p>-->

        </fieldset>
                                    
                                   
                                    
                                    
                                    
                                  
									
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
</body>
<!-- END BODY -->
</html>