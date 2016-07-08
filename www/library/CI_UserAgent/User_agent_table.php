<?php 
/**
 * Mobile Detect Library
 * =====================
 *
 * Motto: "Every business should have a mobile detection script to detect mobile readers"
 *
 * Mobile_Detect is a lightweight PHP class for detecting mobile devices (including tablets).
 * It uses the User-Agent string combined with specific HTTP headers to detect the mobile environment.
 *
 * @author      Current authors: Serban Ghita <serbanghita@gmail.com>
 *                               Nick Ilyin <nick.ilyin@gmail.com>
 *
 *              Original author: Victor Stanciu <vic.stanciu@gmail.com>
 *
 * @license     Code and contributions have 'MIT License'
 *              More details: https://github.com/serbanghita/Mobile-Detect/blob/master/LICENSE.txt
 *
 * @link        Homepage:     http://mobiledetect.net
 *              GitHub Repo:  https://github.com/serbanghita/Mobile-Detect
 *              Google Code:  http://code.google.com/p/php-mobile-detect/
 *              README:       https://github.com/serbanghita/Mobile-Detect/blob/master/README.md
 *              HOWTO:        https://github.com/serbanghita/Mobile-Detect/wiki/Code-examples
 *
 * @version     2.8.19
 */
class TabletDetect{
    /**
     * Mobile detection type.
     *
     * @deprecated since version 2.6.9
     */
    const DETECTION_TYPE_MOBILE     = 'mobile';
    
    /**
     * All possible HTTP headers that represent the
     * User-Agent string.
     *
     * @var array
     */
    public $uaHttpHeaders = array();
    
    /**
     * The User-Agent HTTP header is stored in here.
     * @var string
     */
    protected $userAgent = null;
    /**
     * Flag for if the user-agent is a tablet browser
     *
     * @var bool
     */
    public $is_tablet = FALSE;
    /**
     * Current user-agent tablet name
     *
     * @var string
     */
    public $tablet = '';
    /**
     * List of tablet to compare against current user agent
     *
     * @var array
     */
    public $tablets = array();
    
    /**
     * CloudFront headers. E.g. CloudFront-Is-Desktop-Viewer, CloudFront-Is-Mobile-Viewer & CloudFront-Is-Tablet-Viewer.
     * @var array
     */
    protected $cloudfrontHeaders = array();
    
    /**
     * The matching Regex.
     * This is good for debug.
     * @var string
     */
    protected $matchingRegex = null;
    
    /**
     * The matches extracted from the regex expression.
     * This is good for debug.
     * @var string
     */
    protected $matchesArray = null;
    /**
     * HTTP headers in the PHP-flavor. So HTTP_USER_AGENT and SERVER_SOFTWARE.
     * @var array
     */
    protected $httpHeaders = array();
    
    /**
     * Constructor
     *
     * Sets the User Agent and runs the compilation routine
     *
     * @return	void
     */
    public function __construct(){
        $this->setHttpHeaders();
        $this->setUserAgent();
        $this->_set_tablet();
    }
    
    /**
     * Set the HTTP Headers. Must be PHP-flavored. This method will reset existing headers.
     *
     * @param array $httpHeaders The headers to set. If null, then using PHP's _SERVER to extract
     *                           the headers. The default null is left for backwards compatibilty.
     */
    public function setHttpHeaders($httpHeaders = null)
    {
        // use global _SERVER if $httpHeaders aren't defined
        if (!is_array($httpHeaders) || !count($httpHeaders)) {
            $httpHeaders = $_SERVER;
        }
    
        // clear existing headers
        $this->httpHeaders = array();
    
        // Only save HTTP headers. In PHP land, that means only _SERVER vars that
        // start with HTTP_.
        foreach ($httpHeaders as $key => $value) {
            if (substr($key, 0, 5) === 'HTTP_') {
                $this->httpHeaders[$key] = $value;
            }
        }
    
        // In case we're dealing with CloudFront, we need to know.
        $this->setCfHeaders($httpHeaders);
    }
    
    /**
     * Retrieves the HTTP headers.
     *
     * @return array
     */
    public function getHttpHeaders()
    {
        return $this->httpHeaders;
    }
    
