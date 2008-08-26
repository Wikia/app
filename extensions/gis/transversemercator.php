<?php
/**
 *  Convert latitiude longitude geographical coordinates to
 *  Transverse Mercator coordinates.
 *
 *  Uses the WGS-84 ellipsoid by default
 *
 *  See also:
 *  http://www.posc.org/Epicentre.2_2/DataModel/ExamplesofUsage/eu_cs34h.html
 *  http://kanadier.gps-info.de/d-utm-gitter.htm
 *  http://www.gpsy.com/gpsinfo/geotoutm/
 *  http://www.colorado.edu/geography/gcraft/notes/gps/gps_f.html
 *  http://search.cpan.org/src/GRAHAMC/Geo-Coordinates-UTM-0.05/
 *  UK Ordnance Survey grid (OSBG36): http://www.gps.gov.uk/guidecontents.asp
 *  Swiss CH1903: http://www.gps.gov.uk/guidecontents.asp
 *
 *  ----------------------------------------------------------------------
 *
 *  Copyright 2005, Egil Kvaleberg <egil@kvaleberg.no>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

/**
 *  Tranverse Mercator transformations
 */
class transversemercator
{
	/* public: */
	var $Northing;
	var $Easting;

	/* Reference Ellipsoid, default to WGS-84 */
	var $Radius = 6378137;           /* major semi axis = a */
	var $Eccentricity = 0.006694379990; /* square of eccentricity */

	/* Flattening = f = (a-b) / a */
	/* Inverse flattening = 1/f = 298.2572236 */
	/* Minor semi axis b = a*(1-f) */
	/* Eccentricity e = sqrt(a^2 - b^2)/a = 0.081819190843 */

	/* Transverse Mercator parameters */
	var $Scale = 0.9996;
	var $Easting_Offset        =   500000.0;
	var $Northing_Offset       =        0.0;
	var $Northing_Offset_South = 10000000.0; /* for Southern hemisphere */

	function transversemercator( )
	{
	}

	/**
	 *  Convert latitude, longitude in decimal degrees to
	 *  UTM Zone, Easting, and Northing
	 */
	function LatLon2UTM( $latitude, $longitude )
	{
		$this->Zone = $this->LatLon2UTMZone( $latitude, $longitude );
		$this->LatLonZone2UTM( $latitude, $longitude,
				       $this->Zone);
	}

	/**
	 *  Find UTM zone from latitude and longitude
	 */
	function LatLon2UTMZone( $latitude, $longitude )
	{
		$longitude2 = $longitude - intval(($longitude + 180)/360) * 360;

		if ($latitude >= 56.0 and $latitude < 64.0
		 and $longitude2 >= 3.0 and $longitude2 < 12.0) {
			$zone = 32;
		} elseif ($latitude >= 72.0 and $latitude < 84.0
		      and $longitude2 >= 0.0 and $longitude2 < 42.0) {
			$zone = ($longitude2 < 9.0) ? 31
			     : (($longitude2 < 21.0) ? 33
			     : (($longitude2 < 33.0) ? 35
			     :                    37));
		} else {
			$zone = intval( ($longitude2 + 180)/6) + 1;
		}
		$c = intval( ($latitude + 96) / 8 );
				  /* 000000000011111111112222 */
				  /* 012345678901234567890134 */
		return $zone.substr("CCCDEFGHJKLMNPQRSTUVWXXX",$c,1);
	}

	/**
	 *  Convert latitude, longitude in decimal degrees to
	 *  UTM Easting and Northing in a specific zone
	 *
	 *  \return false if problems
	 */
	function LatLonZone2UTM( $latitude, $longitude, $zone )
	{
		return $this->LatLonOrigin2TM( $latitude, $longitude,
					0.0, $this->utmzone_origin( $zone ));
	}

	/**
	 *  Convert latitude, longitude in decimal degrees to
	 *  OSBG36 Easting and Northing
	 */
	function LatLon2OSGB36( $latitude, $longitude )
	{
		/* Airy 1830 ellipsoid */
		$this->Radius = 6377563.396;
		/* inverse flattening 1/f: 299.3249647 */
		$this->Eccentricity = 0.00667054; /* square of eccentricity */

		$this->Scale = 0.9996013;
		$this->Easting_Offset = 400000.0;
		$this->Northing_Offset = -100000.0;
		$this->Northing_Offset_South = 0.0;

		$latitude_origin = 49.0;
		$longitude_origin = -2.0;

		if (!$this->LatLonOrigin2TM( $latitude, $longitude,
				$latitude_origin, $longitude_origin )) {
			return "";
		}

		/* fix by Roger W Haworth */
		$grid_x = floor( $this->Easting / 100000 );
		$grid_y = floor( $this->Northing / 100000 );
		if ($grid_x < 0 or $grid_x > 6
		 or $grid_y < 0 or $grid_y > 12) {
			/* outside area for OSGB36 */
			return "";
		}
		/*          0000000000111111111122222 */
		/*          0123456789012345678901234 */
		$letters = "ABCDEFGHJKLMNOPQRSTUVWXYZ";

		$c1 = substr($letters,(17-(intval($grid_y/5))*5) + intval($grid_x/5),1);
		$c2 = substr($letters,(20-($grid_y%5)*5) + $grid_x%5,1);
		$e = sprintf("%05d", $this->Easting % 100000);
		$n = sprintf("%05d", $this->Northing % 100000);

		return $c1.$c2.$e.$n;
	}

