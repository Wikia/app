<?php

/**
 * This file contains registration 
 * 
 * {{#geocode:<Address>|<param1>=<value1>|<param2>=<value2>}}
 * {{#geocodelat:<Address>|<param1>=<value1>|<param2>=<value2>}}
 * {{#geocodelng:<Address>|<param1>=<value1>|<param2>=<value2>}}
 *
 * @file Maps_GeocodeFunctions.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 * @author Sergey Chernyshev
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgHooks['LanguageGetMagic'][] = 'efMapsGeoFunctionMagic';
$wgHooks['ParserFirstCallInit'][] = 'efMapsRegisterGeoFunctions';

/**
 * Adds the magic words for the parser functions
 */
function efMapsGeoFunctionMagic( &$magicWords, $langCode ) {
	$magicWords['geocode'] = array( 0, 'geocode' );
	$magicWords['geocodelat']	= array ( 0, 'geocodelat' );
	$magicWords['geocodelng']	= array ( 0, 'geocodelng' );
	
	return true; // Unless we return true, other parser functions won't get loaded
}	

/**
 * Adds the parser function hooks
 */
function efMapsRegisterGeoFunctions(&$wgParser) {
	// Hooks to enable the geocoding parser functions
	$wgParser->setFunctionHook( 'geocode', array('MapsGeocodeFunctions', 'renderGeocoder') );
	$wgParser->setFunctionHook( 'geocodelat', array('MapsGeocodeFunctions', 'renderGeocoderLat') );
	$wgParser->setFunctionHook( 'geocodelng', array('MapsGeocodeFunctions', 'renderGeocoderLng') );
	
	return true;
}	

final class MapsGeocodeFunctions {

	private static function geocoderIsAvailable() {
		global $wgAutoloadClasses;
		return array_key_exists('MapsGeocoder', $wgAutoloadClasses);
	}
	
	/**
	 * Handler for the geocode parser function. Returns the latitude and longitude
	 * for the provided address, or an empty string, when the geocoding fails.
	 *
	 * @param unknown_type $parser
	 * @param string $address The address to geocode.
	 * @param string $service Optional. The geocoding service to use.
	 * @param string $mappingService Optional. The mapping service that will use the geocoded data.
	 * @return string
	 */
	public static function renderGeocoder($parser, $address, $service = '', $mappingService = '') {
		if (self::geocoderIsAvailable()) $geovalues = MapsGeocoder::geocode($address, $service, $mappingService);
		return $geovalues ? $geovalues['lat'].', '.$geovalues['lon'] : '';
	}

	/**
	 * Handler for the geocode parser function. Returns the latitude
	 * for the provided address, or an empty string, when the geocoding fails.
	 *
	 * @param unknown_type $parser
	 * @param string $address The address to geocode.
	 * @param string $service Optional. The geocoding service to use.
	 * @param string $mappingService Optional. The mapping service that will use the geocoded data.
	 * @return string
	 */	
	public static function renderGeocoderLat(&$parser, $address, $service = '', $mappingService = '') {
		if (self::geocoderIsAvailable()) $geovalues = MapsGeocoder::geocode($address, $service, $mappingService);
		return $geovalues ? $geovalues['lat'] : '';
	}
	
	/**
	 * Handler for the geocode parser function. Returns the longitude
	 * for the provided address, or an empty string, when the geocoding fails.
	 *
	 * @param unknown_type $parser
	 * @param string $address The address to geocode.
	 * @param string $service Optional. The geocoding service to use.
	 * @param string $mappingService Optional. The mapping service that will use the geocoded data.
	 * @return string
	 */	
	public static function renderGeocoderLng(&$parser, $address, $service = '', $mappingService = '') {
		if (self::geocoderIsAvailable()) $geovalues = MapsGeocoder::geocode($address, $service, $mappingService);
		return $geovalues ? $geovalues['lon'] : '';
	}
	
}



