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
		$this->addForeignKey('FK_week_season', 'week', 'season_id', 'season', 'season_id', 'NO ACTION', 'NO ACTION');

		// fixture -> week
		$this->addForeignKey('FK_fixture_week', 'fixture', 'week_id', 'week', 'week_id', 'NO ACTION', 'NO ACTION');

		// fixture -> team_home
		$this->addForeignKey('FK_fixture_team_home', 'fixture', 'home_team_id', 'team', 'team_id', 'NO ACTION', 'NO ACTION');

		// fixture -> team_away
		$this->addForeignKey('FK_fixture_team_away', 'fixture', 'away_team_id', 'team', 'team_id', 'NO ACTION', 'NO ACTION');

		// lague_table -> week
		$this->addForeignKey('FK_league_table_week', 'league_table', 'week_id', 'week', 'week_id', 'NO ACTION', 'NO ACTION');

		// lague_table -> team
		$this->addForeignKey('FK_league_table_team', 'league_table', 'team_id', 'team', 'team_id', 'NO ACTION', 'NO ACTION');


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

	}

	public function safeDown()
	{
	}

}