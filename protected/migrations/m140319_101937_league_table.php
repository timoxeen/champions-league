<?php

class m140319_101937_league_table extends CDbMigration
{
	private $optionsForInnoDb = 'ENGINE=InnoDB DEFAULT CHARSET=utf8';

	public function safeUp()
	{
		$this->createTable('league_table',
			array(
				  'league_table_id' => "pk",
				  'season_id' => "int(10) unsigned NOT NULL REFERENCES season(season_id)",
				  'week_id' => "int(10) unsigned NOT NULL REFERENCES week(week_id)",
				  'team_id' => "int(10) unsigned NOT NULL REFERENCES team(team_id)",
				  'total_win' => "smallint(5) unsigned NOT NULL DEFAULT '0'",
				  'total_lost' => "smallint(5) unsigned NOT NULL DEFAULT '0'",
				  'total_deuce' => "smallint(5) unsigned NOT NULL DEFAULT '0'",
				  'goal_forward' => "smallint(5) unsigned NOT NULL DEFAULT '0'",
				  'goal_against' => "smallint(5) unsigned NOT NULL DEFAULT '0'",
				  'goal_difference' => "smallint(5) NOT NULL DEFAULT '0'"
			),
			$this->optionsForInnoDb
		);
	}
	public function safeDown()
	{
	}

}