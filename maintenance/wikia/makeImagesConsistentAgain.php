<?php

require_once __DIR__ . '/../Maintenance.php';

class MakeImagesConsistentAgain extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->setBatchSize( 200 );
		$this->addOption( 'dry-run', 'Only output statistics without queueing tasks' );
		$this->addOption( 'from', 'Process uploads later than this timestamp', true, true );
		$this->addOption( 'until', 'Process uploads earlier than this timestamp', true, true );
	}

	public function execute() {
		$dryRun = $this->hasOption( 'dry-run' );

		if ( $dryRun ) {
			$this->output( "Dry-run mode, no tasks will be queued!\n" );
		}

		$i = 0;
		$batches = [];
		$count = 0;
		$total = 0;

		// prepare no more than mBatchSize file operations for each background task
		foreach ( $this->getAllOperations() as $operation ) {
			if ( ++$count > $this->mBatchSize ) {
				$i++;
			}

			$batches[$i][] = $operation;
			$total++;
		}

		$this->output( "Got $total operations to synchronize; going to queue $i background tasks.\n" );

		if ( !$dryRun ) {
			foreach ( $batches as $batch ) {
				$task = \Wikia\Tasks\Tasks\ImageSyncTask::newLocalTask();
				$task->call( 'synchronize', $batch );
				$task->queue();
			}
		} else {
			var_dump( $batches );
		}
	}

	private function getAllOperations() {
		$uploads = 0;
		foreach ( $this->getNewUploads() as $operation ) {
			$uploads++;
			yield $operation;
		}

		$this->output( "Got $uploads image uploads to synchronize.\n" );

		$deleted = 0;
		foreach ( $this->getDeletedFiles() as $operation ) {
			$deleted++;
			yield $operation;
		}

		$this->output( "Got $deleted deletions to synchronize.\n" );
	}

	private function getNewUploads() {
		$dbr = wfGetDB( DB_SLAVE );
		$repo = RepoGroup::singleton()->getLocalRepo();

		$zone = $repo->getZonePath( 'public' );
		$from = $this->getOption( 'from' );

		$safeFrom = $dbr->addQuotes( $dbr->timestamp( $from ) );
		$safeUntil = $dbr->addQuotes( $dbr->timestamp( $this->getOption( 'until' ) ) );

		$res = $dbr->select(
			'image',
			[ 'img_name' ],
			[ "img_timestamp > $safeFrom", "img_timestamp < $safeUntil" ],
			__METHOD__
		);

		foreach ( $res as $row ) {
			$hashWithSlash = $repo->getHashPath( $row->img_name );

			yield [
				'op' => 'store',
				'src' => '',
				'dst' => "$zone/$hashWithSlash" . $row->img_name,
			];

			$old = $dbr->select(
				'oldimage',
				[ 'oi_name', 'oi_archive_name', 'oi_timestamp' ],
				[ 'oi_name' => $row->img_name ],
				__METHOD__
			);

			// Synchronize archived previous revisions of the upload
			foreach ( $old as $oldRow ) {
				$hashWithSlash = $repo->getHashPath( $oldRow->oi_name );

				yield [
					'op' => 'store',
					'src' => '',
					'dst' => "$zone/archive/$hashWithSlash" . $oldRow->oi_archive_name,
				];

				// If the old revision was uploaded before the start cutoff
				// then any previous revisions were correctly synced
				if ( $oldRow->oi_timestamp < $from ) {
					break;
				}
			}
		}
	}

	private function getDeletedFiles() {
		$dbr = wfGetDB( DB_SLAVE );
		$repo = RepoGroup::singleton()->getLocalRepo();

		$zone = $repo->getZonePath( 'public' );
		$delZone = $repo->getZonePath( 'deleted' );

		$safeFrom = $dbr->addQuotes( $dbr->timestamp( $this->getOption( 'from' ) ) );
		$safeUntil = $dbr->addQuotes( $dbr->timestamp( $this->getOption( 'until' ) ) );

		$res = $dbr->select(
			[ 'filearchive', 'image' ],
			[ 'fa_name', 'fa_archive_name', 'fa_storage_key' ],
			[ "fa_deleted_timestamp > $safeFrom", "fa_timestamp < $safeUntil" ],
			__METHOD__,
			[],
			[ 'image' => [ 'LEFT JOIN', 'fa_name = img_name' ] ]
		);

		foreach ( $res as $row ) {
			$hashWithSlash = $repo->getHashPath( $row->fa_name );
			$deletedWithSlash = $repo->getDeletedHashPath( $row->fa_storage_key );

			if ( $row->fa_archive_name ) {
				// old revision - delete path for archived revision
				yield [
					'op' => 'delete',
					'src' => '',
					'dst' => "$zone/archive/$hashWithSlash" . $row->fa_archive_name,
				];
			} elseif ( empty( $row->img_name ) ) {
				// delete latest image path, only if no one uploaded a file with the same name since then
				yield [
					'op' => 'delete',
					'src' => '',
					'dst' => "$zone/$hashWithSlash" . $row->fa_name,
				];
			}

			// store archived file
			yield [
				'op' => 'store',
				'src' => '',
				'dst' => "$delZone/$deletedWithSlash" . $row->fa_storage_key
			];
		}
	}
}

$maintClass = MakeImagesConsistentAgain::class;
require_once RUN_MAINTENANCE_IF_MAIN;
