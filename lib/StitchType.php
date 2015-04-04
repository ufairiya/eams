<?php
	/**
	  * Stitch Type class
	  *
	  * @author Subash Gopalaswamy <subashchandraa@gmail.com>
	  */
  
  class StitchType
  {
	public function __construct()
	{
	   //
	}
	
	public function setDb($oDb)
	{
	   $this->oDb = $oDb;
	}
	
	public function addStitchType($aRequest)
	{
	  $stitchname   = strtoupper($aRequest['fStitchName']);
	  $isocode      = $aRequest['fISOcode'];
	  $description  = strtoupper($aRequest['fStitchDesc']);
	  $needles      = $aRequest['fNeedles'];
	  $needlethread      = $aRequest['fNeedleThread'];
	  $looperthread      = $aRequest['fLooperThread'];
	  $status      = $aRequest['fStatus'];
	  $created_by   = $_SESSION['sesCustomerInfo']['user_id'];
	 $query = "INSERT INTO thread_stitchtype (id_stitchtype, stitchname, isocode, description, needles, needlethread, looperthread, created_by,created_on,modified_by, modified_on,status) VALUES (null, '".$stitchname."','".$isocode."','".$description."','".$needles."','".$needlethread."','".$looperthread."','".$created_by."',now(),'', now(),'".$status."')";
	
	  if($this->oDb->query($query))
	   {
	     //exit();
	     return true;
	   }
	   else { //exit();
	     return false;
	   }	 
	}
	public function getStitchTypeInfo($stitchtypeId)
	{
	   
	   $aStitchTypeInfo = array();
	   $query = "SELECT id_stitchtype, stitchname, isocode, description, needles, needlethread, looperthread, created_by,created_on,modified_by, modified_on,status FROM thread_stitchtype WHERE id_stitchtype =".$stitchtypeId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $aStitchTypeInfo['id_stitchtype']  = $row->id_stitchtype;
		  $aStitchTypeInfo['stitchname']     = strtoupper($row->stitchname);
		  $aStitchTypeInfo['isocode']        = $row->isocode; 
		  $aStitchTypeInfo['description']    = strtoupper($row->description);
		  $aStitchTypeInfo['needles']        = $row->needles;
		  $aStitchTypeInfo['needlethread']   = $row->needlethread;
		  $aStitchTypeInfo['looperthread']   = $row->looperthread;
		  $aStitchTypeInfo['status']         = $row->status;
	   }
	   return $aStitchTypeInfo;
	   
	}
	public function getStitchTypeName($id)
	{
	   $stitchname = '';
	   if($id == '0')
	   {
	     $stitchname = 'No Parent';
	   }
	   else {
	   $query = "SELECT stitchname FROM thread_stitchtype WHERE id_stitchtype =".$unitId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $asset_unit_name = $row->unit_name;
	   }
	   }
	   return $asset_unit_name;
	}
	
	public function updateStitchType($aRequest)
	{
	  $done = 0;
	  $stitchid          = $aRequest['fStitchId'];
	  $stitchname        = strtoupper($aRequest['fStitchName']);
	  $isocode          = $aRequest['fISOcode'];
	  $description      = strtoupper($aRequest['fStitchDesc']);
	  $needles          = $aRequest['fNeedles'];
	  $needlethread     = $aRequest['fNeedleThread'];
	  $looperthread     = $aRequest['fLooperThread'];
	  
	  //$id_stitch = $aRequest['fStitchId'];
	  $stitchtype_modified_by = $_SESSION['sesCustomerInfo']['user_id'];
	  $status = $aRequest['fStatus'];
	 $query = "UPDATE thread_stitchtype SET stitchname ='".$stitchname."', description ='".$description."', isocode='".$isocode."', needles = '".$needles."', needlethread ='".$needlethread."', looperthread = '".$looperthread."', status = ".$status.",modified_by = ".$stitchtype_modified_by.", modified_on = now() WHERE id_stitchtype = ".$stitchid;
	
	 if($this->oDb->query($query))
	  {
	     $done = 1;
	  }
	  return $done;
	  
	}
	
	public function deleteStitchType($id)
	{
		   $done = 0;
		  $query = "DELETE FROM thread_stitchtype WHERE id_stitchtype =".$id;
			 if($this->oDb->query($query))
			 {
			   $done = 1;
			 }
	        return $done;
	   
	} //deleteStitchType
	
	

	public function getAllStitchTypeInfo()
	{
	   
	   $aStitchTypeInfo = array();
	   $query = "SELECT * FROM thread_stitchtype WHERE status != 2";
	   if($result = $this->oDb->get_results($query))
	   {
		   foreach($result as $row)
		   {
			  $aStitchType = array();
			  $aStitchType['id_stitchtype'] = $row->id_stitchtype;
			  $aStitchType['stitchname']    = strtoupper($row->stitchname);
			  $aStitchType['isocode']       = $row->isocode; 
			  $aStitchType['description']   = strtoupper($row->description);
			  $aStitchType['needles']    = $row->needles;
			  $aStitchType['needlethread']    = $row->needlethread;
			  $aStitchType['looperthread']    = $row->looperthread;
			  $aStitchType['status']       = $row->status;
			  $aStitchTypeInfo[]           = $aStitchType;
		   }
		  
	   }
	   return $aStitchTypeInfo;
	   
	}
  } //end class
?>