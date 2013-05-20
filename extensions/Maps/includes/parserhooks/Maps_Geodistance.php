<?php

/**
 * Class for the 'geodistance' parser hooks, which can
 * calculate the geographical distance between two points.
 * 
 * @since 0.7
 * 
 * @file Maps_Geodistance.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsGeodistance extends ParserHook {
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
		return 'geodistance';
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
		global $egMapsDistanceUnit, $egMapsDistanceDecimals, $egMapsAvailableGeoServices, $egMapsDefaultGeoService; 
		
		$params = array();
		
		$params['location1'] = new Parameter(
			'location1',
			Parameter::TYPE_STRING,
			null,
			array( 'from' ),
			array(
				new CriterionIsLocation(),
			)			
		);
		$params['location1']->addDependencies( 'mappingservice', 'geoservice' );
		$params['location1']->setMessage( 'maps-geodistance-par-location1' );
		
		$params['location2'] = new Parameter(
			'location2',
			Parameter::TYPE_STRING,
			null,
			array( 'to' ),
			array(
				new CriterionIsLocation(),
			)			
		);
		$params['location2']->addDependencies( 'mappingservice', 'geoservice' );			
		$params['location2']->setMessage( 'maps-geodistance-par-location2' );
		
		$params['unit'] = new Parameter(
			'unit',
			Parameter::TYPE_STRING,
			$egMapsDistanceUnit,
			array(),
			array(
				new CriterionInArray( MapsDistanceParser::getUnits() ),
			)
		);
		$params['unit']->addManipulations( new ParamManipulationFunctions( 'strtolower' ) );
		$params['unit']->setMessage( 'maps-geodistance-par-unit' );
		
		$params['decimals'] = new Parameter(
			'decimals',
			Parameter::TYPE_INTEGER,
			$egMapsDistanceDecimals
		);			
		$params['decimals']->setMessage( 'maps-geodistance-par-decimals' );
		
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
		$params['mappingservice']->setMessage( 'maps-geodistance-par-mappingservice' );
		
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
		$params['geoservice']->setMessage( 'maps-geodistance-par-geoservice' );
		
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
		return array( 'location1', 'location2', 'unit', 'decimals' );
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
		if ( MapsGeocoders::canGeocode() ) {
			$start = MapsGeocoders::attemptToGeocode( $parameters['location1'], $parameters['geoservice'], $parameters['mappingservice'] );
			$end = MapsGeocoders::attemptToGeocode( $parameters['location2'], $parameters['geoservice'], $parameters['mappingservice'] );
		} else {
			$start = MapsCoordinateParser::parseCoordinates( $parameters['location1'] );
			$end = MapsCoordinateParser::parseCoordinates( $parameters['location2'] );
		}
		
		if ( $start && $end ) {
			$output = MapsDistanceParser::formatDistance( MapsGeoFunctions::calculateDistance( $start, $end ), $parameters['unit'], $parameters['decimals'] );
		} else {
			// The locations should be valid when this method gets called.
			throw new MWException( 'Attempt to find the distance between locations of at least one is invalid' );
		}

		return $output;
	}

	/**
	 * @see ParserHook::getMessage()
	 * 
	 * @since 1.0
	 */
	public function getMessage() {
		return 'maps-geodistance-description';
	}	
	
}