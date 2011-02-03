<?php

abstract class WikiaController {

	protected $request = null;
	protected $response = null;

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

	public function init() {}
}
