<?php
include_once('config/config.php');

include_once('lib/Master.php');

$itemgrouptwoid = $_POST['id'];

$fgroup2 =  $_POST['group1'];

$oMaster = new Master;
  
$oMaster->setDb($oDb);

  if($itemgrouptwoid!='')
  {
  $itemlistsqry = $oMaster->ItemListDisplay($itemgrouptwoid,$fgroup2);
  
 echo '<p><b>Items Added in this Group</b></p>';
 
 if(empty($itemlistsqry))
	{
		echo 'No Items Added'; 
		
	}
	
  $i=1;
  
  foreach($itemlistsqry as $displaylists)
  {
	
	echo '<p>'.$i.'.'.' '.$displaylists['item_name'];   
	echo '</p>'; 
	$i++;
  }
  }
?>