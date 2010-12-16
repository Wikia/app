<?php
/**
 * A query printer for maps using the Google Maps API
 *
 * @file SM_GoogleMaps.php
 * @ingroup SMGoogleMaps
 *
 * @author Robert Buzink
 * @author Yaron Koren
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

final class SMGoogleMapsQP extends SMMapPrinter {
	
	public $serviceName = MapsGoogleMaps::SERVICE_NAME;
	
	protected $spesificParameters;
	
	/**
	 * @see SMMapPrinter::setQueryPrinterSettings()
	 *
	 */
	protected function setQueryPrinterSettings() {
		global $egMapsGoogleMapsZoom, $egMapsGoogleMapsPrefix, $egMapsGMapOverlays;
		
		$this->elementNamePrefix = $egMapsGoogleMapsPrefix;

		$this->defaultZoom = $egMapsGoogleMapsZoom;
		
		$this->spesificParameters = array(
			'overlays' => array(
				'type' => array('string', 'list'),
				'criteria' => array(
					'is_google_overlay' => array()
					),	
				'default' => $egMapsGMapOverlays,	
				),
		);			
	}	
	
	/**
	 * @see SMMapPrinter::doMapServiceLoad()
	 *
	 */
	protected function doMapServiceLoad() {
		global $egGoogleMapsOnThisPage;

		if (empty($egGoogleMapsOnThisPage)) {
			$egGoogleMapsOnThisPage = 0;
			MapsGoogleMaps::addGMapDependencies($this->output);
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

		$onloadFunctions = MapsGoogleMaps::addOverlayOutput($this->output, $this->mapName, $this->overlays, $this->controls);
		
		$markerItems = array();
		
		foreach ($this->m_locations as $location) {
			list($lat, $lon, $title, $label, $icon) = $location;
			
			$title = str_replace("'", "\'", $title);
			$label = str_replace("'", "\'", $label);
			
			$markerItems[] = "getGMarkerData($lat, $lon, '$title', '$label', '$icon')";
		}
		
		// Create a string containing the marker JS 
		$markersString = implode(',', $markerItems);		
		
		$this->output .= <<<END
<div id="$this->mapName" class="$this->class" style="$this->style" ></div>
<script type="$wgJsMimeType"> /*<![CDATA[*/
addOnloadHook(
	initializeGoogleMap('$this->mapName', 
		{
		width: $this->width,
		height: $this->height,
		lat: $this->centre_lat,
		lon: $this->centre_lon,
		zoom: $this->zoom,
		type: $this->type,
		types: [$this->types],
		controls: [$this->controls],
		scrollWheelZoom: $this->autozoom
		},
		[$markersString]	
	)
);
/*]]>*/ </script>

END;
	
		$this->output .= $onloadFunctions;	
	}
	
	/**
	 * Returns type info, descriptions and allowed values for this QP's parameters after adding the spesific ones to the list.
	 */
    public function getParameters() {
        $params = parent::getParameters();
        
        $allowedTypes = MapsGoogleMaps::getTypeNames();
        
        $params[] = array('name' => 'controls', 'type' => 'enum-list', 'description' => wfMsg('semanticmaps_paramdesc_controls'), 'values' => MapsGoogleMaps::getControlNames());
        $params[] = array('name' => 'types', 'type' => 'enum-list', 'description' => wfMsg('semanticmaps_paramdesc_types'), 'values' => $allowedTypes);
        $params[] = array('name' => 'type', 'type' => 'enumeration', 'description' => wfMsg('semanticmaps_paramdesc_type'), 'values' => $allowedTypes);
        $params[] = array('name' => 'overlays', 'type' => 'enum-list', 'description' => wfMsg('semanticmaps_paramdesc_overlays'), 'values' => MapsGoogleMaps::getOverlayNames());
        $params[] = array('name' => 'autozoom', 'type' => 'enumeration', 'description' => wfMsg('semanticmaps_paramdesc_autozoom'), 'values' => array('on', 'off'));
        
        return $params;
    }
	
}

