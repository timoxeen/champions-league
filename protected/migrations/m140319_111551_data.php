<?php

class m140319_111551_data extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		/**
		** create foreign key and table relations
		*/

		// week -> session
		$this->addForeignKey('FK_week_season', 'week', 'season_id', 'season', 'season_id');

		// fixture -> week
		$this->addForeignKey('FK_fixture_week', 'fixture', 'week_id', 'week', 'week_id');

		// fixture -> team_home
		$this->addForeignKey('FK_fixture_team_home', 'fixture', 'home_team_id', 'team', 'team_id');

		// fixture -> team_away
		$this->addForeignKey('FK_fixture_team_away', 'fixture', 'away_team_id', 'team', 'team_id');

		// lague_table -> week
		$this->addForeignKey('FK_league_table_week', 'league_table', 'week_id', 'week', 'week_id');

		// lague_table -> team
		$this->addForeignKey('FK_league_table_team', 'league_table', 'team_id', 'team', 'team_id');


		/**
		** insert default data
		*/

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
			'week_id' => 1,
		    'home_team_id'	=>	1,
		    'away_team_id'	=>	2,
		)); 

		$command->insert('fixture', array(
			'week_id' => 1,
		    'home_team_id'	=>	3,
		    'away_team_id'	=>	4,
		)); 
	}

	public function safeDown()
	{
	}

}