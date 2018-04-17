<?php

/**
 * Class for the 'display_map' parser hooks.
 *
 * @since 0.7
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsDisplayMap extends ParserHook {

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
		$this->defaultMapZoom( $parameters );
		$this->trackMap();

		$renderer = new MapsDisplayMapRenderer(
			MapsMappingServices::getServiceInstance( $parameters['mappingservice'] )
		);

		return $renderer->renderMap( $parameters, $this->parser );
	}

	private function defaultMapZoom( &$parameters ) {
		$fullParams = $this->validator->getParameters();

		if ( array_key_exists( 'zoom', $fullParams ) && $fullParams['zoom']->wasSetToDefault() && count(
				$parameters['coordinates']
			) > 1 ) {
			$parameters['zoom'] = false;
		}
	}

	private function trackMap() {
		if ( $GLOBALS['egMapsEnableCategory'] ) {
			$this->parser->addTrackingCategory( 'maps-tracking-category' );
		}
	}

	/**
	 * @see ParserHook::getMessage()
	 *
	 * @since 1.0
	 */
	public function getMessage() {
		return 'maps-displaymap-description';
	}

	/**
	 * @see ParserHook::getNames()
	 *
	 * @since 2.0
	 *
	 * @return array
	 */
	protected function getNames() {
		return [ $this->getName(), 'display_point', 'display_points', 'display_line' ];
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
		return 'display_map';
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
		$params = MapsMapper::getCommonParameters();

		$params['mappingservice']['feature'] = 'display_map';

		$params['coordinates'] = [
			'type' => 'string',
			'aliases' => [ 'coords', 'location', 'address', 'addresses', 'locations', 'points' ],
			'default' => [],
			'islist' => true,
			'delimiter' => $type === ParserHook::TYPE_FUNCTION ? ';' : "\n",
			'message' => 'maps-displaymap-par-coordinates',
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
		return [ 'coordinates' ];
	}

	/**
	 * Returns the parser function options.
	 *
	 * @see ParserHook::getFunctionOptions
	 *
	 * @since 0.7
	 *
	 * @return array
	 */
	protected function getFunctionOptions() {
		return [
			'noparse' => true,
			'isHTML' => true
		];
	}

}
