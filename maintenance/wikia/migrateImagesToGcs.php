<?php

use Wikia\Rabbit\ConnectionBase;

require_once( __DIR__ . '/../Maintenance.php' );

class MigrateImages extends Maintenance {

	const TABLE_IMAGE = 'image';
	/** @var DatabaseBase */
	private $db;
	/** @var LocalRepo */
	private $repo;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Migrate images to GCS";
	}

	public function execute() {
		$this->db = wfGetDB( DB_SLAVE );
		$this->repo = RepoGroup::singleton()->getLocalRepo();

		( new \WikiaSQL() )->SELECT( "page.*, revision.*" )
			->FROM( 'page' )
			->LEFT_JOIN( 'revision' )
			->ON( 'revision.rev_page = page.page_id' )
			->WHERE( 'page.page_namespace' )
			->EQUAL_TO( NS_FILE )
			->runLoop( $this->db, function ( &$pages, $row ) use ( &$display_order ) {
				$this->publishImageUploadRequest( $this->getFile( $row ), $row->page_id,
					$row->rev_id );
			} );
	}

	private function getFile( $row ): LocalFile {
		if ( $row->page_latest === $row->rev_id ) {
			return $this->repo->newFile( $row->page_title );
		} else {
			return $this->repo->newFile( $row->page_title, $row->rev_timestamp );
		}
	}

	public function todo( LocalFile $file ) {
		$this->output( "file: " . $file->getPath() . "\n" );
	}


	private function publishImageUploadRequest( LocalFile $file, $pageId, $revisionId ) {
		global $wgGoogleCloudUploaderPublisher;

		$sha1 = $this->repo->getFullSha1( $file->getPath() );
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
			'sha1Hash' => $file->getSha1(),
			'pageId' => $pageId,
			'revisionId' => $revisionId,
		];

		$this->output( "Publishing a request to upload: " . json_encode( $data ) . "\n\n" );

		$connectionBase = new ConnectionBase( $wgGoogleCloudUploaderPublisher );
		$connectionBase->publish( "{$file->getBucket()}", $data );
	}
}

$maintClass = "MigrateImages";
require_once( RUN_MAINTENANCE_IF_MAIN );
