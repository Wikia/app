<?php
/**
 * Spaces UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterViewFacilitiesSpace extends DataCenterView {

	/* Functions */

	public function main(
		$path
	) {
		// Gets all components from database
		$spaces = DataCenterDB::getSpaces(
			array_merge_recursive(
				DataCenterDB::buildJoin(
					'facility', 'location', 'id',
					'facility', 'space', 'location',
					array( 'name' => 'location_name' )
				),
				DataCenterDB::buildSort(
					'facility', 'space', array( 'location_name', 'name' )
				)
			)
		);
		$spacesTable = DataCenterDB::buildLookupTable( 'tense', $spaces );
		$tables = array();
		foreach ( array( 'present', 'future', 'past' ) as $tense ) {
			if ( isset( $spacesTable[$tense] ) ) {
				$tables[$tense] = DataCenterUI::renderWidget( 'table',
					array(
						'rows' => $spacesTable[$tense],
						'fields' => array(
							'name',
							'location' => array(
								'field' => 'location_name'
							),
							'size' => array(
								'fields' => array( 'width', 'height', 'depth' ),
								'glue' => 'x'
							),
							'power',
						),
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
		// Returns 2 columm layout with a table and a map widget
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading', array( 'message' => 'spaces' )
						),
						DataCenterUI::renderLayout( 'tabs', $tables )
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
		// Gets facility space from database
		$space = DataCenterDB::getSpace( $path['id'] );
		// Gets plans for this space from database
		$plans = $space->getPlans();
		// Builds lookup table of locations keyed on tense
		$plansTable = DataCenterDB::buildLookupTable( 'tense', $plans );
		// Builds table widget for each tense
		$tables = array();
		foreach ( array( 'present', 'future', 'past' ) as $tense ) {
			if ( isset( $plansTable[$tense] ) ) {
				$tables[$tense] = DataCenterUI::renderWidget(
					'table',
					array(
						'rows' => (
							isset( $plansTable[$tense] ) ?
							$plansTable[$tense] :
							array()
						),
						'fields' => array(
							'name',
							'space' => array( 'field' => 'space_name' ),
							'tense' => array( 'format' => 'option' ),
						),
						'link' => array(
							'page' => 'plans',
							'action' => 'view',
							'type' => 'plan',
							'id' => '#id',
						),
					)
				);
			} else {
				$tables[$tense] = null;
			}
		}
		// Returns 2 columm layout with a table and a scene
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading', array( 'message' => 'plans' )
						),
						DataCenterUI::renderLayout(
							'tabs', $tables
						),
						DataCenterUI::renderWidget(
							'actions',
							array(
								'links' => array(
									array(
										'page' => 'plans',
										'type' => 'plan',
										'action' => 'add',
										'parameter' => array(
											'space', $space->getId()
										)
									)
								),
								'rights' => array( 'change' ),
							)
						),
						DataCenterUI::renderWidget(
							'heading', array( 'message' => 'space' )
						),
						DataCenterUI::renderWidget(
							'details',
							array(
								'row' => $space,
								'fields' => array(
									'tense' => array( 'format' => 'option' ),
									'name',
									'size' => array(
										'fields' => array(
											'width',
											'depth',
											'height',
										),
										'glue' => ' x '
									),
									'power'
								),
							)
						),
					)
				),
				DataCenterUI::renderWidget(
					'space', array(
						'space' => $space
					)
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
		// Checks if...
		if (
			// No space facility was specified
			!$path['id'] &&
			// Parameters were given
			is_array( $path['parameter'] ) &&
			// At least 2 parameters were given
			count( $path['parameter'] >= 2 ) &&
			// The deployment target is a location
			( $path['parameter'][0] == 'location' )
		) {
			// Creates new facility with default parameters
			$space = DataCenterDBSpace::newFromValues(
				array(
					'location' => $path['parameter'][1],
					'tense' => 'present',
					'name' => DataCenterUI::message(
						'default', 'new-type', DataCenterUI::message(
							'type', 'space'
						)
					)
				)
			);
			// Sets 'do' specific parameters
			$formParameters = array(
				'label' => 'add',
				'hidden' => array( $path['parameter'][0] ),
				'success' => array(
					'page' => 'facilities',
					'type' => $path['parameter'][0],
					'action' => 'view',
					'id' => $path['parameter'][1],
				),
				'type' => 'add',
			);
			$headingParameters = array(
				'message' => 'adding-type',
				'subject' => DataCenterUI::message( 'type', $path['type'] )
			);
		} else {
			// Gets facility from database
			$space = DataCenterDB::getSpace( $path['id'] );
			// Sets 'do' specific parameters
			$formParameters = array(
				'label' => 'save',
				'hidden' => array( 'location', 'id' ),
				'success' => array(
					'page' => 'facilities',
					'type' => 'space',
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
		// Builds javascript to access renderable facility
		$jsTarget = DataCenterJs::chain(
			array(
				"dataCenter.renderer.getTarget" =>
					DataCenterJs::toScalar( 'space' ),
				'getModule'
			),
			false
		);
		// Complete form parameters
		$formParameters = array_merge(
			$formParameters,
			array(
				'do' => 'save',
				'failure' => $path,
				'action' => array(
					'page' => 'facilities', 'type' => 'space'
				),
				'row' => $space,
				'fields' => array(
					'tense' => array(
						'type' => 'tense', 'disable' => array( 'past' )
					),
					'name' => array( 'type' => 'string' ),
					'width' => array(
						'type' => 'number',
						'effect' => $jsTarget .
							'.setWidth( {this}.value, true );',
					),
					'height' => array(
						'type' => 'number',
						'effect' => $jsTarget .
							'.setHeight( {this}.value, true );',
					),
					'depth' => array(
						'type' => 'number',
						'effect' => $jsTarget .
							'.setDepth( {this}.value, true );',
					),
					'power' => array(
						'type' => 'number',
						'min' => 0,
						'max' => 100000,
						'step' => 100
					),
				)
			)
		);
		// Returns 2 columm layout with a form and a scene
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
					'space', array( 'space' => $space )
				)
			)
		);
	}
}
