<?php

abstract class WikiaController {

	/**
	 * request object
	 * @var unknown_type
	 */
	protected $request = null;
	/**
	 * response object
	 * @var WikiaResponse
	 */
	protected $response = null;

	public function canDispatch( $method, $format ) {
		return true;
	}

	public function setRequest(WikiaRequest $request) {
		$this->request = $request;
	}

	public function getRequest() {
		return $this->request;
	}

	public function setResponse(WikiaResponse $response) {
		$this->response = $response;
	}

	public function getResponse() {
		return $this->response;
	}

	public function redirect( $controllerName, $methodName, $resetResponse = true ) {
		if( $resetResponse ) {
			$this->response->resetData();
		}

		$this->request->setVal( 'controller', $controllerName );
		$this->request->setVal( 'method', $methodName );
		$this->request->setDispatched(false);
	}

	public function init() {}
}
