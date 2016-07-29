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
 * @subpackage K111_Db_Table_Row
 * @copyright  Free
 * @license    
 * @version    
 */

/**
 * @category   K111
 * @package    K111_Db
 * @subpackage K111_Db_Table_Row
 * @copyright  Free
 * @license    
 */
class K111_Db_Table_Row_Abstract extends Zend_Db_Table_Row_Abstract
{
    /**
     * Retrieve row field value
     *
     * @param  string $columnName The user-specified column name.
     * @return string             The corresponding column value.
     * @throws Zend_Db_Table_Row_Exception if the $columnName is not a column in the row.
     */
    public function __get($columnName)
    {
    	$columnName = $this->_transformColumn($columnName);
        $funcName = 'get' . ucfirst($columnName);
        if (method_exists($this, $funcName)) {
            return $this->{$funcName}();
        }
        
        return parent::__get($columnName);
    }
    
    /**
     * Set row field value
     *
     * @param  string $columnName The column key.
     * @param  mixed  $value      The value for the property.
     * @return void
     * @throws Zend_Db_Table_Row_Exception
     */
    public function __set($columnName, $value)
    {
    	$columnName = $this->_transformColumn($columnName);
        $funcName = 'set' . ucfirst($columnName);
        if (method_exists($this, $funcName)) {
        	$this->_modifiedFields[$columnName] = true;
            return $this->{$funcName}($value);
        }
        
        return parent::__set($columnName, $value);
    }
    
    /**
     * Query a parent table to retrieve the single row matching the reference rule.
     *
     * @param string $rule Rule
     * @proxy ::findParentRow
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function findParentRowByRule($rule) {
        $refMapItem = $this->getTable()->getReferenceMap($rule);
        if ($refMapItem) {
            return $this->findParentRow($refMapItem[Zend_Db_Table_Abstract::REF_TABLE_CLASS], $rule);
        }
    }
}