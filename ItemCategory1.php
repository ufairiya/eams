<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
   //print_r($aCustomerInfo);
  
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>Metronic | Form Stuff - Form Validation</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
   <link href="assets/css/metro.css" rel="stylesheet" />
   <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="assets/css/style.css" rel="stylesheet" />
   <link href="assets/css/style_responsive.css" rel="stylesheet" />
   <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
   <link rel="stylesheet" type="text/css" href="assets/gritter/css/jquery.gritter.css" />
   <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
   <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-timepicker/compiled/timepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-colorpicker/css/colorpicker.css" />
   <link rel="stylesheet" href="assets/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
   <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
   <link rel="stylesheet" type="text/css" href="assets/bootstrap-daterangepicker/daterangepicker.css" />
   <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
   <link rel="shortcut icon" href="favicon.ico" />
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
                  <div class="color-panel hidden-phone">
                     <div class="color-mode-icons icon-color"></div>
                     <div class="color-mode-icons icon-color-close"></div>
                     <div class="color-mode">
                        <p>THEME COLOR</p>
                        <ul class="inline">
                           <li class="color-black current color-default" data-style="default"></li>
                           <li class="color-blue" data-style="blue"></li>
                           <li class="color-brown" data-style="brown"></li>
                           <li class="color-purple" data-style="purple"></li>
                           <li class="color-white color-light" data-style="light"></li>
                        </ul>
                        <label class="hidden-phone">
                        <input type="checkbox" class="header" checked value="" />
                        <span class="color-mode-label">Fixed Header</span>
                        </label>                    
                     </div>
                  </div>
                  <!-- END BEGIN STYLE CUSTOMIZER -->     
                  <h3 class="page-title">
                     Form Validation
                     <small>form validation states</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.html">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Form Stuff</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Form Validation</a></li>
                  </ul>
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
                  <div class="portlet box blue">
                     <div class="portlet-title">
                        <h4><i class="icon-reorder"></i>Validation States</h4>
                        <div class="tools">
                           <a href="javascript:;" class="collapse"></a>
                           <a href="#portlet-config" data-toggle="modal" class="config"></a>
                           <a href="javascript:;" class="reload"></a>
                           <a href="javascript:;" class="remove"></a>
                        </div>
                     </div>
                     <div class="portlet-body form">
                        <h3 class="block">Basic validation states</h3>
                        <!-- BEGIN FORM-->
                        <form action="#" class="form-horizontal">
                           <div class="control-group warning">
                              <label class="control-label" for="inputWarning">Input with warning</label>
                              <div class="controls">
                                 <input type="text" class="span6 m-wrap" id="inputWarning" />
                                 <span class="help-inline">Something may have gone wrong</span>
                              </div>
                           </div>
                           <div class="control-group error">
                              <label class="control-label" for="inputError">Input with error</label>
                              <div class="controls">
                                 <input type="text" class="span6 m-wrap" id="inputError" />
                                 <span class="help-inline">Please correct the error</span>
                              </div>
                           </div>
                           <div class="control-group success">
                              <label class="control-label" for="inputSuccess">Input with success</label>
                              <div class="controls">
                                 <input type="text" class="span6 m-wrap" id="inputSuccess" />
                                 <span class="help-inline ok"></span>
                              </div>
                           </div>
                           <div class="control-group warning">
                              <label class="control-label">Input with warning</label>
                              <div class="controls input-icon">
                                 <input type="text" class="span6 m-wrap" />                                 
                                 <span class="input-warning tooltips" data-original-title="please write a valid email">
                                 <i class="icon-warning-sign"></i>
                                 </span>
                              </div>
                           </div>
                           <div class="control-group error">
                              <label class="control-label">Input with error</label>
                              <div class="controls input-icon">
                                 <input type="text" class="span6 m-wrap" />
                                 <span class="input-error tooltips" data-original-title="please write a valid email">
                                 <i class="icon-exclamation-sign"></i>
                                 </span>
                              </div>
                           </div>
                           <div class="control-group success">
                              <label class="control-label">Input with success</label>
                              <div class="controls input-icon">
                                 <input type="text" class="span6 m-wrap" />
                                 <span class="input-success tooltips" data-original-title="Success input!">
                                 <i class="icon-ok"></i>
                                 </span>
                              </div>
                           </div>
                           <div class="form-actions">
                              <button type="submit" class="btn blue">Save</button>
                              <button type="button" class="btn">Cancel</button>
                           </div>
                        </form>
                        <!-- END FORM-->
                     </div>
                  </div>
                  <!-- END VALIDATION STATES-->
               </div>
            </div>
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
                  <div class="portlet box purple">
                     <div class="portlet-title">
                        <h4><i class="icon-reorder"></i>Basic Validation</h4>
                        <div class="tools">
                           <a href="javascript:;" class="collapse"></a>
                           <a href="#portlet-config" data-toggle="modal" class="config"></a>
                           <a href="javascript:;" class="reload"></a>
                           <a href="javascript:;" class="remove"></a>
                        </div>
                     </div>
                     <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form action="#" id="form_sample_1" class="form-horizontal">
                           <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
                           <div class="alert alert-success hide">
                              <button class="close" data-dismiss="alert"></button>
                              Your form validation is successful!
                           </div>
                           <div class="control-group">
                              <label class="control-label">Name<span class="required">*</span></label>
                              <div class="controls">
                                 <input type="text" name="name" data-required="1" class="span6 m-wrap"/>
                              </div>
                           </div>
                           <div class="control-group">
                              <label class="control-label">Email<span class="required">*</span></label>
                              <div class="controls">
                                 <input name="email" type="text" class="span6 m-wrap"/>
                              </div>
                           </div>
                           <div class="control-group">
                              <label class="control-label">URL<span class="required">*</span></label>
                              <div class="controls">
                                 <input name="url" type="text" class="span6 m-wrap"/>
                                 <span class="help-block">e.g: http://www.demo.com or http://demo.com</span>
                              </div>
                           </div>
                           <div class="control-group">
                              <label class="control-label">Number<span class="required">*</span></label>
                              <div class="controls">
                                 <input name="number" type="text" class="span6 m-wrap"/>
                              </div>
                           </div>
                           <div class="control-group">
                              <label class="control-label">Digits<span class="required">*</span></label>
                              <div class="controls">
                                 <input name="digits" type="text" class="span6 m-wrap"/>
                              </div>
                           </div>
                           <div class="control-group">
                              <label class="control-label">Credit Card<span class="required">*</span></label>
                              <div class="controls">
                                 <input name="creditcard" type="text" class="span6 m-wrap"/>
                                 <span class="help-block">e.g: 5500 0000 0000 0004</span>
                              </div>
                           </div>
                           <div class="control-group">
                              <label class="control-label">Occupation&nbsp;&nbsp;</label>
                              <div class="controls">
                                 <input name="occupation" type="text" class="span6 m-wrap"/>
                                 <span class="help-block">optional field</span>
                              </div>
                           </div>
                           <div class="control-group">
                              <label class="control-label">Category<span class="required">*</span></label>
                              <div class="controls">
                                 <select class="span6 m-wrap" name="category">
                                    <option value="">Select...</option>
                                    <option value="Category 1">Category 1</option>
                                    <option value="Category 2">Category 2</option>
                                    <option value="Category 3">Category 5</option>
                                    <option value="Category 4">Category 4</option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-actions">
                              <button type="submit" class="btn purple">Validate</button>
                              <button type="button" class="btn">Cancel</button>
                           </div>
                        </form>
                        <!-- END FORM-->
                     </div>
                  </div>
                  <!-- END VALIDATION STATES-->
               </div>
            </div>
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
                  <div class="portlet box green">
                     <div class="portlet-title">
                        <h4><i class="icon-reorder"></i>Advance Validation</h4>
                        <div class="tools">
                           <a href="javascript:;" class="collapse"></a>
                           <a href="#portlet-config" data-toggle="modal" class="config"></a>
                           <a href="javascript:;" class="reload"></a>
                           <a href="javascript:;" class="remove"></a>
                        </div>
                     </div>
                     <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <h3>Advance validation of custom radio buttons, checkboxes and chosen dropdowns</h3>
                        <form action="#" id="form_sample_2" class="form-horizontal">
                           <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
                           <div class="alert alert-success hide">
                              <button class="close" data-dismiss="alert"></button>
                              Your form validation is successful!
                           </div>
                           <div class="control-group">
                              <label class="control-label">Name<span class="required">*</span></label>
                              <div class="controls">
                                 <input type="text" name="name" data-required="1" class="span6 m-wrap"/>
                              </div>
                           </div>
                           <div class="control-group">
                              <label class="control-label">Email<span class="required">*</span></label>
                              <div class="controls">
                                 <input name="email" type="text" class="span6 m-wrap"/>
                              </div>
                           </div>
                           <div class="control-group">
                              <label class="control-label">Occupation&nbsp;&nbsp;</label>
                              <div class="controls">
                                 <input name="occupation" type="text" class="span6 m-wrap"/>
                              </div>
                           </div>
                           <div class="control-group">
                              <label class="control-label">Category<span class="required">*</span></label>
                              <div class="controls">
                                 <select class="span6 m-wrap" name="category">
                                    <option value="">Select...</option>
                                    <option value="Category 1">Category 1</option>
                                    <option value="Category 2">Category 2</option>
                                    <option value="Category 3">Category 5</option>
                                    <option value="Category 4">Category 4</option>
                                 </select>
                              </div>
                           </div>
                           <div class="control-group">
                              <label class="control-label">Education<span class="required">*</span></label>
                              <div class="controls chzn-controls">
                                 <select id="form_2_education" class="span6 chosen-with-diselect" name="education" data-placeholder="Choose an Education" tabindex="1">
                                    <option value=""></option>
                                    <option value="Education 1">Education 1</option>
                                    <option value="Education 2">Education 2</option>
                                    <option value="Education 3">Education 5</option>
                                    <option value="Education 4">Education 4</option>
                                 </select>
                              </div>
                           </div>
                           <div class="control-group">
                              <label class="control-label">Membership<span class="required">*</span></label>
                              <div class="controls">
                                 <label class="radio line">
                                 <input type="radio" name="membership" value="1" />
                                 Fee
                                 </label>
                                 <label class="radio line">
                                 <input type="radio" name="membership" value="2" />
                                 Professional
                                 </label> 
                                 <div id="form_2_membership_error"></div>
                              </div>
                           </div>
                           <div class="control-group">
                              <label class="control-label">Services<span class="required">*</span></label>
                              <div class="controls">
                                 <label class="checkbox line">
                                 <input type="checkbox" value="1" name="service"/> Service 1
                                 </label>
                                 <label class="checkbox line">
                                 <input type="checkbox" value="2" name="service"/> Service 2
                                 </label>
                                 <label class="checkbox line">
                                 <input type="checkbox" value="3" name="service"/> Service 3
                                 </label>
                                 <span class="help-block">(select at least two)</span>
                                 <div id="form_2_service_error"></div>
                              </div>
                           </div>
                           <div class="form-actions">
                              <button type="submit" class="btn green">Validate</button>
                              <button type="button" class="btn">Cancel</button>
                           </div>
                        </form>
                        <!-- END FORM-->
                     </div>
                  </div>
                  <!-- END VALIDATION STATES-->
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
</body>
<!-- END BODY -->
</html>