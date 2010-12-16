<?php

/**
 * File holding class MapsBasePointMap.
 * 
 * @file Maps_BasePointMap.php
 * @ingroup Maps
 * 
 * @author Jeroen De Dauw
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * Abstract class MapsBasePointMap provides the scafolding for classes handling display_point(s)
 * and display_address(es) calls for a spesific mapping service. It inherits from MapsMapFeature and therefore
 * forces inheriting classes to implement sereveral methods.
 *
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */
abstract class MapsBasePointMap extends MapsMapFeature implements iDisplayFunction {
	
	private $markerData = array();
	protected $markerStringFormat = '';
	protected $markerString;
	
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
		
		$this->featureParameters = MapsDisplayPoint::$parameters;
		
		if (parent::manageMapProperties($params, __CLASS__)) {
			$this->doMapServiceLoad();
	
			$this->setMapName();
			
			$this->setMarkerData($parser);	
	
			$this->createMarkerString();
			
			$this->setZoom();
			
			$this->setCentre();
			
			$this->addSpecificMapHTML();
		}	
		
		return $this->output . $this->errorList;
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
	private function setMarkerData($parser) {
		$this->coordinates = explode(';', $this->coordinates);		
		
		$this->title = Xml::escapeJsString( $parser->recursiveTagParse( $this->title ) );
		$this->label = Xml::escapeJsString( $parser->recursiveTagParse( $this->label ) );	
		
		foreach($this->coordinates as $coordinates) {
			$args = explode('~', $coordinates);
			
            $args[0] = str_replace('″', '"', $args[0]);
            $args[0] = str_replace('′', "'", $args[0]); 		
			
			$markerData = MapsUtils::getLatLon($args[0]);
			
			if (count($args) > 1) {
				// Parse and add the point specific title if it's present.
				$markerData['title'] = $parser->recursiveTagParse( $args[1] );
				
				if (count($args) > 2) {
					// Parse and add the point specific label if it's present.
					$markerData['label'] = $parser->recursiveTagParse( $args[2] );
					
					if (count($args) > 3) {
						// Add the point specific icon if it's present.
						$markerData['icon'] = $args[3];
					}
				}
			}
			
			// If there is no point specific icon, use the general icon parameter when available.
			if (! array_key_exists('icon', $markerData) && strlen($this->icon) > 0) $markerData['icon'] = $this->icon;
			
			// Get the url for the icon when there is one, else set the icon to an empty string.
			if (array_key_exists('icon', $markerData)) {
				$icon_image_page = new ImagePage( Title::newFromText( $markerData['icon'] ) );
				$markerData['icon'] = $icon_image_page->getDisplayedFile()->getURL();				
			}
			else {
				$markerData['icon'] = '';
			}
			
			$this->markerData[] = $markerData;
		}
	}
	
	/**
	 * Creates a JS string with the marker data. Takes care of escaping the used values.
	 */
	private function createMarkerString() {
		$markerItems = array();
		
		foreach ($this->markerData as $markerData) {
			$title = array_key_exists('title', $markerData) ? Xml::escapeJsString($markerData['title']) : $this->title;
			$label = array_key_exists('label', $markerData) ? Xml::escapeJsString($markerData['label']) : $this->label;	
			
			$markerData['lon'] = Xml::escapeJsString($markerData['lon']);
			$markerData['lat'] = Xml::escapeJsString($markerData['lat']);
			$markerData['icon'] = Xml::escapeJsString($markerData['icon']);
			
			$markerItems[] = str_replace(	array('lon', 'lat', 'title', 'label', 'icon'), 
											array($markerData['lon'], $markerData['lat'], $title, $label, $markerData['icon']), 
											$this->markerStringFormat
											);
		}
		
		$this->markerString = implode(',', $markerItems);		
	}

	/**
	 * Sets the $centre_lat and $centre_lon fields.
	 * Note: this needs to be done AFTRE the maker coordinates are set.
	 */
	private function setCentre() {
		if (empty($this->centre)) {
			if (count($this->markerData) == 1) {
				// If centre is not set and there is exactelly one marker, use it's coordinates.
				$this->centre_lat = Xml::escapeJsString( $this->markerData[0]['lat'] );
				$this->centre_lon = Xml::escapeJsString( $this->markerData[0]['lon'] );
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
			$this->centre = MapsGeocodeUtils::attemptToGeocode($this->centre, $this->geoservice, $this->serviceName);
			
			// If the centre is not false, it will be a valid coordinate, which can be used to set the latitude and longitutde.
			if ($this->centre) {
				$this->centre = MapsUtils::getLatLon($this->centre);
				$this->centre_lat = Xml::escapeJsString( $this->centre['lat'] );
				$this->centre_lon = Xml::escapeJsString( $this->centre['lon'] );				
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
}
