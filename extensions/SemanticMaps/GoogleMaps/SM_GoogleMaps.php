<?php
/**
 * A query printer for maps using the Google Maps API
 *
 * @file SM_GoogleMaps.php
 * @ingroup SemanticMaps
 *
 * @author Robert Buzink
 * @author Yaron Koren
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

final class SMGoogleMaps extends SMMapPrinter {
	
	public $serviceName = MapsGoogleMaps::SERVICE_NAME;
	
	/**
	 * @see SMMapPrinter::setQueryPrinterSettings()
	 *
	 */
	protected function setQueryPrinterSettings() {
		global $egMapsGoogleMapsZoom, $egMapsGoogleMapsPrefix;
		
		$this->elementNamePrefix = $egMapsGoogleMapsPrefix;

		$this->defaultZoom = $egMapsGoogleMapsZoom;
		
		$this->defaultParams = MapsGoogleMapsUtils::getDefaultParams();
	}	
	
	/**
	 * @see SMMapPrinter::doMapServiceLoad()
	 *
	 */
	protected function doMapServiceLoad() {
		global $egGoogleMapsOnThisPage;

		if (empty($egGoogleMapsOnThisPage)) {
			$egGoogleMapsOnThisPage = 0;
			MapsGoogleMapsUtils::addGMapDependencies($this->output);
		}
		
		$egGoogleMapsOnThisPage++;	
		
		$this->elementNr = $egGoogleMapsOnThisPage;		
	}
	
	/**
	 * @see SMMapPrinter::getQueryResult()
	 *
	 */
	protected function addSpecificMapHTML() {
		global $wgJsMimeType;
				
		$enableEarth = MapsGoogleMapsUtils::getEarthValue($this->earth);
		
		// Get the Google Maps names for the control and map types
		$this->type = MapsGoogleMapsUtils::getGMapType($this->type, true);
		
		$this->controls = MapsGoogleMapsUtils::createControlsString($this->controls);

		$this->autozoom = MapsGoogleMapsUtils::getAutozoomJSValue($this->autozoom);
		
		$markerItems = array();
		
		foreach ($this->m_locations as $location) {
			list($lat, $lon, $title, $label, $icon) = $location;
			
			$title = str_replace("'", "\'", $title);
			$label = str_replace("'", "\'", $label);
			
			$markerItems[] = "getGMarkerData($lat, $lon, '$title', '$label', '$icon')";
		}
		
		// Create a string containing the marker JS 
		$markersString = implode(',', $markerItems);		
		
		$this->types = explode(",", $this->types);
		
		$typesString = MapsGoogleMapsUtils::createTypesString($this->types, $enableEarth);		
		
		$this->output .= <<<END
<div id="$this->mapName" class="$this->class" style="$this->style" ></div>
<script type="$wgJsMimeType"> /*<![CDATA[*/
addLoadEvent(
	initializeGoogleMap('$this->mapName', $this->width, $this->height, $this->centre_lat, $this->centre_lon, $this->zoom, $this->type, [$typesString], [$this->controls], $this->autozoom, [$markersString])
);
/*]]>*/ </script>

END;
	
	}
	

}

