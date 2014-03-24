<?php

class Helpers {

	public static function printPre($arr, $isExit = FALSE)
	{
		if(TRUE === Helpers::isDevelopment())
		{
			echo "<pre>";
			print_r($arr);
			echo "</pre>";
					
			($isExit===TRUE?exit:'');
		}
	}

	public static function isDevelopment()
	{		
		return TRUE;
	}

	public static function getSeasonWeekCount($teamCount)
	{
		return ($teamCount*2) - 2;
	}

	public static function scheduler($teams)
	{

	    if (count($teams)%2 != 0)
	    {
	        array_push($teams, "bye");
	    }

	    $away 	= 	array_splice($teams,(count($teams)/2));
	    $home 	= 	$teams;

	    for ($i=0; $i < count($home)+count($away)-1; $i++)
	    {
	        for ($j=0; $j<count($home); $j++)
	        {
	            $round[$i][$j]['home']=$home[$j];
	            $round[$i][$j]['away']=$away[$j];
	        }

	        if(count($home)+count($away)-1 > 2)
	        {
	            array_unshift($away,array_shift(array_splice($home,1,1)));
	            array_push($home,array_pop($away));
	        }
	    }

	    return $round;
	}

	public static function getTeamPower()
	{
		return rand(0,100);
	}
}