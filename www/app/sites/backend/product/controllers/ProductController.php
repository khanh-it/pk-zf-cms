<?php
/**
 * Product product
 * @author khanhdtp
 * @MCAInfo({
 	"name": "Sản phẩm",
	"info": "Quản lý sản phẩm"
})
 */
class Product_ProductController extends K111_Controller_Action
{
	/**
	 * @var string Product's type
	 */
	const PRODUCT_TYPE = 'PRODUCT';
	
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Action::init()
     */
	public function init()
	{
		// Set request's default params
		$this->getRequest()
			->setParam('_options', array(
			// Default product's type
				'type' => self::PRODUCT_TYPE,
			// Auto sync module/controller/action for request
				//'syncModuleName' => true,
				'syncControllerName' => true,
				'syncActionName' => true,
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
	
	/**
	 * Action: language;
	 * @MCAInfo({
	 	"name": "Ngôn ngữ",
		"info": "Chuyển đổi ngôn ngữ."
	})
	 * @return void
	 */
	public function languageAction()
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