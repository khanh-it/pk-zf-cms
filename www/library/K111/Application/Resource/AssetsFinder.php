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
class K111_Application_Resource_AssetsFinder extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * Set K111_AssetsFinder's default options.
     * @return K111_Assets_Finder
     */
    public function init()
    {
        // Get K111_Assets_Finder instance, + set default options. 
        return K111_AssetsFinder::getInstance($this->getOptions());
    }
}