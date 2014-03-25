<?php

/**
 * This is the model class for table "league_table".
 *
 * The followings are the available columns in table 'league_table':
 * @property integer $league_table_id
 * @property integer $week_id
 * @property integer $team_id
 * @property integer $total_win
 * @property integer $total_lost
 * @property integer $total_deuce
 * @property integer $goal_forward
 * @property integer $goal_against
 * @property integer $goal_difference
 *
 * The followings are the available model relations:
 * @property Team $team
 * @property Week $week
 */
class LeagueTable extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'league_table';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('week_id, team_id', 'required'),
			array('week_id, team_id, total_win, total_lost, total_deuce, goal_forward, goal_against, goal_difference', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('league_table_id, week_id, team_id, total_win, total_lost, total_deuce, goal_forward, goal_against, goal_difference', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'team' => array(self::BELONGS_TO, 'Team', 'team_id'),
			'week' => array(self::BELONGS_TO, 'Week', 'week_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'league_table_id' => 'League Table',
			'week_id' => 'Week',
			'team_id' => 'Team',
			'total_win' => 'Total Win',
			'total_lost' => 'Total Lost',
			'total_deuce' => 'Total Deuce',
			'goal_forward' => 'Goal Forward',
			'goal_against' => 'Goal Against',
			'goal_difference' => 'Goal Difference',
		);
	}

	public function scopes()
    {
		return array(
	            'lastOne'=>array(
	            	'order' => 'points DESC, goal_difference DESC',
	                'limit'=>1,
	            ),
	        );
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('league_table_id',$this->league_table_id);
		$criteria->compare('week_id',$this->week_id);
		$criteria->compare('team_id',$this->team_id);
		$criteria->compare('total_win',$this->total_win);
		$criteria->compare('total_lost',$this->total_lost);
		$criteria->compare('total_deuce',$this->total_deuce);
		$criteria->compare('goal_forward',$this->goal_forward);
		$criteria->compare('goal_against',$this->goal_against);
		$criteria->compare('goal_difference',$this->goal_difference);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LeagueTable the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function createSeasonLeagueTableByFixtures($fixtures)
	{
		$isFirstWeek = TRUE;

		foreach($fixtures as $row)
		{
			$weekId 	=	$row->week_id;

			if(TRUE === $isFirstWeek)
			{
				if(! isset($tempWeekId))
				{
					$tempWeekId  =	$weekId;
				}
				else
				{
					if($tempWeekId !== $weekId)
					{
						$isFirstWeek 	=	FALSE;
						$tempWeekId  	=	$weekId;
					}
				}
			}
			
			if(TRUE === $isFirstWeek)
			{
				$homeTeamLastWeekData 	=	$this->_getDefaultData();
				$awayTeamLastWeekData 	=	$this->_getDefaultData();
			}
			else 
			{
				$homeTeamLastWeekData 	=	$this->_getLastDataByTeamId($row->home_team_id, $row->week_id);
				$awayTeamLastWeekData 	=	$this->_getLastDataByTeamId($row->away_team_id, $row->week_id);
			}

			$matchDetail 	=	Helpers::getMatchDetail($row->home_team_goal, $row->away_team_goal);

			// add for home team
			$this->_addLeagueTable($weekId, $row, $homeTeamLastWeekData, $matchDetail, TRUE);

			// add for away team
			$this->_addLeagueTable($weekId, $row, $awayTeamLastWeekData, $matchDetail, FALSE);
		}
	}

	public function createSeasonLeagueTableByFixturesForOneByOne($fixtures, $seasonId, $weekId)
	{
		$seasonFirstWeekId 	=	Week::model()->getSeasonFirstWeekIdBySeasonId($seasonId);

		foreach($fixtures as $row)
		{
			if($seasonFirstWeekId === $weekId)
			{
				$homeTeamLastWeekData 	=	$this->_getDefaultData();
				$awayTeamLastWeekData 	=	$this->_getDefaultData();
			}
			else 
			{	
				$homeTeamLastWeekData 	=	$this->_getLastDataByTeamId($row->home_team_id, $row->week_id);
				$awayTeamLastWeekData 	=	$this->_getLastDataByTeamId($row->away_team_id, $row->week_id);
			}

			$matchDetail 	=	Helpers::getMatchDetail($row->home_team_goal, $row->away_team_goal);

			// add for home team
			$this->_addLeagueTable($weekId, $row, $homeTeamLastWeekData, $matchDetail, TRUE);

			// add for away team
			$this->_addLeagueTable($weekId, $row, $awayTeamLastWeekData, $matchDetail, FALSE);
		}
	}

	private function _addLeagueTable($weekId, $row, $teamLastWeekData, $matchDetail, $isHomeTeam = TRUE)
	{
		if(TRUE === $isHomeTeam)
		{
			$homeTeamGoal 	=	$row->home_team_goal;
			$awayTeamGoal 	=	$row->away_team_goal;
			$teamId 		=	$row->home_team_id;
			$teamPoints 	=	$matchDetail['home_points'];
			$teamWin 		=	$matchDetail['home_win'];
			$teamLost 		=	$matchDetail['home_lost'];
			$teamDeuce 		=	$matchDetail['home_deuce'];
		}
		else 
		{
			$homeTeamGoal 	=	$row->away_team_goal;
			$awayTeamGoal 	=	$row->home_team_goal;	
			$teamId 		=	$row->away_team_id;
			$teamPoints 	=	$matchDetail['away_points'];
			$teamWin 		=	$matchDetail['away_win'];
			$teamLost 		=	$matchDetail['away_lost'];
			$teamDeuce 		=	$matchDetail['away_deuce'];
		}

		$leagueTableHome 					=	new LeagueTable;
		$leagueTableHome->week_id 			=	$weekId;
		$leagueTableHome->team_id 			=	$teamId;
		$leagueTableHome->points			=	$teamLastWeekData->points + $teamPoints;
		$leagueTableHome->total_win 		=	$teamLastWeekData->total_win + $teamWin;
		$leagueTableHome->total_lost 		=	$teamLastWeekData->total_lost + $teamLost;
		$leagueTableHome->total_deuce 		=	$teamLastWeekData->total_deuce + $teamDeuce;
		$leagueTableHome->goal_forward 		=	$teamLastWeekData->goal_forward + $homeTeamGoal;
		$leagueTableHome->goal_against 		=	$teamLastWeekData->goal_against + $awayTeamGoal;	
		$leagueTableHome->goal_difference	=	$leagueTableHome->goal_forward - $leagueTableHome->goal_against;
		$leagueTableHome->save();
	}

	private function _getDefaultData()
	{
		$data 	=	new LeagueTable;

		$data->points 			=	0;
		$data->total_win 		=	0;
		$data->total_lost 		=	0;
		$data->total_deuce 		=	0;
		$data->goal_forward 	=	0;
		$data->goal_against 	=	0;
		$data->goal_difference 	=	0;

		return $data;
	}

	private function _getLastDataByTeamId($teamId, $weekId)
	{
		$criteria = new CDbCriteria();
		$criteria->condition 	= 	'team_id = ' . $teamId;
		$criteria->limit 		= 	1;
		$criteria->offset 		= 	0;
		$criteria->order 		= 	'league_table_id DESC';
		$data 	= 	LeagueTable::model()->find($criteria);			

		return $data;
	}

	public function getSeasonChampion($seasonId)
	{
		$seasonLastWeekId 	=	Week::model()->getLastCompletedWeekIdBySeasonId($seasonId);

		$condition 	=	'week_id=:week_id';
		$param 		=	array(':week_id' => $seasonLastWeekId);
		$data 		=	LeagueTable::model()->lastOne()->find($condition, $param);

		$championTeam 	=	$data->team->title;

		return $championTeam;
	}
}
