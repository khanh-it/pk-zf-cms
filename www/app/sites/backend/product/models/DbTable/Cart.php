<?php
/**
 */
class Product_Model_DbTable_Cart extends K111_Db_Table
{
	/**
	 * @var int|string Payment method: cash 
	 */
	 const PMT_METHOD_CASH = 'CASH';
	 /**
	  * @var int|string Payment method: transfer 
	  */
	 const PMT_METHOD_TRANSFER = 'TRANSFER';
	 /**
	 * @var int|string Payment method: E_COMMERCE
	 */
	 const PMT_METHOD_E_COMMERCE = 'E_COMMERCE';
	 /**
	  * 
	  * @return array
	  */
	 public static function returnPaymentMethods() {
	 	return array(
	 		self::PMT_METHOD_CASH => 'Tiền mặt',
	 		self::PMT_METHOD_TRANSFER => 'Chuyển khoản',
	 		self::PMT_METHOD_E_COMMERCE => 'Trực tuyến'
		);
	 }
	 
	 /**
	 * @var int|string Transport method: buyer
	 */
	 const TRANSPORT_METHOD_BUYER = 'BUYER';
	 /**
	  * @var int|string Transport method: seller 
	  */
	 const TRANSPORT_METHOD_SELLER = 'SELLER';
	 /**
	  * 
	  * @return array
	  */
	 public static function returnTransportMethods() {
	 	return array(
	 		self::TRANSPORT_METHOD_BUYER => 'Bên mua vận chuyển',
	 		self::TRANSPORT_METHOD_SELLER => 'Bên bán vận chyển',
		);
	 }
	 
	/**
	 * @var int|string Gift flag 1
	 */
	 const GIFT_YES = 1;
	 /**
	 * @var int|string Gift flag 0
	 */
	 const GIFT_NO = 0;
	 /**
	  * 
	  * @return array
	  */
	 public static function returnGifts() {
	 	return array(
	 		self::GIFT_YES => 'Yes',
	 		self::GIFT_NO => 'No',
		);
	 }
	 
	 /**
	  * @var int|string Invoice flag 1
	  */
	 const INVOICE_YES = 1;
	 /**
	  * @var int|string Invoice flag 0
	  */
	 const INVOICE_NO = 0;
	 /**
	  * 
	  * @return array
	  */
	 public static function returnInvoices() {
	 	return array(
	 		self::INVOICE_YES => 'Yes',
	 		self::INVOICE_NO => 'No',
		);
	 }
	 
	 /**
	  * @var int|string Status: NEW
	  */
	 const STATUS_NEW = 0;
	 /**
	  * @var int|string Status: DONE
	  */
	 const STATUS_DONE = 1;
	 /**
	  * @var int|string Status: CANCELED
	  */
	 const STATUS_CANCELED = -1;
	 /**
	  * 
	  * @return array
	  */
	 public static function returnStatuses() {
	 	return array(
	 		self::STATUS_NEW => 'Mới tạo',
	 		self::STATUS_DONE => 'Đã hoàn tất',
	 		self::STATUS_CANCELED => 'Đã hủy',
		);
	 }
	 
	 /**
	  * @var int|string Process status: NEW
	  */
	 const PROCESS_STATUS_NEW = 0;
	 /**
	  * @var int|string Process status: PROCESSING
	  */
	 const PROCESS_STATUS_PROCESSING = 1;
	 /**
	  * @var int|string Process status: DONE
	  */
	 const PROCESS_STATUS_DONE = 2;
	 /**
	  * 
	  * @return array
	  */
	 public static function returnProcessStatuses() {
	 	return array(
	 		self::PROCESS_STATUS_NEW => 'Chưa xử lý',
	 		self::PROCESS_STATUS_PROCESSING => 'Đang xử lý',
	 		self::PROCESS_STATUS_DONE => 'Đã xử lý',
		);
	 }
	
	 /**
     * The table name.
     * @var string
     */
    protected $_name = 'tbl_cart';
    
    /**
     * The primary key column or columns.
     * @var mixed
     */
    protected $_primary = array('id');
	
	/**
	 * Default cart's type
	 */
	protected $_defaultType = 'PRODUCT';
	
    /**
     * Classname for row
     * @var string
     */
    protected $_rowClass = 'Product_Model_DbTable_Row_Cart';
	
	/**
	 * Dependent tables map
	 */
	protected $_dependentTables = array(
		'Product_Model_DbTable_CartDetail',
		'Product_Model_DbTable_CartLog'
	);
	
