<?php

/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterWidgetTable extends DataCenterWidget {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML id attribute
		 * @datatype	string
		 */
		'id' => 'table',
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'widget-table',
		/**
		 * Data Source
		 * @datatype	array of DataCenterDBRow
		 */
		'rows' => array(),
		/**
		 * Number of possible rows
		 * @datatype	integer
		 */
		//'num' => null,
		/**
		 * Array of field labels and options using self::processFields
		 * @datatype	array
		 */
		'fields' => array(),
		/**
		 * Link for each row using DataCenterXml::buildLink
		 * @datatype	array
		 */
		'link' => array(),
		/**
		 * Effects for each row using DataCenterXml::buildEffects
		 * @datatype	array
		 */
		'effects' => array(),
	);

	private static $defaultFieldOptions = array(
		/**
		 * Overrides the use of label as field (single)
		 * @datatype	string
		 */
		'field' => null,
		/**
		 * List of fields (multi)
		 * @datatype	array
		 */
		'fields' => array(),
		/**
		 * Inserted between multi-field values
		 * @datatype	string
		 */
		'glue' => ',',
		/**
		 * Alignment of of column
		 * @datatype	string
		 */
		'align' => 'left',
		/**
		 * Formatting to apply using DataCenterUI::format
		 * @datatype	string
		 */
		'format' => null,
	);

	/* Static Functions */

	public static function render(
		array $parameters
	) {
		// Sets defaults
		$parameters = array_merge_recursive(
			self::$defaultParameters, $parameters
		);
		// Begins widget
		$xmlOutput = parent::begin( $parameters['class'] );
		// Processes fields
		$fields = self::processFields( $parameters['fields'] );
		// Check if there was an error processing fields
		if ( !$fields ) {
			// Tells the user
			return DataCenterUI::message( 'error', 'no-fields' );
		}
		// Begins table
		$xmlOutput .= DataCenterXml::open(
			'table', array( 'border' => 0, 'cellspacing' => 0 )
		);
		// Gets current path
		$path = DataCenterPage::getPath();
		// Check if number of possible records was given
		if ( isset( $parameters['num'] )) {
			// Adds paging
			$xmlOutput .= DataCenterXml::row(
				DataCenterXml::cell(
					array(
						'colspan' => count( $parameters['fields'] ),
						'align' => 'right'
					),
					parent::buildPaging( $path, $parameters['num'] )
				)
			);
		}
		// Adds headings
		foreach( $fields as $label => $options ) {
			$xmlOutput .= DataCenterXml::headingCell(
				array( 'align' => $options['align'] ),
				DataCenterUI::message( 'field', $label )
			);
		}
		if ( count( $parameters['rows'] ) == 0 ) {
			$xmlOutput .= DataCenterXml::row(
				DataCenterXml::cell(
					DataCenterUI::message( 'error', 'no-rows' )
				)
			);
		}
		// Loops over each row
		foreach ( $parameters['rows'] as $i => $row ) {
			// Builds row attributes
			$rowAttributes = array_merge(
				array( 'class' => ( ( $i % 2 == 0 ) ? 'odd' : 'even' ) ),
				DataCenterXml::buildEffects( $parameters['effects'], $row ),
				DataCenterXml::buildLink( $parameters['link'], $row )
			);
			if ( count( $parameters['link'] ) > 0 ) {
				$rowAttributes['class'] .= ' link';
			}
			// Begins row
			$xmlOutput .= DataCenterXml::open( 'tr', $rowAttributes );
			// Loops over each field
			foreach( $fields as $label => $options ) {
				// Checks if multiple fields were specified
				if ( count( $options['fields'] ) > 0 ) {
					// Builds array of values
					$values = array();
					foreach ( $options['fields'] as $field => $fieldOptions ) {
						$values[] = DataCenterUI::format(
							$row->get( $field ), $fieldOptions['format']
						);
					}
					// Glues values together
					$value = implode( $options['glue'], $values );
				// Alternatively checks if a field was specified
				} else if ( $options['field'] ) {
					// Uses specified field
					$value = DataCenterUI::format(
						$row->get( $options['field'] ), $options['format']
					);
				} else {
					// Uses label as field
					$value = DataCenterUI::format(
						$row->get( $label ), $options['format']
					);
				}
				// Adds cell
				$xmlOutput .= DataCenterXml::cell(
					array( 'align' => $options['align'] ), $value
				);
			}
			// Ends row
			$xmlOutput .= DataCenterXml::close( 'tr' );
		}
		// Ends table
		$xmlOutput .= DataCenterXml::close( 'table' );
		// Clears any floating
		$xmlOutput .= DataCenterXml::clearFloating();
		// Ends widget
		$xmlOutput .= parent::end();
		// Returns results
		return $xmlOutput;
	}

	/* Private Static Functions */

	/**
	 * Converts mixed arrays of fields to associative arrays recursively
	 * @param	fields			Mixed Array of field => options pairs or just
	 * 							fields, where the field is used to retrieve the
	 * 							value from the row being rendered and the
	 * 							parameters being an Array which is passed back to
	 * 							the widget as options for the entire column,
	 * 							merging with default options to ensure keys exist
	 */
	private static function processFields(
		$fields
	) {
		// Checks that fields is an array with at least one element
		if ( count( $fields ) == 0 ) {
			return null;
		}
		// Loops over each field in fields translating numericaly indexed array
		// elements to associative array elements, resulting in an entirely
		// associaitive array
		$convertedFields = array();
		foreach( $fields as $key => $value ) {
			// Checks what kind of element was given
			if ( is_int( $key ) ) {
				// Sets a string-keyed
				$convertedFields[$value] = self::$defaultFieldOptions;
			} else {
				// Uses key as field and value as parameters
				$convertedFields[$key] = array_merge(
					self::$defaultFieldOptions, $value
				);
			}
			// Performs recursive processing if multiple files specified
			if ( isset( $convertedFields[$key]['fields'] ) ) {
				$convertedFields[$key]['fields'] = self::processFields(
					$convertedFields[$key]['fields']
				);
			}
		}
		// Returns results
		return $convertedFields;
	}
}