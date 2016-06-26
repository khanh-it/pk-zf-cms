<?php
/**
 * pk-zf-cms (Zend Framework powered)
 *
 * LICENSE
 *
 * Free
 *
 * @category   K111
 * @package    K111_Db
 * @copyright  Free
 * @license    
 * @version    
 */

/**
 * Class for SQL table interface.
 *
 * @category   K111
 * @package    K111_Db
 * @copyright  Free
 * @license    
 */
class K111_Db_Table extends Zend_Db_Table_Abstract
{

    /**
     * __construct() - For concrete implementation of Zend_Db_Table
     *
     * @param string|array $config string can reference a Zend_Registry key for a db adapter
     *                             OR it can reference the name of a table
     * @param array|Zend_Db_Table_Definition $definition
     */
    public function __construct($config = array(), $definition = null)
    {
        if ($definition !== null && is_array($definition)) {
            $definition = new Zend_Db_Table_Definition($definition);
        }

        if (is_string($config)) {
            if (Zend_Registry::isRegistered($config)) {
                trigger_error(__CLASS__ . '::' . __METHOD__ . '(\'registryName\') is not valid usage of Zend_Db_Table, '
                    . 'try extending Zend_Db_Table_Abstract in your extending classes.',
                    E_USER_NOTICE
                    );
                $config = array(self::ADAPTER => $config);
            } else {
                // process this as table with or without a definition
                if ($definition instanceof Zend_Db_Table_Definition
                    && $definition->hasTableConfig($config)) {
                    // this will have DEFINITION_CONFIG_NAME & DEFINITION
                    $config = $definition->getTableConfig($config);
                } else {
                    $config = array(self::NAME => $config);
                }
            }
        }

        parent::__construct($config);
    }
    
    /**
     * Returns a normalized version of the reference map
     * 
     * @param string $rule Rule
     * @return array
     */
    public function getReferenceMap($rule = null)
    {
        // Get reference map normalized
        $refMap = $this->_getReferenceMapNormalized();
        // Return
        return $rule ? $refMap[$rule] : $refMap;
    }
}