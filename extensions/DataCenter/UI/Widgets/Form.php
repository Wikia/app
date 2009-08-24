<?php
/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterWidgetForm extends DataCenterWidget {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML id attribute
		 * @datatype	string
		 */
		'id' => 'form',
		/**
		 * XML class attribute
		 * @datatype	string
		 */
		'class' => 'widget-form',
		/**
		 * Data Source
		 * @datatype	DataCenterDBRow
		 */
		'row' => null,
		/**
		 * Fields to display
		 * @datatype	array
		 */
		'fields' => null,
		/**
		 * Link parameters for DataCenterXml::url of where to process the form
		 * @datatype	array
		 */
		'action' => array(),
		/**
		 * Link parameters for DataCenterXml::url of where to go on success
		 * @datatype	array
		 */
		'success' => array(),
		/**
		 * Link parameters for DataCenterXml::url of where to go on cancellation
		 * @datatype	array
		 */
		'cancellation' => array(),
		/**
		 * Link parameters for DataCenterXml::url of where to go on failure
		 * @datatype	array
		 */
		'failure' => array(),
		/**
		 * Name of processing handler in controller of page action referrs to
		 * @datatype	string
		 */
		'do' => 'submit',
		/**
		 * Array of effect options for DataCenterJs::buildEffect run on submit
		 * @datatype	array
		 */
		'effect' => null,
		/**
		 * XML content to place inside the form before fields
		 * @datatype	string
		 */
		'insert' => '',
		/**
		 * XML content to place inside the form after fields
		 * @datatype	string
		 */
		'append' => '',
		/**
		 * UI message for submission button
		 * @datatype	string
		 */
		'label' => 'submit',
		/**
		 * List of fields to include in the form as hidden fields, in name and
		 * value pairs or names of which values will be looked up in the row
		 * @datatype	array
		 */
		'hidden' => array(),
		/**
		 * Whether to display meta fields as well
		 * @datatype	boolean
		 */
		'meta' => true,
		/**
		 * Name of type of transaction being processed used when logging changes
		 * @datatype	string
		 */
		'type' => null,
	);

	private static $defaultAttributes = array(
		/**
		 * Default XML attributes for table
		 */
		'table' => array(
			'width' => '100%',
			'cellpadding' => 5,
			'cellspacing' => 0,
			'border' => 0,
		),
		/**
		 * Default XML attributes for empty cell
		 */
		'empty' => array(
			'class' => 'empty'
		),
		/**
		 * Default XML attributes for label cell
		 */
		'label' => array(
			'class' => 'label',
			'align' => 'left',
			'nowrap' => 'nowrap',
		),
		/**
		 * Default XML attributes for field cell
		 */
		'field' => array(
			'class' => 'field',
			'width' => '210',
			'align' => 'left',
			'nowrap' => 'nowrap',
		),
		/**
		 * Default XML attributes for submit button cell
		 */
		'buttons' => array(
			'class' => 'buttons',
			'align' => 'right',
			'colspan' => 2
		),
		/**
		 * Default XML attributes for data row
		 */
		'row' => array(
			'class' => 'row',
		),
		/**
		 * Default XML attributes for meta row
		 */
		'meta' => array(
			'class' => 'meta',
		),
		/**
		 * Default XML attributes for change row
		 */
		'change' => array(
			'class' => 'change',
		),
	);

	/* Functions */

	public static function render(
		array $parameters
	) {
		global $wgUser;
		// Sets defaults
		$parameters = array_merge( self::$defaultParameters, $parameters );
		// Begins widget
		$xmlOutput = parent::begin( $parameters['class'] );
		// Builds form attributes
		$formAttributes = array(
			'id' => 'form_' . $parameters['do'],
			'name' => 'form_' . $parameters['do'],
			'method' => 'post',
			'action' => DataCenterXml::url( $parameters['action'] ),
			'onsubmit' => DataCenterJs::buildEffect(
				$parameters['effect'], $parameters['row']->get()
			),
		);
		// Begins form
		$xmlOutput .= DataCenterXml::open( 'form', $formAttributes );
		// Inserts content before fields
		$xmlOutput .= $parameters['insert'];
		// Begins table
		$xmlOutput .= DataCenterXml::open(
			'table', self::$defaultAttributes['table']
		);
		// Creates array to keep track of the number of each type for auto-naming
		$count = array();
		// Loops over each field
		foreach ( $parameters['fields'] as $label => $options ) {
			// Begins row
			$xmlOutput .= DataCenterXml::open(
				'tr', self::$defaultAttributes['row']
			);
			// Checks if the key is a numeric index
			if ( is_int( $label ) ) {
				// Adds an empty cell
				$xmlOutput .= DataCenterXml::cell(
					self::$defaultAttributes['empty']
				);
			} else {
				// Adds a label cell
				$xmlOutput .= DataCenterXml::cell(
					self::$defaultAttributes['label'],
					DataCenterUI::message( 'field', $label )
				);
			}
			// Checks if field is not an array
			if ( !is_array( $options ) ) {
				// Uses value as the input type
				$options = array();
			}
			// Checks if no type was set
			if ( !isset( $options['type'] ) ) {
				// Uses "text" as the default
				$options['type'] = 'text';
			}
			// Verifies the input type is available
			if ( DataCenterUI::isInput( $options['type'] ) ) {
				// Copies field for use as options for input
				$inputOptions = $options;
				// Removes type from attributes since the input doesn't need it
				unset( $inputOptions['type'] );
				// Check no field or fields were set
				if (
					!isset( $inputOptions['fields'] ) &&
					!isset( $inputOptions['field'] )
				) {
					// Uses key as field
					$inputOptions['field'] = $label;
				}
				// Checks if this is an un-named field
				if ( is_int( $label ) ) {
					// Checks if there has been this type before
					if ( isset( $count[$options['type']] ) ) {
						// Incriments type count
						$count[$options['type']]++;
					} else {
						// Starts counting fields of this type
						$count[$options['type']] = 0;
					}
					// Sets ID from type and count
					$inputOptions['id'] =
						"field_{$options['type']}_{$count[$options['type']]}";
					// Sets name of input for form processing
					$inputOptions['name'] =
						"row[{$inputOptions['field']}]";
				} else {
					// Checks if a specific field was given
					if ( isset( $inputOptions['field'] ) ) {
						// Checks if no value was set
						if ( !isset( $inputOptions['value'] ) ) {
							// Sets value of input from row
							$inputOptions['value'] = $parameters['row']->get(
								$inputOptions['field']
							);
						}
						// Sets ID from name
						$inputOptions['id'] =
							"field_{$inputOptions['field']}";
						// Sets name of input for form processing
						$inputOptions['name'] = "row[{$inputOptions['field']}]";
					// Alternatively checks if a list of fields were given
					} else if ( isset( $inputOptions['fields'] ) ) {
						// Loops over each sub-field
						foreach( $inputOptions['fields'] as $key => $field ) {
							// Checks if sub-field is an array
							if ( is_array( $inputOptions['fields'][$key] ) ) {
								// Uses sub-field's specific field name
								$fieldName =
									$inputOptions['fields'][$key]['field'];
							} else {
								// Uses simple value as field name
								$fieldName = $field;
								// Creates arrray for sub-field options
								$inputOptions['fields'][$key] = array();
							}
							// Checks if...
							if (
								// No value was set
								!isset( $inputOptions['fields'][$key]['value'] )
							) {
								// Set the value of the field from the row
								$inputOptions['fields'][$key]['value'] =
									$parameters['row']->get( $fieldName );
							}
							// Set the ID of the field
							$inputOptions['fields'][$key]['id'] =
								"field_{$fieldName}";
							// Sets the name of the field
							$inputOptions['fields'][$key]['name'] =
								"row[{$fieldName}]";
						}
					}
				}
				// Renders input
				$widget = DataCenterUI::renderInput(
					$options['type'], $inputOptions
				);
			} else {
				// Alerts the user that the input did not exist
				$widget = DataCenterUI::message(
					'error', 'no-ui-widget', $label
				);
			}
			// Adds input cell
			$xmlOutput .= DataCenterXml::cell(
				self::$defaultAttributes['field'], $widget
			);
			// Ends field row
			$xmlOutput .= DataCenterXml::close( 'tr' );
		}
		// Checks if row is a component
		if (
			$parameters['meta'] &&
			$parameters['row'] instanceof DataCenterDBComponent
		) {
			// Adds meta fields
			$metaFields = $parameters['row']->getMetaFields();
			$metaValues = $parameters['row']->getMetaValues();
			$valuesTable = DataCenterDB::buildLookupTable(
				'field', $metaValues
			);
			foreach( $metaFields as $metaField ) {
				$field = $metaField->get( 'field' );
				$value = '';
				if (
					isset( $valuesTable[$field][0] ) &&
					$valuesTable[$field][0] instanceof DataCenterDBMetaValue
				) {
					$value = $valuesTable[$field][0]->get( 'value' );
				}
				// Begins row
				$xmlOutput .= DataCenterXml::open(
					'tr', self::$defaultAttributes['meta']
				);
				// Adds label cell
				$xmlOutput .= DataCenterXml::cell(
					self::$defaultAttributes['label'],
					$metaField->get( 'name' )
				);
				// Adds input cell
				$xmlOutput .= DataCenterXml::cell(
					self::$defaultAttributes['field'],
					DataCenterUI::renderInput(
						$metaField->get( 'format' ),
						array(
							'name' => 'meta[' . $field . ']',
							'id' => 'meta_' . $field,
							'value' => $value
						)
					)
				);
				// Ends field row
				$xmlOutput .= DataCenterXml::close( 'tr' );
			}
			// Adds change comment field
			$xmlOutput .= DataCenterXml::row(
				self::$defaultAttributes['change'],
				DataCenterXml::cell(
					self::$defaultAttributes['label'],
					DataCenterUI::message( 'field', 'change-summary' )
				),
				DataCenterXml::cell(
					self::$defaultAttributes['field'],
					DataCenterUI::renderInput(
						'string',
						array( 'name' => 'change[note]', 'id' => 'change_note' )
					)
				)
			);
			// Adds type of edit field
			$xmlOutput .= DataCenterXml::tag(
				'input',
				array(
					'type' => 'hidden',
					'name' => 'change[type]',
					'value' => $parameters['type']
				)
			);
		}
		// Adds cancel and submit button
		$xmlOutput .= DataCenterXML::row(
			DataCenterXml::cell(
				self::$defaultAttributes['buttons'],
				DataCenterXml::tag(
					'input',
					array(
						'type' => 'submit',
						'name' => 'cancel',
						'class' => 'cancel',
						'value' => DataCenterUI::message( 'label', 'cancel' ),
					)
				) .
				DataCenterXml::tag(
					'input',
					array(
						'type' => 'submit',
						'name' => 'submit',
						'class' => 'submit',
						'value' => DataCenterUI::message(
							'label', $parameters['label']
						),
					)
				)
			)
		);
		// Ends table
		$xmlOutput .= DataCenterXml::close( 'table' );
		// Adds do field
		$xmlOutput .= DataCenterXml::tag(
			'input', array(
				'type' => 'hidden',
				'name' => 'do',
				'value' => $parameters['do']
			)
		);
		// Adds token field
		$xmlOutput .= DataCenterXml::tag(
			'input', array(
				'type' => 'hidden',
				'name' => 'token',
				'value' => $wgUser->editToken()
			)
		);
		// Adds success field
		$xmlOutput .= DataCenterXml::tag(
			'input',
			array(
				'type' => 'hidden',
				'name' => 'success',
				'value' => DataCenterXml::url( $parameters['success'] )
			)
		);
		// Adds failure field
		$xmlOutput .= DataCenterXml::tag(
			'input',
			array(
				'type' => 'hidden',
				'name' => 'failure',
				'value' => DataCenterXml::url( $parameters['failure'] )
			)
		);
		// Adds canellation field
		$xmlOutput .= DataCenterXml::tag(
			'input',
			array(
				'type' => 'hidden',
				'name' => 'cancellation',
				'value' => DataCenterXml::url(
					count( $parameters['cancellation'] ) > 0 ?
					$parameters['cancellation'] : $parameters['success']
				)
			)
		);
		// Loops over hidden fields
		foreach ( $parameters['hidden'] as $key => $value ) {
			// Checks if key is numeric
			if ( is_int( $key ) ) {
				// Adds field with value from row
				$xmlOutput .= DataCenterXml::tag(
					'input',
					array(
						'type' => 'hidden',
						'name' => "row[{$value}]",
						'value' => $parameters['row']->get( $value )
					)
				);
			} else {
				// Adds field with specified value
				$xmlOutput .= DataCenterXml::tag(
					'input',
					array(
						'type' => 'hidden',
						'name' => "row[{$key}]",
						'value' => $value
					)
				);
			}
		}
		// Appends content after fields
		$xmlOutput .= $parameters['append'];
		// Ends form
		$xmlOutput .= DataCenterXml::close( 'form' );
		// Ends widget
		$xmlOutput .= DataCenterXml::close( 'div' );
		// Returns the results
		return $xmlOutput;
	}
}