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
	// product.category //
    'product.category' => array(
        'pages' => array(
            'index' => array(
                'pages' => array(
                	// Create
					'create' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Thêm mới[/span]',
		                'module' => 'product',
		                'controller' => 'category',
		                'action' => 'create',
		                'visible' => false
		            ),
		            // Update
		            'update' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Cập nhật[/span]',
		                'module' => 'product',
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
		                'module' => 'product',
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
    // end.product.category //
    
    // product.product //
    'product.product' => array(
        'pages' => array(
            'index' => array(
                'pages' => array(
                	// Create
		            'create' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Thêm mới[/span]',
		                'module' => 'product',
		                'controller' => 'product',
		                'action' => 'create',
		                'visible' => false
		            ),
		            // Update
		            'update' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Cập nhật[/span]',
		                'module' => 'product',
		                'controller' => 'product',
		                'action' => 'update',
		                'visible' => false,
		                'params' => array(
		                	'id' => $reqParams['id'], 
						)
		            ),
		            // Detail
		            'detail' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Xem chi tiết[/span]',
		                'module' => 'product',
		                'controller' => 'product',
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
    // end.product.product // 
);