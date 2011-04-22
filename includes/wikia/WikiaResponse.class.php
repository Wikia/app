<?php

class WikiaResponse {

	const RESPONSE_CODE_OK = 200;
	const RESPONSE_CODE_ERROR = 501;
	const RESPONSE_CODE_FORBIDDEN = 403;

	/**
	 * View object
	 * @var WikiaView
	 */
	private $view = null;
	private $body = null;
	private $code;
	private $contentType = null;
	private $headers = array();
	private $format = null;
	private $controllerName = null;
	private $methodName = null;
	protected $data = array();
	protected $exception = null;

	public function __construct( $format ) {
		$this->setCode( self::RESPONSE_CODE_OK );
		$this->setFormat( $format );
		$this->setView( F::build( 'WikiaView' ) );
	}

	public function setException(Exception $exception) {
		$this->exception = $exception;
	}

	/**
	 * get view
	 * @return WikiaView
	 */
	public function getView() {
		return $this->view;
	}

	/**
	 * set view
	 * @param WikiaView $view
	 */
	public function setView( WikiaView $view ) {
		$this->view = $view;
		$this->view->setResponse( $this );
	}

	public function getControllerName() {
		return $this->controllerName;
	}

	public function setControllerName( $value ) {
		$this->controllerName = $value;
	}

	public function getMethodName() {
		return $this->methodName;
	}

	public function setMethodName( $value ) {
		$this->methodName = $value;
	}

	public function getData() {
		return $this->data;
	}

	public function setData( Array $data ) {
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

	public function getContentType() {
		return $this->contentType;
	}

	public function setContentType($value) {
		$this->contentType = $value;
	}

	public function hasContentType() {
		return (bool) $this->contentType;
	}

	public function getFormat() {
		return $this->format;
	}

	public function setFormat( $value ) {
		$this->format = $value;
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
		if( isset( $this->data[$key] ) ) {
			return $this->data[$key];
		}
		return $default;
	}

	public function hasException() {
		return ($this->exception == null) ? false : true;
	}

	public function getException() {
		return $this->exception;
	}

	/**
	 * alias to be compatibile with MW AjaxDispatcher
	 * @return string
	 */
	public function printText() {
		print $this->toString();
	}

	public function render() {
		print $this->toString();
	}

	public function toString() {
		if( $this->body === null ) {
			$this->body = $this->view->render();
		}
		return $this->body;
	}

	public function sendHeaders() {
		$this->view->prepareResponse($this);

		$responseCodeSent = false;

		foreach( $this->getHeaders() as $header ) {
			$this->sendHeader( ( $header['name'] . ': ' . $header['value'] ), $header['replace'], ( !$responseCodeSent ? $this->code : null ) );
			$responseCodeSent = true;
		}

		if(!$responseCodeSent) {
			$this->sendHeader( "HTTP/1.1 " . $this->code, false );
		}

		if($this->contentType != null) {
			$this->sendHeader( "Content-Type: " . $this->contentType, true );
		}

	}

	// @codeCoverageIgnoreStart
	protected function sendHeader( $header, $replace, $responseCode = null ) {
		if( !empty( $responseCode ) ) {
			header( $header, $replace, $responseCode );
		}
		else {
			header( $header, $replace );
		}
	}
	// @codeCoverageIgnoreEnd

	public function __toString() {
		return $this->toString();
	}

}
