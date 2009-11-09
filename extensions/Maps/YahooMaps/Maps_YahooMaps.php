<?php

/**
 * This file holds the general information for the Yahoo! Maps service
 *
 * @file Maps_YahooMaps.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

$egMapsServices['yahoomaps'] = array(
									'pf' => array(
										'display_point' => array('class' => 'MapsYahooMapsDispPoint', 'file' => 'YahooMaps/Maps_YahooMapsDispPoint.php', 'local' => true),
										'display_map' => array('class' => 'MapsYahooMapsDispMap', 'file' => 'YahooMaps/Maps_YahooMapsDispMap.php', 'local' => true),
										),
									'classes' => array(
											array('class' => 'MapsYahooMapsUtils', 'file' => 'YahooMaps/Maps_YahooMapsUtils.php', 'local' => true)
											),
									'aliases' => array('yahoo', 'yahoomap', 'ymap', 'ymaps'),
									'parameters' => array(
											'type' => array('map-type'),
											'types' => array('map-types', 'map types'),
											'autozoom' => array('auto zoom', 'mouse zoom', 'mousezoom')
											)
									);