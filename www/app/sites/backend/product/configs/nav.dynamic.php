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
	'product' => array(
        'label' => '[i class="zmdi zmdi-layers"][/i] [span]Sản phẩm[/span] [i class="fa fa-angle-left pull-right"][/i]',
        'class' => '',
        'uri' => 'javascript:void(0);',
        'pages' => array(
			// category //
		    'category' => array(
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
				            ),
				            // Language
				            'language' => array(
				                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Dịch ngôn ngữ[/span]',
				                'module' => 'product',
				                'controller' => 'category',
				                'action' => 'language',
				                'visible' => false,
				                'params' => array(
				                	'id' => $reqParams['id'], 
								)
				            )
						)
		            ),
				)
		    ),
		    // end.category //
		    
		    // product //
		    'product' => array(
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
				            ),
				            // Language
				            'language' => array(
				                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Dịch ngôn ngữ[/span]',
				                'module' => 'product',
				                'controller' => 'product',
				                'action' => 'language',
				                'visible' => false,
				                'params' => array(
				                	'id' => $reqParams['id'], 
								)
				            )
						),
					),
				)
		    ),
		    // end.product //
		)
	)
);