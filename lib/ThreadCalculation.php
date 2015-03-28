<?php
	/**
	  * ThreadCalculation class
	  *
	  * @author Subash Gopalaswamy <subashchandraa@gmail.com>
	  */
  
  class ThreadCalculation
  {
	public function __construct()
	{
	   //
	}
	public function calcLengthPerOperation($iso,$numRow,$S,$T,$seamLength) 
	{
	   
	}
	public function calculateThreadPerInch($iso,$S,$T,$W=0) //($stitchType,$spi,$seamThickness)
	{
	   $T = $T * 0.039370;  //THICKNESS IN INCH
	   if($iso == '101') { return(3 + (2 * $T * $S)); }
	   
	   if($iso == '301') { $N = 1/$S;  return 2 + (2*$T*$S);  } //2+2TS
	   if($iso == '302') { return 3 + ((2*$S)*(2*$T+$W)); }
	   if($iso == '303') { return 4 + 2*$S(3*$T + $W) ;}
	   if($iso == '304') { return 2 * $S(sqrt(pow($W,2) + pow($N,2)) + $T); } 
	   if($iso == '305') { return ( 3 * sqrt($W*$W+$N*$N) + 4*$T + 2*$W ) * $S; }
	   
	   if($iso == '401') { return(4 + (2 * $T * $S)); }
	   if($iso == '402') { return 5 + ((4*$S)*($T+$W)); }
	   if($iso == '403') { return 5 + ((4*$S)*($T+$W)); }
	   
	  /*if($stitchType == '302') { return (3 + 2 * $T * $S); }
	   if($stitchType == '303') { return (3 + 2 * $T * $S); }
	   if($stitchType == '304') { return (3 + 2 * $T * $S); }
	   if($stitchType == '305') { return (3 + 2 * $T * $S); }
	   if($stitchType == '401') { return (3 + 2 * $T * $S); }
	   if($stitchType == '402') { return (3 + 2 * $T * $S); }
	   if($stitchType == '403') { return (3 + 2 * $T * $S); }
	   if($stitchType == '404') { return (3 + 2 * $T * $S); }
	   if($stitchType == '405') { return (3 + 2 * $T * $S); }
	   if($stitchType == '406') { return (3 + 2 * $T * $S); }
	   if($stitchType == '407') { return (3 + 2 * $T * $S); }
	   if($stitchType == '501') { return (3 + 2 * $T * $S); }
	   if($stitchType == '502') { return (3 + 2 * $T * $S); }
	   if($stitchType == '503') { return (3 + 2 * $T * $S); }
	   if($stitchType == '504') { return (3 + 2 * $T * $S); }
	   if($stitchType == '505') { return (3 + 2 * $T * $S); }
	   if($stitchType == '506') { return (3 + 2 * $T * $S); }
	   if($stitchType == '512') { return (3 + 2 * $T * $S); }
	   if($stitchType == '601') { return (3 + 2 * $T * $S); }
	   if($stitchType == '602') { return (3 + 2 * $T * $S); }
	   if($stitchType == '603') { return (3 + 2 * $T * $S); }
	   if($stitchType == '604') { return (3 + 2 * $T * $S); }
	   if($stitchType == '605') { return (3 + 2 * $T * $S); }
	   if($stitchType == '606') { return (3 + 2 * $T * $S); }
	   if($stitchType == '607') { return (3 + 2 * $T * $S); }*/
	  
	   
	}
	
	
	public function setDb($oDb)
	{
	   $this->oDb = $oDb;
	}
	
	public function addColor($aRequest)
	{
	  $colorname   = strtoupper($aRequest['fColorName']);
	  $pantonenumber = strtoupper($aRequest['fPantoneNumber']);
	  $description  = strtoupper($aRequest['fColorDesc']);
	 
	 
	  $status      = $aRequest['fStatus'];
	  $created_by   = $_SESSION['sesCustomerInfo']['user_id'];
	 $query = "INSERT INTO thread_color (id_color, colorname, pantonenumber, description,created_by,created_on,modified_by, modified_on,status) VALUES (null, '".$colorname."','".$pantonenumber."','".$description."','".$created_by."',now(),'', now(),'".$status."')";
	
	  if($this->oDb->query($query))
	   {
	     //exit();
	     return true;
	   }
	   else { //exit();
	     return false;
	   }	 
	}
	public function getColorInfo($colorId)
	{
	   
	   $aColorInfo = array();
	   $query = "SELECT id_color, colorname, pantonenumber, description, created_by,created_on,modified_by, modified_on,status FROM thread_color WHERE id_color =".$colorId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $aColorInfo['id_color']    = $row->id_color;
		  $aColorInfo['colorname']  = strtoupper($row->colorname);
		  $aColorInfo['pantonenumber']    = strtoupper($row->pantonenumber); 
		  $aColorInfo['description']      = strtoupper($row->description);
		  $aColorInfo['status']         = $row->status;
	   }
	   return $aColorInfo;
	   
	}
	public function getColorName($id)
	{
	   $stitchname = '';
	   if($id == '0')
	   {
	     $stitchname = 'No Parent';
	   }
	   else {
	   $query = "SELECT colorname FROM thread_color WHERE id_color =".$id;
	   if($row = $this->oDb->get_row($query))
	   {
	      $colorname = $row->colorname;
	   }
	   }
	   return $colorname;
	}
	
	public function updateColor($aRequest)
	{
	  $done = 0;
	  $colorid          = $aRequest['fColorId'];
	  $colorname        = strtoupper($aRequest['fColorName']);
	  $pantonenumber          = strtoupper($aRequest['fPantoneNumber']);
	  $description           = strtoupper($aRequest['fColorDesc']);
	  
	 	  
	  //$id_stitch = $aRequest['fStitchId'];
	  $modified_by = $_SESSION['sesCustomerInfo']['user_id'];
	  $status = $aRequest['fStatus'];
	  $query = "UPDATE thread_color SET colorname ='".$colorname."', description ='".$description."', pantonenumber='".$pantonenumber."', status = ".$status.",modified_by = ".$modified_by.", modified_on = now() WHERE id_color = ".$colorid;
	
	 if($this->oDb->query($query))
	  {
	     $done = 1;
	  }
	  return $done;
	  
	}
	
	public function deleteColor($id)
	{
		   $done = 0;
		   $query = "DELETE from thread_color WHERE id_color =".$id;
		  
			 if($this->oDb->query($query))
			 {
			   $done = 1;
			 }
	        return $done;
	   
	} //deleteColor
	
	

	public function getAllColorInfo()
	{
	   
	   $aColorInfo = array();
	   $query = "SELECT * FROM thread_color WHERE status != 2";
	   if($result = $this->oDb->get_results($query))
	   {
		   foreach($result as $row)
		   {
			  $aColor = array();
			  $aColor['id_color'] = $row->id_color;
			  $aColor['colorname']    = strtoupper($row->colorname);
			  $aColor['pantonenumber']       = strtoupper($row->pantonenumber); 
			  $aColor['description']   = strtoupper($row->description);
			  $aColor['status']       = $row->status;
			  $aColorInfo[]           = $aColor;
		   }
		  
	   }
	   return $aColorInfo;
	   
	}
  } //end class
?>