<?php
class SeasonForm extends CFormModel
{
	public $seasonId;

	public $seasonTitle;
    public $seasonStatus;
	public $weeks;
    public $championTeam = NULL;

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
    }

}