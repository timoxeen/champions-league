<?php

Yii::import('zii.widgets.CPortlet');

class SeasonList extends CPortlet
{
	public function getSeasonList()
	{
		return Season::model()->getAll();
	}

	protected function renderContent()
	{
		$this->render('seasonList');
	}
}