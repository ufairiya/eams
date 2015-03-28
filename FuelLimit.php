<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $allResult = $oMaster->getFuelLimitList();
 /* echo '<pre>';
  print_r( $allResult );
  echo '</pre>';
  exit();*/
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Fuel Limit List </title>
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
                     Fuel Limit  
                     <small>   Fuel Limit   master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Transport</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Fuel </a></li>
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
									if($aRequest['msg'] == 'success')
									{
										echo $msg = 'New Fuel Limit Added Successfully';
									}
									else if($aRequest['msg'] == 'updatesucess')
									{
										echo $msg = 'Fuel Limit Updated Successfully';
									}
									else if($aRequest['msg'] =='delsuccess')
									{
										echo $msg = 'Fuel Limit Deleted Successfully';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'This Fuel Limit is parent, so we can not delete';
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
								<h4><i class="icon-globe"></i>Fuel Limit Master</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="btn-group">
                                <a href="FuelDetailEdit.php?action=Add"  role="button" class="btn green" data-toggle="modal">Add New Fuel Limit<i class="icon-plus"></i></a>								
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>SLNO</th>
                                             <th>Asset Number</th>
                                            <th>Vehicle Number</th>
                                            <th>Vehicle</th>
                                           <th> Fuel Limit</th>
                                            <th>Created Date</th>
                                            <th>Action</th>	
										</tr>
									</thead>
									<tbody>
                                    	<?php 
										$a=1;
										foreach ($allResult as $item){ ?>
                                       
										<tr class="odd gradeX">
                                            <td><?php echo $a; ?></td>
											<td><?php echo $item['asset_no']; ?></td>
											<td><?php echo $item['machine_no']; ?></td>
                                           	<td><?php echo $item['item_name']; ?></td>
                                           <td><?php echo $item['fuel_limit']; ?></td>
                                            <td><?php echo date('d/m/Y',strtotime($item['created_on'])); ?></td>
                                           	<td>
                                            <div class="flash" id="flash_<?php echo  $item['id_fuel']; ?>"></div>
                                      <a href="FuelDetailEdit.php?id=<?php echo  $item['id_asset_item']; ?>&action=edit" class="btn mini purple"><i class="icon-edit"></i>Edit</a> &nbsp; &nbsp;
                                            
                                          <?php /*?>  <a  class="delete btn mini black" href="javascript:void()" onclick=deleteBox(<?php echo  $item['id_fuel']; ?>)><i class="icon-trash"></i>Delete</a>   <?php */?>
                                           
                                            </td>
                                          
										</tr>
                                        <?php $a++; } ?>
										
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
									</div>
				
									<!-- END PAGE CONTENT-->
            
            
            
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
		var dataString = 'data=Fuellist&Fid='+ id;
		 alert(dataString);
		$("#flash_"+id).show();
		$("#flash_"+id).fadeIn(400).html('<img src="assets/img/loading.gif"/>');
		$.ajax({
			   type: "POST",
			   url: "delete.php",
			   data: dataString,
			   cache: false,
			   success: function(result){
				   alert(result);
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