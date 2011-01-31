<?php
/**
 * A query printer for maps using the Google Maps API.
 *
 * @file SM_GoogleMapsQP.php
 * @ingroup SMGoogleMaps
 *
 * @author Robert Buzink
 * @author Yaron Koren
 * @author Jeroen De Dauw
 */
class SMGoogleMapsQP extends SMMapPrinter {
	
	/**
	 * @see SMMapPrinter::getServiceName
	 */	
	protected function getServiceName() {
		return 'googlemaps2';
	}
	
	/**
	 * @see SMMapPrinter::initSpecificParamInfo
	 */
	protected function initSpecificParamInfo( array &$parameters ) {
	}
	
	/**
	 * @see SMMapPrinter::addSpecificMapHTML
	 */
	public function addSpecificMapHTML() {
		$mapName = $this->service->getMapId();	
		
		$this->service->addOverlayOutput( $this->output, $mapName, $this->overlays, $this->controls );
		
		$this->output .= Html::element(
			'div',
			array(
				'id' => $mapName,
				'style' => "width: $this->width; height: $this->height; background-color: #cccccc; overflow: hidden;",
			),
			wfMsg( 'maps-loading-map' )
		);
		
		MapsMapper::addInlineScript( $this->service, <<<EOT
		initializeGoogleMap("$mapName", 
			{
				lat: $this->centreLat,
				lon: $this->centreLon,
				zoom: $this->zoom,
				type: $this->type,
				types: [$this->types],
				controls: [$this->controls],
				scrollWheelZoom: $this->autozoom,
				kml: [$this->kml]
			},
			$this->markerJs	
		);
EOT
		);
	}
	
	/**
	 * Returns type info, descriptions and allowed values for this QP's parameters after adding the
	 * specific ones to the list.
	 * 
	 * @return array
	 */
    public function getParameters() {
        $params = parent::getParameters();
        
        $allowedTypes = array_keys( MapsGoogleMaps::$mapTypes );
        
        $params[] = array( 'name' => 'controls', 'type' => 'enum-list', 'description' => wfMsg( 'semanticmaps_paramdesc_controls' ), 'values' => MapsGoogleMaps::getControlNames() );
        $params[] = array( 'name' => 'types', 'type' => 'enum-list', 'description' => wfMsg( 'semanticmaps_paramdesc_types' ), 'values' => $allowedTypes );
        $params[] = array( 'name' => 'type', 'type' => 'enumeration', 'description' => wfMsg( 'semanticmaps_paramdesc_type' ), 'values' => $allowedTypes );
        $params[] = array( 'name' => 'overlays', 'type' => 'enum-list', 'description' => wfMsg( 'semanticmaps_paramdesc_overlays' ), 'values' => MapsGoogleMaps::getOverlayNames() );
        $params[] = array( 'name' => 'autozoom', 'type' => 'enumeration', 'description' => wfMsg( 'semanticmaps_paramdesc_autozoom' ), 'values' => array( 'on', 'off' ) );
        
        return $params;
    }
	
}