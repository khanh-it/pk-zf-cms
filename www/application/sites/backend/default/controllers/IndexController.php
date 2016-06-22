<?php
// application/controllers/IndexController.php
class IndexController extends K111_Controller_Action
{
	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
		//
		$this->view->readme = file_get_contents($READMEPath = APPLICATION_PATH . '/../README.txt');
		
	}
}