<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class SiteController extends CController
{	

	public $layout='//layouts/layout-without-nav';

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