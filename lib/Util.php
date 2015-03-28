<?php
class Util
{

	public $symbols = array('/','\\','\'','"',',','.','<','>','?',';',':','[',']','{','}','|','=','+','-','_',')','(','*','&','^','%','$','#','@','!','~','`'	);

	function __construct()
	{
		//$this->oSession = &Singleton::getInstance('SessionController');
	}
	public function cleanthis($str)
	{
		$str = $this->cleanInput($str);
		return $str;
	}

	public function cleanInput($aInput)
	{

		$search = array(
		"@<script[^>]*?>.*?</script>@si",   // Strip out javascript
		"@<[\/\!]*?[^<>]*?>@si",            // Strip out HTML tags
		"@<style[^>]*?>.*?</style>@siU",    // Strip style tags properly
		"@<![\s\S]*?�[ \t\n\r]*>@"         // Strip multi-line comments
		);

	//	$aInput = $this->removeSymbols($aInput);

		$aOutput = stripslashes(preg_replace($search, "", $aInput));
		return trim($aOutput);
	}

	public function sanitize($aInput)
	{
		if (is_array($aInput))
		{
			foreach($aInput as $var=>$val)
			{
				$aOutput[$var] = $this->sanitize($val);
			}
		}
		else
		{
			if (get_magic_quotes_gpc())
			{
				$aInput = stripslashes($aInput);
			}
			$aInput  = $this->cleanInput($aInput);
			$aOutput = mysql_escape_string($aInput);
		}
		return $aOutput;
	}


	function removeSymbols($string)
	{
		$noOfSymbols = sizeof($this->symbols);

		for ($i = 0; $i < $noOfSymbols ; $i++) {
			$string = str_replace($this->symbols[$i],' ',$string);
		}
		return $string;
	}

	public function check_int($value)
	{
		if(is_numeric($value))
		{
			return (int)$value;
		}
		else
		{
			return false;
		}
	}

