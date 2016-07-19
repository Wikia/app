<?php

/**
 * Generate unique request ID or use the value when passed as HTTP request header or env variable
 *
 * Usage:
 *
 * Wikia\Tracer\RequestId::instance()->getRequestId()
 *
 * @see PLATFORM-362
 */
namespace Wikia\Tracer;

class RequestId {

	private $requestId = false;

	/**
	 * @return self
	 */
	public static function instance() {
		static $instance = null;

		if ( !isset( $instance ) ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Return unique request ID. Either:
	 *
	 * - get it from HTTP request header (X-Request-Id)
	 * - get it from env variable (X_TRACE_ID)
	 * - generate a new one
	 *
	 * @return string unique ID
	 */
	function getRequestId() {
		// request ID is already generated
		if ( $this->requestId !== false ) {
			return $this->requestId;
		}

		// try to get the value from request's X-Request-Id header or env variable
		// we can't simply use $wgRequest as it's not yet set at this point
		// this method is called on WikiFactoryExecuteComplete hook
		// TODO: handle X-Trace-Id header as well
		$headerValue = !empty( $_SERVER['HTTP_X_REQUEST_ID'] ) ? $_SERVER['HTTP_X_REQUEST_ID'] : false;
		$envValue = !empty( $_ENV[WikiaTracer::ENV_VARIABLES_PREFIX . 'X_TRACE_ID'] ) ? $_ENV[WikiaTracer::ENV_VARIABLES_PREFIX . 'X_TRACE_ID'] : false;

		if ( self::isValidId( $headerValue ) ) {
			$this->requestId = $headerValue;
			wfDebug( __METHOD__ . ": from HTTP request\n" );
		}
		else if ( self::isValidId( $envValue ) ) {
			$this->requestId = $envValue;
			wfDebug( __METHOD__ . ": from env variable\n" );
		}
		else {
			$this->requestId = self::generateId();
			wfDebug( __METHOD__ . ": generated a new one\n" );
		}

		wfDebug( __METHOD__ . ": {$this->requestId}\n" );
		return $this->requestId;
	}

	/**
	 * Return a version 4 (random) UUID (e.g. 8454441a-f0e1-11e5-9c4a-00163e046284)
	 * @return string
	 */
	public static function generateId() {
		return Uuid::v4();
	}

	/**
	 * Validate provided request ID
	 *
	 * @param string $id
	 * @return bool
	 */
	public static function isValidId( $id ) {
		return Uuid::isValid( $id );
	}
}
