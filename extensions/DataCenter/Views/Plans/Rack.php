<?php
/**
 * Racks UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterViewPlansRack extends DataCenterView {

	/* Functions */

	public function view(
		$path
	) {
		// Checks if the user did not provide enough information
		if ( !$path['id'] ) {
			// Returns error message
			return DataCenterUI::message( 'error', 'insufficient-data' );
		}
		// Gets link from database
		$rackLink = DataCenterDB::getAssetLink( $path['id'] );
		// Extracts rack from link
		$rack = $rackLink->getAsset();
		// Gets plan from database
		$plan = DataCenterDB::getPlan( $rackLink->get( 'plan' ) );
		// Gets structure of plan
		$structure = $plan->getStructure(
			DataCenterDB::buildSort(
				'link', 'asset', array( 'orientation', 'z DESC' )
			)
		);
		// Gets objects from rack in structure
		$id = $rackLink->getId();
		$objectLinks = array();
		foreach ( $structure as $rackLink ) {
			if ( $rackLink->getId() == $id ) {
				$objectLinks = $rackLink->getStructure();
				break;
			}
		}
		foreach ( $objectLinks as $key => $objectLink ) {
			$object = $objectLink->getAsset();
			$objectModel = $object->getModel();
			$objectLinks[$key]->set(
				array(
					'rack' => $object->getId(),
					'model' => implode(
						' / ',
						$objectModel->get( array( 'manufacturer', 'name' ) )
					),
					'position' => implode(
						' / ',
						array(
							$objectLink->get( 'z' ),
							DataCenterUI::format(
								$objectLink->get( 'orientation' ), 'side'
							),
						)
					),
				)
			);
		}
		// Builds javascript that references the renderable asset
		$target = DataCenterJs::chain(
			array(
				'dataCenter.renderer.getTarget' => array(
					DataCenterJs::toScalar( 'plan' )
				),
				'getModule'
			),
			false
		);
		// Detects if this user came from a zoomed out page
		$refererPath = DataCenterPage::getRefererPath();
		$zoomOptions = array();
		if (
			$refererPath['page'] != $path['page'] ||
			$refererPath['type'] == 'plan'
		) {
			$zoomOptions['zoom-to-rack'] = $rack->getId();
		} else {
			$zoomOptions['look-at-rack'] = $rack->getId();
		}
		// Returns single columm layout with a table
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading', array( 'message' => 'objects' )
						),
						'objects' => DataCenterUI::renderWidget(
							'table',
							array(
								'rows' => $objectLinks,
								'fields' => array(
									'name', 'model', 'position',
								),
								'link' => array(
									'page' => 'plans',
									'type' => 'object',
									'id' => '#id',
									'action' => 'view',
								),
								'effects' => array(
									array(
										'event' => 'onmouseover',
										'script' => $target .
											'.setObjectHighlight({rack},true);',
										'field' => 'id'
									),
									array(
										'event' => 'onmouseout',
										'script' => $target .
											'.clearObjectHighlight( true );',
									),
								),
							)
						),
						DataCenterUI::renderWidget(
							'actions',
							array(
								'links' => array(
									array(
										'page' => 'plans',
										'type' => 'object',
										'action' => 'select',
										'parameter' => array(
											'rack', $path['id']
										),
									),
								),
								'rights' => array( 'change' ),
							)
						),
						DataCenterUI::renderWidget(
							'heading', array( 'message' => 'configuration' )
						),
						DataCenterUI::renderWidget(
							'details',
							array(
								'row' => $rackLink,
								'fields' => array(
									'position' => array(
										'fields' => array( 'x', 'y' ),
										'glue' => ' x '
									),
									'orientation' => array(
										'format' => 'angle'
									)
								),
							)
						),
						DataCenterUI::renderWidget(
							'heading', array( 'message' => 'asset' )
						),
						DataCenterUI::renderWidget(
							'details',
							array(
								'row' => $rack,
								'fields' => array( 'serial', 'asset' ),
							)
						),
					)
				),
				DataCenterUI::renderWidget(
					'plan',
					array_merge(
						array(
							'plan' => $plan, 'current-rack' => $rack->getId(),
						),
						$zoomOptions
					)
				),
			)
		);
	}

	public function select(
		$path
	) {
		// Checks if...
		if (
			// No rack asset was specified
			!$path['id'] &&
			// Parameters were given
			is_array( $path['parameter'] ) &&
			// At least 3 parameters were given
			count( $path['parameter'] ) >= 2 &&
			// The deployment target is a location
			( $path['parameter'][0] == 'plan' )
		) {
			$plan = DataCenterDB::getPlan( $path['parameter'][1] );
			$space = $plan->getSpace();
			// Gets rack links which are linked to this plan
			$rackLinks = DataCenterDB::getAssetLinks(
				array_merge_recursive(
					DataCenterDB::buildCondition(
						'link', 'asset', 'plan', $plan->getId()
					),
					DataCenterDB::buildCondition(
						'link', 'asset', 'asset_type', 'rack'
					)
				)
			);
			$existsTable = array();
			foreach ( $rackLinks as $rackLink ) {
				$existsTable[$rackLink->get( 'asset_id' )] = true;
			}
			// Gets rack from database in two varieties, local and remote
			$racks = array(
				'local' => DataCenterDB::getAssets(
					'rack',
					array_merge_recursive(
						DataCenterDB::buildCondition(
							'asset',
							'rack',
							'location',
							$space->get( 'location' )
						),
						DataCenterDB::buildJoin(
							'facility', 'location', 'id',
							'asset', 'rack', 'location',
							array(
								'name' => 'location_name',
								'region' => 'location_region',
							)
						)
					)
				),
				'remote' => DataCenterDB::getAssets(
					'rack',
					array_merge_recursive(
						DataCenterDB::buildCondition(
							'asset',
							'rack',
							'location',
							$space->get( 'location' ),
							'!='
						),
						DataCenterDB::buildJoin(
							'facility', 'location', 'id',
							'asset', 'rack', 'location',
							array(
								'name' => 'location_name',
								'region' => 'location_region',
							)
						)
					)
				)
			);
			$tables = array();
			foreach ( $racks as $groupName => $rackGroup ) {
				foreach( $rackGroup as $key => $rack ) {
					if (
						$rack->get( 'tense' ) == 'past' ||
						isset( $existsTable[$rack->getId()] )
					) {
						unset( $rackGroup[$key] );
					} else {
						$rackModel = $rack->getModel();
						$rack->set(
							$rackModel->get( array( 'name', 'manufacturer' ) )
						);
					}
				}
				if ( count( $rackGroup ) > 0 ) {
					$tabs[$groupName] = DataCenterUI::renderWidget(
						'table',
						array(
							'rows' => $rackGroup,
							'fields' => array(
								'manufacturer',
								'model' => array( 'field' => 'name' ),
								'serial',
								'asset',
								'location' => array(
									'fields' => array(
										'location_name', 'location_region'
									),
									'glue' => ' / ',
								),
							),
							'link' => array(
								'page' => 'plans',
								'type' => 'rack',
								'id' => $path['id'],
								'action' => 'attach',
								'parameter' => array(
									'plan', $path['parameter'][1], '#id'
								),
							),
						)
					);
				} else {
					$tabs[$groupName] = null;
				}
			}
			// Returns 2 columm layout with a form and a scene
			return DataCenterUI::renderLayout(
				'columns',
				array(
					DataCenterUI::renderLayout(
						'rows',
						array(
							DataCenterUI::renderWidget(
								'heading',
								array(
									'message' => 'select-attach-type',
									'type' => 'rack'
								)
							),
							DataCenterUI::renderLayout( 'tabs', $tabs )
						)
					),
				)
			);
		}
	}

	public function remove(
		$path
	) {
		// Gets link from database
		$rackLink = DataCenterDB::getAssetLink( $path['id'] );
		// Extracts rack from link
		$rack = $rackLink->getAsset();
		// Gets plan from database
		$plan = DataCenterDB::getPlan( $rackLink->get( 'plan' ) );
		// Gets structure of rack
		$links = $rackLink->getLinks();
		// Returns 2 columm layout with a form and a scene
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading',
							array(
								'message' => 'remove-type', 'type' => 'rack',
							)
						),
						DataCenterUI::renderWidget(
							'body',
							array(
								'message' => 'notice-removing-type',
								'type' => $path['type'],
								'style' => 'notice',
							)
						),
						DataCenterUI::renderWidget(
							'table',
							array(
								'rows' => $links,
								'fields' => array(
									'name',
									'type' => array(
										'field' => 'asset_type',
										'format' => 'type'
									)
								)
							)
						),
						DataCenterUI::renderWidget(
							'form',
							array(
								'do' => 'remove',
								'label' => 'remove',
								'hidden' => array( 'id' ),
								'success' => array(
									'page' => 'plans',
									'type' => 'plan',
									'action' => 'view',
									'id' => $plan->getId(),
								),
								'failure' => $path,
								'cancellation' => array(
									'page' => 'plans',
									'type' => 'rack',
									'action' => 'view',
									'id' => $path['id'],
								),
								'row' => $rackLink,
								'action' => array(
									'page' => 'plans',
									'type' => 'rack'
								),
								'fields' => array(
									'confirm' => array( 'type' => 'string' )
								)
							)
						),
					)
				),
				DataCenterUI::renderWidget(
					'plan', array(
						'plan' => $plan,
						'current-rack' => $rack->getId(),
					)
				)
			)
		);
	}

	public function attach(
		$path
	) {
		return $this->configure( $path );
	}

	public function configure(
		$path
	) {
		// Checks if...
		if (
			// No rack asset was specified
			!$path['id'] &&
			// Parameters were given
			is_array( $path['parameter'] ) &&
			// At least 3 parameters were given
			count( $path['parameter'] ) >= 3 &&
			// The deployment target is a location
			( $path['parameter'][0] == 'plan' )
		) {
			// Gets plan from database
			$plan = DataCenterDB::getPlan( $path['parameter'][1] );
			// Creates new asset with default parameters
			$rack = DataCenterDB::getAsset( 'rack', $path['parameter'][2] );
			// Creates new asset link
			$rackLink = DataCenterDBAssetLink::newFromValues(
				array(
					'name' => DataCenterUI::message( 'type', 'rack' ),
					'plan' => $plan->getId(),
					'asset_type' => 'rack',
					'asset_id' => $rack->getId(),
					'x' => 1,
					'y' => 1,
					'orientation' => 0
				)
			);
			// Sets action specific parameters
			$formParameters = array(
				'label' => 'attach',
				'hidden' => array( 'plan', 'asset_type', 'asset_id' ),
				'success' => array(
					'page' => 'plans',
					'type' => 'plan',
					'action' => 'view',
					'id' => $path['parameter'][1],
				),
			);
			$headingParameters = array(
				'message' => 'attaching-type', 'type' => 'rack'
			);
		} else {
			// Gets asset from database
			$rackLink = DataCenterDB::getAssetLink( $path['id'] );
			// Gets rack that rack link links to
			$rack = $rackLink->getAsset();
			// Gets plan from database
			$plan = DataCenterDB::getPlan( $rackLink->get( 'plan' ) );
			// Sets action specific parameters
			$formParameters = array(
				'label' => 'save',
				'hidden' => array( 'id' ),
				'success' => array(
					'page' => 'plans',
					'type' => 'rack',
					'action' => 'view',
					'id' => $path['id'],
				),
			);
			$headingParameters = array(
				'message' => 'configuring-type', 'type' => 'rack'
			);
		}
		// Gets parent asset from database
		$space = $plan->getSpace();
		// Builds javascript that references the renderable asset
		$target = array(
			'dataCenter.renderer.getTarget' => array(
				DataCenterJs::toScalar( 'plan' )
			),
			'getModule'
		);
		$objectId = $rack->getId();
		// Builds form parameters
		$formParameters = array_merge(
			$formParameters,
			array(
				'do' => 'save',
				'failure' => $path,
				'action' => array(
					'page' => 'plans',
					'type' => 'rack'
				),
				'row' => $rackLink,
				'fields' => array(
					'name' => array( 'type' => 'string' ),
					'position' => array(
						'fields' => array(
							'x' => array(
								'field' => 'x',
								'min' => 1,
								'max' => $space->get( 'width' )
							),
							'y' => array(
								'field' => 'y',
								'min' => 1,
								'max' => $space->get( 'depth' )
							),
						),
						'type' => 'position',
						'effect' => DataCenterJs::chain(
							array_merge(
								$target,
								array(
									'setRackPosition' => array(
										DataCenterJs::toScalar( $objectId ),
										'{this.x}.value',
										'{this.y}.value',
										DataCenterJs::toScalar( true )
									)
								)
							),
							false
						),
						'mode' => 'iso',
					),
					'orientation' => array(
						'type' => 'number',
						'min' => 0,
						'max' => 3,
						'effect' => DataCenterJs::chain(
							array_merge(
								$target,
								array(
									'setRackOrientation' => array(
										DataCenterJs::toScalar( $objectId ),
										'{this}.value',
										DataCenterJs::toScalar( true )
									)
								)
							),
							false
						),
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
					'plan',
					array(
						'plan' => $plan,
						'zoom-from-rack' => $rack->getIdOrZero(),
						'current-rack' => $rack->getId(),
						'include' => $rackLink
					)
				),
			)
		);
	}
}