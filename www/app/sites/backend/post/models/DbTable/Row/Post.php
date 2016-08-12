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
	 * @param $tagId int|string Tag id
	 * @return Zend_Db_Table_Rowset_Abstract|array
	 */
	public function findChildrenTagItem($tagId = null) {
		// Fetch data
		$rows = $this->findDependentRowset('Post_Model_DbTable_TagItem', 'Post');
		
		// Return;
		return $rows->getGroupedData(
			Post_Model_DbTable_Post::TAG,
			$this->_data['id'],
			$tagId
		);
	}
	
	/**
	 * Return account's avatar uploaded web path
	 * 
	 * @param $avatar string Account's avatar
	 * @return string
	 */
	public function returnImgsWebPath() {
		return Post_Model_DbTable_Post::returnImgsWebPath($this->imgs);
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
			$this->modifyData('type', Post_Model_DbTable_Post::getDefaultType());
		}
		// +++ Always use default phrase context!
		$this->modifyData('phrase', Post_Model_DbTable_Post::PHRASE);
	}
}