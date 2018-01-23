<?php

use DataValues\Geo\Formatters\GeoCoordinateFormatter;
use Jeroen\SimpleGeocoder\Geocoder;
use ValueFormatters\FormatterOptions;

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

	private $geocoder;

	public function __construct( Geocoder $geocoder = null ) {
		$this->geocoder = $geocoder ?? \Maps\MapsFactory::newDefault()->newGeocoder();
		parent::__construct();
	}

	/**
	 * Renders and returns the output.
	 *
	 * @see ParserHook::render
	 *
	 * @since 0.7
	 *
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function render( array $parameters ) {
		$coordinates = $this->geocoder->geocode( $parameters['location'] );

		if ( $coordinates === null ) {
			return 'Geocoding failed'; // TODO: i18n
		}

		return $this->newCoordinateFormatter( $parameters )->format( $coordinates );
	}

	private function newCoordinateFormatter( array $parameters ) {
		return new GeoCoordinateFormatter(
			new FormatterOptions(
				[
					GeoCoordinateFormatter::OPT_FORMAT => $parameters['format'],
					GeoCoordinateFormatter::OPT_DIRECTIONAL => $parameters['directional'],
					GeoCoordinateFormatter::OPT_PRECISION => 1 / 360000
				]
			)
		);
	}

	/**
	 * @see ParserHook::getMessage()
	 *
	 * @since 1.0
	 */
	public function getMessage() {
		return 'maps-geocode-description';
	}

	/**
	 * Gets the name of the parser hook.
	 *
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
	 *
	 * @see ParserHook::getParameterInfo
	 *
	 * @since 0.7
	 *
	 * @return array
	 */
	protected function getParameterInfo( $type ) {
		global $egMapsAvailableCoordNotations;
		global $egMapsCoordinateNotation;
		global $egMapsCoordinateDirectional;

		$params = [];

		$params['location'] = [
			'type' => 'string',
			'message' => 'maps-geocode-par-location',
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
	 *
	 * @see ParserHook::getDefaultParameters
	 *
	 * @since 0.7
	 *
	 * @return array
	 */
	protected function getDefaultParameters( $type ) {
		return [ 'location' ];
	}

}
