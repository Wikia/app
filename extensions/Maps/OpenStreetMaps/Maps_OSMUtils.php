<?php

/**
 * A class that holds static helper functions for OSM.
 *
 * @file Maps_OSMUtils.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

final class MapsOSMUtils {
	
	const SERVICE_NAME = 'osm';	
	
	private static $layers = array(
		'osm-wm' => array(
			// First layer = default
			'layers' => array( 'osm-like' ),
	
			// Default "zoom=" argument
			'defaultZoomLevel' => 14,
	
			'static_rendering' => array(
				'type' => 'SlippyMapExportCgiBin',
				'options' => array(
					'base_url' => 'http://cassini.toolserver.org/cgi-bin/export',
	
					'format' => 'png',
					'numZoomLevels' => 19,
					'maxResolution' => 156543.0339,
					'unit' => 'm',
					'sphericalMercator' => true,
	
					// More GET arguments
					'get_args' => array(
						// Will use $wgContLang->getCode()
						'locale' => true,
						'maptype' => 'osm-like'
					),
				),
			),
		),
		'osm' => array(
			// First layer = default
			'layers' => array( 'mapnik', 'osmarender', 'maplint', 'cycle' ),
	
			// Default "zoom=" argument
			'defaultZoomLevel' => 14,
	
			'static_rendering' => array(
				'type' => 'SlippyMapExportCgiBin',
				'options' => array(
					'base_url' => 'http://tile.openstreetmap.org/cgi-bin/export',
	
					'format' => 'png',
					'numZoomLevels' => 19,
					'maxResolution' => 156543.0339,
					'unit' => 'm',
					'sphericalMercator' => true
				),
			),
		),
		'satellite' => array(
			'layers' => array( 'urban', 'landsat', 'bluemarble' ),
			'defaultZoomLevel' => 14,
			'static_rendering' => null,
		),
	);
	
	/**
	 * Retuns an array holding the default parameters and their values.
	 *
	 * @return array
	 */
	public static function getDefaultParams() {
		return array
			(
			); 		
	}		
	
	/**
	 * If this is the first OSM map on the page, load the OpenLayers API, OSM styles and extra JS functions
	 * 
	 * @param string $output
	 */
	public static function addOSMDependencies(&$output) {
		global $wgJsMimeType, $wgStyleVersion;
		global $egOSMMapsOnThisPage, $egMapsScriptPath;
		
		if (empty($egOSMMapsOnThisPage)) {
			$egOSMMapsOnThisPage = 0;
			
			$output .="<link rel='stylesheet' href='$egMapsScriptPath/OpenLayers/OpenLayers/theme/default/style.css' type='text/css' />
			<script type='$wgJsMimeType' src='$egMapsScriptPath/OpenLayers/OpenLayers/OpenLayers.js'></script>		
			<script type='$wgJsMimeType' src='$egMapsScriptPath/OpenStreetMaps/OSMFunctions.js?$wgStyleVersion'></script>
			<script type='$wgJsMimeType'>slippymaps = Array();</script>\n";
		}		
	}	

	/**
	 * Build up a csv string with the controls, to be outputted as a JS array
	 *
	 * @param array $controls
	 * @return csv string
	 */
	public static function createControlsString(array $controls) {
		global $egMapsOSMControls;
		return MapsMapper::createJSItemsString($controls, $egMapsOSMControls);
	}		
	
}

?>