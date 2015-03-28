<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $oAssetCategory = &Singleton::getInstance('AssetCategory');
  $oAssetCategory->setDb($oDb);
$aInventoryItems = $oMaster->getInventoryList('grn');
$inventoryId = $aRequest['fGrnId'];
$counts = $oMaster->assetCount();
  $oAssetUnit = &Singleton::getInstance('AssetUnit');
  $oAssetUnit->setDb($oDb);
   if(isset( $inventoryId ))
	 {
		$aassetItemInfo = $oMaster->getAssetItemInfo($aRequest['assetId']);
		$aInvetoryItemInfo = $oMaster->getInventoryInfo($inventoryId,'id');
		$aVendorAddress =$oMaster->getVendorContactAddress($aInvetoryItemInfo['id_vendor']);
		$inventoryItemList = $oMaster->getInventoryItemList($inventoryId,'inspection','');
		$aInventoryItemAsset = $oMaster->getInventoryItemInfo($aRequest['fInventoryItemid'],'lookup');
		
		if($aInventoryItemAsset['return_status'] > 0)
		{
		$Quantity = $aInventoryItemAsset['balanced_qty'];
		}
		else
		{
		$Quantity = $aInventoryItemAsset['qty'];
		}
		
		
/*echo '<pre>';
print_r($aInventoryItemAsset );
echo '</pre>';*/
	 }
	 if(isset($aRequest['send']))
  {
    $oFormValidator->setField("ALLTEXT", " Asset Type", $aRequest['fAssetTypeId'], 1, '', '', '', '');
	 $oFormValidator->setField("ALLTEXT", " Machine Life", $aRequest['fMachineLife'], 1, '', '', '', '');
		
		
	  if($oFormValidator->validation())
	  {

	if($oMaster->addAssetItem($aRequest,$_FILES))
	{
	  $msg = "New Asset Added.";
	 /* echo '<script type="text/javascript">window.location.href="AssetDetails.php?assetId='.$result['asset_no'].'&id='.$result['id_vendor'].'&tab=2";</script>';*/
	 echo '<script type="text/javascript">window.location.href="AssetList.php?msg=success";</script>';
	}
	else $msg = "Sorry";
	}
      else
	  {
	   $errMsg = $oFormValidator->createMsg("<br />");
	  }
  } //submit 
  
   if(isset($aRequest['add']))
  {
    
	$oFormValidator->setField("ALLTEXT", " Asset Type", $aRequest['fAssetTypeId'], 1, '', '', '', '');
	 $oFormValidator->setField("ALLTEXT", " Machine Life", $aRequest['fMachineLife'], 1, '', '', '', '');	
		
	  if($oFormValidator->validation())
	  {
	if( $oMaster->addContract($aRequest,$_FILES))
	{
	   $msg = "New Contract Added.";
	  echo '<script type="text/javascript">window.location.href="AssetList.php?msg=updatesucess";</script>';
	}
	else $msg = "Sorry";
	}
      else
	  {
	   $errMsg = $oFormValidator->createMsg("<br />");
	  }
  } //submit 
	 
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS | Asset </title>
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
                     Asset
                     <small>Asset  master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Asset</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Add Asset </a></li>
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
										echo $msg = 'New Asset Added Successfully';
									}
									else if($_GET['msg'] == 'updatesucess')
									{
										echo $msg = 'New Asset Updated Successfully';
									}
									else if($_GET['msg'] =='delsuccess')
									{
										echo $msg = 'New Asset Deleted Successfully';
									}
									else if($_GET['msg'] =='undelsuccess')
									{
										echo $msg = 'This Asset is parent, so we can not delete';
									}
									   ?>
								</div>
                                
								<?php
								  }
								?> 
                                
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            
            <!-- BEGIN PAGE CONTENT-->
            <?php if(isset($aRequest['assetId']) || isset($aRequest['fGrnId']) || isset($aRequest['action'])) { ?>
            
            <?php } else { ?>
            <div class="row-fluid">
					<div class="span12">
                    <form action="Contract.php" class="form-horizontal" id="form_sample_3" method="post" enctype="multipart/form-data">
                    <?php
					$aAssetItemList = $oMaster->getAssetItemByGrn($aRequest['fgrnId'],$aRequest['fInventoryItemd']);?>
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box light-grey">
							<div class="portlet-title">
								<h4><i class="icon-globe"></i>Add Contract</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
									<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>											<th>Asset Number</th>
											<th class="hidden-480">Asset Name</th>
										
										</tr>
									</thead>
									<tbody>
                                    <?php foreach($aAssetItemList as $assetItem) { ?>
										<tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" name="fAssetNumber[]" value="<?php echo (!empty($assetItem['id_asset_item'])? $assetItem['id_asset_item']:$aRequest['fAssetNumber']);?>" /></td>
											<td><?php echo $assetItem['asset_no'];?></td>
											<td ><?php echo $assetItem['item_name'];?></td>
											
										</tr>
										<?php } ?>
                       
                                        
									</tbody>
								</table>
                                 <div class="row-fluid" style="text-align:center">
                                 <input type="hidden" name="fGrnId" value="<?php echo $aRequest['fgrnId'];?>"/>
                                 <input type="hidden" name="fMultiple" value="<?php echo $aRequest['fMultiple'];?>" />
                                 <button type="submit" class="btn blue" ><i class="icon-ok"></i> Add Contract</button>
                                 </div>
							</div>
						</div>
                        </form>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
            
            <?php }?>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_sample_3" method="post" enctype="multipart/form-data">
						<?php if(isset($aRequest['action']) || $aRequest['fGrnId'] && $aRequest['tab']!=2 ) {	?>
                        <div class="row-fluid">
                         <?php } else if($aRequest['tab']==2 ) { ?> 
                        <div class="row-fluid" style="display:none;">
                         <?php } else { ?> 
                        <div class="row-fluid" style="display:none;">
                        <?php } ?>
               <div class="span12">
                  <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue">
                     <div class="portlet-title">
                        <h4><i class="icon-reorder"></i>Asset Details</h4>
                        <div class="tools">
                           <a href="javascript:;" class="collapse"></a>
                          
                        </div>
                     </div>
                     <div class="portlet-body form">
                    
                       <div class="row-fluid">
                                       <div class="span6">
                                          <div class="control-group error">
                                             <label class="control-label">GRN No:</label>
                                             <div class="controls">
                                              <select class="chosen" data-placeholder="Choose a Inventory ID" tabindex="1" name="fgrnId" id="fgrnId" onChange="ShowResult(this.value,'')">
     										    <option value="0"></option>
												  <?php
												 
												  foreach($aInventoryItems as $aInventoryItem)
												  {
												 ?>
												 <option value="<?php echo $aInventoryItem['id_inventory']; ?>" <?php if((!empty($inventoryId)? $inventoryId:$aRequest['fgrnId']) == $aInventoryItem['id_inventory'] || (!empty($aassetItemInfo['id_grn'])? $aassetItemInfo['id_grn']:$aRequest['fgrnId'])== $aInventoryItem['id_inventory']) { echo 'selected=selected' ;}?> ><?php echo $aInventoryItem['grn_no']; ?></option>
												 <?php
												  }
												 ?>
                                             </select>
                                              </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       
                                       <div class="span6">
                                          <div class="control-group error">
                                             <label class="control-label">Item:</label>
                                             <div class="controls" id="inventoryitemlist">
                                           <select class="span6 chosen" data-placeholder="Choose a Inventory Item" tabindex="1" name="fInventoryItemid" id="fInventoryItemd" onChange="ShowResult(this.value,<?php echo $inventoryId;?>)">
                                           <option value="0"></option>
                                         <?php foreach($inventoryItemList as $inventoryItem)
										 { ?>
                                           <option value="<?php echo $inventoryItem['id_inventory_item']?>" <?php if((!empty($aRequest['fInventoryItemid'])? $aRequest['fInventoryItemid']:$aRequest['fInventoryItemid']) == $inventoryItem['id_inventory_item']  || (!empty($aassetItemInfo['id_inventory_item'])? $aassetItemInfo['id_inventory_item']:$aRequest['fInventoryItemid'])== $inventoryItem['id_inventory_item']  ) { echo 'selected=selected' ;}?> ><?php echo $inventoryItem['item_name'];?></option>
                                          <?php } ?>
                                           </select>
                                              </div>
                                          </div>
                                       </div>
                                       
                                        
                                       </div>
                                   
                        <!-- END FORM-->           
                     </div>
                  </div>
                  <!-- END SAMPLE FORM PORTLET-->
               </div>
            </div>	
                         	
				<?php if(isset($aRequest['fGrnId']) || $aRequest['tab'] ) {	?>
                  <div class="row-fluid">               
                         <?php }else { ?>              	
				<div class="row-fluid" style="display:none">
                 <?php } ?>  
               <div class="span12">
                  <div class="tabbable tabbable-custom boxless">
                     <ul class="nav nav-tabs">
                      <?php if($aRequest['tab'] == '1') { ?>
                        <li class="active"><a  href="#tab_1" data-toggle="tab">Inventory Details</a></li>
                        
                     <?php } ?>
                       
                     </ul>
                     <div class="tab-content">
                      <?php if($aRequest['tab'] == '1') { ?>
                        <div class="tab-pane active" id="tab_1">
                         <?php } else {?>
                        <div class="tab-pane" id="tab_1">
                       
                        <?php } ?>
                           <div class="portlet box blue">
                              <div class="portlet-title">
                                 <h4><i class="icon-reorder"></i>Inventory Details</h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="javascript:;" class="reload"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                              
                                                          <?php		                                     
                                    if(!empty($errMsg))
										  {
										?>
										  <div class="alert alert-success" id="error_msg">
									         <button class="close" data-dismiss="alert"></button>
											 <?php echo $errMsg; ?>
									      <div id= delete_info></div>
								         </div>
										<?php
										  }
										?>              
                                    <!--/row-->
                                     <div class="form-horizontal form-view">
                                   <h3 class="form-section"></h3>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                              <div class="control-group">
                                              <label class="control-label">Bill Number:</label>
                                             <div class="controls">
                                               <span class="text"><?php echo $aInvetoryItemInfo['bill_number'];?></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                     </div>
                                    <!--/row-->
                                    <div class="row-fluid">
                                       
                                        <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">D C No:</label>
                                             <div class="controls">
                                                 <span class="text"><?php echo $aInvetoryItemInfo['dc_number'];?></span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
									   <div class="span6 ">
                                          <div class="control-group">
											  <label class="control-label" style="width:60px; text-align:left;">DC Date:</label>
											  <div class="controls" style="margin-left:60px;">
												   <span class="text"><?php echo date('d-m-Y',strtotime($aInvetoryItemInfo['dc_date']));?></span>
												 </div>
											  </div>
										   </div>
                                    </div>
                                    <!--/row-->        
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                              <label class="control-label">PO Number:</label>
                                             <div class="controls">
                                               <span class="text"><input type="hidden" name="fPoId" value="<?php echo $aInvetoryItemInfo['id_po'];?>"/><?php echo (!empty($aInvetoryItemInfo['po_number'])? $aInvetoryItemInfo['po_number']:$aRequest['fPoId']);?></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
											  <label class="control-label" style="width:60px; text-align:left;">PO Date:</label>
											  <div class="controls" style="margin-left:60px;">
												   <span class="text"><?php echo date('d-m-Y',strtotime($aInvetoryItemInfo['po_date']));?></span>
												 </div>
											  </div>
										   </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->                               
                                       <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Vendor Details:</label>
                                             <div class="controls">
                                                <span class="text"><input type="hidden" name="fVendorId" value="<?php echo (!empty($aInvetoryItemInfo['id_vendor'])? $aInvetoryItemInfo['id_vendor']:$aRequest['fVendorId']);?>"/> <?php  echo $aVendorAddress[0]['address_format'];    ?></span>
                                             </div>
                                          </div>
                                       </div>
                                       
                                       <!--/span-->
                                    </div>                           
                                 </div>
                                     
                                     <?php if(isset($aRequest['fInventoryItemid'] )|| $aRequest['assetId'] ) {	?>
                   <div class="form-horizontal form-view">             
                         <?php }else { ?>              	
				  <div class="form-horizontal form-view" style="display:none;">
                 <?php } ?>             
                                   
                                   <h3 class="form-section"></h3>
                                   <div class="row-fluid">
                                       <div class="span6 ">
                                              <div class="control-group">
                                              <label class="control-label">Asset Number:</label>
                                              <?php if(isset($aRequest['assetId'])) { ?>
                                             <div class="controls">
                                               <span class="text"><?php echo $aassetItemInfo['asset_no']; ?></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                             <?php } else {?>
                                             <div class="controls">
                                               <span class="text"><input type="hidden" name="fAssetNo" value"<?php echo $counts['count']; ?>"/><?php echo $counts['count']; ?></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                             <?php } ?>
                                          </div>
                                       </div>
                                       <!--/span-->
                                      
                                       <div class="span6 ">  
                                      <div class="control-group">
                                              <label class="control-label" style="width:60px; text-align:left;">Store : </label>
                                              
                                             <div class="controls">
                                             <select class="m-wrap chosen" data-placeholder="Choose a Store"  name="fStoreId" id="fStoreId">
                                          
                                          <option value="0">Choose a Store</option>
                                          <?php
											  $aUnitList = $oAssetUnit->getAllAssetUnitInfo();
											  foreach($aUnitList as $aUnit)
											  {
											 ?>
                                              <optgroup label="<?php echo  $aUnit['unit_name'];?>">
                                              
                                          <?php
											  $aStoreList = $oMaster->getStoreListInfo($aUnit['id_unit'],'unit');
											  foreach($aStoreList as $aStore)
											  {
											 ?>
                                             
                                             
                                             <option value="<?php echo $aStore['id_store']; ?>/<?php echo $aUnit['id_unit'];?>" <?php if($aInvetoryItemInfo['id_store'] == $aStore['id_store']) { echo 'selected=selected' ;}?>><?php echo $aStore['store_name']; ?></option>
                                           
                                             <?php
											  }
											 ?>
                                           </optgroup>
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
                                              <label class="control-label">Asset Type: <span class="required">*</span></label>
									   <div class="controls">
											  <select class="chosen" data-placeholder="Choose Asset type"  tabindex="1" name="fAssetTypeId">
												 <option value="0">Choose Asset type</option>
												 <?php
												  $aAssetTypeInfo = $oAssetType->getAllAssetTypeList();
												  foreach($aAssetTypeInfo as $aAssetType)
												  {
									
												 ?>
												 <option value="<?php echo $aAssetType['id_asset_type']; ?>"<?php if((!empty($aInventoryItemAsset['id_asset_type'])? $aInventoryItemAsset['id_asset_type']:$aRequest['fAssetTypeId']) == $aAssetType['id_asset_type']) { echo 'selected=selected' ;}?>><?php echo $aAssetType['asset_type_name']; ?></option>
												 <?php
												  }
												 ?>
												  </select>
												<!--  <a href="AssetUnitEdit.php?action=Add">Add New Unit</a>-->
										   </div>
										   </div>
									</div></div>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                              <div class="control-group">
                                              <label class="control-label">Item Group1:</label>
                                               <?php if(isset($aRequest['assetId'])) { ?>
                                             <div class="controls">
                                               <span class="text"><?php echo $aassetItemInfo['asset_name']; ?></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                             <?php } else {?>
                                             <div class="controls">
                                              <select class="chosen" data-placeholder="Choose a Group 1" tabindex="2" name="fGroup1">
                                            <option value="0" selected="selected" >Choose the ItemGroup 1 </option>
											 <?php
											  $aItemGroup1List = $oMaster->getItemGroup1List();
											  foreach($aItemGroup1List as $aItemGroup1)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup1['id_itemgroup1']; ?>" <?php if($aInventoryItemAsset['id_itemgroup1'] == $aItemGroup1['id_itemgroup1']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup1['itemgroup1_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                               <?php } ?>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       </div>
                                        <div class="row-fluid">
                                         <?php if(isset($aRequest['assetId'])) { ?>
                                         
                                       <div class="span6 " >
                                          <div class="control-group" >
                                             <label class="control-label" style=" text-align:left;">Item Group 2:</label>
                                             <div class="controls">
                                                <select class="chosen" data-placeholder="Choose a Group 2" tabindex="3" name="fGroup2">
                                               <option value="0" selected="selected" >Choose the ItemGroup 2 </option>
											 <?php
											  $aItemGroup2List = $oMaster->getItemGroup2List();
											  foreach($aItemGroup2List as $aItemGroup2)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup2['id_itemgroup2']; ?>" <?php if($aInventoryItemAsset['id_itemgroup2'] == $aItemGroup2['id_itemgroup2']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup2['itemgroup2_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                             </div>
                                          </div>
                                       </div>
                                       <?php } else { ?>
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label"> Item Group 2:</label>
                                             <div class="controls">
                                               <select class="chosen" data-placeholder="Choose a Group 2" tabindex="3" name="fGroup2">
                                               <option value="0" selected="selected" >Choose the ItemGroup 2 </option>
											 <?php
											  $aItemGroup2List = $oMaster->getItemGroup2List();
											  foreach($aItemGroup2List as $aItemGroup2)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup2['id_itemgroup2']; ?>" <?php if($aInventoryItemAsset['id_itemgroup2'] == $aItemGroup2['id_itemgroup2']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup2['itemgroup2_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                             </div>
                                          </div>
                                       </div>
                                       <?php } ?>
                                        </div>
                                        <div class="row-fluid">
                                       <div class="span6" >
                                              <div class="control-group">
                                              <label class="control-label"> Item Name:</label>
                                               <?php if(isset($aRequest['assetId'])) { ?>
                                             <div class="controls">
                                              <select class="chosen" data-placeholder="Choose a Item" tabindex="1" name="fItemName">
                                    <option value="0" >Choose the Item</option>
											 <?php
											  $aItemList = $oMaster->getItemList();
											  foreach($aItemList as $aItem)
											  {
											 ?>
                                             <option value="<?php echo $aItem['id_item']; ?>" <?php if($aInventoryItemAsset['id_item'] == $aItem['id_item']) { echo 'selected=selected' ;}?>><?php echo $aItem['item_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select> 
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                             <?php } else {?>
                                             <div class="controls">
                                            <select class="chosen" data-placeholder="Choose a Item" tabindex="1" name="fItemName">
                                    <option value="0" >Choose the Item</option>
											 <?php
											  $aItemList = $oMaster->getItemList();
											  foreach($aItemList as $aItem)
											  {
											 ?>
                                             <option value="<?php echo $aItem['id_item']; ?>" <?php if($aInventoryItemAsset['id_item'] == $aItem['id_item']) { echo 'selected=selected' ;}?>><?php echo $aItem['item_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                               <?php } ?>
                                          </div>
                                       </div>
                                     </div>
                                    <!--/row-->
                                    <div class="row-fluid">
                                        <!--/span-->
									   <div class="span4 " style="width:150px;">
                                          <div class="control-group">
											  <label class="control-label" >Quanity:</label>
                                                <?php if(isset($aRequest['assetId'])) { ?>
                                         
											 <div class="controls">
												   <span class="text">1</span>
												 </div>
                                             <?php } else {?>
											  <div class="controls">
												   <span class="text"><input type="hidden" name="fInventoryItemqty" value="<?php echo (!empty($Quantity)? $Quantity:$aRequest['fInventoryItemqty']);?>"/><?php echo $Quantity;?></span>
                                                   
												 </div>
                                                
                                                  <?php } ?>
											  </div>
										   </div>
                                           
                                           <div class="span4" style="margin-left: -76px;">
                                          
                                           <div class="controls" >  
                                                 <select class="m-wrap ysmall chosen"  data-placeholder="Choose a UOM" name="fUOMId" >
                                               <option value="0">UOM</option>
											 <?php
											  $aUOMList= $oMaster->getUomList();
											  foreach($aUOMList as $aUOM)
											  {
			  
											 ?>
                                             <option value="<?php echo $aUOM['id_uom']; ?>" <?php if((!empty($inventoryItemList[0]['id_uom'])? $inventoryItemList[0]['id_uom']:$aRequest['fLookup']) == $aUOM['id_uom']) { echo 'selected=selected' ;}?>><?php echo $aUOM['uom_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                         
                                          </div>
                                          </div>
                                        <div class="span4">
                                          <div class="control-group">
                                              <label class="control-label" >Price:</label>
                                                <?php if(isset($aRequest['assetId'])) { ?>
                                               <div class="controls">
                                               <span class="text"><?php echo $aassetItemInfo['asset_amount']; ?></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                             <?php } else {?>
                                             <div class="controls">
                                               <span class="text"><input type="hidden" name="fAssetAmount" value="<?php echo (!empty($aInventoryItemAsset['unit_cost'])? $aInventoryItemAsset['unit_cost']:$aRequest['fAssetAmount']) ;?>"/><?php echo $aInventoryItemAsset['unit_cost'];?></span>
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                                <?php } ?>
                                          </div>
                                       </div>
                                    </div>
                                    <!--/row-->        
                                             
                                    <div class="row-fluid"> 
                                    <div class="span6">
                                    <table id="purchaseItems" name="purchaseItems">
                              <?php if(isset($aInventoryItemAsset['images']))
							  {
								  $a = 1;
							  ?>
								 <?php foreach($aInventoryItemAsset['images'] as $image ) {
									
									?>
                                   
                                <tr>
                               
                                <td>
                                <div class="control-group">
                              <label class="control-label">Image Upload#<?php echo $a;?></label>
                              <div class="controls">
                                 <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                    <?php if(isset($image['image_path'])){
									 ?>
                                       <img src="uploads/assetimage/<?php echo $image['image_path'];?>" alt="" />
                                         <?php } else if($aRequest['assetId']) { 
										 if($aassetItemInfo['asset_image']!='') {
										 ?>
                                           <img src="uploads/assetimage/<?php echo $aassetItemInfo['asset_image'];?>" alt="" />
                                     		<?php } else {?>
                                             <img src="assets/img/noimage.gif" alt="" />
                                            <?php } ?>							   
									   <?php } else { ?>
                                          <img src="assets/img/noimage.gif" alt="" />
                                       <?php } ?>
                                       <img src="assets/img/noimage.gif" alt="" />
                                    </div>
                                   
                                       <input type="hidden" name="fimages[]" value="<?php echo $image['image_path'];?>"/>
                                <input type="hidden" name="fImageId[]" value="<?php echo $image['id_image'];?>"/> 
                                    </div>
                                 </div>
                               
                              </div>
                          
                                </td>
                               <td> <input type="checkbox"  name="fDeleteImageCheckbox[]" value='<?php echo $image['id_image'];?>' /> Delete Image</td>
									
                                </tr>
                                <?php $a++ ; } ?>
                                <?php } ?>
                                </table>
                                    
                                    
                                    <div class="control-group">
                              <label class="control-label">Image </label>
                              <div class="controls">
                                 <label class="checkbox">
                                 <input type="checkbox"  name="fAddImgeCheckbox" id="fAddImgeCheckbox" /> Add Image
                                 </label>
                                
                              </div>
                                        </div>
                                    <div id="addimage" style="display:none">
                                     <table id="purchaseItems" name="purchaseItems">
                                      <tr>
                               
                                <td>
                                <div class="control-group">
                              <label class="control-label">Image Upload<span class="countimage">#1</span></label>
                              <div class="controls">
                                 <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                  
								
                                          <img src="assets/img/noimage.gif" alt="" />
                                     
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                    <div>
                                       <span class="btn btn-file"><span class="fileupload-new">Select image</span>
                                       <span class="fileupload-exists">Change</span>
                                       <input type="file" class="default" name="fImage[]" /></span>
                                       <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                    </div>
                                 </div>
                               
                              </div>
                           </div>
                                </td>
                               <td><input type="button" name="addRow[]" class="add" value='+'></td>
									<td><input type="button" name="addRow[]" class="removeRow" value='-'>
                                   
                                    </td>
                                </tr>
                               
                                </table>  
                                </div>
                           			</div>
                                     <div class="span6 ">
                                    <div class="control-group">
                                       <label class="control-label" style="width:60px; text-align:left;">Remarks</label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fRemark"></textarea>
                                       </div>
                                    </div>
                                    </div>
                                      </div>                            
                                
                                 
                                  <h3 class="form-section">Assign Existing Contract</h3>
                                  
                                  <div class="row-fluid">
                                       <div class="span6 ">
                                 <div class="control-group">
                              <label class="control-label">Contract</label>
                               <div class="controls" >  
                               
                               
                                             
                                                 <select class="m-wrap  chosen"  data-placeholder="Choose a Contract" name="fContractID" >
                                             <option value="0" selected="selected">Choose a Contract </option>
											 <?php
											  $aContractGroupList= $oMaster->getContractList('list');
											 											
											foreach($aContractGroupList as $aContractGroup)
											  {
			   									
											 ?>
                                             <optgroup label="<?php echo $aContractGroup['contract_type'];?>">
											   <?php
											  $aContractList = $oMaster->getContractGroupList('group',$aContractGroup['contract_type']);
											  foreach($aContractList as $aContract)
											  {
											 ?>
                                       
                                             <option value="<?php echo $aContract['id_contract']; ?>" <?php if($aStockItem['id_contract'] == $aContract['id_contract']) { echo 'selected=selected' ;}?>><?php echo $aContract['contract_title']; ?></option>
                                           
                                             <?php
											  }
											 ?>
                                             </optgroup>
                                             <?php } ?>
                                             
                                          </select>
                                         
                                          </div>
                           </div>                
                                    </div>
                                    
                                    	<div class="span6 ">
                                          
                                       </div>
                                    </div>
                                  <div class="form-horizontal form-view">             
                                                         
                                   <h3 class="form-section"></h3>
                                   <div class="row-fluid">
                                       <div class="span6 ">
                                 <div class="control-group">
                              <label class="control-label">Depreciation</label>
                               <div class="controls">
                                 <div class="input-prepend">
                             <span class="add-on">%</span> <input type="text" class="m-wrap span4 price input-prepend" name="fDepressation" value="<?php echo (!empty($aRequest['fDepressation'])? $aRequest['fDepressation']:0)?>" /> 
                                 </div>
                              </div>
                           </div>                
                                    </div>
                                    
                                    	<div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" style="text-align:left;">Date of Install</label>
                                               <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fDateofInstall" value="<?php echo date('d-m-Y');?>"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
                                            
                                          </div>
                                       </div>
                                    </div>
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                 <div class="control-group">
                              <label class="control-label">Machine Purchased Date</label>
                               <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
	<input class="m-wrap  date-picker span10"  style="margin-left:20px;" placeholder="Machine Purchase Date" size="10" type="text" name="fMachineDate" value="<?php echo date('d-m-Y');?>" ><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
                           </div>                
                                    </div>
                                    
                                    	<div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" style="text-align:left;">Machine Life <span class="required">*</span></label>
                                               <div class="controls">
												  <input type="text" class="m-wrap small nextRow "  placeholder="Machine Life" name="fMachineLife" value="<?php echo (!empty($aassetItemInfo['machine_life'])? $aassetItemInfo['machine_life']:$aRequest['fMachineLife']);?>">      
											  </div>
                                            
                                          </div>
                                       </div>
                                    </div>
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                 <div class="control-group">
                              <label class="control-label">Manufacturer</label>
                               <div class="controls">
                                 <select class="chosen"  data-placeholder="Choose the Manufacturer" tabindex="5" name="fManufactureId">
                                    <option value="0">Choose the Manufacturer</option>
											 <?php
											  $aManufacturerList = $oMaster->getManufacturerList();
											  foreach($aManufacturerList as $aManufacturer)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aManufacturer['id_manufacturer']; ?>" <?php if($aassetItemInfo['id_manufacturer'] == $aManufacturer['id_manufacturer']) { echo 'selected=selected' ;}?>><?php echo $aManufacturer['manufacturer_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                              </div>
                           </div>                
                                    </div>
                                    
                                    	<div  class="span6 ">
                                         <div class="control-group">
                              <label class="control-label">Machine And Warranty </label>
                              <div class="controls">
                                 <label class="checkbox">
                                 <input type="checkbox" value="1" name="fMachineCheckbox" id="fMachineCheckbox" /> Add Machine Number And Warranty
                                 </label>
                                
                              </div>
                                        </div>
                                    </div>
                                    	
                                    
                                    </div>  
                                    
                                    <div id="machinenumberlist" style="display:none">
                                    <?php for($i=1;$i<=$Quantity;$i++)
									{
										?>
                                     <div class="row-fluid">
                                     <div class="span4 ">
                                          <div class="control-group">
                                             <label class="control-label" style="text-align:left;">Machine Number #<?php echo $i;?></label>
                                               <div class="controls">
												  <input type="text" class="m-wrap small nextRow "  placeholder="Machine Number" name="fMachineNumber<?php echo $i;?>" value="<?php echo $aassetItemInfo['machine_no'];?>">      
											  </div>
                                            
                                          </div>
                                       </div>
                                    
									 
									  <div class="span4 ">
									  <label class="control-label" style="text-align:left;">Warranty Start Date #<?php echo $i;?></label>
                                    <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
	<input class="m-wrap m-ctrl-small date-picker span10" placeholder="Warranty Start date" size="10" type="text" name="fWarrantyStartDate<?php echo $i;?>" value="<?php if($aStockItem['warranty_start_date'] == '1970-01-01' || $aStockItem['warranty_start_date'] == '')
							 {
								/* echo  date('d-m-Y');*/
							 }
							 else
							 { echo date('d-m-Y',strtotime($aStockItem['warranty_start_date']));
							 }?>" ><span class="add-on"><i class="icon-calendar"></i></span>
												 </div></div>
												  <div class="span4 ">
												  <label class="control-label" style="text-align:left;">Warranty End Date #<?php echo $i;?></label>
                                    <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
	<input class="m-wrap m-ctrl-small date-picker span10" placeholder="Warranty End date" size="10" type="text" name="fWarrantyEndDate<?php echo $i;?>" value="<?php
	  if($aStockItem['warranty_end_date'] == '1970-01-01' || $aStockItem['warranty_end_date'] == '')
							 {
								/* echo  date('d-m-Y');*/
							 }
							 else
							 { echo date('d-m-Y',strtotime($aStockItem['warranty_end_date']));
							 }?>" ><span class="add-on"><i class="icon-calendar"></i></span>
												 </div> 
												  </div>
                                      </div>
                                     <?php } ?> 
                                     </div>  
									<div class="loading disabled"><p>Please wait until the Process will  Complete.</p></div>
                                   <?php if(empty($aRequest['assetId'])) { ?> 
                                    <div class="form-actions">
									<input type="hidden" name="fGrnId" value="<?php echo $aRequest['fGrnId'];?>"/>
									<input type="hidden" name="fInventoryItemid" value="<?php echo $aRequest['fInventoryItemid'];?>"/>
									<input type="hidden" name="tab" value="<?php echo $aRequest['tab'];?>"/>
                                       <button type="submit" class="btn blue ajax_bt" name="send"><i class="icon-ok"></i> Save</button>
                                       <button type="button" class="btn">Cancel</button>
                                    </div>
                                    <?php } ?>
                                 </form>
                               
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>
                       
                      
                        
                        </div>
                  </div>
               </div>
            </div>
									<!-- END PAGE CONTENT-->
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
	
	function ShowResult(id,grnid)
			{
				
			url = document.URL.split("?")[0];
			var dropresult = addParam(url, "fInventoryItemid",id);	
			var dropresult1 = addParam(dropresult, "fGrnId",grnid);	
			var dropresult2 = addParam(url, "fGrnId",id);	
			var dropresult3= addParam(dropresult1, "tab",1);	
			var dropresult4= addParam(dropresult2, "tab",1);	
			if(grnid !='')
			{
			window.location.href = dropresult3;
			}
			else
			{
				window.location.href = dropresult4;
			}
			}
			
			 jQuery(document).ready(function() { 
		 $('#fMachineCheckbox').click(function() {
    $("#machinenumberlist").toggle(this.checked);
});
		 
		  }); //
	
	
	 jQuery(document).ready(function() { 
		 $('#fAddImgeCheckbox').click(function() {
    $("#addimage").toggle(this.checked);
});
		 
		  }); //
	
	
	function addParam(url, param, value) {
    var a = document.createElement('a');
    a.href = url;
    a.search += a.search.substring(0,1) == "?" ? "&" : "?";
    a.search += encodeURIComponent(param);
    if (value)
        a.search += "=" + encodeURIComponent(value);
    return a.href;
}
function deleteBox(id){
  if (confirm("Are you sure you want to delete this record?"))
  {
    var dataString = 'data=Catdelete&cid='+ id;
	$("#flash_"+id).show();
    $("#flash_"+id).fadeIn(400).html('<img src="assets/img/ajax-loader.gif"/>');
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
}
</script>
<script type="text/javascript">
      
 $(document).ready(function () {
    $(document).on('click', '#purchaseItems .add', function () {
        var row = $(this).closest('tr');
        var clone = row.clone();
        // clear the values
        var tr = clone.closest('tr');
        tr.find('input[type=text]').val('');
		 clone.find('td').each(function(){
            var el = $(this).find('.countimage');
            var id = el.text() || null;
			
            if(id) {
                var i = id.substr(id.length-1);
                var prefix = id.substr(0, (id.length-1));
		
              el.html(prefix+(+i+1));
               
            }
        });
	
	
		
        $(this).closest('tr').after(clone);
    });
    $(document).on('keypress', '#purchaseItems .next', function (e) {
        if (e.which == 13) {
            var v = $(this).index('input:text');
            var n = v + 1;
            $('input:text').eq(n).focus();
            //$(this).next().focus();
        }
    });
    $(document).on('keypress', '#purchaseItems .nextRow', function (e) {
        if (e.which == 13) {
            $(this).closest('tr').find('.add').trigger('click');
            $(this).closest('tr').next().find('input:first').focus();
        }
    });
    $(document).on('click', '#purchaseItems .removeRow', function () {
        if ($('#purchaseItems .add').length > 1) {
            $(this).closest('tr').remove();
        }
    });
});
    </script>
</body>
<!-- END BODY -->
</html>