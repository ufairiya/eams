<?php
	/**
	  * Style Details class
	  *
	  * @author Subash Gopalaswamy <subashchandraa@gmail.com>
	  */
  
  class StyleDetails
  {
	public function __construct()
	{
	   //
	}
	
	public function setDb($oDb)
	{
	   $this->oDb = $oDb;
	}
	
	public function addStyle($aRequest)
	{
	  $ordernumber   = strtoupper($aRequest['fOrderNumber']);
	  $buyerref    = $aRequest['fBuyerRef'];
	  $stylenumber = $aRequest['fStyleNumber'];
	  $status      = $aRequest['fStatus'];
	  $asset_create_by   = $_SESSION['sesCustomerInfo']['user_id'];
	 $query = "INSERT INTO thread_order (id_order, ordernumber, buyerref,stylenumber, created_by,created_on,modified_by, modified_on,status) VALUES (null, '".$ordernumber."','".$buyerref."','".$stylenumber."','".$asset_create_by."',now(),'', now(),'".$status."')";
	
	  if($this->oDb->query($query))
	   {
	      //Adding colors of the style order
		  $insert_id = $this->oDb->insert_id;
		  $aColorId = $aRequest['fColorId'];
		  foreach($aColorId as $colorid)
		  {
		     echo $qry = "INSERT INTO thread_ordercolormap (id_colormap, id_color, id_order) VALUES (null, '".$colorid."','".$insert_id."')";
			 $this->oDb->query($qry);
		  }	 
		 
	     return true;
	   }
	   else { //exit();
	     return false;
	   }	 
	}
	public function getStyleInfo($unitId)
	{
	   
	   $aStyleInfo = array();
	   $query = "SELECT id_order, ordernumber, buyerref, stylenumber,created_by,created_on,modified_by, modified_on,status FROM thread_order WHERE id_order =".$unitId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $aStyleInfo['id_order']      = $row->id_order;
		  $aStyleInfo['ordernumber']   = strtoupper($row->ordernumber);
		  $aStyleInfo['buyerref']      = strtoupper($row->buyerref); 
		  $aStyleInfo['stylenumber']   = strtoupper($row->stylenumber);
		  $aStyleInfo['status']        = $row->status;
	   }
	   $qry = "SELECT id_order, id_color, id_colormap FROM thread_ordercolormap WHERE id_order = ".$unitId;
	   $aOrderColor = array();
	   if($cresults = $this->oDb->get_results($qry))
	   {
	      foreach($cresults as $crow)
		  {
		     $aOrderColor[$crow->id_colormap] = $crow->id_color;
		  }
	   }
	   $aStyleInfo['aColor'] = $aOrderColor;
	   return $aStyleInfo;
	   
	}
    
	
	public function updateStyle($aRequest)
	{
	  $done = 0;
	  $id_order       = $aRequest['fOrderId'];
	  $ordernumber        = strtoupper($aRequest['fOrderNumber']);
	  $buyerref         =  strtoupper($aRequest['fBuyerRef']);
	  $stylenumber =  strtoupper($aRequest['fStyleNumber']);
	  $asset_modified_by = $_SESSION['sesCustomerInfo']['user_id'];
	  $status = $aRequest['fStatus'];
	$query = "UPDATE thread_order SET ordernumber ='".$ordernumber."', buyerref ='".$buyerref."', stylenumber ='".$stylenumber."', status = ".$status.",modified_by = ".$asset_modified_by.", modified_on = now() WHERE id_order = ".$id_order;
	 if($this->oDb->query($query))
	  {
	     $aColor = $aRequest['fColorId']; 
		 foreach($aColor as $colorid)
		 {
		    $qry = "UPDATE thread_ordercolormap SET ";
		 }
		 
		 
		 $done = 1;
	  }
	  return $done;
	  
	}
	
	public function deleteStyle($unitId)
	{
		   $done = 0;

			 $query = "DELETE thread_order where id_order = ".$unitId;
			 if($this->oDb->query($query))
			 {
			   $done = 1;
			 }
	       
		   return $done;
	   
	} //deleteStyle
	

	public function getAllStyleInfo()
	{
	   
	   $aAllStyleInfo = array();
	   $query = "SELECT * FROM thread_order WHERE status != 2";
	   if($result = $this->oDb->get_results($query))
	   {
		   foreach($result as $row)
		   {
			  $aStyle = array();
			  $aStyle['id_order']          = $row->id_order;
			  $aStyle['ordernumber']   = strtoupper($row->ordernumber);
			  $aStyle['buyerref'] = strtoupper($row->buyerref); 
			  $aStyle['stylenumber']    = strtoupper($row->stylenumber);
			  $aStyle['status']       = $row->status;
			  $aAllStyleInfo[]           = $aStyle;
		   }
		  
	   }
	   return $aAllStyleInfo;
	   
	}
  } //end class
?>