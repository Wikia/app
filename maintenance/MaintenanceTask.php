<?php

class MaintenanceTask extends \Wikia\Tasks\Tasks\BaseTask {
	public function run( $cmd ) {
		return shell_exec( $cmd['script'] );
	}
}
