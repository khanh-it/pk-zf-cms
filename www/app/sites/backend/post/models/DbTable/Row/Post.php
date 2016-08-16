<?php
/**
 * 
 * @author khanhdtp
 */
class Post_Model_DbTable_Row_Post extends K111_Db_Table_Row_BitStat
{
	/**
	 * Find current row's dependent post entry (phrase) data
	 * 
	 * @param $lang string Language string
	 * @return array
	 */
	public function findChildrenEntry($lang = null) {
		// 
		$rows = $this->findDependentRowset('Post_Model_DbTable_PostEntry', 'Post');
		// Return;
		return $rows->getGroupedData(
			Post_Model_DbTable_Post::PHRASE,
			$this->_data['id'],
			$lang
		);
	}
	
	/**
	 * Find current row's dependent tag item dta
	 * 
	 * @return Zend_Db_Table_Rowset_Abstract|array
	 */
	public function findChildrenTagItem() {
		// Fetch data
		$rows = $this->findDependentRowset('Post_Model_DbTable_TagItem', 'Post');
		
		// Return;
		return $rows->getGroupedData(
			Post_Model_DbTable_Post::TAG,
			$this->_data['id']
		);
	}
	
	/**
	 * Find current row's dependent post category data
	 * 
	 * @return Zend_Db_Table_Rowset_Abstract|array
	 */
	public function findChildrenPostCategory() {
		// Fetch data
		$rows = $this->findDependentRowset('Post_Model_DbTable_PostCategory', 'Post');
		
		// Return data
		$return = array();
		foreach ($rows as $row) {
			$return[$row->category_id] = $row->findParentCategory();
		}
		
		// Return;
		return $return;
	}
	
	/**
	 * Return account's avatar uploaded web path
	 * 
	 * @param $type string Post's type
	 * @return string
	 */
	public function returnImgsWebPath($type = null) {
		return Post_Model_DbTable_Post::returnImgsWebPath(
			$this->imgs, $type ?: $this->getTable()->getDefaultType()
		);
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
			// +++ Type 
			$this->modifyData('type', $this->getTable()->getDefaultType());
		}
		// +++ Always use default phrase context!
		$this->modifyData('phrase', Post_Model_DbTable_Post::PHRASE);
		// +++ Always use default tag context!
		$this->modifyData('tag', Post_Model_DbTable_Post::TAG);
	}
}