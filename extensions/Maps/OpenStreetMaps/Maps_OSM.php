<?php

/**
 * This file holds the general information for the OSM optimized OpenLayers service
 *
 * @file Maps_OSM.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

$egMapsServices['osm'] = array(
									'pf' => array(
										'display_point' => array('class' => 'MapsOSMDispPoint', 'file' => 'OpenStreetMaps/Maps_OSMDispPoint.php', 'local' => true),
										'display_map' => array('class' => 'MapsOSMDispMap', 'file' => 'OpenStreetMaps/Maps_OSMDispMap.php', 'local' => true),
										),
									'classes' => array(
											array('class' => 'MapsOSMUtils', 'file' => 'OpenStreetMaps/Maps_OSMUtils.php', 'local' => true)
											),
									'aliases' => array('openstreetmap', 'openstreetmaps'),
									'parameters' => array(
											)
									);