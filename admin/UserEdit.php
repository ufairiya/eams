<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isAdmin())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
   $oAssetUnit = &Singleton::getInstance('AssetUnit');
  $oAssetUnit->setDb($oDb);
 
  if(isset($aRequest['send']))
  {
    if($aresult = $oCustomer->registerNewCustomer($aRequest))
	{
	  switch($aresult['msg'])
	  {
		case 1:
		$msg = "New User Added.";
		echo '<script type="text/javascript">window.location.href="User.php?msg=success";</script>';
		break;
		case 2:
		$msg = "Username Already Exist.";
		 $page = $_SERVER['HTTP_REFERER'];
	     $sec = "1";
         header("Refresh: $sec; url=$page");
		break;
		default :
		$msg = "sorry could not added..";
		break;
	}
	}
	
  } 
 if($_REQUEST['action'] == 'Add')
  {
  $usertype  = "Add User";
 $edit_result['user_type'] = 'New';
 }
  if($_REQUEST['action'] == 'edit')
  {
    $usertype  = "Edit User";
	$item_id = $_REQUEST['id'];
	$edit_result = $oCustomer->getUserInfo($item_id,'id');
/*	echo '<pre>';
	print_r($edit_result );
		echo '</pre>';*/
	
  } //edit
   if(isset($aRequest['Update']))
  {
  if($aresult = $oCustomer->updateProfileInfo($aRequest))
	{
	 switch($aresult['msg'])
	  {
		case 1:
		echo '<script type="text/javascript">window.location.href="User.php?msg=updatesucess";</script>';
		break;
		case 2:
		$msg = "Username Already Exist.";
		 $page = $_SERVER['HTTP_REFERER'];
	     $sec = "1";
         header("Refresh: $sec; url=$page");
		break;
		default :
		$msg = "sorry could not added..";
		break;
	}
	  
	}
	else $msg = "Sorry could not add..";
  } 
  
 
  
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| User</title>
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
                     User
                     <small>User master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">User List</a>
                        <span class="icon-angle-right"></span>
                     </li>
					 
                     <li><a href="#"><?php echo $usertype;?></a></li>
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
									<a href="User.php" class="btn red mini active">Back to List</a>
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
                    <h4><i class="icon-reorder"></i><?php echo $usertype;?></h4>
                          
                     </div>
                     <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                       
                                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="register" method="post">
									<div class="alert alert-error hide">
									  <button class="close" data-dismiss="alert"></button>
									  You have some form errors. Please check below.
								   </div>
                       					
									<?php if($aRequest['action'] !='edit')
									{?>
									<div class="control-group">
                                      <div class="controls">
                                 <label class="radio">
                                 <input type="radio" name="fUserType" id="fUserType" value="New" tabindex="2" <?php if($edit_result['user_type'] == 'New') { echo 'checked=checked' ;}?> onChange="getUserType(this.value);"/>
                                 Add New User
                                 </label>
                                 <label class="radio">
                                 <input type="radio" name="fUserType" id="fUserType" value="Existing" tabindex="3" <?php if($edit_result['user_type'] == 'Item') { echo 'checked=checked' ;}?> onChange="getUserType(this.value);" />
                                Choose Employee 
                                 </label>  
                               
                              </div>
                                                       
                                    </div>	
									
								
									
								<div id="UserList" style="display:none">	
									<?php } ?>		                                     
                                    <div class="control-group">
                                       <label class="control-label">User First Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="1" class="m-wrap large" name="fFirstName" id="fFirstName" data-required="1" value="<?php echo $edit_result['first_name']; ?>"/>                                         <span class="help-inline">Enter User First name</span>
                                       </div>
                                    </div>
									
									   <div class="control-group">
                                       <label class="control-label">User Last Name</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="1" class="m-wrap large" name="fLastName" data-required="1" value="<?php echo $edit_result['last_name']; ?>"/>                                         <span class="help-inline">Enter User Last name</span>
                                       </div>
                                    </div>
									
			
									 <div class="control-group">
                                       <label class="control-label">Addr Line1<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="4" class="m-wrap large" name="fAddr1" id="fAddr1" data-required="1" value="<?php echo $edit_result['address1'];?>"/>
                                          <span class="help-inline">Enter Address Line</span>
                                       </div>
                                    </div>
									
									
									 <div class="control-group">
                                       <label class="control-label">Addr Line2</label>
                                       <div class="controls">
                                          <input type="text" placeholder=""  tabindex="5" class="m-wrap large" name="fAddr2" data-required="1" value="<?php echo $edit_result['address2'];?>"/>
                                          <span class="help-inline">Enter Address Line</span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Addr Line3</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="6" class="m-wrap large" name="fAddr3" data-required="1" value="<?php echo $edit_result['address3'];?>"/>
                                          <span class="help-inline">Enter Address Line</span>
                                       </div>
                                    </div>
									
									
									<div class="control-group">
                                       <label class="control-label">City</label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="7" name="fCityId"id="fCityId">
											 <option value="0">Choose the City</option>
											 <?php
											  $aCityList = $oMaster->getCityList();
											  foreach($aCityList as $aCity)
											  {
			  
											 ?>
                                             <option value="<?php echo $aCity['id_city']; ?>" <?php if($edit_result['id_city'] == $aCity['id_city']) { echo 'selected=selected' ;}?>><?php echo $aCity['city_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										    <span><a href="#" class="contact" title="Add New City"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                       </div>
                                    </div>
									
									<div class="control-group">
                                       <label class="control-label">State</label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="8" name="fStateId" id="fStateId">
											<option value="0" >Choose the State </option>
											 <?php
											  $aStateList = $oMaster->getStateList();
											  foreach($aStateList as $aState)
											  {
			  
											 ?>
                                             <option value="<?php echo $aState['id_state']; ?>" <?php if($edit_result['id_state'] == $aState['id_state']) { echo 'selected=selected' ;}?>><?php echo $aState['state_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										   <span><a href="#" class="state" title="Add New State"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Country</label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="9" name="fCountryId" id="fCountryId">
											 <option value="0" >Choose the Country </option>
											 <?php
											  $aCountryList = $oMaster->getCountryList();
											  foreach($aCountryList as $aCountry)
											  {
			  
											 ?>
                                             <option value="<?php echo $aCountry['id_country']; ?>" <?php if($edit_result['id_country'] == $aCountry['id_country']) { echo 'selected=selected' ;}?>><?php echo $aCountry['country_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										  <span><a href="#" class="country" title="Add New Country"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Pincode</label>
                                       <div class="controls">
                                          <input type="text" placeholder="" tabindex="10" class="m-wrap large" name="fZipCode" data-required="1" value="<?php echo $edit_result['zipcode'];?>"/>
                                          <span class="help-inline">Enter Pincode</span>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Telphone / Mobile <span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder=""  tabindex="11" class="m-wrap large" name="fPhone"  id="fPhone" data-required="1" value="<?php echo $edit_result['phonenumber'];?>"/>
                                          <span class="help-inline">Enter Phone number</span>
                                       </div>
                                    </div>
					
                    
                    				 <div class="control-group">
                               <label class="control-label">Email</label>
                              <div class="controls">
                                 <div class="input-prepend">
                                    <span class="add-on">@</span><input class="m-wrap " tabindex="12" type="text" placeholder="Email Address" name="fEmail" data-required="1" value="<?php echo $edit_result['email'];?>" />
                                 </div>
                                   <span class="help-inline">Enter Email Id</span>
                              </div>
                           </div>
									
										<?php if($aRequest['action'] !='edit')
									{?>
									</div>
									<?php } ?>		
									<div id="User" style="display:none;">
									<div class="control-group">
                                       <label class="control-label">Select Employee Name</label>
                                       <div class="controls" >
									   <span id="EmployeeList"></span>
									   	 <span><a href="#" class="employee" title="Add New Employee"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>				  
									   </div>
 				
									   </div>

									</div>
									
									<div class="control-group">
                                       <label class="control-label">Select User Role</label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="" name="fUserRoleId"id="fUserRoleId">
											 <option value="0">Choose the User Role</option>
											 <?php
											  $aUserRoleList = $oCustomer->getUserRoleList();
											  foreach($aUserRoleList as $aUserRole)
											  {
			  
											 ?>
                                             <option value="<?php echo $aUserRole['role_id']; ?>" <?php if($edit_result['db_roleId'] == $aUserRole['role_id']) { echo 'selected=selected' ;}?>><?php echo $aUserRole['role_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										   
                                       </div>
                                    </div>
								
							<div class="control-group">
                                       <label class="control-label">Login User Name<span class="required">*</span></label>
                                       <div class="controls">
 <input type="text"  class="m-wrap large" name="fLoginName" id="username" autocomplete="off" value="<?php echo $edit_result['login_name']; ?>"/> 
 <span class="flash" id="flash"></span>
 <span class="help-inline loginname">Enter Login User name</span>
                                       </div>
                                    </div>                             
                                     
							<div class="control-group">
                                       <label class="control-label">Password <span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="password" id="register_password" autocomplete="off" placeholder="" tabindex="1" class="m-wrap large" name="fPassword" data-required="1" value="<?php echo $edit_result['password']; ?>"/>                                         <span class="help-inline">Enter Password</span>
                                       </div>
                                    </div>    
									
									<div class="control-group">
                                       <label class="control-label">Confirm Password <span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="password"  id="rpassword" autocomplete="off" placeholder="" tabindex="1" class="m-wrap large" name="fConfirmPassword" data-required="1" value="<?php echo $edit_result['password']; ?>"/>                                         <span class="help-inline">Enter Confirm Password</span>
                                       </div>
                                    </div>     		 
                        
									 <div class="control-group">
                                       <label class="control-label">Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" tabindex="20" value="1" <?php if($edit_result['status'] === '1') { echo 'checked=checked' ;}?> />
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" tabindex="21" value="0" <?php if($edit_result['status'] == '0' ||  $edit_result['status'] == '2') { echo 'checked=checked' ;}?> />
                                          In-Active
                                          </label>  
                                       </div>
                                    </div>
                                 
									
                                    <div class="form-actions">
                                   <?php if($aRequest['action'] == 'edit')
								   {
								   ?>
								    <button type="submit" class="btn blue" name="Update"><i class="icon-ok"></i>Update User</button> 
									 <input type="hidden" name="fUserId" value="<?php echo $aRequest['id'];?>"/>
                                                       
								   <?php
								   } else {
								   ?>
                                      <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Add User</button>   
                                   <?php
								   } 
								   ?>
								   <button type="button" style="color:#009933; font-weight:bold"class="btn">Cancel</button>
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
	
	<script type="text/javascript">
	
	$(document).ready(function(){
	 $('#username').keyup(function(){ 
	 //get the username  
        var username = $(this).val();  
  var dataString = 'action=checkusername&username='+ username;
  	$("#flash").show();
		$("#flash").fadeIn(400).html('<img src="../assets/img/gif-load.gif"/>');
		$.ajax({
			   type: "POST",
			   url: "ajax.php",
			   data: dataString,
			   cache: false,
			   success: function(result){
			   if(result == 1){  
                    //show that the username is available 
					
                    $('.loginname').html('<span style="color:#009933;font-weight:bold">'+username + ' is Available</span>');  
					$("#flash").hide();
                }else{  
                    //show that the username is NOT available  
                    $('.loginname').html('<span style="color:red;font-weight:bold">'+username + ' is not Available</span>'); 
					$("#flash").hide(); 
                }
				
				}
			});
    
});  
	});
	</script>
	<script type="text/javascript">
	 function getUserType(value,id)
		 {
			if(value == 'New')
			{
			$('#UserList').css('display','');
				$('#User').css('display','none');
			$('.form-horizontal').attr('id','register');
			$('#fFirstName').css('display','');
			$('#fPhone').css('display','');
			$('#fAddr1').css('display','');
			}
			else
			{
			$('#UserList').css('display','none');
			$('#User').css('display','');
			$('.form-horizontal').attr('id','register1');
			$('#fFirstName').css('display','none');
			$('#fPhone').css('display','none');
			$('#fAddr1').css('display','none');
			
			
			var dataStr = 'action=getUserType&type='+value+'&id='+id;
			 $.ajax({
			   type: 'POST',
			   url: 'ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				     $("#EmployeeList").html(result);
				 	   }
         
		  
		 });
		 }
		 }
		 jQuery(document).ready(function() { 
	
	$(function () {
	 $('input[type="radio"]:checked').change();
	
	});

});


		 
	</script>
</body>
<!-- END BODY -->
</html>