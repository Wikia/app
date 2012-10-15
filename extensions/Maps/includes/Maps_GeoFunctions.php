<?php

// The approximate radius of the earth in meters, according to http://en.wikipedia.org/wiki/Earth_radius.
define( 'Maps_EARTH_RADIUS', 6371000 );

/**
 * Static class containing geographical functions.
 *
 * @since 0.6
 * 
 * @file Maps_GeoFunctions.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 * @author Pnelnik
 * @author Matěj Grabovský
 */
final class MapsGeoFunctions {	
	
	/**
	 * Returns the geographical distance between two coordinates.
	 * See http://en.wikipedia.org/wiki/Geographical_distance
	 * 
	 * @since 0.6
	 * 
	 * @param array $start The first coordinates, as non-directional floats in an array with lat and lon keys.
	 * @param array $end The second coordinates, as non-directional floats in an array with lat and lon keys.
	 * 
	 * @return float Distance in m.
	 */
	public static function calculateDistance( array $start, array $end ) {
		$northRad1 = deg2rad( $start['lat'] );
		$eastRad1 = deg2rad( $start['lon'] );

		$cosNorth1 = cos( $northRad1 );
		$cosEast1 = cos( $eastRad1 );
		
		$sinNorth1 = sin( $northRad1 );
		$sinEast1 = sin( $eastRad1 );
		
		$northRad2 = deg2rad( $end['lat'] );
		$eastRad2 = deg2rad( $end['lon'] );
		
		$cosNorth2 = cos( $northRad2 );
		$cosEast2 = cos( $eastRad2 );

		$sinNorth2 = sin( $northRad2 );
		$sinEast2 = sin( $eastRad2 );

		$term1 = $cosNorth1 * $sinEast1 - $cosNorth2 * $sinEast2;
		$term2 = $cosNorth1 * $cosEast1 - $cosNorth2 * $cosEast2;
		$term3 = $sinNorth1 - $sinNorth2;

		$distThruSquared = $term1 * $term1 + $term2 * $term2 + $term3 * $term3;

		return 2 * Maps_EARTH_RADIUS * asin( sqrt( $distThruSquared ) / 2 );	
	}
	
	/**
	 * Finds a destination given a starting location, bearing and distance.
	 * 
	 * @since 0.6
	 * 
	 * @param array $startingCoordinates The starting coordinates, as non-directional floats in an array with lat and lon keys.
	 * @param float $bearing The initial bearing in degrees.
	 * @param float $distance The distance to travel in km.
	 * 
	 * @return array The desitination coordinates, as non-directional floats in an array with lat and lon keys.
	 */
	public static function findDestination( array $startingCoordinates, $bearing, $distance ) {
		$startingCoordinates['lat'] = deg2rad( (float)$startingCoordinates['lat'] );
		$startingCoordinates['lon'] = deg2rad( (float)$startingCoordinates['lon'] );
	
		$radBearing = deg2rad ( (float)$bearing );
		$angularDistance = $distance / Maps_EARTH_RADIUS;
		
		$lat = asin (sin ( $startingCoordinates['lat'] ) * cos ( $angularDistance ) + cos ( $startingCoordinates['lat'] )  * sin ( $angularDistance ) * cos ( $radBearing ) );
		$lon = $startingCoordinates['lon'] + atan2 ( sin ( $radBearing ) * sin ( $angularDistance ) * cos ( $startingCoordinates['lat'] ), cos ( $angularDistance ) - sin ( $startingCoordinates['lat'] ) * sin ( $lat ) );
	
		return array(
			'lat' => rad2deg( $lat ),
			'lon' => rad2deg( $lon )
		);
	}
	
}