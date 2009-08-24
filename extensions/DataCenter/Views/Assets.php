<?php
/**
 * Racks UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterViewAssets extends DataCenterView {

	/* Static Members */

	public static $options = array(
		'rack' => array(
			'heading' => array(
				'message' => 'racks',
			),
			'details' => array(
				'fields' => array(
					'manufacturer',
					'model' => array( 'field' => 'name' ),
					'units',
				),
			),
		),
		'object' => array(
			'heading' => array(
				'message' => 'objects',
			),
			'details' => array(
				'fields' => array(
					'manufacturer',
					'model' => array( 'field' => 'name' ),
					'units',
					'depth',
					'power',
				),
			),
		),
	);

	/* Functions */

	public function main(
		$path
	) {
		if ( !isset( self::$options[$path['type']] ) ) {
			return DataCenterUI::renderWidget(
				'body', array(
					'message' => 'invalid-request', 'type' => 'error'
				)
			);
		}
		// Gets all assets from database
		$assets = DataCenterDB::getAssets(
			$path['type'],
			array_merge_recursive(
				DataCenterDB::buildJoin(
					'model', $path['type'], 'id',
					'asset', $path['type'], 'model',
					array( 'name', 'manufacturer' )
				),
				DataCenterDB::buildJoin(
					'facility', 'location', 'id',
					'asset', $path['type'], 'location',
					array( 'name' => 'location_name' )
				),
				DataCenterDB::buildRange( $path )
			)
		);
		$numAssets = DataCenterDB::numAssets( $path['type'] );
		// Returns single columm layout with a table
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading',
							array(
								'message' => 'assets-type',
								'subject' => DataCenterUI::message(
									'type', $path['type']
								)
							)
						),
						DataCenterUI::renderWidget(
							'table',
							array(
								'rows' => $assets,
								'num' => $numAssets,
								'fields' => array(
									'manufacturer',
									'model' => array( 'field' => 'name' ),
									'serial',
									'asset',
									'tense' => array( 'format' => 'option' ),
									'location' => array(
										'field' => 'location_name'
									)
								),
								'link' => array(
									'page' => 'assets',
									'type' => $path['type'],
									'id' => '#id',
									'action' => 'view',
								),
							)
						),
						DataCenterUI::renderWidget(
							'actions',
							array(
								'links' => array(
									array(
										'page' => 'assets',
										'type' => $path['type'],
										'action' => 'design',
									),
								),
								'rights' => array( 'change' ),
							)
						)
					)
				),
			)
		);
	}

	public function history(
		$path
	) {
		$asset = DataCenterDB::getAsset( $path['type'], $path['id'] );
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading',
							array(
								'message' => 'history-type',
								'subject' => DataCenterUI::message(
									'type', $path['type']
								)
							)
						),
						DataCenterUI::renderWidget(
							'history',
							array( 'component' => $asset )
						),
					)
				),
			)
		);
	}

	public function export(
		$path
	) {
		// Returns single columm layout with a table
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading', array( 'message' => 'export' )
						),
						DataCenterUI::renderWidget(
							'export',
							array(
								'category' => 'asset',
								'type' => $path['type']
							)
						),
					)
				),
				' '
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
		// Gets asset from database
		$asset = DataCenterDB::getAsset( $path['type'], $path['id'] );
		// Gets location asset is in from database
		$location = $asset->getLocation();
		// Sets location name to asset
		$asset->set( 'location_name', $location->get( 'name' ) );
		$asset->set( 'location_region', $location->get( 'region' ) );
		$model = $asset->getModel();
		// Returns single columm layout with a table
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading', array(
								'message' => 'asset-type',
								'type' => $path['type'],
							)
						),
						DataCenterUI::renderWidget(
							'details',
							array(
								'heading' => array(
									'message' => 'details-for',
									'subject' => $model->get( 'name' ),
								),
								'row' => $asset,
								'fields' => array(
									'tense' => array( 'format' => 'option' ),
									'serial',
									'asset',
									'location' => array(
										'fields' => array(
											'location_name', 'location_region'
										),
										'glue' => ' / ',
									)
								),
							)
						),
					)
				),
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading', array(
								'message' => 'model-type',
								'type' => $path['type'],
							)
						),
						DataCenterUI::renderWidget(
							'details',
							array_merge(
								self::$options[$path['type']]['details'],
								array( 'row' => $model )
							)
						),
					)
				),
			)
		);
	}

	public function design(
		$path
	) {
		$options = DataCenterViewModels::$options[$path['type']];
		if ( isset( $options['gallery'] ) ) {
			// Gets all components from database
			$models = DataCenterDB::getModels( $path['type'] );
			// Returns single columm layout with a table
			return DataCenterUI::renderLayout(
				'columns',
				array(
					DataCenterUI::renderLayout(
						'rows',
						array(
							DataCenterUI::renderWidget(
								'heading',
								array(
									'message' => 'select-deploy-type',
									'type' => 'model'
								)
							),
							DataCenterUI::renderWidget(
								'gallery',
								array_merge(
									$options['gallery'],
									array(
										'rows' => $models,
										'link' => array(
											'page' => 'assets',
											'type' => $path['type'],
											'action' => 'deploy',
											'parameter' => '#id',
										),
									)
								)
							),
						)
					),
				)
			);
		}
	}

	public function deploy(
		$path
	) {
		return $this->manage( $path );
	}

	public function manage(
		$path
	) {
		// Checks if...
		if (
			// No rack asset was specified
			!$path['id'] &&
			// A single parameter was given
			is_scalar( $path['parameter'] )
		) {
			// Creates new asset with default parameters
			$asset = DataCenterDBAsset::newFromType(
				$path['type'],
				array('model' => $path['parameter'], 'tense' => 'present' )
			);
			// Sets action specific parameters
			$formParameters = array(
				'label' => 'deploy',
				'hidden' => array( 'model' ),
				'success' => array(
					'page' => 'assets',
					'type' => $path['type'],
				),
				'type' => 'deploy',
			);
			$headingParameters = array(
				'message' => 'deploying-asset-type',
				'subject' => DataCenterUI::message(
					'type', $path['type']
				)
			);
		} else {
			// Gets asset from database
			$asset = DataCenterDB::getAsset( $path['type'], $path['id'] );
			// Sets 'do' specific parameters
			$formParameters = array(
				'label' => 'save',
				'hidden' => array( 'id' ),
				'success' => array(
					'page' => 'assets',
					'type' => $path['type'],
					'action' => 'view',
					'id' => $path['id'],
				),
				'type' => 'manage',
			);
			$headingParameters = array(
				'message' => 'managing-asset-type',
				'subject' => DataCenterUI::message(
					'type', $path['type']
				)
			);
		}
		// Gets model from database
		$model = $asset->getModel();
		// Gets list of locations
		$locations = DataCenterDB::getLocations();
		// Completes form parameters
		$formParameters = array_merge(
			$formParameters,
			array(
				'do' => 'save',
				'failure' => $path,
				'action' => array(
					'page' => 'assets',
					'type' => $path['type']
				),
				'row' => $asset,
				'fields' => array(
					'tense' => array(
						'type' => 'tense',
						'disable' => !$path['id'] ? array( 'past' ) : array(),
					),
					'location' => array(
						'type' => 'list',
						'rows' => $locations,
						'labels' => array( 'name', 'region' ),
						'glue' => ' / ',
					),
					'serial' => array( 'type' => 'string' ),
					'asset' => array( 'type' => 'string' ),
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
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading',
							array(
								'message' => 'model-type',
								'type' => $path['type'],
							)
						),
						DataCenterUI::renderWidget(
							'details',
							array_merge(
								self::$options[$path['type']]['details'],
								array( 'row' => $model )
							)
						)
					)
				),
			)
		);
	}
}