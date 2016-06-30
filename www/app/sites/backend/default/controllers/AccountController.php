<?php
/**
 * 
 * @author khanhdtp
 *
 */
class AccountController extends K111_Controller_Action
{
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Action::init()
     */
	public function init()
	{
		/* Initialize action controller here */
	}
	
	/**
	 * Action: login page
	 * 
	 * @return void
	 */
	public function loginAction()
	{
	    // Case: logged in!
	    if ($this->_authIdentity) {
	        // Redirect to home page!
	        return $this->redirect($this->view->baseUrl('/'), array(
	            'prependBaseUrl' => false
	        ));
	    }
	    
	    // Use layout `login`
	    $this->_helper->layout()->setLayout('login');
	    
	    // Start session (if was not)
	    if (!Zend_Session::isStarted()) {
	        Zend_Session::start();
	    }
	    
	    // Define vars
	    $vData = array();
	    
	    // Case: post data, process...
	    if ($this->_request->isPost()) {
	        // Get post data;
	        $postData = $this->_request->getPost();
	        
	        // Check data's validation
	        if (($securityMatched = ($postData['security'] == $_SESSION['security'])) // security
	            && ($postData['username'] = trim(strip_tags($postData['username']))) // username
	            && ($postData['password'] = trim(strip_tags($postData['password']))) // password
            ) {
                // Get Zend_Auth
                $zAuth = Zend_Auth::getInstance();
                // Use Zend_Auth_Adapter_DbTable to authenticate.
                $zAuthAdapterDbTable = new Zend_Auth_Adapter_DbTable();
                // Get authenticate result. 
                $zAuthResult = $zAuthAdapterDbTable
                    ->setTableName(Default_Model_DbTable_Account::TBL_NAME)
                    ->setIdentityColumn('username')
                    ->setIdentity($postData['username'])
                    ->setCredentialColumn('password')
                    ->setCredential($postData['password'])
                    ->setCredentialTreatment('MD5(?) AND `active` = ' . Default_Model_DbTable_Account::ACTIVE_YES)
                    ->authenticate()
                ;
                // Check authenticate result
                switch ($zAuthResult->getCode()) {
                    // Case: failed unkhown
                    case Zend_Auth_Result::FAILURE : 
                    case Zend_Auth_Result::FAILURE_UNCATEGORIZED: {
                        Zend_Registry::set('layout-messages', '[danger]' 
                            . $this->view->translate('Đăng nhập không thành công!')
                            . ' Errs: ' . implode("<br />\n", $zAuthResult->getMessages())
                        );
                    } break;
                    // Case: username or password not macthed.
                    case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID :
                    case Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS: 
                    case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND: {
                        Zend_Registry::set('layout-messages', '[danger]'
                            . $this->view->translate('Đăng nhập không thành công! Tên đăng nhập/Mật khẩu không đúng!')
                        );
                    } break;
                    // Case: success.
                    case Zend_Auth_Result::SUCCESS: {
                        // Account object info from database;
                        $accountResultObject = $zAuthAdapterDbTable->getResultRowObject();
                        // Write a session storage to Zend_Auth;
                        // +++ 
                        // +++ Remember me?
                        if ($postData['remember']) {
                            Zend_Session::rememberMe(2 * 86400); //2 days
                        }
                        // +++ 
                        $zAuthStorage = new Zend_Auth_Storage_Session();
                        $zAuthStorage->write($accountResultObject);
                        $zAuth->setStorage($zAuthStorage);
                        
                        // Inform user;
                        $this->_helper->flashMessenger->addMessage($this->view->translate('Đăng nhập thành công!'));
                        
                        // Redirect to home page!
                        return $this->redirect($this->view->baseUrl('/'), array(
                            'prependBase' => false
                        ));
                    } break;
                }
            // Case: invalid submit data
            } else {
                // Case: invalid security. 
                if (!$securityMatched) {
                    Zend_Registry::set('layout-messages', '[danger]' . $this->view->translate('Mã bảo vệ không hợp lệ!'));
                    
                // Case: empty username or password  
                } else {
                    Zend_Registry::set('layout-messages', '[danger]' . $this->view->translate('Vui lòng nhập đầy đủ thông tin tên đăng nhập, và mật khẩu!'));
                }
            }
	    }
	    
	    // Create new security code;
	    $_SESSION['security'] = $vData['security'] = md5(uniqid());
	    
	    // Assign view's vars
	    $this->view->assign($vData);
	    
	}
	
	/**
	 * Action: logout
	 * 
	 * @return void
	 */
	public function logoutAction()
	{
	    // Get Zend_Auth
	    $zAuth = Zend_Auth::getInstance();
	    // +++ Clear storage!
	    $zAuth->getStorage()->clear();
	    // +++ Clear identity
	    $zAuth->clearIdentity();
	    
	    // Redirect to home page!
	    return $this->redirect($this->view->baseUrl('/'), array(
	        'prependBase' => false
	    ));
	}
	
	/**
	 *
	 */
	public function changePasswordAction()
	{
	    
	}
	
	/**
	 *
	 */
	public function profileAction()
	{
	}
}