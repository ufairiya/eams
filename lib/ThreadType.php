<?php
	/**
	  * Stitch Type class
	  *
	  * @author Subash Gopalaswamy <subashchandraa@gmail.com>
	  */
  
  class ThreadType
  {
	public function __construct()
	{
	   //
	}
	
	public function setDb($oDb)
	{
	   $this->oDb = $oDb;
	}
	
	public function addThreadType($aRequest)
	{
	  $threadtype   = strtoupper($aRequest['fThreadTypeName']);
	  $ticketnumber = $aRequest['fTicketNumber'];
	  $description  = strtoupper($aRequest['fThreadDesc']);
	  $conelength      = $aRequest['fConeLength'];
	 
	  $status      = $aRequest['fStatus'];
	  $created_by   = $_SESSION['sesCustomerInfo']['user_id'];
	 $query = "INSERT INTO thread_threadtype (id_threadtype, threadtype_name, ticket_number, description, cone_length, created_by,created_on,modified_by, modified_on,status) VALUES (null, '".$threadtype."','".$ticketnumber."','".$description."','".$conelength."','".$created_by."',now(),'', now(),'".$status."')";
	
	  if($this->oDb->query($query))
	   {
	     //exit();
	     return true;
	   }
	   else { //exit();
	     return false;
	   }	 
	}
	public function getThreadTypeInfo($threadtypeId)
	{
	   
	   $aThreadTypeInfo = array();
	   $query = "SELECT id_threadtype, threadtype_name, ticket_number, description, cone_length, created_by,created_on,modified_by, modified_on,status FROM thread_threadtype WHERE id_threadtype =".$threadtypeId;
	   if($row = $this->oDb->get_row($query))
	   {
	      $aThreadTypeInfo['id_threadtype']    = $row->id_threadtype;
		  $aThreadTypeInfo['threadtype_name']  = strtoupper($row->threadtype_name);
		  $aThreadTypeInfo['ticket_number']    = $row->ticket_number; 
		  $aThreadTypeInfo['description']      = strtoupper($row->description);
		  $aThreadTypeInfo['cone_length']      = $row->cone_length;
		  $aThreadTypeInfo['status']         = $row->status;
	   }
	   return $aThreadTypeInfo;
	   
	}
	public function getThreadTypeName($id)
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
	
	public function updateThreadType($aRequest)
	{
	  $done = 0;
	  $threadtypeid          = $aRequest['fThreadTypeId'];
	  $threadtypename        = strtoupper($aRequest['fThreadTypeName']);
	  $ticketnumber          = $aRequest['fTicketNumber'];
	  $description           = strtoupper($aRequest['fThreadDesc']);
	  $conelength            = $aRequest['fConeLength'];
	 	  
	  //$id_stitch = $aRequest['fStitchId'];
	  $stitchtype_modified_by = $_SESSION['sesCustomerInfo']['user_id'];
	  $status = $aRequest['fStatus'];
	  $query = "UPDATE thread_threadtype SET threadtype_name ='".$threadtypename."', description ='".$description."', ticket_number='".$ticketnumber."', cone_length = '".$conelength."', status = ".$status.",modified_by = ".$stitchtype_modified_by.", modified_on = now() WHERE id_threadtype = ".$threadtypeid;
	
	 if($this->oDb->query($query))
	  {
	     $done = 1;
	  }
	  return $done;
	  
	}
	
	public function deleteThreadType($id)
	{
		   $done = 0;
		  $query = "DELETE FROM thread_threadtype WHERE id_threadtype =".$id;
			 if($this->oDb->query($query))
			 {
			   $done = 1;
			 }
	        return $done;
	   
	} //deleteThreadType
	
	

	public function getAllThreadTypeInfo()
	{
	   
	   $aThreadTypeInfo = array();
	   $query = "SELECT * FROM thread_threadtype WHERE status != 2";
	   if($result = $this->oDb->get_results($query))
	   {
		   foreach($result as $row)
		   {
			  $aThreadType = array();
			  $aThreadType['id_threadtype'] = $row->id_threadtype;
			  $aThreadType['threadtype_name']    = strtoupper($row->threadtype_name);
			  $aThreadType['ticket_number']       = $row->ticket_number; 
			  $aThreadType['description']   = strtoupper($row->description);
			  $aThreadType['cone_length']    = $row->cone_length;
			  $aThreadType['status']       = $row->status;
			  $aThreadTypeInfo[]           = $aThreadType;
		   }
		  
	   }
	   return $aThreadTypeInfo;
	   
	}
  } //end class
?>