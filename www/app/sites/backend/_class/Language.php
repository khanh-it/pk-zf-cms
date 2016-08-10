<?php
/**
 * Simple language manager
 * @author khanhdtp
 */
class Language {
	/**
	 * @var array 
	 */
	protected static $_configs;
	
	/**
	 * @var string
	 */
	protected static $_default;
	
	/**
	 * Set languages configs
	 */
	public static function setConfigs(array $configs = array()) {
		// Set default configs
		self::$_configs = $configs;
	}

	/**
	 * Set default language
	 * 
	 * @param $_lang string Languague data string to get data
	 * @return void
	 */
	public static function setDefault($lang) {
		// Get defined language in config
		$languages = (array)self::$_configs['languages'];
		if ($languages[$lang]) {
			self::$_default = $lang;	
		}
	}
	
	/**
	 * Get default language
	 * 
	 * @return array
	 */
	public static function getDefault() {
		// Get defined languages
		$languages = self::get();
		
		if ($data = $languages[self::$_default]) {
			return array(self::$_default, $data);
		}

		return array();		
	}
	
	/**
	 * Get languages defined in configs
	 * 
	 * @param $_lang string Languague data string to get data
	 * @return array
	 */
	public static function get($_lang = null) {
		// Get languages defined in configs
		$languages = (array)self::$_configs['languages'];
		
		// Format input
		$_lang = $languages[$_lang] ? $_lang : self::$_default;
		$_lang = $_lang ?: key($languages); 
	
		// Build data
		$langData = self::data();
		foreach ($languages as $lang => $data) {
			$languages[$lang] = array_merge($data, array(
				'name' => $langData[$_lang][$lang]
			));
		}
		
		// Return
		return $languages;
	}
	
	/**
	 * Get language data defined in configs
	 * 
	 * @param $_lang string Languague
	 * @return array
	 */
	public static function data($_lang = null) {
		// Get  data
		$data = (array)self::$_configs['data'];
		// Return
		return $_lang ? $data[$_lang] : $data;
	}
	
	/**
	 * Get top (default) language defined in configs
	 * 
	 * @return array
	 */
	public static function getTop() {
		// Get defined languages
		$languages = self::get();
		reset($languages);
		$lang = key($languages);
		$data = $languages[$lang];
		
		return array($lang, $data);
	}
	
	
	/**
	 * Build language options
	 * 
	 * @param $_lang string Languague data string to get data
	 * @return array
	 */
	public static function buildOptions($_lang = null) {
		// Get langauge with data 
		$languages = self::get($lang);
		
		// Build options
		$options = array();
		foreach ($languages as $lang => $data) {
			$options[$lang] = $data['name'];
		}

		// Return
		return $options;
	}
	
	/**
	 * Render list of language icons
	 * 
	 * @param $langs array An array of languages
	 * @param $options array An array of options
	 * @return string
	 */
	public static function renderLangIcons($langs, array $options = array()) {
		// Format data
		$langs = (array)$langs;
		if (empty($langs)) {
			return '';
		}
		
		// Get default language
		$defLang = self::$_default;
		
		// Get languages info
		$languages = self::get();
		
		// Render
		$html = '';
		foreach ($langs as $lang) {
			if (($defLang == $lang) && !(true == $options['render_default'])) {
				continue;	
			}
			if ($langData = $languages[$lang]) {
				$html .= '<i class="lang-icon" title="' . $langData['name'] . '">'
					. '<img src="' . $langData['icon'] . '" />'
					. '</i>'
				;
			}
		}
		
		// Return;
		return $html;
	}
}