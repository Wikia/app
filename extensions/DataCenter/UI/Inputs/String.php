<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterInputString extends DataCenterInput {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML id attribute
		 * @datatype	string
		 */
		'id' => 'string',
		/**
		 * XML name attribute
		 * @datatype	string
		 */
		'name' => 'string',
		/**
		 * XML value attribute
		 * @datatype	scalar
		 */
		'value' => '',
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'input-string',
	);

	/* Functions */

	public static function render(
		array $parameters
	) {
		// Sets defaults
		$parameters = array_merge( self::$defaultParameters, $parameters );
		// Begins input
		$xmlOutput = parent::begin( $parameters['class'] );
		// Adds button
		$xmlOutput .= DataCenterXml::tag(
			'input',
			array(
				'type' => 'text',
				'id' => $parameters['id'],
				'name' => $parameters['name'],
				'class' => 'string',
				'value' => $parameters['value'],
				'autocomplete' => 'off',
			)
		);
		// Ends input
		$xmlOutput .= parent::end();
		// Returns XML
		return $xmlOutput;
	}
}