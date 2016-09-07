<?php
/**
 * Module's navigation file (static)
 * @return array
 */
return array(
	// dashboard
    'dashboard' => array(
        'label' => '[i class="zmdi zmdi-home"][/i] [span]Dashboard[/span]',
        'title' => 'Dashboard',
        'module' => ''
    ),
    // end.dashboard
    
    // system
    'default' => array(
        'label' => '[i class="zmdi zmdi-layers"][/i] [span]Hệ thống[/span] [i class="fa fa-angle-left pull-right"][/i]',
        'class' => '',
        'uri' => 'javascript:void(0);',
        'pages' => array(
	        // group
	        'group' => array(
	            'label' => '[i class="zmdi zmdi-layers"][/i] [span]Nhóm tài khoản[/span] [i class="fa fa-angle-left pull-right"][/i]',
	            'class' => '',
	            'uri' => '#',
	            'pages' => array(
	                // 
	                'index' => array(
	                    'label' => '[i class="zmdi zmdi-layers"][/i] [span]Danh sách[/span]',
	                    'module' => 'default',
	                    'controller' => 'group',
	                    'action' => 'index',
	                ),
	                //
	                'insert' => array(
	                    'label' => '[i class="zmdi zmdi-layers"][/i] [span]Thêm mới[/span]',
	                    'module' => 'default',
	                    'controller' => 'group',
	                    'action' => 'create',
	                )
	            )
	        ),
	        // end.group
	        
	        // account //
	        'account' => array(
	            'label' => '[i class="zmdi zmdi-layers"][/i] [span]Tài khoản[/span] [i class="fa fa-angle-left pull-right"][/i]',
	            'class' => '',
	            'uri' => 'javascript:void(0);',
	            'pages' => array(
	                //
	                'index' => array(
	                	'label' => '[i class="zmdi zmdi-layers"][/i] [span]Danh sách[/span]',
	                    'module' => 'default',
	                    'controller' => 'account',
	                    'action' => 'index',
	                ),
	                //
	                'insert' => array(
	                    'label' => '[i class="zmdi zmdi-layers"][/i] [span]Thêm mới[/span]',
	                    'module' => 'default',
	                    'controller' => 'account',
	                    'action' => 'insert',
	                ),
	                //
	                'profile' => array(
	                    'label' => '[i class="zmdi zmdi-layers"][/i] [span]Hồ sơ cá nhân[/span]',
	                    'module' => 'default',
	                    'controller' => 'account',
	                    'action' => 'profile',
	                    'visible' => false,
	                ),
	                //
	                'settings' => array(
	                    'label' => '[i class="zmdi zmdi-layers"][/i] [span]Cài đặt khác[/span]',
	                    'module' => 'default',
	                    'controller' => 'account',
	                    'action' => 'settings',
	                    'visible' => false,
	                )
	            )
	        ),
	        // end.account //
	        
	        // tag //
	        'tag' => array(
	            'label' => '[i class="zmdi zmdi-layers"][/i] [span]Tags[/span]',
	            'class' => '',
	            'module' => 'default',
	            'controller' => 'tag',
	            'action' => 'index'
	        ),
	        // end.tag //
		)
		// end.system 
	)
);