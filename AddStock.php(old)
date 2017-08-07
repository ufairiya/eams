<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  $oAssetVendor = &Singleton::getInstance('Vendor');
  $oAssetVendor->setDb($oDb);
    $oAssetUnit = &Singleton::getInstance('AssetUnit');
  $oAssetUnit->setDb($oDb);
  $id_stock = $aRequest['id'];
  $aStockItem =$oMaster->getStockInfo($id_stock,'asset');

 $asset_no = $oMaster->assetCount();
   if(isset($aRequest['Update']))
  {
    if($result = $oMaster->updateStockItem($aRequest))
	{
	  $msg = "New Stock Updated.";
	 /* echo '<script type="text/javascript">window.location.href="StockList.php?msg=updatesucess";</script>';*/
	}
	else $msg = "Sorry";
  } //update
  
   if(isset($aRequest['send']))
  {
    if($oMaster->addStockItem($aRequest))
	{
	   $msg = "New Stock Added";
	  /* echo '<script type="text/javascript">window.location.href="AddStock.php?msg=success";</script>';*/
	}
	else 
	  $msg = "Sorry could not add..";
  } 
 
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Add Stock</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <meta http-equiv="Cache-control" content="No-Cache">
  <?php include('Stylesheets.php');?>
  <style>
	  input.add {
		-moz-border-radius: 4px;
		border-radius: 4px;
		background-color: #33CC00;
		-moz-box-shadow: 0 0 4px rgba(0, 0, 0, .75);
		box-shadow: 0 0 4px rgba(0, 0, 0, .75);
	}
	input.add:hover {
		background-color:#1EFF00;
		-moz-border-radius: 4px;
		border-radius: 4px;
	}
	input.removeRow {
		-moz-border-radius: 4px;
		border-radius: 4px;
		background-color:#FFBBBB;
		-moz-box-shadow: 0 0 4px rgba(0, 0, 0, .75);
		box-shadow: 0 0 4px rgba(0, 0, 0, .75);
	}
	input.removeRow:hover {
		background-color:#FF0000;
		-moz-border-radius: 4px;
		border-radius: 4px;
	}
  </style>
  </head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top" onLoad="getGroup2ItemListing('group1','<?php echo $aStockItem['id_itemgroup1'];?>','<?php echo $aStockItem['id_itemgroup2'];?>');
