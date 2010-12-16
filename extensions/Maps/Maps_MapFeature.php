<?php

/**
 * File holding class MapsMapFeature.
 *
 * @file Maps_MapFeature.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * MapsMapFeature bundles base functionallity for all general mapping feature classes.
 * 
 * @ingroup Maps
 * 
 * @author Jeroen De Dauw
 */
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

	protected $defaultZoom;
	
	protected $elementNr;
	protected $elementNamePrefix;
	
	protected $mapName;
	
	protected $centre_lat;
	protected $centre_lon;

	protected $output = '';	
	protected $errorList;	
	
	protected $featureParameters = array();
	protected $spesificParameters = array();
	
	/**
	 * Validates and corrects the provided map properties, and the sets them as class fields.
	 * 
	 * @param array $mapProperties
	 * @param string $className 
	 * 
	 * @return boolean Indicates whether the map should be shown or not.
	 */
	protected final function manageMapProperties(array $mapProperties, $className) {
		global $egMapsServices;
		
		/*
		 * Assembliy of the allowed parameters and their information. 
		 * The main parameters (the ones that are shared by everything) are overidden
		 * by the feature parameters (the ones spesific to a feature). The result is then
		 * again overidden by the service parameters (the ones spesific to the service),
		 * and finally by the spesific parameters (the ones spesific to a service-feature combination).
		 */
		$parameterInfo = array_merge(MapsMapper::getMainParams(), $this->featureParameters);
		$parameterInfo = array_merge($parameterInfo, $egMapsServices[$this->serviceName]['parameters']);
		$parameterInfo = array_merge($parameterInfo, $this->spesificParameters);
		
		$manager = new ValidatorManager();
		
		$result = $manager->manageMapparameters($mapProperties, $parameterInfo);
		
		$showMap = $result !== false;
		
		if ($showMap) $this->setMapProperties($result, $className);
		
		$this->errorList = $manager->getErrorList();
		
		return $showMap;
	}
	
	/**
	 * Sets the map properties as class fields.
	 * 
	 * @param array $mapProperties
	 * @param string $className
	 */
	private function setMapProperties(array $mapProperties, $className) {
		foreach($mapProperties as $paramName => $paramValue) {
			if (! property_exists($className, $paramName)) {
				$this->{$paramName} = $paramValue;
			}
			else {
				throw new Exception('Attempt to override a class field during map property assignment. Field name: ' . $paramName);
			}
		}		
	}
	
	/**
	 * Sets the $mapName field, using the $elementNamePrefix and $elementNr.
	 */
	protected function setMapName() {
		$this->mapName = $this->elementNamePrefix . '_' . $this->elementNr;
	}
	
}