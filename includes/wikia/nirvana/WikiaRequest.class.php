<?php

/**
 * Nirvana Framework - Request class
 *
 * @ingroup nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 */
class WikiaRequest implements Wikia\Interfaces\IRequest {

	// default = "wrap and throw" for internal requests, "return" for external requests
	const EXCEPTION_MODE_DEFAULT = -1;
	const EXCEPTION_MODE_RETURN = 0;
	const EXCEPTION_MODE_WRAP_AND_THROW = 1;
	const EXCEPTION_MODE_THROW = 2;

	static private $exceptionModes = [
		self::EXCEPTION_MODE_DEFAULT,
		self::EXCEPTION_MODE_RETURN,
		self::EXCEPTION_MODE_WRAP_AND_THROW,
		self::EXCEPTION_MODE_THROW,
	];

	private $isInternal = false;
	private $exceptionMode = self::EXCEPTION_MODE_DEFAULT;
	protected $params = array();

	/**
	 * constructor
	 * @param array $params
	 */
	public function __construct( Array $params ) {
		$this->params = $params;
	}

	/**
	 * checks if it's an ajax request
	 * @note This is experimental
	 * @return bool
	 */
	public function isXmlHttp() {
		if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) ) {
			return true;
		}
		return false;
	}

	/**
	 * get param value
	 * @param string $key param key
	 * @param mixed $default param value
	 * @return mixed
	 */
	public function getVal( $key, $default = null ) {
		if( isset($this->params[$key]) ) {
			return $this->params[$key];
		}

		return $default;
	}

	/**
	 * set param value
	 * @param string $key param key
	 * @param mixed $value param value
	 */
	public function setVal( $key, $value ) {
		$this->params[$key] = $value;
	}

	/**
	 * checks if it's internal request
	 * @return bool
	 */
	public function isInternal() {
		return $this->isInternal;
	}

	/**
	 * set "internal" flag
	 * @param bool $value
	 */
	public function setInternal($value) {
		$this->isInternal = (bool) $value;
	}

	/**
	 * checks what exception mode is set
	 * @return int One of WikiaRequest::EXCEPTION_MODE_*
	 */
	public function getExceptionMode() {
		return $this->exceptionMode;
	}

	/**
	 * set exception mode
	 * @param int $value One of WikiaRequest::EXCEPTION_MODE_*
	 */
	public function setExceptionMode( $value ) {
		$value = (int) $value;
		if ( !in_array( $value, self::$exceptionModes ) ) {
			throw new InvalidArgumentException( 'Exception mode is invalid' );
		}
		$this->exceptionMode = $value;
	}

	/**
	 * returns the effective exception mode (resolved the "default" mode depending on "isInternal" flag)
	 * @return int One of WikiaRequest::EXCEPTION_MODE_*
	 */
	public function getEffectiveExceptionMode() {
		$exceptionMode = $this->getExceptionMode();
		if ( $exceptionMode == self::EXCEPTION_MODE_DEFAULT ) {
			$exceptionMode = $this->isInternal() ? self::EXCEPTION_MODE_WRAP_AND_THROW : self::EXCEPTION_MODE_RETURN;
		}

		return $exceptionMode;
	}

	/**
	 * get all params
	 * @return array
	 */
	public function getParams() {
		return $this->params;
	}

	/**
	 * Fetch an integer value from the input or return $default if not set.
	 * Guaranteed to return an integer; non-numeric input will typically
	 * return 0.
	 * @param $name string
	 * @param $default int
	 * @return int
	 */
	public function getInt( $name, $default = 0 ) {
		return intval( $this->getVal( $name, $default ) );
	}

	/**
	 * Fetch a boolean value from the input or return $default if not set.
	 * Guaranteed to return true or false, with normal PHP semantics for
	 * boolean interpretation of strings.
	 * String "false" will be interpreted as false.
	 * @param $name string
	 * @param $default bool
	 * @return bool
	 */
	public function getBool( $name, $default = false ) {
		$value = $this->getVal( $name, $default );
		if (is_string($value) && strcasecmp($value, "false") == 0) return false;
		return $value ? true : false;
	}

	/**
	 * Return true if the named value is set in the input, whatever that
	 * value is (even "0"). Return false if the named value is not set.
	 * Example use is checking for the presence of check boxes in forms.
	 * @param $name string
	 * @return bool
	 */
	public function getCheck( $name ) {
		$val = $this->getVal( $name, null );
		return isset( $val );
	}

	/**
	 * Returns the value as an array,
	 * if it's not set it will return the default if specified;
	 * if the value is a comma-separate list of elements as a string
	 * (e.g. 1,2,3,4,5) it will be split and returned as an array
	 *
	 * @param string $name The name of the value to retrieve
	 * @param mixed $default The default to return if the value is not set
	 *
	 * @return  Array The value as an array
	 */
	public function getArray( $name, $default = array() ) {
		$val = $this->getVal( $name, $default );

		if ( $val === $default ) {
			//just return $default
		} else if ( is_string( $val ) && strpos( $val, ',') !== false ) {
			$val = explode( ',', $val );
		} elseif ( !is_array( $val ) ) {
			$val = array( $val );
		}

		return $val;
	}

	/**
	 * Returns true if the present request was reached by a POST operation,
	 * false otherwise (GET, HEAD, or command-line).
	 *
	 * Note that values retrieved by the object may come from the
	 * GET URL etc even on a POST request.
	 *
	 * @return bool
	 */
	public function wasPosted() {
		wfRunHooks( 'WikiaRequestWasPosted' );

		return isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] == 'POST';
	}


	/**
	 * get cookies array
	 * @deprecated
	 * @return array
	 */
	public function getCookies() {
		return $_COOKIE;
	}

	/**
	 * get cookie
	 * @param string $key
	 * @return mixed
	 */
	public function getCookie( $key ) {
		return $this->isCookie( $key ) ? $_COOKIE[ $key ] : null;
	}

	/**
	 * set cookie
	 * @param string $key
	 * @param mixed $value
	 * @param int $expire
	 * @param string $path
	 * @param string $domain
	 */
	public function setCookie( $key, $value, $expire, $path = '/', $domain = null ) {
		setcookie( $key, $value, $expire, $path, $domain );
	}

	/**
	 * unset cookie
	 * @param string $key
	 */
	public function unsetCookie( $key ) {
		unset( $_COOKIE[ $key ] );
	}

	/**
	 * check if cookie is set
	 * @param string $key
	 */
	public function isCookie( $key ) {
		return (bool) isset( $_COOKIE[ $key ] );
	}

	/*
	 * Get data from $_SESSION
	 * @param $key String Name of key in $_SESSION
	 * @return mixed
	 */
	public function getSessionData( $key ) {
		if( !isset( $_SESSION[$key] ) )
			return null;
		return $_SESSION[$key];
	}

	/**
	 * Set session data
	 * @param $key String Name of key in $_SESSION
	 * @param $data mixed
	 */
	public function setSessionData( $key, $data ) {
		$_SESSION[$key] = $data;
	}
	
	/*
	 * Get data from $_SERVER['SCRIPT_URL'], which is original path of the request, before mod_rewrite changed it.
	 * Please be aware how our URL rewrites work before you think about using this.
	 * @return string|null
	 */
	public function getScriptUrl() {
		$scriptUrl = isset( $_SERVER['SCRIPT_URL'] ) ? $_SERVER['SCRIPT_URL'] : null;
		return $scriptUrl;
	}

	/**
	 * Verify if write request is a valid, non-CSRF request
	 * (uses POST and contains a valid edit token)
	 *
	 * @param \User $user
	 * @return mixed
	 * @throws BadRequestException
	 */
	public function isValidWriteRequest( \User $user ) {
		if ( !$this->wasPosted() || !$user->matchEditToken( $this->getVal( 'token' ) ) ) {
			throw new BadRequestException( 'Request must be POSTed and provide a valid edit token.' );
		}
	}
}
