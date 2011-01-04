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
 * @author Jeroen De Dauw
 */
class MapsGeocode extends ParserHook {
	
	/**
	 * No LST in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 */
	public static function staticMagic( array &$magicWords, $langCode ) {
		$className = __CLASS__;
		$instance = new $className();
		return $instance->magic( $magicWords, $langCode );
	}
	
	/**
	 * No LST in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 */	
	public static function staticInit( Parser &$wgParser ) {
		$className = __CLASS__;
		$instance = new $className();
		return $instance->init( $wgParser );
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
		global $egMapsAvailableServices, $egMapsAvailableGeoServices, $egMapsAvailableCoordNotations;
		global $egMapsDefaultServices, $egMapsDefaultGeoService, $egMapsCoordinateNotation;
		global $egMapsAllowCoordsGeocoding, $egMapsCoordinateDirectional;
		
		$params = array();
		
		$params['location'] = new Parameter( 'location' );
		$params['location']->addDependencies( 'mappingservice', 'geoservice' );
		$params['location']->addCriteria( new CriterionIsLocation() );	
		
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
		
		$params['allowcoordinates'] = new Parameter(
			'allowcoordinates', 
			Parameter::TYPE_BOOLEAN,
			$egMapsAllowCoordsGeocoding
		);
		
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
		
		$params['directional'] = new Parameter(
			'directional',
			Parameter::TYPE_BOOLEAN,
			$egMapsCoordinateDirectional			
		);		
		
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
	
}