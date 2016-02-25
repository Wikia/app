<?php

$dir = __DIR__ . '/../../../../';
require_once $dir . 'maintenance/Maintenance.php';

use Flags\Models\Flag;

class RevertNotices extends Maintenance {
	public function execute() {
		global $IP;

		$flagModel = new Flag();
		$wikiIds = $flagModel->getWikisWithFlags();

		foreach ( $wikiIds as $wikiId ) {
			$id = wfEscapeShellArg( $wikiId );
			$cmd = "SERVER_ID={$id} /usr/bin/php {$IP}/extensions/wikia/Flags/maintenance/RevertNotice.php";
			$this->output("Run cmd: $cmd\n");
			$output = wfShellExec( $cmd );

			$this->output( $output . "\n" );
		}
	}
}

$maintClass = 'RevertNotices';
require_once RUN_MAINTENANCE_IF_MAIN;
