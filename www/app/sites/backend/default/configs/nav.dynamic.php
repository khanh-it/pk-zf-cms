<?php
/**
 * Module's navigation file (static)
 * @return array
 */
// Get Zend_Controller_Request_Abstract 
$frontReq = Zend_Controller_Front::getInstance()->getRequest();
// +++ Request params
$reqParams = $frontReq->getParams(); 

// Return
return array(
	'default' => array(
        'pages' => array(
			// group //
		    'group' => array(
		        'pages' => array(
		            //
		            'index' => array(
		                'pages' => array(
		                	//
				            'create' => array(
				                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Thêm mới[/span]',
				                'module' => 'default',
				                'controller' => 'group',
				                'action' => 'create',
				                'visible' => false,
				            ),
				            // Update
				            'update' => array(
				                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Cập nhật[/span]',
				                'module' => 'default',
				                'controller' => 'group',
				                'action' => 'update',
				                'visible' => false,
				                'params' => array(
				                	'id' => $reqParams['id'], 
								)
				            ),
				            // Detail
				            'detail' => array(
				                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Xem chi tiết[/span]',
				                'module' => 'default',
				                'controller' => 'group',
				                'action' => 'detail',
				                'visible' => false,
				                'params' => array(
				                	'id' => $reqParams['id'], 
								)
				            ),
				            // Acl
				            'acl' => array(
				                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Phân quyền truy cập[/span]',
				                'module' => 'default',
				                'controller' => 'group',
				                'action' => 'acl',
				                'visible' => false,
				                'params' => array(
				                	'id' => $reqParams['id'], 
								)
				            )
						)
		            ),
		        )
		    ),
		    // end.group //
		    
			// account //
		    'account' => array(
		        'pages' => array(
		            //
		            'index' => array(
		                'pages' => array(
		                	//
				            'create' => array(
				                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Thêm mới[/span]',
				                'module' => 'default',
				                'controller' => 'account',
				                'action' => 'create',
				                'visible' => false,
				            ),
				            // Update
				            'update' => array(
				                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Cập nhật[/span]',
				                'module' => 'default',
				                'controller' => 'account',
				                'action' => 'update',
				                'visible' => false,
				                'params' => array(
				                	'id' => $reqParams['id'], 
								)
				            ),
				            // Detail
				            'detail' => array(
				                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Xem chi tiết[/span]',
				                'module' => 'default',
				                'controller' => 'account',
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
		    // end.account //
		)
	)
);