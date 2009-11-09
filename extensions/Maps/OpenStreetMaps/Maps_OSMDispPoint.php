<?php

/**
 * Class for handling the display_point(s) parser functions with OSM.
 *
 * @file Maps_OSMDispPoint.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class MapsOSMDispPoint extends MapsBasePointMap {
	
	public $serviceName = MapsOSMUtils::SERVICE_NAME;	
	
	/**
	 * @see MapsBaseMap::setMapSettings()
	 *
	 */	
	protected function setMapSettings() {
		global $egMapsOSMZoom, $egMapsOSMPrefix;
		
		$this->defaultParams = MapsOSMUtils::getDefaultParams();
		
		$this->elementNamePrefix = $egMapsOSMPrefix;
		$this->defaultZoom = $egMapsOSMZoom;
	}
	
	/**
	 * @see MapsBaseMap::doMapServiceLoad()
	 *
	 */		
	protected function doMapServiceLoad() {
		global $egOSMMapsOnThisPage;
		
		MapsOSMUtils::addOSMDependencies($this->output);
		$egOSMMapsOnThisPage++;
		
		$this->elementNr = $egOSMMapsOnThisPage;
	}	
	
	/**
	 * @see MapsBaseMap::addSpecificMapHTML()
	 *
	 */	
	public function addSpecificMapHTML() {
		global $wgJsMimeType;
		
		$markerItems = array();		
		
		// TODO: Refactor up
		foreach ($this->markerData as $markerData) {
			$lat = $markerData['lat'];
			$lon = $markerData['lon'];
			
			$title = array_key_exists('title', $markerData) ? $markerData['title'] : $this->title;
			$label = array_key_exists('label', $markerData) ? $markerData['label'] : $this->label;	
			
			$title = str_replace("'", "\'", $title);
			$label = str_replace("'", "\'", $label);				

			$icon = array_key_exists('icon', $markerData) ? $markerData['icon'] : '';
			$markerItems[] = "getOSMMarkerData($lon, $lat, '$title', '$label', '$icon')";
		}		
		
		$markersString = implode(',', $markerItems);		
		
		$controlItems = MapsOSMUtils::createControlsString($this->controls);
		
		$this->output .= <<<EOT
			<script type='$wgJsMimeType'>slippymaps['$this->mapName'] = new slippymap_map('$this->mapName', {
				mode: 'osm-wm',
				layer: 'osm-like',
				locale: 'en',				
				lat: $this->centre_lat,
				lon: $this->centre_lon,
				zoom: $this->zoom,
				width: $this->width,
				height: $this->height,
				markers: [$markersString],
				controls: [$controlItems]
				
			});</script>
		
				<!-- map div -->
				<div id='$this->mapName' class='map' style='width:{$this->width}px; height:{$this->height}px;'>
					<script type='$wgJsMimeType'>slippymaps['$this->mapName'].init();</script>
				<!-- /map div -->
				</div>
EOT;
	}

}