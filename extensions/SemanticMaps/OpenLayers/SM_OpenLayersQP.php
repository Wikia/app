<?php

/**
 * A query printer for maps using the Open Layers API
 *
 * @file SM_OpenLayersQP.php 
 * @ingroup SMOpenLayers
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

final class SMOpenLayersQP extends SMMapPrinter {

	public $serviceName = MapsOpenLayers::SERVICE_NAME;	
	
	/**
	 * @see SMMapPrinter::setQueryPrinterSettings()
	 *
	 */
	protected function setQueryPrinterSettings() {
		global $egMapsOpenLayersZoom, $egMapsOpenLayersPrefix;
		
		$this->elementNamePrefix = $egMapsOpenLayersPrefix;
		$this->defaultZoom = $egMapsOpenLayersZoom;		
	}	

	/**
	 * @see SMMapPrinter::doMapServiceLoad()
	 *
	 */
	protected function doMapServiceLoad() {
		global $egOpenLayersOnThisPage;
		
		MapsOpenLayers::addOLDependencies($this->output);
		$egOpenLayersOnThisPage++;
		
		$this->elementNr = $egOpenLayersOnThisPage;		
	}
	
	/**
	 * @see SMMapPrinter::addSpecificMapHTML()
	 *
	 */
	protected function addSpecificMapHTML() {
		global $wgJsMimeType;

		$layerItems = MapsOpenLayers::createLayersStringAndLoadDependencies($this->output, $this->layers);

		$markerItems = array();
		
		foreach ($this->m_locations as $location) {
			// Create a string containing the marker JS 
			list($lat, $lon, $title, $label, $icon) = $location;

			$title = str_replace("'", "\'", $title);
			$label = str_replace("'", "\'", $label);

			$markerItems[] = "getOLMarkerData($lon, $lat, '$title', '$label', '$icon')";
		}

		$markersString = implode(',', $markerItems);		

		$this->output .= "<div id='$this->mapName' style='width: {$this->width}px; height: {$this->height}px; background-color: #cccccc;'></div>
		<script type='$wgJsMimeType'> /*<![CDATA[*/
			addOnloadHook(
				initOpenLayer('$this->mapName', $this->centre_lon, $this->centre_lat, $this->zoom, [$layerItems], [$this->controls], [$markersString], $this->height)
			);
		/*]]>*/ </script>";		
	}

	/**
	 * Returns type info, descriptions and allowed values for this QP's parameters after adding the spesific ones to the list.
	 */	
    public function getParameters() {
        $params = parent::getParameters();
        
        $params[] = array('name' => 'controls', 'type' => 'enum-list', 'description' => wfMsg('semanticmaps_paramdesc_controls'), 'values' => MapsOpenLayers::getControlNames());
        $params[] = array('name' => 'layers', 'type' => 'enum-list', 'description' => wfMsg('semanticmaps_paramdesc_layers'), 'values' => MapsOpenLayers::getLayerNames());
        
        return $params;
    }	
	
}
