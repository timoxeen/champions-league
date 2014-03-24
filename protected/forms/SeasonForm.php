<?php
class SeasonForm extends CFormModel
{
	public $seasonId;

	public $seasonTitle;
    public $seasonStatus;
	public $weeks;
    public $championTeam = NULL;
    public $seasonNotCompletedWeekId;

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
            $this->seasonNotCompletedWeekId     =   Week::model()->getLastNotCompletedWeekIdBySeasonId($this->seasonId);
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

    public function createSeasonLeagueTableByFixture()
    {
        LeagueTable::model()->createSeasonLeagueTableByFixtures($this->fixture);
    }
}