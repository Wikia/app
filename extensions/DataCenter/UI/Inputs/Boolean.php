<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterInputBoolean extends DataCenterInput {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML id attribute
		 * @datatype	string
		 */
		'id' => 'boolean',
		/**
		 * XML name attribute
		 * @datatype	string
		 */
		'name' => 'boolean',
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'input-boolean',
	);

	/* Functions */

	public static function render(
		array $parameters
	) {
		// Sets defaults
		$parameters = array_merge( self::$defaultParameters, $parameters );
		// Begins input
		$xmlOutput = parent::begin( $parameters['class'] );
		// Creates list of buttons
		$buttons = array( 'true' => true, 'false' => false );
		// Adds buttons
		foreach ( $buttons as $button => $value ) {
			$radioAttributes = array(
				'type' => 'radio',
				'id' => $parameters['id'] . '_' . $button,
				'name' => $parameters['name'],
				'value' => $value ? 1 : 0,
				'class' => 'button',
			);
			$labelAttributes = array(
				'for' => $parameters['id'] . '_' . $button,
				'class' => 'label'
			);
			if (
				( $parameters['value'] == ( $value ? 1 : 0 ) ) &&
				( $parameters['value'] !== null ) &&
				( $parameters['value'] !== '' )
			) {
				$radioAttributes['checked'] = 'checked';
			}
			$xmlOutput .= DataCenterXml::tag( 'input', $radioAttributes );
			$xmlOutput .= DataCenterXml::tag(
				'label',
				$labelAttributes,
				DataCenterUI::message( 'option', $button )
			);
		}
		// Ends input
		$xmlOutput .= parent::end();
		// Returns XML
		return $xmlOutput;
	}
}