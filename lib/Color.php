<?php
	/**
	  * Color class
	  *
	  * @author Subash Gopalaswamy <subashchandraa@gmail.com>
	  */
  
  class Color
  {
	public function __construct()
	{
	   //
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
	  $stitchtype_modified_by = $_SESSION['sesCustomerInfo']['user_id'];
	  $status = $aRequest['fStatus'];
	  $query = "UPDATE thread_color SET colorname ='".$colorname."', description ='".$description."', pantonenumber='".$pantonenumber."', status = ".$status.",modified_by = ".$stitchtype_modified_by.", modified_on = now() WHERE id_color = ".$colorid;
	
	 if($this->oDb->query($query))
	  {
	     $done = 1;
	  }
	  return $done;
	  
	}
	
	public function deleteColor($id)
	{
		   $done = 0;
		  echo $query = "DELETE from thread_color WHERE id_color =".$id;
		  
			 if($this->oDb->query($query))
			 {
			   $done = 1;
			 }
	        return $done;
	   
	} //deleteThreadType
	
	

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