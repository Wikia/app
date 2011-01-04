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
 * @author Jeroen De Dauw
 */
class MapsDistance extends ParserHook {
	
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
		
		$params['unit'] = new Parameter(
			'unit',
			Parameter::TYPE_STRING,
			$egMapsDistanceUnit,
			array(),
			array(
				new CriterionInArray( MapsDistanceParser::getUnits() ),
			)
		);	

		$params['decimals'] = new Parameter(
			'decimals',
			Parameter::TYPE_INTEGER,
			$egMapsDistanceDecimals
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
	
}