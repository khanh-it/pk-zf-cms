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
	// post.category //
    'post.category' => array(
        'pages' => array(
            'index' => array(
                'pages' => array(
                	// Create
					'create' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Thêm mới[/span]',
		                'module' => 'post',
		                'controller' => 'category',
		                'action' => 'create',
		                'visible' => false
		            ),
		            // Update
		            'update' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Cập nhật[/span]',
		                'module' => 'post',
		                'controller' => 'category',
		                'action' => 'update',
		                'visible' => false,
		                'params' => array(
		                	'id' => $reqParams['id'], 
						)
		            ),
		            // Detail
		            'detail' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Xem chi tiết[/span]',
		                'module' => 'post',
		                'controller' => 'category',
		                'action' => 'detail',
		                'visible' => false,
		                'params' => array(
		                	'id' => $reqParams['id'], 
						)
		            )
				)
            ),
		)
    ),
    // end.post.category //
    
    // post.post //
    'post.post' => array(
        'pages' => array(
            'index' => array(
                'pages' => array(
                	// Create
		            'create' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Thêm mới[/span]',
		                'module' => 'post',
		                'controller' => 'post',
		                'action' => 'create',
		                'visible' => false
		            ),
		            // Update
		            'update' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Cập nhật[/span]',
		                'module' => 'post',
		                'controller' => 'post',
		                'action' => 'update',
		                'visible' => false,
		                'params' => array(
		                	'id' => $reqParams['id'], 
						)
		            ),
		            // Detail
		            'detail' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Xem chi tiết[/span]',
		                'module' => 'post',
		                'controller' => 'post',
		                'action' => 'detail',
		                'visible' => false,
		                'params' => array(
		                	'id' => $reqParams['id'], 
						)
		            )
				),
			),
		)
    ),
    // end.post.post // 
);