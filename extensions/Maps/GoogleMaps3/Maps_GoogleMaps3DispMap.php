<?php

/**
 * Class for handling the display_map parser function with Google Maps v3.
 *
 * @file Maps_GoogleMaps3DispMap.php
 * @ingroup MapsGoogleMaps3
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * Class for handling the display_map parser functions with Google Maps v3.
 *
 * @ingroup MapsGoogleMaps3
 *
 * @author Jeroen De Dauw
 */
final class MapsGoogleMaps3DispMap extends MapsBaseMap {
	
	public $serviceName = MapsGoogleMaps3::SERVICE_NAME;

	/**
	 * @see MapsBaseMap::setMapSettings()
	 *
	 */	
	protected function setMapSettings() {
		global $egMapsGMaps3Zoom, $egMapsGMaps3Prefix;
		
		$this->elementNamePrefix = $egMapsGMaps3Prefix;
		$this->defaultZoom = $egMapsGMaps3Zoom;
		
		$this->spesificParameters = array(			
		);
	}
	
	/**
	 * @see MapsBaseMap::doMapServiceLoad()
	 *
	 */
	protected function doMapServiceLoad() {
		global $egGMaps3OnThisPage;
		
		MapsGoogleMaps3::addGMap3Dependencies($this->output);
		$egGMaps3OnThisPage++;
		
		$this->elementNr = $egGMaps3OnThisPage;
	}
	
	/**
	 * @see MapsBaseMap::addSpecificMapHTML()
	 *
	 */
	public function addSpecificMapHTML() {
		global $wgJsMimeType;
		
		$this->output .=<<<END
<div id="$this->mapName" style="width:{$this->width}px; height:{$this->height}px"></div>
<script type="$wgJsMimeType"> /*<![CDATA[*/
addOnloadHook(
	initGMap3("$this->mapName", {
			zoom: $this->zoom,
			lat: $this->centre_lat,
			lon: $this->centre_lon,	
			types: [],
			mapTypeId: $this->type
		},
		[]
	)
);
/*]]>*/ </script>
END;
		
	}
	
}

