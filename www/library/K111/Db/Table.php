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
     * The primary default values.
     * @var mixed
     */
    protected $_primaryValues;
	
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
     * Returns table name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }
	
	/**
     * Returns table primary key(s)
     * 
     * @return string|array
     */
    public function getPrimary()
    {
        return $this->_primary;
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
	
	/**
     * Fetches rows by primary key. 
	 * 
	 * Set default values for primary keys if available!
     *
     * @param  mixed $key The value(s) of the primary keys.
     * @return Zend_Db_Table_Rowset_Abstract Row(s) matching the criteria.
     * @throws Zend_Db_Table_Exception
     */
    public function find()
    {
    	$args = func_get_args();
		
		$argsCount = count($args);
		$argsZeroCount = count($args[0]);
		$primaryCount = count((array)$this->_primary);
		
    	if (($argsCount < $primaryCount) && $argsZeroCount && !empty($this->_primaryValues)) {
    		for ($i = $argsCount; $i < $primaryCount; $i++) {
    			$args[$i] = array_fill(0, $argsZeroCount, $this->_primaryValues[$i]);
    		}
    	}
    	
		return call_user_func_array(array('parent', __FUNCTION__), $args);
    }
}