<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterWidgetDetails extends DataCenterWidget {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML id attribute
		 * @datatype	string
		 */
		'id' => 'details',
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'widget-details',
		/**
		 * Data Source
		 * @datatype	DataCenterDBRow
		 */
		'row' => null,
		/**
		 * Fields to display
		 * @datatype	array
		 */
		'fields' => array(),
		/**
		 * Whether to display meta information as well
		 */
		'meta' => true,
	);

	/* Functions */

	public static function render(
		array $parameters
	) {
		// Sets defaults
		$parameters = array_merge( self::$defaultParameters, $parameters );
		// Begins widget
		$xmlOutput = parent::begin( $parameters['class'] );
		// Begins table
		$xmlOutput .= DataCenterXml::open( 'table' );
		// Checks that an array of fields and valid row was given
		if (
			is_array( $parameters['fields'] ) &&
			( $parameters['row'] instanceof DataCenterDBRow )
		) {
			// Loops over each field
			foreach ( $parameters['fields'] as $key => $value ) {
				$values = array();
				if ( is_int( $key ) ) {
					$label = $value;
					$value = $parameters['row']->get( $value );
				} else {
					$label = $key;
					if ( is_array( $value ) ) {
						if ( isset( $value['fields'] ) ) {
							foreach ( $value['fields'] as $fieldName ) {
								$values[] = DataCenterUI::format(
									$parameters['row']->get( $fieldName ),
									isset( $value['format'] ) ?
									$value['format'] :
									null
								);
							}
						} elseif ( isset( $value['field'] ) ) {
							$value = DataCenterUI::format(
								$parameters['row']->get( $value['field'] ),
								isset( $value['format'] ) ?
								$value['format'] :
								null
							);
						} else {
							$value = DataCenterUI::format(
								$parameters['row']->get( $key ),
								isset( $value['format'] ) ?
								$value['format'] :
								null
							);
						}
					} else {
						$value = $parameters['row']->get( $key );
					}
				}
				if ( isset( $value['glue'] ) ) {
					$glue = $value['glue'];
				} else {
					$glue = ', ';
				}
				// Adds row
				$xmlOutput .= DataCenterXml::row(
					DataCenterXml::cell(
						array( 'class' => 'label' ),
						DataCenterUI::message( 'field', $label )
					),
					DataCenterXml::cell(
						array( 'class' => 'value' ),
						count( $values ) ? implode( $glue, $values ) : $value
					)
				);
			}
		}
		if (
			$parameters['meta'] &&
			$parameters['row'] instanceof DataCenterDBComponent
		) {
			$values = $parameters['row']->getMetaValues();
			foreach ( $values as $value ) {
				// Adds row
				$xmlOutput .= DataCenterXml::row(
					DataCenterXml::cell(
						array( 'class' => 'label' ), $value->get( 'name' )
					),
					DataCenterXml::cell(
						array( 'class' => 'value' ),
						DataCenterUI::format(
							$value->get( 'value' ), $value->get( 'format' )
						)
					)
				);
			}
		}
		// Ends table
		$xmlOutput .= DataCenterXml::close( 'table' );
		// Ends widget
		$xmlOutput .= parent::end();
		// Returns results
		return $xmlOutput;
	}
}