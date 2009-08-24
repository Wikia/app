<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterLayoutRows extends DataCenterLayout {

	/* Private Static Members */

	private static $parameters = array(
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'layout-rows',
	);

	/* Functions */

	public static function render(
		array $parameters
	) {
		// Begins layout
		$xmlOutput = parent::begin( self::$parameters['class'] );
		// Loops over each content block
		foreach ( $parameters as $content ) {
			// Adds row
			$xmlOutput .= DataCenterXml::div(
				DataCenterXml::div( array( 'class' => 'row' ), $content )
			);
		}
		// Ends layout
		$xmlOutput .= parent::end();
		// Returns results
		return $xmlOutput;
	}
}