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
	
	public static function setSkinTemplateObj(&$skinTemplate) {
		self::$skinTemplateObj = $skinTemplate;
	}

	public static function getSkinTemplateObj() {
		return self::$skinTemplateObj;
	}

	// TODO: This function goes away when all usages are replaced by Controller::sendRequest
	public static function get($name, $action = 'Index', $params = null) {
		return F::app()->sendRequest($name, $action, $params);		
	}

	public function getData($var = null) {
		if($var === null) {
			return get_object_vars($this);
		} else {
			$vars = get_object_vars($this);
			return isset($vars[$var]) ? $vars[$var] : null;
		}
	}
}
