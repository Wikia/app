<?php

/**
 * A class that holds static helper functions and extension hooks for the Google Maps service
 *
 * @file SM_GoogleMapsFormInput.php
 * @ingroup SMGoogleMaps
 * 
 * @author Robert Buzink
 * @author Yaron Koren
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

final class SMGoogleMapsFormInput extends SMFormInput {

	public $serviceName = MapsGoogleMaps::SERVICE_NAME;
	
	/**
	 * @see MapsMapFeature::setMapSettings()
	 *
	 */
	protected function setMapSettings() {
		global $egMapsGoogleMapsZoom, $egMapsGoogleMapsPrefix;
		
		$this->elementNamePrefix = $egMapsGoogleMapsPrefix;
		$this->showAddresFunction = 'showGAddress';	

		$this->earthZoom = 1;
		
        $this->defaultZoom = $egMapsGoogleMapsZoom;	        
	}
	
	/**
	 * (non-PHPdoc)
	 * @see smw/extensions/SemanticMaps/FormInputs/SMFormInput#addFormDependencies()
	 */
	protected function addFormDependencies() {
		global $wgJsMimeType;
		global $smgScriptPath, $smgGoogleFormsOnThisPage, $smgStyleVersion;
		
		MapsGoogleMaps::addGMapDependencies($this->output);
		
		if (empty($smgGoogleFormsOnThisPage)) {
			$smgGoogleFormsOnThisPage = 0;
			$this->output .= "<script type='$wgJsMimeType' src='$smgScriptPath/GoogleMaps/SM_GoogleMapsFunctions.js?$smgStyleVersion'></script>";
		}
	}
	
	/**
	 * @see MapsMapFeature::doMapServiceLoad()
	 *
	 */
	protected function doMapServiceLoad() {
		global $egGoogleMapsOnThisPage, $smgGoogleFormsOnThisPage;
		
		self::addFormDependencies();
		
		$egGoogleMapsOnThisPage++;
		$smgGoogleFormsOnThisPage++;	
		
		$this->elementNr = $egGoogleMapsOnThisPage;
	}
	
	/**
	 * @see MapsMapFeature::addSpecificFormInputHTML()
	 *
	 */
	protected function addSpecificMapHTML() {
		global $wgJsMimeType;
		
		// Remove the overlays control in case it's present.
		if (in_string('overlays', $this->controls)) {
			$this->controls = str_replace(",'overlays'", '', $this->controls);
			$this->controls = str_replace("'overlays',", '', $this->controls);
		}
		
		$this->output .= "
		<div id='".$this->mapName."' class='".$this->class."'></div>
	
		<script type='$wgJsMimeType'>/*<![CDATA[*/
		addOnloadHook(
			makeGoogleMapFormInput(
				'$this->mapName', 
				'$this->coordsFieldName',
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
				$this->marker_lat,
				$this->marker_lon	
			)			
		);
		/*]]>*/</script>";			
	}
	
	/**
	 * @see SMFormInput::manageGeocoding()
	 *
	 */
	protected function manageGeocoding() {
		global $egGoogleMapsKey;
		$this->enableGeocoding = strlen(trim($egGoogleMapsKey)) > 0;
		if ($this->enableGeocoding) MapsGoogleMaps::addGMapDependencies($this->output);		
	}	
	
}
