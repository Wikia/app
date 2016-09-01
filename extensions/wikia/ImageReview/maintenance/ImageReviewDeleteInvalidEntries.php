<?php

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

class ImageReviewDeleteInvalidEntries extends Maintenance {

	const BATCH_SIZE = 128;
	private $dryRun = false;

	public function execute() {
		global $wgExternalDatawareDB;

		$this->output( PHP_EOL . 'Running ' . basename( __FILE__ ) . PHP_EOL );
		$this->dryRun = $this->hasOption( 'dry-run' );
		if ( $this->dryRun ) {
			$this->output( 'Running in DRY RUN mode!' . PHP_EOL );
		}

		$this->output( 'Querying the database...' . PHP_EOL );
		$db = wfGetDB( DB_SLAVE, [], $wgExternalDatawareDB );
		$res = $db->select(
			/* tables */ [ 'image_review', 'pages' ],
			/* fields */ [ 'pages.page_id', 'image_review.wiki_id', 'image_review.state', 'image_review.flags', 'image_review.priority' ],
			/* conds  */ [ 'state' => 0 ],
			__METHOD__,
			/* opts */   [ 'ORDER BY' => 'image_review.last_edited DESC' ],
			/* join */   [
				'pages' => [
					'join',
					[
						'image_review.wiki_id = pages.page_wikia_id',
						'image_review.page_id = pages.page_id'
					]
				]
			]
		);
		$this->output( sprintf( "Fetched %d row(s)..." . PHP_EOL, $db->numRows( $res ) ) );

		$delete = [];
		$icons = [];
		foreach ( $res as $row ) {
			$verified = ImageReviewHelper::checkImageValidity( $row );

			switch ( $verified['reason'] ) {
				case 'verified':
					break;
				case 'ico':
					$icons[] = [
						'wiki_id' => $row->wiki_id,
						'page_id' => $row->page_id,
						'state'   => ImageReviewStatuses::STATE_ICO_IMAGE,
					];
					break;
				default:
					$this->output( sprintf( "DEL wiki: %d, page: %d, reason: %s" . PHP_EOL, $row->wiki_id, $row->page_id, $verified['reason'] ) );
					$delete[] = [
						'wiki_id' => $row->wiki_id,
						'page_id' => $row->page_id,
						'reason'  => $verified['reason']
					];
			}

			// full batch
			if ( count( $delete ) == self::BATCH_SIZE ) {
				$this->queueTaskForDelete( $delete );
				$delete = [];
				if ( !$this->dryRun ) {
					sleep(1);
				}
			}

			if ( count( $icons ) == self::BATCH_SIZE ) {
				$this->queueTaskForUpdate( $icons );
				$icons = [];
				if ( !$this->dryRun ) {
					sleep(1);
				}
			}
		}

		// remainder
		$this->queueTaskForDelete( $delete );
		$this->queueTaskForUpdate( $icons );
	}

	private function queueTaskForUpdate( $set ) {
		if ( empty( $set ) ) {
			return;
		}

		$this->output( sprintf( "Summary: %d image(s) marked as icons" . PHP_EOL, self::BATCH_SIZE ) );
		\Wikia\Logger\WikiaLogger::instance()->info( 'ImageReviewDeleteInvalidEntries', [ 'type' => 'ico', 'images' => $set ] );
		if ( $this->dryRun ) {
			return;
		}
		$task = new \Wikia\Tasks\Tasks\ImageReviewTask();
		$task->call( 'setImageReviewState', $set );
		$task->prioritize();
		$task->queue();
	}

	private function queueTaskForDelete( $set ) {
		if ( empty( $set ) ) {
			return;
		}

		$this->output( sprintf( "Summary: %d image(s) marked for deletion" . PHP_EOL, self::BATCH_SIZE ) );
		\Wikia\Logger\WikiaLogger::instance()->info( 'ImageReviewDeleteInvalidEntries', [ 'type' => 'delete', 'images' => $set ] );
		if ( $this->dryRun ) {
			return;
		}
		$task = new \Wikia\Tasks\Tasks\ImageReviewTask();
		$task->call( 'deleteFromQueue', $set );
		$task->prioritize();
		$task->queue();
	}
}

$maintClass = 'ImageReviewDeleteInvalidEntries';

require_once RUN_MAINTENANCE_IF_MAIN;
