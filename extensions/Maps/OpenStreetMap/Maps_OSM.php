<?php

/**
 * This groupe contains all OpenStreetMap related files of the Maps extension.
 * 
 * @defgroup MapsOpenStreetMap OpenStreetMap
 * @ingroup Maps
 */

/**
 * This file holds the general information for the OSM optimized OpenLayers service
 *
 * @file Maps_OSM.php
 * @ingroup MapsOpenStreetMap
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$egMapsServices['osm'] = array(
									'pf' => array(
										'display_point' => array('class' => 'MapsOSMDispPoint', 'file' => 'OpenStreetMap/Maps_OSMDispPoint.php', 'local' => true),
										'display_map' => array('class' => 'MapsOSMDispMap', 'file' => 'OpenStreetMap/Maps_OSMDispMap.php', 'local' => true),
										),
									'classes' => array(
											array('class' => 'MapsOSM', 'file' => 'OpenStreetMap/Maps_OSM.php', 'local' => true),
											array('class' => 'MapsOSMCgiBin', 'file' => 'OpenStreetMap/Maps_OSMCgiBin.php', 'local' => true),
											),
									'aliases' => array('openstreetmap', 'openstreetmaps'),
									);
									
/**
 * Class for OpenStreetMap initialization.
 * 
 * @ingroup MapsOpenStreetMap
 * 
 * @author Jeroen De Dauw
 */						
class MapsOSM {
	
	const SERVICE_NAME = 'osm';		
	
	public static function initialize() {
		self::initializeParams();
	}
	
	private static function initializeParams() {
		global $wgLang;
		global $egMapsServices, $egMapsOSMZoom, $egMapsOSMControls;
		
		$egMapsServices[self::SERVICE_NAME]['parameters']['zoom']['default'] = $egMapsOSMZoom;
		$egMapsServices[self::SERVICE_NAME]['parameters']['zoom']['criteria']['in_range'] = array(0, 19);
		
		$egMapsServices[self::SERVICE_NAME]['parameters'] = array(
			'controls' => array(
				'type' => array('string', 'list'),
				'criteria' => array(
					'in_array' => self::getControlNames()
					),
				'default' => $egMapsOSMControls,
				'output-type' => array('list', ',', '\'')	
				),	
			'lang' => array(
				'aliases' => array('locale', 'language'),	
				'criteria' => array(
					'in_array' => array_keys( Language::getLanguageNames( false ) )
					),
				'default' => $wgLang->getCode()
				),												
			);
	}
	
	/**
	 * Returns the names of all supported controls. 
	 * This data is a copy of the one used to actually translate the names
	 * into the controls, since this resides client side, in OSMFunctions.js. 
	 * 
	 * @return array
	 */		
	public static function getControlNames() {
		return array(
					  'ArgParser', 'Attribution', 'Button', 'DragFeature', 'DragPan', 
	                  'DrawFeature', 'EditingToolbar', 'GetFeature', 'KeyboardDefaults', 'LayerSwitcher',
	                  'Measure', 'ModifyFeature', 'MouseDefaults', 'MousePosition', 'MouseToolbar',
	                  'Navigation', 'NavigationHistory', 'NavToolbar', 'OverviewMap', 'Pan',
	                  'Panel', 'PanPanel', 'PanZoom', 'PanZoomBar', 'AutoPanZoom', 'Permalink',
	                  'Scale', 'ScaleLine', 'SelectFeature', 'Snapping', 'Split', 
	                  'WMSGetFeatureInfo', 'ZoomBox', 'ZoomIn', 'ZoomOut', 'ZoomPanel',
	                  'ZoomToMaxExtent'
			);
	}		
	
	private static $modes = array(
		'osm-wm' => array(
			'handler' => 'MapsOSMCgiBin',
			'options' => array(
				'base_url' => 'http://cassini.toolserver.org/cgi-bin/export',

				'format' => 'png',
				'numZoomLevels' => 16,
				'maxResolution' => 156543.0339,
				'unit' => 'm',
				'sphericalMercator' => true,
	
				'maptype' => 'osm-like'
			),
		),
		
		'osm' => array(
			'handler' => 'MapsOSMCgiBin',
			'options' => array(
				'base_url' => 'http://tile.openstreetmap.org/cgi-bin/export',

				'format' => 'png',
				'numZoomLevels' => 16,
				'maxResolution' => 156543.0339,
				'unit' => 'm',
				'sphericalMercator' => true
			),
		),
	);
	
	/**
	 * Returns an array containing the names of all modes.
	 * 
	 * @return array
	 */
	public static function getModeNames() {
		return array_keys(self::$modes);
	}
	
	/**
	 * Returns the data of a mode.
	 * 
	 * @param string $modeName
	 * @return array
	 */
	public static function getModeData($modeName) {
		return self::$modes[$modeName];
	}
	
	/**
	 * If this is the first OSM map on the page, load the OpenLayers API, OSM styles and extra JS functions
	 * 
	 * @param string $output
	 */
	public static function addOSMDependencies(&$output) {
		global $wgJsMimeType;
		global $egOSMMapsOnThisPage, $egMapsScriptPath, $egMapsStyleVersion;
		
		if (empty($egOSMMapsOnThisPage)) {
			$egOSMMapsOnThisPage = 0;
			
			$output .="<link rel='stylesheet' href='$egMapsScriptPath/OpenLayers/OpenLayers/theme/default/style.css' type='text/css' />
			<script type='$wgJsMimeType' src='$egMapsScriptPath/OpenLayers/OpenLayers/OpenLayers.js'></script>		
			<script type='$wgJsMimeType' src='$egMapsScriptPath/OpenStreetMap/OSMFunctions.min.js?$egMapsStyleVersion'></script>
			<script type='$wgJsMimeType'>slippymaps = Array();</script>\n";
		}		
	}			
	
}									