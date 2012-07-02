<?php
/**
 * Connections UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterViewSettingsField extends DataCenterView {

	/* Functions */

	public function main( $path ) {
		$metaFields = DataCenterDB::getMetaFields();
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading', array( 'message' => 'fields' )
						),
						DataCenterUI::renderWidget(
							'table',
							array(
								'rows' => $metaFields,
								'fields' => array(
									'name',
									'format' => array( 'format' => 'option' )
								),
								'link' => array(
									'page' => 'settings',
									'type' => 'field',
									'action' => 'view',
									'id' => '#id',
								)
							)
						),
						DataCenterUI::renderWidget(
							'actions',
							array(
								'links' => array(
									array(
										'page' => 'settings',
										'type' => 'field',
										'action' => 'add'
									)
								),
								'rights' => array( 'change' ),
							)
						),
					)
				),
			)
		);
	}

	public function view( $path ) {
		$metaField = DataCenterDB::getMetaField( $path['id'] );
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading', array( 'message' => 'field' )
						),
						DataCenterUI::renderWidget(
							'details',
							array(
								'row' => $metaField,
								'fields' => array(
									'name',
									'format' => array( 'format' => 'option' )
								)
							)
						),
					)
				),
				DataCenterUI::renderLayout(
					'rows',
					array(
						DataCenterUI::renderWidget(
							'heading',
							array( 'message' => 'applied-components' )
						),
						DataCenterUI::renderWidget(
							'fieldlinks',
							array(
								'field' => $metaField,
								'path' => $path,
							)
						),
					)
				),
			)
		);
	}

	public function remove( $path ) {
		$metaField = DataCenterDB::getMetaField( $path['id'] );
		$metaFieldLinks = $metaField->getLinks();
		foreach ( $metaFieldLinks as $metaFieldLink ) {
			$metaFieldLink->set( 'uses', $metaFieldLink->numValues() );
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
								'message' => 'remove-type',
								'type' => 'field'
							)
						),
						DataCenterUI::renderWidget(
							'body',
							array(
								'message' => 'notice-removing-field',
								'style' => 'notice',
							)
						),
						DataCenterUI::renderWidget(
							'table',
							array(
								'rows' => $metaFieldLinks,
								'fields' => array(
									'category' => array(
										'field' => 'component_category',
										'format' => 'category'
									),
									'type' => array(
										'field' => 'component_type',
										'format' => 'type'
									),
									'uses'
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
									'page' => 'settings',
									'type' => 'field',
								),
								'failure' => $path,
								'cancellation' => array(
									'page' => 'settings',
									'type' => 'field',
									'action' => 'view',
									'id' => $path['id'],
								),
								'row' => $metaField,
								'action' => array(
									'page' => 'settings',
									'type' => 'field'
								),
								'fields' => array(
									'confirm' => array( 'type' => 'string' )
								)
							)
						)
					)
				),
				'&#160;'
			)
		);
	}

	public function add( $path ) {
		return $this->configure( $path );
	}

	public function configure( $path ) {
		// Detects mode
		if ( !$path['id'] ) {
			// Creates new component
			$field = DataCenterDBMetaField::newFromValues();
			// Sets 'do' specific parameters
			$formParameters = array(
				'label' => 'add',
				'success' => array(
					'page' => 'settings',
					'type' => 'field'
				),
			);
			$rows = array(
				DataCenterUI::renderWidget(
					'heading',
					array(
						'message' => 'adding-type',
						'type' => 'field',
					)
				),
			);
		} else {
			// Gets component from database
			$field = DataCenterDB::getMetaField( $path['id'] );
			// Sets 'do' specific parameters
			$formParameters = array(
				'label' => 'save',
				'hidden' => array( 'id' ),
				'success' => array(
					'page' => 'settings',
					'type' => 'field',
					'action' => 'view',
					'id' => $path['id'],
				),
			);
			$rows = array(
				DataCenterUI::renderWidget(
					'heading',
					array(
						'message' => 'configuring-type',
						'type' => 'field',
					)
				),
				DataCenterUI::renderWidget(
					'body',
					array(
						'message' => 'important-configuring-field',
						'style' => 'important',
					)
				),
			);
		}
		// Returns 2 columm layout with a form and a scene
		return DataCenterUI::renderLayout(
			'columns',
			array(
				DataCenterUI::renderLayout(
					'rows',
					array_merge(
						$rows,
						array(
							DataCenterUI::renderWidget(
								'form',
								array_merge(
									$formParameters,
									array(
										'do' => 'save',
										'failure' => $path,
										'action' => array(
											'page' => 'settings',
											'type' => 'field'
										),
										'row' => $field,
										'fields' => array(
											'name' => array(
												'type' => 'string'
											),
											'format' => array(
												'type' => 'list',
												'enum' => array(
													'category' => 'meta',
													'type' => 'field',
													'field' => 'format',
												),
											),
										),
									)
								)
							),
						)
					)
				),
				'&#160;'
			)
		);
	}
}