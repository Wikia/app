<?php
/**
 * Locations UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterViewFacilitiesLocation extends DataCenterView {

	/* Functions */

	public function main(
		$path
	) {
		// Gets all components from database
		$locations = DataCenterDB::getLocations(
			DataCenterDB::buildSort(
				'facility', 'location', array( 'name', 'region' )
			)
		);
		// Builds lookup table of locations keyed on tense
		$locationsTable = DataCenterDB::buildLookupTable( 'tense', $locations );
		// Builds table widget for each tense
		$tables = array();
		foreach ( array( 'present', 'future', 'past' ) as $tense ) {
			if ( isset( $locationsTable[$tense] ) ) {
				$tables[$tense] = DataCenterUI::renderWidget(
					'table',
					array(
						'rows' => $locationsTable[$tense],
						'fields' => array( 'name', 'region' ),
						'link' => array(
							'page' => 'facilities',
							'type' => 'location',
							'id' => '#id',
							'action' => 'view',
						),
					)
				);
			} else {
				$tables[$tense] = null;
			}
		}
		// Returns 2 columm layout with a table and a map widget
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading', array( 'message' => 'locations' )
						),
						DataCenterUI::renderLayout( 'tabs', $tables ),
						DataCenterUI::renderWidget(
							'actions',
							array(
								'links' => array(
									array(
										'page' => 'facilities',
										'type' => 'location',
										'action' => 'add'
									),
								),
								'rights' => array( 'change' ),
							)
						),
					)
				),
				DataCenterUI::renderWidget(
					'map', array(
						'locations' => $locations,
						'link' => true
					)
				)
			)
		);
	}

	public function view(
		$path
	) {
		// Checks if the user did not provide enough information
		if ( !$path['id'] ) {
			// Returns error message
			return DataCenterUI::message( 'error', 'insufficient-data' );
		}
		// Gets location from database
		$location = DataCenterDB::getLocation( $path['id'] );
		// Gets meta values
		$metaValues = $location->getMetaValues();
		// Gets spaces in location from database
		$spaces = $location->getSpaces(
			DataCenterDB::buildSort( 'facility', 'space', 'name' )
		);
		// Builds lookup table of locations keyed on tense
		$spacesTable = DataCenterDB::buildLookupTable( 'tense', $spaces );
		// Builds table widget for each tense
		$tables = array();
		foreach ( array( 'present', 'future', 'past' ) as $tense ) {
			if ( isset( $spacesTable[$tense] ) ) {
				$tables[$tense] = DataCenterUI::renderWidget(
					'table',
					array(
						'rows' => $spacesTable[$tense],
						'fields' => array( 'name' ),
						'link' => array(
							'page' => 'facilities',
							'type' => 'space',
							'id' => '#id',
							'action' => 'view'
						),
					)
				);
			} else {
				$tables[$tense] = null;
			}
		}
		// Returns 2 columm layout with tabs and a map widget
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading', array( 'message' => 'spaces' )
						),
						DataCenterUI::renderLayout( 'tabs', $tables ),
						DataCenterUI::renderWidget(
							'actions',
							array(
								'links' => array(
									array(
										'page' => 'facilities',
										'type' => 'space',
										'action' => 'add',
										'parameter' => array(
											'location',
											$location->getId()
										),
									)
								),
								'rights' => array( 'change' ),
							)
						),
						DataCenterUI::renderWidget(
							'heading', array( 'message' => 'location' )
						),
						DataCenterUI::renderWidget(
							'details',
							array(
								'row' => $location,
								'fields' => array(
									'tense' => array( 'format' => 'option' ),
									'name', 'region', 'latitude', 'longitude'
								),
							)
						),
					)
				),
				DataCenterUI::renderWidget(
					'map', array( 'location' => $location, 'jumpto' => true )
				)
			)
		);
	}

	public function add(
		$path
	) {
		return $this->edit( $path );
	}

	public function edit(
		$path
	) {
		// Detects mode
		if ( !$path['id'] ) {
			// Creates a new facility location
			$location = DataCenterDBLocation::newFromValues(
				array(
					'tense' => 'present',
					'name' => DataCenterUI::message(
						'default', 'new-type', DataCenterUI::message(
							'type', 'location'
						)
					)
				)
			);
			// Sets 'do' specific parameters
			$formParameters = array(
				'label' => 'add',
				'success' => array(
					'page' => 'facilities',
					'type' => 'location'
				),
				'type' => 'add',
			);
			$headingParameters = array(
				'message' => 'adding-type',
				'subject' => DataCenterUI::message( 'type', $path['type'] )
			);
		} else {
			// Gets facility location from database
			$location = DataCenterDB::getLocation( $path['id'] );
			// Sets 'do' specific parameters
			$formParameters = array(
				'label' => 'save',
				'hidden' => array( 'id' ),
				'success' => array(
					'page' => 'facilities',
					'type' => 'location',
					'action' => 'view',
					'id' => $path['id'],
				),
				'type' => 'edit',
			);
			$headingParameters = array(
				'message' => 'editing-type',
				'subject' => DataCenterUI::message( 'type', $path['type'] )
			);
		}
		// Builds javascript that hooks the button into the geocoder
		$jsForm = 'document.form_save';
		$jsOut = DataCenterJs::callFunction(
			'addHandler',
			array(
				"{$jsForm}.field_button_0",
				DataCenterJs::toScalar( 'click' ),
				DataCenterJs::buildFunction(
					null,
					DataCenterJs::chain(
						array(
							'dataCenter.renderer.getTarget' =>
								DataCenterJs::toScalar( 'map' ),
							'showAddress' => array(
								'document.form_save.field_region.value',
								DataCenterJs::toObject(
									array(
										'latField' =>
											"'{$jsForm}.field_latitude'",
										'lngField' =>
											"'{$jsForm}.field_longitude'",
									)
								)
							)
						)
					)
				)
			)
		);
		// Complete form parameters
		$formParameters = array_merge(
			$formParameters,
			array(
				'do' => 'save',
				'failure' => $path,
				'action' => array(
					'page' => 'facilities', 'type' => 'location'
				),
				'row' => $location,
				'fields' =>  array(
					'tense' => array(
						'type' => 'tense',
						'disable' => (
							!$path['id'] ? array( 'past' ) : array()
						)
					),
					'name' => array( 'type' => 'string' ),
					'region' => array( 'type' => 'string' ),
					array( 'type' => 'button', 'label' => 'lookup' ),
					'latitude' => array( 'type' => 'string' ),
					'longitude' => array( 'type' => 'string' ),
				)
			)
		);
		// Returns 2 columm layout with a form and a map widget
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading', $headingParameters
						),
						DataCenterUI::renderWidget( 'form', $formParameters ),
					)
				),
				DataCenterUI::renderWidget(
					'map',
					!$path['id'] ? array() : array( 'location' => $location )
				)
			)
		) . DataCenterXml::script( $jsOut );
	}
}