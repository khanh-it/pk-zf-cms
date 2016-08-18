<?php
/**
 * Module's navigation file (static)
 * @return array
 */
return array(
	'post' => array(
        'label' => '[i class="zmdi zmdi-layers"][/i] [span]Bài viết[/span] [i class="fa fa-angle-left pull-right"][/i]',
        'class' => '',
        'uri' => 'javascript:void(0);',
        'pages' => array(
			// category //
		    'category' => array(
		        'label' => '[i class="zmdi zmdi-layers"][/i] [span]Danh mục bài viết[/span] [i class="fa fa-angle-left pull-right"][/i]',
		        'class' => '',
		        'uri' => 'javascript:void(0);',
		        'pages' => array(
		            // 
		            'index' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Danh sách[/span]',
		                'module' => 'post',
		                'controller' => 'category',
		                'action' => 'index',
		            ),
		            // 
		            'insert' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Thêm mới[/span]',
		                'module' => 'post',
		                'controller' => 'category',
		                'action' => 'create',
		            ),
		        )
		    ),
		    // end.category //
		    
		    // post //
		    'post' => array(
		        'label' => '[i class="zmdi zmdi-layers"][/i] [span]Bài viết[/span] [i class="fa fa-angle-left pull-right"][/i]',
		        'class' => '',
		        'uri' => '#',
		        'pages' => array(
		            // 
		            'index' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Danh sách[/span]',
		                'module' => 'post',
		                'controller' => 'post',
		                'action' => 'index',
		            ),
		            //
		            'insert' => array(
		                'label' => '[i class="zmdi zmdi-layers"][/i] [span]Thêm mới[/span]',
		                'module' => 'post',
		                'controller' => 'post',
		                'action' => 'create',
		            )
		        )
		    ),
		    // end.post //
		)
	)
);