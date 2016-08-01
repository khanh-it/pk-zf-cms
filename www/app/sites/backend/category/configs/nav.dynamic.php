<?php
/**
 * Module's navigation file (dynamic)
 * @return array
 */
// Get Zend_Controller_Request_Abstract 
$frontReq = Zend_Controller_Front::getInstance()->getRequest();
// +++ Request params
$reqParams = $frontReq->getParams(); 
 
// Return
return array(
	// Category
    'category' => array(
        'pages' => array(
        	// Index
            'index' => array(
                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Danh sách[/span]',
                'module' => 'category',
                'controller' => 'index',
                'action' => 'index',
                'params' => array(
                	'type' => $reqParams['type']
				)
            ),
            // Create
            'create' => array(
                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Thêm mới[/span]',
                'module' => 'category',
                'controller' => 'index',
                'action' => 'create',
                'visible' => false,
                'params' => array(
                	'type' => $reqParams['type']
				)
            ),
            // Update
            'update' => array(
                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Cập nhật[/span]',
                'module' => 'category',
                'controller' => 'index',
                'action' => 'update',
                'visible' => false,
                'params' => array(
                	'type' => $reqParams['type'],
                	'id' => $reqParams['id'], 
				)
            ),
            // Detail
            'detail' => array(
                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Xem chi tiết[/span]',
                'module' => 'category',
                'controller' => 'index',
                'action' => 'detail',
                'visible' => false,
                'params' => array(
                	'type' => $reqParams['type'],
                	'id' => $reqParams['id'], 
				)
            )
		)
    ),
    // end.category 
);