	/**
	 *  Convert latitude, longitude in decimal degrees to
	 *  CH1903 Easting and Northing
	 *  Assumed range is latitude 45.5 .. 48 and logitude 5 - 11
	 */
	function LatLon2CH1903( $latitude, $longitude )
	{
		if ($latitude < 45.5 or $latitude > 48
		 or $longitude < 5.0 or $longitude > 11) {
		    /* outside reasonable range */
		    $this->Easting = "";
		    $this->Northing = "";
		    return false;
		}

		/* ellipsoid: Bessel 1841 */
		$this->Radius = 6377397.155;
		// 299.1528128
		$this->Eccentricity = 0.006674372;

		$this->Scale = 1.0;
		$this->Easting_Offset =   600000.0;
		$this->Northing_Offset =  200000.0;
		$this->Northing_Offset_South = 0.0;

		$latitude_origin  = 46.95240555556;
		$longitude_origin =  7.43958333333;

		$this->LatLonOrigin2TM( $latitude, $longitude,
				$latitude_origin, $longitude_origin );
	}

	function utmzone_origin( $zone )
	{
		return (intval($zone) - 1)*6 - 180 + 3;
	}

	function find_M ( $lat_rad )
	{
		$e = $this->Eccentricity;

		return $this->Radius
			* ( ( 1 - $e/4 - 3 * $e * $e/64
			      - 5 * $e * $e * $e/256
			    ) * $lat_rad
			  - ( 3 * $e/8 + 3 * $e * $e/32
			      + 45 * $e * $e * $e/1024
			    ) * sin(2 * $lat_rad)
			  + ( 15 * $e * $e/256 +
			      45 * $e * $e * $e/1024
			    ) * sin(4 * $lat_rad)
			  - ( 35 * $e * $e * $e/3072
			    ) * sin(6 * $lat_rad) );
	}

	function deg2rad( $deg )
	{
		return (M_PI / 180) * $deg;
	}

	function rad2deg( $rad )
	{
		return $rad * (180 / M_PI);
	}

	/**
	 *  Convert latitude, longitude in decimal degrees to
	 *  TM Easting and Northing based on a specified origin
	 *
	 *  \return false if problems
	 */
	function LatLonOrigin2TM( $latitude, $longitude,
				  $latitude_origin, $longitude_origin )
	{
		if ($longitude < -180 or $longitude > 180
		 or $latitude < -80 or $latitude > 84) {
			# UTM not defined in this range
			return false;
		}
		$longitude2 = $longitude - intval(($longitude + 180)/360) * 360;

		$lat_rad = $this->deg2rad( $latitude );

		$e = $this->Eccentricity;
		$e_prime_sq = $e / (1-$e);

		$v = $this->Radius / sqrt(1 - $e * sin($lat_rad)*sin($lat_rad));
		$T = pow( tan($lat_rad), 2);
		$C = $e_prime_sq * pow( cos($lat_rad), 2);
		$A = $this->deg2rad( $longitude2 -$longitude_origin )
		     * cos($lat_rad);
		$M = $this->find_M( $lat_rad );
		if ( $latitude_origin != 0) {
			$M0 = $this->find_M( $this->deg2rad( $latitude_origin ));
		} else {
			$M0 = 0.0;
		}

		$northing = $this->Northing_Offset + $this->Scale *
			    ( ($M - $M0) + $v*tan($lat_rad) * 
			      ( $A*$A/2 
				+ (5 - $T + 9*$C + 4*$C*$C) * pow($A,4)/24
				+ (61 - 58*$T + $T*$T 
				+ 600*$C - 330*$e_prime_sq) * pow($A,6)/720 ));

		$easting = $this->Easting_Offset + $this->Scale * $v *
			   ( $A 
			     + (1-$T+$C)*pow($A,3)/6
			     + (5 - 18*$T + pow($T,2) + 72*$C 
				- 58 * $e_prime_sq)*pow($A,5)/120 );

		# FIXME: Use zone_letter
		# if (ord($zone_letter) < ord('N'))
		if ( $latitude < 0 ) {
			$northing += $this->Northing_Offset_South;
		}

		$this->Northing = $northing;
		$this->Easting = $easting;

		return true;
	}
}
