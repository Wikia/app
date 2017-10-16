<?php

use \Wikia\Logger\WikiaLogger;

/**
 * Script that pushes image uploads for a given to image review queue
 *
 * @see SUS-2988
 *
 * @author Macbre
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class PushUploadsToImageReview extends Maintenance {

	// perform push for uploads performed between these two timestamp
	const TIMESTAMP_FROM = '2017-08-31';
	const TIMESTAMP_TO = '2017-10-13';

	private $isDryRun = false;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();

		$this->addOption( 'dry-run', 'Don\'t perform any operations' );
		$this->mDescription = 'This script pushes image uploads for a given to image review queue';
	}

	public function execute() {
		$this->isDryRun = $this->hasOption( 'dry-run' );

		// timestamps
		$timestampFrom = strtotime(self::TIMESTAMP_FROM);
		$timestampTo = strtotime(self::TIMESTAMP_TO);

		// fetch uploads to handle
		// select rev_id, page_id, rev_user, rev_timestamp, page_title from revision, page where revision.rev_page = page.page_id and page_namespace = 6
		$db = $this->getDB(DB_SLAVE);

		$res = $db->select(
			['page', 'revision'],
			[
				'page_id',
				'page_title',
				'page_namespace',
				'rev_id',
				'rev_user',
				'rev_timestamp',
			],
			[
				'revision.rev_page = page.page_id',
				'page_namespace' => NS_FILE,
				sprintf('rev_timestamp > "%s"', $db->timestamp($timestampFrom)),
				sprintf('rev_timestamp < "%s"', $db->timestamp($timestampTo))
			],
			__METHOD__
		);

		$count = $db->affectedRows();
		$pushed = 0;

		if ($this->isDryRun === true) {
			$this->output($db->lastQuery() . "\n");
		}

		// logging
		global $wgDBname;
		$this->output( "{$wgDBname} - {$count} uploads will be checked\n");

		foreach($res as $row) {
			$title = Title::newFromRow($row);

			// skipping as this is not an image
			if (!ImageReviewEventsHooks::isFileForReview($title)) {
				continue;
			}

			$pushed++;

			if ($this->isDryRun === false) {
				ImageReviewEventsHooks::requeueImageUpload($title, $row->rev_id, $row->rev_user);
			}
			else {
				$this->output("* would push {$row->page_title} (rev #{$row->rev_id}), but running in dry-run mode\n" );
			}
		}

		$this->output( "{$wgDBname} - {$pushed} uploads were pushed\n");

		WikiaLogger::instance()->info( __CLASS__, [ 'uploads_pushed' => $pushed ] );
	}
}

$maintClass = PushUploadsToImageReview::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
