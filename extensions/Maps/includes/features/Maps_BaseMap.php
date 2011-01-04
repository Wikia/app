<?php

/**
 * Abstract class MapsBaseMap provides the scafolding for classes handling display_map
 * calls for a specific mapping service. It inherits from MapsMapFeature and therefore
 * forces inheriting classes to implement sereveral methods.
 *
 * @file Maps_BaseMap.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */
abstract class MapsBaseMap {
	
	/**
	 * @since 0.6.x
	 * 
	 * @var iMappingService
	 */	
	protected $service;

	/**
	 * @since 0.7.3
	 * 
	 * @var array
	 */
	protected $properties = array();
	
	/**
	 * Returns the HTML to display the map.
	 * 
	 * @since 0.7.3
	 * 
	 * @param array $params
	 * @param $parser
	 * 
	 * @return string
	 */
	protected abstract function getMapHTML( array $params, Parser $parser );
	
	/**
	 * Constructor.
	 * 
	 * @param MapsMappingService $service
	 */
	public function __construct( iMappingService $service ) {
		$this->service = $service;
	}
	
	/**
	 * @see 
	 * 
	 * @since 0.7.3
	 */	
	public function addParameterInfo( array &$params ) {
	}
	
	/**
	 * Handles the request from the parser hook by doing the work that's common for all
	 * mapping services, calling the specific methods and finally returning the resulting output.
	 *
	 * @since 0.7.3
	 *
	 * @param array $params
	 * @param Parser $parser
	 * 
	 * @return html
	 */
	public final function renderMap( array $params, Parser $parser ) {
		global $egMapsUseRL;
		
		$this->setCentre( $params );
		
		if ( $params['zoom'] == 'null' ) {
			$params['zoom'] = $this->service->getDefaultZoom();
		}
		
		$output = $this->getMapHTML( $params, $parser );
		
		if ( $egMapsUseRL ) {
			$output .= $this->getJSON( $params, $parser );
		}
		
		global $wgTitle;
		if ( $wgTitle->getNamespace() == NS_SPECIAL ) {
			global $wgOut;
			$this->service->addDependencies( $wgOut );
		}
		else {
			$this->service->addDependencies( $parser );			
		}
		
		return $output;
	}
	
	/**
	 * Returns the JSON with the maps data.
	 *
	 * @since 0.7.3
	 *
	 * @param array $params
	 * @param Parser $parser
	 * 
	 * @return string
	 */	
	protected function getJSON( array $params, Parser $parser ) {
		$object = $this->getJSONObject( $params, $parser );
		
		if ( $object === false ) {
			return '';
		}
		
		// TODO
		return Html::inlineScript( "maps=[]; maps['{$this->service->getName()}']=[]; maps['{$this->service->getName()}'].push(" . json_encode( $object ) . ')' );
	}
	
	/**
	 * Returns a PHP object to encode to JSON with the map data.
	 *
	 * @since 0.7.3
	 *
	 * @param array $params
	 * @param Parser $parser
	 * 
	 * @return mixed
	 */	
	protected function getJSONObject( array $params, Parser $parser ) {
		return $params;
	}
	
	/**
	 * Translates the coordinates field to the centre field and makes sure it's set to it's default when invalid. 
	 */
	protected function setCentre( array &$params ) {
		// If it's false, the coordinate was invalid, or geocoding failed. Either way, the default's should be used.
		if ( $params['coordinates'] === false ) {
			global $egMapsDefaultMapCentre;
		
			$centre = MapsGeocoders::attemptToGeocode( $egMapsDefaultMapCentre, $params['geoservice'], $this->service->getName() );
			
			if ( $centre === false ) {
				throw new Exception( 'Failed to parse the default centre for the map. Please check the value of $egMapsDefaultMapCentre.' );
			}
			else {
				$params['centre'] = $centre;
			}
		}
		else {
			$params['centre'] = MapsCoordinateParser::parseCoordinates( $params['coordinates'] );
		}
		
		unset( $params['coordinates'] );
	}
	
}