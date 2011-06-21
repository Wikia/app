<?php


/**
 * Nirvana Framework - Local registry class
 *
 * @ingroup nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 */
class WikiaLocalRegistry extends WikiaRegistry {

	private $container = array();

	public function get( $propertyName ) {
		if ( $this->has( $propertyName ) ) {
			return $this->container[$propertyName];
		}

		return null;
	}

	public function set( $propertyName, $value ) {
		$this->validatePropertyName( $propertyName );
		$this->container[$propertyName] = $value;
		return $this;
	}

	public function remove( $propertyName ) {
		$this->validatePropertyName( $propertyName );
		unset($this->container[$propertyName]);
		return $this;
	}

	public function has( $propertyName ) {
		$this->validatePropertyName( $propertyName );
		return isset( $this->container[$propertyName] );
	}
}