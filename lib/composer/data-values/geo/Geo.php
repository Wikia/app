<?php

/**
 * Entry point of the DataValues Geo library.
 *
 * @since 0.1
 * @codeCoverageIgnore
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( defined( 'DATAVALUES_GEO_VERSION' ) ) {
	// Do not initialize more than once.
	return 1;
}

define( 'DATAVALUES_GEO_VERSION', '2.1.1' );

// Aliases introduced in 1.0
class_alias( DataValues\Geo\Values\LatLongValue::class, 'DataValues\LatLongValue' );
class_alias( DataValues\Geo\Values\GlobeCoordinateValue::class, 'DataValues\GlobeCoordinateValue' );

// Aliases introduced in 2.0
class_alias(
	DataValues\Geo\Formatters\LatLongFormatter::class,
	'DataValues\Geo\Formatters\GeoCoordinateFormatter'
);
class_alias(
	DataValues\Geo\Parsers\LatLongParser::class,
	'DataValues\Geo\Parsers\GeoCoordinateParser'
);
