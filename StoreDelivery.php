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
  $oAssetDepartment = &Singleton::getInstance('Department');
  $oAssetDepartment->setDb($oDb);
  $astoreNumber = $oMaster->internalStoreDeliveryCount(); 
	
	 if($aRequest['action'] == 'edit')
     { 
	   $item_id = $aRequest['id'];
	   $edit_result = $oMaster->getDeliveryItemInfoList($item_id,'delivery');
	   $sesItemList = array();
	   foreach($edit_result as $aDeliveryItem) 
	   {		
		  $Sid               = $aDeliveryItem['id_asset_item'];
		  $sesItemList[$Sid] = $aDeliveryItem['issue_quantitiy']; 
	   }
		$oSession->setSession('ses_Itemlist',$sesItemList);	
      }
   
   

  if(isset($aRequest['Update']))
  {
    if($oMaster->updateAssetDelivery($aRequest, 'update'))
	{
	  $msg = "Store Delivery Updated.";
	  header("Location: DeliveryList.php?msg=updatesucess");	  
	}
	else 
	  $msg = "Sorry";
  } //update
  
  if($aRequest['action'] == 'edit')
  {
	$item_id = $aRequest['id'];
	$edit_result = $oMaster->getDeliveryItemInfoList($item_id,'delivery');
	$aDeliveryDetails = $oMaster->getDeliveryInfo($item_id,'delivery');
	
	$issue_no = explode("-",$aDeliveryDetails['issue_no']);
		/*$sesItemList = $oSession->getSession('ses_Itemlist');
		if(empty($sesItemList))
		{
		$sesItemList = array();
		}*/
	
  }
  if($aRequest['action'] == 'Add')
  {
	 $_SESSION['ses_Itemlist'] = '';
  }
  
  
  
  if(isset($aRequest['send']))
  {
    if($oMaster->addAssetDelivery($aRequest))
	{
	   $msg = 'Store delivery Added';
	   header("Location: DeliveryList.php?msg=success");
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
   <title>EAMS| Store Delivery </title>
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
                     Store Delivery
                     <small>Store Delivery Master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Store Delivery</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Store Delivery</a></li>
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
                                    <a href="#" class="btn red mini active">Back to List</a>
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
                  
                   
                     <div class="tab-content">
                        
                        <div class="tab-pane active" id="purchaseorder">
                           <div class="portlet box green">
                              <div class="portlet-title">
                                 <h4><i class="icon-reorder"></i>Store Delivery </h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="javascript:;" class="reload"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_sample_3" method="post" enctype="multipart/form-data">
                                        <h3 class="form-section">Store Delivery</h3>
                                 <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Company Name</label>
                               <div class="controls">
                                       
                                       <select class="span12 chosen" data-placeholder="Choose Company" tabindex="1" name="fCompanyId" id="fCompanyId" onChange="getCompanyLookup(this.value);">
                                       
											 <?php
											  $aCompanyList = $oMaster->getCompanyList();
											  ?>
											   <option value=''>Choose the Company</option>
											  <?php
                                              foreach($aCompanyList as $aCompany)
											  {
											 ?>
                                              <option value="<?php echo $aCompany['id_company']; ?>"<?php if(COMPANY == $aCompany['id_company']) { echo 'selected=selected' ;}?>><?php echo $aCompany['company_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select>
                                        <?php if($aRequest['action'] =='edit')
									{?>  
                                          <input type="hidden" name="fCompanyLookup" id="fCompanyLookup" value="<?php echo $issue_no[0];?>"/>
                                         <?php }else { ?>
                                          <input type="hidden" name="fCompanyLookup" id="fCompanyLookup"/>
                                         <?php } ?>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                          
                                    <?php if($aRequest['action'] =='edit')
									{?>
                                    <div class="span6 ">
                                            <div class="control-group">
                                      <div class="controls">
                                 <label class="radio">
                                 <input type="radio" name="fDeliveryType" id="fDeliveryType" value="ISD" tabindex="2" <?php if($aDeliveryDetails['delivery_type'] == 'ISD') { echo 'checked=checked' ;}?>  onChange="getDeliveryType(this.value)"/>
                                 Store
                                 </label>
                                 <label class="radio">
                                 <input type="radio" name="fDeliveryType" id="fDeliveryType" value="ESD" tabindex="3" <?php if($aDeliveryDetails['delivery_type'] == 'ESD') { echo 'checked=checked' ;}?> onChange="getDeliveryType(this.value)"/>
                                Vendor
                                 </label>  
                               
                              </div>
                           </div>                               
                                    </div>
                                    <?php } else {?>
                                    <div class="span6 ">
                                            <div class="control-group">
                                      <div class="controls">
                                 <label class="radio">
                                 <input type="radio" name="fDeliveryType" id="fDeliveryType" value="ISD"  tabindex="2" checked onChange="getDeliveryType(this.value)"/>
                                 Store
                                 </label>
                                 <label class="radio">
                                 <input type="radio" name="fDeliveryType" id="fDeliveryType" value="ESD"   tabindex="3" onChange="getDeliveryType(this.value)"/>
                                Vendor
                                 </label>  
                               
                              </div>
                           </div>                               
                                    </div>
                                    <?php } ?>
                                  </div>  
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">From Store</label>
                               <div class="controls">
                                       
                                        <select class="span12 chosen" data-placeholder="Choose a From Store" tabindex="4" name="fFromStoreId" id="fFromStoreId" onChange="getItemList(this.value);">
                                          <option value=""></option>
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
                                             
                                             
                                             <option value="<?php echo $aStore['id_store']; ?>"<?php if($aDeliveryDetails['from_id_store'] == $aStore['id_store']) { echo 'selected=selected' ;}?>><?php echo $aStore['store_name']; ?></option>
                                           
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
                                       <!--/span-->
                                   
                                          
                                             
                                       <div class="span6 " id="DeliveryType">
                                          <div class="control-group" id="ISD" style="display:none;">
                                             <label class="control-label">To Store</label>
                               <div class="controls" >
                                       
                                        <select class="span12 chosen" data-placeholder="Choose a To Store " tabindex="5" name="fToStoreId">
											
											   <option value=""></option>
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
                                             
                                             
                                             <option value="<?php echo $aStore['id_store']; ?>" <?php if($aDeliveryDetails['to_id_store'] == $aStore['id_store']) { echo 'selected=selected' ;}?>><?php echo $aStore['store_name']; ?></option>
                                           
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
                                          
                                          <div class="control-group"  id="ESD" style="display:none;">
                                             <label class="control-label">To Vendor</label>
                               <div class="controls">
                                       
                                       <select class="span12 chosen" data-placeholder="Choose a Vendor" tabindex="5" name="fvendorId">
											 <?php
											  $avendorList = $oAssetVendor->getAllVendorInfo();
											  ?>
											    <option value=""></option>
											  <?php
                                              foreach($avendorList as $aVendor)
											  {
			  
											 ?>
                                             
                                              <option value="<?php echo $aVendor['id_vendor']; ?>" <?php if($aDeliveryDetails['to_id_vendor'] == $aVendor['id_vendor']) { echo 'selected=selected' ;}?>><?php echo $aVendor['vendor_name']; ?></option>
                                          
                                             <?php
											  }
											 ?>
                                          </select>
                                         
                                             </div>
                                          </div>
                                            </div>
                                         
                                     
                                         <!--/span-->
                                    </div>
                                    
                           <h3 class="form-section"></h3>          
                                 <div class="row-fluid" id="ItemList" style="width: 75%;margin-left: 180px;">
                                                                        
                                        <div class="span4">
                                       <select class="m-wrap" tabindex="6" name="fItemGroup1" id="fItemGroup1" onChange="getGroup2ItemListing(this.value);"  >
                                            <option value="0" selected="selected" >Choose the ItemGroup 1 </option>
                                            
                                             <?php
											  $aItemGroup1List = $oMaster->getItemGroup1ByStore($aDeliveryDetails['from_id_store'],'','store');
											  foreach($aItemGroup1List as $aItemGroup1)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup1['id_itemgroup1']; ?>"><?php echo $aItemGroup1['itemgroup1_name']; ?></option>
                                             <?php
											  }
											 ?>
										     </select> 
                                       </div>
                                     
                                        <div class="span4" id="Group2ItemList">
                                       <select class="m-wrap" tabindex="7" name="fItemGroup2" id="fItemGroup2" onChange="getItemLising(this.value);">
                                               <option value="0" selected="selected" >Choose the ItemGroup 2 </option>
											
                                          </select>
                                       </div>
                                       
                                       <div class="span4" id="ItemsList">
                                       <select class=" m-wrap  " tabindex="8" name="fItemName" id="fItemName">
                                    <option value="0" >Choose the Item</option>
											</select>
                                       </div>
                                       </div>
                                       
                                   <br>
                                    <div class="row-fluid">
                                    <div class="span6 ">
                                              <div class="control-group">
                                              <label class="control-label">Issue Number:</label>
                                             <div class="controls">
                                               <span class="text" id="DeliveryNumber"><?php echo $astoreNumber['count'];?></span>
                                                <?php if($aRequest['action'] =='edit')
									{?>  
                                            <input type="hidden" value="<?php echo $issue_no[2];?>" id="fStoreNumber" name="fStoreNumber">
                                             <input type="hidden" value="<?php echo $issue_no[2];?>" id="fIssueNumber" name="fIssueNumber">
                                         <?php }else { ?>
                                            <input type="hidden" value="<?php echo $astoreNumber['count'];?>" id="fStoreNumber">
                                         <?php } ?>
                                             
                                              
                                             </div>
                                          </div>
                                       </div>
                                    
                                       <div class="span6 "> 
                                        <div class="control-group">
                                             <label class="control-label">Issue Date</label>
                               <div class="controls">
                                    <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" placeholder="Required Date" size="10" type="text" name="fRequireDate" value="<?php echo date('d-m-Y');?>" style="width:100px;"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
                                                 </div>
                                            </div>
                                       </div> 
                                                 
                                                 </div>
												 
												  <div class="row-fluid">
                                    <div class="span4 ">
                                              <div class="control-group">
                                              <label class="control-label">Maintenance : </label>
                                             <div class="controls">
                                              <input type="checkbox" name="fServiceType"/> 
                                             </div>
                                          </div>
                                           </div>
                                                                          
                                         <div class="span4 ">
                                              <div class="control-group">
                                              <label class="control-label">No Return Asset Item : </label>
                                             <div class="controls">
                                              <input type="checkbox" name="fNoReturnItem"/> 
                                             </div>
                                          </div>
                                           </div>
                                                 
                                                 </div>
												 
												 
												 
                                                 <?php if($aRequest['action'] == 'edit') { ?>
                                                   <div class="row-fluid">               
                                         <table id="purchaseItems" name="purchaseItems" class="table table-striped table-bordered table-hover">
								<tr>
											 <th>Item Group1</th>
											<th>Item Group2</th>
                                             <th>Item </th>
                                             <th>UOM</th>
                                            <th>Stock Quantity</th>
                                           <th>Issue Quantity</th>
                                           <th>Asset Number</th>
                                         	<th>Action</th>
								</tr>
                                
                               <?php 
									 
									 foreach($edit_result as $aDeliveryItem) 
									 {		
										$display_asset_no = ($aDeliveryItem['machine_no'] != '') ? $aDeliveryItem['asset_no'].' / '.$aDeliveryItem['machine_no'] :  $aDeliveryItem['asset_no'];										 
									  ?>
                                      <tr>
                                            <td><?php echo $aDeliveryItem['itemgroup1_name']; ?><input type="hidden" name="fItemGroup1Id[]" value="<?php echo $aDeliveryItem['id_itemgroup1']; ?>"/></td>
                                            <td><?php echo $aDeliveryItem['itemgroup2_name']; ?><input type="hidden" name="fItemGroup2Id[]" value="<?php echo $aDeliveryItem['id_itemgroup2']; ?>"/></td>
                                            <td><?php echo $aDeliveryItem['item_name']; ?><input type="hidden" name="fItemId[]" value="<?php echo $aDeliveryItem['id_item']; ?>"/></td>
                                            <td><?php echo $aDeliveryItem['uom_name']; ?><input type="hidden" name="fUomId[]" value="<?php echo $aDeliveryItem['id_uom']; ?>"/></td>
                                            <td><?php echo $aDeliveryItem['current_stock_quantity']; ?><input type="hidden" name="fStockQuqntity[]" value="<?php echo $aDeliveryItem['current_stock_quantity']; ?>"/></td>
                                            <td><input type="text" name="fIssueQuantity[]" size="15" onKeyup="addQuanitity(<?php echo $aDeliveryItem['id_asset_item']; ?>)" value="<?php echo $aDeliveryItem['issue_quantitiy']; ?>"/></td>
                                            <td><?php echo $display_asset_no; ?><input type="hidden" name="fAssetNumber[]" value="<?php echo $aDeliveryItem['asset_no']; ?>"/></td>
                                            <td><a href="#" id="RemoveItem" onClick="removeItem(<?php echo $aDeliveryItem['id_asset_item']; ?>)">Remove Item</a><input type="hidden" name="fAssetItemId[]" value="<?php echo $aDeliveryItem['id_asset_item']; ?>"/></td>
                                         </tr>
                                 <?php  }  ?>
								
                                  </table>
                                 
                                 
                                
                                   </div>       
                                    <?php  } else { ?>                
                                  <div class="row-fluid">               
                                         <table id="purchaseItems" name="purchaseItems" class="table table-striped table-bordered table-hover">
								<tr>
											 <th>Item Group1</th>
											<th>Item Group2</th>
                                             <th>Item </th>
                                             <th>UOM</th>
                                            <th>Stock Quantity</th>
                                           <th>Issue Quantity</th>
                                           <th>Asset Number</th>
										   <th>Maintenance</th>
                                         	<th>Action</th>
								</tr>
                                
                               
								
                                  </table>
                                 
                                 
                                
                                   </div>     
                                   <?php  }  ?>                   
                                    <h3 class="form-section"></h3>       
                                   <div class="row-fluid">
                                       <div class="span6 ">
                                       <div class="control-group">
                                       <label class="control-label">Remarks</label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fRemark"><?php echo $aDeliveryDetails['remark'];?></textarea>
                                       </div>
                                    </div>
                                         <!--/span-->
                                    </div>
                                      </div>
                                   
                                    <div class="form-actions">
                                    
                                    <?php if($aRequest['action'] == 'edit')
						{
						?>
							<button type="submit" class="btn blue" id="sends" name="Update"><i class="icon-ok"></i>Save</button>  
                            <input type="hidden" name="fDeliveryId" value="<?php echo $aRequest['id'];?>"/>                 
						<?php
						} else {
						?>
							  <button type="submit" class="btn blue" id="sends" name="send"><i class="icon-ok"></i>Add</button>       
						<?php
						} 
						?>
                              
                                    </div>
                                 </form>
                                 <!-- END FORM-->                
                              </div>
                           </div>
                        </div>
                        
                        
                        
                        
                        
                  </div>
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
   var itemtable = "<table id='purchaseItems' name='purchaseItems' class='table table-striped table-bordered table-hover'><tr> <th>Item Group1</th>	<th>Item Group2</th><th>Item </th><th>UOM</th><th>Stock Quantity</th><th>Issue Quantity</th><th>Asset Number</th><th>Maintenance</th><th>Action</th></tr> </table>";
function getParameterByName( name )
{
name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
var regexS = "[\\?&]"+name+"=([^&#]*)";
var regex = new RegExp( regexS );
var results = regex.exec( window.location.href );
if( results == null )
return "";
else
return decodeURIComponent(results[1].replace(/\+/g, " "));
}

   
   url = document.URL.split("?");
   var action =getParameterByName("action",url);
   
   if(action == 'edit')
   {
	
	  var DeliveryNumber = '<?php echo $aDeliveryDetails['issue_no'];?>';
	  $("#DeliveryNumber").html(DeliveryNumber);
	    $("#fIssueNumber").val(DeliveryNumber);
	  
	  
	  var DeliveryType  = '<?php echo $aDeliveryDetails['delivery_type'];?>';
	   $("#"+DeliveryType).css('display','block');
	
	
	
	  
	   var Group1 =  '<?php echo $edit_result[0]['id_itemgroup1'];?>';
	    var Group2 =  '<?php echo $edit_result[0]['id_itemgroup2'];?>';
	   var fromstore = '<?php echo $aDeliveryDetails['from_id_store'];?>';
	
	
   }
   else
   {
	   
jQuery(document).ready(function() { 
	
	$(function () {
	$("select#fCompanyId").change();
	
	});

});


	  
   }
 
 
 function getDeliveryType(value)
	{
		var dataStr = 'action=getDeliverytype&dId='+value;
		$.ajax({
		type: 'POST',
		url: 'ajax/ajax.php',
		data: dataStr,
		cache: false,
		success: function(result) {
		$("#DeliveryType").html(result);
		
		
		}
		});
		var number =  $("#fStoreNumber").val(); 
		var Company =  $("#fCompanyLookup").val(); 
		if(value =='ESD')
		{
		
		$('#DeliveryNumber').html(Company + "-ESD-"+ number);
		}
		else if(value =='ISD')
		{
		
		$('#DeliveryNumber').html(Company + "-ISD-"+ number );
		}
		
      }
	
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
		    var dataStr = 'action=getStoreList&fromstoreId='+id;
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				 $("#StoreList").html(result);
			  $('#purchaseItems').html(itemtable);
			  
				 
			   }
          });
		}
  
	
		
		function getCompanyLookup(id)
		{
		
		   	var dataStr = 'action=getCompanyLookup&cmpyID='+id;
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {$("#fCompanyLookup").val(result);
				  $('input[type="radio"]:checked').change();
				 
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
		 
		 function removeItem(id)
		 {
			
			 	 var storeId =  $('#fFromStoreId').val();	  
				var dataStr = 'action=remove&removeId='+id+'&StoreId='+storeId;
				  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				
				  $('#purchaseItems').html(itemtable);
				  $('#purchaseItems').append(result);
			   }
          });
		 }
		
		  function getItemLising(id)
		  {
		 var Group1id = $("#fItemGroup1").val();
		  var storeId =  $('#fFromStoreId').val();
		var dataStr = 'action=getItemsList&Group1Id='+Group1id+'&StoreId='+storeId+'&Group2Id='+id;
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
		 function addQuanitity()
		  {
			  
			  
			  var qty = new Array();
				$("input[name='fIssueQuantity[]']").each(function(){
					var quantity = $(this).val();
					qty.push(quantity);
				});
				
				  var stockqty = new Array();
				$("input[name='fStockQuqntity[]']").each(function(){
					var Stockquantity = $(this).val();
					stockqty.push(Stockquantity);
				});
				
								  var item = new Array();
				$("input[name='fAssetItemId[]']").each(function(){
					var items = $(this).val();
					item.push(items);
				});
				
				Array.prototype.compare = function(testArr) {
    if (this.length != testArr.length) return false;
    for (var i = 0; i < testArr.length; i++) {
        if (this[i].compare) { 
            if (!this[i].compare(testArr[i])) return false;
        }
        if (this[i] !== testArr[i]) 
		
			
		return false;
    }
    return true;
}
				if(stockqty.compare(qty)) {

			var dataStr = 'action=addQuantity&asset_item='+JSON.stringify(item)+'&qty='+JSON.stringify(qty);
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {}
          });
		  } else {
     alert("Please Enter the issue quantity less than or equal Stock quantity");
	  
	 return false;
}

		  }
		 
		 function AddItem(id)
		 {
			 var id = $('#fItemName').val();
			 var storeId =  $('#fFromStoreId').val();
			var dataStr = 'action=addItem&StoreId='+storeId+'&ItemId='+id;
			
		  $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				  $('#purchaseItems').append(result);
				
			   }
          });
			
			
    //$('#purchaseItems').append('<tr><td>COL1</td><td>COL2</td><td>COL1</td><td>COL2</td><td>COL1</td><td>COL2</td><td>COL1</td></tr>');
		 }

		  
		  
   </script>
   <script type="text/javascript">
   jQuery('form#form_sample_3').one('submit',function(e) {
    e.preventDefault();
   amsPopup();
    var form = jQuery(this);
    form.submit();
  });
   </script>
</body>
<!-- END BODY -->
</html>