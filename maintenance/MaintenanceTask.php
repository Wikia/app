<?php

class MaintenanceTask extends \Wikia\Tasks\Tasks\BaseTask {
	public function run( $script ) {
		return shell_exec( $script );
	}
}
