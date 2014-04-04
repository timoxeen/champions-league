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

	public static function playGame($firstTeamPower, $secondTeamPower)
	{
		$results['home_team_goal']	=	0;
		$results['away_team_goal']	=	0;

		$differencePower 	=	abs($firstTeamPower - $secondTeamPower);

		if($differencePower < 15) 	// deuce
		{
			$goal 	=	Helpers::getGoal(0, 8);

			$homeTeamGoal	=	$goal;
			$awayTeamGoal	=	$goal;
		}
		else
		{
			$goals 	=	Helpers::uniqueRandomNumbersWithinRange(0, 8, 2);
			
			if($firstTeamPower > $secondTeamPower)
			{
				$homeTeamGoal	=	$goals[1];
				$awayTeamGoal	=	$goals[0];
			}
			else 
			{
				$homeTeamGoal	=	$goals[0];
				$awayTeamGoal	=	$goals[1];
			}
		}

		$results['home']	=	$homeTeamGoal;
		$results['away']	=	$awayTeamGoal;

		return $results;
	}

	public static function getGoal($start, $limit)
	{
		$goal 	=	rand($start, $limit);

		return $goal;
	}

	public static function uniqueRandomNumbersWithinRange($min, $max, $quantity) 
	{
	    $numbers 			= 	range($min, $max);
	    shuffle($numbers);
    	$arrNumbers			=	array_slice($numbers, 0, $quantity);
    	sort($arrNumbers);	

    	return $arrNumbers;
	}

	public static function getMatchDetail($homeTeamGoal, $awayTeamGoal)
	{
		$results = array();

		if($homeTeamGoal === $awayTeamGoal)	
		{
			$homePoints		=	1;
			$awayPoints		=	1;
			$homeWin 		=	0;
			$awayWin 		=	0;
			$homeLost 		=	0;
			$awayLost 		=	0;
			$homeDeuce 		=	1;
			$awayDeuce 		=	1;
		}
		elseif($homeTeamGoal > $awayTeamGoal)	
		{
			$homePoints		=	3;
			$awayPoints		=	0;
			$homeWin 		=	1;
			$awayWin 		=	0;
			$homeLost 		=	0;
			$awayLost 		=	1;
			$homeDeuce 		=	0;
			$awayDeuce 		=	0;
		}
		else
		{
			$homePoints		=	0;
			$awayPoints		=	3;
			$homeWin 		=	0;
			$awayWin 		=	1;
			$homeLost 		=	1;
			$awayLost 		=	0;
			$homeDeuce 		=	0;
			$awayDeuce 		=	0;
		}

		$results['home_points']		=	$homePoints;
		$results['away_points']		=	$awayPoints;
		$results['home_win']		=	$homeWin;
		$results['away_win']		=	$awayWin;
		$results['home_lost']		=	$homeLost;
		$results['away_lost']		=	$awayLost;
		$results['home_deuce']		=	$homeDeuce;
		$results['away_deuce']		=	$awayDeuce;

		return $results;
	}

	public static function getModelFirstError($model)
	{
		$errors = $model->getErrors();

		foreach($errors as $error)
		{
			$firstError = $error[0];
			break;
		}

		return $firstError;
	}
}