<?php
/**
 * A query printer for maps using the Yahoo Maps API
 *
 * @file SM_YahooMaps.php
 * @ingroup SemanticMaps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

final class SMYahooMaps extends SMMapPrinter {

	public $serviceName = MapsYahooMaps::SERVICE_NAME;
	
	/**
	 * @see SMMapPrinter::setQueryPrinterSettings()
	 *
	 */
	protected function setQueryPrinterSettings() {
		global $egMapsYahooMapsZoom, $egMapsYahooMapsPrefix;
		
		$this->elementNamePrefix = $egMapsYahooMapsPrefix;
		
		$this->defaultZoom = $egMapsYahooMapsZoom;	

		$this->defaultParams = MapsYahooMapsUtils::getDefaultParams();
	}
	
	/**
	 * @see SMMapPrinter::doMapServiceLoad()
	 *
	 */
	protected function doMapServiceLoad() {
		global $egYahooMapsOnThisPage;
		
		MapsYahooMapsUtils::addYMapDependencies($this->output);	
		$egYahooMapsOnThisPage++;
		
		$this->elementNr = $egYahooMapsOnThisPage;		
	}
	
	/**
	 * @see SMMapPrinter::addSpecificMapHTML()
	 *
	 */
	protected function addSpecificMapHTML() {
		global $wgJsMimeType;
		
		$this->type = MapsYahooMapsUtils::getYMapType($this->type, true);
		$this->controls = MapsYahooMapsUtils::createControlsString($this->controls);
		
		MapsUtils::makePxValue($this->width);
		MapsUtils::makePxValue($this->height);		
		
		$this->autozoom = MapsYahooMapsUtils::getAutozoomJSValue($this->autozoom);
		
		$markerItems = array();
		
		foreach ($this->m_locations as $location) {
			// Create a string containing the marker JS 
			list($lat, $lon, $title, $label, $icon) = $location;
			
			$title = str_replace("'", "\'", $title);
			$label = str_replace("'", "\'", $label);
			
			$markerItems[] = "getYMarkerData($lat, $lon, '$title', '$label', '$icon')";
		}
		
		$markersString = implode(',', $markerItems);

		$this->types = explode(",", $this->types);
		
		$typesString = MapsYahooMapsUtils::createTypesString($this->types);			
		
		$this->output .= "
		<div id='$this->mapName' style='width: $this->width; height: $this->height;'></div>  
		
		<script type='$wgJsMimeType'>/*<![CDATA[*/
		addLoadEvent(
			initializeYahooMap('$this->mapName', $this->centre_lat, $this->centre_lon, $this->zoom, $this->type, [$typesString], [$this->controls], $this->autozoom, [$markersString])
		);
			/*]]>*/</script>";		

	}	

}