<?php
/*
 * Not because you want to, but because you have to.
 *
 * Example usage:
 * $wrapper = new GlobalStateWrapper(array('wgUser' => $user));
 * $wrapper->wrap(function () {
 *		// ... do some stuff with core that expects $wgUser
 * });
 *
 */

namespace Wikia\Util;

class GlobalStateWrapper {


	/**
	 * @var array $globalsToWrap
	 */
	private $globalsToWrap = null;

	/*
	 * @var array $capturedState
	 */
	private $capturedState = null;


	/**
	 * @param array $globalsToWrap key value pair of global name and overriding value
	 */
	function __construct( array $globalsToWrap ) {
		$this->globalsToWrap = $globalsToWrap;
	}

	public function wrap( $function ) {
		if ( !is_callable( $function ) ) {
			throw new \InvalidArgumentException( "Error, the \$function parameter provided is not callable." );
		}

		$result = null;
		$caughtException = null;
		$this->captureState();

		try {
			$result = $function();
		} catch ( \Exception $e ) {
			$caughtException = $e;
		}

		$this->restoreState();

		if ( isset( $caughtException ) ) {
			throw $caughtException;
		}

		return $result;
	}

	protected function captureState() {
		$this->capturedState = array();
		foreach ( $this->globalsToWrap as $globalKey => $globalValue ) {
			$this->capturedState[$globalKey] = array_key_exists( $globalKey, $GLOBALS ) ? $GLOBALS[$globalKey] : null;
			$GLOBALS[$globalKey] = $globalValue;
		}
	}

	protected function restoreState() {
		foreach ( $this->globalsToWrap as $globalKey => $globalValue ) {
			$GLOBALS[$globalKey] = $this->capturedState[$globalKey];
		}
	}

}
