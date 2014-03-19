<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class SiteController extends CController
{	

	public $layout='//layouts/main-layout';

	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionTest()
	{
		die("test");
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
}