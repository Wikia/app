<?php
/** \file
 *
 *  Support the <geo> extension, see also:
 *  http://en.wikipedia.org/wiki/Wikipedia:WikiProject_Geographical_coordinates
 *
 *  To install, put the following in your LocalSettings.php:
 *
 *      include( "extensions/gis/geo.php" );
 *
 *  If $wgMapsourcesURL is not defined, there will not be links to the
 *  "Map sources" page, but the geo tag will still be rendered.
 *
 *  To add the points to a database, see the gis/geodb extension
 *
 *  \todo Translations
 *  \todo Various FIXMEs
 *
 *  ----------------------------------------------------------------------
 *
 *  Copyright 2005, Egil Kvaleberg <egil@kvaleberg.no>
 *  Copyright 2006, Jens Frank <jeluf@wikimedia.org>
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

if ( !defined( 'MEDIAWIKI' ) ) {
        echo "Geo extension\n";
        exit( 1 ) ;
}


class GeoParam {
	var $latdeg;
	var $londeg;

	var $latdeg_min;
	var $londeg_min;
	var $latdeg_max;
	var $londeg_max;

	var $pieces;
	var $error;
	var $coor;
	var $title;

	/**
	 *   Constructor:
	 *   Read coordinates, and if there is a range, read the range
	 */
	function GeoParam( $param = false )
	{
		$this->pieces=array();
		if ( is_string( $param ) ) {
			$this->fillFromString( $param );
		} else {
			$this->fillFromWgRequest();
		}
	}

	/**
	 * Helper function for the constructor.
	 * Fills the strutctures from a string
	 * Expects a string like 51 17 32 N 11 7 42 E
	 */
	function fillFromString( $param ) {
		$this->pieces = explode(" ", str_replace( '_', ' ', trim( str_replace( '<geo>', ' ', $param ) ) ));
		$this->get_coor( );

		$this->latdeg_min = $this->latdeg_max = $this->latdeg;
		$this->londeg_min = $this->londeg_max = $this->londeg;
		if ( isset( $this->pieces[0] ) && $this->pieces[0] == "to") {
			array_shift($this->pieces);
			$this->get_coor();
			if ($this->latdeg < $this->latdeg_max) {
				$this->latdeg_min = $this->latdeg;
			} else {
				$this->latdeg_max = $this->latdeg;
			}
			if ($this->londeg < $this->londeg_max) {
				$this->londeg_min = $this->londeg;
			} else {
				$this->londeg_max = $this->londeg;
			}
			$this->latdeg = ($this->latdeg_max+$this->latdeg_min) / 2;
			$this->londeg = ($this->londeg_max+$this->londeg_min) / 2;
			$this->coor = array();
		}
	}
	/**
	 * Helper function for the constructor.
	 * Fills the strutctures from a web request
	 * Expects a request like latdeg=60&latmin=0&latsec=0&latns=N&londeg=0&lonmin=0&lonsec=0&lonew=E
	 * or a request of the form BBOX=50,5,60.5,15.25
	 * If a point is given, latmin == latmax == lat, lonmin == lonmax == lon
	 * If a box is given, lat/lon specify the arithmetic center of the box.
	 */
	function fillFromWgRequest() {
		global $wgRequest;
		$this->coor = array(
			'latdeg' =>  $wgRequest->getVal('latdeg'),
			'latmin' =>  $wgRequest->getVal('latmin'),
			'latsec' =>  $wgRequest->getVal('latsec'),
			'latns' =>   $wgRequest->getVal('latns'),
			'londeg' =>  $wgRequest->getVal('londeg'),
			'lonmin' =>  $wgRequest->getVal('lonmin'),
			'lonsec' =>  $wgRequest->getVal('lonsec'),
			'lonew' =>   $wgRequest->getVal('lonew') );
		$this->title = $wgRequest->getVal('pagetitle');
		$this->latdeg_min = $this->latdeg_max = $this->latdeg;
		$this->londeg_min = $this->londeg_max = $this->londeg;
		$this->updateInternal();


	}

	/**
	 *  Private:
	 *  Get a set of coordinates from parameters
	 */
	function get_coor() {
		if ($i = strpos($this->pieces[0],';')) {
			/* two values separated by a semicolon */
			$this->coor = array(
				'latdeg' => substr($this->pieces[0],0,$i),
				'londeg' => substr($this->pieces[0],$i+1),
				'latns'  => 'N',
				'lonew'  => 'E' );
			array_shift($this->pieces);
		} elseif ($this->is_coor($this->pieces[1],$this->pieces[3])) {
			$this->coor = array(
				'latdeg' => array_shift($this->pieces),
				'latns'  => array_shift($this->pieces),
				'londeg' => array_shift($this->pieces),
				'lonew'  => array_shift($this->pieces) );
		} elseif ($this->is_coor($this->pieces[2],$this->pieces[5])) {
			$this->coor = array(
				'latdeg' => array_shift($this->pieces),
				'latmin' => array_shift($this->pieces),
				'latns'  => array_shift($this->pieces),
				'londeg' => array_shift($this->pieces),
				'lonmin' => array_shift($this->pieces),
				'lonew'  => array_shift($this->pieces));
		} elseif ($this->is_coor($this->pieces[3],$this->pieces[7])) {
			$this->coor = array(
				'latdeg' => array_shift($this->pieces),
				'latmin' => array_shift($this->pieces),
				'latsec' => array_shift($this->pieces),
				'latns'  => array_shift($this->pieces),
				'londeg' => array_shift($this->pieces),
				'lonmin' => array_shift($this->pieces),
				'lonsec' => array_shift($this->pieces),
				'lonew'  => array_shift($this->pieces));
		} else {
			# support decimal, signed lat, lon
			$this->error = "Unrecognized format";
		}
		$this->updateInternal();
	}