    /**
     * Reference map
     */
    protected $_referenceMap = array(
        'Creator' => array(
            'columns' => 'create_account_id',
            'refTableClass' => 'Default_Model_DbTable_Account',
            'refColumns' => array('id')
        )
    );
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
            )));
        }
		// +++ id?
		$options['exclude_id'] = array_filter((array)($options['exclude_id']));
        if (!empty($options['exclude_id'])) {
            $select->where($dbA->quoteIdentifier('id') . ' NOT IN (?)', $options['exclude_id']);
        }
		// +++ type?
        $options['type'] = array_filter(
        	(array)($options['type'] ?: $this->_defaultType)
		);
        if (!empty($options['type'])) {
            $select->where($dbA->quoteIdentifier('type') . ' IN (?)', $options['type']);
        }
		// +++ payment_method?
        $options['payment_method'] = array_filter((array)($options['payment_method']));
        if (!empty($options['payment_method'])) {
            $select->where($dbA->quoteIdentifier('payment_method') . ' IN (?)', $options['payment_method']);
        }
        // +++ transport_method?
        $options['transport_method'] = array_filter((array)($options['transport_method']));
        if (!empty($options['transport_method'])) {
            $select->where($dbA->quoteIdentifier('transport_method') . ' IN (?)', $options['transport_method']);
        }
		// +++ gift?
        $options['gift'] = trim($options['gift']);
        if ('' != $options['gift']) {
            $select->where($dbA->quoteIdentifier('gift') . ' = ?', $options['gift']);
        }
		// +++ invoice?
        $options['invoice'] = trim($options['invoice']);
        if ('' != $options['invoice']) {
            $select->where($dbA->quoteIdentifier('invoice') . ' = ?', $options['invoice']);
        }
		// +++ transport_price?
        $options['transport_price_f'] = trim($options['transport_price_f']);
        if ('' != $options['transport_price_f']) {
            $select->where($dbA->quoteIdentifier('transport_price') . ' >= ?', doubleval($options['transport_price_f']));
        }
		$options['transport_price_t'] = trim($options['transport_price_t']);
        if ('' != $options['transport_price_t']) {
            $select->where($dbA->quoteIdentifier('transport_price') . ' <= ?', doubleval($options['transport_price_t']));
        }
		// +++ total_promotion?
        $options['total_promotion_f'] = trim($options['total_promotion_f']);
        if ('' != $options['total_promotion_f']) {
            $select->where($dbA->quoteIdentifier('total_promotion') . ' >= ?', doubleval($options['total_promotion_f']));
        }
		$options['total_promotion_t'] = trim($options['total_promotion_t']);
        if ('' != $options['total_promotion_t']) {
            $select->where($dbA->quoteIdentifier('total_promotion') . ' <= ?', doubleval($options['total_promotion_t']));
        }
		// +++ total_qty?
        $options['total_qty_f'] = trim($options['total_qty_f']);
        if ('' != $options['total_qty_f']) {
            $select->where($dbA->quoteIdentifier('total_qty') . ' >= ?', doubleval($options['total_qty_f']));
        }
		$options['total_qty_t'] = trim($options['total_qty_t']);
        if ('' != $options['total_qty_t']) {
            $select->where($dbA->quoteIdentifier('total_qty') . ' <= ?', doubleval($options['total_qty_t']));
        }
		// +++ total_price?
        $options['total_price_f'] = trim($options['total_price_f']);
        if ('' != $options['total_price_f']) {
            $select->where($dbA->quoteIdentifier('total_price') . ' >= ?', doubleval($options['total_price_f']));
        }
		$options['total_price_t'] = trim($options['total_price_t']);
        if ('' != $options['total_price_t']) {
            $select->where($dbA->quoteIdentifier('total_price') . ' <= ?', doubleval($options['total_price_t']));
        }
		// +++ status?
        $options['status'] = trim($options['status']);
        if ('' != $options['status']) {
            $select->where($dbA->quoteIdentifier('status') . ' = ?', $options['status']);
        }
		// +++ process_status?
        $options['process_status'] = trim($options['process_status']);
        if ('' != $options['process_status']) {
            $select->where($dbA->quoteIdentifier('process_status') . ' = ?', $options['process_status']);
        }
		// +++ create_account_id?
        $options['create_account_id'] = array_filter((array)($options['create_account_id']));
        if (!empty($options['create_account_id'])) {
            $select->where($dbA->quoteIdentifier('create_account_id') . ' IN (?)', $options['create_account_id']);
        }
		// +++ created_time?
        $options['created_time_f'] = trim($options['created_time_f']);
        if ('' != $options['created_time_f']) {
            $select->where($dbA->quoteIdentifier('created_time') . ' >= ?', doubleval($options['created_time_f']));
        }
		$options['created_time_t'] = trim($options['created_time_t']);
        if ('' != $options['created_time_t']) {
            $select->where($dbA->quoteIdentifier('created_time') . ' <= ?', doubleval($options['created_time_t']));
        }
		
		// +++ Bind filter data 
		$select->bind($bind);
        //die($select);
        
        // Return;
        return $select;
    }
// +++ End.Repo helpers
}