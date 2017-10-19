<?php

require_once __DIR__  . '/../Maintenance.php';

class CleanupEditTags extends Maintenance {
	const TAGS_TO_REMOVE = [
		'apiedit',
		'categoryselect',
		'gallery',
		'rollback',
		'source',
		'wysiwyg',
		'rte-source',
		'rte-wysiwyg',
		'sourceedit',
	];

	const BATCH_SIZE = 500;

	/** @var bool $isDryRun */
	private $isDryRun = true;

	/** @var int $updatedRows */
	private $updatedRows = 0;

	/** @var int $deletedRows */
	private $deletedRows = 0;

	public function __construct() {
		parent::__construct();
		$this->addOption( 'dry-run', 'Don\'t make any changes' );
	}

	public function execute() {
		$this->isDryRun = $this->hasOption( 'dry-run' );

		if ( $this->isDryRun ) {
			$this->output( "Dry-run mode, no changes will be made!\n" );
		}

		$this->output( "Scanning tag_summary table...\n" );

		$dbw = wfGetDB( DB_MASTER );
		$offset = 0;

		do {
			$res = $dbw->select( 'tag_summary', '*', [], __METHOD__, [
				'LIMIT' => static::BATCH_SIZE,
				'OFFSET' => $offset
			] );
			$nextOffset = $offset + static::BATCH_SIZE;

			$this->output( "Processing rows $offset ... $nextOffset\n" );

			foreach ( $res as $row ) {
				$tags = str_getcsv( $row->ts_tags );
				$tagsToKeep = array_diff( $tags, static::TAGS_TO_REMOVE );

				// No tags left, delete the row
				if ( empty( $tagsToKeep ) ) {
					$this->deleteTagSummaryRow( $dbw, $row->ts_id );
					continue;
				}

				// Some tags changed, update the row
				if ( !empty( array_diff( $tags, $tagsToKeep ) ) ) {
					$this->updateTagSummaryRow( $dbw, $row->ts_id, $tagsToKeep );
				}
			}

			$this->output( "Waiting for slaves...\n" );
			wfWaitForSlaves();

			$offset = $nextOffset;
		} while ( $res->numRows() > 0 );

		$this->output( "Updated {$this->updatedRows} and deleted {$this->deletedRows} rows.\n" );
	}

	private function deleteTagSummaryRow( DatabaseBase $databaseBase, int $tsId ) {
		if ( !$this->isDryRun ) {
			$databaseBase->delete( 'tag_summary', [ 'ts_id' => $tsId ], __METHOD__ );
		}

		$this->deletedRows++;
	}

	private function updateTagSummaryRow( DatabaseBase $databaseBase, int $tsId, array $tags ) {
		if ( !$this->isDryRun ) {
			$databaseBase->update(
				'tag_summary',
				[ 'ts_tags' => implode( ',', $tags ) ],
				[ 'ts_id' => $tsId],
				__METHOD__
			);
		}

		$this->updatedRows++;
	}
}

$maintClass = CleanupEditTags::class;
require_once RUN_MAINTENANCE_IF_MAIN;
