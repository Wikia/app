<?php

/**
 * Abstract class MapsBasePointMap provides the scafolding for classes handling display_point(s)
 * and display_address(es) calls for a spesific mapping service. It inherits from MapsMapFeature and therefore
 * forces inheriting classes to implement sereveral methods.
 *
 * @file Maps_BasePointMap.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

abstract class MapsBasePointMap extends MapsMapFeature {
	
	protected $markerData = array();
	
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
		
		$this->setCoordinates($parser);		
		
		$this->setZoom();
		
		$this->setCentre();
		
		$this->doParsing($parser);
		
		$this->doEscaping();
		
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
		if (strlen($this->zoom) < 1) {
			if (count($this->markerData) > 1) {
		        $this->zoom = 'null';
		    }
		    else {
		        $this->zoom = $this->defaultZoom;
		    }
		}				
	}	
	
	/**
	 * Fills the $markerData array with the locations and their meta data.
	 *
	 * @param unknown_type $parser
	 */
	private function setCoordinates($parser) {
		$this->coordinates = explode(';', $this->coordinates);		
		
		foreach($this->coordinates as $coordinates) {
			$args = explode('~', $coordinates);
			
			$args[0] = str_replace('″', '"', $args[0]);
			$args[0] = str_replace('′', "'", $args[0]);			
			
			$markerData = MapsUtils::getLatLon($args[0]);
			
			if (count($args) > 1) {
				$markerData['title'] = $parser->recursiveTagParse( $args[1] );
				
				if (count($args) > 2) {
					$markerData['label'] = $parser->recursiveTagParse( $args[2] );
					
					if (count($args) > 3) {
						$markerData['icon'] = $args[3];
					}					
				}
			}

			$this->markerData[] = $markerData;
		}
	}
	
	/**
	 * Sets the $centre_lat and $centre_lon fields.
	 * Note: this needs to be done AFTRE the maker coordinates are set.
	 */
	private function setCentre() {
		if (empty($this->centre)) {
			if (count($this->markerData) == 1) {
				// If centre is not set and there is exactelly one marker, use it's coordinates.
				$this->centre_lat = $this->markerData[0]['lat'];
				$this->centre_lon = $this->markerData[0]['lon'];
			}
			elseif (count($this->markerData) > 1) {
				// If centre is not set and there are multiple markers, set the values to null,
				// to be auto determined by the JS of the mapping API.
				$this->centre_lat = 'null';
				$this->centre_lon = 'null';
			}
			else {
				// If centre is not set and there are no markers, use the default latitude and longitutde.
				$this->setCentreDefaults();
			}
		}
		else { // If a centre value is set, geocode when needed and use it.
			$this->centre = MapsParserGeocoder::attemptToGeocode($this->centre, $this->geoservice, $this->serviceName);
			
			// If the centre is not false, it will be a valid coordinate, which can be used to set the latitude and longitutde.
			if ($this->centre) {
				$this->centre = MapsUtils::getLatLon($this->centre);
				$this->centre_lat = $this->centre['lat'];
				$this->centre_lon = $this->centre['lon'];				
			}
			else { // If it's false, the coordinate was invalid, or geocoding failed. Either way, the default's should be used.
				$this->setCentreDefaults();
			}
		}
	}
	
	/**
	 * Sets the centre latitude and longitutde to the defaults.
	 */
	private function setCentreDefaults() {
		global $egMapsMapLat, $egMapsMapLon;
		$this->centre_lat = $egMapsMapLat;
		$this->centre_lon = $egMapsMapLon;		
	}

	/**
	 * Parse the wiki text in the title and label values.
	 * 
	 * @param unknown_type $parser
	 */
	private function doParsing(&$parser) {
		$this->title = $parser->recursiveTagParse( $this->title );
		$this->label = $parser->recursiveTagParse( $this->label );
	}
	
	/**
	 * Escape the title and label text
	 */
	private function doEscaping() {
		$this->title = str_replace("'", "\'", $this->title);
		$this->label = str_replace("'", "\'", $this->label);		
	}
	
}
