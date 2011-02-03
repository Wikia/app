<?php

class WikiaResponse {

	private $printer = null;
	private $body = null;
	private $headers = array();
	protected $data = array();
	protected $exception = null;
	protected $responseCode = null;

	public function __construct( $format ) {
		$this->setPrinter( WF::build( 'WikiaResponse' . strtoupper( $format ) . 'Printer' ) );
	}

	public function setException(Exception $exception) {
		$this->exception = $exception;
	}

	public function getPrinter() {
		if (null === $this->printer) {
			$this->printer = WF::build('WikiaResponsePrinter');
		}

		return $this->printer;
	}

	public function setPrinter( WikiaResponsePrinter $printer ) {
		$this->printer = $printer;
	}

	public function getData() {
		return $this->data;
	}

	public function setData( $data ) {
		$this->data = $data;
	}

	public function getBody() {
		return $this->body;
	}

	public function setBody($value) {
		$this->body = $value;
	}

	public function appendBody($value) {
		$this->body .= $value;
	}

	public function getHeaders() {
		return $this->headers;
	}

	public function setHeader( $key, $value ) {
		$this->headers[$key] = $value;
	}

	public function setVal( $key, $value ) {
		$this->data[$key] = $value;
	}

	public function getVal( $key, $default = null ) {
		if( isset($this->params[$key]) ) {
			return $this->params[$key];
		}
		return $default;
	}

	public function isException() {
		return ($this->exception == null) ? false : true;
	}

	public function getException() {
		return $this->exception;
	}

	/**
	 * alias to be compatibile with MW AjaxDispatcher
	 */
	public function printText() {
		print $this->toString();
	}

	public function toString() {
		if( $this->body === null ) {
			$this->setBody( $this->getPrinter()->render( $this ) );
		}
		return $this->getBody();
	}

	public function sendHeaders() {
		foreach ($this->getHeaders() as $key => $value) {
			$this->sendHeader( $key, $value );
		}
	}

	public function sendHeader( $key, $value ) {
		header( $key, $value );
	}

	public function __toString() {
		return $this->toString();
	}

}
