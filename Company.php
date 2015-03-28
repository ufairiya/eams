<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $allResult = $oMaster->getCompanyList();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|Company </title>
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
                     Company 
                     <small>Company master</small>
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
                     <li><a href="#">Company</a></li>
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
										echo $msg = 'New Company Added Successfully';
									}
									else if($aRequest['msg'] == 'updatesucess')
									{
										echo $msg = 'Company Updated Successfully';
									}
									else if($aRequest['msg'] =='delsuccess')
									{
										echo $msg = 'Company Deleted Successfully';
									}
									else if($aRequest['msg'] =='trashsuccess')
									{
										echo $msg = 'Company Moved To Trash Successfully';
									}
									else if($aRequest['msg'] =='error')
									{
										echo $msg = 'Sorry Error occur, try again';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'This Company is parent, so we can not delete';
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
								<h4><i class="icon-globe"></i>Company Master</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="btn-group">
                                <a href="CompanyEdit.php?action=Add"  role="button" class="btn green" data-toggle="modal">Add New <i class="icon-plus"></i></a>								
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th>SLNO</th>
											<th>Company Name</th>
											<th>Lookup</th>
											<th>Phone</th>
											<th>Status</th>
											<th>Action</th>	
										</tr>
									</thead>
									<tbody>
                                    	<?php 
										$i =1;
										foreach ($allResult as $item): ?>
                                       
										<tr class="odd gradeX">
											<td><?php echo $i; ?></td>
											<td><?php echo $item['company_name']; ?></td>
											<td><?php echo $item['lookup']; ?></td>
											<td><?php echo $item['phone']; ?></td>
											<td><?php echo $oUtil->AssetItemStatus($item['status']);?> </td>
                                            <td>
                                            <div class="flash" id="flash_<?php echo  $item['id_company']; ?>"></div>
											<a href="CompanyEdit.php?fCompanyId=<?php echo  urlencode($item['id_company']); ?>&action=edit" class="btn mini purple icn-only"><i class="icon-edit"></i></a>&nbsp; &nbsp;
											 <?php if($item['status']!=2)
											{
											?>
											 <a  class="delete btn mini black" href="javascript:void()" onclick=deleteBox('<?php echo  $item['id_company']; ?>','companydelete','Move')><i class="icon-trash"></i>Delete</a>
											<?php } else { ?>
											  <a  class="delete btn mini red" href="javascript:void()" onclick=deleteBox('<?php echo  $item['id_company']; ?>','companydelete','Permanent')><i class="icon-trash"></i>Delete</a>
											<?php } ?>
											
											
                                           
                                            </td>
                                          
										</tr>
                                        <?php 
										$i ++;
										endforeach; ?>
										
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