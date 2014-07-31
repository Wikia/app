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
 * if ($wrapper->getException()) {
 *	  // oops, something went wrong, but I don't need to clean up $wgUser
 *    // because that's been done for me
 * }
 */

namespace Wikia\Util;

class GlobalStateWrapper {

	private $caughtException = null;

	private $globalsToWrap = null;

	private $capturedState = null;


	/**
	 * @param array $globalsToWrap key value pair of global name and overriding value
	 */
	function __construct(array $globalsToWrap) {
		$this->globalsToWrap = $globalsToWrap;
	}

	public function wrap($function) {
		$result = null;
		$this->captureState();

		try {
			$result = $function();
		} catch (\Exception $e) {
			$this->caughtException = $e;
		}

		$this->restoreState();

		return $result;
	}

	public function setCaughtException(Exception $e) {
		$this->caughtException = $e;
	}

	public function getException() {
		return $this->caughtException;
	}

	protected function captureState() {
		$this->capturedState = array();
		foreach($this->globalsToWrap as $globalKey => $globalValue) {
			$this->capturedState[$globalKey] = $GLOBALS[$globalKey];
			$GLOBALS[$globalKey] = $globalValue;
		}
	}

	protected function restoreState() {
		foreach($this->globalsToWrap as $globalKey => $globalValue) {
			$GLOBALS[$globalKey] = $this->capturedState[$globalKey];
		}
	}

}
