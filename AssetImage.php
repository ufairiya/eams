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

  if(isset($aRequest['fReturnURL']))
  {
 $aImageResult = $oMaster-> getAssetImages($aRequest['fInventoryItem'],$aRequest['fAssetNumber']);
	}
if(isset($aRequest['send']))
  {
    if($result = $oMaster->addAssetImages($aRequest,$_FILES,$aRequest['fAssetId']))
	{
    $aImageResult = $oMaster-> getAssetImages($result['inventoryitem'],$result['assetid']); 
	if($result['url'] == 'AssetList.php')
	{
	$ReturnURL = $result['url'];
	}
	else
	{
	$ReturnURL = $result['url'].'?fAssetNumber='.$result['assetid'];
	}
	if($result['msg'] == '1')
	{
	$msg = "New Asset Image Added.";
	}
	else if($result['msg'] == '2')
	{
	$msg = "Asset Image Deleted.";
	}
	else
	{
	$msg = "Sorry Image not uploaded.";
	}
	
	  /*echo '<script type="text/javascript">window.location.href="'.$ReturnURL.'";</script>';*/
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
   <title>EAMS | Asset Image</title>
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
									<?php echo $msg; unset($msg); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo $ReturnURL;?>" class="btn red mini active">Back to List</a>
								</div>
                                
								<?php
								  }
								?> 
                                
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
			
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" id="form_sample_3" method="post" enctype="multipart/form-data">
						
                      
                      
                        	<div class="row-fluid"> 

                                    <div class="span6">

                                    <table id="purchaseItems" name="purchaseItems">

                              <?php if(isset($aImageResult))

							  {

								  $a = 1;

							  ?>

								 <?php foreach($aImageResult as $image ) {

									

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

                                     

                                      </div>
                         	
				
                                 
                                    <div class="form-actions">
                                       <button type="submit" class="btn blue" name="send"><i class="icon-ok"></i> Save</button>
                                       <input type="hidden" name="fAssetId" value="<?php 
									   if($result['assetid']!='')
										 {
										echo $result['assetid'];
										 }
										 else
										 {
									   echo $aRequest['fAssetNumber'];}?>"/>
									     <input type="hidden" name="fUrl" value="<?php 
										  if($result['url']!='')
										 {
										echo $result['url'];
										 }
										 else
										 {
										 
										 echo  $aRequest['fReturnURL'];
										 }?>"/>
									     <input type="hidden" name="fInventoryItemId" value="<?php 
										 if($result['inventoryitem']!='')
										 {
										echo $result['inventoryitem'];
										 }
										 else
										 {
										 echo  $aRequest['fInventoryItem'];
										 }?>"/>
									  
                                      
                                    </div>
                                   
                                 </form>
                               
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>
              </div>         
                      
                     
   <!-- END CONTAINER -->
	<?php include_once 'Footer1.php'; ?>
  
<script type="text/javascript">
     
	 jQuery(document).ready(function() { 

		 $('#fAddImgeCheckbox').click(function() {

    $("#addimage").toggle(this.checked);

});

		 

		  }); //

	  
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