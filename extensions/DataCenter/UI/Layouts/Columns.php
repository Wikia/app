<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterLayoutColumns extends DataCenterLayout {

	/* Private Static Members */

	private static $parameters = array(
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'layout-columns',
	);

	/* Functions */

	public static function render(
		array $parameters
	) {
		// Begins layout
		$xmlOutput = parent::begin( self::$parameters['class'] );
		// Calculates split percentage
		$split = round( 100 / count( $parameters ) );
		// Loops over each content block
		foreach ( $parameters as $content ) {
			// Adds column
			$xmlOutput .= DataCenterXml::div(
				array( 'style' => "width:{$split}%;float:left;" ),
				DataCenterXml::div( array( 'class' => 'column' ), $content )
			);
		}
		// Ends layout
		$xmlOutput .= parent::end();
		// Returns results
		return $xmlOutput;
	}
}