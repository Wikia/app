<?php

/**
 * Class that performs basic coordinate calculations
 * Note that the formulas are useful only for our specific purposes, some of them may be
 * inaccurate for long distances. Oh well.
 * 
 * All the functions that accept coordinates assume that they're in degrees, not radians.
 */
/* static */class GeoMath {
	const EARTH_RADIUS = 6371010;

	/**
	 * Calculates distance between two coordinates
	 * @see https://en.wikipedia.org/wiki/Haversine_formula
	 *
	 * @param float $lat1
	 * @param float $lon1
	 * @param float $lat2
	 * @param float $lon2
	 * @return float Distance in meters
	 */
	public static function distance( $lat1, $lon1, $lat2, $lon2 ) {
		$lat1 = deg2rad( $lat1 );
		$lon1 = deg2rad( $lon1 );
		$lat2 = deg2rad( $lat2 );
		$lon2 = deg2rad( $lon2 );
		$sin1 = sin( ( $lat2 - $lat1 ) / 2 );
		$sin2 = sin( ( $lon2 - $lon1 ) / 2 );
		return 2 * self::EARTH_RADIUS * asin( sqrt( $sin1 * $sin1 + cos( $lat1 ) * cos( $lat2 ) * $sin2 * $sin2 ) );
	}

	/**
	 * Returns a bounding rectangle around a given point
	 * 
	 * @param float $lat
	 * @param float $lon
	 * @param float $radius
	 * @return Array 
	 */
	public static function rectAround( $lat, $lon, $radius ) {
		if ( !$radius ) {
			return array(
				'minLat' => $lat, 'maxLat' => $lat,
				'minLon' => $lon, 'maxLon' => $lon
			);
		}
		$r2lat = rad2deg( $radius / self::EARTH_RADIUS );
		// @todo: doesn't work around poles, should we care?
		if ( abs( $lat ) < 89.9 ) {
			$r2lon = rad2deg( $radius / cos( deg2rad( $lat ) ) / self::EARTH_RADIUS );
		} else {
			$r2lon = 0.1;
		}
		$res = array(
			'minLat' => $lat - $r2lat,
			'maxLat' => $lat + $r2lat,
			'minLon' => $lon - $r2lon,
			'maxLon' => $lon + $r2lon
		);
		self::wrapAround( $res['minLat'], $res['maxLat'], -90, 90 );
		self::wrapAround( $res['minLon'], $res['maxLon'], -180, 180 );
		return $res;
	}

	private static function wrapAround( &$from, &$to, $min, $max ) {
		if ( $from < $min ) {
			$from = $max - ( $min - $from );
		}
		if ( $to > $max ) {
			$to = $min + $to - $max;
		}
	}

	/**
	 * Sign function
	 * 
	 * @param Float $x: Value to get sinng of
	 * @return int
	 */
	public static function sign( $x ) {
		if ( $x >= 0 ) {
			return 1;
		}
		return -1;
	}
}
