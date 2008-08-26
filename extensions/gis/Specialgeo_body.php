<?php
/*
 *  Support the "Map sources" list mechanism, see also:
 *  http://en.wikipedia.org/wiki/Wikipedia:WikiProject_Geographical_coordinates
 *
 *  This extension was designed to work together with the geo tag 
 *  extension (geo.php). It can be useful in its own right also, but
 *  class GeoParam from geo.php needs to be avalibale
 *
 *  To install, remember to tune the settings in "gissettings.php".
 *
 *  When installing geo.php, remember to set the $wgMapsourcesURL
 *  appropriately in LocalSettings.php
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

if ( !defined( 'MEDIAWIKI' ) ) {
        echo "GIS extension\n";
        exit( 1 );
}

# Add messages
global $wgMessageCache, $wgDesysopMessages;
// !JF1
/*
foreach( $wgDesysopMessages as $key => $value ) {
        $wgMessageCache->addMessages( $wgDesysopMessages[$key], $key );
}
*/
require_once('mapsources.php');

class GeoPage extends SpecialPage {
        function __construct() {
                parent::__construct( 'Geo', 'geo' );
        }

	function execute( $subpage ) {
		global $wgOut, $wgRequest, $wgCookiePrefix;
		$params = $wgRequest->getValues();

		$wgOut->addHTML( '<form><select name="subaction"><option>Map sources</option>
<option value="near" ' . ( $params['subaction'] == 'near' ? ' selected' : '' )  .'>Nearby places</option>
</select>' );
# <option value="maparea">Not yet sure what this is</option></select>' );
		if ( $params['subaction'] == 'near' ) {
			$wgOut->addHTML( '<select name="dist">' );
			if ( isset( $params['dist'] ) ) {
				$wgOut->addHTML( "<option value=\"{$params['dist']}\">{$params['dist']} km</option>" );
			}
			$distances = array(1000,100,10,1);
			foreach ( $distances as $d ) {
				$wgOut->addHTML( "<option value=\"{$d}\">{$d} km</option>" );
			}
			$wgOut->addHTML( '</select>' );
			unset( $params['dist'] );
		}
		unset( $params['subaction'] );
		unset( $params[$wgCookiePrefix.'_session'] );
		
		foreach ( $params as $key => $val ) {
			$wgOut->addHTML( "<input type=\"hidden\" name=\"$key\" value=\"$val\">\n" );
		}
		$wgOut->addHTML( "<input type=\"submit\" /></form>\n" );

		if ( $wgRequest->getVal( 'subaction' ) == 'near' ) {
			require_once('neighbors.php');
			$dist = $wgRequest->getVal( 'dist', 1000 );
			$bsl = new neighbors( $dist );
			$bsl->show();
		} elseif ( $wgRequest->getVal( 'subaction' ) == 'maparea' ) {
			require_once('maparea.php');
			$action = $wgRequest->getVal( 'action' );
			$bsl = new maparea();
			$bsl->show( $action );
		} else {
			$bsl = new map_sources();
			$bsl->show();
		}
	}
}
/*
global $wgRequest;

if ( isset ( $_GET['geo'] ) ) {
	$geo = $wgRequest->getVal( 'geo' );
	$title = $wgRequest->getVal( 'title' );
	$bsl = new map_sources( $geo, $title );
	$bsl->show();
} else if ( isset ( $_GET['near'] ) ) {
	$near = $wgRequest->getVal( 'near' );
	$dist = $wgRequest->getVal( 'dist' );
	$title = $wgRequest->getVal( 'title' ); 
	$bsl = new neighbors( $near, $dist, $title );
	$bsl->show();
} else if ( isset ( $_GET['maparea'] ) ) {
	$maparea = $wgRequest->getVal( 'maparea' );
	$action = $wgRequest->getVal( 'action' );
	$bsl = new maparea( $maparea );
	$bsl->show( $action );
} else if ( isset ( $_GET['version'] ) ) {
	$bsl = new gis_version( );
	$bsl->show();
}

*/

