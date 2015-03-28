<?php
  //depreciation calculation
  
  $purchasePrice = '464.88';
  $lifeTime = 5;
  $salvageValue = '100';
  
  //Straight Line method.
  
  $annual_depreciation = $purchasePrice / $lifeTime;
  
  //Depreciation Yearwise.
  
  $aDepreciation = array();
  $startYear = '2013';
  $currentAssetPrice = $purchasePrice;
  for($i = 0; $i < $lifeTime; $i++)
  {
	  $aDep = array();
	  $aDep['Year'] = ($startYear + $i)." - " .($startYear + $i + 1);
	  $aDep['Annual_Dep'] = $purchasePrice / $lifeTime;
	  $currentAssetPrice = $currentAssetPrice - ($purchasePrice / $lifeTime);
	  $aDep['Dep_Asset_Price'] = $currentAssetPrice;
	  $aDepreciation[] = $aDep;
  }
  
  //echo '<pre>';
  //print_r($aDepreciation);
  //echo '</pre>';
  
  //Straight Line calculation using the Salvage Value
  //http://www.assetaide.com/depreciation/sl-sv.html
  $annual_depreciation_sv = ($purchasePrice - $salvageValue) / $lifeTime;
  
  $aDepreciation_sv = array();
  $startYear = '2013';
  $currentAssetPrice = $purchasePrice;
  for($i = 0; $i < $lifeTime; $i++)
  {
	  $aDep = array();
	  $aDep['Year'] = ($startYear + $i)." - " .($startYear + $i + 1);
	  $aDep['Annual_Dep'] = ($purchasePrice - $salvageValue) / $lifeTime;
	  $currentAssetPrice = $currentAssetPrice - ($aDep['Annual_Dep']);
	  $aDep['Dep_Asset_Price'] = $currentAssetPrice;
	  $aDepreciation_sv[] = $aDep;
  }
  
?>
StraightLine method - Without Salvage value.
<table cellpadding="3" border="1">
<tr>
   <th colspan="2">Asset Purchase Price</th>
   <th><?php echo $purchasePrice; ?></th>
 </tr>
 <tr>
   <th colspan="2">LifeTime</th>
   <th><?php echo $lifeTime; ?></th>
 </tr>

 <tr>
   <th>Year</th>
   <th>Annual Depreciation</th>
   <th>Dep.Asset.Price</th>
 </tr>
 <?php
   foreach($aDepreciation as $aDep)
   {
 ?>
   <tr>
   <td><?php echo $aDep['Year']; ?></td>
   <td><?php echo $aDep['Annual_Dep']; ?></td>
   <td><?php echo $aDep['Dep_Asset_Price']; ?></td>
   </tr>
 <?php
   }
 ?>
 </table>
 <br>
StraightLine method - With Salvage value.
 <table cellpadding="3" border="1">
<tr>
   <th colspan="2">Asset Purchase Price</th>
   <th><?php echo $purchasePrice; ?></th>
 </tr>
 <tr>
   <th colspan="2">LifeTime</th>
   <th><?php echo $lifeTime; ?></th>
 </tr>
 
  <tr>
   <th colspan="2">Salvage Value</th>
   <th><?php echo $salvageValue; ?></th>
 </tr>

 <tr>
   <th>Year</th>
   <th>Annual Depreciation</th>
   <th>Dep.Asset.Price</th>
 </tr>
 <?php
   foreach($aDepreciation_sv as $aDep)
   {
 ?>
   <tr>
   <td><?php echo $aDep['Year']; ?></td>
   <td><?php echo $aDep['Annual_Dep']; ?></td>
   <td><?php echo $aDep['Dep_Asset_Price']; ?></td>
   </tr>
 <?php
   }
 ?>
 </table>
 
 <?php
  // Declining Balance Depreciation Method
  //http://www.assetaide.com/depreciation/calculation.html
  $purchasePrice = '3217.89';
  $lifeTime = 4;
  $factor = 2 * (1/$lifeTime);
  
  $aDepreciation = array();
  $startYear = '2013';
  $dep_basis = $purchasePrice;
  $accu = 0;
  for($i = 0; $i < $lifeTime; $i++)
  {
	  $aDep = array();
	  $aDep['Year'] = ($startYear + $i)." - " .($startYear + $i + 1);
	  
	  //$dep_basis = $accumulated_dep;
	  
	  $aDep['Depreciable_Basis'] = $dep_basis;
	  //calculation
	  $dep_expense = $dep_basis * $factor;
	  $aDep['Dep_Expense'] = $dep_expense;
	  
	  $dep_basis = $dep_basis - $dep_expense;

	  $accu = $accu + $dep_expense;	  
	  $aDep['Accumulated_Dep'] = $accu;
	  $aDepreciation[] = $aDep;
  }
 // echo '<pre>';
  //print_r($aDepreciation);
  
 ?>
 <br>
