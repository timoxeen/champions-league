<?php

class m140319_070722_week extends CDbMigration
{
	private $optionsForInnoDb = 'ENGINE=InnoDB DEFAULT CHARSET=utf8';

	public function safeUp()
	{
		$this->createTable('week',
			array(
				  'week_id' => "pk",
				  'season_id' => "int(11) NOT NULL",
				  'title' => "varchar(255) DEFAULT NULL",
				  'status' => 'enum("not-completed","completed") NOT NULL DEFAULT "not-completed"'
			),
			$this->optionsForInnoDb
		);
	}

	public function safeDown()
	{
		echo "m140319_070722_week does not support migration down.\n";
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