<?php

/**
 * Class for the 'coordinates' parser hooks, 
 * which can transform the notation of a set of coordinates.
 * 
 * @since 0.7
 * 
 * @file Maps_Coordinates.php
 * @ingroup Maps
 * 
 * @author Jeroen De Dauw
 */
class MapsCoordinates extends ParserHook {
	
	/**
	 * No LSB in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 */
	public static function staticMagic( array &$magicWords, $langCode ) {
		$instance = new self;
		return $instance->magic( $magicWords, $langCode );
	}
	
	/**
	 * No LSB in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 */	
	public static function staticInit( Parser &$parser ) {
		$instance = new self;
		return $instance->init( $parser );
	}	
	
	/**
	 * Gets the name of the parser hook.
	 * @see ParserHook::getName
	 * 
	 * @since 0.7
	 * 
	 * @return string
	 */
	protected function getName() {
		return 'coordinates';
	}
	
	/**
	 * Returns an array containing the parameter info.
	 * @see ParserHook::getParameterInfo
	 * 
	 * @since 0.7
	 * 
	 * @return array
	 */
	protected function getParameterInfo( $type ) {
		global $egMapsAvailableServices, $egMapsAvailableCoordNotations;
		global $egMapsDefaultServices, $egMapsDefaultGeoService, $egMapsCoordinateNotation;
		global $egMapsAllowCoordsGeocoding, $egMapsCoordinateDirectional;
		
		$params = array();
		
		$params['location'] = new Parameter(
			'location',
			Parameter::TYPE_STRING,
			null,
			array(),
			array(
				new CriterionIsLocation(),
			)	
		);
		$params['location']->setMessage( 'maps-coordinates-par-location' );
		
		$params['format'] = new Parameter(
			'format',
			Parameter::TYPE_STRING,
			$egMapsCoordinateNotation,
			array( 'notation' ),
			array(
				new CriterionInArray( $egMapsAvailableCoordNotations ),
			)			
		);	
		$params['format']->addManipulations( new ParamManipulationFunctions( 'strtolower' ) );
		$params['format']->setMessage( 'maps-coordinates-par-format' );
		
		$params['directional'] = new Parameter(
			'directional',
			Parameter::TYPE_BOOLEAN,
			$egMapsCoordinateDirectional			
		);
		$params['directional']->setMessage( 'maps-coordinates-par-directional' );
		
		return $params;
	}
	
	/**
	 * Returns the list of default parameters.
	 * @see ParserHook::getDefaultParameters
	 * 
	 * @since 0.7
	 * 
	 * @return array
	 */
	protected function getDefaultParameters( $type ) {
		return array( 'location', 'format', 'directional' );
	}
	
	/**
	 * Renders and returns the output.
	 * @see ParserHook::render
	 * 
	 * @since 0.7
	 * 
	 * @param array $parameters
	 * 
	 * @return string
	 */
	public function render( array $parameters ) {
		$parsedCoords = MapsCoordinateParser::parseCoordinates( $parameters['location'] );
		
		if ( $parsedCoords ) {
			$output = MapsCoordinateParser::formatCoordinates( $parsedCoords, $parameters['format'], $parameters['directional'] );
		} else {
			// The coordinates should be valid when this method gets called.
			throw new Exception( 'Attempt to format an invalid set of coordinates' );
		}
		
		return $output;		
	}
	
	/**
	 * @see ParserHook::getMessage()
	 * 
	 * @since 1.0
	 */
	public function getMessage() {
		return 'maps-coordinates-description';
	}	
	
}