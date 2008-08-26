<?php
/**
 *  Great Circle cakculations
 *
 *  See also:
 *  http://www.ac6v.com/greatcircle.htm
 *  http://williams.best.vwh.net/avform.htm
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
 *  Great Circle calculations
 */
class greatcircle
{
	var $distance;
	var $heading;

	function deg2rad( $deg )
	{
		return (M_PI / 180) * $deg;
	}

	function rad2deg( $rad )
	{
		return $rad * (180 / M_PI);
	}

	function octant()
	{

		$o = round($this->heading / 45);
		$a = array( 'N',
			    'N'.'E',
			    'E',
			    'S'.'E',
			    'S',
			    'S'.'W',
			    'W',
			    'N'.'W',
			    'N');
		return $a[$o];
	}

	/**
	 *  Calculate Great Circle distance
	 */
	function greatcircle( $latitude, $longitude,
			      $latitude_origin, $longitude_origin )
	{
		$lat1 = $this->deg2rad( $latitude_origin );
		$lat2 = $this->deg2rad( $latitude );
		$lon1 = $this->deg2rad( $longitude_origin );
		$lon2 = $this->deg2rad( $longitude );

		$d = 2*asin(sqrt(pow(sin(($lat1-$lat2)/2),2) +
			cos($lat1)*cos($lat2)*pow(sin(($lon1-$lon2)/2),2)));

		if ($d <= 0.0000001) {
			$tc1 = 0; // less than 10 cm: going to self
		} elseif ($lat1 > M_PI/2.0001) {
			$tc1 = M_PI; // starting from N pole
		} elseif ($lat1 < -M_PI/2.0001) {
			$tc1 = 0; // starting from S pole
		} else {
			$tc1 = acos((sin($lat2)-sin($lat1)*cos($d))
			     / (sin($d) * cos($lat1)));
			if (sin($lon2-$lon1) < 0) {
				$tc1 = 2*M_PI - $tc1;
			}
		}
		$this->heading = rad2deg($tc1);
		$this->distance = rad2deg($d) * 60 * 1852;
		/* Assumes Earth radius of 6366.71 km */
	}
}

