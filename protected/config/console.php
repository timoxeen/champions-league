<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=champions_league',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '736726',
			'charset' => 'utf8',
			//'tablePrefix' => 'tbl_',
		)
	)
);