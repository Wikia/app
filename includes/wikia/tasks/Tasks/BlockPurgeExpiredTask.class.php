<?php
/**
 * An offline version of Block::purgeExpired method
 *
 * @see SUS-2147
 */

namespace Wikia\Tasks\Tasks;

class BlockPurgeExpiredTask extends BaseTask {

	/**
	 * Purge expired blocks from the ipblocks table
	 *
	 * @return bool
	 */
	public function purgeExpired() {
		if ( !wfReadOnly() ) {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->delete( 'ipblocks',
				array( 'ipb_expiry < ' . $dbw->addQuotes( $dbw->timestamp() ) ), __METHOD__ );

			$this->info( __METHOD__, [
				'num_rows' => (int) $dbw->affectedRows()
			] );
		}
		return true;
	}
}
