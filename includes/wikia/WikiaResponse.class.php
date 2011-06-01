<?php

/**
 * Nirvana Framework - Response class
 *
 * @ingroup nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 */
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
	private $code = null;
	private $contentType = null;
	private $headers = array();
	private $format = null;
	private $controllerName = null;
	private $methodName = null;
	protected $data = array();
	protected $exception = null;

	/**
	 * constructor
	 * @param string $format
	 */
	public function __construct( $format ) {
		$this->setFormat( $format );
		$this->setView( F::build( 'WikiaView' ) );
	}

	/**
	 * set exception
	 * @param Exception $exception
	 */
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

	/**
	 * gets the controller name
	 * @return string
	 */
	public function getControllerName() {
		return $this->controllerName;
	}

	/**
	 * sets the controller name
	 * @param string $value
	 */
	public function setControllerName( $value ) {
		$this->controllerName = $value;
	}

	/**
	 * gets method name
	 * @return string
	 */
	public function getMethodName() {
		return $this->methodName;
	}

	/**
	 * sets method name
	 * @param string $value
	 */
	public function setMethodName( $value ) {
		$this->methodName = $value;
	}

	/**
	 * gets response data
	 * @return array
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * sets response data
	 * @param array $data
	 */
	public function setData( Array $data ) {
		$this->data = $data;
	}

	/**
	 * get response body
	 * @return string
	 */
	public function getBody() {
		return $this->body;
	}

	/**
	 * sets response body
	 * @param string $value
	 */
	public function setBody($value) {
		$this->body = $value;
	}

	/**
	 * reset all response data
	 */
	public function resetData() {
		$this->data = array();
	}

	/**
	 * append something to response body
	 * @param string $value
	 */
	public function appendBody($value) {
		$this->body .= $value;
	}

	/**
	 * get response code
	 * @return int
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * set response code
	 * @param int $value
	 */
	public function setCode($value) {
		$this->code = $value;
	}

	/**
	 * get content type
	 * @return string
	 */
	public function getContentType() {
		return $this->contentType;
	}

	/**
	 * set content type
	 * @param string $value
	 */
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

		foreach( $this->getHeaders() as $header ) {
			$this->sendHeader( ( $header['name'] . ': ' . $header['value'] ), $header['replace']);
		}

		if(!empty($this->code)) {
			$msg = '';
			
			//standard HTTP response codes get automatically described by PHP and those descriptions shouldn't be overridden, ever
			//use a custom error code if you need a custom code description
			if( !$this->isStandardHTTPCode( $this->code ) ) {
				if ( $this->hasException() ) {
					$msg = ' ' . $this->getException()->getMessage();
				}
				
				if(empty($msg))
					$msg = ' Unknown';
			}
			
			$this->sendHeader( "HTTP/1.1 {$this->code}{$msg}", false );
		}

		if(!empty($this->contentType)) {
			$this->sendHeader( "Content-Type: " . $this->contentType, true );
		}

	}
	
	private function isStandardHTTPCode($code){
		return in_array( $code, array(
			100, 101,
			200, 201, 202, 203, 204, 205, 206,
			300, 301, 302, 303, 304, 305, 306, 307,
			401, 402, 403, 404, 405, 406, 407, 408, 409, 410, 411, 412, 413, 414, 415, 416, 417,
			500, 501, 502, 503, 504, 505
		) );
	}

	// @codeCoverageIgnoreStart
	protected function sendHeader( $header, $replace ) {
		header( $header, $replace );
	}
	// @codeCoverageIgnoreEnd

	public function __toString() {
		try {
			return $this->toString();
		} catch( Exception $e ) {
			// php doesn't allow exceptions to be thrown inside __toString() so we need an extra try/catch block here
			$app = F::app();
			$this->setException( $e );
			return $app->getView( 'WikiaError', 'error', array( 'response' => $this, 'devel' => $app->wg->DevelEnvironment ) )->render();
		}
	}

}
