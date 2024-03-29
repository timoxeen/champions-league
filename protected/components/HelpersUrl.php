<?php

class HelpersUrl {

	const URL_SLUG_SEASON 	=	'season';

	public static function getSeasonUrl($seasonId)
	{
		return Yii::app()->createUrl('/' . HelpersUrl::URL_SLUG_SEASON . '/' . $seasonId);
	}

	public static function getSeasonNextWeekUrl($seasonId)
	{
		return Yii::app()->createUrl('/' . HelpersUrl::URL_SLUG_SEASON . '/' . $seasonId . '/next-week');
	}

}