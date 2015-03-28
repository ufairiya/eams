<?php
include_once 'ApplicationHeader.php';
  $oCal = &Singleton::getInstance('ThreadCalculation');
  $oCal->setDb($oDb);
  
  
  $iso = '101';
  $spi = 8;
  $seamThickness = 1.2; //mm
  echo $oCal->calculateThreadPerInch($iso,$spi,$seamThickness);
  
  

?>
