<?php

use \Wikia\Tasks\Tasks\BaseTask;

class BrokenRenameFixTask extends BaseTask {

	public function rerunRenameScript( $userId, $oldName, $newName ) {
		$maintenanceDir = __DIR__ . '/../../../maintenance/wikia';
		$rerunRenameScript = $maintenanceDir . '/RerunRenameUserLocal.class.php';

		if ( !file_exists( $rerunRenameScript ) ) {
			$this->error( "The maintenance script {$rerunRenameScript} does not exist." );
			return false;
		} else {
			$this->info( "Running the {$rerunRenameScript}. Please wait for the results.
			It may take a long time, depending on the amount of wikias the user edited at." );

			$cmd = sprintf( 'SERVER_ID=177 php %s --userId=%d --oldName="%s" --newName="%s"',
				$rerunRenameScript, $userId, $oldName, $newName );

			$output = wfShellExec( $cmd );

			$this->info( "The script has finished. See the logs below for the result." );
			$this->info( $output );

			return true;
		}
	}
}
