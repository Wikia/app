<?php

/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterWidgetHistory extends DataCenterWidget {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML ID attribute of widget
		 * @datatype	string
		 */
		'id' => 'history',
		/**
		 * CSS class of widget
		 * @datatype	string
		 */
		'class' => 'widget-history',
		/**
		 * Data Source
		 * @datatype	DataCenterComponent
		 */
		'component' => null,
		/**
		 * Range of records to show
		 * @datatype	integer
		 */
		'paging' => array( 'limit' => 10, 'offset' => 0 ),
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
		 * Default XML attributes for heading cell
		 */
		'heading' => array(
			'align' => 'left',
		),
		/**
		 * Default XML attributes for checkbox cell
		 */
		'radio' => array(
			'class' => 'radio',
			'width' => '1%',
		),
		/**
		 * Default XML attributes for label cell
		 */
		'field' => array(
			'class' => 'field',
		),
		/**
		 * Default XML attributes for buttons cell
		 */
		'buttons' => array(
			'class' => 'buttons',
			'align' => 'right',
			'colspan' => 6
		),
		/**
		 * Default XML attributes for paging cell
		 */
		'paging' => array(
			'class' => 'paging',
			'align' => 'right',
			'colspan' => 6
		),
	);

	/* Static Functions */

	public static function render(
		array $parameters
	) {
		global $wgUser;
		// Gets current path
		$path = DataCenterPage::getPath();
		// Sets Defaults
		$parameters = array_merge( self::$defaultParameters, $parameters );
		// Begins widget
		$xmlOutput = parent::begin( $parameters['class'] );
		if (
			isset( $path['parameter'] ) &&
			is_array( $path['parameter'] ) &&
			( count( $path['parameter'] ) >= 2 )
		) {
			$changes = array(
				DataCenterDB::getChange( $path['parameter'][0] ),
				DataCenterDB::getChange( $path['parameter'][1] ),
			);
			if (
				$changes[0]->get( 'timestamp' ) >
					$changes[1]->get( 'timestamp' )
			) {
				$changes = array_reverse( $changes );
			}
			// Use blank user name if none is set
			foreach ( $changes as $change ) {
				if ( $change->get( 'user' ) == 0 ) {
					$change->set(
						'username',
						DataCenterUI::message( 'label', 'change-blank-user' )
					);
				}
			}
			// Get states from serialized versions
			$states = array(
				unserialize( $changes[0]->get( 'state' ) ),
				unserialize( $changes[1]->get( 'state' ) ),
			);
			// Begins table
			$xmlOutput .= DataCenterXml::open(
				'table', self::$defaultAttributes['table']
			);
			// Restructures data
			$data = array();
			foreach ( $states as $i => $state ) {
				foreach ( $state as $group => $fields ) {
					if ( !isset( $data[$group] ) ) {
						$data[$group] = array();
					}
					foreach ( $fields as $field => $value ) {
						if ( $field !== 'id' ) {
							if ( !isset( $data[$group][$field] ) ) {
								$data[$group][$field] = array();
							}
							$data[$group][$field][$i] = $value;
						}
					}
				}
			}
			$xmlOutput .= DataCenterXml::row(
				DataCenterXml::cell(),
				DataCenterXml::cell(
					$changes[0]->get( 'username' ) . ' - ' .
					DataCenterUI::format(
						$changes[0]->get( 'timestamp' ), 'date'
					)
				),
				DataCenterXml::cell(
					$changes[1]->get( 'username' ) . ' - ' .
					DataCenterUI::format(
						$changes[1]->get( 'timestamp' ), 'date'
					)
				)
			);
			// Loops over each field
			foreach ( $data as $group => $fields ) {
				if ( count( $fields ) == 0 ) {
					continue;
				}
				$xmlOutput .= DataCenterXml::row(
					DataCenterXml::headingCell(
						array_merge(
							self::$defaultAttributes['heading'],
							array( 'colspan' => 3 )
						),
						DataCenterUI::message(
							'label', 'change-state-' . $group
						)
					)
				);
				$even = true;
				foreach ( $fields as $field => $values ) {
					// Deals with incomplete data
					if ( count( $values ) == 1 ) {
						if ( !isset( $values[0] ) ) {
							$values[0] = null;
						}
						if ( !isset( $values[1] ) ) {
							$values[1] = null;
						}
					}
					// Detects differnce
					$different = ( (string)$values[0] !== (string)$values[1] );
					$spanAttributes = array(
						'class' => $different ? 'different' : 'same'
					);
					// Gets label name
					if ( $group == 'row' ) {
						$label = DataCenterUI::message(
							'field', strtr( $field, '_', '-' )
						);
					} else if ( $group == 'meta' ) {
						$metaField = DataCenterDB::getMetaField( $field );
						$label = $metaField->get( 'name' );
					}
					$state = $even ? 'even' : 'odd';
					// Adds row
					$xmlOutput .= DataCenterXml::row(
						DataCenterXml::cell(
							array( 'class' => 'label' ), $label
						),
						DataCenterXml::cell(
							array( 'class' => 'older-' . $state ),
							DataCenterXml::span( $spanAttributes, $values[0] )
						),
						DataCenterXml::cell(
							array( 'class' => 'newer-' . $state ),
							DataCenterXml::span( $spanAttributes, $values[1] )
						)
					);
					$even = !$even;
				}
			}
			// Ends table
			$xmlOutput .= DataCenterXml::close( 'table' );
		} else {
			// Gets history of component from database
			$changes = $parameters['component']->getChanges(
				array_merge_recursive(
					DataCenterDB::buildSort(
						'meta', 'change', array( 'timestamp DESC' )
					),
					DataCenterDB::buildRange( $path )
				)
			);
			// Gets number of changes fromd database
			$numChanges = $parameters['component']->numChanges();
			// Use blank user name if none is set
			foreach ( $changes as $change ) {
				if ( $change->get( 'user' ) == 0 ) {
					$change->set(
						'username',
						DataCenterUI::message( 'label', 'change-blank-user' )
					);
				}
			}
			// Builds form attributes
			$formAttributes = array(
				'id' => 'form_history',
				'name' => 'form_history',
				'method' => 'post',
				'action' => DataCenterXml::url( $path ),
			);
			// Begins form
			$xmlOutput .= DataCenterXml::open( 'form', $formAttributes );
			// Begins table
			$xmlOutput .= DataCenterXml::open(
				'table', self::$defaultAttributes['table']
			);
			// Adds paging
			$xmlOutput .= DataCenterXml::row(
				DataCenterXml::cell(
					self::$defaultAttributes['paging'],
					parent::buildPaging( $path, $numChanges )
				)
			);
			// Adds headings
			$xmlOutput .= DataCenterXml::row(
				DataCenterXml::headingCell(),
				DataCenterXml::headingCell(),
				DataCenterXml::headingCell(
					self::$defaultAttributes['heading'],
					DataCenterUI::message( 'field', 'date' )
				),
				DataCenterXml::headingCell(
					self::$defaultAttributes['heading'],
					DataCenterUI::message( 'field', 'username' )
				),
				DataCenterXml::headingCell(
					self::$defaultAttributes['heading'],
					DataCenterUI::message( 'field', 'type' )
				),
				DataCenterXml::headingCell(
					self::$defaultAttributes['heading'],
					DataCenterUI::message( 'field', 'note' )
				)
			);
			foreach ( $changes as $i => $change ) {
				// Build row attributes
				$rowAttributes = array(
					'class' => ( ( $i % 2 == 0 ) ? 'odd' : 'even' )
				);
				// Build radio attributes
				$radio1Attributes = array(
					'type' => 'radio',
					'name' => 'meta[change1]',
					'id' => 'field_change1_' . $change->getId(),
					'value' => $change->getId(),
				);
				if ( $i == 0 ) {
					$radio1Attributes['checked'] = 'checked';
				}
				$radio2Attributes = array(
					'type' => 'radio',
					'name' => 'meta[change2]',
					'id' => 'field_change2_' . $change->getId(),
					'value' => $change->getId(),
				);
				if ( $i == 1 || count( $changes ) == 1 ) {
					$radio2Attributes['checked'] = 'checked';
				}
				$xmlOutput .= DataCenterXml::row(
					$rowAttributes,
					DataCenterXml::cell(
						self::$defaultAttributes['radio'],
						DataCenterXml::tag( 'input', $radio1Attributes )
					),
					DataCenterXml::cell(
						self::$defaultAttributes['radio'],
						DataCenterXml::tag( 'input', $radio2Attributes )
					),
					DataCenterXml::cell(
						self::$defaultAttributes['field'],
						DataCenterUI::format(
							$change->get( 'timestamp' ), 'date'
						)
					),
					DataCenterXml::cell(
						self::$defaultAttributes['field'],
						$change->get( 'username' )
					),
					DataCenterXml::cell(
						self::$defaultAttributes['field'],
						$change->get( 'type' )
					),
					DataCenterXml::cell(
						self::$defaultAttributes['field'],
						$change->get( 'note' )
					)
				);
			}
			// Adds reset and submit button
			$xmlOutput .= DataCenterXML::row(
				DataCenterXml::cell(
					self::$defaultAttributes['buttons'],
					DataCenterXml::tag(
						'input',
						array(
							'type' => 'reset',
							'name' => 'reset',
							'class' => 'reset',
							'value' => DataCenterUI::message(
								'label', 'reset'
							),
						)
					) .
					DataCenterXml::tag(
						'input',
						array(
							'type' => 'submit',
							'name' => 'submit',
							'class' => 'submit',
							'value' => DataCenterUI::message(
								'label', 'compare-changes'
							),
						)
					)
				)
			);
			// Adds do field
			$xmlOutput .= DataCenterXml::tag(
				'input', array(
					'type' => 'hidden',
					'name' => 'do',
					'value' => 'compareChanges'
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
			$xmlOutput .= DataCenterXml::close( 'table' );
			$xmlOutput .= DataCenterXml::close( 'form' );
		}
		// Ends widget
		$xmlOutput .= parent::end();
		// Returns results
		return $xmlOutput;
	}

	public static function compareChanges(
		$data
	) {
		global $wgOut;
		$path = DataCenterPage::getPath();
		$path['parameter'] = array(
			$data['meta']['change1'], $data['meta']['change2']
		);
		$wgOut->redirect( DataCenterXml::url( $path ) );
	}
}