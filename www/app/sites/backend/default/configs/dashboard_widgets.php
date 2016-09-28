<?php
/**
 * Module's dashboard widgets
 * @return array
 */
return array(
	//  
	($widgetOffset = 1000) => array(
		'name' => '',
		'note' => '',
		'module' => 'default',
		'controller' => 'widget',
		'action' => 'widget-list-modules',
		'params' => array()
	),
	//  
	($widgetOffset += 10) => array(
		'name' => 'Report something',
		'note' => 'Report something...',
		'module' => 'default',
		'controller' => 'widget',
		'action' => 'widget-report-something',
		'params' => array()
	)
);