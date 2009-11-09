<?php

/**
 * A class that holds static helper functions for OpenLayers
 *
 * @file Maps_OpenLayersUtils.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

final class MapsOpenLayersUtils {
	
	const SERVICE_NAME = 'openlayers';	
	
	private static $loadedBing = false; 
	private static $loadedYahoo = false;
	private static $loadedOL = false;
	private static $loadedOSM = false; 
	
	/**
	 * Load the dependencies of a layer if they are not loaded yet
	 *
	 * @param string $output The output to which the html to load the dependencies needs to be added
	 * @param string $layer The layer to check (and load the dependencies for
	 */
	public static function loadDependencyWhenNeeded(&$output, $layer) {
		global $wgJsMimeType, $wgStyleVersion;
		global $egGoogleMapsOnThisPage, $egMapsScriptPath;
		
		switch ($layer) {
			case 'google' : case 'google-normal' : case 'google-sattelite' : case 'google-hybrid' : case 'google-physical' :
				if (empty($egGoogleMapsOnThisPage)) {
					$egGoogleMapsOnThisPage = 0;
					MapsGoogleMapsUtils::addGMapDependencies($output);
					}
				break;
			case 'bing' : case 'virtual-earth' :
				if (!self::$loadedBing) { $output .= "<script type='$wgJsMimeType' src='http://dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=6.1'></script>\n"; self::$loadedBing = true; }
				break;
			case 'yahoo' : case 'yahoo-maps' :
				if (!self::$loadedYahoo) { $output .= "<style type='text/css'> #controls {width: 512px;}</style><script src='http://api.maps.yahoo.com/ajaxymap?v=3.0&appid=euzuro-openlayers'></script>\n"; self::$loadedYahoo = true; }
				break;
			case 'openlayers' : case 'open-layers' :
				if (!self::$loadedOL) { $output .= "<script type='$wgJsMimeType' src='http://clients.multimap.com/API/maps/1.1/metacarta_04'></script>\n"; self::$loadedOL = true; }
				break;
			case 'osm' : case 'openstreetmap' :
				if (!self::$loadedOSM) { $output .= "<script type='$wgJsMimeType' src='$egMapsScriptPath/OpenLayers/OSM/OpenStreetMap.js?$wgStyleVersion'></script>\n"; self::$loadedOSM = true; }
				break;													
		}		
	}
	
	/**
	 * Retuns an array holding the default parameters and their values.
	 *
	 * @return array
	 */
	public static function getDefaultParams() {
		return array
			(
			'layers' => array(),
			'baselayer' => ''
			); 		
	}		
	
	/**
	 * If this is the first open layers map on the page, load the API, styles and extra JS functions
	 * 
	 * @param string $output
	 */
	public static function addOLDependencies(&$output) {
		global $wgJsMimeType;
		global $egOpenLayersOnThisPage, $egMapsScriptPath;
		
		if (empty($egOpenLayersOnThisPage)) {
			$egOpenLayersOnThisPage = 0;
			
			$output .="<link rel='stylesheet' href='$egMapsScriptPath/OpenLayers/OpenLayers/theme/default/style.css' type='text/css' />
			<script type='$wgJsMimeType' src='$egMapsScriptPath/OpenLayers/OpenLayers/OpenLayers.js'></script>		
			<script type='$wgJsMimeType' src='$egMapsScriptPath/OpenLayers/OpenLayerFunctions.js'></script>
			<script type='$wgJsMimeType'>initOLSettings(200, 100);</script>\n";
		}		
	}
		
	/**
	 * Build up a csv string with the layers, to be outputted as a JS array
	 *
	 * @param string $output
	 * @param array $layers
	 * @return csv string
	 */
	public static function createLayersStringAndLoadDependencies(&$output, array $layers) {
		global $egMapsOLLayers;
		
		if (count($layers) < 1) $layers = $egMapsOLLayers;
		
		$layerItems = '';
		foreach ($layers as $layer) {
			$layer = strtolower($layer);
			$layerItems .= "'$layer'" . ',';
			self::loadDependencyWhenNeeded($output, $layer);
		}
		
		return rtrim($layerItems, ',');		
	}
	
	/**
	 * Build up a csv string with the controls, to be outputted as a JS array
	 *
	 * @param array $controls
	 * @return csv string
	 */
	public static function createControlsString(array $controls) {
		global $egMapsOLControls;
		return MapsMapper::createJSItemsString($controls, $egMapsOLControls);
	}			
	
}

?>