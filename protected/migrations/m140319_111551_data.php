<?php

class m140319_111551_data extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$command =   Yii::app()->db->createCommand();

		// insert teams
		$command->insert('team', array(
		    'title'	=>	'Beşiktaş'
		));
		$command->insert('team', array(
		    'title'	=>	'Fenerbahçe'
		));
		$command->insert('team', array(
		    'title'	=>	'Galatasaray'
		));
		$command->insert('team', array(
		    'title'	=>	'Trabzon Spor'
		));

		// insert season
		$command->insert('season', array(
		    'title'	=>	'1. Season'
		));

		// insert weeks
		$command->insert('week', array(
			'season_id' => 1,
		    'title'	=>	'1. Week'
		));

		// insert fixture
		$command->insert('fixture', array(
			'season_id' => 1,
			'week_id' => 1,
		    'home_team_id'	=>	1,
		    'away_team_id'	=>	2,
		)); 

		$command->insert('fixture', array(
			'season_id' => 1,
			'week_id' => 1,
		    'home_team_id'	=>	3,
		    'away_team_id'	=>	4,
		)); 
	}

	public function safeDown()
	{
	}

}