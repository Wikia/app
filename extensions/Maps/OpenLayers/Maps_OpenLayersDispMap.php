<?php

/**
 * Class for handling the display_map parser function with OpenLayers
 *
 * @file Maps_OpenLayersDispMap.php
 * @ingroup MapsOpenLayers
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class MapsOpenLayersDispMap extends MapsBaseMap {
	
	public $serviceName = MapsOpenLayers::SERVICE_NAME;	
	
	/**
	 * @see MapsBaseMap::setMapSettings()
	 *
	 */	
	protected function setMapSettings() {
		global $egMapsOpenLayersZoom, $egMapsOpenLayersPrefix;
		
		$this->elementNamePrefix = $egMapsOpenLayersPrefix;
		$this->defaultZoom = $egMapsOpenLayersZoom;	
	}
	
	/**
	 * @see MapsBaseMap::doMapServiceLoad()
	 *
	 */		
	protected function doMapServiceLoad() {
		global $egOpenLayersOnThisPage;
		
		MapsOpenLayers::addOLDependencies($this->output);
		$egOpenLayersOnThisPage++;
		
		$this->elementNr = $egOpenLayersOnThisPage;
	}	
	
	/**
	 * @see MapsBaseMap::addSpecificMapHTML()
	 *
	 */	
	public function addSpecificMapHTML() {
		global $wgJsMimeType;
		
		$layerItems = MapsOpenLayers::createLayersStringAndLoadDependencies($this->output, $this->layers);
		
		$this->output .= "<div id='$this->mapName' style='width: {$this->width}px; height: {$this->height}px; background-color: #cccccc;'></div>
		<script type='$wgJsMimeType'> /*<![CDATA[*/
			addOnloadHook(
				initOpenLayer('$this->mapName', $this->centre_lon, $this->centre_lat, $this->zoom, [$layerItems], [$this->controls],[], $this->height)
			);
		/*]]>*/ </script>";
	}

}