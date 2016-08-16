<?php
/**
 */
class Post_Model_DbTable_PostCategory extends Category_Model_DbTable_Category
{
	/**
     * The table name.
     * @var string
     */
    protected $_name = 'tbl_post_category';
    
    /**
     * The primary key column or columns.
     * @var mixed
     */
    protected $_primary = 'id';
	
    /**
     * Classname for row
     * @var string
     */
    protected $_rowClass = 'Post_Model_DbTable_Row_PostCategory';
	
    /**
     * Reference map
     */
    protected $_referenceMap = array(
        'Category' => array(
            'columns' => 'category_id',
            'refTableClass' => 'Post_Model_DbTable_Category',
            'refColumns' => array('id')
        ),
        'Post' => array(
            'columns' => 'post_id',
            'refTableClass' => 'Post_Model_DbTable_Post',
            'refColumns' => array('id')
        )
    );
	
// +++ Repo helpers
	
	/**
	 * 
	 */
	public function insertPostCategory($postId, $categoryId = null, array $options = array()) {
		// Format data
		$data = array();
		if (is_array($postId) && is_null($categoryId)) {
			$data = $postId;
		} else {
			$data[$postId] = $categoryId;
		}
		
		// Return data
		$return = array();
		
		// Clean old data?
		if ($options['clean_old_post_data']) {
			$this->delete(array(
				'post_id IN (?)' => array_keys($data)
			));
		}
		
		// Loop, insert (or update) data
		if (!empty($data)) {
			foreach ($data as $postId => $categoryId) {
				// Format category id
				$categoryId = array_filter(
					is_array($categoryId) ? $categoryId : (array)$categoryId
				);
				if (!empty($categoryId)) {
					foreach ($categoryId as $cId) {
						// Insert data (if not any)
						$row = $this->fetchRow(array(
							'post_id = ?' => $postId,
							'category_id = ?' => $cId
						));
						if (!$row) {
							$row = $this->createRow(array(
							// +++ Post 
								'post_id' => $postId,
							// +++ Category
								'category_id' => $cId,
							// +++ Creator
								'create_account_id' => $options['create_account_id']
							));
							$row->save();
						}
						// 
						$return[] = $row;
					}
				}
			}
		}
		
		// Return
		return $return;
	}
// +++ End.Repo helpers
}