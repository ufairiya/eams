<!-- BEGIN FOOTER -->
	<div class="footer">
		<?php echo date('Y');?> &copy;EnterpriseAMS
		<div class="span pull-right">
			<span class="go-top"><i class="icon-angle-up"></i></span>
		</div>
	</div>
  
	<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS -->
	<!-- Load javascripts at bottom, this will reduce page load time -->
	<script src="assets/js/jquery-1.8.3.min.js"></script>	
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>	
	<![endif]-->	
	<script src="assets/breakpoints/breakpoints.js"></script>		
	<script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>	
	<script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.blockui.js"></script>	
	<script src="assets/js/jquery.cookie.js"></script>
	<script src="assets/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>	
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>	
	<!--<script src="assets/flot/jquery.flot.js"></script>
	<script src="assets/flot/jquery.flot.resize.js"></script>-->
	<script type="text/javascript" src="assets/gritter/js/jquery.gritter.js"></script>
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>	
	<script type="text/javascript" src="assets/js/jquery.pulsate.min.js"></script>
	<script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>	
	<script src="assets/js/app.js"></script>				
	<script>
		jQuery(document).ready(function() {		
			App.setPage("index");  // set current page
			App.init(); // init the rest of plugins and elements
		});
	</script>
	<script type="text/javascript">
	 function getGroup2ItemListing(id,value,group2id,itemid)
		 {
		   var ids= id.split("group");
			var dataStr = 'action=getGroup2ItemList&Group1Id='+value+'&group2Id='+group2id;
		
			 $.ajax({
			   type: 'POST',
			   url: 'ajax/report.php',
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
			   url: 'ajax/report.php',
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
			   url: 'ajax/report.php',
			   data: dataStr,
			   cache: false,
			   success: function(result) {
				  $("#fItemName"+ids[1]).html(result);
				 
			   }
          });
		  
		  }
	
	</script>
	 <script type="text/javascript">
	jQuery(document).ready(function(){
	jQuery('#fSearchType').change(function(){ 
	  var type = $('#fSearchType').val();
      var searchdataStrs = 'action=searchType&stype='+type;
			 jQuery.ajax({
			   type: 'POST',
			   url: 'ajax/report.php',
			   data: searchdataStrs,
			     success: function(searchresult) {
				 jQuery('#searchtype').html(searchresult);
			   }
			   });	 
	   	 });  
		 
		 
	});
	
	
	
    </script>
   
	<script type="text/javascript">
	   var seconds = 15;
	   var flag = 1;
	     var appendflag = 1;
		$(document).ready(function() {
		
			var updateInterval = setInterval(function() {
					 var ListdataString = 'action=warrantyList';
			  $.ajax({
			   type: 'POST',
			  url: 'Notification.php',
			   data: ListdataString,
			   cache: false,
			   success: function(ListdataStringresult) {
	            $('#warrants').html(ListdataStringresult);
				   }
			 
			   });
			    var contractdataString = 'action=contractList';
			  $.ajax({
			   type: 'POST',
			  url: 'Notification.php',
			   data: contractdataString,
			   cache: false,
			   success: function(contractdataStringresult) {
	            $('#contractList').html(contractdataStringresult);
				   }
			 
			   });
			   
			    var insurancedataString = 'action=insuranceList';
			  $.ajax({
			   type: 'POST',
			  url: 'Notification.php',
			   data: insurancedataString,
			   cache: false,
			   success: function(insurancedataStringresult) {
	            $('#insuranceList').html(insurancedataStringresult);
				   }
			 
			   });
				
				
				var dataString = 'action=dashBoard';
				
				$.ajax({
			   type: 'POST',
			   url: 'ajax/dropdown.php',
			   data: dataString,
			   cache: false,
			    dataType:"json",
			   success: function(results) {
				$('#total-asset').html(results.Total_Asset_Count);
				$('#po-count').html(results.New_PO_Count);
				$('#PurchaseRequest-count').html(results.New_PR_Count);
				$('#Addasset-count').html(results.Add_Asset_Count);
				
			   }
			   });
			   
			  
	var dataStr = 'action=getNewPr';
			
		  $.ajax({
			   type: 'POST',
			   url: 'Notification.php',
			   data: dataStr,
			   cache: false,
			    dataType:"json",
			   success: function(result) {
				
				if(result.prcount>0 ){  
				
				
		var notifycount = '<?php 
		echo $sesNotify = $oSession->getSession('notifycount');
		
		?>';	
			var notifycount1 = ''+result.prcount;
	if(flag ==1)
				{$.gritter.add({
	// (string | mandatory) the heading of the notification
	title: 'Purchase Requests  Approval Notice',
	// (string | mandatory) the text inside the notification
	text: ''+result.prcount+result.msg,
	image: 'uploads/companylogo/logo.png',
	sticky: true,
	 before_open: function(){
		$.post('session.php', { 'action' : 'PR', 'count' : ''+result.prcount});
		           if($('.my-sticky-class1').length == 1)
                    {
                        // Returning false prevents a new gritter from opening
								
                        return false;
                    }
                },
			class_name: 'my-sticky-class1',	
	after_close: function(){
		//alert('I am a sticky called after it closes');
			flag = 0;
			$.gritter.removeAll();
	}
	
});	
}	
   if(appendflag == 1) {
		appendflag = 0;
if(parseInt(notifycount) != parseInt(notifycount1))
	{
	var dataStrs = 'action=PR&PRcounts='+result.prcount;
	
	 $.ajax({
			   type: 'POST',
			   url: 'session.php',
			   data: dataStrs,
			   cache: false,
			    dataType:"json",
			   success: function(results) {
			   }
			   });	
	
	   $.gritter.removeAll();
	 
	}
	else
	{
	}
	}
	else { appendflag = 1; }
				}	
			   }
          });
		
  	
			var WarrantydataStr = 'action=getWarranty';
			
				$.ajax({
			   type: 'POST',
			 url: 'ajax/dropdown.php',
			   data: WarrantydataStr,
			   cache: false,
			    dataType:"json",
			   success: function(warranty) {
			  
			 		if(warranty.warrantycount>0 ){  
				
				
		var notifywarrantycount = '<?php echo $oSession->getSession('notifywarrantycount');?>';	
			var notifywarrantycount1 = ''+warranty.warrantycount;
		
		console.log("session:"+notifywarrantycount);
		
			console.log("count:"+notifywarrantycount1);
	if(flag ==1)
				{$.gritter.add({
	// (string | mandatory) the heading of the notification
	title: 'Warranty Expire Notice',
	// (string | mandatory) the text inside the notification
	text: ''+warranty.warrantycount+warranty.msg,
	image: 'uploads/companylogo/logo.png',
	sticky: true,
	 before_open: function(){
		$.post('session.php', { 'action' : 'Warranty', 'count' : ''+warranty.warrantycount});
		
		           if($('.my-sticky-class').length == 1)
                    {
                        // Returning false prevents a new gritter from opening
								
                        return false;
                    }
                
                },
				class_name: 'my-sticky-class',
	after_close: function(){
		//alert('I am a sticky called after it closes');
			flag = 0;
			$.gritter.removeAll();
	}
	
});	
}	
   if(appendflag == 1) {
		appendflag = 0;
		
if(parseInt(notifywarrantycount1) != parseInt(notifywarrantycount))
	{
	
	if(notifywarrantycount <= notifywarrantycount1 || notifywarrantycount>= notifywarrantycount1)
		{
			   var dataStrs1 = 'action=Warranty&counts='+warranty.warrantycount;
	
				 $.ajax({
			   type: 'POST',
			   url: 'session.php',
			   data: dataStrs1,
			   cache: false,
			    dataType:"json",
			   success: function(results1) {
					var notifywarrantycount = results1;	
			   }
			   });	 
			
			
		}
	
	
	 
	 
	}
	else
	{
	}
	}
	else { appendflag = 1; }
				}	
			   }
			   });	
				
	  
			
}, (seconds*1000));	
	
			
	});
	</script>
    
  
	<!-- END JAVASCRIPTS -->