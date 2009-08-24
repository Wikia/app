<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterInputList extends DataCenterInput {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML id attribute
		 * @datatype	string
		 */
		'id' => 'list',
		/**
		 * XML name attribute
		 * @datatype	string
		 */
		'name' => 'list',
		/**
		 * XML value attribute
		 * @datatype	scalar
		 */
		'value' => '',
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'input-list',
		/**
		 * Data source: Array of DataCenterDBRow elements
		 * @datatype	array
		 */
		'rows' => array(),
		/**
		 * Array of Strings of field names of row for label of option
		 * @datatype	array
		 */
		'labels' => array( 'id' ),
		/**
		 * String to use when sticking fields together
		 * @datatype	string
		 */
		'glue' => ', ',
		/**
		 * Data source: Array of message => value pairs
		 * @datatype	array
		 */
		'options' => null,
		/**
		 * Data source: Array with category, type and field keys for enum lookup
		 * @datatype	array
		 */
		'enum' => null,
	);

	/* Functions */

	public static function render(
		array $parameters
	) {
		// Sets defaults
		$parameters = array_merge( self::$defaultParameters, $parameters );
		// Begins input
		$xmlOutput = parent::begin( $parameters['class'] );
		// Begins select
		$xmlOutput .= DataCenterXml::open(
			'select',
			array(
				'name' => $parameters['name'],
				'id' => $parameters['id'],
				'class' => 'list',
			)
		);
		// Checks if rows were given
		if ( $parameters['rows'] ) {
			// Loops over each row
			foreach ( $parameters['rows'] as $row ) {
				// Builds attributes for option
				$optionAttributes = array( 'value' => $row->getId() );
				// Checks if option value matches input value
				if ( $optionAttributes['value'] == $parameters['value'] ) {
					// Adds selected attribute to option
					$optionAttributes['selected'] = 'selected';
				}
				// Adds option
				$xmlOutput .= DataCenterXml::tag(
					'option',
					$optionAttributes,
					implode(
						$row->get( $parameters['labels'] ),
						$parameters['glue']
					)
				);
			}
		// Alternatively check if options were given
		} else if ( $parameters['options'] ) {
			// Loops over each option
			foreach ( $parameters['options'] as $key => $value ) {
				// Checks if option key was not given
				if ( is_int( $key ) ) {
					// Uses key as value
					$optionAttributes = array( 'value' => $key );
					// Uses value as label
					$optionLabel = $value;
				} else {
					// Uses value as value
					$optionAttributes = array( 'value' => $value );
					// Uses key as label
					$optionLabel = $key;
				}
				// Checks if option value matches input value
				if ( $optionAttributes['value'] == $parameters['value'] ) {
					// Adds selected attribute to option
					$optionAttributes['selected'] = 'selected';
				}
				// Adds option
				$xmlOutput .= DataCenterXml::tag(
					'option',
					$optionAttributes,
					DataCenterUI::message( 'option', $optionLabel )
				);
			}
		// Alternatively check if an enum was given
		} else if (
			isset(
				$parameters['enum']['category'],
				$parameters['enum']['type'],
				$parameters['enum']['field']
			)
		) {
			// Gets enum values from database
			$enum = DataCenterDB::getEnum(
				$parameters['enum']['category'],
				$parameters['enum']['type'],
				$parameters['enum']['field']
			);
			// Loops over each name
			foreach ( $enum as $name ) {
				// Uses name as value
				$optionAttributes = array( 'value' => $name );
				// Uses name as label
				$optionLabel = $name;
				// Checks if option value matches input value
				if ( $optionAttributes['value'] == $parameters['value'] ) {
					// Adds selected attribute to option
					$optionAttributes['selected'] = 'selected';
				}
				// Adds option
				$xmlOutput .= Xml::element(
					'option',
					$optionAttributes,
					DataCenterUI::message( 'option', $optionLabel )
				);
			}
		}
		// Ends select
		$xmlOutput .= DataCenterXml::close( 'select' );
		// Ends input
		$xmlOutput .= parent::end();
		// Returns XML
		return $xmlOutput;
	}
}