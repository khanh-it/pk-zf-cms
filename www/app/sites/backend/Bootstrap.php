<?php
/**
 * 
 * @author khanhdtp
 */
class Bootstrap extends K111_Application_Bootstrap_Bootstrap
{
    /**
     * 
     */
	protected function _initPaginator() {
	    //
	    Zend_Paginator::setDefaultScrollingStyle('Sliding');
	    //
	    Zend_Paginator::setDefaultItemCountPerPage($_GET['iccp'] ? $_GET['iccp'] : 128);
	    //
	    Zend_View_Helper_PaginationControl::setDefaultViewPartial('pager.phtml');
	}
}