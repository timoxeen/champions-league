<?php

class m140319_064311_team extends CDbMigration
{
	private $optionsForInnoDb = 'ENGINE=InnoDB DEFAULT CHARSET=utf8';

	public function safeUp()
	{
		$this->createTable('team',
			array(
				  "team_id" => "pk",
				  "title" => "varchar(255) DEFAULT NULL"
			),
			$this->optionsForInnoDb
		);
	}

	public function safeDown()
	{
		echo "m140319_064311_team does not support migration down.\n";
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