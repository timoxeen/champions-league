<?php

class m140319_064849_season extends CDbMigration
{
	private $optionsForInnoDb = 'ENGINE=InnoDB DEFAULT CHARSET=utf8';

	public function safeUp()
	{
		$this->createTable('season',
			array(
				  "season_id" => "pk",
				  "title" => "varchar(255) DEFAULT NULL",
				  'status' => 'enum("active","completed") NOT NULL DEFAULT "active"'
			),
			$this->optionsForInnoDb
		);
	}

	public function safeDown()
	{
		echo "m140319_064849_season does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}