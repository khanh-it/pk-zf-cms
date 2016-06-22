<?php
/**
 */
class Bootstrap extends K111_Application_Bootstrap_Bootstrap
{
	protected function _initTest() {
		return;
		$this->bootstrap('K111_Application_Resource_AssetsFinder');

		$assetsFinder = $this->getResource('K111_Application_Resource_AssetsFinder');

		/*\Zend_Debug::dump($assetsFinder->getDocumentRoot());
		\Zend_Debug::dump($assetsFinder->getUploadDir());
		\Zend_Debug::dump($assetsFinder->getAssetsDir());
		\Zend_Debug::dump($assetsFinder->getSiteDir());
		\Zend_Debug::dump($assetsFinder->getTypes());
		\Zend_Debug::dump($assetsFinder->isFileLocal('abc/def/ghi.js'));*/

		
		\Zend_Debug::dump($assetsFinder->files(array(
			'abc.js',
			'def.js'
		), 'lib'));
		\Zend_Debug::dump($assetsFinder->files(array(
			'abc.js',
			'def.js'
		), 'lib', true));

		\Zend_Debug::dump($assetsFinder->uploadFiles(array(
			'abc.js',
			'def.js'
		)));
		\Zend_Debug::dump($assetsFinder->uploadFiles(array(
			'abc.js',
			'def.js'
		), true));
		die();
	}
}