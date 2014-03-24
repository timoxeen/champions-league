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
			$this->render('error');
			Yii::app()->end();
		}

		$seasonForm->setSeasonData();		

		$this->render('detail', array('data'=>$seasonForm));

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