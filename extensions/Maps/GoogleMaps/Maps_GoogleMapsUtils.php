<?php

/**
 * A class that holds static helper functions for Google Maps
 *
 * @file Maps_GooleMapsUtils.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}
 
final class MapsGoogleMapsUtils {
	
	const SERVICE_NAME = 'googlemaps';
	
	// http://code.google.com/apis/maps/documentation/reference.html#GMapType.G_NORMAL_MAP
	// TODO: Add a true alliasing system? Might be overkill.
	private static $mapTypes = array(
					'normal' => 'G_NORMAL_MAP',
					'G_NORMAL_MAP' => 'G_NORMAL_MAP',
	
					'satellite' => 'G_SATELLITE_MAP',
					'G_SATELLITE_MAP' => 'G_SATELLITE_MAP',
	
					'hybrid' => 'G_HYBRID_MAP',
					'G_HYBRID_MAP' => 'G_HYBRID_MAP',
	
					'physical' => 'G_PHYSICAL_MAP',
					'G_PHYSICAL_MAP' => 'G_PHYSICAL_MAP',
	
					'earth' => 'G_SATELLITE_3D_MAP',
					'G_SATELLITE_3D_MAP' => 'G_SATELLITE_3D_MAP',
	
					'sky' => 'G_SKY_VISIBLE_MAP',
					'G_SKY_VISIBLE_MAP' => 'G_SKY_VISIBLE_MAP',	
	
					'moon' => 'G_MOON_VISIBLE_MAP',
					'G_MOON_VISIBLE_MAP' => 'G_MOON_VISIBLE_MAP',

					'moon-elevation' => 'G_MOON_ELEVATION_MAP',
					'G_MOON_ELEVATION_MAP' => 'G_MOON_ELEVATION_MAP',
	
					'mars' => 'G_MARS_VISIBLE_MAP',
					'G_MARS_VISIBLE_MAP' => 'G_MARS_VISIBLE_MAP',

					'mars-elevation' => 'G_MARS_ELEVATION_MAP',
					'G_MARS_ELEVATION_MAP' => 'G_MARS_ELEVATION_MAP',
	
					'mars-infrared' => 'G_MARS_INFRARED_MAP',
					'G_MARS_INFRARED_MAP' => 'G_MARS_INFRARED_MAP',	
					);

	/**
	 * Returns the Google Map type (defined in MapsGoogleMaps::$mapTypes) 
	 * for the provided a general map type. When no match is found, false
	 * will be returned.
	 *
	 * @param string $type
	 * @param boolean $restoreAsDefault
	 * @return string or false
	 */
	public static function getGMapType($type, $restoreAsDefault = false) {
		global $egMapsGoogleMapsType;
		$typeIsValid = array_key_exists($type, self::$mapTypes);
		
		if ($typeIsValid) {
			return self::$mapTypes[ $type ];
		}
		else {
			if ($restoreAsDefault) {
				return self::$mapTypes[ $egMapsGoogleMapsType ]; 
			}
			else {
				return false;
			}
		}
	}
	
	/**
	 * Build up a csv string with the controls, to be outputted as a JS array
	 *
	 * @param array $controls
	 * @return csv string
	 */
	public static function createControlsString(array $controls) {
		global $egMapsGMapControls;
		return MapsMapper::createJSItemsString($controls, $egMapsGMapControls);
	}		
	
	/**
	 * Retuns an array holding the default parameters and their values.
	 *
	 * @return array
	 */
	public static function getDefaultParams() {
		global $egMapsGoogleAutozoom;
		return array
			(
			'type' => '',
			'types' => '',			
			'class' => 'pmap',
			'autozoom' => $egMapsGoogleAutozoom ? 'on' : 'off',
			'earth' => '',
			'style' => ''			
			); 		
	}
	
	/**
	 * Add references to the Google Maps API and required JS file to the provided output 
	 *
	 * @param string $output
	 */
	public static function addGMapDependencies(&$output) {
		global $wgJsMimeType, $wgLang, $wgStyleVersion;
		global $egGoogleMapsKey, $egMapsScriptPath, $egGoogleMapsOnThisPage;
		
		if (empty($egGoogleMapsOnThisPage)) {
			$egGoogleMapsOnThisPage = 0;

			MapsGoogleMapsUtils::validateGoogleMapsKey();
			
			// TODO: use strbuilder for performance gain?
			$output .= "<script src='http://maps.google.com/maps?file=api&v=2&key=$egGoogleMapsKey&hl={$wgLang->getCode()}' type='$wgJsMimeType'></script>
			<script type='$wgJsMimeType' src='$egMapsScriptPath/GoogleMaps/GoogleMapFunctions.js?$wgStyleVersion'></script>";
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
	 * Returns a boolean representing if the earth map type should be showed or not,
	 * when provided the the wiki code value.
	 *
	 * @param string $earthValue
	 * @param boolean $adaptDefault When not set to false, the default map type will be changed to earth when earth is enabled
	 * @return boolean Indicates wether the earth type should be enabled.
	 */
	public static function getEarthValue($earthValue, $adaptDefault = true) {
		$trueValues = array('on', 'yes');
		$enabled = in_array($earthValue, $trueValues);
		
		if ($enabled && $adaptDefault) {
			global $egMapsGoogleMapsType;
			$egMapsGoogleMapsType = 'G_SATELLITE_3D_MAP';
		}
		
		return $enabled;		
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
	public static function createTypesString(array &$types, $enableEarth = false) {	
		global $egMapsGoogleMapsTypes, $egMapsGoogleMapTypesValid;
		
		$types = MapsMapper::getValidTypes($types, $egMapsGoogleMapsTypes, $egMapsGoogleMapTypesValid, array(__CLASS__, 'getGMapType'));
		
		// This is to ensure backwards compatibility with 0.1 and 0.2.
		if ($enableEarth && ! in_array('G_SATELLITE_3D_MAP', $types)) $types[] = 'G_SATELLITE_3D_MAP';	
			
		return MapsMapper::createJSItemsString($types, null, false, false);
	}
	
	/**
	 * This function ensures backward compatibility with Semantic Google Maps and other extensions
	 * using $wgGoogleMapsKey instead of $egGoogleMapsKey.
	 */
	public static function validateGoogleMapsKey() {
		global $egGoogleMapsKey, $wgGoogleMapsKey;
		
		if (isset($wgGoogleMapsKey)){
			if (strlen(trim($egGoogleMapsKey)) < 1) $egGoogleMapsKey = $wgGoogleMapsKey;
		} 
	}	
	
}