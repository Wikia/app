<?php

/**
 * Abstract class MapsBasePointMap provides the scafolding for classes handling display_point(s)
 * calls for a specific mapping service. It inherits from MapsMapFeature and therefore forces
 * inheriting classes to implement sereveral methods.
 *
 * @file Maps_BasePointMap.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */
abstract class MapsBasePointMap {
	
	/**
	 * @var iMappingService
	 */
	protected $service;
	
	protected $centreLat, $centreLon;
	protected $markerJs;

	protected $output = '';
	
	protected $markerString;
	
	private $specificParameters = false;
	private $markerData = array();
	
	public function __construct( iMappingService $service ) {
		$this->service = $service;
	}
	
	/**
	 * Sets the map properties as class fields.
	 * 
	 * @param array $mapProperties
	 */
	protected function setMapProperties( array $mapProperties ) {
		foreach ( $mapProperties as $paramName => $paramValue ) {
			if ( !property_exists( __CLASS__, $paramName ) ) {
				$this-> { $paramName } = $paramValue;
			}
			else {
				// If this happens in any way, it could be a big vunerability, so throw an exception.
				throw new Exception( 'Attempt to override a class field during map property assignment. Field name: ' . $paramName );
			}
		}
	}
	
	/**
	 * Returns the specific parameters by first checking if they have been initialized yet,
	 * doing to work if this is not the case, and then returning them.
	 * 
	 * @return array
	 */
	public final function getSpecificParameterInfo() {
		if ( $this->specificParameters === false ) {
			$this->specificParameters = array();
			$this->initSpecificParamInfo( $this->specificParameters );
		}
		
		return $this->specificParameters;
	}
	
	/**
	 * Initializes the specific parameters.
	 * 
	 * Override this method to set parameters specific to a feature service comibination in
	 * the inheriting class.
	 */
	protected function initSpecificParamInfo( array &$parameters ) {
	}	
	
	/**
	 * Handles the request from the parser hook by doing the work that's common for all
	 * mapping services, calling the specific methods and finally returning the resulting output.
	 *
	 * @param array $params
	 * @param Parser $parser
	 * 
	 * @return html
	 */
	public final function getMapHtml( array $params, Parser $parser ) {
		$this->setMapProperties( $params );
		
		$this->setMarkerData();

		$this->setCentre();
		
		// TODO
		if ( count( $this->markerData ) <= 1 && $this->zoom == 'null' ) {
			$this->zoom = $this->service->getDefaultZoom();
		}
		
		$this->markerJs = $this->service->createMarkersJs( $this->markerData );
		
		$this->addSpecificMapHTML( $parser );
		
		global $wgTitle;
		if ( $wgTitle->getNamespace() == NS_SPECIAL ) {
			global $wgOut;
			$this->service->addDependencies( $wgOut );
		}
		else {
			$this->service->addDependencies( $parser );			
		}
		
		return $this->output;
	}
	
	/**
	 * Fills the $markerData array with the locations and their meta data.
	 */
	private function setMarkerData() {
		global $wgTitle;
		
		// New parser object to render popup contents with.
		$parser = new Parser();			
		
		$this->title = $parser->parse( $this->title, $wgTitle, new ParserOptions() )->getText();
		$this->label = $parser->parse( $this->label, $wgTitle, new ParserOptions() )->getText();
		
		// Each $args is an array containg the coordinate set as first element, possibly followed by meta data. 
		foreach ( $this->coordinates as $args ) {
			$markerData = MapsCoordinateParser::parseCoordinates( array_shift( $args ) );

			if ( !$markerData ) continue;
			
			$markerData = array( $markerData['lat'], $markerData['lon'] );
			
			if ( count( $args ) > 0 ) {
				// Parse and add the point specific title if it's present.
				$markerData['title'] = $parser->parse( $args[0], $wgTitle, new ParserOptions() )->getText();
				
				if ( count( $args ) > 1 ) {
					// Parse and add the point specific label if it's present.
					$markerData['label'] = $parser->parse( $args[1], $wgTitle, new ParserOptions() )->getText();
					
					if ( count( $args ) > 2 ) {
						// Add the point specific icon if it's present.
						$markerData['icon'] = $args[2];
					}
				}
			}
			
			// If there is no point specific icon, use the general icon parameter when available.
			if ( !array_key_exists( 'icon', $markerData ) ) {
				$markerData['icon'] = $this->icon;
			}
			
			if ( $markerData['icon'] != '' ) {
				$markerData['icon'] = MapsMapper::getImageUrl( $markerData['icon'] );
			}
			
			// Temporary fix, will refactor away later
			// TODO
			$markerData = array_values( $markerData );
			if ( count( $markerData ) < 5 ) {
				if ( count( $markerData ) < 4 ) {
					$markerData[] = '';
				}				
				$markerData[] = '';
			} 
			
			$this->markerData[] = $markerData;
		}
		
	}

	/**
	 * Sets the $centre_lat and $centre_lon fields.
	 * Note: this needs to be done AFTRE the maker coordinates are set.
	 */
	protected function setCentre() {
		global $egMapsDefaultMapCentre;
		
		if ( $this->centre === false ) {
			if ( count( $this->markerData ) == 1 ) {
				// If centre is not set and there is exactly one marker, use its coordinates.
				$this->centreLat = Xml::escapeJsString( $this->markerData[0][0] );
				$this->centreLon = Xml::escapeJsString( $this->markerData[0][1] );				
			}
			elseif ( count( $this->markerData ) > 1 ) {
				// If centre is not set and there are multiple markers, set the values to null,
				// to be auto determined by the JS of the mapping API.
				$this->centreLat = 'null';
				$this->centreLon = 'null';
			}
			else  {
				$this->setCentreToDefault();
			}
			
		}
		else { // If a centre value is set, geocode when needed and use it.
			$this->centre = MapsGeocoders::attemptToGeocode( $this->centre, $this->geoservice, $this->service->getName() );
			
			// If the centre is not false, it will be a valid coordinate, which can be used to set the latitude and longitutde.
			if ( $this->centre ) {
				$this->centreLat = Xml::escapeJsString( $this->centre['lat'] );
				$this->centreLon = Xml::escapeJsString( $this->centre['lon'] );
			}
			else { // If it's false, the coordinate was invalid, or geocoding failed. Either way, the default's should be used.
				$this->setCentreToDefault();
			}
		}

	}
	
	/**
	 * Attempts to set the centreLat and centreLon fields to the Maps default.
	 * When this fails (aka the default is not valid), an exception is thrown.
	 * 
	 * @since 0.7
	 */
	protected function setCentreToDefault() {
		global $egMapsDefaultMapCentre;
		
		$centre = MapsGeocoders::attemptToGeocode( $egMapsDefaultMapCentre, $this->geoservice, $this->service->getName() );
		
		if ( $centre === false ) {
			throw new Exception( 'Failed to parse the default centre for the map. Please check the value of $egMapsDefaultMapCentre.' );
		}
		else {
			$this->centreLat = Xml::escapeJsString( $centre['lat'] );
			$this->centreLon = Xml::escapeJsString( $centre['lon'] );			
		}
	}
	
}