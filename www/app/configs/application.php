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
			'display_errors' => false,
			// Set default timezone;
			'date' => array(
				'timezone' => 'Asia/Ho_Chi_Minh'
			)
		),
		
		'includePaths' => array(
			'library' => "{$data['app_path']}/../library"
		),
		
		'bootstrap' => array(
			'path' => "{$data['app_path']}/sites/{$data['app_site']}/Bootstrap.php",
			'class' => "Bootstrap"
		),
		
		// 
		'appnamespace' => "App",

		//
		'autoloaderNamespaces' => array('Twitter', 'K111'),

		//
		// Not works :(
		//'pluginPaths' => array(
		//	'K111_Application_Resource' => 'K111/Application/Resource/'
		//),
		
		'resources' => array(
		// +++ Layout
			'layout' => array(
				'layout' => 'default',
				'layoutPath' => "{$data['app_path']}/sites/{$data['app_site']}/_layouts/scripts",
			),
		// End.Layout
		// +++ Multi modules
			'modules' => true,
		// End.Multi modules
		// +++ Front controller
			'frontController' => array(
			// Register custom action helpers.
				'actionHelperPaths' => array(
					'K111_Controller_Action_Helper' => 'K111/Controller/Action/Helper'
				),
			// 
				'moduleDirectory' => "{$data['app_path']}/sites/{$data['app_site']}/",
			// 
                'plugins' => array(
                    'K111_Controller_Plugin_SystemHooks'
                ),
			// 
				'params' => array(
					'displayExceptions' => false,
                // Flag: enviroment modes?
				    'isEnvDevelopment' => ('development' == APPLICATION_ENV),
				    'isEnvProduction' => ('production' == APPLICATION_ENV),
				    'isEnvTesting' => ('testing' == APPLICATION_ENV)
				),
			),
		// Edn.Front controller
		// +++ Cache manager
			'cacheManager' => array(
			// Used to cache hole page.
				'page' => array(
					'frontend' => array(
						'name' => 'Core',
						'customFrontendNaming' => false,
						'options' => array(
							'lifetime' => (5 * 60),
							'automatic_serialization' => false
						),
					),
					'backend' => array(
						'name' => 'File',
						'customBackendNaming' => false,
						'options' => array(
							'cache_dir' => "{$data['app_path']}/../data/cache/pages",
						)
					),
					// Lazy load;
					'frontendBackendAutoload' => false
				),
			// Used to cache data only
				'data' => array(
					'frontend' => array(
						'name' => 'Core',
						'customFrontendNaming' => false,
						'options' => array(
							'lifetime' => (30 * 60),
							'automatic_serialization' => true
						),
					),
					'backend' => array(
						'name' => 'File',
						'customBackendNaming' => false,
						'options' => array(
							'cache_dir' => "{$data['app_path']}/../data/cache/data",
						)
					),
					// Lazy load;
					'frontendBackendAutoload' => false
				), 
			),
		// End.Cache manager;
		// +++ Log
			'log' => array(
				'timestampFormat' => 'Y-m-d',
				array(
					'writerName' => 'Stream',
					'writerParams' => array(
						'stream' => "{$data['app_path']}/../data/logs/{$data['app_site']}.log",
						'mode' => 'a'
					),
					//'filterName' => 'Priority',
					//'filterParams' => array('priority' => 4),
					//'formatterName' => 'Simple',
					//'formatterParams' => array('format' => '%timestamp%: %message% -- %info%'),
				)
			),
		// End.Log	
		// +++ Database	
			'db' => array(
				'adapter' => 'PDO_MYSQL',
				'params' => array(
					'host' => 'localhost',
					'username' => 'root',
					'password' => '',
					'dbname' => 'db_pk_zf_cms'
				),
				'isDefaultTableAdapter' => true
			),
		// End.Database
        // View
            'view' => array(
            // Register view's helper;
                'helperPath' => array(
                    'App_View_Helper' => "{$data['app_path']}/views/helpers/"
                )
            ),
		// View
		// +++ K111_Application_Resource_CheckDbConnection
			//'K111_Application_Resource_CheckDbConnection' => true,
		// End.K111_Application_Resource_CheckDbConnection
		// +++ K111_Application_Resource_AssetsFinder
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
		// End.K111_Application_Resource_AssetsFinder
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