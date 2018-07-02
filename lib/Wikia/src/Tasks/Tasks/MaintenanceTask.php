<?php

namespace Wikia\Tasks\Tasks;

class MaintenanceTask extends BaseTask {
	public function run( $script ) {
		$exitStatus = 0;
		wfShellExec($script, $exitStatus);

		return;
	}
}
