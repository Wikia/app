<?php

/**
 * Class for the 'display_map' parser hooks.
 * 
 * @since 0.7
 * 
 * @file Maps_DisplayMap.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsDisplayMap extends ParserHook {
	/**
	 * No LSB in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 */	
	public static function staticInit( Parser &$parser ) {
		$instance = new self;
		return $instance->init( $parser );
	}	
	
	public static function initialize() {
		
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
		return 'display_map';
	}

	/**
	 * @see ParserHook::getNames()
	 *
	 * @since 2.0
	 *
	 * @return array
	 */
	protected function getNames() {
		return array( $this->getName(), 'display_point', 'display_points', 'display_line' );
	}
	
	/**
	 * Returns an array containing the parameter info.
	 * @see ParserHook::getParameterInfo
	 *
	 * TODO: migrate stuff
	 * 
	 * @since 0.7
	 * 
	 * @return array
	 */
	protected function getParameterInfo( $type ) {
		global $egMapsDefaultTitle, $egMapsDefaultLabel;

		$params = MapsMapper::getCommonParameters();

		$params['mappingservice']['feature'] = 'display_map';

		$params['zoom']['dependencies'] = array( 'coordinates', 'mappingservice' );
		$params['zoom']['manipulations'] = new MapsParamZoom();

		$params['coordinates'] = array(
			'aliases' => array( 'coords', 'location', 'address', 'addresses', 'locations', 'points' ),
			'criteria' => new CriterionIsLocation( $type === ParserHook::TYPE_FUNCTION ? '~' : '|' ),
			'manipulations' => new MapsParamLocation( $type === ParserHook::TYPE_FUNCTION ? '~' : '|' ),
			'dependencies' => array( 'mappingservice', 'geoservice' ),
			'default' => array(),
			'islist' => true,
			'delimiter' => $type === ParserHook::TYPE_FUNCTION ? ';' : "\n",
		);

		$params['title'] = array(
			'name' => 'title',
			'default' => $egMapsDefaultTitle,
		);

		$params['label'] = array(
			'default' => $egMapsDefaultLabel,
			'aliases' => 'text',
		);

		$params['icon'] = array( // TODO: image param
			'default' => '', // TODO
		);

		$params['visitedicon'] = array(
			'default' => '', //TODO: image param
		);

		$params['lines'] = array(
			'default' => array(),
			'criteria' => new CriterionLine( '~' ), // TODO
			'manipulations' => new MapsParamLine( '~' ), // TODO
			'delimiter' => ';',
			'islist' => true,
		);

		$params['polygons'] = array(
			'default' => array(),
			'criteria' => new CriterionPolygon( '~' ), // TODO
			'manipulations' => new MapsParamPolygon( '~' ), // TODO
			'delimiter' => ';',
			'islist' => true,
		);

		$params['circles'] = array(
			'default' => array(),
			'manipulations' => new MapsParamCircle( '~' ), // TODO
			'delimiter' => ';',
			'islist' => true,
		);

		$params['rectangles'] = array(
			'default' => array(),
			'manipulations' => new MapsParamRectangle( '~' ), // TODO
			'delimiter' => ';',
			'islist' => true,
		);

		$params['copycoords'] = array(
			'type' => 'boolean',
			'default' => false,
		);

		$params['static'] = array(
			'type' => 'boolean',
			'default' => false,
		);

		$params['wmsoverlay'] = array(
			'type' => 'string',
			'default' => false,
			'manipulations' => new MapsParamWmsOverlay( ' ' ), // TODO
			'delimiter' => ';',
		);

		$params['maxzoom'] = array(
			'type' => 'integer',
			'default' => false,
			'manipulatedefault' => false,
			'dependencies' => 'minzoom',
		);

		$params['minzoom'] = array(
			'type' => 'integer',
			'default' => false,
			'manipulatedefault' => false,
			'lowerbound' => 0,
		);

		foreach ( $params as $name => &$param ) {
			if ( !array_key_exists( 'message', $param ) ) {
				$param['message'] = 'maps-displaymap-par-' . $name;
			}
		}
		
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
		$mapClass = $service->getFeatureInstance( $this->getName() );

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
		return 'maps-displaymap-description';
	}		
	
}