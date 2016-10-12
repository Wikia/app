<?php

/**
 * Class for the 'geocode' parser hooks, which can turn
 * human readable locations into sets of coordinates.
 * 
 * @since 0.7
 * 
 * @file Maps_Geocode.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsGeocode extends ParserHook {
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
		return 'geocode';
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
		global $egMapsAvailableGeoServices, $egMapsAvailableCoordNotations;
		global $egMapsDefaultGeoService, $egMapsCoordinateNotation;
		global $egMapsAllowCoordsGeocoding, $egMapsCoordinateDirectional;
		
		$params = array();
		
		$params['location'] = new Parameter( 'location' );
		$params['location']->addDependencies( 'mappingservice', 'geoservice' );
		$params['location']->addCriteria( new CriterionIsLocation() );	
		$params['location']->setMessage( 'maps-geocode-par-location' );
		
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
		$params['mappingservice']->setMessage( 'maps-geocode-par-mappingservice' );
		
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
		$params['geoservice']->setMessage( 'maps-geocode-par-geoservice' );
		
		$params['allowcoordinates'] = new Parameter(
			'allowcoordinates', 
			Parameter::TYPE_BOOLEAN,
			$egMapsAllowCoordsGeocoding
		);
		$params['allowcoordinates']->setMessage( 'maps-geocode-par-allowcoordinates' );
		
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
		$params['format']->setMessage( 'maps-geocode-par-format' );
		
		$params['directional'] = new Parameter(
			'directional',
			Parameter::TYPE_BOOLEAN,
			$egMapsCoordinateDirectional			
		);		
		$params['directional']->setMessage( 'maps-geocode-par-directional' );
		
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
		return array( 'location', 'geoservice', 'mappingservice' );
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
			$geovalues = MapsGeocoders::attemptToGeocodeToString(
				$parameters['location'],
				$parameters['geoservice'],
				$parameters['mappingservice'],
				$parameters['allowcoordinates'],
				$parameters['format'],
				$parameters['directional']
			);
			
			$output = $geovalues ? $geovalues : '';
		}
		else {
			$output = htmlspecialchars( wfMsg( 'maps-geocoder-not-available' ) );
		}

		return $output;		
	}

	/**
	 * @see ParserHook::getMessage()
	 * 
	 * @since 1.0
	 */
	public function getMessage() {
		return 'maps-geocode-description';
	}		
	
}