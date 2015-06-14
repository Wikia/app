<?php

/*
 * Generate unique request ID or use the value when passed as HTTP request header
 *
 * Usage:
 *
 * Wikia\Util\RequestId::instance()->getRequestId()
 *
 * @see PLATFORM-362
 */

namespace Wikia\Util;

class RequestId {

	const REQUEST_HEADER_NAME = 'X-Request-Id';
	const REQUEST_HEADER_ORIGIN_HOST = 'X-Request-Origin-Host';
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

	/*
	 * Return unique request ID. Either:
	 *
	 * - get it from HTTP request header
	 * - generate a new one
	 *
	 * @return string unique ID
	 */
	function getRequestId() {
		// request ID is already generated
		if ( $this->requestId !== false ) {
			return $this->requestId;
		}

		// try to get the value from request header
		// we can't simply use $wgRequest as it's not yet set at this point
		// this method is called on WikiFactoryExecuteComplete hook
		$headerValue = !empty( $_SERVER['HTTP_X_REQUEST_ID'] ) ? $_SERVER['HTTP_X_REQUEST_ID'] : false;

		if ( self::isValidId( $headerValue ) ) {
			$this->requestId = $headerValue;
			wfDebug( __METHOD__ . ": from HTTP request\n" );
		}
		else {
			// return 23 characters long unique ID + mw prefix
			// e.g. mw5405bb3d129e76.46189257
			$this->requestId = uniqid( 'mw', true );
			wfDebug( __METHOD__ . ": generated a new one\n" );
		}

		wfDebug( __METHOD__ . ": {$this->requestId}\n" );
		return $this->requestId;
	}

	/**
	 * Validate provided request ID
	 *
	 * @param $id
	 * @return bool
	 */
	public static function isValidId( $id ) {
		return is_string( $id ) &&
			strlen( $id ) === 25 &&
			startsWith( $id, 'mw' );
	}
}
