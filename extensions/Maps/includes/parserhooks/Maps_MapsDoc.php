<?php

use ParamProcessor\ParamDefinition;

/**
 * Class for the 'mapsdoc' parser hooks,
 * which displays documentation for a specified mapping service.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsMapsDoc extends ParserHook {

	/**
	 * Field to store the value of the language parameter.
	 *
	 * @since 1.0.1
	 *
	 * @var string
	 */
	protected $language;

	/**
	 * Renders and returns the output.
	 *
	 * @see ParserHook::render
	 *
	 * @since 1.0
	 *
	 * @param array $parameters
	 *
	 * @return string
	 */
	public function render( array $parameters ) {
		$this->language = $parameters['language'];

		$params = $this->getServiceParameters( $parameters['service'] );

		return $this->getParameterTable( $params );
	}

	private function getServiceParameters( $service ) {
		$service = MapsMappingServices::getServiceInstance( $service );

		$params = [];

		$params['zoom'] = [
			'type' => 'integer',
			'message' => 'maps-par-zoom',
		];

		$service->addParameterInfo( $params );

		return $params;
	}

	/**
	 * Returns the wikitext for a table listing the provided parameters.
	 *
	 * @since 1.0
	 *
	 * @param array $parameters
	 *
	 * @return string
	 */
	private function getParameterTable( array $parameters ) {
		$tableRows = [];

		$parameters = ParamDefinition::getCleanDefinitions( $parameters );

		foreach ( $parameters as $parameter ) {
			$tableRows[] = $this->getDescriptionRow( $parameter );
		}

		$table = '';

		if ( count( $tableRows ) > 0 ) {
			$tableRows = array_merge(
				[
					'!' . $this->msg( 'validator-describe-header-parameter' ) . "\n" .
					//'!' . $this->msg( 'validator-describe-header-aliases' ) ."\n" .
					'!' . $this->msg( 'validator-describe-header-type' ) . "\n" .
					'!' . $this->msg( 'validator-describe-header-default' ) . "\n" .
					'!' . $this->msg( 'validator-describe-header-description' )
				],
				$tableRows
			);

			$table = implode( "\n|-\n", $tableRows );

			$table =
				'{| class="wikitable sortable"' . "\n" .
				$table .
				"\n|}";
		}

		return $table;
	}

	/**
	 * Returns the wikitext for a table row describing a single parameter.
	 *
	 * @param ParamDefinition $parameter
	 *
	 * @return string
	 */
	private function getDescriptionRow( ParamDefinition $parameter ) {
		$description = $this->msg( $parameter->getMessage() );

		$type = $this->msg( $parameter->getTypeMessage() );

		$default = $parameter->isRequired() ? "''" . $this->msg(
				'validator-describe-required'
			) . "''" : $parameter->getDefault();
		if ( is_array( $default ) ) {
			$default = implode( ', ', $default );
		} elseif ( is_bool( $default ) ) {
			$default = $default ? 'yes' : 'no';
		}

		if ( $default === '' ) {
			$default = "''" . $this->msg( 'validator-describe-empty' ) . "''";
		}

		return <<<EOT
| {$parameter->getName()}
| {$type}
| {$default}
| {$description}
EOT;
	}

	/**
	 * Message function that takes into account the language parameter.
	 *
	 * @since 1.0.1
	 *
	 * @param string $key
	 * @param ... $args
	 *
	 * @return string
	 */
	private function msg() {
		$args = func_get_args();
		$key = array_shift( $args );
		return wfMessage( $key, $args )->inLanguage( $this->language )->text();
	}

	/**
	 * @see ParserHook::getDescription()
	 *
	 * @since 1.0
	 */
	public function getMessage() {
		return 'maps-mapsdoc-description';
	}

	/**
	 * Gets the name of the parser hook.
	 *
	 * @see ParserHook::getName
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	protected function getName() {
		return 'mapsdoc';
	}

	/**
	 * Returns an array containing the parameter info.
	 *
	 * @see ParserHook::getParameterInfo
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	protected function getParameterInfo( $type ) {
		$params = [];

		$params['service'] = [
			'values' => $GLOBALS['egMapsAvailableServices'],
			'tolower' => true,
		];

		$params['language'] = [
			'default' => $GLOBALS['wgLanguageCode'],
		];

		// Give grep a chance to find the usages:
		// maps-geocode-par-service, maps-geocode-par-language
		foreach ( $params as $name => &$param ) {
			$param['message'] = 'maps-geocode-par-' . $name;
		}

		return $params;
	}

	/**
	 * Returns the list of default parameters.
	 *
	 * @see ParserHook::getDefaultParameters
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	protected function getDefaultParameters( $type ) {
		return [ 'service', 'language' ];
	}

}
