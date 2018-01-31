<?php

/**
 * Class for the 'geodistance' parser hooks, which can
 * calculate the geographical distance between two points.
 *
 * @since 0.7
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsGeodistance extends ParserHook {

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
	 * @throws MWException
	 */
	public function render( array $parameters ) {
		/**
		 * @var \DataValues\LatLongValue $coordinates1
		 * @var \DataValues\LatLongValue $coordinates2
		 */
		$coordinates1 = $parameters['location1']->getCoordinates();
		$coordinates2 = $parameters['location2']->getCoordinates();

		$distance = MapsGeoFunctions::calculateDistance( $coordinates1, $coordinates2 );
		$output = MapsDistanceParser::formatDistance( $distance, $parameters['unit'], $parameters['decimals'] );

		return $output;
	}

	/**
	 * @see ParserHook::getMessage
	 *
	 * @since 1.0
	 */
	public function getMessage() {
		return 'maps-geodistance-description';
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
		return 'geodistance';
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
		global $egMapsDistanceUnit, $egMapsDistanceDecimals;

		$params = [];

		$params['unit'] = [
			'default' => $egMapsDistanceUnit,
			'values' => MapsDistanceParser::getUnits(),
		];

		$params['decimals'] = [
			'type' => 'integer',
			'default' => $egMapsDistanceDecimals,
		];

		$params['location1'] = [
			'type' => 'mapslocation', // FIXME: geoservice is not used
			'aliases' => 'from',
		];

		$params['location2'] = [
			'type' => 'mapslocation', // FIXME: geoservice is not used
			'aliases' => 'to',
		];

		// Give grep a chance to find the usages:
		// maps-geodistance-par-mappingservice, maps-geodistance-par-geoservice,
		// maps-geodistance-par-unit, maps-geodistance-par-decimals,
		// maps-geodistance-par-location1, maps-geodistance-par-location2
		foreach ( $params as $name => &$param ) {
			$param['message'] = 'maps-geodistance-par-' . $name;
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
	 * @param $type
	 *
	 * @return array
	 */
	protected function getDefaultParameters( $type ) {
		return [ 'location1', 'location2', 'unit', 'decimals' ];
	}

}