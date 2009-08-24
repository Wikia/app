<?php
/**
 * Racks Page Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterControllerAssets extends DataCenterController {

	/* Members */

	public $types = array(
		'rack' => array( 'page' => 'assets', 'type' => 'rack' ),
		'object' => array( 'page' => 'assets', 'type' => 'object' ),
	);

	/* Functions */

	public function __construct(
		array $path
	) {
		// Actions
		if ( $path['id'] ) {
			if ( DataCenterPage::userCan( 'change' ) ) {
				$this->actions['manage'] = array(
					'page' => 'assets',
					'type' => $path['type'],
					'action' => 'manage',
					'id' => $path['id'],
				);
			}
			$this->actions['history'] = array(
				'page' => 'assets',
				'type' => $path['type'],
				'action' => 'history',
				'id' => $path['id'],
			);
			$this->actions['view'] = array(
				'page' => 'assets',
				'type' => $path['type'],
				'action' => 'view',
				'id' => $path['id'],
			);
		} else {
			if ( DataCenterPage::userCan( 'export' ) ) {
				$this->actions['export'] = array(
					'page' => 'assets',
					'type' => $path['type'],
					'action' => 'export',
				);
			}
		}
	}

	public function save(
		array $data,
		$type
	) {
		if ( !DataCenterPage::userCan( 'change' ) ) {
			return false;
		}
		$asset = DataCenterDBAsset::newFromType( $type, $data['row'] );
		$asset->save();
		$asset->saveMetaValues( $data['meta'] );
		$asset->insertChange( $data['change'] );
		return true;
	}

	public function export(
		array $data,
		$type
	) {
		if ( !DataCenterPage::userCan( 'export' ) ) {
			return false;
		}
		DataCenterWidgetExport::export( $data );
		return null;
	}

	public function compareChanges(
		array $data,
		$type
	) {
		DataCenterWidgetHistory::compareChanges( $data );
		return null;
	}
}