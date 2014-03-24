<?php

class LeagueController extends CController
{
	public $layout='//layouts/layout-with-nav';
	private $data = array();

	public function actionIndex()
	{
		$isSeasonExists	=	Season::model()->isExists();
$isSeasonExists = false;
		if(FALSE === $isSeasonExists)
		{
			$this->render('no-season');
		}
		else 
		{
			$this->render('week', array('data'=>$data));
		}

	}

	public function actionNextWeek()
	{

	}

	public function actionPlayAllSeason()
	{
		$transaction = Yii::app()->db->beginTransaction();

		try {

			$isSeasonExists	=	Season::model()->isExists();
$isSeasonExists = FALSE;
			if(FALSE === $isSeasonExists)
			{
				// create new season
				$seasonId 	=	Season::model()->createNewSeason();				

				// create all weeks for season
				$weekIds 	= 	Week::model()->createSeasonAllWeekBySeasonId($seasonId);
				
				// create fixtures for season 
				$fixtures 	=	Fixture::model()->createSeasonAllFixtureWithWeekIds($weekIds);

				// play all games for season
				$fixtures 	=	Fixture::model()->playFixtureByFixtures($fixtures);

				// play weeks for season
				Week::model()->completeSeasonWeeks($seasonId);

				// set league_table
				LeagueTable::model()->createSeasonLeagueTableByFixtures($fixtures, $seasonId);

				$transaction->commit();
			}
			else 
			{

			}

		} catch (Exception $e) {
            $transaction->rollback();
            Yii::log('LeagueController -> actionPlayAllSeason: '.$e->getMessage(), \CLogger::LEVEL_ERROR, 'core.models.store.Order');
            die('Error: ' . $e->getMessage());
        }

	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$this->layout = '//layouts/layout-without-nav';

	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}