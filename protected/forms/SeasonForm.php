<?php
class SeasonForm extends CFormModel
{
	public $seasonId;

	public $seasonTitle;
    public $seasonStatus;
	public $weeks;
    public $championTeam = NULL;
    public $seasonNotCompletedWeekId;
    public $seasonLastCompletedWeekId;
    public $isNextWeekButton    =   FALSE;

    private $fixture;

	public function rules()
    {
        return array(
           array('seasonId', 'required', 'on'=>'detail'),
           array('seasonId', 'controlSeason', 'on'=>'detail'),
        );
    }

    public function controlSeason()
    {
    	$isExists 	=	Season::model()->isExistsBySeasonId($this->seasonId);

    	if(FALSE === $isExists)
    	{
    		Yii::app()->user->setFlash('error', "Böyle bir sezon bulunamadı!");
    		$this->addError("error", TRUE);
    	}
    }

    public function setSeasonData()
    {
    	$seasonData 	=	Season::model()->getBySeasonId($this->seasonId);

    	$this->seasonTitle     =	$seasonData->title;
        $this->seasonStatus    =    $seasonData->status;
    	$this->weeks	       =	$seasonData->weeks;	

        if(Season::STATUS_COMPLETED === $seasonData->status)
        {
            $this->championTeam     =   LeagueTable::model()->getSeasonChampion($this->seasonId);
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