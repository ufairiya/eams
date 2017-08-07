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
   <title>EAMS|Transport Report</title>
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
                     Transport Report
                     <small>Transport Report master</small>
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
                     <li><a href="#">Transport Report</a></li>
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
                                    <a href="TransportReportList.php" class="btn red mini active">Back to List</a>
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
                     
                          <h4><i class="icon-reorder"></i>Transport Report</h4>
                                              
                     </div>
                     <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                       
                                 <form action="TransportReportList.php" class="form-horizontal" id="form_sample_3" method="post">
									    <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
                       		                                                  
                              <div class="row-fluid">
								<div class="span12 ">
								<div class="control-group">
								<label class="control-label">Item Group1</label>
								<div class="controls">
								<select class="m-wrap margin" tabindex="2" name="fGroup1" onChange="getGroup2ItemListing(this.value);" id="fGroup1" >
								<option value="0" selected="selected" >Choose the ItemGroup 1 </option>
								<?php
								$aItemGroup1List = $oMaster->getItemGroup1List();
								foreach($aItemGroup1List as $aItemGroup1)
								{
								?>
								
								<option value="<?php echo $aItemGroup1['id_itemgroup1']; ?>" <?php if($aServiceInfo['id_itemgroup1'] == $aItemGroup1['id_itemgroup1']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup1['itemgroup1_name']; ?></option>
								<?php
								}
								?>
								</select>
								</div>
								</div>
								</div>
								</div>
								
								<div class="row-fluid">
								<div class="span12 ">
								<div class="control-group">
								<label class="control-label">Brand / Make</label>
								<div class="controls" id="Group2ItemList">
								<select class="m-wrap" tabindex="3" name="fGroup2">
								<option value="0" selected="selected" >Choose the Brand / Make </option>
								
								</select>
								</div>
								</div>
								</div>
								</div>
								
								<div class="row-fluid">
								
								<div class="span12 ">
								<div class="control-group" >
								<label class="control-label">Item</label>
								<div class="controls" id="ItemsList">
								<select class="m-wrap  nextRow margin" tabindex="1" name="fItemName">
								<option value="0" >Choose the Item</option>
								
								</select>
								</div>
								</div>
								</div>
								</div>
								
								<div class="row-fluid">
                                       <div class="span12 ">
								<div class="controls">
                                 <label class="checkbox">
                                 <div class="checker" id="uniform-undefined"><span class="checked"><input type="checkbox" name="fCheck[]" value="Fuel" id="fFuel" style="opacity: 0;"></span></div> Fuel
                                 </label>
                                 <label class="checkbox">
                                 <div class="checker" id="uniform-undefined"><span class="checked"><input type="checkbox" name="fCheck[]" value="Service" id="fService" style="opacity: 0;"></span></div> Service
                                 </label>
                              </div>
							  </div>
							  </div>
								 <br>
                                  <div class="form-horizontal form-view">
                                     <div id="machinenumberlist" style="display:none"> 
								    <div class="row-fluid">
                                       <div class="span4 ">
									<div class="control-group">
                                             <label class="control-label"> Start Date</label>
                                               <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text"  name="fStartDate"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
                                            
                                          </div>
                                          </div>
                                           <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label">End Date</label>
                                               <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10"  type="text" name="fEndDate"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
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
   <script type="text/javascript" >
   function getGroup2ItemListing(id,group2id,itemid)
		 {
			 
			var dataStr = 'action=getGroupsItemList&Group1Id='+id+'&group2Id='+group2id;
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				          $("#Group2ItemList").html(result);
				 
			   }
         
		  
		 });
		 
		 	var dataStr = 'action=getGroupsItemList1&Group1Id='+id+'&itemId='+itemid;
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/dropdown.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
			        $("#ItemsList").html(result);
				 
			   }
         
		  
		 });
		
		  
		 
		 }	
		 
		 function getItemLising(id)
		 {
		 	var group1 = $('#fGroup1').val();
			var dataStr = 'action=getItemList2&Group2Id='+id+'&Group1Id='+group1;
			 $.ajax({
			   type: 'POST',
			   url: 'ajax/dropdown.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
			          $("#ItemsList").html(result);
				 
			   }
         
		  
		 });
		
		  
		 }			
   
    jQuery(document).ready(function() { 

		 $('#fFuel').click(function() {

    $("#machinenumberlist").toggle(this.checked);

});

		 

		  }); //
   </script>
        
</body>
<!-- END BODY -->
</html>