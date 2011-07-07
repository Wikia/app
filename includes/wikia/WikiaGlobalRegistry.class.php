
<?php

/**
 * Nirvana Framework - Global registry class
 *
 * @ingroup nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaGlobalRegistry extends WikiaRegistry {
	private function preparePropertyName( $propertyName ) {
		return 'wg' . ucfirst( $propertyName );
	}
	
	public function get($propertyName) {
		if ( $this->has($propertyName ) ) {
			return $GLOBALS[$this->preparePropertyName( $propertyName )];
		}

		return null;
	}

	public function append($propertyName, $value, $key = null) {
		$propertyName = $this->preparePropertyName( $propertyName );
		$this->validatePropertyName($propertyName);
		
		if ( is_null( $key ) ) {
			$GLOBALS[$propertyName][] = $value;
		}
		else {
			$GLOBALS[$propertyName][$key][] = $value;
		}

		return $this;
	}

	public function set($propertyName, $value, $key = null) {
		$propertyName = $this->preparePropertyName( $propertyName );
		$this->validatePropertyName( $propertyName );
		
		if (is_null($key)) {
			$GLOBALS[$propertyName] = $value;
		} else {
			$GLOBALS[$propertyName][$key] = $value;
		}
		return $this;
	}

	public function remove($propertyName) {
		$propertyName = $this->preparePropertyName( $propertyName );
		$this->validatePropertyName( $propertyName );
		unset( $GLOBALS[$propertyName] );
		return $this;
	}

	public function has($propertyName) {
		$propertyName = $this->preparePropertyName( $propertyName );
		$this->validatePropertyName( $propertyName );
		
		return isset( $GLOBALS[$propertyName] );
	}

	public function __get($propertyName) {
		return $this->get( $propertyName );
	}

	public function __set($propertyName, $value) {
		$this->set( $propertyName, $value );
	}
	
	public function __isset($propertyName){
		return $this->has($propertyName);
	}
	
	public function __unset( $propertyName ) {
		$this->remove( $propertyName  );
	}
}
