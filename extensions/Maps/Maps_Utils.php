<?php

/**  
 * A class that holds static helper functions for common functionality that is map-spesific.
 * Non spesific functions are located in @see MapsParserFunctions
 *
 * @file Maps_Utils.php
 * @ingroup Maps
 *
 * @author Robert Buzink
 * @author Yaron Koren
 * @author Jeroen De Dauw
 */

if (! defined ( 'MEDIAWIKI' )) {
	die ( 'Not an entry point.' );
}

class MapsUtils {	
	
	/*
	 * Returns an array containing the latitude (lat) and longitude (lon)
	 * of the provided coordinate string.
	 * 
	 * @param string $coordinates
	 */
	public static function getLatLon($coordinates) {
		$coordinates = preg_split ( "/,/", $coordinates );
		if (count ( $coordinates ) == 2) {
			$lat = MapsUtils::convertCoord ( $coordinates [0] );
			$lon = MapsUtils::convertCoord ( $coordinates [1] );
			return array ('lat' => $lat, 'lon' => $lon);
		} else {
			return array ('lat' => null, 'lon' => null);
		}
	}
	
	/**
	 * 
	 * @param $deg_coord
	 * @return unknown_type
	 */
	private static function convertCoord($deg_coord = "") {
		if (preg_match ( '/°/', $deg_coord )) {
			if (preg_match ( '/"/', $deg_coord )) {
				return MapsUtils::degree2Decimal ( $deg_coord );
			} else {
				return MapsUtils::decDegree2Decimal ( $deg_coord );
			}
		}
		return $deg_coord;
	}	
	
	/**
	 * 
	 * @param $deg_coord
	 * @return unknown_type
	 */
	private static function degree2Decimal($deg_coord = "") {
		$dpos = strpos ( $deg_coord, '°' );
		$mpos = strpos ( $deg_coord, '.' );
		$spos = strpos ( $deg_coord, '"' );
		$mlen = (($mpos - $dpos) - 1);
		$slen = (($spos - $mpos) - 1);
		$direction = substr ( strrev ( $deg_coord ), 0, 1 );
		$degrees = substr ( $deg_coord, 0, $dpos );
		$minutes = substr ( $deg_coord, $dpos + 1, $mlen );
		$seconds = substr ( $deg_coord, $mpos + 1, $slen );
		$seconds = ($seconds / 60);
		$minutes = ($minutes + $seconds);
		$minutes = ($minutes / 60);
		$decimal = ($degrees + $minutes);
		//South latitudes and West longitudes need to return a negative result
		if ($direction == "S" || $direction == "W") {
			$decimal *= - 1;
		}
		return $decimal;
	}
	
	/**
	 * 
	 * @param $deg_coord
	 * @return unknown_type
	 */
	private static function decDegree2Decimal($deg_coord = "") {
		$direction = substr ( strrev ( $deg_coord ), 0, 1 );
		$decimal = floatval ( $deg_coord );
		if (($direction == "S") or ($direction == "W")) {
			$decimal *= - 1;
		}
		return $decimal;
	}
	
	/**
	 * 
	 * @param $decimal
	 * @return unknown_type
	 */
	public static function latDecimal2Degree($decimal) {
		if ($decimal < 0) {
			return abs ( $decimal ) . "° S";
		} else {
			return $decimal . "° N";
		}
	}
	
	/**
	 * 
	 * @param $decimal
	 * @return unknown_type
	 */
	public static function lonDecimal2Degree($decimal) {
		if ($decimal < 0) {
			return abs ( $decimal ) . "° W";
		} else {
			return $decimal . "° E";
		}
	}
	
	/**
	 * If the provided height or width do not fall within the allowed interval,
	 * they are changed to the nearest allowed value.
	 * 
	 * @param integer $width
	 * @param integer $height
	 */
	public static function makeMapSizeValid(&$width, &$height) {
		global $egMapsSizeRestrictions;

		if ($width < $egMapsSizeRestrictions['width'][0])  {
			$width = $egMapsSizeRestrictions['width'][0];
		}
		else if($width > $egMapsSizeRestrictions['width'][1]) {
			$width = $egMapsSizeRestrictions['width'][1];
		}
		
		if ($height < $egMapsSizeRestrictions['height'][0])  {
			$height = $egMapsSizeRestrictions['height'][0];
		}
		else if($height > $egMapsSizeRestrictions['height'][1]) {
			$height = $egMapsSizeRestrictions['height'][1];
		}		
	}

	/**
	 * Convert from WGS84 to spherical mercator.
	 */
	public static function forwardMercator($lonlat) {
		for ($i=0; $i<count($lonlat); $i+=2) {
			/* lon */
			$lonlat[$i] = $lonlat[$i] * (2 * M_PI * 6378137 / 2.0) / 180.0;
			
			/* lat */
			$lonlat[$i+1] = log(tan((90 + $lonlat[$i+1]) * M_PI / 360.0)) / (M_PI / 180.0);
			$lonlat[$i+1] = $lonlat[$i+1] * (2 * M_PI * 6378137 / 2.0) / 180.0;
		}		
		return $lonlat;
	}
	
	/**
	 * Convert from spherical mercator to WGS84.
	 */
	public static function inverseMercator($lonlat) {
		for ($i=0; $i<count($lonlat); $i+=2) {
			/* lon */
			$lonlat[$i] = $lonlat[$i] / ((2 * M_PI * 6378137 / 2.0) / 180.0);
			
			/* lat */
			$lonlat[$i+1] = $lonlat[$i+1] / ((2 * M_PI * 6378137 / 2.0) / 180.0);
			$lonlat[$i+1] = 180.0 / M_PI * (2 * atan(exp($lonlat[$i+1] * M_PI / 180.0)) - M_PI / 2);
		}		
		
		return $lonlat;
	}	
	
	/**
	 * Returns if the current php version is equal of bigger then the provided one.
	 *
	 * @param string $requiredVersion
	 * @return boolean
	 */
	public static function phpVersionIsEqualOrBigger($requiredVersion) {
		// TODO: Ensure this works, and does not cause errors for some versions.
		$currentVersion = phpversion();

		for($i = 0; $i < 3; $i++) {
			if ($currentVersion[$i] < $requiredVersion[$i]) {
				return false; 
			}
			else if($currentVersion[$i] > $requiredVersion[$i]) {
				return true;
			} 
		}
		
		return true;
	}	
	
}
