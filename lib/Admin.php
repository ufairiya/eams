<?php

/**
 * 
 * 
 * $Id$
 * 
 * @author Deepa <mailto:deepa.vells@gmail.com> (13-Oct-2012) (13.10.12)
 */
class Admin {
	
	public function __construct()
	{
		//$this->oDb = $oDb;
	}
	public function setDb($oDb)
	{
		$this->oDb = $oDb;
	}
	public function isLoggedIn()
	{
		return $_SESSION['LOGIN'];
	}
	public function checkLogin($userId, $password)
	{
		$adminInfo = array();
		$adminInfo['CheckLogin'] = 0;
		$query = "SELECT id,login_name,password,status FROM admin WHERE login_name='".$userId."' AND password ='".$password."' AND status = 1";
		if($row = $this->oDb->get_row($query))
		{
		   	$adminInfo['user_id']			   = $row->id;
			$adminInfo['user_name']            = $row->login_name;
			$adminInfo['password']             = $row->password;
			$adminInfo['status']               = $row->status;
			$adminInfo['CheckLogin']           = 1;
			$checkLogin = 1;
	
		}
		return $adminInfo;
		
	} //end checkLogin
	
 public function insertProfileInfo($aRequest)
			{
			$inserted = 0;
			$created_date = date('Y-m-d H:i:s');
			$insert_profile = "INSERT INTO admin SET ";
				if(!empty($insert_profile))	
				{
				 $insert_profile .="login_name = '".$aRequest['fUserName']."'";
				 $insert_profile .=",password= '".$aRequest['fPassword']."'";
				 $insert_profile .=",company_name= '".$aRequest['fCompanyName']."'";
				 $insert_profile .=",address1= '".$aRequest['fAddress1']."'";
				 $insert_profile .=",address2= '".$aRequest['fAddress2']."'";
			 	 $insert_profile .=",city= '".$aRequest['City']."'";
			 	 $insert_profile .=",state= '".$aRequest['State']."'";
				 $insert_profile .=",country= '".$aRequest['Country']."'";
				 $insert_profile .=",zipCode= '".$aRequest['ZipCode']."'";
				 $insert_profile .=",telPhone1= '".$aRequest['fMobile1_1'].'-'.$aRequest['fMobile1_2'].'-'.$aRequest['fMobile1_3']."'";
				 $insert_profile .=",telPhone2= '".$aRequest['fMobile2_1'].'-'.$aRequest['fMobile2_2'].'-'.$aRequest['fMobile2_3']."'";
				 $insert_profile .=",telPhone3= '".$aRequest['fMobile3_1'].'-'.$aRequest['fMobile3_2'].'-'.$aRequest['fMobile3_3']."'";
				 $insert_profile .=",fax1= '".$aRequest['fFax1']."'";
				 $insert_profile .=",fax2= '".$aRequest['fFax2']."'";
				 $insert_profile .=",email= '".$aRequest['fEmailID']."'";
				 $insert_profile .=",created_date= '".$created_date."'";
				}
				
				if($this->oDb->query($insert_profile))
			  {
			   $inserted = 1;
			  }
			  return $inserted;				 
			}
	
	
	public function insertTeamInfo($aRequest,$files)
	{
	//print_r($files);
	    $inserted = 0;
		/*$aTeaminfo = array();
		$aTeaminfo['fTeamName'] = $aRequest['fTeamName'];
		$aTeaminfo['fTeamCountry'] = $aRequest['fTeamCountry'];
		$aTeaminfo['fTeamDescription'] = $aRequest['fTeamDescription'];*/
		$created_date = date('Y-m-d H:i:s');
		//print_r($aTeaminfo);
		$insert_team = "INSERT INTO tks_team SET ";
			if(!empty($insert_team))
			{
			  $insert_team .=" team_name= '".$aRequest['fTeamName']."'";
			  $insert_team .=", team_country= '".$aRequest['fTeamCountry']."'";
			  $insert_team .=", team_description= '".$aRequest['fTeamDescription']."'";
			  $insert_team .=", created_date= '".$created_date."'";
			}
			if($this->oDb->query($insert_team))
		    {
			$inserted = 1;
            }
		
		if(!empty($files['fTeamLogo']['name']))
		{
		   $fileName = $files['fTeamLogo']['name']; //echo '<br>';
		   $ext = explode(".", $fileName);
		   $ext = array_pop($ext);
		   $newFileName = 'logo.'.$ext;
		   $fileup = $files['fTeamLogo']['tmp_name']; //echo '<br>';
		   $targetPath 	= APP_ROOT."/admin/images/uploads/"; //echo '<br>';
		   $team_id = mysql_insert_id(); //echo '<br>';
		   $targetFileName = "team".$team_id."_".$newFileName; //echo '<br>';
		   move_uploaded_file($fileup, $targetPath.$targetFileName);
		   //update database.
		   $query = "UPDATE tks_team SET team_logo1 = '".$targetFileName."' WHERE team_id = ".$team_id;
		   if($this->oDb->query($query))
		   {
			 $valid = true;
		   }	 
			return $valid;
		}
		return $inserted;
	}
	 public function insertStadiumInfo($aRequest,$files)
	  {
	//print_r($aRequest);
	   $inserted = 0;
	 /*  $aStadiuminfo = array();
	   $aStadiuminfo['fStadiumName'] = $aRequest['fStadiumName'];
	   $aStadiuminfo['fStadiumCountry'] = $aRequest['fStadiumCountry'];
	   $aStadiuminfo['fStadiumDescription'] = $aRequest['fStadiumDescription'];*/
	   $created_date = date('Y-m-d H:i:s');
	   $insert_stadium = "INSERT INTO tks_stadium SET ";
			if(!empty($insert_stadium))
			{
			  $insert_stadium .=" stadium_name = '".$aRequest['fStadiumName']."'";
			  $insert_stadium .=", stadium_country = '".$aRequest['fStadiumCountry']."'";
			  $insert_stadium .=", stadium_description = '".$aRequest['fStadiumDescription']."'";
			  $insert_stadium .=", created_date = '".$created_date."'";
			 
			}
		//print_r($aStadiuminfo);
     if($this->oDb->query($insert_stadium))
		{
			$inserted = 1;
		}
		
		if(!empty($files['fStadiumLogo']['name']))
		{
		   $fileName = $files['fStadiumLogo']['name']; //echo '<br>';
		   $ext = explode(".", $fileName);
		   $ext = array_pop($ext);
		   $newFileName = 'logo.'.$ext;
		   $fileup = $files['fStadiumLogo']['tmp_name']; //echo '<br>';
		   $targetPath 	= APP_ROOT."/admin/images/uploads/"; //echo '<br>';
		   $stadium_id = mysql_insert_id(); //echo '<br>';
		   $targetFileName = "stadium".$stadium_id."_".$newFileName; //echo '<br>';
		   move_uploaded_file($fileup, $targetPath.$targetFileName);
		   //update database.
		   $query = "UPDATE tks_stadium SET stadium_image = '".$targetFileName."' WHERE stadium_id = ".$stadium_id;
		   if($this->oDb->query($query))
		   {
			 $valid = true;
		   }	 
			return $valid;
		}
		return $inserted;
	  }
	  public function insertSectionInfo($aRequest)
	  {
	//print_r($aRequest);
	   $inserted = 0;
	   $created_date = date('Y-m-d H:i:s');
	   $insert_section = "INSERT INTO tks_stadium_section SET ";
			if(!empty($insert_section))
			{
			  $insert_section .=" stadium_id = '".$aRequest['fStadiumid']."'";
			  $insert_section .=", stadium_sectname = '".$aRequest['fStsectionName']."'";
			  $insert_section .=", stadium_sectdesc = '".$aRequest['fStsectionDescription']."'";
			  $insert_section .=", stadium_section_seats = '".$aRequest['fStseatCount']."'";
			  $insert_section .=", created_date = '".$created_date."'";
			}
			
	 
     if($this->oDb->query($insert_section))
		{
			$inserted = 1;
		}
		return $inserted;
	  }
		public function insertMatchInfo($aRequest,$files)
	   {
	    $inserted = 0;
	    $created_date = date('Y-m-d H:i:s');
		$insert_match = "INSERT INTO tks_match SET ";
			if(!empty($insert_match))
			{
			  $insert_match .= " stadium_id = '".$aRequest['fMStadiumid']."'";
			  $insert_match .=", match_name = '".$aRequest['fMatchName']."'";
			   $insert_match .=", match_type = '".$aRequest['fMatchType']."'";
			  $insert_match .=", team1_id = '".$aRequest['fTeam1id']."'";
			  $insert_match .=", team2_id = '".$aRequest['fTeam2id']."'";
			  $insert_match .=", match_date = '".$aRequest['fMatchDate']."'";
			  $insert_match .=", mstart_time = '".$aRequest['fMatchStartTime']."'";
			  $insert_match .=", registration_closedate = '".$aRequest['fMatchRegEndDate']."'";
			  $insert_match .=", match_created = '".$created_date."'";
			}
			if($this->oDb->query($insert_match))
			  {
			   $inserted = 1;
			  }
			  
		 if(!empty($files['fMatchLogo']['name']))
		   {
			   $fileName = $files['fMatchLogo']['name']; //echo '<br>';
			   $ext = explode(".", $fileName);
			   $ext = array_pop($ext);
			   $newFileName = 'logo.'.$ext;
			   $fileup = $files['fMatchLogo']['tmp_name']; //echo '<br>';
			   $targetPath 	= APP_ROOT."/admin/images/uploads/"; //echo '<br>';
			   $match_id = mysql_insert_id(); //echo '<br>';
			   $targetFileName = "match".$match_id."_".$newFileName; //echo '<br>';
			   move_uploaded_file($fileup, $targetPath.$targetFileName);
			   //update database.
			   $query = "UPDATE tks_match SET match_logo = '".$targetFileName."' WHERE match_id = ".$match_id;
			   if($this->oDb->query($query))
			   {
				 $valid = true;
			   }	 
				return $valid;
		   }
		return $inserted;
	  }
	
