<?php

namespace Wikia\Tasks\Tasks;
use Wikia\Logger\WikiaLogger;

class MaintenanceTask extends BaseTask {
	public function run( $script ) {
		try {
			$exitStatus = 0;
			wfShellExec( $script, $exitStatus );
		} catch (Exception $e) {
			WikiaLogger::instance()->error( $script.' failed', [
				'exception' => $e,
			] );
		}

		return;
	}
}
