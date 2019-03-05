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
			$this->runForDeletedImages();
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
				$file = $this->getFile( $row );
				if ( $file->exists() ) {
					$this->verifyObject( $this->toGcsPath( $file->getPath() ), $file->getSha1() );
				}
			} );
	}

	private function runForDeletedImages() {
		( new \WikiaSQL() )->SELECT( "page.*, filearchive.*" )
			->FROM( 'page' )
			->SELECT( "filearchive.*" )
			->JOIN( 'filearchive' )
			->ON( 'page.page_title = filearchive.fa_name' )
			->WHERE( 'page.page_namespace' )
			->EQUAL_TO( NS_FILE )
			->runLoop( $this->db, function ( &$pages, $row ) {
				$relative =
					$this->repo->getDeletedHashPath( $row->fa_storage_key ) . $row->fa_storage_key;
				$path = $this->repo->getZonePath( 'deleted' ) . $relative;
				$sha1 = substr( $row->fa_storage_key, 0, strcspn( $row->fa_storage_key, '.' ) );
				$this->verifyObject( $this->toGcsPath( $path ), $sha1 );
			} );
	}

	private function getFile( $row ): LocalFile {
		if ( $row->page_latest === $row->rev_id ) {
			return $this->repo->newFile( $row->page_title );
		} else {
			return $this->repo->newFile( $row->page_title, $row->rev_timestamp );
		}
	}

	private function toGcsPath( $path ) {
		// remove backend
		$path = str_replace( "mwstore://swift-backend/", "mediawiki/", $path );
		// we may have already switched to gcs here but that doesn't matter
		$path = str_replace( "mwstore://gcs-backend/", "mediawiki/", $path );

		// deleted files are elsewhere
		return str_replace( "mwrepo://local/deleted", "mediawiki/deleted/", $path );
	}

	private function verifyObject( $path, $sha1 ) {
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


		if ( $sha1 !== wfBaseConvert( $metadata['sha1'], 16, 36, 31 ) ) {
			$this->error( $path . " - sha1 mismatch!\n" );

			return;
		}

		$this->output( $path . " - everything is awesome!\n" );
	}

}

$maintClass = "CheckConsistency";
require_once( RUN_MAINTENANCE_IF_MAIN );
