<?php
/**
 * Site `frontend` configs;
 * @var array
 */
$configs = array(
// +++ default section
	'__default' => array(
		'resources' => array(
			'frontController' => array(
				'baseUrl' => '/'
			)
		)
	),
// +++ `development` section
	'development' => array(),

// +++ `production` section
	'production' => array(),
);

// Return;
return array_replace_recursive($configs['__default'], (array)$configs[APPLICATION_ENV]);