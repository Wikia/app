<?php

/**
 * Replacement task for the MediaWiki 1.25 RecentChangesUpdateJob
 *
 * @see PLATFORM-965
 */
namespace Wikia\Tasks\Tasks;

/**
 * Job for pruning recent changes
 *
 * @ingroup JobQueue
 * @since 1.25
 */
class RecentChangesUpdateTask extends BaseTask {

	/**
	 * @return self
	 */
	public static function newPurgeTask() {
		global $wgCityId;

		$task = new self();
		$task->call( 'purgeExpiredRows' );
		$task->wikiId( $wgCityId );
		$task->title( \SpecialPage::getTitleFor( 'Recentchanges' ) );
		$task->queue();

		return $task;
	}

	public function purgeExpiredRows() {
		global $wgRCMaxAge;

		$dbw = wfGetDB( DB_MASTER );
		$rows = 0;

		$cutoff = $dbw->timestamp( time() - $wgRCMaxAge );
		do {
			$rcIds = $dbw->selectFieldValues( 'recentchanges',
				'rc_id',
				array( 'rc_timestamp < ' . $dbw->addQuotes( $cutoff ) ),
				__METHOD__,
				array( 'LIMIT' => 100 ) // avoid slave lag
			);
			if ( $rcIds ) {
				$dbw->delete( 'recentchanges', array( 'rc_id' => $rcIds ), __METHOD__ );
				$rows += $dbw->affectedRows();
			}
			// No need for this to be in a transaction.
			$dbw->commit( __METHOD__, 'flush' );
		} while ( $rcIds );

		$this->info( __METHOD__, [
			'rows' => $rows
		] );

		return true;
	}
}