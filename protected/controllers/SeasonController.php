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

		die("dfsds");
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