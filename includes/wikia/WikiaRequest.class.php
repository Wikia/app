<?php

class WikiaRequest {

	private $isDispatched = false;
	private $isInternal = false;
	protected $params = array();

	public function __construct( Array $params ) {
		$this->params = $params;
	}

	public function isXmlHttp() {
		if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) ) {
			return true;
		}
		return false;
	}

	public function getVal( $key, $default = null ) {
		if( isset($this->params[$key]) ) {
			return $this->params[$key];
		}

		return $default;
	}

	public function setVal( $key, $value ) {
		$this->params[$key] = $value;
	}

	public function isDispatched() {
		return $this->isDispatched;
	}

	public function setDispatched($value) {
		$this->isDispatched = (bool) $value;
	}

	public function isInternal() {
		return $this->isInternal;
	}

	public function setInternal($flag) {
		$this->isInternal = (bool) $flag;
	}

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
	 * @param $name string
	 * @param $default bool
	 * @return bool
	 */
	public function getBool( $name, $default = false ) {
		return $this->getVal( $name, $default ) ? true : false;
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
	 * Returns true if the present request was reached by a POST operation,
	 * false otherwise (GET, HEAD, or command-line).
	 *
	 * Note that values retrieved by the object may come from the
	 * GET URL etc even on a POST request.
	 *
	 * @return bool
	 */
	public function wasPosted() {
		return isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] == 'POST';
	}
}
