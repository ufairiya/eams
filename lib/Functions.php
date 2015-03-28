<?php

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

function getStatesList($oDb)
{
	$qStatesList	= "SELECT * FROM state";
	$rStatesList 	= $oDb->get_results($qStatesList);
	return $rStatesList;
}

function getDomainList($oDb)
{
	    $aDomainList = array();
		$query = "SELECT id, domain_name, status FROM domainlist";
		if($result = $oDb->get_results($query))
		{
			foreach($result as $row)
			{
				$aDomain = array();
				$aDomain['id'] = $row->id;
				$aDomain ['DomainName'] = $row->domain_name;
				$aDomainList[] = $aDomain;
			}	
		}
		return $aDomainList;
} //


//Bank Add / Edit / Delete
function addBank($aRequest)
{
	$bankName = $aRequest['fBankName'];
	$lookup = $aRequest['fLookup'];
	
	$qry = "INSERT INTO bank (id_bank, bank_name, lookup) VALUES (null, '$bankName', '$lookup')";
	
}

?>