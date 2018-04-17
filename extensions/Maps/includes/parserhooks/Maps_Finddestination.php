<?php

use DataValues\Geo\Formatters\GeoCoordinateFormatter;

/**
 * Class for the 'finddestination' parser hooks, which can find a
 * destination given a starting point, an initial bearing and a distance.
 *
 * @since 0.7
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsFinddestination extends ParserHook {

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
		$destination = MapsGeoFunctions::findDestination(
			$parameters['location']->getCoordinates(),
			$parameters['bearing'],
			$parameters['distance']
		);

		$options = new \ValueFormatters\FormatterOptions(
			[
				GeoCoordinateFormatter::OPT_FORMAT => $parameters['format'],
				GeoCoordinateFormatter::OPT_DIRECTIONAL => $parameters['directional'],
				GeoCoordinateFormatter::OPT_PRECISION => 1 / 360000
			]
		);

		$formatter = new GeoCoordinateFormatter( $options );

		$geoCoords = new \DataValues\LatLongValue( $destination['lat'], $destination['lon'] );
		$output = $formatter->format( $geoCoords );

		return $output;
	}

	/**
	 * @see ParserHook::getMessage()
	 *
	 * @since 1.0
	 */
	public function getMessage() {
		return 'maps-finddestination-description';
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
		return 'finddestination';
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
		global $egMapsCoordinateNotation, $egMapsCoordinateDirectional;

		$params = [];

		$params['location'] = [
			'type' => 'mapslocation',
		];

		$params['format'] = [
			'default' => $egMapsCoordinateNotation,
			'values' => $egMapsAvailableCoordNotations,
			'aliases' => 'notation',
			'tolower' => true,
		];

		$params['directional'] = [
			'type' => 'boolean',
			'default' => $egMapsCoordinateDirectional,
		];

		$params['bearing'] = [
			'type' => 'float',
		];

		$params['distance'] = [
			'type' => 'distance',
		];

		// Give grep a chance to find the usages:
		// maps-finddestination-par-location, maps-finddestination-par-format,
		// maps-finddestination-par-directional, maps-finddestination-par-bearing,
		// maps-finddestination-par-distance, maps-finddestination-par-mappingservice,
		// maps-finddestination-par-geoservice, maps-finddestination-par-allowcoordinates
		foreach ( $params as $name => &$param ) {
			$param['message'] = 'maps-finddestination-par-' . $name;
		}

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
		return [ 'location', 'bearing', 'distance' ];
	}

}