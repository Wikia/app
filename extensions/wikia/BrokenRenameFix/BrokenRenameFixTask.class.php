<?php
/**
 * Class BrokenRenameFixTask
 *
 * A task that runs the RerunRenameUserLocal maintenance script that reruns local rename jobs.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package BrokenRenameFix
 */

use \Wikia\Tasks\Tasks\BaseTask;

class BrokenRenameFixTask extends BaseTask {

	public function rerunRenameScript( $userId, $oldName, $newName ) {
		if ( !$this->createdByUser()->isAllowed( 'renameuser' ) ) {
			$this->error( 'A user that created the task is not allowed to perform a rename' );
			return false;
		}

		$maintenanceDir = __DIR__ . '/../../../maintenance/wikia';
		$rerunRenameScript = $maintenanceDir . '/RerunRenameUserLocal.class.php';

		if ( !file_exists( $rerunRenameScript ) ) {
			$this->error( "The maintenance script {$rerunRenameScript} does not exist." );
			return false;
		} else {
			$this->info( "Running the {$rerunRenameScript}. Please wait for the results.
			It may take a long time, depending on the amount of wikias the user edited at." );

			$wikis = User::newFromId( $userId )->getWikiasWithUserContributions();

			if ( empty( $wikis ) ) {
				$this->info( 'No wikias with contributions found for the user' );
				return true;
			}

			$this->info( 'Wikias with the user\'s edits: ' . json_encode( $wikis ) );

			foreach ( $wikis as $wikiId ) {
				$cmd = sprintf( 'SERVER_ID=177 php %s --userId=%d --oldName=%s --newName=%s --wikiId=%d',
					$rerunRenameScript,
					(int)$userId,
					wfEscapeShellArg( $oldName ),
					wfEscapeShellArg( $newName ),
					(int)$wikiId
				);
				$output = wfShellExec( $cmd );

				$this->info( $output );
			}

			return true;
		}
	}
}
