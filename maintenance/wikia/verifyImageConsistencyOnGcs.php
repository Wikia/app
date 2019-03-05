<?php

use Google\Cloud\Storage\StorageClient;

require_once( __DIR__ . '/../Maintenance.php' );

class CheckConsistency extends Maintenance {

	const TABLE_IMAGE = 'image';
	/** @var DatabaseBase */
	private $db;
	/** @var LocalRepo */
	private $repo;
	/** @var bool */
	private $postMigration;
	/** @var StorageClient */
	private $storage;
	/** @var string */
	private $bucketName;

	public function __construct() {
		parent::__construct();
		$this->mDescription =
			"Verify image consistency on GCS. `Usage SERVER_DBNAME=muppet php -d display_errors=1 ./wikia/verifyImageConsistencyOnGcs.php`";
		$this->addOption( 'post-migration', 'Will involve checks on additional metadata', false,
			false, 'm' );
	}

	public function execute() {
		global $wgGcsConfig;
		$this->postMigration = $this->hasOption( 'post-migration' );
		$this->db = wfGetDB( DB_SLAVE );
		$this->repo = RepoGroup::singleton()->getLocalRepo();
		$this->storage = new StorageClient( [ 'keyFile' => $wgGcsConfig['gcsCredentials'] ] );
		$this->bucketName = $wgGcsConfig['gcsBucket'];

		try {
			$this->runForAllImages();
		}
		catch ( Exception $e ) {
			$this->error( "Failure when calculating consistency" . json_encode( $e ) );
		}

		return 0;
	}

	private function runForAllImages() {
		( new \WikiaSQL() )->SELECT( "page.*, revision.*" )
			->FROM( 'page' )
			->LEFT_JOIN( 'revision' )
			->ON( 'revision.rev_page = page.page_id' )
			->WHERE( 'page.page_namespace' )
			->EQUAL_TO( NS_FILE )
			->runLoop( $this->db, function ( &$pages, $row ) {
				$this->verifyConsistency( $this->getFile( $row ), $row->page_id, $row->rev_id,
					$row->rev_user );
			} );
	}

	private function getFile( $row ): LocalFile {
		if ( $row->page_latest === $row->rev_id ) {
			return $this->repo->newFile( $row->page_title );
		} else {
			return $this->repo->newFile( $row->page_title, $row->rev_timestamp );
		}
	}

	private function verifyConsistency( LocalFile $file, $pageId, $revisionId, $uploaderId ) {
		$path = $file->getPath();
		// remove backend
		$path = str_replace( "mwstore://swift-backend/", "mediawiki/", $path );
		// we may have already switched to gcs here but that doesn't matter
		$path = str_replace( "mwstore://gcs-backend/", "mediawiki/", $path );

		$object = $this->storage->bucket( $this->bucketName )->object( $path );

		if ( !$object->exists() ) {
			$this->error( $path . " - object does not exist!\n" );

			return;
		}

		if ( !isset( $object->info()['metadata'] ) ) {
			$this->error( $path . " - metadata not set! \n" );

			return;
		}

		$metadata = $object->info()['metadata'];

		if ( !isset( $metadata['sha1'] ) ) {
			$this->error( $path . " - sha1 not set! \n" );

			return;
		}

		if ( $file->getSha1() !== wfBaseConvert( $metadata['sha1'], 16, 36, 31 ) ) {
			$this->error( $path . " - sha1 mismatch!\n" );

			return;
		}

		if ( $this->postMigrationCheck ) {
			if ( $metadata['mw-revision'] != $revisionId ) {
				$this->error( $path . " -revision does not match\n" );

				return;
			}
			if ( $metadata['mw-page'] != $pageId ) {
				$this->error( $path . " -page does not match\n" );

				return;
			}
			if ( $metadata['uploader'] != $uploaderId ) {
				$this->error( $path . " -uploader does not match\n" );

				return;
			}
		}

		$this->output( $path . " - everything is awesome!\n" );
	}
}

$maintClass = "CheckConsistency";
require_once( RUN_MAINTENANCE_IF_MAIN );
