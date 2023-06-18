<?php




$week = date("W"); 
  
  
   if($week==54 or $week==53 )
  {
	$week=1;  
  }
  
  
  

if($week==1)
	
	{
$weekm1=52;
  $weekm2=51;
  $weekm3=50;
  $weekm4=49;
		
		
	}
else if($week==2)
	
	{
		$weekm1=1;
  $weekm2=52;
  $weekm3=51;
  $weekm4=50;
		
		
	}
else if($week==3)
	
	{
		$weekm1=2;
  $weekm2=1;
  $weekm3=52;
  $weekm4=51;
		
		
	}
	
	else if($week==4)
	
	{
		$weekm1=3;
  $weekm2=2;
  $weekm3=1;
  $weekm4=52;
		
		
	}
	
	else{
		
		
		
		
	
 $weekm1=$week-1;
  $weekm2=$week-2;
  $weekm3=$week-3;
  $weekm4=$week-4;
  
	}
	
	
  $nameweekm1="S".$weekm1;
  $nameweekm2="S".$weekm2;
  $nameweekm3="S".$weekm3;
  $nameweekm4="S".$weekm4;













?>