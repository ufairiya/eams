   <!-- BEGIN FOOTER -->
   <div class="footer">
      <?php echo date('Y');?> &copy;EnterpriseAMS.
      <div class="span pull-right">
         <span class="go-top"><i class="icon-angle-up"></i></span>
      </div>
   </div>
   <!-- END FOOTER -->
   <!-- BEGIN JAVASCRIPTS -->    
   <!-- Load javascripts at bottom, this will reduce page load time -->
   <script src="assets/js/jquery-1.8.3.min.js"></script>    
   <script src="assets/breakpoints/breakpoints.js"></script>
   <script type="text/javascript" src="assets/ckeditor/ckeditor.js"></script>        
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>
   <script src="assets/js/jquery.blockui.js"></script>
   <script src="assets/js/jquery.cookie.js"></script>
   <!-- ie8 fixes -->
   <!--[if lt IE 9]>
   <script src="assets/js/excanvas.js"></script>
   <script src="assets/js/respond.js"></script>
   <![endif]-->
   <script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
   <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
   <script type="text/javascript" src="assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
   <script type="text/javascript" src="assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
   <script type="text/javascript" src="assets/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
   <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
   <script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script> 
   <script type="text/javascript" src="assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>  
   <script type="text/javascript" src="assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
    <script type="text/javascript" src="assets/jquery-validation/dist/jquery.validate.min.js"></script>
   <script type="text/javascript" src="assets/jquery-validation/dist/additional-methods.min.js"></script>
     <script src="assets/js/app.js"></script> 
	 <script src="assets/js/delete.js"></script>   
 
	<script type="text/javascript" src="assets/gritter/js/jquery.gritter.js"></script>
	<script type="text/javascript" src="assets/js/jquery.pulsate.min.js"></script>

	  
  <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
     <script src="js/jquery.simplemodal.js"></script>
		<script src="js/city.js"></script>
		<script src="js/state.js"></script>
		<script src="js/country.js"></script>
		<script src="js/unit.js"></script>
		<script src="js/vendor.js"></script>
		<script src="js/employee.js"></script>
		<script src="js/division.js"></script>
		<script src="js/itemgroup1.js"></script>
		<script src="js/itemgroup2.js"></script>
		<script src="js/item.js"></script>
		<script src="js/store.js"></script>
 <script>
      jQuery(document).ready(function() {   
         // initiate layout and plugins
		 
		   
         // to fix chosen dropdown width in inactive hidden tab content
         $('.advance_form_with_chosen_element').on('shown', function (e) {
            App.initChosenSelect('.chosen_category:visible');
         });
      
         App.setPage("ItemCategory");
	     App.init();
		 
		 
      });
	  
	  
   </script>
    <script src="assets/fancybox/source/jquery.fancybox.pack.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
					$('.fancybox').fancybox();
	});
	</script>
	<style type="text/css">
		.fancybox-custom .fancybox-skin {
			box-shadow: 0 0 50px #222;
		}
	</style>
	<script type="text/javascript">
$(document).ready(function()
{

  $('.ajax_bt').click(function() {

 $('div.loading').addClass("enabled");
	$('div.loading').removeClass("disabled");

  });

});  

</script>
    
   <!-- END JAVASCRIPTS -->   