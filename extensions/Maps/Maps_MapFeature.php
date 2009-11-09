<?php

/**
 * MapsMapFeature bundles some base functionallity for all general mapping feature classes.
 *
 * @file Maps_MapFeature.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

abstract class MapsMapFeature {
	
	/**
	 * Set the map service specific element name and the javascript function handling the displaying of an address
	 */
	protected abstract function setMapSettings();
	
	/**
	 * Map service specific map count and loading of dependencies
	 */	
	protected abstract function doMapServiceLoad();
	
	/**
	 * Adds the HTML specific to the mapping service to the output
	 */	
	protected abstract function addSpecificMapHTML();
	
	public $serviceName;
	
	protected $defaultParams = array();
	
	protected $defaultZoom;
	
	protected $elementNr;
	protected $elementNamePrefix;
	
	protected $mapName;
	
	protected $centre_lat;
	protected $centre_lon;

	protected $output = '';	
	
	/**
	 * Sets the map properties as class fields.
	 */
	protected function manageMapProperties($mapProperties, $className) {
		global $egMapsServices;
		
		$mapProperties = MapsMapper::getValidParams($mapProperties, $egMapsServices[$this->serviceName]['parameters']);
		$mapProperties = MapsMapper::setDefaultParValues($mapProperties, $this->defaultParams);
		
		// Go through the array with map parameters and create new variables
		// with the name of the key and value of the item if they don't exist on class level yet.
		foreach($mapProperties as $paramName => $paramValue) {
			if (! property_exists($className, $paramName)) {
				$this->{$paramName} = $paramValue;
			}
		}
		
		MapsMapper::enforceArrayValues($this->controls);
		
		MapsUtils::makeMapSizeValid($this->width, $this->height);
	}	
	
	/**
	 * Sets the $mapName field, using the $elementNamePrefix and $elementNr.
	 */
	protected function setMapName() {
		$this->mapName = $this->elementNamePrefix.'_'.$this->elementNr;
	}
	
}