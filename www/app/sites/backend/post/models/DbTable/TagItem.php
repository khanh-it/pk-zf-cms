<?php
/**
 * 
 * @author khanhdtp
 */
class Post_Model_DbTable_TagItem extends Default_Model_DbTable_TagItem
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
	    	'Post' => array(
	            'columns' => array('context', 'item_id'),
	            'refTableClass' => 'Post_Model_DbTable_Post',
	            'refColumns' => array('tag', 'id'),
	            'onDelete' => self::CASCADE,
	            'onUpdate' => self::CASCADE
	        )
		));
    }
}