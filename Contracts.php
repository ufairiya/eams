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
  
$aAssetItem = $oMaster->getAssetItemInfo($aRequest['fAssetNumber'],'id');
$aContactInfo =$oMaster->getContractInfoList($aRequest['fAssetNumber']);
$aContactDetails = $oMaster->geContractInfo($aRequest['fAssetNumber']);
$aVendorContact = $oMaster->getContractVendorContact($aContactDetails['id_contract'],'contract');
   if(isset($aRequest['add']))
  {
    if( $oMaster->addContracts($aRequest,$_FILES))
	{
	   $msg = "New Contract Added.";
	 echo '<script type="text/javascript">window.location.href="ContractList.php?msg=success";</script>';
	}
	else $msg = "Sorry";
  } //submit 
																
	if(isset($aRequest['fContractId']) && $aRequest['action'] =='edit')
	{
	$edit_result = $oMaster->getContractInfos($aRequest['fContractId'],'id');
	/*echo '<pre>';
	print_r($edit_result);
	echo '</pre>';*/
	
	}	
	 if(isset($aRequest['update']))
  {
    if( $oMaster->updateContract($aRequest,$_FILES))
	{
	   $msg = "New Contract Updated.";
	 echo '<script type="text/javascript">window.location.href="ContractList.php?msg=updatesucess";</script>';
	}
	else $msg = "Sorry";
  } //submit 
							
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS | Contracts </title>
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
       
							<div class="portlet box green">
                              <div class="portlet-title">
                                 <h4><i class="icon-reorder"></i>Contract </h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                    <a href="javascript:;" class="reload"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body form">
                                 <!-- BEGIN FORM-->
                                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="post" id="contract" enctype="multipart/form-data">
                                 
                                 <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Contract Type <span class="required">*</span></label>
                                             <div class="controls">
                                             <select  class="span10 " name="fContractType" >
											 <option value="">Choose the Contract Type</option>
                                             <?php $contractType = $oUtil->getContractType(); 
											 foreach ( $contractType as $key => $value )
											 {
											 ?>
                                             <option value="<?php echo $key;?>" <?php if((!empty($edit_result['contract_type'])? $edit_result['contract_type']:$aRequest['fContractType']) == $key) { echo 'selected=selected' ;}?>><?php echo $value;?></option>
                                             <?php } ?>
                                             </select>
                                                
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Contract Date <span class="required">*</span></label>
                                               <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fContractDate" value="<?php echo (!empty($edit_result['contract_date'])? date('d-m-Y',strtotime($edit_result['contract_date'])):$aRequest['fContractDate']); ?>"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
                                             <span for="fContractDate" class="help-inline"></span>
                                          </div>
                                       </div>
                                      
                                       <!--/span-->
                                    </div>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
										  <label class="control-label">Contract Title <span class="required">*</span></label>
										  <div class="controls" id="polist">
                                                <input type="text" class="m-wrap span10" placeholder="Contract Title" name="fContractTitle" value="<?php echo (!empty($edit_result['contract_title'])? $edit_result['contract_title']:$aRequest['fContactName']); ?>">
                                                <!--<span class="help-block">Purchase Order No.</span>-->
                                          </div>
										</div>
                                       </div>
                                       <!--/span-->
                                      <div class="span6 ">
                                          <div class="control-group">
										  <label class="control-label">Contract Reference Number</label>
										  <div class="controls" id="polist">
                                                <input type="text" class="m-wrap span10" placeholder="Contract Reference Number" name="fContractReferenceNo" value="<?php echo (!empty($edit_result['contract_reference_number'])? $edit_result['contract_reference_number']:$aRequest['fContractReferenceNo']); ?>">
                                                <!--<span class="help-block">Purchase Order No.</span>-->
                                          </div>
										</div>
                                       </div>
                                    </div>
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                    <div class="control-group">
                                       <label class="control-label">Max No of Items <span class="required">*</span></label>
                                       <div class="controls">
                                         <select name="fMaxContract" class="chosen span10"  data-placeholder="Choose the Max Item">
                                         <option value="0">Choose the Max item</option>
                                         <?php for($i=1;$i<=200;$i++)
										 {?>
                                         <option value="<?php echo $i;?>" <?php if((!empty($edit_result['no_items'])? $edit_result['no_items']:$aRequest['fMaxContract']) == $i) { echo 'selected=selected' ;}?>><?php echo $i;?></option>
                                         <?php }?>
                                         </select>
                                       </div>
                                    </div>
                                    </div>
                                    </div>
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Contract Order Value <span class="required">*</span></label>
                                             <div class="controls">
                                            
                                            <input type="text" class="m-wrap span10" name="fContractOrderValue" value="<?php echo (!empty($edit_result['contract_order_value'])? $edit_result['contract_order_value']:$aRequest['fContractOrderValue']); ?>">
                                      
                                                
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Contract Value As Per the Contract <span class="required">*</span></label>
                                               <div class="controls">
												  <input type="text" class="m-wrap span10" name="fContractValue" value="<?php echo (!empty($edit_result['contract_value'])? $edit_result['contract_value']:$aRequest['fContractValue']); ?>">
											  </div>
                                            
                                          </div>
                                       </div>
                                      
                                       <!--/span-->
                                    </div>
                                    
                                    
                                    
                                    
                                   <div class="row-fluid">
                                       <div class="span6 ">
									    <div class="control-group">
                                        
                                        
                                        <label class="control-label">Vendor / Supplier<span class="required">*</span></label>
                                        
                                          <div class="controls">
                                             <select class="span10" data-placeholder="Choose a Vendor" tabindex="1" name="fVendorId" id="fVendorId" onChange="getVendorContact(this.id);">
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
												 <option value="<?php echo $aVendor['id_vendor']; ?>" <?php if((!empty($edit_result['id_vendor'])? $edit_result['id_vendor']:$aRequest['fVendorId']) == $aVendor['id_vendor']) { echo 'selected=selected' ;}?>><?php echo $aVendor['vendor_name']; ?></option>
												 <?php
												  }
												 ?>
	</optgroup>
	<?php } ?>
                                             </select>
											  &nbsp; &nbsp; <span><a href="#" class="vendor" title="Add New Vendor"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                           </div>
                                         </div>
									  </div>
                                       <!--/span-->
                                       
                                       <div class="span6 ">
                                    <div class="control-group">
                              <label class="control-label">Vendor Contact Person</label>
                              <div class="controls" id="Contactlist">
                                 <select data-placeholder="Choose Multiple Contact Person" class="chosen span10" multiple="multiple" tabindex="6">
                                 <option value="0">Choose Contact Person</option>
                                  </select>
                              </div>
                           </div>
                                    </div>
                                      
                                       
                                       <!--/span-->
                                    </div>
                                    <!--/row-->        
                                    <div class="row-fluid">
                                     <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Contract Start Date (FROM)<span class="required">*</span></label>
                                               <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fContractStartDate" value="<?php echo (!empty($edit_result['contract_start_date'])? date('d-m-Y',strtotime($edit_result['contract_start_date'])):$aRequest['fContractStartDate']); ?>">
													<span class="add-on"><i class="icon-calendar"></i></span>
												
												 </div>
											  </div>
                                            	<span for="fContractStartDate" class="help-inline"></span>
                                          </div>
										
                                       </div>
                                       
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Contract End Date (TO) <span class="required">*</span></label>
                                             <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fContractEndDate" value="<?php echo (!empty($edit_result['contract_end_date'])? date('d-m-Y',strtotime($edit_result['contract_end_date'])):$aRequest['fContractEndDate']); ?>">
													<span class="add-on"><i class="icon-calendar"></i></span>
													
												 </div>
											  </div>
											  <span for="fContractEndDate" class="help-inline"></span>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->                               
                                   <div class="row-fluid">
                                       <div class="span6 ">
                                         <div class="control-group">
                              <label class="control-label">Upload Multiple Contract Document</label>
                              <div class="controls">
                                 <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="input-append">
                                       <div class="uneditable-input">
                                          <i class="icon-file fileupload-exists"></i> 
                                          <span class="fileupload-preview"></span>
                                       </div>
                                       <span class="btn btn-file">
                                       <span class="fileupload-new">Select file</span>
                                       <span class="fileupload-exists">Change</span>
                                      <input type="file" name="files[]" multiple/>
                                        </span>
                                       <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                    </div>
                                 </div>
                              </div>
                           </div> 
                                       </div>
                                       
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label">Next Contract Renewal Date <span class="required">*</span></label>
                                               <div class="controls">
												 <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" size="10" type="text" name="fContractRenewalDate" value="<?php echo (!empty($edit_result['renewal_date'])? date('d-m-Y',strtotime($edit_result['renewal_date'])):$aRequest['fContractRenewalDate']); ?>"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
											  </div>
                                              <span for="fContractRenewalDate" class="help-inline"></span>
                                          </div>
                                       </div>
                                    </div>
                                    
                                     <div class="row-fluid">
                                       <div class="span6 ">
                                    <div class="control-group">
                                       <label class="control-label">Remarks</label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fRemark"><?php echo (!empty($edit_result['remark'])? $edit_result['remark']:$aRequest['fRemark']); ?></textarea>
                                       </div>
                                    </div>
                                    </div>
                                    <div class="span6 ">
                                    <div class="control-group">
                                       <label class="control-label">Terms and Conditions</label>
                                       <div class="controls">
                                          <textarea class="large m-wrap" rows="3" name="fTerms"><?php echo (!empty($edit_result['terms_and_conditions'])? $edit_result['terms_and_conditions']:$aRequest['fTerms']); ?></textarea>
                                       </div>
                                    </div>
                                    </div>
                                    </div>
                                                                  
                                       
                                       <div class="form-actions">
									   <?php if($aRequest['action'] == 'Add') {?>
									   <input type="hidden" name="action" value="Add"/>
                                        <button type="submit" class="btn blue" name="add"><i class="icon-ok"></i> Add</button>
									    <?php } else if($aRequest['action'] == 'edit') {?>
										 <input type="hidden" name="action" value="edit"/>
										  <input type="hidden" name="fContractId" value="<?php echo (!empty($edit_result['id_contract'])? $edit_result['id_contract']:$aRequest['fContractId']);?>"/>
                                       <button type="submit" class="btn blue" name="update"><i class="icon-ok"></i> Update</button>
									   	   <?php } else { ?>
										    <input type="hidden" name="action" value="Add"/>
									    <button type="submit" class="btn blue" name="add"><i class="icon-ok"></i> Add</button>
									    <?php } ?>
                                       <button type="button" class="btn">Cancel</button>
                                    </div>
                                      
                                     
                                    <!--/row-->
                                    
                                 </form>
                                 <!-- END FORM-->                
                              </div>
                              </div>
                             
                                      
                        
           <!-- BEGIN PAGE CONTENT-->
				
				<!-- END PAGE CONTENT-->
            <!-- END PAGE CONTENT--> 
            </div>        
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      
      
      <!-- END PAGE -->  
 
   <!-- END CONTAINER -->
	<?php include_once 'Footer1.php'; ?>
     
    
    <script type="text/javascript">
	
	function ShowResult(id,grnid)
			{
				
			url = document.URL.split("?")[0];
			var dropresult = addParam(url, "Itemid",id);	
			var dropresult1 = addParam(dropresult, "id",grnid);	
			var dropresult2 = addParam(url, "id",id);	
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
		 jQuery("#fAssetCategoryId").on('change', function() {
		   
		   var id = $("#fAssetCategoryId").val();
		   	var dataStr = 'action=getAssettype&catId='+id;
		    $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				 
					  jQuery("#Assettypeitemlist").html(result);
				 
			   }
          });
		  
		 });
		 
		  }); //
		  
		 function getVendorContact(id)
		 {
		   var id = $("#fVendorId").val();
		   	var dataStr = 'action=getVendorContact&vendorId='+id;
		    $.ajax({
			   type: 'POST',
			   url: 'ajax/ajax.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
					  jQuery("#Contactlist").html(result);
				 
			   }
          });
		  
		 }
	
	function addParam(url, param, value) {
    var a = document.createElement('a');
    a.href = url;
    a.search += a.search.substring(0,1) == "?" ? "&" : "?";
    a.search += encodeURIComponent(param);
    if (value)
        a.search += "=" + encodeURIComponent(value);
    return a.href;
}
jQuery(document).ready(function() { 
	
	$(function () {
	$("select#fVendorId").change();
	
	});
});

