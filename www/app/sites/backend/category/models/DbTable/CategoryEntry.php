<?php
/**
 * 
 * @author khanhdtp
 */
class Category_Model_DbTable_CategoryEntry extends Default_Model_DbTable_Phrase
{
    /**
     * Reference map
     */
    protected $_referenceMap = array(
        'Category' => array(
            'columns' => array('phr_context', 'phr_rel_id'),
            'refTableClass' => 'Category_Model_DbTable_Category',
            'refColumns' => array('phrase', 'id'),
            'onDelete' => self::CASCADE,
            'onUpdate' => self::CASCADE
        )
    );
}