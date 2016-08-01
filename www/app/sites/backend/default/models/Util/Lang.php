<?php
/**
 * @author khanhdtp
 */
class Default_Model_Util_Lang extends Default_Model_Util_Abstract
{
	/**
	 * @var lang VI
	 */
	const LANG_VI = 'vi';
	/**
	 * @var lang EN
	 */
	const LANG_EN = 'en';
	/**
	 * @var lang JP
	 */
	const LANG_JP = 'jp';
	
	/**
	 * Get language info
	 * 
	 * @return array
	 */
	public static function returnLangs() {
		return array(
			self::LANG_VI => 'Vietnamese',
			self::LANG_EN => 'English',
			self::LANG_JP => 'Japanese',
		);
	}  
}