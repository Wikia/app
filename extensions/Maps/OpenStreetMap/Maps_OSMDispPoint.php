<?php

/**
 * File holding the MapsOSMDispPoint class.
 *
 * @file Maps_OSMDispPoint.php
 * @ingroup MapsOpenStreetMap
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * Class for handling the display_point(s) parser functions with OSM.
 *
 * @author Jeroen De Dauw
 */
class MapsOSMDispPoint extends MapsBasePointMap {
	
	public $serviceName = MapsOSM::SERVICE_NAME;	
	
	/**
	 * @see MapsBaseMap::setMapSettings()
	 *
	 */	
	protected function setMapSettings() {
		global $egMapsOSMZoom, $egMapsOSMPrefix;
		
		$this->elementNamePrefix = $egMapsOSMPrefix;
		$this->defaultZoom = $egMapsOSMZoom;
		
		$this->markerStringFormat = 'getOSMMarkerData(lat, lon, \'title\', \'label\', "icon")';			
	}
	
	/**
	 * @see MapsBaseMap::doMapServiceLoad()
	 *
	 */		
	protected function doMapServiceLoad() {
		global $egOSMMapsOnThisPage;
		
		MapsOSM::addOSMDependencies($this->output);
		$egOSMMapsOnThisPage++;
		
		$this->elementNr = $egOSMMapsOnThisPage;
	}	
	
	/**
	 * @see MapsBaseMap::addSpecificMapHTML()
	 *
	 */	
	public function addSpecificMapHTML() {
		global $wgJsMimeType;	
		
		$this->output .= <<<EOT
			<script type='$wgJsMimeType'>slippymaps['$this->mapName'] = new slippymap_map('$this->mapName', {
				mode: 'osm-wm',
				layer: 'osm-like',
				locale: '$this->lang',				
				lat: $this->centre_lat,
				lon: $this->centre_lon,
				zoom: $this->zoom,
				width: $this->width,
				height: $this->height,
				markers: [$this->markerString],
				controls: [$this->controls]
			});</script>
		
				<!-- map div -->
				<div id='$this->mapName' class='map' style='width:{$this->width}px; height:{$this->height}px;'>
					<script type='$wgJsMimeType'>slippymaps['$this->mapName'].init();</script>
				<!-- /map div -->
				</div>
EOT;
	}

}