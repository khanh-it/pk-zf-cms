<?php
/**
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	/**
	 * Test database connection.
	 * @return bool
	 */
	protected function _initTestDbConnect() {
		try {
			$this->bootstrap('db');
			$db = $this->getResource('db');
			if ($db) {
				$db->getConnection();
			}
		} catch (Exception $e) {
			die('Database connection failed. Err msg: ' . $e->getMessage());
		}
	
		return true;
	}
}