/*
		if ($this->latdeg >  90 or $this->latdeg <  -90
		 or $this->londeg > 180 or $this->londeg < -180
		 or $latmin       >  60 or $latmin       <    0
		 or $lonmin       >  60 or $lonmin       <    0
		 or $latsec       >  60 or $latsec       <    0
		 or $lonsec       >  60 or $lonsec       <    0) {
			$this->error = "Out of range {$this->latdeg} $latmin $latsec, {$this->londeg} $lonmin $lonsec ";
		}

*/
	/**
	 * Helper function.
	 * Updates alternative internal representations, e.g. decimal degrees.
	 */
	function updateInternal() {
		# Make decimal degree, if not already
		$latmin = $this->coor['latmin'] + $this->coor['latsec']/60.0;
		$lonmin = $this->coor['lonmin'] + $this->coor['lonsec']/60.0;
		$this->latdeg = $this->coor['latdeg'] + $latmin/60.0;
		$this->londeg = $this->coor['londeg'] + $lonmin/60.0;

		if ( $this->coor['latns'] == 'S' ) {
			$this->latdeg = -$this->latdeg;
		}
		if ( $this->coor['lonew'] == 'W' ) {
			$this->londeg = -$this->londeg;
		}
	}

	/**
	 *   Given decimal degrees, convert to
	 *   minutes, seconds and direction
	 */
	function make_minsec( $deg ) {
		if ( $deg >= 0) {
			$NS = "N";
			$EW = "E";
		} else {
			$NS = "S";
			$EW = "W";
		}
		# Round to a suitable number of digits
		# FIXME: should reflect precision
		$deg = round($deg, 6);
		$min = 60.0 * (abs($deg) - intval(abs($deg)));
		$min = round($min, 4);
		$sec = 60.0 * ($min - intval($min));
		$sec = round($sec, 2);

		return array(
			'deg'   => $deg,
			'min'   => $min,
			'sec'   => $sec,
			'NS'    => $NS,
			'EW'    => $EW);
	}

	/**
	 *   Given decimal degrees latitude and longitude, convert to
	 *   string
	*/
	function make_position( $lat, $lon ) {
		$latdms = GeoParam::make_minsec( $lat );
		$londms = GeoParam::make_minsec( $lon );
		$outlat = intval(abs($latdms['deg'])) . "&deg;&nbsp;";
		$outlon = intval(abs($londms['deg'])) . "&deg;&nbsp;";
		if ($latdms['min'] != 0 or $londms['min'] != 0
		 or $latdms['sec'] != 0 or $londms['sec'] != 0) {
			$outlat .= intval($latdms['min']) . "&prime;&nbsp;";
			$outlon .= intval($londms['min']) . "&prime;&nbsp;";
			if ($latdms['sec'] != 0 or $londms['sec'] != 0) {
				$outlat .= $latdms['sec']. "&Prime;&nbsp;";
				$outlon .= $londms['sec']. "&Prime;&nbsp;";
			}
		}
		return $outlat . $latdms['NS'] . " " . $outlon . $londms['EW'];
	}


	/**
	 *  Get the additional attributes in an associative array
	 */
	function get_attr() {
		$a = array();
		while (($s = array_shift($this->pieces))) {
			if (($i = strpos($s,":")) >= 1) {
				$attr = substr($s,0,$i);
				$val = substr($s,$i+1);
				if (($j = strpos($val,"("))
				 && ($k = strpos($val,")"))
				 && ($k > $j)) {
					$a["arg:".$attr] = substr($val,$j+1,$k-($j+1));
					$val = substr($val,0,$j);
				}
				$a[$attr] = $val;
			} elseif (intval($s) > 0) {
			    if ($a['$scale'] != "")
				$a['scale'] = intval($s);
			}
		}
		return $a;
	}

	function is_coor( $ns, $ew ) {
		$ns = trim(strtoupper($ns));
		$ew = trim(strtoupper($ew));
		return (($ns=="N" or $ns=="S") and
			($ew=="E" or $ew=="W"));
	}

	function frac( $f) {
		return abs($f) - abs(intval($f));
	}

	/**
	 *  Get composite position in RFC2045 format
	 */
	function get_position( ) {
		return $this->latdeg.";".$this->londeg;
	}

	/**
	 *  Get error message that applies, or "" of all is well
	 */
	function get_error() {
		if ($this->error != "") {
			return "Error:".$this->error;
		}
		return "";
	}

	/**
	 * Produce markup suitable for use in a link
	 */
	function get_param_string() {
		$res='';
		foreach ( $this->coor as $key => $value ) {
			$res .= ( $res == '' ? '' : '&' ) . "$key=$value";
		}
		return $res."&pagetitle={$this->title}";
	}

	/**
	 *  Produce markup suitable for use in page
	 *  Use original content as much as possible
	 */
	function get_markup()
	{
		$n = count($this->coor);

		if ($n == 0) {
			# Range is special case
			return $this->make_position( $this->latdeg_min,
						     $this->londeg_min )
			     . " to "
			     . $this->make_position( $this->latdeg_max,
						     $this->londeg_max );
		} elseif ($n == 2) {
			return $this->getMicroformat( $this->coor['latdeg'].';', $this->coor['londeg'] );
		} elseif ($n == 4) {
			return $this->getMicroformat(
				$this->coor['latdeg'].'&deg;&nbsp;'. $this->coor['latns'],
			       $this->coor['londeg'].'&deg;&nbsp;'. $this->coor['lonew'] );
		} elseif ($n == 6) {
			return $this->getMicroformat(
				$this->coor['latdeg'].'&deg;'. $this->coor['latmin'].'&prime;&nbsp;'.
			       $this->coor['latns'],
			       $this->coor['londeg'].'&deg;'. $this->coor['lonmin'].'&prime;&nbsp;'.
			       $this->coor['lonew'] );
		} elseif ($n == 8) {
			return $this->getMicroformat(
				$this->coor['latdeg'].'&deg;'.  $this->coor['latmin'].'&prime;'.
			       $this->coor['latsec'].'&Prime;&nbsp;'.  $this->coor['latns'],

			       $this->coor['londeg'].'&deg;'.  $this->coor['lonmin'].'&prime;'.
			       $this->coor['lonsec'].'&Prime;&nbsp;'.  $this->coor['lonew'] );
		} else {
			return $this->get_error();
		}
	}

	function getMicroformat($lat, $lon) {
		return '<span class="geo"><abbr class="latitude" title="' . $this->latdeg .
			'">' . $lat . '</abbr> <abbr class="longitude" title="' . $this->londeg .
			'">' . $lon . '</abbr></span>';
	}
}
