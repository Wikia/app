<?php

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

class ImageReviewDeleteInvalidEntries extends Maintenance {

	const BATCH_SIZE = 128;

	public function execute() {
		$this->output( "Querying the database...\n" );

		global $wgExternalDatawareDB;
		$db = wfGetDB( DB_SLAVE, [], $wgExternalDatawareDB );
		$res = $db->select(
			/* tables */ [ 'image_review', 'pages' ],
			/* fields */ [ 'pages.page_id', 'pages.page_wikia_id' ],
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

		$this->output( sprintf( "Fetched %d row(s)...\n", $db->numRows( $res ) ) );

		$delete = [];
		$reason = '';

		while ( $row = $db->fetchObject( $res ) ) {
			$page = GlobalTitle::newFromId( $row->page_id, $row->page_wikia_id );

			if ( ! $page instanceof GlobalTitle ) {
				$reason = 'page does not exist';
			} else if ( $page->isRedirect() ) {
				$reason = 'page is a redirect';
			} else {
				$file = new GlobalFile( $page );
				
				if ( ! $file instanceof GlobalFile || ! $file->exists() ) {
					$reason = 'file does not exist';
				}
			}

			if ( ! empty( $reason ) ) {
				$this->output( sprintf( "DEL wiki: %d, page: %d, reason: %s\n", $row->page_wikia_id, $row->page_id, $reason  ) );
				$delete[] = [
					'wiki_id' => $row->page_wikia_id,
					'page_id' => $row->page_id,
					'reason'  => $reason
				];
			}

			// full batch
			if ( count( $delete ) == self::BATCH_SIZE ) {
				$this->queueTask( $delete );
				$delete = [];
				sleep(1);
			}
		}

		// remainder
		$this->queueTask( $delete );
		
	}

	private function queueTask( $set ) {

		if ( empty( $set ) ) {
			return;
		}

		$this->output( sprintf( "Summary: %d image(s) marked for deletion\n", self::BATCH_SIZE ) );
		\Wikia\Logger\WikiaLogger::instance()->info( 'ImageReviewDeleteInvalidEntries', [ 'images' => $set ] );
		$task = new \Wikia\Tasks\Tasks\ImageReviewTask();
		$task->call('deleteFromQueue', $set );
		$task->prioritize();
		$task->queue();
	}

}

$maintClass = 'ImageReviewDeleteInvalidEntries';

require_once RUN_MAINTENANCE_IF_MAIN;
