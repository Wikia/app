<?php

/**
 * Class for handling the display_point(s) parser functions with OpenLayers
 *
 * @file Maps_OpenLayersDispPoint.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class MapsOpenLayersDispPoint extends MapsBasePointMap {
	
	public $serviceName = MapsOpenLayersUtils::SERVICE_NAME;	
	
	/**
	 * @see MapsBaseMap::setMapSettings()
	 *
	 */	
	protected function setMapSettings() {
		global $egMapsOpenLayersZoom, $egMapsOpenLayersPrefix;
		
		$this->defaultParams = MapsOpenLayersUtils::getDefaultParams();
		
		$this->elementNamePrefix = $egMapsOpenLayersPrefix;
		$this->defaultZoom = $egMapsOpenLayersZoom;
	}
	
	/**
	 * @see MapsBaseMap::doMapServiceLoad()
	 *
	 */		
	protected function doMapServiceLoad() {
		global $egOpenLayersOnThisPage;
		
		MapsOpenLayersUtils::addOLDependencies($this->output);
		$egOpenLayersOnThisPage++;
		
		$this->elementNr = $egOpenLayersOnThisPage;
	}	
	
	/**
	 * @see MapsBaseMap::addSpecificMapHTML()
	 *
	 */	
	public function addSpecificMapHTML() {
		global $wgJsMimeType;
		
		$controlItems = MapsOpenLayersUtils::createControlsString($this->controls);
		
		MapsMapper::enforceArrayValues($this->layers);
		$layerItems = MapsOpenLayersUtils::createLayersStringAndLoadDependencies($this->output, $this->layers);
		
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
			$markerItems[] = "getOLMarkerData($lon, $lat, '$title', '$label', '$icon')";
		}		
		
		$markersString = implode(',', $markerItems);		
		
		$this->output .= "<div id='$this->mapName' style='width: {$this->width}px; height: {$this->height}px; background-color: #cccccc;'></div>
		<script type='$wgJsMimeType'> /*<![CDATA[*/
			addOnloadHook(
				initOpenLayer('$this->mapName', $this->centre_lon, $this->centre_lat, $this->zoom, [$layerItems], [$controlItems],[$markersString], $this->height)
			);
		/*]]>*/ </script>";
	}

}