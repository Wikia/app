<?php

/**
 * Class for handling the display_point(s) parser functions with Yahoo! Maps
 *
 * @file Maps_YahooMapsDispPoint.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class MapsYahooMapsDispPoint extends MapsBasePointMap {
	
	public $serviceName = MapsYahooMapsUtils::SERVICE_NAME;		
	
	/**
	 * @see MapsBaseMap::setFormInputSettings()
	 *
	 */	
	protected function setMapSettings() {
		global $egMapsYahooMapsZoom, $egMapsYahooMapsPrefix;
		
		$this->defaultParams = MapsYahooMapsUtils::getDefaultParams();
		
		$this->elementNamePrefix = $egMapsYahooMapsPrefix;
		$this->defaultZoom = $egMapsYahooMapsZoom;
	}
	
	/**
	 * @see MapsBaseMap::doMapServiceLoad()
	 *
	 */		
	protected function doMapServiceLoad() {
		global $egYahooMapsOnThisPage;
		
		MapsYahooMapsUtils::addYMapDependencies($this->output);	
		$egYahooMapsOnThisPage++;
		
		$this->elementNr = $egYahooMapsOnThisPage;
	}	
	
	/**
	 * @see MapsBaseMap::addSpecificMapHTML()
	 *
	 */		
	public function addSpecificMapHTML() {
		global $wgJsMimeType;
		
		$this->type = MapsYahooMapsUtils::getYMapType($this->type, true);
		
		$this->controls = MapsYahooMapsUtils::createControlsString($this->controls);

		$this->autozoom = MapsYahooMapsUtils::getAutozoomJSValue($this->autozoom);
		
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
			$markerItems[] = "getYMarkerData($lat, $lon, '$title', '$label', '$icon')";
		}		
		
		$markersString = implode(',', $markerItems);

		$this->types = explode(",", $this->types);
		
		$typesString = MapsYahooMapsUtils::createTypesString($this->types);		
		
		$this->output .= <<<END
		<div id="$this->mapName" style="width: {$this->width}px; height: {$this->height}px;"></div>  
		
		<script type="$wgJsMimeType">/*<![CDATA[*/
		addOnloadHook(
			initializeYahooMap('$this->mapName', $this->centre_lat, $this->centre_lon, $this->zoom, $this->type, [$typesString], [$this->controls], $this->autozoom, [$markersString])
		);
			/*]]>*/</script>
END;
	}

}
