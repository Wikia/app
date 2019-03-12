<?php

use Wikia\Rabbit\ConnectionBase;

require_once( __DIR__ . '/../Maintenance.php' );

class MigrateImages extends Maintenance {

	const TABLE_IMAGE = 'image';
	/** @var DatabaseBase */
	private $db;
	/** @var LocalRepo */
	private $repo;
	/** @var string */
	private $bucket;
	/** @var bool */
	private $dryRun;
	/** @var ConnectionBase */
	private $rabbitConnection;
	/** @var bool */
	private $verify;
	/** @var string */
	private $correlationId;
	private $parallel;
	private $thread;


	public function __construct() {
		parent::__construct();
		$this->mDescription =
			"Migrate images to GCS. `Usage SERVER_DBNAME=muppet php -d display_errors=1 ./wikia/migrateImagesToGcs.php`";
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );
		$this->addOption( 'verify', 'Verify consistency between metadata and storage', false, false, 'v' );
		$this->addOption( 'parallel', 'How many threads per wiki', false, true, 'm' );
		$this->addOption( 'thread', 'Which thread is running', false, true, 't' );
	}

	public function execute() {
		global $wgGoogleCloudUploaderPublisher, $wgUploadPath;

		$this->correlationId = \Wikia\Tracer\WikiaTracer::instance()->getTraceId();
		$this->bucket = VignetteRequest::parseBucket( $wgUploadPath );
		$this->dryRun = $this->hasOption( 'dry-run' );
		$this->verify = $this->hasOption( 'verify' );
		$this->parallel = $this->getOption( 'parallel', 1 );
		$this->thread = $this->getOption( 'thread', 0 );

		$this->db = wfGetDB( DB_SLAVE );
		// This means that this script should be run for communities for which we have not switched to GCSFileBackend
		$this->repo = RepoGroup::singleton()->getLocalRepo();
		$this->rabbitConnection = new ConnectionBase( $wgGoogleCloudUploaderPublisher );

		try {
			$this->output( "Starting process with id = {$this->correlationId}\n" );
			$this->runForAllImages();
			$this->runForDeletedImages();
		}
		catch ( Exception $e ) {
			$this->error( "Failure to migrate" . json_encode( $e ) );
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
			->AND_("MOD(page.page_id, {$this->parallel})")
			->EQUAL_TO($this->thread)
			->runLoop( $this->db, function ( &$pages, $row ) {
				$file = $this->getFile( $row );

				if ( $file === null ) {
					$this->output( "File could not have been created: {$row->page_id}.{$row->rev_id}\n\n" );

					return;
				}

				if ( !$file->exists() ) {
					$this->output( "File does not exist: {$row->page_title} {$row->page_id}.{$row->rev_id} - {$file->getPath()}\n\n" );
					return;
				}

				$this->publishImageUploadRequest( $file->getPath(), $file->getName(),
					$file->getMimeType(), $file->getSha1(), $row->page_id, $row->rev_id,
					$row->rev_user );
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
			->AND_("MOD(page.page_id, {$this->parallel})")
			->EQUAL_TO($this->thread)
			->runLoop( $this->db, function ( &$pages, $row ) {
				if ( empty( $row->fa_storage_key ) ) {
					$this->error( "Ignoring {$row->fa_id} due to a missing storage key." );

					return;
				}
				$relative =
					$this->repo->getDeletedHashPath( $row->fa_storage_key ) . $row->fa_storage_key;
				$path = $this->repo->getZonePath( 'deleted' ) . '/' . $relative;
				$revision = $this->getRevisionId( $row->fa_archive_name );
				$sha1 = substr( $row->fa_storage_key, 0, strcspn( $row->fa_storage_key, '.' ) );

				$this->publishImageUploadRequest( $path, $row->fa_name,
					"{$row->fa_major_mime}/{$row->fa_minor_mime}", $sha1, $row->page_id, $revision,
					$row->fa_user );
			} );
	}

	private function getFile( $row ) {
		if ( $row->page_latest === $row->rev_id ) {
			return $this->repo->newFile( $row->page_title );
		} else {
			return $this->repo->newFile( $row->page_title, $row->rev_timestamp );
		}
	}

	private function getRevisionId( $archiveName ) {
		if ( empty( $archiveName ) ) {
			return '';
		}

		return substr( $archiveName, 0, strcspn( $archiveName, '!' ) );
	}

	private function publishImageUploadRequest(
		$path, $filename, $mimeType, $sha1, $pageId, $revisionId, $uploaderId
	) {
		$bucket = $this->bucket;

		$data = [
			'correlationId' => $this->correlationId,
			'bucket' => $bucket,
			'path' => $path,
			'originalFilename' => $filename,
			'mimeType' => $mimeType,
			'sha1' => $sha1,
			'pageId' => $pageId,
			'revisionId' => $revisionId,
			'uploaderId' => $uploaderId,
		];

		$routingKey = $this->verify ? "verify-file.{$bucket}" : "migrate-file.{$bucket}";


		if ( !$this->dryRun ) {
			$this->output( "Publishing message to {$routingKey}: " . json_encode( $data ) . "\n\n" );
			$this->rabbitConnection->publish( $routingKey , $data );
		} else {
			$this->output( "DRY RUN ({$this->thread}, {$this->parallel}): Would have published message to {$routingKey}: " .
						   json_encode( $data ) . "\n\n" );
		}
	}

}

$maintClass = "MigrateImages";
require_once( RUN_MAINTENANCE_IF_MAIN );
