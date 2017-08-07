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
   <title>EAMS|Po Item Search</title>
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
                  <!-- BEGIN STYLE CUSTOMIZER -->
                 
                  <!-- END STYLE CUSTOMIZER -->  
                  <h3 class="page-title">
                    Po Item Search
                     
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                      <li>
                        <a href="PurchaseOrder.php">Purchase Order</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">PO Item Search</a></li>
                  </ul>
               </div>
            </div>
            
                                                             
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
        
            			
            <div class="row-fluid">
               <div class="span12">
               
               <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue">
                     <div class="portlet-title">
                     
                          <h4><i class="icon-reorder"></i>PO Item Search</h4>
                                              
                     </div>
                     <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                       
                             
                              <form action="PoItemList.php" class="form-horizontal" id="form_sample_3" method="post">
                             
									    <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
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
                                    <div class="form-actions">
                                    <?php
									if(isset($aRequest['report']))
									{
									?>
                                    
                                    <?php
									}
									?>
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
  
</body>
<!-- END BODY -->
</html>