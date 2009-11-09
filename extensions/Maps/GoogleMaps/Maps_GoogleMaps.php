<?php

/**
 * This file holds the general information for the Google Maps service
 *
 * @file Maps_GoogleMaps.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

$egMapsServices['googlemaps'] = array(
									'pf' => array(
										'display_point' => array('class' => 'MapsGoogleMapsDispPoint', 'file' => 'GoogleMaps/Maps_GoogleMapsDispPoint.php', 'local' => true),
										'display_map' => array('class' => 'MapsGoogleMapsDispMap', 'file' => 'GoogleMaps/Maps_GoogleMapsDispMap.php', 'local' => true),
										),
									'classes' => array(
											array('class' => 'MapsGoogleMapsUtils', 'file' => 'GoogleMaps/Maps_GoogleMapsUtils.php', 'local' => true)
											),
									'aliases' => array('google', 'googlemap', 'gmap', 'gmaps'),
									'parameters' => array(
											'type' => array('map-type', 'map type'),
											'types' => array('map-types', 'map types'),
											'earth' => array(),
											'autozoom' => array('auto zoom', 'mouse zoom', 'mousezoom'),
											'class' => array(),
											'style' => array()										
											)
									);