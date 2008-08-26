<?php
# Copyright (C) 2004 Magnus Manske <magnus.manske@web.de>
# http://www.mediawiki.org/
# 
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or 
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
# http://www.gnu.org/copyleft/gpl.html

/**
 *
 * @addtogroup SpecialPage
 */

/**
 *
 */
function wfSpecialGeo( $page = '' ) {
	global $wgOut, $wgLang, $wgRequest;
	$coordinates = htmlspecialchars( $wgRequest->getText( 'coordinates' ) );
	$coordinates = explode ( ":" , $coordinates ) ;
	$ns = array_shift ( $coordinates ) ;
	$ew = array_shift ( $coordinates ) ;
	if ( 0 < count ( $coordinates ) ) $zoom = length ( array_shift ( $coordinates ) ) ;
	else $zoom = 6 ;
	
	$ns = explode ( "." , $ns ) ;
	$ew = explode ( "." , $ew ) ;
	while ( count ( $ns ) < 3 ) $ns[] = "0" ;
	while ( count ( $ew ) < 3 ) $ew[] = "0" ;
	
	$mapquest = "http://www.mapquest.com/maps/map.adp?latlongtype=decimal&latitude={$ns[0]}.{$ns[1]}&longitude={$ew[0]}.{$ew[1]}&zoom={$zoom}" ;
	$mapquest = "<a href=\"{$mapquest}\">Mapquest</a>" ;
	
	
	$wgOut->addHTML( "{$mapquest}" ) ;
/*	
	if( $wgRequest->getVal( 'action' ) == 'submit') {
		$page = $wgRequest->getText( 'pages' );
		$curonly = $wgRequest->getCheck( 'curonly' );
	} else {
		# Pre-check the 'current version only' box in the UI
		$curonly = true;
	}
	
	if( $page != "" ) {
		header( "Content-type: application/xml; charset=utf-8" );
		$pages = explode( "\n", $page );
		$xml = pages2xml( $pages, $curonly );
		echo $xml;
		wfAbruptExit();
	}
	
	$wgOut->addWikiText( wfMsg( "exporttext" ) );
	$titleObj = Title::makeTitle( NS_SPECIAL, "Export" );
	$action = $titleObj->escapeLocalURL();
	$wgOut->addHTML( "
<form method='post' action=\"$action\">
<input type='hidden' name='action' value='submit' />
<textarea name='pages' cols='40' rows='10'></textarea><br />
<label><input type='checkbox' name='curonly' value='true' checked='checked' />
" . wfMsg( "exportcuronly" ) . "</label><br />
<input type='submit' />
</form>
" );
*/
}


# This bit used to be in the Parser object. If used, it needs to be
# run as a hook somehow.

	/**
	 * Return an HTML link for the "GEO ..." text
	 * @access private
	 */
	function magicGEO( $text ) {
		global $wgLang, $wgUseGeoMode;
		$fname = 'Parser::magicGEO';
		wfProfileIn( $fname );

		# These next five lines are only for the ~35000 U.S. Census Rambot pages...
		$directions = array ( 'N' => 'North' , 'S' => 'South' , 'E' => 'East' , 'W' => 'West' ) ;
		$text = preg_replace ( "/(\d+)&deg;(\d+)'(\d+)\" {$directions['N']}, (\d+)&deg;(\d+)'(\d+)\" {$directions['W']}/" , "(GEO +\$1.\$2.\$3:-\$4.\$5.\$6)" , $text ) ;
		$text = preg_replace ( "/(\d+)&deg;(\d+)'(\d+)\" {$directions['N']}, (\d+)&deg;(\d+)'(\d+)\" {$directions['E']}/" , "(GEO +\$1.\$2.\$3:+\$4.\$5.\$6)" , $text ) ;
		$text = preg_replace ( "/(\d+)&deg;(\d+)'(\d+)\" {$directions['S']}, (\d+)&deg;(\d+)'(\d+)\" {$directions['W']}/" , "(GEO +\$1.\$2.\$3:-\$4.\$5.\$6)" , $text ) ;
		$text = preg_replace ( "/(\d+)&deg;(\d+)'(\d+)\" {$directions['S']}, (\d+)&deg;(\d+)'(\d+)\" {$directions['E']}/" , "(GEO +\$1.\$2.\$3:+\$4.\$5.\$6)" , $text ) ;

		$a = split( 'GEO ', ' '.$text );
		if ( count ( $a ) < 2 ) {
			wfProfileOut( $fname );
			return $text;
		}
		$text = substr( array_shift( $a ), 1);
		$valid = '0123456789.+-:';

		foreach ( $a as $x ) {
			$geo = $blank = '' ;
			while ( ' ' == $x{0} ) {
				$blank .= ' ';
				$x = substr( $x, 1 );
			}
			while ( strstr( $valid, $x{0} ) != false ) {
				$geo .= $x{0};
				$x = substr( $x, 1 );
			}
			$num = str_replace( '+', '', $geo );
			$num = str_replace( ' ', '', $num );

			if ( '' == $num || count ( explode ( ':' , $num , 3 ) ) < 2 ) {
				$text .= "GEO $blank$x";
			} else {
				$titleObj = Title::makeTitle( NS_SPECIAL, 'Geo' );
				$text .= '<a href="' .
				$titleObj->escapeLocalUrl( 'coordinates='.$num ) .
					"\" class=\"internal\">GEO $geo</a>";
				$text .= $x;
			}
		}
		wfProfileOut( $fname );
		return $text;
	}



