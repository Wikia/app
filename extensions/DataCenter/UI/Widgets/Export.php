<?php

/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterWidgetExport extends DataCenterWidget {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML ID attribute of widget
		 * @datatype	string
		 */
		'id' => 'export',
		/**
		 * CSS class of widget
		 * @datatype	string
		 */
		'class' => 'widget-export',
		/**
		 * Name of category of table to export
		 * @datatype	string
		 */
		'category' => null,
		/**
		 * Name of type of table to export
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
		 * Default XML attributes for heading cell
		 */
		'heading' => array(
			'align' => 'left',
			'colspan' => 3
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
		 * Default XML attributes for label cell
		 */
		'input' => array(
			'class' => 'input',
			'align' => 'left',
			'width' => '200',
		),
		/**
		 * Default XML attributes for buttons cell
		 */
		'buttons' => array(
			'class' => 'buttons',
			'align' => 'right',
			'colspan' => 3
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
		// Builds form attributes
		$formAttributes = array(
			'id' => 'form_export',
			'name' => 'form_export',
			'method' => 'post',
			'action' => DataCenterXml::url( $path ),
		);
		// Begins form
		$xmlOutput .= DataCenterXml::open( 'form', $formAttributes );
		// Begins table
		$xmlOutput .= DataCenterXml::open(
			'table', self::$defaultAttributes['table']
		);
		// Adds ...
		$xmlOutput .= DataCenterXml::row(
			DataCenterXml::cell(
				self::$defaultAttributes['label'],
				DataCenterUI::message( 'field', 'format' )
			),
			DataCenterXml::cell(
				self::$defaultAttributes['input'],
				DataCenterUI::renderInput(
					'list',
					array(
						'name' => 'meta[format]',
						'options' => array( 'csv' => 'csv' )
					)
				)
			)
		);
		$xmlOutput .= DataCenterXml::row(
			DataCenterXml::cell(
				self::$defaultAttributes['label'],
				DataCenterUI::message( 'field', 'include-meta' )
			),
			DataCenterXml::cell(
				self::$defaultAttributes['input'],
				DataCenterUI::renderInput(
					'boolean',
					array(
						'name' => 'meta[include-meta]',
						'value' => true,
					)
				)
			)
		);
		if ( DataCenterPage::userCan( 'export' ) ) {
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
								'label', 'export'
							),
						)
					)
				)
			);
		}
		$xmlOutput .= DataCenterXml::close( 'table' );
		// Adds category field
		$xmlOutput .= DataCenterXml::tag(
			'input', array(
				'type' => 'hidden',
				'name' => 'meta[category]',
				'value' => $parameters['category'],
			)
		);
		// Adds type field
		$xmlOutput .= DataCenterXml::tag(
			'input', array(
				'type' => 'hidden',
				'name' => 'meta[type]',
				'value' => $parameters['type'],
			)
		);
		// Adds do field
		$xmlOutput .= DataCenterXml::tag(
			'input', array(
				'type' => 'hidden',
				'name' => 'do',
				'value' => 'export'
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
				'value' => DataCenterXml::url( $path )
			)
		);
		// Adds failure field
		$xmlOutput .= DataCenterXml::tag(
			'input',
			array(
				'type' => 'hidden',
				'name' => 'failure',
				'value' => DataCenterXml::url( $path )
			)
		);
		// Adds canellation field
		$xmlOutput .= DataCenterXml::tag(
			'input',
			array(
				'type' => 'hidden',
				'name' => 'cancellation',
				'value' => DataCenterXml::url( $path )
			)
		);
		$xmlOutput .= DataCenterXml::close( 'form' );
		// Ends widget
		$xmlOutput .= parent::end();
		// Returns results
		return $xmlOutput;
	}

	public static function export(
		array $data
	) {
		global $wgOut;
		// Disables mediawiki output
		$wgOut->disable();
		// Gets current path
		$path = DataCenterPage::getPath();
		// Gets time in a nice format
		$date = date( 'Y-m-d' );
		$fileName = DataCenterUI::message( 'datacenter' ) .
			' - ' .
			DataCenterUI::message(
				'label',
				'export-type',
				DataCenterUI::message( 'type', $data['meta']['type'] ) .
				' ' .
				DataCenterUI::message( 'category', $data['meta']['category'] )
			) .
			' - ' . $date . '.' . $data['meta']['format'];
		// Sets headers for downloading CSV file
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"{$fileName}\"");
		$rows = DataCenterDB::getRows(
			'DataCenterDBRow',
			$data['meta']['category'],
			$data['meta']['type']
		);
		$useMeta = (
			$data['meta']['include-meta'] == 1 &&
			(
				(
					$data['meta']['category'] == 'facility' &&
					DataCenterDB::isFacilityType( $data['meta']['type'] )
				) ||
				(
					$data['meta']['category'] == 'asset' &&
					DataCenterDB::isAssetType( $data['meta']['type'] )
				) ||
				(
					$data['meta']['category'] == 'model' &&
					DataCenterDB::isModelType( $data['meta']['type'] )
				)
			)
		);
		if ( $data['meta']['format'] == 'csv' ) {
			$metaFieldsTable = null;
			$lines = array();
			$fieldNames = '';
			$first = true;
			foreach ( $rows as $row ) {
				$line = '';
				$fields = $row->get();
				foreach ( $fields as $field => $value ) {
					$line .= self::exportValue( $value );
				}
				if ( $first ) {
					foreach ( $fields as $field => $value ) {
						$fieldNames .= self::exportValue(
							DataCenterUI::message( 'field', $field )
						);
					}
				}
				if ( $useMeta ) {
					$component = DataCenterDBComponent::newFromClass(
						'DataCenterDBComponent',
						$data['meta']['category'],
						$data['meta']['type'],
						$fields
					);
					if ( !$metaFieldsTable ) {
						$metaFields = $component->getMetaFields();
						$metaFieldsTable = array();
						foreach ( $metaFields as $metaField ) {
							$metaFieldsTable[] = $metaField->get( 'field' );
						}
						if ( $first ) {
							foreach ( $metaFields as $metaField ) {
								$fieldNames .= self::exportValue(
									$metaField->get( 'name' )
								);
							}
						}
					}
					$metaValues = $component->getMetaValues();
					$metaValuesTable = array();
					foreach ( $metaValues as $metaValue ) {
						$metaValuesTable[$metaValue->get( 'field' )] =
							$metaValue->get( 'value' );
					}
					foreach ( $metaFieldsTable as $metaField ) {
						if ( isset( $metaValuesTable[$metaField] ) ) {
							$line .= self::exportValue(
								$metaValuesTable[$metaField]
							);
						} else {
							$line .=  ',';
						}
					}
				}
				$lines[] = rtrim( $line, ',' ) . "\r\n";
				$first = false;
			}
			echo rtrim( $fieldNames, ',' ) . "\r\n";
			echo implode( $lines );
		}
	}

	private static function exportValue(
		$value
	) {
		if (
			strpos( $value, ',' ) !== false ||
			strpos( $value, '"' ) !== false ||
			strpos( $value, "\n" ) !== false
		) {
			return '"' . str_replace( '"', '""', $value ) . '",';
		} else {
			return $value . ',';
		}
	}
}