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
 
  $oAssetVendor = &Singleton::getInstance('Vendor');
  $oAssetVendor->setDb($oDb);
  $oAssetAddress = &Singleton::getInstance('Address');
  $oAssetAddress->setDb($oDb);
  if(isset($aRequest['submit']))
  {
    if($oAssetVendor->addBuilding($aRequest))
	{
	   $msg = "New Bulding Added.";
	  
	}
	else $msg = "Sorry";
  } //submit
 //$allResult = $oAssetVendor->getAllVendorInfo();
 $allResult = $oAssetVendor->getUsertypeList("SUP");
/* echo '<pre>';
 print_r($allResult);
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
   <title>EAMS|Vendor</title>
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
                     Vendor 
                     <small>Vendor  master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Masters</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Vendor</a></li>
                  </ul>
               </div>
            </div>
            
                               <?php
							     if(isset($_GET['msg']))
								 {
							   ?>
							    <div class="alert alert-success">
									<button class="close" data-dismiss="alert"></button>
									<?php
									
									if($_GET['msg'] == 'success')
									{
										echo $msg = 'New Vendor Added Successfully';
									}
									else if($_GET['msg'] == 'updatesucess')
									{
										echo $msg = ' Vendor Updated Successfully';
									}
									else if($_GET['msg'] =='delsuccess')
									{
										echo $msg = ' Vendor Deleted Successfully';
									}
									else if($aRequest['msg'] =='trashsuccess')
									{
										echo $msg = 'Vendor Moved To Trash Successfully';
									}
									else if($aRequest['msg'] =='error')
									{
										echo $msg = 'Sorry Error occur, try again';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'This Vendor is parent, so we can not delete';
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
								<h4><i class="icon-globe"></i>Vendor Master</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="btn-group">
                               <!-- <a href="#myModal1"  role="button" class="btn green" data-toggle="modal">Add New <i class="icon-plus"></i></a>	-->
  <a href="SupplierEdit.php?action=Add"  role="button" class="btn green" data-toggle="modal">Add New <i class="icon-plus"></i></a>									   
									</div>
									
								</div>
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
											<th>SLNO</th>
											<th>Vendor Name</th>
                                            <th>LookUp</th>
											<th>Vendor City </th>
											<th>Phone</th>
											<th>Vendor Group</th>
											<th>Status</th>
											<th>Action</th>	
                                                							
											
										</tr>
									</thead>
									<tbody>
                                    	<?php 
										$i =1;
										foreach ($allResult as $item) {
																					
											 $aAddress = $oMaster->getContactInfo($item['id_address'],'id');
											
											?>
                                       
										<tr class="odd gradeX">
												<!--<td><input type="checkbox" class="checkboxes" value="<?php echo $item['item_cat_id'];?>" /></td> -->
											<td><?php echo $i;; ?></td>
											<td><?php echo $item['vendor_name']; ?></td>
                                            <td><?php echo $item['lookup']; ?></td>
											<td><?php $aCity = $oMaster->getCityInfo($aAddress['id_city'],'id'); echo $aCity['city_name'];?></td>
                                           	<td class="hidden-480"><?php echo $aAddress['phone'];?></td>
											<td><?php echo $item['itemgroup1_name'];?></td>
											<td><?php echo $oUtil->AssetItemStatus($item['status']);?></td>
                                            <td>
                                            <div class="flash" id="flash_<?php echo  $item['id_vendor']; ?>"></div>
                                            <a href="SupplierEdit.php?fVendorId=<?php echo  $item['id_vendor']; ?>&action=edit" class="btn mini purple"><i class="icon-edit"></i>Edit</a> &nbsp; &nbsp;    &nbsp; &nbsp;    <a href="Contact.php?fVendorId=<?php echo  $item['id_vendor']; ?>" class="btn mini purple"><i class="icon-edit"></i>View Contacts</a>  
											 <?php if($item['status']!=2)
											{
											?>
                                            <a  class="delete btn mini black" href="javascript:void()" onclick=deleteBox('<?php echo  $item['id_vendor']; ?>','supplierdelete','Move')><i class="icon-trash"></i>Delete</a>   
                                           <?php } else { ?>
										      <a  class="delete btn mini red" href="javascript:void()" onclick=deleteBox('<?php echo  $item['id_vendor']; ?>','supplierdelete','Permanent')><i class="icon-trash"></i>Delete</a>   
										   	<?php } ?>
                                           
                                           
                                            </td>
                                          
										</tr>
                                        <?php 
										$i++;
										} ?>
										
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
									</div>
				
									<!-- END PAGE CONTENT-->
            
            <div class="portlet-body">
								
								<!-- Button to trigger modal -->
								
								<div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h3 id="myModalLabel1">Add Building</h3>
									</div>
									<div class="modal-body">
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_sample_3" method="post">
									    <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
                       						 
                                      <div class="control-group">
                                       <label class="control-label">Unit Name</label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="1" name="fAssetUnitID">
                                             <option value="0">No Parent</option>
                                             <?php
											  $aAssetUnitInfo = $oAssetUnit->getAllAssetUnitInfo();
											  foreach($aAssetUnitInfo as $aAssetUnit)
											  {
			  
											 ?>
                                             <option value="<?php echo $aAssetUnit['id_unit']; ?>"><?php echo $aAssetUnit['unit_name']; ?></option>
                                             <?php
											  }
											 ?>
											  </select>
                                            <!--  <a href="AssetUnitEdit.php?action=Add">Add New Unit</a>-->
                                       </div>
                                    </div>
 
                                    <div class="control-group">
                                       <label class="control-label">Building Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fBuildingName" 		data-required="1"/>
                                          <span class="help-inline">Enter unit name</span>
                                       </div>
                                    </div>
									                                       
                                    <div class="control-group">
                                       <label class="control-label">Building Description<span class="required">*</span></label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fBuildingDesc"></textarea>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Building Status</label>
                                       <div class="controls">
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="1" checked />
                                          Active
                                          </label>
                                          <label class="radio line">
                                          <input type="radio" name="fStatus" value="0" />
                                          In-Active
                                          </label>  
                                       </div>
                                    </div>
                                   								
                                    <div class="form-actions">
                                  
                                       <button type="submit" class="btn blue" name="submit"><i class="icon-ok"></i> Add Building</button>
                                  
                                       <input type="reset" class="btn" value="Reset" name="reset" id="resetform"/>
                                    </div>
                                 </form>
									</div>
									
								</div>
								<!-- Modal -->
					</div>			
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