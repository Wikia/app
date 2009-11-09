<?php

/**
 * Form input hook that adds an Open Layers map format to Semantic Forms
 *
 * @file SM_OpenLayersFormInput.php
 * @ingroup SemanticMaps
 * 
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

final class SMOpenLayersFormInput extends SMFormInput {
	
	public $serviceName = MapsOpenLayersUtils::SERVICE_NAME;	
	
	/**
	 * @see MapsMapFeature::setMapSettings()
	 *
	 */
	protected function setMapSettings() {
		global $egMapsOpenLayersZoom, $egMapsOpenLayersPrefix;
		
		$this->elementNamePrefix = $egMapsOpenLayersPrefix;
		$this->showAddresFunction = 'showOLAddress';	

		$this->earthZoom = 1;

		$this->defaultParams = MapsOpenLayersUtils::getDefaultParams();
        $this->defaultZoom = $egMapsOpenLayersZoom;			
	}	
	
	/**
	 * @see MapsMapFeature::addFormDependencies()
	 * 	  
	 */
	protected function addFormDependencies() {
		global $wgJsMimeType;
		global $smgScriptPath, $smgOLFormsOnThisPage;
		
		MapsOpenLayersUtils::addOLDependencies($this->output);
		
		if (empty($smgOLFormsOnThisPage)) {
			$smgOLFormsOnThisPage = 0;
			$this->output .= "<script type='$wgJsMimeType' src='$smgScriptPath/OpenLayers/SM_OpenLayersFunctions.js'></script>";
		}
	}	
	
	/**
	 * @see MapsMapFeature::doMapServiceLoad()
	 *
	 */
	protected function doMapServiceLoad() {
		global $egOpenLayersOnThisPage, $smgOLFormsOnThisPage;
		
		self::addFormDependencies();
		
		$egOpenLayersOnThisPage++;	
		$smgOLFormsOnThisPage++;

		$this->elementNr = $egOpenLayersOnThisPage;
	}	
	
	/**
	 * @see MapsMapFeature::addSpecificMapHTML()
	 *
	 */
	protected function addSpecificMapHTML() {
		global $wgJsMimeType;
		
		$controlItems = MapsOpenLayersUtils::createControlsString($this->controls);
		
		$layerItems = MapsOpenLayersUtils::createLayersStringAndLoadDependencies($this->output, $this->layers);	
		
		$this->output .="
		<div id='".$this->mapName."' style='width: {$this->width}px; height: {$this->height}px; background-color: #cccccc;'></div>  
		
		<script type='$wgJsMimeType'>/*<![CDATA[*/
		addOnloadHook(makeFormInputOpenLayer('".$this->mapName."', '".$this->coordsFieldName."', ".$this->centre_lat.", ".$this->centre_lon.", ".$this->zoom.", ".$this->marker_lat.", ".$this->marker_lon.", [$layerItems], [$controlItems], $this->height));
		/*]]>*/</script>";			
	}
	
	/**
	 * @see SMFormInput::manageGeocoding()
	 *
	 */
	protected function manageGeocoding() {	
		$this->enableGeocoding = false;
	}
	
}