	public function strip_alltags($value)
	{
		$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
						   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
						   '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
						   '@<![\s\S]*?--[ \t\n\r]*>@'        // Strip multi-line comments including CDATA
		);
		$text = preg_replace($search, '', $value);
		return stripslashes($text);
	}

	public function clearXSS($value)
	{
		$val = ereg_replace("~<script[^>]*>.+</script[^>]*>~isU", "", strip_alltags(rawurldecode($value)));
		return(ereg_replace(")","",$val));
	}


	public function getRemoteAddress()
	{
		$aHost = array();
		if (getenv(HTTP_X_FORWARDED_FOR))
		{
		$aHost = array ('ip'   => getenv('HTTP_X_FORWARD_FOR'),
				'host' => gethostbyaddr(getenv('HTTP_X_FORWARD_FOR'))
				);
		}
		else
		{
			$aHost = array ('ip'   => getenv('REMOTE_ADDR'),
					'host' => gethostbyaddr(getenv('REMOTE_ADDR'))
					);
			}
		return $aHost;
	}


	public function nameDisplay($str)
	{
		$line="";
		$tStr = trim($str);
		if(!empty($tStr))
		{
			$words=explode(" ",$tStr);
			for($i=0;$i<count($words);$i++)
			{
				if(!empty($words[$i]))
					$line.= ucfirst(strtolower($words[$i]))." ";
			}
		}
		return trim($line);
	}


	public function ordStatus($Status)
	{
		switch ($Status)
		{
			case 1:
				$ST = "A";
				break;
			case 2:
				$ST = "P";
				break;
			case 3:
				$ST = "O";
				break;
			case 4:
				$ST = "B";
				break;
			case 5:
				$ST = "C";
				break;
			case 6:
				$ST = "F";
				break;
			case 7:
				$ST = "I";
				break;
			default:
				$ST = "?";
		}
		return $ST;
	}



	public function maritalStatus($mstatus)
	{
		switch ($mstatus)
			{
			case 1:
				$ST = "Single";
				break;
			case 2:
				$ST = "Married";
				break;
			case 3:
				$ST = "Widowed";
				break;
			case 4:
				$ST = "Divorced";
				break;
			case 5:
				$ST = "Legally Separated";
				break;
			default:
				$ST = " ";
		 }
			 return $ST;
	}

	public function getOrdStatus($Status)
	{
		switch ($Status)
		   {
			case 1:
				$ST = "Active";
				break;
			case 2:
				$ST = "Pending";
				break;
			case 3:
				$ST = "Overdue";
				break;
			case 4:
				$ST = "Bad";
				break;
			case 5:
				$ST = "Cancel";
				break;
			case 6:
				$ST = "Completed";
				break;
			case 7:
				$ST = "New";
				break;
			case 8:
				$ST = "Domain Released";
				break;
			case 9:
				$ST = "Trial";
				break;
			case 10:
				$ST = "Trial-Overdue";
				break;
			case 11:
				$ST = "Trial-Cancel";
				break;
			case 0:
				$ST = "Free";
				break;
			default:
				$ST = "?";
		 }
			 return $ST;
	}


	public function getProductStatus($statusId)
	{
		$status = "";
		switch ($statusId)
			{
			case 0:
				$status = "Disable";
				break;
			case 1:
				$status = "Active";
				break;
			case 2:
				$status = "Discontinue";
				break;
			default:
				$status = "Disable";
		 }
			 return $status;
	}


	public function payType($param)
	{
		if($param == 1)
		   return "Credit Card";
		else
		   return "Check Draft";
	}

	public function paymode($param)
	{
		 if($param == 0)
			return "One Time";
		 else if($param == 1)
			return "Monthly";
		 else if($param == 3)
			return "Quartely";
		 else if($param == 6)
			return "Semi";
		 else if($param == 12)
			return "Anually";
	}

	public function cardtype($param)
	{
		if($param == "V")
			return "<img src='".IMAGE_PATH."/visa.gif'>&nbsp;&nbsp;&nbsp;Visa";
		else if($param == "M")
			return "<img src='".IMAGE_PATH."/mastercard.gif'>&nbsp;&nbsp;Master Card";
		else if($param == "D")
			return "<img src='".IMAGE_PATH."/discover.gif'>&nbsp;&nbsp;Discoverer";
		else if($param == "A")
			return "<img src='".IMAGE_PATH."/amex.gif'>&nbsp;&nbsp;American Express";
	}

	public function doctype($param)
	{
		if($param == 0)
			return "<img src='".IMAGE_PATH."/jpg_icon.gif' border='0'>";
		else if($param == 1)
			return "<img src='".IMAGE_PATH."/gif_icon.gif' border='0'>";
		else if($param == 2)
			return "<img src='".IMAGE_PATH."/doc_icon.gif' border='0'>";
		else if($param == 3)
			return "<img src='".IMAGE_PATH."/tif_icon.gif' border='0'>";
		else if($param == 4)
			return "<img src='".IMAGE_PATH."/pdf_icon.gif' border='0'>";
		else if($param == 5)
			return "<img src='".IMAGE_PATH."/txt_icon.gif' border='0'>";
		else
			return "<img src='".IMAGE_PATH."/alt.gif' border='0'>";
	}

	public function status($param)
	{
	   if($param == 1)
		  return "<img src='".IMAGE_PATH."/active.gif'>";
	   else if($param == 0)
		 return "<img src='".IMAGE_PATH."/deactive.gif'>";
	}

	public function orderType($param)
	{
		 if($param == 1)
			return "Active";
		 else if($param == 2)
			return "Pending";
		 else if($param == 3)
			return "Overdue";
		 else if($param == 4)
			return "Incomplete";
		 else if($param == 5)
			return "Cancelled";
		 else if($param == 6)
			return "Completed";
		 else if($param == 7)
			return "New";
		 else if($param == 8)
			return "In Progress";
	}

	public function ssnSplit($param)
	{
		if(!empty($param))
			return substr($param,0,3)."-".substr($param,3,2)."-".substr($param,5,4);
		else
			return "";
	}


	public function phoneSplit($param)
	{
		if(!empty($param))
			return substr($param,0,3)."-".substr($param,3,3)."-".substr($param,6,5);
		else
			return "";
	}

	public function dateSplit($param)
	{
		if($param == "0000-00-00" || $param == NULL)
			return "";
		else
		{
			$yr 	= substr($param,0,4);
			$mon 	= substr($param,5,2);
			$day 	= substr($param,8,2);
		}
		return $mon."-".$day."-".$yr;
	}

	public function payUsedFor1($type)
	{
		switch ($type)
		{
			case 'A';
				$Ty = "All Charges";
				break;
			case 'I';
				$Ty = "Initial Charge Only";
				break;
			case 'F';
				$Ty = "Future Charges Only";
				break;
		}
		return $Ty;
	}

	public function acctType($type)
	{
		switch ($type)
		{
			case "I";
				$Ty = "Individual";
				break;
			case "B";
				$Ty = "Business";
				break;
		}
		return $Ty;
	}

	public function CCType($type)
	{
		$Ty = "";
		switch ($type)
		{
			case "V";
				$Ty = "VISA";
				break;
			case "A";
				$Ty = "American Express";
				break;
			case "M";
				$Ty = "Master Card";
				break;
			case "D";
				$Ty = "Discover";
				break;
		}
		return $Ty;
	}

	public function ccSplit($param)
	{
		if(!empty($param))
			return substr($param,0,4)."-".substr($param,4,4)."-".substr($param,8,4)."-".substr($param,12,4);
		else
			return "";
	}

	public function nonechk($param)
	{
		if(!empty($param))
			return $param;
		else
			return "<i>none</i>";
	}

	public function rowColor($i)
	{
		$bg1 = '#f8f3e8';
	    $bg2 = '#f1e7d1';
		if($i%2)
		   return $bg1;
		else
		  return $bg2;
	}

	public function changeCellBackground($param,$param1)
	{
		if((empty($param) || $param == "0000-00-00") && ($param1 == "m"))
			return "#FFFFCA";
		else
			return "#C0C0C0";
	}

	public function findStart($limit,$page)
	{
		 if ((!isset($page)) || ($page == "1"))
		 {
			 $start = 0;
			 $page = 1;
		 }
		 else
		 {
		 	$start = ($page-1) * $limit;
		 }
		return $start;
	}

	public function findPages($count, $limit)
	{
		 $pages = (($count % $limit) == 0) ? $count / $limit : floor($count / $limit) + 1;
		 return $pages;
	}

	public function pageList($curpage, $pages, $sortby)
	{
		 $page_list  = "";
		 /* Print the first and previous page links if necessary */
		 if (($curpage != 1) && ($curpage))
		 {
			 $page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?page=1&t_sortBy=".$sortby."\" title=\"First Page\">�</a> ";
		 }

		 if (($curpage-1) > 0)
		 {
			 $page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage-1)."&t_sortBy=".$sortby."\" title=\"Previous Page\"><</a> ";
		 }

		 /* Print the numeric page list; make the current page unlinked and bold */
		 for ($i=1; $i<=$pages; $i++)
		 {
			 if ($i == $curpage)
			 {
				 $page_list .= "<b>".$i."</b>";
			 }
			 else
			 {
				 $page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".$i."&t_sortBy=".$sortby."\" title=\"Page ".$i."\">".$i."</a>";
			 }
			 $page_list .= " ";
		 }

		 /* Print the Next and Last page links if necessary */
		 if (($curpage+1) <= $pages)
		 {
		 	$page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage+1)."&t_sortBy=".$sortby."\" title=\"Next Page\">></a> ";
		 }

		 if (($curpage != $pages) && ($pages != 0))
		 {
			 $page_list .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".$pages."&t_sortBy=".$sortby."\" title=\"Last Page\">�</a> ";
		 }
		 $page_list .= "</td>\n";

		 return $page_list;
	}

	public function nextPrev($url, $curpage, $pages, $sortby)
	{
		$next_prev  = "";
		if (($curpage-1) <= 0)
		{
			$next_prev .= "Previous";
		}
		else
		{
			$next_prev .= "<a href=\"".$url."&page=".($curpage-1)."&t_sortBy=".$sortby."\">Previous</a>";
		}
		$next_prev .= " | ";
		if (($curpage+1) > $pages)
		{
			$next_prev .= "Next";
		}
		else
		{
			$next_prev .= "<a href=\"".$url."&page=".($curpage+1)."&t_sortBy=".$sortby."\">Next</a>";
		}
		return $next_prev;
	}

	public function randomPassword( $pass_len = 10 )
	{
		$allchar = "ABCDEFGHIJKLNMOPQRSTUVWXYZ" ;
		$str = "";
		mt_srand (( double) microtime() * 1000000 );
		for ( $i = 0; $i<$pass_len ; $i++ )
			$str .= substr( $allchar, mt_rand (0,25), 1 ) ;
		return $str;
	}

	public function SafeNumber($acctNum, $char = 'x', $numToShow = 4)
	{
	  // Return only part of the number
		  $acctNum1 = "";
		  if($numToShow < 4)
		  {
			  $numToShow = 4;
		  }
		  if($numToShow > 10)
		  {
			  $numToShow = 10;
		  }

		  $numToHide = (strlen($acctNum) - $numToShow);
		  for($i = 0; $i < $numToHide; $i++)
		  {
			  $acctNum1 .= $char;
		  }
		  $numToShow = $numToShow * (-1);
		  $acctNum1 .= substr($acctNum, $numToShow);

		  return $acctNum1;
	}



	public function getMonths($date1, $date2)
	{
		$time1  = strtotime($date1);
		$time2  = strtotime($date2);
		$my     = date('mY', $time2);

		$tmp 	= date('m-Y', $time1);
		$months[$tmp] = $tmp;
		$f      = '';

		while($time1 < $time2)
		{
			$time1 = strtotime((date('Y-m-d', $time1).' +15days'));
			if(date('F', $time1) != $f)
			{
				$f = date('F', $time1);
				if(date('mY', $time1) != $my && ($time1 < $time2))
				$tmp = date('m-Y', $time1);
				$months[$tmp] = $tmp;
			}
		}

		$tmp = date('m-Y', $time2);
		$months[$tmp] = $tmp;
		return $months;
	}

	public function cleanString($wild)
	{
		$str =  str_replace(',',' ',$wild);
		return strtoupper($str);
	}

	public function cleanString2($wild)
	{
		$str = ereg_replace('[^[:alnum:]+]',' ',$wild);
		return strtoupper(trim($str));
	}

	public function getDateComponent($date, $componentType)
	{
		$date = split('[/.-]', $date);
		switch ($componentType)
		{
			case 'month':
				return $date[0];
			case 'day':
				return $date[1];
			case 'year':
				return $date[2];
			default:
				return null;
		}
	}

	public function getStorageConvertor($pBytes, $pReturnType='auto')
	{

		$tRetrun = '';

		if ($pReturnType == 'auto') {

			if ($pBytes >= 1073741824) {
				$tSize = $pBytes/1073741824;
				$tUnit = 'GB';
			} else if ($pBytes >= 1048576) {
				$tSize = $pBytes/1048576;
				$tUnit = 'MB';
			} else if ($pBytes >= 1024) {
				$tSize = $pBytes/1024;
				$tUnit = 'KB';
			} else {
				$tSize = $pBtyes;
				$tUnit = 'BYTE';
			}

		} else {

			$tUnit = $pReturnType;

			if ($pReturnType == 'BYTE') {
				$tSize = $pBytes;
			} else if ($pReturnType == 'KB') {
				$tSize = ($pBytes/1024);
			} else if ($pReturnType == 'MB') {
				$tSize = ($pBytes/1048576);
			} else if ($pReturnType == 'GB') {
				$tSize = ($pBytes/1073741824);
			}
		}

		if ($tUnit == 'BYTE') {
			$tSize  . " $tUnit";
		} else {
			return ereg('^[[:digit:]]+$', $tSize)?$tSize  . " $tUnit" : sprintf("%01.2f", $tSize)  . " $tUnit";
		}
	}


	public function hms2min($timestamp)
	{
		$temp = explode(':', $timestamp);
		return  ( ($temp[0] * 3600) + ($temp[1] * 60) ) / 60;
	}

	public function min2hms ($min, $padHours = true)
	{

		$hms = "";
		$sec = $min * 60;
		$hours = intval(intval($sec) / 3600);

		$hms .= ($padHours) ? str_pad($hours, 2, "0", STR_PAD_LEFT). ':' : $hours. ':';

		$minutes = intval(($sec / 60) % 60);
		$hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';

		$seconds = intval($sec % 60);
		$hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
		return $hms;
	}


	//build the sql in clause depending on array passed in
	public function buildInClause($arrayIn, $useQuotes=true)
	{
		$inText = ($useQuotes) ? "('" : "(";
		for($i =0; $i < count($arrayIn); $i++)
		{
			if($i == 0)
			{
				$inText .= $arrayIn["$i"];
			}
			else
			{
				$inText .= ','.$arrayIn["$i"];
			}
		}
		$inText .= ($useQuotes) ? "')" : ")";

		return $inText;
	}

	public function getDollarFormat($amount)
	{
		$newAmount = "$". sprintf("%.2f", $amount);
		return $newAmount;
	}

	public function daysInMonth($month, $year)
	{
		// calculate number of days in a month
		$days = $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);

		$aDay = array();
		for ($i=1; $i<=$days; $i++) {
			$aDay[] = sprintf("%02d", $i);
		}

		return $aDay;
	}


	function totalDaysInMonth($pDate)
	{
		$aDate = explode('-', $pDate);

		$month = $aDate[1];
		$year  = $aDate[0];
		// calculate number of days in a month
		$days = $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);

		return $days;
	}

	public function getFulfillmentType($typeId)
	{
		$fulfillmentType = "";
		switch($typeId)
		{
			case 'N':
				$fulfillmentType = "Mail";
				break;
			case 'R':
				$fulfillmentType = "ReOrder";
				break;
			case 'E':
				$fulfillmentType = "Electronic";
				break;
		}
		return $fulfillmentType;
	}

	public function getVendorType($typeId)
	{
		$vendorType = "";
		switch($typeId)
		{
			case 'N':
				$vendorType = "New";
				break;
			case 'C':
				$vendorType = "Cancel";
				break;
			case 'R':
				$vendorType = "Reactivate";
				break;
			case 'U':
				$vendorType = "Update";
				break;
		}
		return $vendorType;
	}
	
	public function GeneratePassword()
	{
		// Create the meta-password
		$sMetaPassword = "";
	
		$CONFIG['security']['password_generator'] = array(
		"C" => array('characters' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 'minimum' => 6, 'maximum' => 6),
		"N" => array('characters' => '23456789', 'minimum' => 2, 'maximum' => 2)
		);
	
		$ahPasswordGenerator = $CONFIG['security']['password_generator'];
		foreach ($ahPasswordGenerator as $cToken => $ahPasswordSeed)
		{
			$sMetaPassword .= str_repeat($cToken, rand($ahPasswordSeed['minimum'], $ahPasswordSeed['maximum']));
		}
	
		$sMetaPassword = str_shuffle($sMetaPassword);
	
		// Create the real password
		$arBuffer = array();
		for ($i = 0; $i < strlen($sMetaPassword); $i ++)
		{
			$arBuffer[] = $ahPasswordGenerator[(string)$sMetaPassword[$i]]['characters'][rand(0, strlen($ahPasswordGenerator[$sMetaPassword[$i]]['characters']) - 1)];
		}
	
		return implode("", $arBuffer);
	}

	function htmlEmail($mailTo, $nameTo, $mailFrom, $nameFrom, $subject, $body, $attFile='')
	{
		$emailAddress = $nameTo . "<" . $mailTo . ">";
		
		if(!empty($attFile) || $attFile != '') {
	
			$fileAtt      = $attFile;
			$fileAttType = substr($attFile, strrpos($attFile, ".")+1,3);
			//$fileAttType = mime_content_type($attFile);
			$fileAttName = basename($attFile);
	
			$headers  = "From: ". $nameFrom . " <" . $mailFrom . ">\n";		
			$headers .= "Reply-To: ". $nameFrom . " <" . $mailFrom . ">\n";
			$headers .= "Return-Path: " . $mailFrom ."\n";	
			// $headers .= "Content-type: text/html;\n";
	
			$file = fopen($fileAtt,'rb');
			$data = fread($file,filesize($fileAtt));
			fclose($file);
	
			$semiRand = md5(time());
			$mimeBoundary = "{$semiRand}";
	
			$headers .= "MIME-Version: 1.0\n" .
			"Content-Type: multipart/mixed; boundary=\"{$mimeBoundary}\"\n\n";
	
			$body = "This is a multi-part message in MIME format.\n\n" .
			"--{$mimeBoundary}\n" .
			"Content-Type: text/html; charset=\"iso-8859-1\"\n" .
			"Content-Transfer-Encoding: 7bit\n\n" .
			$body . "\n\n";
	
			$data = chunk_split(base64_encode($data));
	
			$body .= "--{$mimeBoundary}\n" .
			"Content-Type: {$fileAttType}; name=\"{$fileAttName}\"\n" .
			"Content-Disposition: attachment; filename=\"{$fileAttName}\"\n" .
			"Content-Transfer-Encoding: base64\n\n" .
			$data . "\n\n" .
			"--{$mimeBoundary}--\n";
	
		} else {
			$headers  = "From: ". $nameFrom . " <" . $mailFrom . ">\n";		
			$headers .= "Reply-To: ". $nameFrom . " <" . $mailFrom . ">\n";
			$headers .= "Return-Path: " . $mailFrom ."\n";	
			$headers .= "Content-type: text/html;\n";
		}
		mail($emailAddress, $subject, $body, $headers);
	}

