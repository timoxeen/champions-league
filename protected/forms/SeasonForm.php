<?php
class SeasonForm extends CFormModel
{
	public $seasonId;

	public $title;
	public $weeks;

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

    	$this->title 	=	$seasonData->title;
    	$this->weeks	=	$seasonData->weeks;	
    }

}