   public function getAllStadiumInfo()
	   {
		// returns the dealer profile info as an array.
		$aStadiuminfo = array();
		$query = "SELECT * FROM tks_stadium";
		if($results = $this->oDb->get_results($query))
		{
		   
			foreach($results as $row)
			{
			    $astadium = array();
				$astadium['stadium_id'] = $row->stadium_id;
				$astadium['stadium_name'] = $row->stadium_name;
				$astadium['stadium_country'] = $row->stadium_country;
				$astadium['stadium_description'] = $row->stadium_description;
				$astadium['created_date'] = $row->created_date;
				$astadium['status'] = $row->status;
				$aStadiuminfo[] = $astadium;
		   }	
		}
		return $aStadiuminfo;
		
	}//end getAllStadiumInfo()
	   public function getAllTeamInfo()
	   {
		// returns the dealer profile info as an array.
		$aTeaminfo = array();
		$query = "SELECT * FROM tks_team";
		if($results = $this->oDb->get_results($query))
		{
		   
			foreach($results as $row)
			{
			    $aTeam = array();
				$aTeam['team_id'] = $row->team_id;
				$aTeam['team_name'] = $row->team_name;
				$aTeam['team_country'] = $row->team_country;
				$aTeam['team_description'] = $row->team_description;
				$aTeam['team_logo1'] = $row->team_logo1;
				$aTeam['created_date'] = $row->created_date;
				$aTeam['status'] = $row->status;
				$aTeaminfo[] = $aTeam;
		   }	
		}
		return $aTeaminfo;
		
	}//end getAllTeamInfo()
	
	
	public function getMatchStatus($matchStatusId)
	{
		$openTag1 = '<span class="colorlabel important">'; $closeTag = '</span>';
		$openTag2 = '<span class="colorlabel success">';
		$openTag3 = '<span class="colorlabel closed">';
		$openTag4 = '<span class="colorlabel cancelled">';
		$status = '';
		if($matchStatusId == 0)
		{
		  $status = $openTag1.'Not Enabled'.$closeTag;
		}
		else if($matchStatusId == 1)
		{
		  $status = $openTag2.'Open'.$closeTag;
		}
		else if($matchStatusId == 2)
		{
		  $status = $openTag3.'Closed'.$closeTag;
		}
		else if($matchStatusId == 3)
		{
          $status = $openTag4.'Cancelled'.$closeTag;
		}
		return $status;
	}
	public function getMatchStatusList()
	{
		$aStatus = array();
		$aStatus[0] = 'Not Enabled';
		$aStatus[1] = 'Open';
		$aStatus[2] = 'Closed';
		$aStatus[3] = 'Cancelled';
		return $aStatus;
		
	}
	public function getMatchList($offset='', $rowsPerPage='', $field='', $sort='')
	   {
        $condition = ''; $limit = ''; $orderBy = '';
		
		if(!empty($rowsPerPage))
		{
			$limit 	= "LIMIT $offset, $rowsPerPage";
		}
		if(!empty($field))
		{
			$orderBy = "ORDER BY ".$field." ".$sort." ";
		}
		else $orderBy = "ORDER BY match_created DESC";	
		
		$aMatchList = array();
		
		$query = "SELECT match_id,stadium_id,match_name,match_type,team1_id,team2_id,match_logo,match_date,DATE_FORMAT(match_date, '%D %b, %Y ') as matchdate,mstart_time,registration_closedate,DATE_FORMAT(registration_closedate, '%D %b, %Y %r') as regcloseDate,match_created,DATE_FORMAT(match_created, '%D %b, %Y %r') as createdDate,match_status FROM tks_match $condition $orderBy $limit";
		
		if($results = $this->oDb->get_results($query))
		{
			foreach($results as $row)
			{
			    $aMatch = array();
				$aMatch['match_id'] = $row->match_id;
				$aMatch['stadium_id'] = $row->stadium_id;
				$aMatch['match_name'] = $row->match_name;
				$aMatch['match_type'] = $row->match_type;
				$aMatch['team1_id'] = $row->team1_id;
				$aMatch['team2_id'] = $row->team2_id;
				$aMatch['match_logo'] = $row->match_logo;
				$aMatch['match_date'] = $row->matchdate;
				$aMatch['mstart_time'] = $row->mstart_time;
				$aMatch['regcloseDate'] = $row->regcloseDate;
				$aMatch['createdDate'] = $row->createdDate;
				$aMatch['match_status_id'] = $row->match_status;
				$aMatch['match_status'] = $this->getMatchStatus($aMatch['match_status_id']);
				$aMatchList[] = $aMatch;
		   }	
		}
		return $aMatchList;
		
	}//end getMatchList()
		
	
	public function getMatchInfo($matchId)
		{
	        $aMatchInfo = array();
		    $query = "SELECT *  FROM tks_match WHERE match_id=".$matchId;
            if($row = $this->oDb->get_row($query))
		     {
				$aMatchInfo['match_id'] = $row->match_id;
				$aMatchInfo['stadium_id'] = $row->stadium_id;
				$aMatchInfo['match_name'] = $row->match_name;
				$aMatchInfo['match_type'] = $row->match_type;
				$aMatchInfo['team1_id'] = $row->team1_id;
				$aMatchInfo['team2_id'] = $row->team2_id;
				$aMatchInfo['match_logo'] = $row->match_logo;
				$aMatchInfo['match_date'] = $row->match_date;
				$aMatchInfo['mstart_time'] = $row->mstart_time;
				$aMatchInfo['registration_closedate'] = $row->registration_closedate;
				$aMatchInfo['match_created'] = $row->match_created;
				$aMatchInfo['match_status_id'] = $row->match_status;
				$aMatchInfo['match_status'] = $this->getMatchStatus($aMatchInfo['match_status_id']);
		     }	
	
	return $aMatchInfo;
		
	}//end getMatchInfo()
	  public function getTeamInfoById($team_id)
	   {
		// returns the dealer profile info as an array.
		$aTeaminfo = array();
		$query = "SELECT * FROM tks_team WHERE team_id=".$team_id;
		if($row = $this->oDb->get_row($query))
		{
			   	$aTeaminfo['team_id'] = $row->team_id;
				$aTeaminfo['team_name'] = $row->team_name;
				$aTeaminfo['team_country'] = $row->team_country;
				$aTeaminfo['team_description'] = $row->team_description;
				$aTeaminfo['team_logo1'] = $row->team_logo1;
				$aTeaminfo['created_date'] = $row->created_date;
				$aTeaminfo['status'] = $row->status;
     	}
		return $aTeaminfo;
		
	}//end getTeamInfoById()
	public function getSectionInfoByStadiumId($stadium_id)
	   {
		// returns the dealer profile info as an array.
		$aSectioninfo = array();
		$query = "SELECT * FROM tks_stadium_section WHERE stadium_id=".$stadium_id;
		if($results = $this->oDb->get_results($query))
		{
		   foreach($results as $row)
		   {
		       $asectinfo = array();
			   	$asectinfo['stadium_sectionid'] = $row->stadium_sectionid;
				$asectinfo['stadium_id'] = $row->stadium_id;
				$asectinfo['stadium_sectname'] = $row->stadium_sectname;
				$asectinfo['stadium_sectdesc'] = $row->stadium_sectdesc;
				$asectinfo['stadium_section_seats'] = $row->stadium_section_seats;
				$asectinfo['created_date'] = $row->created_date;
				$asectinfo['status'] = $row->status;
				$aSectioninfo[] = $asectinfo;
     	  }
	} 
		return $aSectioninfo;
		
	}//end getSectionInfoByStadiumId()
	  public function getTeamNameById($team_id)
	   {
		// returns the dealer profile info as an array.
		$query = "SELECT team_name FROM tks_team WHERE team_id=".$team_id;
		if($row = $this->oDb->get_row($query))
		{
			  $teamName = $row->team_name;
				
       }
		return $teamName;
		
	}//end getTeamNameById()
		  public function getStadiumNameById($stadium_id)
	   {
		// returns the dealer profile info as an array.
		$query = "SELECT stadium_name FROM tks_stadium WHERE stadium_id=".$stadium_id;
		if($row = $this->oDb->get_row($query))
		{
			  $stadiumName = $row->stadium_name;
				
       }
		return $stadiumName;
		
	}//end getStadiumNameById()
	
