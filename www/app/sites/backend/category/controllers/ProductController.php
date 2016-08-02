<?php
/**
 * Product category
 * @author khanhdtp
 * @MCAInfo({
 	"name": "Danh mục sản phẩm",
	"info": "Quản lý danh mục sản phẩm"
})
 */
class Category_ProductController extends K111_Controller_Action
{
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Action::init()
     */
	public function init()
	{
		// Set request's default params
		$this->getRequest()
			->setParam('_options', array(
				'type' => Category_Model_DbTable_Row_Category::TYPE_PRODUCT
			))
		;
	}
	
	/**
	 * Action: list data;
	 * @MCAInfo({
	 	"name": "Danh sách",
		"info": "Xem danh sách dữ liệu."
	})
	 * @return void
	 */
	public function indexAction()
	{
		// Forward request
		$this->forward(
			$this->_request->getActionName(),
			'index',
			$this->_request->getModuleName(),
			$this->_request->getUserParams()
		);
	}
	
	/**
	 * Action: active;
	 * @MCAInfo({
	 	"name": "Kích hoạt/Hủy kích hoạt",
		"info": "Chuyển đổi trạng thái kích hoạt/hủy kích hoạt dữ liệu."
	})
	 * @return void
	 */
	public function activeAction()
	{
		// Forward request
		$this->forward(
			$this->_request->getActionName(),
			'index',
			$this->_request->getModuleName(),
			$this->_request->getUserParams()
		);
	}
	
	/**
	 * Action: create new data;
	 * @MCAInfo({
	 	"name": "Thêm mới",
		"info": "Thêm mới dữ liệu."
	})
	 * @return void
	 */
	public function createAction()
	{
		// Forward request
		$this->forward(
			$this->_request->getActionName(),
			'index',
			$this->_request->getModuleName(),
			$this->_request->getUserParams()
		);
	}
	
	/**
	 * Action: update data;
	 * @MCAInfo({
	 	"name": "Cập nhật",
		"info": "Cập nhật dữ liệu."
	})
	 * @return void
	 */
	public function updateAction()
	{
		// Forward request
		$this->forward(
			$this->_request->getActionName(),
			'index',
			$this->_request->getModuleName(),
			$this->_request->getUserParams()
		);
	}
	
	/**
	 * Action: view detail;
	 * @MCAInfo({
	 	"name": "Chi tiết",
		"info": "Xem thông tin chi tiết dữ liệu."
	})
	 * @return void 
	 */
	public function detailAction() 
	{
		// Forward request
		$this->forward(
			$this->_request->getActionName(),
			'index',
			$this->_request->getModuleName(),
			$this->_request->getUserParams()
		);
	}
	
	/**
	 * Action: delete;
	 * @MCAInfo({
	 	"name": "Hủy",
		"info": "Hủy dữ liệu."
	})
	 * @return void
	 */
	public function deleteAction()
	{
		// Forward request
		$this->forward(
			$this->_request->getActionName(),
			'index',
			$this->_request->getModuleName(),
			$this->_request->getUserParams()
		);
	}
}