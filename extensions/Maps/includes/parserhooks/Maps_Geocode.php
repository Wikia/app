<?php
use DataValues\Geo\Formatters\GeoCoordinateFormatter;

/**
 * Class for the 'geocode' parser hooks, which can turn
 * human readable locations into sets of coordinates.
 * 
 * @since 0.7
 * 
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsGeocode extends ParserHook {

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

		$params['location'] = array(
			'type' => 'mapslocation',
			'dependencies' => array( 'mappingservice', 'geoservice' ),
		);

		$params['mappingservice'] = array(
			'default' => '',
			'values' => MapsMappingServices::getAllServiceValues(),
			'tolower' => true,
		);

		$params['geoservice'] = array(
			'default' => $egMapsDefaultGeoService,
			'aliases' => 'service',
			'values' => $egMapsAvailableGeoServices,
			'tolower' => true,
		);

		$params['allowcoordinates'] = array(
			'type' => 'boolean',
			'default' => $egMapsAllowCoordsGeocoding,
		);

		$params['format'] = array(
			'default' => $egMapsCoordinateNotation,
			'values' => $egMapsAvailableCoordNotations,
			'aliases' => 'notation',
			'tolower' => true,
		);

		$params['directional'] = array(
			'type' => 'boolean',
			'default' => $egMapsCoordinateDirectional,
		);

		// Give grep a chance to find the usages:
		// maps-geocode-par-location, maps-geocode-par-mappingservice, maps-geocode-par-geoservice,
		// maps-geocode-par-allowcoordinates, maps-geocode-par-format, maps-geocode-par-directional
		foreach ( $params as $name => &$param ) {
			$param['message'] = 'maps-geocode-par-' . $name;
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
		/**
		 * @var \DataValues\LatLongValue $coordinates
		 */
		$coordinates = $parameters['location']->getCoordinates();

		$options = new \ValueFormatters\FormatterOptions( array(
			GeoCoordinateFormatter::OPT_FORMAT => $parameters['format'],
			GeoCoordinateFormatter::OPT_DIRECTIONAL => $parameters['directional'],
			GeoCoordinateFormatter::OPT_PRECISION => 1 / 360000
		) );

		$formatter = new GeoCoordinateFormatter( $options );

		return $formatter->format( $coordinates );
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