	public function updateStatus($aRequest)
	{
	  $updated =0;
	  $update_status = "UPDATE tks_match SET";
	    if(!empty($update_status))
			{
			  $update_status .= " match_status = '".$aRequest['updateMatchstatus']."'";
			}
	  $condition = " WHERE match_id =".$aRequest['status_matchid'];
	  $update_status .= $condition;
	  if($this->oDb->query($update_status))
			  {
			   $updated = 1;
			  }
			  return $updated;
	}
	public function getTicketAmount($match_id,$stadium_id,$section_id)
	{
	  $query = "SELECT * FROM tks_ticket_amount WHERE match_id ='".$match_id."'AND stadium_id='".$stadium_id."' AND stadium_sectionid ='".$section_id."'";
	  if($Amtresults = $this->oDb->get_row($query))
	   {
	        $aTicketAmt = array();
			$aTicketAmt['id'] = $Amtresults->id;
		    $aTicketAmt['match_id'] = $Amtresults->match_id;
		    $aTicketAmt['stadium_id'] = $Amtresults->stadium_id;
			$aTicketAmt['sectionid'] = $Amtresults->stadium_sectionid;
			$aTicketAmt['amount'] = $Amtresults->amount;
			$aTicketAmt['amount_added_date'] = $Amtresults->amount_added_date;
		    $aTicketAmt['status'] = $Amtresults->status;
	   }
	   return $aTicketAmt;
	}
	public function updatematchlist($aRequest,$files)
	{
	 $updated =0;
	 //echo $matid;

	
	 $update_status = "UPDATE tks_match SET";
	    if(!empty($update_status))
			{
			  $update_status .= " match_name = '".$aRequest['fMatchName']."'," 
			                   ." match_type = '".$aRequest['fMatchType']."',"
							   ." team1_id = '".$aRequest['fTeam1id']."',"
							   ." team2_id = '".$aRequest['fTeam2id']."',"
							   ." match_date = '".$aRequest['fMatchDate']."',"
							   ." match_date = '".$aRequest['fMatchDate']."',"
							   ." mstart_time = '".$aRequest['fMatchStartTime']."',"
							   ." registration_closedate = '".$aRequest['fMatchRegEndDate']."',"
							   ." match_status = '".$aRequest['updateMatchstatus']."'";
			}
	  $condition = " WHERE match_id =".$aRequest['fmatchId'];
	  $update_status .= $condition;

	  if($this->oDb->query($update_status))
			  {
			   $updated = 1;
			  }

		if(!empty($files['fMatchLogo']['name']))
		   {
			   $fileName = $files['fMatchLogo']['name']; //echo '<br>';
			   $ext = explode(".", $fileName);
			   $ext = array_pop($ext);
			   $newFileName = 'logo.'.$ext;
			   $fileup = $files['fMatchLogo']['tmp_name']; //echo '<br>';
			   $targetPath 	= APP_ROOT."/admin/images/uploads/"; //echo '<br>';
			   $match_id = $aRequest['fmatchId']; //echo '<br>';
			   $targetFileName = "match".$match_id."_".$newFileName; //echo '<br>';
			   move_uploaded_file($fileup, $targetPath.$targetFileName);
			   //update database.
			   $query = "UPDATE tks_match SET match_logo = '".$targetFileName."' WHERE match_id = ".$match_id;
			   if($this->oDb->query($query))
			   {
				 $valid = true;
			   }	 
				return $valid;
		   }
	return $updated;
	}
	
