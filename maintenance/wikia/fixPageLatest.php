<?php

/**
 * Script that tries to fix page_latest entry in page table
 *
 * @author macbre
 * @file
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class FixPageLatest extends Maintenance {

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( "dry-run", "Do not update page table" );
		$this->mDescription = 'Fixes page_latest entry in page table';
	}

	public function execute() {
		$isDryRun = $this->hasOption('dry-run');
		$dbr = $this->getDB(DB_SLAVE);

		# select page_id, page_title, page_touched, rev_id from page left join revision on rev_page = page_id where page_latest = 0
		$this->output('Looking for pages with broken page_latest entry...');
		$res = $dbr->select(
			['page', 'revision'],
			[
				'page_id',
				'page_title',
				#'page_touched',
				'rev_id'
			],
			['page_latest' => 0],
			__METHOD__,
			[],
			['revision' => ['LEFT JOIN', 'rev_page = page_id']]
		);

		$count = $res->numRows();
		$this->output(" {$count} pages(s) found\n\n");

		if ($count === 0) {
			$this->output("No articles found!\n");
			die();
		}

		// fix entries
		$fixed = 0;
		$dbw = $this->getDB(DB_MASTER);

		while($row = $res->fetchObject()) {
			$revId = intval($row->rev_id);

			// no revision data
			if ($revId === 0) {
				continue;
			}

			$this->output("* {$row->page_title}");

			if ($isDryRun) {
				$this->output(" - page_latest would be set to {$revId}\n");
			}
			else {
				$dbw->update(
					'page',
					['page_latest' => $revId],
					['page_id' => $row->page_id],
					__METHOD__
				);
				$this->output(" - page_latest set to {$revId}\n");

				$fixed++;
			}
		}

		$this->output("Done - {$fixed} page(s) fixed\n");
	}
}

$maintClass = "FixPageLatest";
require_once( RUN_MAINTENANCE_IF_MAIN );
