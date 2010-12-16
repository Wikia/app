<?php

/**
 * This groupe contains all Yahoo! Maps related files of the Maps extension.
 * 
 * @defgroup MapsYahooMaps Yahoo! Maps
 * @ingroup Maps
 */

/**
 * This file holds the general information for the Yahoo! Maps service
 *
 * @file Maps_YahooMaps.php
 * @ingroup MapsYahooMaps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$egMapsServices['yahoomaps'] = array(
									'pf' => array(
										'display_point' => array('class' => 'MapsYahooMapsDispPoint', 'file' => 'YahooMaps/Maps_YahooMapsDispPoint.php', 'local' => true),
										'display_map' => array('class' => 'MapsYahooMapsDispMap', 'file' => 'YahooMaps/Maps_YahooMapsDispMap.php', 'local' => true),
										),
									'classes' => array(
											array('class' => 'MapsYahooMaps', 'file' => 'YahooMaps/Maps_YahooMapsUtils.php', 'local' => true)											
											),
									'aliases' => array('yahoo', 'yahoomap', 'ymap', 'ymaps'),
									);
									
/**
 * Class for Yahoo! Maps initialization.
 * 
 * @ingroup MapsYahooMaps
 * 
 * @author Jeroen De Dauw
 */						
class MapsYahooMaps {
	
	const SERVICE_NAME = 'yahoomaps';	
	
	public static function initialize() {
		self::initializeParams();
		Validator::addOutputFormat('ymaptype', array(__CLASS__, 'setYMapType'));
		Validator::addOutputFormat('ymaptypes', array(__CLASS__, 'setYMapTypes'));		
	}
	
	private static function initializeParams() {
		global $egMapsServices, $egMapsYahooAutozoom, $egMapsYahooMapsType, $egMapsYahooMapsTypes, $egMapsYahooMapsZoom, $egMapsYMapControls;
		
		$allowedTypes = MapsYahooMaps::getTypeNames();
		
		$egMapsServices[self::SERVICE_NAME]['parameters']['zoom']['default'] = $egMapsYahooMapsZoom;
		$egMapsServices[self::SERVICE_NAME]['parameters']['zoom']['criteria']['in_range'] = array(1, 13);
		
		$egMapsServices[self::SERVICE_NAME]['parameters'] = array(
				'controls' => array(
					'type' => array('string', 'list'),
					'criteria' => array(
						'in_array' => self::getControlNames()
					),
					'default' => $egMapsYMapControls,
					'output-type' => array('list', ',', '\'')		
					),
				'type' => array (
					'aliases' => array('map-type', 'map type'),
					'criteria' => array(
						'in_array' => $allowedTypes			
						),
					'default' => $egMapsYahooMapsType, // FIXME: default value should not be used when not present in types parameter.
					'output-type' => 'ymaptype'
					),
				'types' => array (
					'type' => array('string', 'list'),
					'aliases' => array('map-types', 'map types'),
					'criteria' => array(
						'in_array' => $allowedTypes
						),
					'default' =>  $egMapsYahooMapsTypes,
					'output-types' => array('ymaptypes', 'list')									
					),
				'autozoom' => array(
					'type' => 'boolean',
					'aliases' => array('auto zoom', 'mouse zoom', 'mousezoom'),
					'default' => $egMapsYahooAutozoom,
					'output-type' => 'boolstr'										
					),		
				);
	}
	
	// http://developer.yahoo.com/maps/ajax
	private static $mapTypes = array(
					'normal' => 'YAHOO_MAP_REG',
					'satellite' => 'YAHOO_MAP_SAT',
					'hybrid' => 'YAHOO_MAP_HYB',
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
	 * Returns the names of all supported controls. 
	 * This data is a copy of the one used to actually translate the names
	 * into the controls, since this resides client side, in YahooMapFunctions.js. 
	 * 
	 * @return array
	 */
	public static function getControlNames() {
		return array('scale', 'type', 'pan', 'zoom', 'zoom-short', 'auto-zoom');
	}	
	
	/**
	 * Changes the map type name into the corresponding Yahoo! Maps API identifier.
	 *
	 * @param string $type
	 * 
	 * @return string
	 */
	public static function setYMapType(&$type) {
		$type = self::$mapTypes[ $type ];
	}	
	
	/**
	 * Changes the map type names into the corresponding Yahoo! Maps API identifiers.
	 * 
	 * @param array $types
	 * 
	 * @return array
	 */
	public static function setYMapTypes(array &$types) {
		for($i = count($types) - 1; $i >= 0; $i--) {
			$types[$i] = self::$mapTypes[ $types[$i] ];
		}
	}	

	/**
	 * Add references to the Yahoo! Maps API and required JS file to the provided output 
	 *
	 * @param string $output
	 */
	public static function addYMapDependencies(&$output) {
		global $wgJsMimeType;
		global $egYahooMapsKey, $egMapsScriptPath, $egYahooMapsOnThisPage, $egMapsStyleVersion;
		
		if (empty($egYahooMapsOnThisPage)) {
			$egYahooMapsOnThisPage = 0;
			$output .= "<script type='$wgJsMimeType' src='http://api.maps.yahoo.com/ajaxymap?v=3.8&amp;appid=$egYahooMapsKey'></script>
			<script type='$wgJsMimeType' src='$egMapsScriptPath/YahooMaps/YahooMapFunctions.min.js?$egMapsStyleVersion'></script>";
		}
	}	
	
}									