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
  
   $id_fuel = $aRequest['fFuelId'];
  $aFuelInfo =$oMaster->getFuelInfo($id_fuel,'id');
/*  echo '<pre>';
  print_r($aFuelInfo);
  exit();*/
 if(isset($aRequest['send']))
  {
   $oFormValidator->setField("ALLTEXT", "Bill Number", $aRequest['fBillNumber'], 1, '', '', '', '');
$oFormValidator->setField("ALLTEXT", " Bill Amount", $aRequest['fBillAmount'], 1, '', '', '', '');
$oFormValidator->setField("ALLTEXT", " Token Number", $aRequest['fTkNumber'], 1, '', '', '', '');
$oFormValidator->setField("LIST", " Vendor", $aRequest['fVendorId'], 1, '', '', '', '');
$oFormValidator->setField("LIST", " Item Group 1", $aRequest['fGroup1'], 1, '', '', '', '');
$oFormValidator->setField("LIST", " Brand / Make", $aRequest['fItemGroup2'], 1, '', '', '', '');
$oFormValidator->setField("LIST", " Item Name", $aRequest['fItemName'], 1, '', '', '', '');
$oFormValidator->setField("LIST", " Employee Name", $aRequest['fEmployeeId'], 1, '', '', '', '');
$oFormValidator->setField("LIST", " Fuel Type", $aRequest['fFuelType'], 1, '', '', '', '');
$oFormValidator->setField("LIST", " UOM", $aRequest['fUOMId'], 1, '', '', '', '');
$oFormValidator->setField("ALLTEXT", " CMR", $aRequest['fCMR'], 1, '', '', '', '');
$oFormValidator->setField("ALLTEXT", " Quantity", $aRequest['fQuantity'], 1, '', '', '', '');
$oFormValidator->setField("ALLTEXT", " Total Amount", $aRequest['fTotalPrice'], 1, '', '', '', '');		
	  if($oFormValidator->validation())
	  {
  
    if($result = $oMaster->addFuel($aRequest))
	{
	  $msg = "New Fuel Added.";
		 
	 echo '<script type="text/javascript">window.location.href="FuelList.php?msg=success"</script>'; 
	}
	else $msg = $_aErrorMsg['Duplicate']; //"Sorry could not add..";
  
  }
  
      else
	  {
	   $errMsg = $oFormValidator->createMsg("<br />");
	  }
	  }
   if(isset($aRequest['update']))
  {
    if($result = $oMaster->updateFuel($aRequest))
	{
	  $msg = "Update Successfully.";
		 
	 echo '<script type="text/javascript">window.location.href="FuelList.php?msg=updatesucess"</script>'; 
	}
	else $msg = $_aErrorMsg['Duplicate']; //"Sorry could not add..";
  } 
 
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Fuel Details</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
   <meta http-equiv="Cache-control" content="No-Cache">
  <?php include('Stylesheets.php');?>
  </head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top" onLoad="getGroup2ItemListing('<?php echo $aFuelInfo['id_itemgroup1'];?>','<?php echo $aFuelInfo['id_itemgroup2'];?>','<?php echo $aFuelInfo['id_asset_item']; ?>');">
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
                     
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Fuel</a>
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
               
               <!-- BEGIN SAMPLE FORM PORTLET-->   
                  <div class="portlet box blue">
                     <div class="portlet-title">
                      <?php if($aRequest['action'] == 'Add')
							{ ?>
                        <h4><i class="icon-reorder"></i>Add Fuel Details</h4>
                         <?php } else {?>
                          <h4><i class="icon-reorder"></i>Edit Fuel Details</h4>
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
						
						    <div class="alert alert-error hide">
                                <button class="close" data-dismiss="alert"></button>
                                You have some form errors. Please check below.
                            </div>
                       						                                     
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
							
                                 <!-- BEGIN FORM-->
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal form-row-seperated" id="form_sample_3" method="post">
								   <h3 class="form-section">Enter Fuel Details</h3>
                                      <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                              <label class="control-label">Bill Number <span class="required">*</span></label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap " tabindex="1" placeholder="Bill Number" name="fBillNumber" value="<?php echo (!empty($aFuelInfo['bill_no'])? $aFuelInfo['bill_no']:$aRequest['fBillNumber']);?>">
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
											  <label class="control-label" >Bill Date</label>
											  <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" tabindex="2" size="10" type="text" value="<?php echo (!empty($aFuelInfo['bill_date'])? date('d-m-Y',strtotime($aFuelInfo['bill_date'])):$aRequest['fBillDate']);?>" name="fBillDate"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
										   </div>
                                       </div>
                                         </div>
                                         	<div class="row-fluid">
                                       <div class="span6">
                                          <div class="control-group">
                                              <label class="control-label">Bill Amount <span class="required">*</span></label>
                                             <div class="controls">
                                                <input type="text" class="m-wrap " tabindex="3"  placeholder="Bill Amount" name="fBillAmount" value="<?php echo (!empty($aFuelInfo['bill_amount'])? $aFuelInfo['bill_amount']:$aRequest['fBillAmount']);?>" >
                                                <!--<span class="help-block">Auto created</span>-->
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
									   <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" >Payment Type</label>
                                             <div class="controls" >
                                               <select class=" chosen" data-placeholder="Choose Payment type" tabindex="4" name="fPaymentType" id="fPaymentType">
                                                
                                                <?php $apaymentType =  $oUtil->getPaymentType();
												 foreach($apaymentType as $key => $value)
												  {
												 ?>
                                                  <option value="<?php echo $key; ?>" <?php if((!empty($aFuelInfo['payment_type'])? $aFuelInfo['payment_type']:$aRequest['fPaymentType']) == $key) { echo 'selected=selected' ;}?>><?php echo $value; ?></option>
                                                 <?php }
												 ?>
                                                 </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->
									  	<div class="row-fluid">
										<div class="span12 ">
                                          <div class="control-group">
                                             <label class="control-label" >Token No.<span class="required">*</span></label>
                                             <div class="controls" >
                                                <input type="text" class="m-wrap " tabindex="5"  placeholder="Token Number." value="<?php echo (!empty($aFuelInfo['token_no'])? $aFuelInfo['token_no']:$aRequest['fTkNumber']);?>" name="fTkNumber">
                                                
                                             </div>
                                          </div>
                                       </div>
                                      
                                      </div>
									<div class="row-fluid">
									  
									  <div class="span12 ">
									    <div class="control-group">
                                        <label class="control-label">Vendor / Supplier<span class="required">*</span></label>
                                          <div class="controls">
                                             <select class="span3 m-wrap" data-placeholder="Choose a Vendor" tabindex="6" name="fVendorId" id="fVendorId" onChange="getVendorItemGroup(this.value);">
     										    <option value="0">Choose a Vendor</option>
												  <?php
													 $aItemGroup = $oMaster->getDistIgroup();
												  foreach( $aItemGroup as $ItemGroup)
												  {
												  ?>
												  <optgroup label="<?php echo $ItemGroup['itemgroup1_name']; ?>">
												  <?php
												  $avendorList = $oAssetVendor->getAllVendorInfos($ItemGroup['id_itemgroup1']);
												  foreach($avendorList as $aVendor)
												  {
												 ?>
												 <option value="<?php echo $aVendor['id_vendor']; ?>" <?php if((!empty($aFuelInfo['id_vendor'])? $aFuelInfo['id_vendor']:$aRequest['fVendorId']) == $aVendor['id_vendor']) { echo 'selected=selected' ;}?>><?php echo $aVendor['vendor_name']; ?></option>
												 <?php
												  }
												 ?>
												 </optgroup>
												 <?php } ?>
                                             </select> &nbsp;&nbsp;
											  <span><a href="#" class="vendor" title="Add New Vendor"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
											
                                           </div>
										   
                                         </div>
									  </div>
                                      
                                      </div>
                                      	<div class="row-fluid">
                                      <div class="span12 ">
									    <div class="control-group">
                                        <label class="control-label">Item Group1<span class="required">*</span></label>
                                          <div class="controls">
                                             <select class="m-wrap margin" tabindex="7" name="fGroup1" id="group1" onChange="getGroup2ItemListing(this.value);" >
                                            <option value="0" selected="selected" >Choose the ItemGroup 1 </option>
											 <?php
											  $aItemGroup1List = $oMaster->getItemGroup1List();
											  foreach($aItemGroup1List as $aItemGroup1)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup1['id_itemgroup1']; ?>" <?php if((!empty($aFuelInfo['id_itemgroup1'])? $aFuelInfo['id_itemgroup1']:$aRequest['fGroup1']) == $aItemGroup1['id_itemgroup1']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup1['itemgroup1_name']; ?></option>
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
                                        <label class="control-label">Brand / Make<span class="required">*</span></label>
                                          <div class="controls" id="Group2ItemList">
                                             <select class="m-wrap" tabindex="8" name="fGroup2">
                                               <option value="0" selected="selected" >Choose the ItemGroup 2 </option>
											 <?php
											  $aItemGroup2List = $oMaster->getItemGroup2List();
											  foreach($aItemGroup2List as $aItemGroup2)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup2['id_itemgroup2']; ?>" <?php if((!empty($aFuelInfo['id_itemgroup2'])? $aFuelInfo['id_itemgroup2']:$aRequest['fGroup2']) == $aItemGroup2['id_itemgroup2']) { echo 'selected=selected' ;}?>><?php echo $aItemGroup2['itemgroup2_name']; ?></option>
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
									    <div class="control-group" >
                                        <label class="control-label">Item<span class="required">*</span></label>
                                          <div class="controls" id="ItemsList">
                                             <select class="m-wrap  nextRow margin" tabindex="9" name="fItemName" onChange="getCMR(this.value);getUsedFuelcount(this.value);">
                                    <option value="0" >Choose the Item</option>
											 <?php
											  $aItemList = $oMaster->getItemList();
											  foreach($aItemList as $aItem)
											  {
											 ?>
                                             <option value="<?php echo $aItem['id_item']; ?>" <?php if((!empty($aFuelInfo['id_asset_item'])? $aFuelInfo['id_asset_item']:$aRequest['fItemName']) == $aItem['id_item']) { echo 'selected=selected' ;}?>><?php echo $aItem['item_name']; ?></option>
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
                                       <label class="control-label">Select Employee Name<span class="required">*</span></label>
                                       <div class="controls">
                                        <select class="m-wrap" tabindex="10" name="fEmployeeId">
											<option value="0">Choose Employee Name</option>
											<?php
											  $aEmployeeList = $oMaster->getEmployeeList();
											  foreach($aEmployeeList as $aEmployee)
											  {
			  
											 ?>
                                             <option value="<?php echo $aEmployee['id_employee']; ?>" <?php if((!empty($edit_result['approved_by'])? $edit_result['approved_by']:$aRequest['fEmployeeId']) == $aEmployee['id_employee']) { echo 'selected=selected' ;}?>><?php echo $aEmployee['employee_name']; ?></option>
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
									    <div class="control-group" >
                                        <label class="control-label">Fuel Type<span class="required">*</span></label>
                                          <div class="controls" id="ItemsList">
                                             <select class="m-wrap  nextRow margin" tabindex="11" name="fFuelType">
                                    <option value=" " selected="selected">Choose  Fuel Type </option>
											 <?php
											  $aItemList =$oUtil->getFuelType();;
											  foreach($aItemList as $key => $value)
											  {
											 ?>
                                             <option value="<?php echo $key; ?>" <?php if((!empty($aFuelInfo['id_fuel_type'])? $aFuelInfo['id_fuel_type']:$aRequest['fFuelType']) == $key) { echo 'selected=selected' ;}?>><?php echo $value; ?></option>
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
                                             <label class="control-label" >Fuel Used This Month:</label>
                                             <div class="controls" >
                                              <b><span id="fuelcount"><?php echo $oMaster->FuelUsedCount($aFuelInfo['id_asset_item']);?> </span> Lit</b>
                                                
                                             </div>
                                          </div>
                                       </div>
                                      
                                      </div>                             <!--/row-->
									   <h3 class="form-section">Enter Milage Posting Details</h3>
									      <div class="row-fluid">
                                      
                                      <div class="span6 ">
									  <div class="control-group">
                                       <label class="control-label">OMR</label>
                                       <div class="controls">
									    <input type="text" name="fOMR" tabindex="12" value="<?php echo $aFuelInfo['omr'];?>" id="OMR" readonly class="TxtReadonly"/>
									  </div>
									  </div>
									    </div>
										<div class="span6 ">
									  <div class="control-group">
                                       <label class="control-label">CMR<span class="required">*</span></label>
                                       <div class="controls">
									    <input type="text" name="fCMR" tabindex="13" value="<?php echo  (!empty($aFuelInfo['cmr'])? $aFuelInfo['cmr']:$aRequest['fCMR']);?>"/>
									  </div>
									  </div>
									    </div>
									  </div>
								
								<h3 class="form-section">Enter Fuel Details</h3>
								  <div class="row-fluid">
                                      
                                      <div class="span12 ">
									  <div class="control-group">
                                       <label class="control-label">Quantity/ UOM<span class="required">*</span></label>
                                       <div class="controls">
									     <input type="text" class="m-wrap xsmall" tabindex="14" value="<?php echo (!empty($aFuelInfo['qty'])? $aFuelInfo['qty']:$aRequest['fQuantity']);?>"  placeholder="Quantity" style=" float:left;" name="fQuantity">
									 <?php /*?>  <input type="text" class="m-wrap xsmall" value="<?php echo $aFuelInfo['qty'];?>"  placeholder="Quantity" style="text-align:right; float:left;" name="fQuantity" onKeyUp="qtytotalpricecalc(this.id);"id="qty1"><?php */?>
									   
									    <select class="m-wrap small chosen"  tabindex="15" data-placeholder="Choose a UOM" name="fUOMId">
                                               <option value=""></option>
											 <?php
											  $aUOMList= $oMaster->getUomList();
											  foreach($aUOMList as $aUOM)
											  {
			  
											 ?>
                                             <option value="<?php echo $aUOM['id_uom']; ?>" <?php if((!empty($aFuelInfo['id_uom'])? $aFuelInfo['id_uom']:$aRequest['fUOMId']) == $aUOM['id_uom']) { echo 'selected=selected' ;}?>><?php echo $aUOM['uom_name']; ?></option>
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
                                       <label class="control-label">Unit Price (<?php echo Currencycode;?>)</label>
                                       <div class="controls">
									    <input type="text" class="m-wrap  " tabindex="16" placeholder="Enter Unit Price"  value="<?php echo (!empty($aFuelInfo['unit_price'])? $aFuelInfo['unit_price']:$aRequest['fUnitPrice']);?>"  name="fUnitPrice" >
										<?php /*?><input type="text" class="m-wrap  " placeholder="Enter Unit Price"  value="<?php echo $aFuelInfo['unit_price'];?>" style="text-align:right;" name="fUnitPrice" id="unitprice1" onKeyUp="unitcalc(this.id);" ><?php */?>
									  </div>
									  </div>
									    </div>
										  </div>
								
								  <div class="row-fluid">
										<div class="span12 ">
									  <div class="control-group">
                                       <label class="control-label">Total (<?php echo Currencycode;?>) <span class="required">*</span></label>
                                       <div class="controls">
						  <input type="text" class="m-wrap " tabindex="17" placeholder="Total Proce"  name="fTotalPrice" value="<?php echo (!empty($aFuelInfo['total_price'])? $aFuelInfo['total_price']:$aRequest['fTotalPrice']);?>" id="unittotal1" >
									  </div>
									  </div>
									    </div>
									  </div>
								
															                                                                        
                                  
                                      
								    <div class="row-fluid">
                                       <div class="span12">
                                          <div class="control-group">
                                             <label class="control-label">Remark</label>
                                             <div class="controls">
                                                <textarea class="large m-wrap" tabindex="18" rows="3" name="fRemark"><?php echo (!empty($aFuelInfo['remarks'])? $aFuelInfo['remarks']:$aRequest['fRemark']);?></textarea>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       
                                       
                                    </div>
                                    
								  <div class="form-actions">
                                   <?php if($aRequest['action'] == 'Add')
							{ ?>  <button type="submit" class="btn blue" tabindex="19" name="send"><i class="icon-ok"></i>Add </button>   
							       <input name="action" type="hidden" value="Add"/>  
                                      <?php } else if($aRequest['action'] == 'edit'){ ?>
                                      <input type="hidden" name="fFuelId" value="<?php echo $aRequest['fFuelId'];?>"/>
									    <input type="hidden" name="fTripId" value="<?php echo $aFuelInfo['id_trip'];?>"/>
                                        <button type="submit" tabindex="19" class="btn blue" name="update"><i class="icon-ok"></i>Update </button> 
                                       <button type="button" class="btn">Go Back</button>
                                        <?php } else { ?>
										 <input name="action" type="hidden" value="Add"/>  
										 <button type="submit" class="btn blue" tabindex="19" name="send"><i class="icon-ok"></i>Add </button>    
										<?php } ?>
                                    </div>
								   </form>
                                  
                             
                                 <!-- END FORM-->                
                            
                        
									
									
									
									
									
									
                               
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
	<script>
	 
			 
		 
	  /*onChange="javascript: callvendor();"*/
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
			
			
				function unitcalc(id)
				{
					
					var ids= id.split("unitprice");
					var unitprice = $("#"+id).val();
					var qty = $("#qty"+ids[1]).val();
					if(parseInt(qty)>=0 && parseInt(unitprice)>=0 || qty =='' || unitprice == '')
					{
					var unittotal = parseFloat(unitprice) * parseFloat(qty);
					if(unitprice!='' && qty!='')
					{
					var unittotal = parseFloat(unitprice) * parseFloat(qty);
					}
					else
					{
						var unittotal = 0;
					}
					if(unittotal =='NaN')
					{
						$("#unittotal"+ids[1]).val(0);
						$("#unittotals"+ids[1]).html(0);
					}
					else
					{
						$("#unittotal"+ids[1]).val(unittotal.toFixed(2));
						$("#unittotals"+ids[1]).html(unittotal.toFixed(2));
					}
					}
					else
					{
						alert("Please Enter Correct Value");
						return false;
					}
					
					$("input[name='fTaxTotal[]']").each(function(){
					var taxprice = $(this).attr('id').split("taxprice");
					var taxid = "tax"+taxprice[1];
					taxcalc(taxid);
					}); 
					recalc();
					
					
					
				}
			
				function taxcalc(id)
				{ 
					var unitprice=0;
					$("input[name='fUnitTotal[]']").each(function(){
					unitprice+=parseFloat($(this).val());
					}); 
					var tax = $('#'+id).val();
					var tax_spilt = id.split("tax");
					var taxvalues = tax.split("/");
					var taxvalue = taxvalues[0];
					var addless = taxvalues[1];
					var taxtotal = parseFloat(unitprice)*parseFloat(tax);
					var taxtotals = parseFloat(taxtotal)/100;
				
					var TAXtotal=0;
					$("input[name='fTaxTotal[]']").each(function(){
					TAXtotal+= parseFloat($(this).val());
					});
					var netamount = parseFloat(unitprice);
					if(parseFloat(TAXtotal)==0)
					{
						
					if(addless == '+')
					{
				    var netamount = parseFloat(netamount) +  parseFloat(taxtotals);
					
					}
					else
					{
				     var netamount = parseFloat(netamount) -  parseFloat(taxtotals);
					}
					}
								
					else
					{
						var netamount = parseFloat(TAXtotal) + parseFloat(unitprice);
						
						if(addless == '+')
						{
						var netamount = parseFloat(netamount) +  parseFloat(taxtotals);
						
						}
						else
						{
						 var netamount = parseFloat(netamount) -  parseFloat(taxtotals);
						}
					}
					
					$('#taxprice'+tax_spilt[1]).val(addless+taxtotals.toFixed(2));
					$('#addless'+tax_spilt[1]).val(addless);
					$('#addlesss'+tax_spilt[1]).html(addless);
					var netamount= netamount.toFixed(2);
			
					recalc();
				}
			
			function qtytotalpricecalc(id)
			{
				var ids= id.split("qty");
				var unitprice = $("#"+id).val();
				var qty = $("#unitprice"+ids[1]).val();
					if(parseInt(qty)>=0 && parseInt(unitprice)>=0 || qty =='' || unitprice == '')
				{
				var unittotal = parseFloat(unitprice) * parseFloat(qty);
				var  unittotal= unittotal.toFixed(2);
				if(unitprice!='' && qty!='')
				{
				var unittotal = parseFloat(unitprice) * parseFloat(qty);
				var  unittotal= unittotal.toFixed(2);
				}
				else
				{
					var unittotal = 0;
				}
				if(unittotal =='NaN')
				{
					$("#unittotal"+ids[1]).val(0);
					$("#unittotals"+ids[1]).html(0);
				}
				else
				{
					$("#unittotal"+ids[1]).val(unittotal);
					$("#unittotals"+ids[1]).html(unittotal);
				}
				}
				else
				{
					alert("Please Enter Correct Value");
					return false;
				}
				
			
					recalc();	
				
				
			}
			
		function recalc()
		{
				var grantunitprice=0;
				$("input[name='fTotalPrice']").each(function(){
					grantunitprice+=parseFloat($(this).val());
				}); 
				$('#nettotal1').val(grantunitprice.toFixed(2));
				$('#nettotals1').html(grantunitprice.toFixed(2));
		}
		
			function Caluclation()
				{
					var Qty=0;
				$("input[name='fQuantity']").each(function(){
					Qty=$(this).attr('id');
					qtytotalpricecalc(Qty);
					
				});
				}	
			/*jQuery(document).ready(function() { 
$(function () {
	Caluclation();
	recalc();
	});
	});*/
			
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
			
			
			function getCMR(value)
		   {
			 
			var dataStr = 'action=getCMR&assetid='+value;
			
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/dropdown.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
			 
			$('#OMR').val(result);
			
			   }
			    });
				}
			function getUsedFuelcount(value)
		   {
			 
			var dataStr = 'action=getUsedFuelcount&assetid='+value;
			 $.ajax({
			   type: 'POST',
			   url: 'ajax/dropdown.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
			 
			$('#fuelcount').html(result);
			
			   }
         
		  
		 });
		 }
		   function getVendorItemGroup(value,id)
		 {
			
			var dataStr = 'action=getVendorItemList&vendorId='+value+'&id='+id;
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/dropdown.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				     $("#group1").html(result);
					
						
			   }
         
		  
		 });
		 }
</script>
 <?php /*?><script type="text/javascript">
 jQuery(document).ready(function() { 

$(function () {

	getVendorItemGroup('<?php echo (!empty($aFuelInfo['id_vendor'])? $aFuelInfo['id_vendor']:$aRequest['fVendorId']);?>');
	getGroup2ItemListing('<?php echo (!empty($aFuelInfo['id_itemgroup1'])? $aFuelInfo['id_itemgroup1']:$aRequest['fGroup1']);?>');
	getCMR('<?php echo (!empty($aFuelInfo['id_asset_item'])? $aFuelInfo['id_asset_item']:$aRequest['fItemName']);?>');
	});
	});
	
  
 </script><?php */?>
    
</body>
<!-- END BODY -->
</html>