<?php
return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			'db'=>array(
				'connectionString' => 'mysql:host=onurdegerli.db.6611725.hostedresource.com;dbname=onurdegerli',
				'emulatePrepare' => true,
				'username' => 'onurdegerli',
				'password' => '7523ba889f11',
				'charset' => 'utf8',
			),
		),
	)
);
