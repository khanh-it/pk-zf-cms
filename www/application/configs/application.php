<?php
/**
 */
return array(
	'phpSettings' => array(
		//	
		'display_startup_errors' => true,
		//
		'display_errors' => true
	),
	
	'includePaths' => array(
		'library' => APPLICATION_PATH . "/../library"
	),
	
	'bootstrap' => array(
		'path' => APPLICATION_PATH . "/Bootstrap.php",
		'class' => "Bootstrap"
	),
	
	'appnamespace' => "Application",
	
	'resources' => array(
		'frontController' => array(
			'controllerDirectory' => APPLICATION_PATH . "/controllers",
			'params' => array(
				'displayExceptions' => true
			)
		),
		
		'db' => array(
			'adapter' => 'PDO_MYSQL',
			'params' => array(
				'host' => 'localhost',
				'username' => 'root',
				'password' => '',
				'dbname' => 'db_booking'
			)
		)
	)
);