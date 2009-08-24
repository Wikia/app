<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterInputButton extends DataCenterInput {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML id attribute
		 * @datatype	string
		 */
		'id' => 'button',
		/**
		 * XML name attribute
		 * @datatype	string
		 */
		'name' => 'button',
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'input-button',
		/**
		 * UI message for XML value attribute
		 * @datatype	string
		 */
		'label' => 'submit',
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
				'type' => 'button',
				'id' => $parameters['id'],
				'name' => $parameters['name'],
				'class' => 'button',
				'value' => DataCenterUI::message( 'label', $parameters['label'] )
			)
		);
		// Ends input
		$xmlOutput .= parent::end();
		// Returns XML
		return $xmlOutput;
	}
}