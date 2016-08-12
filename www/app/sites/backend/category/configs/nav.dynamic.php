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
);