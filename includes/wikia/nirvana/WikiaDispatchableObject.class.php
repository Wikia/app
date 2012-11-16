<?php

/**
 * Nirvana Framework - Dispatchable Object class
 * This class adds Request / Response vars and a sendRequest method to WikiaObject
 *
 * @ingroup nirvana
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 */
abstract class WikiaDispatchableObject extends WikiaObject {
	
	/**
	 * Mediawiki RequestContext object
	 * @var $context RequestContext
	 */
	protected $context = null;

	/**
	 * request object
	 * @var $request WikiaRequest
	 */
	protected $request = null;
	
	/**
	 * response object
	 * @var $response WikiaResponse
	 */
	protected $response = null;
	
	/**
	 * wether the class accepts external requests
	 * @return boolean
	 */
	abstract public function allowsExternalRequests();

	/**
	 * Forwards application flow to another controller/method
	 *
	 * @param string $controllerName
	 * @param string $methodName
	 * @param bool $resetData
	 */
	protected function forward( $controllerName, $methodName, $resetData = true ) {
		if( $resetData ) {
			$this->response->resetData();
		}

		$this->request->setVal( 'controller', $controllerName );
		$this->request->setVal( 'method', $methodName );
		$this->request->setDispatched(false);
	}

	/**
	 * Shortcut to override the template for the current response
	 *
	 * @param string $templateName The name of the template without the
	 * CONTROLLERNAME_ prefix and the .php suffix (e.g. pass Test for
	 * the MyController_Test.php template file)
	 */
	protected function overrideTemplate( $templateName ){
		$this->response->getView()->setTemplate( get_class( $this ), $templateName );
	}

	/**
	 * send request to another controller/method
	 *
	 * @param string $controllerName
	 * @param string $methodName
	 * @param array $params
	 * @return WikiaResponse
	 */
	protected function sendRequest( $controllerName, $methodName, $params = array() ) {
		return $this->app->sendRequest( $controllerName, $methodName, $params );
	}

	/**
	 * Convenience method for sending requests to the same controller
	 *
	 * @param string $methodName
	 * @param array $params
	 * @return WikiaResponse
	 */
	protected function sendSelfRequest( $methodName, $params = array() ) {
		return $this->sendRequest( $this->response->getControllerName(), $methodName, $params );
	}

	/**
	 * Convenience method for getting a value from the request object
	 * @param string $key
	 * @param string $value
	 */

	protected function getVal($key, $default = null) {
		return $this->request->getVal($key, $default);
	}

	/**
	 * Convenience method for setting a value on the response object
	 * @param string $key
	 * @param string $value
	 */
	protected function setVal($key, $value) {
		$this->response->setVal($key, $value);
	}

	/**
	 * force framework to skip rendering the template
	 */
	public function skipRendering() {
		$this->response->setBody('');
	}

	/**
	 * init function for controller, called just before sendRequest method dispatching
	 */
	public function init() {}

	/**
	 * set context 
	 * @param RequestContext $context
	 */

	public function setContext(RequestContext $context) {
		$this->context = $context;
	}
	
	public function getContext() {
		return $this->context;
	}
	
	/**
	 * set request
	 * @param WikiaRequest $request
	 */
	public function setRequest(WikiaRequest $request) {
		$this->request = $request;
	}

	/**
	 * get request
	 * @return WikiaRequest
	 */
	public function getRequest() {
		return $this->request;
	}

	/**
	 * set response
	 * @param WikiaResponse $response
	 */
	public function setResponse(WikiaResponse $response) {
		$this->response = $response;
	}

	/**
	 * get response
	 * @return WikiaResponse
	 */
	public function getResponse() {
		return $this->response;
	}

	// Magic setting of template variables so we don't have to do $this->response->setVal
	// NOTE: This is the opposite behavior of the Oasis Module
	// In a module, a public member variable goes to the template
	// In a controller, a public member variable does NOT go to the template, it's a local var
	
	public function __set($propertyName, $value) {
		if (property_exists($this, $propertyName)) {
			$this->$propertyName = $value;
		} else {
			$this->response->setVal( $propertyName, $value );
		}
	}
	
	// Returns a reference now, allowing for better syntax during set operations
	public function &__get($propertyName) {
		if (property_exists($this, $propertyName)) {
			return $this->$propertyName;
		} else {
			return $this->response->getVal( $propertyName );
		}
	}
	
	public function __isset($propertyName) {
		if (property_exists($this, $propertyName)) {
			return isset($this->$propertyName);
		} else {
			// have to use temp var here because isset is a write context and you can't use the function call directly
			$value = $this->response->getVal( $propertyName );
			return isset( $value );
		}
	}
	
	public function __unset($propertyName) {
		if (property_exists($this, $propertyName)) {
			unset ($this->$propertyName);
		} else {
			$this->response->unsetVal($propertyName);
		}		
	}

	/**
	 * get URL that would be used from Ajax Nirvana call to access this method
	 * primary intended use is for Purging those URLs in Varnish
	 * @return String url
	 */
	public static function getUrl($method, $format = 'html', $params = array() ) {
		$app = F::app();
		$basePath = $app->wf->ExpandUrl( $app->wg->Server . $app->wg->ScriptPath . '/wikia.php' );
		$baseParams = array(
			'controller' => get_called_class(),
			'method' => $method,
			'format' => $format,
		);
		ksort($params);
		$params = array_merge( $baseParams, $params );
		return $app->wf->AppendQuery( $basePath, $params );
	}
	/**
	 * purge external method call from caches
	 */
	public static function purgeMethod($method, $format = 'html', $params = array() ) {
		$url = call_user_func(get_called_class()."::getUrl", $method, $format, $params );
		$squidUpdate = new SquidUpdate( array($url) );
		$squidUpdate->doUpdate();
	}
	
	
	/**
	 *  purge external method with multiple sets of parameters 
	 * 
	 *  For example we have method which get some information about article: 
	 *  controller=somectr&method=getSomeData&articleId=2 
	 * 
	 *  Now after some action in system we want to purge this method for articleId=1 and articleId=2
	 * 
	 *  we can call somectr::purgeMethodWithMultipleInputs('getSomeData', 'html', array( array('articleId' => 1), array('articleId' => 2) ) );
	 *   
	 */
	public static function purgeMethodWithMultipleInputs($method, $format = 'html', $paramsArray = array() ) {
		$urls = array();
		foreach($paramsArray as $params) {
			$url = call_user_func(get_called_class()."::getUrl", $method, $format, $params );
			$urls[] = $url;			
		}

		$squidUpdate = new SquidUpdate( $urls );
		$squidUpdate->doUpdate();		
	}
}