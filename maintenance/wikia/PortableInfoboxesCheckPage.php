<?php

require_once __DIR__ . '/../../usr/wikia/slot1/current/src/maintenance/Maintenance.php';

/**
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @ingroup Maintenance
 */
class PortableInfoboxesCheckPage extends Maintenance {
	public function __construct() {
		parent::__construct();
	}

	public function execute() {
		global $wgParser, $wgEnableInsightsExt, $wgEnableInsightsInfoboxes, $wgEnablePortableInfoboxExt;

		if ( empty( $wgEnableInsightsExt )
			|| empty( $wgEnableInsightsInfoboxes )
			|| empty( $wgEnablePortableInfoboxExt )
		) {
			return;
		}

		$title = Title::newFromID( 38785 );
		$prop = PortableInfoboxDataService::newFromTitle( $title )->getData();
		var_dump($prop);
	}
}

$maintClass = 'PortableInfoboxesCheckPage';
require_once RUN_MAINTENANCE_IF_MAIN;