/*New car functions*/

	public function getAdditionalCarFeatures()
	{
		$__aCarFeatures = array('fFeatures1' => 'ABS (4-Wheel)', 
					  'fFeatures2' => 'Air Conditioning',
					  'fFeatures3' => 'Alloy Wheels',
					  'fFeatures4' => 'AM/FM Stereo',
					  'fFeatures5' => 'Bluetooth Wireless',
					  'fFeatures6' => 'Cassette',
					  'fFeatures7' => 'CD (Multi Disc)',
					  'fFeatures8' => 'CD (Single Disc)',
					  'fFeatures9' => 'Cruise Control',
					  'fFeatures10' => 'Dual Air Bags',
					  'fFeatures11' => 'Dual Power Seats',
					  'fFeatures12' => 'DVD System',
					  'fFeatures13' => 'JBL Premium Sound',
					  'fFeatures14' => 'Leather',
					  'fFeatures15' => 'Moon Roof',
					  'fFeatures16' => 'MP3 (Multi Disc)',
					  'fFeatures17' => 'MP3 (Single Disc)',
					  'fFeatures18' => 'Navigation System',
					  'fFeatures19' => 'Power Door Locks',
					  'fFeatures20' => 'Power Seat',
					  'fFeatures21' => 'Power Steering',
					  'fFeatures22' => 'Power Windows',
					  'fFeatures23' => 'Premium Wheels',
					  'fFeatures24' => 'Rear Spoiler',
					  'fFeatures25' => 'Side Air Bags',
					  'fFeatures26' => 'Special Edition',
					  'fFeatures27' => 'Stability Control',
					  'fFeatures28' => 'Sun Roof',
					  'fFeatures29' => 'Tilt Wheel',
					  'fFeatures30' => 'Traction Control',
					  'fFeatures31' => '',
					  'fFeatures32' => '',
					  'fFeatures33' => '',
					  'fFeatures34' => '',
					  'fFeatures35' => ''					  
					 );
			return $__aCarFeatures;		 
	}
	
	public function getColors()
	{
		$__aColors = array (
						'Beige',
						'Black',
						'Blue',
						'Brown',
						'Burgundy',
						'Champagne',
						'Charcoal',
						'Cream',
						'Gold',
						'Gray',
						'Green',
						'Maroon',
						'Off White',
						'Orange',
						'Pewter',
						'Pink',
						'Purple',
						'Red',
						'Silver',
						'Tan',
						'Teal',
						'Titanium',
						'Turquoise',
						'White',
						'Yellow',
						'Other' );
		return $__aColors;				
	}
	
	public function getTransmission()
	{
		$__aTransmission = array( 'Manual','Automatic','Automanual'	);
		return $__aTransmission;
	}
	
	public function getDoors()
	{
		$__aDoors = array('2','3','4','5','Others/Don\'t Know');
		return $__aDoors;
	}
	
	public function getEngineCylinders()
	{
		$__aEngineCylinders = array('3','4','5','6','8','10','12','Others/Don\'t Know');
		return $__aEngineCylinders;
	}

	public function getDriveTrain()
	{
		$__aDriveTrain = array('2WD','4WD','FWD','AWD','RWD','Others/Don\'t Know');
		return $__aDriveTrain;
	}
	
	public function getFuelType()
	{
		$__aFuelType = array('Diesel','Petrol','Compressed Natural Gas','Others/Don\'t Know');
		return $__aFuelType;
	}
	
	public function getBodyStyle()
	{
		$__aBodyStyle = array('Convertible','Coupe','Hatchback','Sedan','SUV','Truck','Van/Minivan','Wagon');
		return $__aBodyStyle;
	}
	public function getMenuDisplayText($key)
	{
		$key = trim($key);
		if($key == 'BETWEEN 0 AND 5000')
		 $displayText = 'Upto $'.number_format(5000,0,'.',',');
		else if($key == 'BETWEEN 5001 AND 10000')
		 $displayText = '$'.number_format(5001,0,'.',',').' - $'.number_format(10000,'0','.',',');
		else if($key == 'BETWEEN 10001 AND 20000')
		 $displayText = '$'.number_format(10001,0,'.',',').' - $'.number_format(20000,'0','.',',');
		else if($key == 'BETWEEN 20001 AND 30000')
		 $displayText = '$'.number_format(20001,0,'.',',').' - $'.number_format(30000,'0','.',',');
		else if($key == 'BETWEEN 30001 AND 40000')
		 $displayText = '$'.number_format(30001,0,'.',',').' - $'.number_format(40000,'0','.',',');
		else if($key == '>= 40001')
		 $displayText = '$'.number_format(40000,0,'.',',').' + ';
		 
		 return $displayText;
		  
	}
	
	public function getTimeDurationList()
	{
		$aTimeDurationList = array(	
									'CLOSED',
									'12:00 AM', '12:15 AM', '12:30 AM', '12:45 AM',
									'01:00 AM', '01:15 AM', '01:30 AM', '01:45 AM', 
									'02:00 AM',	'02:15 AM', '02:30 AM', '02:45 AM', 
									'03:00 AM', '03:15 AM',	'03:30 AM', '03:45 AM', 
									'04:00 AM', '04:15 AM', '04:30 AM',	'04:45 AM', 
									'05:00 AM', '05:15 AM', '05:30 AM', '05:45 AM',
									'06:00 AM', '06:15 AM', '06:30 AM', '06:45 AM',
									'07:00 AM', '07:15 AM', '07:30 AM', '07:45 AM',
									'08:00 AM', '08:15 AM', '08:30 AM', '08:45 AM',
									'09:00 AM', '09:15 AM', '09:30 AM', '09:45 AM',
									'10:00 AM', '10:15 AM', '10:30 AM', '10:45 AM',
									'11:00 AM', '11:15 AM', '11:30 AM', '11:45 AM',
									'12:00 PM', '12:15 PM', '12:30 PM', '12:45 PM',
									'01:00 PM', '01:15 PM', '01:30 PM', '01:45 PM', 
									'02:00 PM',	'02:15 PM', '02:30 PM', '02:45 PM', 
									'03:00 PM', '03:15 PM',	'03:30 PM', '03:45 PM', 
									'04:00 PM', '04:15 PM', '04:30 PM',	'04:45 PM', 
									'05:00 PM', '05:15 PM', '05:30 PM', '05:45 PM',
									'06:00 PM', '06:15 PM', '06:30 PM', '06:45 PM',
									'07:00 PM', '07:15 PM', '07:30 PM', '07:45 PM',
									'08:00 PM', '08:15 PM', '08:30 PM', '08:45 PM',
									'09:00 PM', '09:15 PM', '09:30 PM', '09:45 PM',
									'10:00 PM', '10:15 PM', '10:30 PM', '10:45 PM',
									'11:00 PM', '11:15 PM', '11:30 PM', '11:45 PM'
									);
		return $aTimeDurationList;						
	}

    /* Asset management functions */
	public function getEmployeeType()
	{
		$__aEmployeeType = array('Management','Staff','Worker');
		return $__aEmployeeType;
	}
	public function getPaymentType()
	{
		$__aPaymentType = array('Choose the Payment Type','Cash','CreditCard','Cheque');
		return $__aPaymentType;
	}
	public function encode($text)
	{
		$encode_text = base64_encode(base64_encode(base64_encode($text)));
		return $encode_text;
	}
	public function decode($text)
	{
		$encode_text = base64_decode(base64_decode(base64_decode($text)));
		return $encode_text;
	}
	public function inspectionStatus($statusId)
	{
		$status = "";
		switch ($statusId)
			{
			case 1:
				$status = "Open";
				$label ="label-success";
				break;
			case 2:
				$status = "Deleted";
				$label ="label-warning";
				break;
			case 3:
			    $status = "Passed";	
				$label ="label-success";
				break;
			case 4:
			    $status = "Rejected";
				$label ="label-warning";	
				break;
			case 12:
			    $status = "Closed";
				$label ="label-warning";	
				break;
			default:
				$status = "Open";
				$label ="label-success";
		 }
		 $status = '<span class="label '.$label.' ">'.$status.'</span>';
		 return $status;	
	}
	
	public function AssetItemStatus($statusId)
	{
		$status = "";
		switch ($statusId)
			{
			case 1:
				$status = "Active";
				$label ="label-success";
				break;
			case 2:
				$status = "Trashed";
				$label ="label-warning";
				break;
			case 3:
			    $status = "Approved";
				$label ="label-approve";	
				break;
			case 4:
			    $status = "Unapproved";	
				$label ="label-warning";
				break;
			case 5:
			    $status = "Inspection Open";
				$label ="label-success";	
				break;
			case 6:
			    $status = "Inspection Closed";	
				$label ="label-warning";
				break;
			case 7:
			    $status = "Stock";
				$label ="label-success";	
				break;
			case 8:
			    $status = "In-Transit";	
				$label ="label-warning";
				break;
			case 9:
			    $status = "Received";	
				$label ="label-success";
				break;
			case 10:
			    $status = "Partial-Received";
				$label ="label-warning";	
				break;
			case 11:
			    $status = "Return";	
				$label ="label-warning";
				break;	
			case 12:
			    $status = "Closed";
				$label ="label-important";	
				break;	
			case 13:
			    $status = "Less";
				$label ="label-info";	
				break;	
			case 14:
			    $status = "Excess";
				$label ="label-info";	
				break;	
			case 15:
			    $status = "Forced Close";
				$label ="label-info";	
				break;
			case 16:
			    $status = "Delivered";
				$label ="label-info";	
				break;	
		   case 17:
			    $status = "Cancel";	
				$label ="label-warning";
				break;
			case 18:
			    $status = "Approved Cancel";	
				$label ="label-warning";
				break;	
				
			case 19:
			    $status = "Under Service";	
				$label ="label-warning";
				break;		
				
			case 20:
			    $status = "Maintenance";	
				$label ="label-info";
				break;						
			case 21:
			    $status = "Sold";	
				$label ="label-warning";
				break;	
			case 22:
			    $status = "Expired";	
				$label ="label-warning";
				break;			
			default:
				$status = "Open";
				$label ="label-success";
		 }
		 $status = '<span class="label '.$label.' ">'.$status.'</span>';
		 return $status;	
	}
	public function Stockstatus($statusId)
	{
		$status = "";
		switch ($statusId)
			{
			case 0:
				$status = "Available";
				$label ="label-success";
				break;
			case 1:
				$status = "Used";
				$label ="label-warning";
				break;
							
			default:
				$status = "Available";
				$label ="label-success";
		 }
		 $status = '<span class="label '.$label.' ">'.$status.'</span>';
		 return $status;	
	}
	public function getContractType()
	{
		$__aContractType = array( 'AMC' => 'Annual Maintenance Contract','SC' => 'Service Contract','Warranty' => 'Warranty');		
		return $__aContractType;
	}
	public function getServiceType()
	{
		$__aServiceType = array( '0' => 'Free','1' => 'Paid');		
		return $__aServiceType;
	}
	
	
	

}
?>