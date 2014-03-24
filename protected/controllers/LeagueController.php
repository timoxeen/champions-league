<?php

class LeagueController extends CController
{
	public $layout='//layouts/layout-with-nav';
	private $data = array();

	public function actionIndex()
	{
		$isSeasonExists	=	Season::model()->isExists();

		if(FALSE === $isSeasonExists)
		{
			$this->render('no-season');
			Yii::app()->end();
		}
		
		$this->_controlActiveSeasonAndRedirect();
		
		$this->render('no-season');
	}

	public function actionStartSeason()
	{
		$isSeasonExists	=	Season::model()->isExists();

		if(FALSE === $isSeasonExists)
		{
			$this->render('no-season');
		}
		else 
		{
			$this->_controlActiveSeasonAndRedirect();

			// create new season
			$transaction = Yii::app()->db->beginTransaction();

			try {

				$lastSeasonId 	=	$this->_controlAndGetLastSeasonId();

				// create new season
				$seasonId 	=	Season::model()->createNewSeason($lastSeasonId);				

				// create all weeks for season
				$weekIds 	= 	Week::model()->createSeasonAllWeekBySeasonId($seasonId);
				
				// create fixtures for season 
				$fixtures 	=	Fixture::model()->createSeasonAllFixtureWithWeekIds($weekIds);

				$transaction->commit();

				$this->redirect('/season/' . $seasonId);

			} catch (Exception $e) {
	            $transaction->rollback();
	            Yii::log('LeagueController -> actionPlayAllSeason: '.$e->getMessage(), \CLogger::LEVEL_ERROR, 'core.models.store.Order');
	            die('Error: ' . $e->getMessage());
	        }
		}
	}

	private function _controlAndGetLastSeasonId()
	{
		$lastSeasonData 	=	Season::model()->getLastCompletedSeason();

		if(isset($lastSeasonData->season_id))
			$lastSeasonId = $lastSeasonData->season_id;
		else 
			$lastSeasonId = 0;

		return $lastSeasonId;
	}

	private function _controlActiveSeasonAndRedirect()
	{
		$activeSeasonData 	=	Season::model()->getActiveSeason();

		if(isset($activeSeasonData->season_id))
		{
			$this->redirect('/season/' . $activeSeasonData->season_id);
			Yii::app()->end();
		}
	}

	public function actionPlayAllSeason()
	{

		$this->_controlActiveSeasonAndRedirect();

		// create new season
		$transaction = Yii::app()->db->beginTransaction();

		try {

			$lastSeasonId 	=	$this->_controlAndGetLastSeasonId();

			// create new season
			$seasonId 	=	Season::model()->createNewSeason($lastSeasonId);				

			// create all weeks for season
			$weekIds 	= 	Week::model()->createSeasonAllWeekBySeasonId($seasonId);
			
			// create fixtures for season 
			$fixtures 	=	Fixture::model()->createSeasonAllFixtureWithWeekIds($weekIds);

			// play all games for season
			$fixtures 	=	Fixture::model()->playFixtureByFixtures($fixtures);

			// play weeks for season
			Week::model()->completeSeasonWeeks($seasonId);

			// set league_table
			LeagueTable::model()->createSeasonLeagueTableByFixtures($fixtures);

			// complete season 
			Season::model()->completeSeason($seasonId);

			$transaction->commit();

			$this->redirect('/season/' . $seasonId);

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