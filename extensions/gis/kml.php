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

$wgRequestTime = microtime();

$wgGisVersion = '0.5alpha';

include_once ( "gissettings.php" ) ;

if ( isset ( $wikibasedir ) )
	{
	define( "MEDIAWIKI", true );

	require_once( "{$wikibasedir}/includes/Defines.php" );
	require_once( "{$wikibasedir}/LocalSettings.php" );
	require_once( "{$wikibasedir}/includes/Setup.php" );
	require_once( "geo.php" );
	}
	
require_once( "mapsources.php");
require_once( "neighbors.php");
require_once( "maparea.php");
require_once( "gisversion.php");

global $wgRequest;
header( 'Content-type: application/vnd.google-earth.kml+xml' );

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<kml xmlns="http://earth.google.com/kml/2.0">';

if ( $wgRequest->getVal('BBOX', '') ==  '' ) {
	$title = $wgRequest->getVal( 'title','' );
	$coords = $wgRequest->getVal( 'coords','0,0' );
?>
	<Folder>
  	<description>Wikipedia</description>
    		<name>Wikipedia</name>
      		<visibility>1</visibility>
        	<open>1</open>
		<Placemark><description>YADDAYADDAYADDA at wikipedia</description>
			<name><?php echo $title;?></name>
			<visibility>1</visibility>
		  	<flyToView>1</flyToView>
			<Point><coordinates><?php echo $coords;?>,0</coordinates></Point>
		</Placemark>
	    	<NetworkLink>
	          	<description>The view-based refresh allows the remote server to calculate the center of your screen and return a placemark.</description>
		  	<name>View Placemark</name>
		  	<visibility>1</visibility>
		  	<open>0</open>
		  	<refreshVisibility>1</refreshVisibility>
		  	<Url>
		  		<href>http://mediawiki.mormo.org/ext/extensions/gis/kml.php</href>
		  		<refreshInverval>2</refreshInverval>
		  		<viewRefreshMode>onStop</viewRefreshMode>
		  		<viewRefreshTime>1</viewRefreshTime>
		  	</Url>
	  	</NetworkLink>
  	</Folder>
	</kml>
	<?php
	exit( 0 );
} else {
	// split the client's BBOX return by commas and spaces to obtain an array of coordinates
	print "<Folder><name>de.wikipedia</name><open>1</open>\n";
	$coords = preg_split('/,|\s/', $wgRequest->getVal( 'BBOX', '0,0,0,0' ) );

	// for clarity, place each coordinate into a clearly marked bottom_left or top_right variable
	$bl_lon = $coords[0];
	$bl_lat = $coords[1];
	$tr_lon = $coords[2];
	$tr_lat = $coords[3];

	$geodb = new GisDatabase();
	$geodb->select_area( $bl_lat, $bl_lon, $tr_lat, $tr_lon );
	while (($place = $geodb->fetch_position())) {
		$nt = Title::makeTitle( $place->page_namespace, $place->page_title );

	        echo '<Placemark>';
        	echo '<name>'.$nt->getText().'</name>'."\n";
        	echo '<description><![CDATA[ Read more about this on <a href="'.$nt->getFullUrl().'">Wikipedia</a>. ]]></description>'."\n";
        	echo '<styleUrl>root://styles#default</styleUrl><Style><IconStyle><Icon><href>root://icons/palette-4.png</href><x>160</x><y>160</y><w>32</w><h>32</h></Icon><scale>0.75</scale></IconStyle><LabelStyle><color>ffffffaa</color><scale>0.8</scale></LabelStyle></Style>';
        	echo '<Point>';
        	echo "<coordinates>{$place->gis_longitude_min},{$place->gis_latitude_min},0</coordinates>";
        	echo '</Point>'."\n";
        	echo '</Placemark>'."\n";
	}
	print "</Folder></kml>\n";
}

exit ( 0 ) ;

?>