Declining balance depreciation method.
 <table cellpadding="3" border="1">
<tr>
   <th colspan="3">Asset Purchase Price</th>
   <th><?php echo $purchasePrice; ?></th>
 </tr>
 <tr>
   <th colspan="3">LifeTime</th>
   <th><?php echo $lifeTime; ?></th>
 </tr>
 
  <tr>
   <th colspan="3">Factor</th>
   <th><?php echo $factor; ?></th>
 </tr>

 <tr>
   <th>Year</th>
   <th>Depreciable Basis</th>
   <th>Depreciation Expense</th>
   <th>Accumulated Depreciation</th>
 </tr>
 <?php
   foreach($aDepreciation as $aDep)
   {
 ?>
   <tr>
   <td><?php echo $aDep['Year']; ?></td>
   <td><?php echo $aDep['Depreciable_Basis']; ?></td>
   <td><?php echo $aDep['Dep_Expense']; ?></td>
   <td><?php echo $aDep['Accumulated_Dep']; ?></td>
   </tr>
 <?php
   }
 ?>
 </table>
 
 <!--
 The declining balance depreciation method uses the depreciable basis of an asset multiplied by a factor based on the life of the asset. The depreciable basis of the asset is the book value of the fixed asset -- cost less accumulated depreciation.

The factor is the percentage of the asset that would be depreciated each year under straight line depreciation times the accelerator. For example, an asset with a four year life would have 25% of the cost depreciated each year. Using double declining balance or 200%, which is the most common, would mean that depreciation expense in the first year would be twice that or 50%. So to calculate the depreciation expense each year the depreciable basis would be multiplied by 50%.

Example: A copy machine is purchased for $3,217.89. The expected life is 4 years. Using double declining balance the depreciation would be calculated as follows: 
factor = 2 * (1/4) = 0.50

http://scn.sap.com/docs/DOC-46210
http://www.wikihow.com/Sample/Straight-Line-Depreciation-Calculator

 -->
 
 
 <?php
 	function sumOfYearsDigits($purchasePrice, $startYear, $lifeTime)
	{
	   $sumofdigits = ($lifeTime * ($lifeTime + 1)) / 2; //sum of digits - n(n+1) / 2
	   $aYearPercent = array();
	   for($i = $lifeTime; $i > 0; $i--)
	   {
	      $aYearPercent[] = round(($i / $sumofdigits) * 100, 2);
	   }
	   $aDepreciation = array();
	   for($i = 0; $i < $lifeTime; $i++)
	   {
	     $aDep = array();
		 $aDep['Year'] = ($startYear + $i)." - " .($startYear + $i + 1);
		 //calculation
		 $dep_amount              = ($purchasePrice * $aYearPercent[$i]) / 100;
		 $aDep['Dep_Amount']      = $dep_amount;
		 $aDep['Dep_Calculation'] = $purchasePrice. "*" . $aYearPercent[$i]. "%";
		 $aDepreciation[] = $aDep;
	   }
       return $aDepreciation;
	}
	
	$aDepreciation = sumOfYearsDigits('1467.89', '2013', 5);
	//echo '<pre>';
	//print_r($aDepreciation);
 
 ?>
Sum of the Years Digits
<table cellpadding="3" border="1">
<tr>
   <th colspan="2">Asset Purchase Price</th>
   <th><?php echo $purchasePrice; ?></th>
 </tr>
 <tr>
   <th colspan="2">LifeTime</th>
   <th><?php echo $lifeTime; ?></th>
 </tr>

 <tr>
   <th>Year</th>
   <th>Depreciation Calculation</th>
   <th>Dep.Asset.Price</th>
 </tr>
 <?php
   foreach($aDepreciation as $aDep)
   {
 ?>
   <tr>
   <td><?php echo $aDep['Year']; ?></td>
   <td><?php echo $aDep['Dep_Calculation']; ?></td>
   <td><?php echo $aDep['Dep_Amount']; ?></td>
   </tr>
 <?php
   }
 ?>
 </table>