	/***Divya***/
	public function getProfileInfo()
		{
	        $aProfileInfo = array();
		    $query = "SELECT *  FROM admin WHERE status=1" ;
            if($row = $this->oDb->get_results($query))
		     {
			 foreach($row as $res)
			 {
			 $aProInfo = array();
				$aProInfo['login_name'] = $res->login_name;
				$aProInfo['password'] = $res->password;
				$aProInfo['company_name'] = $res->company_name;
				$aProInfo['address1'] = $res->address1;
				$aProInfo['address2'] = $res->address2;
				$aProInfo['city'] = $res->city;
				$aProInfo['state'] = $res->state;
				$aProInfo['country'] = $res->country;
				$aProInfo['zipCode'] = $res->zipCode;
				$aProInfo['telPhone1'] = $res->telPhone1;
				$aProInfo['telPhone2'] = $res->telPhone2;
				$aProInfo['telPhone3'] = $res->telPhone3;
				$aProInfo['fax1'] = $res->fax1;
				$aProInfo['fax2'] = $res->fax2;
				$aProInfo['email'] = $res->email;
				$aProInfo['created_date'] = $res->created_date;
				$aProInfo['status'] = $res->status;
				$aProfileInfo[] = $aProInfo;
				
			}
		     }	
			 //print_r($aProfileInfo);	
	return $aProfileInfo[0];
	}
	
	
	public function getProfileInfoByName($user_name)
	   {
		// returns the profile info as an array.
		$aAdminproinfo = array();
		//print_r($user_name);
		$query = "SELECT * FROM admin WHERE login_name='".$user_name."'";
		if($row = $this->oDb->get_row($query))
		{
    		   	$aAdminproinfo['user_name'] = $row->login_name;
			 	$aAdminproinfo['password'] = $row->password;
				$aAdminproinfo['company_name'] = $row->company_name;
				$aAdminproinfo['address1'] = $row->address1;
				$aAdminproinfo['address2'] = $row->address2;
				$aAdminproinfo['city'] = $row->city;
				$aAdminproinfo['state'] = $row->state;
				$aAdminproinfo['country'] = $row->country;
				$aAdminproinfo['zipCode'] = $row->zipCode;
				
				
				
				$aAdminproinfo['telPhone1'] = $row->telPhone1;
					$phone1 = $row->telPhone1;
					$aPhone1 = explode('-',$phone1);
					$aAdminproinfo['fMobile1_1'] = $aPhone1[0];
					$aAdminproinfo['fMobile1_2'] = $aPhone1[1];
					$aAdminproinfo['fMobile1_3'] = $aPhone1[2];
				
				
				$aAdminproinfo['telPhone2'] = $row->telPhone2;
						$phone2 = $row->telPhone2;
						$aPhone2 = explode('-',$phone2);
						$aAdminproinfo['fMobile2_1'] = $aPhone1[0];
						$aAdminproinfo['fMobile2_2'] = $aPhone1[1];
						$aAdminproinfo['fMobile2_3'] = $aPhone1[2];
			
			
			
				$aAdminproinfo['telPhone3'] = $row->telPhone3;
						$phone3 = $row->telPhone3;
						$aPhone3 = explode('-',$phone3);
						$aAdminproinfo['fMobile3_1'] = $aPhone1[0];
						$aAdminproinfo['fMobile3_2'] = $aPhone1[1];
						$aAdminproinfo['fMobile3_3'] = $aPhone1[2];
			
				$aAdminproinfo['fax1'] = $row->fax1;
				$aAdminproinfo['fax2'] = $row->fax2;
				$aAdminproinfo['email'] = $row->email;
				
			  
				
       }
	  //print_r($aAdminproinfo);
		return $aAdminproinfo;
		}

	
	public function updateProfileInfo($aRequest,$user_name)
	{
		$updated = 0;
		$updated_date = date('Y-m-d H:i:s');
		$update_profile = "UPDATE admin SET ";
		if(!empty($update_profile))	
				{
				 $update_profile .="login_name= '".$aRequest['fUpdateUserId']."'";
				 if(!empty($aRequest['fUpdateNewPassword']))
				 {
				 $update_profile .=",password= '".$aRequest['fUpdateNewPassword']."'";
				 }else
				 {
                 $update_profile .=",password= '".$aRequest['fUpdatePassword']."'";
 				 }
				 $update_profile .=",company_name= '".$aRequest['fUpdateCompanyName']."'";
				 $update_profile .=",address1= '".$aRequest['fUpdateAddress1']."'";
				 $update_profile .=",address2= '".$aRequest['fUpdateAddress2']."'";
			 	 $update_profile .=",city= '".$aRequest['UpdateCity']."'";
			 	 $update_profile .=",state= '".$aRequest['UpdateState']."'";
				 $update_profile .=",country= '".$aRequest['UpdateCountry']."'";
				 $update_profile .=",zipCode= '".$aRequest['UpdateZipCode']."'";
				 $update_profile .=",telPhone1= '".$aRequest['fUpdateMobile1_1'].'-'.$aRequest['fUpdateMobile1_2'].'-'.$aRequest['fUpdateMobile1_3']."'";
				 $update_profile .=",telPhone2= '".$aRequest['fUpdateMobile2_1'].'-'.$aRequest['fUpdateMobile2_2'].'-'.$aRequest['fUpdateMobile2_3']."'";
				 $update_profile .=",telPhone3= '".$aRequest['fUpdateMobile3_1'].'-'.$aRequest['fUpdateMobile3_2'].'-'.$aRequest['fUpdateMobile3_3']."'";
				 $update_profile .=",fax1= '".$aRequest['fUpdateFax1']."'";
				 $update_profile .=",fax2= '".$aRequest['fUpdateFax2']."'";
				 $update_profile .=",email= '".$aRequest['fUpdateEmailID']."'";
				 $update_profile .=",created_date= '".$updated_date."'";
 				 

				}
		
		$whereCondition = " WHERE login_name='".$user_name."'";
		
		$qry = $update_profile.$whereCondition;
		if($this->oDb->query($qry))
		{
			$updated = 1;
		}
		return $updated;
}
	
}