getItemLising('itemgroup1','<?php echo $aStockItem['id_itemgroup2'];?>','<?php echo $aStockItem['asset_name'];?>');
">
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
                     Stock
                     <small>Stock Master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Stock</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Stock </a></li>
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
                                    <a href="<?php echo $result['url'];?>" class="btn red mini active">Back to List</a>
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
                      <?php if($aRequest['action'] == 'edit')
							{ ?>
                         <h4><i class="icon-reorder"></i>Edit Stock</h4>
                         <?php } else {?>                      
                           <h4><i class="icon-reorder"></i>Add Stock</h4>
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
                       
                                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_sample_3" method="post">
									    <div class="alert alert-error hide">
                              <button class="close" data-dismiss="alert"></button>
                              You have some form errors. Please check below.
                           </div>
                           
                           
								 <?php if(isset($aRequest['id'])){?>
                                 
                                <table id="purchaseItems" name="purchaseItems" class="table table-striped table-bordered table-hover">
								<tr>
									 <th>Item</th>
                                     <th>Qty (Nos)</th>
                                     <th>Supplier</th>
                                     <th>Machine Number</th>
                                     <th>Asset Number</th>
                                     <th>Current Unit</th>
									
								</tr>
                                
								<tr>
                                
									<td>
                                   
                                          <select class="m-wrap" tabindex="2" name="fGroup1" id="group1"  onChange="getGroup2ItemListing(this.id,this.value,'<?php echo $aStockItem['id_itemgroup2'];?>');">
                                            <option value="0" selected="selected" >Choose the ItemGroup 1 </option>
											 <?php
											  $aItemGroup1List = $oMaster->getItemGroup1List();
											  foreach($aItemGroup1List as $aItemGroup1)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup1['id_itemgroup1']; ?>" <?php if($aStockItem['id_itemgroup1'] == $aItemGroup1['id_itemgroup1']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup1['itemgroup1_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                          
                                           <br><br>
                                           
                                          <select class="m-wrap group2" tabindex="3" name="fGroup2" id="itemgroup1" onChange="getItemLising(this.id,this.value);">
                                               <option value="0" selected="selected" >Choose the ItemGroup 2 </option>
											<?php /*?> <?php
											  $aItemGroup2List = $oMaster->getItemGroup2List();
											  foreach($aItemGroup2List as $aItemGroup2)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup2['id_itemgroup2']; ?>" <?php if($aStockItem['id_itemgroup2'] == $aItemGroup2['id_itemgroup2']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup2['itemgroup2_name']; ?></option>
                                             <?php
											  }
											 ?><?php */?>
                                          </select>
                                           <br><br>
                                           <select class="m-wrap nextRow items" tabindex="1" name="fItemName"   id="fItemName1" onChange="getAsset(this.value,this.id);">
                                    <option value="0" >Choose the Item</option>
											<?php /*?> <?php
											  $aItemList = $oMaster->getItemList();
											  foreach($aItemList as $aItem)
											  {
											 ?>
                                             <option value="<?php echo $aItem['id_item']; ?>" <?php if($aStockItem['asset_name'] == $aItem['id_item']) { echo 'selected=selected' ;}?>><?php echo $aItem['item_name']; ?></option>
                                             <?php
											  }
											 ?><?php */?>
                                          </select>
                                    
                                   </td>
									
                                
                                          <td><input type="text" class="m-wrap  nextRow xsmall"  name="fQuanity" value="<?php echo $aStockItem['quantity'];?>">
                                          <br><br>
                                          
                                          <select class="m-wrap" style="width:100px;" data-placeholder="Choose a UOM" name="fUOMId" >
                                               <option value="0">UOM</option>
											 <?php
											  $aUOMList= $oMaster->getUomList();
											  foreach($aUOMList as $aUOM)
											  {
			  
											 ?>
                                             <option value="<?php echo $aUOM['id_uom']; ?>" <?php if($aStockItem['id_uom'] == $aUOM['id_uom']) { echo 'selected=selected' ;}?>><?php echo $aUOM['uom_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                          </td>
                                          
                                 
                                 
                                    <td>
                                    <select class=" m-wrap small" tabindex="3" name="fvendorId">
											 <?php
											  $avendorList = $oAssetVendor->getAllVendorInfo();
											 ?>
                                            <option value="0">Choose the Supplier</option>
                                             <?php  foreach($avendorList as $aVendor)
											  {
												  ?>
                                             <option value="<?php echo $aVendor['id_vendor']; ?>"<?php if($aStockItem['id_vendor'] == $aVendor['id_vendor']) { echo 'selected=selected' ;}?>><?php echo $aVendor['vendor_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                          <br><br>
                                          <select class=" m-wrap small" tabindex="1" name="fManufactureId">
                                    <option value="0">Choose the Manufacturer</option>
											 <?php
											  $aManufacturerList = $oMaster->getManufacturerList();
											  foreach($aManufacturerList as $aManufacturer)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aManufacturer['id_manufacturer']; ?>" <?php if($aStockItem['id_manufacturer'] == $aManufacturer['id_manufacturer']) { echo 'selected=selected' ;}?>><?php echo $aManufacturer['manufacturer_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                    </td>
                                    <td><input type="text" class="m-wrap small nextRow "  name="fMachineNo" value="<?php echo $aStockItem['machine_no'];?>">
                                    <br><br>
                                    <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
	<input class="m-wrap m-ctrl-small date-picker span10" placeholder="Machine Purchase Date" size="10" type="text" name="fMachineDate" value="<?php
	 echo date('d-m-Y',strtotime($aStockItem['machine_date']));?>" ><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
                                                 
                                           <br><br>
                                           
                                           <input type="text" class="m-wrap small nextRow "  placeholder="Machine Life" name="fMachineLife" value="<?php echo $aStockItem['machine_life'];?>"> 
										   
										    <input type="text" class="m-wrap small nextRow "  placeholder="Machine Price" name="fMachinePrice" value="<?php echo $aStockItem['machine_price'];?>">         
                                    </td>
                                    <td><input type="text" class="m-wrap small nextRow "  id="fAssetNo1" name="fAssetNo" value="<?php echo $aStockItem['asset_no'];?>">
                                    <br><br>
                                    <input type="text" class="m-wrap small nextRow " id="fAssetNo1" name="fRefAssetNo" value="<?php echo $aStockItem['ref_asset_no'];?>" placeholder="Ref.AssetNumber">
                             <br><br>    
                                <label>Depreciation</label>
                                 <div class="input-prepend">
                             <span class="add-on">%</span> <input type="text" class="m-wrap span4 price input-prepend" name="fDepressation" value="<?php echo $aStockItem['depressation_percent'];?>" /> 
                                 </div>
                           <br><br>  
                           <label> Date Of Install  </label>
                             <input class="m-wrap m-ctrl-small date-picker span12" style="float:left;" placeholder="Machine Date of Install" size="10" type="text"  name="fDateofInstall" value="<?php if($aStockItem['date_of_install'] == '1970-01-01' || $aStockItem['date_of_install'] == '' )
							 {
								 echo  date('d-m-Y');
							 }
							 else
							 {
							
								echo date('d-m-Y',strtotime( $aStockItem['date_of_install']));
							 }?>"  />
                                    </td>
                                    <td>
                                    <select class="m-wrap" data-placeholder="Choose a Store"  name="fStoreId" id="fStoreId">
                                          
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
                                             
                                             
                                             <option value="<?php echo $aStore['id_store']; ?>/<?php echo $aUnit['id_unit'];?>" <?php if($aStockItem['id_store'] == $aStore['id_store']) { echo 'selected=selected' ;}?>><?php echo $aStore['store_name']; ?></option>
                                           
                                             <?php
											  }
											 ?>
                                           </optgroup>
                                            <?php
											  }
											 ?>
                                             </select>
									
									<br><br>
                                    <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
	<input class="m-wrap m-ctrl-small date-picker span10" placeholder="Warranty Start date" size="10" type="text" name="fWarrantyStartDate" value="<?php
	 if($aStockItem['warranty_start_date'] == '1970-01-01' || $aStockItem['warranty_start_date'] == '')
							 {
								 echo  date('d-m-Y');
							 }
							 else
							 { echo date('d-m-Y',strtotime($aStockItem['warranty_start_date']));
							 }?>" ><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
												 <br><br>
                                    <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
	<input class="m-wrap m-ctrl-small date-picker span10" placeholder="Warranty End date" size="10" type="text" name="fWarrantyEndDate" value="<?php
	  if($aStockItem['warranty_end_date'] == '1970-01-01' || $aStockItem['warranty_end_date'] == '')
							 {
								 echo  date('d-m-Y');
							 }
							 else
							 { echo date('d-m-Y',strtotime($aStockItem['warranty_end_date']));
							 }?>" ><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
                                    </td>
									
                                     
								</tr>
                              
							</table>
                                 
                                 
                                 <?php } else { ?>		 
						                                    
								<table id="purchaseItems" name="purchaseItems" class="table table-striped table-bordered table-hover">
								<tr>
									 <th>Item</th>
                                     <th>Qty (Nos)</th>
                                     <th>Supplier</th>
                                     <th>Machine Number</th>
                                     <th>Asset Number</th>
                                     <th>Current Unit</th>
									<th>&nbsp;</th>
								</tr>
								<tr>
									<td>
                                    
                                        
                                          
                                          <select class="m-wrap" tabindex="2" name="fGroup1[]" id="group1" onChange="getGroup2ItemListing(this.id,this.value);">
                                            <option value="0" selected="selected" >Choose the ItemGroup 1 </option>
											 <?php
											  $aItemGroup1List = $oMaster->getItemGroup1List();
											  foreach($aItemGroup1List as $aItemGroup1)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup1['id_itemgroup1']; ?>" <?php if($edit_result['id_itemgroup1'] == $aItemGroup1['id_itemgroup1']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup1['itemgroup1_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                          
                                           <br><br>
                                         
                                          <select class="m-wrap group2" tabindex="3" name="fGroup2[]" id="itemgroup1" onChange="getItemLising(this.id,this.value);">
                                               <option value="0" selected="selected" >Choose the ItemGroup 2 </option>
											 <?php
											  $aItemGroup2List = $oMaster->getItemGroup2List();
											  foreach($aItemGroup2List as $aItemGroup2)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup2['id_itemgroup2']; ?>" <?php if($edit_result['id_itemgroup2'] == $aItemGroup2['id_itemgroup2']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup2['itemgroup2_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										 
                                          
                                            <br><br>
                                            
                                          <select class="m-wrap nextRow items" tabindex="1" id="fItemName1" name="fItemName[]">
                                    <option value="0" >Choose the Item</option>
											 <?php
											  $aItemList = $oMaster->getItemList();
											  foreach($aItemList as $aItem)
											  {
											 ?>
                                             <option value="<?php echo $aItem['id_item']; ?>" <?php if($edit_result['id_item'] == $aItem['id_item']) { echo 'selected=selected' ;}?>><?php echo $aItem['item_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
										 
                                   </td>
									
                                
                                          <td><input type="text" class="m-wrap  nextRow xsmall"  name="fQuanity[]" value="1">
                                          <br><br>
                                          
                                          <select class="m-wrap" style="width:100px;" data-placeholder="Choose a UOM" name="fUOMId[]" >
                                               <option value="0">UOM</option>
											 <?php
											  $aUOMList= $oMaster->getUomList();
											  foreach($aUOMList as $aUOM)
											  {
			  
											 ?>
                                             <option value="<?php echo $aUOM['id_uom']; ?>" <?php if($edit_result['id_uom'] == $aUOM['id_uom']) { echo 'selected=selected' ;}?>><?php echo $aUOM['uom_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                          </td>
                                          
                                 
                                 
                                    <td>
                                    <select class=" m-wrap small" tabindex="3" name="fvendorId[]">
											 <?php
											  $avendorList = $oAssetVendor->getAllVendorInfo();
											 ?>
                                            <option value="0">Choose the Supplier</option>
                                             <?php  foreach($avendorList as $aVendor)
											  {
												  ?>
                                             <option value="<?php echo $aVendor['id_vendor']; ?>"><?php echo $aVendor['vendor_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                          <br><br>
                                          <select class=" m-wrap small" tabindex="1" name="fManufactureId[]">
                                    <option value="0">Choose the Manufacturer</option>
											 <?php
											  $aManufacturerList = $oMaster->getManufacturerList();
											  foreach($aManufacturerList as $aManufacturer)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aManufacturer['id_manufacturer']; ?>" <?php if($edit_result['id_manufacturer'] == $aManufacturer['id_manufacturer']) { echo 'selected=selected' ;}?>><?php echo $aManufacturer['manufacturer_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                    </td>
                                    <td><input type="text" class="m-wrap small nextRow "  name="fMachineNo[]">
                                    
                                     <br><br>
                             <input class="m-wrap m-ctrl-small date-picker span12" style="float:left;" placeholder="Machine Purchased Date" size="10" type="text"  name="fMachineDate[]"  />
                                                                              
                                           <br><br>
                                           
                                           <input type="text" class="m-wrap small nextRow "  placeholder="Machine Life" name="fMachineLife[]" value="<?php echo $aStockItem['machine_life'];?>">  
										   
										     <input type="text" class="m-wrap small nextRow "  placeholder="Machine Price" name="fMachinePrice[]" value="<?php echo $aStockItem['machine_price'];?>">  
                                    
                                    </td>
                                    <td>
                                         <input type="text" class="m-wrap small nextRow " id="fAssetNo1" name="fRefAssetNo[]" value="" placeholder="Ref.AssetNumber">
                             <br><br>    
                                <label>Depreciation</label>
                                 <div class="input-prepend">
                             <span class="add-on">%</span> <input type="text" class="m-wrap span4 price input-prepend" name="fDepressation[]" value="0" /> 
                                 </div>
                           <br><br>  
                           <label> Date Of Install  </label>
                             <input class="m-wrap m-ctrl-small date-picker span12" style="float:left;" placeholder="Machine Date of Install" size="10" type="text"  name="fDateofInstall[]"/>
  
                                            
                                          
                                    </td>
                                   <td>
                                     <select class="m-wrap" data-placeholder="Choose a Store"  name="fStoreId[]" id="fStoreId">
                                          
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
                                             
                                             
                                             <option value="<?php echo $aStore['id_store']; ?>/<?php echo $aUnit['id_unit'];?>" <?php if($edit_result['id_store'] == $aStore['id_store']) { echo 'selected=selected' ;}?>><?php echo $aStore['store_name']; ?></option>
                                           
                                             <?php
											  }
											 ?>
                                           </optgroup>
                                            <?php
											  }
											 ?>
											 </select>
                               <br><br>
                                    <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
	<input class="m-wrap m-ctrl-small date-picker span10" placeholder="Warranty Start date" size="10" type="text" name="fWarrantyStartDate[]" ><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
												 <br><br>
                                    <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
	<input class="m-wrap m-ctrl-small date-picker span10" placeholder="Warranty End date" size="10" type="text" name="fWarrantyEndDate[]" ><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
                                    </td>
									<td><input type="button" name="addRow[]" class="add" value='+'/> 
									<br><br>
									<input type="button" name="addRow[]" class="removeRow" value='-'/></td>
								</tr>
							</table>
						
			 					<?php } ?>
			                        
									
						<div class="form-actions">
						<?php if($aRequest['action'] == 'edit')
						{
						?>
							<button type="submit" class="btn blue" id="sends" name="Update"><i class="icon-ok"></i>Update Stock</button>                   			<input type="hidden" name="fAssetStockId" value="<?php echo $aRequest['id'];?>"/>
							<input type="hidden" name="fUrl" value="<?php echo $aRequest['fReturnUrl'];?>"/>
							
						<?php
						} else {
						?>
							  <button type="submit" class="btn blue" id="sends" name="send"><i class="icon-ok"></i>Add Stock</button>       
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
    <script type="text/javascript">
      
 $(document).ready(function () {
    $(document).on('click', '#purchaseItems .add', function () {
        var row = $(this).closest('tr');
        var clone = row.clone();
        // clear the values
		var tr = clone.closest('tr');
        tr.find('input[type=text]').val('');
		tr.find('input[name="fMachineDate[]"]').siblings('.ui-datepicker-trigger,.ui-datepicker-apply').remove();
		tr.find('input[name="fMachineDate[]"]').removeClass('hasDatepicker');
		tr.find('input[name="fMachineDate[]"]').removeData('datepicker');
		tr.find('input[name="fMachineDate[]"]').unbind();
		tr.find('input[name="fMachineDate[]"]').datepicker();
		
		tr.find('input[name="fDateofInstall[]"]').siblings('.ui-datepicker-trigger,.ui-datepicker-apply').remove();
		tr.find('input[name="fDateofInstall[]"]').removeClass('hasDatepicker');
		tr.find('input[name="fDateofInstall[]"]').removeData('datepicker');
		tr.find('input[name="fDateofInstall[]"]').unbind();
		tr.find('input[name="fDateofInstall[]"]').datepicker();
		
		tr.find('input[name="fWarrantyEndDate[]"]').siblings('.ui-datepicker-trigger,.ui-datepicker-apply').remove();
		tr.find('input[name="fWarrantyEndDate[]"]').removeClass('hasDatepicker');
		tr.find('input[name="fWarrantyEndDate[]"]').removeData('datepicker');
		tr.find('input[name="fWarrantyEndDate[]"]').unbind();
		tr.find('input[name="fWarrantyEndDate[]"]').datepicker();
		
		tr.find('input[name="fWarrantyStartDate[]"]').siblings('.ui-datepicker-trigger,.ui-datepicker-apply').remove();
		tr.find('input[name="fWarrantyStartDate[]"]').removeClass('hasDatepicker');
		tr.find('input[name="fWarrantyStartDate[]"]').removeData('datepicker');
		tr.find('input[name="fWarrantyStartDate[]"]').unbind();
		tr.find('input[name="fWarrantyStartDate[]"]').datepicker();
				
				
		 clone.find('td').each(function(){
            var el = $(this).find(':first-child');
            var id = el.attr('id') || null;
            if(id) {
                var i = id.substr(id.length-1);
                var prefix = id.substr(0, (id.length-1));
		
              el.attr('id', prefix+(+i+1));
               
            }
        });
			 clone.find('td').each(function(){
            var el = $(this).find('.group1');
            var id = el.attr('id') || null;
            if(id) {
                var i = id.substr(id.length-1);
                var prefix = id.substr(0, (id.length-1));
		
              el.attr('id', prefix+(+i+1));
               
            }
        });
		 clone.find('td').each(function(){
            var el = $(this).find('.group2');
            var id = el.attr('id') || null;
            if(id) {
                var i = id.substr(id.length-1);
                var prefix = id.substr(0, (id.length-1));
		
              el.attr('id', prefix+(+i+1));
               
            }
        });
		 clone.find('td').each(function(){
            var el = $(this).find('.items');
            var id = el.attr('id') || null;
            if(id) {
                var i = id.substr(id.length-1);
                var prefix = id.substr(0, (id.length-1));
		
              el.attr('id', prefix+(+i+1));
               
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

		 function getGroup2ItemListing(id,value,group2id,itemid)
		 {
			 var ids= id.split("group");
			var dataStr = 'action=getGroup2ItemList&Group1Id='+value+'&group2Id='+group2id;
			 $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				          $("#itemgroup"+ids[1]).html(result);
				 
			   }
         
		  
		 });
		 
		   var Group1id = $("#group"+ids[1]).val();
		  var Group2id = $("#itemgroup"+ids[1]).val();
		var dataStr = 'action=getItemsListBystock&Group1Id='+Group1id+'&Group2Id='+Group2id;
		   $.ajax({
			   type: 'POST',
			   url: 'ajax/dropdown.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				  $("#fItemName"+ids[1]).html(result);
				 
			   }
          });
		 }
		 
		 function getItemLising(id,value,itemid)
		  {
		  var ids= id.split("itemgroup");
		 var Group1id = $("#group"+ids[1]).val();
		var dataStr = 'action=getItemsListBystock&Group1Id='+Group1id+'&Group2Id='+value+'&itemid='+itemid;
		  $.ajax({
			   type: 'POST',
			   url: 'ajax/dropdown.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				  $("#fItemName"+ids[1]).html(result);
				 
			   }
          });
		  
		  }
		
		function getAsset(value,id)
		{
		
		  var asset_no = $('#fAssetNo1').val();
		   	var dataStr = 'action=getAssetNumber&itemId='+value+'&asset_no='+asset_no;
			
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				   var itemid = id.split("fItemName");
				   $('#fAssetNo'+itemid[1]).val(result);
				 			 
			   }
          });
		}
    </script>
     
</body>
<!-- END BODY -->
</html>