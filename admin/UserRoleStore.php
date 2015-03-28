<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isAdmin())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $allResult = $oMaster->getAllUserList();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| User Role </title>
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
                     User Role 
                     <small>User Role master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Setup</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">User Role</a></li>
                  </ul>
               </div>
            </div>
            
                              <?php
							     if(isset($aRequest['msg']))
								 {
							   ?>
							    <div class="alert alert-success">
									<button class="close" data-dismiss="alert"></button>
									<?php
									if($_GET['msg'] == 'success')
									{
										echo $msg = 'New User Role Added Successfully';
									}
									else if($_GET['msg'] == 'updatesucess')
									{
										echo $msg = 'New User Role Updated Successfully';
									}
									else if($_GET['msg'] =='delsuccess')
									{
										echo $msg = 'New User Role Deleted Successfully';
									}
									else if($_GET['msg'] =='undelsuccess')
									{
										echo $msg = 'This User Role is parent, so we can not delete';
									}
									?>
								</div>
								<?php
								  }
								?> 
                              
                                
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            
            <!-- BEGIN PAGE CONTENT-->
									<div class="row-fluid">
									<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-globe"></i>User Role Master</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="btn-group">
                                <a href="StoreEdit.php?action=Add"  role="button" class="btn green" data-toggle="modal">Add New User <i class="icon-plus"></i></a>								
									</div>
									<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
										</button>
										<ul class="dropdown-menu">
											<li><a href="#">Print</a></li>
											<li><a href="#">Save as PDF</a></li>
											<li><a href="#">Export to Excel</a></li>
										</ul>
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>User ID</th>
											<th>User Login</th>
											<th>User Role Name</th>
											<th>Menus Allowed</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
                                    	<?php foreach ($allResult as $item): ?>
                                       
										<tr class="odd gradeX">
												<!--<td><input type="checkbox" class="checkboxes" value="<?php echo $item['item_cat_id'];?>" /></td> -->
											<td><?php echo $item['id']; ?></td>
											<td><?php echo $item['login_id']; ?></td>
											<td><?php echo $item['db_roleName']; ?></td>
											<td class="hidden-480"><?php echo  $item['db_lscatId']; ?></td>
											<td><?php  if( $item['status'] == '1')
											{
											echo $status = '<span class="label label-success">Active</span>';
											}
											else
											{
											echo $status = '<span class="label label-warning">In-Active</span>';
											} ?></td>
                                            <td>
                                            <div class="flash" id="flash_<?php echo  $item['id']; ?>"></div>
											<a href="MenuEdit.php?id=<?php echo  urlencode($item['id']); ?>&action=edit" class="btn mini purple"><i class="icon-edit"></i>Menu</a> &nbsp; &nbsp;
                                            <a href="UserRoleEdit.php?id=<?php echo  urlencode($item['id']); ?>&action=edit" class="btn mini purple"><i class="icon-edit"></i>Role</a> &nbsp; &nbsp;
                                            
                                            <a  class="delete btn mini black" href="javascript:void()" onclick=deleteBox(<?php echo  $item['id']; ?>)><i class="icon-trash"></i>Delete</a>   
                                           
                                            </td>
                                          
										</tr>
                                        <?php endforeach; ?>
										
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
									</div>
				
									<!-- END PAGE CONTENT-->
            
            
            <div class="row-fluid">
               <div class="span12">
fdfdf
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
	function addParam(url, param, value) 
	{
		var a = document.createElement('a');
		a.href = url;
		a.search += a.search.substring(0,1) == "?" ? "&" : "?";
		a.search += encodeURIComponent(param);
		if (value)
			a.search += "=" + encodeURIComponent(value);
		return a.href;
	}
	
	function deleteBox(id)
	{
	  if (confirm("Are you sure you want to delete this record?"))
	  {
		var dataString = 'data=storedelete&id='+ id;
		$("#flash_"+id).show();
		$("#flash_"+id).fadeIn(400).html('<img src="assets/img/loading.gif"/>');
		$.ajax({
			   type: "POST",
			   url: "delete.php",
			   data: dataString,
			   cache: false,
			   success: function(result){
					if(result){
					url = document.URL.split("?")[0];
						if(result !=0)
						{
							var resultss = addParam(url, "msg", "delsuccess");	
							window.location.href = resultss;
						}
						else if(result == 0)
						{
							 var resultss = addParam(url, "msg", "undelsuccess");	
							window.location.href = resultss;
						}
						else
						{
							 window.location.href = url;
						}
						
							 }
				}
			});
		 }
	} //
</script>
</body>
<!-- END BODY -->
</html>