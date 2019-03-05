<?php

use Wikia\Rabbit\ConnectionBase;

require_once( __DIR__ . '/../Maintenance.php' );

class MigrateImages extends Maintenance {

	const TABLE_IMAGE = 'image';
	/** @var DatabaseBase */
	private $db;
	/** @var LocalRepo */
	private $repo;
	/** @var bool */
	private $dryRun;
	private $connectionBase;

	public function __construct() {
		parent::__construct();
		$this->mDescription =
			"Migrate images to GCS. `Usage SERVER_DBNAME=muppet php -d display_errors=1 ./wikia/migrateImagesToGcs.php`";
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );
	}

	public function execute() {
		global $wgGoogleCloudUploaderPublisher;

		$this->dryRun = $this->hasOption( 'dry-run' );

		$this->db = wfGetDB( DB_SLAVE );
		// This means that this script should be run for communities for which we have not switched to GCSFileBackend
		$this->repo = RepoGroup::singleton()->getLocalRepo();
		$this->connectionBase = new ConnectionBase( $wgGoogleCloudUploaderPublisher );

		try {
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
			->runLoop( $this->db, function ( &$pages, $row ) {
				$file = $this->getFile( $row );

				if ( !$file->exists() ) {
					$this->output( "File does not exist: {$row->page_id}.{$row->rev_id} - {$file->getPath()}\n\n" );

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
			->runLoop( $this->db, function ( &$pages, $row ) {
				$relative = $this->repo->getDeletedHashPath( $row->fa_storage_key ) . $row->fa_storage_key;
				$path = $this->repo->getZonePath( 'deleted' ) . '/' . $relative;
				$revision = $this->getRevisionId( $row->fa_archive_name );
				$sha1 = substr( $row->fa_storage_key, 0, strcspn( $row->fa_storage_key, '.' ) );

				$this->publishImageUploadRequest( $path, $row->fa_name,
					"{$row->fa_major_mime}/{$row->fa_minor_mime}", $sha1, $row->page_id, $revision,
					$row->fa_user );
			} );
	}

	private function getFile( $row ): LocalFile {
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

	public function getBucket() {
		global $wgUploadPath;

		return VignetteRequest::parseBucket( $wgUploadPath );
	}

	private function publishImageUploadRequest(
		$path, $filename, $mimeType, $sha1, $pageId, $revisionId, $uploaderId
	) {
		$data = [
			'bucket' => $this->getBucket(),
			'path' => $path,
			'originalFilename' => $filename,
			'mimeType' => $mimeType,
			'sha1' => $sha1,
			'pageId' => $pageId,
			'revisionId' => $revisionId,
			'uploaderId' => $uploaderId,
		];


		if ( !$this->dryRun ) {
			$this->output( "Publishing a request to upload: " . json_encode( $data ) . "\n\n" );
			$this->connectionBase->publish( "{$file->getBucket()}", $data );
		} else {
			$this->output( "DRY RUN: Would have published a request to upload	" .
						   json_encode( $data ) . "\n\n" );
		}
	}

}

$maintClass = "MigrateImages";
require_once( RUN_MAINTENANCE_IF_MAIN );
