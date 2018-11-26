<?php
namespace Wikia\Tasks\Tasks;

/**
 * SRE-109: Async task to update cu_changes table
 */
class UpdateCheckUserTask extends BaseTask {

	public function updateWithEditInfo( array $editInfo ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert( 'cu_changes', $editInfo, __METHOD__ );
	}
}
