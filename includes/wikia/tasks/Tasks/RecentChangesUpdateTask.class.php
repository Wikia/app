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

	/**
	 * Remove recentchanges rows older than $wgRCMaxAge.
	 * Additionally limit he number of rows in this table (controlled by $wgRCMaxRows)
	 *
	 * @return bool
	 * @throws \DBUnexpectedError
	 */
	public function purgeExpiredRows() {
		global $wgRCMaxAge, $wgRCMaxRows;

		$dbw = wfGetDB( DB_MASTER );

		$rows = 0;
		$rowsBefore = $dbw->estimateRowCount( 'recentchanges', '*' /* $vars */, '' /* $conds */, __METHOD__ );

		$cutoff = $dbw->timestamp( time() - $wgRCMaxAge );

		/**
		 * Take the timestamp of the n-th row in recentchanges
		 * if we have more rows in recentchanges than we allow
		 *
		 * @see PLATFORM-1393
		 */
		if ( $rowsBefore > $wgRCMaxRows ) {
			$cutoff = $dbw->selectField(
				'recentchanges',
				'rc_timestamp',
				'',
				__METHOD__,
				[
					'ORDER BY' => 'rc_timestamp DESC',
					'LIMIT' => 1,
					'OFFSET' => $wgRCMaxRows
				]
			);
		}

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
			'cutoff' => $cutoff,
			'rows' => $rows,
			'rows_before' => $rowsBefore,
		] );

		return true;
	}
}
