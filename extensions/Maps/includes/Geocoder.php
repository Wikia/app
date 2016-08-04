<?php

namespace Maps;

/**
 * Base geocoder class to be inherited by classes with a specific geocding implementation. 
 * 
 * @since 0.7
 * 
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class Geocoder {

	/**
	 * The internal name of the geocoder.
	 * 
	 * @since 0.7
	 * 
	 * @var string
	 */
	protected static $name;
	
	/**
	 * A list of aliases for the internal name.
	 * 
	 * @since 0.7
	 * 
	 * @var array
	 */
	protected $aliases;	
	
	/**
	 * Returns the url to which to make the geocoding request.
	 * 
	 * @since 0.7
	 * 
	 * @param string $address
	 * 
	 * @return string
	 */
	protected abstract function getRequestUrl( $address );
	
	/**
	 * Parses the response and returns it as an array with lat and lon keys.
	 * 
	 * @since 0.7
	 * 
	 * @param string $response
	 * 
	 * @return array
	 */	
	protected abstract function parseResponse( $response );
	
	/**
	 * Constructor.
	 * 
	 * @since 0.7
	 * 
	 * @param string $identifier
	 */
	public function __construct( $identifier ) {
		self::$name = $identifier;
	}
	
	/**
	 * Returns the geocoders identifier.
	 * 
	 * @since 0.7
	 * 
	 * @return string
	 */	
	public static function getName() {
		return self::$name;
	}
	
	/**
	 * Returns the geocoders aliases.
	 * 
	 * @since 0.7
	 * 
	 * @return array
	 */
	public function getAliases() {
		return $this->aliases;
	}
	
	/**
	 * Returns if the geocoder has a certain alias.
	 * 
	 * @since 0.7
	 *
	 * @param string $alias
	 *
	 * @return boolean
	 */
	public function hasAlias( $alias ) {
		return in_array( $alias, $this->aliases );
	}	
	
	/**
	 * Returns an array containing the geocoded latitude (lat) and
	 * longitude (lon) of the provided address, or false in case the
	 * geocoding fails.
	 *
	 * @since 0.2
	 *
	 * @param $address String: the address to be geocoded
	 * 
	 * @return array or false
	 */
	public function geocode( $address ) {
		$response = \Http::get( $this->getRequestUrl( $address ) );
		
		if ( $response === false ) {
			return false;
		}
		else {
			return $this->parseResponse( $response );
		}
	}
	
	/**
	 * Gets the contents of the first XML tag with the provided name,
	 * returns false when no matching element is found.
	 *
	 * @param string $xml
	 * @param string $tagName
	 * 
	 * @return string or false
	 */
	protected static function getXmlElementValue( $xml, $tagName ) {
		$match = array();
		preg_match( "/<$tagName>(.*?)<\/$tagName>/", $xml, $match );
		return count( $match ) > 1 ? $match[1] : false;
	}
	
	/**
	 * Returns the mapping service overrides for this geocoder, allowing it to be used
	 * instead of the default geocoder when none is provided for certain mapping services.
	 * 
	 * Returns an empty array by default. Override to add overrides.
	 * 
	 * @since 0.7
	 * 
	 * @return array
	 */
	public static function getOverrides() {
		return array();
	}
	
	/**
	 * Returns if the global geocoder cache should be used or not.
	 * By default it should be, but overriding this function allows
	 * for making a geocoder ignore it and implement it's own solution.
	 * 
	 * @since 0.7
	 * 
	 * @return boolean
	 */
	public function hasGlobalCacheSupport() {
		return true;
	}
	
}
