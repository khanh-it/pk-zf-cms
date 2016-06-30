<?php
// Define path to public directory
define('DOCUMENT_ROOT', realpath(dirname(__FILE__)));

// Define path to project directory
define('PROJECT_ROOT', DOCUMENT_ROOT . '/../');

// Define path to application directory
define('APPLICATION_PATH', PROJECT_ROOT . '/app');

// Define application environment
define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Detect `site`!
require_once APPLICATION_PATH . '/configs/__apps.php';

// Typically, you will also want to add your library directory
// to the include_path, particularly if it contains your ZF installed
set_include_path(
	implode(PATH_SEPARATOR, array(
		dirname(dirname(__FILE__)) . '/library',
		get_include_path()
	))
);
 
/** Zend_Application */
require_once 'Zend/Application.php';
// Load configs
// +++ default configs
$appConfs = (array)require_once (APPLICATION_PATH . '/configs/application.php');
// +++ site's configs
$siteConfs = (array)require_once (APPLICATION_PATH . '/configs/' . APPLICATION_SITE . '.php');

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    array_replace_recursive($appConfs, $siteConfs)
);
$application->bootstrap()->run();