<?php

/**
 * A class that holds static helper functions for Yahoo! Maps
 *
 * @file Maps_YahooMapsUtils.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

final class MapsYahooMapsUtils {
	
	const SERVICE_NAME = 'yahoomaps';
	
	// http://developer.yahoo.com/maps/ajax
	private static $mapTypes = array(
					'normal' => 'YAHOO_MAP_REG',
					'YAHOO_MAP_REG' => 'YAHOO_MAP_REG',
	
					'satellite' => 'YAHOO_MAP_SAT',
					'YAHOO_MAP_SAT' => 'YAHOO_MAP_SAT',
	
					'hybrid' => 'YAHOO_MAP_HYB',
					'YAHOO_MAP_HYB' => 'YAHOO_MAP_HYB'
					);				
	
	/**
	 * Returns the Yahoo Map type (defined in MapsYahooMaps::$mapTypes) 
	 * for the provided a general map type. When no match is found, the first 
	 * Google Map type will be returned as default.
	 *
	 * @param string $type
	 * @param boolean $restoreAsDefault
	 * @return string or false
	 */
	public static function getYMapType($type, $restoreAsDefault = false) {
		global $egMapsYahooMapsType;
		
		$typeIsValid = array_key_exists($type, self::$mapTypes);
		
		if (!$typeIsValid && $restoreAsDefault) $type = $egMapsYahooMapsType;
		
		return $typeIsValid || $restoreAsDefault ? self::$mapTypes[ $type ] : false;	
	}
	
	/**
	 * Build up a csv string with the controls, to be outputted as a JS array
	 *
	 * @param array $controls
	 * @return csv string
	 */
	public static function createControlsString(array $controls) {
		global $egMapsYMapControls;
		return MapsMapper::createJSItemsString($controls, $egMapsYMapControls);
	}	

	/**
	 * Retuns an array holding the default parameters and their values.
	 *
	 * @return array
	 */
	public static function getDefaultParams() {
		global $egMapsYahooAutozoom;
		return array
			(
			'type' => '',
			'types' => '',				
			'autozoom' => $egMapsYahooAutozoom ? 'on' : 'off',
			); 		
	}	

	/**
	 * Add references to the Yahoo! Maps API and required JS file to the provided output 
	 *
	 * @param string $output
	 */
	public static function addYMapDependencies(&$output) {
		global $wgJsMimeType, $wgStyleVersion;
		global $egYahooMapsKey, $egMapsScriptPath, $egYahooMapsOnThisPage;
		
		if (empty($egYahooMapsOnThisPage)) {
			$egYahooMapsOnThisPage = 0;
			$output .= "<script type='$wgJsMimeType' src='http://api.maps.yahoo.com/ajaxymap?v=3.8&appid=$egYahooMapsKey'></script>
			<script type='$wgJsMimeType' src='$egMapsScriptPath/YahooMaps/YahooMapFunctions.js?$wgStyleVersion'></script>";
		}
	}

	/**
	 * Retuns a boolean as string, true if $autozoom is on or yes.
	 *
	 * @param string $autozoom
	 * @return string
	 */
	public static function getAutozoomJSValue($autozoom) {
		return MapsMapper::getJSBoolValue(in_array($autozoom, array('on', 'yes')));
	}	

	/**
	 * Returns a JS items string with the provided types. The earth type will
	 * be added to it when it's not present and $enableEarth is true. If there are
	 * no types, the default will be used.
	 *
	 * @param array $types
	 * @param boolean $enableEarth
	 * @return string
	 */
	public function createTypesString(array &$types) {	
		global $egMapsYahooMapsTypes, $egMapsYahooMapTypesValid;
		
		$types = MapsMapper::getValidTypes($types, $egMapsYahooMapsTypes, $egMapsYahooMapTypesValid, array(__CLASS__, 'getYMapType'));
			
		return MapsMapper::createJSItemsString($types, null, false, false);
	}	
	
}