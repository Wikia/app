<?php
/**
 * Removes user name component of article comment titles and replaces it with user ID
 *
 * @see SUS-4766
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class MigrateUserNamesInTitles extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Removes user name component of article comment titles and replaces it with user ID";
		$this->addOption( 'do-migrate', 'Perform the migration', false, false );
	}

	public function execute() {
		/**
		 * SELECT  page_id,page_title  FROM `page`  WHERE page_namespace IN ('1','1201','2001')
		 * AND (page_title LIKE '%/@comment-%' )
		 */
		$dbr = $this->getDB( DB_SLAVE );
		$dbw = $this->getDB( DB_MASTER );

		$rows = $dbr->select(
			'page',
			['page_id', 'page_title'],
			[
				'page_namespace' => [
					NS_TALK, // comments
					1201, // Wall
					2001, // Forum
				],
				'page_title' . $dbr->buildLike(
					$dbr->anyString(), '/' . ARTICLECOMMENT_PREFIX, $dbr->anyString()
				)
			],
			__METHOD__
		);

		$count = $dbr->affectedRows();
		$updated = 0;

		$this->output($dbr->lastQuery() . "\n\n");
		$this->output("Found {$count} rows to be checked...\n");

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
			}
			else {
				$this->output( "dry-run\n" );
			}
		}

		$this->output( "\nDone! $count rows checked, $updated updated.\n" );

		\Wikia\Logger\WikiaLogger::instance()->info(__CLASS__, [
			'updated' => $updated,
			'checked' => $count,
		]);
	}
}

$maintClass = MigrateUserNamesInTitles::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
