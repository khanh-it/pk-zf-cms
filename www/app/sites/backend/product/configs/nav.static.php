<?php
/**
 * Module's navigation file (static)
 * @return array
 */
return array(
    'product' => array(
        'label' => '[i class="zmdi zmdi-layers"][/i] [span]Sản phẩm[/span] [i class="fa fa-angle-left pull-right"][/i]',
        'class' => '',
        'uri' => 'javascript:void(0);',
        'pages' => array(
			// category //
		    'category' => array(
		        'label' => '[i class="zmdi zmdi-layers"][/i] [span]Danh mục sản phẩm[/span] [i class="fa fa-angle-left pull-right"][/i]',
		        'class' => '',
		        'uri' => 'javascript:void(0);',
		        'pages' => array(
		            // 
		            'index' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Danh sách[/span]',
		                'module' => 'product',
		                'controller' => 'category',
		                'action' => 'index',
		            ),
		            // 
		            'insert' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Thêm mới[/span]',
		                'module' => 'product',
		                'controller' => 'category',
		                'action' => 'create',
		            ),
		        )
		    ),
		    // end.category //
		    
		    // product //
		    'product' => array(
		        'label' => '[i class="zmdi zmdi-layers"][/i] [span]Sản phẩm[/span] [i class="fa fa-angle-left pull-right"][/i]',
		        'class' => '',
		        'uri' => '#',
		        'pages' => array(
		            // 
		            'index' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Danh sách[/span]',
		                'module' => 'product',
		                'controller' => 'product',
		                'action' => 'index',
		            ),
		            //
		            'insert' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Thêm mới[/span]',
		                'module' => 'product',
		                'controller' => 'product',
		                'action' => 'create',
		            )
		        )
		    ),
		    // end.product //
		)
	)
);