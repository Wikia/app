<?php

/**
 * Class for Google Maps v2 form inputs.
 * 
 * @file SM_GoogleMapsFormInput.php
 * @ingroup SMGoogleMaps
 * 
 * @author Jeroen De Dauw
 * @author Robert Buzink
 * @author Yaron Koren
 */
class SMGoogleMapsFormInput extends SMFormInput {

	/**
	 * @see SMFormInput::getEarthZoom
	 * 
	 * @since 0.6.5
	 */
	protected function getEarthZoom() {
		return 1;
	}	
	
	/**
	 * @see SMFormInput::getShowAddressFunction
	 * 
	 * @since 0.6.5
	 */	
	protected function getShowAddressFunction() {
		global $egGoogleMapsKey;
		return $egGoogleMapsKey == '' ? false : 'showGAddress';	
	}
	
	/**
	 * @see smw/extensions/SemanticMaps/FormInputs/SMFormInput#addFormDependencies()
	 */
	protected function addFormDependencies() {
		global $wgOut;
		global $smgScriptPath, $smgStyleVersion;

		$this->service->addDependency( Html::linkedScript( "$smgScriptPath/includes/services/GoogleMaps/SM_GoogleMapsForms.js?$smgStyleVersion" ) );
		$this->service->addDependencies( $wgOut );
	}
	
	/**
	 * @see MapsMapFeature::addSpecificFormInputHTML
	 */
	public function addSpecificMapHTML() {
		$mapName = $this->service->getMapId( false );
		
		// Remove the overlays control in case it's present.
		// TODO: make less insane
		if ( in_string( 'overlays', $this->controls ) ) {
			$this->controls = str_replace( array( ",'overlays'", "'overlays'," ), '', $this->controls );
		}
		
		$this->output .= Html::element(
			'div',
			array(
				'id' => $mapName,
				'style' => "width: $this->width; height: $this->height; background-color: #cccccc; overflow: hidden;",
			),
			wfMsg( 'maps-loading-map' )
		);
		
		MapsMapper::addInlineScript( $this->service, <<<EOT
		makeGoogleMapFormInput(
			"$mapName", 
			"$this->coordsFieldName",
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
			{$this->markerCoords['lat']},
			{$this->markerCoords['lon']}	
		);
EOT
		);
	}

}