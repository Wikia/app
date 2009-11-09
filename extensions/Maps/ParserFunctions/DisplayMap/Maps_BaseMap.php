<?php

/**
 * Abstract class MapsBaseMap provides the scafolding for classes handling display_map
 * calls for a spesific mapping service. It inherits from MapsMapFeature and therefore
 * forces inheriting classes to implement sereveral methods.
 *
 * @file Maps_BaseMap.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

abstract class MapsBaseMap extends MapsMapFeature {
	
	/**
	 * Handles the request from the parser hook by doing the work that's common for all
	 * mapping services, calling the specific methods and finally returning the resulting output.
	 *
	 * @param unknown_type $parser
	 * @param array $params
	 * 
	 * @return html
	 */
	public final function displayMap(&$parser, array $params) {			
		$this->setMapSettings();
		
		$coords = $this->manageMapProperties($params);
		
		$this->doMapServiceLoad();

		$this->setMapName();	
		
		$this->setZoom();
		
		$this->setCentre();
		
		$this->addSpecificMapHTML();			
		
		return $this->output;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see smw/extensions/Maps/MapsMapFeature#manageMapProperties($mapProperties, $className)
	 */
	protected function manageMapProperties($params) {
		parent::manageMapProperties($params, __CLASS__);
	}
	
	/**
	 * Sets the zoom level to the provided value. When no zoom is provided, set
	 * it to the default when there is only one location, or the best fitting soom when
	 * there are multiple locations.
	 *
	 */
	private function setZoom() {
		if (empty($this->zoom)) $this->zoom = $this->defaultZoom;			
	}	
	
	/**
	 * Sets the $centre_lat and $centre_lon fields.
	 */
	private function setCentre() {
		if (empty($this->coordinates)) { // If centre is not set, use the default latitude and longitutde.
			global $egMapsMapLat, $egMapsMapLon;
			$this->centre_lat = $egMapsMapLat;
			$this->centre_lon = $egMapsMapLon;	
		} 
		else { // If a centre value is set, geocode when needed and use it.
			$this->coordinates = MapsParserGeocoder::attemptToGeocode($this->coordinates, $this->geoservice, $this->serviceName);

			// If the centre is not false, it will be a valid coordinate, which can be used to set the  latitude and longitutde.
			if ($this->coordinates) {
				$this->coordinates = MapsUtils::getLatLon($this->coordinates);
				$this->centre_lat = $this->coordinates['lat'];
				$this->centre_lon = $this->coordinates['lon'];				
			}
			else { // If it's false, the coordinate was invalid, or geocoding failed. Either way, the default's should be used.
				$this->setCentreDefaults();
			}
		}
	}
	
}
