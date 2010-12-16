<?php
/**
 * A query printer for maps using the Yahoo Maps API
 *
 * @file SM_YahooMaps.php
 * @ingroup SMYahooMaps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

final class SMYahooMapsQP extends SMMapPrinter {

	public $serviceName = MapsYahooMaps::SERVICE_NAME;
	
	/**
	 * @see SMMapPrinter::setQueryPrinterSettings()
	 *
	 */
	protected function setQueryPrinterSettings() {
		global $egMapsYahooMapsZoom, $egMapsYahooMapsPrefix;
		
		$this->elementNamePrefix = $egMapsYahooMapsPrefix;
		
		$this->defaultZoom = $egMapsYahooMapsZoom;				
	}
	
	/**
	 * @see SMMapPrinter::doMapServiceLoad()
	 *
	 */
	protected function doMapServiceLoad() {
		global $egYahooMapsOnThisPage;
		
		MapsYahooMaps::addYMapDependencies($this->output);	
		$egYahooMapsOnThisPage++;
		
		$this->elementNr = $egYahooMapsOnThisPage;		
	}
	
	/**
	 * @see SMMapPrinter::addSpecificMapHTML()
	 *
	 */
	protected function addSpecificMapHTML() {
		global $wgJsMimeType;
		
		$markerItems = array();
		
		foreach ($this->m_locations as $location) {
			// Create a string containing the marker JS 
			list($lat, $lon, $title, $label, $icon) = $location;
			
			$title = str_replace("'", "\'", $title);
			$label = str_replace("'", "\'", $label);
			
			$markerItems[] = "getYMarkerData($lat, $lon, '$title', '$label', '$icon')";
		}
		
		$markersString = implode(',', $markerItems);	
		
		$this->output .= "
		<div id='$this->mapName' style='width: {$this->width}px; height: {$this->height}px;'></div>  
		
		<script type='$wgJsMimeType'>/*<![CDATA[*/
		addOnloadHook(
			initializeYahooMap('$this->mapName', $this->centre_lat, $this->centre_lon, $this->zoom, $this->type, [$this->types], [$this->controls], $this->autozoom, [$markersString], $this->height)
		);
			/*]]>*/</script>";		

	}	

	/**
	 * Returns type info, descriptions and allowed values for this QP's parameters after adding the spesific ones to the list.
	 */	
    public function getParameters() {
        $params = parent::getParameters();
        
        $allowedTypes = MapsYahooMaps::getTypeNames();
        
        $params[] = array('name' => 'controls', 'type' => 'enum-list', 'description' => wfMsg('semanticmaps_paramdesc_controls'), 'values' => MapsYahooMaps::getControlNames());
        $params[] = array('name' => 'types', 'type' => 'enum-list', 'description' => wfMsg('semanticmaps_paramdesc_types'), 'values' => $allowedTypes);
        $params[] = array('name' => 'type', 'type' => 'enumeration', 'description' => wfMsg('semanticmaps_paramdesc_type'), 'values' => $allowedTypes);
        $params[] = array('name' => 'autozoom', 'type' => 'enumeration', 'description' => wfMsg('semanticmaps_paramdesc_autozoom'), 'values' => array('on', 'off'));
        
        return $params;
    }	
	
}