<?php
/**
 * pk-zf-cms (Zend Framework powered)
 *
 * LICENSE
 *
 * Free
 *
 * @category   K111
 * @package    K111_Application
 * @subpackage Resource
 * @copyright  Free
 * @license    
 * @version    
 */

/**
 * Resource for checking database connection
 *
 * @uses       Zend_Application_Resource_ResourceAbstract
 * @category   K111
 * @package    K111_Application
 * @subpackage Resource
 * @copyright  Free
 * @license    
 */
class K111_Application_Resource_CheckDbConnection extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * 
     * @throws Exception 
     * @return void
     */
    public function init()
    {
        $bt = $this->getBootstrap();
        if ($bt->hasPluginResource('db')) {
            try {
                $bt->bootstrap('db');
                $db = $bt->getResource('db');
                if ($db) {
                    $db->getConnection();
                }
            } catch (Exception $e) {
                die('Database connection failed. Err msg: ' . $e->getMessage());
            }
        }
    
        return true;
    }
}