    /**
     * Get all possible HTTP headers that
     * can contain the User-Agent string.
     *
     * @return array List of HTTP headers.
     */
    public function getUaHttpHeaders()
    {
        return $this->uaHttpHeaders;
    }
    /**
     * Set CloudFront headers
     * http://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/header-caching.html#header-caching-web-device
     *
     * @param array $cfHeaders List of HTTP headers
     *
     * @return  boolean If there were CloudFront headers to be set
     */
    public function setCfHeaders($cfHeaders = null) {
        // use global _SERVER if $cfHeaders aren't defined
        if (!is_array($cfHeaders) || !count($cfHeaders)) {
            $cfHeaders = $_SERVER;
        }
    
        // clear existing headers
        $this->cloudfrontHeaders = array();
    
        // Only save CLOUDFRONT headers. In PHP land, that means only _SERVER vars that
        // start with cloudfront-.
        $response = false;
        foreach ($cfHeaders as $key => $value) {
            if (substr(strtolower($key), 0, 16) === 'http_cloudfront_') {
                $this->cloudfrontHeaders[strtoupper($key)] = $value;
                $response = true;
            }
        }
    
        return $response;
    }
    
    /**
     * Retrieves the cloudfront headers.
     *
     * @return array
     */
    public function getCfHeaders()
    {
        return $this->cloudfrontHeaders;
    }
    
    /**
     * Set the User-Agent to be used.
     *
     * @param string $userAgent The user agent string to set.
     *
     * @return string|null
     */
    public function setUserAgent($userAgent = null)
    {
        // Invalidate cache due to #375
        //$this->cache = array();
        
        
        if (false === empty($userAgent)) {
            return $this->userAgent = $userAgent;
        } else {
            $this->userAgent = null;
            foreach ($this->uaHttpHeaders as $altHeader) {
                if (false === empty($this->httpHeaders[$altHeader])) { // @todo: should use getHttpHeader(), but it would be slow. (Serban)
                    $this->userAgent .= $this->httpHeaders[$altHeader] . " ";
                }
            }
            if (!empty($this->userAgent)) {
                return $this->userAgent = trim($this->userAgent);
            }
        }
    
        if (count($this->getCfHeaders()) > 0) {
            return $this->userAgent = 'Amazon CloudFront';
        }
        return $this->userAgent = null;
    }
    
    /**
     * Retrieve the User-Agent.
     *
     * @return string|null The user agent if it's set.
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }
    
    /**
     * Some detection rules are relative (not standard),
     * because of the diversity of devices, vendors and
     * their conventions in representing the User-Agent or
     * the HTTP headers.
     *
     * This method will be used to check custom regexes against
     * the User-Agent string.
     *
     * @param $regex
     * @param  string $userAgent
     * @return bool
     *
     * @todo: search in the HTTP headers too.
     */
    public function match($regex)
    {
        $match = (bool) preg_match(sprintf('#%s#is', $regex), $this->userAgent, $matches);
        // If positive match is found, store the results for debug.
        /* if ($match) {
            $this->matchingRegex = $regex;
            $this->matchesArray = $matches;
        } */
    
        return $match;
    }
    /**
     * Set the tablet
     *
     * @return	bool
     */
    protected function _set_tablet()
    {
        
        // Check specifically for cloudfront headers if the useragent === 'Amazon CloudFront'
        if ($this->getUserAgent() === 'Amazon CloudFront') {
            $cfHeaders = $this->getCfHeaders();
            if(array_key_exists('HTTP_CLOUDFRONT_IS_TABLET_VIEWER', $cfHeaders) && $cfHeaders['HTTP_CLOUDFRONT_IS_TABLET_VIEWER'] === 'true') {
                $this->is_tablet = true;
                return true;
            }
        }
        
        //$this->setDetectionType(self::DETECTION_TYPE_MOBILE);
        foreach ($this->tablets as $_regex) {
            if ($this->match($_regex) ){
                $this->is_tablet = true;
                return true;
            }
        }
         
        return false;
    }
    /**
     * Check if the device is a tablet.
     * Return true if any type of tablet device is detected.
     *
     * @param  string $key
     * @return bool
     */
    public function is_tablet($key = null)
    {
        if ( ! $this->is_tablet)
		{
			return FALSE;
		}

		// No need to be specific, it's a mobile
		if ($key === NULL)
		{
			return TRUE;
		}

		// Check for a specific robot
		return (isset($this->tablets[$key]) && $this->tablets === $this->tablets[$key]);
    }
    
    /**
     * Check if the device is a desktop.
     * Return true if any type of tablet device is detected.
     *
     * @param  string $key
     * @return bool
     */
    public function is_desktop()
    {
        return ($this->is_tablet === false) && ($this->is_mobile === false);
    }
}
?>