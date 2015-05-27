<?php

namespace Flags\Exceptions;

use Wikia\Logger\Loggable;

class FlagsException extends \Exception {
	use Loggable;

	private $data;

	public function __construct( $message = null, $code = 0 ) {
		parent::__construct( $message, $code, null );
//		$this->data = $data;
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
		return !empty( $this->data ) && !empty( $this->data['response'] ) ? $this->data['response'] : null;
	}

	protected function logMe() {
		// noop
	}
}
