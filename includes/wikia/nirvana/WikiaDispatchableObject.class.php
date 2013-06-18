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
	 * Describes object to dispatch to after this one is done
	 * Used by "forward" function and "after" routing rule
	 * @var $callNext array
	 */
	protected $callNext = array();

	/**
	 * Whether the class accepts external requests
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

	public function forward( $controllerName, $methodName, $resetData = true ) {
		$this->callNext[] = array(
			"controller" => $controllerName,
			"method" => $methodName,
			"reset" => $resetData
		);
	}

	public function hasNext() {
		return !empty($this->callNext);
	}

	public function getNext() {
		if ($this->hasNext()) {
			return array_pop($this->callNext);
		} else {
			return false;
		}
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
	 * Returns the URL that would be used for an Ajax or API call (Nirvana) to access this method
	 *
	 * @param string $method The method name
	 * @param array $params An hash with the parameters for the request and their possible values,
	 * schema ['paramName' => 'value', ...]
	 *
	 * @return string The absolute URL
	 */
	public static function getUrl( $method, Array $params = null ) {
		$app = F::app();
		$basePath = wfExpandUrl( $app->wg->Server . $app->wg->ScriptPath . '/wikia.php' );

		$baseParams = array(
			'controller' => preg_replace( "/Controller$/", '', get_called_class() ),
			'method' => $method
		);

		if ( !empty( $params ) ) {
			//WikiaAPI requests accept only sorted params
			//to cut down caching variants
			ksort( $params );
			$baseParams = array_merge( $baseParams, $params );
		}

		return wfAppendQuery( $basePath, $baseParams );
	}

	/**
	 * Purges URL's for multiple methods at once
	 *
	 * @param array $map A map with the schema [['methodName', ['paramName' => 'value', ...]], ...]
	 * or ['methodName', 'methodName2', ...]
	 *
	 * @return array A list of the urls purged
	 */
	public static function purgeMethods( Array $map ){
		$urls = [];

		foreach ( $map as $data ) {
			if ( is_array( $data ) ) {
				$method = $data[0];
				$params = $data[1];
			} else {
				$method = $data;
				$params = null;
			}

			$urls[] = self::getUrl( $method, $params );
		}

		if ( !empty( $urls ) ) {
			$squidUpdate = new SquidUpdate( $urls );
			$squidUpdate->doUpdate();
		} else {
			return false;
		}

		//returning the processed URL's
		//more than for a practical reason
		//this is a work-around for PHPunit's
		//issues with mocking/spying chained static methods
		return $urls;
	}

	/**
	 * Purges the URL for a single method
	 *
	 * @param string $method The method name
	 * @param array $params [OPTIONAL] An hash of the request's parameters with the schema ['paramName' => 'value', ...]
	 *
	 * @return array A list of the urls purged
	 */
	public static function purgeMethod( $method, Array $params = [] ) {
		return self::purgeMethods( [[$method, $params]] );
	}

	/**
	 * Purges multiple URL variants for a method, e.g. in case of different parameter values
	 *
	 * @param string $method The method name
	 * @param array $paramsArray [OPTIONAL] An array of hashes with all the parameters variations,
	 * schema [['paramName' => 'value1', ...], ['paramName' => 'value2', ...], ...]
	 *
	 * @return array A list of the urls purged
	 */
	public static function purgeMethodVariants( $method, Array $paramsArray = [] ) {
		$map = [];

		foreach ( $paramsArray as $params ) {
			$map[] = [$method, $params];
		}

		return self::purgeMethods( $map );
	}
}
