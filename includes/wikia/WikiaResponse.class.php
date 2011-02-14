<?php

class WikiaResponse {

	const RESPONSE_CODE_OK = 200;
	const RESPONSE_CODE_ERROR = 501;

	private $printer = null;
	private $body = null;
	private $code;
	private $headers = array();
	private $format = null;
	protected $data = array();
	protected $exception = null;
	protected $templatePath = null;

	public function __construct( $format ) {
		$this->setCode( self::RESPONSE_CODE_OK );
		$this->setFormat( $format );
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

	public function resetData() {
		$this->data = array();
	}

	public function appendBody($value) {
		$this->body .= $value;
	}

	public function getCode() {
		return $this->code;
	}

	public function setCode($value) {
		$this->code = $value;
	}

	public function getTemplatePath() {
		return $this->templatePath;
	}

	public function setTemplatePath( $value ) {
		$this->templatePath = $value;
	}

	public function buildTemplatePath( $controllerName, $methodName, $forceRebuild = false ) {
		if( ( $this->templatePath == null ) || $forceRebuild ) {
			$autoloadClasses = WF::build( 'App' )->getGlobal( 'wgAutoloadClasses' );
			$controllerClass = $controllerName . 'Controller';

			if( empty( $autoloadClasses[$controllerClass] ) ) {
				throw new WikiaException( "Invalid controller name: $controllerName" );
			}

			$this->setTemplatePath( dirname( $autoloadClasses[$controllerClass] ) . '/templates/' . $controllerName . '_' . $methodName . '.php' );
		}
	}

	public function getFormat() {
		return $this->format;
	}

	public function setFormat( $value ) {
		$this->format = $value;
		$this->setPrinter( WF::build( 'WikiaResponse' . strtoupper( $value ) . 'Printer' ) );
	}

	public function getHeaders() {
		return $this->headers;
	}

	public function setHeader( $name, $value, $replace = true ) {
		if( $replace ) {
			$this->removeHeader( $name );
		}

		$this->headers[] = array(
		 'name' => $name,
		 'value' => $value,
		 'replace' => $replace
		);
	}

	public function getHeader( $name ) {
		$result = array();
		foreach( $this->headers as $key => $header ) {
			if( $header['name'] == $name ) {
				$result[] = $header;
			}
		}

		return ( count($result) ? $result : null );
	}

	public function removeHeader( $name ) {
		foreach( $this->headers as $key => $header ) {
			if( $header['name'] == $name ) {
				unset( $this->headers[ $key ] );
			}
		}
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
		$this->getPrinter()->prepareResponse($this);

		$responseCodeSent = false;

		foreach( $this->getHeaders() as $header ) {
			$this->sendHeader( ( $header['name'] . ': ' . $header['value'] ), $header['replace'], ( !$responseCodeSent ? $this->code : null ) );
			$responseCodeSent = true;
		}

		if(!$responseCodeSent) {
			$this->sendHeader( "HTTP/1.1 " . $this->code, false );
		}
	}

	protected function sendHeader( $header, $replace, $responseCode = null ) {
		if( !empty( $responseCode ) ) {
			header( $header, $replace, $responseCode );
		}
		else {
			header( $header, $replace );
		}
	}

	public function __toString() {
		return $this->toString();
	}

}
