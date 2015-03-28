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
  if(isset($aRequest['id']))
  {
   $id_asset = $aRequest['id'];
  }
  else
  {
    $id_asset = $aRequest['fAssetNumber'];
	}
   $aAssetItem = $oMaster->getAssetItemInfo($id_asset,'id'); 
   $aAssetList = $oMaster->getStockList('asset');
  /* echo '<pre>';
   print_r($aAssetList);
    echo '</pre>';
   exit();*/
   
  
  if(isset($aRequest['send']))
  {
    if($oMaster->addFuelLimit($aRequest))
	{
	   $msg = "New Fuel Added.";
	  echo '<script type="text/javascript">window.location.href="FuelLimit.php?msg=success";</script>';
	}
	else $msg = "Sorry could ccc add..";
  } 
  if($aRequest['action'] == 'bill')
  {
	$item_id = $aRequest['id'];
	$bill_result = $oMaster->getFuelInfo($item_id,'id');
	 
  } //edit
/* echo '<pre>';
  print_r($edit_result);
  exit();*/
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Fuel</title>
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
                     Fuel
                     <small>Fuel master</small>
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
                     <li><a href="#">Fuel</a></li>
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
                                    <a href="Fuel.php" class="btn red mini active">Back to List</a>
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
                      <?php if($aRequest['action'] == 'Add')
							{ ?>
                        <h4><i class="icon-reorder"></i>Add Fuel</h4>
                         <?php } else if($aRequest['action'] == 'bill'){?>
                          <h4><i class="icon-reorder"></i>Add Bill</h4>
                     <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit Fuel</h4>
                        <?php } ?>
                        <div class="tools">
                           <a href="javascript:;" class="collapse"></a>
                           <a href="#portlet-config" data-toggle="modal" class="config"></a>
                           <a href="javascript:;" class="reload"></a>
                           <a href="javascript:;" class="remove"></a>
                        </div>
                     </div>
                     <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                       
                                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_fuellimit_addnew" method="post"  enctype="multipart/form-data">
									    <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
                       				<div class="row-fluid">
								<div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Select Asset</label>
                               <div class="controls">
                                       
                                        <select class="span12 chosen" data-placeholder="Select Asset" tabindex="4" name="fAssetNumber" id="fAssetNumber" onChange="ShowResult(this.value);" >
                                          <option value=""></option>
                                         
                                              
                                          <?php
											 
											  foreach($aAssetList as $aAssets)
											  {
											 ?>
                                             
                                             
                                             <option value="<?php echo $aAssets['id_asset_item']; ?>"<?php if($aAssets['id_asset_item'] == $aAsset['id_asset_item'] || $id_asset  == $aAssets['id_asset_item']) { echo 'selected=selected' ;}?>><?php echo $aAssets['asset_no']; ?></option>
                                           
                                             <?php
											  }
											 ?>
                                         
                                             </select>
                                         
                                             </div>
                                          </div>
                                       </div>
								</div>	
													
								<?php if(!empty($aAssetItem)  || !empty($id_asset))
								{
								?>
										
								<h3 class="form-section">Fuel For</h3>
                                 <table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>Asset Number</th>
                                            <th>Item Group 1 </th>
                                             <th>Item Group 2 </th>
											<th class="hidden-480">Item Name</th>
											 <th>Current Unit </th>
                                             <th>Current Store </th>
                                            </tr>
									</thead>
									<tbody>
                                    <?php 
									$aAssetItemList = $oMaster->getAssetItemInfo($id_asset,'id');
									foreach($aAssetItemLists as $aAssetItemList)
									{
														
									?>
										<tr class="odd gradeX">
											
											<td><?php echo $aAssetItemList['asset_no'];?></td>
                                            <td><?php echo $aAssetItemList['itemgroup1_name'];?></td>
                                            <td><?php echo $aAssetItemList['itemgroup2_name'];?></td>
											<td ><?php echo $aAssetItemList['item_name'];?></td>
                                            <td><?php echo $aAssetItemList['unit_name'];?></td>
											<td ><?php echo $aAssetItemList['store_name'];
											?></td>
                                            
										</tr>
										<?php }
										?>
                                       
                       					<tr class="odd gradeX">
										<td><?php echo $aAssetItem['asset_no'];?></td>
                                            <td><?php echo $aAssetItem['itemgroup1_name'];?></td>
                                            <td><?php echo $aAssetItem['itemgroup2_name'];?></td>
											<td ><?php echo $aAssetItem['item_name'];?></td>
                                            <td><?php echo $aAssetItem['unit_name'];?></td>
											<td ><?php echo $aAssetItem['store_name'];
											?></td>
											
										</tr>
                                        
									</tbody>
								</table>
								<br>
								<?php } ?>
										
										 <div class="control-group">
                                       <label class="control-label">Fuel Limit<span class="required">*</span></label>
                                       <div class="controls">
                                          <input type="text" placeholder="" class="m-wrap large" name="fFuelLimit" data-required="1" value="<?php echo $edit_result['fuel_limit']; ?>"/>       </div>
                                    </div>
								<div class="row-fluid">			                                     
                      		  <div class="span12 "> 
                                        <div class="control-group">
                                             <label class="control-label">Start Date</label>
                               <div class="controls">
                                    <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" placeholder="Start Date" size="10" type="text" name="fStartDate" value="<?php echo date('d-m-Y');?>" style="width:100px;"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
                                                 </div>
                                            </div>
                                       </div>
									   </div>
									
							
							
							
							
							
									<div class="row-fluid">
                                       <div class="span12">
                                          <div class="control-group">
                                             <label class="control-label">Remark</label>
                                             <div class="controls">
                                                <textarea class="large m-wrap" tabindex="18" rows="3" name="fRemarks"><?php echo $aFuelInfo['remarks'];?></textarea>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       
                                       
                                    </div>
                                    <div class="form-actions">
                                   <?php if($aRequest['action'] == 'Add')
								   {
								   ?>
                                   <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Add Fuel</button>                          			<?php /*?><input type="hidden" name="fAssetNumber"  value="<?php echo  $id_asset;?>"/><?php */?>
								   <?php
								   } else if($aRequest['action'] == 'edit'){
								   ?>
                                    <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i>Edit Fuel</button> 
										<?php /*?><input type="hidden" name="fAssetNumber"  value=""<?php echo  $id_asset;?>"/><?php */?>
									
                                   <?php
								   } 
								   ?>
								   <button type="button" class="btn">Cancel</button>
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
	
	  function getItemList(id)
		{
			//var id = $("#fFromStoreId").val();
		      	var dataStr = 'action=getItemList&fromstoreId='+id;
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				  $("#ItemList").html(result);
				
				 
			   }
          });
			}
	
		 
		 function getGroup2ItemListing(id)
		 {
			  var storeId =  $('#fFromStoreId').val();	  
			var dataStr = 'action=getGroupItemList&Group1Id='+id+'&StoreId='+storeId;
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
			           $("#Group2ItemList").html(result);
				 
			   }
         
		  
		 });
		 
		 	var dataStr = 'action=getGroupItemList1&Group1Id='+id+'&StoreId='+storeId;
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
			        $("#ItemsList").html(result);
				 
			   }
         
		  
		 });
		
		  
		 
		 }
	</script>
	
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
			
			function ShowResult(id)
			{
			url = document.URL.split("?")[0];
			var dropresult = addParam(url, "id",id);	
			var dropresult = addParam(dropresult, "action",'Add');	
			window.location.href = dropresult;
			}
			</script>
</body>
<!-- END BODY -->
</html>