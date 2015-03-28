<?php

    /**

	  * Depreciation class

	  * This class lists various Depreciation functions.

	  * 

	  * @author Subash Gopalaswamy <techhead.stallioni@gmail.com>

	  * //SLM, WDV methods etc.,

	  */

 class Depreciation

 {

	function __construct()

	{

		

	}

	public function setDb($oDb)

	{

	   $this->oDb = $oDb;

	}

	

	public function straightLineDepreciation($purchasePrice, $lifeTime, $startYear, $salvageValue = '')
	{
		
		 $startYear = $this->getFinancialyear($startYear);
		 if($startYear == 0 )
		 {
			$aDep = array();
			$aDepreciation[]         = $aDep;
		 }
		 else
		 {
		 if(empty($salvageValue))

		{

		  $salvageValue = 0;

		}

		$depreciableAmount = $purchasePrice - $salvageValue;

		$annual_depreciation = ($depreciableAmount) / $lifeTime;

		

		$aDepreciation = array();

        $currentAssetPrice = $purchasePrice;

		for($i = 0; $i < $lifeTime; $i++)

		{

			$aDep = array();

			$aDep['Year']            = ($startYear + $i)." - " .($startYear + $i + 1);

			$aDep['Annual_Dep']      = $annual_depreciation;

			$currentAssetPrice       = $currentAssetPrice - $annual_depreciation;

			$aDep['Dep_Asset_Price'] = $currentAssetPrice;

			$aDepreciation[]         = $aDep;

		}

		 }
		
		
		return $aDepreciation;

	}

	

	public function decliningBalanceDepreciation($purchasePrice, $lifeTime, $startYear,$factor)

	{

	   $startYear = $this->getFinancialyear($startYear);
		 if($startYear == 0 )
		 {
			$aDep = array();
			$aDepreciation[]         = $aDep;
		 }
		 else
		 {
	
	   $aDepreciation = array();

	   $dep_basis = $purchasePrice;

	   $accu = 0;

		  for($i = 0; $i < $lifeTime; $i++)

		  {

			  $aDep = array();

			  $aDep['Year'] = ($startYear + $i)." - " .($startYear + $i + 1);

			  

			  $aDep['Depreciable_Basis'] = $dep_basis;

			  //calculation

			  $dep_expense = $dep_basis * $factor;

			  $aDep['Dep_Expense'] = $dep_expense;

			  

			  $dep_basis = $dep_basis - $dep_expense;

		

			  $accu = $accu + $dep_expense;	  

			  $aDep['Accumulated_Dep'] = $accu;

			  $aDepreciation[] = $aDep;

		  }
		  }

		  return $aDepreciation;

	} //

   public function sumOfYearsDigits($purchasePrice, $startYear, $lifeTime)

	{

	   $startYear = $this->getFinancialyear($startYear);
		 if($startYear == 0 )
		 {
			$aDep = array();
			$aDepreciation[]         = $aDep;
		 }
		 else
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
	}
       return $aDepreciation;

	}

    
	public function getFinancialyear($date)
	{
	  
	  if($date =='0000-00-00')
	  {
	         $finacialyr='';
	  }
	  else
	  {
			$month =  date("m",strtotime($date))."\n";
			$year =  date("Y",strtotime($date))."\n";
			if($month < 3)
			{
			$finacialyr= ($year -1 );
			
			}
			else
			{
			$finacialyr=$year ;
			}
	}
       return $finacialyr;
	}


public function reducingBalanceDepreciation($purchasePrice, $lifeTime, $startYear,$percent,$lookup)

	{
$factor = $percent/100;
	    $startYear = $this->getFinancialyear($startYear);
	   
		 if($startYear == 0 )
		 {
			$aDep = array();
			$aDepreciation[]         = $aDep;
		 }
		 else
		 {
	
	   $aDepreciation = array();

	   $dep_basis = $purchasePrice;

	   $accu = 0;

		  for($i = 0; $i < $lifeTime; $i++)

		  {
  $aDep = array();
	  $aDep['Year'] = ($startYear + $i)." - " .($startYear + $i + 1);
	  
	 $aDep['AdditionalDepreciable_Basis'] = $this->getAmount($lookup,($startYear + $i),($startYear + $i + 1));
	   $aDep['Depreciable_Basis'] = $dep_basis + $aDep['AdditionalDepreciable_Basis'];
	  //$dep_basis = $accumulated_dep;
	   // $aDep['Depreciable_Basis1'] = $dep_basis;
		// $aDep['Depreciable_Basis2'] = $aDep['AdditionalDepreciable_Basis'];
	 	//  $aDep['Depreciable_Basis3'] =    $aDep['Depreciable_Basis'];
	  
	  //calculation
	  $dep_expense = $aDep['Depreciable_Basis'] * $factor;
	  $aDep['Dep_Expense'] = $dep_expense;
	  
	  $dep_basis = $aDep['Depreciable_Basis'] - $dep_expense;

	  $accu = $accu + $dep_expense;	  
	  $aDep['Accumulated_Dep'] = $accu;
	  $aDep['Written_Down_Value'] = $aDep['Depreciable_Basis'] - $aDep['Dep_Expense'];
	  $aDepreciation[] = $aDep;

		  }
		  }

		  return $aDepreciation;

	} //

 public function getAmount($lookup,$start,$end)
 {
 $qry = "SELECT
   SUM( service_invoice . bill_amount ) As sum_amount
    
FROM
    asset_maintenance 
    INNER JOIN  service_invoice  
        ON ( asset_maintenance . id_asset_maintenance  =  service_invoice . id_asset_maintenance )
        WHERE   asset_maintenance . id_asset_item  ='$lookup' AND service_invoice.created_on BETWEEN '$start-4-1' AND '$end-3-31' AND  service_invoice . for_depreciation =1 ;";
		if($row = $this->oDb->get_row($qry))
		{
		$aAdditionalAmount  = $row->sum_amount;
		}
		return $aAdditionalAmount ;
 }
 
 
 
 public function getFinancialyearCal($date)
	{
	   $finacialyr =array();
	  if($date =='0000-00-00' || $date =='00-00-0000')
	  {
	         $finacialyr='0';
	  }
	  else
	  {
			$month =  date("m",strtotime($date))."\n";
			$year =  date("Y",strtotime($date))."\n";
			if($month < 3)
			{
			$finacialyr['start_year']= ($year -1 );
			$finacialyr['end_year']= ($year);
			$finacialyr['fina_year']= ($year -1 ).'-'.($year );
			$finacialyr['start_date']= '01-04'.'-'.($year -1 );
			$finacialyr['end_date']= '31-03'.'-'.($year);
			
			}
			else
			{
				$finacialyr['start_year']= $year;
				$finacialyr['end_year']= ($year + 1);
				$finacialyr['fina_year']= $year.'-'.($year + 1);
			}
			
	}
       return $finacialyr;
	}
	
	public function getFinYearDiff($purchasedate,$saledate)
	{
		$aStartFinyear =$this->getFinancialyearCal($purchasedate);
		$aEndFinyear = $this->getFinancialyearCal($saledate);
		if(empty($aStartFinyear))
		{
		$diffYear = '0';
		}
		else
		{
		$diffYear = $aEndFinyear['end_year'] - $aStartFinyear['start_year'];
		}
		return $diffYear;
	}
 
 
 }// end class



?>