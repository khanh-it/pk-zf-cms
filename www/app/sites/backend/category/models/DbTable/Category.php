<?php
/**
 */
class Category_Model_DbTable_Category extends K111_Db_Table
{
	/**
	 * @var string 
	 */
	const PHRASE = 'CATEGORY';
	
    /**
     * The table name.
     * @var string
     */
    protected $_name = 'tbl_category';
    
    /**
     * The primary key column or columns.
     * @var mixed
     */
    protected $_primary = array('id', 'phrase');
	/**
     * The primary values.
     * @var mixed
     */
    protected $_primaryValues = array(null, 'CATEGORY');
    
    /**
     * Classname for row
     * @var string
     */
    protected $_rowClass = 'Category_Model_DbTable_Row_Category';
	
	/**
	 * Dependent tables map
	 */
	protected $_dependentTables = array(
		'Category_Model_DbTable_Category',
		'Category_Model_DbTable_CategoryEntry'
	);
	
    /**
     * Reference map
     */
    protected $_referenceMap = array(
        'Parent' => array(
            'columns' => 'parent_id',
            'refTableClass' => 'Category_Model_DbTable_Category',
            'refColumns' => array('id')
        ),
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
	 * Base folder, used to store category's image
	 */
	const IMG_FOLDER = 'category.index.images';
	/**
	 * Return category's image folder appended with category's type
	 * 
	 * @param $type string Category's type
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
	 * Return category's images uploaded web path
	 * 
	 * @param $imgs string|array Category's images
	 * @param $type string Category's type
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
	 * Default category's type
	 */
	protected $_defaultType;
	/**
	 * Get default category's type
	 * 
	 * @return string Category type
	 */
	public function getDefaultType() {
		// Return;
		return $this->_defaultType;
	} 
	/**
	 * Set default category's type
	 * 
	 * @param $type string Category type
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
		$bind = $select->getBind();
        
        // Filter data;
        $dbA = $select->getAdapter();
        // +++ keyword
        $options['keyword'] = trim($options['keyword']);
        if ($options['keyword']) {
        	$bind['keyword'] = "%{$options['keyword']}%";
            $select->where(implode(' OR ', array(
                '(' . $dbA->quoteIdentifier('code') . ' LIKE :keyword)',
                '(' . $dbA->quoteIdentifier('name') . ' LIKE :keyword)'
            )));
        }
		// +++ id?
		$options['exclude_id'] = array_filter((array)($options['exclude_id']));
        if (!empty($options['exclude_id'])) {
            $select->where('id NOT IN (?)', $options['exclude_id']);
        }
		// +++ parent?
        $options['parent_id'] = array_filter((array)($options['parent_id']));
        if (!empty($options['parent_id'])) {
            $select->where('parent_id IN (?)', $options['parent_id']);
        }
		// +++ type?
        $options['type'] = array_filter(
        	(array)($options['type'] ?: $this->_defaultType)
		);
        if (!empty($options['type'])) {
            $select->where('type IN (?)', $options['type']);
        }
		// +++ active?
        $options['active'] = trim($options['active']);
        if ('' != $options['active']) {
            $select->where('active = ?', $options['active']);
        }
		// +++ Bind filter data 
		$select->bind($bind);
        //die($select);
        
        // Return;
        return $select;
    }

	/**
	 * Get data recursive (data type: array)
	 * 
	 * @param array $data Data array 
	 * @param array $options An array of options
	 * @param int|string $parentId Parent id
	 * @return array 
	 */
	public function dataRecursiveArray($data, $options = array(), $parentId = null) {
		// Format, get options
		// +++ index by id
		$options['index_by_id'] = $options['index_by_id'] ?: false;
		
		// Return values
		$return = array();
		// +++ 
		foreach ($data as $item) {
			if ($item['parent_id'] == $parentId) {
				// Has child? 
				$item['_children'] = $this->dataRecursiveArray($data, $options, $item['id']);
				// Case: index by id
				if ($options['index_by_id']) {
					$return[$item['id']] = $item;
				// Case: index auto
				} else {
					$return[] = $item;
				}
			}
		}
		// Return;
		return $return;
	}
	
	/**
	 * Flattern fetched data
	 * 
	 * @param array $data An array of data
	 * @param array $options An array of options
	 * @return array
	 */
	public function flatternDataRecursive($data, array $options = array()) {
		// Get, format opitons
		// +++ Build options key/value pairs?
		$options['build_option'] = $options['build_option'] ?: false;
		// +++ Index by?
		if (isset($options['build_option'])) {
			$options['index_by'] = isset($options['index_by']) ? $options['index_by'] : true;
		}
		// +++ Format output?
		if (true === $options['build_option']) {
			$options['format_output'] = isset($options['format_output']) ? $options['format_output'] : function($item, $options){
				return str_repeat(':: ', $item['_level'] - 1) 
			 	. ((true === $options['build_option'])
					? "{$item['name']} [{$item['code']}]" 
					: (false === $options['build_option'] ? "{$item['code']} [{$item['name']}]" : $item['name']
					)
				);
			};
		}
		
		// Define vars
		// +++ 
		$tmp = array();
		// +++
		$levels = array();
		// 
		while (!empty($data)) {
			// Get first item data.
			$item = array_shift($data);
			// Calculate item's level;
			$item['_level'] = (int)$levels[$item['parent_id']];
			$levels[$item['id']] = ++$item['_level'];
			// Prepend item(s) if any. 
			if ($item['_hasChild'] = !empty($item['_children'])) {
				$data = array_merge($item['_children'], $data);
			}
			unset($item['_children']);
			
			// Case: index by?
			$idx = (true === $options['index_by']) 
				? $item['id']
				: (is_callable($options['index_by'])
					? $options['index_by']($item) : null
				)
			;
			// Format output?
			$item = is_callable($options['format_output']) 
				? $options['format_output']($item, $options)
				: $item
			;
			if ($idx) {
				$tmp[$idx] = $item;
			// Case: index auto	
			} else {
				$tmp[] = $item;
			}
		}
		
		// Return;
		return $tmp;
	}

	/**
     * Fetch all data recursive
	 * 
	 * @param array $options An array of options
	 * @param array $order Order array
	 * @return Zend_Db_Table_Selector
     */
	public function fetchDataRecursive(array $options = array(), array $order = array()) {
        // Call function, build selector fetch data;
        $select = $this->buildFetchDataSelector($options, $order);
		
		// Fetch data
		$rows = $this->fetchAll($select);
		$return = $this->dataRecursiveArray($rows->toArray());
		
		// Return
        return $return;
    }

	/**
	 * Check data exist by code
	 * 
	 * @param $code string Category code
	 * @param $options array An array of options
	 * @return bool
	 */
	public function checkExistsByCode($code, array $options = array()) {
		// Where
		$where = array(
        	'code = ?' => $code
		);
		// +++ type?
		$options['type'] = array_filter(
			(array)($options['type'] ?: $this->_defaultType)
		);
		if (!empty($options['type'])) {
			$where['type IN (?)'] = $options['type'];
		}
		// +++ exclude_id?
		$options['exclude_id'] = array_filter((array)$options['exclude_id']);
		if (!empty($options['exclude_id'])) {
			$where['id NOT IN (?)'] = $options['exclude_id'];
		}
		//Zend_Debug::dump($where);die();
		
		// Return;
		return !!$this->fetchRow($where);
	}
// +++ End.Repo helpers
}