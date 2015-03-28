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
    
  if(isset($aRequest['submit']))
  {
    if($oAssetUnit->addAssetUnit($aRequest))
	{
	   $msg = "New Unit Added.";
	 /*  echo '<script type="text/javascript">window.location.reload();</script>';*/
	}
	else $msg = "Sorry";
  } //submit
  if(isset($aRequest['update']))
  {
    //print_r($aRequest);
     $item_cat_id     = $aRequest['item_cat_id'];
	 $itemCatName     = $aRequest['fItemCatName'];
	 $itemCatDesc     = $aRequest['fItemCatDesc'];
    if($oAssetUnit->updateAssetUnit($aRequest))
	{
	  $msg = "New Item Category Updated.";
	 /* echo '<script type="text/javascript">window.location.reload();</script>';*/
	}
	else $msg = "Sorry";
  } //update
  if($_REQUEST['action'] == 'edit')
  {
	$item_id = $_REQUEST['eid'];
	$edit_result = $oAssetUnit->getAssetUnitInfo($item_id);
  } //edit
  
  $allResult = $oAssetUnit->getAllAssetUnitInfo();
 /* echo '<font color="white">';
  print_r( $allResult ); 
  echo '</font>';*/
   
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Unit </title>
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
							     if(isset($_GET['msg']))
								 {
							   ?>
							    <div class="alert alert-success">
									<button class="close" data-dismiss="alert"></button>
									<?php
									
									if($_GET['msg'] == 'success')
									{
										echo $msg = 'New Unit Added Successfully';
									}
									else if($_GET['msg'] == 'updatesucess')
									{
										echo $msg = 'New Unit Updated Successfully';
									}
									else if($_GET['msg'] =='delsuccess')
									{
										echo $msg = 'New Unit Deleted Successfully';
									}
									else if($aRequest['msg'] =='trashsuccess')
									{
										echo $msg = 'Unit Moved To Trash Successfully';
									}
									else if($aRequest['msg'] =='error')
									{
										echo $msg = 'Sorry Error occur, try again';
									}
									else if($aRequest['msg'] =='undelsuccess')
									{
										echo $msg = 'This Unit is parent, so we can not delete';
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
								<h4><i class="icon-globe"></i>Unit Master</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="btn-group">
                                <a href="AssetUnitEdit.php?action=Add"  role="button" class="btn green" data-toggle="modal">Add New <i class="icon-plus"></i></a>								
									</div>
								</div>
								<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
											<th>SLNO</th>
											<th>Unit Name</th>
											<th>Parent Unit Name</th>
											<th>Unit In-Charge</th>
                                            <th>Unit Address</th>
											<th>Status</th>
											<th>Action</th>	
                                                							
											
										</tr>
									</thead>
									<tbody>
                                    	<?php 
										$i = 1;
										foreach ($allResult as $item): ?>
                                       
										<tr class="odd gradeX">
												<!--<td><input type="checkbox" class="checkboxes" value="<?php echo $item['item_cat_id'];?>" /></td> -->
											<td><?php echo $i; ?></td>
											<td><?php echo $item['unit_name']; ?></td>
											<td><?php echo $item['asset_parent_unit_name']; ?></td>
											<td ><?php $aEmployeeInfo = $oMaster->getEmployeeInfo($item['id_employee']);
											
											echo $aEmployeeInfo['employee_name'];
											 ?></td>
                                             <td><?php $aUnitaddress = $oMaster->getUnitAddress($item['id_unit_address'],$item['unit_name'],'id'); 
											 echo $aUnitaddress['address_format'];
											 ?></td>
											<td><?php echo $oUtil->AssetItemStatus($item['status']);?> </td>
                                            <td>
                                            <div class="flash" id="flash_<?php echo  $item['id_unit']; ?>"></div>
                                            <a href="AssetUnitEdit.php?fAssetUnitID=<?php echo  urlencode($item['id_unit']); ?>&action=edit" class="btn mini purple"><i class="icon-edit"></i>Edit</a> &nbsp; &nbsp;
                                            
                                            <?php if($item['status']!=2)
											{
											?>
											 <a  class="delete btn mini black" href="javascript:void()" onclick=deleteBox('<?php echo  $item['id_unit']; ?>','unitdelete','Move')><i class="icon-trash"></i>Delete</a>
											<?php } else { ?>
											  <a  class="delete btn mini red" href="javascript:void()" onclick=deleteBox('<?php echo  $item['id_unit']; ?>','unitdelete','Permanent')><i class="icon-trash"></i>Delete</a>
											<?php } ?>
                                           
                                            </td>
                                          
										</tr>
                                        <?php 
										$i++;
										endforeach; ?>
										
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
										<h3 id="myModalLabel1">Add Unit</h3>
									</div>
									<div class="modal-body">
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_sample_3" method="post">
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
                                             <option value="<?php echo $aAssetUnit['id_unit']; ?>"><?php echo $aAssetUnit['unit_name']; ?></option>
                                             <?php
											  }
											 ?>
											  </select>
                                       </div>
                                    </div>
 
                                    <div class="control-group">
                                       <label class="control-label">Unit Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fAssetUnitName" 		data-required="1"/>
                                          <span class="help-inline">Enter unit name</span>
                                       </div>
                                    </div>
									                                       
                                    <div class="control-group">
                                       <label class="control-label">Unit Description<span class="required">*</span></label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fAssetUnitDesc"></textarea>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Unit Status</label>
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
                                  
                                       <button type="submit" class="btn blue" name="submit"><i class="icon-ok"></i> Add Unit</button>
                                  
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