</script>
<script>
      jQuery(document).ready(function() {   
         // initiate layout and plugins
         App.setPage("contracts");
         App.init();
      });
   </script>

<script>

$(document).ready(function() {

var contractform =  $("#contract");
  contractform.validate({
	errorElement: 'span', //default input error message container
            errorClass: 'help-inline', // default input error message class
  rules: {
            fContractTitle: {
                required: true
            },
			fContractType: {
			required: true
			},
			fContractDate: {
			required: true
			},
			fMaxContract: {
			required: true
			},
			fContractOrderValue: {
			required: true
			},
			fContractValue: {
			required: true
			},
			fVendorId: {
			required: true
			},
			fContractStartDate: {
			required: true
			},
			fContractEndDate: {
			required: true
			},
			fContractRenewalDate: {
			required: true
			},			
			
			
        },
		 messages: { // custom messages for radio buttons and checkboxes
              
				 fContractTitle: {
                    required: "Please Enter the Contract Title"
                },
				fContractType: {
                    required: "Select  the Contract Type"
                },
				fContractDate: {
                    required: "Please Enter the Contract Date"
                },
				fMaxContract: {
                    required: "Select  the Maximum Contract Item"
                },
				fContractOrderValue: {
                    required: "Please Enter the Contract Order Value"
                },
				
				fContractValue: {
                    required: "Please Enter the Contract Value"
                },
				fVendorId: {
                    required: "Select  the Contract Provider"
                },
				fContractStartDate: {
                    required: "Please Enter the Contract Start Date"
                },
				fContractEndDate: {
                    required: "Please Enter the Contract End Date"
                },
				fContractRenewalDate: {
                    required: "Please Enter the Contract Next Renewal Date"
                }
				
				
				
            },
			  invalidHandler: function (event, validator) { //display error alert on form submit   
               $('.alert-success').hide();
               $('.alert-error').show();
               
            },
			 highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.help-inline').removeClass('ok'); // display OK icon
                $(element)
                    .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
            },
			unhighlight: function (element) { // revert the change dony by hightlight
                $(element)
                    .closest('.control-group').removeClass('error'); // set error class to the control group
            },
    submitHandler: function (form) { // for demo
      $('.alert-success').hide();
               $('.alert-error').show();      
		  
		  form.submit();
           
        }
       
			
    });
	
});


</script>
</body>
<!-- END BODY -->
</html>