<?php

class WikiaGlobalRegistry extends WikiaRegistry {

	public function get($propertyName) {
		if($this->has($propertyName)) {
			return $GLOBALS[$propertyName];
		}

		return null;
	}

	public function append($propertyName, $value, $key = null) {
		$this->validatePropertyName($propertyName);
		if(is_null($key)) {
			$GLOBALS[$propertyName][] = $value;
		}
		else {
			$GLOBALS[$propertyName][$key][] = $value;
		}
		
		return $this;
	}

	public function set($propertyName, $value, $key = null) {
		$this->validatePropertyName($propertyName);
		if (is_null($key)) {
			$GLOBALS[$propertyName] = $value;
		} else {
			$GLOBALS[$propertyName][$key] = $value;
		}
		return $this;
	}

	public function remove($propertyName) {
		$this->validatePropertyName($propertyName);
		unset($GLOBALS[$propertyName]);
		return $this;
	}

	public function has($propertyName) {
		$this->validatePropertyName($propertyName);
		return isset($GLOBALS[$propertyName]);
	}

}
