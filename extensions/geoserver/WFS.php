<?php
/*
 *  Copyright 2007, Jens Frank <jeluf@wikimedia.org>
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
        echo "Geoserver extension\n";
        exit( 1 ) ;
}


class WFS {

	function WFS( $url ) {
		$this->url = $url;
	}

	function save( $name, $displaytitle, $major, $minor, $lat, $lon, $population ) {
		$body = '
		<wfs:Insert>
		  <topp:wikipedia>
		    <topp:title>'.$name.'</topp:title>
		    <topp:type_major>'.$major.'</topp:type_major>
		    <topp:type_minor>'.$minor.'</topp:type_minor>
		    <topp:displaytitle>'.$displaytitle.'</topp:displaytitle>
		    <topp:population>'.$population.'</topp:population>
		    <topp:geom>
		      <gml:Point srsName="http://www.opengis.net/gml/srs/epsg.xml#4326">
		        <gml:coordinates decimal="." cs="," ts=" ">'."$lon,$lat".'</gml:coordinates>
		      </gml:Point>
		    </topp:geom>
		  </topp:wikipedia>
		</wfs:Insert>';
		$this->transaction( $body );
	}

	function delete( $name ) {
		$body = '
		  <wfs:Delete typeName="topp:wikipedia">
		    <ogc:Filter>
		      <ogc:PropertyIsEqualTo>
			<ogc:PropertyName>topp:title</ogc:PropertyName>
			<ogc:Literal>'.$name.'</ogc:Literal>
		      </ogc:PropertyIsEqualTo>
		    </ogc:Filter>
		  </wfs:Delete>';
		$this->transaction( $body );
	}

	function update( $name, $displaytitle, $major, $minor, $lat, $lon, $population ) {
		$this->delete( $name );
		$this->save( $name, $displaytitle, $major, $minor, $lat, $lon, $population );
	}
	
	
	private function transaction( $body ) {
		global $wgWFSHost, $wgWFSPort, $wgWFSPath;
		$result="";
		$request='<wfs:Transaction service="WFS" version="1.0.0"
		  xmlns:wfs="http://www.opengis.net/wfs"
		  xmlns:topp="http://www.openplans.org/topp"
		  xmlns:gml="http://www.opengis.net/gml"
		  xmlns:ogc="http://www.opengis.net/ogc"
		  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		  xsi:schemaLocation="http://www.opengis.net/wfs http://schemas.opengis.net/wfs/1.0.0/WFS-transaction.xsd http://www.openplans.org/topp http://localhost:8080/geoserver/wfs/DescribeFeatureType?typename=topp:wikipedia">'.$body.'
		</wfs:Transaction>';
		$fp = fsockopen($wgWFSHost, $wgWFSPort, $errno, $errstr, 3);
		# TODO Check return code.

		fwrite( $fp, "POST {$wgWFSPath} HTTP/1.0\r\nContent-Type: text/xml\r\nContent-Length: ".
			     strlen( $request )."\r\n\r\n".$request );
		while (!feof($fp)) {
			$result .= fgets($fp, 1024);
		}
		fclose( $fp );
		# TODO Check return code.
		return $result;
	}
}

?>
