<?php
  include_once 'ApplicationHeader.php'; 
  /*if(!$oCustomer->isAdmin())
  {
	header("Location: login.php");
  }*/
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  

  if(isset($aRequest['send']))
  {
    if($aresult = $oCustomer->registerNewUser($aRequest))
	{
    // print_r($aresult);
    
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
		$msg = "sorry could not add..";
		break;
	  }
	}
	
  } 

	//else $msg = "Sorry could not add..";
 
   
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS | Register</title>
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
                    <h3 class="page-title">
                     Register
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Register</a>
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
									<a href="#" class="btn red mini active">Back</a>
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
                  <div class="">
                     
                     <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                       
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="register" method="post">
									<div class="alert alert-error hide">
									  <button class="close" data-dismiss="alert"></button>
									  You have some form errors. Please check below.
								   </div>
                       					
									
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
                               <label class="control-label">Email</label>
                              <div class="controls">
                                 <div class="input-prepend">
                                    <span class="add-on">@</span><input class="m-wrap " tabindex="12" type="text" placeholder="Email Address" name="fEmail" data-required="1" value="<?php echo $edit_result['email'];?>" />
                                 </div>
                                   <span class="help-inline">Enter Email Id</span>
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
                        
							
                                 
									
              <div class="form-actions">
               <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Add User</button>   
						   
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
			   url: "ajax/ajax.php",
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