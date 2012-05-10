<?php
abstract class Module extends WikiaController {

	protected static $skinTemplateObj;

	// Module specific setup here
	public function init() {
		// auto-initialize any module variables which match variables in skinTemplate->data or _GLOBALS
		$objvars = get_object_vars($this);
		$skindata = array();
		if (isset(self::$skinTemplateObj) && is_array(self::$skinTemplateObj->data)) {
			$skindata = self::$skinTemplateObj->data;
		}
		foreach ($objvars as $var => $unused) {
			if (array_key_exists($var, $GLOBALS)) {
				$this->$var = $GLOBALS[$var];
			}
			if (array_key_exists($var, $skindata)) {
				$this->$var = $skindata[$var];
			}
		}
	}

	/* This magic function allows the Module to pretend to be a Response object
	 * We will pass all calls except getData() render() toString() to the real Response object
	 * Dispatcher is none the wiser, and treats the Module as a response object
	 */
	protected $realResponse;
	/**
	 * list of controller properties that won't be passed to view layer
	 * @var array
	 */
	protected $filteredVars = array( 'app', 'request', 'response', 'realResponse', 'filteredVars' );

	public function __call($method, $args)
	{
		if (method_exists($this->realResponse,$method))
			return call_user_func_array(array($this->realResponse,$method), $args);
		else
			throw new WikiaException( sprintf('Response Proxy failed for Method: %s', $method) );
	}

	// Save the real response object so we can act as a proxy
	public function setResponse(WikiaResponse &$response) {
		$this->realResponse = $response;
		$this->response = $this;
		$response = $this;
	}

	public function printText() {
		$this->realResponse->setData($this->getData());
		print $this->realResponse->toString();
	}

	public function render() {
		$this->realResponse->setData($this->getData());
		print $this->realResponse->toString();
	}

	public function toString() {
		$this->realResponse->setData($this->getData());
		return $this->realResponse->toString();
	}

	public function getVal($key, $default = null) {
		return isset($this->$key) ? $this->$key : $default;
	}
	
	protected function setVal($propertyName, $value) {
		if (property_exists($this, $propertyName)) {
			$this->realResponse->setVal( $propertyName, $value );
		} else {
			$this->$propertyName = $value;
		}
	}	

	// Magic setting of template variables so we don't have to do $this->response->setVal
	// NOTE: This is the opposite behavior of the default Controller
	// In a module, a public member variable goes to the template
	// In a controller, a public member variable does NOT go to the template, it's a local var
	public function __set($propertyName, $value) {
		if (property_exists($this, $propertyName)) {
			$this->realResponse->setVal( $propertyName, $value );
		} else {
			$this->$propertyName = $value;
		}
	}	

	/**
	 * @deprecated
	 */
	public static function setSkinTemplateObj(&$skinTemplate) {
		F::app()->setSkinTemplateObj( $skinTemplate );
	}

	/**
	 * @deprecated
	 */
	public static function getSkinTemplateObj() {
		return F::app()->getSkinTemplateObj();
	}

	// TODO: This function goes away when all usages are replaced by Controller::sendRequest
	public static function get($name, $action = 'Index', $params = null) {
		return F::app()->sendRequest($name, $action, $params);
	}

	public function getData($var = null) {
		$vars = get_object_vars($this);
		if($var === null) {
			return $this->filterData($vars);
		} else {
			return isset($vars[$var]) ? $vars[$var] : null;
		}
	}

	private function filterData( Array $data ) {
		foreach( $this->filteredVars as $varName ) {
			if( isset( $data[$varName] ) ) {
				unset( $data[$varName] );
			}
		}
		return $data;
	}
}
