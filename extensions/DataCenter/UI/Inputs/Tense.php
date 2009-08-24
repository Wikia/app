<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterInputTense extends DataCenterInput {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML id attribute
		 * @datatype	string
		 */
		'id' => 'tense',
		/**
		 * XML name attribute
		 * @datatype	string
		 */
		'name' => 'tense',
		/**
		 * Value of selection
		 * @datatype	scalar
		 */
		'value' => '',
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'input-tense',
		/**
		 * List of fields to disable
		 * @datatype	array
		 */
		 'disable' => array(),
	);

	/* Functions */

	public static function render(
		array $parameters
	) {
		// Sets defaults
		$parameters = array_merge( self::$defaultParameters, $parameters );
		// Begins input
		$xmlOutput = parent::begin( $parameters['class'] );
		// Adds buttons
		foreach ( array( 'past', 'present', 'future' ) as $tense ) {
			$radioAttributes = array(
				'type' => 'radio',
				'id' => $parameters['id'] . '_' . $tense,
				'name' => $parameters['name'],
				'value' => $tense,
				'class' => 'button',
			);
			$labelAttributes = array(
				'for' => $parameters['id'] . '_' . $tense,
				'class' => 'label'
			);
			if ( $parameters['value'] == $tense ) {
				$radioAttributes['checked'] = 'checked';
			}
			if ( in_array( $tense, $parameters['disable'] ) ) {
				$radioAttributes['disabled'] = 'true';
				$labelAttributes['class'] .= ' disabled';
			}
			$xmlOutput .= DataCenterXml::tag( 'input', $radioAttributes );
			$xmlOutput .= DataCenterXml::tag(
				'label',
				$labelAttributes,
				DataCenterUI::message( 'option', $tense )
			);
		}
		// Ends input
		$xmlOutput .= parent::end();
		// Returns XML
		return $xmlOutput;
	}
}