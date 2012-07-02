<?php

/**
 * Class for the 'display_point' parser hooks.
 * 
 * @since 0.7
 * 
 * @file Maps_DisplayPoint.php
 * @ingroup Maps
 * 
 * @author Jeroen De Dauw
 */
class MapsDisplayPoint extends ParserHook {
	
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
		return array( 'display_point', 'display_points' );
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
		global $egMapsMapWidth, $egMapsMapHeight, $egMapsDefaultServices, $egMapsDefaultTitle, $egMapsDefaultLabel, $egMapsDefaultMapCentre;
		
		$params = MapsMapper::getCommonParameters();
		
		$params['mappingservice']->setDefault( $egMapsDefaultServices['display_point'] );
		$params['mappingservice']->addManipulations( new MapsParamService( 'display_point' ) );
		$params['mappingservice']->setMessage( 'maps-displaypoints-par-mappingservice' );
		
		$params['zoom']->addDependencies( 'coordinates', 'mappingservice' );
		$params['zoom']->addManipulations( new MapsParamZoom() );
		$params['zoom']->setMessage( 'maps-displaypoints-par-zoom' );
		
		$params['coordinates'] = new ListParameter( 'coordinates', $type === ParserHook::TYPE_FUNCTION ? ';' : "\n" );
		$params['coordinates']->addAliases( 'coords', 'location', 'address', 'addresses', 'locations' );
		$params['coordinates']->addCriteria( new CriterionIsLocation( $type === ParserHook::TYPE_FUNCTION ? '~' : '|' ) );
		$params['coordinates']->addManipulations( new MapsParamLocation( $type === ParserHook::TYPE_FUNCTION ? '~' : '|' ) );		
		$params['coordinates']->addDependencies( 'mappingservice', 'geoservice' );
		$params['coordinates']->setMessage( 'maps-displaypoints-par-coordinates' );
		
		$params['centre'] = new Parameter( 'centre' );
		$params['centre']->setDefault( false );
		$params['centre']->addAliases( 'center' );
		$params['centre']->addCriteria( new CriterionIsLocation() );
		$params['centre']->setMessage( 'maps-displaypoints-par-centre' );
		$params['centre']->setDoManipulationOfDefault( false );
		$manipulation = new MapsParamLocation();
		$manipulation->toJSONObj = true;
		$params['centre']->addManipulations( $manipulation );
		
		$params['title'] = new Parameter(
			'title',
			Parameter::TYPE_STRING,
			$egMapsDefaultTitle
		);
		$params['title']->setMessage( 'maps-displaypoints-par-title' );
		
		$params['label'] = new Parameter(
			'label',
			Parameter::TYPE_STRING,
			$egMapsDefaultLabel,
			array( 'text' )
		);
		$params['label']->setMessage( 'maps-displaypoints-par-label' );
		
		$params['icon'] = new Parameter(
			'icon',
			Parameter::TYPE_STRING,
			'', // TODO
			array(),
			array(
				New CriterionNotEmpty()
			)
		);	
		$params['icon']->setMessage( 'maps-displaypoints-par-icon' );
		
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
		return array( 'coordinates' );
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
		// Get the instance of the service class. 
		$service = MapsMappingServices::getServiceInstance( $parameters['mappingservice'], $this->getName() );
		
		// Get an instance of the class handling the current parser hook and service. 
		$mapClass = $service->getFeatureInstance( 'display_point' );
		
		return $mapClass->renderMap( $parameters, $this->parser );
	}
	
	/**
	 * Returns the parser function otpions.
	 * @see ParserHook::getFunctionOptions
	 * 
	 * @since 0.7
	 * 
	 * @return array
	 */
	protected function getFunctionOptions() {
		return array(
			'noparse' => true,
			'isHTML' => true
		);
	}	

	/**
	 * @see ParserHook::getMessage()
	 * 
	 * @since 1.0
	 */
	public function getMessage() {
		return 'maps-displaypoint-description';
	}		
	
}
