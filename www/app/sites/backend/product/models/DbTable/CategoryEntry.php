<?php
/**
 * 
 * @author khanhdtp
 */
class Product_Model_DbTable_CategoryEntry extends Default_Model_DbTable_Phrase
{
	/**
     * Initialize object
     *
     * Called from {@link __construct()} as final step of object instantiation.
     *
     * @return void
     */
    public function init()
    {
    	// Setup Reference map
    	$this->_referenceMap = array_merge($this->_referenceMap, array(
	    	'Category' => array(
	            'columns' => array('phr_context', 'phr_rel_id'),
	            'refTableClass' => 'Product_Model_DbTable_Category',
	            'refColumns' => array('phrase', 'id'),
	            'onDelete' => self::CASCADE,
	            'onUpdate' => self::CASCADE
	        )
		));
    }
}