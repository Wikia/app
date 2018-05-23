<?php
/**
 * Removes user name component of article comment titles and replaces it with user ID
 *
 * Per-wiki tables that are modified:
 *  - page
 *  - recentchanges
 *  - watchlist
 *
 * @see SUS-4766
 * @see SUS-4806
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class MigrateUserNamesInTitles extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Removes user name component of article comment titles and replaces it with user ID";
		$this->addOption( 'do-migrate', 'Perform the migration', false, false );
	}

	private function migratePageTableRows( ResultWrapper $rows) : int {
		$dbw = $this->getDB( DB_MASTER );

		$count = $rows->numRows();
		$updated = 0;

		$this->output("Found {$count} `page` table rows to be checked...\n");

		// process each title
		foreach($rows as $row) {
			$pageId = $row->page_id;
			$oldPageTitle = $row->page_title;
			$newPageTitle = ArticleCommentsTitle::normalize( $oldPageTitle );

			// no reason to update
			if ($oldPageTitle === $newPageTitle) {
				continue;
			}

			$this->output( "#{$pageId}: {$oldPageTitle} -> {$newPageTitle} ... " );

			if ($this->hasOption('do-migrate')) {
				$dbw->update(
					'page',
					['page_title' => $newPageTitle],
					['page_id' => $pageId],
					__METHOD__
				);

				$updated += $dbw->affectedRows();

				$this->output( "updated\n" );

				// glee wiki has ~2mm rows to be processed here, do not harm the DB replication
				if ($updated % 5000 === 0) {
					wfWaitForSlaves();
				}
			}
			else {
				$this->output( "dry-run\n" );
			}
		}

		return $updated;
	}

	private function migrateRecentChangesTableRows( ResultWrapper $rows) : int {
		$dbw = $this->getDB( DB_MASTER );

		$count = $rows->numRows();
		$updated = 0;

		$this->output("Found {$count} `recentchanges` table rows to be checked...\n");

		// process each title
		foreach($rows as $row) {
			$rc_id = $row->rc_id;
			$oldPageTitle = $row->rc_title;
			$newPageTitle = ArticleCommentsTitle::normalize( $oldPageTitle );

			// no reason to update
			if ($oldPageTitle === $newPageTitle) {
				continue;
			}

			$this->output( "#{$rc_id}: {$oldPageTitle} -> {$newPageTitle} ... " );

			if ($this->hasOption('do-migrate')) {
				$dbw->update(
					'recentchanges',
					['rc_title' => $newPageTitle],
					['rc_id' => $rc_id],
					__METHOD__
				);

				$updated += $dbw->affectedRows();

				$this->output( "updated\n" );

				// do not harm the DB replication
				if ($updated % 5000 === 0) {
					wfWaitForSlaves();
				}
			}
			else {
				$this->output( "dry-run\n" );
			}
		}

		return $updated;
	}

	private function migrateWatchlistTableRows( ResultWrapper $rows) : int {
		$dbw = $this->getDB( DB_MASTER );

		$count = $rows->numRows();
		$updated = 0;

		$this->output("Found {$count} `watchlist` table rows to be checked...\n");

		// process each title
		foreach($rows as $row) {
			$pageNs = $row->wl_namespace;
			$oldPageTitle = $row->wl_title;
			$newPageTitle = ArticleCommentsTitle::normalize( $oldPageTitle );

			// no reason to update
			if ($oldPageTitle === $newPageTitle) {
				continue;
			}

			$this->output( "NS {$pageNs}:{$oldPageTitle} -> {$newPageTitle} ... " );

			if ($this->hasOption('do-migrate')) {
				$dbw->update(
					'watchlist',
					['wl_title' => $newPageTitle],
					['wl_namespace' => $pageNs , 'wl_title' => $oldPageTitle],
					__METHOD__,
					'IGNORE'
				);

				$updated += $dbw->affectedRows();

				$this->output( "updated\n" );

				// do not harm the DB replication
				if ($updated % 5000 === 0) {
					wfWaitForSlaves();
				}
			}
			else {
				$this->output( "dry-run\n" );
			}
		}

		return $updated;
	}

	public function execute() {
		$dbr = $this->getDB( DB_SLAVE );

		$updated = 0;

		// SELECT  page_id,page_title  FROM `page`  WHERE (page_title LIKE '%/@comment-%' )
		$updated += $this->migratePageTableRows($dbr->select(
			'page',
			['page_id', 'page_title'],
			[
				'page_title' . $dbr->buildLike(
					$dbr->anyString(), '/' . ARTICLECOMMENT_PREFIX, $dbr->anyString()
				)
			],
			__METHOD__
		));

		// SELECT  wl_namespace,wl_title  FROM `watchlist`  WHERE (wl_title LIKE '%/@comment-%' )
		$updated += $this->migrateWatchlistTableRows($dbr->select(
			'watchlist',
			['wl_namespace', 'wl_title'],
			[
				'wl_title' . $dbr->buildLike(
					$dbr->anyString(), '/' . ARTICLECOMMENT_PREFIX, $dbr->anyString()
				)
			],
			__METHOD__
		));

		// SELECT  rc_id,rc_title  FROM `recentchanges`  WHERE (rc_title LIKE '%/@comment-%' )
		$updated += $this->migrateRecentChangesTableRows($dbr->select(
			'recentchanges',
			['rc_id', 'rc_title'],
			[
				'rc_title' . $dbr->buildLike(
					$dbr->anyString(), '/' . ARTICLECOMMENT_PREFIX, $dbr->anyString()
				)
			],
			__METHOD__
		));

		$this->output( "\nDone! $updated rows updated.\n" );

		\Wikia\Logger\WikiaLogger::instance()->info(__CLASS__, [
			'updated' => $updated,
		]);
	}
}

$maintClass = MigrateUserNamesInTitles::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
