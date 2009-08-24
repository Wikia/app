<?php
/**
 * Facilities Page Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterControllerFacilities extends DataCenterController {

	/* Members */

	public $types = array(
		'location' => array( 'page' => 'facilities', 'type' => 'location' ),
		'space' => array( 'page' => 'facilities', 'type' => 'space' ),
	);

	/* Functions */

	public function __construct(
		array $path
	) {
		// Actions
		if ( $path['id'] ) {
			if ( DataCenterPage::userCan( 'change' ) ) {
				$this->actions['edit'] = array(
					'page' => 'facilities',
					'type' => $path['type'],
					'action' => 'edit',
					'id' => $path['id']
				);
			}
			$this->actions['history'] = array(
				'page' => 'facilities',
				'type' => $path['type'],
				'action' => 'history',
				'id' => $path['id']
			);
			$this->actions['view'] = array(
				'page' => 'facilities',
				'type' => $path['type'],
				'action' => 'view',
				'id' => $path['id']
			);
		}
	}

	public function save(
		array $data,
		$type
	) {
		if ( !DataCenterPage::userCan( 'change' ) ) {
			return false;
		}
		switch ( $type ) {
			case 'location':
				$component = DataCenterDBLocation::newFromValues(
					$data['row']
				);
				break;
			case 'space':
				$component = DataCenterDBSpace::newFromValues(
					$data['row']
				);
				break;
		}
		if ( isset( $component ) ) {
			$component->save();
			$component->saveMetaValues( $data['meta'] );
			$component->insertChange( $data['change'] );
			return true;
		}
		return false;
	}

	public function compareChanges(
		array $data,
		$type
	) {
		DataCenterWidgetHistory::compareChanges( $data );
		return null;
	}
}