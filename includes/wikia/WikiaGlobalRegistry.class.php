<?php

/**
 * Nirvana Framework - Global registry class
 *
 * @group nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 */
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

	public function __get($propertyName) {
		return $this->get( 'wg' . ucfirst($propertyName) );
	}

	public function __set($propertyName, $value) {
		$this->set( ( 'wg' . ucfirst($propertyName) ), $value );
	}

}
