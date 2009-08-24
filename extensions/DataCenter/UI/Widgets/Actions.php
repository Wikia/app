<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterWidgetActions extends DataCenterWidget {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML id attribute
		 * @datatype	string
		 */
		'id' => 'actions',
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'widget-actions',
		/**
		 * String of field of each link to use as type
		 * @datatype	string
		 */
		'subject' => 'type',
		/**
		 * Links to display
		 * @datatype	array
		 */
		'links' => array(),
		/**
		 * Rights required for display
		 * @datatype	array
		 */
		'rights' => array(),
	);

	/* Functions */

	public static function render(
		array $parameters
	) {
		// Sets defaults
		$parameters = array_merge( self::$defaultParameters, $parameters );
		// Checks for permissions
		if ( !DataCenterPage::userCan( $parameters['rights'] ) ) {
			return null;
		}
		// Begins widget
		$xmlOutput = parent::begin( $parameters['class'] );
		// Checks if links is an array
		if ( is_array( $parameters['links'] ) ) {
			// Loops over each link
			foreach ( $parameters['links'] as $label => $link ) {
				// Checks if link is not an array
				if ( !is_array( $link ) ) {
					// Skips the invalid data
					continue;
				}
				// Checks if a label was not given but an action was
				if ( is_int( $label ) && isset( $link['action'] ) ) {
					// Uses action as label
					$label = $link['action'];
				}
				if ( is_array( $link[$parameters['subject']] ) ) {
					$subject = current( $link[$parameters['subject']] );
				} else {
					$subject = $link[$parameters['subject']];
				}
				// Builds label
				$label = DataCenterUI::message( 'action', $label . '-type',
					DataCenterUI::message('type', $subject )
				);
				// Builds link
				$link = DataCenterXml::link( $label, $link );
				// Adds action link
				$xmlOutput .= DataCenterXml::div(
					array( 'class' => 'action' ), $link
				);
			}
		}
		// Ends widget
		$xmlOutput .= parent::end();
		$xmlOutput .= DataCenterXml::clearFloating();
		// Returns results
		return $xmlOutput;
	}
}