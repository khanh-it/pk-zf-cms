<?php
/**
 */
class Bootstrap extends K111_Application_Bootstrap_Bootstrap
{
	/**
	 * Test database connection.
	 * @return bool
	 */
	protected function _initTestDbConnect() {
		return;
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