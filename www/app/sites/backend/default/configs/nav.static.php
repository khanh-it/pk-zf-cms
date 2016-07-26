<?php
/**
 * Module's navigation file (static)
 * @return array
 */
return array(
// SECTION #
    //'default' => array(
    // dashboard
        /*'dashboard-header' => array(
            'label' => '[i class="zmdi zmdi-layers"][/i] PK-ZF-CMS # MAIN NAVIGATION',
            'class' => 'li-header',
            'uri' => '' // Noted: an empty string!
        ),*/
        'dashboard' => array(
            'label' => '[i class="zmdi zmdi-home"][/i] [span]Dashboard[/span]',
            'title' => 'Dashboard',
            'module' => ''
        ),
    // end.dashboard

    // system
        // #label
        /*'system-label' => array(
            'label' => '[i class="zmdi zmdi-layers"][/i] HỆ THỐNG',
            'class' => 'li-header',
            'uri' => ''
        ),*/
        // group
        'group' => array(
            'label' => '[i class="zmdi zmdi-layers"][/i] [span]Nhóm tài khoản[/span] [i class="fa fa-angle-left pull-right"][/i]',
            'class' => '',
            'uri' => '#',
            'pages' => array(
                // 
                'index' => array(
                    'label' => '[i class="zmdi zmdi-layers"][/i] [span]Danh mục[/span]',
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
        // account
        'account' => array(
            'label' => '[i class="zmdi zmdi-layers"][/i] [span]Tài khoản[/span] [i class="fa fa-angle-left pull-right"][/i]',
            'class' => '',
            'uri' => '#',
            'pages' => array(
                //
                'index' => array(
                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Danh mục[/span]',
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
                )
            )
        ),
        // end.account
    // end.system
    //) 
);