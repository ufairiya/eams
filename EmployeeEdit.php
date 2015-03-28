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
  if(isset($aRequest['Update']))
  {
    if($oMaster->updateEmployee($aRequest, $_FILES, 'update'))
	{
	  $msg = "New Employee Updated.";
	  echo '<script type="text/javascript">window.location.href="Employee.php?msg=updatesucess";</script>';
	}
	else $msg = "Sorry";
  } //update
  if(isset($aRequest['send']))
  {
    if($oMaster->addEmployee($aRequest, $_FILES))
	{
	   $msg = "New Employee Added.";
	  echo '<script type="text/javascript">window.location.href="Employee.php?msg=success";</script>';
	}
	else $msg = "Sorry could not add..";
  } 
  if($aRequest['action'] == 'edit')
  {
	$item_id = $aRequest['fEmployeeId'];
	$edit_result = $oMaster->getEmployeeInfo($item_id,'id');
	
  } //edit
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Employee</title>
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
                     Employee
                     <small>Employee master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Extra</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Employee</a></li>
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
                                    <a href="Employee.php" class="btn red mini active">Back to List</a>
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
                      <?php if($aRequest['action'] == 'Add')
							{ ?>
                        <h4><i class="icon-reorder"></i>Add Employee</h4>
                         <?php } else if($aRequest['action'] == 'edit'){?>
                          <h4><i class="icon-reorder"></i>Edit Employee</h4>
                        <?php } ?>
                        <div class="tools">
                           <a href="javascript:;" class="collapse"></a>
                           <a href="#portlet-config" data-toggle="modal" class="config"></a>
                           <a href="javascript:;" class="reload"></a>
                           <a href="javascript:;" class="remove"></a>
                        </div>
                     </div>
                     <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                       
                                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_employee_addnew" method="post" enctype="multipart/form-data">
								
									
									<div class="alert alert-error hide">
									  <button class="close" data-dismiss="alert"></button>
									  You have some form errors. Please check below.
								   </div>
                       						
												<div class="control-group">
                                       <label class="control-label">Prefix<span class="required">*</span></label>
                                       <div class="controls">
                                         <select class="large m-wrap" tabindex="2" name="fPrefix">
											<option value="0">Choose the Prefix</option>
                                             <option value="MR" <?php if((!empty($edit_result['prefix'])? $edit_result['prefix']:$aRequest['fPrefix']) == 'MR') { echo 'selected=selected' ;}?>>MR.</option>
											 <option value="MS" <?php if((!empty($edit_result['prefix'])? $edit_result['prefix']:$aRequest['fPrefix']) == 'MS') { echo 'selected=selected' ;}?> >MS.</option>
											 <option value="MRS" <?php if((!empty($edit_result['prefix'])? $edit_result['prefix']:$aRequest['fPrefix']) == 'MRS') { echo 'selected=selected' ;}?> >MRS.</option>
                                             <option value="M/S" <?php if((!empty($edit_result['prefix'])? $edit_result['prefix']:$aRequest['fPrefix']) == 'M/S') { echo 'selected=selected' ;}?>>M/S.</option>
                                            
                                          </select>
                                         
                                       </div>
                                    </div>
											                                    
                                    <div class="control-group">
                                       <label class="control-label">Employee First Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="1" class="m-wrap large" name="fEmployeeFirstName" data-required="1" value="<?php echo (!empty($edit_result['employee_first_name'])? $edit_result['employee_first_name']:$aRequest['fEmployeeFirstName']); ?>"/>                                         <span class="help-inline">Enter Employee name</span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Employee Last Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="1" class="m-wrap large" name="fEmployeeLastName" data-required="1" value="<?php echo (!empty($edit_result['employee_last_name'])? $edit_result['employee_last_name']:$aRequest['fEmployeeLastName']); ?>"/>                                         <span class="help-inline">Enter Employee Last name</span>
                                       </div>
                                    </div>
									
									
									 <div class="control-group">
                                       <label class="control-label">Addr Line1<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="4" class="m-wrap large" name="fAddr1" data-required="1" value="<?php echo (!empty($edit_result['addr1'])? $edit_result['addr1']:$aRequest['fAddr1']);?>"/>
                                          <span class="help-inline">Enter Address Line</span>
                                       </div>
                                    </div>
									
									
									 <div class="control-group">
                                       <label class="control-label">Addr Line2<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder=""  tabindex="5" class="m-wrap large" name="fAddr2" data-required="1" value="<?php echo (!empty($edit_result['addr2'])?$edit_result['addr2']:$aRequest['fAddr2']);?>"/>
                                          <span class="help-inline">Enter Address Line</span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Addr Line3</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="6" class="m-wrap large" name="fAddr3" data-required="1" value="<?php echo (!empty($edit_result['addr3'])?$edit_result['addr3']:$aRequest['fAddr3']);?>"/>
                                          <span class="help-inline">Enter Address Line</span>
                                       </div>
                                    </div>
									
									
									<div class="control-group">
                                       <label class="control-label">City<span class="required">*</span></label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="7" name="fCityId"id="fCityId">
											 <option value="0">Choose the City</option>
											 <?php
											  $aCityList = $oMaster->getCityList();
											  foreach($aCityList as $aCity)
											  {
			  
											 ?>
                                             <option value="<?php echo $aCity['id_city']; ?>" <?php if((!empty($edit_result['id_city'])?$edit_result['id_city']:$aRequest['fCityId']) == $aCity['id_city']) { echo 'selected=selected' ;}?>><?php echo $aCity['city_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										    <span><a href="#" class="contact" title="Add New City"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                       </div>
                                    </div>
									
									<div class="control-group">
                                       <label class="control-label">State<span class="required">*</span></label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="8" name="fStateId" id="fStateId">
											<option value="0" >Choose the State </option>
											 <?php
											  $aStateList = $oMaster->getStateList();
											  foreach($aStateList as $aState)
											  {
			  
											 ?>
                                             <option value="<?php echo $aState['id_state']; ?>" <?php if((!empty($edit_result['id_state'])?$edit_result['id_state']:$aRequest['fStateId']) == $aState['id_state']) { echo 'selected=selected' ;}?>><?php echo $aState['state_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										   <span><a href="#" class="state" title="Add New State"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Country<span class="required">*</span></label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="9" name="fCountryId" id="fCountryId">
											 <option value="0" >Choose the Country </option>
											 <?php
											  $aCountryList = $oMaster->getCountryList();
											  foreach($aCountryList as $aCountry)
											  {
			  
											 ?>
                                             <option value="<?php echo $aCountry['id_country']; ?>" <?php if((!empty($edit_result['id_country'])?$edit_result['id_country']:$aRequest['fCountryId']) == $aCountry['id_country']) { echo 'selected=selected' ;}?>><?php echo $aCountry['country_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										  <span><a href="#" class="country" title="Add New Country"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Pincode<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="10" class="m-wrap large" name="fZipCode" data-required="1" value="<?php echo (!empty($edit_result['zipcode'])?$edit_result['zipcode']:$aRequest['fZipCode']);?>"/>
                                          <span class="help-inline">Enter Pincode</span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Telphone<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder=""  tabindex="11" class="m-wrap large" name="fPhone" data-required="1" value="<?php echo (!empty($edit_result['phone'])?$edit_result['phone']:$aRequest['fPhone']);?>"/>
                                          <span class="help-inline">Enter Phone number</span>
                                       </div>
                                    </div>
					
                    
                    				 <div class="control-group">
                               <label class="control-label">Email</label>
                              <div class="controls">
                                 <div class="input-prepend">
                                    <span class="add-on">@</span><input class="m-wrap " tabindex="12" type="text" placeholder="Email Address" name="fEmail" data-required="1" value="<?php echo (!empty($edit_result['email'])?$edit_result['email']:$aRequest['fEmail']);?>" />
                                 </div>
                                   <span class="help-inline">Enter Email Id</span>
                              </div>
                           </div>
									
									 <div class="control-group">
                                       <label class="control-label">Employee Type<span class="required">*</span></label>
                                       <div class="controls">
                                        <select class="large m-wrap" tabindex="13" name="fEmployeeType">
											<option value="0" >Choose the Employee Type </option>
                                             <option value="Permanent" <?php if((!empty($edit_result['employee_type'])?$edit_result['employee_type']:$aRequest['fEmployeeType']) == 'Permanent') { echo 'selected=selected' ;}?> >Permanent</option>
                                             <option value="Temporary" <?php if((!empty($edit_result['employee_type'])?$edit_result['employee_type']:$aRequest['fEmployeeType']) == 'Temporary') { echo 'selected=selected' ;}?>>Temporary</option>
                                                                                        
                                          </select>
                                          
                                       </div>
                                    </div>
                                     <div class="control-group">
                                       <label class="control-label">Employee Category<span class="required">*</span></label>
                                       <div class="controls">
                                      
                                        <select class="large m-wrap" tabindex="14" name="fEmployeeCategory">
										<option value="0" >Choose the Employee Category </option>
                                        <?php foreach($aEmptype as $emptype){ ?>
										  <option value="<?php echo $emptype ?>" <?php if((!empty($edit_result['employee_category'])?$edit_result['employee_category']:$aRequest['fEmployeeCategory']) == $emptype ) { echo 'selected=selected' ;}?>><?php echo $emptype; ?></option>
                                            <?php } ?>
                                          </select>
                                          
                                       </div>
                                    </div>
                                                                        
                                       <div class="control-group">
                                       <label class="control-label">Company<span class="required">*</span></label>
                                       <div class="controls">
                                        <select class="large m-wrap" tabindex="15" name="fCompanyId">
											 <option value="0" >Choose the Company </option>
											 <?php
											  $aCompanyList = $oMaster->getCompanyList();
											  foreach($aCompanyList as $aCompany)
											  {
											 ?>
                                             <option value="<?php echo $aCompany['id_company']; ?>" <?php if((!empty($edit_result['id_company'])?$edit_result['id_company']:$aRequest['fCompanyId']) == $aCompany['id_company']) { echo 'selected=selected' ;}?>><?php echo $aCompany['company_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Unit<span class="required">*</span></label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="16" name="fUnitId" id="fUnitId">
											 <option value="0" >Choose the Unit</option>
											 <?php
											  $aUnitList = $oAssetUnit->getAllAssetUnitInfo();
											  foreach($aUnitList as $aUnit)
											  {
			  
											 ?>
                                             <option value="<?php echo $aUnit['id_unit']; ?>" <?php if((!empty($edit_result['id_unit'])?$edit_result['id_unit']:$aRequest['fUnitId']) == $aUnit['id_unit']) { echo 'selected=selected' ;}?>><?php echo $aUnit['unit_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										   <span><a href="#" class="unit" title="Add New Unit"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                       </div>
                                    </div>
                                    
                                     <div class="control-group">
                                       <label class="control-label">Employee Designation </label>
                                       <div class="controls">
                                          <input type="text" placeholder=""  tabindex="17" class="m-wrap large" name="fEmployeeDesignation" data-required="1" value="<?php echo (!empty($edit_result['employee_designation'])?$edit_result['employee_designation']:$aRequest['fEmployeeDesignation']);?>"/>
                                          <span class="help-inline">Enter Employee Designation </span>
                                       </div>
                                    </div>
                                    
                                                                        
                                     <div class="control-group">
                              <label class="control-label">Date Of Join</label>
                              <div class="controls">
                              
                                 <input class="m-wrap m-ctrl-medium date-picker" tabindex="18" size="16" type="text" name="fDateOfJoin" data-required="1" value="<?php
								 if($edit_result['date_of_join']=="" || $edit_result['date_of_join'] == '1970-01-01')
								 {
									 echo date('d-m-Y');
								 }
								 else
								 {
									 echo date('d-m-Y',strtotime($edit_result['date_of_join']));
								 }?>" />
                              </div>
                             
                           </div>
                                                       
					
									<div class="control-group">
                                       <label class="control-label">Employee Image</label>
                                       <div class="controls">
                                     <input type="file" class="input-xlarge" tabindex="19" id="fEmployeeImage" name="fEmployeeImage">
                                     <br>
                                     <?php if($edit_result['employee_image']!='')
									 {
										 ?>
                                     <img src="<?php echo "uploads/employeeimage/".$edit_result['employee_image'];?>" height="100" width="100"/>
                                     <?php } ?>
                                        </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" tabindex="20" value="1" <?php if((!empty($edit_result['status'])?$edit_result['status']:$aRequest['fStatus']) === '1') { echo 'checked=checked' ;}?> />
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" tabindex="21" value="0" <?php if((!empty($edit_result['status'])?$edit_result['status']:$aRequest['fStatus']) == '0') { echo 'checked=checked' ;}?> />
                                          In-Active
                                          </label>  
										  <div id="form_2_membership_error"></div> 
                                       </div>
                                    </div>
									
									<div class="loading disabled"><p>Please wait until the Process will  Complete.</p></div>
                                    <div class="form-actions">
                                   <?php if($aRequest['action'] == 'Add')
								   {
								   ?>
                                    <input type="hidden" name="action" value="Add"/>
                                   <button type="submit" class="btn blue ajax_bt" name="send"><i class="icon-ok"></i>Add Employee</button>                          
								   <?php
								   } else {
								   ?> 
                                     <input type="hidden" name="fEmployeeId" value="<?php echo $aRequest['fEmployeeId'];?>"/>
                                      <input type="hidden" name="action" value="edit"/>
                                    <button type="submit" class="btn blue ajax_bt" name="Update"><i class="icon-ok"></i>Update Employee</button> 
                                   <?php
								   } 
								   ?>
								   <button type="button" class="btn">Cancel</button>
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
</body>
<!-- END BODY -->
</html>