<?php

/**
 * WikiaMockProxyInvocation helps to call original function or method when you have mocked it.
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
class WikiaMockProxyInvocation {

	protected $object;
	protected $className;
	protected $functionName;
	protected $arguments;

	public function __construct( $options ) {
		foreach ($options as $k => $v) {
			if ( property_exists($this,$k) ) {
				$this->$k = $v;
			}
		}
	}

	public function getObject() {
		return $this->object;
	}

	public function getClassName() {
		return $this->className;
	}

	public function getFunctionName() {
		return $this->functionName;
	}

	public function getArguments() {
		return $this->arguments;
	}

	protected function getOriginalCallback() {
		// no ability to call original constructor
		if ( $this->functionName === '__construct' ) {
			return null;
		}
		if ( !empty( $this->object ) ) {
			// regular method call
			$savedName = WikiaMockProxy::SAVED_PREFIX . $this->functionName;
//			$callback = array( $this->object, method_exists( $this->object, $savedName ) ? $savedName : $this->functionName );
			$callback = array( $this->object, $savedName );
		} else if ( !empty( $this->className ) ) {
			// static method call
			$savedName = WikiaMockProxy::SAVED_PREFIX . $this->functionName;
//			$callback = array( $this->className, method_exists( $this->className, $savedName ) ? $savedName : $this->functionName );
			$callback = array( $this->className, $savedName );
		} else {
			// global function call
			list($namespace,$baseName) = WikiaMockProxy::parseGlobalFunctionName($this->functionName);
			$savedName = $namespace . WikiaMockProxy::SAVED_PREFIX . $baseName;
//			$callback = function_exists( $savedName ) ? $savedName : $this->functionName;
			$callback = $savedName;
		}

		return $callback;
	}

	/**
	 * Call an original function or method and return the result
	 *
	 * @param $arguments array (optional) Arguments
	 * @return mixed
	 * @throws Exception
	 */
	public function callOriginal( $arguments = null ) {
		if ( func_num_args() == 0 ) {
			$arguments = $this->arguments;
		}
		$callback = $this->getOriginalCallback();
		if ( $callback === null ) {
			throw new Exception("Due to technical limitations the original function/method could not be called.");
		}
		return call_user_func_array( $callback, $arguments );
	}

	public function __toString() {
		if ( !empty( $this->object ) ) {
			// regular method call
			$string = get_class($this->object) .'->' . $this->functionName . '()';
		} else if ( !empty( $this->className ) ) {
			// static method call
			$string = $this->className . '::' . $this->functionName . '()';
		} else {
			// global function call
			$string = $this->functionName . '()';
		}
		return $string;
	}

}