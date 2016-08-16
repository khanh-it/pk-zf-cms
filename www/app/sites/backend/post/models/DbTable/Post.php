<?php
/**
 */
class Post_Model_DbTable_Post extends K111_Db_Table
{
	/**
	 * @var string 
	 */
	const PHRASE = 'POST';
	
	/**
	 * @var string 
	 */
	const TAG = 'POST';
	
	/**
	 * @var string Category's type: POST
	 */
	const CATEGORY_TYPE_POST = 'POST';
	
    /**
     * The table name.
     * @var string
     */
    protected $_name = 'tbl_post';
    
    /**
     * The primary key column or columns.
     * @var mixed
     */
    protected $_primary = array('id', 'phrase', 'tag');
	/**
     * The primary values.
     * @var mixed
     */
    protected $_primaryValues = array(null, 'POST', 'POST');
    
    /**
     * Classname for row
     * @var string
     */
    protected $_rowClass = 'Post_Model_DbTable_Row_Post';
	
	/**
	 * Dependent tables map
	 */
	protected $_dependentTables = array(
		'Post_Model_DbTable_PostEntry',
		'Post_Model_DbTable_TagItem',
		'Post_Model_DbTable_PostCategory'
	);
	
    /**
     * Reference map
     */
    protected $_referenceMap = array(
        'Creator' => array(
            'columns' => 'create_account_id',
            'refTableClass' => 'Default_Model_DbTable_Account',
            'refColumns' => array('id')
        ),
        'LastModifier' => array(
            'columns' => 'last_modified_account_id',
            'refTableClass' => 'Default_Model_DbTable_Account',
            'refColumns' => array('id')
        )
    );
	
	/**
	 * Base folder, used to store post's image
	 */
	const IMG_FOLDER = 'post.index.images';
	/**
	 * Return post's image folder appended with post's type
	 * 
	 * @param $type string Post's type
	 * @return string
	 */
	public static function returnImgFolder($type) {
		// Format input 
		$type = trim($type);
		$type = strtolower(preg_replace("/[^_\-\.A-Za-z0-9]/", '', $type));
		// Return
		return self::IMG_FOLDER . "--{$type}";
	}
	/**
	 * Return post's images uploaded web path
	 * 
	 * @param $type string Post's type
	 * @param $imgs string|array Post's images
	 * @return string|array
	 */
	public static function returnImgsWebPath($imgs, $type) {
		$imgs = array_filter(is_array($imgs) ? $imgs : explode("\n", trim($imgs)));
		if (!empty($imgs)) {
			// Get K111_AssetsFinder;
			$assetsFinder = K111_AssetsFinder::getInstance();
			// Image folder 
			$imgFolder = self::returnImgFolder($type);
			// +++
			foreach ($imgs as $key => $img) {
				if (!$img) {
					unset($imgs[$key]); continue;
				}
				$imgs[$key] = trim("{$imgFolder}{$img}");	
			} 
			$imgs = $assetsFinder->uploadFiles($imgs);
		}
		return $imgs;
	}
	
	/**
	 * Default post's type
	 */
	protected $_defaultType;
	/**
	 * Get default post's type
	 * 
	 * @return string Post type
	 */
	public function getDefaultType() {
		// Return;
		return $this->_defaultType;
	} 
	/**
	 * Set default post's type
	 * 
	 * @param $type string Post type
	 * @return void
	 */
	public function setDefaultType($type) {
		$this->_defaultType = (string)$type;
		// Return;
		return $this;
	}
	
// +++ Repo helpers
    /**
     * Build fetch all data selector
	 * 
	 * @param array $options An array of options
	 * @param array $order Order array
	 * @return Zend_Db_Table_Selector
     */
    public function buildFetchDataSelector(array $options = array(), array $order = array()) {
        // Init select
        $select = $this->select()
			->from($this->_name)
		;
        
        // Filter data;
        $dbA = $select->getAdapter();
        // +++ keyword
        $options['keyword'] = trim($options['keyword']);
        if ($options['keyword']) {
            $subOrWhere = array(
                '(' . $dbA->quoteIdentifier('name') . ' LIKE :keyword)'
            );
            $select
                ->where(implode(' OR ', $subOrWhere))
                ->bind(array(
                    'keyword' => "%{$options['keyword']}%"
                ))
            ;
        }
		// +++ id?
		$options['exclude_id'] = array_filter((array)($options['exclude_id']));
        if (!empty($options['exclude_id'])) {
            $select
                ->where('id NOT IN (?)', $options['exclude_id'])
            ;
        }
		// +++ type?
        $options['type'] = array_filter(
        	(array)($options['type'] ?: $this->_defaultType)
		);
        if (!empty($options['type'])) {
            $select
                ->where('type IN (?)', $options['type'])
            ;
        }
		// +++ active?
        $options['active'] = trim($options['active']);
        if ('' != $options['active']) {
            $select
                ->where('active = :active', $options['active'])
                ->bind(array(
                    'active' => $options['active']
                ))
            ;
        }
		// +++ draft?
        if (isset($options['draft'])) {
            $select->where('draft IS NOT NULL');
        }
        //die($select);
        
        // Return;
        return $select;
    }
// +++ End.Repo helpers
}