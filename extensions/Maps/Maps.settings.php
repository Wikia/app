<?php

/**
 * File defining the settings for the Maps extension.
 * Changing one of these settings can be done by assigning to $egMapsSettings.
 * More info can be found at http://mapping.referata.com/wiki/Help:Configuration
 *
 * @since 1.1
 *
 * @file Maps.settings.php
 * @ingroup Maps
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

$s = array(
	
	new Setting(
		'services',
		array(
			'googlemaps2',
			'googlemaps3',
			'yahoomaps',
			'openlayers',
			'osm'
		)
	),
	
	new Setting( 'defaultService', 'googlemaps3' ),
	
	new Setting(
		'defaultServices',
			array(
			'display_point' => 'googlemaps3',
			'display_map' => 'googlemaps3'
		)
	),
	
	new Setting(
		'geoServices',
		array(
			'geonames',
			'google',
			'yahoo'
		)
	),
	
	new Setting(
		'defaultGeoService',
		'geonames'
	),
	
	new Setting(
		'useGeoOverrides',
		true
	),
	
	new Setting(
		'allowCoordsGeocoding',
		true
	),
	
	new Setting(
		'enableGeoCache',
		true
	),
	
	new Setting(
		'geoNamesUser',
		''
	),
	
	// TODO
);

foreach ( $s as &$setting ) {
	$setting->setMessage( 'maps-setting-' . $setting->getName() );
}

return $s;