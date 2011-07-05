<?php

/**
 * Nirvana Framework - Component class
 *
 * @ingroup nirvana
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
abstract class WikiaBaseController {
	/**
	 * request object
	 * @var WikiaRequest
	 */
	protected $request = null;
	
	/**
	 * response object
	 * @var WikiaResponse
	 */
	protected $response = null;
	
	/**
	 * application object
	 * @var WikiaApp
	 */
	protected $app = null;
	
	/**
	 * global registry object
	 * @var WikiaGlobalRegistry
	 */
	protected $wg = null;
	
	/**
	 * function wrapper object
	 * @var WikiaFunctionWrapper
	 */
	protected $wf = null;

	/**
	 * wether the class accepts external requests
	 * @return boolean
	 */
	abstract public function allowsExternalRequests();

	/**
	 * redirects flow to another controller/method
	 *
	 * @param string $controllerName
	 * @param string $methodName
	 * @param bool $resetResponse
	 */
	protected function redirect( $controllerName, $methodName, $resetResponse = true ) {
		if( $resetResponse ) {
			$this->response->resetData();
		}

		$this->request->setVal( 'controller', $controllerName );
		$this->request->setVal( 'method', $methodName );
		$this->request->setDispatched(false);
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
	 * init function for controller, called just before method
	 */
	public function init() {}

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

	/**
	 * get application
	 * @return WikiaApp
	 */
	public function getApp() {
		return $this->app;
	}

	/**
	 * set application
	 * @param WikiaApp $app
	 */
	public function setApp( WikiaApp $app ) {
		$this->app = $app;

		// setting helpers
		$this->wg = $app->wg;
		$this->wf = $app->wf;
	}
}