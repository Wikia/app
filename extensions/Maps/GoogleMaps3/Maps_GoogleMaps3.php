<?php

/**
 * This groupe contains all Google Maps v3 related files of the Maps extension.
 * 
 * @defgroup MapsGoogleMaps3 Google Maps v3
 * @ingroup Maps
 */

/**
 * This file holds the general information for the Google Maps v3 service.
 *
 * @file Maps_GoogleMaps3.php
 * @ingroup MapsGoogleMaps3
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$egMapsServices['googlemaps3'] = array(
									'pf' => array(
										//'display_point' => array('class' => 'MapsGoogleMaps3DispPoint', 'file' => 'GoogleMaps3/Maps_GoogleMaps3DispPoint.php', 'local' => true),
										'display_map' => array('class' => 'MapsGoogleMaps3DispMap', 'file' => 'GoogleMaps3/Maps_GoogleMaps3DispMap.php', 'local' => true),
										),
									'classes' => array(
											array('class' => 'MapsGoogleMaps3', 'file' => 'GoogleMaps3/Maps_GoogleMaps3.php', 'local' => true)
											),
									'aliases' => array('google3', 'googlemap3', 'gmap3', 'gmaps3'),
									);	

/**
 * Class for Google Maps v3 initialization.
 * 
 * @ingroup MapsGoogleMaps3
 * 
 * @author Jeroen De Dauw
 */											
class MapsGoogleMaps3 {
	
	const SERVICE_NAME = 'googlemaps3';	
	
	public static function initialize() {
		self::initializeParams();
		Validator::addOutputFormat('gmap3type', array('MapsGoogleMaps3', 'setGMapType'));
		Validator::addOutputFormat('gmap3types', array('MapsGoogleMaps3', 'setGMapTypes'));		
	}
	
	private static function initializeParams() {
		global $egMapsServices, $egMapsGMaps3Type, $egMapsGMaps3Types;
		
		$allowedTypes = self::getTypeNames();
		
		$egMapsServices[self::SERVICE_NAME]['parameters'] = array(
				'type' => array(
					'aliases' => array('map-type', 'map type'),
					'criteria' => array(
						'in_array' => $allowedTypes		
						),
					'default' => $egMapsGMaps3Type, // FIXME: default value should not be used when not present in types parameter.
					'output-type' => 'gmap3type'										
					),
					/*
				'types' => array(
					'type' => array('string', 'list'),
					'aliases' => array('map-types', 'map types'),
					'criteria' => array(
						'in_array' => $allowedTypes
						),
					'default' => $egMapsGMaps3Types,
					'output-types' => array('gmap3types', 'list')				
					),	
					*/	
				);	
	}
	
	private static $mapTypes = array(
					'normal' => 'ROADMAP',
					'roadmap' => 'ROADMAP',	
					'satellite' => 'SATELLITE',
					'hybrid' => 'HYBRID',
					'terrain' => 'TERRAIN',
					'physical' => 'TERRAIN'
					);	
	
	/**
	 * Returns the names of all supported map types.
	 * 
	 * @return array
	 */					
	public static function getTypeNames() {
		return array_keys(self::$mapTypes);
	} 	
	
	/**
	 * Changes the map type name into the corresponding Google Maps API v3 identifier.
	 *
	 * @param string $type
	 * 
	 * @return string
	 */
	public static function setGMapType(&$type) {
		$type = 'google.maps.MapTypeId.' . self::$mapTypes[ $type ];
	}
	
	/**
	 * Changes the map type names into the corresponding Google Maps API v3 identifiers.
	 * 
	 * @param array $types
	 * 
	 * @return array
	 */
	public static function setGMapTypes(array &$types) {
		for($i = count($types) - 1; $i >= 0; $i--) {
			self::setGMapType($types[$i]);
		}
	}	
	
	/**
	 * Add references to the Google Maps API v3 and required JS file to the provided output 
	 *
	 * @param string $output
	 */
	public static function addGMap3Dependencies(&$output) {
		global $wgJsMimeType, $wgLang;
		global $egMapsScriptPath, $egGMaps3OnThisPage, $egMapsStyleVersion;

		if (empty($egGMaps3OnThisPage)) {
			$egGMaps3OnThisPage = 0;

			$output .= "<script type='$wgJsMimeType' src='http://maps.google.com/maps/api/js?sensor=false&amp;language={$wgLang->getCode()}'></script><script type='$wgJsMimeType' src='$egMapsScriptPath/GoogleMaps3/GoogleMap3Functions.js?$egMapsStyleVersion'></script>";
		}
	}
	
}
									