<?php
/**
 */
class Product_Model_DbTable_Product extends K111_Db_Table
{
	/**
	 * @var string 
	 */
	const PHRASE = 'PRODUCT';
	
	/**
	 * @var string 
	 */
	const TAG = 'PRODUCT';
	
	/**
	 * @var string Category's type: PRODUCT
	 */
	const CATEGORY_TYPE_PRODUCT = 'PRODUCT';
	
    /**
     * The table name.
     * @var string
     */
    protected $_name = 'tbl_product';
    
    /**
     * The primary key column or columns.
     * @var mixed
     */
    protected $_primary = array('id', 'phrase', 'tag');
	/**
     * The primary values.
     * @var mixed
     */
    protected $_primaryValues = array(null, 'PRODUCT', 'PRODUCT');
    
    /**
     * Classname for row
     * @var string
     */
    protected $_rowClass = 'Product_Model_DbTable_Row_Product';
	
	/**
	 * Dependent tables map
	 */
	protected $_dependentTables = array(
		'Product_Model_DbTable_ProductEntry',
		'Product_Model_DbTable_TagItem',
		'Product_Model_DbTable_ProductCategory'
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
	 * Base folder, used to store product's image
	 */
	const IMG_FOLDER = 'product.index.images';
	/**
	 * Return product's image folder appended with product's type
	 * 
	 * @param $type string Product's type
	 * @return string
	 */
	public static function returnImgFolder($type = null) {
		// Format input
		$type = trim($type);
		if ($type) {
			$type = strtolower(preg_replace("/[^_\-\.A-Za-z0-9]/", '', $type));
			$type = "--{$type}";	
		}
		
		// Return
		return self::IMG_FOLDER . $type;
	}
	/**
	 * Return product's images uploaded web path
	 * 
	 * @param $imgs string|array Product's images
	 * @param $type string Product's type
	 * @return string|array
	 */
	public static function returnImgsWebPath($imgs, $type = null) {
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
	 * Default product's type
	 */
	protected $_defaultType;
	/**
	 * Get default product's type
	 * 
	 * @return string Product type
	 */
	public function getDefaultType() {
		// Return;
		return $this->_defaultType;
	} 
	/**
	 * Set default product's type
	 * 
	 * @param $type string Product type
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
			//->setIntegrityCheck(false)
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
		// +++ type?
        $options['type'] = array_filter(
        	(array)($options['type'] ?: $this->_defaultType)
		);
        if (!empty($options['type'])) {
            $select->where('type IN (?)', $options['type']);
        }
		// +++ price?
        $options['price_f'] = trim($options['price_f']);
        if ('' != $options['price_f']) {
            $select->where('price >= ?', doubleval($options['price_f']));
        }
		$options['price_t'] = trim($options['price_t']);
        if ('' != $options['price_t']) {
            $select->where('price <= ?', doubleval($options['price_t']));
        }
		// +++ active?
        $options['active'] = trim($options['active']);
        if ('' != $options['active']) {
            $select->where('active = ?', $options['active']);
        }
		// +++ draft?
        if (isset($options['draft'])) {
            $select->where('draft IS NOT NULL');
        }
		// +++ category
		$options['category_id'] = array_filter((array)($options['category_id']));
        if (!empty($options['category_id'])) {
        	// Relative DbTable objects
			$repoProductCategory = new Product_Model_DbTable_ProductCategory();
			// Build sub where selector
        	$subSelector = $repoProductCategory->select()
				->where('category_id IN (?)', $options['category_id'])
				->where($dbA->quoteIdentifier('product_id') 
					. ' = ' . $dbA->quoteIdentifier($this->_name . '.id')
				)
			;
            $select->where('EXISTS (' . (new Zend_Db_Expr($subSelector)) . ')');
        }
		
		// +++ Bind filter data 
		$select->bind($bind);
        //die($select);
        
        // Return;
        return $select;
    }

	/**
	 * Check data exist by condition
	 * 
	 * @param $by array String condition
	 * @param $options array An array of options
	 * @return bool
	 */
	protected function _checkExists(array $by, array $options = array()) {
		// Where
		$where = array();
		// +++ By code?
		if (!empty($by['code'])) {
			$where['code = ?'] = $by['code'];
		}
		// +++ By sku?
		if (!empty($by['sku'])) {
			$where['sku = ?'] = $by['sku'];
		}
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
	
	/**
	 * Check data exist by code
	 * 
	 * @param $code string Product code
	 * @param $options array An array of options
	 * @return bool
	 */
	public function checkExistsByCode($code, array $options = array()) {
		return $this->_checkExists(array('code' => $code), $options);
	}
	
	/**
	 * Check data exist by sku
	 * 
	 * @param $sku string Product sku
	 * @param $options array An array of options
	 * @return bool
	 */
	public function checkExistsBySku($sku, array $options = array()) {
		return $this->_checkExists(array('sku' => $sku), $options);
	}
// +++ End.Repo helpers
}