<?php
/**
 * Racks UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterViewModels extends DataCenterView {

	/* Static Members */

	public static $options = array(
		'rack' => array(
			'sort' => array( 'manufacturer', 'name' ),
			'attachable' => null,
			'gallery' => array(
				'label' => array( 'manufacturer', 'name', 'units' ),
				'heading' => array( 'message' => 'racks' ),
			),
			'form' =>  array(
				'fields' => array(
					'manufacturer' => array( 'type' => 'string' ),
					'name' => array( 'type' => 'string' ),
					'kind' => array( 'type' => 'string' ),
					'units' => array(
						'type' => 'number',
						'min' => 1,
						'max' => 100,
					),
				)
			),
			'details' => array(
				'heading' => array( 'field' => 'name' ),
				'fields' => array(
					'manufacturer', 'name', 'kind', 'units'
				)
			),
		),
		'object' => array(
			'sort' => array( 'form_factor', 'manufacturer', 'name' ),
			'attachable' => array( 'object', 'port' ),
			'gallery' => array(
				'label' => array( 'manufacturer', 'name', 'kind' ),
				'types' => array( 'form_factor' ),
				'heading' => array( 'message' => 'objects' ),
			),
			'form' => array(
				'fields' => array(
					'manufacturer' => array( 'type' => 'string' ),
					'name' => array( 'type' => 'string' ),
					'kind' => array( 'type' => 'string' ),
					'form-factor' => array(
						'field' => 'form_factor',
						'type' => 'list',
						'enum' => array(
							'category' => 'model',
							'type' => 'object',
							'field' => 'form_factor',
						),
					),
					'units' => array(
						'type' => 'number', 'min' => 1, 'max' => 100,
					),
					'depth' => array(
						'type' => 'number', 'min' => 0, 'max' => 4,
					),
					'power' => array(
						'type' => 'number',
						'min' => 0,
						'max' => 100000,
						'step' => 100
					),
				),
			),
			'details' => array(
				'heading' => array( 'field' => 'name' ),
				'fields' => array(
					'manufacturer',
					'name',
					'kind',
					'form-factor' => array(
						'field' => 'form_factor', 'format' => 'option'
					),
					'units',
					'depth',
					'power',
				)
			),
		),
		'port' => array(
			'sort' => array( 'category', 'name' ),
			'attachable' => null,
			'gallery' => array(
				'label' => array( 'name', 'kind', 'format' ),
				'types' => array( 'category', 'format' ),
				'heading' => array( 'message' => 'ports' ),
			),
			'form' => array(
				'fields' => array(
					'name' => array( 'type' => 'string' ),
					'kind' => array( 'type' => 'string' ),
					'category' => array(
						'type' => 'list',
						'enum' => array(
							'category' => 'model',
							'type' => 'port',
							'field' => 'category',
						),
					),
					'format' => array(
						'type' => 'list',
						'enum' => array(
							'category' => 'model',
							'type' => 'port',
							'field' => 'format',
						),
					),
				)
			),
			'details' => array(
				'heading' => array( 'field' => 'name' ),
				'fields' => array(
					'name', 'kind', 'category', 'format'
				)
			),
		),
	);

	/* Functions */

	public function main(
		$path
	) {
		if ( !isset( self::$options[$path['type']] ) ) {
			return 'MODELS';
		}
		// Gets all components from database
		$models = DataCenterDB::getModels(
			$path['type'],
			DataCenterDB::buildSort(
				'model',
				$path['type'],
				self::$options[$path['type']]['sort']
			)
		);
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
								'message' => 'models-type',
								'subject' => DataCenterUI::message(
									'type', $path['type']
								)
							)
						),
						DataCenterUI::renderWidget(
							'gallery',
							array_merge_recursive(
								self::$options[$path['type']]['gallery'],
								array(
									'rows' => $models,
									'link' => array(
										'page' => 'models',
										'type' => $path['type'],
										'id' => '#id',
										'action' => 'view',
									),
								)
							)
						),
						DataCenterUI::renderWidget(
							'actions',
							array(
								'links' => array(
									array(
										'page' => 'models',
										'type' => $path['type'],
										'action' => 'create',
									),
								),
								'subject' => 'type',
								'rights' => array( 'change' ),
							)
						),
					)
				),
			)
		);
	}

	public function history(
		$path
	) {
		$model = DataCenterDB::getModel( $path['type'], $path['id'] );
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
							array( 'component' => $model )
						),
					)
				),
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
		// Gets component from database
		$model = DataCenterDB::getModel( $path['type'], $path['id'] );
		if ( self::$options[$path['type']]['attachable'] ) {
			// Actions
			$actions = array();
			foreach (
				self::$options[$path['type']]['attachable'] as $attachable
			) {
				$actions[] = array(
					'page' => 'models',
					'type' => $path['type'],
					'action' => 'select',
					'id' => $path['id'],
					'parameter' => $attachable,
				);
			}
			// Attachments
			$view = DataCenterUI::renderLayout(
				'rows',
				array(
					DataCenterUI::renderWidget(
						'heading', array( 'message' => 'model-attachments' )
					),
					DataCenterUI::renderWidget(
						'model',
						array(
							'model' => $model,
							'link' => array(
								'page' => 'models',
								'type' => $path['type'],
								'id' => $path['id'],
								'action' => 'configure',
								'parameter' => '#link'
							),
						)
					),
					DataCenterUI::renderWidget(
						'actions',
						array(
							'links' => $actions,
							'subject' => 'parameter',
							'rights' => array( 'change' ),
						)
					)
				)
			);
		} else {
			$view = '';
		}
		// Returns single columm layout with a table
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading', array(
								'message' => 'model-type',
								'subject' => DataCenterUI::message(
									'type', $path['type']
								)
							)
						),
						DataCenterUI::renderWidget(
							'details',
							array_merge(
								array( 'row' => $model ),
								self::$options[$path['type']]['details']
							)
						)
					)
				),
				$view
			)
		);
	}

	public function select(
		$path
	) {
		// Checks if...
		if (
			// There was only one parameter
			is_scalar( $path['parameter'] ) &&
			// The parameter was a valid type to browse
			isset( self::$options[$path['parameter']]['gallery'] )
		) {
			// Gets all components from database
			$models = DataCenterDB::getModels(
				$path['parameter'],
				dataCenterDB::buildSort(
					'model',
					$path['parameter'],
					self::$options[$path['parameter']]['sort']
				)
			);
			// Build gallery options
			$galleryOptions = array_merge(
				self::$options[$path['parameter']]['gallery'],
				array(
					'rows' => $models,
					'link' => array(
						'page' => 'models',
						'type' => $path['type'],
						'id' => $path['id'],
						'action' => 'attach',
						'parameter' => array(
							$path['parameter'], '#id'
						),
					),
				)
			);
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
									'message' => 'select-attach-type',
									'type' => 'model'
								)
							),
							DataCenterUI::renderWidget(
								'gallery', $galleryOptions
							)
						)
					)
				)
			);
		}
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
			is_array( $path['parameter'] ) &&
			( count( $path['parameter'] ) >= 2 ) &&
			isset( self::$options[$path['parameter'][0]]['gallery'] )
		) {
			$modelLink = DataCenterDBModelLink::newFromValues(
				array(
					'parent_type' => $path['type'],
					'parent_id' => $path['id'],
					'child_type' => $path['parameter'][0],
					'child_id' => $path['parameter'][1],
				)
			);
			$model = DataCenterDB::getModel(
				$path['parameter'][0], $path['parameter'][1]
			);
			$modelLink->set( 'name', $model->get( 'kind' ) );
			$modelLink->set( 'quantity', 1 );
			$formOptions = array(
				'label' => 'attach',
				'success' => array(
					'page' => 'models',
					'type' => $path['type'],
					'action' => 'view',
					'id' => $path['id']
				),
			);
			$headingOptions = array(
				'message' => 'attaching-type',
				'subject' => DataCenterUI::message(
					'type', $path['parameter'][0]
				)
			);
		} else {
			$modelLink = DataCenterDB::getModelLink( $path['parameter'][0] );
			$model = $modelLink->getModel();
			$formOptions = array(
				'label' => 'save',
				'hidden' => array( 'id' ),
				'success' => array(
					'page' => 'models',
					'type' => $path['type'],
					'action' => 'view',
					'id' => $path['id']
				),
			);
			$headingOptions = array(
				'message' => 'configuring-type',
				'type' => 'attachment'
			);
		}
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading', $headingOptions
						),
						DataCenterUI::renderWidget(
							'form',
							array_merge_recursive(
								$formOptions,
								array(
									'do' => 'link',
									'action' => array( 'page' => 'models', ),
									'failure' => $path,
									'row' => $modelLink,
									'hidden' => array(
										'parent_type',
										'parent_id',
										'child_type',
										'child_id',
									),
									'fields' => array(
										'name' => array( 'type' => 'string' ),
										'quantity' => array(
											'type' => 'number',
											'min' => 0,
											'max' => 1000
										),
									),
								)
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
								'type' => $path['type']
							)
						),
						DataCenterUI::renderWidget(
							'details',
							array_merge(
								array( 'row' => $model ),
								self::$options[$model->getType()]['details']
							)
						),
					)
				),
			)
		);
	}

	public function create(
		$path
	) {
		return $this->modify( $path );
	}

	public function modify(
		$path
	) {
		// Checks if the type is supported
		if ( !isset( self::$options[$path['type']]['gallery'] ) ) {
			// Returns error message
			return wfMsg( 'datacenter-error-invalid-data' );
		}
		// Detects mode
		if ( !$path['id'] ) {
			// Creates new component
			$model = DataCenterDBModel::newFromType( $path['type'] );
			// Sets 'do' specific parameters
			$formParameters = array(
				'label' => 'create',
				'success' => array(
					'page' => 'models',
					'type' => $path['type']
				),
				'type' => 'create',
			);
			$headingParameters = array(
				'message' => 'creating-model-type',
				'subject' => DataCenterUI::message( 'type', $path['type'] ),
			);
		} else {
			// Gets component from database
			$model = DataCenterDB::getModel( $path['type'], $path['id'] );
			// Sets 'do' specific parameters
			$formParameters = array(
				'label' => 'save',
				'hidden' => array( 'id' ),
				'success' => array(
					'page' => 'models',
					'type' => $path['type'],
					'action' => 'view',
					'id' => $path['id'],
				),
				'type' => 'modify',
			);
			$headingParameters = array(
				'message' => 'modifying-model-type',
				'subject' => DataCenterUI::message( 'type', $path['type'] ),
			);
		}
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
						DataCenterUI::renderWidget(
							'form',
							array_merge(
								$formParameters,
								self::$options[$path['type']]['form'],
								array(
									'do' => 'save',
									'failure' => $path,
									'action' => array(
										'page' => 'models',
										'type' => $path['type']
									),
									'row' => $model,
								)
							)
						),
					)
				),
				'[MODEL VIEWER]',
			)
		);
	}
}