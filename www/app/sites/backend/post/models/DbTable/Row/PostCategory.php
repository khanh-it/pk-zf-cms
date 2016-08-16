<?php
/**
 * 
 * @author khanhdtp
 */
class Post_Model_DbTable_Row_PostCategory extends K111_Db_Table_Row_Abstract
{
	/**
	 * Find current row's parent row category
	 * 
	 * @return Post_Model_DbTable_Row_Category|null
	 */
	public function findParentCategory() {
		return $this->findParentRowByRule('Category');
	}
	
	/**
	 * Find current row's parent row post
	 * 
	 * @return Post_Model_DbTable_Row_Post|null
	 */
	public function findParentPost() {
		return $this->findParentRowByRule('Post');
	}
	
	/**
	 * Initialize object
	 *
	 * @return void
	 */
	public function init()
	{
	    // Set default data
	    if ($this->isClean()) {
		    // +++ 
		    $date = new DateTime();
			$this->modifyData('created_time', $date->format('Y-m-d H:i:s'));
		}
	}
}