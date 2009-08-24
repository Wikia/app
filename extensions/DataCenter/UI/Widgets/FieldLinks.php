<?php

/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterWidgetFieldLinks extends DataCenterWidget {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML ID attribute of widget
		 * @datatype	string
		 */
		'id' => 'fieldlinks',
		/**
		 * CSS class of widget
		 * @datatype	string
		 */
		'class' => 'widget-fieldlinks',
		/**
		 * Data Source
		 * @datatype	DataCenterField
		 */
		'field' => null,
	);

	private static $targets = array(
		'facility' => array(
			'location',
			'space',
		),
		'asset' => array(
			'rack',
			'object',
		),
		'model' => array(
			'rack',
			'object',
			'port',
		),
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
		 * Default XML attributes for checkbox cell
		 */
		'checkbox' => array(
			'class' => 'checkbox',
			'width' => '10%',
		),
		/**
		 * Default XML attributes for label cell
		 */
		'label' => array(
			'class' => 'label',
		),
		/**
		 * Default XML attributes for label cell
		 */
		'uses' => array(
			'class' => 'uses',
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
		// Gets existing links from database
		$metaFieldLinks = $parameters['field']->getLinks();
		$existsTable = array();
		foreach ( $metaFieldLinks as $metaFieldLink ) {
			$key = implode(
				'_',
				$metaFieldLink->get(
					array( 'component_category', 'component_type' )
				)
			);
			$existsTable[$key] = $metaFieldLink;
		}
		// Builds form attributes
		$formAttributes = array(
			'id' => 'form_fieldlinks',
			'name' => 'form_fieldlinks',
			'method' => 'post',
			'action' => DataCenterXml::url( $path ),
		);
		// Begins form
		$xmlOutput .= DataCenterXml::open( 'form', $formAttributes );
		// Begins table
		$xmlOutput .= DataCenterXml::open(
			'table', self::$defaultAttributes['table']
		);
		foreach ( self::$targets as $category => $types ) {
			$xmlOutput .= DataCenterXml::row(
				DataCenterXml::headingCell(
					self::$defaultAttributes['heading'],
					DataCenterUI::message( 'category', $category )
				)
			);
			foreach ( $types as $type ) {
				$name = $category . '_' . $type;
				$checkboxAttributes = array(
					'type' => 'checkbox',
					'name' => "meta[{$name}]",
					'id' => "field_{$name}",
					'value' => 1,
				);
				$count = 0;
				if ( isset( $existsTable[$name] ) ) {
					$checkboxAttributes['checked'] = 'checked';
					$count = $existsTable[$name]->numValues();
					if ( $count > 0 ) {
						$checkboxAttributes['disabled'] = 'true';
						$checkboxAttributes['name'] = "locked[{$name}]";
						$xmlOutput .= DataCenterXml::tag(
							'input',
							array(
								'type' => 'hidden',
								'name' => "meta[{$name}]",
								'value' => 1,
							)
						);
					}
				}
				if ( !DataCenterPage::userCan( 'change' ) ) {
					$checkboxAttributes['disabled'] = 'true';
				}
				$xmlOutput .= DataCenterXml::row(
					DataCenterXml::cell(
						self::$defaultAttributes['checkbox'],
						DataCenterXml::tag( 'input', $checkboxAttributes )
					),
					DataCenterXml::cell(
						self::$defaultAttributes['label'],
						DataCenterXml::tag(
							'label',
							array( 'for' => "field_{$name}" ),
							DataCenterUI::message( 'type', $type )
						)
					),
					DataCenterXml::cell(
						self::$defaultAttributes['uses'],
						$count > 0 ?
						DataCenterUI::message( 'label', 'num-uses', $count ) :
						''
					)
				);
			}
		}
		if ( DataCenterPage::userCan( 'change' ) ) {
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
								'label', 'save'
							),
						)
					)
				)
			);
		}
		$xmlOutput .= DataCenterXml::close( 'table' );
		// Adds row fields
		$xmlOutput .= DataCenterXml::tag(
			'input', array(
				'type' => 'hidden',
				'name' => 'row[id]',
				'value' => $parameters['field']->getId(),
			)
		);
		// Adds do field
		$xmlOutput .= DataCenterXml::tag(
			'input', array(
				'type' => 'hidden',
				'name' => 'do',
				'value' => 'saveFieldLinks'
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

	public function saveFieldLinks(
		array $data
	) {
		$metaField = DataCenterDBMetaField::newFromValues( $data['row'] );
		$metaFieldLinks = $metaField->getLinks();
		// Build table of links that do exist
		$doesExistTable = array();
		foreach ( $metaFieldLinks as $metaFieldLink ) {
			$key = implode(
				'_',
				$metaFieldLink->get(
					array( 'component_category', 'component_type' )
				)
			);
			$doesExistTable[$key] = $metaFieldLink;
		}
		// Build table of links that should exist
		$shouldExistTable = array();
		foreach ( $data['meta'] as $key => $value ) {
			list( $category, $type ) =  explode( '_', $key );
			$shouldExistTable[$category . '_' . $type] = true;
		}
		// Solve the difference
		foreach ( self::$targets as $category => $types ) {
			foreach ( $types as $type ) {
				$key = $category . '_' . $type;
				if (
					isset( $shouldExistTable[$key] ) &&
					!isset( $doesExistTable[$key] )
				) {
					// Insert new
					$metaFieldLink = DataCenterDBMetaFieldLink::newFromValues(
						array(
							'field' => $metaField->getId(),
							'component_category' => $category,
							'component_type' => $type,
						)
					);
					$metaFieldLink->insert();
				} else if (
					!isset( $shouldExistTable[$key] ) &&
					isset( $doesExistTable[$key] ) &&
					( $doesExistTable[$key]->numValues() == 0 )
				) {
					// Remove existing
					$doesExistTable[$key]->delete();
				}
			}
		}
	}
}