<?php

class LeagueController extends CController
{
	public $layout='//layouts/layout-with-nav';
	private $data = array();

	public function actionIndex()
	{
		$isSessionExists	=	Season::model()->isExists();

		if(FALSE === $isSessionExists)
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

			$isSessionExists	=	Season::model()->isExists();

			if(FALSE === $isSessionExists)
			{
				// create season
				$season 			=	new Season;
				$season->title 		=	'1. Season';
				$season->save();

				// create week
				

				$transaction->commit();
			}
			else 
			{

			}

		} catch (Exception $ex) {
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