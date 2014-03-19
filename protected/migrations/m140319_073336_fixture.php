<?php

class m140319_073336_fixture extends CDbMigration
{

	private $optionsForInnoDb = 'ENGINE=InnoDB DEFAULT CHARSET=utf8';

	public function safeUp()
	{
		$this->createTable('fixture',
			array(
				  'fixture_id' => "pk",
				  'week_id' => "int(11) NOT NULL REFERENCES week(week_id)",
				  'home_team_id' => "int(11) NOT NULL REFERENCES team(team_id)",
				  'away_team_id' => "int(11) NOT NULL REFERENCES team(team_id)",
				  'home_team_goal' => "smallint(5) unsigned NOT NULL DEFAULT '0'",
				  'away_team_goal' => "smallint(5) unsigned NOT NULL DEFAULT '0'",
				  'status' => 'enum("not-completed","completed") NOT NULL DEFAULT "not-completed"'
			),
			$this->optionsForInnoDb
		);
	}

	public function safeDown()
	{
	}
	
}