<?php

namespace Wikia\Helios;

/**
 * An exception class for the client.
 */
class Exception extends \Exception
{
	use \Wikia\Logger\Loggable;

	private $data;

	public function __construct( $message = null, $code = 0, \Exception $previous = null, $data = null ) {
		parent::__construct( $message, $code, $previous );
		$this->data = $data;
		$this->logMe();
	}

	public function getLoggerContext() {
		$data = $this->getData();
		if ( $data === null ) {
			$data = [];
		} elseif ( !is_array($data) ) {
			$data = [ 'data' => $data ];
		}
		return array_merge( [ 'exception' => $this ], $data );
	}

	public function getData() {
		return $this->data;
	}

	public function getResponse() {
		return !empty($this->data) && !empty($this->data['response']) ? $this->data['response'] : null;
	}

	protected function logMe() {
		// noop
	}
}

class ClientException extends Exception
{
	protected function logMe() {
		$this->error( 'HELIOS_CLIENT client_exception' );
	}
}
