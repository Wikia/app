<?php

/**
 * Class for handling the display_map parser function with Yahoo! Maps
 *
 * @file Maps_YahooMapsDispMap.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class MapsYahooMapsDispMap extends MapsBaseMap {
	
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

		$this->types = explode(",", $this->types);
		
		$typesString = MapsYahooMapsUtils::createTypesString($this->types);		
		
		$this->output .= <<<END
		<div id="$this->mapName" style="width: {$this->width}px; height: {$this->height}px;"></div>  
		
		<script type="$wgJsMimeType">/*<![CDATA[*/
		addOnloadHook(
			initializeYahooMap('$this->mapName', $this->centre_lat, $this->centre_lon, $this->zoom, $this->type, [$typesString], [$this->controls], $this->autozoom, [])
		);
			/*]]>*/</script>
END;
	}

}
