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
   

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|Stock Report</title>
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
                     Stock Report
                     <small>Stock Report master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Report</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Stock Report</a></li>
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
                                    <a href="StockReportList.php" class="btn red mini active">Back to List</a>
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
                     
                          <h4><i class="icon-reorder"></i>Stock Report</h4>
                                              
                     </div>
                     <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                       
                                 <form action="StockReportList.php" class="form-horizontal" id="form_sample_3" method="post">
									    <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
                       			
									<div class="control-group">
                                       <label class="control-label">Unit</label>
                                       <div class="controls">
                                          <select class=" m-wrap chosen" data-placeholder="Choose a  Unit" tabindex="1" name="fUnitId" onChange="getstore(this.value)">
                                        	  <option value=""></option>
                                             <?php
											  $aUnitList = $oAssetUnit->getAllAssetUnitInfo();
											  foreach($aUnitList as $aUnit)
											  {
			  
											 ?>
                                             <option value="<?php echo $aUnit['id_unit']; ?>" ><?php echo $aUnit['unit_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                       </div>
                                    </div>
									
                                    
									
                                          <div class="control-group">
                                             <label class="control-label">Store</label>
                               <div class="controls" id="StoreList">
                                       
                                        <select class="  m-wrap chosen" data-placeholder="Choose a  Store" tabindex="2" name="fStoreId" >
                                          <option value=""></option>
                                      
                                              
                                          <?php
											  $aStoreList = $oMaster->getStoreList();
											  foreach($aStoreList as $aStore)
											  {
											 ?>
                                             
                                             
                                             <option value="<?php echo $aStore['id_store']; ?>"><?php echo $aStore['store_name']; ?></option>
                                           
                                             <?php
											  }
											 ?>
                                          
                                             </select>
                                         
                                             </div>
                                          </div>
                                          
                                          <div class="control-group">
                                             <label class="control-label">Item Group 1</label>
                               <div class="controls">
                                          <select  class="  m-wrap chosen" data-placeholder="Choose Item Group 1" name="fGroup1">
                                            <option value="" selected="selected" >Choose the ItemGroup 1 </option>
											 <?php
											  $aItemGroup1List = $oMaster->getItemGroup1List();
											  foreach($aItemGroup1List as $aItemGroup1)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup1['id_itemgroup1']; ?>" ><?php echo $aItemGroup1['itemgroup1_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                          
                                          </div>
                                          </div>
                                        <div class="control-group">
                                             <label class="control-label">Item Group 2</label>
                               <div class="controls">
                               <select class="  m-wrap chosen" data-placeholder="Choose Item Group 2"  tabindex="4" name="fGroup2">
                                               <option value="" selected="selected" >Choose the ItemGroup 2 </option>
											 <?php
											  $aItemGroup2List = $oMaster->getItemGroup2List();
											  foreach($aItemGroup2List as $aItemGroup2)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup2['id_itemgroup2']; ?>" ><?php echo $aItemGroup2['itemgroup2_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                               </div>
                               </div>
                                  
                                    <div class="control-group">
                                             <label class="control-label">Item </label>
                               <div class="controls">
                               <select class="  m-wrap chosen" data-placeholder="Choose Item" name="fItemName">
                                    <option value="" >Choose the Item</option>
											 <?php
											  $aItemList = $oMaster->getItemList();
											  foreach($aItemList as $aItem)
											  {
											 ?>
                                             <option value="<?php echo $aItem['id_item']; ?>" ><?php echo $aItem['item_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                               </div>
                               </div>
                                  <div class="form-horizontal form-view">
                                    <div class="row-fluid">
                                       <div class="span4 ">
									<div class="control-group">
                                             <label class="control-label">Machine Purchased Start Date</label>
                                               <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text"  name="fStartDate"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
                                            
                                          </div>
                                          </div>
                                           <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label">Machine Purchased End Date</label>
                                               <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10"  type="text" name="fEndDate"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
                                            
                                          </div>
                                          </div>
                                          
                                           </div>
                                          </div>
                                    <div class="form-actions">
                                  
                                   <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Search</button>                          
								  
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
  <?php /*?> <script type="text/javascript" >
   function getstore(id)
   {
	    var dataStr = 'action=getStore&unitId='+id;
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				  $("#StoreList").html(result);
			  			 
			   }
          });
   }
   
   </script><?php */?>
        
</body>
<!-- END BODY -->
</html>