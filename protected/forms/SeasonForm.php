<?php
class SeasonForm extends CFormModel
{
    public $weekId;
	public $seasonId;
	public $seasonTitle;
    public $seasonStatus;
	public $weeks;
    public $championTeam = NULL;
    public $seasonNotCompletedWeekId;
    public $seasonLastCompletedWeekId;
    public $isNextWeekButton    =   FALSE;

    private $fixture;
    private $week;

	public function rules()
    {
        return array(
           array('seasonId', 'required', 'on'=>'detail'),
           array('seasonId', 'controlSeason', 'on'=>'detail'),
           array('seasonId, weekId', 'required', 'on'=>'ajax_get_week_results'),
           array('seasonId, weekId', 'controlSeason', 'on'=>'ajax_get_week_results'),
           array('seasonId, weekId', 'controlSeasonWeek', 'on'=>'ajax_get_week_results'),
        );
    }

    public function controlSeason()
    {
        if($this->hasErrors())
            return;

    	$isExists 	=	Season::model()->isExistsBySeasonId($this->seasonId);

    	if(FALSE === $isExists)
    	{
    		Yii::app()->user->setFlash('season', "Season not found!");
    		$this->addError("season", "Season not found!");
    	}
    }

    public function controlSeasonWeek()
    {
        if($this->hasErrors())
            return;

        $weekData   =   Week::model()->getBySeasonIdByWeekId($this->seasonId, $this->weekId);

        if(! isset($weekData->week_id))
        {
            $this->addError("week", "Week not found in this season!");
        }
        else 
        {
            $this->week = $weekData;
        }
    }

    public function getWeekFixtures()
    {
        $results = array();
        $i = 0;
        foreach($this->week->fixtures as $fixture)
        {
            $results[$i]['home_team']         =  $fixture->homeTeam->title;
            $results[$i]['away_team']         =  $fixture->awayTeam->title; 
            $results[$i]['home_team_goal']    =  $fixture->home_team_goal;
            $results[$i]['away_team_goal']    =  $fixture->away_team_goal;     

            $i++;
        }

        return $results;
    }

    public function setSeasonData()
    {
    	$seasonData 	=	Season::model()->getBySeasonId($this->seasonId);

        $this->seasonId        =    $seasonData->season_id;
    	$this->seasonTitle     =	$seasonData->title;
        $this->seasonStatus    =    $seasonData->status;
    	$this->weeks	       =	$seasonData->weeks;	

        if(Season::STATUS_COMPLETED === $seasonData->status)
        {
            $this->championTeam                 =   LeagueTable::model()->getSeasonChampion($this->seasonId);
        }
        else 
        {
            $this->seasonLastCompletedWeekId     =   Week::model()->getLastCompletedWeekIdBySeasonId($this->seasonId);
        }
    }

    public function setNextWeekButton()
    {
        $isExistsNotCompletedWeek   =   Week::model()->isExistsNotCompletedWeek($this->seasonId);

        if(TRUE === $isExistsNotCompletedWeek)
        {
            $this->isNextWeekButton     =   TRUE;
        }
    }

    public function setSeasonNotCompletedWeekId()
    {
        $this->seasonNotCompletedWeekId     =   Week::model()->getLastNotCompletedWeekIdBySeasonId($this->seasonId);
    }

    public function setFixtureByWeekId()
    {
        $this->fixture      =   Fixture::model()->getByWeekId($this->seasonNotCompletedWeekId);
    }

    public function playFixtureByFixture()
    {
        $this->fixture      =   Fixture::model()->playFixtureByFixtures($this->fixture);
    }

    public function completeWeekByWeekId()
    {
        Week::model()->completeWeekByWeekId($this->seasonNotCompletedWeekId);
    }

    public function createSeasonLeagueTableByFixturesForOneByOne()
    {
        LeagueTable::model()->createSeasonLeagueTableByFixturesForOneByOne($this->fixture, $this->seasonId,$this->seasonNotCompletedWeekId);
    }

    public function controlAndCompleteSeason()
    {
        $isExistsNotCompletedWeek   =   Week::model()->isExistsNotCompletedWeek($this->seasonId);

        if(FALSE === $isExistsNotCompletedWeek)
        {
            Season::model()->completeSeason($this->seasonId);
        }
    }
}