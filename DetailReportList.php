<?php
  include_once 'ApplicationHeader.php'; 
  if(!$oCustomer->isLoggedIn())
  {
	header("Location: login.php");
  }
  $aCustomerInfo = $oSession->getSession('sesCustomerInfo');
  $aRequest = $_REQUEST;
  
 /* echo '<pre>';
  print_r($aRequest);
  exit();*/
  $sesReportItemList = $oSession->getSession('ses_ReportItemlist');
   
	if(isset($_REQUEST['send']))
		{
	 if(empty($sesReportItemList))
		{
		   $sesReportItemList = array();
		}
		
		$sesReportItemList = $aRequest;
		$oSession->setSession('ses_ReportItemlist',$sesReportItemList);
		}

	$rowsPerPage = 20;
	$pageNum = 1;
 $aSearchList =	$oMaster->getSearchLabel($sesReportItemList);

 $astockReportListcount = $oReport->DetailReportList($sesReportItemList,'count');

		if(isset($_REQUEST['sort']))
		{
			if($_REQUEST['sort']=='ASC')
				$sort='DESC';
			if($_REQUEST['sort']=='DESC')
				$sort='ASC';
		}
		else
		{
		 	$sort = 'DESC';
		}

		if(isset($_REQUEST['page']))
		{
			$sortpage =  $_REQUEST['sort'];
		}
		else
		{
			$sortpage =  "DESC";
		}
		if(isset($_REQUEST['field']))
		{
	 	 	$field = $_REQUEST['field'];
		}
		else
		{
		 	$field = '';
		}
	
		
							
				  	if(isset($_REQUEST['page'])&& $_REQUEST['page']!='')
				  	{
						$pageNum 	= $_REQUEST['page'];
						$sort 		= $_REQUEST['sort'];
						
				  	}
			  	    $offset 		= ($pageNum - 1 )	* $rowsPerPage;
              		$numrows 		= $astockReportListcount; //$oDb->num_rows;
					
	   	  		  	$astockReportList 	= $oReport->DetailReportList( $sesReportItemList,$aRequest['fCriteria'], $offset, $rowsPerPage, $field, $sort);
				    
					$maxPage 		= ceil($numrows/$rowsPerPage);
				    $lastPage 		= ceil($numrows / $rowsPerPage);
	    		  	$pageNum 		= (int)$pageNum;
	    		  	$self 			= $_SERVER['PHP_SELF'];
				  	if($pageNum < 1 ) 
				  		$pageNum  = 1;
				  	else if($pageNum > $lastPage) 
				  		$pageNum = $lastPage;
				  if($pageNum > 1)
				  	{
				    	$page 		= $pageNum - 1;
						$prev 		= "<li><a href='$self?page=$page&field=".$field."&sort=".$sort."' class=pageLink>&lt;&lt; Prev&nbsp;</a></li>";
						$first 		= "<li><a href='$self?page=1&field=".$field."&sort=".$sort."' class=pageLink>[First Page]</a>&nbsp;&nbsp;&nbsp;</li>";
				  	}
				  	else
				  	{
				     	$prev 		= '<li><a>&lt;&lt; Prev&nbsp;</a></li>';
						$first 		= '<li><a>[First Page]&nbsp;&nbsp;&nbsp;</a></li>';
				  	}
				  	if($pageNum < $maxPage)
				  	{
				     	$page 		= $pageNum + 1;
						$next 		= "<li><a href='$self?page=$page&field=".$field."&sort=".$sort."' class=pageLink>Next &gt;&gt;</a></li>&nbsp;&nbsp;&nbsp;";
						$last 		= "<li><a href='$self?page=$maxPage&field=".$field."&sort=".$sort."' class=pageLink>[Last Page]</a></li>&nbsp;&nbsp;&nbsp;";
				  	}
				  	else
				  	{
				    	$next 		= '<li><a>&nbsp;Next &gt;&gt;&nbsp;&nbsp;&nbsp;</a></li>';
						$last 		= '<li><a>[Last Page]&nbsp;&nbsp;&nbsp;</a></li>';
				  	}
				  	$pageLinks 		= "";
				  	for($i=1;$i<=$maxPage;$i++)
				  	{
					  	if(empty($_REQUEST['page']) && $i == 1)
					  	{
					  		$pageLinks.="<li><a><strong>$i</strong></a></li>";
					  	}
					    else if($i == $_REQUEST['page']) 
					    {
						 		$pageLinks.="<li><a><strong>$i</strong></a></li>";
					    }
					    else
					    {
					    	$pageLinks.= "<li><a href='$self?page=$i&field=".$field."&sort=".$sort."' class=pageLink>$i</a></li>";
					    }
			  	}
				if(empty($astockReportList))
				{
				$astockReportList = 0;
				}
	/*		echo '<pre>';
		print_r($aRequest);
		print_r($astockReportList );
		exit();*/
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>EAMS|  Report List </title>
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
   <div class="page-container row-fluid full-width-page">
		<!-- BEGIN SIDEBAR -->
      
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
                      Report 
                 
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="index.php">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                   
                     <li><a href="#"> Report List</a></li>
                  </ul>
               </div>
            </div>
            
                              
                              
                                
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            
            <!-- BEGIN PAGE CONTENT-->
            
             <div class="row-fluid profile">
					<div class="tabbable tabbable-custom">
									<div id="tab_1_5" class="tab-pane">
								
								<div class="portlet-body">
                                <div style="float:left";>
                                <a href="index.php">BACK TO FORM</a>
                                <div >SEARCH FOR :&nbsp;<b><?php echo $aSearchList;?></b></div>
                                </div>
                               <div style="float:right";>
                                <div class="pagination pagination-right">
									<ul>
										 <?php echo $first . $prev . $pageLinks . $next . $last; ?>
									</ul>
								</div>
                                 </div>
								 <?php if($aRequest['fCriteria'] =='count')
								 {?>
								 <div class="row-fluid profile">
			<table class="table table-striped table-hover">
			<thead>
            <tr>
           
			 <th>Name</th>
             <th>Stock Count</th>
             </tr>
            </thead>
            
            <tr>
			 <td><?php echo $oMaster->getSearchName($aRequest);?></td>
            <td><?php echo $astockReportList ;?></td>
             </tr>
           		
			</table>
			</div>
								 <?php } else {?>
								 
             
 <?php  if(empty($astockReportListcount))
  {
  ?> 
  	<table class="table table-striped table-hover">
	<thead>
											<tr>
												<th>SLNO</th>
                                                <th><a href="?field=itemgroup1.itemgroup1_name&sort=<?php echo $sort;?>" class="titleLink">Item Group 1</a></th>
                                                <th><a href="?field=itemgroup2.itemgroup2_name&sort=<?php echo $sort;?>" class="titleLink">Item Group 2</a></th>
                                                <th><a href="?field=item.item_name&sort=<?php echo $sort;?>" class="titleLink">Item </a></th>
                                                <th class="hidden-phone"> <a href="?field=itemgroup1.itemgroup1_name&sort=<?php echo $sort;?>" class="titleLink">Machine Number</a></th>
                                                <th><a href="?field= asset_item.asset_no&sort=<?php echo $sort;?>" class="titleLink"> Asset Number</a></th>
                                                <th class="hidden-phone">Image</th>
												 <th class="hidden-phone"> <a href="?field=asset_stock.id_division&sort=<?php echo $sort;?>" class="titleLink">Division Name</a></th>
                                                <th class="hidden-phone"> <a href="?field=asset_item.machine_no&sort=<?php echo $sort;?>" class="titleLink">Store Name</a></th>
                                                <th > <a href="?field= asset_unit.unit_name&sort=<?php echo $sort;?>" class="titleLink">Unit Name</a></th>
                                                <th><a href="?field=asset_item.status&sort=<?php echo $sort;?>" class="titleLink">Status</a></th>
                                               
											</tr>
										</thead>
										<tbody>
    <tr><td colspan="10" style="text-align:center">No Result Found.</td></tr>
	</table>
  
  <?php
  } else { ?>
									<table class="table table-striped table-hover">
										<thead>
											<tr>
												<th>SLNO</th>
                                                <th><a href="?field=itemgroup1.itemgroup1_name&sort=<?php echo $sort;?>" class="titleLink">Item Group 1</a></th>
                                                <th><a href="?field=itemgroup2.itemgroup2_name&sort=<?php echo $sort;?>" class="titleLink">Item Group 2</a></th>
                                                <th><a href="?field=item.item_name&sort=<?php echo $sort;?>" class="titleLink">Item </a></th>
                                                <th class="hidden-phone"> <a href="?field=itemgroup1.itemgroup1_name&sort=<?php echo $sort;?>" class="titleLink">Machine Number</a></th>
                                                <th><a href="?field= asset_item.asset_no&sort=<?php echo $sort;?>" class="titleLink"> Asset Number</a></th>
                                                <th class="hidden-phone">Image</th>
												 <th class="hidden-phone"> <a href="?field=asset_stock.id_division&sort=<?php echo $sort;?>" class="titleLink">Division Name</a></th>
                                                <th class="hidden-phone"> <a href="?field=asset_item.machine_no&sort=<?php echo $sort;?>" class="titleLink">Store Name</a></th>
                                                <th > <a href="?field= asset_unit.unit_name&sort=<?php echo $sort;?>" class="titleLink">Unit Name</a></th>
                                                <th><a href="?field=asset_item.status&sort=<?php echo $sort;?>" class="titleLink">Status</a></th>
                                               
											</tr>
										</thead>
										<tbody>
                                        <?php 
										 $offset 		= ($pageNum - 1 )	* $rowsPerPage; 
										 $sl_no = $offset +1;
										foreach($astockReportList as $stockReport) {
											?>
											<tr>
												<td><?php echo  $sl_no;?></td>
                                                <td><?php echo $stockReport['itemgroup1_name'];?></td>
												<td><?php echo $stockReport['itemgroup2_name'];?></td>
                                               <td><?php echo $stockReport['item_name'];?></td>
                                               <td  class="hidden-phone"><?php echo $stockReport['machine_no'];?></td>
                                                <td><?php echo $stockReport['asset_no'];?></td>
                                                <td class="hidden-phone">
                                                  <?php if($stockReport['asset_image']!='') {
										 ?>
                                          
										<span class="photo"> <img src="uploads/assetimage/<?php echo $stockReport['asset_image'];?>" alt="" height="50" width="50"/></span>
                                        
                                        <?php } else {?>
                                          <span class="photo">   <img src="assets/img/noimage.gif" alt="" height="50" width="50" /></span>
                                             <?php } ?>
                                                
                                                
                                                </td>
												  <td class="hidden-phone"><?php echo $stockReport['division_name'];?></td>
                                                <td class="hidden-phone"><?php echo $stockReport['store_name'];?></td>
                                                <td><?php echo $stockReport['unit_name'];?></td>
                                               <td><?php echo $oUtil->AssetItemStatus($stockReport['status']);?></td>
                                               
											</tr>
											<?php $sl_no++; } ?>
										</tbody>
									</table>
                                    <?php }?>
									<?php } ?>
								</div>
								<div class="space5"></div>
								<div class="pagination pagination-right">
									<ul>
										 <?php echo $first . $prev . $pageLinks . $next . $last; ?>
									</ul>
								</div>
							</div>
				</div>
                </div>
               
         <!-- END PAGE CONTAINER-->
      </div>
      </div>
      </div>
      
      <!-- END PAGE -->  
   </div>
   <!-- END CONTAINER -->
	<?php include_once 'Footer1.php'; ?>
  
</body>
<!-- END BODY -->
</html>