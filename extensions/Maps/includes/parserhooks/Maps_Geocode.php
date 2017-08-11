<?php

use DataValues\Geo\Formatters\GeoCoordinateFormatter;
use Maps\Geocoders;

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
		
		$params = [];

		$params['location'] = [
			'type' => 'string',
			'message' => 'maps-geocode-par-location',
		];

		$params['geoservice'] = [
			'default' => $egMapsDefaultGeoService,
			'aliases' => 'service',
			'values' => $egMapsAvailableGeoServices,
			'tolower' => true,
			'message' => 'maps-geocode-par-geoservice',
		];

		$params['allowcoordinates'] = [
			'type' => 'boolean',
			'default' => $egMapsAllowCoordsGeocoding,
			'message' => 'maps-geocode-par-allowcoordinates',
		];

		$params['format'] = [
			'default' => $egMapsCoordinateNotation,
			'values' => $egMapsAvailableCoordNotations,
			'aliases' => 'notation',
			'tolower' => true,
			'message' => 'maps-geocode-par-format',
		];

		$params['directional'] = [
			'type' => 'boolean',
			'default' => $egMapsCoordinateDirectional,
			'message' => 'maps-geocode-par-directional',
		];

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
		return [ 'location', 'geoservice' ];
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
		if ( !Geocoders::canGeocode() ) {
			return 'No geocoders available';
		}

		$coordinates = Geocoders::attemptToGeocode(
			$parameters['location'],
			$parameters['geoservice'],
			$parameters['allowcoordinates']
		);

		if ( $coordinates === false ) {
			return 'Geocoding failed';
		}

		$options = new \ValueFormatters\FormatterOptions( [
			GeoCoordinateFormatter::OPT_FORMAT => $parameters['format'],
			GeoCoordinateFormatter::OPT_DIRECTIONAL => $parameters['directional'],
			GeoCoordinateFormatter::OPT_PRECISION => 1 / 360000
		] );

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