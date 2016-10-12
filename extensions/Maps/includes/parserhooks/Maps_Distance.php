<?php

/**
 * Class for the 'distance' parser hooks, 
 * which can transform the notation of a distance.
 * 
 * @since 0.7
 * 
 * @file Maps_Distance.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsDistance extends ParserHook {
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
		return 'distance';
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
		global $egMapsDistanceUnit, $egMapsDistanceDecimals; 
		
		$params = array();
		
		$params['distance'] = new Parameter( 'distance' );
		$params['distance']->addCriteria( new CriterionIsDistance() );
		$params['distance']->setMessage( 'maps-distance-par-distance' );
		
		$params['unit'] = new Parameter(
			'unit',
			Parameter::TYPE_STRING,
			$egMapsDistanceUnit,
			array(),
			array(
				new CriterionInArray( MapsDistanceParser::getUnits() ),
			)
		);
		$params['unit']->setMessage( 'maps-distance-par-unit' );

		$params['decimals'] = new Parameter(
			'decimals',
			Parameter::TYPE_INTEGER,
			$egMapsDistanceDecimals
		);
		$params['decimals']->setMessage( 'maps-distance-par-decimals' );
		
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
		return array( 'distance', 'unit', 'decimals' );
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
		$distanceInMeters = MapsDistanceParser::parseDistance( $parameters['distance'] );
		return MapsDistanceParser::formatDistance( $distanceInMeters, $parameters['unit'], $parameters['decimals'] );
	}

	/**
	 * @see ParserHook::getMessage()
	 * 
	 * @since 1.0
	 */
	public function getMessage() {
		return 'maps-distance-description';
	}		
	
}