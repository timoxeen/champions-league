<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class SeasonController extends CController
{	

	public $layout='//layouts/layout-with-nav';

	public function actionDetail()
	{
		$seasonForm 	=	new SeasonForm('detail');
		$seasonForm->attributes 	=	$_GET;

		if(! $seasonForm->validate())
		{
			$this->layout = '//layouts/layout-without-nav';
			$this->render('error');
			Yii::app()->end();
		}

		$seasonForm->setSeasonData();	
		$seasonForm->setNextWeekButton();	

		$this->render('detail', array('data'=>$seasonForm));

	}

	public function actionPlayNextWeek($seasonId)
	{
		$seasonForm 	=	new SeasonForm('detail');
		$seasonForm->attributes 	=	$_GET;

		if(! $seasonForm->validate())
		{
			$this->layout = '//layouts/layout-without-nav';
			$this->render('error');
			Yii::app()->end();
		}

		$transaction = Yii::app()->db->beginTransaction();

		try {

			$seasonForm->setSeasonNotCompletedWeekId();
			$seasonForm->setFixtureByWeekId();
			$seasonForm->playFixtureByFixture();
			$seasonForm->createSeasonLeagueTableByFixturesForOneByOne();
			$seasonForm->completeWeekByWeekId();
			$seasonForm->controlAndCompleteSeason();

			$transaction->commit();

			$this->redirect('/season/' . $seasonId . '#week' . $seasonForm->seasonNotCompletedWeekId);

		} catch (Exception $e) {
            $transaction->rollback();
            Yii::log('SeasonController -> actionPlayNextWeek: '.$e->getMessage(), \CLogger::LEVEL_ERROR, 'core.models.store.Order');
            die('Error: ' . $e->getMessage());
        }
	}

	public function actionAjaxGetWeekResults()
	{
		if(! Yii::app()->request->isAjaxRequest)
			Yii::app()->end();

		$seasonForm 				=	new SeasonForm('ajax_get_week_results');
		$seasonForm->attributes 	=	$_POST;

		$data['error'] = false;

		if(! $seasonForm->validate())
		{
			$data['error'] = Helpers::getModelFirstError($seasonForm);
			echo CJSON::encode($data);
			Yii::app()->end();
		}

		$data['info']	=	$seasonForm->getWeekFixtures();

		echo CJSON::encode($data);
		Yii::app()->end();
	}

	public function actionAjaxSaveWeekResults()
	{
		if(! Yii::app()->request->isAjaxRequest)
			Yii::app()->end();

		$seasonForm 				=	new SeasonForm('ajax_save_week_results');
		$seasonForm->attributes 	=	$_GET;

		$data['error'] = false;

		if(! $seasonForm->validate())
		{
			$data['error'] = Helpers::getModelFirstError($seasonForm);
			echo CJSON::encode($data);
			Yii::app()->end();
		}

		$transaction = Yii::app()->db->beginTransaction();

		try {

			$seasonForm->updateFixtureResults();
			$seasonForm->deleteSeasonWeekLeagueTables();
			$seasonForm->updateSeasonWeekLeagueTables();			

			$transaction->commit();

			$data['redirectUrl']	=	$seasonForm->getRedirectUrl();

			echo CJSON::encode($data);
			Yii::app()->end();


		} catch (Exception $e) {
            $transaction->rollback();
            Yii::log('SeasonController -> actionAjaxSaveWeekResults: '.$e->getMessage(), \CLogger::LEVEL_ERROR, 'core.models.store.Order');
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
}