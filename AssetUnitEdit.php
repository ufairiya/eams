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
  if($_REQUEST['action'] == 'edit')
  {
	$item_id = $_REQUEST['fAssetUnitID'];
	$edit_result = $oAssetUnit->getAssetUnitInfo($item_id);
	
	 $edit_address = $oMaster->getContactInfo($edit_result['id_unit_address'],'id');
	/*echo '<pre>';
	print_r($edit_address);
	print_r($edit_result);
	echo '</pre>';*/
  } //edit
  if(isset($aRequest['Update']))
  {
	  
	   if($oAssetUnit->updateAssetUnit($aRequest))
		{
    		$edit_address = $oAssetUnit->getAssetUnitInfo($aRequest['fAssetUnitID']);
			if($edit_address['id_unit_address'] > 0)
	    	{
			  $newAddressId = $oMaster->updateUnitAddress($aRequest,'update');
		    }
		    else
		    {
		      $newAddressId = $oMaster->addUnitAddress($aRequest,$aRequest['fAssetUnitID']);
    		}
			//echo $newAddressId;
			
		   $msg = "New Unit Updated.";
	       echo '<script type="text/javascript">window.location.href="AssetUnit.php?msg=updatesucess";</script>';
	    }
	    else $msg = "Sorry not updated";
	
    
  } //update
  if(isset($aRequest['send']))
  {
    if($UnitId = $oAssetUnit->addAssetUnit($aRequest))
	{
	  if($newAddressId = $oMaster->addUnitAddress($aRequest,$UnitId))
		{		  
		   $msg = "New Unit Added.";
	       echo '<script type="text/javascript">window.location.href="AssetUnit.php?msg=success";</script>';
		}
	}
	else $msg = $_aErrorMsg['Duplicate']; //"Sorry";
  }
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Unit</title>
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
                     Unit
                     <small>Unit master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Company</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Unit</a></li>
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
                                    <a href="AssetUnit.php" class="btn red mini active">Back to List</a>
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
                        <h4><i class="icon-reorder"></i>Add Unit Form</h4>
                         <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit Unit Form</h4>
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
                       
                                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_aunit_addnew" method="post">
									    <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
                       
								 
                                      <div class="control-group">
                                       <label class="control-label">Parent Unit</label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="1" name="fAssetParentUnit">
                                             <option value="0">No Parent</option>
											 <?php
											  $aAssetUnitInfo = $oAssetUnit->getAllAssetUnitInfo();
											  foreach($aAssetUnitInfo as $aAssetUnit)
											  {
			  
											 ?>
                                             <option value="<?php echo $aAssetUnit['id_unit']; ?>" <?php if((!empty($edit_result['id_parent_unit'])? $edit_result['id_parent_unit']:$aRequest['fAssetParentUnit']) == $aAssetUnit['id_unit']) { echo 'selected=selected' ;}?>><?php echo $aAssetUnit['unit_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                       </div>
                                    </div>
 
                                    <div class="control-group">
                                       <label class="control-label">Unit Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder=""  tabindex="2" class="m-wrap large" name="fAssetUnitName" data-required="1" value="<?php echo (!empty($edit_result['unit_name'])? $edit_result['unit_name']:$aRequest['fAssetUnitName']);?>"/>
                                          <span class="help-inline">Enter Unit name</span>
                                       </div>
                                    </div>
                                    
                                      <div class="control-group">
                                       <label class="control-label">Unit Address1<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="3" class="m-wrap large" name="fAddr1" data-required="1" value="<?php echo (!empty($edit_address['addr1'])? $edit_address['addr1']:$aRequest['fAddr1']);?>"/>
                                          <span class="help-inline">Enter Unit Address1</span>
                                       </div>
                                    </div>
                                    
                                       <div class="control-group">
                                       <label class="control-label">Unit Address2<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="4" class="m-wrap large" name="fAddr2" data-required="1" value="<?php echo (!empty($edit_address['addr2'])? $edit_address['addr2']:$aRequest['fAddr2']);?>"/>
                                          <span class="help-inline">Enter Unit Address2</span>
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Unit Address3</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="5" class="m-wrap large" name="fAddr3" data-required="1" value="<?php echo (!empty($edit_address['addr3'])? $edit_address['addr3']:$aRequest['fAddr3']);?>"/>
                                          <span class="help-inline">Enter Unit Address3</span>
                                       </div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Unit Pincode<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder=""  tabindex="6" class="m-wrap large" name="fZipCode" data-required="1" value="<?php echo (!empty($edit_address['zipcode'])? $edit_address['zipcode']:$aRequest['fZipCode']);?>" maxlength="6"/>
                                          <span class="help-inline">Enter Unit Pincode</span>
                                       </div>
                                    </div>
                                      <div class="control-group">
                                       <label class="control-label">City<span class="required">*</span></label>
                                       <div class="controls">
                                         <select class="large m-wrap" tabindex="7" name="fCityId" id="fCityId">
											 <option value="0">Choose the City</option>
											 <?php
											  $aCityList = $oMaster->getCityList();
											  foreach($aCityList as $aCity)
											  {
			  
											 ?>
                                             <option value="<?php echo $aCity['id_city']; ?>" <?php if((!empty($edit_address['id_city'])? $edit_address['id_city']:$aRequest['fCityId']) == $aCity['id_city']) { echo 'selected=selected' ;}?>><?php echo $aCity['city_name']; ?></option>
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
											  <option value="0">Choose the State</option>
											 <?php
											  $aStateList = $oMaster->getStateList();
											  foreach($aStateList as $aState)
											  {
			  
											 ?>
                                             <option value="<?php echo $aState['id_state']; ?>" <?php if((!empty($edit_address['id_state'])? $edit_address['id_state']:$aRequest['fStateId']) == $aState['id_state']) { echo 'selected=selected' ;}?>><?php echo $aState['state_name']; ?></option>
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
											 <option value="0">Choose the Country</option>
											 <?php
											  $aCountryList = $oMaster->getCountryList();
											  foreach($aCountryList as $aCountry)
											  {
			  
											 ?>
                                             <option value="<?php echo $aCountry['id_country']; ?>" <?php if((!empty($edit_address['id_country'])? $edit_address['id_country']:$aRequest['fCountryId']) == $aCountry['id_country']) { echo 'selected=selected' ;}?>><?php echo $aCountry['country_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select> <span><a href="#" class="country" title="Add New Country"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                       </div>
                                    </div>
                                    
                                     <div class="control-group">
                                       <label class="control-label">Unit Phone<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="10" class="m-wrap large" name="fPhone" data-required="1" value="<?php echo (!empty($edit_address['phone'])? $edit_address['phone']:$aRequest['fPhone']);?>"/>
                                          <span class="help-inline">Enter Unit Phone1</span>
                                       </div>
                                    </div>
                                    
                                      
                                    
                                       <div class="control-group">
                                       <label class="control-label">Unit Email</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="11" class="m-wrap large" name="fEmail" data-required="1" value="<?php echo (!empty($edit_address['email'])? $edit_address['email']:$aRequest['fEmail']);?>"/>
                                          <span class="help-inline">Enter Unit Email1</span>
                                       </div>
                                    </div>
                                    
                                      
                                    
                                      <div class="control-group">
                                       <label class="control-label">Unit Fax</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="12" class="m-wrap large" name="fFax" data-required="1" value="<?php echo (!empty($edit_address['fax'])? $edit_address['fax']:$aRequest['fFax']);?>"/>
                                          <span class="help-inline">Enter Unit Fax1</span>
                                       </div>
                                    </div>
									                                       
                                <?php /*?> <div class="control-group">
                                       <label class="control-label">Unit Description<span class="required">*</span></label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fAssetUnitDesc"><?php echo $edit_result['unit_desc'];?></textarea>
                                       </div>
                                    </div><?php */?>
                                    
                                    <div class="control-group">
                                       <label class="control-label">Unit In-Charge</label>
                                       <div class="controls">
                                        <select class="large m-wrap" tabindex="13" name="fEmployeeId" id="fEmployeeId">
											 <option value="0" >Choose the Unit In Charge  </option>
											 <?php
											  $aEmployeeList = $oMaster->getEmployeeList();
											  foreach($aEmployeeList as $aEmployee)
											  {
			  
											 ?>
                                             <option value="<?php echo $aEmployee['id_employee']; ?>" <?php if((!empty($edit_result['id_employee'])? $edit_result['id_employee']:$aRequest['fEmployeeId']) == $aEmployee['id_employee']) { echo 'selected=selected' ;}?>><?php echo $aEmployee['employee_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										  <span><a href="#" class="employee" title="Add New Employee"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                       </div>
                                    </div>
									 <div class="loading disabled"><p>Please wait until the Process will  Complete.</p></div>
									 <div class="control-group">
                                       <label class="control-label">Unit Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" tabindex="14" value="1" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus']) == 1) { echo 'checked=checked' ;}?> />
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" tabindex="15"  value="0" <?php if((!empty($edit_result['status'])? $edit_result['status']:$aRequest['fStatus']) == 0) { echo 'checked=checked' ;}?> />
                                          In-Active
                                          </label>  
                                       </div>
                                    </div>
                                 
                                    <div class="form-actions">
                                   <?php if($_REQUEST['action'] == 'Add')
								   {?>
								    <input type="hidden" name="action" value="Add"/>
                                   <button type="submit" class="btn blue ajax_bt" name="send"><i class="icon-ok"></i>Add Unit</button>                          
									   <?php
								   } else if($_REQUEST['action'] == 'edit'){
								   ?>
								    <input type="hidden" name="fAssetUnitID" value="<?php echo $aRequest['fAssetUnitID'];?>"/>
									 <input type="hidden" name="action" value="edit"/>
                                        <input type="hidden" name="fContactId" value="<?php echo $edit_result['id_unit_address'];?>"/>
                                       <button type="submit" class="btn blue ajax_bt" name="Update"><i class="icon-ok"></i>Update Unit</button> 
									    <?php
								   } 
								   else {
								   ?> 
								   <input type="hidden" name="action" value="Add"/>
								          <button type="submit" class="btn blue ajax_bt" name="send"><i class="icon-ok"></i>Add Unit</button>
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
</body>
<!-- END BODY -->
</html>