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
  $astoreNumber = $oMaster->salesInvoiceCount(); 
  if($aRequest['action'] == 'edit')
  {
		
	
  }
   if(isset($aRequest['send']))
   {
	 if($oMaster->addSalesInvoice($aRequest))
	 {
	  $msg = 'Added';
	    echo '<script type="text/javascript">window.location.href="SalesInvoice.php?msg=success";</script>';
	 }
	 else
	 {
	 $msg = 'sorty';
	 }	
	
  }
  

	 $_SESSION['ses_SaleItemlist'] = '';
	
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS| Sales Invoice </title>
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
                     Sales Invoice
                     <small>Sales Invoice Master</small>
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="#">Sales Invoice</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Sales Invoice</a></li>
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
                                 <h4><i class="icon-reorder"></i>Sales Invoice </h4>
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
                                        <h3 class="form-section">Sales Invoice</h3>
										
										<div class="row-fluid">
                                    <div class="span12">
                                              <div class="control-group">
                                              <label class="control-label">Sales Invoice Number:</label>
                                             <div class="controls">
                                               <span class="text" id="DeliveryNumber"><b><?php echo $astoreNumber;?></b></span>
                                              
                                              
                                             </div>
                                          </div>
                                       </div>
									   </div>
                               <div class="row-fluid">
                                       <div class="span12 "> 
                                        <div class="control-group">
                                             <label class="control-label">Invoice Date</label>
                               <div class="controls">
                                    <div class="input-append date date-picker" data-date="<?php echo date('d-m-Y');?>" data-date-format="dd-mm-yyyy">
													<input class="m-wrap m-ctrl-small date-picker span8" placeholder="Invoice Date" size="10" type="text" name="fRequireDate" value="<?php echo date('d-m-Y');?>" style="width:100px;"><span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
                                                 </div>
                                            </div>
                                       </div> 
                                                 
                                                 </div>
                                 <div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group">
                                             <label class="control-label">Company Name</label>
                               <div class="controls">
                                       
                                       <select class="large m-wrap chosen" data-placeholder="Choose Company" tabindex="1" name="fCompanyId" id="fCompanyId" onChange="getCompanyLookup(this.value);" >
                                       
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
									     </div>
                                        <div class="row-fluid">  
                                  <div class="control-group">
                                      <label class="control-label">Select Vendor</label>
                                       <div class="controls">
                                       <select class="large m-wrap" tabindex="3" name="fvendorId" id="fVendorId">
											 <?php
											  $avendorList = $oAssetVendor->getAllVendorInfo();
											 ?>
                                             <option value="0">Choose the Supplier</option>
                                             <?php  foreach($avendorList as $aVendor)
											  {
												  ?>
                                             <option value="<?php echo $aVendor['id_vendor']; ?>"  <?php if($edit_result['id_vendor'] == $aVendor['id_vendor']) { echo 'selected=selected' ;}?>><?php echo $aVendor['vendor_name']; ?></option>
                                             <?php
											  }
											 ?>
                                          </select> 
										   &nbsp;  &nbsp;
										  <span><a href="#" class="vendor" title="Add New Vendor"><i class="icon-plus-sign" style="color:#009900;"></i></a></span>
                                             </div>
                                   		 </div>
                                  </div>  
                                    
                               
                                    
                           <h3 class="form-section"></h3>          
                                 <div class="row-fluid" id="ItemList" style="width: 75%;margin-left: 180px;">
                                                                        
                                        <div class="span4">
                                       <select class="m-wrap" tabindex="6" name="fItemGroup1" id="fItemGroup1" onChange="getGroup2ItemListing(this.value);"  >
                                            <option value="0" selected="selected" >Choose the ItemGroup 1 </option>
                                            
                                             <?php
											 $aItemGroup1List = $oMaster->getItemGroup1List();
											  foreach($aItemGroup1List as $aItemGroup1)
											  {
											 ?>
                                                
                                             <option value="<?php echo $aItemGroup1['id_itemgroup1']; ?>"><?php echo $aItemGroup1['itemgroup1_name']; ?></option>
                                             <?php
											  }
											 ?>
										     </select> 
                                       </div>
                                     
                                        <div class="span4" >
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
                                    
												
												 
												 
												 
                                                 <?php if($aRequest['action'] == 'edit') {} else { ?>                
                                  <div class="row-fluid">               
                                         <table id="purchaseItems" name="purchaseItems" class="table table-striped table-bordered table-hover">
								<tr>
											  <th>Asset Number</th>
											 <th>Item</th>
											 <th>Quantity</th>
                                          	<th>Purchase Price</th>
											<th>Depreciation Price</th>
											<th>Sale Price</th>
											<th>Tax</th>                                          
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
                                    <input type="hidden" name="fDeliveryType" value="ESD"/>
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
   var itemtable = "<table id='purchaseItems' name='purchaseItems' class='table table-striped table-bordered table-hover'><tr>  <th>Asset Number</th>											 <th>Item</th><th>Quantity</th> <th>Purchase Price</th>	<th>Depreciation Price</th>	<th>Sale Price</th>	<th>Tax</th><th>Action</th> </tr> </table>";
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
jQuery(document).ready(function() { 
	
	$(function () {
	$("select#fCompanyId").change();
	
	});

});

   </script>
   <script type="text/javascript" >
   	 function getGroup2ItemListing(id)
		 {
			 
			var dataStr = 'action=getGroup2ItemList&Group1Id='+id;
		    $.ajax({
			   type: 'POST',
			   url: 'ajax/sale.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
			    $("#fItemGroup2").html(result);
			  }
         
		  
		 });
		 	
		  
		 
		 }
			 function getItemLising(id) 
			 {
		  var group1 = $('#fItemGroup1').val();
		 	var dataStr = 'action=getGroupItemList1&Group1Id='+group1+'&Group2Id='+id;

			  $.ajax({
			   type: 'POST',
			   url: 'ajax/sale.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
			
			      $("#ItemsList").html(result); 
				 
			   }
      
		 });
   }
   
    function AddItem(id)
		 {
			 var id = $('#fItemName').val();
		var dataStr = 'action=addItem&ItemId='+id;
			
		  $.ajax({
			   type: 'POST',
			   url: 'ajax/sale.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				  $('#purchaseItems').append(result);
				
			   }
          });
			

		 }
		 
		  function removeItem(id)
		 {
			var dataStr = 'action=remove&removeId='+id;
			  $.ajax({
			   type: 'POST',
			   url: 'ajax/sale.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				
				  $('#purchaseItems').html(itemtable);
				  $('#purchaseItems').append(result);
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
								 
			   }
          });
		}
		


   </script>
</body>
<!-- END BODY -->
</html>