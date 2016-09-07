<?php
/**
 * Site `frontend` configs;
 * @var array
 */
$configs = array(
// +++ default section
	'__default' => array(
		'resources' => array(
		// +++ Layout
			'layout' => array(
				'layout' => 'default',
				'layoutPath' => APPLICATION_PATH . "/sites/" . APPLICATION_SITE . "/_layouts/scripts/",
			),
		// End.Layout
		// +++ Front controller
			'frontController' => array(
				'baseUrl' => '/'
			)
		)
		// End.Front controller
	),
// +++ `development` section
	'development' => array(),

// +++ `production` section
	'production' => array(),
);

// Define constants
require_once 'constant/backend.php';

// Return;
return array_replace_recursive($configs['__default'], (array)$configs[APPLICATION_ENV]);