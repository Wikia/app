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
				$this->publishImageUploadRequest( $this->getFile( $row ), $row->page_id,
					$row->rev_id, $row->rev_user );
			} );
	}

	private function getFile( $row ): LocalFile {
		if ( $row->page_latest === $row->rev_id ) {
			return $this->repo->newFile( $row->page_title );
		} else {
			return $this->repo->newFile( $row->page_title, $row->rev_timestamp );
		}
	}

	private function publishImageUploadRequest( LocalFile $file, $pageId, $revisionId, $uploaderId
	) {
		if ( $this->dryRun ) {
			$sha1 = 'dry-run-sha1';
		} else {
			$sha1 = $this->repo->getFullSha1( $file->getPath() );
		}

		if ( $sha1 === false ) {
			$this->output( "File does not exist: {$pageId}.{$revisionId} - {$file->getPath()}\n\n" );

			return;
		}

		$data = [
			'bucket' => $file->getBucket(),
			'pathPrefix' => $file->getPathPrefix(),
			'path' => $file->getPath(),
			'originalFilename' => $file->getName(),
			'mimeType' => $file->getMimeType(),
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
