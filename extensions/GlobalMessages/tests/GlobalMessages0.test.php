<?php

require '/usr/wikia/source/wiki/maintenance/Maintenance.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 0);
ini_set('html_errors', 0);

class GlobalMessages0Test extends Maintenance {

	public function execute() {

		$this->dataProvider = require '/usr/wikia/source/wiki/extensions/GlobalMessages/tests/GlobalMessages0.data.php';

		global $wgLang;
		$wgLang = Language::factory( 'en' );

		$docOut = [];

		foreach ( $this->dataProvider as $k => $v ) {

			$msg = wfMessage( $k )->text();

			if ( $msg !== $v ) {
				echo "$k\n\nACTUAL:\n\n$msg\n\nEXPECTED:\n\n$v\n\n";
				break;
			}
		}

		$this->output("OK :-)\n");
	}

}

$maintClass = 'GlobalMessages0Test';
require RUN_MAINTENANCE_IF_MAIN;
