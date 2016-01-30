<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $oItemCategory = &Singleton::getInstance('ItemCategory');
  $oItemCategory->setDb($oDb);
    
  if(isset($aRequest['submit']))
  {
    if($oItemCategory->addItemCategory($aRequest))
	{
	   $msg = "New Item Category Added.";
	   echo '<script type="text/javascript">window.location.reload();</script>';
	}
	else $msg = "Sorry";
  } //submit
  if(isset($aRequest['update']))
  {
    //print_r($aRequest);
     $item_cat_id     = $aRequest['item_cat_id'];
	 $itemCatName     = $aRequest['fItemCatName'];
	 $itemCatDesc     = $aRequest['fItemCatDesc'];
    if($oItemCategory->updateItemCategory($aRequest))
	{
	  $msg = "New Item Category Updated.";
	  echo '<script type="text/javascript">window.location.reload();</script>';
	}
	else $msg = "Sorry";
  } //update
  if($_REQUEST['action'] == 'edit')
  {
	$item_id = $_REQUEST['eid'];
	$edit_result = $oItemCategory->getItemCategoryInfo($item_id);
  } //edit
  
  $allResult = $oItemCategory->getAllItemCategoryInfo();
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
   <title>Metronic | Form Stuff - Form Layouts</title>
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
                     Item Category
                     <small>Item Category master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Form Stuff</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Form Layouts</a></li>
                  </ul>
               </div>
            </div>
            
                              <?php
							     if(isset($msg))
								 {
							   ?>
							    <div class="alert alert-success">
									<button class="close" data-dismiss="alert"></button>
									<?php echo $msg; unset($msg); ?>
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
            
            <!-- BEGIN PAGE CONTENT-->
									<div class="row-fluid">
									<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-globe"></i>Managed Table</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									</div>
							</div>
							<div class="portlet-body">
								<div class="clearfix">
                                <div class="btn-group">
                                <a href="#myModal1"  role="button" class="btn green" data-toggle="modal">Add New <i class="icon-plus"></i></a>								
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
											<!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th> -->
											<th>Item Category ID</th>
											<th>Item Category Name</th>
											<th>Item Category Parent ID</th>
											<th class="hidden-480">Item Category Description</th>
											<th>Category Status</th>
												<th>Action</th>	
                                                							
											
										</tr>
									</thead>
									<tbody>
                                    	<?php foreach ($allResult as $item): ?>
                                       
										<tr class="odd gradeX">
												<!--<td><input type="checkbox" class="checkboxes" value="<?php echo $item['item_cat_id'];?>" /></td> -->
											<td><?php echo $item['item_cat_id']; ?></td>
											<td><?php echo $item['item_cat_name']; ?></td>
											<td><?php echo $item['item_parent_cat_id']; ?></td>
											<td class="hidden-480"><?php echo  $item['item_cat_desc']; ?></td>
											<td><?php  if( $item['item_cat_status'] == '1')
											{
											echo $status = '<span class="label label-success">Active</span>';
											}
											else
											{
											echo $status = '<span class="label label-warning">In-Active</span>';
											} ?></td>
                                            <td>
                                            <div class="flash" id="flash_<?php echo  $item['item_cat_id']; ?>"></div>
                                            <a href="ItemCategoryEdit.php?id=<?php echo  urlencode($item['item_cat_id']); ?>&action=edit" class="btn mini purple"><i class="icon-edit"></i>Edit</a> &nbsp; &nbsp;
                                            
                                            <a  class="delete btn mini black" href="javascript:void()" onclick=deleteBox(<?php echo  $item['item_cat_id']; ?>)><i class="icon-trash"></i>Delete</a>   
                                           
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
            
            <div class="portlet-body">
								
								<!-- Button to trigger modal -->
								
								<div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h3 id="myModalLabel1">Add Item Category</h3>
									</div>
									<div class="modal-body">
										<form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_sample_2" method="post">
									    <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
                       
								 
                                      <div class="control-group">
                                       <label class="control-label">Parent Category</label>
                                       <div class="controls">
                                          <select class="large m-wrap" tabindex="1" name="fItemParentCat">
                                             <option value="0">No Parent</option>
											 <?php
											 ?>
                                             <option value="2">Category 2</option>
											 <?php
											 ?>
                                          </select>
                                       </div>
                                    </div>
 
                                    <div class="control-group">
                                       <label class="control-label">Item Category Name<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fItemCatName" data-required="1" value="<?php echo $edit_result['item_cat_name'];?>"/>
                                          <span class="help-inline">Enter category name</span>
                                       </div>
                                    </div>
									                                       
                                    <div class="control-group">
                                       <label class="control-label">Item Category Description<span class="required">*</span></label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fItemCatDesc"><?php echo $edit_result['item_cat_desc'];?></textarea>
                                       </div>
                                    </div>
									
									 <div class="control-group">
                                       <label class="control-label">Radio Buttons</label>
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
                                     <input type="hidden" name="item_cat_id" value="<?php echo $_REQUEST['eid']; ?>"/>
									
                                    <div class="form-actions">
                                  
                                       <button type="submit" class="btn blue" name="submit"><i class="icon-ok"></i> Add Item Category</button>
                                  
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