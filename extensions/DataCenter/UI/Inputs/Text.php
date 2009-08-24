<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterInputText extends DataCenterInput {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML id attribute
		 * @datatype	string
		 */
		'id' => 'text',
		/**
		 * XML name attribute
		 * @datatype	string
		 */
		'name' => 'text',
		/**
		 * XML value attribute
		 * @datatype	scalar
		 */
		'value' => '',
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'input-text',
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
			'textarea',
			array(
				'id' => $parameters['id'],
				'name' => $parameters['name'],
				'class' => 'text',
			),
			$parameters['value']
		);
		// Ends input
		$xmlOutput .= parent::end();
		// Returns XML
		return $xmlOutput;
	}
}