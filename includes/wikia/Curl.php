<?php
/**
 * cURL wrapper
 *
 * @category Wikia
 * @version $Id:$
 */

/**
 * cURL wrapper
 *
 * To separate business logic from intrastructure (cURL) use this class.
 * It's straight forward curl functions wrapper.
 * curl_multi_* functions are not wrapped. Do so if you need them.
 *
 * @category Wikia
 * @link http://php.net/manual/en/book.curl.php
 * @author Wojciech Szela <wojtek@wikia-inc.com>
 */
class Curl {
	/**
	 * cURL handle (resource)
	 *
	 * @var resource
	 */
	private $curlHandle;
	
	/**
	 * Constructor
	 *
	 * If URL is given initializes cURL handle, otherwise just creates Curl object
	 * and handle has to be initalized manualy
	 * 
	 * @see   Curl::init();
	 * @param string|null $url;
	 */
	public function __construct($url = null) {
		if (null !== $url) {
			$this->init($url);
		}
	}
	
	/**
	 * Destructor
	 *
	 * Ensures handle is closed
	 */
	public function __destruct() {
		if ($this->hasHandle()) {
			$this->close();
		}
	}
	
	/**
	 * Clones object
	 *
	 * Ensures cURL handle is cloned too
	 *
	 * @link http://pl2.php.net/manual/en/function.curl-copy-handle.php
	 */
	public function __clone() {
		if ($this->hasHandle()) {
			$this->setHandle(curl_copy_handle($this->getHandle()));
		}
	}
	
	/**
	 * Close a cURL session
	 *
	 * @link   http://pl2.php.net/manual/en/function.curl-close.php
	 * @return Curl
	 */
	public function close() {
		curl_close($this->getHandle());

		return $this;
	}
	
	/**
	 * Return the last error number
	 *
	 * @link   http://pl2.php.net/manual/en/function.curl-errno.php
	 * @return int
	 */
	public function errno() {
		return curl_errno($this->getHandle());
	}
	
	/**
	 * Return a string containing the last error for the current session
	 *
	 * @link   http://pl2.php.net/manual/en/function.curl-error.php
	 * @return string
	 */
	public function error() {
		return curl_error($this->getHandle());
	}
	
	/**
	 * Perform a cURL session
	 *
	 * @link   http://pl2.php.net/manual/en/function.curl-exec.php
	 * @return bool|string
	 */
	public function exec() {
		return curl_exec($this->getHandle());
	}
	
	/**
	 * Get information regarding a specific transfer
	 *
	 * @link   http://pl2.php.net/manual/en/function.curl-getinfo.php
	 * @param  int one of CURLINFO_* constants
	 * @return array|string
	 */
	public function getinfo($opt = 0) {
		if ($opt) {
			return curl_getinfo($this->getHandle(), $opt);
		}

		return curl_getinfo($this->getHandle());
	}
	
	/**
	 * Initialize a cURL session
	 *
	 * @link   http://pl2.php.net/manual/en/function.curl-init.php
	 * @param  string|null $url
	 * @return bool
	 */
	public function init($url = null) {
		$this->setHandle(curl_init($url));
		
		return $this->hasHandle();
	}
	
	/**
	 * Set multiple options for a cURL transfer
	 *
	 * @link   http://pl2.php.net/manual/en/function.curl-setopt-array.php
	 * @param  array $options
	 * @return bool
	 */
	public function setopt_array(array $options) {
		return curl_setopt_array($this->getHandle(), $options);
	}
	
	/**
	 * Set an option for a cURL transfer
	 *
	 * @link   http://pl2.php.net/manual/en/function.curl-setopt.php
	 * @param  int $option CURLOPT_* option to set
	 * @param  mixed $value
	 * @return bool
	 */
	public function setopt($option, $value) {
		return curl_setopt($this->getHandle(), $option, $value);
	}
	
	/**
	 * Gets cURL version information
	 *
	 * @link   http://pl2.php.net/manual/en/function.curl-version.php
	 * @param  int $age
	 * @return array
	 */
	public function version($age = CURLVERSION_NOW) {
		return curl_version($age);
	}
	
	/**
	 * cURL handle getter
	 *
	 * @return resource|null
	 */
	public function getHandle() {
		return $this->curlHandle;
	}

	/**
	 * cURL handle setter
	 *
	 * @param  resource|null $resource
	 * @return Curl
	 */
	public function setHandle($resource) {
		if (null !== $resource && !is_resource($resource)) {
			throw new WikiaException("Can not set handle that is not cURL handle resource");
		}

		$this->curlHandle = $resource;

		return $this;
	}
	
	/**
	 * Checks if cURL handle is set
	 *
	 * @return bool
	 */
	public function hasHandle() {
		return is_resource($this->getHandle());
	}
}
