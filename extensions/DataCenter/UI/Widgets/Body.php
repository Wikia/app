<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterWidgetBody extends DataCenterWidget {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML id attribute
		 * @datatype	string
		 */
		'id' => 'body',
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'widget-body',
		/**
		 * Message to display
		 * @datatype	string
		 */
		 'message' => null,
		/**
		 * Text to inject as paramter for message
		 * @datatype	string
		 */
		 'subject' => null,
		/**
		 * Name of type of component to inject as parameter for message
		 * @datatype	string
		 */
		 'type' => null,
		/**
		 * Text to display
		 * @datatype	string
		 */
		 'text' => null,
		/**
		 * Style of box to display body in
		 * @datatype	string
		 */
		 'style' => 'generic',
	);

	/* Functions */

	public static function render(
		array $parameters
	) {
		// Sets defaults
		$parameters = array_merge( self::$defaultParameters, $parameters );
		// Begins widget
		$xmlOutput = parent::begin( $parameters['class'] );
		// Checks for...
		if (
			// Required parameters
			isset( $parameters['message'] ) &&
			// Required styles
			is_scalar( $parameters['message'] ) &&
			// Required values
			( $parameters['message'] !== null )
		) {
			// Checks if a subject was given
			if (
				isset( $parameters['subject'] ) &&
				$parameters['subject'] !== null
			) {
				// Uses subject-based message
				$message = DataCenterUI::message(
					'body', $parameters['message'], $parameters['subject']
				);
			// Checks if a type was given
			} else if ( $parameters['type'] !== null ) {
				// Uses type-based message
				$message = DataCenterUI::message(
					'body',
					$parameters['message'],
					DataCenterUI::message( 'type', $parameters['type'] )
				);
			} else {
				// Uses plain message
				$message = DataCenterUI::message(
					'body', $parameters['message']
				);
			}
			// Returns body with message
			$xmlOutput .= DataCenterXml::div(
				array( 'class' => $parameters['style'] ),
				DataCenterXml::div( $message )
			);
		// Checks if text was given
		} else if (
			// Required parameters
			isset( $parameters['text'] ) &&
			// Required styles
			is_scalar( $parameters['text'] ) &&
			// Required values
			( $parameters['text'] !== null )
		) {
			// Returns a body with text
			$xmlOutput .= DataCenterXml::div(
				array( 'class' => $parameters['style'] ),
				DataCenterXml::div( $parameters['text'] )
			);
		}
		// Ends widget
		$xmlOutput .= parent::end();
		// Returns results
		return $xmlOutput;
	}
}