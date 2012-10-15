<?php

/**
 * Class for the 'finddestination' parser hooks, which can find a
 * destination given a starting point, an initial bearing and a distance.
 * 
 * @since 0.7
 * 
 * @file Maps_Finddestination.php
 * @ingroup Maps
 * 
 * @author Jeroen De Dauw
 */
class MapsFinddestination extends ParserHook {
	
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
		return 'finddestination';
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
		global $egMapsAvailableServices, $egMapsAvailableGeoServices, $egMapsDefaultGeoService, $egMapsAvailableCoordNotations;
		global $egMapsCoordinateNotation, $egMapsAllowCoordsGeocoding, $egMapsCoordinateDirectional;	 
		
		$params = array();
		
		$params['location'] = new Parameter( 'location' );
		$params['location']->addCriteria( new CriterionIsLocation() );
		$params['location']->addDependencies( 'mappingservice', 'geoservice' );
		$params['location']->setMessage( 'maps-finddestination-par-location' );
		
		$params['bearing'] = new Parameter(
			'bearing',
			Parameter::TYPE_FLOAT
		);
		$params['bearing']->setMessage( 'maps-finddestination-par-bearing' );
		
		$params['distance'] = new Parameter( 'distance' );
		$params['distance']->addCriteria( new CriterionIsDistance() );
		$params['distance']->setMessage( 'maps-finddestination-par-distance' );
		// TODO: manipulate to distance object
		
		$params['mappingservice'] = new Parameter(
			'mappingservice', 
			Parameter::TYPE_STRING,
			'', // TODO
			array(),
			array(
				new CriterionInArray( MapsMappingServices::getAllServiceValues() ),
			)
		);
		$params['mappingservice']->addManipulations( new ParamManipulationFunctions( 'strtolower' ) );
		$params['mappingservice']->setMessage( 'maps-finddestination-par-mappingservice' );
		
		$params['geoservice'] = new Parameter(
			'geoservice', 
			Parameter::TYPE_STRING,
			$egMapsDefaultGeoService,
			array( 'service' ),
			array(
				new CriterionInArray( $egMapsAvailableGeoServices ),
			)
		);
		$params['geoservice']->addManipulations( new ParamManipulationFunctions( 'strtolower' ) );
		$params['geoservice']->setMessage( 'maps-finddestination-par-geoservice' );
		
		$params['allowcoordinates'] = new Parameter(
			'allowcoordinates', 
			Parameter::TYPE_BOOLEAN,
			$egMapsAllowCoordsGeocoding
		);			
		$params['allowcoordinates']->setMessage( 'maps-finddestination-par-allowcoordinates' );
		
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
		$params['format']->setMessage( 'maps-finddestination-par-format' );
		
		$params['directional'] = new Parameter(
			'directional',
			Parameter::TYPE_BOOLEAN,
			$egMapsCoordinateDirectional
		);			
		$params['directional']->setMessage( 'maps-finddestination-par-directional' );
		
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
		return array( 'location', 'bearing', 'distance' );
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
		$canGeocode = MapsGeocoders::canGeocode();
			
		if ( $canGeocode ) {
			$location = MapsGeocoders::attemptToGeocode(
				$parameters['location'],
				$parameters['geoservice'],
				$parameters['mappingservice']
			);
		} else {
			$location = MapsCoordinateParser::parseCoordinates( $parameters['location'] );
		}
		
		// TODO
		if ( $location ) {
			$destination = MapsGeoFunctions::findDestination(
				$location,
				$parameters['bearing'],
				MapsDistanceParser::parseDistance( $parameters['distance'] )
			);
			$output = MapsCoordinateParser::formatCoordinates( $destination, $parameters['format'], $parameters['directional'] );
		} else {
			// The location should be valid when this method gets called.
			throw new Exception( 'Attempt to find a destination from an invalid location' );
		}
			
		return $output;
	}

	/**
	 * @see ParserHook::getMessage()
	 * 
	 * @since 1.0
	 */
	public function getMessage() {
		return 'maps-finddestination-description';
	}	
	
}