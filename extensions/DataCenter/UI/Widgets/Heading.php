<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterWidgetHeading extends DataCenterWidget {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML id attribute
		 * @datatype	string
		 */
		'id' => 'heading',
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'widget-heading',
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
			// Required types
			is_scalar( $parameters['message'] ) &&
			// Required values
			( $parameters['message'] !== null )
		) {
			// Checks if a subject was given
			if ( $parameters['subject'] !== null ) {
				// Uses subject-based message
				$message = DataCenterUI::message(
					'heading', $parameters['message'], $parameters['subject']
				);
			}
			// Checks if a type was given
			else if ( $parameters['type'] !== null ) {
				// Uses type-based message
				$message = DataCenterUI::message(
					'heading',
					$parameters['message'],
					DataCenterUI::message( 'type', $parameters['type'] )
				);
			} else {
				// Uses plain message
				$message = DataCenterUI::message(
					'heading', $parameters['message']
				);
			}
			// Returns heading with message
			$xmlOutput .= $message;
		// Checks if text was given
		} else if ( $parameters['text'] !== null ) {
			// Adds a heading with text
			$xmlOutput .= $parameters['text'];
		}
		// Ends widget
		$xmlOutput .= parent::end();
		// Returns results
		return $xmlOutput;
	}
}