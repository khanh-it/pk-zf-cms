<?php
/**
 * Application's default configs;
 * @var array
 */
// Declare temp data variable;
$data = array(
// +++ 
	'app_path' => APPLICATION_PATH,
// +++
	'app_site' => APPLICATION_SITE,
// +++
	'app_lang' => APPLICATION_LANG,
);
// Declare configs variable;
$configs = array(
// +++ default section
	'__default' => array(
		'phpSettings' => array(
			//	
			'display_startup_errors' => false,
			//
			'display_errors' => false
		),
		
		'includePaths' => array(
			'library' => "{$data['app_path']}/../library"
		),
		
		'bootstrap' => array(
			'path' => "{$data['app_path']}/sites/{$data['app_site']}/Bootstrap.php",
			'class' => "Bootstrap"
		),
		
		// 
		'appnamespace' => "Application",

		//
		'autoloaderNamespaces' => array('K111'),

		//
		// Not works :(
		//'pluginPaths' => array(
		//	'K111_Application_Resource' => 'K111/Application/Resource/'
		//),
		
		'resources' => array(
		// +++ Multi modules
			'modules' => true,

			'frontController' => array(
				'moduleDirectory' => "{$data['app_path']}/sites/{$data['app_site']}/",
				'params' => array(
					'displayExceptions' => false
				)
			),
			
			'db' => array(
				'adapter' => 'PDO_MYSQL',
				'params' => array(
					'host' => 'localhost',
					'username' => 'root',
					'password' => '',
					'dbname' => 'db_pk_zf_cms'
				)
			),

			//'K111_Application_Resource_CheckDbConnection' => true,

			//
			'K111_Application_Resource_AssetsFinder' => array(
				'document_root' => DOCUMENT_ROOT,
				'upload_dir' => "/upload/{$data['app_site']}",
				'assets_dir' => '/assets',
				'site_dir' => "/{$data['app_site']}",
				'skin_dir' => "/default",
				'types' => array(
					'js' => 'js',
					'css' => 'css',
					'file' => 'file',
					'img' => 'img',
					'lib' => 'lib'
				)
			),
		)
	),
// +++ `development` section
	'development' => array(
		'phpSettings' => array(
			//	
			'display_startup_errors' => true,
			//
			'display_errors' => true
		),

		'resources' => array(
			'frontController' => array(
				'params' => array(
					'displayExceptions' => true
				)
			)
		)
	),

// +++ `production` section
	'production' => array(

	),
);

// Return;
// +++ 
unset($data);
// +++ 
return array_replace_recursive($configs['__default'], (array)$configs[APPLICATION_ENV]);