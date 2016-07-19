<?php

/**
 * Class for geocoder functionality of the Maps extension. 
 * 
 * @since 0.4
 * 
 * @file Maps_Geocoders.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class MapsGeocoders {
	
	/**
	 * Associative with geoservice identifiers as keys containing instances of
	 * the geocoder classes. 
	 * 
	 * Note: This list only contains the instances, so is not to be used for
	 * looping over all available services, as not all of them are guaranteed 
	 * to have an instance already, use $registeredServices for this purpouse.
	 * 
	 * @since 0.7
	 * 
	 * @var array of string => MapsGeocoder
	 */
	protected static $geocoders = array();	
	
	/**
	 * Associative with geoservice identifiers as keys containing the class
	 * name of the geocoders. This is used for registration of a geocoder
	 * without immediately instantiating it.
	 * 
	 * @since 0.7
	 * 
	 * @var array of string => string
	 */
	public static $registeredGeocoders = array();
	
	/**
	 * The global geocoder cache, holding geocoded data when enabled.
	 *
	 * @since 0.7
	 *
	 * @var array
	 */
	private static $globalGeocoderCache = array();	
	
	/**
	 * Can geocoding happen, ie are there any geocoders available.
	 * 
	 * @since 1.0.3
	 * @var boolean
	 */
	protected static $canGeocode = false;
	
	/**
	 * Returns if this class can do geocoding operations.
	 * Ie. if there are any geocoders available.
	 * 
	 * @since 0.7
	 * 
	 * @return boolean
	 */
	public static function canGeocode() {
		self::init();
		return self::$canGeocode;
	}
	
	/**
	 * Gets a list of available geocoders.
	 * 
	 * @since 1.0.3
	 * 
	 * @return array
	 */
	public static function getAvailableGeocoders() {
		self::init();
		return array_keys( self::$registeredGeocoders );
	}
	
	/**
	 * Initiate the geocoding functionality.
	 * 
	 * @since 1.0.3
	 * 
	 * @return boolean Indicates if init happened
	 */
	public static function init() {
		static $initiated = false;
		
		if ( $initiated ) {
			return false;
		}
		
		$initiated = true;
		
		// Register the geocoders.
		wfRunHooks( 'GeocoderFirstCallInit' );
		
		// Determine if there are any geocoders.
		self::$canGeocode = count( self::$registeredGeocoders ) > 0;
		
		return true;
	}
	
	/**
	 * This function first determines wether the provided string is a pair or coordinates
	 * or an address. If it's the later, an attempt to geocode will be made. The function will
	 * return the coordinates or false, in case a geocoding attempt was made but failed. 
	 * 
	 * @since 0.7
	 * 
	 * @param string $coordsOrAddress
	 * @param string $geoservice
	 * @param string|false $mappingService
	 * @param boolean $checkForCoords
	 *
	 * @return array or false
	 */
	public static function attemptToGeocode( $coordsOrAddress, $geoservice = '', $mappingService = false, $checkForCoords = true ) {
		if ( $checkForCoords ) {
			if ( MapsCoordinateParser::areCoordinates( $coordsOrAddress ) ) {
				return MapsCoordinateParser::parseCoordinates( $coordsOrAddress );
			} else {
				return self::geocode( $coordsOrAddress, $geoservice, $mappingService );
			}
		} else {
			return self::geocode( $coordsOrAddress, $geoservice, $mappingService );
		}
	}
	
	/**
	 * 
	 * 
	 * @since 0.7
	 * 
	 * @param string $coordsOrAddress
	 * @param string $geoService
	 * @param string|false $mappingService
	 * 
	 * @return boolean
	 */
	public static function isLocation( $coordsOrAddress, $geoService = '', $mappingService = false ) {
		return self::attemptToGeocode( $coordsOrAddress, $geoService, $mappingService ) !== false;
	}
	
	/**
	 * Geocodes an address with the provided geocoding service and returns the result 
	 * as a string with the optionally provided format, or false when the geocoding failed.
	 * 
	 * @since 0.7
	 * 
	 * @param string $coordsOrAddress
	 * @param string $service
	 * @param string $mappingService
	 * @param boolean $checkForCoords
	 * @param coordinate type $targetFormat The notation to which they should be formatted. Defaults to floats.
	 * @param boolean $directional Indicates if the target notation should be directional. Defaults to false.
	 * 
	 * @return formatted coordinates string or false
	 */
	public static function attemptToGeocodeToString( $coordsOrAddress, $service = '', $mappingService = false, $checkForCoords = true, $targetFormat = Maps_COORDS_FLOAT, $directional = false ) {
		$geoValues = self::attemptToGeocode( $coordsOrAddress, $service, $mappingService, $checkForCoords );
		return $geoValues ?  MapsCoordinateParser::formatCoordinates( $geoValues, $targetFormat, $directional ) : false;
	}

	/**
	 * Geocodes an address with the provided geocoding service and returns the result 
	 * as an array, or false when the geocoding failed.
	 *
	 * @since 0.7
	 *
	 * @param string $address
	 * @param string $geoService
	 * @param string $mappingService
	 * 
	 * @return array with coordinates or false
	 */
	public static function geocode( $address, $geoService = '', $mappingService = false ) {
		if ( !is_string( $address ) ) {
			throw new MWException( 'Parameter $address must be a string at ' . __METHOD__ );
		}		
		
		if ( !self::canGeocode() ) {
			return false;
		}
		
		$geocoder = self::getValidGeocoderInstance( $geoService, $mappingService );

		// This means there was no suitable geocoder found, so return false.
		if ( $geocoder === false ) {
			return false;
		}
		
		if ( $geocoder->hasGlobalCacheSupport() ) {
			$cacheResult = self::cacheRead( $address );
	
			// This means the cache returned an already computed set of coordinates.
			if ( $cacheResult !== false ) {
				return $cacheResult;
			}				
		}
		
		// Do the actual geocoding via the geocoder.
		$coordinates = $geocoder->geocode( $address );
		
		// If there address could not be geocoded, and contains comma's, try again without the comma's.
		// This is cause several geocoding services such as geonames do not handle comma's well.
		if ( !$coordinates && strpos( $address, ',' ) !== false ) {
			$coordinates = $geocoder->geocode( str_replace( ',', '', $address ) );
		}
		
		if ( $coordinates !== false ) {
			self::cacheWrite( $address, $coordinates );
		}
		
		return $coordinates;
	}
	
	/**
	 * Returns already coordinates already known from previous geocoding operations,
	 * or false if there is no match found in the cache.
	 * 
	 * @since 0.7
	 * 
	 * @param string $address
	 * 
	 * @return array or false
	 */
	protected static function cacheRead( $address ) {
		global $egMapsEnableGeoCache;
		
		if ( $egMapsEnableGeoCache && array_key_exists( $address, self::$globalGeocoderCache ) ) {
			return self::$globalGeocoderCache[$address];
		}
		else {
			return false;
		}
	}
	
	/**
	 * Writes the geocoded result to the cache if the cache is on.
	 * 
	 * @since 0.7
	 * 
	 * @param string $address
	 * @param array $coordinates
	 */
	protected static function cacheWrite( $address, array $coordinates ) {
		global $egMapsEnableGeoCache;
		
		// Add the obtained coordinates to the cache when there is a result and the cache is enabled.
		if ( $egMapsEnableGeoCache && $coordinates ) {
			self::$globalGeocoderCache[$address] = $coordinates;
		}
	}
	
	/**
	 * Does the same as Geocode, but also formats the result into a string.
	 * 
	 * @since 0.7
	 * 
	 * @param string $coordsOrAddress
	 * @param string $service
	 * @param string $mappingService
	 * @param coordinate type $targetFormat The notation to which they should be formatted. Defaults to floats.
	 * @param boolean $directional Indicates if the target notation should be directional. Defaults to false.
	 * 
	 * @return formatted coordinates string or false
	 */
	public static function geocodeToString( $address, $service = '', $mappingService = false, $targetFormat = Maps_COORDS_FLOAT, $directional = false  ) {
		$coordinates = self::geocode( $address, $service, $mappingService );
		return $coordinates ?  MapsCoordinateParser::formatCoordinates( $coordinates, $targetFormat, $directional ) : false;
	}
	
	/**
	 * Registers a geocoder linked to an identifier.
	 * 
	 * @since 0.7
	 * 
	 * @param string $geocoderIdentifier
	 * @param string $geocoderClassName
	 */
	public static function registerGeocoder( $geocoderIdentifier, $geocoderClassName ) {
		self::$registeredGeocoders[$geocoderIdentifier] = $geocoderClassName;
	}
	
	/**
	 * Returns the instance of the geocoder linked to the provided identifier
	 * or the default one when it's not valid. False is returned when there
	 * are no geocoders available.
	 * 
	 * @since 0.7
	 * 
	 * @param string $geocoderIdentifier
	 * 
	 * @return MapsGeocoder or false
	 */
	protected static function getValidGeocoderInstance( $geocoderIdentifier ) {
		return self::getGeocoderInstance( self::getValidGeocoderIdentifier( $geocoderIdentifier ) );
	}
	
	/**
	 * Returns the instance of a geocoder. This function assumes there is a
	 * geocoder linked to the identifier you provide - if you are not sure
	 * it does, use getValidGeocoderInstance instead.
	 * 
	 * @since 0.7
	 * 
	 * @param string $geocoderIdentifier
	 * 
	 * @return MapsGeocoder or false
	 */
	protected static function getGeocoderInstance( $geocoderIdentifier ) {
		if ( !array_key_exists( $geocoderIdentifier, self::$geocoders ) ) {
			if ( array_key_exists( $geocoderIdentifier, self::$registeredGeocoders ) ) {
				$className = self::$registeredGeocoders[$geocoderIdentifier];
				$geocoder = new $className( $geocoderIdentifier );

				//if ( $service instanceof iMappingService ) {
					self::$geocoders[$geocoderIdentifier] = $geocoder;
				//}
				//else {
				//	throw new MWException( 'The geocoder linked to identifier ' . $geocoderIdentifier . ' does not implement .' );
				//}
			}
			else {
				throw new MWException( 'There is geocoder linked to identifier ' . $geocoderIdentifier . '.' );
			}
		}

		return self::$geocoders[$geocoderIdentifier];
	}
	
	/**
	 * Returns a valid geocoder idenifier. If the given one is a valid main identifier,
	 * it will simply be returned. If it's an alias, it will be turned into the correponding
	 * main identifier. If it's not recognized at all (or empty), the default will be used.
	 * Only call this function when there are geocoders available, else an erro will be thrown.
	 * 
	 * @since 0.7
	 *
	 * @param string $geocoderIdentifier
	 * 
	 * @return string or false
	 */
	protected static function getValidGeocoderIdentifier( $geocoderIdentifier ) {
		global $egMapsDefaultGeoService;
		static $validatedDefault = false;
		
		if ( $geocoderIdentifier === '' || !array_key_exists( $geocoderIdentifier, self::$registeredGeocoders ) ) {
			if ( !$validatedDefault ) {
				if ( !array_key_exists( $egMapsDefaultGeoService, self::$registeredGeocoders ) ) {
					$services = array_keys( self::$registeredGeocoders );
					$egMapsDefaultGeoService = array_shift( $services );
					if ( is_null( $egMapsDefaultGeoService ) ) {
						throw new MWException( 'Tried to geocode while there are no geocoders available at ' . __METHOD__  );
					}
				}
			}
			
			if ( array_key_exists( $egMapsDefaultGeoService, self::$registeredGeocoders ) ) {
				$geocoderIdentifier = $egMapsDefaultGeoService;
			}
			else {
				return false;
			}
		}
		
		return $geocoderIdentifier;
	}
	
}