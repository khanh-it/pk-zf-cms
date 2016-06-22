<?php
// Define site's baseurl;
// +++ Frontend
define('BASEURL_FRONTEND', '/');
// +++ Backend
define('BASEURL_BACKEND', '/admincp/');

// Define `sites`.
$data['sites'] = array(
	// Site 1
	array(
		// Domain list
		array($_SERVER['SERVER_NAME']),
		// Site's configs
		array(
			BASEURL_FRONTEND => array('frontend', 'vi'),
			BASEURL_BACKEND => array('backend', 'vi'),
		)
	)
);

// Get, + format request's uri.
$data['REQUEST_URI'] = str_replace("?{$_SERVER['QUERY_STRING']}", '', $_SERVER['REQUEST_URI']);
$data['REQUEST_URI'] = str_replace('//', '/', "{$data['REQUEST_URI']}/");

// Loop, detect `site`;
$siteConfigs = null;
foreach ($data['sites'] as $data['site']) {
	list($data['arrDomain'], $data['arrSiteConfs']) = $data['site'];

	if (in_array($_SERVER['SERVER_NAME'], $data['arrDomain'])) {
		foreach ($data['arrSiteConfs'] as $data['baseUrl'] => $data['configs']) {
			if (0 === strpos($data['REQUEST_URI'], "{$data['baseUrl']}")) {
				$siteConfigs = $data['configs'];
			}
		}
	}
}


// Case: site was not mactched!
if (!$siteConfigs) {
	echo 'Site was not found!';
	exit(1);
}

// Define app's site
define('APPLICATION_SITE', $siteConfigs[0]);

// Define app's langguage
define('APPLICATION_LANG', $siteConfigs[1]);

// Unset data;
unset($data, $siteConfigs);