<?php
/**
 * pk-zf-cms (Zend Framework powered)
 *
 * LICENSE
 *
 * Free
 *
 * @category   K111
 * @package    K111
 * @copyright  Free
 * @license    
 * @version    
 */

/**
 * Helper find asset's path info.
 *
 * @category   K111
 * @package    K111
 * @copyright  Free
 * @license    
 */
class K111_AssetsFinder
{
    /**
     * @var int Error code: type not defined!
     */
    const ERR_TYPE_NOT_DEFINED = 100;

    /**
     * @var string Special assets type: upload
     */
    const TYPE_UPLOAD = '__upload__';

    /**
     * @var string Document root
     */
    protected $_documentRoot = '';

    /**
     * @var string Upload dir
     */
    protected $_uploadDir = '';

    /**
     * @var string Assets dir
     */
    protected $_assetsDir = '';

    /**
     * @var string Site dir
     */
    protected $_siteDir = '';

    /**
     * @var string Skin dir
     */
    protected $_skinDir = '';

    /**
     * @var array An array of defined types
     */
    protected $_types = array();

    /**
     * @var K111_AssetsFinder
     */
    protected static $_instance;

    /**
     * Construct (protected uses only)
     */
    protected function __construct() {}

    /**
     * Helper: remove duplicate forward slashes
     * @param string $path 
     * @return string
     */
    public function removeDuplicateForwardSlashes($path) {
        return str_replace(array('///', '//'), '/', (string)$path);
    }

    /**
     * Helper: detect is search files from local?
     * @param string $path 
     * @return bool
     */
    public function isFileLocal($path) {
        return (false === strpos((string)$path, '://'));
    }

    /**
     * Get K111_AssetsFinder
     * @param null|array $options An array of options
     * @return K111_AssetsFinder
     */
    public static function getInstance($options = null) {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        // Set default options?
        if (is_array($options)) {
            self::$_instance->setOptions($options);    
        }
        // Return
        return self::$_instance;
    }

    /**
     * Set options
     * @param array $options An array of options
     * @return this
     */
    public function setOptions($options = array()) {
        foreach ($options as $key => $value) {
            switch (strtolower($key)) {
            // +++ 
                case 'document_root': {
                    $this->setDocumentRoot((string)$value);
                } break;
            // +++ 
                case 'upload_dir': {
                    $this->setUploadDir((string)$value);
                } break;
            // +++ 
                case 'assets_dir': {
                    $this->setAssetsDir((string)$value);
                } break;
            // +++ 
                case 'site_dir': {
                    $this->setSiteDir((string)$value);
                } break;
            // +++ 
                case 'skin_dir': {
                    $this->setSkinDir((string)$value);
                } break;
            // +++ 
                case 'types': {
                    $this->setTypes((array)$value);
                } break;
            }
        }
    }

    /**
     * Set document root
     * @param string $documentRoot Document root path
     * @return this
     */
    public function setDocumentRoot($documentRoot) {
        $this->_documentRoot = $this->removeDuplicateForwardSlashes($documentRoot);

        return $this;
    }
    /**
     * Get document root
     * @return string
     */
    public function getDocumentRoot() {
        return $this->_documentRoot;
    }

    /**
     * Set upload dir
     * @param string $uploadDir Upload dir
     * @return this
     */
    public function setUploadDir($uploadDir) {
        $this->_uploadDir = $this->removeDuplicateForwardSlashes($uploadDir);

        return $this;
    }
    /**
     * Get upload dir
     * @return string
     */
    public function getUploadDir() {
        return $this->_uploadDir;
    }

    /**
     * Set assets dir
     * @param string $assetsDir Assets dir
     * @return this
     */
    public function setAssetsDir($assetsDir) {
        $this->_assetsDir = $this->removeDuplicateForwardSlashes($assetsDir);

        return $this;
    }
    /**
     * Get assets dir
     * @return string
     */
    public function getAssetsDir() {
        return $this->_assetsDir;
    }

    /**
     * Set site dir
     * @param string $siteDir Site dir
     * @return this
     */
    public function setSiteDir($siteDir) {
        $this->_siteDir = $this->removeDuplicateForwardSlashes($siteDir);

        return $this;
    }
    /**
     * Get site dir
     * @return string
     */
    public function getSiteDir() {
        return $this->_siteDir;
    }

    /**
     * Set skin dir
     * @param string $skinDir Skin dir
     * @return this
     */
    public function setSkinDir($skinDir) {
        $this->_skinDir = $this->removeDuplicateForwardSlashes($skinDir);

        return $this;
    }
    /**
     * Get skin dir
     * @return string
     */
    public function getSkinDir() {
        return $this->_skinDir;
    }

    /**
     * Set types
     * @param array $types Types of assets
     * @return this
     */
    public function setTypes(array $types) {
        $this->_types = $types;

        return $this;
    }
    /**
     * Get types of assets
     * @return array
     */
    public function getTypes() {
        return $this->_types;
    }

    /**
     * Get full assets path.
     * @param bool $getAsSystemPath Get path as system path?
     * @param null|string $type Type of asset
     * @return string
     */
    public function compileAssetsPath($getAsSystemPath = false, $type = null) {
        $dir = $this->removeDuplicateForwardSlashes(
            ($getAsSystemPath ? $this->_documentRoot : '')
            . "/{$this->_assetsDir}"
            . "/{$this->_siteDir}"
            . "/{$this->_skinDir}"
            . ($type ? "/{$this->_types[$type]}" : '')
        );
        return $dir;
    }

    /**
     * Get full upload path.
     * @param bool $getAsSystemPath Get path as system path?
     * @param null|string $type Type of asset
     * @return string
     */
    public function compileUploadPath($getAsSystemPath = false) {
        $dir = $this->removeDuplicateForwardSlashes(
            ($getAsSystemPath ? $this->_documentRoot : '')
            . "/{$this->_uploadDir}"
            //. "/{$this->_siteDir}"
        );
        return $dir;
    }    

    /**
     * Get files
     * @param string|array $files Files of assets
     * @param null|string $type Type of asset
     * @param bool $getAsSystemPath Get path as system path?
     * @throws Exception
     * @return string|array
     */
    public function files($files, $type, $getAsSystemPath = false) {
        // Check if `$type` was defined?
        // +++ 
        $isTypeUpload = (self::TYPE_UPLOAD == $type);
        // +++
        if (!$this->_types[$type] && !$isTypeUpload) {
            throw new Exception("Type: `$type` was not defined!", self::ERR_TYPE_NOT_DEFINED);
        }

        // Flag: get 1 file or an array of files?
        $isArray = is_array($files);
        // +++ Force input to be array;
        $files = (array)$files;

        // Get full path.
        $filesPath = $isTypeUpload
        // +++ Case: upload files?
            ? $this->compileUploadPath($getAsSystemPath)
        // +++ Case: assets files?
            : $this->compileAssetsPath($getAsSystemPath, $type)
        ;

        // Process on get files info.
        // +++
        $assets = array();
        // +++ 
        foreach ($files as $key => $file) {
            $assets[$key] = (
            // Case: file from remote?
                !$this->isFileLocal($file)
                ? $file
            // Case: file from local.
                : $this->removeDuplicateForwardSlashes("{$filesPath}/{$file}")
            );
        }

        return $isArray ? $assets : current($assets);
    }

    /**
     * Get upload files
     * @param string|array $files Files of assets
     * @param bool $getAsSystemPath Get path as system path?
     * @throws Exception
     * @return string|array
     */
    public function uploadFiles($files, $getAsSystemPath = false) {
        return $this->files($files, self::TYPE_UPLOAD, $getAsSystemPath);
    }
}