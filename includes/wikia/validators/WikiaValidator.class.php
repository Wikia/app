<?php

abstract class WikiaValidator {
	protected $error = null;
	protected $options = array();
	protected $msgs = array();
	protected $value = null;

	function __construct(array $options = array(), array $msgs = array()) {
		$this->setOption( "required", false );
		$this->config( $options );
		$this->configMsgs( $msgs );

		foreach($options as $key => $option ) {
			if( $this->hasOption($key) ) {
				$this->setOption( $key, $option );
			} else {
				$this->throwException("option ".$key." is not supported for ".get_class($this) );
			}
		}
		foreach($msgs as $key => $msg ) {
			if( $this->hasMsg($key) ) {
				$this->setMsg( $key, $msg );
			} else {
				$this->throwException("error code is not supported:".$key);
			}
		}
	}

	public function isValidInternal($value = null) {
		return false;
	}

	protected function config( array $options = array() ) {
		return null;
	}

	protected function configMsgs( array $msgs = array() ) {
		return null;
	}

	public function isValid($value = null) {
		if(!is_array($value) && !$this->getOption("required") && strlen($value) == 0 ) {
			return true;
		}
		$this->error = null;
		return $this->isValidInternal($value);
	}

	public function getError() {
		return $this->error;
	}


	protected function setError( $error ) {
		$this->error = $error;
	}

	protected function generateError( $errorCode ) {
		if( !$this->hasMsg( $errorCode ) ) {
			$this->throwException("error code is not supported:".$errorCode);
		}

		return new WikiaValidationError( $errorCode, $this->mwMsg( $errorCode ) );

	}

	protected function createError( $errorCode ) {
		$this->setError( $this->generateError($errorCode) );
	}

	protected function throwException($info) {
		throw new Exception($info);
	}

	protected function setOption($name, $value) {
		$this->options[$name] = $value;
	}

	protected function getOption( $name ) {
		return $this->options[$name];
	}

	protected function hasOption( $name ){
		return isset($this->options[$name]);
	}

	protected function mwMsg($errorCode) {
		$msg = wfMsg( $this->getMsg($errorCode) );

		$options = $this->options;
		$options['value'] = $this->value;

		foreach ($this->options as $key => $value) {
			if( is_string($value) || is_numeric($value) ) {
				$msg = str_replace( '$' + $key, $value, $msg );
			}
		}

		return $msg;
	}

	protected function setMsg( $errorCode, $msg ) {
		$this->msgs[$errorCode] = $msg;
	}

	protected function getMsg( $errorCode ) {
		return $this->msgs[$errorCode];
	}

	protected function setVal($value) {
		$this->value = $value;
	}

	protected function getVal($value) {
		return $this->value;
	}

	protected function hasMsg( $errorCode ) {
		return isset($this->msgs[$errorCode]);
	}

	protected function isWikiaValidator($validator) {
		return (is_object( $validator ) && is_a ( $validator , 'WikiaValidator' ));
	}


	public function arrayMergeHelper( $array1, $array2 ) {
		$plain = true;

		foreach ($array1 as $v)
		if (is_array($v)) {
			$plain = false;
			break;
		}
		foreach ($array2 as $v)
		if (is_array($v)) {
			$plain = false;
			break;
		}
		if ($plain) {
			return array_merge($array1,$array2);
		} else {
			$keys = array_intersect( array_keys($array1), array_keys($array2) );
			foreach ($keys as $key) {
				$array1[$key] = array_merge((array)$array1[$key],(array)$array2[$key]);
				unset($array2[$key]);
			}
			foreach ($array2 as $k => $v) {
				$array1[$k] = $v;
			}
			return $array1;
		}
	}

}
